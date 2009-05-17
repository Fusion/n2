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
