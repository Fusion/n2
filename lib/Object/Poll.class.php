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
## ****************** POLL CLASS ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Poll extends Object {
	private $pollid, $info;

	// Constructor
	public function __construct($id = '', $pollinfo = '') {
		global $lang;

		if(!empty($pollinfo) AND is_array($pollinfo)) {
			$this->info = $pollinfo;
			$this->pollid = $this->info['pollid'];
		}

		else if(!empty($id)) {
			$this->pollid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// unserialize some stuff...
		if(isset($this->info['voters'])) {
			$this->info['voters'] = array_map('censor', unserialize($this->info['voters']));
		}

		if(isset($this->info['polloptions'])) {
			$this->info['polloptions'] = array_map('censor', unserialize($this->info['polloptions']));
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('polls', 'pollid', $this->pollid, '', true, true);

		// now update the thread with NO POLL
		$Thread = new Thread($this->getThreadId());
		$Thread->update(Array('poll' => 0));
	}

	// Updates poll... Accepts an array of fields and values
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
		new Query($query['polls']['update'], Array(1 => $update, 2 => $this->pollid), 'query', false);
	}

	// Accessors
	public function getPollId() {
		return $this->pollid;
	}

	public function getThreadId() {
		return $this->info['threadid'];
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function getTimeline() {
		return $this->info['poll_timeline'];
	}

	public function getTitle() {
		return censor($this->info['title']);
	}

	public function getNumOptions() {
		return $this->info['options'];
	}

	public function getNumVotes() {
		return $this->info['votes'];
	}

	public function getPollOptions() {
		return $this->info['polloptions'];
	}

	public function getTimeout() {
		return $this->info['timeout'];
	}

	public function isClosed() {
		// get the number of days in seconds...
		$days = $this->getTimeout() * (60 * 60 * 24);

		// add on to timeline
		$total = $days + $this->getTimeline();

		// less than NOW?
		if($total < NOW AND $this->getTimeout()) {
			return true;
		}

		else {
			return false;
		}
	}

	public function isPublic() {
		return $this->info['public'];
	}

	public function isDisabled() {
		return $this->info['disabled'];
	}

	public function isMultiple() {
		return $this->info['multiple'];
	}

	public function getInfo() {
		return $this->info;
	}

	// more advanced "accessors"...
	// perms if they can close
	public function canVote() {
		global $User;

		// make sure they can close own
		// and it's the proper user
		if($User->check('canVotePolls', $this->getForumid())) {
			return true;
		}

		// nope, sorry
		return false;
	}

	// checks to see if current user HAS voted
	public function hasVoted() {
		global $User;

		// closed?
		if($this->isClosed()) {
			return true;
		}

		// quick fix for guest viewing
		if(!LOGIN) {
			return true;
		}

		foreach($this->info['polloptions'] as $option) {
			if(is_array($option['voters'])) {
				foreach($option['voters'] as $username) {
					if($User->info['username'] == $username) {
						return true;
					}
				}
			}
		}

		// nope, didn't vote
		return false;
	}

	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB, $User;

		$getPoll = new Query($query['polls']['get'], Array(1 => $this->pollid));

		$this->info = parent::queryInfoById($getPoll);
	}


	// Static Methods
	// Public
	// inserts poll... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['polls']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}
