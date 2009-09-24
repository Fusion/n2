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
		if($this->oGroups) {
			reset($this->oGroups);
		}
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
