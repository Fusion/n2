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
## **************** IMPORT LANGUAGE ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class ImportLanguage {
	private $xml, $type, $cats, $dom;
	private $importCats, $importSubCats, $importWords;
	private $trackCats, $createLang, $langid, $words;
	private $insertLangId, $langName;
	
	// Constructor
	public function __construct($xmlContents, $newLangid = -1, $newLangName = '', $typeOfImport = 'normal') {
		global $wtcDB, $query;
				
		// set instance variables		
		$this->xml = $xmlContents;
		$this->type = $typeOfImport;
		$this->langid = $newLangid;
		$this->insertLangId = 0;
		$this->langName = $newLangName;
		$this->importCats = Array();
		$this->importSubCats = Array();
		$this->importWords = Array();
		$this->trackCats = Array();
		$this->words = Array();
		
		// instantiate DOM
		$this->dom = new DomDocument();
		
		// load XML
		$this->dom->loadXML($this->xml);
		
		// form arrays
		$this->formImportCats();
		$this->formImportSubCats();
		$this->formImportWords();
		
		// if we're overwriting... make array of words
		// so if some IDs are screwy, we can correct it...
		if($newLangid > -1) {
			$getWords = new Query($query['admin']['get_words_noDefault'], Array(1 => $newLangid));
			
			while($word = $wtcDB->fetchArray($getWords->getRes())) {
				$this->words[$word['defaultid']] = $word['wordsid'];
			}
		}
		
		/*print('<pre>');
		print_r($this->importCats); print_r($this->importSubCats); print_r($this->importWords);
		print('</pre>');*/
		
		// Go!
		$this->import();
	}
	
	// Private Methods
	// main import method
	private function import() {
		global $query, $wtcDB;
		
		// if we're importing into existing style... just do a replace into
		// otherwise, we need to insert AND keep a correlation of old ids to new ids
		// so we can insert words and subcats correctly...
		// insert new language first?
		if($this->langid == -1) {
			new Query($query['admin']['insert_lang'], Array(1 => $this->langName));
			$this->insertLangId = $wtcDB->lastInsertId();
		}			
		
		foreach($this->importCats as $catid => $info) {
			if($this->langid == -1) {
				new Query($query['admin']['insert_langCat'], Array(
																1 => unhtmlspecialchars($info['catName']),
																2 => $info['depth'],
																3 => $info['parentid']
															));
															
				$this->trackCats[$info['catid']] = $wtcDB->lastInsertId();
			}
			
			else {
				new Query($query['admin']['import_replaceIntoCat'], Array(
																		1 => $catid,
																		2 => unhtmlspecialchars($info['catName']), 
																		3 => $info['depth'], 
																		4 => $info['parentid']
																	));
			}
		}

		// now sub-categories...
		foreach($this->importSubCats as $catid => $info) {
			if($this->langid == -1) {
				new Query($query['admin']['insert_langCat'], Array(
																1 => unhtmlspecialchars($info['catName']),
																2 => $info['depth'],
																3 => $this->trackCats[$info['parentid']]
															));
															
				$this->trackCats[$info['catid']] = $wtcDB->lastInsertId();
			}
			
			else {
				new Query($query['admin']['import_replaceIntoCat'], Array(
																		1 => $catid, 
																		2 => unhtmlspecialchars($info['catName']), 
																		3 => $info['depth'], 
																		4 => $info['parentid']
																	));
			}
		}
		
		// now words...
		foreach($this->importWords as $wordsid => $info) {
			if($this->langid == -1) {
				$wordLangId = $this->insertLangId;
				
				// if default id, make the langid 0...
				if(!$info['defaultid']) {
					$wordLangId = 0;
				}
				
				new Query($query['admin']['insert_words'], Array(
																1 => unhtmlspecialchars($info['name']), 
																2 => $info['words'], 
																3 => $this->insertLangId, 
																4 => $this->trackCats[$info['catid']], 
																5 => unhtmlspecialchars($info['displayName']), 
																6 => $info['defaultid']
															));
			}
			
			else {
				$id = $wordsid;
				$wordLangId = $this->langid;
				
				// hmmm... check to see if IDs have changed... o_0
				if(isset($this->words[$info['defaultid']]) AND $this->words[$info['defaultid']] != $wordsid) {
					$id = $this->words[$info['defaultid']];
				}
				
				// if it's a default word... use 0 langid!
				if(!$info['defaultid']) {
					$wordLangId = 0;
				}
					
				new Query($query['admin']['import_replaceIntoWords'], Array(
																		1 => $id, 
																		2 => unhtmlspecialchars($info['name']), 
																		3 => $info['words'], 
																		4 => $wordLangId, 
																		5 => $info['catid'], 
																		6 => unhtmlspecialchars($info['displayName']), 
																		7 => $info['defaultid']
																	));
			}
		}			
	}
	
	private function formImportCats() {
		$allCats = $this->dom->getElementsByTagName('Category');
		
		foreach($allCats as $node) {
			$this->importCats[$node->getAttribute('catid')] = Array(
																	'catid' => $node->getAttribute('catid'),
																	'catName' => $node->getAttribute('catName'),
																	'depth' => $node->getAttribute('depth'),
																	'parentid' => $node->getAttribute('parentid')
																);
		}
	}
	
	private function formImportSubCats() {
		$allSubCats = $this->dom->getElementsByTagName('SubCategory');
		
		foreach($allSubCats as $node) {
			$this->importSubCats[$node->getAttribute('catid')] = Array(
																	'catid' => $node->getAttribute('catid'),
																	'catName' => $node->getAttribute('catName'),
																	'depth' => $node->getAttribute('depth'),
																	'parentid' => $node->getAttribute('parentid')
																);
		}
	}
	
	private function formImportWords() {
		$allWords = $this->dom->getElementsByTagName('Word');
		
		foreach($allWords as $node) {
			$this->importWords[$node->getAttribute('wordsid')] = Array(
																	'wordsid' => $node->getAttribute('wordsid'),
																	'name' => $node->getAttribute('name'),
																	'catid' => $node->getAttribute('catid'),
																	'displayName' => $node->getAttribute('displayName'),
																	'defaultid' => $node->getAttribute('defaultid'),
																	'words' => $node->nodeValue
																);
		}
	}
}
	

?>