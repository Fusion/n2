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
## **************** MODERATOR CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Moderator extends Object {
	private $info, $modid, $userid, $forumid;
		
	// Constructor
	public function __construct($id = '', $modinfo = '') {
		if(!empty($modinfo) AND is_array($modinfo)) {
			$this->info = $modinfo;
			$this->modid = $this->info['modid'];
		}
		
		else if(!empty($id)) {
			$this->modid = $id;
			$this->queryInfoById();
		}
		
		else {
			new WtcBBException($lang['error_noInfo']);
		}
		
		// asign forumid and userid
		$this->userid = $this->info['userid'];
		$this->forumid = $this->info['forumid'];
		
		$this->nextRun = $this->info['nextRun'];
	}
	
	
	// Public Methods	
	// Deletes...
	public function destroy() {
		global $query, $lang;
		
		new Delete('moderators', 'modid', $this->modid, '');
		
		new Cache('Moderators');
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=forum');
	}
	
	// Updates moderator... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['moderator']['update'], Array(1 => $update, 2 => $this->modid), 'query', false);
		
		new Cache('Moderators');
	}
	
	// Accessors
	public function getForumid() {
		return $this->forumid;
	}
	
	public function getUserid() {
		return $this->userid;
	}
	
	public function getModid() {
		return $this->modid;
	}
	
	public function forum($perm) {
		return $this->info['can' . $perm];
	}
	
	public function modPanel($perm) {
		return $this->info['mod' . $perm];
	}
	
	public function email($perm) {
		return $this->info['email' . $perm];
	}
	
	public function misc($perm) {
		return $this->info[$perm];
	}
	
	public function perm($perm) {
		// not set?
		if(!isset($this->info[$perm])) {
			return false;
		}
		
		return $this->info[$perm];
	}
	
	public function getInfo() {
		return $this->info;
	}
		
	
	// Protected Methods	
	// gets info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getMod = new Query($query['moderator']['get'], Array(1 => $this->modid));
	
		$this->info = parent::queryInfoById($getMod);
	}
	
	
	// Static Methods
	// Public
	// inserts moderator... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['moderator']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		
		new Cache('Moderators');
	}
	
	// finds moderators that mod sub forums
	// and adds to array
	public static function getInheritMods($mods, $solidMods) {
		global $forums, $orderedForums;
		
		// create forum iter
		if(is_array($mods)) {
			$outsideForumIter = new RecursiveIteratorIterator(new RecursiveForumIterator(), true);
			
			// do this for forum perms too...
			// we need to go through forums in order, so we have
			// overrides placed correctly
			foreach($outsideForumIter as $forumObj) {
				if(!isset($mods[$forumObj->info['forumid']])) {
					continue;
				}
				
				foreach($mods[$forumObj->info['forumid']] as $userid => $modObj) {
					if(!$modObj->misc('modSubs')) {
						continue;
					}
					
					$forumIter = new RecursiveIteratorIterator(new RecursiveForumIterator($modObj->getForumid()), true);
			
					foreach($forumIter as $forum) {
						// errm... make sure we don't have a mod overriding this one!
						// only check non-inherited mods... as we want inherited mods to be overridden!
						if(isset($solidMods[$forum->info['forumid']][$modObj->getUserid()])) {
							continue;
						}
						
						$mods[$forum->info['forumid']][$modObj->getUserid()] = $modObj;
					}
				}
			}
		}

		return $mods;	
	}
	
	// initializes the moderators arrays
	public static function init() {
		global $query, $wtcDB, $moderators, $solidMods;
		
		if(!($moderators = Cache::load('moderators'))) {
			$modQ = new Query($query['moderator']['get_all']);
			$moderators = Array();
			
			while($mod = $wtcDB->fetchArray($modQ)) {
				$moderators[$mod['forumid']][$mod['userid']] = new Moderator('', $mod);
			}
		}
	}
}
