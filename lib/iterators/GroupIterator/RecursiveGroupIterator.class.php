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
## ************ RECURSIVE GROUP ITERATOR ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// recusively loops through groups
class RecursiveGroupIterator extends GroupIterator implements RecursiveIterator {
	private $depth, $limit, $type;
	
	// Constructor
	public function __construct($groupType, $parent = -1, $groupLimit = 0) {
		global $orderedGroups, $groups;
		
		parent::__construct($groupType, $parent);
		$this->limit = $groupLimit;
		$this->type = $groupType;
	}
	
	public function hasChildren() {
		return (isset($this->oGroups[$this->group->getGroupId()]));
	}
	
	public function getChildren() {		
		return new RecursiveGroupIterator($this->type, $this->group->getGroupId(), $this->limit);
	}
}

?>