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
## *********** ORDERED STYLES CACHE CLASS *********** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class OrderedStyles extends Cache {	
	// Constructor
	public function __construct() {
		global $_CACHE;
		
		$this->cacheType = 'orderedStyles';
		$this->cacheArray = 1;
		$this->formCache();
		
		// update cache...
		if(!isset($_CACHE['orderedStyles'])) {
			$this->insert();
		}
		
		else {
			$this->update();
		}
	}
	

	// Protected Methods
	protected function formCache() {
		global $query, $wtcDB, $styles;
		
		$getStyles = new Query($query['styles']['get_all']);
		$this->cacheInfo = Array();
		$styleArr = Array();
		
		while($style = $wtcDB->fetchArray($getStyles)) {
			$styleArr[$style['parentid']][$style['disOrder']][$style['styleid']] = $style['styleid'];
		}
		
		// sort'em...
		foreach($styleArr as $parent => $bleh) {
			ksort($styleArr["$parent"]);
		}
		
		// now pack'em...
		foreach($styleArr as $parent => $disOrders) {
			foreach($disOrders as $disOrder => $sids) {
				foreach($sids as $sid => $sidDupe) {
					$this->cacheInfo["$parent"][$sid] = $sid;
					
					$this->cacheContents .= '$' . $this->cacheType . '["' . $parent . '"][\'' . $sid . '\']';
					$this->cacheContents .= ' = ';
					$this->cacheContents .= '\'' . addslashes($sid) . '\';' . "\n";
				}
			}
		}
		
		$this->cacheInfo = serialize($this->cacheInfo);
	}
}
