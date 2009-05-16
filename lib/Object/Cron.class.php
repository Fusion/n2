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
## ******************* CRON CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// handles crons
class Cron extends Object {
	private $info, $cronid, $nextRun;

	// Constructor
	public function __construct($cronid = '', $croninfo = '') {
		if(!empty($croninfo) AND is_array($croninfo)) {
			$this->info = $croninfo;
			$this->cronid = $this->info['cronid'];
		}

		else if(!empty($cronid)) {
			$this->cronid = $cronid;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		$this->nextRun = $this->info['nextRun'];
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('cron', 'cronid', $this->cronid, '');

		new Cache('Crons');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=cron');
	}

	// Updates cron... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['cron']['update'], Array(1 => $update, 2 => $this->cronid), 'query', false);

		new Cache('Crons');
	}

	// executes cron... no questions asked
	public function exec() {
		global $crons, $wtcDB, $query, $lang, $bboptions;

		$logtext = '';

		require_once($this->getFilename());

		// rebuild crons next run time
		$update['nextRun'] = Cron::buildNextRun($this->getInfo());
		$this->update($update);

		// log it!
		if($this->info['log']) {
			new LogCron($update['nextRun'], $this->info['title'], $this->getFilename(), $logtext);
		}
	}

	// Accessors
	public function getInfo() {
		return $this->info;
	}

	public function getFilename() {
		return $this->info['path'];
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getCron = new Query($query['cron']['get'], Array(1 => $this->cronid));

		$this->info = parent::queryInfoById($getCron);
	}


	// Static Methods
	// Public
	// inserts cron... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['cron']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('Crons');
	}

	// checks to make sure we have a unique cron name...
	public static function checkUnique($name) {
		global $wtcDB, $query;

		$check = new Query($query['cron']['check_unique'], Array(1 => $name));
		$result = $wtcDB->fetchArray($check);

		return ((!$result['checking']) ? true : false);
	}

	// checks to make sure we have a unique cron name...
	public static function checkUniqueEdit($name, $id) {
		global $wtcDB, $query;

		$check = new Query($query['cron']['check_unique_edit'], Array(1 => $name, $id));
		$result = $wtcDB->fetchArray($check);

		return ((!$result['checking']) ? true : false);
	}

	// find next cron to run...
	public static function findNextCron() {
		global $crons;

		$nextCronId = 0;
		$nextRunTime = 0;

		foreach($crons as $cronid => $cronObj) {
			$info = $cronObj->getInfo();

			if($info['nextRun'] > $nextRunTime AND $info['nextRun'] <= NOW) {
				$nextCronId = $cronid;
				break;
			}
		}

		return $nextCronId;
	}

	// executes cron file
	public static function execNextCron() {
		global $wtcDB, $query, $lang, $crons, $bboptions;

		chdir(CWD);
		$nextCronId = Cron::findNextCron();

		if(!$nextCronId) {
			return;
		}

		// find the cron...
		$cron = $crons[$nextCronId];

		$info = $cron->getInfo();

		if($info['nextRun'] > NOW OR !file_exists($cron->getFilename())) {
			return;
		}

		// exec cron
		$cron->exec();
	}

	// builds the next run for a cron
	public static function buildNextRun($croninfo) {
		$nows = WtcDate::buildNows();

		// start with two different dates...
		// have to use a second one just in case the first one
		// has already past
		$firstDate = ''; $secondDate = ''; $setDate = '';

		// it has to be a certain week day...
		if($croninfo['dayOfWeek'] != -1) {
			$firstDate = $nows['dayOfMonth'] + ($croninfo['dayOfWeek'] - $nows['dayOfWeek']);
			$secondDate = $firstDate + 7;
		}

		// can be any week day
		else {
			// now we need to check for month
			if($croninfo['dayOfMonth'] != -1) {
				$firstDate = $croninfo['dayOfMonth'];
				$secondDate = $croninfo['dayOfMonth'] + $nows['numDays'];
			}

			// any day...
			else {
				$firstDate = $nows['dayOfMonth'];
				$secondDate = $firstDate + 1;
			}
		}

		// yikes... this is why we need our second date
		if($firstDate < $nows['dayOfMonth']) {
			$setDate = $secondDate;
		}

		else {
			$setDate = $firstDate;
		}

		// if the next run isn't due today...
		if($setDate != $nows['dayOfMonth']) {
			// find the appropriate time...
			$times = Cron::buildNextRunTime($croninfo, 0, -1, false);
		}

		// so... we can run again today??
		else {
			$times = Cron::buildNextRunTime($croninfo, false, false);

			// bleh!
			if($times['hour'] === false AND $times['minute'] === false) {
				$times = Cron::buildNextRunTime($croninfo, 0, -1, false);
				$setDate = $secondDate;
			}
		}

		return WtcDate::mktime($times['hour'], $times['minute'], 0, $nows['month'], $setDate, $nows['year']);
	}

	// builds the next run TIME for a cron
	public static function buildNextRunTime($croninfo, $setHour, $setMinute, $isToday = true) {
		$nows = WtcDate::buildNows();
		$retval = Array(
						'hour' => false,
						'minute' => false
					);

		if($setHour === false) {
			$setHour = $nows['hour'];
		}

		if($setMinute === false) {
			$setMinute = $nows['minute'];
		}

		// any hour, any minute
		// i wish they were all this easy!
		if($croninfo['hour'] == -1 AND $croninfo['minute'] == -1) {
			$retval['hour'] = $setHour;
			$retval['minute'] = $setMinute + 1;
		}

		// specific hour, any minute
		else if($croninfo['hour'] != -1 AND $croninfo['minute'] == -1) {
			// current hour?
			if($croninfo['hour'] == $setHour) {
				$retval['hour'] = $croninfo['hour'];
				$retval['minute'] = $setMinute + 1;
			}

			// past current hour?
			else if($croninfo['hour'] > $setHour) {
				$retval['hour'] = $croninfo['hour'];
				$retval['minute'] = 0; // nice and even
			}
		}

		// any hour, specific minute
		else if($croninfo['hour'] == -1 AND $croninfo['minute'] != -1) {
			// normally set hour to current hour...
			// if it's not today, then set hour to midnight
			if(!$isToday) {
				$retval['hour'] = 0;
			}

			// make sure minutes haven't passed by...
			else if($croninfo['minute'] <= $setMinute) {
				$retval['hour'] = $nows['hour'] + 1;
			}

			else {
				$retval['hour'] = $nows['hour'];
			}

			$retval['minute'] = $croninfo['minute'];
		}

		// specific hour, specific minute
		else if($croninfo['hour'] != -1 AND $croninfo['minute'] != -1) {
			// make sure we have valid time...
			if(($croninfo['hour'] == $setHour AND $croninfo['minute'] > $setMinute) OR $croninfo['hour'] > $setHour) {
				$retval['hour'] = $croninfo['hour'];
				$retval['minute'] = $croninfo['minute'];
			}
		}

		return $retval;
	}
}
