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
## ************* DATE MANIPULATION CLASS ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

class WtcDate {
	private $timestamp, $format, $timeFormat, $todYes, $date;

	// Constructor
	public function __construct($type, $unixEpoch = NOW, $strRep = true) {
		global $bboptions;

		$this->timestamp = $unixEpoch;
		$this->strRep = $strRep;
		$this->date = '';

		switch($type) {
			case 'dateTime':
				$this->format = $bboptions['timeFormat_date'];
				$this->timeFormat = $bboptions['timeFormat_time'];
			break;

			case 'time':
				$this->format = $bboptions['timeFormat_time'];
				$this->timeFormat = '';
			break;

			case 'date':
				$this->format = $bboptions['timeFormat_date'];
				$this->timeFormat = '';
			break;

			default:
				$this->format = $type;
				$this->timeFormat = '';
			break;
		}
	}

	// Public Methods
	// formulates date
	public function getDate() {
		global $User, $bboptions, $lang;

		// start off with actual date...
		if(($this->date = @gmdate($this->format, ($this->timestamp + (($User->info['timezone'] + $User->info['dst']) * 3600)))) === false) {
			return 'Bad';
		}

		if($this->format == $bboptions['timeFormat_date'] AND $this->strRep AND $bboptions['timeFormat_todYes']) {
			// get today
			$today = gmdate($this->format, (NOW + ($User->info['dst'] * 3600) + ($User->info['timezone'] * 3600)));

			// get yesterday
			$yesterday = gmdate($this->format, ((NOW - 86400 + ($User->info['dst'] * 3600)) + ($User->info['timezone'] * 3600)));

			// get tomorrow? o_0
			$tomorrow = gmdate($this->format, ((NOW + 86400 + ($User->info['dst'] * 3600)) + ($User->info['timezone'] * 3600)));

			if($this->date == $today) {
				$this->date = $lang['dates_today'];
			}

			else if($this->date == $yesterday) {
				$this->date = $lang['dates_yesterday'];
			}

			else if($this->date == $tomorrow) {
				$this->date = $lang['dates_tomorrow'];
			}
		}

		// time format too?
		if(!empty($this->timeFormat)) {
			if(($temp = @gmdate($this->timeFormat, ($this->timestamp + (($User->info['timezone'] + $User->info['dst']) * 3600))))) {
				$this->date .= ' ' . $lang['global_at'] . ' ' . $temp;
			}
		}

		return $this->date;
	}

	// Public Static Methods
	// mktime... meh stupid php 5.1.0
	public static function mktime($hour, $minute, $second, $month, $day, $year) {
		global $User;

		// get the gmmktime...
		$retval = gmmktime($hour, $minute, $second, $month, $day, $year);

		// now do our timezone thing...
		$retval -= (($User->info['timezone'] + $User->info['dst']) * 3600);

		return $retval;
	}

	// forms time zone array
	public static function buildTimeZones() {
		global $lang, $bboptions, $User;

		$timeZones = Array();

		for($i = -12; $i <= 12; $i++) {
			$timeZones["$i"] = $lang['dates_gmt'] . ' ' . (($i > 0) ? '+' : '') . (($i) ? ($i . ' ') : '') . '(' . gmdate('h:i A', NOW + ($i * 3600) + ((($User instanceof User) ? $User->info['dst'] : 1) * 3600)) . ')';
		}

		return $timeZones;
	}

	// forms "View Ages" array
	public static function buildViewAge() {
		global $lang;

		$viewAges = Array(
			0 => $lang['global_useForumDefault'],
			ADAY => $lang['dates_showThread_oneDay'],
			(ADAY * 2) => $lang['dates_showThread_twoDays'],
			AWEEK => $lang['dates_showThread_oneWeek'],
			(AWEEK * 2) => $lang['dates_showThread_twoWeeks'],
			AMONTH => $lang['dates_showThread_oneMonth'],
			(ADAY * 45) => $lang['dates_showThread_45Days'],
			(AMONTH * 2) => $lang['dates_showThread_twoMonths'],
			(ADAY * 75) => $lang['dates_showThread_75Days'],
			(AMONTH * 3) => $lang['dates_showThread_threeMonths'],
			(AMONTH * 6) => $lang['dates_showThread_sixMonths'],
			(ADAY * 365) => $lang['dates_showThread_oneYear'],
			-1 => $lang['dates_showThread_all']
		);

		return $viewAges;
	}

	public static function buildYears() {
		$years = Array();

		for($i = date('Y'); $i >= 1900; $i--) {
			$years[$i] = $i;
		}

		return $years;
	}

	public static function buildMonths() {
		global $lang;

		$months = Array(
				1 => $lang['dates_january'], $lang['dates_february'], $lang['dates_march'],
					 $lang['dates_april'], $lang['dates_may'], $lang['dates_june'],
					 $lang['dates_july'], $lang['dates_august'], $lang['dates_september'],
					 $lang['dates_october'], $lang['dates_november'], $lang['dates_december']
				);

		return $months;
	}

	public static function buildWeekdays() {
		global $lang;

		$weekdays = Array(
				$lang['dates_sunday'], $lang['dates_monday'], $lang['dates_tuesday'],
				$lang['dates_wednesday'], $lang['dates_thursday'], $lang['dates_friday'],
				$lang['dates_saturday']
			);

		return $weekdays;
	}

	public static function buildDays() {
		$days = Array();

		for($i = 1; $i <= 31; $i++) {
			$days[$i] = $i;
		}

		return $days;
	}

	public static function buildHours() {
		$hours = Array();

		for($i = 0; $i <= 23; $i++) {
			$hours[$i] = $i;
		}

		return $hours;
	}

	public static function buildMinutes() {
		$minutes = Array();

		for($i = 0; $i <= 59; $i++) {
			$minutes[$i] = $i;
		}

		return $minutes;
	}

	public static function buildNows() {
		$nows = Array(
					'hour' => new WtcDate('G', NOW),
					'niceHour' => new WtcDate('h', NOW),
					'minute' => new WtcDate('i', NOW),
					'dayOfMonth' => new WtcDate('j', NOW),
					'dayOfWeek' => new WtcDate('w', NOW),
					'month' => new WtcDate('n', NOW),
					'year' => new WtcDate('Y', NOW),
					'numDays' => new WtcDate('t', NOW),
					'month' => new WtcDate('m', NOW),
					'date' => new WtcDate('d', NOW),
					'ampm' => new WtcDate('a', NOW),
					'dst' => new WtcDate('I', NOW)
				);

		// now actually get the date
		foreach($nows as $key => $val) {
			if($val instanceof WtcDate) {
				$nows[$key] = $val->getDate();
			}
		}

		return $nows;
	}

	public static function getAmPm($selectName, $selected) {
		global $lang;

		$ampm = Array(
			0 => $lang['dates_am'],
			1 => $lang['dates_pm']
		);

		$return = '<select name="' . $selectName . '">' . "\n";

		foreach($ampm as $va => $dis) {
			$select = '';

			if($selected == $va) {
				$select = ' selected="selected"';
			}

			$return .= "\t" . '<option value="' . $va . '"' . $select . '>' . $dis . '</option>' . "\n";
		}

		$return .= '</select>' . "\n";

		return $return;
	}

	public static function getDays($selectName, $selected) {
		$days = WtcDate::buildDays();

		$return = '<select name="' . $selectName . '">' . "\n";

		$return .= "\t" . '<option value="">-Day-</option>' . "\n";

		foreach($days as $day) {
			$select = '';

			if($day == $selected) {
				$select = ' selected="selected"';
			}

			$return .= "\t" . '<option value="' . $day . '"' . $select . '>' . $day . '</option>' . "\n";
		}

		$return .= '</select>' . "\n";

		return $return;
	}

	public static function getMonths($selectName, $selected) {
		global $lang;

		$months = WtcDate::buildMonths();

		$return = '<select name="' . $selectName . '">' . "\n";

		foreach($months as $va => $dis) {
			$select = '';

			if($va == $selected) {
				$select = ' selected="selected"';
			}

			$return .= "\t" . '<option value="' . $va . '"' . $select . '>' . $dis . '</option>' . "\n";
		}

		$return .= '</select>' . "\n";

		return $return;
	}

	public static function getYears($selectName, $selected) {
		$years = WtcDate::buildYears();

		$return = '<select name="' . $selectName . '">' . "\n";

		$return .= "\t" . '<option value="">-Year-</option>' . "\n";

		foreach($years as $year) {
			$select = '';

			if($year == $selected) {
				$select = ' selected="selected"';
			}

			$return .= "\t" . '<option value="' . $year . '"' . $select . '>' . $year . '</option>' . "\n";
		}

		$return .= '</select>' . "\n";

		return $return;
	}

	public static function getTimeZones($selectName, $selected) {
		$zones = WtcDate::buildTimeZones();

		$return = '<select name="' . $selectName . '">' . "\n";

		foreach($zones as $zone => $text) {
			$select = '';

			if($zone == $selected) {
				$select = ' selected="selected"';
			}

			$return .= "\t" . '<option value="' . $zone . '"' . $select . '>' . $text . '</option>' . "\n";
		}

		$return .= '</select>' . "\n";

		return $return;
	}
}
