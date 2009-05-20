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
## *************** POST ICON CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class PostIcon extends Object {
	private $iconid, $info;

	// Constructor
	public function __construct($id = '', $iconinfo = '') {
		if(!empty($iconinfo) AND is_array($iconinfo)) {
			$this->info = $iconinfo;
			$this->iconid = $this->info['iconid'];
		}

		else if(!empty($id)) {
			$this->iconid = $id;
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

		new Delete('posticons', 'iconid', $this->iconid, '');

		new Cache('PostIcons');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=posticons');
	}

	// Updates post icon... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['posticons']['update'], Array(1 => $update, 2 => $this->iconid), 'query', false);

		new Cache('PostIcons');
	}

	// Accessors
	public function getIconId() {
		return $this->iconid;
	}

	public function getTitle() {
		return $this->info['title'];
	}

	public function getDisOrder() {
		return $this->info['disOrder'];
	}

	public function getImgPath() {
		return $this->info['imgPath'];
	}

	public function getInfo() {
		return $this->info;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getIcon = new Query($query['posticons']['get'], Array(1 => $this->iconid));

		$this->info = parent::queryInfoById($getIcon);
	}


	// Static Methods
	// Public
	// inserts post icon... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['posticons']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('PostIcons');
	}

	// initializes post icons array
	public static function init() {
		global $wtcDB, $query, $_CACHE, $posticons;

		$posticons = Array();

		if(!($posticons = Cache::load('posticons'))) {
			$getIcons = new Query($query['posticons']['get_all']);
			$posticons = Array();

			while($icon = $wtcDB->fetchArray($getIcons)) {
				$posticons[$icon['iconid']] = new PostIcon('', $icon);
			}
		}

		return $posticons;
	}

	// this constructs the post icon bits
	public static function constructPostIcons($selectedImgSrc = '') {
		global $obj, $bits, $selectedImg;

		$selectedImg = $selectedImgSrc;

		extract($GLOBALS);

		$posticons = Cache::load('posticons');
		$bits = '';

		if(!is_array($posticons) OR !count($posticons)) {
			return '';
		}

		foreach($posticons as $id => $obj) {
			$temp = new StyleFragment('postIcon_bit');
			$bits .= $temp->dump();
		}

		$temp = new StyleFragment('postIcon');

		return $temp->dump();
	}
}
