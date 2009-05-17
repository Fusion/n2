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