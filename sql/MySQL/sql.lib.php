<?php
/*
 * "n2" - Forum Software - a nBBS v0.6 + wtcBB remix.
 * Copyright (C) 2009 Chris F. Ravenscroft
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * 
 * Questions? We can be reached at http://www.nextbbs.com
 */
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## ****************** MySQL Queries ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/***** CREATING A NEW ENGINE ***** \\
* In order to create a new engine, you will need
* to re-create every single query in this file, but
* using the syntax of your desired engine. Theoretically
* wtcBB should be able to work with any engine out there,
* as long as you can re-create each query (main engine is
* MySQL). Make sure you keep the question marks in their
* appropriate places. Make sure you keep the array variable
* names _exactly_ the same. It shouldn't take too much time
* to convert queries, there are only subtle differences syntactically
* between most engines.
*/


// ##### GLOBAL Queries ##### \\
$query['global']['options'] = 'SELECT * FROM ' . WTC_TP . 'wtcbboptions';

$query['global']['get_table_fields'] = 'SHOW COLUMNS FROM ' . WTC_TP . '?';

$query['global']['get_words'] = 'SELECT name, words, defaultid, wordsid FROM ' . WTC_TP . 'lang_words WHERE langid = \'?\' OR defaultid = 0 ORDER BY defaultid, name ASC';

$query['global']['get_user_byUsername'] = '
	SELECT
		' . WTC_TP . 'userinfo.*, ' . WTC_TP . 'userinfo_pro.*
	FROM
		' . WTC_TP . 'userinfo
	LEFT JOIN
		' . WTC_TP . 'userinfo_pro
		ON
			' . WTC_TP . 'userinfo_pro.user_id = ' . WTC_TP . 'userinfo.userid
	WHERE username = \'?\'
';

$query['global']['get_user_byId'] = '
	SELECT
		' . WTC_TP . 'userinfo.*, ' . WTC_TP . 'userinfo_pro.*
	FROM
		' . WTC_TP . 'userinfo
	LEFT JOIN
		' . WTC_TP . 'userinfo_pro
		ON
			' . WTC_TP . 'userinfo_pro.user_id = ' . WTC_TP . 'userinfo.userid
	WHERE userid = \'?\'
';

$query['global']['get_user_byId_req'] = '
	SELECT ' . WTC_TP . 'userinfo.*, ' . WTC_TP . 'userinfo_pro.*,
		COUNT(' . WTC_TP . 'logger_ips.log_ipid) AS loggedIps
	FROM ' . WTC_TP . 'userinfo
	LEFT JOIN ' . WTC_TP . 'logger_ips
		ON ' . WTC_TP . 'logger_ips.userid = ' . WTC_TP . 'userinfo.userid
		AND ' . WTC_TP . 'logger_ips.ip_address = \'' . $_SERVER['REMOTE_ADDR'] . '\'
	LEFT JOIN ' . WTC_TP . 'userinfo_pro
		ON ' . WTC_TP . 'userinfo_pro.user_id = ' . WTC_TP . 'userinfo.userid
	WHERE ' . WTC_TP . 'userinfo.userid = \'?\'
	GROUP BY ' . WTC_TP . 'userinfo.username
';

$query['global']['get_usergroup_byId'] = 'SELECT * FROM ' . WTC_TP . 'usergroups WHERE usergroupid = \'?\'';

$query['global']['get_usertitles'] = 'SELECT * FROM ' . WTC_TP . 'ranks';

$query['global']['get_cache'] = 'SELECT title, cache, array FROM ' . WTC_TP . 'cache';

$query['global']['cache_insert'] = 'INSERT INTO ' . WTC_TP . 'cache (title, cache, array) VALUES (\'?\', \'?\', \'?\')';

$query['global']['cache_update'] = 'UPDATE ' . WTC_TP . 'cache SET title = \'?\', cache = \'?\' , array = \'?\' WHERE title = \'?\'';


// ##### USER QUERIES ##### \\
$query['user']['all_users'] = 'SELECT * FROM ' . WTC_TP . 'userinfo';

$query['user']['all_users_admin'] = 'SELECT userid, usergroupid, secgroupids FROM ' . WTC_TP . 'userinfo';

$query['user']['count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'userinfo';

$query['user']['exists_id'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE userid = \'?\'';

$query['user']['exists_username'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE username = \'?\'';

$query['user']['newest'] = 'SELECT userid, username FROM ' . WTC_TP . 'userinfo ORDER BY joined DESC LIMIT 1';

$query['user']['update'] = 'UPDATE ' . WTC_TP . 'userinfo SET ? WHERE userid = \'?\'';

$query['user']['insert'] = 'INSERT INTO ' . WTC_TP . 'userinfo (?) VALUES (?)';

$query['user']['update_counts'] = 'UPDATE ' . WTC_TP . 'userinfo SET threads = (threads + ?) , posts = (posts + ?) WHERE userid = \'?\'';

$query['user']['searchUsers'] = 'SELECT * FROM ' . WTC_TP . 'userinfo WHERE ?';

$query['user']['checkUniqueEmail'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE email = \'?\'';

$query['user']['checkUniqueEmail_edit'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE email = \'?\' AND userid != \'?\'';

$query['user']['checkUniqueName'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE username = \'?\'';

$query['user']['checkUniqueName_edit'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo WHERE username = \'?\' AND userid != \'?\'';

$query['user']['get_activation'] = 'SELECT userid FROM ' . WTC_TP . 'userinfo WHERE passTime = \'?\'';

$query['user']['referrer'] = 'UPDATE ' . WTC_TP . 'userinfo SET referrals = (referrals + 1) WHERE username = \'?\'';

$query['user']['get_banned'] = 'SELECT ' . WTC_TP . 'userinfo_ban.*, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'usergroups.title FROM ' . WTC_TP . 'userinfo_ban LEFT JOIN ' . WTC_TP . 'usergroups ON ' . WTC_TP . 'usergroups.usergroupid = ' . WTC_TP . 'userinfo_ban.usergroupid LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_ban.userid';

$query['user']['get_banned_user'] = 'SELECT ' . WTC_TP . 'userinfo_ban.*, ' . WTC_TP . 'userinfo.username FROM ' . WTC_TP . 'userinfo_ban LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_ban.userid WHERE banid = \'?\'';

$query['user']['get_banned_users'] = 'SELECT ' . WTC_TP . 'userinfo_ban.*, ' . WTC_TP . 'userinfo.username FROM ' . WTC_TP . 'userinfo_ban LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo_ban.userid = ' . WTC_TP . 'userinfo.userid WHERE banLength > 0 AND (banStart + banLength) <= \'' . NOW . '\'';

$query['user']['ban_user_insert'] = 'INSERT INTO ' . WTC_TP . 'userinfo_ban (userid, usergroupid, banLength, banStart, previousGroupId) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\')';

$query['user']['ban_user_update'] = 'UPDATE ' . WTC_TP . 'userinfo_ban SET usergroupid = \'?\' , banLength = \'?\' , banStart = \'?\' WHERE userid = \'?\'';

$query['user']['check_banned'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'userinfo_ban WHERE userid = \'?\'';

$query['user']['log_ip'] = 'INSERT INTO ' . WTC_TP . 'logger_ips (ip_address, userid) VALUES (\'?\', \'?\')';

$query['user']['ip_userid'] = 'SELECT ' . WTC_TP . 'logger_ips.ip_address, ' . WTC_TP . 'userinfo.* FROM ' . WTC_TP . 'logger_ips LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'logger_ips.userid WHERE ' . WTC_TP . 'userinfo.userid = \'?\'';

$query['user']['ip_ip'] = 'SELECT ' . WTC_TP . 'logger_ips.ip_address, ' . WTC_TP . 'userinfo.* FROM ' . WTC_TP . 'logger_ips LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'logger_ips.userid WHERE ip_address LIKE \'?%\'';

$query['user']['memList_count'] = '
SELECT
	COUNT(*) AS total
FROM
	' . WTC_TP . 'userinfo
';

$query['user']['memList'] = '
SELECT
	' . WTC_TP . 'userinfo.*, ' . WTC_TP . 'sessions.userid AS isOnline
FROM
	' . WTC_TP . 'userinfo
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
ORDER BY
	' . WTC_TP . 'userinfo.? ?
';

// merge queries...
$query['user']['merge']['logger_admin'] = 'UPDATE ' . WTC_TP . 'logger_admin SET log_userid = \'?\' WHERE log_userid = \'?\'';

$query['user']['merge']['logger_ips'] = 'UPDATE ' . WTC_TP . 'logger_ips SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['logger_mods'] = 'UPDATE ' . WTC_TP . 'logger_mods SET log_userid = \'?\' WHERE log_userid = \'?\'';

$query['user']['merge']['moderators'] = 'UPDATE ' . WTC_TP . 'moderators SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['personal_folders'] = 'UPDATE ' . WTC_TP . 'personal_folders SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['personal_msg'] = 'UPDATE ' . WTC_TP . 'personal_msg SET sentTo = \'?\' WHERE sentTo = \'?\'';

$query['user']['merge']['personal_msg2'] = 'UPDATE ' . WTC_TP . 'personal_msg SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['personal_receipt'] = 'UPDATE ' . WTC_TP . 'personal_receipt SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['personal_rules'] = 'UPDATE ' . WTC_TP . 'personal_rules SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['subscriptions'] = 'UPDATE ' . WTC_TP . 'subscriptions SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['warn'] = 'UPDATE ' . WTC_TP . 'warn SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['warn2'] = 'UPDATE ' . WTC_TP . 'warn SET whoWarned = \'?\' WHERE whoWarned = \'?\'';

$query['user']['merge']['userinfo_ban'] = 'UPDATE ' . WTC_TP . 'userinfo_ban SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['posts'] = 'UPDATE ' . WTC_TP . 'posts SET userid = \'?\' WHERE userid = \'?\'';

$query['user']['merge']['threads'] = 'UPDATE ' . WTC_TP . 'threads SET madeby = \'?\' WHERE madeby = \'?\'';

$query['user']['merge']['update_postcount'] = 'UPDATE ' . WTC_TP . 'userinfo SET posts = (posts + ?) , threads = (threads + ?) WHERE userid = \'?\'';


// ##### USER CUSTOM PROFILE QUERIES ##### \\
$query['userinfo_pro']['insert'] = 'INSERT INTO ' . WTC_TP . 'userinfo_pro (?) VALUES (?)';

$query['userinfo_pro']['update'] = 'UPDATE ' . WTC_TP . 'userinfo_pro SET ? WHERE user_id = \'?\'';

$query['userinfo_pro']['check'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'userinfo_pro WHERE user_id = \'?\'';


// ##### STYLES QUERIES ##### \\
$query['styles']['insert'] = 'REPLACE INTO ' . WTC_TP . 'styles (?) VALUES (?)';

$query['styles']['update'] = 'UPDATE ' . WTC_TP . 'styles SET ? WHERE styleid = \'?\'';

$query['styles']['get'] = 'SELECT styleid, parentid, name, selectable, enabled, fragmentids, css, disOrder FROM ' . WTC_TP . 'styles WHERE styleid = \'?\'';

$query['styles']['get_all'] = 'SELECT styleid, parentid, name, disOrder, selectable, enabled, fragmentids, css FROM ' . WTC_TP . 'styles ORDER BY disOrder, name';


// ##### STYLE FRAGMENT QUERIES ##### \\
$query['styles_fragments']['insert'] = 'REPLACE INTO ' . WTC_TP . 'styles_fragments (?) VALUES (?)';

$query['styles_fragments']['update'] = 'UPDATE ' . WTC_TP . 'styles_fragments SET ? WHERE fragmentid = \'?\'';

$query['styles_fragments']['get'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE fragmentid = \'?\'';

$query['styles_fragments']['get_all'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments';

$query['styles_fragments']['get_all_default'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE defaultid = 0';

$query['styles_fragments']['get_all_custom'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE defaultid = -1';

$query['styles_fragments']['get_all_inStyle'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE (fragmentid IN (?) OR defaultid = 0) AND fragmentType LIKE \'?\' ORDER BY fragmentVarName';

$query['styles_fragments']['get_all_inStyle_style'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE (fragmentid IN (?) OR defaultid = 0) AND fragmentType LIKE \'?\' ORDER BY disOrder, fragmentVarName';

$query['styles_fragments']['search'] = 'SELECT fragmentid, styleid, groupid, fragmentName, fragmentVarName, fragmentType, fragment, template_php, defaultid, disOrder FROM ' . WTC_TP . 'styles_fragments WHERE (fragmentid IN (?) OR defaultid = 0) AND fragmentType LIKE \'?\' AND (fragmentVarName LIKE \'%?%\' OR fragment LIKE \'%?%\') ORDER BY fragmentVarName';

$query['styles_fragments']['get_all_ids'] = 'SELECT fragmentid FROM ' . WTC_TP . 'styles_fragments WHERE fragmentType LIKE \'?\'';

// ##### SESSION QUERIES ##### \\
$query['sessions']['replace'] = 'REPLACE INTO ' . WTC_TP . 'sessions (sessionid, username, userid, lastactive, loc, details, ip, userAgent, lastaction) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['sessions']['update_usernames'] = 'UPDATE ' . WTC_TP . 'sessions SET username = \'?\' WHERE userid = \'?\'';

$query['sessions']['update_action'] = 'UPDATE ' . WTC_TP . 'sessions SET lastaction = \'?\' WHERE sessionid = \'?\'';

$query['sessions']['get'] = 'SELECT ' . WTC_TP . 'sessions.sessionid, ' . WTC_TP . 'userinfo.* FROM ' . WTC_TP . 'sessions LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'sessions.userid WHERE ' . WTC_TP . 'sessions.sessionid = \'?\' AND ' . WTC_TP . 'userinfo.userid > 0';

$query['sessions']['get_noUser'] = 'SELECT * FROM ' . WTC_TP . 'sessions WHERE sessionid = \'?\'';

$query['sessions']['get_all_noUser'] = 'SELECT sessionid, userid, COUNT(userid) AS num FROM ' . WTC_TP . 'sessions WHERE userid > 0 GROUP BY userid';

$query['sessions']['get_all'] = '
SELECT
	' . WTC_TP . 'sessions.sessionid, ' . WTC_TP . 'sessions.lastactive, ' . WTC_TP . 'sessions.loc,
	' . WTC_TP . 'sessions.details, ' . WTC_TP . 'sessions.ip, ' . WTC_TP . 'sessions.userAgent,
	' . WTC_TP . 'sessions.username AS sessUsername, ' . WTC_TP . 'sessions.userid AS sessUserid, ' . WTC_TP . 'userinfo.username,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd
FROM
	' . WTC_TP . 'sessions
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
ORDER BY
	' . WTC_TP . 'userinfo.username
';

$query['sessions']['get_all_inThreadForum'] = '
SELECT
	' . WTC_TP . 'sessions.sessionid, ' . WTC_TP . 'sessions.lastactive, ' . WTC_TP . 'sessions.loc,
	' . WTC_TP . 'sessions.details, ' . WTC_TP . 'sessions.ip, ' . WTC_TP . 'sessions.userAgent,
	' . WTC_TP . 'sessions.username AS sessUsername, ' . WTC_TP . 'sessions.userid AS sessUserid, ' . WTC_TP . 'userinfo.username,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd
FROM
	' . WTC_TP . 'sessions
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
WHERE
	' . WTC_TP . 'sessions.details = \'?\'
ORDER BY
	' . WTC_TP . 'userinfo.username
';

$query['sessions']['delete_byId'] = 'DELETE FROM ' . WTC_TP . 'sessions WHERE sessionid = \'?\'';

$query['sessions']['delete'] = 'DELETE FROM ' . WTC_TP . 'sessions WHERE lastactive < \'?\'';

$query['sessions']['delete_dupes'] = 'DELETE FROM ' . WTC_TP . 'sessions WHERE userid = \'?\' ORDER BY lastactive ASC LIMIT ?';


// ##### LANGUAGE QUERIES ##### \\
$query['lang']['insert'] = 'INSERT INTO ' . WTC_TP . 'lang (?) VALUES (?)';

$query['lang']['update'] = 'UPDATE ' . WTC_TP . 'lang SET ? WHERE langid = \'?\'';

$query['lang']['get'] = 'SELECT * FROM ' . WTC_TP . 'lang WHERE langid = \'?\'';

$query['lang']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'lang';


// ##### WORD QUERIES ##### \\
$query['lang_words']['insert'] = 'INSERT INTO ' . WTC_TP . 'lang_words (?) VALUES (?)';

$query['lang_words']['update'] = 'UPDATE ' . WTC_TP . 'lang_words SET ? WHERE wordsid = \'?\'';

$query['lang_words']['get'] = 'SELECT * FROM ' . WTC_TP . 'lang_words WHERE wordsid = \'?\'';

$query['lang_words']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'lang_words';


// ##### SUBSCRIPTION QUERIES ##### \\
$query['subscribe']['insert'] = 'INSERT INTO ' . WTC_TP . 'subscribe (?) VALUES (?)';

$query['subscribe']['update'] = 'UPDATE ' . WTC_TP . 'subscribe SET ? WHERE subid = \'?\'';

$query['subscribe']['update_lastEmail'] = 'UPDATE ' . WTC_TP . 'subscribe SET lastEmail = \'?\' WHERE subid IN (?)';

$query['subscribe']['update_lastView'] = 'UPDATE ' . WTC_TP . 'subscribe SET lastView = \'?\' WHERE subid = \'?\'';

$query['subscribe']['get'] = 'SELECT * FROM ' . WTC_TP . 'subscribe WHERE subid = \'?\'';

$query['subscribe']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'subscribe';

$query['subscribe']['get_all_cron'] = '
SELECT
	' . WTC_TP . 'subscribe.*,
	' . WTC_TP . 'threads.last_reply_date AS threadLast,
	' . WTC_TP . 'forums.last_reply_date AS forumLast,
	' . WTC_TP . 'userinfo.email, ' . WTC_TP . 'userinfo.username
FROM
	' . WTC_TP . 'subscribe
LEFT JOIN
	' . WTC_TP . 'forums
	ON
		' . WTC_TP . 'forums.forumid = ' . WTC_TP . 'subscribe.forumid
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'subscribe.threadid
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'subscribe.userid
WHERE
	' . WTC_TP . 'subscribe.lastView >= ' . WTC_TP . 'subscribe.lastEmail
	AND
	(
		(
			' . WTC_TP . 'threads.last_reply_date IS NULL
			AND
			' . WTC_TP . 'forums.last_reply_date >= ' . WTC_TP . 'subscribe.lastView
			AND
			' . WTC_TP . 'forums.last_reply_date >= ' . WTC_TP . 'subscribe.lastEmail
			AND
			' . WTC_TP . 'forums.last_reply_userid != ' . WTC_TP . 'subscribe.userid
		)
		OR
		(
			' . WTC_TP . 'threads.last_reply_date >= ' . WTC_TP . 'subscribe.lastView
			AND
			' . WTC_TP . 'threads.last_reply_date >= ' . WTC_TP . 'subscribe.lastEmail
			AND
			' . WTC_TP . 'threads.last_reply_userid != ' . WTC_TP . 'subscribe.userid
		)
	)
';



// ##### THREAD QUERIES ##### \\
$query['threads']['insert'] = 'INSERT INTO ' . WTC_TP . 'threads (?) VALUES (?)';

$query['threads']['update'] = 'UPDATE ' . WTC_TP . 'threads SET ? WHERE threadid = \'?\'';

$query['threads']['count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'threads';

$query['threads']['update_usernames_starter'] = 'UPDATE ' . WTC_TP . 'threads SET threadUsername = \'?\' WHERE madeby = \'?\'';

$query['threads']['update_usernames_last'] = 'UPDATE ' . WTC_TP . 'threads SET last_reply_username = \'?\' WHERE last_reply_userid = \'?\'';

$query['threads']['delete_redirects'] = 'DELETE FROM ' . WTC_TP . 'threads WHERE moved != 0 AND forumid = \'?\'';

$query['threads']['lastreply'] = 'SELECT threadid, madeby, threadUsername, name, thread_timeline, last_reply_date, last_reply_username, last_reply_userid FROM ' . WTC_TP . 'threads WHERE forumid = \'?\' AND deleted = 0 ORDER BY last_reply_date DESC LIMIT 1';

$query['threads']['count_threads'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'threads WHERE forumid = \'?\'';

$query['threads']['count_threads_user'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'threads WHERE madeby = \'?\' AND forumid NOT IN(?)';

$query['threads']['get'] = '
SELECT
	' . WTC_TP . 'threads.*, ' . WTC_TP . 'read_threads.*, ' . WTC_TP . 'subscribe.subid
FROM
	' . WTC_TP . 'threads
LEFT JOIN
	' . WTC_TP . 'read_threads
	ON
		' . WTC_TP . 'read_threads.readThreadId = ' . WTC_TP . 'threads.threadid
	AND
		' . WTC_TP . 'read_threads.readUserId = \'?\'
LEFT JOIN
	' . WTC_TP . 'subscribe
	ON
		' . WTC_TP . 'subscribe.threadid = ' . WTC_TP . 'threads.threadid
	AND
		' . WTC_TP . 'subscribe.userid = \'?\'
WHERE
	' . WTC_TP . 'threads.threadid = \'?\'
';

$query['threads']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'threads';

$query['threads']['get_newPosts'] = '
SELECT
	' . WTC_TP . 'threads.*, ' . WTC_TP . 'userinfo.userid,
	' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid,
	' . WTC_TP . 'read_threads.*, ' . WTC_TP . 'subscribe.subid, ' . WTC_TP . 'posts.postid
FROM
	' . WTC_TP . 'threads
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'threads.madeby
LEFT JOIN
	' . WTC_TP . 'read_threads
	ON
		' . WTC_TP . 'read_threads.readUserId = \'?\'
	AND
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'read_threads.readThreadId
LEFT JOIN
	' . WTC_TP . 'subscribe
	ON
		' . WTC_TP . 'subscribe.userid = \'?\'
	AND
		' . WTC_TP . 'subscribe.threadid = ' . WTC_TP . 'threads.threadid
LEFT JOIN
	' . WTC_TP . 'posts
	ON
		' . WTC_TP . 'posts.postby = \'?\'
	AND
		' . WTC_TP . 'posts.threadid = ' . WTC_TP . 'threads.threadid
WHERE
	' . WTC_TP . 'threads.last_reply_date >= \'?\'
GROUP BY
	' . WTC_TP . 'threads.threadid
ORDER BY
	' . WTC_TP . 'threads.last_reply_date DESC
LIMIT 50
';

$query['threads']['get_all_forum'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'threads WHERE forumid = \'?\'';

$query['threads']['get_display_forum'] = '
SELECT
	' . WTC_TP . 'threads.*, ' . WTC_TP . 'userinfo.userid,
	' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid,
	' . WTC_TP . 'read_threads.*, ' . WTC_TP . 'subscribe.subid
FROM
	' . WTC_TP . 'threads
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'threads.madeby
LEFT JOIN
	' . WTC_TP . 'read_threads
	ON
		' . WTC_TP . 'read_threads.readUserId = \'?\'
	AND
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'read_threads.readThreadId
LEFT JOIN
	' . WTC_TP . 'subscribe
	ON
		' . WTC_TP . 'subscribe.userid = \'?\'
	AND
		' . WTC_TP . 'subscribe.threadid = ' . WTC_TP . 'threads.threadid
WHERE
	' . WTC_TP . 'threads.forumid = \'?\'
ORDER BY
	' . WTC_TP . 'threads.sticky DESC, ' . WTC_TP . 'threads.?
LIMIT ?, ?
';

$query['threads']['search_all'] = '
SELECT
	COUNT(*) AS total
FROM
	' . WTC_TP . 'threads
LEFT JOIN
	' . WTC_TP . 'posts
	ON
		' . WTC_TP . 'posts.threadid = ' . WTC_TP . 'threads.threadid
WHERE ?
GROUP BY
	' . WTC_TP . 'threads.threadid
LIMIT 500
';

$query['threads']['search'] = '
SELECT
	' . WTC_TP . 'threads.*, ' . WTC_TP . 'userinfo.userid,
	' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid,
	' . WTC_TP . 'posts.postid, ' . WTC_TP . 'posts.message
FROM
	' . WTC_TP . 'threads
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'threads.madeby
LEFT JOIN
	' . WTC_TP . 'posts
	ON
		' . WTC_TP . 'posts.threadid = ' . WTC_TP . 'threads.threadid
WHERE
	?
GROUP BY
	' . WTC_TP . 'threads.threadid
ORDER BY
	' . WTC_TP . 'threads.? ?
LIMIT ?, ?
';


// ##### POST QUERIES ##### \\
$query['posts']['insert'] = 'INSERT INTO ' . WTC_TP . 'posts (?) VALUES (?)';

$query['posts']['update'] = 'UPDATE ' . WTC_TP . 'posts SET ? WHERE postid = \'?\'';

$query['posts']['count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts';

$query['posts']['update_usernames'] = 'UPDATE ' . WTC_TP . 'posts SET postUsername = \'?\' WHERE postby = \'?\'';

$query['posts']['update_thread'] = 'UPDATE ' . WTC_TP . 'posts SET forumid = \'?\' WHERE threadid = \'?\'';

$query['posts']['update_newThread'] = 'UPDATE ' . WTC_TP . 'posts SET threadid = \'?\' WHERE threadid = \'?\'';

$query['posts']['lastreply'] = 'SELECT postid, posts_timeline FROM ' . WTC_TP . 'posts WHERE postby = \'?\' ORDER BY posts_timeline DESC LIMIT 1';

$query['posts']['lastreply_inThread'] = 'SELECT postid, posts_timeline, postUsername, postby FROM ' . WTC_TP . 'posts WHERE threadid = \'?\' AND deleted = 0 ORDER BY posts_timeline DESC LIMIT 1';

$query['posts']['first_postid'] = 'SELECT postid FROM ' . WTC_TP . 'posts WHERE threadid = \'?\' AND deleted = 0 ORDER BY posts_timeline ASC LIMIT 1';

$query['posts']['count_posts'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts WHERE forumid = \'?\'';

$query['posts']['count_posts_user'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts WHERE postby = \'?\' AND forumid NOT IN(?)';

$query['posts']['get'] = 'SELECT * FROM ' . WTC_TP . 'posts WHERE postid = \'?\'';

$query['posts']['get_manyById'] = 'SELECT * FROM ' . WTC_TP . 'posts WHERE postid IN(?)';

$query['posts']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'posts ORDER BY posts_timeline ?';

$query['posts']['get_all_thread'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts WHERE ' . WTC_TP . 'posts.threadid = \'?\' AND ' . WTC_TP . 'posts.deleted != \'?\'';

$query['posts']['get_all_thread_use'] = 'SELECT * FROM ' . WTC_TP . 'posts WHERE threadid = \'?\' ORDER BY posts_timeline, postid ASC';

$query['posts']['get_lastreply'] = 'SELECT postid, postby, postUsername, posts_timeline FROM ' . WTC_TP . 'posts WHERE deleted = 0 AND threadid = \'?\' ORDER BY posts_timeline DESC LIMIT 1';

$query['posts']['get_upto'] = '
SELECT
	postid, deleted
FROM
	' . WTC_TP . 'posts
WHERE
	posts_timeline > \'?\'
	AND
	threadid = \'?\'
ORDER BY
	posts_timeline ASC
';

$query['posts']['nondeleted_count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts WHERE deleted = 0 AND threadid = \'?\'';

$query['posts']['deleted_count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'posts WHERE deleted = 1 AND threadid = \'?\'';

$query['posts']['get_display_small'] = '
SELECT DISTINCT
	' . WTC_TP . 'posts.*,
	' . WTC_TP . 'threads.name, ' . WTC_TP . 'threads.views, ' . WTC_TP . 'threads.threadid,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.joined, ' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.homepage,
	' . WTC_TP . 'userinfo_pro.*
FROM
	' . WTC_TP . 'posts
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'posts.threadid
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'posts.postby = ' . WTC_TP . 'userinfo.userid
LEFT JOIN
	' . WTC_TP . 'userinfo_pro
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_pro.user_id
WHERE
	' . WTC_TP . 'threads.threadid = \'?\' AND ' . WTC_TP . 'posts.deleted != \'?\'
ORDER BY
	' . WTC_TP . 'posts.posts_timeline ASC
';

$query['posts']['get_display_thread'] = '
SELECT DISTINCT
	' . WTC_TP . 'posts.*,
	' . WTC_TP . 'threads.name, ' . WTC_TP . 'threads.views, ' . WTC_TP . 'threads.threadid,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.joined, ' . WTC_TP . 'userinfo.homepage,
	' . WTC_TP . 'userinfo.usertitle, ' . WTC_TP . 'userinfo.usertitle_opt, ' . WTC_TP . 'userinfo.sig,
	' . WTC_TP . 'userinfo.avatar, ' . WTC_TP . 'sessions.userid AS isOnline,
	' . WTC_TP . 'userinfo.reputation,
	' . WTC_TP . 'userinfo_pro.*
FROM
	' . WTC_TP . 'posts
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'posts.threadid
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'posts.postby = ' . WTC_TP . 'userinfo.userid
LEFT JOIN
	' . WTC_TP . 'userinfo_pro
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_pro.user_id
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
LEFT JOIN
	' . WTC_TP . 'read_threads
	ON
		' . WTC_TP . 'read_threads.readUserId = \'?\'
	AND
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'read_threads.readThreadId
WHERE
	' . WTC_TP . 'threads.threadid = \'?\' AND ' . WTC_TP . 'posts.deleted != \'?\'
ORDER BY
	' . WTC_TP . 'posts.? ?
LIMIT ?, ?
';

$query['posts']['search_all'] = '
SELECT
	COUNT(*) AS total
FROM
	' . WTC_TP . 'posts
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'posts.threadid = ' . WTC_TP . 'threads.threadid
WHERE ?
GROUP BY
	' . WTC_TP . 'posts.postid
LIMIT 500
';

$query['posts']['search'] = '
SELECT
	' . WTC_TP . 'threads.*, ' . WTC_TP . 'userinfo.userid,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.joined, ' . WTC_TP . 'userinfo.homepage,
	' . WTC_TP . 'posts.*, ' . WTC_TP . 'sessions.userid AS isOnline,
	' . WTC_TP . 'userinfo_pro.*
FROM
	' . WTC_TP . 'posts
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'posts.postby
LEFT JOIN
	' . WTC_TP . 'userinfo_pro
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_pro.user_id
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'posts.threadid = ' . WTC_TP . 'threads.threadid
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
WHERE
	?
GROUP BY
	' . WTC_TP . 'posts.postid
ORDER BY
	' . WTC_TP . 'posts.? ?
LIMIT ?, ?
';


// ##### FORUM QUERIES ##### \\
$query['forum']['insert'] = 'INSERT INTO ' . WTC_TP . 'forums (?) VALUES (?)';

$query['forum']['update'] = 'UPDATE ' . WTC_TP . 'forums SET ? WHERE forumid = \'?\'';

$query['forum']['update_usernames'] = 'UPDATE ' . WTC_TP . 'forums SET last_reply_username = \'?\' WHERE last_reply_userid = \'?\'';

$query['forum']['get'] = '
SELECT
	' . WTC_TP . 'forums.*, ' . WTC_TP . 'read_forums.*, ' . WTC_TP . 'subscribe.subid
FROM
	' . WTC_TP . 'forums
LEFT JOIN
	' . WTC_TP . 'read_forums
	ON
		' . WTC_TP . 'read_forums.readForumId = ' . WTC_TP . 'forums.forumid
	AND
		' . WTC_TP . 'read_forums.readUserId = \'?\'
LEFT JOIN
	' . WTC_TP . 'subscribe
	ON
		' . WTC_TP . 'subscribe.forumid = ' . WTC_TP . 'forums.forumid
	AND
		' . WTC_TP . 'subscribe.userid = \'?\'
	AND
		' . WTC_TP . 'subscribe.threadid IS NULL
WHERE
	' . WTC_TP . 'forums.forumid = \'?\'
';

$query['forum']['get_all'] = '
SELECT
	' . WTC_TP . 'forums.*, ' . WTC_TP . 'read_forums.*, ' . WTC_TP . 'subscribe.subid
FROM
	' . WTC_TP . 'forums
LEFT JOIN
	' . WTC_TP . 'read_forums
	ON
		' . WTC_TP . 'read_forums.readForumId = ' . WTC_TP . 'forums.forumid
	AND
		' . WTC_TP . 'read_forums.readUserId = \'?\'
LEFT JOIN
	' . WTC_TP . 'subscribe
	ON
		' . WTC_TP . 'subscribe.forumid = ' . WTC_TP . 'forums.forumid
	AND
		' . WTC_TP . 'subscribe.userid = \'?\'
	AND
		' . WTC_TP . 'subscribe.threadid IS NULL
ORDER BY
	' . WTC_TP . 'forums.disOrder
';


// ##### FORUM PERM QUERIES ##### \\
$query['perm']['insert'] = 'INSERT INTO ' . WTC_TP . 'forumperms (?) VALUES (?)';

$query['perm']['update'] = 'UPDATE ' . WTC_TP . 'forumperms SET ? WHERE permid = \'?\'';

$query['perm']['get'] = 'SELECT * FROM ' . WTC_TP . 'forumperms WHERE permid = \'?\'';

$query['perm']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'forumperms';


// ##### READ FORUM QUERIES ##### \\
$query['read_forums']['insert'] = 'REPLACE DELAYED INTO ' . WTC_TP . 'read_forums (readUserId, readForumId, dateRead) VALUES (\'?\', \'?\', \'?\')';

$query['read_forums']['update_markRead'] = 'UPDATE ' . WTC_TP . 'read_forums SET dateRead = \'?\' WHERE readUserId = \'?\'';

$query['read_forums']['update_markRead_forum'] = 'UPDATE ' . WTC_TP . 'read_forums SET dateRead = \'?\' WHERE readUserId = \'?\' AND readForumId = \'?\'';

$query['read_forums']['delete'] = 'DELETE FROM ' . WTC_TP . 'read_forums WHERE readUserId = \'?\'';

$query['read_forums']['delete_time'] = 'DELETE FROM ' . WTC_TP . 'read_forums WHERE dateRead < \'?\'';


// ##### READ THREAD QUERIES ##### \\
$query['read_threads']['insert'] = 'REPLACE DELAYED INTO ' . WTC_TP . 'read_threads (readUserId, readThreadId, dateRead) VALUES (\'?\', \'?\', \'?\')';

$query['read_threads']['update_markRead'] = 'UPDATE ' . WTC_TP . 'read_threads SET dateRead = \'?\' WHERE readUserId = \'?\'';

$query['read_threads']['update_markRead_forum'] = '
UPDATE
	' . WTC_TP . 'read_threads
LEFT JOIN
	' . WTC_TP . 'threads
	ON
		' . WTC_TP . 'threads.threadid = ' . WTC_TP . 'read_threads.readThreadId
SET
	' . WTC_TP . 'read_threads.dateRead = \'?\'
WHERE
	'. WTC_TP . 'read_threads.readUserId = \'?\'
	AND
	' . WTC_TP . 'threads.forumid = \'?\'
';

$query['read_threads']['delete'] = 'DELETE FROM ' . WTC_TP . 'read_threads WHERE readUserId = \'?\'';

$query['read_threads']['delete_time'] = 'DELETE FROM ' . WTC_TP . 'read_threads WHERE dateRead < \'?\'';


// ##### ANNOUNCEMENT QUERIES ##### \\
$query['announce']['insert'] = 'INSERT INTO ' . WTC_TP . 'announcements (?) VALUES (?)';

$query['announce']['update'] = 'UPDATE ' . WTC_TP . 'announcements SET ? WHERE announceid = \'?\'';

$query['announce']['get'] = 'SELECT * FROM ' . WTC_TP . 'announcements WHERE announceid = \'?\'';

$query['announce']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'announcements';

$query['announce']['get_forum'] = '
SELECT
	' . WTC_TP . 'announcements.*,
	' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin, ' . WTC_TP . 'userinfo.joined,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.homepage, ' . WTC_TP . 'userinfo.avatar,
	' . WTC_TP . 'sessions.userid AS isOnline
FROM
	' . WTC_TP . 'announcements
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'announcements.userid
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
WHERE
	forumid IN (?) OR forumid = \'-1\'
ORDER BY
	' . WTC_TP . 'announcements.dateUpdated DESC
';


// ##### POLL QUERIES ##### \\
$query['polls']['insert'] = 'INSERT INTO ' . WTC_TP . 'polls (?) VALUES (?)';

$query['polls']['update'] = 'UPDATE ' . WTC_TP . 'polls SET ? WHERE pollid = \'?\'';

$query['polls']['get'] = 'SELECT * FROM ' . WTC_TP . 'polls WHERE pollid = \'?\'';

$query['polls']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'polls';


// ##### ATTACHMENT EXTENSION QUERIES ##### \\
$query['ext']['insert'] = 'INSERT INTO ' . WTC_TP . 'attach_store (?) VALUES (?)';

$query['ext']['update'] = 'UPDATE ' . WTC_TP . 'attach_store SET ? WHERE storeid = \'?\'';

$query['ext']['get'] = 'SELECT * FROM ' . WTC_TP . 'attach_store WHERE storeid = \'?\'';

$query['ext']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'attach_store';

$query['ext']['check_unique'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'attach_store WHERE ext = \'?\'';

$query['ext']['check_unique_edit'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'attach_store WHERE ext = \'?\' AND storeid != \'?\'';


// ##### ATTACHMENT QUERIES ##### \\
$query['attachments']['insert'] = 'INSERT INTO ' . WTC_TP . 'attachments (?) VALUES (?)';

$query['attachments']['update'] = 'UPDATE ' . WTC_TP . 'attachments SET ? WHERE attachid = \'?\'';

$query['attachments']['update_hash'] = 'UPDATE ' . WTC_TP . 'attachments SET threadid = \'?\' , postid = \'?\' , hash = NULL WHERE hash = \'?\'';

$query['attachments']['update_hash_convo'] = 'UPDATE ' . WTC_TP . 'attachments SET convoid = \'?\' , messageid = \'?\' , hash = NULL WHERE hash = \'?\'';

$query['attachments']['get'] = 'SELECT * FROM ' . WTC_TP . 'attachments WHERE attachid = \'?\'';

$query['attachments']['get_convoid'] = 'SELECT attachid, fileName, messageid, downloads, thumbFileName FROM ' . WTC_TP . 'attachments WHERE convoid = \'?\' ORDER BY fileName';

$query['attachments']['get_messageid'] = 'SELECT * FROM ' . WTC_TP . 'attachments WHERE messageid = \'?\' ORDER BY fileName';

$query['attachments']['get_threadid'] = 'SELECT attachid, fileName, postid, downloads, thumbFileName FROM ' . WTC_TP . 'attachments WHERE threadid = \'?\' ORDER BY fileName';

$query['attachments']['get_forumid'] = 'SELECT threadid FROM ' . WTC_TP . 'attachments WHERE forumid = \'?\'';

$query['attachments']['get_postid'] = 'SELECT * FROM ' . WTC_TP . 'attachments WHERE postid = \'?\' ORDER BY fileName';

$query['attachments']['get_hash'] = 'SELECT * FROM ' . WTC_TP . 'attachments WHERE hash = \'?\' ORDER BY fileName';

$query['attachments']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'attachments';


// ##### CUSTOM PROFILE FIELD QUERIES ##### \\
$query['custom_pro']['insert'] = 'INSERT INTO ' . WTC_TP . 'custom_pro (?) VALUES (?)';

$query['custom_pro']['update'] = 'UPDATE ' . WTC_TP . 'custom_pro SET ? WHERE proid = \'?\'';

$query['custom_pro']['get'] = 'SELECT * FROM ' . WTC_TP . 'custom_pro WHERE proid = \'?\'';

$query['custom_pro']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'custom_pro ORDER BY disOrder, fieldName ASC';

$query['custom_pro']['get_all_groups'] = 'SELECT * FROM ' . WTC_TP . 'groups WHERE groupType = \'custom_pro\' ORDER BY groupName';

$query['custom_pro']['alter_add'] = 'ALTER TABLE ' . WTC_TP . 'userinfo_pro ADD ? TEXT';

$query['custom_pro']['alter_drop'] = 'ALTER TABLE ' . WTC_TP . 'userinfo_pro DROP ?';


// ##### FAQ QUERIES ##### \\
$query['faq']['insert'] = 'INSERT INTO ' . WTC_TP . 'faq (?) VALUES (?)';

$query['faq']['update'] = 'UPDATE ' . WTC_TP . 'faq SET ? WHERE faqid = \'?\'';

$query['faq']['get'] = 'SELECT * FROM ' . WTC_TP . 'faq WHERE faqid = \'?\'';

$query['faq']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'faq';

$query['faq']['get_words'] = 'SELECT * FROM lang_words WHERE catid = \'?\'';

$query['faq']['check_varname'] = 'SELECT COUNT(*) AS checking FROM lang_words WHERE (name LIKE \'?%\' OR name LIKE \'?%\') AND name != \'?\' AND name != \'?\'';


// ##### RANK QUERIES ##### \\
$query['rank']['insert'] = 'INSERT INTO ' . WTC_TP . 'ranks (?) VALUES (?)';

$query['rank']['update'] = 'UPDATE ' . WTC_TP . 'ranks SET ? WHERE rankid = \'?\'';

$query['rank']['get'] = 'SELECT * FROM ' . WTC_TP . 'ranks WHERE rankid = \'?\'';

$query['rank']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'ranks ORDER BY minPosts';


// ##### RANK IMAGES QUERIES ##### \\
$query['rankImage']['insert'] = 'INSERT INTO ' . WTC_TP . 'ranks_images (?) VALUES (?)';

$query['rankImage']['update'] = 'UPDATE ' . WTC_TP . 'ranks_images SET ? WHERE rankiid = \'?\'';

$query['rankImage']['get'] = 'SELECT * FROM ' . WTC_TP . 'ranks_images WHERE rankiid = \'?\'';

$query['rankImage']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'ranks_images ORDER BY minPosts';


// ##### AVATARS QUERIES ##### \\
$query['avatar']['insert'] = 'INSERT INTO ' . WTC_TP . 'avatar (?) VALUES (?)';

$query['avatar']['update'] = 'UPDATE ' . WTC_TP . 'avatar SET ? WHERE avatarid = \'?\'';

$query['avatar']['get'] = 'SELECT * FROM ' . WTC_TP . 'avatar LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'avatar.groupid WHERE ' . WTC_TP . 'avatar.avatarid = \'?\'';

$query['avatar']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'avatar LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'avatar.groupid ORDER BY ' . WTC_TP . 'avatar.disOrder';

$query['avatar']['get_all_inGroup'] = 'SELECT * FROM ' . WTC_TP . 'avatar LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'avatar.groupid WHERE ' . WTC_TP . 'avatar.groupid = \'?\'';

$query['avatar']['get_all_groups'] = 'SELECT * FROM ' . WTC_TP . 'groups WHERE groupType = \'avatar\' ORDER BY groupName';


// ##### SMILIES QUERIES ##### \\
$query['smilies']['insert'] = 'INSERT INTO ' . WTC_TP . 'smilies (?) VALUES (?)';

$query['smilies']['update'] = 'UPDATE ' . WTC_TP . 'smilies SET ? WHERE smileyid = \'?\'';

$query['smilies']['get'] = 'SELECT * FROM ' . WTC_TP . 'smilies LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'smilies.groupid WHERE ' . WTC_TP . 'smilies.smileyid = \'?\'';

$query['smilies']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'smilies LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'smilies.groupid ORDER BY ' . WTC_TP . 'smilies.disOrder';

$query['smilies']['get_all_inGroup'] = 'SELECT * FROM ' . WTC_TP . 'smilies LEFT JOIN ' . WTC_TP . 'groups ON ' . WTC_TP . 'groups.groupid = ' . WTC_TP . 'smilies.groupid WHERE ' . WTC_TP . 'smilies.groupid = \'?\'';

$query['smilies']['get_all_groups'] = 'SELECT * FROM ' . WTC_TP . 'groups WHERE groupType = \'smilies\' ORDER BY groupName';


// ##### POST ICONS QUERIES ##### \\
$query['posticons']['insert'] = 'INSERT INTO ' . WTC_TP . 'posticons (?) VALUES (?)';

$query['posticons']['update'] = 'UPDATE ' . WTC_TP . 'posticons SET ? WHERE iconid = \'?\'';

$query['posticons']['get'] = 'SELECT * FROM ' . WTC_TP . 'posticons WHERE iconid = \'?\'';

$query['posticons']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'posticons ORDER BY disOrder ASC';


// ##### BB CODES QUERIES ##### \\
$query['bbcode']['insert'] = 'INSERT INTO ' . WTC_TP . 'bbcode (?) VALUES (?)';

$query['bbcode']['update'] = 'UPDATE ' . WTC_TP . 'bbcode SET ? WHERE bbcodeid = \'?\'';

$query['bbcode']['get'] = 'SELECT bbcodeid, name, tag, replacement, example, description, display FROM ' . WTC_TP . 'bbcode WHERE bbcodeid = \'?\'';

$query['bbcode']['get_all'] = 'SELECT bbcodeid, name, tag, replacement, example, description, display FROM ' . WTC_TP . 'bbcode ORDER BY disOrder, name';

$query['bbcode']['get_all_realOrder'] = 'SELECT bbcodeid, name, tag, replacement, example, description, display FROM ' . WTC_TP . 'bbcode ORDER BY name';


// ##### GROUPS QUERIES ##### \\
$query['groups']['insert'] = 'INSERT INTO ' . WTC_TP . 'groups (?) VALUES (?)';

$query['groups']['update'] = 'UPDATE ' . WTC_TP . 'groups SET ? WHERE groupid = \'?\'';

$query['groups']['get'] = 'SELECT * FROM ' . WTC_TP . 'groups WHERE groupid = \'?\'';

$query['groups']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'groups ORDER BY groupOrder, groupType, groupName ASC';


// ##### MODERATOR QUERIES ##### \\
$query['moderator']['insert'] = 'INSERT INTO ' . WTC_TP . 'moderators (?) VALUES (?)';

$query['moderator']['update'] = 'UPDATE ' . WTC_TP . 'moderators SET ? WHERE modid = \'?\'';

$query['moderator']['get'] = 'SELECT * FROM ' . WTC_TP . 'moderators LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'moderators.userid WHERE ' . WTC_TP . 'moderators.modid = \'?\'';

$query['moderator']['get_all'] = 'SELECT ' . WTC_TP . 'moderators.*, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids, ' . WTC_TP . 'userinfo.htmlBegin, ' . WTC_TP . 'userinfo.htmlEnd FROM ' . WTC_TP . 'moderators LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'moderators.userid';


// ##### LOG QUERIES ##### \\
$query['log_admin']['get_usernames'] = 'SELECT * FROM ' . WTC_TP . 'logger_admin GROUP BY log_username ORDER BY log_username';

$query['log_admin']['get_scripts'] = 'SELECT * FROM ' . WTC_TP . 'logger_admin GROUP BY log_fileAction ORDER BY log_fileAction';

$query['log_admin']['insert'] = 'INSERT INTO ' . WTC_TP . 'logger_admin (log_userid, log_username, log_date, log_ip, log_filePath, log_fileAction) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['log_admin']['update_usernames'] = 'UPDATE ' . WTC_TP . 'logger_admin SET log_username = \'?\' WHERE log_userid = \'?\'';

$query['log_admin']['search'] = 'SELECT * FROM ' . WTC_TP . 'logger_admin WHERE log_userid LIKE \'?\' AND log_fileAction LIKE \'?\' ORDER BY ?';

$query['log_admin']['delete'] = 'DELETE FROM ' . WTC_TP . 'logger_admin WHERE log_userid LIKE \'?\' AND log_fileAction LIKE \'?\' AND log_date < \'?\'';

$query['log_mod']['get_usernames'] = 'SELECT * FROM ' . WTC_TP . 'logger_mods GROUP BY log_username ORDER BY log_username';

$query['log_mod']['get_actions'] = 'SELECT * FROM ' . WTC_TP . 'logger_mods GROUP BY log_modAction ORDER BY log_modAction';

$query['log_mod']['insert'] = '';

$query['log_mod']['update_usernames'] = 'UPDATE ' . WTC_TP . 'logger_mods SET log_username = \'?\' WHERE log_userid = \'?\'';

$query['log_mod']['search'] = 'SELECT * FROM ' . WTC_TP . 'logger_mods WHERE log_userid LIKE \'?\' AND log_modAction LIKE \'?\' ORDER BY ?';

$query['log_mod']['delete'] = 'DELETE FROM ' . WTC_TP . 'logger_mods WHERE log_userid LIKE \'?\' AND log_modAction LIKE \'?\' AND log_date < \'?\'';

$query['log_cron']['get_scripts'] = 'SELECT * FROM ' . WTC_TP . 'logger_cron GROUP BY log_file ORDER BY log_file';

$query['log_cron']['insert'] = 'INSERT INTO ' . WTC_TP . 'logger_cron (log_crontitle, log_nextRun, log_date, log_results, log_file) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\')';

$query['log_cron']['search'] = 'SELECT * FROM ' . WTC_TP . 'logger_cron WHERE log_file LIKE \'?\' ORDER BY ?';

$query['log_cron']['delete'] = 'DELETE FROM ' . WTC_TP . 'logger_cron WHERE log_file LIKE \'?\' AND log_date < \'?\'';


// ##### USERGROUP QUERIES ##### \\
$query['usergroups']['insert'] = 'INSERT INTO ' . WTC_TP . 'usergroups (?) VALUES (?)';

$query['usergroups']['update'] = 'UPDATE ' . WTC_TP . 'usergroups SET ? WHERE usergroupid = \'?\'';

$query['usergroups']['get_groups'] = 'SELECT * FROM ' . WTC_TP . 'usergroups';

$query['usergroups']['get_default_groups'] = 'SELECT ' . WTC_TP . 'usergroups.*, COUNT(' . WTC_TP . 'userinfo.userid) AS primUsers FROM ' . WTC_TP . 'usergroups LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.usergroupid = ' . WTC_TP . 'usergroups.usergroupid WHERE ' . WTC_TP . 'usergroups.usergroupid <= 8 GROUP BY ' . WTC_TP . 'usergroups.usergroupid';

$query['usergroups']['get_custom_groups'] = 'SELECT ' . WTC_TP . 'usergroups.*, COUNT(' . WTC_TP . 'userinfo.userid) AS primUsers FROM ' . WTC_TP . 'usergroups LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.usergroupid = ' . WTC_TP . 'usergroups.usergroupid WHERE ' . WTC_TP . 'usergroups.usergroupid > 8 GROUP BY ' . WTC_TP . 'usergroups.usergroupid';

$query['usergroups']['get_banned_groups'] = 'SELECT usergroupid, title FROM ' . WTC_TP . 'usergroups WHERE isBanned = 1';

$query['usergroups']['get_total_secUsers'] = 'SELECT secgroupids FROM ' . WTC_TP . 'userinfo WHERE secgroupids != \'\'';

$query['usergroups']['get_allUsers'] = 'SELECT * FROM ' . WTC_TP . 'userinfo WHERE usergroupid = \'?\' OR LOCATE(\'\"?\"\', secgroupids) > 0';

$query['usergroups']['get_secUsers'] = 'SELECT * FROM ' . WTC_TP . 'userinfo WHERE LOCATE(\'\"?\"\', secgroupids) > 0';

$query['usergroups']['check_unique_title'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'usergroups WHERE title = \'?\'';

$query['usergroups']['check_unique_title_edit'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'usergroups WHERE title = \'?\' AND usergroupid != \'?\'';

$query['usergroups']['moveUsersToNewGroup'] = 'UPDATE ' . WTC_TP . 'userinfo SET usergroupid = \'?\' WHERE usergroupid = \'?\'';

$query['usergroups']['get_affectedAuto'] = 'SELECT * FROM ' . WTC_TP . 'usergroups_auto LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'userinfo.usergroupid = ' . WTC_TP . 'usergroups_auto.affectedId';


// ##### CONVERSATION QUERIES ##### \\
$query['personal_convo']['insert'] = 'INSERT INTO ' . WTC_TP . 'personal_convo (?) VALUES (?)';

$query['personal_convo']['update'] = 'UPDATE ' . WTC_TP . 'personal_convo SET ? WHERE convoid = \'?\'';

$query['personal_convo']['get'] = 'SELECT * FROM ' . WTC_TP . 'personal_convo WHERE convoid = \'?\'';

$query['personal_convo']['get_new'] = '
SELECT
	' . WTC_TP . 'personal_convodata.hasAlert
FROM
	' . WTC_TP . 'personal_convo
LEFT JOIN
	' . WTC_TP . 'personal_convodata
	ON
		' . WTC_TP . 'personal_convo.convoid = ' . WTC_TP . 'personal_convodata.convoid
WHERE
		' . WTC_TP . 'personal_convodata.userid = \'?\'
	AND
		' . WTC_TP . 'personal_convodata.lastRead < last_reply_date
';

$query['personal_convo']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'personal_convo';

$query['personal_convo']['get_count_folder'] = '
SELECT
	COUNT(*) AS total
FROM
	' . WTC_TP . 'personal_convo
LEFT JOIN
	' . WTC_TP . 'personal_convodata
	ON
		' . WTC_TP . 'personal_convo.convoid = ' . WTC_TP . 'personal_convodata.convoid
WHERE
		' . WTC_TP . 'personal_convodata.userid = \'?\'
	AND
		' . WTC_TP . 'personal_convodata.folderid = \'?\'
';

$query['personal_convo']['get_all_folder'] = '
SELECT
	' . WTC_TP . 'personal_convo.*
FROM
	' . WTC_TP . 'personal_convo
LEFT JOIN
	' . WTC_TP . 'personal_convodata
	ON
		' . WTC_TP . 'personal_convo.convoid = ' . WTC_TP . 'personal_convodata.convoid
WHERE
		' . WTC_TP . 'personal_convodata.userid = \'?\'
	AND
		' . WTC_TP . 'personal_convodata.folderid = \'?\'
';

$query['personal_convo']['get_display_folder'] = '
SELECT
	' . WTC_TP . 'personal_convo.*
FROM
	' . WTC_TP . 'personal_convo
LEFT JOIN
	' . WTC_TP . 'personal_convodata
	ON
		' . WTC_TP . 'personal_convo.convoid = ' . WTC_TP . 'personal_convodata.convoid
WHERE
		' . WTC_TP . 'personal_convodata.userid = \'?\'
	AND
		' . WTC_TP . 'personal_convodata.folderid = \'?\'
ORDER BY
	' . WTC_TP . 'personal_convo.?
LIMIT ?, ?
';


// ##### CONVERSATION DATA QUERIES ##### \\
$query['personal_convodata']['insert'] = 'INSERT INTO ' . WTC_TP . 'personal_convodata (convoid, userid, folderid, lastRead, hasAlert, username) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['personal_convodata']['update'] = 'UPDATE ' . WTC_TP . 'personal_convodata SET folderid = \'?\' , lastRead = \'?\' , hasAlert = \'?\' , username = \'?\' WHERE userid = \'?\' AND convoid = \'?\'';

$query['personal_convodata']['update_alert'] = 'UPDATE ' . WTC_TP . 'personal_convodata SET hasAlert = 1 WHERE userid = \'?\'';

$query['personal_convodata']['delete'] = 'DELETE FROM ' . WTC_TP . 'personal_convodata WHERE convoid = \'?\' AND userid = \'?\'';

$query['personal_convodata']['get_convo'] = 'SELECT folderid, lastRead, userid, username, hasAlert FROM ' . WTC_TP . 'personal_convodata WHERE convoid = \'?\'';

$query['personal_convodata']['get_convoUser'] = 'SELECT folderid, lastRead, userid, username, hasAlert FROM ' . WTC_TP . 'personal_convodata WHERE convoid = \'?\' AND userid = \'?\'';


// ##### PERSONAL MESSAGE QUERIES ##### \\
$query['personal_msg']['insert'] = 'INSERT INTO ' . WTC_TP . 'personal_msg (?) VALUES (?)';

$query['personal_msg']['update'] = 'UPDATE ' . WTC_TP . 'personal_msg SET ? WHERE messageid = \'?\'';

$query['personal_msg']['get'] = '
SELECT
	' . WTC_TP . 'personal_msg.*, ' . WTC_TP . 'userinfo.username
FROM
	' . WTC_TP . 'personal_msg
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'personal_msg.userid
WHERE messageid = \'?\'
';

$query['personal_msg']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'personal_msg';

$query['personal_msg']['get_all_convo'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'personal_msg WHERE ' . WTC_TP . 'personal_msg.convoid = \'?\'';

$query['personal_msg']['get_display_convo'] = '
SELECT DISTINCT
	' . WTC_TP . 'personal_msg.*,
	' . WTC_TP . 'personal_convo.title, ' . WTC_TP . 'personal_convo.convoid,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.joined, ' . WTC_TP . 'userinfo.homepage,
	' . WTC_TP . 'userinfo.usertitle, ' . WTC_TP . 'userinfo.usertitle_opt, ' . WTC_TP . 'userinfo.sig,
	' . WTC_TP . 'userinfo.avatar, ' . WTC_TP . 'sessions.userid AS isOnline
FROM
	' . WTC_TP . 'personal_msg
LEFT JOIN
	' . WTC_TP . 'personal_convo
	ON
		' . WTC_TP . 'personal_convo.convoid = ' . WTC_TP . 'personal_msg.convoid
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'personal_msg.userid = ' . WTC_TP . 'userinfo.userid
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'personal_msg.userid
WHERE
	' . WTC_TP . 'personal_convo.convoid = \'?\'
ORDER BY
	' . WTC_TP . 'personal_msg.? ?
LIMIT ?, ?
';


// ##### FOLDER QUERIES ##### \\
$query['personal_folders']['insert'] = 'INSERT INTO ' . WTC_TP . 'personal_folders (?) VALUES (?)';

$query['personal_folders']['update'] = 'UPDATE ' . WTC_TP . 'personal_folders SET ? WHERE folderid = \'?\'';

$query['personal_folders']['get'] = 'SELECT * FROM ' . WTC_TP . 'personal_folders WHERE folderid = \'?\'';

$query['personal_folders']['get_all'] = '
SELECT
	*
FROM
	' . WTC_TP . 'personal_folders
WHERE
	userid = 0 OR userid = \'?\'
ORDER BY name
';

// ##### REPUTATIONS QUERIES ##### \\
$query['reputations']['insert'] = 'INSERT INTO ' . WTC_TP . 'reputations (?) VALUES (?)';

$query['reputations']['update'] = 'UPDATE ' . WTC_TP . 'reputations SET ? WHERE repid = \'?\'';

$query['reputations']['count'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'reputations';

$query['reputations']['get'] = 'SELECT * FROM ' . WTC_TP . 'reputations WHERE repid = \'?\'';

$query['reputations']['get_all_member'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'reputations WHERE ' . WTC_TP . 'reputations.userid = \'?\' AND ' . WTC_TP . 'reputations.deleted != \'?\'';

$query['reputations']['get_manyById'] = 'SELECT * FROM ' . WTC_TP . 'reputations WHERE repid IN(?)';

$query['reputations']['get_display_reputation'] = '
SELECT DISTINCT
	' . WTC_TP . 'reputations.*,
	' . WTC_TP . 'userinfo.userid, ' . WTC_TP . 'userinfo.username, ' . WTC_TP . 'userinfo.htmlBegin,
	' . WTC_TP . 'userinfo.htmlEnd, ' . WTC_TP . 'userinfo.usergroupid, ' . WTC_TP . 'userinfo.secgroupids,
	' . WTC_TP . 'userinfo.posts, ' . WTC_TP . 'userinfo.joined, ' . WTC_TP . 'userinfo.homepage,
	' . WTC_TP . 'userinfo.usertitle, ' . WTC_TP . 'userinfo.usertitle_opt, ' . WTC_TP . 'userinfo.sig,
	' . WTC_TP . 'userinfo.avatar, ' . WTC_TP . 'sessions.userid AS isOnline,
	' . WTC_TP . 'userinfo.reputation,
	' . WTC_TP . 'userinfo_pro.*
FROM
	' . WTC_TP . 'reputations
LEFT JOIN
	' . WTC_TP . 'userinfo
	ON
		' . WTC_TP . 'reputations.repby = ' . WTC_TP . 'userinfo.userid
LEFT JOIN
	' . WTC_TP . 'userinfo_pro
	ON
		' . WTC_TP . 'userinfo.userid = ' . WTC_TP . 'userinfo_pro.user_id
LEFT JOIN
	' . WTC_TP . 'sessions
	ON
		' . WTC_TP . 'sessions.userid = ' . WTC_TP . 'userinfo.userid
WHERE
	' . WTC_TP . 'reputations.userid = \'?\' AND ' . WTC_TP . 'reputations.deleted != \'?\'
ORDER BY
	' . WTC_TP . 'reputations.? ?
LIMIT ?, ?
';

// ##### CRON QUERIES ##### \\
$query['cron']['insert'] = 'INSERT INTO ' . WTC_TP . 'cron (?) VALUES (?)';

$query['cron']['update'] = 'UPDATE ' . WTC_TP . 'cron SET ? WHERE cronid = \'?\'';

$query['cron']['get'] = 'SELECT * FROM ' . WTC_TP . 'cron WHERE cronid = \'?\'';

$query['cron']['get_all'] = 'SELECT * FROM ' . WTC_TP . 'cron';

$query['cron']['check_unique'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'cron WHERE title = \'?\'';

$query['cron']['check_unique_edit'] = 'SELECT COUNT(*) AS checking FROM ' . WTC_TP . 'cron WHERE title = \'?\' AND cronid != \'?\'';


// ##### ADMIN QUERIES ##### \\
$query['admin']['get_automations'] = 'SELECT * FROM ' . WTC_TP . 'usergroups_auto';

$query['admin']['get_auto'] = 'SELECT * FROM ' . WTC_TP . 'usergroups_auto WHERE autoid = \'?\'';

$query['admin']['insert_automation'] = 'INSERT INTO ' . WTC_TP . 'usergroups_auto (affectedId, moveTo, daysReg, daysRegComp, postsa, postsComp, type, secondary) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['admin']['update_automation'] = 'UPDATE ' . WTC_TP . 'usergroups_auto SET affectedId = \'?\' , moveTo = \'?\' , daysReg = \'?\' , daysRegComp = \'?\' , postsa = \'?\' , postsComp = \'?\' , type = \'?\' , secondary = \'?\' WHERE autoid = \'?\'';

$query['admin']['get_user_byId_admin'] = 'SELECT * , ' . WTC_TP . 'userinfo.userid AS userUserid FROM ' . WTC_TP . 'userinfo LEFT JOIN ' . WTC_TP . 'admins ON ' . WTC_TP . 'admins.userid = ' . WTC_TP . 'userinfo.userid WHERE ' . WTC_TP . 'userinfo.userid = \'?\'';

$query['admin']['get_user_byId_admin_req'] = 'SELECT ' . WTC_TP . 'admins.*, ' . WTC_TP . 'userinfo.userid AS userUserid, ' . WTC_TP . 'userinfo.*, COUNT(' . WTC_TP . 'logger_ips.log_ipid) AS loggedIps FROM ' . WTC_TP . 'userinfo LEFT JOIN ' . WTC_TP . 'logger_ips ON ' . WTC_TP . 'logger_ips.userid = ' . WTC_TP . 'userinfo.userid AND ' . WTC_TP . 'logger_ips.ip_address = \'' . $_SERVER['REMOTE_ADDR'] . '\' LEFT JOIN ' . WTC_TP . 'admins ON ' . WTC_TP . 'admins.userid = ' . WTC_TP . 'userinfo.userid WHERE ' . WTC_TP . 'userinfo.userid = \'?\' GROUP BY ' . WTC_TP . 'userinfo.username';

$query['admin']['get_user_byUsername_admin'] = 'SELECT * , ' . WTC_TP . 'userinfo.userid AS userUserid FROM ' . WTC_TP . 'userinfo LEFT JOIN ' . WTC_TP . 'admins ON ' . WTC_TP . 'admins.userid = ' . WTC_TP . 'userinfo.userid WHERE ' . WTC_TP . 'userinfo.username = \'?\'';

$query['admin']['get_admins'] = 'SELECT * FROM ' . WTC_TP . 'admins';

$query['admin']['get_admin'] = 'SELECT * FROM ' . WTC_TP . 'admins WHERE userid = \'?\'';

$query['admin']['get_admins_users'] = 'SELECT * FROM ' . WTC_TP . 'admins LEFT JOIN ' . WTC_TP . 'userinfo ON ' . WTC_TP . 'admins.userid = ' . WTC_TP . 'userinfo.userid';

$query['admin']['insert_admin'] = 'INSERT INTO ' . WTC_TP . 'admins (userid, options, language, users, usergroups, cron, forums, announcements, logAdmin, logMod, logCron, pruneLogs, ranks, attachments, faq, ranks_images, smilies, posticons, avatars, maintenance, styles, bbcode, threads_posts, cus_pro) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['admin']['update_admin'] = 'UPDATE ' . WTC_TP . 'admins SET ? WHERE userid = \'?\'';

$query['admin']['options_withGroup'] = 'SELECT * FROM ' . WTC_TP . 'wtcbboptions WHERE settingGroup = \'?\' ORDER BY settingGroup ASC';

$query['admin']['options_update'] = 'UPDATE ' . WTC_TP . 'wtcbboptions SET value = \'?\' WHERE settingid = \'?\'';

$query['admin']['options_update_withName'] = 'UPDATE ' . WTC_TP . 'wtcbboptions SET value = \'?\' WHERE name = \'?\'';

$query['admin']['get_langs'] = 'SELECT langid, name FROM ' . WTC_TP . 'lang ORDER BY name ASC';

$query['admin']['count_langs'] = 'SELECT COUNT(*) AS total FROM ' . WTC_TP . 'lang';

$query['admin']['get_lang'] = ' SELECT * FROM ' . WTC_TP . 'lang WHERE langid = \'?\'';

$query['admin']['get_level1_langCats'] = 'SELECT * FROM ' . WTC_TP . 'lang_categories WHERE depth = 1 ORDER BY catName ASC';

$query['admin']['get_level2_langCats'] = 'SELECT * FROm ' . WTC_TP . 'lang_categories WHERE depth = 2 ORDER BY catName ASC';

$query['admin']['get_langCats'] = 'SELECT * FROM ' . WTC_TP . 'lang_categories ORDER BY catName';

$query['admin']['import_replaceIntoCat'] = 'REPLACE INTO ' . WTC_TP . 'lang_categories (catid, catName, depth, parentid) VALUES (\'?\', \'?\', \'?\', \'?\')';

$query['admin']['insert_langCat'] = 'INSERT INTO ' . WTC_TP . 'lang_categories (catName, depth, parentid) VALUES (\'?\', \'?\', \'?\')';

$query['admin']['update_langCat'] = 'UPDATE ' . WTC_TP . 'lang_categories SET catName = \'?\' , depth = \'?\' , parentid = \'?\' WHERE catid = \'?\'';

$query['admin']['import_replaceIntoWords'] = 'REPLACE INTO ' . WTC_TP . 'lang_words (wordsid, name, words, langid, catid, displayName, defaultid) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['admin']['insert_words'] = 'INSERT INTO ' . WTC_TP . 'lang_words (name, words, langid, catid, displayName, defaultid) VALUES (\'?\', \'?\', \'?\', \'?\', \'?\', \'?\')';

$query['admin']['update_words'] = 'UPDATE ' . WTC_TP . 'lang_words SET name = \'?\' , words = \'?\' , langid = \'?\' , catid = \'?\' , displayName = \'?\' WHERE wordsid = \'?\'';

$query['admin']['get_words_noDefault'] = 'SELECT * FROM ' . WTC_TP . 'lang_words WHERE langid = \'?\'';

$query['admin']['get_words_ordered'] = 'SELECT * FROM ' . WTC_TP . 'lang_words WHERE langid = \'?\' OR defaultid = 0 ORDER BY displayName ASC';

$query['admin']['get_word_info'] = 'SELECT * FROM ' . WTC_TP . 'lang_words WHERE wordsid = \'?\'';

$query['admin']['general_delete'] = 'DELETE FROM ' . WTC_TP . '? WHERE ? = \'?\'';

$query['admin']['get_cat'] = 'SELECT * FROM ' . WTC_TP . 'lang_categories WHERE parentid = \'?\'';

$query['admin']['get_cat_info'] = 'SELECT * FROM ' . WTC_TP . 'lang_categories WHERE catid = \'?\'';

$query['admin']['search_language'] = 'SELECT * FROM ' . WTC_TP . 'lang_words WHERE ? LIKE \'%?%\' AND (langid = \'?\' OR langid = 0)';

$query['admin']['insert_lang'] = 'INSERT INTO ' . WTC_TP . 'lang (name) VALUES (\'?\')';

$query['admin']['update_lang'] = 'UPDATE ' . WTC_TP . 'lang SET name = \'?\' WHERE langid = \'?\'';


?>