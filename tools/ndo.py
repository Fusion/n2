#!/bin/env python

########################################################
# CONFIGURATION - YOU NEED TO EDIT BELOW               #
########################################################

db_name = "testn2"
db_prfx = "n2_"
db_user = "testn2"
db_pass = "testn2"
db_host = "localhost"

########################################################
# PRIVATE FUNCTIONS                                    #
########################################################

conn   = None
cursor = None

def display_usage(extra = None):
	print "Syntax: __file__ <action> [arguments]"
	print "Actions:"
	print "- addstr <name> \"<string>\" [admin]"
	print "- setoption <text|textarea|select|checkbox> <group> <name> \"<value>\" [displayorder [hidden]]"
	print "- readoption <group> [name]"
	print "- deloption <group> <name>"
	if extra != None:
		print "\nNote: %s\n" % extra

def display_error(msg):
	print "ERROR: " + msg

def db_connect():
	global conn
	try:
		conn = MySQLdb.connect(
			host = db_host,
			user = db_user,
			passwd = db_pass,
			db = db_name)
	except MySQLdb.Error, e:
		display_error("(DB) %d: %s" % (e.args[0], e.args[1]))
		sys.exit(-2)

def db_select(sql):
	global conn
	global cursor
	cursor = conn.cursor(MySQLdb.cursors.DictCursor)
	cursor.execute(sql)
	result = cursor.fetchall()
	return result

def db_exec(sql):
	global conn
	global cursor
	cursor = conn.cursor()
	cursor.execute(sql)

def db_neuter(txt):
	return re.sub('''(['"])''', r'\\\1', txt)
	
# Add a dictionary string
def addstr():
	if len(sys.argv) < 4:
		display_usage()
		sys.exit(-2)
	str_key = sys.argv[2]
	str_val = db_neuter(sys.argv[3])
	suffix = ''
	if len(sys.argv) > 4:
		if sys.argv[4] == 'admin':
			suffix = '_admin'
		else:
			display_usage("Admin parameter should be absent or 'admin'")
			sys.exit(-2)
	new_str = "$lang['%s'] = '%s';" % (str_key, str_val)
	print "Creating new dictionary entry:\n%s\n" % new_str
	for x in ['chinese', 'english', 'indonesian', 'simplified_chinese']:
		curfile = __PATH__ + 'language/' + x + suffix + '.php'
		print "Updating: %s" % curfile
		f = open(curfile, 'a');
		f.write(new_str)
		f.close()

# Add/update a bboption
def setoption():
	if len(sys.argv) < 6:
		display_usage()
		sys.exit(-2)
	str_type = db_neuter(sys.argv[2])
	str_group = db_neuter(sys.argv[3])
	str_name = db_neuter(sys.argv[4])
	str_value = db_neuter(sys.argv[5])
	str_order = None
	str_hidden = None
	if len(sys.argv) > 6:
		str_order = sys.argv[6]
		if len(sys.argv) > 7:
			str_hidden = sys.argv[7]
	if str_type != 'text' and str_type != 'textarea' and str_type != 'select' and str_type != 'checkbox':
		display_usage("Illegal value for Type parameter")
		sys.exit(-2)
	if str_order != None and str_order.isdigit() == False:
		display_usage("Order parameter should be integer")
		sys.exit(-2)
	if str_hidden != None and str_hidden != 'hidden':
		display_usage("Hidden parameter should be absent or 'hidden'")
		sys.exit(-2)
	if str_order == None:
		str_order = 'NULL'
	if str_hidden == 'hidden':
		str_hidden = '1'
	else:
		str_hidden = 'NULL'
	str_settingName = 'admin_options_' + str_group + '_' + str_name
	db_connect()	
	options = db_select("SELECT * FROM %swtcbboptions WHERE settingName='%s'" % (db_prfx, str_settingName))
	if len(options) > 1:
		display_error("More than one option exists with this key")
		sys.exit(-2)
	if len(options) == 1:
		print "Info: Updating option"
		sql = "UPDATE %swtcbboptions SET settingType='%s', value='%s', settingName='%s', settingGroup='%s', name='%s', displayOrder=%s, hidden=%s WHERE settingName='%s'" % (db_prfx, str_type, str_value, str_settingName, str_group, str_name, str_order, str_hidden, str_settingName)
	else:
		print "Info: Creating option"
		sql = "INSERT INTO %swtcbboptions (settingType, value, settingName, settingGroup, name, displayOrder, hidden) VALUES('%s', '%s', '%s', '%s', '%s', %s, %s)" % (db_prfx, str_type, str_value, str_settingName, str_group, str_name, str_order, str_hidden)
	db_exec(sql)

def readoption():
	if len(sys.argv) < 3:
		display_usage()
		sys.exit(-2)
	str_group = db_neuter(sys.argv[2])
	if len(sys.argv) > 3:
		str_name = db_neuter(sys.argv[3])
	else:
		str_name = None
	db_connect()	
	if str_name != None:
		str_settingName = 'admin_options_' + str_group + '_' + str_name
		options = db_select("SELECT * FROM %swtcbboptions WHERE settingName='%s'" % (db_prfx, str_settingName))
	else:
		options = db_select("SELECT * FROM %swtcbboptions WHERE settingGroup='%s'" % (db_prfx, str_group))
	if len(options) < 1:
		print "This option does not exist"
	else:
		for option in options:
			if option['hidden'] == 1:
				option['hidden'] = 'hidden'
			else:
				option['hidden'] = ''
			print "%s %s %s \"%s\" %s %s" % (option['settingType'], option['settingGroup'],option['name'],option['value'],option['displayOrder'],option['hidden'])

def deloption():
	if len(sys.argv) < 4:
		display_usage()
		sys.exit(-2)
	str_group = db_neuter(sys.argv[2])
	str_name = db_neuter(sys.argv[3])
	db_connect()	
	str_settingName = 'admin_options_' + str_group + '_' + str_name
	sql = "DELETE FROM %swtcbboptions WHERE settingName='%s'" % (db_prfx, str_settingName)
	db_exec(sql)

########################################################
# MAIN                                                 #
########################################################

import sys
import os
import shutil
import stat
import re
try:
	import MySQLdb
except:
	display_error("You need to install the MySQLdb module: download from http://sourceforge.net/projects/mysql-python/")
	sys.exit(-1)

__PATH__ = os.path.abspath(os.path.dirname(__file__)) + '/../'

if len(sys.argv) < 2:
        display_usage()
        sys.exit(-1)

{	'addstr'	: addstr,
	'setoption'	: setoption,
	'readoption'	: readoption,
	'deloption'	: deloption,
        'help'		: display_usage,
}.get(sys.argv[1], display_usage)()

sys.exit(0)
