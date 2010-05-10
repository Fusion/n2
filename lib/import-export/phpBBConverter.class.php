<?php
require_once "admin/tidbit.php";

/**
 * Input filter used to convert FROM a phpBB2 board
 */
class phpBBConverter
{
var $sourcedb, $prefixfrom, $res, $res2, $gflag, $goffset;


	function Converter($sourcedb, $prefixfrom)
	{
// Default nbbs: up to 4 groups - the admin will have to adjust this value if more are available
		define('GROUPS', '4');

		$this->sourcedb = $sourcedb;
		$this->prefixfrom = $prefixfrom;
	}

	function getTotalMessages()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}privmsgs";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMessages($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}privmsgs m LEFT JOIN {$this->prefixfrom}privmsgs_text t ON (m.privmsgs_id=t.privmsgs_text_id) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMessage()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['message_ID'] = &$row['privmsgs_id'];
		$retrow['recipient_id'] = &$row['privmsgs_to_userid'];
		$retrow['author_id'] = &$row['privmsgs_from_userid'];
		$retrow['message_title'] = &$row['privmsgs_subject'];
		$retrow['text'] = &$row['privmsgs_text'];
		$retrow['message_date'] = &$row['privmsgs_date'];
		$retrow['folder'] = 2; // phpBB2 doesn't have the concept of folders
		$retrow['read'] = 1; // Info not available - should use dates certainly
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
		$qry = "SELECT *,p.post_id as pid FROM {$this->prefixfrom}posts p LEFT JOIN {$this->prefixfrom}posts_text t ON (p.post_id=t.post_id) LEFT JOIN {$this->prefixfrom}users u ON (p.poster_id=u.user_id) LIMIT {$offset},{$windowsize}";
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
		$retrow['post_title'] = &$row['post_subject'];
		$retrow['text'] = &$row['post_text'];
		$retrow['post_date'] = &$row['post_time'];
		$retrow['author_id'] = &$row['poster_id'];
		$retrow['author_name'] = &$row['username'];
		$retrow['author_edit'] = '';
		$retrow['post_icon_id'] = '';
		$retrow['from_ip_address'] = '';
		$retrow['richtext'] = 0;

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
		$qry = "SELECT *,t.topic_id as tid,max(p.post_id) FROM {$this->prefixfrom}topics t LEFT JOIN {$this->prefixfrom}vote_desc d ON (t.topic_id=d.topic_id) LEFT JOIN {$this->prefixfrom}posts p ON (t.topic_id=p.topic_id) LEFT JOIN {$this->prefixfrom}users u ON (p.poster_id=u.user_id) GROUP BY p.topic_id LIMIT {$offset},{$windowsize}";
print $qry."<br>";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTopic()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['topic_ID'] = &$row['tid'];
		$retrow['area'] = &$row['forum_id'];
		$retrow['topic_title'] = &$row['topic_title'];
		$retrow['topic_description'] = '';
		$retrow['starter_id'] = &$row['topic_poster'];
		$retrow['last_poster_id'] = &$row['poster_id'];
		$retrow['start_date'] = &$row['topic_time'];
		$retrow['last_post_date'] = &$row['post_time'];
		$retrow['topic_replies'] = &$row['topic_replies'];
		$retrow['topic_views'] = &$row['topic_views'];
		$retrow['starter_name'] = &$row['username'];
		$retrow['last_poster_name'] = &$row['post_username'];
		$retrow['pinned'] = '0'; // TODO
		if(isset($row['topic_vote']) && !empty($row['topic_vote']))
		{
			$retrow['is_poll'] = '1';
			$choices = array();
			$qry = "SELECT * FROM {$this->prefixfrom}vote_results WHERE vote_id='".$row['vote_id']."'";
			$res2 = $this->sourcedb->query($qry);
			while($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC))
			{
				$choices[] = array(
					"element_ID" => $row2['vote_option_id'],
					"poll_question" => $row2['vote_option_text'],
					"poll_votes" => $row2['vote_result']);
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
		$qry = "SELECT * FROM {$this->prefixfrom}forums f LEFT JOIN {$this->prefixfrom}posts p ON (f.forum_last_post_id=p.post_id) LEFT JOIN {$this->prefixfrom}topics t ON (p.topic_id=t.topic_id) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['forum_id'];
		$retrow['area_title'] = &$row['forum_name'];
		$retrow['area_description'] = &$row['forum_desc'];
		$retrow['area_order'] = 1; /** @TODO */
		$retrow['parent'] = 1;
		$retrow['area_topics'] = &$row['forum_topics'];
		$retrow['area_replies'] = &$row['forum_posts'];
		$retrow['last_topic_id'] = &$row['topic_id'];
		$retrow['last_topic_title'] = &$row['topic_title'];
		$retrow['last_topic_date'] = &$row['post_time'];
		$retrow['last_author_id'] = &$row['post_username'];
		$retrow['last_author_name'] = &$row['poster_id'];
		return $retrow;
	}

	function getTotalGroups()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}groups";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		$c = $row['co'];
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}ranks";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return intval($c) + intval($row['co']);
	}

	function getGroups($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}groups LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
		$qry = "SELECT * FROM {$this->prefixfrom}ranks LIMIT {$offset},{$windowsize}";
		$this->res2 = $this->sourcedb->query($qry);
		$this->gflag = false;
		$this->goffset = 0;
	}

	function getNextGroup()
	{
		// Not importing groups yet. Problem: how would we increment group_id correctly?
		if(!$this->gflag) // Still returning results from the groups table
		{
			$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
			if(!$row)
			{
				$this->gflag = true;
			}
			else
			{
				$retrow['group_ID'] = &$row['group_id'];
				$retrow['group_name'] = &$row['group_name'];
				$retrow['admin'] = '0';
				$retrow['moderator'] = $row['group_moderator'] > 0 ? 1 : 0;
				$this->goffset ++;
				return $retrow;
			}
		}
		// Returning results from the ranks table
		$row = $this->res2->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;
		$retrow['group_ID'] = intval($row['rank_id']) + $this->goffset;
		$retrow['group_name'] = &$row['rank_title'];
		$retrow['admin'] = $row['rank_special'] > 0 ? 1 : 0;
		$retrow['moderator'] = 0;
		return $retrow;
	}

	function getTotalMembers()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->prefixfrom}users";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMembers($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->prefixfrom}users LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMember()
	{
		global $COMMON;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		// Do not include guest: flag the guy! (phpbb: user 0 == unknown)
		if($row['user_id']==0)
		{
			$retrow['cdse_ignore'] = true;
			return $retrow;
		}

		$retrow['user_ID'] = &$row['user_id'];
		$retrow['userid'] = &$row['username'];
		$retrow['password'] = &$row['user_password'];
		$retrow['reg_date'] = &$row['regdate'];
		$retrow['in_birthday'] = ''; // Unknown
		$retrow['email'] = &$row['user_email'];
#		if($row['avatar_type']=='1') // Upload but anyway we will automatically parse it if it's a URL
		$retrow['avatar'] = &$row['avatar'];
		$retrow['last_action'] = &$row['user_lastvisit'];
		$retrow['last_session'] = &$row['user_lastvisit'];
		$retrow['user_posts'] = &$row['user_posts'];
		$retrow['pms'] = $row['user_new_privmsg']!=0?1:0;
		$retrow['in_aim'] = &$row['user_aim'];
		$retrow['in_msn'] = &$row['user_msnm'];
		$retrow['in_icq'] = '';
		$retrow['in_yahoo'] = &$row['user_yim'];
		$retrow['in_location'] = '';
		$retrow['in_www'] = &$row['user_website'];
		$retrow['in_interests'] = &$row['user_interests'];
		$retrow['skinid'] = ''; // Use default skin

		$retrow['signature'] = $COMMON->OptBBCode($row['user_sig']);

		// And now, for the slow stuff! 1 request/user...could cache all this but then there's always the risk of running out of memory
		$qry = "SELECT * FROM {$this->prefixfrom}user_group WHERE user_id='{$row['user_id']}'";
		$res2 = $this->sourcedb->query($qry);
		if(!$res2)
			return $retrow;

		$gctr = 0;
		while($row2 = $res2->fetchRow(DB_FETCHMODE_ASSOC))
		{
			if($gctr==0)
				$retrow['mgroup'] = $row2['group_id'];
			else
				$retrow['mgroup'.$gctr] = $row2['group_id']; // TODO: make sure import.php write secondary groups
			$gctr ++;
			if($gctr == 1 )
				$gctr = 2;
		}
		return $retrow;
	}
}
?>
