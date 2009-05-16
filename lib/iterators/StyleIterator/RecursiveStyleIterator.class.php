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
## ************ RECURSIVE STYLE ITERATOR ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// recusively loops through styles
class RecursiveStyleIterator extends StyleIterator implements RecursiveIterator {
	private $depth, $limit;
	
	// Constructor
	public function __construct($parent = -1, $styleLimit = 0, $forceNoCache = false) {
		global $orderedStyles, $styles;
		
		parent::__construct($parent, $forceNoCache);
		$this->limit = $styleLimit;
	}
	
	public function hasChildren() {
		return (isset($this->oStyles[$this->style->getStyleId()]));
	}
	
	public function getChildren() {		
		return new RecursiveStyleIterator($this->style->getStyleId(), $this->limit);
	}
}
