#!/bin/bash

source /service/miduoduo/spider/.env/bin/activate
cd /service/miduoduo/spider
scrapy runspider spider/spiders/xiaolianbang.py
scrapy runspider spider/spiders/xiaolianbang_nearby.py
