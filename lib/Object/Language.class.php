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
## **************** LANGUAGE CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Language extends Object {
	private $langid, $langName, $info;

	// Constructor
	public function __construct($id = '', $langinfo = '') {
		global $lang;

		if(!empty($langinfo) AND is_array($langinfo)) {
			$this->info = $langinfo;
			$this->langid = $this->info['langid'];
		}

		else if(!empty($id)) {
			$this->langid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// unserialize groupids to make'em ready for use
		$this->langName = $this->info['name'];
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('lang', 'langid', $this->langid, '', true, true);
		new Delete('lang_words', 'langid', $this->langid, '', true, true);

		@unlink('./language/' . $this->getFileName() . '.php');

		new Cache('Languages');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=language');
	}

	// Updates lang... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['lang']['update'], Array(1 => $update, 2 => $this->langid), 'query', false);

		Language::cache();
	}


	// Accessors
	public function getLangId() {
		return $this->langid;
	}

	public function getName() {
		return $this->langName;
	}

	public function getFileName() {
		return preg_replace('/\s+/', '-', strtolower($this->langName));
	}

	public function getInfo() {
		return $this->info;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getLang = new Query($query['lang']['get'], Array(1 => $this->langid));

		$this->info = parent::queryInfoById($getLang);
	}


	// Static Methods
	// Public
	// inserts language... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['lang']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		Language::cache();
	}

	public static function getLanguages($name, $val) {
		$retval = '<select name="' . $name . '">' . "\n";

		$langs = Language::buildLanguages();

		foreach($langs as $langName => $langVal) {
			if($val == $langVal) {
				$selected = ' selected="selected"';
			}

			$retval = '<option value="' . $langVal . '">' . $langName . '</option>' . "\n";
		}

		$retval .= '</select>' . "\n\n";

		return $retval;
	}

	public static function buildLanguages() {
		global $wtcDB, $query;

		$getLangs = new Query($query['admin']['get_langs']);
		$retval = Array();

		while($lang = $getLangs->fetchArray()) {
			$retval[$lang['name']] = $lang['langid'];
		}

		return $retval;
	}

	// Writes all words to a file...
	public static function cache() {
		global $query, $wtcDB, $lang;

		// get all languages
		$getLangs = new Query($query['admin']['get_langs']);

		while($langA = $wtcDB->fetchArray($getLangs)) {
			$fileContents = '<?php
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
 ' . "\n\n";
			$adminContents = '<?php
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
 ' . "\n\n";

			// get words
			$getWords = new Query($query['global']['get_words'], Array(1 => $langA['langid']));

			// now get all words... and put them in arrays...
			while($word = $wtcDB->fetchArray($getWords)) {
				if(substr($word['name'], 0, 5) != 'admin') {
					$fileContents .= '$lang[\'' . $word['name'] . '\'] = \'' . str_replace("'", "\'", $word['words']) . '\';' . "\n";
				}

				$adminContents .= '$lang[\'' . $word['name'] . '\'] = \'' . str_replace("'", "\'", $word['words']) . '\';' . "\n";
			}

			$fileContents .= "\n" . '?>';
			$adminContents .= "\n" . '?>';

			file_put_contents('./language/' . preg_replace('/\s+/', '-', strtolower($langA['name'])) . '.php', $fileContents);
			file_put_contents('./language/' . preg_replace('/\s+/', '-', strtolower($langA['name'])) . '_admin.php', $adminContents);
		}

		new Cache('Languages');
	}
}
