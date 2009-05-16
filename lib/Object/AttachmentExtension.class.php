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
## ********** ATTACHMENT EXTENSION CLASS ************ ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class AttachmentExtension extends Object {
	public $info;
	private $storeid, $ext, $mime, $mimeArray;

	// Constructor
	public function __construct($id = '', $extinfo = '') {
		if(!empty($extinfo) AND is_array($extinfo)) {
			$this->info = $extinfo;
			$this->storeid = $this->info['storeid'];
		}

		else if(!empty($id)) {
			$this->storeid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}

		// asign extension and mime type
		$this->ext = $this->info['ext'];
		$this->mime = $this->info['mime'];
		$this->formMimeArray();
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('attach_store', 'storeid', $this->storeid, '');

		new Cache('AttachmentExtensions');

		new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=attachments');
	}

	// Updates attachment extension... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['ext']['update'], Array(1 => $update, 2 => $this->storeid), 'query', false);

		new Cache('AttachmentExtensions');
	}

	// Accessors
	public function getStoreid() {
		return $this->storeid;
	}

	public function getExt() {
		return $this->ext;
	}

	public function getWholeMime() {
		return $this->mime;
	}

	public function maxSize() {
		return $this->info['maxSize'];
	}

	public function maxHeight() {
		return $this->info['maxHeight'];
	}

	public function maxWidth() {
		return $this->info['maxWidth'];
	}

	public function isAllowed() {
		return (($this->info['enabled']) ? true : false);
	}

	public function getMimes() {
		return $this->mimeArray;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$getExt = new Query($query['ext']['get'], Array(1 => $this->storeid));

		$this->info = parent::queryInfoById($getExt);
	}


	// Private Methods
	// creates array of mimes
	private function formMimeArray() {
		// separate by carriage returns...
		$this->mimeArray = preg_split('/(\r|\n|\r\n)/', $this->mime, -1, PREG_SPLIT_NO_EMPTY);
	}


	// Static Methods
	// Public
	// inserts attachment extension... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['ext']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		new Cache('AttachmentExtensions');
	}

	// initializes extensions
	public static function init() {
		global $query, $wtcDB, $exts, $_CACHE;

		if(!($exts = Cache::load('exts'))) {
			$getExts = new Query($query['ext']['get_all']);
			$exts = Array();

			while($ext = $getExts->fetchArray()) {
				$exts[$ext['storeid']] = new AttachmentExtension('', $ext);
			}
		}
	}
}

?>