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
## ************* PARENT FORUM ITERATOR ************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// iterates through forums (up the tree)
// mostly used for checking inherited stuff...
class ParentForumIterator implements Iterator {
	protected $forum, $start, $foruminfo, $count;
		
	// Constructor
	public function __construct($startForum = -1) {
		global $orderedForums, $forums, $query, $wtcDB;
		
		if(!isset($forums)) {
			Forum::init();
		}
			
		$this->foruminfo = $forums;
		$this->start = $startForum;
		
		// bleh...
		if($this->start == -1 OR !isset($this->foruminfo[$this->start])) {
			return;
		}
				
		$this->forum = $this->foruminfo[$this->foruminfo[$this->start]->info['forumid']];
		$this->count = 0;
	}
	
	public function next() {
		$this->forum = $this->foruminfo[$this->forum->info['parent']];
	}
	
	public function rewind() {
		$this->forum = $this->foruminfo[$this->foruminfo[$this->start]->info['parent']];
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