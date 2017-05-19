# -*- coding: utf-8 -*-
import scrapy
import re
import simplejson
import datetime

from spider.items import Task
from spider import utils
from scrapy.http.cookies import CookieJar


category_img_map = {
    '820107777f84bb0f4dd202e917b3fa14': '促销',
    '22c7d4cd63e7f13a097990da955030cc': '展会',
    '56545be65a163d1a77d0efeff5bb5722': '家教',
    '73a40933d8c7eb552720308c93d699a2': '客服',
    '610e7389d522685ad7db1491b642efb9': '小时工',
    'a423df01deeab461a1776d2c5678bb24': '礼仪',
    '6202cbf3c296ac4dc7dce933aca5c093': '才艺',
    '6202cbf3c296ac4dc7dce933aca5c093': '发单',
    '3c06cda4b42481ada4881d88b5075148': '志愿者',
    'fb4bb5e50a6aa637e54794cf3087b8b9': '义工',
    }

class XlbSpider(scrapy.Spider):

    name = "xiaolianbang"

    origin = 'xiaolianbang'

    exists_ids = set()

    this_year = '%s' % datetime.date.today().year

    def start_requests(self):
        yield scrapy.http.Request("http://m.xiaolianbang.com/",
                callback=self.login)

    def login(self , response):

        params = {
                'user_acc': '18661775819',
                'user_pwd': '123123'
                }
        yield scrapy.http.FormRequest(
                "http://m.xiaolianbang.com/user/login",
                self.parse_login,
                formdata=params)

    def parse_login(self, response):
        if not re.search(r'error_code\":0', response.body):
            self.logger.error("Could not login xiaolianbang , quiting .....")
            import sys
            sys.exit("Quit scraping data....")
        yield scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities)


    def parse_cities(self, response):
        cities = response.selector.xpath('//*[@id="city_list"]/li/text()').extract()
        for city in cities:
            yield self.build_list_request(city, 1)

    def build_list_request(self, city, page=1):
        cookies = {}
        cookies['cur_city'] = city
        return scrapy.http.Request(
                "http://m.xiaolianbang.com/?page=%s" % page,
                cookies = cookies,
                meta={
                    'city': city,
                    'page': page,
                    },
                dont_filter=True,
                callback=self.parse_list)

    def parse_list(self, response):
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        _ids = list(response.selector.xpath(
                '//*[@id="main-con"]//article/@data-id').extract())

        meta = response.meta

        for _id in _ids:
            if _id not in self.exists_ids:
                yield self.build_detail_request(_id, meta['city'])
            else:
                self.logger.debug('%s is exists.', _id)


        lis = response.selector.xpath(
                '//*[@id="main-con"]//article')
        if len(lis)>0:
            meta = response.meta
            yield self.build_list_request(meta['city'], meta['page']+1)

    def build_detail_request(self, _id, city):
        return scrapy.http.Request(
                    "http://m.xiaolianbang.com/pt/%s/detail" % _id,
                    meta = {
                        'city': city,
                        'id': _id,
                        },
                    callback=self.parse_detail)

    def parse_detail(self, response):
        try:
            task = Task()

            task['lat'] = None
            task['lng'] = None
            task['email'] = None
            task['phonenum'] = None
            task['address'] = None
            task['company_name'] = None
            task['contact'] = None
            task['need_quantity'] = 0
            task['from_date'] = '1999-09-09'
            task['to_date'] = '2115-01-01'
            task['release_date'] = datetime.date.today()

            self.logger.debug(
                    "The release date is : %s", task['release_date'])
            task['id'] = response.meta['id']
            task['city'] = response.meta['city']
            task['origin'] = self.origin
            task['title'] = response.xpath(
                    '//*[@id="headerD"]/article/p/text()').extract_first()

            cat_img = response.xpath('//*[@id="headerD"]/article/figure/img/@src').extract_first();
            task['category_name'] = '其他'
            for k, v in category_img_map.items():
                if k in cat_img:
                    task['category_name'] = v

            trs = response.xpath('//*[@id="jz-baseInfo"]//tr')

            for tr in trs:
                label = tr.xpath(
                        'th/text()')\
                                .extract_first()
                info = tr.xpath(
                        'td/text()')\
                                .extract_first()
                if label and info:
                    label = label.encode('utf-8')
                    info = info.encode('utf-8').decode('utf-8')
                else:
                    continue
                self.logger.debug(
                        "parse field: %s value: %s",
                        label.decode('utf-8'), info)
                if '发布机构' in label:
                    task['company_name'] = info
                elif '薪资待遇' in label:
                    task['salary'], task['salary_unit'] = 0, None
                    if info:
                        r = re.search(ur'(\d+).*?/([^\<]?)', info)
                        if r:
                            task['salary'], task['salary_unit'] = r.group(1, 2)
                elif '结算方式' in label:
                    task['clearance_period'] = info
                elif '招聘人数' in label:
                    if info:
                        r = re.search(ur'(\d+)', info)
                        task['need_quantity'] = r and int(r.group(1)) or 0
                elif '性别要求' in label:
                    task['gender'] = info
                elif '工作地点' in label:
                    task['address'] = info
                    if info and ("不限" in info.encode('utf-8')):
                        task['address'] = None
                elif '工作日期' in label:
                    r = re.search(ur'(\d+\.\d+)~(\d+\.\d+)', info)
                    if r:
                        task['is_long_term'] = False;
                        task['from_date'] = self.this_year + '-' + '-'.join(r.group(1).split('.'))
                        task['to_date'] = self.this_year + '-' + '-'.join(r.group(2).split('.'))
                elif '发布时间' in label:
                    task['release_date'] = info
            cnodes = response.xpath(
                    '//*[@id="jz-detail"]//div[contains(@class, "detail")]/node()').extract()
            task['content'] = "\n".join(cnodes)
            yield self.build_contact_request(task)

        except Exception, e:
            self.logger.error("parse detail failed with error: %s" % e)


    def build_contact_request(self, task):

        self.logger.debug("Build apply request for task: %s, %s", task['id'], task['title'])
        return scrapy.http.Request(
                'http://m.xiaolianbang.com/pt/%s/apply' % task['id'],
                meta = {
                     'task': task,
                     },
                callback=self.parse_contact)

    def parse_contact(self, response):
        task = response.meta['task']
        r = re.search(r'"tel:(\d+)"', response.body)
        if r:
            task['phonenum'] = r.group(1)

        r = re.search(ur'[\d\w\_\-\.]+\@([\w\_\-\_]+\.)+([\w]+)', response.body)
        if r:
            task['email'] = r.group(0)

        if task['address']:
            self.logger.debug("start scrape location for address: %s", task['address'])
            yield scrapy.http.Request(
                    utils.build_pio_url(task['address'], task['city']),
                    meta = {
                         'task': task,
                         },
                    callback=self.parse_poi)


    def parse_poi(self, response):

        r = simplejson.loads(response.body)
        task = response.meta['task']
        location = r['status']=='OK' and r['result'] and r['result']['location']
        self.logger.debug("got poi: %s" % location)
        if (location):
            task['lat'] = location['lat']
            task['lng'] = location['lng']
        yield task


