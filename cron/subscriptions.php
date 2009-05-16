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
## ********* CRON - SEND SUBSCRIPTIONG EMAIL ******** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// don't have access to database?
if(!isset($wtcDB)) {
	exit;
}

// get all subscriptions and mail out...
// make sure the lastEmail is greater than
// the last email...
$needToEmail = new Query($query['subscribe']['get_all_cron']);
$updateToNow = Array(); // array of subids to make lastEmail NOW

while($subscribe = $needToEmail->fetchArray()) {
	$sub = new Subscription('', $subscribe);

	if(!$sub->isThreadSub()) {
		$mail = new Email('subscribe', $subscribe, '', Array('link' => 'http://wtcbb2.com/index.php?file=forum&f=' . $sub->getForumId()));
	}

	else {
		$mail = new Email('subscribe', $subscribe, '', Array('link' => 'http://wtcbb2.com/index.php?file=thread&t=' . $sub->getThreadId() . '&do=newest'));
	}

	if($mail->isSent()) {
		$updateToNow[] = $sub->getSubId();
	}
}

// now run the update query
if(count($updateToNow)) {
	new Query($query['subscribe']['update_lastEmail'],
		Array(
			1 => NOW,
			2 => implode(',', $updateToNow)
		)
	);
}

?>