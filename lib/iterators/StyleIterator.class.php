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
## ***************** STYLE ITERATOR ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// iterates through styles
class StyleIterator implements Iterator {
	protected $style, $parent, $oStyles, $styleinfo, $count;
		
	// Constructor
	public function __construct($parent = -1, $forceNoCache = false) {
		global $orderedStyles, $styles, $query, $wtcDB;
		
		// uh oh... no cache data? o_0
		// these arrays are global, so it will only do this once
		if(!isset($styles) OR !is_array($styles) OR $forceNoCache) {
			$getStyles = new Query($query['styles']['get_all']);
			$styles = Array();
			$orderedStyles = Array();
			
			while($style = $wtcDB->fetchArray($getStyles)) {
				$styles[$style['styleid']] = new Style('', $style);
				$orderedStyles[$style['parentid']][$style['styleid']] = $style['styleid'];
			}
		}

		// only ordered?
		else if(!isset($orderedStyles) OR !is_array($orderedStyles) OR $forceNoCache) {
			$orderedStyles = Array();
			
			foreach($styles as $style) {
				$styles[$style->getStyleId()] = new Style('', $style->getInfo());
				$orderedStyles[$style->getParentId()][$style->getStyleId()] = $style->getStyleId();
			}
		}
		
		$this->oStyles = $orderedStyles;		
		$this->styleinfo = $styles;
		$this->parent = $parent;
		
		// bleh...
		if(!is_array($this->oStyles["$this->parent"])) {
			return false;
		}
				
		$this->style = $this->styleinfo[current($this->oStyles["$this->parent"])];
		$this->count = 0;
	}
	
	public function next() {
		$this->style = $this->styleinfo[next($this->oStyles["$this->parent"])];
	}
	
	public function rewind() {
		reset($this->oStyles);
	}
	
	public function current() {
		return $this->style;
	}
	
	public function valid() {
		if($this->style instanceof Style) {
			return true;
		}
		
		else {
			return false;
		}
	}
	
	public function key() {
		return ++$this->count;
	}
}

?>