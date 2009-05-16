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
