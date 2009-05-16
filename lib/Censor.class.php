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
## ****************** CENSOR CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Censor {
	private static $find = false, $replace = false, $censor = true, $construct = false;

	// Constructor - Sets cookie
	public function __construct() {
		global $bboptions;

		Censor::$construct = true;

		if(empty($bboptions['censor']) OR empty($bboptions['censorChar'])) {
			Censor::$censor = false;
			return;
		}

		$words = preg_split('/\s+/s', $bboptions['censor']);
		Censor::$find = Array(); Censor::$replace = Array();

		foreach($words as $word) {
			Censor::$find[] = $word;
			Censor::$replace[] = str_repeat($bboptions['censorChar'], strlen($word));
		}
	}

	// Public static
	public static function c($text) {
		global $bboptions;

		$retval = $text;

		if(!Censor::$construct) {
			new Censor();
		}

		if(!Censor::$censor) {
			return $retval;
		}

		$retval = str_ireplace(Censor::$find, Censor::$replace, $retval);

		return $retval;
	}
}
