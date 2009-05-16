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
## ********** CUSTOM PROFILE FIELD CLASS ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class CustomPro extends Object {
	private $proid, $info;

	// Constructor
	public function __construct($id = '', $proinfo = '') {
		global $lang;

		if(!empty($proinfo) AND is_array($proinfo)) {
			$this->info = $proinfo;
			$this->proid = $this->info['proid'];
		}

		else if(!empty($id)) {
			$this->proid = $id;
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

		new Delete('custom_pro', 'proid', $this->proid, '', true, true);

		// also drop the column...
		new Query($query['custom_pro']['alter_drop'], Array(1 => $this->getColName()));
	}

	// Updates profile field... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['custom_pro']['update'], Array(1 => $update, 2 => $this->proid), 'query', false);

		new Cache('CustomPros');
	}

	// Accessors
	public function getProId() {
		return $this->proid;
	}

	public function getGroupId() {
		return $this->info['groupid'];
	}

	public function getColName() {
		return $this->info['colName'];
	}

	public function getName() {
		return $this->info['fieldName'];
	}

	public function getDesc() {
		return $this->info['fieldDesc'];
	}

	public function getType() {
		return $this->info['fieldType'];
	}

	public function getOptionText() {
		return $this->info['optionText'];
	}

	public function getOptionTextArray() {
		return preg_split('/(\r\n|\n|\r)/', $this->getOptionText());
	}

	public function getDefValue() {
		return $this->info['defValue'];
	}

	public function getDisOrder() {
		return $this->info['disOrder'];
	}

	public function getInfo() {
		return $this->info;
	}

	// this will build the HTML (inputs, etc)
	// for the given field, this includes
	// inserting names and values...
	public function buildHTML($cName, $cValue) {
		global $proName, $proValue, $proSize, $optBits, $optVal, $id, $selected;

		// start it off
		$html = '';
		$optBits = '';
		$optVal = '';
		$id = '';
		$selected = false;
		$proSize = 10;

		// different HTML for each field type...
		switch($this->getType()) {
			case 'text':
				$proName = $cName;
				$proValue = (empty($cValue) ? $this->getDefValue() : $cValue);
				$html = new StyleFragment('custompro_text');
			break;

			case 'textarea':
				$proName = $cName;
				$proValue = (empty($cValue) ? $this->getDefValue() : $cValue);
				$html = new StyleFragment('custompro_textarea');
			break;

			case 'select':
				$proName = $cName;
				$proValue = (empty($cValue) ? $this->getDefValue() : $cValue);
				$opts = $this->getOptionTextArray();

				if(is_array($opts)) {
					foreach($opts as $optVal) {
						$temp = new StyleFragment('custompro_select_opt');
						$optBits .= $temp->dump();
					}
				}

				if(empty($optBits)) {
					return false;
				}

				$html = new StyleFragment('custompro_select');
			break;

			case 'multi-select':
				$proName = $cName;
				$proValue = preg_split('/(\r\n|\n|\r)/', $cValue);
				$opts = $this->getOptionTextArray();

				if(!is_array($proValue) OR !count($proValue) OR empty($cValue)) {
					$proValue = preg_split('/(\r\n|\n|\r)/', $this->getDefValue());
				}

				if(count($opts) < 10) {
					$proSize = count($opts);
				}

				if(is_array($opts)) {
					foreach($opts as $optVal) {
						$selected = false;

						foreach($proValue as $check) {
							if(trim($check) == trim($optVal)) {
								$selected = true;
								break;
							}
						}

						$temp = new StyleFragment('custompro_multiselect_opt');
						$optBits .= $temp->dump();
					}
				}

				if(empty($optBits)) {
					return false;
				}

				$html = new StyleFragment('custompro_multiselect');
			break;

			case 'radio':
				$proName = $cName;
				$proValue = (empty($cValue) ? $this->getDefValue() : $cValue);
				$opts = $this->getOptionTextArray();
				$count = 1;

				if(is_array($opts)) {
					foreach($opts as $optVal) {
						$id = $this->getColName() . $count++;

						$temp = new StyleFragment('custompro_radio_opt');
						$optBits .= $temp->dump();
					}
				}

				if(empty($optBits)) {
					return false;
				}

				$html = new StyleFragment('custompro_radio');
			break;

			case 'checkbox':
				$proName = $cName;
				$proValue = preg_split('/(\r\n|\n|\r)/', $cValue);
				$opts = $this->getOptionTextArray();
				$count = 1;

				if(!is_array($proValue) OR !count($proValue) OR empty($cValue)) {
					$proValue = preg_split('/(\r\n|\n|\r)/', $this->getDefValue());
				}

				if(is_array($opts)) {
					foreach($opts as $optVal) {
						$selected = false;
						$id = $this->getColName() . $count++;

						foreach($proValue as $check) {
							if(trim($check) == trim($optVal)) {
								$selected = true;
								break;
							}
						}

						$temp = new StyleFragment('custompro_checkbox_opt');
						$optBits .= $temp->dump();
					}
				}

				if(empty($optBits)) {
					return false;
				}

				$html = new StyleFragment('custompro_checkbox');
			break;
		}

		// return our html...
		if($html instanceof StyleFragment) {
			return $html->dump();
		}

		return false;
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getPro = new Query($query['custom_pro']['get'], Array(1 => $this->proid));

		$this->info = parent::queryInfoById($getPro);
	}


	// Static Methods
	// Public
	// inserts profile field... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['custom_pro']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
		$id = $wtcDB->lastInsertId();

		// also add col name... only used when first created...
		$inserted = new CustomPro($id);
		$inserted->update(Array('colName' => 'profile' . $id));
		new Query($query['custom_pro']['alter_add'], Array(1 => 'profile' . $id));

		new Cache('CustomPros');

		return $id;
	}

	// initializes profile fields array
	public static function init() {
		global $wtcDB, $query, $_CACHE, $profs;

		$profs = Array();

		if(!($profs = Cache::load('profs'))) {
			$getPros = new Query($query['custom_pro']['get_all']);
			$profs = Array();

			while($prof = $wtcDB->fetchArray($getPros)) {
				$profs[$prof['groupid']][$prof['proid']] = new CustomPro('', $prof);
			}
		}

		return $profs;
	}
}
