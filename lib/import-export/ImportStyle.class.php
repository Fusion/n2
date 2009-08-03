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
## ****************** IMPORT STYLE ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class ImportStyle {
	private $xml, $dom, $parentId, $styleName;
	
	// Constructor
	public function __construct($xmlContents, $parentId, $newStyleName) {
		global $wtcDB, $query;
				
		// set instance variables		
		$this->xml = $xmlContents;
		$this->parentId = $parentId;
		$this->styleName = $newStyleName;
		
		// instantiate DOM
		$this->dom = new DomDocument();
		
		// load XML
		$this->dom->loadXML($this->xml);
		
		$this->import();
	}
	
	// Private Methods
	// main import method
	private function import() {
		global $query, $wtcDB;

		/*
		 * We are going to import a new skin
		 * Things such as fragmentid and stylid are worthless because we are going
		 * to assign new ids all around.
		 *
		 * First, we are going to create a new style
		 * We will then insert all fragments
		 * And finally update style info.
		 */

		$styles = $this->dom->getElementsByTagName('style');

		// This loop would be useful if we stored more than one style per xml file
		// But we don't therefore some shortcuts are taken.
		foreach($styles as $style) {
			$css = $style->getElementsByTagName('css');

			foreach($css as $sheet) {
				$cssContent = $sheet->nodeValue;
				break;
			}

			Style::beginPartialInsert(Array(
				'parentid' => $this->parentId,
				'name' => $this->styleName,
				'disOrder' => 1,
				'selectable' => 1,
				'enabled' => 1,
				'css' => $cssContent
				), true
			);
			
			$styleId = $wtcDB->lastInsertId();
		}





		$fragments = $this->dom->getElementsByTagName('fragment');
		
		foreach($fragments as $frag) {
			$template = $frag->getElementsByTagName('template');

			foreach($template as $t) {
				$myFrag = $t->nodeValue;
				break;
			}
			
			$myFrag = str_replace("\n", "\r\n", $myFrag);
			
			StyleFragment::insert(Array(
#				'fragmentid' => $frag->getAttribute('fragmentid'),
#				'styleid' => $frag->getAttribute('styleid'),
				'styleid' => $styleId,
				'groupid' => $frag->getAttribute('groupid'),
				'fragmentName' => $frag->getAttribute('fragmentName'),
				'fragmentVarName' => $frag->getAttribute('fragmentVarName'),
				'fragmentType' => $frag->getAttribute('fragmentType'),
				'defaultid' => $frag->getAttribute('defaultid'),
				'disOrder' => $frag->getAttribute('disOrder'),
				'fragment' => $myFrag,
				), true
			);
		}
		
		Style::completePartialInsert();
		
		// Fix PHP
		$search = new Query($query['styles_fragments']['get_all_ids'], array(1 => 'template'));
		
		// nuttin!
		if(!$wtcDB->numRows($search)) {
			new WtcBBException($lang['admin_error_noResults']);
		}
	
		// alrighty... loop through and put results into array
		while($result = $wtcDB->fetchArray($search)) {
			$fragmentObj = new StyleFragment($result['fragmentid']);
			$updateData = array('template_php' => StyleFragment::parseTemplate($fragmentObj->getFragment()));
			$fragmentObj->update($updateData);
		}			
	}
}
	

?>