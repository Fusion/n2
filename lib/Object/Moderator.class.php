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
