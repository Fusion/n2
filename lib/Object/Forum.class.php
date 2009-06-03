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
## ******************* CRON CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// handles crons
class Forum extends Object {
	public $info;
	private $forumid;

	// Constructor
	public function __construct($forumid = '', $foruminfo = '') {
		if(!empty($foruminfo) AND is_array($foruminfo)) {
			$this->info = $foruminfo;
			$this->info['urlizedname'] = n2urlize($this->info['name']);
			$this->forumid = $this->info['forumid'];
		}

		else if(!empty($forumid)) {
			$this->forumid = $forumid;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		$this->info['directSubs'] = unserialize($this->info['directSubs']);
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $forums, $orderedForums, $lang;

		// can't delete if it's the only forum left...
		if(count($forums) === 1) {
			new WtcBBException($lang['admin_error_lastForum']);
		}

		// we need to modify parents directSubs...
		if($this->info['parent'] != -1) {
			$parent = $forums[$this->info['parent']];

			if(is_array($parent->info['directSubs'])) {
				foreach($parent->info['directSubs'] as $index => $forumid) {
					if($forumid == $this->forumid) {
						unset($parent->info['directSubs'][$index]);
					}
				}

				// re-update...
				$parent->update(Array('directSubs' => ((count($parent->info['directSubs'])) ? serialize($parent->info['directSubs']) : '')));
			}
		}

		$childIter = new ForumIterator($this->info['forumid']);

		foreach($childIter as $sub) {
			$sub->destroy();
		}

		new Delete('posts', 'forumid', $this->forumid, '', true, true);
		new Delete('threads', 'forumid', $this->forumid, '', true, true);
		new Delete('moderators', 'forumid', $this->forumid, '', true, true);
		new Delete('forums', 'forumid', $this->forumid, '', true, true);

		// we rebuild the cache outside of this method
		// since it's recursive
	}

	// Updates forum... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['forum']['update'], Array(1 => $update, 2 => $this->forumid), 'query', false);

		new Cache('Forums');
	}

	// updates last reply stuff... and post/thread counts
	// iterates through all parent forums too
	public function updateLastReplyAndCounts($lastReply, $thread = false, $increment = 1) {
		// we have the update info, now iterate through parent forums
		if($this->info['parent'] != -1) {
			$forumIter = new ParentForumIterator($this->forumid);

			foreach($forumIter as $forum) {
				// don't forget to add in post counts
				if($increment) {
					$lastReply['posts'] = $forum->info['posts'] + $increment;

					if($thread) {
						$lastReply['threads'] = $forum->info['threads'] + $inrement;
					}
				}

				$forum->update($lastReply);
			}
		}

		if($increment) {
			$lastReply['posts'] = $this->info['posts'] + $increment;

			if($thread) {
				$lastReply['threads'] = $this->info['threads'] + $increment;
			}
		}

		$this->update($lastReply);
	}

	// Accessors
	public function getModerators() {
		global $moderators;

		$retval = Array();

		if(is_array($moderators[$this->forumid])) {
			foreach($moderators[$this->forumid] as $userid => $modObj) {
				$retval[$modObj->getModid()] = $modObj;
			}
		}

		return $retval;
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function isRead() {
		global $bboptions, $User;

		if(!LOGIN) {
			return true;
		}

		return !($User->info['markedRead'] < $this->info['last_reply_date'] AND $this->info['last_reply_date'] >= $bboptions['readTimeout'] AND (!$this->info['dateRead'] OR ($this->info['dateRead'] AND $this->info['dateRead'] < $this->info['last_reply_date'])));
	}

	public function isSubscribed() {
		if(!isset($this->info['subid']) OR !$this->info['subid']) {
			return false;
		}

		// must be subscribed
		return true;
	}

	public function isActive() {
		// check for activeness...
		if(!$this->info['isAct']) {
			return false;
		}

		else {
			$parIter = new ParentForumIterator($this->info['forumid']);

			foreach($parIter as $par) {
				if(!$par->info['isAct']) {
					return false;
				}
			}
		}

		return true;
	}

	public function goToLink() {
		if(!empty($this->info['link'])) {
			// update hits
			$this->update(Array('linkCount' => ($this->info['linkCount'] + 1)));

			// send'em!
			header('Location: ' . $this->info['link']);
		}
	}

	// gets child ids as CSV
	public function getChildIds($currIdTack = true) {
		$ids = ''; $before = '';

		$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($this->info['forumid']), true);

		foreach($forumIter as $forum) {
			$ids .= $before . $forum->info['forumid'];
			$before = ',';
		}

		$ids .= $before . $this->info['forumid'];

		return $ids;
	}

	// gets parent ids as CSV
	public function getParentIds($currIdTack = true) {
		$ids = ''; $before = '';

		$forumIter = new ParentForumIterator($this->info['forumid']);

		foreach($forumIter as $forum) {
			$ids .= $forum->info['forumid'];
			$before = ',';
		}

		$ids .= $before . $this->info['forumid'];

		return $ids;
	}

	// advanced accessors...
	// mainly permissions
	// can post a thread?
	public function canPost() {
		global $User;

		if($User->check('canPostThreads', $this->forumid)) {
			return true;
		}

		return false;
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB, $User;

		$getForum = new Query($query['forum']['get'], Array(1 => $User->info['userid'], $User->info['userid'], $this->forumid));

		$this->info = parent::queryInfoById($getForum);
		$this->info['urlizedname'] = n2urlize($this->info['name']);
	}


	// Public Methods
	// builds the forum jump bits
	public static function buildForumJump() {
		global $forums, $orderedForums, $perms, $User, $wtcDB, $query, $_CACHE, $solidPerms;
		global $fid, $indent, $forum;

		ForumPerm::init();
		$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

		foreach($forumIter as $forum) {
			$fid = $forum->info['forumid'];

			if(!$forum->isActive()) {
				continue;
			}

			$canView = $User->canViewForum($fid);

			// this checks forum permissions, usergroups, and user forum access
			if(!$canView) {
				continue;
			}

			$indent = str_repeat('-', $forumIter->getDepth());

			$temp = new StyleFragment('forumJump_bit');
			$forumBits .= $temp->dump();

			$first = false;
		}

		return $forumBits;
	}

	// this will update a user's subscription (lastView)
	// precondition is that user is subscribed
	public function updateSubscription() {
		global $query;

		new Query($query['subscribe']['update_lastView'],
			Array(
				1 => NOW,
				2 => $this->info['subid']
			)
		);
	}

	// subscribes/unsubscires from forum
	public function subUnsub() {
		global $User, $query;

		// if the user is subscribed, unsubscribe
		if($this->isSubscribed()) {
			$this->unsubscribe();
		}

		else {
			$this->subscribe();
		}
	}

	// helper methods for above
	// subscribes to forum... obviously
	public function subscribe() {
		global $User, $query;

		// just insert
		Subscription::insert(
			Array(
				'userid' => $User->info['userid'],
				'forumid' => $this->getForumId(),
				'lastView' => NOW,
				'lastEmail' => 0,
				'subType' => 'normal'
			)
		);
	}

	// unsubscribes to this forum
	public function unsubscribe() {
		global $query;

		// just delete
		$sub = new Subscription($this->info['subid']);
		$sub->destroy();
	}

	// this will remove thread redirects
	public function removeRedirects() {
		global $query;

		// just do a delete... actually
		new Query($query['threads']['delete_redirects'], Array(1 => $this->forumid));
	}

	// Static Methods
	// Public
	// constructs a select menu of forums (with perms)
	public static function constructForumSelect($multiple2 = false) {
		global $User, $forums, $perms, $groups, $moderators, $forumName, $fid, $forumSelectBits, $depthMarker, $isCat, $multiple;

		$multiple = $multiple2;

		// iterate through forums...
		$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
		$forumSelectBits = '';

		foreach($forumIter as $forum) {
			$fid = $forum->info['forumid'];
			$forumName = $forum->info['name'];

			/*if($forumIter->getDepth() > 1) {
				continue;
			}*/

			// this checks forum permissions, usergroups, and user forum access
			if(!$User->canViewForum($fid)) {
				continue;
			}

			// do the depth marker...
			if($forumIter->getDepth()) {
				$depthMarker = str_repeat('-', $forumIter->getDepth()) . ' ';
			}

			else {
				$depthMarker = '';
			}

			$isCat = $forum->info['isCat'];

			$temp = new StyleFragment('forumSelect_bit');
			$forumSelectBits .= $temp->dump();
		}

		$temp = new StyleFragment('forumSelect');

		return $temp->dump();
	}

	// inserts forum... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query, $forums;

		$arr['linkCount'] = 0;
		$arr['dateMade'] = NOW;
		$arr['last_reply_username'] = '';
		$arr['last_reply_userid'] = -1;
		$arr['last_reply_date'] = 0;
		$arr['last_reply_threadid'] = 0;
		$arr['last_reply_threadtitle'] = '';
		$arr['posts'] = 0;
		$arr['threads'] = 0;

		// alright, lets get the depth...
		if($arr['parent'] == -1) {
			$arr['depth'] = 1;
		}

		else {
			$arr['depth'] = $forums[$arr['parent']]->info['depth'] + 1;
		}

		$db = $wtcDB->massInsert($arr);

		new Query($query['forum']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		// get last insert id...
		$newForumId = $wtcDB->lastInsertId();

		// now, let's modify the parent's directSubs...
		if(isset($forums[$arr['parent']])) {
			$directSubs = $forums[$arr['parent']]->info['directSubs']; // already unserialized

			// add forum id to subs
			$directSubs[] = $newForumId;

			// serialize and update!
			$update['directSubs'] = serialize($directSubs);

			$forums[$arr['parent']]->update($update);
		}

		new Cache('Forums');
	}

	// inits the forum arrays
	public static function init($info = '') {
		global $forums, $orderedForums, $query, $wtcDB, $User;

		$forums = Array();
		$orderedForums = Array();

		$forumsQ = new Query($query['forum']['get_all'], Array(1 => $User->info['userid'], $User->info['userid']));
		$forums = Array();
		$orderedForums = Array();

		while($forum = $wtcDB->fetchArray($forumsQ)) {
			$forums[$forum['forumid']] = new Forum('', $forum);
			$orderedForums[$forum['parent']][$forum['forumid']] = $forum['forumid'];
		}
	}
}
