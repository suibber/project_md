# -*- coding: utf-8 -*-
import scrapy
import re
import simplejson
import datetime
import urllib2
import cookielib

from spider.items import Task
from spider import utils
from spider import deathbycaptcha

from scrapy.http.cookies import CookieJar
from collections import defaultdict


class XlbSpider(scrapy.Spider):

    name = "jianzhimao"

    origin = 'jianzhimao'

    exists_ids = set()

    this_year = '%s' % datetime.date.today().year

    today = str(datetime.date.today())
    yesterday = str(datetime.date.fromordinal(datetime.date.today().toordinal()-1))

    def start_requests(self):

        url = "http://m.jianzhimao.com/job?prov=%E6%B9%96%E5%8D%97&c=%E9%95%BF%E6%B2%99&a=--%E5%8C%BA--&type=";
        yield scrapy.http.Request(url, callback=self.parse_entry);

    def parse_entry(self, response):
        content = response.body
        provs = response.selector.xpath('//*[@id="p"]/option/text()').extract();
        for prov in provs:
            yield scrapy.http.Request(
                    'http://m.jianzhimao.com/getArea?pre=%s&state=2' % prov,
                    callback=self.parse_districts
                    )

    def parse_districts(self, response):
        data = simplejson.loads(response.body)
        if data['status']=='0':
            for record in data['list']:
                prov = record['province'].encode('utf-8')
                city = record['city'].encode('utf-8')
                yield self.build_list_request(prov, city)


    def build_list_request(self, prov, city, page=1):
        url = 'http://m.jianzhimao.com/job?prov=%s&c=%s&a=%s&type=&p=%s' % (
                    prov, city, '--区--', page);
        return scrapy.http.Request(
                url, meta={'prov': prov, 'city': city, 'page': page},
                callback=self.parse_list)

    def parse_list(self, response):
        data = simplejson.loads(response.body)
        meta = response.meta
        if data['status']=='0':
            for item in data['list']:
                yield self.build_detail_request(item, meta)
            yield self.build_list_request(
                    meta['prov'], meta['city'], meta['page']+1)

    def build_detail_request(self, item, meta):
        url = 'http://m.jianzhimao.com/cmp/wxgetJob?id=%s' % item['id']
        return scrapy.http.Request(url,
                meta={'item': item, 'prov': meta['prov'], 'city': meta['city']},
                callback=self.parse_detail)

    def parse_detail(self, response):

        self.logger.debug("Get detail response, item id is: %s", response.meta['item']['id'])
        item = response.meta['item']
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
            task['to_date'] = '1999-09-09'
            task['origin'] = self.origin

            if item['starttime'] == u'昨天':
                task['release_date'] = self.yesterday
            elif u'刚' in item['starttime'] or u'小时前' in item['starttime']:
                task['release_date'] = self.today
            else:
                task['release_date'] = item['starttime']
            self.logger.debug(
                    "The release date is : %s", task['release_date'])

            task['city'] = response.meta['city']
            task['id'] = item['id']
            task['title'] = item['title']

            task['category_name'] = response.xpath(
                    '//*[contains(@class, "lx")]/text()').extract_first()

            self.logger.debug("Trace 7....")

            qs = response.xpath(
                    '//*[contains(@class, "rs")]/text()').extract_first()
            if qs:
                r = re.search(r'(\d+)', qs)
                if r:
                    task['need_quantity'] = int(r.group(1))
            self.logger.debug("Trace 8: need quantity....")

            if item['salary']:
                r = re.search(ur'(\d+).*?/([^\<]?)', item['salary'])
                if r:
                    task['salary'], task['salary_unit'] = r.group(1, 2)
            self.logger.debug("Trace 9: salary....")

            task['content'] = response.xpath('//pre[contains(@class, "con")]/text()').extract_first()
            task['company_name'] = response.xpath('//span[contains(@class, "gs")]/a/text()').extract_first()
            self.logger.debug("Trace 10: content and company_name ....")

            contact = response.xpath('//div[contains(@class, "m-jxcall")]/ul/li/text()').extract_first()
            if contact:
                task['contact'] = contact.split(u'\uff1a', 1)[-1]
            phonenum = response.xpath('//a[contains(@href, "tel:")]/@href').extract_first()
            if phonenum:
                task['phonenum'] = phonenum.split(':')[-1]
            self.logger.debug("Trace 11: contact and phonenum ....")

            address = response.xpath('//address/text()').extract_first()
            if address:
                task['address'] = address.split(':', 1)[-1].strip()
            self.logger.debug("Trace 12:  address....")

            location_href = response.xpath('//a[contains(@href, "http://api.map.baidu.com")]/@href').extract_first()
            if location_href:
                r = re.search(r'location=([\d\.]+),([\d\.]+)&', location_href)
                if r:
                    task['lat'] = r.group(1)
                    task['lng'] = r.group(2)
            self.logger.debug("Trace end: location....")
            yield task
        except Exception, e:
            self.logger.error("parse detail failed with error: %s" % e)


    """
    def login(self, username=18661775819, password=123123):

        url = "http://www.jianzhimao.com/ctrlcity/login"
        vurl = "http://www/jianzhimao.com/ctrlcommon/ValidateCode"
        decaptcha = deathbycaptcha.SocketClient(username, password)
        cj = cookielib.CookieJar()
        opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
        opener.addheaders = [('User-Agent', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.2.11) Gecko/20101012 Firefox/3.6.11'),
                    ]
        opener.open(url)

        def _login_post():
            retry = 3
            while retry>0:
                img = opener.open(vurl)
                cres = decaptcha.upload(img)
                if cres:
                    vcode = cres['text']
                    break;
                retry -= 1

            params = {
                    'user_type': 1,
                    'account': username,
                    'password': password,
                    'webcode': vcode,
                    'auto_login': True
                    }
            req = urllib2.Request(url, urllib.urlencode(params))
            res = opener.open(req)

        retry = 3
        while retry>0:
            retry -= 1
            if _login_post():
                self.build_start_request(cj)
                break

    def build_start_request(self, cookiejar):
        url = "http://m.jianzhimao.com/job?p=5&prov=%E5%8C%97%E4%BA%AC%E5%B8%82&c=%E5%8C%97%E4%BA%AC&a=&type=";
        for cookie in cj:
            cookie.name, cookie.value, cookie.domain #etc etc
    """


