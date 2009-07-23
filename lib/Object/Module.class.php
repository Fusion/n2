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
## ***************** MODULE CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Module extends Object {
	private $info, $moduleid;

	// Constructor
	public function __construct($typeOrId = '', $name = '') {
		if(!empty($typeOrId) && !empty($name)) {
			$this->queryInfoByTypeName($typeOrId, $name);
			$this->moduleid = $this->info['moduleid'];
		}

		else if(!empty($typeOrId)) {
			$this->moduleid = $typeOrId;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}

	public function destroy() {}
	
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['modules']['update'], Array(1 => $update, 2 => $this->moduleid), 'query', false);	
	}
	
	public function getPath() {
		return $this->info['path'];
	}
	
	public static function updateAll($what, $where, $arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['modules']['update_all'], Array(1 => $update, 2 => $what, 3 => $type), 'query', false);	
	}
	
	public static function insert($arr) {
		global $wtcDB, $query;
		
		$db = $wtcDB->massInsert($arr);
		new Query($query['modules']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);	
	}

	public static function getModules() {
		global $query;
		
		$modules = array();
			
		$toppath = 'modules';				
		$pdir = dir($toppath);
		
		while(false !== ($plugin = $pdir->read())) {
			if($plugin[0] == '.')
				continue;
				
			$curPlugin = $toppath . '/' . $plugin;
			if(is_dir($curPlugin))
				$curInfo = self::findMainFile($curPlugin);
			else
				$curInfo = self::retrieveInfo($curPlugin);
			if(!$curInfo)
				continue;
				
			if(!isset($plugins[$curInfo['n2type']])) {
				$plugins[$curInfo['n2type']] = array();
			}
			
			$plugins[$curInfo['n2type']][$curInfo['name']] = $curInfo;
		}
		
		$pdir->close();
		
		$modulesArr = array();
				
		$dbModules = new Query($query['modules']['get_all']);
		while($dbModule = $dbModules->fetchArray()) {
			if(!$modulesArr[$dbModule['type']]) {
				$modulesArr[$dbModule['type']] = array();
			}
			$modulesArr[$dbModule['type']][$dbModule['name']] = $dbModule;
		}
		
		foreach($plugins as $type => $info) {
			foreach($info as $name => $moreinfo) {
				if($modulesArr[$type] && $modulesArr[$type][$name]) {
					$plugins[$type][$name]['enabled'] = $modulesArr[$type][$name]['enabled'];
					$plugins[$type][$name]['default'] = $modulesArr[$type][$name]['default'];
				}
				else {
					// Not in database yet
					$plugins[$type][$name]['enabled'] = false;
					$info = array(
						'type' => $plugins[$type][$name]['n2type'],
						'name' => $name,
						'path' => $plugins[$type][$name]['path'],
						'long_name' => $plugins[$type][$name]['long_path'] ? $plugins[$type][$name]['long_path'] : $name,
						'`default`' => 0
					);
					self::insert($info);
				}
			}
		}
		
		return $plugins;
	}
	
	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getModule = new Query($query['modules']['get'], Array(1 => $this->moduleid));
		$this->info = parent::queryInfoById($getModule);
	}
	
	protected function queryInfoByTypeName($type, $name) {
		global $query, $lang, $wtcDB;

		$getModule = new Query($query['modules']['get_by_type_name'], array(1 => $type, 2 => $name));
		$this->info = parent::queryInfoById($getModule);
		
	}

	static protected function findMainFile($path) {
		$fdir = dir($path);
		
		while(false !== ($file = $fdir->read())) {
			if($file[0] == '.')
				continue;
				
			if(strrpos($file, '.php') != strlen($file) - 4)
				continue;
				
			$curFile = $path . '/' . $file;
			$curInfo = self::retrieveInfo($curFile);
			if(!$curInfo)
				continue;
				
			return $curInfo;
		}
		
		return null;
	}

	static protected function retrieveInfo($path) {
		$contents = @file_get_contents($path);
		if(!$contents)
			return null;
			
		$trimchars = "\t\n\r";
		
		if(preg_match('#Plugin Name:(?:\s)(.+)#i', $contents, $matches) < 1)
			return null;
			
		$ret = array('enabled' => false, 'path' => $path, 'name' => trim($matches[1], $trimchars));
		if(preg_match('#Plugin URI:(?:\s)(.+)#i', $contents, $matches) > 0) {
			$ret['plugin_uri'] = trim($matches[1], $trimchars);
		}
		if(preg_match('#Description:(?:\s)(.+)#i', $contents, $matches) > 0) {
			$ret['description'] = trim($matches[1], $trimchars);
		}
		if(preg_match('#Author URI:(?:\s)(.+)#i', $contents, $matches) > 0) {
			$ret['author_uri'] = trim($matches[1], $trimchars);
		}
		if(preg_match('#Long Name:(?:\s)(.+)#i', $contents, $matches) > 0) {
			$ret['long_name'] = trim($matches[1], $trimchars);
		}
		if(preg_match('#N2Type:(?:\s)(.+)#i', $contents, $matches) > 0) {
			$ret['n2type'] = trim($matches[1], $trimchars);
		}
		else {
			$ret['n2type'] = 'W';
		}
		
		return $ret;
	}
}
