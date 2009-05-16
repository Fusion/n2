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
## ****************** OBJECT CLASS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Should be extended by anything that needs to be
// inserted, updated, or destroyed in a database...
// ie: user, usergroups, forum, avatar, smiley, etc...
abstract class Object {
	/**
	 * Deletes... nothing to put in here...
	 */
	abstract public function destroy();

	/**
	 * Updates object's data in database
	 */
	abstract public function update($arr);

	/**
	 * Gets info if ID is given
	 */
	protected function queryInfoById($get) {
		global $query, $lang, $wtcDB;

		if(!$wtcDB->numRows($get)) {
			return false;
		}

		return $wtcDB->fetchArray($get);
	}

	/**
	 * Inserts object data in database
	 */
	abstract public static function insert($arr);
}
