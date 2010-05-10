<?php
/**
 * Input filter used to convert FROM nextBBS v <= 1.0
 */
class nextBBSConverter
{
var $sourcedb, $res;

	function __construct($sourcedb)
	{
		$this->sourcedb = $sourcedb;
	}

	function _t($txt)
	{
		$out = str_replace(
			array('<br />', '<p>', '</p>', '<br/>', '<u>', '</u>', '<b>', '</b>', '<i>', '</i>'),
			array('', '', '', "\n", '[u]', '[/u]', '[b]', '[/b]', '[i]', '[/i]'),
			$txt);
		$out = preg_replace(
			array(
				'/<!--.+?-->/',
				"/<img src=['\"](.*?)['\"].*?>/",
				'/<a href="(.*?)".*?>(.*?)<\/a>/s',
				'/<\/?table.*?>/',
				'/<\/?tbody.*?>/',
				'/<\/?tr.*?>/',
				'/<\/?td.*?>/',
				'/<\/?span.*?>/',),
			array(
				'',
				'[img]$1[/img]',
				'[url=$1]$2[/url]',
				'',
				'',
				'',
				'',
				'',),
			$out);
		return $out;
	}

	function getTotalMessages()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}messages";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMessages($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}messages LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMessage()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

            /* @todo LOTS OF STUFF! */
		$retrow['message_ID'] = &$row['message_ID'];
		$retrow['recipient_id'] = &$row['recipient_id'];
		$retrow['author_id'] = &$row['author_id'];
		$retrow['message_title'] = &$row['message_title'];
		$retrow['text'] = $this->_t($row['text']);
		$retrow['message_date'] = &$row['message_date'];
		$retrow['folder'] = $retrow['folder'];
		$retrow['read'] = &$row['read'];
		$retrow['richtext'] = $retrow['richtext'];

		return $retrow;
	}

	function getTotalPosts()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}posts";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getPosts($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}posts p LEFT JOIN {$this->sourcedb->prefix}topics t ON (p.topic=t.topic_ID) LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextPost()
	{
		global $CONFIG;

		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['post_ID'] = &$row['post_ID'];
		$retrow['topic'] = &$row['topic'];
		$retrow['area'] = &$row['area'];
		$retrow['post_title'] = empty($row['post_title']) ? $row['topic_title'] : $row['post_title'];
		$retrow['text'] = $this->_t($row['text']);
		$retrow['post_date'] = &$row['post_date'];
		$retrow['author_id'] = &$row['author_id'];
		$retrow['author_name'] = &$row['author_name'];
		$retrow['author_edit'] = &$row['author_edit'];
		$retrow['post_icon_id'] = &$row['post_icon_id'];
		$retrow['from_ip_address'] = &$row['from_ip_address'];
		$retrow['richtext'] = $retrow['richtext'];
/* @todo Missing forum id! */
/* @todo
		if($row['attach_id']!='')
		{
			$attach = "<br /><br /><img src='".$CONFIG->server."/attachments/".$row['attach_id']."'>";
			$retrow['text'] .= $attach;
		}
*/
                
		return $retrow;
	}

	function getTotalTopics()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}topics";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTopics($offset, $windowsize)
	{
		$qry = "SELECT *FROM {$this->sourcedb->prefix}topics LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTopic()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['topic_ID'] = &$row['topic_ID'];
		$retrow['area'] = &$row['area'];
		$retrow['topic_title'] = &$row['topic_title'];
		$retrow['topic_description'] = &$row['topic_description'];
		$retrow['starter_id'] = &$row['starter_id'];
		$retrow['last_poster_id'] = &$row['last_poster_id'];
		$retrow['start_date'] = &$row['start_date'];
		$retrow['last_post_date'] = &$row['last_post_date'];
		$retrow['topic_replies'] = &$row['topic_replies'];
		$retrow['topic_views'] = &$row['topic_views'];
		$retrow['starter_name'] = &$row['starter_name'];
		$retrow['last_poster_name'] = &$row['last_poster_name'];
		$retrow['pinned'] = &$row['pinned'];
/* @todo
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
 */
		return $retrow;
	}

	function getTotalAreas()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}areas WHERE parent!=-1";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getAreas($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}areas WHERE parent!=-1 LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['area_ID'];
		$retrow['area_title'] = &$row['area_title'];
		$retrow['area_description'] = &$row['area_description'];
		$retrow['area_order'] = &$row['area_order'];
		$retrow['parent'] = &$row['parent'];
		$retrow['area_topics'] = &$row['area_topics'];
		$retrow['area_replies'] = &$row['area_replies'];
		$retrow['last_topic_id'] = &$row['last_topic_id'];
		$retrow['last_topic_title'] = &$row['last_topic_title'];
		$retrow['last_topic_date'] = &$row['last_topic_date'];
		$retrow['last_author_id'] = &$row['last_author_id'];
		$retrow['last_author_name'] = &$row['last_author_name'];
		return $retrow;
	}

	function getTotalTLAreas()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}areas WHERE parent=-1";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getTLAreas($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}areas WHERE parent=-1 LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextTLArea()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['area_ID'] = &$row['area_ID'];
		$retrow['area_title'] = &$row['area_title'];
		$retrow['area_description'] = $retrow['area_description'];
		$retrow['area_order'] = &$row['area_order'];
		$retrow['area_topics'] = &$retrow['area_topics'];
		$retrow['area_replies'] = &$retrow['area_replies'];
		$retrow['last_topic_id'] = &$retrow['last_topic_id'];
		$retrow['last_topic_title'] = &$retrow['last_topic_title'];
		$retrow['last_topic_date'] = &$retrow['last_topic_date'];
		$retrow['last_author_id'] = &$retrow['last_author_id'];
		$retrow['last_author_name'] = &$retrow['last_author_name'];
		return $retrow;
	}

	function getTotalGroups()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}groups";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getGroups($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}groups LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextGroup()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['group_ID'] = &$row['group_ID'];
		$retrow['group_name'] = &$row['group_name'];
		$retrow['admin'] = &$row['admin'];
		$retrow['moderator'] = &$row['moderator'];
		return $retrow;
	}

	function getTotalMembers()
	{
		$qry = "SELECT COUNT(*) AS co FROM {$this->sourcedb->prefix}users";
		$res = $this->sourcedb->query($qry);
		$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			die("Unable to query sourcedb");
		return $row['co'];
	}

	function getMembers($offset, $windowsize)
	{
		$qry = "SELECT * FROM {$this->sourcedb->prefix}users LIMIT {$offset},{$windowsize}";
		$this->res = $this->sourcedb->query($qry);
	}

	function getNextMember()
	{
		$row = $this->res->fetchRow(DB_FETCHMODE_ASSOC);
		if(!$row)
			return null;

		$retrow['user_ID'] = &$row['user_ID'];
		$retrow['userid'] = &$row['userid'];
		$retrow['mgroup'] = &$row['mgroup'];
                // Secondary groups
                if(!empty($row['mgroup2'])) {
                    $retrow['mgroup2'] = $row['mgroup2'];
                }
                if(!empty($row['mgroup3'])) {
                    $retrow['mgroup3'] = $row['mgroup3'];
                }
                if(!empty($row['mgroup4'])) {
                    $retrow['mgroup4'] = $row['mgroup4'];
                }
                //
                $retrow['password'] = &$row['password'];
		$retrow['reg_date'] = &$row['reg_date'];
		$retrow['in_birthday'] = &$row['in_birthday'];
		$retrow['email'] = &$row['email'];
		$retrow['avatar'] = &$row['avatar'];
		$retrow['last_action'] = &$row['last_action'];
		$retrow['last_session'] = &$row['last_session'];
		$retrow['user_posts'] = &$row['user_posts'];
/* @todo Improvement: Add pm counter to n2 */
		$retrow['pms'] = $row['pms'];
		$retrow['in_aim'] = &$row['aim_name'];
		$retrow['in_msn'] = &$row['in_msn'];
		$retrow['in_icq'] = &$row['in_icq'];
		$retrow['in_yahoo'] = &$row['in_yahoo'];
		$retrow['in_location'] = &$row['in_location'];
		$retrow['in_www'] = &$row['in_www'];
		$retrow['in_interests'] = &$row['in_interests'];
                // Deprecated
		$retrow['skinid'] = '';
		$retrow['signature'] = $this->_t($row['signature']);

		return $retrow;
	}
}
?>
