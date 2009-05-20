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
 

$exts['1'] = new AttachmentExtension('', Array('storeid' => '1', 'ext' => 'jpg', 'mime' => 'image/jpeg
image/jpg
image/pjpeg', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['2'] = new AttachmentExtension('', Array('storeid' => '2', 'ext' => 'bmp', 'mime' => 'image/bmp
image/vnd.wap.wbmp', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['3'] = new AttachmentExtension('', Array('storeid' => '3', 'ext' => 'gif', 'mime' => 'image/gif', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['4'] = new AttachmentExtension('', Array('storeid' => '4', 'ext' => 'png', 'mime' => 'image/png
image/x-png', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['5'] = new AttachmentExtension('', Array('storeid' => '5', 'ext' => 'jpeg', 'mime' => 'image/jpeg', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['6'] = new AttachmentExtension('', Array('storeid' => '6', 'ext' => 'zip', 'mime' => 'application/zip
application/x-zip-compressed', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['7'] = new AttachmentExtension('', Array('storeid' => '7', 'ext' => 'rar', 'mime' => 'application/octet-stream', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['8'] = new AttachmentExtension('', Array('storeid' => '8', 'ext' => 'mov', 'mime' => 'video/quicktime', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['9'] = new AttachmentExtension('', Array('storeid' => '9', 'ext' => 'mpeg', 'mime' => 'video/mpeg', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['10'] = new AttachmentExtension('', Array('storeid' => '10', 'ext' => 'mp3', 'mime' => 'audio/mpeg', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['11'] = new AttachmentExtension('', Array('storeid' => '11', 'ext' => 'pdf', 'mime' => 'application/pdf', 'maxSize' => '5000000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['12'] = new AttachmentExtension('', Array('storeid' => '12', 'ext' => 'txt', 'mime' => 'text/plain', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));
$exts['13'] = new AttachmentExtension('', Array('storeid' => '13', 'ext' => 'swf', 'mime' => 'application/x-shockwave-flash', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['14'] = new AttachmentExtension('', Array('storeid' => '14', 'ext' => 'css', 'mime' => 'text/css', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['15'] = new AttachmentExtension('', Array('storeid' => '15', 'ext' => 'doc', 'mime' => 'application/msword', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['16'] = new AttachmentExtension('', Array('storeid' => '16', 'ext' => 'html', 'mime' => 'text/html', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['17'] = new AttachmentExtension('', Array('storeid' => '17', 'ext' => 'phps', 'mime' => 'application/x-httpd-php-source
application/octet-stream', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['18'] = new AttachmentExtension('', Array('storeid' => '18', 'ext' => 'php', 'mime' => 'application/x-httpd-php
application/octet-stream', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['19'] = new AttachmentExtension('', Array('storeid' => '19', 'ext' => 'xml', 'mime' => 'text/xml', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['20'] = new AttachmentExtension('', Array('storeid' => '20', 'ext' => 'ico', 'mime' => 'image/x-icon', 'maxSize' => '500000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '0'));
$exts['24'] = new AttachmentExtension('', Array('storeid' => '24', 'ext' => 'xls', 'mime' => 'application/vnd.ms-excel', 'maxSize' => '10000000', 'maxWidth' => '0', 'maxHeight' => '0', 'enabled' => '1'));

?>