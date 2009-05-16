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
## ***************** CRON LOG CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class LogCron extends Log {
	private $nextRunTime, $title, $file, $results;
	
	// Constructor
	public function __construct($nextRun, $cronTitle, $fileName, $text) {
		global $User, $query, $wtcDB;
		
		$this->nextRunTime = $nextRun; $this->title = $cronTitle;
		$this->file = $fileName; $this->results = $text;
		
		$this->logit();
	}
	
	
	// Protected Methods
	protected function logit() {
		global $User, $query, $wtcDB;
		
		new Query($query['log_cron']['insert'], Array(
													1 => $this->title,
													$this->nextRunTime,
													NOW,
													$this->results,
													$this->file
												));
	}
}
