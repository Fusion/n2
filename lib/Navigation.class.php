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
