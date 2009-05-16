<?php
 /*

 * wtcBB Community Software (Open Source Freeware Version)

 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software
Solutions.

 * http://www.wtcbb.com/

 *

 * Licensed under the terms of the GNU Lesser General Public License:

 * http://www.wtcbb.com/wtcbb-license-general-public-license

 *

 * For support visit:

 * http://forums.wtcbb.com/

 *

 * Powered by wtcBB - http://www.wtcbb.com/

 * Protected by ChargebackFile - http://www.chargebackfile.com/

 *

*/
 

$crons['8'] = new Cron('', Array('cronid' => '8', 'title' => 'Lift Temporary Bans', 'path' => './cron/liftbans.php', 'log' => '1', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '30', 'nextRun' => '1175686200'));
$crons['7'] = new Cron('', Array('cronid' => '7', 'title' => 'Usergroup Automations', 'path' => './cron/automations.php', 'log' => '1', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '0', 'nextRun' => '1175752800'));
$crons['9'] = new Cron('', Array('cronid' => '9', 'title' => 'End of the Day Clean Up', 'path' => './cron/cleanup.php', 'log' => '0', 'dayOfWeek' => '0', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '1', 'nextRun' => '1176012060'));
$crons['11'] = new Cron('', Array('cronid' => '11', 'title' => 'Session Timeout', 'path' => './cron/timeout.php', 'log' => '0', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '-1', 'nextRun' => '1175682660'));
$crons['12'] = new Cron('', Array('cronid' => '12', 'title' => 'Read/Unread Indicator Cleanup', 'path' => './cron/readIndicatorCleanup.php', 'log' => '0', 'dayOfWeek' => '1', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '10', 'nextRun' => '1157350200'));
$crons['13'] = new Cron('', Array('cronid' => '13', 'title' => 'Subscriptions', 'path' => './cron/subscriptions.php', 'log' => '0', 'dayOfWeek' => '-1', 'dayOfMonth' => '-1', 'hour' => '-1', 'minute' => '-1', 'nextRun' => '1156815060'));
$crons['14'] = new Cron('', Array('cronid' => '14', 'title' => 'Attachment Clean Up', 'path' => './cron/cleanAttachments.php', 'log' => '0', 'dayOfWeek' => '0', 'dayOfMonth' => '-1', 'hour' => '2', 'minute' => '0', 'nextRun' => '1157266800'));

?>