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
## **************** GENERAL FUNCTIONS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

function __autoload($className) {
	global $classPath;

	foreach($classPath as $index => $path) {
		if(file_exists($path . $className . '.class.php')) {
			require_once($path . $className . '.class.php');

			break;
		}

		else if(file_exists($path . $className . '.interface.php')) {
			require_once($path . $className . '.interface.php');

			break;
		}
	}
}


/**
 * Outputs DEBUG messages
 */
function _DEBUG($strOrArray, $pre = true) {
	if($pre) {
		print('<pre style="font-size: 10pt;">');
	}

	if(is_array($strOrArray)) {
		print_r($strOrArray);
	}

	else {
		print($strOrArray);
	}

	if($pre) {
		print('</pre>');
	}
}


/**
 * Sees if a value in an array matches
 * a value in another array...
 * Very dangerous, only use if you must
 */
function searchArray($arr1, $arr2) {
	if(!is_array($arr2)) {
		return false;
	}

	foreach($arr1 as $v) {
		if(in_array($v, $arr2)) {
			return true;
		}
	}

	return false;
}


/**
 * Replaces values in keys of an array
 */
function array_str_replace($search, $replace, $subject) {
	foreach($subject as $key => $val) {
		$subject[str_replace($search, $replace, $key)] = $val;
		unset($subject[$key]);
	}

	return $subject;
}


/**
 * array_map... but recursion!
 * (actually, it only handles a matrix)
 */
function array_map_recursive($func, $arr) {
   $result = array();

   do {
       $key = key($arr);

       if (is_array(current($arr))) {
           $result[$key] = array_map($func, $arr[$key]);
           $result += $result[$key];
       }

       else {
           $result[$key] = $func(current($arr));
       }
   } while(next($arr) !== false);

   return $result;
}


/**
 * Neatly trims strings...
 */
function trimString($string, $trim) {
	// make sure that the length of string is larger than trim
	if(strlen($string) > $trim) {
		// trim
		$string = substr($string, 0, strrpos(substr($string, 0, $trim), ' '));

		// add some dots to make it look good
		$string .= '...';

		// return!
		return $string;
	}

	return $string;
}


/**
 * This function will strip
 * the session id from any URL
 */
function stripSessionId($url) {
	return preg_replace('/(\?)?(&|&amp;|)session=([^=]+)/is', '$1', $url);
}


/**
 * wtcBB Addslashes function
 * Checks for magic_quotes_gpc
 * If enabled, won't addslashes
 */
function wtcslashes($string) {
	if(!get_magic_quotes_gpc()) {
		return addslashes($string);
	}

	else {
		return $string;
	}
}


/**
 * Function to htmlspecialchar
 * quotes only
 */
function wtcquotes($text) {
	$find = Array("'", '"');
	$replace = Array('&#039;', '&quot;');

	return str_replace($find, $replace, $text);
}


/**
 * HTMLSPECIALCHARS... so i can change it's behavior
 * easily... basically so I don't need to use ENT_QUOTES
 */
function wtcspecialchars($retval) {
	if(is_array($retval)) {
		$retval = array_map('wtcspecialchars', $retval);
	}

	else {
		$retval = htmlspecialchars($retval, ENT_QUOTES);
	}

	return $retval;
}


/**
 * We use htmlspecialchars, so it wouldn't be
 * applicable to use html_entity_decode
 */
function unhtmlspecialchars($text) {
   // flip html translation table
   $trans_table = array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES));

   // add &#039;
   $trans_table['&#039;'] = "'";

   // use the strtr function to replace occurrences
   return strtr($text, $trans_table);
}

function n2urlize($text) {
	return
		str_replace(
			array('/', '?'),
			array('&#47;', '&#63;'),
			$text);
}

/**
 * Take a regular link and seoize it if necessary
 */
function n2link($text, $removeHead = false) {
	if($removeHead)
		$text = str_replace('./index.php?', '', $text);
		
	if(SEO)
	{
		return 
			HOME .
			str_replace(
				array('=', '&amp;'),
				array('/', '/'),
				$text);
	}
	else if(!ADMIN)
	{
		return '?'.$text;
	}
	else
	{
		return $text;
	}
}

/**
 * Alias to censor stuff
 */
function censor($txt) {
	global $bboptions;

	return Censor::c($txt);
}

/**
 * function to grab database layer
 */
function getDBAClass() {
	switch(DB_ENGINE) {
		case 'MySQL':
			require_once('./sql/MySQL/WtcDBA.class.php');
		break;

		case 'MySQLi':
			require_once('./sql/MySQLi/WtcDBA.class.php');
		break;
	}
}


/**
 * Gets page load time
 */
function pageLoadTime() {
	global $startTime;

	// do some exploding, and format
	$startTime2 = explode(' ', $startTime);
	$startMillSec = $startTime2[0];
	$startRegSec = new WtcDate('s', $startTime2[1]);
	$startRegSec = $startRegSec->getDate();

	$endTime = explode(' ', microtime());
	$endMillSec = $endTime[0];
	$endRegSec = new WtcDate('s', $endTime[1]);
	$endRegSec = $endRegSec->getDate();

	$startTotal = $startRegSec + $startMillSec;
	$endTotal = $endRegSec + $endMillSec;
	$total = $endTotal - $startTotal;

	// what if end is 0.xxx and start is xx.xxx??
	if($total < 0) {
		$startDiff = 60 - $startTotal;
		$total = $startDiff + $endTotal;
	}

	return number_format($total, 2);
}

/**
 * Gets cpu load
 */
	function getServerLoad()
	{
		$loadavg = false;
		
		// Original algorithm is taken from
		// Adodb perf source code, taken from
		// http://msdn.microsoft.com/library/default.asp?url=/library/en-us/wmisdk/wmi/example__obtaining_raw_performance_data.asp
		if (strncmp(PHP_OS,'WIN',3)==0)
		{
			if (PHP_VERSION == '5.0.0') return false;
			if (PHP_VERSION == '5.0.1') return false;
			if (PHP_VERSION == '5.0.2') return false;
			if (PHP_VERSION == '5.0.3') return false;
			if (PHP_VERSION == '5.0.11') return false; # see http://bugs.php.net/bug.php?id=31737
			if (PHP_VERSION == '5.0.12') return false; # see http://bugs.php.net/bug.php?id=31737
			if (PHP_VERSION == '4.3.10') return false; # see http://bugs.php.net/bug.php?id=31737
			
			@$c = new COM("WinMgmts:{impersonationLevel=impersonate}!Win32_PerfRawData_PerfOS_Processor.Name='_Total'");
			if (!$c) return false;
			
			$info[0] = $c->PercentProcessorTime;
			$info[1] = 0;
			$info[2] = 0;
			$info[3] = $c->TimeStamp_Sys100NS;
			return $info;
		}
		
		if ( @file_exists('/proc/loadavg') )
		{
			$f = @fopen("/proc/loadavg", "r");
			if($f)
			{
				$line = fgets($f);
				if($line)
				{
					$tokens = explode( ' ', $line );
					$loadavg = trim($tokens[0]);
				}
				fclose($f);
			}
		}
		return $loadavg;
	}
?>