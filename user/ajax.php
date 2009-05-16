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
## **************** AJAX MANAGEMENT ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// This file takes care of SAVING information using AJAX
// As well as RETRIEVING information
// When we SAVE we like to use POST data...

if($_GET['do'] == 'save') {
	if($_GET['what'] == 'postquote') {
		$Post = new Post($_POST['postid']);

		exit(BBCode::stripMe($Post->getMessage(), 'quote'));
	}

	else if($_GET['what'] == 'postedittext') {
		$Post = new Post($_POST['postid']);
		exit($Post->getMessage());
	}

	else if($_GET['what'] == 'postedit') {
		// our post...
		Forum::init();
		$Post = new Post($_POST['postid']);
		$Thread = new Thread($Post->getThreadId());

		// unescape '&'
		$_POST['message'] = str_replace('^*^**^*^', '&', $_POST['message']);

		// make sure we have permission
		if(!$User->canViewForum($Post->getForumId()) OR !$Post->canEdit() OR !$Thread->canView() OR $Thread->isDeleted() OR $Post->isDeleted()) {
			exit('Failed');
		}

		// initiate the message parser
		$MessageParser = new Message();
		$MessageParser->autoOptions($User, $Post);

		// start checking
		// wait, is there a name change? for thread?
		$checking = $MessageParser->check($_POST['message'], 'A Good Title');

		// uh oh...
		if($checking instanceof WtcBBException) {
			exit('Failed');
		}

		// flood
		/*else if($User->flood()) {
			exit('Failed');
		}*/

		// good to go
		else {
			// initiate
			$update = Array();

			// okay we're good... get message
			$_POST['message'] = $checking;

			// now form our post insert
			$update['message'] = $_POST['message'];
			$update['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$update['edited_by'] = $User->info['username']; $update['edited_timeline'] = NOW;

			// now update the post
			$Post->update($update);

			print($MessageParser->parse($_POST['message'], $User->info['username']));
			exit;
		}
	}
}

else if($_GET['do'] == 'retrieve') {
}

?>