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
## ****************** CACHE CLASS ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Make sure you call cache classes
// AFTER new information has been inserted
// into database
class Cache {
	protected $cacheType, $cacheInfo, $cacheArray, $cacheContents;
	
	// Constructor
	public function __construct($cacheName) {
		$this->cacheType = '';
		$this->cacheInfo = '';
		$this->cacheArray = 0;
		$this->cacheContents = '';
		
		if($cacheName == 'Forums' OR $cacheName == 'OrderedForums') {
			return;
		}
		
		eval('new ' . $cacheName . '();');
	}
	
	
	// Protected Methods
	protected function insert() {
		global $query, $wtcDB;
		
		//$q = new Query($query['global']['cache_insert'], Array(1 => $this->cacheType, $this->cacheInfo, $this->cacheArray));
		
		$this->cacheFile();
	}
	
	protected function update() {
		global $query, $wtcDB;
		
		//new Query($query['global']['cache_update'], Array(1 => $this->cacheType, $this->cacheInfo, $this->cacheArray, $this->cacheType));
		
		$this->cacheFile();
	}
	
	// caches the file
	protected function cacheFile() {
		// write cache contents to file (as PHP code)
		//if(!empty($this->cacheContents)) {
			$this->cacheContents = '<?php
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
 ' . "\n\n" . $this->cacheContents . "\n" . '?>';
			file_put_contents('./cache/' . $this->cacheType . '.cache.php', $this->cacheContents);
		//}
	}
	
	// MUST BE OVERLOADED
	protected function formCache() {}
	
	// STATIC METHODS
	// this will load cache data
	public static function load($cacheItemToRetrieve) {
		extract($GLOBALS);
		
		$path = './cache/' . $cacheItemToRetrieve . '.cache.php';
		
		if(file_exists($path)) {
			require_once($path);
			
			if(!isset(${$cacheItemToRetrieve})) {
				$retval = Array(0);
			}
			
			else {
				$retval = ${$cacheItemToRetrieve};
			}
		}
		
		else {
			$retval = false;
		}
		
		return $retval;
	}
	
	// this makes an array writable
	public static function writeArray($array) {
		$retval = '';
		$before = '';
		
		foreach($array as $key => $val) {
			$retval .= $before . '\'' . str_replace("'", "\'", $key) . '\' => \'' . str_replace("'", "\'", $val) . '\'';
			$before = ', ';
		}
		
		return $retval;
	}
}
