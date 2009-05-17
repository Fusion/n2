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
## *************** PERSONAL MESSAGING *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// if not logged in... perm
if(!LOGIN) {
	new WtcBBException('perm');
}

if($_GET['do'] == 'convo') {
	// Define AREA
	define('AREA', 'USER-PER');
	require_once('./includes/sessions.php');

	// if we're viewing a convo...
	if($_GET['c']) {
		$Convo = new Conversation($_GET['c']);

		// proper permissions...
		if(!$Convo->canRead()) {
			new WtcBBException('perm');
		}

		// this just gets the number of posts (so we can do a limit)
		$allMsgs = new Query($query['personal_msg']['get_all_convo'], Array(1 => $Convo->getConvoId()));
		$allMsgs = $wtcDB->fetchArray($allMsgs);

		// make sure we HAVE posts
		if(!$allMsgs['total']) {
			new WtcBBException($lang['error_thread_invalidThread']);
		}

		// get our page number
		if($_GET['page'] <= 0 OR !is_numeric($_GET['page'])) {
			$page = 1;
		}

		else {
			$page = $_GET['page'];
		}

		// now get our start and end...
		$start = $bboptions['postsPerPage'] * ($page - 1);
		$perPage = $bboptions['postsPerPage'];

		// now build our posts
		$orderBy = 'msg_timeline';
		$postBits = ''; $whoBits = '';
		$ALT = 1;
		$post = Array();

		// initiate toolbar
		$toolBar = Message::buildLiteToolBar();

		$displayMessages = new Query($query['personal_msg']['get_display_convo'], Array(
																		1 => $Convo->getConvoId(),
																		2 => $orderBy,
																		3 => $User->info['displayOrder'],
																		4 => $start,
																		5 => $perPage
																	));

		// get all attachments for thread and group into array
		$attachments = new Query($query['attachments']['get_convoid'], Array(1 => $Convo->getConvoId()));

		while($attach = $attachments->fetchArray()) {
			$attaching[$attach['messageid']][] = $attach;
		}

		// initialize the message parser
		$post = $wtcDB->fetchArray($displayMessages);
		$MessageParser = new Message();

		do {
			// get our post and user
			$post = new PersonalMessage('', $post);
			$postUser = new User('', '', $post->getInfo());

			// get dates
			$joined = new WtcDate('date', $postUser->info['joined']);
			$timeline = new WtcDate('dateTime', $post->getTimeline());
			$signature = '';

			// soo.... what can we do for options?
			$MessageParser->globalAutoOptions($postUser, $post->getInfo());
			$message = $MessageParser->parse($post->getMessage(), $postUser->info['username']);
			$quoteText = BBCode::stripMe($post->getMessageTextArea(), 'quote');

			// online or offline
			if($postUser->info['isOnline']) {
				$temp = new StyleFragment('status_online');
			}

			else {
				$temp = new StyleFragment('status_offline');
			}

			$status = $temp->dump();

			// any attachments?
			$attachBits = '';
			$thumbBits = '';

			if(isset($attaching[$post->getMessageId()])) {
				foreach($attaching[$post->getMessageId()] as $attach) {
					$Attach = new Attachment('', $attach);

					if(file_exists($Attach->getThumbPath())) {
						$temp = new StyleFragment('threaddisplay_attachThumbBit');
						$thumbBits .= $temp->dump();
					}

					$temp = new StyleFragment('threaddisplay_attachbit');
					$attachBits .= $temp->dump();
				}
			}

			// user ranks?
			$ranks = $postUser->getUserRank();

			// parse signature?
			$MessageParser->setOptions($postUser->check('canBBCode'), $postUser->check('canSmilies'), $postUser->check('canImg'), $postUser->info['allowHtml']);
                        $personalMessage =  new PersonalMessage($Convo->getConvoId());
                        if($personalMessage->showSig()) 
			$signature = $MessageParser->parse($postUser->info['sig'], $postUser->info['username']);

			$temp = new StyleFragment('personal_viewconvo_bit');
			$postBits .= $temp->dump();

			if($ALT === 1) {
				$ALT = 2;
			}

			else {
				$ALT = 1;
			}
		} while($post = $wtcDB->fetchArray($displayMessages));

		// now make the member list
		$members = $Convo->getUserList();

		// make sure to update last read by user...
		$inConvo = $Convo->getCurrentUserInfo();
		$inConvo['lastRead'] = NOW;
		$nowConvo[$User->info['userid']] = $inConvo;
		$Convo->update(Array('users' => $nowConvo));

		// create page numbers
		$pages = new PageNumbers($page, $allMsgs['total'], $bboptions['postsPerPage']);

		// create navigation
		$Nav = new Navigation(Array(
								$lang['user_per_per'] => './index.php?file=personal&amp;do=convo',
								$Convo->getTitle() => ''
							));

		$content = new StyleFragment('personal_viewconvo');
	}

	// view convo list
	else {
		// are we going to delete/move?
		if($_POST['dowhat'] AND is_array($_POST['convocheck']) AND count($_POST['convocheck'])) {
			foreach($_POST['convocheck'] as $convoid => $bleh) {
				if($_POST['dowhat'] == -1) {
					// do a lite destroy
					// if this is the last user, it converts to a permanent destroy
					$Convo = new Conversation($convoid);
					$Convo->liteDestroy();
				}

				// marking read
				else if($_POST['dowhat'] == -2) {
					// get our convo
					$Convo = new Conversation($convoid);

					$inConvo = $Convo->getCurrentUserInfo();
					$inConvo['lastRead'] = NOW;
					$nowConvo[$User->info['userid']] = $inConvo;
					$Convo->update(Array('users' => $nowConvo));
				}

				else {
					// do moving
					$Convo = new Conversation($convoid);
					$Convo->move($_POST['dowhat']);
				}
			}

			if($_POST['dowhat'] == -1) {
				new WtcBBThanks($lang['thanks_convoDelete']);
			}

			else if($_POST['dowhat'] == -2) {
				new WtcBBThanks($lang['thanks_convoRead']);
			}

			else {
				new WtcBBThanks($lang['thanks_convoMoved']);
			}
		}

		// folder id?
		if(!$_GET['f'] OR !is_numeric($_GET['f'])) {
			$folderid = 1;
		}

		else {
			$folderid = $_GET['f'];
		}

		// get all conversations...
		$allConvos = new Query($query['personal_convo']['get_count_folder'], Array(
			1 => $User->info['userid'],
			2 => $folderid
		));

		// now fetch array (just total threads)
		$allConvos = $wtcDB->fetchArray($allConvos);

		// build page number, start, and per page
		// get our page number
		if(!$_GET['page'] OR !is_numeric($_GET['page'])) {
			$page = 1;
		}

		else {
			$page = $_GET['page'];
		}

		// now get our start and end...
		$start = $bboptions['threadsPerPage'] * ($page - 1);
		$perPage = $bboptions['threadsPerPage'];

		// now build our threads
		switch($_GET['sort']) {
			case 'title':
				$orderBy = 'title';
			break;

			case 'messages':
				$orderBy = 'messages';
			break;

			default:
				$orderBy = 'last_reply_date';
			break;
		}

		switch($_GET['order']) {
			case 'ASC':
				$orderBy .= ' ASC';
			break;

			default:
				$orderBy .= ' DESC';
			break;
		}

		$convoBits = '';
		$first = true;
		$ALT = 1;

		// construct SORT URL (remove &sort and &order)
		$SORT_URL = preg_replace('/&amp;order=.+?(&|$)/i', '$1', $_SERVER['REQUEST_URI']);
		$SORT_URL = preg_replace('/&amp;sort=.+?(&|$)/i', '$1', $SORT_URL);

		// query for actual threads
		$displayConvos = new Query($query['personal_convo']['get_display_folder'], Array(
																		1 => $User->info['userid'],
																		2 => $folderid,
																		3 => $orderBy,
																		4 => $start,
																		5 => $perPage
																	));

		while($convo = $displayConvos->fetchArray()) {
			// get thread object
			$obj = new Conversation('', $convo);

			// get the members in the convo
			$members = $obj->getUserList();

			// get the current data, and make sure it's the right folder...
			$myData = $obj->getCurrentUserInfo();

			if($myData['folderid'] != $folderid) {
				$allConvos['total']--;
				continue;
			}

			// get date
			$replyDate = new WtcDate('dateTime', $obj->getLastReplyDate());

			// get page numbers (and force an URL)
			$pages = new PageNumbers(1, ($obj->getMessages()), $bboptions['postsPerPage'], './index.php?file=personal&amp;do=convo&amp;c=' . $obj->getConvoId() . $SESSURL);
			$pages = $pages->getPageNumbers(true);

			$temp = new StyleFragment('personal_convo_bit');
			$convoBits .= $temp->dump();

			if($ALT === 1) {
				$ALT = 2;
			}

			else {
				$ALT = 1;
			}

			$first = false;
		}

		// all folders
		$folders = new Query($query['personal_folders']['get_all'], Array(1 => $User->info['userid']));
		$folderBits = ''; $moveFolderBits = ''; $moving = false;

		// we will always have folders...
		while($folder = $folders->fetchArray()) {
			// create our object
			$Folder = new Folder('', $folder);
			$moving = false;

			// form the bits
			$temp = new StyleFragment('personal_convo_folderBit');
			$folderBits .= $temp->dump();

			// now form moving bits... while we're at it
			$moving = true;
			$temp = new StyleFragment('personal_convo_folderBit');
			$moveFolderBits .= $temp->dump();
		}

		// create page numbers
		$pages = new PageNumbers($page, $allConvos['total'], $bboptions['threadsPerPage']);

		// create navigation
		$Nav = new Navigation(Array(
								$lang['user_per_per'] => './index.php?file=personal',
								$lang['user_per_convo'] => ''
							));

		$content = new StyleFragment('personal_convo');
	}
}

else if($_GET['do'] == 'folders') {
	// Define AREA
	define('AREA', 'USER-PER');
	require_once('./includes/sessions.php');

	// all folders
	$folders = new Query($query['personal_folders']['get_all'], Array(1 => $User->info['userid']));
	$ALT = 1; $folderBits = '';

	$_POST = array_map_recursive('trim', $_POST);

	// add the folder
	if($_POST['addFolder'] AND !empty($_POST['addFolder']['name'])) {
		// just insert...
		Folder::insert(Array('name' => $_POST['addFolder']['name'], 'userid' => $User->info['userid']));

		new WtcBBThanks($lang['thanks_addFolder']);
	}

	// edit folders
	if($_POST['edit'] OR $_POST['delete']) {
		// loop through and edit/delete...
		while($folder = $folders->fetchArray()) {
			// create our object
			$Folder = new Folder('', $folder);

			// not set? continue
			if(!isset($_POST['edit'][$Folder->getFolderId()]) OR !$Folder->getUserId()) {
				continue;
			}

			// delete?
			if($_POST['delSel'] AND isset($_POST['delete'][$Folder->getFolderId()])) {
				$Folder->destroy(); // deletes messages
			}

			// make sure it's changed
			else if(!$_POST['delSel'] AND $_POST['edit'][$Folder->getFolderId()] != $Folder->getName()) {
				$Folder->update(Array('name' => $_POST['edit'][$Folder->getFolderId()]));
			}
		}

		new WtcBBThanks($lang['thanks_updateFolders']);
	}

	// we will always have folders...
	while($folder = $folders->fetchArray()) {
		// create our object
		$Folder = new Folder('', $folder);

		// fill in the field...
		if(!$_POST['edit'][$Folder->getFolderId()]) {
			$_POST['edit'][$Folder->getFolderId()] = $Folder->getName();
		}

		// form the bits
		$temp = new StyleFragment('personal_folders_bit');
		$folderBits .= $temp->dump();

		// alternation
		if($ALT == 2) {
			$ALT = 1;
		}

		else {
			$ALT = 2;
		}
	}

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_per_per'] => 'index.php?file=personal',
							$lang['user_per_folders'] => ''
						));

	$content = new StyleFragment('personal_folders');
}

else if($_GET['do'] == 'send') {
        
	// Define AREA
	define('AREA', 'USER-PER');
	require_once('./includes/sessions.php');

	// get conversation...
	if($_GET['c']) {
		$Convo = new Conversation($_GET['c']);

		// proper permissions...
		if(!$Convo->canRead()) {
			new WtcBBException('perm');
		}
	}

	else {
		$Convo = NULL;
	}

	// create a hash for attachments
	if(empty($_POST['myHash'])) {
		$myHash = md5(time() . $User->info['userid'] . microtime() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
	}

	else {
		$myHash = $_POST['myHash'];
	}

	// get me quotes
	$quoted = '';

	if(is_array($_GET['p'])) {
		$count = 1;

		foreach($_GET['p'] as $msgid) {
			// hmm... over the limit?
			if($count > $bboptions['maxQuote']) {
				break;
			}

			$count++;

			$Msg = new PersonalMessage($msgid);
			$temp = BBCode::stripMe($Msg->getMessageTextArea(), 'quote');
			$quoted .= '[quote=' . $Msg->getStarterName() . ']' . $temp . '[/quote]' . "\n\n";
		}

		// picky picky... remove one "\n" from end
		$quoted = preg_replace('/(\n\n)$/', "\n", $quoted);
	}

	// we are good to go... for posting...
	if($_POST) {
		// initiate the message parser
		$MessageParser = new Message();
		$MessageParser->globalAutoOptions($User, $_POST['send']);

		// preview?
		if($_POST['preview']) {
			$preview = $MessageParser->parse($_POST['message'], $User->info['username']);
		}

		else {
			// error checking on message and title
			$checking = $MessageParser->check($_POST['message'], $_POST['send']['title']);

			// make sure all the user's are good...
			$userCorrelations = Array();
			$find = explode(',', $_POST['send']['to']);
			$allGood = true; $count = 1;
			$maxAllowed = $User->check('personalSendUsers');

			if(is_array($find)) {
				foreach($find as $username) {
					$username = trim($username);

					if(empty($username)) {
						continue;
					}

					// tsk tsk
					if($count > $maxAllowed) {
						break;
					}

					// find user...
					$userObj = new User('', $username, false, false, true);

					// if it's the same as current user, skip it
					// we add current user later
					if($userObj->info['userid'] == $User->info['userid']) {
						continue;
					}

					$userCorrelations[$userObj->info['userid']] = Array(
						'username' => $userObj->info['username'],
						'lastRead' => 0,
						'hasAlert' => 0,
						'folderid' => 1
					);

					if(!$userObj->info['userid']) {
						$userCorrelations[$userObj->info['userid']] = Array('username' => $username); // so we can use in error
						$allGood = false;
					}

					$count++;
				}
			}

			else {
				$allGood = false;
			}

			// uh oh...
			if($checking instanceof WtcBBException) {
				$error = $checking->dump();
			}

			// bad username listed
			else if(!$allGood OR (!count($userCorrelations) AND !($Convo instanceof Conversation))) {
				if(!count($userCorrelations)) {
					$error = new WtcBBException($lang['error_per_noSend'], false);
				}

				else {
					if(isset($userCorrelations[0])) {
						$error = new WtcBBException($lang['error_per_badUser'] . ' <strong>' . $userCorrelations[0]['username'] . '</strong>', false);
					}
				}

				if($error instanceof WtcBBException) {
					$error = $error->dump();
				}
			}

			else {
				// initiate
				$insert = Array();

				// okay we're good... get message
				$_POST['message'] = $checking;

				// insert our conversation, if needed...
				$_POST['send'] = array_map('wtcspecialchars', $_POST['send']);

				if(!($Convo instanceof Conversation)) {
					$insert['title'] = $_POST['send']['title'];
					$insert['last_reply_date'] = NOW; $insert['last_reply_username'] = $User->info['username'];
					$insert['last_reply_userid'] = $User->info['userid']; $insert['last_reply_messageid'] = 0;
					$insert['messages'] = 1;
					$insert['convoTimeline'] = NOW;

					// do the users now...
					// don't forget to add user sending it too!
					$userCorrelations[$User->info['userid']] = Array(
						'username' => $User->info['username'],
						'folderid' => 1,
						'lastRead' => NOW,
						'hasAlert' => 0
					);

					$insert['users'] = $userCorrelations;

					// insert conversation...
					$convoid = Conversation::insert($insert);
					$insert['convoid'] = $convoid;
					$convoObj = new Conversation('', $insert);
				}

				else {
					$update['last_reply_date'] = NOW; $update['last_reply_username'] = $User->info['username'];
					$update['last_reply_userid'] = $User->info['userid'];
					$update['messages'] = ($Convo->getMessages()) + 1;

					// go through user correlations... make sure there are no dupes
					$currentUsers = $Convo->getUserInfo();

					// don't forget to add user sending it too!
					$currentUsers[$User->info['userid']] = Array(
						'username' => $User->info['username'],
						'folderid' => 1,
						'lastRead' => NOW,
						'hasAlert' => 0
					);

					foreach($userCorrelations as $userid => $info) {
						// add
						if(!isset($currentUsers[$userid])) {
							$currentUsers[$userid] = $info;
						}
					}

					foreach($currentUsers as $userid => $info) {
						$currentUsers[$userid]['hasAlert'] = 0;
					}

					// serialize it
					$update['users'] = $currentUsers;

					// UPDATE!
					$Convo->update($update);
					$convoObj = $Convo;
					$convoid = $Convo->getConvoId();
				}

				// restart insert
				$oldInsert = $insert;
				$insert = Array();

				// now form our post insert
				$insert['convoid'] = $convoid;
				$insert['userid'] = $User->info['userid'];
				$insert['pmHash'] = $myHash;
				$insert['message'] = $_POST['message'];
				$insert['title'] = $_POST['send']['title'];
				$insert['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$insert['msg_timeline'] = NOW;
				$insert['readby'] = '';
                               
				// options
                                
				$insert['sig'] = (!empty($_POST['send']['sig']))?1:0;
				$insert['smilies'] = $_POST['send']['smilies'];
				$insert['bbcode'] = $_POST['send']['bbcode'];
				// now insert the post
				$messageid = PersonalMessage::insert($insert);

				// now update our thread...
				$convoObj->update(Array('last_reply_messageid' => $messageid));

				// update any attachments?
				new Query($query['attachments']['update_hash_convo'],
					Array(
						1 => $convoObj->getConvoId(),
						2 => $messageid,
						3 => $myHash
					)
				);

				new WtcBBThanks($lang['thanks_sentPerMessage'], './index.php?file=personal&amp;do=convo&amp;c=' . $convoid . $SESSURL);
			}
		}
	}

	// uh oh...
	if($_POST) {
		$_POST = array_map_recursive('wtcspecialchars', $_POST);
	}

	// set some things
	if($Convo instanceof Conversation) {
		$_POST['send']['title'] = 'Re: ' . $Convo->getTitle();
	}

	else if(!$_POST AND $_GET['u']) {
               $UserObj  =  new User($_GET['u']);
               $_POST['send']['to'] = wtcspecialchars($UserObj->info['username']);
// 		$_POST['send']['to'] = wtcspecialchars($_GET['u']);
	}

	// initiate toolbar
	$toolBar = Message::buildToolBar();

	// quick var assignment
	$maxUsers = $User->check('personalSendUsers');

	// create navigation
	if($Convo instanceof Conversation) {
		$Nav = new Navigation(Array(
								$lang['user_per_per'] => './index.php?file=personal&amp;do=convo',
								$Convo->getTitle() => './index.php?file=personal&amp;do=convo&amp;c=' . $Convo->getConvoId(),
								$lang['user_per_send'] => ''
							));
	}

	else {
		$Nav = new Navigation(Array(
								$lang['user_per_per'] => './index.php?file=personal&amp;do=convo',
								$lang['user_per_send'] => ''
							));
	}

	$content = new StyleFragment('personal_send');
}

// main CP area
else {

	// Define AREA
	define('AREA', 'USER-PER');
	require_once('./includes/sessions.php');

	// for now... redirect...
	// should probably do something like "new personal messages" later
	new Redirect('./index.php?file=personal&do=convo' . $SESSURL);

	// create navigation
	$Nav = new Navigation(Array(
							$lang['user_per_per'] => ''
						));

	$content = new StyleFragment('personal_main');
}

$header = new StyleFragment('header');
$perHeader = new StyleFragment('personal_header');
$perFooter = new StyleFragment('personal_footer');
$footer = new StyleFragment('footer');

$header->output();
$perHeader->output();
$content->output();
$perFooter->output();
$footer->output();

?>