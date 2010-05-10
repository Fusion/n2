<?php
require_once "admin/tidbit.php";

/**
 * Input filter used to convert FROM an Invision board
 */
class IbfConverter
{
var $sourcedb, $prefixfrom, $res;

	function Converter($sourcedb, $prefixfrom)
	{
		$this->sourcedb = $sourcedb;
		$this->prefixfrom = $prefixfrom;
	}

	function getTotalMessages()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}messages";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMessages($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}messages LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMessage()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['message_ID'] = &$row['msg_id'];
		$retrow['recipient_id'] = &$row['recipient_id'];
		$retrow['author_id'] = &$row['from_id'];
		$retrow['message_title'] = &$row['title'];
		$retrow['text'] = &$row['message'];
		$retrow['message_date'] = &$row['msg_date'];
		$retrow['folder'] = ($row['vid']=="sent"?-1:-2); // -1=sent, -2=inbox
		$retrow['read'] = &$row['read_state'];
		$retrow['richtext'] = 0;

		return $retrow;
	}

	function getTotalPosts()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}posts";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getPosts($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}posts LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextPost()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['post_ID'] = &$row['pid'];
		$retrow['topic'] = &$row['topic_id'];
		$retrow['post_title'] = &$row['post_title'];
		$retrow['text'] = &$row['post'];
		$retrow['post_date'] = &$row['post_date'];
		$retrow['author_id'] = &$row['author_id'];
		$retrow['author_name'] = &$row['author_name'];
		$retrow['author_edit'] = &$row['edit_name'];
		$retrow['post_icon_id'] = &$row['icon_id'];
		$retrow['from_ip_address'] = &$row['ip_address'];
		$retrow['richtext'] = 0;

		if($row['attach_id']!='')
		{
			$attach = "<br /><br /><img src='".$CONFIG->server."/attachments/".$row['attach_id']."'>";
			$retrow['text'] .= $attach;
		}

		return $retrow;
	}

	function getTotalTopics()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}topics";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTopics($offset, $windowsize)
	{
		$qry = "SELECT *,t.tid AS topic_ID, t.start_date AS t_start_date, t.starter_id AS t_starter_id, t.forum_id AS t_forum_id FROM {$this->prefixfrom}topics t LEFT JOIN {$this->prefixfrom}polls p ON (t.tid=p.tid) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTopic()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['topic_ID'] = &$row['topic_ID'];
		$retrow['area'] = &$row['t_forum_id'];
		$retrow['topic_title'] = &$row['title'];
		$retrow['topic_description'] = &$row['description'];
		$retrow['starter_id'] = &$row['t_starter_id'];
		$retrow['last_poster_id'] = &$row['last_poster_id'];
		$retrow['start_date'] = &$row['t_start_date'];
		$retrow['last_post_date'] = &$row['last_post'];
		$retrow['topic_replies'] = &$row['posts'];
		$retrow['topic_views'] = &$row['views'];
		$retrow['starter_name'] = &$row['starter_name'];
		$retrow['last_poster_name'] = &$row['last_poster_name'];
		$retrow['pinned'] = &$row['pinned'];
		if(isset($row['choices']))
		{
			$retrow['is_poll'] = '1';
			$choices = array();
			$decoded = unserialize(stripslashes($row['choices']));
			for($i=0;$i<count($decoded);$i++)
			{
				$choicerow = &$decoded[$i];
				list($choiceid,$choicestring,$choicevotes) = $choicerow;
				$choices[] = array(
					"element_ID" => $choiceid,
					"poll_question" => $choicestring,
					"poll_votes" => $choicevotes);
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
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}forums";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getAreas($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}forums LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['id'];
		$retrow['area_title'] = &$row['name'];
		$retrow['area_description'] = &$row['description'];
		$retrow['area_order'] = &$row['position'];
		$retrow['parent'] = &$row['category'];
		$retrow['area_topics'] = &$row['topics'];
		$retrow['area_replies'] = &$row['posts'];
		$retrow['last_topic_id'] = &$row['last_id'];
		$retrow['last_topic_title'] = &$row['last_title'];
		$retrow['last_topic_date'] = &$row['last_post'];
		$retrow['last_author_id'] = &$row['last_poster_id'];
		$retrow['last_author_name'] = &$row['last_poster_name'];
		return $retrow;
	}

	function getTotalTLAreas()
	{
		$qry = "SELECT COUNT(DISTINCT(category)) AS co FROM {$this->prefixfrom}forums";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTLAreas($offset, $windowsize)
	{
		$qry = "SELECT DISTINCT(category),c.name,c.position FROM {$this->prefixfrom}forums f LEFT JOIN {$this->prefixfrom}categories c ON (f.category=c.id) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTLArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['category'];
		$retrow['area_title'] = &$row['name'];
		$retrow['area_description'] = '';
		$retrow['area_order'] = &$row['position'];
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
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}groups";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getGroups($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}groups LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextGroup()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['group_ID'] = &$row['g_id'];
		$retrow['group_name'] = &$row['g_title'];
		$retrow['admin'] = &$row['g_access_cp'];
		$retrow['moderator'] = &$row['g_is_supmod'];
		return $retrow;
	}

	function getTotalMembers()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}members";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMembers($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}members LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMember()
	{
		global $COMMON;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		// Do not include guest: flag the guy! (ibf: user 0 == guest)
		if($row['id']==0)
		{
			$retrow['cdse_ignore'] = true;
			return $retrow;
		}

		$retrow['user_ID'] = &$row['id'];
		$retrow['userid'] = &$row['name'];
		$retrow['mgroup'] = &$row['mgroup'];
		$retrow['password'] = &$row['password'];
		$retrow['reg_date'] = &$row['joined'];
		$retrow['in_birthday'] =
			(isset($row['bday_day']) && $row['bday_day']!='' &&
			isset($row['bday_month']) && $row['bday_month']!='' &&
			isset($row['bday_year']) && $row['bday_year']!='') ?
			sprintf("%04s-%02s-%02s",$row['bday_year'],$row['bday_month'],$row['bday_day']) :
			'';
		$retrow['email'] = &$row['email'];
		$retrow['avatar'] = &$row['avatar'];
		if($retrow['avatar']=='noavatar') // IBF: no avatar
			$retrow['avatar']='';
		$retrow['last_action'] = &$row['last_activity'];
		$retrow['last_session'] = &$row['last_visit'];
		$retrow['user_posts'] = &$row['posts'];
		$retrow['pms'] = $row['new_msg']!=0?1:0;
		$retrow['in_aim'] = &$row['aim_name'];
		$retrow['in_msn'] = &$row['msnname'];
		$retrow['in_icq'] = &$row['icq_number'];
		$retrow['in_yahoo'] = &$row['yahoo'];
		$retrow['in_location'] = &$row['location'];
		$retrow['in_www'] = &$row['website'];
		$retrow['in_interests'] = &$row['interests'];
		$retrow['skinid'] = ''; // Use default skin

		$retrow['signature'] = $COMMON->OptBBCode($row['signature']);

		return $retrow;
	}
}
?>
