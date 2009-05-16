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
## ************ RECURSIVE FORUM ITERATOR ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// recusively loops through forums
class RecursiveForumIterator extends ForumIterator implements RecursiveIterator {
	private $depth, $limit;

	// Constructor
	public function __construct($parent = -1, $forumLimit = 0) {
		global $orderedForums, $forums, $User;

		parent::__construct($parent);
		$this->limit = $forumLimit;
	}

	public function hasChildren() {
		return (isset($this->oForums[$this->forum->info['forumid']]));
	}

	public function getChildren() {
		return new RecursiveForumIterator($this->forum->info['forumid'], $this->limit);
	}
}
