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
## ****************** STYLE CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Style extends Object {
	private $styleid;
	public $info;
	public static $fragments = false;

	// Constructor
	public function __construct($id = '', $styleinfo = '') {
		global $lang;
               
		if(!empty($styleinfo) AND is_array($styleinfo)) {
			$this->info = $styleinfo;
			$this->styleid = $this->info['styleid'];
		}

		else if(!empty($id)) {
			$this->styleid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		if(!is_array($this->info['fragmentids'])) {
			$this->info['fragmentids'] = unserialize($this->info['fragmentids']);
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang, $styles, $orderedStyles;

		// only one style left?
		if($this->getStyleId() == 1) {
			new WtcBBException($lang['admin_error_lastStyle']);
		}

		// we just need to iterate through direct childs
		$styleIter = new StyleIterator($this->styleid);

		foreach($styleIter as $obj) {
			$obj->destroy();
		}

		// now wipe everything
		new Delete('styles', 'styleid', $this->styleid, '');
		new Delete('styles_fragments', 'styleid', $this->styleid, '');
		@unlink('./css/' . $this->styleid . '.css');
	}

	// Updates avatar... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['styles']['update'], Array(1 => $update, 2 => $this->styleid), 'query', false);

		new Cache('Styles');
		new Cache('OrderedStyles');
	}

	// builds the fragments for THIS style
	// organized: groupid -> fragmentid
	public function buildFragments($type = 'template') {
		global $query, $wtcDB;

		$fragIds = '';
		$before = '';

		// form frag id list
		if(is_array($this->getFragmentIds())) {
			foreach($this->getFragmentIds() as $vals) {
				$fragIds .= $before . $vals['fragmentid'];
				$before = ',';
			}
		}

		// uh oh?
		if(empty($fragIds)) {
			$fragIds = 0;
		}

		if($type == 'style') {
			$allTemplates = new Query($query['styles_fragments']['get_all_inStyle_style'], Array(1 => $fragIds, $type));
		}

		else {
			$allTemplates = new Query($query['styles_fragments']['get_all_inStyle'], Array(1 => $fragIds, $type));
		}

		$regTemps = Array();
		$defTemps = Array();
		$templates = Array();

		while($template = $wtcDB->fetchArray()) {
			if(!$template['defaultid']) {
				$defTemps[$template['fragmentid']] = new StyleFragment('', $template);
			}

			else {
				$regTemps[$template['defaultid']] = new StyleFragment('', $template);
			}
		}

		// build what we want...
		foreach($defTemps as $defFragId => $obj) {
			if(isset($regTemps[$defFragId])) {
				$templates[$regTemps[$defFragId]->getGroupId()][$regTemps[$defFragId]->getFragmentId()] = $regTemps[$defFragId];
				unset($regTemps[$defFragId]);
			}

			else {
				$templates[$obj->getGroupId()][$defFragId] = $obj;
			}
		}

		// clean up customs...
		foreach($regTemps as $defid => $obj) {
			$templates[$obj->getGroupId()][$obj->getFragmentId()] = $obj;
		}

		return $templates;
	}

	// builds the fragments for THIS style by name
	// organized: type -> fragmentVarName
	public function buildFragmentsByName($type = 'template') {
		global $query, $wtcDB;

		$fragIds = '';
		$before = '';

		// form frag id list
		if(is_array($this->getFragmentIds())) {
			foreach($this->getFragmentIds() as $vals) {
				$fragIds .= $before . $vals['fragmentid'];
				$before = ',';
			}
		}

		// uh oh?
		if(empty($fragIds)) {
			$fragIds = 0;
		}

		$allTemplates = new Query($query['styles_fragments']['get_all_inStyle'], Array(1 => $fragIds, $type));
		$regTemps = Array();
		$defTemps = Array();
		$templates = Array();

		while($template = $wtcDB->fetchArray($allTemplates)) {
			if(!$template['defaultid']) {
				$defTemps[$template['fragmentid']] = new StyleFragment('', $template, true);
			}

			else {
				$regTemps[$template['defaultid']] = new StyleFragment('', $template, true);
			}
		}

		// build what we want...
		foreach($defTemps as $defFragId => $obj) {
			if(isset($regTemps[$defFragId])) {
				$templates[$regTemps[$defFragId]->getFragmentType()][$regTemps[$defFragId]->getVarName()] = $regTemps[$defFragId];
				unset($regTemps[$defFragId]);
			}

			else {
				$templates[$obj->getFragmentType()][$obj->getVarName()] = $obj;
			}
		}

		// clean up customs...
		foreach($regTemps as $defid => $obj) {
			$templates[$obj->getVarName()] = $obj;
		}

		return $templates;
	}

	// Accessors
	public function getStyleId() {
		return $this->styleid;
	}

	public function getParentId() {
		return $this->info['parentid'];
	}

	public function getFragmentIds() {
		return $this->info['fragmentids'];
	}

	public function isEnabled() {
		return $this->info['enabled'];
	}

	public function isSelectable() {
		return $this->info['selectable'];
	}

	public function getName() {
		return $this->info['name'];
	}

	public function getCSS() {
		return $this->info['css'];
	}

	public function getDisOrder() {
		return $this->info['disOrder'];
	}

	public function getInfo() {
		return $this->info;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getStyle = new Query($query['styles']['get'], Array(1 => $this->styleid));

		$this->info = parent::queryInfoById($getStyle);
	}


	// Static Methods
	// Public
	// inserts style... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['styles']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		// update styles now...
		Style::buildStyles();

		new Cache('Styles');
		new Cache('OrderedStyles');
	}

	// builds all the fragments
	// organized: styleid -> fragmentid
	public static function buildAllFragments() {
		global $query, $wtcDB;

		$allTemplates = new Query($query['styles_fragments']['get_all']);
		$regTemps = Array();
		$defTemps = Array();
		$templates = Array();

		while($template = $wtcDB->fetchArray($allTemplates)) {
			// delete CSS file...
			if(file_exists('./css/' . $template['fragmentid'] . '_' . preg_replace('/\s+/', '-', $template['fragmentVarName']) . '.css')) {
				@unlink('./css/' . $template['fragmentid'] . '_' . preg_replace('/\s+/', '-', $template['fragmentVarName']) . '.css');
			}

			if(!$template['defaultid']) {
				$defTemps[$template['fragmentid']] = new StyleFragment('', $template);
			}

			else {
				$regTemps[$template['defaultid']][$template['fragmentid']] = new StyleFragment('', $template);
			}
		}

		// build what we want...
		foreach($defTemps as $defFragId => $obj) {
			if(isset($regTemps[$defFragId])) {
				foreach($regTemps[$defFragId] as $fragObj) {
					$templates[$fragObj->getStyleId()][$fragObj->getFragmentId()] = $fragObj;
				}

				unset($regTemps[$defFragId]);
			}

			else {
				$templates[0][$defFragId] = $obj;
			}
		}

		// add in the rest...
		foreach($regTemps as $defid => $more) {
			foreach($more as $fragid => $obj) {
				$templates[$obj->getStyleId()][$obj->getFragmentId()] = $obj;
			}
		}

		return $templates;
	}

	// this method will rebuild all styles
	// making sure fragments inheirt or override and what not...
	public static function buildStyles() {
		global $wtcDB, $lang;

		// initiate some stuff...
		$styleIter = new RecursiveIteratorIterator(new RecursiveStyleIterator(-1, 0, true), true);
		$templates = Style::buildAllFragments();
		$fragIds = Array();

		// create an array correlating the type of a CSS val
		// to it's actual property
		$cssCorrelation = Array(
							'bgColor' => 'background:',
							'fontFamily' => 'font-family:',
							'fontColor' => 'color:',
							'fontSize' => 'font-size:',
							'fontStyle' => 'font-style:',
							'fontWeight' => 'font-weight:',
							'textDec' => 'text-decoration:',
							'advanced_extra' => ''
						);

		// now a correlation for the different kinds of classes
		$classCorrelation = Array(
								'main' => '', 'regLink' => ' a', 'visitLink' => ' a:visited',
								'hoverLink' => ' a:hover'
							);

		foreach($styleIter as $style) {
			// loop through fragids and set to inherit...
			if(isset($fragIds[$styleIter->getDepth() - 1])) {
				foreach($fragIds[$styleIter->getDepth() - 1] as $styleid => $more) {
					foreach($more as $index => $vals) {
						$fragIds[$styleIter->getDepth()][$style->getStyleId()][$index]['type'] = 'inherit';
						$fragIds[$styleIter->getDepth()][$style->getStyleId()][$index]['fragmentid'] = $vals['fragmentid'];
					}
				}
			}

			// iterate through each style's templates
			// keep a defaultid to fragmentid relationship
			// so we know which ids to override...
			if(isset($templates[$style->getStyleId()])) {
				foreach($templates[$style->getStyleId()] as $fragid => $template) {
					$fragIds[$styleIter->getDepth()][$style->getStyleId()][$template->getDefaultId()] = Array(
															'type' => 'override',
															'fragmentid' => $fragid
														);
				}
			}

			// serialize and update...
			$update['fragmentids'] = serialize($fragIds[$styleIter->getDepth()][$style->getStyleId()]);
			$style->info['fragmentids'] = $fragIds[$styleIter->getDepth()][$style->getStyleId()];
			$style->update($update);

			// now build the style sheet for each style...
			$css = $style->buildFragments('style');
			$sheet = '/**' . "\n";
				$sheet .= ' * CSS For Style: ' . $style->getName() . "\n";
				$sheet .= ' * Style ID: ' . $style->getStyleId() . "\n";
			$sheet .= ' */' . "\n\n";

			foreach($css as $groupid => $more) {
				foreach($more as $fragid => $cssObj) {
					$cssVals = unserialize($cssObj->getFragment());

					if(is_array($cssVals)) {
						foreach($classCorrelation as $section => $class) {
							if($section != 'main') {
								$sheet .= "\t";
							}

							// make sure we insert the class for each comma...
							if(strpos($cssObj->getName(), ',') === false) {
								$useClass = $cssObj->getName() . $class;
							}

							else {
								$useClass = preg_replace('/,\s*/', $class . ', ', $cssObj->getName()) . $class;
							}

							$sheet .= $useClass . ' {' . "\n";

							foreach($cssVals as $type => $val) {
								if(strpos($type, $section) === false OR empty($val)) {
									continue;
								}

								// extract type from type
								$realType = substr($type, strpos($type, '_') + 1);

								// add extra tab if not main...
								if($section != 'main') {
									$sheet .= "\t";
								}

								$sheet .= "\t" . $cssCorrelation[$realType] . ' ' . $val . ';' . "\n";
							}

							// extra?
							if($section == 'main' AND !empty($cssVals['extra'])) {
								$sheet .= "\t" . preg_replace('/\n/', "\t", $cssVals['extra']) . "\n";
							}

							if($section != 'main') {
								$sheet .= "\t";
							}

							$sheet .= '}' . "\n\n";
						}
					}
				}
			}

			// get rid of empty "select {}" stuff...
			$sheet = trim(preg_replace('/.+{\s*}/iU', '', $sheet));

			// get rid of huge spacing...
			while(preg_match('/\n{3,}/isU', $sheet)) {
				$sheet = preg_replace('/\n{3,}/isU', "\n", $sheet);
			}

			file_put_contents('./css/' . $style->getStyleId() . '.css', $sheet);
			$style->update(Array('css' => $sheet));
		}
	}

	// initializes all styles
	public static function init() {
		global $styles, $wtcDB, $query, $_CACHE;

		if(!($styles = Cache::load('styles'))) {
			$getStyles = new Query($query['styles']['get_all']);

			while($style = $getStyles->fetchArray()) {
				unset($style['css']); // don't want to clog memory

				$styles[$style['styleid']] = new Style('', $style);
			}
		}
	}
}
