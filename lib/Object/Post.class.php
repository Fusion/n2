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
## ****************** POST CLASS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Post extends Object {
	private $postid, $info;

	// Constructor
	public function __construct($id = '', $postinfo = '') {
		global $lang;

		if(!empty($postinfo) AND is_array($postinfo)) {
			$this->info = $postinfo;
			$this->postid = $this->info['postid'];
		}

		else if(!empty($id)) {
			$this->postid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('posts', 'postid', $this->postid, '', true, true);
		new Delete('attachments', 'postid', $this->postid, '', true, true);
	}

	// Updates post... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);
                // Execute!
		new Query($query['posts']['update'], Array(1 => $update, 2 => $this->postid), 'query', false);
	}

	// Accessors
	public function getPostId() {
		return $this->postid;
	}

	public function getThreadId() {
		return $this->info['threadid'];
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function exists() {
		if(!isset($this->info['postid']) OR !$this->info['postid']) {
			return false;
		}

		return true;
	}

	public function getStarterId() {
		return $this->info['postby'];
	}

	public function getStarterName() {
		return $this->info['postUsername'];
	}

	public function getMessage() {
		global $bboptions;

		return censor($this->info['message']);
	}

	public function getMessageTextArea() {
		global $bboptions;

		return wtcspecialchars(censor($this->info['message']));
	}

	public function getTitle() {
		global $bboptions;

		return censor($this->info['title']);
	}

	public function getIP() {
		return $this->info['ip_address'];
	}

	public function getTimeline() {
		return $this->info['posts_timeline'];
	}

	public function getPostIcon() {
		return $this->info['posticon'];
	}

	public function isDeleted() {
		return $this->info['deleted'];
	}

	public function isEdited() {
		return ($this->info['edited_by'] AND !$this->isDeleted());
	}

	public function actionBy() {
		return $this->info['edited_by'];
	}

	public function actionTimeline() {
		return $this->info['edited_timeline'];
	}

	public function actionReason() {
		global $bboptions;

		return censor($this->info['edited_reason']);
	}

	public function showSig() {
		return $this->info['sig'];
	}

	public function showSmilies() {
		return $this->info['smilies'];
	}

	public function showBBCode() {
		return $this->info['bbcode'];
	}

	public function getInfo() {
		return $this->info;
	}

	// these are some functions that check permissions
	// relating to the user trying to do the action
	public function showEdited($user) {
		// make sure we still have perms
		if(!$this->info['edited_show'] AND !$user->check('canEditedNotice', $this->getForumId())) {
			return true;
		}

		return $this->info['edited_show'];
	}

	// checks soft delete
	public function canDelete($Thread = '') {
		global $User, $moderators;

		// moderator?
		if($User->modAction('canDelete', $this->getForumId())) {
			return true;
		}

		// what if it's the first post?
		if($Thread instanceof Thread AND $this->getPostId() == $Thread->getFirstPostId()) {
			if($User->info['userid'] == $this->getStarterId() AND $User->check('canDelOwnThreads', $this->getForumId())) {
				return true;
			}
		}

		else {
			// if they don't have the perm, no
			if($User->info['userid'] == $this->getStarterId() AND $User->check('canDelOwnPosts', $this->getForumId())) {
				return true;
			}
		}

		return false;
	}

	// checks permanent deletion
	public function canPermDelete($Thread = '') {
		global $User, $moderators;

		if($User->modAction('canPermDelete', $this->getForumId())) {
			return true;
		}

		if($Thread instanceof Thread AND $this->getPostId() == $Thread->getFirstPostId()) {
			if($User->info['userid'] == $this->getStarterId() AND $User->check('canPermDelOwnThreads', $this->getForumId())) {
				return true;
			}
		}

		else {
			if($User->info['userid'] == $this->getStarterId() AND $User->check('canPermDelOwnPosts', $this->getForumId())) {
				return true;
			}
		}

		return false;
	}

	// permission methods
	// all make use of $User var
	public function canEdit() {
		global $User, $moderators;

		// moderator perms
		if($User->modAction('canEditPosts', $this->getForumId())) {
			return true;
		}

		// if user is same user and has edit perms
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canEditOwn', $this->getForumId())) {
			return true;
		}

		return false;
	}


	// Public functions
	// restores a post...
	public function restore($Thread) {
		global $User, $query, $wtcDB, $forums;

		// get forum
		$Forum = $forums[$this->getForumId()];

		$updatePost = Array(
			'deleted' => 0
		);

		// update the post
		$this->update($updatePost);

		// update thread post count
		$updateThread = Array(
			'replies' => ($Thread->getReplies() + 1),
			'deleted_replies' => ($Thread->getDelReplies() - 1)
		);

		// is it the newest post?
		if($this->getTimeline() > $Thread->getLastReplyDate()) {
			// update the thread
			$updateThread['last_reply_username'] = $this->getStarterName();
			$updateThread['last_reply_userid'] = $this->getStarterId();
			$updateThread['last_reply_date'] = $this->getTimeline();
			$updateThread['last_reply_postid'] = $this->getPostId();

			// was it the last forum post too?
			if($Thread->getThreadId() == $Forum->info['last_reply_threadid']) {
				$updateForum = Array(
					'last_reply_username' => $updateThread['last_reply_username'],
					'last_reply_userid' => $updateThread['last_reply_userid'],
					'last_reply_date' => $updateThread['last_reply_date'],
					'last_reply_threadid' => $Thread->getThreadId(),
					'last_reply_threadtitle' => $Thread->getName()
				);

				$Forum->update($updateForum);
			}
		}

		// update the thread
		$Thread->update($updateThread);

		// now increase user post count
		new Query($query['user']['update_counts'],
			Array(
				1 => 0,
				2 => (($forums[$this->getForumId()]->info['countPosts']) ? 1 : 0),
				3 => $this->getStarterId()
			)
		);
	}

	// this function will soft delete posts
	// it does NOT check permissions
	public function softDelete($Thread, $reason = '') {
		global $User, $query, $wtcDB, $forums;
                
		// if this is the first post... then no...
// 		if($this->getPostId() == $Thread->getFirstPostId()) {
// 			return;
// 		}
		// get forum
		$Forum = $forums[$this->getForumId()];

		// update post...
		$updatePost = Array(
			'deleted' => 1,
			'edited_by' => $User->info['username'],
			'edited_timeline' => NOW,
			'edited_reason' => $reason
		);
                
		// update post
		$this->update($updatePost);
               
		// update thread post count
		$updateThread = Array(
			'replies' => ($Thread->getReplies() - 1),
			'deleted_replies' => ($Thread->getDelReplies() + 1)
		);
                
		// was it the last post?
		if($this->getPostId() == $Thread->getLastReplyPostId()) {
			// now get the last post for this thread...
			$lastReply = new Query($query['posts']['get_lastreply'], Array(1 => $Thread->getThreadId()));
			$lastReply = $lastReply->fetchArray();

			$updateThread['last_reply_username'] = $lastReply['postUsername'];
			$updateThread['last_reply_userid'] = $lastReply['postby'];
			$updateThread['last_reply_date'] = $lastReply['posts_timeline'];
			$updateThread['last_reply_postid'] = $lastReply['postid'];

			// can only be forum last post if thread last post...
			if($Forum->info['last_reply_threadid'] == $Thread->getThreadId()) {
				// just use previous last post data...
				$updateForum = Array(
					'last_reply_username' => $lastReply['postUsername'],
					'last_reply_userid' => $lastReply['postby'],
					'last_reply_date' => $lastReply['posts_timeline'],
					'last_reply_threadid' => $Thread->getThreadId(),
					'last_reply_threadtitle' => $Thread->getName()
				);

				$Forum->update($updateForum);
			}
		}

		$Thread->update($updateThread);

		// update user post counts
		new Query($query['user']['update_counts'],
			Array(
				1 => 0,
				2 => (($forums[$this->getForumId()]->info['countPosts']) ? -1 : 0),
				3 => $this->getStarterId()
			)
		);
	}

	// this will do the same as softDelete
	// except it will permanently delete
	// it does NOT check permissions
	public function permDelete($Thread) {
		global $User, $query, $wtcDB, $forums;

		// get forum
		$Forum = $forums[$this->getForumId()];

		// kill the post
		$this->destroy();

		// update thread post count
		$updateThread = Array(
			'replies' => ($Thread->getReplies() - 1)
		);

		// was it the last post?
		if($this->getPostId() == $Thread->getLastReplyPostId()) {
			// now get the last post for this thread...
			$lastReply = new Query($query['posts']['get_lastreply'], Array(1 => $Thread->getThreadId()));
			$lastReply = $lastReply->fetchArray();

			$updateThread['last_reply_username'] = $lastReply['postUsername'];
			$updateThread['last_reply_userid'] = $lastReply['postby'];
			$updateThread['last_reply_date'] = $lastReply['posts_timeline'];
			$updateThread['last_reply_postid'] = $lastReply['postid'];

			// can only be forum last post if thread last post...
			if($Forum->info['last_reply_threadid'] == $Thread->getThreadId()) {
				// just use previous last post data...
				$updateForum = Array(
					'last_reply_username' => $lastReply['postUsername'],
					'last_reply_userid' => $lastReply['postby'],
					'last_reply_date' => $lastReply['posts_timeline'],
					'last_reply_threadid' => $Thread->getThreadId(),
					'last_reply_threadtitle' => $Thread->getName(),
					'posts' => ($Forum->info['posts'] - 1)
				);

				$Forum->update($updateForum);
			}
		}

		$Thread->update($updateThread);

		// update user post counts
		new Query($query['user']['update_counts'],
			Array(
				1 => 0,
				2 => (($forums[$this->getForumId()]->info['countPosts']) ? -1 : 0),
				3 => $this->getStarterId()
			)
		);
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getPost = new Query($query['posts']['get'], Array(1 => $this->postid));

		$this->info = parent::queryInfoById($getPost);
	}


	// Static Methods
	// Public
	// inserts post... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['posts']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}
