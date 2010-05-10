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
## *************** wtcBB IMPORT DATA **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-MAINTENANCE');
define('FILE_ACTION', 'maintenance');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

class ResultHandler {
    private $result;

    function __construct($result) {
        $this->result = $result;
    }

    function fetchRow($whatever) {
        return mysql_fetch_assoc($this->result);
    }
}

class Sourcedb {
    private $link;
    public  $prefix;

    function __construct($env) {
        if(!($this->link = mysql_connect($env['dbhostname'], $env['dbusername'], $env['dbuserpassword']))) {
            throw new Exception("Unable to connect to database");
        }

        if(!mysql_select_db($env['dbname'], $this->link)) {
            throw new Exception("Unable to select database: " . mysql_error($this->link));
        }

        $this->prefix = mysql_real_escape_string($env['dbprefix']);
    }

    function query($qry) {
        if(!($result = mysql_query($qry, $this->link))) {
            throw new Exception("Unable to run query: " . mysql_error($this->link));
        }
        return new ResultHandler($result);
    }
}

class Otherdb {
    private $link, $prefix;
    public  $converter;

    function __construct($env, $persist = false) {
        global $query;
        
        $sourceName = $env['source'] . 'Converter';
        $this->converter = new $sourceName(new Sourcedb($env));

        if($persist) {
            // Need only be called the very first time
            list(
                $_SESSION['DATA']['source'],
                $_SESSION['DATA']['dbhostname'],
                $_SESSION['DATA']['dbname'],
                $_SESSION['DATA']['dbusername'],
                $_SESSION['DATA']['dbuserpassword'],
                $_SESSION['DATA']['dbprefix']
            ) = array(
                $env['source'],
                $env['dbhostname'],
                $env['dbname'],
                $env['dbusername'],
                $env['dbuserpassword'],
                $env['dbprefix']
            );

            // Collect our local stats
            $qry = new Query($query['admin_import']['get_groups_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['GROUP_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_users_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['USER_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_categories_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['TL_AREA_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_forums_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['AREA_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_topics_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['TOPIC_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_posts_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['POST_OFFSET'] = $row['m'] + 1;

            $qry = new Query($query['admin_import']['get_pm_convo_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['PM_CONVO_OFFSET'] = $row['m'] + 1;
            $qry = new Query($query['admin_import']['get_pm_msg_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['PM_MSG_OFFSET'] = $row['m'] + 1;
            $qry = new Query($query['admin_import']['get_pm_data_maxid']);
            $row = $qry->fetchArray();
            $_SESSION['DATA']['PM_DATA_OFFSET'] = $row['m'] + 1;
        }
    }
}

function prepare() {
    if(!isset($_SESSION['DATA']['state'])) {
        $_SESSION['DATA']['state'] = 0;
    }

    if(!isset($_SESSION['DATA']['offset'])) {
        $_SESSION['DATA']['offset'] = 0;
    }

    $_SESSION['DATA']['windowsize'] = 100;

    return $_SESSION['DATA'];
}

function navigationCode($action, $offset) {
    $_SESSION['DATA']['offset'] = $offset;
    $url = 'admin.php?file=importdata&' . $action . '=Import';
    $js  = <<<EOB
<script type="text/javascript" src="./scripts/jquery.js"></script>
<script language="javascript" type="text/javascript">
jQuery(document).ready(function() {
    window.location = "$url";
});
</script>

EOB;
    return $js;
}

function __n($txt) {
	return htmlspecialchars($txt) . "<br />\n";
}

function n2Query($qryStr, $vars) {
    $qryE = new Query($qryStr, $vars, null);
    if(!$qryE->execute()) {
        die("<p style='color:red'>Sorry, an error occured while running this query:<br /><em>$qryStr</em></p>");
    }
}

if('' == session_id()) {
    // We will use a session to navigate from page to page...
    session_start();
}

if(!$_POST) {
    $_POST = array();
}

$backToMain = "<br /><br />...Done. <a href='admin.php?file=importdata&importmenu=Import'>Back to the Options Screen</a>";

if($_REQUEST['importgroups']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalGroups();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} groups...<br /><br />";
    if($cfg['offset'] < $count)
    {
	// Get "registered user" info and use it for new groups
        $qry = new Query($query['admin_import']['read_default_group']);
        $info = $qry->fetchArray();
        if(!$info)
        {
            die("Sorry, but it seems that you deleted the 'Registered Users' group!");
        }
	$info['description'] = 'Imported usergroup';
        $otherdb->converter->getGroups($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextGroup())
        {
            echo __n($row['group_name']);
	    $info['usergroupid'] = $row['group_ID'] + $_SESSION['DATA']['GROUP_OFFSET'];
	    $info['title'] = $row['group_name'];
	    $info['admin'] = $row['admin'];
	    $info['global'] = $row['moderator'];
            Usergroup::insert($info);
/*
            n2Query($query['admin_import']['import_group'],
                array(
                    1 => $row['group_ID'] + $_SESSION['DATA']['GROUP_OFFSET'],
                    2 => $row['group_name'],
                    3 => $row['admin'],
                    4 => $row['moderator'],
                )
            );
*/
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importgroups', $newoffset);
    }
    else
    {
	@unlink('./cache/groups.cache.php');
        echo $backToMain;
    }
}

elseif($_REQUEST['importusers']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalMembers();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} users...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getMembers($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextMember())
        {
            // Prepare secondary groups
            $secgroupids = false;
            for($i=2;; $i++) {
                $groupId = 'mgroup' . $i;
                if(!isset($row[$groupId])) {
                    break;
                }
                if(!$secgroupids) {
                    $secgroupids = array();
                }
                $secgroupids[] = $row[$groupId] + $_SESSION['DATA']['GROUP_OFFSET'];
            }

            echo __n($row['userid']);
            if($secgroupids) {
                n2Query($query['admin_import']['import_user_w_groups'],
                    array(
                        1 => $row['user_ID'] + $_SESSION['DATA']['USER_OFFSET'],
                        2 => $row['userid'],
                        3 => $row['mgroup'] + $_SESSION['DATA']['GROUP_OFFSET'],
                        5 => $row['password'],
                        6 => $row['reg_date'],
                        7 => $row['in_birthday'],
                        8 => $row['email'],
                        9 => $row['avatar'],
                        10 => $row['last_action'],
                        11 => $row['last_session'],
                        12 => $row['user_posts'],
                        13 => $row['in_aim'],
                        14 => $row['in_msn'],
                        15 => $row['in_yahoo'],
                        16 => $row['in_icq'],
                        17 => $row['in_location'],
                        18 => $row['in_www'],
                        19 => $row['in_interests'],
                        20 => $row['signature'],
                        21 => serialize($secgroupids),
                    )
                );
            }
            else {
                n2Query($query['admin_import']['import_user'],
                    array(
                        1 => $row['user_ID'] + $_SESSION['DATA']['USER_OFFSET'],
                        2 => $row['userid'],
                        3 => $row['mgroup'] + $_SESSION['DATA']['GROUP_OFFSET'],
                        5 => $row['password'],
                        6 => $row['reg_date'],
                        7 => $row['in_birthday'],
                        8 => $row['email'],
                        9 => $row['avatar'],
                        10 => $row['last_action'],
                        11 => $row['last_session'],
                        12 => $row['user_posts'],
                        13 => $row['in_aim'],
                        14 => $row['in_msn'],
                        15 => $row['in_yahoo'],
                        16 => $row['in_icq'],
                        17 => $row['in_location'],
                        18 => $row['in_www'],
                        19 => $row['in_interests'],
                        20 => $row['signature'],
                    )
                );
            }
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importusers', $newoffset);
    }
    else
    {
        echo $backToMain;
    }
}

elseif($_REQUEST['importtlareas']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalTLAreas();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} categories...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getTLAreas($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextTLArea())
        {
            echo __n($row['area_title']);
            n2Query($query['admin_import']['import_category'],
                array(
                    1 => '-1',
                    2 => '1',
                    3 => $row['area_ID'] + $_SESSION['DATA']['TL_AREA_OFFSET'],
                    4 => $row['area_title'],
                    5 => $row['area_description'],
                    6 => $row['area_order'],
                    7 => $row['area_topics'],
                    8 => $row['area_replies'],
                    9 => $row['last_topic_id'] + $_SESSION['DATA']['TOPIC_OFFSET'],
                    10 => $row['last_topic_title'],
                    11 => $row['last_topic_date'],
                    12 => $row['last_author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    13 => $row['last_author_name'],
                )
            );
				// Problem: categories and forums share the same id...they may overlap.
				// Fix:
				if($row['area_ID'] + $_SESSION['DATA']['TL_AREA_OFFSET'] >= $_SESSION['DATA']['AREA_OFFSET'])
				{
                    $_SESSION['DATA']['AREA_OFFSET'] = $row['area_ID'] + $_SESSION['DATA']['TL_AREA_OFFSET'] + 1;
				}
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importtlareas', $newoffset);
    }
    else
    {
        echo $backToMain;
    }
}

elseif($_REQUEST['importareas']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalAreas();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} forums...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getAreas($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextArea())
        {
            echo __n($row['area_title']);
            n2Query($query['admin_import']['import_forum'],
                array(
                    1 => '1',
                    2 => '2',
                    3 => $row['area_ID'] + $_SESSION['DATA']['AREA_OFFSET'],
                    4 => $row['area_title'],
                    5 => $row['area_description'],
                    6 => $row['area_order'],
                    7 => $row['area_topics'],
                    8 => $row['area_replies'],
                    9 => $row['last_topic_id'] + $_SESSION['DATA']['TOPIC_OFFSET'],
                    10 => $row['last_topic_title'],
                    11 => $row['last_topic_date'],
                    12 => $row['last_author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    13 => $row['last_author_name'],
                )
            );
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importareas', $newoffset);
    }
    else
    {
	$m_cats = array();
	$m_fora = array();
	$qry = new Query($query['admin_import']['reread_categories_and_forums']);
	while($row = $qry->fetchArray())
	{
		if($row['parent'] == -1)
		{
			$m_cats[$row['forumid']] = array();
		}
		else
		{
			$m_fora[$row['forumid']] = $row;
		}
	}
	// Notes: this code levels subforums under main categories
	// Well it would...but I'm storing everybody under main category
	foreach($m_fora as $id => $forum)
	{
		$rid = $forum['parent'];
		while(!isset($m_cats[$rid]))
		{
			$rid = $forum[$rid]['parent'];
		}
		$m_cats[$rid][] = $id;
	}
	foreach($m_cats as $id => $subs)
	{
		$str = serialize($subs);
		n2Query($query['admin_import']['rewrite_category_subs'],
			array(
				1 => $str,
				2 => $id
			));
	}

        echo $backToMain;
    }
}

elseif($_REQUEST['importtopics']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalTopics();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} topics...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getTopics($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextTopic())
        {
            echo __n($row['topic_title']);
            n2Query($query['admin_import']['import_topic'],
                array(
                    1 => $row['topic_ID'] + $_SESSION['DATA']['TOPIC_OFFSET'],
                    2 => $row['area'] + $_SESSION['DATA']['AREA_OFFSET'],
                    3 => $row['topic_title'],
                    4 => $row['topic_description'],
                    5 => $row['starter_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    6 => $row['last_poster_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    7 => $row['start_date'],
                    8 => $row['last_post_date'],
                    9 => $row['topic_replies'],
                    10 => $row['topic_views'],
                    11 => $row['starter_name'],
                    12 => $row['last_poster_name'],
                    13 => $row['pinned'],
                    14 => 0, // @todo POLL
                )
            );
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importtopics', $newoffset);
    }
    else
    {
        echo $backToMain;
    }
}

elseif($_REQUEST['importposts']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalPosts();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} posts...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getPosts($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextPost())
        {
            echo __n($row['post_title']);
            n2Query($query['admin_import']['import_post'],
                array(
                    1 => $row['post_ID'] + $_SESSION['DATA']['POST_OFFSET'],
                    2 => $row['topic'] + $_SESSION['DATA']['TOPIC_OFFSET'],
                    3 => $row['area'] + $_SESSION['DATA']['AREA_OFFSET'],
                    4 => $row['post_title'] ,
                    5 => $row['text'] ,
                    6 => $row['post_date'] ,
                    7 => $row['author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    8 => $row['author_name'] ,
                    9 => '',
                    10 => '',
                    11 => $row['from_ip_address'] ,
                )
            );
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importposts', $newoffset);
    }
    else
    {
        echo $backToMain;
    }
}

/*
                $retrow['message_ID'] = &$row['message_ID'];
                $retrow['recipient_id'] = &$row['recipient_id'];
                $retrow['author_id'] = &$row['author_id'];
                $retrow['message_title'] = &$row['message_title'];
                $retrow['text'] = &$row['text'];
                $retrow['message_date'] = &$row['message_date'];
                $retrow['folder'] = $retrow['folder'];
                $retrow['read'] = &$row['read'];
                $retrow['richtext'] = $retrow['richtext'];
*/
elseif($_REQUEST['importpms']) {
    $cfg = prepare();
    $otherdb = new Otherdb($cfg);
    $count = $otherdb->converter->getTotalMessages();
    if($cfg['offset'] > $count) {
        $cfg['offset'] = $count;
    }
    echo "Imported {$cfg['offset']}/{$count} messages...<br /><br />";
    if($cfg['offset'] < $count)
    {
        $otherdb->converter->getMessages($cfg['offset'], $cfg['windowsize']);
        while($row = $otherdb->converter->getNextMessage())
        {
            $senderInfo = new User($row['author_id'] + $_SESSION['DATA']['USER_OFFSET']);
            $recipientInfo = new User($row['recipient_id'] + $_SESSION['DATA']['USER_OFFSET']);
            echo __n("From " .
		$senderInfo->info['username'] .
		"(" . ($row['author_id'] + $_SESSION['DATA']['USER_OFFSET']) . ") to " .
		$recipientInfo->info['username'] .
		"(" . ($row['recipient_id'] + $_SESSION['DATA']['USER_OFFSET']) . ") " .
		$row['message_title']);
            $p = new Password('');
            $myHash = md5(time() . $row['author_id'] . microtime() . $p->getSalt());
            n2Query($query['admin_import']['import_pm_convo'],
                array(
                    1 => $row['message_ID'] + $_SESSION['DATA']['PM_CONVO_OFFSET'],
                    2 => $row['message_title'],
                    3 => $row['message_date'],
                    4 => $row['message_date'],
                    5 => $senderInfo->info['username'],
                    6 => $row['author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    7 => $row['message_ID'] + $_SESSION['DATA']['PM_CONVO_OFFSET'],
                    8 => 1,
                )
            );
            n2Query($query['admin_import']['import_pm_msg'],
                array(
                    1 => $row['message_ID'] + $_SESSION['DATA']['PM_MSG_OFFSET'],
                    2 => $row['message_ID'] + $_SESSION['DATA']['PM_CONVO_OFFSET'],
                    3 => $row['message_title'],
                    4 => $row['author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    5 => $row['text'],
                    6 => '',
                    7 => $row['message_date'],
                    8 => $row['recipient_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    9 => $myHash,
                    10 => 1,
                    11 => 1,
                    12 => 1,
                )
            );
            n2Query($query['admin_import']['import_pm_data'],
                array(
                    1 => $row['message_ID'] + $_SESSION['DATA']['PM_CONVO_OFFSET'],
                    2 => $row['recipient_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    3 => 1,
                    4 => 0,
                    5 => 0,
                    6 => $recipientInfo->info['username'],
                )
            );
            n2Query($query['admin_import']['import_pm_data'],
                array(
                    1 => $row['message_ID'] + $_SESSION['DATA']['PM_CONVO_OFFSET'],
                    2 => $row['author_id'] + $_SESSION['DATA']['USER_OFFSET'],
                    3 => 1,
                    4 => $row['message_date'],
                    5 => 0,
                    6 => $senderInfo->info['username'],
                )
            );
        }
        $newoffset = $cfg['offset'] + $cfg['windowsize'];
        echo navigationCode('importpms', $newoffset);
    }
    else
    {
        echo $backToMain;
    }
}

else {
        $editinfo['source'] = null; // For select
        $errorstr = ''; // Display input error


        if(($_POST && isset($_POST['data']['source'])) || ($_GET && isset($_GET['importmenu']))) {
            // User selected database info
            try {
                // Let's now check that it's OK
                if($_POST && $_POST['data']) {
                    new Otherdb($_POST['data'], true);
                    // User entered correct info
                }

                // Display choices
                new AdminHTML('header', 'Import Data From Other Board', true);

                new AdminHTML('tableBegin', 'Import Data From Other Board', true);

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    "<strong>Please follow these steps in their numerical order:</strong>" => Array('colspan' => 2)
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "1-User Groups" . '</strong><p class="small">' . "Import the other board's user groups" . '</p>' => Array(),
                    '<input type="submit" name="importgroups" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "2-User Accounts" . '</strong><p class="small">' . "Import the other board's user accounts" . '</p>' => Array(),
                    '<input type="submit" name="importusers" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "3-Categories" . '</strong><p class="small">' . "Import the other board's forum categories" . '</p>' => Array(),
                    '<input type="submit" name="importtlareas" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "4-Forums" . '</strong><p class="small">' . "Import the other board's forums" . '</p>' => Array(),
                    '<input type="submit" name="importareas" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "5-Topics" . '</strong><p class="small">' . "Import the other board's forum topics" . '</p>' => Array(),
                    '<input type="submit" name="importtopics" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "6-Posts" . '</strong><p class="small">' . "Import the other board's forum posts" . '</p>' => Array(),
                    '<input type="submit" name="importposts" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableCells', '', true, Array(
                    'cells' => Array(
                    '<strong>' . "7-Private Messages" . '</strong><p class="small">' . "Import the other board's private messages" . '</p>' => Array(),
                    '<input type="submit" name="importpms" class="button" value="' . "Import" . '" />' => Array()
                    )));

                new AdminHTML('tableEnd', '', true, Array('form' => 1, 'footerText' => '&nbsp;'));

                new AdminHTML('footer', '', true);

                unset($_SESSION['DATA']['state']);
                unset($_SESSION['DATA']['offset']);

                exit;
            } // End "if successful connection to other database"
            catch(Exception $e) {
                $errorstr = "<p style='font-weight:bold;color:red'>Unable to connect to database. Please verify your input.</p><p>Error: $e</p>";
                $editinfo = array(
                    'source'         => $_POST['data']['source'],
                    'dbhostname'     => $_POST['data']['dbhostname'],
                    'dbname'         => $_POST['data']['dbname'],
                    'dbusername'     => $_POST['data']['dbusername'],
                    'dbuserpassword' => $_POST['data']['dbuserpassword'],
                    'dbprefix'       => $_POST['data']['dbprefix'],
                    );
            }
        }

	new AdminHTML('header', 'Import Data From Other Board', true);

	new AdminHTML('tableBegin', 'Import Data From Other Board', true);

        if($errorstr) {
            new AdminHTML('tableCells', '', true, Array(
                'cells' => Array(
                $errorstr => Array('colspan' => 2)
                )));
        }

        new AdminHTML('tableCells', '', true, Array(
            'cells' => Array(
            "<strong>Note: it is strongly recommended to close down your board while importing data.<br />\n" .
            "If new data is added while importing, index conflicts may happen.</strong>" => Array('colspan' => 2)
            )));

        $sources = array(
            'nextBBS' => 'nextBBS',
            'Invision Board 1.x' => 'Ibf',
            );
	new AdminHTML('tableRow', Array(
            'title' => 'Source Type',
            'desc' => 'Select the software used by the board you are importing',
            'type' => 'select',
            'name' => 'data[source]',
            'select' => Array('fields' => $sources, 'select' => $editinfo['source'])
            ), true);

        new AdminHTML('tableRow', Array(
            'title' => 'Hostname',
            'desc' => "The host where your other board's database is located",
            'type' => 'text',
            'name' => 'data[dbhostname]',
            'value' => $editinfo['dbhostname']
        ), true);

	new AdminHTML('tableRow', Array(
            'title' => 'Database',
            'desc' => "Name of your other board's database",
            'type' => 'text',
            'name' => 'data[dbname]',
            'value' => $editinfo['dbname']
        ), true);

	new AdminHTML('tableRow', Array(
            'title' => 'User',
            'desc' => "User name used to query the other board's database",
            'type' => 'text',
            'name' => 'data[dbusername]',
            'value' => $editinfo['dbusername']
        ), true);

	new AdminHTML('tableRow', Array(
            'title' => 'Password',
            'desc' => "Password for the user used to query the other board's database",
            'type' => 'text',
            'name' => 'data[dbuserpassword]',
            'value' => $editinfo['dbuserpassword']
        ), true);

	new AdminHTML('tableRow', Array(
            'title' => 'Prefix',
            'desc' => "A string used to prefix your other board's database tables, if any",
            'type' => 'text',
            'name' => 'data[dbprefix]',
            'value' => $editinfo['dbprefix']
        ), true);

        new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

?>
