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
