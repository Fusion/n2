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
## ********** CRON - USERGROUP AUTOMATIONS ********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

$getAutos = new Query($query['usergroups']['get_affectedAuto']);
$users = '';

if($wtcDB->numRows($getAutos)) {
	$logtext = $lang['admin_cron_log_changeGroup'] . ' ';
	
	while($auto = $wtcDB->fetchArray($getAutos)) {
		// unserialize secgroupids...
		$userSecs = unserialize($auto['secgroupids']);
		$opPosts = ''; $opDays = ''; $move = false; $daysRegged = 0;
		
		if(!is_array($userSecs)) {
			$userSecs = Array();
		}
		
		// can't put user in a group that they are already in!
		if($auto['moveTo'] == $auto['usergroupid'] OR in_array($auto['moveTo'], $userSecs)) {
			continue;
		}
		
		// get total number of days registered
		$elapsed = NOW - $auto['joined'];
		$daysRegged = ceil($elapsed / 86400);
		
		// create user obj
		$userObj = new User('', '', $auto);
		
		switch($auto['postsComp']) {
			case 1:
				$opPosts = '>=';
			break;
			
			default:
				$opPosts = '<';
			break;
		}
		
		switch($auto['daysRegComp']) {
			case 1:
				$opDays = '>=';
			break;
			
			default:
				$opDays = '<';
			break;
		}
		
		// which comparison are we doing?
		switch($auto['type']) {
			// just posts
			case 1:
				if(eval('return ' . $auto['posts'] . ' ' . $opPosts . ' ' . $auto['postsa'] . ';')) {
					$move = true;
				}
			break;
			
			// just days registered
			case 2:
				if(eval('return ' . $daysRegged . ' ' . $opDays . ' ' . $auto['daysReg'] . ';')) {
					$move = true;
				}
			break;
			
			// posts or days
			case 3:
				if(eval('return ' . $auto['posts'] . ' ' . $opPosts . ' ' . $auto['postsa'] . ';') OR eval('return ' . $daysRegged . ' ' . $opDays . ' ' . $auto['daysReg'] . ';')) {
					$move = true;
				}
			break;
			
			// posts and days
			case 4:
				if(eval('return ' . $auto['posts'] . ' ' . $opPosts . ' ' . $auto['postsa'] . ';') AND eval('return ' . $daysRegged . ' ' . $opDays . ' ' . $auto['daysReg'] . ';')) {
					$move = true;
				}
			break;
		}
		
		// move?
		if($move) {
			// secondary?
			if($auto['secondary']) {
				$userSecs[] = $auto['moveTo'];
				$arr['secgroupids'] = serialize($userSecs);
			}
			
			else {
				$arr['usergroupid'] = $auto['moveTo'];
			}
			
			$users .= '<a href="admin.php?file=user&amp;edit=' . $userObj->info['userid'] . '">' . $userObj->info['username'] . '</a>, ';
			
			$userObj->update($arr, true);
		}				
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