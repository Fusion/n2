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
## ****************** RANK CLASS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Rank extends Object {
	public $info;
	private $rankid, $minPosts, $title;
		
	// Constructor
	public function __construct($id = '', $rankinfo = '') {
		if(!empty($rankinfo) AND is_array($rankinfo)) {
			$this->info = $rankinfo;
			$this->rankid = $this->info['rankid'];
		}
		
		else if(!empty($id)) {
			$this->rankid = $id;
			$this->queryInfoById();
		}
		
		else {
			new WtcBBException($lang['error_noInfo']);
		}
		
		// asign forumid and usergroupid
		$this->minPosts = $this->info['minPosts'];
		$this->title = $this->info['title'];
	}
	
	
	// Public Methods	
	// Deletes...
	public function destroy() {
		global $query, $lang;
		
		new Delete('ranks', 'rankid', $this->rankid, '');
		
		new Cache('Ranks');
		
		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=ranks');
	}
	
	// Updates rank... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['rank']['update'], Array(1 => $update, 2 => $this->rankid), 'query', false);
		
		new Cache('Ranks');
	}
	
	// Accessors
	public function getRankid() {
		return $this->rankid;
	}
	
	public function getMinPosts() {
		return $this->minPosts;
	}
	
	public function getTitle() {
		return $this->title;
	}
		
	
	// Protected Methods	
	// gets info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getRank = new Query($query['rank']['get'], Array(1 => $this->rankid));
	
		$this->info = parent::queryInfoById($getRank);
	}
	
	
	// Static Methods
	// Public
	// inserts rank... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['rank']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		
		new Cache('Ranks');
	}
}
