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
