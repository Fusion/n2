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
## ******* CUSTOM PROFILE FIELDS CACHE CLASS ******** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class CustomPros extends Cache {
	// Constructor
	public function __construct() {
		global $_CACHE;

		$this->cacheType = 'profs';
		$this->cacheArray = 1;
		$this->formCache();

		// update cache...
		if(!isset($_CACHE['profs'])) {
			$this->insert();
		}

		else {
			$this->update();
		}
	}


	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB;

		$getProfs = new Query($query['custom_pro']['get_all']);
		$this->cacheInfo = Array();

		while($prof = $wtcDB->fetchArray($getProfs)) {
			$this->cacheInfo[$prof['groupid']][$prof['proid']] = new CustomPro('', $prof);

			$this->cacheContents .= '$' . $this->cacheType . '[\'' . $prof['groupid'] . '\'][\'' . $prof['proid'] . '\']';
			$this->cacheContents .= ' = ';
			$this->cacheContents .= 'new CustomPro(\'\', Array(' . Cache::writeArray($prof) . '));' . "\n";
		}

		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
