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
## ************** ANNOUNCEMENT CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Announcement extends Object {
	public $info;
	private $announceid, $forumid, $userid;

	// Constructor
	public function __construct($id = '', $announceinfo = '') {
		global $lang;

		if(!empty($announceinfo) AND is_array($announceinfo)) {
			$this->info = $announceinfo;
			$this->announceid = $this->info['announceid'];
		}

		else if(!empty($id)) {
			$this->announceid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// asign forumid and usergroupid
		$this->userid = $this->info['userid'];
		$this->forumid = $this->info['forumid'];
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('announcements', 'announceid', $this->announceid, 'admin.php?file=announce');
	}

	// Updates announce... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['announce']['update'], Array(1 => $update, 2 => $this->announceid), 'query', false);
	}

	// Accessors
	public function getTitle() {
		return $this->info['title'];
	}

	public function getForumid() {
		return $this->forumid;
	}

	public function getUserid() {
		return $this->userid;
	}

	public function getAnnounceid() {
		return $this->announceid;
	}

	public function getStarter() {
		$userObj = new User('', '', $this->info);
		$retval = $userObj->getHTMLName();

		if(empty($retval) OR !$this->info['userid']) {
			return $this->info['username'];
		}

		else {
			return $retval;
		}
	}

	public function getStarterId() {
		return $this->info['userid'];
	}

	public function getViews() {
		return $this->info['views'];
	}

	public function lastUpdated() {
		return $this->info['dateUpdated'];
	}

	public function getMessage() {
		return $this->info['message'];
	}

	public function showBBCode() {
		return $this->info['parseBBCode'];
	}

	public function showSmilies() {
		return $this->info['parseSmilies'];
	}

	public function showHtml() {
		return $this->info['parseHtml'];
	}

	public function getInfo() {
		return $this->info;
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getAnnounce = new Query($query['announce']['get'], Array(1 => $this->announceid));

		$this->info = parent::queryInfoById($getAnnounce);
	}


	// Static Methods
	// Public
	// inserts announcement... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['announce']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
	}

	// finds inherited announcements
	public static function getInheritAnnounce($announce) {
		global $forums, $orderedForums;

		$solidAnnounce = $announce;

		// create forum iter
		if(is_array($announce)) {
			$outsideForumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);

			// we need to go through forums in order, so we have
			// overrides placed correctly
			foreach($outsideForumIter as $forumObj) {
				if(!isset($announce[$forumObj->info['forumid']])) {
					continue;
				}

				foreach($announce[$forumObj->info['forumid']] as $stamp => $info) {
					if(!$info['inherit']) {
						continue;
					}

					$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($info['forumid']), true);

					foreach($forumIter as $forum) {
						// errm... make sure we don't have an announcement overriding this one!
						// only check non-inherited announcements... as we want inherited announcements to be overridden!
						if(isset($solidAnnounce[$forum->info['forumid']][$info['dateUpdated']])) {
							continue;
						}

						$announce[$forum->info['forumid']][$info['dateUpdated']] = $info;
					}
				}
			}
		}

		return $announce;
	}
}
