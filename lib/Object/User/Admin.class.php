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
## ****************** ADMIN CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Admin extends User {
	// assigns admin permissions
	public function assignAdmin($arr) {
		$this->admin = $arr;
	}

	// check an admin perm
	public function canAdmin($section) {
		if(strpos($section, '-') !== false) {
			$section = strtolower(substr($section, (strpos($section, '-') + 1)));
		}

		if($section == 'navigation' OR $section == 'index' OR $section == 'main') {
			return true;
		}

		if($this->isSuperAdmin()) {
			return true;
		}

		return $this->admin[$section];
	}


	// Protected Methods
	// gets user info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		if($this->userReq) {
			$getUser = new Query($query['admin']['get_user_byId_admin_req'], Array(1 => $this->userid));
		}

		else {
			$getUser = new Query($query['admin']['get_user_byId_admin'], Array(1 => $this->userid));
		}

		$this->info = parent::queryInfoById($getUser);

		$this->username = $this->info['username'];
		$this->userid = $this->info['userUserid'];
		$this->info['userid'] = $this->info['userUserid'];
		$this->info['secgroupids'] = unserialize($this->info['secgroupids']);
		$this->assignAdmin($this->info);

		// not admin?!?
		if(!$this->admin['adminid'] AND !$this->isSuperAdmin()) {
			new WtcBBException($lang['admin_error_privilegesAdmin']);
		}
	}

	// gets user info if there's no id, but username given
	protected function queryInfoByUsername() {
		global $query, $lang, $wtcDB;

		$getUser = new Query($query['admin']['get_user_byUsername_admin'], Array(1 => $this->username));

		parent::queryInfoByUsername($getUser);

		$this->userid = $this->info['userUserid'];
		$this->info['userid'] = $this->info['userUserid'];
		$this->info['secgroupids'] = unserialize($this->info['secgroupids']);
		$this->assignAdmin($this->info);

		// not admin?!?
		if(!$this->admin['adminid'] AND !$this->isSuperAdmin()) {

			new WtcBBException($lang['admin_error_privilegesAdmin']);
		}
	}


	// Public static
	// handles admins
	// should be ran after any user or usergroup
	// modification!
	public static function addDelAdmins() {
		global $wtcDB, $query;

		// query for freshest groups
		$usergroups = new Query($query['usergroups']['get_groups']);

		while($group = $wtcDB->fetchArray($usergroups)) {
			$groups[$group['usergroupid']] = new Usergroup('', $group);
		}

		// Initialize Admin Groups
		$adminGroups = Array();

		foreach($groups as $groupid => $obj) {
			if($obj->isAdmin()) {
				$adminGroups[] = $groupid;
			}
		}

		// Get all admins
		$getAdmins = new Query($query['admin']['get_admins']);
		$admins = Array();

		if($wtcDB->numRows($getAdmins)) {
			while($admin = $wtcDB->fetchArray($getAdmins)) {
				$admins[$admin['userid']] = $admin;
			}
		}

		$get = new Query($query['user']['all_users_admin']);

		if($wtcDB->numRows($get)) {
			while($admin = $wtcDB->fetchArray($get)) {
				if(in_array($admin['usergroupid'], $adminGroups) OR searchArray($adminGroups, unserialize($admin['secgroupids']))) {
					$sAdmins[$admin['userid']] = $admin;
				}
			}
		}

		// Add in un-added admins
		if(is_array($sAdmins)) {
			foreach($sAdmins as $userid => $info) {
				if(!isset($admins[$userid])) {
					if($userid == 1) {
						$insert = Array(1 => $userid, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
					}

					else {
						$insert = Array(1 => $userid, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
					}

					new Query($query['admin']['insert_admin'], $insert);
				}
			}
		}

		// Delete admins
		if(is_array($admins)) {
			foreach($admins as $userid => $info) {
				if(!isset($sAdmins[$userid])) {
					new Delete('admins', 'adminid', $info['adminid'], '', false, true);
				}
			}
		}
	}
}
