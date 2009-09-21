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
## ****************** BOGUS FILE ******************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

/*
 * Call: 
 * $bogus = new Bogus('bogus');
 * $bogus->doBogus('not err');
 */
class Bogus {
	private $bogus;

	// Constructor
	public function __construct($bogus) {
		global $lang;

		$this->bogus = $bogus;
	}

	// bogus
	public function doBogus($bogus) {
		global $lang;

		$err = '';

		if('err' == $bogus)) {
			$err = new WtcBBException($lang['bogus_text'] . $this->bogus, false);
		}

		return $err;
	}

	// Private methods
	private function checkBogus() {
		global $lang;

		$valid = false;

		if(!$valid) {
			return new WtcBBException($lang['bogus_check'] . $this->bogus, false);
		}
	}
}

?>