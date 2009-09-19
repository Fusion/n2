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
## ****************** GROUP CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * Serves as a general purpose class for groups of all types (not usergroups):
 * Template Groups
 * Smiley/Post Icon Groups
 * Avatar Groups
 * Language Groups
 ** Should also be used for any other groups that may be needed.
 */

class Group extends Object {
	private $groupid, $info;

	// Constructor
	public function __construct($id = '', $groupinfo = '') {
		global $lang;

		if(!empty($groupinfo) AND is_array($groupinfo)) {
			$this->info = $groupinfo;
			$this->groupid = $this->info['groupid'];
		}

		else if(!empty($id)) {
			$this->groupid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// unserialize groupids to make'em ready for use
		$this->info['usergroupids'] = unserialize($this->info['usergroupids']);
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		// make sure we can delete...
		if(!$this->isDeletable()) {
			//new WtcBBException($lang['admin_error_cannotDeleteGroup']);
		}

		new Delete('groups', 'groupid', $this->groupid, '');
		new Delete($this->getGroupType(), ($this->getGroupType() == 'lang_words') ? 'catid' : 'groupid', $this->groupid, '');

		new Cache('GeneralGroups');
		new Cache('OrderedGroups');
	}

	// Updates smiley... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['groups']['update'], Array(1 => $update, 2 => $this->groupid), 'query', false);

		new Cache('GeneralGroups');
		new Cache('OrderedGroups');
	}

	// Checks to see if this group is a parent
	// of the specified group
	// can also accept an array of groupids as keys to check
	public function isChild($groupid) {
		// create iterator
		$groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator($this->getGroupType(), $this->getGroupId()), true);

		// array?
		if(is_array($groupid)) {
			foreach($groupIter as $obj) {
				if(isset($groupid[$obj->getGroupId()])) {
					return true;
				}
			}
		}

		else {
			foreach($groupIter as $obj) {
				if($obj->getGroupId() == $groupid) {
					return true;
				}
			}
		}

		return false;
	}

	// Checks to see if this group is a child
	// of the specified group
	// can also accept an array of groupids as keys to check
	public function isParent($groupid) {
		// array?
		if(is_array($groupid)) {
			foreach($groupid as $gid => $meh) {
				$groupIter = new GroupIterator($this->getGroupType(), $gid);

				foreach($groupIter as $obj) {
					if($obj->getGroupId() == $this->getGroupId()) {
						return true;
					}
				}
			}
		}

		else {
			$groupIter = new GroupIterator($this->getGroupType(), $groupid);

			foreach($groupIter as $obj) {
				if($obj->getGroupId() == $this->getGroupId()) {
					return true;
				}
			}
		}

		return false;
	}

	// Checks to see if the two groups are siblings
	// can also accept an array of groupids as keys to check
	public function isSibling($groupid) {
		// create iterator
		$groupIter = new GroupIterator($this->getGroupType(), $this->getParentId());

		// array?
		if(is_array($groupid)) {
			foreach($groupIter as $obj) {
				if(isset($groupid[$obj->getGroupId()])) {
					return true;
				}
			}
		}

		else {
			foreach($groupIter as $obj) {
				if($obj->getGroupId() == $groupid) {
					return true;
				}
			}
		}

		return false;
	}

	// this checks for... hmm... aunts and uncles?
	// use sparingly... can be O(n^3)
	public function isAuntOrUncle($groupid) {
		$groupIter = new GroupIterator($this->getGroupType(), $this->getParentId());

		// array?
		if(is_array($groupid)) {
			foreach($groupIter as $obj) {
				foreach($groupid as $gid => $meh) {
					if($obj->isChild($gid)) {
						return true;
					}
				}
			}
		}

		else {
			foreach($groupIter as $obj) {
				if($obj->isChild($groupid)) {
					return true;
				}
			}
		}

		return false;
	}

	// Accessors
	public function getGroupId() {
		return $this->groupid;
	}

	// Overwrite groupid...does not commit back to db.
	public function forceGroupId($groupid) {
		$this->groupid = $groupid;
	}

	public function getGroupUUID() {
		return $this->info['groupuuid'];
	}

	public function getGroupType() {
		return $this->info['groupType'];
	}

	public function getGroupName() {
		return $this->info['groupName'];
	}

	public function getParentId() {
		return $this->info['parentid'];
	}

	public function getUserGroupIds() {
		return $this->info['usergroupids'];
	}

	public function getDisOrder() {
		return $this->info['groupOrder'];
	}

	public function isDeletable() {
		return $this->info['deletable'];
	}

	public function getInfo() {
		return $this->info;
	}

	// has permissions to view this group?
	public function canView() {
		global $User;

		$allowedGroups = $this->getUserGroupIds();

		// all groups?
		if(in_array(-1, $allowedGroups)) {
			return true;
		}

		// now loop through groupids and check against
		// secondary groupids and primary groupid
		foreach($allowedGroups as $groupid) {
			if($groupid == $User->info['usergroupid'] OR (is_array($User->info['secgroupids']) AND in_array($groupid, $User->info['secgroupids']))) {
				return true;
			}
		}
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getGroup = new Query($query['groups']['get'], Array(1 => $this->groupid));

		$this->info = parent::queryInfoById($getGroup);
	}


	// Static Methods
	// Public
	// inserts group... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query, $lang;

		$db = $wtcDB->massInsert($arr);

		new Query($query['groups']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('GeneralGroups');
		new Cache('OrderedGroups');
	}

	// initializes groups
	public static function init() {
		global $wtcDB, $query, $_CACHE, $generalGroups;

		$generalGroups = Array();

		if(!($generalGroups = Cache::load('generalGroups'))) {
			$getGroups = new Query($query['groups']['get_all']);
			$generalGroups = Array();

			while($group = $getGroups->fetchArray()) {
				$generalGroups[$group['groupType']][$group['groupid']] = new Group('', $group);
			}
		}
	}
}
