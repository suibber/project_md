# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: http://doc.scrapy.org/en/latest/topics/item-pipeline.html

from spider.items import Task
from spider.items import Company
from spider.items import NearbyTaskList
from scrapy.utils.project import get_project_settings
import MySQLdb
import simplejson
import logging

logger = logging.getLogger(__file__)


class SpiderPipeline(object):

    def __init__(self):
        mysql_config = get_project_settings().get('MYSQL_CONFIG')
        self.db = MySQLdb.connect(**mysql_config)
        self.db.autocommit(False)

    def open_spider(self, spider):
        if (spider.name == 'xiaolianbang'):
            cursor = self.db.cursor()
            cid = 0
            while 1:
                cursor.execute(
                        'select id, origin_id from jz_task_pool where origin=%s and id>%s order by id asc limit 1000',
                        (spider.origin, cid))
                rows = cursor.fetchall()
                for _id, origin_id in rows:
                    spider.exists_ids.add(origin_id)
                if rows:
                    cid = _id
                    logger.log(logging.DEBUG, "got %s exists tasks", len(rows))
                if len(rows)<1000:
                    break;
            logger.log(
                    logging.DEBUG,
                    "got exists tasks total count is : %s", len(spider.exists_ids))
        if (spider.name == 'mark_poi'):
            spider.item_addresses
            pass


    def close_spider(self, spider):
        pass


    def process_item(self, item, spider):
        if isinstance(item, Task):
            cursor = self.db.cursor()
            details = simplejson.dumps(dict(item))
            try:
                cursor.execute("""
                insert into jz_task_pool (
                    company_name, city, origin_id,
                    origin, details, lat, lng,
                    title, contact, phonenum,
                    release_date, to_date
                ) values (
                    %(company_name)s, %(city)s,
                    %(origin_id)s, %(origin)s, %(details)s,
                    %(lat)s, %(lng)s,
                    %(title)s, %(contact)s, %(phonenum)s,
                    %(release_date)s, %(to_date)s
                );
                    """, {
                        'company_name': item['company_name'],
                        'origin_id': item['id'],
                        'city': item['city'],
                        'origin': item['origin'],
                        'details': details,
                        'lat': item['lat'],
                        'lng': item['lng'],
                        'title': item['title'],
                        'contact': item['contact'],
                        'phonenum': item['phonenum'],
                        'to_date': item['to_date'],
                        'release_date': item['release_date'],
                        })
                self.db.commit()
            except MySQLdb.IntegrityError, e:
                self.db.rollback()
                if item['lat'] or item['phonenum']:
                    try:
                        cursor.execute("""
                                update jz_task_pool set lat=%s, lng=%s, details=%s
                                 where origin_id = %s and origin=%s
                                """, (item['lat'], item['lng'], details,
                                    item['id'], item['origin']))
                        self.db.commit()
                    except Exception, e:
                        self.db.rollback()
                        logger.log(logging.ERROR, "task updated failed with error:%s", e)
                logger.log(logging.DEBUG, "task exists: %s, %s , %s" % (
                    item['id'], spider.name, item['origin']))
            except Exception, e:
                self.db.rollback()
                logger.log(logging.ERROR, "insert task failed with error: %s " % e)
            finally:
                cursor.close()

        if isinstance(item, NearbyTaskList):
            cursor = self.db.cursor()
            try:
                format_strings = ','.join(['%s'] * len(item['ids']))
                cursor.execute("""
                    update jz_task_pool set has_poi = true where origin_id in (%s) and origin='%s' and has_poi = false
                """ % (format_strings, item['origin']), tuple(item['ids']))
                self.db.commit()
            except Exception, e:
                self.db.rollback()
                logger.log(logging.ERROR,
                        "update has_poi flag faided with exception: %s " % e)
            finally:
                cursor.close()
