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
## ************** SUBSCRIPTION CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Subscription extends Object {
	public $info;
	private $subid;

	// Constructor
	public function __construct($id = '', $subinfo = '') {
		if(!empty($subinfo) AND is_array($subinfo)) {
			$this->info = $subinfo;
			$this->subid = $this->info['subid'];
		}

		else if(!empty($id)) {
			$this->subid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('subscribe', 'subid', $this->subid, '', true, true);
	}

	// Updates subscription... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['subscribe']['update'], Array(1 => $update, 2 => $this->subid), 'query', false);
	}

	// Accessors
	public function getSubId() {
		return $this->subid;
	}

	public function getUserId() {
		return $this->info['userid'];
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function getThreadId() {
		return $this->info['threadid'];
	}

	public function getType() {
		return $this->info['subType'];
	}

	public function lastEmailed() {
		return $this->info['lastEmail'];
	}

	public function lastView() {
		return $this->info['lastView'];
	}

	public function isThreadSub() {
		return (($this->info['threadid'] > 0 ? true : false));
	}

	public function getInfo() {
		return $this->info;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getSub = new Query($query['subscribe']['get'], Array(1 => $this->subid));

		$this->info = parent::queryInfoById($getSub);
	}


	// Static Methods
	// Public
	// inserts subscription... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['subscribe']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
	}
}
