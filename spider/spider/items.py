# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class Company(scrapy.Item):
    name = scrapy.Field()


class TaskAddress(scrapy.Item):
    pass


class Task(scrapy.Item):

    id = scrapy.Field()
    origin = scrapy.Field()

    city = scrapy.Field()

    title = scrapy.Field()
    category_name = scrapy.Field(default=u'其他')
    is_long_term = scrapy.Field(default=True)
    from_date = scrapy.Field(default='1999-09-19')
    to_date = scrapy.Field(default='1999-09-09')
    from_time = scrapy.Field()
    to_time = scrapy.Field()
    address = scrapy.Field()
    content = scrapy.Field()
    need_quantity = scrapy.Field()
    salary = scrapy.Field(default=0)
    salary_unit = scrapy.Field()
    clearance_period = scrapy.Field()
    company_name = scrapy.Field()
    contact = scrapy.Field()
    phonenum = scrapy.Field()
    email = scrapy.Field()
    release_date = scrapy.Field()
    gender = scrapy.Field()

    lat = scrapy.Field()
    lng = scrapy.Field()


class NearbyTaskList(scrapy.Item):

    ids = scrapy.Field()
    city = scrapy.Field()
    origin = scrapy.Field()
