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
## **************** NAVIGATION CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Navigation {
	private $path, $type, $navBits;

	// Constructor - Sets cookie
	public function __construct($path, $type = '') {
		$this->type = $type;
		$this->path = $path;
		$this->navBits = '';

		if($this->type == 'forum') {
			$this->buildForumNav();
		}

		// do the path
		if(is_array($this->path)) {
			$this->buildPath();
		}
	}

	// Private Methods
	// builds a forum nav...
	private function buildForumNav() {
		global $FORUM, $SESSURL, $navLink, $navName, $forums;

		$forumIter = new ParentForumIterator($FORUM->info['forumid']);

		foreach($forumIter as $forum) {
			$navLink = './index.php?file=forum&amp;f=' . $forum->info['forumid'] . $SESSURL;
			$navName = $forum->info['name'];

			$temp = new StyleFragment('navigation_linkBit');
			$this->navBits = $temp->dump() . $this->navBits;
		}

		if(is_array($this->path)) {
			$navLink = './index.php?file=forum&amp;f=' . $FORUM->info['forumid'] . $SESSURL;
			$navName = $FORUM->info['name'];

			$temp = new StyleFragment('navigation_linkBit');
			$this->navBits .= $temp->dump();
		}

		else {
			$navName = $FORUM->info['name'];

			$temp = new StyleFragment('navigation_nolinkBit');
			$this->navBits .= $temp->dump();
		}
	}

	// builds the path
	// path should be an associative array
	// (key) Language Var Name => (value) Link
	private function buildPath() {
		global $SESSURL, $navLink, $navName, $lang;

		foreach($this->path as $name => $link) {
			$navLink = $link . $SESSURL;
			$navName = $name;

			if(!empty($link)) {
				$temp = new StyleFragment('navigation_linkBit');
			}

			else {
				$temp = new StyleFragment('navigation_nolinkBit');
			}

			$this->navBits .= $temp->dump();
		}
	}

	// Public methods
	public function dump() {
		return $this->navBits;
	}
}
