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
