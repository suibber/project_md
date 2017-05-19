# -*- coding: utf-8 -*-
import scrapy
import re
import urllib2
from scrapy.utils.project import get_project_settings

from spider.items import Task
import simplejson
import math

from spider.items import NearbyTaskList
from spider import utils

class XlbNearbySpider(scrapy.Spider):

    name = "xiaolianbang_nearby"
    allowed_domains = ["m.xiaolianbang.com"]

    city_locations = {}
    origin = 'xiaolianbang'

    def start_requests(self):
        return [scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities
                )]

    def parse_cities(self, response):
        content = response.body
        res = re.findall('data-city="([^"]+)"', content)
        for city in res:
            location  = utils.get_location(city.decode('utf-8'))
            if location:
                self.city_locations[city] = location
            else:
                self.logger.error(
                        "No location for :%s , we cloud not get nearby list of this city",
                        city)
        for city, location in self.city_locations.items():
            yield self.build_list_request(city, location, extend="left_top")
            yield self.build_list_request(city, location, extend="right_top")
            yield self.build_list_request(city, location, extend="right_bottom")
            yield self.build_list_request(city, location, extend="left_bottom")

    def build_list_request(self, city, location, extend, page=1):
        return scrapy.http.Request(
                "http://m.xiaolianbang.com/pt/nearby?page=%s&lng=%s&lat=%s" % (
                    page, location['lng'], location['lat']),
                cookies = location,
                meta={
                    'city': city,
                    'page': page,
                    'location': location,
                    'extend': extend,
                    },
                callback=self.parse_list)

    def parse_list(self, response):
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())

        extend = response.meta['extend']
        page = response.meta['page']
        location = response.meta['location']
        city = response.meta['city']
        if len(_ids)>0:
            task_list =  NearbyTaskList()
            task_list['origin'] = self.origin
            task_list['ids'] = _ids
            task_list['city'] = city
            yield task_list
            yield self.build_list_request(
                    city, location, extend=extend, page=page+1)
        else:
            if page>1:
                for loc in self.expandLocaton(location, extend):
                    yield self.build_list_request(
                            response.meta['city'], loc, extend=extend)

    def expandLocaton(self, location, extend):
        lat = location['lat']
        lng = location['lng']
        # 20 KM
        distance = 50.0

        lat_range = 180.0/math.pi*distance/6372.797
        lng_range = lat_range/math.cos(lat*math.pi/180.0)
        if 'left' in extend:
            yield {'lat': lat - lat_range, 'lng': lng}

        if 'top' in extend:
            yield {'lat': lat, 'lng': lng + lng_range}

        if 'right' in extend:
            yield {'lat': lat + lat_range, 'lng': lng}

        if 'bottom' in extend:
            yield {'lat': lat, 'lng': lng - lng_range}
