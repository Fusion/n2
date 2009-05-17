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