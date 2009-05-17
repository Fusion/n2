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
