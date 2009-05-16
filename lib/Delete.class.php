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
## ****************** ADMIN DELETE ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class Delete {
	private $tName, $fName, $value, $goto, $type;
	
	// Constructor
	public function __construct($tblName, $fieldName, $v, $uri, $delete = true, $skip = false, $which = 'admin_delete') {
		$this->tName = $tblName;
		$this->fName = $fieldName;
		$this->value = $v;
		$this->goto = $uri;
		$this->type = $which;
		
		if($skip) {
			$this->doDel();
		}
		
		if($_POST AND $delete) {
			if($_POST['delConfirm']) {
				$this->doDel();
			}
			
			else {
				// don't forget to get rid of &amp;!
				if(!empty($this->goto)) {
					new Redirect(str_replace('&amp;', '&', $this->goto));
				}
			}
		}
		
		else if(!$_POST AND $delete AND !$skip) {		
			$this->doDelConfirm();
		}
	}
	
	// Private Methods
	private function doDel() {
		global $lang, $query;
		
		new Query($query['admin']['general_delete'], Array(
														1 => $this->tName,
														2 => $this->fName,
														3 => $this->value
													));
													
		if(!empty($this->goto)) {
			new WtcBBThanks($lang['admin_thanks_msg'], $this->goto);
		}
	}
	
	private function doDelConfirm() {
		global $lang;
		
		new AdminHTML('header', (!isset($lang[$this->type . '_areYouSure']) ? $lang['admin_delete_areYouSure'] : $lang[$this->type . '_areYouSure']), true);
		
		print("\t" . '<div class="box">' . "\n");
			print("\t\t" . '<h2>' . (!isset($lang[$this->type . '_areYouSure']) ? $lang['admin_delete_areYouSure'] : $lang[$this->type . '_areYouSure']) . '</h2>' . "\n");
			print("\t\t" . '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">' . "\n");
				print("\t\t\t" . '<input type="hidden" name="formSet" value="1" />' . "\n\n");
				
				if(isset($lang[$this->type . '_msg'])) {
					print('<p>' . $lang[$this->type . '_msg'] . '</p>');
				}
				
				print("\t\t\t" . '<div class="center">' . "\n");					
					print("\t\t\t\t" . '<label for="yes"><input type="radio" name="delConfirm" id="yes" value="1" checked="checked" /> ' . $lang['admin_yes'] . '</label>' . "\n");
					print("\t\t\t\t" . '<label for="no"><input type="radio" name="delConfirm" id="no" value="0" /> ' . $lang['admin_no'] . '</label>' . "\n");
					print("\t\t\t\t" . '<div class="marTop"><input type="submit" id="delButton" class="button" value="' . (!isset($lang[$this->type]) ? $lang['admin_delete'] : $lang[$this->type]) . '" /></div>' . "\n");
				print("\t\t\t" . '</div>' . "\n");
			print("\t\t" . '</form>' . "\n\n");
			
			print("\t\t" . '<script type="text/javascript">document.getElementById(\'delButton\').focus();</script>' . "\n");
		print("\t" . '</div>' . "\n\n");
		
		new AdminHTML('footer', '', true);
		exit;
	}
}
	

?>