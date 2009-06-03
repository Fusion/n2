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
## ********************* GLOBAL ********************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


/**
 * Initialize User
 */
$User = NULL;
$LOGIN = true;

if(Cookie::get('password') AND Cookie::get('userid')) {
	$User = new User(Cookie::get('userid'), '', false, true);

	if(!$User->validateSession(Cookie::get('password'))) {
		$User = NULL;
	}
}

// what if no cookies, but we have a session id?
else if(!$bboptions['cookLogin'] AND !Cookie::get('password') AND !Cookie::get('userid') AND !empty($_REQUEST['session'])) {
	// attempt to get user from sessions table...
	$getUser = new Query($query['sessions']['get'], Array(1 => $_REQUEST['session']));

	if($wtcDB->numRows($getUser)) {
		$User = new User('', '', $wtcDB->fetchArray($getUser), true);
	}
}

// bad user...
if($User == NULL) {
	$guestinfo = Array(
		'userid' => 0,
		'username' => 'Guest',
		'usergroupid' => 1,
		'timezone' => -5,
		'dst' => $bboptions['dst'],
		'lang' => -1,
		'styleid' => 0
	);

	$User = new User('', '', $guestinfo);
	$LOGIN = false;
}

// define it
define('LOGIN', $LOGIN);


/**
 * Get Language File
 */
define('LANG', (($User->info['lang'] == -1 OR !LOGIN) ? $bboptions['defLang'] : $User->info['lang']));
require_once('./language/' . $langs[LANG]->getFileName() . '.php');
//$lang = array_map(Array(&$wtcDB, 'doEscaping'), $lang);


/**
 * We should reset some values in bboptions
 * based on user options & environment
 */
$bboptions['readTimeout'] = NOW - ($bboptions['readTimeout'] * 86400);
$bboptions['postsPerPage'] = (($User->info['postsPerPage'] > 0) ? $User->info['postsPerPage'] : $bboptions['postsPerPage']);


/**
 * Initialize Style Info
 */
if(!$User->info['styleid']) {
	$STYLEID = $bboptions['defStyle'];
}

else {
	$STYLEID = $User->info['styleid'];

	if(!isset($styles[$STYLEID])) {
		$STYLEID = $bboptions['defStyle'];
	}
}

$STYLE = new Style('', $styles[$STYLEID]->getInfo());


/**
 * Initialize Visual Settings
 */
$VISUALS = Array(
				'borderStyle' => '',
				'borderWidth' => '',
				'borderColor' => '',
				'inBorderWidth' => '',
				'inBorderColor' => '',
				'docType' => '',
				'images' => '',
				'innerWidth' => '',
				'padding' => '',
				'pageWidth' => '',
				'titleImage' => ''
			);

foreach($VISUALS as $var => $meh) {
	$temp = new StyleFragment($var, 'option');
	$VISUALS[$var] = $temp->dump();
	if('images' == $var)
		$VISUALS[$var] = str_replace('./', HOME, $VISUALS[$var]);
}

// throw together all border styles...
// writing them all out is a pain in the but...
$VISUALS['border'] = $VISUALS['borderWidth'] . ' ' . $VISUALS['borderStyle'] . ' ' . $VISUALS['borderColor'];
$VISUALS['inBorder'] = $VISUALS['inBorderWidth'] . ' solid ' . $VISUALS['inBorderColor'];

// we need a margin-left for the message area in the postbit
// as we need to double the padding and add to 150 (probably should make this a visual setting)
$VISUALS['postbitLeft'] = 150 + ($VISUALS['padding'] * 2);
$VISUALS['postbitLeftHalf'] = ceil($VISUALS['postbitLeft'] / 2);
$VISUALS['indexLeft'] = 50 + ($VISUALS['padding'] * 2) + ($VISUALS['inBorderWidth']);


/**
 * Initialize Style Image Paths
 */
$IMAGES = Array(
			'expand' => '',
			'collapse' => '',
			'postthread' => '',
			'postreply' => '',
			'postbit_edit' => '',
			'postbit_reply' => '',
			'indicatorOn' => '',
			'indicatorOff' => '',
			'indicatorPrivate' => '',
			'lastPost' => '',
			'newestPost' => '',
			'stats' => '',
			'whosOnline' => '',
			'upIcon' => '',
			'aimIcon' => '',
			'msnIcon' => '',
			'yahooIcon' => '',
			'icqIcon' => '',
			'profileIcon' => '',
			'postbit_pm' => '',
			'online' => '',
			'offline' => '',
			'postbit_quoteP' => '',
			'postbit_quoteM' => '',
			'closed' => '',
			'postbit_quickReply' => '',
			'postbit_www' => '',
			'postbit_report' => '',
			'navIcon' => '',
			'threadPre_sticky' => '',
			'threadPre_closed' => '',
			'threadPre_moved' => '',
			'threadPre_poll' => '',
			'postbit_dPlus' => '',
			'postbit_dMinus' => '',
			'postbit_delIcon' => '',
			'subscribed' => '',
			'postbit_email' => '',
			'folderReg' => '',
			'folderRegDot' => '',
			'folderHot' => '',
			'folderHotDot' => '',
			'announceIcon' => '',
			'homeIcon' => '',
			'closeAll' => '',
			'attachIcon' => '',
			'threadPre_attach' => ''
		);

foreach($IMAGES as $var => $meh) {
	$temp = new StyleFragment($var, 'imageName');
	$IMAGES[$var] = $temp->dump();
}


/**
 * Initialize global stylesheet
 */
$stylesheet = new StyleFragment('stylesheet_global');
$stylesheetName = './css/' . $stylesheet->getFragmentId() . '_' . preg_replace('/\s+/', '-', $stylesheet->getVarName()) . '.css';

if(!file_exists($stylesheetName)) {
	file_put_contents($stylesheetName, $stylesheet->dump());
}


/**
 * Do lastactivity and lastvisit
 * check for new PMs too while we're at it
 */
$hasNew = false;
$hasAlert = false;

if(LOGIN) {
	// we need to change the last visit...
	if($User->info['lastactivity'] < (NOW - $bboptions['cookTimeout'])) {
		$User->update(Array('lastvisit' => $User->info['lastactivity'], 'lastactivity' => NOW));
		$User->info['lastvisit'] = $User->info['lastactivity'];
	}

	// just last activity
	else {
		$User->update(Array('lastactivity' => NOW));
	}

	$User->info['lastactivity'] = NOW;

	if($User->info['receivePm']) {
		$find = new Query($query['personal_convo']['get_new'], Array(1 => $User->info['userid']));

		if($find->numRows()) {
			$hasNew = true;
		}

		// alerts?
		while($data = $find->fetchArray()) {
			if(!$data['hasAlert']) {
				$hasAlert = true;
				new Query($query['personal_convodata']['update_alert'], Array(1 => $User->info['userid']));
			}
		}
	}

	// get the last visit while we're at it
	$globalLastVisit = new WtcDate('dateTime', $User->info['lastvisit']);
}

if($hasNew) {
	define('PMS', true);
}

else {
	define('PMS', false);
}

if($hasAlert) {
	define('PMS_ALERT', true);
}

else {
	define('PMS_ALERT', false);
}

/**
 * Build the Forum Jump
 */
if($bboptions['forumJump']) {
	$forumJumpBits = Forum::buildForumJump();
}

else {
	$forumJumpBits = '';
}


/**
 * Set some variables... save some typing
 */
$selected = ' selected="selected"';
$checked = ' checked="checked"';
$attachBits = '';

?>