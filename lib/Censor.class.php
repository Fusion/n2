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
