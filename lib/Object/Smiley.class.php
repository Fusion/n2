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
## ***************** SMILEY CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Smiley extends Object {
	private $smileyid, $info;

	// Constructor
	public function __construct($id = '', $smileyinfo = '') {
		if(!empty($smileyinfo) AND is_array($smileyinfo)) {
			$this->info = $smileyinfo;
			$this->smileyid = $this->info['smileyid'];
		}

		else if(!empty($id)) {
			$this->smileyid = $id;
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

		new Delete('smilies', 'smileyid', $this->smileyid, '');

		new Cache('Smilies');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=smilies&amp;groupid=' . $this->getGroupId());
	}

	// Updates smiley... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['smilies']['update'], Array(1 => $update, 2 => $this->smileyid), 'query', false);

		new Cache('Smilies');
	}

	// parses the current smiliey in the given text
	public function parse($txt) {
		return str_replace(wtcspecialchars($this->getReplacement()), '<img src="' . $this->getImgPath() . '" alt="' . $this->getReplacement() . '" />', $txt);
	}

	public function strip($txt) {
		return str_replace('<img src=\"' . $this->getImgPath() . '\" alt=\"' . $this->getReplacement() . '\" />', $this->getReplacement(), $txt);
	}

	// Accessors
	public function getSmileyId() {
		return $this->smileyid;
	}

	public function getReplacement() {
		return $this->info['replacement'];
	}

	public function getRegexReplacement() {
		return preg_quote($this->info['replacement'], '/');
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

		$getSmiley = new Query($query['smilies']['get'], Array(1 => $this->smileyid));

		$this->info = parent::queryInfoById($getSmiley);
	}


	// Static Methods
	// Public
	// inserts smiley... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['smilies']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('Smilies');
	}

	// initializes Smilies array...
	public static function init() {
		global $wtcDB, $query;

		$getSmilies = new Query($query['smilies']['get_all']);
		$retval = Array();

		while($smiley = $wtcDB->fetchArray($getSmilies)) {
			$retval[$smiley['groupid']][$smiley['smileyid']] = new Smiley('', $smiley);
		}

		return $retval;
	}

	// this parses all smilies in a given text
	public static function parseAll($txt) {
		global $query, $wtcDB, $smilies;

		$retval = $txt;

		if(!($smilies = Cache::load('smilies'))) {
			$smilies = Smiley::init();
		}

		if(is_array($smilies)) {
			foreach($smilies as $groupid => $more) {
				if(is_array($more)) {
					foreach($more as $id => $smiley) {
						$retval = $smiley->parse($retval);
					}
				}
			}
		}

		// now fix
		$retval = preg_replace('/(&[0-9a-z]+)<img src="[^"]+?" alt="([^"]+?)" \/>/i', '$1$2', $retval);

		return $retval;
	}

	// this will strip all smilies...
	public static function stripAll($txt) {
		global $query, $wtcDB, $smilies;

		$retval = $txt;

		if(!($smilies = Cache::load('smilies'))) {
			$smilies = Smiley::init();
		}

		foreach($smilies as $groupid => $more) {
			foreach($more as $id => $smiley) {
				$retval = $smiley->strip($retval);
			}
		}

		return $retval;
	}

	// this constructs the smiley bits
	public static function construct() {
		global $obj, $bits, $bits2, $alt;

		extract($GLOBALS);

		if(!($smilies = Cache::load('smilies'))) {
			$smilies = Smiley::init();
		}

		$count = 1;
		$bits = '';
		$bits2 = '';
		$alt = true;

		if(!is_numeric($bboptions['smilies']) OR $bboptions['smilies'] <= 0) {
			return '';
		}

		foreach($smilies as $groupid => $more) {
			foreach($more as $id => $obj) {
				if($count > $bboptions['smilies']) {
					break;
				}

				$temp = new StyleFragment('smiley_bit');
				$bits .= $temp->dump();

				if($alt) {
					$alt = false;
				}

				else {
					$alt = true;
				}

				$count++;
			}
		}

		$temp = new StyleFragment('smiley');

		return $temp->dump();
	}
}
