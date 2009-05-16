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
## **************** USERGROUP CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Usergroup extends Object {
	public $info;
	private $groupid, $groupName, $destination;
	
	// Constructor - Allow already created info to exist (skip query)
	public function __construct($id = '', $groupInfo = '') {
		global $lang;
		
		// hmmm... both empty? bad...
		if(empty($id) AND !$groupInfo) {
			new WtcBBException($lang['error_invalidGroupId']);
		}
		
		// what if info is already available?
		// no need to query...
		if(!$groupInfo) {
			$this->groupid = $id;
			$this->queryInfoById();
			$this->groupName = $this->info['title'];
		}

		else {
			$this->groupid = $groupInfo['usergroupid'];
			$this->info = $groupInfo;
			$this->groupName = $this->info['title'];
		}
	}
	
	// Public Methods
	public function update($arr) {
		global $query, $wtcDB, $lang, $_CACHE;
		
		if($this->findTheUntouchables()) {
			new WtcBBException($lang['admin_error_untouchableGroup']);
		}

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['usergroups']['update'], Array(1 => $update, 2 => $this->groupid), 'query', false);
		
		new Cache('Usergroups');	
		
		Admin::addDelAdmins();
	}

	/**
	 * Deletes usergroup... Does not provide GUI...
	 * Just the database part... This will also move users
	 * from the deleted group to a selected group
	 */
	public function destroy() {
		global $query, $wtcDB, $lang, $_CACHE;
		
		if($this->findTheUntouchables()) {
			new WtcBBException($lang['admin_error_untouchableGroup']);
		}

		// run our queries...
		$this->moveUsersToNewGroup($this->destination);
		new Delete('usergroups', 'usergroupid', $this->groupid, '', true, true);
		
		new Cache('Usergroups');
		
		Admin::addDelAdmins();
	}
	
	// moves users to a new group
	public function moveUsersToNewGroup($destination) {
		global $query;
		
		new Query($query['usergroups']['moveUsersToNewGroup'], Array(1 => $destination, $this->groupid));
	}
	
	// Accessors
	public function isBanned() {
		return $this->info['isBanned'];
	}
	
	public function isAdmin() {
		return $this->info['admin'];
	}
	
	public function isGlobal() {
		return $this->info['global'];
	}
	
	public function can($field) {
		return $this->info['can' . $field];
	}
	
	public function override($field) {
		return $this->info['override' . $field];
	}
	
	public function limit($field) {
		return $this->info[$field];
	}
	
	public function show($field) {
		return $this->info['show' . $field];
	}
	
	public function getName() {
		return $this->info['title'];
	}
	
	public function getId() {
		return $this->info['usergroupid'];
	}
	
	public function misc($field) {
		return $this->info[$field];
	}
	
	
	// Setters
	public function setDestination($destination) {
		$this->destination = $destination;
	}
	
	
	// Protected Methods
	// gets usergroup info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getUsergroup = new Query($query['global']['get_usergroup_byId'], Array(1 => $this->groupid));
		
		$this->info = parent::queryInfoById($getUsergroup);
	}
	
	
	// Private Methods
	// checks to make sure there are no
	// untouchable users in group
	private function findTheUntouchables() {
		global $query, $wtcDB;
		
		// query for all users...
		$getAllUsers = new Query($query['usergroups']['get_allUsers'], Array(1 => $this->groupid, $this->groupid));
		
		if(!$wtcDB->numRows($getAllUsers)) {
			return false;
		}
		
		while($user = $wtcDB->fetchArray($getAllUsers)) {
			$userObj = new User('', '', $user);
			
			if($userObj->untouchable()) {
				return true;
			}
		}
		
		return false;
	}
	
	
	// Static Methods
	// Public
	// inserts usergroup... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query, $_CACHE;

		$db = $wtcDB->massInsert($arr);

		new Query($query['usergroups']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		
		new Cache('Usergroups');
		
		Admin::addDelAdmins();
	}
	
	// gets groups and sorts by title
	public static function groupAndSort($queryStr) {
		global $wtcDB;
		
		// get
		$get = new Query($queryStr);
		$groups = Array();
		
		if($wtcDB->numRows($get)) {
			while($group = $wtcDB->fetchArray($get)) {
				$groups[$group['title']] = $group;
			}
		
			ksort($groups);
		}
		
		return $groups;
	}
}
