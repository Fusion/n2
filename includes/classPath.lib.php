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

function __autoload($className)
{ 
	ClassLoader::instance()->loadClass($className);
} 

function import($path)
{
	ClassLoader::instance()->import($path);
}

class ClassLoader
{
private $_classpath, $_imports, $_wildcardFiles;
static private $_classLoader;

	private function __construct()
	{
		$this->_classpath	= array(
			'./lib',
			'./lib/Cache',
			'./lib/import-export',
			'./lib/interfaces',
			'./lib/iterators',
			'./lib/iterators/FaqIterator',
			'./lib/iterators/ForumIterator',
			'./lib/iterators/GroupIterator',
			'./lib/iterators/StyleIterator',
			'./lib/Log',
			'./lib/Object',
			'./lib/Object/User',
		);
		$this->_imports       = array();
		$this->_wildcardFiles = array();

		// Constants for classpath management
		define('SEARCH_CP',	true);
		define('NO_SEARCH',	false);
	}

	static function instance()
	{
		if(!self::$_classLoader)
			self::$_classLoader = new ClassLoader();
		return self::$_classLoader;
	}

	public function addToClasspath($path)
	{
		// Take precedence
		array_unshift($this->_classpath, $path);
	}

	public function import($path)
	{
		$c = $this->_getClass($path);
		if($c == '*')
		{
			$searchPath = $path;
			foreach($this->_classpath as $classpath)
			{
				$fullPath = $classpath . '/' . $searchPath;
				if(file_exists($fullPath) && is_dir($fullPath))
				{
					foreach(glob($fullPath . '/*.php') as $filename)
					{
						$filename = str_replace('.php', '', $filename);
						$p = strrpos($filename, '/');
						$c_name = substr($filename, $p+1);
						$this->_import($c_name, $filename, NO_SEARCH);
					}
				}
			}
		}
		else
		{
			$this->_import($c, $path, SEARCH_CP);
		}
	}

	function loadClass($fileName)
	{
		global $inflector, $context;

		if(isset($this->_imports[$fileName]))
		{
			include_once($this->_imports[$fileName] . '.php');
			return;
		}
		else
		{
			foreach($this->_classpath as $classpath)
			{
				$fullPath = $classpath . '/' . $fileName . '.class.php';
				if(file_exists($fullPath))
				{
					include_once($fullPath);
					return;
				}
				$fullPath = $classpath . '/' . $fileName . '.interface.php';
				if(file_exists($fullPath))
				{
					include_once($fullPath);
					return;
				}
			}
			throw new Exception("Class not found error: $fileName");
		}
	}

	private function _import($name, $path, $searchClasspath)
	{
		if(SEARCH_CP == $searchClasspath)
		{
			$found = false;
			foreach($this->_classpath as $classpath)
			{
				$fullPath = $classpath . '/' . $path . '.class.php';
				if(file_exists($fullPath))
				{
					$found = true;
					$path = str_replace('.php', '', $fullPath);
					break;
				}
				$fullPath = $classpath . '/' . $path . '.interface.php';
				if(file_exists($fullPath))
				{
					$found = true;
					$path = str_replace('.php', '', $fullPath);
					break;
				}
			}
			if(!$found)
				throw new Exception("Class not found error: $path");
		}

		$key = $name;
		$value = $path;
		if(isset($this->_imports[$key]) && $this->_imports[$key] != $value)
			throw new Exception(
				"Package conflict when importing from $value.php: conflicts with " .
				$this->_imports[$key] . '.php');
		$this->_imports[$key] = $value;
	}

	private function _getClass($path)
	{
		if(false !== ($p = strrpos($path, '.')))
			return substr($path, $p+1);
		else
			return $path;
#		throw new Exception("Sorry, no class found in $path");
	}

	private function _getPath($path)
	{
		if(false !== ($p = strrpos($path, '.')))
			return substr($path, 0, $p);
		return '';
	}
}

### MODULES

function loadModule($name)
{
	$modulePath = n2links('modules/'.$name.'/'.$name.'.mod.php');
	require $modulePath;
	$getModule = 'getModule_'.$name;
	return $getModule();
}
?>
