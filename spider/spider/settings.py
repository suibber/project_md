# -*- coding: utf-8 -*-

# Scrapy settings for mspider project
#
# For simplicity, this file contains only settings considered important or
# commonly used. You can find more settings consulting the documentation:
#
#     http://doc.scrapy.org/en/latest/topics/settings.html
#     http://scrapy.readthedocs.org/en/latest/topics/downloader-middleware.html
#     http://scrapy.readthedocs.org/en/latest/topics/spider-middleware.html
import datetime

BOT_NAME = 'spider'

LOG_LEVEL = 'WARNING'
LOG_FILE = '/service/data/logs/spider/%s.log' % datetime.date.today()

SPIDER_MODULES = ['spider.spiders']
NEWSPIDER_MODULE = 'spider.spiders'

COOKIES_ENABLED=True
COOKIES_DEBUG = False

MYSQL_CONFIG = {
        "host":"localhost", 
        "user":"root",
        "passwd":"123123",
        "db":"miduoduo",
        "use_unicode": True,
        "charset": "utf8",
        }
BAIDU_MAP_KEY = 'oUVOlwx2f8Ok7iGt30CcB2aQ'

USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.94 Safari/537.36'

CONCURRENT_REQUESTS=32

#DOWNLOAD_DELAY=3
#CONCURRENT_REQUESTS_PER_DOMAIN=16
#CONCURRENT_REQUESTS_PER_IP=16

#COOKIES_ENABLED=False

#TELNETCONSOLE_ENABLED=False

DEFAULT_REQUEST_HEADERS = {
   'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
   'Accept-Language': 'en',
}

SPIDER_MIDDLEWARES = {
}

DOWNLOADER_MIDDLEWARES = {
}
EXTENSIONS = {
}
ITEM_PIPELINES = {
    'spider.pipelines.SpiderPipeline': 300,
}
#AUTOTHROTTLE_ENABLED=True
# The initial download delay

#AUTOTHROTTLE_START_DELAY=5
# The maximum download delay to be set in case of high latencies

#AUTOTHROTTLE_MAX_DELAY=60
# Enable showing throttling stats for every response received:
#AUTOTHROTTLE_DEBUG=False

#HTTPCACHE_ENABLED=True
#HTTPCACHE_EXPIRATION_SECS=0
#HTTPCACHE_DIR='httpcache'
#HTTPCACHE_IGNORE_HTTP_CODES=[]
#HTTPCACHE_STORAGE='scrapy.extensions.httpcache.FilesystemCacheStorage'
import os
ROOT = os.path.dirname(os.path.realpath(__file__))
execfile(os.path.join(ROOT, "settings_local.py"))
