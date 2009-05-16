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
## *************** FORUM PERMS CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class ForumPerm extends Object {
	public $info;
	private $permid, $forumid, $groupid;
		
	// Constructor
	public function __construct($id = '', $perminfo = '') {
		if(!empty($perminfo) AND is_array($perminfo)) {
			$this->info = $perminfo;
			$this->permid = $this->info['permid'];
		}
		
		else if(!empty($id)) {
			$this->permid = $id;
			$this->queryInfoById();
		}
		
		else {
			new WtcBBException($lang['error_noInfo']);
		}
		
		// asign forumid and usergroupid
		$this->groupid = $this->info['usergroupid'];
		$this->forumid = $this->info['forumid'];
	}
	
	
	// Public Methods	
	// Deletes...
	public function destroy() {
		global $query, $lang;
		
		new Delete('forumPerms', 'permid', $this->permid, '');
		
		new Cache('ForumPerms');
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum&amp;do=perms');
	}
	
	// Updates perm... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['perm']['update'], Array(1 => $update, 2 => $this->permid), 'query', false);
		
		new Cache('ForumPerms');
	}
	
	// Accessors
	public function getForumid() {
		return $this->forumid;
	}
	
	public function getGroupid() {
		return $this->groupid;
	}
	
	public function getPermid() {
		return $this->permid;
	}
	
	public function misc($perm) {
		return $this->info[$perm];
	}
	
	public function getInfo() {
		return $this->info;
	}
		
	
	// Protected Methods	
	// gets info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getPerm = new Query($query['perm']['get'], Array(1 => $this->permid));
	
		$this->info = parent::queryInfoById($getPerm);
	}
	
	
	// Static Methods
	// Public
	// inserts perm... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['perm']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		
		new Cache('ForumPerms');
	}
	
	// finds forum perms that inherit
	// and adds to array
	public static function getInheritPerms($forumPerms) {
		global $forums, $orderedForums, $solidPerms;
		
		// create forum iter
		if(count($forumPerms)) {
			$outsideForumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
			
			// we need to iterate through all forums
			// so we get appropriate order... overrides must occur in proper order
			foreach($outsideForumIter as $forumObj) {
				if(!isset($forumPerms[$forumObj->info['forumid']])) {
					continue;
				}
				
				foreach($forumPerms[$forumObj->info['forumid']] as $groupid => $permObj) {						
					$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($permObj->getForumid()), true);
			
					foreach($forumIter as $forum) {
						// errm... make sure we don't have a perm overriding this one!
						// only check non-inherited perms... as we want inherited perms to be overridden!
						if(isset($solidPerms[$forum->info['forumid']][$permObj->getGroupid()])) {
							continue;
						}
						
						$forumPerms[$forum->info['forumid']][$permObj->getGroupid()] = $permObj;
					}
				}
			}
		}

		return $forumPerms;	
	}
	
	// initializes the forum perms arrays
	public static function init() {
		global $_CACHE, $perms, $solidPerms, $query, $wtcDB, $User;
		
		if(!($perms = Cache::load('perms'))) {
			$permsQ = new Query($query['perm']['get_all']);
			$perms = Array();
			
			while($perm = $wtcDB->fetchArray($permsQ)) {
				$perms[$perm['forumid']][$perm['usergroupid']] = new ForumPerm('', $perm);
			}
		}
	
		$solidPerms = $perms; // no inherited perms
		$perms = ForumPerm::getInheritPerms($perms);
	}
}
