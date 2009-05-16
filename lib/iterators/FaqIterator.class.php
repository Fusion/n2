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
## ****************** FAQ ITERATOR ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// iterates through faqs
class FaqIterator implements Iterator {
	protected $faq, $parent, $oFaqs, $faqinfo, $count;
		
	// Constructor
	public function __construct($parent = -1) {
		global $orderedFaqs, $faqs;
		
		$this->oFaqs = $orderedFaqs;		
		$this->faqinfo = $faqs;
		$this->parent = $parent;
		
		// bleh...
		if(!is_array($this->oFaqs["$this->parent"])) {
			return false;
		}
				
		$this->faq = $this->faqinfo[current($this->oFaqs["$this->parent"])];
		$this->count = 0;
	}
	
	public function next() {
		$this->faq = $this->faqinfo[next($this->oFaqs["$this->parent"])];
	}
	
	public function rewind() {
		reset($this->oFaqs);
	}
	
	public function current() {
		return $this->faq;
	}
	
	public function valid() {
		if($this->faq instanceof FaqEntry) {
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