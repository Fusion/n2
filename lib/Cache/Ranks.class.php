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
## *************** RANKS CACHE CLASS **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Ranks extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'ranks';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['ranks'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getRanks = new Query($query['rank']['get_all']);
		$this->cacheInfo = Array();
		
		while($rank = $wtcDB->fetchArray($getRanks)) {
			$this->cacheInfo[$rank['rankid']] = new Rank('', $rank);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $rank['rankid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new Rank(\'\', Array(' . Cache::writeArray($rank) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
