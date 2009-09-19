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
		$this->formImportWords();
		
		// if we're overwriting... make array of words
		// so if some IDs are screwy, we can correct it...
		if($newLangid > -1) {
			$getWords = new Query($query['admin']['get_words_noDefault'], Array(1 => $newLangid));
			
			while($word = $wtcDB->fetchArray($getWords->getRes())) {
				$this->words[$word['defaultid']] = $word['wordsid'];
			}
		}
		
		// Go!
		$this->import();
		Language::cache();
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

		// For starters, load existing categories definitions
        $groupIter = new RecursiveIteratorIterator(new RecursiveGroupIterator('lang_words'), true);
		$parentsArr = array();
		foreach($groupIter as $obj) {
			$parentsArr[$obj->getGroupUUID()]  = $obj;
		}

		// Import all categories
		$parentIdToRealId = array();
		foreach($this->importCats as $catid => $info) {
			if(!isset($parentsArr[$info['catuuid']])) {
				// This is a brand-new category! Create it...
				if(!empty($info['parentuuid']) && !isset($parentsArr[$info['parentuuid']])) {
					die("I am sorry, but category '".$info['catName']."' references a non-existent parent.");
				}
				$parent = $parentsArr[$info['parentuuid']];
				Group::insert(
						array(
							'groupType' => 'lang_words',
							'groupuuid' => $info['catuuid'],
							'groupName' => unhtmlspecialchars($info['catName']),
							'deletable' => $info['deletable'],
							'parentuuid' => $info['parentuuid'],
							'parentid' => $parent->getGroupId(),
							)
						);
				// Of course this group now becomes a potential parent
				$parentsArr[$info['catuuid']] = new Group(
						false,
						array(
							'groupType' => 'lang_words',
							'groupuuid' => $info['catuuid'],
							'groupName' => $info['catName'],
							'deletable' => $info['deletable'],
							'parentuuid' => $info['parentuuid'],
							'parentid' => $parent->getGroupId(),
							)
					);
				$parentsArr[$info['catuuid']]->forceGroupId($wtcDB->lastInsertId());
			}

			// Update current id mapping
			// Note: new info[catid] is bogus! It's likely not the category's real id
			// but it's how it is referenced in our xml file
			$parentIdToRealId[$catid] = $parentsArr[$info['catuuid']]->getGroupId();
		}
		
		// now words...
		foreach($this->importWords as $wordsid => $info) {
			// As we know, ids are quite volatile. Let's match real ids...
			if(!isset($parentIdToRealId[$info['catid']])) {
				// Should never happen unless xml file was edited by hand
				die("I am sorry, but word '".$info['name']."' references a non-existent category.");
			}
			$realCatId = $parentIdToRealId[$info['catid']];
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
																4 => $realCatId,
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
																		5 => $realCatId,
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
																	'catuuid' => $node->getAttribute('catuuid'),
																	'catName' => $node->getAttribute('catName'),
																	'deletable' => $node->getAttribute('deletable'),
																	'parentid' => $node->getAttribute('parentid'),
																	'parentuuid' => $node->getAttribute('parentuuid'),
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
