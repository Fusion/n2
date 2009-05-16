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
## ************** CONVERSATION CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Conversation extends Object {
	private $convoid, $info;
	private $USERDATA;

	// Constructor
	public function __construct($id = '', $convoinfo = '') {
		global $lang;

		if(!empty($convoinfo) AND is_array($convoinfo)) {
			$this->info = $convoinfo;
			$this->convoid = $this->info['convoid'];
		}

		else if(!empty($id)) {
			$this->convoid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		$this->info['users'] = @unserialize($this->info['users']);
		$this->info['usersData'] = @unserialize($this->info['usersData']);
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('personal_convo', 'convoid', $this->convoid, '', true, true);

		// now delete all messages, attachments, etc
		new Delete('personal_msg', 'convoid', $this->convoid, '', true, true);
		new Delete('personal_convodata', 'convoid', $this->convoid, '', true, true);
		//new Delete('attachments', 'threadid', $this->threadid, '', true, true);
	}

	// deletes from CURRENT user
	// this will transfer over to destroy if only one user remains
	public function liteDestroy() {
		global $User, $query, $wtcDB;

		$left = $this->getUserInfo();

		// only one?
		if(count($left) == 1) {
			$this->destroy();
		}

		// just the delete the user from the convo data...
		new Query($query['personal_convodata']['delete'], Array(
			1 => $this->convoid,
			2 => $User->info['userid']
		));
	}

	// Updates conversation... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		// find and extract user data
		$temp = '';
		if(isset($arr['users'])) {
			$temp = $arr['users'];
			unset($arr['users']);
		}

		// add to current info too...
		if(count($arr)) {
			foreach($arr as $key => $val) {
				if(isset($this->info[$key])) {
					$this->info[$key] = $val;
				}
			}

			$update = $wtcDB->massUpdate($arr);

			// Execute!
			new Query($query['personal_convo']['update'], Array(1 => $update, 2 => $this->convoid), 'query', false);
		}

		// now update the user data
		if(is_array($temp)) {
			$current = $this->getUserInfo();

			foreach($temp as $userid => $info) {
				if(isset($current[$userid])) {
					new Query($query['personal_convodata']['update'], Array(
						1 => $info['folderid'],
						2 => $info['lastRead'],
						3 => $info['hasAlert'],
						4 => $info['username'],
						5 => $userid,
						6 => $this->convoid
					));
				}

				else {
					new Query($query['personal_convodata']['insert'], Array(
						1 => $this->convoid,
						2 => $userid,
						3 => $info['folderid'],
						4 => $info['lastRead'],
						5 => $info['hasAlert'],
						6 => $info['username']
					));
				}
			}
		}
	}

	// moves to a new folder
	public function move($folderid) {
		global $User;

		// get the folder...
		$Folder = new Folder($folderid);

		// uh oh!
		if($User->info['userid'] != $Folder->getUserId() AND $Folder->getUserId()) {
			return false;
		}

		// now do the moving... just update the user record in convodata
		$curData = $this->getCurrentUserInfo();

		// bleh... wasteful!
		if($curData['folderid'] == $Folder->getFolderId()) {
			return true; // pretend we moved it
		}

		$curData['folderid'] = $Folder->getFolderId();
		$updating[$User->info['userid']] = $curData;
		$this->update(Array('users' => $updating));

		return true;
	}

	// Accessors
	public function getConvoId() {
		return $this->convoid;
	}

	public function getTitle() {
		return $this->info['title'];
	}

	public function getUserInfo() {
		global $query, $wtcDB;

		$getInfo = new Query($query['personal_convodata']['get_convo'], Array(1 => $this->convoid));
		$retval = Array();

		while($info = $getInfo->fetchArray()) {
			$retval[$info['userid']] = $info;

			if(!isset($this->USERDATA[$info['userid']])) {
				$this->USERDATA[$info['userid']] = $info;
			}
		}

		return $retval;
	}

	public function getCurrentUserInfo() {
		global $query, $wtcDB, $User;

		// make sure we don't already have it...
		if(isset($this->USERDATA[$User->info['userid']])) {
			return $this->USERDATA[$User->info['userid']];
		}

		else {
			$getInfo = new Query($query['personal_convodata']['get_convoUser'], Array(1 => $this->convoid, 2 => $User->info['userid']));
			$retval = $getInfo->fetchArray();
			$this->USERDATA[$User->info['userid']] = $retval;
		}

		return $retval;
	}

	public function getMessages() {
		return $this->info['messages'];
	}

	public function getTimeline() {
		return $this->info['convoTimeline'];
	}

	public function getLastReplyDate() {
		return $this->info['last_reply_date'];
	}

	public function getLastReplyMessageId() {
		return $this->info['last_reply_messageid'];
	}

	public function getLastReplyUsername() {
		return $this->info['last_reply_username'];
	}

	public function getLastReplyUserId() {
		return $this->info['last_reply_userid'];
	}

	public function isRead() {
		global $User;

		$current = $this->getCurrentUserInfo();

		if($current['lastRead'] > $this->getLastReplyDate()) {
			return true;
		}

		return false;
	}

	public function showAlert() {
		global $User;

		$current = $this->getCurrentUserInfo();

		if($current['lastRead'] <= $this->getLastReplyDate() AND !$current['hasAlert']) {
			return true;
		}

		return false;
	}

	public function getInfo() {
		return $this->info;
	}

	// checks if the current user viewing is viable...
	public function canRead() {
		global $User, $query, $wtcDB;

		// get all the users...
		$properUsers = $this->getUserInfo();

		if(!isset($properUsers[$User->info['userid']])) {
			return false;
		}

		return true;
	}

	// gets a comma separated list of users in the convo
	public function getUserList() {
		global $before, $userid, $username, $SESSURL;

		$retval = '';
		$before = '';

		foreach($this->getUserInfo() as $userid => $info) {
			$username = $info['username'];
			$temp = new StyleFragment('personal_convoMembers');
			$retval .= $temp->dump();

			$before = ', ';
		}

		return $retval;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB, $User;

		$getConvo = new Query($query['personal_convo']['get'], Array(1 => $this->convoid));

		$this->info = parent::queryInfoById($getConvo);
	}


	// Static Methods
	// Public
	// inserts conversation... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$temp = '';
		if(isset($arr['users'])) {
			$temp = $arr['users'];
			unset($arr['users']);
		}

		$db = $wtcDB->massInsert($arr);

		new Query($query['personal_convo']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		$retval = $wtcDB->lastInsertId();

		// extract the 'users' data, insert, then unset...
		if(is_array($temp)) {
			foreach($temp as $userid => $info) {
				new Query($query['personal_convodata']['insert'], Array(
					1 => $retval,
					2 => $userid,
					3 => $info['folderid'],
					4 => $info['lastRead'],
					5 => $info['hasAlert'],
					6 => $info['username']
				));
			}
		}

		return $retval;
	}
}
