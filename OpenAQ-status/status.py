#!/usr/bin/env python
import json
import os
import re
import sys  
import operator
import math
import urllib
import string
from datetime import datetime
from datetime import timedelta
import time

#reload(sys)  
#sys.setdefaultencoding('utf8')


OPENAQ_URL = "https://api.openaq.org/v1/latest?parameter=pm25&limit=10000"

response = urllib.urlopen(OPENAQ_URL)
data = json.loads(response.read())
feeds = data['results']
results = []
num = 0
err = 0
for item in feeds:
	try:
		site = {}
		site["sensor"] = {}
		site["sensor"]["pm25"] = -1
		site["sensor"]["pm10"] = -1
		site["sensor"]["o3"] = -1
		site["sensor"]["no2"] = -1
		site["sensor"]["so2"] = -1
		site["sensor"]["co"] = -1
		site["sensor"]["bc"] = -1
		site["active"] = -1

		if "coordinates" in item:
			site["gps_lat"] = item["coordinates"]["latitude"]
			site["gps_lon"] = item["coordinates"]["longitude"]
		else:
			err = err + 1
			continue

		site["timestamp"] = item["measurements"][0]["lastUpdated"]
		site["sourceName"] = item["measurements"][0]["sourceName"]
		site["location"] = item["location"]
		site["city"] = item["city"]
		site["country"] = item["country"]

		for sensor in item["measurements"]:
			site["sensor"][sensor["parameter"]] = sensor["value"]
			site["active"] = 1
		ts = item["measurements"][0]["lastUpdated"]
		current = datetime.now()
		timestamp = datetime.strptime(ts,'%Y-%m-%dT%H:%M:%S.000Z')
		difference = current - timestamp
		if difference.seconds < 0 or difference.seconds > 60 * 60 * 8 or difference.days > 0:
			site["active"] = -1
		site["diff_s"] = difference.seconds
		site["diff_d"] = difference.days


		num = num + 1
		results.append(site)
	except:
		err = err + 1
		continue

msg = {}
source = str(os.path.basename(__file__)).split(".")
msg["source"] = str(source[0] + " by IIS-NRL").encode("utf-8")
msg["num_of_records"] = num
msg["num_of_error_records"] = err
msg["feeds"] = results
utc_datetime = datetime.utcnow()
msg["version"] = utc_datetime.strftime("%Y-%m-%dT%H:%M:%SZ")

json_results = json.dumps(msg)
print json_results

