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
 

$crons['8'] = new Cron('', Array('cronid' => '8', 'title' => 'Lift Temporary Bans', 'path' => './cron/liftbans.php', 'log' => '1', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '30', 'nextRun' => '1175686200'));
$crons['7'] = new Cron('', Array('cronid' => '7', 'title' => 'Usergroup Automations', 'path' => './cron/automations.php', 'log' => '1', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '0', 'nextRun' => '1175752800'));
$crons['9'] = new Cron('', Array('cronid' => '9', 'title' => 'End of the Day Clean Up', 'path' => './cron/cleanup.php', 'log' => '0', 'dayOfWeek' => '0', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '1', 'nextRun' => '1176012060'));
$crons['11'] = new Cron('', Array('cronid' => '11', 'title' => 'Session Timeout', 'path' => './cron/timeout.php', 'log' => '0', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '-1', 'nextRun' => '1175682660'));
$crons['12'] = new Cron('', Array('cronid' => '12', 'title' => 'Read/Unread Indicator Cleanup', 'path' => './cron/readIndicatorCleanup.php', 'log' => '0', 'dayOfWeek' => '1', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '10', 'nextRun' => '1157350200'));
$crons['13'] = new Cron('', Array('cronid' => '13', 'title' => 'Subscriptions', 'path' => './cron/subscriptions.php', 'log' => '0', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '-1', 'nextRun' => '1156815060'));
$crons['14'] = new Cron('', Array('cronid' => '14', 'title' => 'Attachment Clean Up', 'path' => './cron/cleanAttachments.php', 'log' => '0', 'dayOfWeek' => '0', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '0', 'nextRun' => '1157266800'));

?>