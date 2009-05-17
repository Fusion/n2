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
## ***************** BB CODE CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class BBCode extends Object {
	private $bbcodeid, $info;

	// Constructor
	public function __construct($id = '', $bbcodeinfo = '') {
		if(!empty($bbcodeinfo) AND is_array($bbcodeinfo)) {
			$this->info = $bbcodeinfo;
			$this->bbcodeid = $this->info['bbcodeid'];
		}

		else if(!empty($id)) {
			$this->bbcodeid = $id;
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

		new Delete('bbcode', 'bbcodeid', $this->bbcodeid, '');

		new Cache('BBCodes');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=bbcode');
	}

	// Updates bbcode... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['bbcode']['update'], Array(1 => $update, 2 => $this->bbcodeid), 'query', false);

		new Cache('BBCodes');
	}

	// Parses the BB Code against text...
	public function parse($txt, $html = false) {
		$retval = $txt;

		// option?
		// this is tricky...
		if($this->useOption()) {
			// always try the replace first...
			// if the text remains unchanged, then stop
			// if text changes, try again!
			do {
				$prev = $retval;

				// i love me some negative look ahead...
				//$retval = preg_replace('/\[' . $this->getRegexTag() . '=([^\]]+)\]((?:[^\[]|\[(?!\/' . $this->getRegexTag() . '\]))+)\[\/' . $this->getRegexTag() . '\]/ie', '$this->doReplaceWithOption(\'$2\', \'$1\')', $retval);

				$retval = preg_replace('/\[' . $this->getRegexTag() . '=([^\]"\']+)\](.+?)\[\/' . $this->getRegexTag() . '\]/ise', '$this->doReplaceWithOption(\'$2\', \'$1\')', $retval);
			} while($prev != $retval);
		}

		// no option... cake & pie
		else {
			// always try the replace first...
			// if the text remains unchanged, then stop
			// if text changes, try again!
			do {
				$prev = $retval;

				$retval = preg_replace('/\[' . $this->getRegexTag() . '\](.+?)\[\/' . $this->getRegexTag() . '\]/ise', '$this->doReplaceNoOption(\'$1\', $html)', $retval);
			} while($prev != $retval);
		}

		return $retval;
	}

	// Accessors
	public function getBBCodeId() {
		return $this->bbcodeid;
	}

	public function getName() {
		return $this->info['name'];
	}

	public function getTag() {
		return $this->info['tag'];
	}

	public function getRegexTag() {
		return preg_quote($this->getTag(), '/');
	}

	public function getReplacement() {
		return $this->info['replacement'];
	}

	public function getExample() {
		return $this->info['example'];
	}

	public function getDescription() {
		return $this->info['description'];
	}

	public function useOption() {
		return ((strpos($this->getReplacement(), '{option}') !== false) ? true : false);
	}

	public function showInUI() {
		return (($this->info['display']) ? true : false);
	}

	public function getInfo() {
		return $this->info;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getBBCode = new Query($query['bbcode']['get'], Array(1 => $this->bbcodeid));

		$this->info = parent::queryInfoById($getBBCode);
	}


	// Private Methods
	// replaces BB Codes with HTML
	// No Option though... param should be the argument
	private function doReplaceNoOption($param, $html) {
		// php???
		if(strtolower($this->getTag()) == 'php') {
			// strip BR...
			$param = preg_replace('/<br \/>/i', '', $param);

			// strip smilies
			$param = Smiley::stripAll($param);

			// no need to unhtml... we never html'ed...
			// do some stuff with quotes though
			if($html) {
				$param = trim(preg_replace('/(\\\)"/', '"', $param));
			}

			else {
				// unhtml... so it looks okay...
				$param = trim(unhtmlspecialchars($param));
			}

			// no PHP!?!
			$hasPhpTop = true;
			$hasPhpBot = true;

			if(!preg_match('/^<\?php/i', $param)) {
				$hasPhpTop = false;
				$param = '<?php
 /*

 * wtcBB Community Software (Open Source Freeware Version)

 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software
Solutions.

 * http://www.wtcbb.com/

 *

 * Licensed under the terms of the GNU Lesser General Public License:

 * http://www.wtcbb.com/wtcbb-license-general-public-license

 *

 * For support visit:

 * http://forums.wtcbb.com/

 *

 * Powered by wtcBB - http://www.wtcbb.com/

 * Protected by ChargebackFile - http://www.chargebackfile.com/

 *

*/
  ' . $param;
			}

			if(!preg_match('/\?>/i', $param)) {
				$hasPhpBot = false;
				$param .= ' ?>';
			}

			$param = highlight_string($param, true);

			if(!$hasPhpTop) {
				$param = preg_replace('/&lt;\?.*?php&nbsp;/i', '', $param);
			}

			if(!$hasPhpBot) {
				$param = preg_replace('/<span style="color: #0000BB">\?&gt;<\/span>/i', '', $param);
			}
		}

		else if(strtolower($this->getTag()) == 'code') {
			// strip smilies!
			$param = Smiley::stripAll($param);
		}

		else if(strtolower($this->getTag()) == 'ul' OR strtolower($this->getTag()) == 'ol') {
			// strip BR...
			$param = preg_replace('/<br \/>/i', '', $param);
		}

		else {
			// get rid of extraneous slashes
			$param = trim(preg_replace('/(\\\){1,}"/', '"', $param));
		}

		// do a simple search and replace on param
		if(strtolower($this->getTag()) == 'url') {
			$param2 = $param;

			if(strlen($param2) >= Message::$maxChars) {
				$chunk1 = substr($param2, 0, 15);
				$chunk2 = substr($param2, (strlen($param2) - 15), 15);
				$param2 = $chunk1 . '...' . $chunk2;
			}

			$retval = preg_replace('/\{param\}/i', $param, $this->getReplacement(), 1);
			$retval = str_ireplace('{param}', $param2, $retval);
		}

		else {
			$retval = str_ireplace('{param}', $param, $this->getReplacement());
		}

		return $retval;
	}

	// replaces BB Codes with HTML
	// with an option... should be param as first arg
	// and the option text as the second arg...
	private function doReplaceWithOption($param, $option) {
		// get rid of extraneous slashes
		$param = trim(preg_replace('/(\\\){1,}"/', '"', $param));

		// do a simple search and replace on param AND option
		$find = Array('{param}', '{option}');
		$replace = Array($param, $option);

		// do a simple search and replace on param
		if(strtolower($this->getTag()) == 'url') {
			$param2 = $param;

			if(strlen($param2) >= Message::$maxChars) {
				$chunk1 = substr($param2, 0, 15);
				$chunk2 = substr($param2, (strlen($param2) - 15), 15);
				$param2 = $chunk1 . '...' . $chunk2;
			}

			$replace[0] = $param2;
		}

		$retval = str_ireplace($find, $replace, $this->getReplacement());

		return $retval;
	}


	// Static Methods
	// Public
	// inserts bbcode... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['bbcode']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('BBCodes');
	}

	// initializes BB Code array...
	public static function init() {
		global $wtcDB, $query;

		$getBBCodes = new Query($query['bbcode']['get_all']);
		$retval = Array();

		while($bbcode = $wtcDB->fetchArray($getBBCodes)) {
			$retval[$bbcode['bbcodeid']] = new BBCode('', $bbcode);
		}

		return $retval;
	}

	// parses all BB Code...
	public static function parseAll($txt, $parseImages = true, $html = false) {
		global $query, $wtcDB, $bbcode;

		$retval = $txt;

		if(!($bbcode = Cache::load('bbcode'))) {
			$bbcode = BBCode::init();
		}

		foreach($bbcode as $id => $BB) {
			if($BB->getTag() == 'img' AND !$parseImages) {
				continue;
			}

			$retval = $BB->parse($retval, $html);
		}

		// take care of XSS...
		$find = Array('javascript:', 'vbscript:');
		$replace = Array('javascript:<em></em>', 'vbscript:<em></em>');

		$retval = str_ireplace($find, $replace, $retval);

		return $retval;
	}

	// strips ALL bb code
	public static function stripAll($txt) {
		$retval = $txt;

		do {
			$prev = $retval;
			$retval = preg_replace('/\[([^\]=]+)(?:=[^\]]+)?\].+?\[\/\1\]/i', '$2', $retval);
		} while($prev != $retval);

		return $retval;
	}

	// strips empty tags
	public static function stripEmptyTags($txt) {
		$retval = $txt;

		do {
			$prev = $retval;
			$retval = preg_replace('/\[([^\]=]+)(?:=[^\]]+)?\]\[\/\1\]/i', '', $retval);
		} while($prev != $retval);

		return $retval;
	}

	// strips a specified tag
	public static function stripMe($txt, $tag) {
		$retval = $txt;
		$tag = preg_quote($tag, '/');

		do {
			$prev = $retval;
			$retval = preg_replace('/\[' . $tag . '(?:=[^\]]+)?\].+?\[\/' . $tag . '\]/is', '', $retval);
		} while($prev != $retval);

		return trim($retval);
	}

	// this will construct the simple BB Code buttons
	// b, i, and u
	public static function liteConstruct() {
		global $query, $wtcDB, $bbcode, $bits, $BB;

		if(!($bbcode = Cache::load('bbcode'))) {
			$bbcode = BBCode::init();
		}

		$bits = '';

		// allowed BB Codes
		$allowed = Array('b', 'i', 'u');

		// build simple bb codes (and custom)
		foreach($bbcode as $id => $BB) {
			if(!in_array(strtolower($BB->getTag()), $allowed)) {
				continue;
			}

			$temp = new StyleFragment('bbcode_bit');
			$bits .= $temp->dump();
		}

		$temp = new StyleFragment('bbcodeLite');

		return $temp->dump();
	}

	// this will construct the BB Code buttons
	public static function construct() {
		global $query, $wtcDB, $bbcode, $bits, $BB, $key, $val;
		global $colorBits, $fontBits, $sizeBits;

		if(!($bbcode = Cache::load('bbcode'))) {
			$bbcode = BBCode::init();
		}

		$bits = '';
		$colorBits = '';
		$fontBits = '';
		$sizeBits = '';

		// build simple bb codes (and custom)
		foreach($bbcode as $id => $BB) {
			if(!$BB->showInUI()) {
				continue;
			}

			$temp = new StyleFragment('bbcode_bit');
			$bits .= $temp->dump();
		}

		// now build the colors
		$colors = Array(
			'user_color_red' => '#f00',
			'user_color_blue' => '#00f',
			'user_color_green' => '#008000',
			'user_color_purple' => '#800080',
			'user_color_pink' => '#ffc0cb',
			'user_color_black' => '#000',
			'user_color_white' => '#fff',
			'user_color_yellow' => '#ff0',
			'user_color_brown' => '#a52a2a',
			'user_color_cyan' => '#0ff',
			'user_color_magenta' => '#f0f',
			'user_color_steelBlue' => '#4682b4',
			'user_color_turquoise' => '#40e0d0',
			'user_color_orange' => '#ffa500',
			'user_color_orangeRed' => '#ff4500',
			'user_color_navy' => '#000080',
			'user_color_limeGreen' => '#32cd32',
			'user_color_lightCoral' => '#f08080',
			'user_color_fireBrick' => '#b22222',
			'user_color_gold' => '#ffd700',
			'user_color_silver' => '#c0c0c0',
			'user_color_orchid' => '#da70d6',
			'user_color_indianRed' => '#cd5c5c',
			'user_color_lime' => '#0f0',
			'user_color_indigo' => '#4b0082'
		);

		// i'm lazy... so what
		ksort($colors);

		// build html
		foreach($colors as $key => $val) {
			$temp = new StyleFragment('bbcode_colorbit');
			$colorBits .= $temp->dump();
		}

		// now build the fonts
		$fonts = Array(
			'user_font_verdana' => 'verdana',
			'user_font_arial' => 'arial',
			'user_font_tahoma' => 'tahoma',
			'user_font_century' => 'century',
			'user_font_comicSansMS' => 'comic sans ms',
			'user_font_jester' => 'jester',
			'user_font_trebuchetMS' => 'trebuchet ms',
			'user_font_timesNewRoman' => 'times new roman',
			'user_font_lucidaSans' => 'lucida sans',
			'user_font_teletype' => 'teletype'
		);

		// i'm lazy... so what
		ksort($fonts);

		// build html
		foreach($fonts as $key => $val) {
			$temp = new StyleFragment('bbcode_fontbit');
			$fontBits .= $temp->dump();
		}

		// now build the sizes
		$sizes = Array(
				6, 8, 10, 12, 14,
				16, 18, 22, 26, 32,
				36, 48, 60, 72
			);

		foreach($sizes as $val) {
			$temp = new StyleFragment('bbcode_sizebit');
			$sizeBits .= $temp->dump();
		}

		$temp = new StyleFragment('bbcode');

		return $temp->dump();
	}
}
