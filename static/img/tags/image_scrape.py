#!/usr/bin/env python
# -*- coding: utf-8 -*- 

import MySQLdb as mdb
import sys
import requests
import json
import urllib2
import hashlib
import time
#Connect to MySQL db, get list of image fields to scrape

def lookup(num):
	num = int(num)
	conn = mdb.connect('127.0.0.1', 'YRS-2013', 'hipercritical', 'yrs-2013', port=3306, charset='utf8')
	cur = conn.cursor()
	cur.execute("SELECT * FROM tagque LIMIT 0,1")
	fetched = cur.fetchall()
	return_tag = fetched[num][1]
	conn.close()
	delete_tag(return_tag)
	return return_tag

def delete_tag(return_tag):
	conn = mdb.connect('127.0.0.1', 'YRS-2013', 'hipercritical', 'yrs-2013', port=3306, charset='utf8')
	cur = conn.cursor()
	cur.execute("DELETE FROM `tagque` WHERE `tag`=%s", (return_tag))
	conn.commit()
	#DELETE FROM tagque WHERE idea=...

def mysql_connection(img_name, tag_raw, tag_name, checksum):
	try:
		conn = mdb.connect('127.0.0.1', 'YRS-2013', 'hipercritical', 'yrs-2013', port = 3306,charset='utf8')
		cur = conn.cursor()
		cur.execute("INSERT INTO images (checksum, url) VALUES (%s, %s)", (checksum, img_name))
		conn.commit()
		print "get last id"
		print cur.lastrowid
		print img_name
		last_img_id2 = cur.lastrowid
	except mdb.Error, e:
		print "Error, I died... I know that's not very helpful but meh %d: %s" % (e.args[0], e.args[1])
		#conn.close()
		pass
		last_img_id2=0
	finally:
		if conn:
			conn.close()
			return last_img_id2

def insert_tags(tag_raw, tag_name, last_img_id):
	print last_img_id
	try:
		conn = mdb.connect('127.0.0.1', 'YRS-2013','hipercritical', 'yrs-2013', port=3306, charset='utf8')
		cur = conn.cursor()
		cur.execute("INSERT INTO imagetag (imageid, languageid, name, machine) VALUES (%s, %s, %s,%s)", (last_img_id, "1", tag_raw,"1"))
		#print tag_raw
		conn.commit()
	except mdb.Error, e:
		print "Error inserting tags... %d: %s" % (e.args[0], e.args[1])
		#conn.close()
		pass
	finally:
		if conn:
			conn.close()

#Connect to Flickr API, perform request
i = 0
tag = lookup(i)
tag_length = len(tag)
while i < tag_length:
	if i == 0:
		url_tag = tag[i]
	else:
		#url_tag = url_tag + "," + tag[i]
		url_tag = tag[i]
	i += 1
url_tag=tag
tag_name=tag

	
url = "http://ycpi.api.flickr.com/services/rest/?method=flickr.photos.search&sort=relevance&safety_level=safe&per_page=10&api_key=37cf642c93fc4bc58d8be3292db48442&format=json&text=" + url_tag

r = requests.get(url)
txt = r.text
txt = txt[14:-1]
json_data = json.loads(txt)
#print json_data
json_data = json_data["photos"]["photo"]
#print json_data
#Follow URL :-)
#Iterate thru all json_data to find id
json_length = len(json_data)
i = 0
id_list = []
farm_list = []
server_id = []
secret = []
while i < json_length:
	cur_id = json_data[i]["id"]
	cur_farm = json_data[i]["farm"]
	cur_server = json_data[i]["server"]
	cur_secret = json_data[i]["secret"]
	img_url = "http://farm" + str(cur_farm) + ".staticflickr.com/" + str(cur_server) + "/" + str(cur_id) + "_" + str(cur_secret) + "_n.jpg"
	#Get tags!
	tag_url = "https://secure.flickr.com/services/rest/?method=flickr.photos.getInfo&format=json&api_key=37cf642c93fc4bc58d8be3292db48442&photo_id=" + cur_id
	g = requests.get(tag_url)
	time.sleep(1)
	tag_txt = g.text
	tag_txt = tag_txt[14:-1]
	#print tag_txt
	#print "\n"
	json_tag_txt = json.loads(tag_txt)
	a = 0
	a = int(a)
	tag_raw = []
	tag_ids = []
	json_tag_txt = json_tag_txt["photo"]["tags"]["tag"]
	tag_len = len(json_tag_txt)
	q = 0
	img_name = tag_name + str(i) + ".jpg"
	img = urllib2.urlopen(img_url).read()
	checksum = hashlib.md5(img)
	checksum = checksum.hexdigest()
	#print checksum
	with open(img_name, 'wb') as f:
		f.write(img)
		f.close()
	i += 1
	last_img_id = mysql_connection(img_name, tag_raw, tag_ids, checksum)
	insert_tags(tag_name, "", last_img_id)
	for tag_loop in json_tag_txt:
		tag_id = tag_loop["id"]
		tag_txt = tag_loop["raw"]
		insert_tags(tag_txt, tag_id, last_img_id)
		a += 1
		tag_raw.append(tag_txt)
		tag_ids.append(tag_id)

#Insert back into SQL db, the tag URL, the tags - both raw, id
#http://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
#Grab the image, based on the image ID - then grab the tags

#Resize image