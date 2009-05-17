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
## ***************** FORUM ITERATOR ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// iterates through forums
class ForumIterator implements Iterator {
	protected $forum, $parent, $oForums, $foruminfo, $count;

	// Constructor
	public function __construct($parent = -1) {
		global $orderedForums, $forums, $query, $wtcDB, $User;

		if(!is_array($forums) OR !is_array($orderedForums)) {
			$forums = Cache::load('forums');
			$orderedForums = Cache::load('orderedForums');
		}

		if(!is_array($forums) OR !is_array($orderedForums)) {
			Forum::init();
		}

		$this->oForums = $orderedForums;
		$this->foruminfo = $forums;
		$this->parent = $parent;

		// bleh...
		if(!is_array($this->oForums["$this->parent"])) {
			return false;
		}

		$this->forum = $this->foruminfo[current($this->oForums["$this->parent"])];
		$this->count = 0;
	}

	public function next() {
		$this->forum = $this->foruminfo[next($this->oForums["$this->parent"])];
	}

	public function rewind() {
		reset($this->oForums);
	}

	public function current() {
		return $this->forum;
	}

	public function valid() {
		if($this->forum instanceof Forum) {
			return true;
		}

		else {
			return false;
		}
	}

	public function key() {
		return ++$this->count;
	}
}

?>