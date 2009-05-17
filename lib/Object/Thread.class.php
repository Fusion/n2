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
## ***************** THREAD CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Thread extends Object {
	private $threadid, $info;

	// Constructor
	public function __construct($id = '', $threadinfo = '') {
		global $lang;
              	if(!empty($threadinfo) AND is_array($threadinfo)) {
			$this->info = $threadinfo;
			$this->threadid = $this->info['threadid'];
		}

		else if(!empty($id)) { 
			$this->threadid = $id;
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

		new Delete('threads', 'threadid', $this->threadid, '', true, true);

		// now delete all posts, attachments, subscriptions, etc
		new Delete('posts', 'threadid', $this->threadid, '', true, true);
		new Delete('attachments', 'threadid', $this->threadid, '', true, true);
		new Delete('subscribe', 'threadid', $this->threadid, '', true, true);
	}

	// Updates thread... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		// add to current info too...
		foreach($arr as $key => $val) {
			if(isset($this->info[$key])) {
				$this->info[$key] = $val;
			}
		}

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['threads']['update'], Array(1 => $update, 2 => $this->threadid), 'query', false);
	}

	// Accessors
	public function getThreadId() {
		return $this->threadid;
	}

	public function getStarter() {
		$userObj = new User('', '', $this->info);
		$retval = $userObj->getHTMLName();

		if(empty($retval) OR !$this->info['userid']) {
			return $this->info['threadUsername'];
		}

		else {
			return $retval;
		}
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function getStarterId() {
		return $this->info['madeby'];
	}

	public function getName() {
		return censor($this->info['name']);
	}

	public function getViews() {
		return $this->info['views'];
	}

	public function getFirstPostId() {
		return $this->info['first_postid'];
	}

	public function getDesc() {
		return censor($this->info['descript']);
	}

	public function getPostIconPath() {
		return $this->info['posticon'];
	}

	public function getReplies() {
		return $this->info['replies'];
	}

	// this counts deleted posts, runs a query!
	public function getRealReplies() {
		global $query, $wtcDB, $groups, $perms, $User;

		// only get deleted if we can view...
		if($User->check('canViewDelNotices', $this->getForumId())) {
			$deleted['total'] = $this->getDelReplies();
		}

		else {
			$deleted['total'] = 0;
		}

		return ($deleted['total'] + $this->getReplies());
	}

	public function getDelReplies() {
		return $this->info['deleted_replies'];
	}

	public function getLastReplyDate() {
		return $this->info['last_reply_date'];
	}

	public function getLastReplyPostId() {
		return $this->info['last_reply_postid'];
	}

	public function getLastReplyUsername() {
		return $this->info['last_reply_username'];
	}

	public function getLastReplyUserId() {
		return $this->info['last_reply_userid'];
	}

	public function isDeleted() {
		return $this->info['deleted'];
	}

	public function actionBy() {
		return $this->info['deleted_by'];
	}

	public function actionReason() {
		return censor($this->info['deleted_reason']);
	}

	public function actionDate() {
		return $this->info['deleted_timeline'];
	}

	public function lastRead() {
		return $this->info['dateRead'];
	}

	public function isClosed() {
		return $this->info['closed'];
	}

	public function isSticky() {
		return $this->info['sticky'];
	}

	public function isPoll() {
		return $this->info['poll'];
	}

	public function movedTo() {
		return $this->info['moved'];
	}

	public function isRead() {
		global $bboptions, $User;

		if(!LOGIN) {
			return true;
		}

		return (($this->lastRead() AND $this->lastRead() >= $this->getLastReplyDate()) OR $this->getLastReplyDate() <= $bboptions['readTimeout'] OR $User->info['markedRead'] > $this->getLastReplyDate());
	}

	public function hasAttach() {
		if($this->info['hasAttach'] OR $this->info['attachid']) {
			return true;
		}

		return false;
	}

	public function getFolderName($participated) {
		global $bboptions;

		if($this->getReplies() >= $bboptions['hotReplies'] OR $this->getViews() >= $bboptions['hotViews']) {
			if(!$participated) {
				return 'folderHot';
			}

			else {
				return 'folderHotDot';
			}
		}

		else {
			if(!$participated) {
				return 'folderReg';
			}

			else {
				return 'folderRegDot';
			}
		}
	}

	public function isSubscribed() {
		if(!isset($this->info['subid']) OR !$this->info['subid']) {
			return false;
		}

		// must be subscribed
		return true;
	}

	public function getInfo() {
		return $this->info;
	}

	// more advanced "accessors"...
	// perms if they can close
	public function canClose() {
		global $User;

		// moderator
		if($User->modAction('canOpenClose', $this->getForumId())) {
			return true;
		}

		// make sure they can close own
		// and it's the proper user
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canCloseOwn', $this->getForumid())) {
			return true;
		}

		// nope, sorry
		return false;
	}

	// can this user create a poll?
	public function canPolls() {
		global $User;

		// moderator
		if($User->modAction('canEditPolls', $this->getForumId())) {
			return true;
		}

		// make sure it's the proper person...
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canCreatePolls', $this->getForumId())) {
			return true;
		}

		// nope, sorry
		return false;
	}

	// perms if user can sticky
	// strictly moderator
	public function canSticky() {
		global $User;

		if($User->modAction('canStick', $this->getForumId())) {
			return true;
		}

		// nope, sorry
		return false;
	}

	// checks the perms for moving thread
	public function canMove() {
		global $User;

		if($User->modAction('canMove', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// checks moderator perms for thread splitting
	public function canSplit() {
		global $User;

		// just mod perms...
		if($User->modAction('canSplit', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// checks moderator perms for thread splitting
	public function canMerge() {
		global $User;

		// just mod perms...
		if($User->modAction('canMerge', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// this will check perms for adding a reply
	// lots of them!
	public function canReply() {
		global $User;

		// if moderator of forum with open/close privs...
		// and it's locked
		// yes!
		if($this->isClosed() AND $User->modAction('canOpenClose', $this->getForumId())) {
			return true;
		}

		// we know that if it's closed, and not a mod
		// can't reply!
		if($this->isClosed()) {
			return false;
		}

		// if they can reply own AND others... we know we're good
		if($User->check('canReplyOwn', $this->getForumId()) AND $User->check('canReplyOthers', $this->getForumId())) {
			return true;
		}

		// so one or the other has to be false...
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canReplyOwn', $this->getForumId())) {
			return true;
		}

		if($User->info['userid'] != $this->getStarterId() AND $User->check('canReplyOthers', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// just viewing the thread
	public function canView() {
		global $User;

		// can't view the board?
		if(!$User->check('canViewBoard', $this->getForumId())) {
			return false;
		}

		// deleted... but has perms?
		if($this->isDeleted() AND $User->check('canViewDelNotices', $this->getForumId())) {
			return true;
		}

		// deleted thread now means no access
		if($this->isDeleted()) {
			return false;
		}

		// view threads and own threads? view all
		if($User->check('canViewThreads', $this->getForumId()) AND $User->check('canViewOwnThreads', $this->getForumId())) {
			return true;
		}

		// so one or the other has to be false...
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canViewOwnThreads', $this->getForumId())) {
			return true;
		}

		if($User->info['userid'] != $this->getStarterId() AND $User->check('canViewThreads', $this->getForumId())) {
			return true;
		}

		return false; // welp... lots of perms
	}

	// editing thread title
	public function canEditThreadTitle() {
		global $User;

		// mod with editing thread perms
		if($User->modAction('canEditThreads', $this->getForumId())) {
			return true;
		}

		// made it, and has perms
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canEditOwnThreadTitle', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// sees if current user can delete
	public function canDelete() {
		global $User;

		// moderator?
		if($User->modAction('canDelete', $this->getForumId())) {
			return true;
		}

		// what if it's the first post?
		if($User->info['userid'] == $this->getStarterId() AND $User->check('canDelOwnThreads', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// sees if current user can permanently delete
	// checks permanent deletion
	public function canPermDelete() {
		global $User, $moderators;

		if($User->modAction('canPermDelete', $this->getForumId())) {
			return true;
		}

		if($User->info['userid'] == $this->getStarterId() AND $User->check('canPermDelOwnThreads', $this->getForumId())) {
			return true;
		}

		return false;
	}

	// Public functions
	// subscribes/unsubscires from thread
	public function subUnsub() {
		global $User, $query;

		// if the user is subscribed, unsubscribe
		if($this->isSubscribed()) {
			$this->unsubscribe();
		}

		else {
			$this->subscribe();
		}
	}

	// this will update a user's subscription (lastView)
	// precondition is that user is subscribed
	public function updateSubscription() {
		global $query;

		new Query($query['subscribe']['update_lastView'],
			Array(
				1 => NOW,
				2 => $this->info['subid']
			)
		);
	}

	// helper methods for above
	// subscribes to thread... obviously
	public function subscribe() {
		global $User, $query;

		// just insert
		Subscription::insert(
			Array(
				'userid' => $User->info['userid'],
				'forumid' => $this->getForumId(),
				'threadid' => $this->getThreadId(),
				'lastView' => NOW,
				'lastEmail' => 0,
				'subType' => 'normal'
			)
		);
	}

	// unsubscribes to this thread
	public function unsubscribe() {
		global $query;

		// just delete
		$sub = new Subscription($this->info['subid']);
		$sub->destroy();
	}

	// closes/open the thread
	public function openClose() {
		if($this->isClosed()) {
			$this->update(Array('closed' => 0));
		}

		else {
			$this->update(Array('closed' => 1));
		}
	}

	// sticks/unsticks thread
	public function stickUnstick() {
		if($this->isSticky()) {
			$this->update(Array('sticky' => 0));
		}

		else {
			$this->update(Array('sticky' => 1));
		}
	}

	// restores a thread..
	public function restore() {
		global $User, $query, $wtcDB, $forums;

		// get forum
		$Forum = $forums[$this->getForumId()];

		$updateThread = Array(
			'deleted' => 0
		);

		// update the thread
		$this->update($updateThread);

		// update thread post count
		$updateForumCounts = Array(
			'posts' => ($Forum->info['posts'] + ($this->getReplies() + 1)),
			'threads' => ($Forum->info['threads'] + 1)
		);

		$Forum->update($updateForumCounts);

		// is it the newest thread?
		if($this->getLastReplyDate() > $Forum->info['last_reply_date']) {
			// update the forum
			// we know THIS is the thread
			$updateForum['last_reply_username'] = $this->getLastReplyUsername();
			$updateForum['last_reply_userid'] = $this->getLastReplyUserId();
			$updateForum['last_reply_date'] = $this->getLastReplyDate();
			$updateForum['last_reply_threadid'] = $this->getThreadId();
			$updateForum['last_reply_threadtitle'] = $this->getName();

			$Forum->updateLastReplyAndCounts($updateForum, false, 0);
		}

		// now increase user thread count
		// update user post counts (we only do thread count here)
		new Query($query['user']['update_counts'],
			Array(
				1 => (($forums[$this->getForumId()]->info['countPosts']) ? 1 : 0),
				2 => 0,
				3 => $this->getStarterId()
			)
		);
	}

	// this function will soft delete threads
	// it does NOT check permissions
	public function softDelete($reason = '') {
		global $User, $query, $wtcDB, $forums;

		// get forum
		$Forum = $forums[$this->getForumId()];

		// update thread...
		$updateThread = Array(
			'deleted' => 1,
			'deleted_by' => $User->info['username'],
			'deleted_timeline' => NOW,
			'deleted_reason' => $reason
		);

		// update thread
		$this->update($updateThread);

		// update thread post count
		$updateForumCounts = Array(
			'posts' => ($Forum->info['posts'] - ($this->getReplies() + 1)),
			'threads' => ($Forum->info['threads'] - 1)
		);

		$Forum->update($updateForumCounts);

		// was it the last post?
		if($this->getThreadId() == $Forum->info['last_reply_threadid']) {
			// now get the last post for this forum...
			$lastReply = new Query($query['threads']['lastreply'], Array(1 => $Forum->info['forumid']));
			$lastReply = $lastReply->fetchArray();

			$updateForum['last_reply_username'] = $lastReply['threadUsername'];
			$updateForum['last_reply_userid'] = $lastReply['madeby'];
			$updateForum['last_reply_date'] = $lastReply['thread_timeline'];
			$updateForum['last_reply_threadid'] = $lastReply['threadid'];
			$updateForum['last_reply_threadtitle'] = $lastReply['name'];

			$Forum->updateLastReplyAndCounts($updateForum, false, 0);
		}

		// update user post counts (we only do thread count here)
		new Query($query['user']['update_counts'],
			Array(
				1 => (($forums[$this->getForumId()]->info['countPosts']) ? -1 : 0),
				2 => 0,
				3 => $this->getStarterId()
			)
		);
	}

	// this will do the same as softDelete
	// except it will permanently delete
	// it does NOT check permissions
	public function permDelete() {
		global $User, $query, $wtcDB, $forums;

		// get forum
		$Forum = $forums[$this->getForumId()];

		// kill the thread
		$this->destroy();

		// update thread post count
		$updateForumCounts = Array(
			'posts' => ($Forum->info['posts'] - ($this->getReplies() + 1)),
			'threads' => ($Forum->info['threads'] - 1)
		);

		$Forum->update($updateForumCounts);

		// was it the last post?
		if($this->getThreadId() == $Forum->info['last_reply_threadid']) {
			// now get the last post for this forum...
			$lastReply = new Query($query['threads']['lastreply'], Array(1 => $Forum->info['forumid']));
			$lastReply = $lastReply->fetchArray();

			$updateForum['last_reply_username'] = $lastReply['threadUsername'];
			$updateForum['last_reply_userid'] = $lastReply['madeby'];
			$updateForum['last_reply_date'] = $lastReply['thread_timeline'];
			$updateForum['last_reply_threadid'] = $lastReply['threadid'];
			$updateForum['last_reply_threadtitle'] = $lastReply['name'];

			$Forum->updateLastReplyAndCounts($updateForum, false, 0);
		}

		// update user post counts (we only do thread count here)
		new Query($query['user']['update_counts'],
			Array(
				1 => (($forums[$this->getForumId()]->info['countPosts']) ? -1 : 0),
				2 => 0,
				3 => $this->getStarterId()
			)
		);
	}

	// this will copy the thread to another forum
	// perms aren't taken into account here
	public function copy($Forum, $move = false, $redirect = false, $postids = false) {
		global $query, $wtcDB, $forums;

		$newinfo = $this->info;
		$oldForum = $forums[$this->getForumId()];

		// should we update thread, or re-insert? o_0
		if($move) {
			$this->update(
				Array(
					'forumid' => $Forum->info['forumid']
				)
			);

			// one step further... insert a redirect
			if($redirect) {
				unset($newinfo['threadid'], $newinfo['readUserId'], $newinfo['readThreadId'], $newinfo['dateRead'], $newinfo['subid']);
				$newinfo['moved'] = $this->getThreadId(); // make it moved

				Thread::insert($newinfo);
			}

			// update the old forum
			else {
				// update thread post count
				$updateForumCounts = Array(
					'posts' => ($oldForum->info['posts'] - ($this->getReplies() + 1)),
					'threads' => ($oldForum->info['threads'] - 1)
				);

				$oldForum->update($updateForumCounts);

				// was it the last post?
				if($this->getThreadId() == $oldForum->info['last_reply_threadid']) {
					// now get the last post for this forum...
					$lastReply = new Query($query['threads']['lastreply'], Array(1 => $oldForum->info['forumid']));
					$lastReply = $lastReply->fetchArray();

					$updateForum['last_reply_username'] = $lastReply['threadUsername'];
					$updateForum['last_reply_userid'] = $lastReply['madeby'];
					$updateForum['last_reply_date'] = $lastReply['thread_timeline'];
					$updateForum['last_reply_threadid'] = $lastReply['threadid'];
					$updateForum['last_reply_threadtitle'] = $lastReply['name'];

					$oldForum->updateLastReplyAndCounts($updateForum, false, 0);
				}
			}
		}

		else {
			// change forum id, unset a few things, and re-insert
			$newinfo['forumid'] = $Forum->info['forumid'];
			unset($newinfo['threadid'], $newinfo['readUserId'], $newinfo['readThreadId'], $newinfo['dateRead'], $newinfo['subid']);

			// okay... insert
			$newThreadId = Thread::insert($newinfo);
		}

		// should we just update posts? (if we're moving)
		if($move) {
			new Query($query['posts']['update_thread'],
				Array(
					1 => $Forum->info['forumid'],
					2 => $newinfo['threadid']
				)
			);
		}

		else {
			// now re-insert all posts for thread...
			$posts = new Query($query['posts']['get_all_thread_use'], Array(1 => $this->getThreadId()));
			$firstPostId = 0;

			while($post = $posts->fetchArray()) {
				// if the post is deleted, we lose it
				if($post['deleted']) {
					continue;
				}

				// only do the post if it's in the array...
				if($postids AND !in_array($post['postid'], $postids)) {
					continue;
				}

				// change thread id and forum id
				$post['threadid'] = $newThreadId;
				$post['forumid'] = $Forum->info['forumid'];
				unset($post['postid']);

				// now insert
				$lastPostId = Post::insert($post);

				// first post id?
				if(!$firstPostId) {
					$firstPostId = $lastPostId;
				}
			}

			// now update with last post id
			$newThread = new Thread($newThreadId);
			$newThread->update(
				Array(
					'last_reply_postid' => $lastPostId,
					'first_postid' => $firstPostId
				)
			);

			// now increase user thread count
			// update user post counts (we only do thread count here)
			new Query($query['user']['update_counts'],
				Array(
					1 => (($forums[$this->getForumId()]->info['countPosts']) ? 1 : 0),
					2 => 0,
					3 => $this->getStarterId()
				)
			);
		}

		// update thread post count
		$updateForumCounts = Array(
			'posts' => ($Forum->info['posts'] + ($this->getReplies() + 1)),
			'threads' => ($Forum->info['threads'] + 1)
		);

		$Forum->update($updateForumCounts);

		// is it the newest thread?
		if($this->getLastReplyDate() > $Forum->info['last_reply_date']) {
			// update the forum
			// we know THIS is the thread
			$updateForum['last_reply_username'] = $this->getLastReplyUsername();
			$updateForum['last_reply_userid'] = $this->getLastReplyUserId();
			$updateForum['last_reply_date'] = $this->getLastReplyDate();
			$updateForum['last_reply_threadid'] = (!$move ? $newThread->getThreadId() : $this->getThreadId());
			$updateForum['last_reply_threadtitle'] = $this->getName();

			$Forum->updateLastReplyAndCounts($updateForum, false, 0);
		}

		// returns the new thread object...
		if(!$move) {
			return $newThread;
		}

		else {
			return $this;
		}
	}

	// this will split the current thread
	// also takes an array of postids to use...
	// you can set postids to false, and it will use the WHOLE thread
	public function split($newName, $postids = false) {
		global $query, $wtcDB, $forums;

		// firstly, copy the thread with selected postids...
		$Splitted = $this->copy($forums[$this->getForumId()], false, false, $postids);

		// any updates required, or was it a clean copy? o_0
		$update = Array();

		// update post counts...
		if((count($postids) - 1) != $this->getReplies()) {
			$update['replies'] = (count($postids) - 1);
		}

		// new thread name?
		// it needs to be verified already
		// since errors aren't thrown here
		if($this->getName() != $newName) {
			$update['name'] = $newName;
		}

		// nada nada limonada
		$update['views'] = 0;

		// new last reply
		$lastPost = new Post($Splitted->getLastReplyPostId());
		$update['last_reply_username'] = $lastPost->getStarterName();
		$update['last_reply_userid'] = $lastPost->getStarterId();
		$update['last_reply_date'] = $lastPost->getTimeline();

		// update
		$Splitted->update($update);

		// return splitted thread... if needed
		return $Splitted;
	}

	// this function will merge the current thread
	// with the specified thread in argument
	// no permissions as usual
	public function merge($Thread) {
		global $query, $wtcDB, $forums;

		// get the forum
		$Forum = $forums[$this->getForumId()];

		// first, update all posts in merging thread
		// into new thread
		new Query($query['posts']['update_newThread'],
			Array(
				1 => $this->getThreadId(),
				2 => $Thread->getThreadId()
			)
		);

		// last post is different now?
		$lastPost = new Query($query['posts']['lastreply_inThread'], Array(1 => $this->getThreadId()));
		$lastPost = $lastPost->fetchArray();

		if($lastPost['postid'] != $this->getLastReplyPostId()) {
			// update the thread
			$updateThread['last_reply_username'] = $lastPost['postUsername'];
			$updateThread['last_reply_userid'] = $lastPost['postby'];
			$updateThread['last_reply_date'] = $lastPost['posts_timeline'];
			$updateThread['last_reply_postid'] = $lastPost['postid'];

			// was it the last forum post too?
			if($this->getThreadId() == $Forum->info['last_reply_threadid']) {
				$updateForum = Array(
					'last_reply_username' => $updateThread['last_reply_username'],
					'last_reply_userid' => $updateThread['last_reply_userid'],
					'last_reply_date' => $updateThread['last_reply_date']
				);

				$Forum->updateLastReplyAndCounts($updateForum, false, 0);
			}
		}

		// okay, what about first post?
		$firstPost = new Query($query['posts']['first_postid'], Array(1 => $this->getThreadId()));
		$firstPost = $firstPost->fetchArray();

		if($firstPost['postid'] != $this->getFirstPostId()) {
			$updateThread['first_postid'] = $firstPost['postid'];
		}

		// update replies and what not...
		$updateThread['replies'] = ($this->getReplies() + $Thread->getReplies() + 1);
		$updateThread['views'] = ($this->getViews() + $Thread->getViews());

		// forum counts now...
		if($Thread->getForumId() != $this->getForumId()) {
			$Forum->update(Array('posts' => ($Forum->info['posts'] + $Thread->getReplies() + 1)));
		}

		// update thread
		$this->update($updateThread);

		// killl old thread
		$Thread->permDelete();
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB, $User;

		$getThread = new Query($query['threads']['get'], Array(1 => $User->info['userid'], $User->info['userid'], $this->threadid));

		$this->info = parent::queryInfoById($getThread);
	}


	// Static Methods
	// Public
	// inserts thread... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['threads']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}
