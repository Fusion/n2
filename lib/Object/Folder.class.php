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
