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
## **************** FAQ ENTRY CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class FaqEntry extends Object {
	private $faqid, $info;
		
	// Constructor
	public function __construct($id = '', $faqinfo = '') {
		if(!empty($faqinfo) AND is_array($faqinfo)) {
			$this->info = $faqinfo;
			$this->faqid = $this->info['faqid'];
		}
		
		else if(!empty($id)) {
			$this->faqid = $id;
			$this->queryInfoById();
		}
		
		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}
	
	
	// Public Methods	
	// Deletes...
	public function destroy() {
		global $orderedFaqs, $faqs, $query, $wtcDB, $lang;
		
		// can't delete the FAQ root...
		// can't delete if it's the only forum left...
		if($this->faqid == 1) {
			new WtcBBException($lang['admin_error_faqRoot']);
		}
		
		// loop through direct childs... and recursively call this method
		if(isset($orderedFaqs[$this->faqid])) {
			foreach($orderedFaqs[$this->faqid] as $id) {
				$faqs[$id]->destroy();
			}
		}
		
		new Delete('faq', 'faqid', $this->faqid, '', true, true);
	}
	
	// Updates faq entry... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['faq']['update'], Array(1 => $update, 2 => $this->faqid), 'query', false);
	}
	
	// Accessors
	public function getFaqId() {
		return $this->faqid;
	}
	
	public function getParent() {
		return $this->info['parent'];
	}
	
	public function getDirectSubs() {
		return $this->info['directSubs'];
	}
	
	public function getVarname() {
		return $this->info['varname'];
	}
	
	public function getDisOrder() {
		return $this->info['disOrder'];
	}
	
	public function getDepth() {
		return $this->info['depth'];
	}
	
	public function getInfo() {
		return $this->info;
	}
	
	// returns title of FAQ from lang
	public function getFaqTitle() {
		global $lang;
		
		return $lang[$this->info['varname'] . '__title'];
	}
	
	// returns faq entry; false if it doesn't exist
	public function getFaqEntry() {
		global $lang;
		
		if(!isset($lang[$this->info['varname'] . '__content'])) {
			return false;
		}
		
		else {
			return $lang[$this->info['varname'] . '__content'];
		}
	}
		
	
	// Protected Methods	
	// gets info if ID is given	
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;
		
		$getFaq = new Query($query['faq']['get'], Array(1 => $this->faqid));
	
		$this->info = parent::queryInfoById($getFaq);
	}
	
	
	// Static Methods
	// Public
	// inserts faq entry... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['faq']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);
	}
	
	// initiazes stuff required for FAQs
	public static function init() {
		global $orderedFaqs, $faqs, $query, $wtcDB;
		
		// init faq entries
		$faqQ = new Query($query['faq']['get_all']);
		$faqs = Array();
		$orderedFaqs = Array();
		$formOrderedFaqs = Array();
		
		while($faq = $wtcDB->fetchArray($faqQ)) {
			$faqs[$faq['faqid']] = new FaqEntry('', $faq);
			$formOrderedFaqs[$faq['parent']][$faq['disOrder']][$faq['faqid']] = $faq['faqid'];
		}
		
		foreach($formOrderedFaqs as $parentid => $meh) {
			ksort($formOrderedFaqs["$parentid"]);
		}
		
		foreach($formOrderedFaqs as $parentid => $arr3) {
			foreach($arr3 as $arr2) {
				foreach($arr2 as $id => $arr1) {
					$orderedFaqs[$parentid][$id] = $id;
				}
			}
		}
	}
}
