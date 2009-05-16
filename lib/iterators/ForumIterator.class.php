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