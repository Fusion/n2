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
## ***************** MESSAGE CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

/**
 * This class is responsible for the parsing of any user message
 */

class Message {
	private $txt, $parseBBCode, $parseSmilies, $parseImages, $allowHtml;
	public static $maxChars = 80;

	// Constructor - Initializes Instance Variables
	public function __construct() {
		$this->txt = '';
		$this->parseBBCode = false;
		$this->parseSmilies = false;
		$this->parseImages = false;
		$this->allowHtml = false;
	}

	// Public Methods
	// Setters
	public function setBBCode($bool) {
		if($bool) {
			$this->parseBBCode = true;
		}

		else {
			$this->parseBBCode = false;
		}
	}

	public function setSmilies($bool) {
		if($bool) {
			$this->parseSmilies = true;
		}

		else {
			$this->parseSmilies = false;
		}
	}

	public function setImages($bool) {
		if($bool) {
			$this->parseImages = true;
		}

		else {
			$this->parseImages = false;
		}
	}

	public function setHtml($bool) {
		if($bool) {
			$this->allowHtml = true;
		}

		else {
			$this->allowHtml = false;
		}
	}

	// short cut... i'm lazy
	public function setOptions($bbcode, $smilies, $images, $html) {
		$this->setBBCode($bbcode);
		$this->setSmilies($smilies);
		$this->setImages($images);
		$this->setHtml($html);
	}

	// this will automatically figure out user post options
	// given a user and a post
	public function autoOptions($User, $Post) {
		// html?
		if($User->info['allowHtml']) {
			$this->setHtml(true);
		}

		else {
			$this->setHtml(false);
		}

		// bb code?
		if($Post->showBBCode() AND $User->check('canBBCode', $Post->getForumId())) {
			$this->setBBCode(true);
		}

		else {
			$this->setBBCode(false);
		}

		// smilies?
		if($Post->showSmilies() AND $User->check('canSmilies', $Post->getForumId())) {
			$this->setSmilies(true);
		}

		else {
			$this->setSmilies(false);
		}

		// images?
		if($User->check('canImg', $Post->getForumId())) {
			$this->setImages(true);
		}

		else {
			$this->setImages(false);
		}
	}

	// same as above, except globally (doesn't use forum perms)
	public function globalAutoOptions($User, $info) {
		// html?
		if($User->info['allowHtml']) {
			$this->setHtml(true);
		}

		else {
			$this->setHtml(false);
		}

		// bb code?
		if($info['bbcode'] AND $User->check('canBBCode')) {
			$this->setBBCode(true);
		}

		else {
			$this->setBBCode(false);
		}

		// smilies?
		if($info['smilies'] AND $User->check('canSmilies')) {
			$this->setSmilies(true);
		}

		else {
			$this->setSmilies(false);
		}

		// images?
		if($User->check('canImg')) {
			$this->setImages(true);
		}

		else {
			$this->setImages(false);
		}
	}

	// Parses the message and returns result
	public function parse($txt, $poster) {
		global $query, $wtcDB, $User, $bboptions;

		// just set it
		$this->txt = $txt;

		// parse URLs
		//$this->txt = preg_replace('/(?<!(?:\[(?:img|url)\]))(?<!url=)\b((?:https?|ftp):\/\/[-\w]+(?:\.\w[-\w]*)+(?:\d+)?(\/[^"\'<>()\[\]{}\s\x7F-\xFF]+)*)\b/', '[url=$1]$1[/url]', $this->txt); // thank you Jeffrey E. F. Friedl!
		$this->txt = preg_replace('/(^|\s|=|\])www\./isU', '$1http://www.', $this->txt);
		$this->txt = preg_replace('/(^|\s)(http:\/\/.+)($|\s|\n|\r\n|\[|\))/isU', '$1[url=$2]$2[/url]$3', $this->txt);

		// wordwrap!
		$this->txt = Message::wordwrap($this->txt);

		// strip HTML
		if(!$this->allowHtml) {
			$this->txt = wtcspecialchars($this->txt);
		}

		// now add some line breaks
		$this->txt = nl2br($this->txt);

		// parse smilies
		if($this->parseSmilies) {
			$this->txt = Smiley::parseAll($this->txt);
		}

		// now parse the BB Code...
		if($this->parseBBCode) {
			$this->txt = BBCode::parseAll($this->txt, $this->parseImages, $this->allowHtml);
		}

		// one last thing... remove BR's after lists... too much spacing
		$this->txt = preg_replace('/(<\/(?:o|u)l>)<br \/>/i', '$1', $this->txt);

		// alright I lied, one more thing... replace {poster} with username
		$this->txt = str_replace('{poster}', $poster, $this->txt);

		// censoring...
		$this->txt = $this->txt;

		return $this->txt;
	}

	// this method will "check" a message...
	// returning proper errors... returns the actual
	// message on success
	public function check($txt, $title) {
		global $query, $wtcDB, $bboptions, $lang, $User;

		// no txt?
		if($txt !== false) {
			// first, strip EMPTY codes
			$txt = BBCode::stripEmptyTags(trim($txt));

			// we'll return $retval
			// and manipulate $txt
			$retval = $txt;

			// okay, now strip ALL bb code and check char counts
			$txt = BBCode::stripAll($txt);
		}

		// don't forget about the title
		$title = trim($title);

		// don't forget to check overrides too...
		if(!$User->check('overridePostMinChars')) {
			if($txt !== false AND strlen($txt) < $bboptions['minMessageChars']) {
				return new WtcBBException($lang['error_message_underMinChars'] . ' <strong>' . $bboptions['minMessageChars'] . '</strong>', false);
			}

			if(strlen($title) < $bboptions['minTitleChars']) {
				return new WtcBBException($lang['error_message_underMinChars_title'] . ' <strong>' . $bboptions['minTitleChars'] . '</strong>', false);
			}
		}

		else {
			// at least make sure it isn't empty...
			if(($txt !== false AND empty($txt)) OR empty($title)) {
				return new WtcBBException($lang['error_message_empty'], false);
			}
		}

		if(!$User->check('overridePostMaxChars')) {
			if($txt !== false AND strlen($txt) > $bboptions['maxMessageChars']) {
				return new WtcBBException($lang['error_message_overMaxChars'] . ' <strong>' . $bboptions['maxMessageChars'] . '</strong>', false);
			}

			if(strlen($title) > $bboptions['maxTitleChars']) {
				return new WtcBBException($lang['error_message_overMaxChars_title'] . ' <strong>' . $bboptions['maxTitleChars'] . '</strong>', false);
			}
		}

		// now parse it, and find the number of images
		if($txt !== false) {
			// okay... revert back
			$txt = $retval;

			$txt = $this->parse($txt, $User->info['username']);

			if(!$User->check('overridePostMaxImages') AND $this->imageCount($txt) > $bboptions['maxMessageImgs']) {
				return new WtcBBException($lang['error_message_overMaxImgs'] . '<strong>' . $bboptions['maxMessageImgs'] . '</strong>', false);
			}
		}

		else {
			$retval = true;
		}

		// okay... we're all set
		return $retval;
	}

	// counts the number of images (HTML)
	public function imageCount($txt) {
		return substr_count($txt, '<img src');
	}

	// Static Methods
	// this will wrap the words (takes bb code into account
	public static function wordwrap($txt, $break = ' ') {
		$count = true;
		$wordLen = 0;
		$retval = '';
		$curTag = ''; $addToTag = false;

		for($i = 0; $i < strlen($txt); $i++) {
			$c = $txt[$i];

			if($addToTag) {
				if($c == ']' OR $c == '=') {
					$addToTag = false;
				}

				else {
					$curTag .= $c;
				}
			}

			if($c == '[') {
				$count = false;
				$addToTag = true;
				$curTag = '';
			}

			if($c == "\n" OR strtolower($curTag) == 'url' OR $c == ' ') {
				$wordLen = 0;
			}

			if($count) {
				$wordLen++;

				if($wordLen >= Message::$maxChars) {
					$retval .= ' ';
					$wordLen = 0;
				}
			}

			if($c == ']') {
				$count = true;

				if(strtolower($curTag) == '/url') {
					$curTag = '';
					$addToTag = false;
				}
			}

			$retval .= $c;
		}

		return $retval;
	}

	// this will construct the toolbar
	public static function buildToolBar() {
		global $bboptions, $smiley, $bbcodes, $postIcon, $attachBits;

		$smiley = Smiley::construct();
		$bbcodes = BBCode::construct();

		return (new StyleFragment('message_toolBar'));
	}

	// this will make a lighter toolbar (quick reply)
	public static function buildLiteToolBar() {
		global $bboptions, $bbcodes;

		$bbcodes = BBCode::liteConstruct();

		return (new StyleFragment('message_liteToolBar'));
	}

	// will build a DESC of a message (first line; no BB Code)
	public static function buildDesc($txt) {
		$retval = wtcspecialchars(trim($txt));
		$retval = preg_replace('/^([^\r\n]+).*$/s', '$1', $retval);

		// strip all BB Code...
		$retval = BBCode::stripAll($retval);

		return $retval;
	}
}
