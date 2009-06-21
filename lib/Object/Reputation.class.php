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
## *************** REPUTATION CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Reputation extends Object {
	private $repid, $info;

	// Constructor
	public function __construct($id = '', $repinfo = '') {
		global $lang;

		if(!empty($repinfo) AND is_array($repinfo)) {
			$this->info = $repinfo;
			$this->repid = $this->info['repid'];
		}

		else if(!empty($id)) {
			$this->repid = $id;
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

		new Delete('reputations', 'repid', $this->repid, '', true, true);
	}

	// Updates reputation... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);
                // Execute!
		new Query($query['reputations']['update'], Array(1 => $update, 2 => $this->repid), 'query', false);
	}

	// Accessors
	public function getRepId() {
		return $this->repid;
	}

	public function getUserId() {
		return $this->info['userid'];
	}
	
	public function getForumId() {
		return 0;
	}

	public function exists() {
		if(!isset($this->info['repid']) OR !$this->info['repid']) {
			return false;
		}

		return true;
	}

	public function getReputationGiverId() {
		return $this->info['repby'];
	}

	public function getReputationGiverName() {
		return $this->info['repUsername'];
	}

	public function getMessage() {
		global $bboptions;

		return censor($this->info['message']);
	}

	public function getMessageTextArea() {
		global $bboptions;

		return wtcspecialchars(censor($this->info['message']));
	}

	public function getIP() {
		return $this->info['ip_address'];
	}

	public function getTimeline() {
		return $this->info['rep_timeline'];
	}

	public function isUpvote() {
		return (!empty($this->info['up']));
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
		return false;
	}

	public function showSmilies() {
		return false;
	}

	public function showBBCode() {
		return false;
	}


	public function getInfo() {
		return $this->info;
	}

	// these are some functions that check permissions
	// relating to the user trying to do the action
	public function showEdited($user) {
		return true;
	}

	// checks soft delete
	public function canDelete($Thread = '') {
		global $User, $moderators;

		// moderator?
		if($User->modAction('canDelete', 0)) {
			return true;
		}

		// if they don't have the perm, no
		if($User->info['userid'] == $this->getReputationGiverId()) {
			return true;
		}

		return false;
	}

	// checks permanent deletion
	public function canPermDelete($Thread = '') {
		global $User, $moderators;

		if($User->modAction('canPermDelete', $this->getForumId())) {
			return true;
		}

		if($User->info['userid'] == $this->getReputationGiverId()) {
			return true;
		}

		return false;
	}

	// permission methods
	// all make use of $User var
	public function canEdit() {
		global $User, $moderators;

		// moderator perms
		if($User->modAction('canEditReputations', 0)) {
			return true;
		}

		// if user is same user and has edit perms
		if($User->info['userid'] == $this->getReputationGiverId()) {
			return true;
		}

		return false;
	}


	// Public functions
	// restores a reputation...
	public function restore() {
		global $User, $query, $wtcDB, $forums;

		$updateRep = Array(
			'deleted' => 0
		);

		// update the reputation
		$this->update($updateRep);
	}

	// this function will soft delete reputations
	// it does NOT check permissions
	public function softDelete($reason = '') {
		global $User, $query, $wtcDB, $forums;

		// update reputation...
		$updateRep = Array(
			'deleted' => 1,
			'edited_by' => $User->info['username'],
			'edited_timeline' => NOW,
			'edited_reason' => $reason
		);
                
		// update reputation
		$this->update($updateRep);               
	}

	// this will do the same as softDelete
	// except it will permanently delete
	// it does NOT check permissions
	public function permDelete() {
		global $User, $query, $wtcDB, $forums;

		// kill the reputation
		$this->destroy();
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getRep = new Query($query['reputations']['get'], Array(1 => $this->repid));

		$this->info = parent::queryInfoById($getRep);
	}


	// Static Methods
	// Public
	// inserts reputations... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['reputations']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}
