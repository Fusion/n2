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
## *************** ATTACHMENT CLASS ***************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Attachment extends Object {
	private $attachid, $info;

	// Constructor
	public function __construct($id = '', $attachinfo = '') {
		global $lang;

		if(!empty($attachinfo) AND is_array($attachinfo)) {
			$this->info = $attachinfo;
			$this->attachid = $this->info['attachid'];
		}

		else if(!empty($id)) {
			$this->attachid = $id;
			$this->queryInfoById();
		}

		else {
			new WtcBBException($lang['error_noInfo']);
		}
	}


	// Public Methods
	// Deletes...
	public function destroy() {
		global $query, $lang;

		new Delete('attachments', 'attachid', $this->attachid, '', true, true);

		// now delete from file system
		@unlink($this->getPathName());

		if(file_exists($this->getThumbPath())) {
			@unlink($this->getThumbPath());
		}
	}

	// Updates attachment... Accepts an array of fields and values
	public function update($arr) {
		global $query, $wtcDB, $lang;

		$update = $wtcDB->massUpdate($arr);

		// Execute!
		new Query($query['attachments']['update'], Array(1 => $update, 2 => $this->attachid), 'query', false);
	}

	// Accessors
	public function getAttachId() {
		return $this->info['attachid'];
	}

	public function getPathName() {
		return $this->info['pathName'];
	}

	public function getFileName() {
		global $bboptions;

		return wtcspecialchars(censor($this->info['fileName']));
	}

	public function getThumbPath() {
		return $this->info['thumbFileName'];
	}

	public function getHash() {
		return $this->info['hash'];
	}

	public function getDownloads() {
		return $this->info['downloads'];
	}

	public function getMimeType() {
		return $this->info['mime'];
	}

	public function getFileSize() {
		return $this->info['fileSize'];
	}

	public function isImage() {
		return $this->info['image'];
	}

	// tests for jpg, png, or gif
	// uses attach extensions
	public function isGoodImage() {
		// reliable test
		if(!($imgInfo = @getimagesize($this->getPathName()))) {
			return false;
		}

		// 1 = GIF, 2 = JPG, 3 = PNG
		$corrs = Array(1 => 'gif', 2 => 'jpg', 3 => 'png');

		if($imgInfo[2] > 3) {
			return false;
		}

		// good to go!
		return $corrs[$imgInfo[2]];
	}

	public function getUserId() {
		return $this->info['userid'];
	}

	public function getForumId() {
		return $this->info['forumid'];
	}

	public function getThreadId() {
		return $this->info['threadid'];
	}

	public function getPostId() {
		return $this->info['postid'];
	}

	public function getConvoId() {
		return $this->info['convoid'];
	}

	public function getMessageId() {
		return $this->info['messageid'];
	}

	// generates thumbnail...
	// this handles everything... from updating DB to checking if GD (and proper version) is enabled
	public function doThumbNail() {
		// do the actual generation
		if(!($thumbName = $this->generateThumbNail())) {
			return false;
		}

		// update DB...
		$this->update(Array('thumbFileName' => $thumbName));

		return true;
	}


	// Protected Methods
	// gets info if ID is given
	protected function queryInfoById() {
		global $query, $lang, $wtcDB;

		$get = new Query($query['attachments']['get'], Array(1 => $this->attachid));

		$this->info = parent::queryInfoById($get);
	}


	// Private Methods
	// generates the actual thumbnail
	private function generateThumbNail() {
		global $bboptions;

		// get the image resource
		if(!($curImage = $this->createImageResource())) {
			return false;
		}

		// get the current dimensions
		if(!($imgInfo = @getimagesize($this->getPathName()))) {
			return false;
		}

		$curWidth = $imgInfo[0];
		$curHeight = $imgInfo[1];
		$newWidth = 0;
		$newHeight = 0;

		// now figure out the new dimensions...
		// make sure we are over anyway
		if($curWidth > $bboptions['thumbWidth'] OR $curHeight > $bboptions['thumbHeight']) {
			// use the width ratio for the height...
			if($curWidth > $curHeight) {
				$newWidth = $bboptions['thumbWidth'];
				$newHeight = floor(($newWidth / $curWidth) * $curHeight);
			}

			// use the height ratio for the width...
			else {
				$newHeight = $bboptions['thumbHeight'];
				$newWidth = floor(($newHeight / $curHeight) * $curWidth);
			}
		}

		// no need to resize... already small
		else {
			$newWidth = $curWidth;
			$newHeight = $curHeight;
		}

		// now do the image creation
		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImage, $curImage, 0, 0, 0, 0, $newWidth, $newHeight, $curWidth, $curHeight);

		// form the new attachment name...
		$thumbName = preg_replace('/\.attach$/i', '.thumb', $this->getPathName());

		// we want jpeg!
		if(!@imagejpeg($newImage, $thumbName)) {
			return false;
		}

		// we're good!
		return $thumbName;
	}

	// creates an image resource
	private function createImageResource() {
		if(!($imageType = $this->isGoodImage())) {
			return false;
		}

		// which function to use?
		switch($imageType) {
			case 'gif':
				return imagecreatefromgif($this->getPathName());
			break;

			case 'jpg':
				return imagecreatefromjpeg($this->getPathName());
			break;

			case 'png':
				return imagecreatefrompng($this->getPathName());
			break;
		}

		// not good...
		return false;
	}

	// Static Methods
	// Public
	// inserts attachment... key is database field, value is database value in array
	public static function insert($arr) {
		global $wtcDB, $query;

		$db = $wtcDB->massInsert($arr);

		new Query($query['attachments']['insert'], Array(1 => $db['fields'], 2 => $db['values']), 'query', false);

		return $wtcDB->lastInsertId();
	}
}

?>