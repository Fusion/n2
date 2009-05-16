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
## ************* RECURSIVE FAQ ITERATOR ************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// recusively loops through faqs
class RecursiveFaqIterator extends FaqIterator implements RecursiveIterator {
	private $limit;
	
	// Constructor
	public function __construct($parent = -1, $faqLimit = 0) {
		global $orderedFaqs, $faqs;
		
		parent::__construct($parent);
		$this->limit = $faqLimit;
	}
	
	public function hasChildren() {
		// weird... putting "$this->faq->getDirectSubs()" in the 
		// empty function gave me errors... o_0		
		$checkId = $this->faq->getFaqId();
		
		return (isset($this->oFaqs["$checkId"]));
	}
	
	public function getChildren() {		
		return new RecursiveFaqIterator($this->faq->getFaqId(), $this->limit);
	}
}
