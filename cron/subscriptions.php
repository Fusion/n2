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