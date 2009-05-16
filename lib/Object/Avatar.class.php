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
## ***************** AVATAR CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Avatar extends Object {
	private $avatarid, $info;

	// Constructor
	public function __construct($id = '', $avatarinfo = '') {
		if(!empty($avatarinfo) AND is_array($avatarinfo)) {
			$this->info = $avatarinfo;
			$this->avatarid = $this->info['avatarid'];
		}

		else if(!empty($id)) {
			$this->avatarid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// unserialize groupids to make'em ready for use
		$this->info['usergroupid'] = unserialize($this->info['usergroupid']);
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('avatar', 'avatarid', $this->avatarid, '');

		new Cache('Avatars');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=avatar');
	}

	// Updates avatar... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['avatar']['update'], Array(1 => $update, 2 => $this->avatarid), 'query', false);

		new Cache('Avatars');
	}

	// Accessors
	public function getAvatarId() {
		return $this->avatarid;
	}

	public function getTitle() {
		return $this->info['title'];
	}

	public function getGroupId() {
		return $this->info['groupid'];
	}

	public function getUserGroupIds() {
		return $this->info['usergroupids'];
	}

	public function getGroupName() {
		return $this->info['groupName'];
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

		$getAvatar = new Query($query['avatar']['get'], Array(1 => $this->avatarid));

		$this->info = parent::queryInfoById($getAvatar);
	}


	// Static Methods
	// Public
	// inserts avatar... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['avatar']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('Avatars');
	}

	// initializes avatars array
	public static function init() {
		global $wtcDB, $query, $_CACHE, $avatars;

		$avatars = Array();

		if(!($avatars = Cache::load('avatars'))) {
			$getAvatars = new Query($query['avatar']['get_all']);
			$avatars = Array();

			while($avatar = $wtcDB->fetchArray($getAvatars)) {
				$avatars[$avatar['groupid']][$avatar['avatarid']] = new Avatar('', $avatar);
			}
		}

		return $avatars;
	}

	// this will compile a list of group names...
	// and sort...
	public static function groupNames($avatars) {
		global $User, $wtcDB, $_CACHE, $query, $generalGroups;

		// get the groups...
		Group::init();

		$retval = Array();

		foreach($generalGroups['avatar'] as $groupid => $obj) {
			if($obj->canView()) {
				$retval[$obj->getGroupName()] = $obj->getGroupId();
			}
		}

		ksort($retval);

		return $retval;
	}
}
