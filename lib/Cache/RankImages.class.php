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
## ************* RANK IMAGES CACHE CLASS ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class RankImages extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'rankImages';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['rankImages'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;
		
		$getRankImages = new Query($query['rankImage']['get_all']);
		$this->cacheInfo = Array();
		
		while($rankImage = $wtcDB->fetchArray($getRankImages)) {
			$this->cacheInfo[$rankImage['rankiid']] = new RankImage('', $rankImage);
			
			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $rankImage['rankiid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new RankImage(\'\', Array(' . Cache::writeArray($rankImage) . '));' . "\n";
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
