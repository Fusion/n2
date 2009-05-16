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
## ****************** ATTACHMENTS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// This file handles ALL user uploads
// AND
// Viewing of ALL uploaded files

// viewing image
if(!isset($_GET['do']) AND $_GET['a']) {
	// make sure we have proper permissions
	$Attach = new Attachment($_GET['a']);
	$hasher = $Attach->getHash();
	Forum::init();

	if(empty($hasher)) {
		// conversation... or thread?
		if(!$Attach->getThreadId() AND $Attach->getConvoId()) {
			$Convo = new Conversation($Attach->getConvoId());

			// check convo viewing perms, and user downloading perms
			if(!$Convo->canRead() OR !$User->check('canDownAttach')) {
				new WtcBBException('perm');
			}
		}

		else {
			$Thread = new Thread($Attach->getThreadId());
			$Post = new Post($Attach->getPostId());

			// thread or post deleted?
			if($Thread->isDeleted()) {
				new WtcBBException($lang['error_forum_threadDel']);
			}

			// can't allow if post is deleted either
			if($Post->isDeleted()) {
				new WtcBBException($lang['error_forum_postDel']);
			}

			// this checks forum permissions, usergroups, and user forum access
			if(!$User->canViewForum($Thread->getForumId()) OR !$Thread->canView() OR !$User->check('canDownAttach', $Thread->getForumId())) {
				new WtcBBException('perm');
			}
		}
	}

	// just show the attachment...
	header('Content-type: ' . $Attach->getMimeType());

	// if it's not an image, force download
	if(!$Attach->isImage()) {
		header('Content-Disposition: attachment; filename="' . $Attach->getFileName() . '"');
	}

	// print the file... thumbnail?
	if($_GET['thumb'] AND file_exists($Attach->getThumbPath())) {
		print(file_get_contents($Attach->getThumbPath()));
	}

	else {
		print(file_get_contents($Attach->getPathName()));

		// downloaded...
		$Attach->update(Array('downloads' => ($Attach->getDownloads() + 1)));
	}
}

// deleting?
else if($_GET['do'] == 'delete') {
	// make sure we have proper permissions
	$Attach = new Attachment($_GET['a']);
	$hasher = $Attach->getHash();

	if(empty($hasher)) {
		$Thread = new Thread($Attach->getThreadId());
		$Post = new Post($Attach->getPostId());

		// thread or post deleted?
		if($Thread->isDeleted()) {
			new WtcBBException($lang['error_forum_threadDel']);
		}

		// can't allow if post is deleted either
		if($Post->isDeleted()) {
			new WtcBBException($lang['error_forum_postDel']);
		}

		// this checks forum permissions, usergroups, and user forum access
		if(!LOGIN OR !$User->canViewForum($Attach->getForumId()) OR !$Post->canEdit() OR !$Thread->canView() OR !$User->check('canUpAttach', $Attach->getForumId())) {
			new WtcBBException('perm');
		}
	}

	// we're okay to delete...
	$Attach->destroy();

	new Redirect(); // referer
}

// so... are we uploading?
else if($_GET['do'] == 'upload') {
	// set some vars...
	$hash = false;
	$postid = false;
	$messageid = false;
	$Convo = NULL; $Message = NULL; $Post = NULL; $Thread = NULL;
	$error = '';

	// if it's a personal message, we need a different routine entirely
	if($_GET['f'] OR $_GET['t']) {
		// initiate forum stuff
		Forum::init();
		ForumPerm::init();
		Moderator::init();

		$FORUM = $forums[$_GET['f']];
		$forumid = $FORUM->getForumId();

		if(is_numeric($_GET['link']) AND strlen($_GET['link']) != 32) {
			$postid = $_GET['link'];
			$myLink = $postid;
			$Post = new Post($postid);
			$GET = new Query($query['attachments']['get_postid'], Array(1 => $postid));
		}

		else if(strlen($_GET['link']) == 32) {
			$myLink = wtcspecialchars($_GET['link']);
			$hash = $myLink;
			$GET = new Query($query['attachments']['get_hash'], Array(1 => $hash));
		}

		else {
			new WtcBBException($lang['error_attach_badLink']);
		}

		if(!isset($forums[$_GET['f']])) {
			new WtcBBException($lang['error_attach_badLink']);
		}

		// thread
		if($_GET['t']) {
			$Thread = new Thread($_GET['t']);
		}

		// thread or post deleted?
		if($Thread instanceof Thread AND $Thread->isDeleted()) {
			$error = new WtcBBException($lang['error_forum_threadDel'], false);
		}

		// can't allow if post is deleted either
		if($Post instanceof Post AND $Post->isDeleted()) {
			$error = new WtcBBException($lang['error_forum_postDel'], false);
		}

		// this checks forum permissions, usergroups, and user forum access
		if(!LOGIN OR !$User->canViewForum($FORUM->info['forumid']) OR ($Post instanceof Post AND !$Post->canEdit()) OR ($Thread instanceof Thread AND !$Thread->canView()) OR !$User->check('canUpAttach', $FORUM->info['forumid'])) {
			$error = new WtcBBException('perm', false);
		}
	}

	// personal message attachments
	else {
		$forumid = 0;

		// still check the link
		if(strlen($_GET['link']) == 32) {
			$myLink = wtcspecialchars($_GET['link']);
			$hash = $myLink;
			$GET = new Query($query['attachments']['get_hash'], Array(1 => $hash));
		}

		else {
			new WtcBBException($lang['error_attach_badLink']);
		}

		if($_GET['c']) {
			$Convo = new Conversation($_GET['c']);
		}

		// this checks usergroup perms
		if(!LOGIN OR !$User->check('canUpAttach') OR ($Convo instanceof Conversation AND !$Convo->canRead())) {
			$error = new WtcBBException('perm', false);
		}
	}

	// now initalize extensions
	AttachmentExtension::init();

	// assemble checking extensions array (and ext bits)
	$allowMimes = Array();
	$allowExts = Array(); // these two arrays should have correlating indexes
	$extBits = ''; $before = '';
	$maxAttach = $User->check('maxAttach', $forumid);
	$maxFileSize = $User->check('attachFilesize', $forumid);
	$niceFileSize = round($maxFileSize / 1000);

	// now form
	foreach($exts as $obj) {
		if($obj->isAllowed()) {
			foreach($obj->getMimes() as $mime) {
				$allowExts[] = $obj->getExt();
				$allowMimes[] = $mime;
			}

			$extBits .= $before . $obj->getExt();
			$before = ', ';
		}
	}

	// do the upload...
	if(!($error instanceof WtcBBException) AND is_array($_FILES) AND count($_FILES['attach'])) {
		// get the file extension
		$extension = Upload::extensionFromFileName($_FILES['attach']['name']);
		$fileSize = 0;
		$image = false;

		// pin point mime so we can get max file size
		// and maybe width and height
		foreach($exts as $obj) {
			if(strtolower($extension) == strtolower($obj->getExt())) {
				$fileSize = $obj->maxSize();

				// we have an image too? o_0
				if(stripos($_FILES['attach']['type'], 'image') !== false) {
					$image = Array(
						'width' => $obj->maxWidth(),
						'height' => $obj->maxHeight()
					);
				}

				break;
			}
		} // if nothing is found here, there is error checking in Upload class

		// what if group file size is smaller?
		if($maxFileSize >= 1 AND $maxFileSize < $fileSize) {
			$fileSize = $maxFileSize;
		}

		// first, generate a file name
		$fileName = md5(microtime() . time() . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) . '.attach';

		// start the upload
		$Upload = new Upload($allowExts, $allowMimes, $_FILES['attach'], './attach/' . $fileName, $fileSize, $image);

		// do it... maybe error
		$uploading = $Upload->doUpload();

		// too many attachments?
		if($GET->numRows() >= $maxAttach) {
			$uploading = new WtcBBException($lang['error_attach_tooMany'], false);
		}

		// gasp!
		if($uploading instanceof WtcBBException) {
			$error = $uploading->dump();
			$Upload->destroy();
		}

		else {
			// we know a few things that we'll definitely need
			$insert['pathName'] = './attach/' . $fileName;
			$insert['fileName'] = wtcspecialchars($_FILES['attach']['name']);
			$insert['mime'] = wtcspecialchars($_FILES['attach']['type']);
			$insert['fileSize'] = $_FILES['attach']['size'];
			$insert['userid'] = $User->info['userid'];
			$insert['forumid'] = $forumid;

			// some values we might set, and we might not
			if($hash) {
				$insert['hash'] = $hash;
			}

			// we have a thread id
			if($Thread instanceof Thread) {
				$insert['threadid'] = $Thread->getThreadId();
			}

			// we have a post id
			if($Post instanceof Post) {
				$insert['postid'] = $Post->getPostId();
			}

			// we have a convo id
			if($Convo instanceof Conversation) {
				$insert['convoid'] = $Convo->getConvoId();
			}

			// image?
			if($Upload->isImage()) {
				$insert['image'] = 1;
			}

			// okay, insert the attachment
			$attachID = Attachment::insert($insert);

			// form attachment object and create thumbnail
			$Attach = new Attachment($attachID);
			$Attach->doThumbNail();

			// just refresh
			new Redirect($_SERVER['REQUEST_URI']);
		}
	}

	// build attachments...
	$attachBits = '';
	$ALT = 1;

	while($attach = $GET->fetchArray()) {
		$Attach = new Attachment('', $attach);

		$temp = new StyleFragment('upload_attachbit');
		$attachBits .= $temp->dump();

		if($ALT == 1) {
			$ALT = 2;
		}

		else {
			$ALT = 1;
		}
	}

	// hmmmm
	if(empty($attachBits) AND !$maxAttach) {
		$error = new WtcBBException('perm', false);
	}

	if($error instanceof WtcBBException) {
		$error = $error->dump();
	}

	$header = new StyleFragment('header_smallWindow');
	$content = new StyleFragment('upload');
	$footer = new StyleFragment('footer_smallWindow');

	$header->output();
	$content->output();
	$footer->output();
}

else {
}

?>