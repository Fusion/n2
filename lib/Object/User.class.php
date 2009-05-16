<?php
/*
 * wtcBB Community Software (Open Source Freeware Version)
 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software Solutions.
 * http://www.wtcbb.com
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * http://www.wtcbb.com/wtcbb-license-general-public-license 
 *
 * For support visit: http://forums.wtcbb.com
 *
 * Powered by wtcBB - http://www.wtcbb.com
 * Protected by ChargebackFile - http://www.chargebackfile.com
 * 
 */
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## ******************* USER CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class User extends Object {
	public $info, $group, $perm; // lots of info for a user; don't need accessors for each bit of info! whew...
	protected $userid, $username, $admin, $userReq, $doError, $javascript;
	private $permUsage;

	// static vars that hold information for all users
	// check vars... so we don't run a query more than once!
	protected static $gotUsertitles = false, $usertitles = NULL;

	// Constructor - Allow already created info to exist (skip query)
	public function __construct($id = '', $name = '', $userinfo = false, $special = false, $suppress = false) {
		global $lang, $query, $groups, $bboptions;

		$this->admin = NULL;
		$this->userReq = $special;
		$this->doError = $suppress;
		$this->group = Array();
		$this->perm = Array();
		$this->permUsage = Array();

		// hmmm... both empty? bad...
		if($id != 0 AND empty($id) AND empty($name) AND !$userinfo) {
			if($special) {
				return false;
			}

			new WtcBBException($lang['error_noUsernameOrId']);
		}

		// what if info is already available?
		// no need to query...
		if(!$userinfo) {
			if($id == 0 AND $id != '') {
				$this->userid = $id;
				$this->username = 'Guest';
				$this->info = Array();
			}

			else if(empty($id)) {
				$this->username = $name;
				$this->queryInfoByUsername();
			}

			else {
				$this->userid = $id;
				$this->queryInfoById();
			}
		}

		else {
			$this->info = $userinfo;
		}

		$this->username = $this->info['username'];
		$this->userid = $this->info['userid'];
		$this->info['secgroupids'] = unserialize($this->info['secgroupids']);
		$this->info['blockedForums'] = unserialize($this->info['blockedForums']);

		// bad groupid?
		if(!$this->info['usergroupid'] OR !$this->info['userid']) {
			$this->info['userid'] = 0;
			$this->info['username'] = 'Guest';
			$this->info['usergroupid'] = 1;
		}

		$this->group = $groups[$this->info['usergroupid']];

		// censor the sig
		$this->info['sig'] = censor($this->info['sig']);

		// if user request... log ip...
		// and make sure it's a user req
		if(!$this->info['loggedIps'] AND $this->userReq AND $this->userid) {
			new Query($query['user']['log_ip'], Array(1 => $_SERVER['REMOTE_ADDR'], $this->userid));
		}
	}

	// Updates user... Accepts an array of fields and values
	public function update($arr, $suppressError = false) {
		global $query, $wtcDB, $lang;

		if($this->untouchable()) {
			if($suppressError) {
				exit;
			}

			else {
				new WtcBBException($lang['admin_error_untouchable']);
			}
		}

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['user']['update'], Array(1 => $update, 2 => $this->userid), 'query', false);

		if(ADMIN) {
			Admin::addDelAdmins();
		}
	}

	// This updates custom profile fields...
	public function updateCustom($arr, $suppressError = false) {
		global $query, $wtcDB, $lang;

		if($this->untouchable()) {
			if($suppressError) {
				exit;
			}

			else {
				new WtcBBException($lang['admin_error_untouchable']);
			}
		}

		// do we wanna insert, or update?
		$haveRows = new Query($query['userinfo_pro']['check'], Array(1 => $this->userid));
		$res = $wtcDB->fetchArray($haveRows);

		// we have a row already, update
		if($res['total']) {
			$update = $wtcDB->massUpdate($arr);

			// Execute!
			new Query($query['userinfo_pro']['update'], Array(1 => $update, 2 => $this->userid), 'query', false);
		}

		// we need to insert a new row
		else {
			$arr['user_id'] = $this->userid;
			$db = $wtcDB->massInsert($arr);

			new Query($query['userinfo_pro']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		}
	}

	/**
	 * Deletes user... Does not provide GUI...
	 * Just the database part... This takes care
	 * of everything the user took part in (personal
	 * messages, subscriptions, etc
	 */
	public function destroy() {
		global $query, $wtcDB, $lang;

		if($this->untouchable()) {
			new WtcBBException($lang['admin_error_untouchable']);
		}

		// run our queries...
		new Delete('logger_admin', 'log_userid', $this->userid, '', true, true);
		new Delete('logger_ips', 'userid', $this->userid, '', true, true);
		new Delete('logger_mods', 'log_userid', $this->userid, '', true, true);
		new Delete('moderators', 'userid', $this->userid, '', true, true);
		new Delete('personal_folders', 'userid', $this->userid, '', true, true);
		new Delete('subscribe', 'userid', $this->userid, '', true, true);
		new Delete('userinfo', 'userid', $this->userid, '', true, true);
		new Delete('userinfo_ban', 'userid', $this->userid, '', true, true);

		Admin::addDelAdmins();
	}

	// Accessors
	// whether admin or not...
	public function isAdmin() {
		global $groups;

		return ($groups[$this->info['usergroupid']]->info['admin'] == 1) ? true : false;
	}

	// whether global mod or not...
	public function isGlobal() {
		global $groups;

		return ($groups[$this->info['usergroupid']]->info['global'] == 1) ? true: false;
	}

	// finds whether user is a mod or not...
	public function isMod($forumid = 0) {
		global $moderators;

		// a guest? o_0
		if(!$this->info['userid']) {
			return false;
		}

		// global or admin?
		if($this->isAdmin() OR $this->isGlobal()) {
			return true;
		}

		// make sure we have a good array...
		if(!$moderators OR !count($moderators)) {
			return false;
		}

		// okay... we know we have an array
		// but check to see if user IS a mod
		// loop through array if no specific forumid
		if(!$forumid) {
			foreach($moderators as $fid => $info) {
				if(isset($moderators[$fid][$this->info['userid']])) {
					return true;
				}
			}

			// nope
			return false;
		}

		else {
			if(!isset($moderators[$forumid][$this->info['userid']])) {
				return false;
			}
		}

		// good to go!
		return true;
	}

	// check if super admin
	public function isSuperAdmin() {
		global $superAdministrators;

		// no super admins?
		if(empty($superAdministrators)) {
			return false;
		}

		// split
		$kaboom = split(',', $superAdministrators);

		if(!in_array($this->info['userid'], $kaboom)) {
			return false;
		}

		return true;
	}

	// finds whether or not user is untouchable
	public function untouchable() {
		global $uneditableUsers;

		// none?
		if(empty($uneditableUsers)) {
			return false;
		}

		// split
		$kaboom = split(',', $uneditableUsers);

		if(!in_array($this->info['userid'], $kaboom)) {
			return false;
		}

		return true;
	}

	// gets secondary group IDs
	public function getSecGroups() {
		return $this->info['secgroupids'];
	}

	// gets the HTML username
	public function getHTMLName() {
		global $groups;

		// first check the username HTML...
		if(!empty($this->info['htmlBegin']) OR !empty($this->info['htmlEnd'])) {
			return $this->info['htmlBegin'] . $this->info['username'] . $this->info['htmlEnd'];
		}

		// usergroup HTML then...
		else if(!empty($this->group->info['htmlBegin']) OR !empty($this->group->info['htmlEnd'])) {
			return $this->group->info['htmlBegin'] . $this->info['username'] . $this->group->info['htmlEnd'];
		}

		// just return the username
		return $this->info['username'];
	}

	// gets the user title (in case one isn't set o_0)
	public function getTitle() {
		if(empty($this->info['usertitle'])) {
			// try it...
			$maybe = User::getUserTitle(0, $this->info['posts'], '', $this->info['usergroupid']);

			// bah
			$retval = $maybe;
		}

		else {
			$retval = $this->info['usertitle'];
		}

		// wtcspecialchar or no?
		if($this->info['usertitle_opt'] == 2) {
			$retval = wtcspecialchars($retval);
		}

		return $retval;
	}

	// checks a mod permission... just pass forum id
	public function modAction($perm, $forumid) {
		global $moderators;

		// not a moderator? o_0
		if(!$this->isMod($forumid)) {
			return false;
		}

		// admin or global?
		if($this->isAdmin() OR $this->isGlobal()) {
			return true;
		}

		// okay... so we have a valid mod
		if(!$moderators[$forumid][$this->info['userid']]->perm($perm)) {
			return false;
		}

		// good to go!
		return true;
	}

	// this is your global method for
	// checking a usergroup and/or forum permission
	public function check($perm, $forumid = 0) {
		global $groups, $perms;

		// cached?
		if(isset($this->permUsage[$perm][$forumid])) {
			return $this->permUsage[$perm][$forumid];
		}

		// nothin?
		if(!isset($this->group->info[$perm])) {
			return false;
		}

		// get some info...
		$secGroups = $this->getSecGroups();
		$groupid = $this->info['usergroupid'];

		// max wins!
		$retval = 0;

		// plain old primary group perm...
		if(!$forumid OR ($forumid AND !isset($perms[$forumid][$groupid]->info[$perm]))) {
			$retval = $this->group->info[$perm];
		}

		// plain old prim group forum perms
		else if($forumid AND isset($perms[$forumid][$groupid]->info[$perm])) {
			$retval = $perms[$forumid][$groupid]->info[$perm];
		}

		// we should never be here
		else {
			_DEBUG('WTF!?: ' . $perm . ' => ' . $forumid);
		}

		// secondary groups... bah
		if(is_array($secGroups)) {
			// must loop through each one
			foreach($secGroups as $secGroupId) {
				// should be the same procedure as above...
				// except applied to secondary groups

				// okay... so forum perms or not?
				// no forum perms
				if(!$forumid OR ($forumid AND !isset($perms[$forumid][$secGroupId]->info[$perm]))) {
					if($groups[$secGroupId]->info[$perm] > $retval) {
						$retval = $groups[$secGroupId]->info[$perm];
					}
				}

				// forum perms
				else if($forumid AND isset($perms[$forumid][$secGroupId]->info[$perm])) {
					if($perms[$forumid][$secGroupId]->info[$perm] > $retval) {
						$retval = $perms[$forumid][$secGroupId]->info[$perm];
					}
				}

				// we should never be here
				else {
					_DEBUG('WTF!?: ' . $perm . ' => ' . $forumid);
				}
			}
		}

		// cache results
		// we know it isn't set... if it was, we wouldn't be here
		$this->permUsage[$perm][$forumid] = $retval;

		// return
		return $retval;
	}

	// can a user view this forum?
	public function canViewForum($forumid) {
		global $User, $forums, $orderedForums;

		// set this once, so we don't run it again
		$hasAccess = $this->hasForumAccess($forumid);
		$hasPermBoard = $User->check('canViewBoard', $forumid);

		// make sure we have permissions...
		if((!$hasPermBoard AND $hasAccess !== true) OR $hasAccess === false) {
			return false;
		}

		if(!$forums[$forumid]->isActive()) {
			return false;
		}

		// need to check a weird case...
		// a child forum is enabled for viewing (user forum access)
		// yet a parent cannot be viewed via forum perms
		if($hasAccess === true AND !$hasPermBoard) {
			$backForumIter = new ParentForumIterator($forumid);
			$view = true;

			foreach($backForumIter as $par) {
				if(!$User->check('canViewBoard', $par->info['forumid']) AND $User->canViewForum($par->info['forumid']) !== true) {
					$view = false;
					break;
				}
			}

			if(!$view) {
				return false;
			}
		}

		return true;
	}

	// validates user session
	public function validateSession($cookPass) {
		if($this->info['password'] != $cookPass) {
			return false;
		}

		return true;
	}

	// gets user rank... and returns the HTML required
	public function getUserRank() {
		global $wtcDB, $query, $lang;

		if(!$this->check('showRanks')) {
			return false;
		}

		$rank = RankImage::findRank($this->info['posts']);
		$retval = '';

		// uh oh!
		if(!($rank instanceof RankImage)) {
			return false;
		}

		for($x = 1; $x <= $rank->getImgRepeat(); $x++) {
			$retval .= '<img src="' . $rank->getImgPath() . '" alt="' . $lang['user_rankAlt'] . '" />';
		}

		return $retval;
	}

	// this does a flood check... just a simple yes/no...
	// you decide what to do with it
	public function flood() {
		global $bboptions, $query, $wtcDB;

		// assign retval...
		$retval = true;

		// overridden??
		if($this->check('overrideFlood')) {
			$retval = false;
		}

		// first get session data...
		$getSession = new Query($query['sessions']['get_noUser'], Array(1 => SID));

		if($wtcDB->numRows($getSession)) {
			$session = $wtcDB->fetchArray($getSession);
			$difference = NOW - $session['lastaction'];

			if($difference >= $bboptions['floodcheck']) {
				$retval = false;
			}
		}

		// if we're checking for flood, then that means it is an action!
		// so update the action...
		new Query($query['sessions']['update_action'], Array(1 => NOW, 2 => SID));

		return $retval;
	}

	// Protected Methods
	// can view a forum (checks user forum access)
	protected function hasForumAccess($forumid) {
		// no blocked forums, true
		if(!is_array($this->info['blockedForums']) OR !count($this->info['blockedForums'])) {
			return NULL;
		}

		else if(isset($this->info['blockedForums'][$forumid]) AND !$this->info['blockedForums'][$forumid]) {
			return false;
		}

		// inheritance...
		else if(!isset($this->info['blockedForums'][$forumid])) {
			$backForumIter = new ParentForumIterator($forumid);

			foreach($backForumIter as $forum) {
				if(isset($this->info['blockedForums'][$forum->info['forumid']])) {
					if($this->info['blockedForums'][$forum->info['forumid']]) {
						return true;
					}

					else {
						return false;
					}
				}
			}

			// nothin?
			return NULL;
		}

		// this means it's a YES...
		// but we need to make sure that no parent
		// forum has disabled accesss... "NO" rules all...
		else {
			$backForumIter = new ParentForumIterator($forumid);

			foreach($backForumIter as $forum) {
				if(isset($this->info['blockedForums'][$forum->info['forumid']]) AND !$this->info['blockedForums'][$forum->info['forumid']]) {
					return false;
				}
			}

			return true;
		}
	}

	// gets user info if ID is given
	protected function queryInfoById($obj = '') {
		global $query, $lang, $wtcDB;

		if(!empty($obj)) {
			$this->info = parent::queryInfoById($obj);

			if($this->info instanceof WtcBBException) {
				return false;
			}

			return $this->info;
		}

		else {
			if($this->userReq) {
				$getUser = new Query($query['global']['get_user_byId_req'], Array(1 => $this->userid));
			}

			else {
				$getUser = new Query($query['global']['get_user_byId'], Array(1 => $this->userid));
			}

			$this->info = parent::queryInfoById($getUser);

			if($this->info instanceof WtcBBException) {
				return false;
			}
		}
	}

	// gets user info if there's no id, but username given
	protected function queryInfoByUsername($obj = '') {
		global $query, $lang, $wtcDB;

		if(!empty($obj)) {
			$getUser = $obj;
		}

		else {
			$getUser = new Query($query['global']['get_user_byUsername'], Array(1 => $this->username));
		}

		if(!$wtcDB->numRows($getUser) AND !$this->doError) {
			if($this->userReq) {
				return false;
			}

			new WtcBBException($lang['error_userDoesNotExist']);
		}

		$this->info = $wtcDB->fetchArray($getUser);
	}


	// Static Methods
	// Public
	// inserts user... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['user']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		$retval = $wtcDB->lastInsertId();

		Admin::addDelAdmins();

		return $retval;
	}

	// Method to query for users
	public static function searchUsers($arr, $sql = '', $force = false, $limit = false, $tacky = '') {
		global $wtcDB, $query, $lang;

		$return = Array();
		$queryStr = '';
		$limitTack = '';

		if(is_array($limit)) {
			$limitTack = ' LIMIT ' . $limit['start'] . ', ' . $limit['length'];
		}

		if(empty($sql)) {
			if(count($arr)) {
				foreach($arr as $field => $v) {
					if(is_numeric($v)) {
						$queryStr .= $field . ' = "' . $wtcDB->escapeString($v) . '" AND ';
					}

					else {
						$queryStr .= $field . ' LIKE "' . $wtcDB->escapeString($v) . '%" AND ';
					}
				}

				// remove ending stuff
				$queryStr = preg_replace('/AND\s$/', '', $queryStr);

				$find = new Query($query['user']['searchUsers'] . $tacky . $limitTack, Array(1 => $queryStr), 'query', false);
			}

			else {
				$find = new Query($query['user']['all_users'] . $tacky . $limitTack);
			}
		}

		else {
			$find = new Query($sql . $tacky . $limitTack);
		}


		if(!$wtcDB->numRows($find)) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		if($wtcDB->numRows($find) == 1) {
			$result = $wtcDB->fetchArray($find);
			$return["-1"] = $result;
		}

		else {
			while($result = $wtcDB->fetchArray($find)) {
				$return[$result['userid']] = $result;
			}
		}

		if(empty($sql) AND !$force) {
			return $return;
		}

		else {
			return Array('return' => $return, 'ref' => $find);
		}
	}

	// Methods to query for all secondary users in specified group
	public static function getSecUsers($groupid) {
		global $wtcDB, $query, $lang;

		$return = Array();

		$find = new Query($query['usergroups']['get_secUsers'], Array(1 => $groupid));

		if(!$wtcDB->numRows($find)) {
			new WtcBBException($lang['admin_error_noResults']);
		}

		if($wtcDB->numRows($find) == 1) {
			$result = $wtcDB->fetchArray($find);
			$return["-1"] = $result;
		}

		else {
			while($result = $wtcDB->fetchArray($find)) {
				$return[$result['userid']] = $result;
			}
		}

		return $return;
	}

	/**
	 * Will not get user titles from DB unless
	 * you call this method... only query when
	 * necessary... If array already exists, don't
	 * query again
	 */
	public static function getUserTitle($titleOpt, $posts, $possibleTitle, $groupid) {
		global $wtcDB, $groups;

		$titles = User::formUserTitles();

		if(!$titleOpt AND (count($titles) OR !empty($groups[$groupid]->info['usertitle']))) {
			// COME BACK TO FOR USERGROUPS! \\
			if(!empty($groups[$groupid]->info['usertitle'])) {
				return $groups[$groupid]->info['usertitle'];
			}

			else {
				for($i = 0; $i < count($titles); $i++) {
					if(($i + 1) == count($titles) OR ($posts >= $titles[$i]['minPosts'] AND $posts < $titles[$i + 1]['minPosts'])) {
						return $titles[$i]['title'];
					}
				}
			}
		}

		else if($titleOpt AND $groups[$groupid]->info['canUsertitle']) {
			return $possibleTitle; // we htmlspecialchar when we FETCH user title
		}

		// wha whoa...
		else {
			return 'No Usertitle';
		}
	}

	// forms user title array
	public static function formUserTitles() {
		global $wtcDB, $query;

		if(User::$gotUsertitles) {
			return User::$usertitles;
		}

		$getTitles = new Query($query['global']['get_usertitles']);
		User::$usertitles = Array();

		if($wtcDB->numRows($getTitles)) {
			while($title = $wtcDB->fetchArray($getTitles)) {
				User::$usertitles[] = $title;
			}
		}

		User::$gotUsertitles = true;
		return User::$usertitles;
	}

	// gets user's online... index, thread, or forum
	// this will also put $members, $guests, and $robots into global view
	public static function getOnlineUsers($forum = 0, $thread = 0) {
		global $bboptions, $query, $before, $userObj, $SESSURL;
		global $members, $guests, $robots, $lang;

		// viewing thread/forum
		if($thread OR $forum) {
			$sessions = new Query($query['sessions']['get_all_inThreadForum'],
				Array(
					1 => ($forum ? $lang['user_forums'] : $lang['user_thread'])
				)
			);
		}

		// index
		else {
			$sessions = new Query($query['sessions']['get_all']);
		}

		// formulate bits
		$whoBits = '';
		$before = '';
		$members = 0; $guests = 0; $robots = 0;

		// form robots array
		$detect = preg_split('/(\r\n|\r|\n)/', $bboptions['robotDetect']);
		$desc = preg_split('/(\r\n|\r|\n)/', $bboptions['robotDesc']);

		// if someone is viewing, which they are, then we
		// must have rows...
		while($session = $sessions->fetchArray()) {
			// skip if session isn't in thread/forum
			// not correct thread?
			if($thread AND !preg_match('/t=' . $thread . '($|&)/', $session['loc'])) {
				continue;
			}

			// not correct forum?
			if($forum AND !preg_match('/f=' . $forum . '($|&)/', $session['loc'])) {
				continue;
			}

			$userObj = new User('', '', $session);

			// member, guest, robot count
			if($userObj->info['userid']) {
				$members++;
			}

			else {
				foreach($detect as $index => $bot) {
					if(stripos($userObj->info['userAgent'], $bot) !== false) {
						$robots++;
						$guests--;

						$userObj->info['username'] = $desc[$index];
					}
				}

				$guests++;
			}

			if($userObj->info['userid'] > 0) {
				$temp = new StyleFragment('forumhome_whoBit');
				$whoBits .= $temp->dump();
				$before = ', ';
			}
		}

		// return the bits!
		return $whoBits;
	}

	// checks if a user exists or not
	public static function exists($userid = 0, $username = '') {
		global $query, $wtcDB;

		if(!$userid AND !$username) {
			return false;
		}

		if($userid) {
			$check = new Query($query['user']['exists_id'], Array(1 => $userid));
		}

		else {
			$check = new Query($query['user']['exists_username'], Array(1 => $username));
		}

		$result = $check->fetchArray();

		if(!$result['checking']) {
			return false;
		}

		return true;
	}
}
