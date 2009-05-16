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