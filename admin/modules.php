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
## ***************#* wtcBB MODULES******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-MODULES');
define('FILE_ACTION', 'n2 Modules');

// require files
require_once('./includes/global_admin.php');

// log action
new LogAdmin();

// some action
if(isset($_GET['do'])) {
	$moduleObj = new Module($_GET['type'], $_GET['name']);
	switch($_GET['do']) {
		case 'enable':
			$disable_autoload = true;
			$moduleObj->update(array('enabled' => 1));
			require SCRIPT_HOME . $moduleObj->getPath();
			$moduleName = str_replace('modules/', 'activate_', $moduleObj->getPath());
			do_action($moduleName);
			unset($disable_autoload);
			break;
		case 'disable':
			$disable_autoload = true;
			$moduleObj->update(array('enabled' => 0));
			require SCRIPT_HOME . $moduleObj->getPath();
			$moduleName = str_replace('modules/', 'deactivate_', $moduleObj->getPath());
			do_action($moduleName);
			unset($disable_autoload);
			break;
		case 'makedefault':
			Module::updateAll('type', $_GET['type'], array('`default`' => 0));
			$moduleObj->update(array('`default`' => 1));
			break;
	}
	new WtcBBThanks($lang['admin_thanks_msg'], 'admin.php?file=modules');	
}

// cron manager
else {
	$typeStrs = array('E' => 'Editors', 'L' => 'Libraries', 'W' => 'Wordpress');
	
	new AdminHTML('header', 'Boom its the modules!', true);
	
	// First, find all modules on disk and which ones are enabled
	$modules = Module::getModules();
	
	foreach($modules as $type => $info) {
		$cols = $type == 'W' ? 3 : 4;
		new AdminHTML('tableBegin', $typeStrs[$type], true, Array('form' => 0, 'colspan' => $cols));

		if($cols == 4) {
			$cells = array(
						'name' => Array('th' => true, 'class' => 'small'),
						'descriptiom' => Array('th' => true, 'class' => 'small'),
						'&nbsp;' => Array('th' => true, 'class' => 'small'),
						'&nbsp;&nbsp;' => Array('th' => true, 'class' => 'small')
					);
		}
		else {
			$cells = array(
						'name' => Array('th' => true, 'class' => 'small'),
						'descriptiom' => Array('th' => true, 'class' => 'small'),
						'&nbsp;&nbsp;' => Array('th' => true, 'class' => 'small')
					);		
		}
		new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		
		foreach($info as $name => $module) {
			if($module['enabled']) {
				if($name == 'plainEdit') {
					// If we disable plainEdit we may end up shooting ourself in the foot and not have ANY editor left...
					$enabledStr = '';
				}
				else {
					$enabledStr = '<a href="admin.php?file=modules&amp;do=disable&type=' . $module['n2type'] . '&name=' . $module['name'] . '">' . 'disable' . '</a>';
				}
			}
			else {
				$enabledStr = '<a href="admin.php?file=modules&amp;do=enable&type=' . $module['n2type'] . '&name=' . $module['name'] . '">' . 'enable' . '</a>';			
			}
			$defaultStr = '&nbsp;';
			if($cols == 4) {
				if(!$module['default']) {
					$defaultStr = '<a href="admin.php?file=modules&amp;do=makedefault&type=' . $module['n2type'] . '&name=' . $module['name'] . '">' . 'default' . '</a>';
				}
				$cells = array(
						'<strong>' . $name . '</strong>' => array(),
						$module['description'] => array(),
						$defaultStr => array(),
						$enabledStr => array()
					);
			}
			else {
				$cells = array(
						'<strong>' . $name . '</strong>' => array(),
						$module['description'] => array(),
						$enabledStr => array()
					);
			}
			
			new AdminHTML('tableCells', '', true, Array('cells' => $cells));
		}
		
		new AdminHTML('tableEnd', '', true, Array('form' => 0, 'colspan' => $cols));
	}
	
	new AdminHTML('footer', '', true);	
}


?>