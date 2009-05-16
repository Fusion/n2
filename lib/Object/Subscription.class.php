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
