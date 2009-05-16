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
## ***************** Group ITERATOR ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// iterates through styles
class GroupIterator implements Iterator {
	protected $group, $parent, $oGroups, $groupinfo, $count;
		
	// Constructor
	public function __construct($groupType, $parent = -1) {
		global $orderedGroups, $generalGroups, $wtcDB, $query;

		// uh oh... no cache data? o_0
		// these arrays are global, so it will only do this once
		if(!isset($generalGroups) OR !is_array($generalGroups)) {
			$getGroups = new Query($query['groups']['get_all']);
			$generalGroups = Array();
			$orderedGroups = Array();
			
			while($group = $wtcDB->fetchArray($getGroups->getRes())) {
				$generalGroups[$group['groupType']][$group['groupid']] = new Group('', $group);
				$orderedGroups[$group['groupType']][$group['parentid']][$group['groupid']] = $group['groupid'];
			}
		}

		// only ordered?
		else if(!isset($orderedGroups) OR !is_array($orderedGroups)) {
			$getGroups = new Query($query['groups']['get_all']);
			$orderedGroups = Array();
			
			while($group = $wtcDB->fetchArray($getGroups->getRes())) {
				$orderedGroups[$group['groupType']][$group['parentid']][$group['groupid']] = $group['groupid'];
			}
		}
		
		$this->oGroups = $orderedGroups[$groupType];		
		$this->groupinfo = $generalGroups[$groupType];
		$this->parent = $parent;
		
		// bleh...
		if(!is_array($this->oGroups["$this->parent"])) {
			return false;
		}
				
		$this->group = $this->groupinfo[current($this->oGroups["$this->parent"])];
		$this->count = 0;
	}
	
	public function next() {
		$this->group = $this->groupinfo[next($this->oGroups["$this->parent"])];
	}
	
	public function rewind() {
		reset($this->oGroups);
	}
	
	public function current() {
		return $this->group;
	}
	
	public function valid() {
		if($this->group instanceof Group) {
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