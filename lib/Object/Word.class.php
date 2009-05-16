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
## ****************** WORD CLASS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Word extends Object {
	private $wordid, $info;
		
	// Constructor
	public function __construct($id = '', $wordinfo = '') {
		global $lang;
		
		if(!empty($wordinfo) AND is_array($wordinfo)) {
			$this->info = $wordinfo;
			$this->wordid = $this->info['wordsid'];
		}
		
		else if(!empty($id)) {
			$this->wordid = $id;
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
			
		new Delete('lang_words', 'wordsid', $this->wordid, '');
	}
	
	// Updates word... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['lang_words']['update'], Array(1 => $update, 2 => $this->wordid), 'query', false);
		
		Language::cache();
	}
	
	// Accessors
	public function getWordId() {
		return $this->wordid;
	}

	public function getDefaultId() {
		return $this->info['defaultid'];
	}

	public function getLangId() {
		return $this->info['langid'];
	}

	public function getGroupId() {
		return $this->info['catid'];
	}
	
	public function getName() {
		return $this->info['name'];
	}

	public function getDisplayName() {
		return $this->info['displayName'];
	}
	
	public function getWords() {
		return $this->info['words'];
	}
	
	public function getInfo() {
		return $this->info;
	}
		
	
	// Protected Methods	
	// gets info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getWord = new Query($query['lang_words']['get'], Array(1 => $this->wordid));
	
		$this->info = parent::queryInfoById($getWord);
	}
	
	
	// Static Methods
	// Public
	// inserts word... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['lang_words']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		
		Language::cache();
	}
}
