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
