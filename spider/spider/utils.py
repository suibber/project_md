# -*- coding: utf-8 -*-
import urllib2
import urllib
import simplejson
import logging

from scrapy.utils.project import get_project_settings

logger = logging.getLogger(__file__)


settings = get_project_settings()

def build_pio_url(address, city=''):
    params = {
            'address': address.encode('utf-8'),
            'city': city.encode('utf-8'),
            'output': 'json',
            'key': settings.get('BAIDU_MAP_KEY')
            }
    query = urllib.urlencode(params)
    return "http://api.map.baidu.com/geocoder?%s" % query


def get_location(address, city=''):
    url = build_pio_url(address, city)
    logger.debug(
            "get city: %s url: %s",
            city, url)
    try:
        fp = urllib2.urlopen(url)
        c = fp.read()
        r = simplejson.loads(c)
        return r['status']=='OK' and r['result'] and r['result']['location']
    except Exception, e:
        logger.info(
                "Failed to get address location: %s-'%s' with exception: %s",
                city, address, e)
