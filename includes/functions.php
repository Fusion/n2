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
## **************** GENERAL FUNCTIONS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * Auto Loads classes...
 */
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

	return $total;
}

?>