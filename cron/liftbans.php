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
## *********** CRON - LIFT TEMPORARY BANS *********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

$getBannedUsers = new Query($query['user']['get_banned_users']);
$users = '';

if($wtcDB->numRows($getBannedUsers)) {
	$logtext = $lang['admin_cron_log_banLifted'] . ' ';
	
	while($user = $wtcDB->fetchArray($getBannedUsers)) {
		$userObj = new User('', '', $user);

		// unban!
		$arr['usergroupid'] = $user['previousGroupId'];
		$userObj->update($arr);

		new Delete('userinfo_ban', 'banid', $user['banid'], '', true, true);
		
		$users .= '<a href="admin.php?file=user&amp;edit=' . $userObj->info['userid'] . '">' . $userObj->info['username'] . '</a>, ';
	}
}

// form results...
if(empty($users)) {
	$logtext = $lang['admin_cron_log_noAffect'];
}

else {
	$logtext = $logtext . preg_replace('/,\s+$/', '', $users);
}


?>