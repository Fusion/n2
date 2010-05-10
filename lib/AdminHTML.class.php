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
## ******************* ADMIN HTML ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class AdminHTML {
	private $stylesheet, $extra, $extra2, $title, $type, $tableOpts;
	private static $alt = 'alt1', $opt = 1;

	// Constructor - Allow Immediate Printing
	public function __construct($pageType, $pageTitle = '', $output = false, $table = '') {
		global $lang;

		$this->title = $pageTitle;
		$this->type = $pageType;
		$this->stylesheet = './css/adminContent.css';
		$this->tableOpts = $table;

		/**
		 * Lots of configurations...
		 * I guess it makes HTML for admin panel easier...
		 * Just takes a lot of referencing back to see which
		 * names to use... But it's better than re-writing something
		 * many times over!
		 */
		if(isset($this->tableOpts['extra2'])) {
			$this->extra2 = $this->tableOpts['extra2'];
		}

		if(!isset($this->tableOpts['method'])) {
			$this->tableOpts['method'] = 'post';
		}

		if(!isset($this->tableOpts['action'])) {
			$this->tableOpts['action'] = '';
		}

		if(!isset($this->tableOpts['colspan'])) {
			$this->tableOpts['colspan'] = 2;
		}

		if(!isset($this->tableOpts['submitText'])) {
			$this->tableOpts['submitText'] = $lang['admin_save'];
		}

		if(!isset($this->tableOpts['checkboxType'])) {
			$this->tableOpts['checkboxType'] = $lang['admin_yes'];
		}

		if(!isset($this->tableOpts['showTitle'])) {
			$this->tableOpts['showTitle'] = true;
		}

		if(!isset($this->tableOpts['upload'])) {
			$this->tableOpts['upload'] = false;
		}

		if(!isset($this->tableOpts['form']) AND ($pageType == 'tableBegin' OR $pageType == 'tableEnd')) {
			$this->tableOpts['form'] = 1;
		}

		if(!isset($this->tableOpts['noForm'])) {
			$this->tableOpts['noForm'] = false;
		}

		else if(!isset($this->tableOpts['form'])) {
			$this->tableOpts['form'] = 0;
		}

		if($output) {
			$this->dump();
		}
	}

	// Public Methods
	public function dump() {
		if($this->tableOpts['return']) {
			@ob_start();
		}

		// which HTML to spit out?
		switch($this->type) {
			case 'loginScreen':
				$this->loginScreen();
			break;

			case 'header':
				$this->header();
			break;

			case 'footer':
				$this->footer();
			break;

			case 'navBox':
				$this->navBox();
			break;

			case 'tableBegin':
				$this->tableBegin();
			break;

			case 'tableEnd':
				$this->tableEnd();
			break;

			case 'tableRow':
				$this->tableRow();
				AdminHTML::switchAlt();
			break;

			case 'tableCells':
				$this->tableCells();
				AdminHTML::switchAlt();
			break;

			case 'bigTextarea':
				$this->bigTextarea();
				AdminHTML::switchAlt();
			break;

			case 'locationSelect':
				$this->locationSelect();
			break;

			case 'allYesNo':
				$this->allYesNo();
			break;

			case 'divit':
				$this->divit();
			break;

			case 'divitBox':
				$this->divitBox();
			break;

			default:
				$this->whoops();
			break;
		}

		if($this->tableOpts['return']) {
			$return = @ob_get_contents();
			@ob_end_clean();
			return $return;
		}
	}

	public function setExtra($pageExtra) {
		$this->extra = $pageExtra;
	}

	public function setStylesheet($pageStyle) {
		$this->stylesheet = $pageStyle;
	}

	public function setType($pageType) {
		$this->type = $pageType;
	}

	// Private Methods (actual HTML)
	private function whoops() {
		print('<span style="color: #bb0000; font-weight: bold; font-size: 150%;">You are calling a non-existant admin html template: <em>' . $this->type . '</em></span>');
	}

	private function loginScreen() {
		global $lang;

		print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n");
		print('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">' . "\n");
		print('<head>' . "\n");
			print("\t" . '<title> ' . $lang['admin_title'] . ' - ' . $this->title . ' </title>' . "\n");
			print("\t" . '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />' . "\n");
			print("\t" . '<style type="text/css"> @import "' . $this->stylesheet . '"; </style>' . "\n\n");
		print('</head>' . "\n");
		print('<body>' . "\n");
			print('    <div id="container">' . "\n");

				print("\t" . '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">' . "\n");
					print("\t\t" . '<table cellspacing="0" cellpadding="0" id="login">' . "\n");
						print("\t\t\t" . '<tr>' . "\n");
							print("\t\t\t\t" . '<th class="header" colspan="2">' . $lang['admin_login'] . '</th>' . "\n");
						print("\t\t\t" . '</tr>' . "\n\n");

						print("\t\t\t" . '<tr>' . "\n");
							print("\t\t\t\t" . '<td><strong>' . $lang['users_username'] . ':</strong></td>' . "\n");
							print("\t\t\t\t" . '<td><input type="text" id="username" name="login[username]" value="' . Cookie::get('adminUsername') . '" class="text" /></td>' . "\n");
						print("\t\t\t" . '</tr>' . "\n\n");

						print("\t\t\t" . '<tr>' . "\n");
							print("\t\t\t\t" . '<td><strong>' . $lang['users_password'] . ':</strong></td>' . "\n");
							print("\t\t\t\t" . '<td><input type="password" id="password" name="login[password]" value="" class="text" /></td>' . "\n");
						print("\t\t\t" . '</tr>' . "\n\n");

						print("\t\t\t" . '<tr>' . "\n");
							print("\t\t\t\t" . '<td class="header center" colspan="2"><input type="submit" value="' . $lang['admin_save'] . '" class="button" /></td>' . "\n");
						print("\t\t\t" . '</tr>' . "\n");
					print("\t\t" . '</table>' . "\n");
				print("\t" . '</form>' . "\n\n");

				print("\t" . '<script type="text/javascript">' . "\n");

				if(Cookie::get('adminUsername')) {
					print("\t\t" . '(document.getElementById("password")).focus();' . "\n");
				}

				else {
					print("\t\t" . '(document.getElementById("username")).focus();' . "\n");
				}

				print("\t" . '</script>' . "\n");

			print('    </div>' . "\n");
		print('</body>' . "\n");
		print('</html>');

		exit;
	}

	private function header() {
		global $lang, $bboptions;

		print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n");
		print('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">' . "\n");
		print('<head>' . "\n");
			print("\t" . '<title> ' . ((!$_GET['windowEdit']) ? ($lang['admin_title'] . ' - ') : ('')) . $this->title . ' </title>' . "\n");
			print("\t" . '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />' . "\n");
			print("\t" . '<style type="text/css"> @import "' . $this->stylesheet . '"; </style>' . "\n\n");

			print("\t" . '<script type="text/javascript">' . "\n");
				print("\t\t" . 'var cookiePrefix = "' . WTC_COOKIE_PREFIX . '";' . "\n");
				print("\t\t" . 'var wtcBBDomain = "' . $bboptions['cookDomain'] . '";' . "\n");
				print("\t\t" . 'var wtcBBPath = "' . $bboptions['cookPath'] . '";' . "\n");
			print("\t" . '</script>' . "\n\n");

			if(!empty($this->extra)) {
				print("\t" . $this->extra . "\n");
			}

                        print("\t" . '<script type="text/javascript" src="./scripts/jquery.js"></script>' . "\n");
			print("\t" . '<script type="text/javascript" src="./scripts/wtcBBLib.js"></script>' . "\n");
			print("\t" . '<script type="text/javascript" src="./scripts/expandCollapse.js"></script>' . "\n");

		print('</head>' . "\n");
		print('<body>' . "\n");
			print('    <div id="container">' . "\n");
			if($_GET['file'] == 'navigation') {
				 print('<div><img src=./images/wtcBB-Default/n2_hangtag_2.png></div>');
			}
			if(!$_GET['windowEdit'] AND $this->tableOpts['showTitle'] AND !empty($this->title)) {
				print("\t" . '<h1>' . $this->title . '</h1>' . "\n\n");
			}

			if(!empty($this->extra2)) {
				print($this->extra2);
			}

			if($this->tableOpts['form']) {
				// set action... if it's get use PHP_SELF, otherwise REQUEST_URI (if action is empty)
				if(empty($this->tableOpts['action'])) {
					if($this->tableOpts['method'] == 'get') {
						$this->tableOpts['action'] = $_SERVER['PHP_SELF'];
					}

					else {
						$this->tableOpts['action'] = $_SERVER['REQUEST_URI'];
					}
				}

				print("\t" . '<form method="' . $this->tableOpts['method'] . '" action="' . $this->tableOpts['action'] . '">' . "\n");

				if($this->tableOpts['method'] == 'post') {
					print("\t\t" . '<input type="hidden" name="formSet" value="1" />' . "\n");
				}

				if(is_array($this->tableOpts['hiddenInputs'])) {
					foreach($this->tableOpts['hiddenInputs'] as $name => $v) {
						print("\t\t" . '<input type="hidden" name="' . $name . '" value="' . $v . '" />' . "\n");
					}
				}

				print("\n");
			}
	}

	private function footer() {
		global $wtcDB, $startTime;

		if(!empty($this->extra)) {
			print("\t" . $this->extra . "\n");
		}

			if($this->tableOpts['form']) {
				print("\t" . '</form>' . "\n");
			}

			if(AREA != 'ADMIN-NAVIGATION') {
                               
				print("\t" . '<p class="center noMar"><a href="http://www.wtcbb.com/" target="_blank">Copyright (C) 2009 Chris F. Ravenscroft</a></p>' . "\n");

				if($wtcDB instanceof WtcDBA) {
					print("\t" . '<p class="center noMar">Queries: ' . $wtcDB->getQueryCount() . ' | Execution Time: ' . pageLoadTime() . '</p>' . "\n");
				}
			}

			print('    </div>' . "\n");
		print('</body>' . "\n");
		print('</html>');
	}

	private function divitBox() {
		print("\t" . '<div class="divit">' . "\n");
			print("\t\t" . '<h3>' . $this->title['title'] . '</h3>' . "\n\n");
			print("\t\t" . '<div class="divitit">' . "\n");
				print($this->title['content']);
			print("\t\t" . '</div>' . "\n");
		print("\t" . '</div>' . "\n\n");
	}

	private function divit() {
		$classes = '';

		if(!empty($this->title['class'])) {
			$classes = ' ' . $this->title['class'];
		}

		print("\t" . '<div class="divit' . $classes . '">' . "\n");
			print("\t\t" . '<div class="likeH3">' . "\n");
				print("\t\t\t" . $this->title['content'] . "\n");
			print("\t\t" . '</div>' . "\n");
		print("\t" . '</div>' . "\n\n");
	}

	private function navBox() {
		// strip spaces...
		$noSpaces = preg_replace('/\s+/', '', $this->title['main']);

		print("\t" . '<h2 class="exCol_dblclick_' . $noSpaces . '"><img src="./images/admin/collapse.png" alt="Expand" id="' . $noSpaces . '_img" class="exCol_click_' . $noSpaces . '" /> ' . $this->title['main'] . '</h2>' . "\n");
		print("\t" . '<div class="navBox exCo" id="' . $noSpaces . '">' . "\n");
			print("\t\t" . '<ul>' . "\n");
				foreach($this->title as $linkTitle => $linkHref) {
					if($linkTitle == 'main') {
						continue;
					}

					print("\t\t\t" . '<li><a href="' . $linkHref . '" target="content">' . $linkTitle . '</a></li>' . "\n");
				}
			print("\t\t" . '</ul>' . "\n");
		print("\t" . '</div>' . "\n");
	}

	private function tableBegin() {
		global $lang;

		if($this->tableOpts['form']) {
			$upload = '';

			if($this->tableOpts['upload']) {
				$upload = ' enctype="multipart/form-data"';
			}

			// set action... if it's get use PHP_SELF, otherwise REQUEST_URI (if action is empty)
			if(empty($this->tableOpts['action'])) {
				if($this->tableOpts['method'] == 'get') {
					$this->tableOpts['action'] = $_SERVER['PHP_SELF'];
				}

				else {
					$this->tableOpts['action'] = $_SERVER['REQUEST_URI'];
				}
			}

			print("\t" . '<form method="' . $this->tableOpts['method'] . '" action="' . $this->tableOpts['action'] . '"' . $upload .'>' . "\n");

			if($this->tableOpts['method'] == 'post') {
				print("\t\t" . '<input type="hidden" name="formSet" value="1" />' . "\n");
			}

			if(is_array($this->tableOpts['hiddenInputs'])) {
				foreach($this->tableOpts['hiddenInputs'] as $name => $v) {
					print("\t\t" . '<input type="hidden" name="' . $name . '" value="' . $v . '" />' . "\n");
				}
			}

			print("\n");
		}

			$tableClass = ' class="admintable"';

			if(!empty($this->tableOpts['tableClass'])) {
				$tableClass = ' class="' . $this->tableOpts['tableClass'] . '"';
			}

			print("\t\t" . '<table cellspacing="0" cellpadding="0"' . $tableClass . '>' . "\n");
				print("\t\t\t" . '<tr>' . "\n");

				if(!$this->tableOpts['noTh']) {
					print("\t\t\t\t" . '<th colspan="' . $this->tableOpts['colspan'] . '"' . (isset($this->tableOpts['class']) ? ' class="' . $this->tableOpts['class'] . '"' : '') . '>' . $this->title . '</th>' . "\n");
				}

				print("\t\t\t" . '</tr>' . "\n\n");

			if(isset($this->tableOpts['headers'])) {
				print("\t\t\t" . '<tr>' . "\n");

				foreach($this->tableOpts['headers'] as $name => $link) {
					if(!empty($name) AND !empty($link)) {
						print("\t\t\t\t" . '<th><a href="' . $link . '">' . $name . '</a></th>' . "\n\n");
					}

					else {
						print("\t\t\t\t" . '<th>' . $link . '</th>' . "\n\n");
					}
				}

				print("\t\t\t" . '</tr>' . "\n\n");
			}
	}

	private function tableEnd() {
		global $lang;

				print("\t\t\t" . '<tr>' . "\n");
					print("\t\t\t\t" . '<th colspan="' . $this->tableOpts['colspan'] . '" class="footer">' . "\n");

					if($this->tableOpts['footerText']) {
						print("\t\t\t\t\t" . $this->tableOpts['footerText'] . "\n");
					}

					else if($this->tableOpts['form']) {
						print("\t\t\t\t\t" . '<input type="submit" value="' . $this->tableOpts['submitText'] . '" class="button" />  <input type="reset" value="' . $lang['admin_reset'] . '" class="button" />' . "\n");
					}

					else {
						print("\t\t\t\t\t" . '&nbsp;' . "\n");
					}

					print("\t\t\t\t" . '</th>' . "\n");
				print("\t\t\t" . '</tr>' . "\n");
			print("\t\t" . '</table>' . "\n");

		if($this->tableOpts['form'] > 0) {
			print("\t" . '</form>' . "\n");
		}

		print("\n");
	}

	private function locationSelect() {
		global $lang;

		if(!$this->tableOpts['noForm']) print("\t\t\t\t\t" . '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="noMar">' . "\n");
			if($this->tableOpts['message']) {
				print("\t\t\t\t\t\t" . $this->tableOpts['message'] . "\n");
			}

			print("\t\t\t\t\t\t" . '<select name="opt' . AdminHTML::$opt . '" onchange="wtcBB.selectLoc(form.opt' . AdminHTML::$opt . ');">' . "\n");

			foreach($this->tableOpts['locs'] as $loc => $dis) {
				$selected = '';

				if($this->tableOpts['select'] == $dis) {
					$selected = ' selected="selected"';
				}

				if($this->tableOpts['disable'] && $this->tableOpts['disable'] == $loc{0}) {
					print("\t\t\t\t\t\t\t" . '<option disabled="disabled" value="' . $loc . '"' . $selected . '>' . $dis . '</option>' . "\n");
				}
				else {
					print("\t\t\t\t\t\t\t" . '<option value="' . $loc . '"' . $selected . '>' . $dis . '</option>' . "\n");
				}
			}
			print("\t\t\t\t\t\t" . '</select>' . "\n");
			print("\t\t\t\t\t\t" . '<input type="button" value="' . $lang['admin_go'] . '" class="button" onclick="wtcBB.selectLoc(form.opt' . AdminHTML::$opt . ');" />' . "\n");
		if(!$this->tableOpts['noForm']) print("\t\t\t\t\t" . '</form>' . "\n");

		AdminHTML::$opt++;
	}

	private function allYesNo() {
		global $lang;

		print("\t\t\t\t\t" . '<label for="allYes"><input type="radio" name="all" id="allYes" value="1" onclick="wtcBB.tickAllYes(this.form);" /> ' . $lang['admin_allYes'] . '</label>' . "\n");
		print("\t\t\t\t\t" . '<label for="allNo"><input type="radio" name="all" id="allNo" value="0" onclick="wtcBB.tickAllNo(this.form);" /> ' . $lang['admin_allNo'] . '</label>' . "\n");
	}

	private function tableCells() {
		global $lang;

		print("\t\t\t" . '<tr>' . "\n");

		foreach($this->tableOpts['cells'] as $cellTitle => $cellinfo) {
			$class = '';
			$colspan= '';
			$fullTitle = $cellTitle;

			if(isset($cellinfo['class'])) {
				$class = ' class="' . $cellinfo['class'] . '"';
			}

			if(isset($cellinfo['colspan'])) {
				$colspan = ' colspan="' . $cellinfo['colspan'] . '"';
			}

			if(isset($cellinfo['bold'])) {
				$fullTitle = '<strong>' . $fullTitle . '</strong>';
			}

			if(isset($cellinfo['small'])) {
				$fullTitle = '<span class="small">' . $fullTitle . '</span>';
			}

			if($cellinfo['th']) {
				print("\t\t\t\t" . '<th' . $class . $colspan . '>' . "\n");
					print("\t\t\t\t\t" . $fullTitle . "\n");
				print("\t\t\t\t" . '</th>' . "\n\n");

				// couteract alt switch
				AdminHTML::switchAlt();
			}

			else {
				// add in alt...
				// make sure it's not a header td
				if(strpos($cellinfo['class'], 'header') === false AND strpos($cellinfo['class'], 'noAlt') === false) {
					if(empty($class)) {
						$class = ' class="' . AdminHTML::$alt . '"';
					}

					else {
						// get rid of last quote, and add in alt
						$class = preg_replace('/"$/', ' ' . AdminHTML::$alt . '"', $class);
					}
				}

				else {
					// like before... counteract alt switch
					AdminHTML::switchAlt();
				}

				print("\t\t\t\t" . '<td' . $class . $colspan . '>' . "\n");
					print("\t\t\t\t\t" . $fullTitle . "\n");
				print("\t\t\t\t" . '</td>' . "\n\n");
			}
		}

		print("\t\t\t" . '</tr>' . "\n\n");
	}

	private function bigTextarea() {
		print("\t\t\t" . '<tr>' . "\n");
			print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . ' center" colspan="2">' . "\n");
				print("\t\t\t\t\t" . '<p class="left emphasis">' . $this->title['title'] . '</p>' . "\n");
				print("\t\t\t\t\t" . '<textarea name="' . $this->title['name'] . '" id="' .
					str_replace(array('[', ']'), array('_', '_'), $this->title['name']) .
					'" class="bigArea' . $this->title['class'] . '">' . wtcspecialchars($this->title['value']) . '</textarea>' . "\n");
			print("\t\t\t\t" . '</td>' . "\n\n");
		print("\t\t\t" . '</tr>' . "\n\n");
		
	}

	public static function formatBigTextArea($areaName) {
		$areaName = str_replace(array('[', ']'), array('_', '_'), $areaName);
		print(
			"\t<script src=\"" . HOME . "includes/thirdparty/codemirror/js/codemirror.js\" type=\"text/javascript\"></script>\n" .
			"\t<script type=\"text/javascript\">\n" .
			"\t\tCodeMirror.fromTextArea('{$areaName}', {\n" .
			"\t\t\theight: \"350px\",\n" .
			"\t\t\tparserfile: [\"parsexml.js\", \"parsecss.js\", \"tokenizejavascript.js\", \"parsejavascript.js\", \"parsehtmlmixed.js\"],\n" .
		    "\t\t\tstylesheet: [\n" .
		    "\t\t\t\t\"" . HOME . "includes/thirdparty/codemirror/css/xmlcolors.css\",\n" .
		    "\t\t\t\t\"" . HOME . "includes/thirdparty/codemirrorcss/jscolors.css\",\n" .
		    "\t\t\t\t\"" . HOME . "includes/thirdparty/codemirrorcss/csscolors.css\"\n" .
		    "\t\t\t],\n" .			
			"\t\t\tpath: \"" . HOME . "includes/thirdparty/codemirror/js/\",\n" .
			"\t\t\tcontinuousScanning: 500,\n" .
			"\t\t\tlineNumbers: false,\n" .
			"\t\t\ttextWrapping: false,\n" .
			"\t\t\tautoMatchParens: true\n" .
			"\t\t});\n" .
			"\t</script>\n");
	}
	
	private function tableRow() {
		global $lang;

		print("\t\t\t" . '<tr>' . "\n");
			print("\t\t\t\t" . '<td class="top ' . AdminHTML::$alt . '">' . "\n");
				print("\t\t\t\t\t" . '<p><strong>' . $this->title['title'] . '</strong></p>' . "\n");
				print("\t\t\t\t\t" . '<p class="small">' . $this->title['desc'] . '</p>' . "\n");
			print("\t\t\t\t" . '</td>' . "\n\n");

			switch($this->title['type']) {
				case 'dateTime':
				case 'date':
					print("\t\t\t\t" . '<td class="nowrap ' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<table cellspacing="0" cellpadding="0" class="dateTime">' . "\n");
							print("\t\t\t\t\t\t" . '<tr>' . "\n");
								print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_month'] . '</th>' . "\n");
								print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_day'] . '</th>' . "\n");
								print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_year'] . '</th>' . "\n");

								if($this->title['type'] == 'dateTime') {
									print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_hour'] . '</th>' . "\n");
									print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_minute'] . '</th>' . "\n");
									print("\t\t\t\t\t\t\t" . '<th>' . $lang['dates_ampm'] . '</th>' . "\n");
								}
							print("\t\t\t\t\t\t" . '</tr>' . "\n\n");

							print("\t\t\t\t\t\t" . '<tr>' . "\n");
								print("\t\t\t\t\t\t\t" . '<td>' . WtcDate::getMonths($this->title['month']['name'], $this->title['month']['value']) . '</td>' . "\n");
								print("\t\t\t\t\t\t\t" . '<td>' . WtcDate::getDays($this->title['day']['name'], $this->title['day']['value']) . '</td>' . "\n");
								print("\t\t\t\t\t\t\t" . '<td>' . WtcDate::getYears($this->title['year']['name'], $this->title['year']['value']) . '</td>' . "\n");

								if($this->title['type'] == 'dateTime') {
									print("\t\t\t\t\t\t\t" . '<td><input type="text" name="' . $this->title['hour']['name'] . '" value="' . wtcspecialchars($this->title['hour']['value']) . '" class="text" /></td>' . "\n");
									print("\t\t\t\t\t\t\t" . '<td><input type="text" name="' . $this->title['minute']['name'] . '" value="' . wtcspecialchars($this->title['minute']['value']) . '" class="text" /></td>' . "\n");
									print("\t\t\t\t\t\t\t" . '<td>' . WtcDate::getAmPm($this->title['ampm']['name'], $this->title['ampm']['value']) . '</td>' . "\n");
								}
							print("\t\t\t\t\t\t" . '</tr>' . "\n");
						print("\t\t\t\t\t" . '</table>' . "\n");
					print("\t\t\t\t" . '</td>' . "\n");
				break;

				case 'checkbox':
					$checkedYes = ''; $checkedNo = ' checked="checked"';

					if(!isset($this->title['actualValue'])) {
						$this->title['actualValue'] = 1;
					}

					if($this->title['value'] == $this->title['actualValue']) {
						$checkedYes = ' checked="checked"';
						$checkedNo = '';
					}

					print("\t\t\t\t" . '<td class="nowrap ' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<label for="' . $this->title['name'] . '_yes"><input type="radio" name="' . $this->title['name'] . '" id="' . $this->title['name'] . '_yes" value="' . $this->title['actualValue'] . '"' . $checkedYes . ' /> ' . $lang['admin_yes'] . '</label>' . "\n");
						print("\t\t\t\t\t" . '<label for="' . $this->title['name'] . '_no"><input type="radio" name="' . $this->title['name'] . '" id="' . $this->title['name'] . '_no" value="0"' . $checkedNo . ' /> ' . $lang['admin_no'] . '</label>' . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'text':
				case 'advanced':
					// html?
					$this->title['value'] = wtcspecialchars($this->title['value']);

					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<input type="text" class="text' . $this->title['class'] . '" name="' . $this->title['name'] . '" value="' . $this->title['value'] . '" />' . "\n");

						if($this->title['addRevert']) {
							print("\t\t\t\t\t" . '<label for="revert_' . $this->title['name'] . '"><input type="checkbox" name="revert_' . $this->title['name'] . '" id="revert_' . $this->title['name'] . '" /> <strong>' . $lang['admin_style_revert'] . '</strong></label>' . "\n");
						}
						
						if($this->title['type'] == 'advanced')
							print($lang['admin_info_advanced']);
						
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'textColor':
					// html?
					$this->title['value'] = wtcspecialchars($this->title['value']);

					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<input type="text" class="text floatLeft' . $this->title['class'] . '" name="' . $this->title['name'] . '" value="' . $this->title['value'] . '" onblur="wtcBB.colorViewer(\'' . str_replace(Array('[', ']'), Array('', ''), $this->title['name']) . '\', this);" />' . "\n");

						$addBg = '';

						if(!empty($this->title['value'])) {
							 $addBg = ' style="background: ' . $this->title['value'] . ';"';
						}

						print("\t\t\t\t\t" . '<div class="colorBox" id="' . str_replace(Array('[', ']'), Array('', ''), $this->title['name']) . '"' . $addBg . '>&nbsp;</div>' . "\n");

						if($this->title['addRevert']) {
							print("\t\t\t\t\t" . '<label for="revert_' . $this->title['name'] . '"><input type="checkbox" name="revert_' . $this->title['name'] . '" id="revert_' . $this->title['name'] . '" /> <strong>' . $lang['admin_style_revert'] . '</strong></label>' . "\n");
						}
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'plainText':
					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . $this->title['value'] . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'file':
					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<input type="file" class="text" name="' . $this->title['name'] . '" value="' . wtcspecialchars($this->title['value']) . '" />' . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'textarea':
					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<textarea name="' . $this->title['name'] . '" class="norm">' . wtcspecialchars($this->title['value']) . '</textarea>' . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'select':
					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<select name="'. $this->title['name'] . '">' . "\n");

						foreach($this->title['select']['fields'] as $show => $value) {
							$disabled = '';
							$selected = '';

							if(is_array($value)) {
								if($this->title['select']['select'] == $value['value']) {
									$selected = ' selected="selected"';
								}

								if($value['disabled']) {
									$disabled = ' disabled="disabled"';
								}

								$value = $value['value'];
							}

							else {
								if($this->title['select']['select'] == $value) {
									$selected = ' selected="selected"';
								}
							}

							print("\t\t\t\t\t\t" . '<option value="' . $value . '"' . $selected . $disabled . '>' . $show . '</option>' . "\n");
						}

						print("\t\t\t\t\t" . '</select>' . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;

				case 'multiple':
					print("\t\t\t\t" . '<td class="' . AdminHTML::$alt . '">' . "\n");
						print("\t\t\t\t\t" . '<select name="'. $this->title['name'] . '" multiple="multiple" class="multiple">' . "\n");

						foreach($this->title['select']['fields'] as $show => $value) {
							$selected = '';

							if(strpos($this->title['select']['select'], ',') !== false) {
								$kaboom = explode(',', $this->title['select']['select']);

								if(in_array($value, $kaboom)) {
									$selected = ' selected="selected"';
								}
							}

							else {
								if($this->title['select']['select'] == $value) {
									$selected = ' selected="selected"';
								}
							}

							print("\t\t\t\t\t\t" . '<option value="' . $value . '"' . $selected . '>' . $show . '</option>' . "\n");
						}

						print("\t\t\t\t\t" . '</select>' . "\n");
					print("\t\t\t\t" . '</td>' . "\n\n");
				break;
			}

		print("\t\t\t" . '</tr>' . "\n\n");
	}

	/**
	 * Public Static Functions
	 */
	// switches the alt
	public static function switchAlt() {
		if(AdminHTML::$alt == 'alt1') {
			AdminHTML::$alt = 'alt2';
		}

		else {
			AdminHTML::$alt = 'alt1';
		}
	}
}
