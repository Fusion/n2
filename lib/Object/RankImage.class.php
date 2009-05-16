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
## *************** RANK IMAGE CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class RankImage extends Object {
	public $info;
	private $rankiid, $minPosts, $imgPath, $imgRepeat;

	// Constructor
	public function __construct($id = '', $rankinfo = '') {
		if(!empty($rankinfo) AND is_array($rankinfo)) {
			$this->info = $rankinfo;
			$this->rankiid = $this->info['rankiid'];
		}

		else if(!empty($id)) {
			$this->rankiid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// asign forumid and usergroupid
		$this->minPosts = $this->info['minPosts'];
		$this->imgPath = $this->info['imgPath'];
		$this->imgRepeat = $this->info['rankRepeat'];
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('ranks_images', 'rankiid', $this->rankiid, '');

		new Cache('RankImages');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=rankImages');
	}

	// Updates rank... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['rankImage']['update'], Array(1 => $update, 2 => $this->rankiid), 'query', false);

		new Cache('RankImages');
	}

	// Accessors
	public function getRankiid() {
		return $this->rankiid;
	}

	public function getMinPosts() {
		return $this->minPosts;
	}

	public function getImgPath() {
		return $this->imgPath;
	}

	public function getImgRepeat() {
		return $this->imgRepeat;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getRankImage = new Query($query['rankImage']['get'], Array(1 => $this->rankiid));

		$this->info = parent::queryInfoById($getRankImage);
	}


	// Static Methods
	// Public
	// inserts rank... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['rankImage']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('RankImages');
	}

	// puts ranks into array ($rankImages)
	public static function init() {
		global $query, $wtcDB, $rankImages;

		$getRankImages = new Query($query['rankImage']['get_all']);
		$rankImages = Array();

		while($rankImage = $wtcDB->fetchArray($getRankImages)) {
			$rankImages[$rankImage['rankiid']] = new RankImage('', $rankImage);
		}
	}

	// Calculates which rank should be used
	public static function findRank($postCount) {
		global $rankImages, $wtcDB, $query;

		// initialize ranks
		RankImage::init();

		// iterate through each of them...
		// the lowest difference wins!
		$diff = $postCount + 1;
		$retval = false;

		foreach($rankImages as $rankiid => $obj) {
			if($postCount >= $obj->getMinPosts() AND ($postCount - $obj->getMinPosts()) < $diff) {
				$diff = $postCount - $obj->getMinPosts();
				$retval = $obj;
			}
		}

		return $retval;
	}
}
