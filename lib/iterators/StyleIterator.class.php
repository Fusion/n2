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