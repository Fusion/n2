<?php
require_once "admin/tidbit.php";

/**
 * Input filter used to convert FROM a vBulletin board
 */
class VBulletin35Converter
{
var $sourcedb, $prefixfrom, $res;

	function Converter($sourcedb, $prefixfrom)
	{
		$this->sourcedb = $sourcedb;
		$this->prefixfrom = $prefixfrom;
	}

	function getTotalMessages()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}pm";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMessages($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}pm m LEFT JOIN {$this->prefixfrom}pmtext t ON (m.pmtextid=t.pmtextid) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMessage()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['message_ID'] = &$row['pmid'];
		$retrow['recipient_id'] = &$row['userid'];
		$retrow['author_id'] = &$row['fromuserid'];
		$retrow['message_title'] = &$row['title'];
		$retrow['text'] = &$row['message'];
		$retrow['message_date'] = &$row['dateline']; // When in Rome...
		$retrow['folder'] = ($row['folderid']==-1?-1:-2); // -1=sent, -2=inbox
		$retrow['read'] = &$row['messageread'];
		$retrow['richtext'] = 0;

		return $retrow;
	}

	function getTotalPosts()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}post";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getPosts($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}post LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextPost()
	{
		global $CONFIG, $COMMON;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['post_ID'] = &$row['postid'];
		$retrow['topic'] = &$row['threadid'];
		$retrow['post_title'] = &$row['title'];
		$retrow['text'] = $COMMON->OptBBCode($row['pagetext']);
		$retrow['post_date'] = &$row['post_date']; // todo
		$retrow['author_id'] = &$row['userid'];
		$retrow['author_name'] = &$row['username'];
		$retrow['author_edit'] = '';
		$retrow['post_icon_id'] = &$row['iconid'];
		$retrow['from_ip_address'] = &$row['ipaddress'];
		$retrow['richtext'] = 0;

		// Note: attachments are in the database. Oh, my.
		// TODO: eh, you know...
		return $retrow;
	}

	function getTotalTopics()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}thread";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTopics($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}thread t LEFT JOIN {$this->prefixfrom}user u ON (t.lastposter=u.username) LEFT JOIN {$this->prefixfrom}poll p ON (t.threadid=p.pollid) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTopic()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['topic_ID'] = &$row['threadid'];
		$retrow['area'] = &$row['forumid'];
		$retrow['topic_title'] = &$row['title'];
		$retrow['topic_description'] = '';
		$retrow['starter_id'] = &$row['postuserid'];
		$retrow['last_poster_id'] = &$row['userid'];
		$retrow['start_date'] = &$row['dateline'];
		$retrow['last_post_date'] = &$row['lastpost'];
		$retrow['topic_replies'] = &$row['replycount'];
		$retrow['topic_views'] = &$row['views'];
		$retrow['starter_name'] = &$row['postusername'];
		$retrow['last_poster_name'] = &$row['lastposter'];
		$retrow['pinned'] = &$row['sticky'];
		if(!empty($row['options']))
		{
			$retrow['is_poll'] = '1';
			$choices = array();
			$options = explode('|||', $row['options']);
			$votes = explode('|||', $row['votes']);
			for($i=0;$i<count($options);$i++)
			{
				$choices[] = array(
					"element_ID" => $i,
					"poll_question" => $options[$i],
					"poll_votes" => $votes[$i]);
			}
			$retrow['choices'] = &$choices;
		}
		else
		{
			$retrow['is_poll'] = '0';
		}
		return $retrow;
	}

	function getTotalAreas()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}forum WHERE parentid!=-1";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getAreas($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}forum f LEFT JOIN {$this->prefixfrom}user u ON (f.lastposter=u.username) WHERE parentid!=-1 LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['forumid'];
		$retrow['area_title'] = &$row['title_clean'];
		$retrow['area_description'] = &$row['description'];
		$retrow['area_order'] = &$row['displayorder'];
		$retrow['parent'] = &$row['parentid'];
		$retrow['area_topics'] = &$row['threadcount'];
		$retrow['area_replies'] = &$row['replycount'];
		$retrow['last_topic_id'] = &$row['lastthreadid'];
		$retrow['last_topic_title'] = &$row['lastthread'];
		$retrow['last_topic_date'] = &$row['lastpost'];
		$retrow['last_author_id'] = &$row['userid'];
		$retrow['last_author_name'] = &$row['lastposter'];
		return $retrow;
	}

	function getTotalTLAreas()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}forum WHERE parentid=-1";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTLAreas($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}forum WHERE parentid=-1";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTLArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['forumid'];
		$retrow['area_title'] = &$row['title_clean'];
		$retrow['area_description'] = &$row['description'];
		$retrow['area_order'] = &$row['displayorder'];
		$retrow['area_topics'] = 0;
		$retrow['area_replies'] = 0;
		$retrow['last_topic_id'] = 0;
		$retrow['last_topic_title'] = '';
		$retrow['last_topic_date'] = '';
		$retrow['last_author_id'] = '';
		$retrow['last_author_name'] = '';
		return $retrow;
	}

	function getTotalGroups()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}usergroup";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getGroups($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}usergroup LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextGroup()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['group_ID'] = &$row['usergroupid'];
		$retrow['group_name'] = &$row['title'];
		$retrow['admin'] = ($row['adminpermissions'] == '3' ? 1 : 0);
		$retrow['moderator'] = ($row['adminpermissions'] == '1' ? 1 : 0);
		return $retrow;
	}

	function getTotalMembers()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}user u LEFT JOIN {$this->prefixfrom}avatar a ON (u.avatarid=a.avatarid) LEFT JOIN {$this->prefixfrom}customavatar c ON (u.userid=c.userid) LEFT JOIN {$this->prefixfrom}usertextfield t ON (u.userid=t.userid)";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMembers($offset, $windowsize)
	{
		$qry = "SELECT *,c.userid AS c_avatarid FROM {$this->prefixfrom}user u LEFT JOIN {$this->prefixfrom}avatar a ON (u.avatarid=a.avatarid) LEFT JOIN {$this->prefixfrom}customavatar c ON (u.userid=c.userid) LEFT JOIN {$this->prefixfrom}usertextfield t ON (u.userid=t.userid) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMember()
	{
		global $COMMON;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		// vB does not come with any king of bogus guest user - yay for vB!

		$retrow['user_ID'] = &$row['userid'];
		$retrow['userid'] = &$row['username'];
		$retrow['mgroup'] = &$row['usergroupid'];
		$retrow['password'] = &$row['password'];
		$retrow['reg_date'] = &$row['joindate'];
		$retrow['in_birthday'] = &$row['birthday'];
		$retrow['email'] = &$row['email'];
		// vBulletin does this very peculiar thing: all pictures, after upload, are stored in the database
		// It would be an incredible amount of work to figure out their algorithm and since I refuse
		// to check the source code so that there can be no hint of reverse engineering...
		if(!empty($row['avatarpath']))
			$retrow['avatar'] = &$row['avatarpath'];
		else if (!empty($row['c_avatarid']))
			$retrow['avatar'] = 'customavatars/avatar' . $row['c_avatarid'] . '_' . $row['avatarrevision'] . '.gif';
		else
			$retrow['avatar'] = null; // *sigh *
		//
		$retrow['last_action'] = &$row['lastactivity'];
		$retrow['last_session'] = &$row['lastvisit'];
		$retrow['user_posts'] = &$row['posts'];
		$retrow['pms'] = $row['pmtotal']!=0?1:0;
		$retrow['in_aim'] = &$row['aim'];
		$retrow['in_msn'] = &$row['msn'];
		$retrow['in_icq'] = &$row['icq'];
		$retrow['in_yahoo'] = &$row['yahoo'];
		$retrow['in_location'] = '';
		$retrow['in_www'] = &$row['homepage'];
		$retrow['in_interests'] = &$row['interests'];
		$retrow['skinid'] = ''; // Use default skin

		$retrow['signature'] = $COMMON->OptBBCode($row['signature']);

		return $retrow;
	}
}
?>
