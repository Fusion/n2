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
## ***************** FOLDER CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Folder extends Object {
	private $folderid, $info;

	// Constructor
	public function __construct($id = '', $folderinfo = '') {
		global $lang;

		if(!empty($folderinfo) AND is_array($folderinfo)) {
			$this->info = $folderinfo;
			$this->folderid = $this->info['folderid'];
		}

		else if(!empty($id)) {
			$this->folderid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang, $User;

		// cannot destroy inbox!
		if($this->folderid == 1) {
			return false;
		}

		new Delete('personal_folders', 'folderid', $this->folderid, '', true, true);

		// iterate through all conversations and destroy
		$allConvos = new Query($query['personal_convo']['get_all_folder'], Array(
			1 => $User->info['userid'],
			2 => $this->folderid
		));

		while($obj = $allConvos->fetchArray()) {
			_DEBUG($obj);
			$Convo = new Conversation('', $obj);
			$Convo->liteDestroy();
		}
	}

	// Updates folder... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['personal_folders']['update'], Array(1 => $update, 2 => $this->folderid), 'query', false);
	}

	// Accessors
	public function getFolderId() {
		return $this->folderid;
	}

	public function getName() {
		return censor(wtcspecialchars($this->info['name']));
	}

	public function getUserId() {
		return $this->info['userid'];
	}

	public function getTotalMessages() {
		global $query, $wtcDB, $User;

		$folderCount = new Query($query['personal_convo']['get_count_folder'], Array(
			1 => $User->info['userid'],
			2 => $this->folderid
		));

		$folderCount = $folderCount->fetchArray();

		return $folderCount['total'];
	}

	public function getInfo() {
		return $this->info;
	}

	// empties folder... (deletes all messages)
	public function emptyMe() {
		global $User;


	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getFolder = new Query($query['personal_folders']['get'], Array(1 => $this->folderid));

		$this->info = parent::queryInfoById($getFolder);
	}


	// Static Methods
	// Public
	// inserts folder... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['personal_folders']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}
