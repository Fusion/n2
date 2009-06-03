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
## ***************** INSTALLATION ******************* ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\

// An interesting test to ensure that we are not runing this guy directly.
// @todo Come up with better solution.
if(strpos(preg_replace('/.+\//i', '', $_SERVER['SCRIPT_NAME']), 'install') === false) {
	exit('Invalid Installer Script');
}

define('NOW', time());
define(SEO, false);

if(!isset($_GET['step'])) {
	$_GET['step'] = 1;
}

if($_GET['step'] > 1) {
	require_once('./includes/config.php');

	// CONSTANTS \\
	define('WTC_TP', $tablePrefix);
	define('WTC_COOKIE_PREFIX', $cookiePrefix);
	define('CWD', getcwd());
	define('DB_ENGINE', $dbType); unset($dbType);
	define('ADMIN_DIR', './admin');
	define('ADMIN', (strpos($_SERVER['PHP_SELF'], 'admin.php') !== false OR strpos($_SERVER['PHP_SELF'], 'install.php') !== false));
	define('ADAY', 60 * 60 * 24);
	define('AWEEK', ADAY * 7);
	define('AMONTH', ADAY * 31);
	define('AYEAR', ADAY * 365);
	define('FAQ_LANG_CAT', 119);
	define('DEV', false);

	getDBAClass();
	require_once('./sql/' . DB_ENGINE . '/sql.lib.php');

	$wtcDB = new WtcDBA($username, $password, $host);
	$wtcDB->selectDB($database);
}

// we need to check if
// the appropriate directories are readable/writable
$checkperms = Array(
	'./attach/', './cache/', './css/', './exports/', './language/', './images/', './includes/config.php',
	'./images/avatars/', './images/icons/', './images/ranks/', './images/smilies/'
);
$bad = '';

foreach($checkperms as $dir) {
	if(strpos(substr($dir, 1, strlen($dir)), '.') === false) {
		if(!($check = @fopen($dir . 'index2.html', 'w+'))) {
			$bad = $dir;
		}

		@unlink($dir . 'index2.html');
	}

	else {
		if(!is_writable($dir)) {
			$bad = $dir;
		}
	}
}

if(!empty($bad)) {
	$error = '<ul style="list-style-type: none; padding-left: 10px;">';
	foreach($checkperms as $dir) {
		$error .= '<li>' . (($dir == $bad) ? '<strong>' . $dir . '</strong>' : $dir) . '</li>';
	}
	$error .= '</ul>';

	new WtcBBException($lang['install_error_fileperms'] . $error);
}

if($_GET['step'] == 1) {
	$DBTYPES = Array(
		'MySQL' => 'MySQL',
		'MySQLi' => 'MySQLi'
	);

	if(!extension_loaded('mysql')) {
		unset($DBTYPES['MySQL']);
	}

	if(!extension_loaded('mysqli')) {
		unset($DBTYPES['MySQLi']);
	}

	if(!count($DBTYPES)) {
		new WtcBBException($lang['install_error_nodatabasing']);
	}

	// alright... time to write our config file...
	if($_POST['formSet']) {
		$conf = $_POST['config'];

		// try to connect to DB...
		require_once('./sql/' . $conf['dbtype'] . '/WtcDBA.class.php');

		$wtcDB = new WtcDBA($conf['username'], $conf['password'], $conf['host']);
		$wtcDB->selectDB($conf['dbname']);

		$config = '<?php' . "\n\n";
		$config .= '$username = \'' . $conf['username'] . '\';' . "\n\n";
		$config .= '$password = \'' . $conf['password'] . '\';' . "\n\n";
		$config .= '$host = \'' . $conf['host'] . '\';' . "\n\n";
		$config .= '$database = \'' . $conf['dbname'] . '\';' . "\n\n";
		$config .= '$tablePrefix = \'' . $conf['tblprefix'] . '\';' . "\n\n";
		$config .= '$cookiePrefix = \'' . $conf['cookprefix'] . '\';' . "\n\n";
		$config .= '$superAdministrators = \'1\';' . "\n\n";
		$config .= '$uneditableUsers = \'\';' . "\n\n";
		$config .= '$dbType = \'' . $conf['dbtype'] . '\';' . "\n\n";
		$config .= '?>';

		file_put_contents('./includes/config.php', $config);

		// make sure we have enough time...
		set_time_limit((60 * 15));

		// start loading in the SQL...
		$SQL = file_get_contents('./install/wtcbb2.sql');

		preg_match_all('/(CREATE TABLE `.+?` \(.+?\);)/is', $SQL, $tables, PREG_PATTERN_ORDER);
		preg_match_all('/(INSERT INTO .+?\);)/i', $SQL, $inserts, PREG_PATTERN_ORDER);

		foreach($tables[0] as $query) {
            $query = preg_replace('/CREATE TABLE `(.+?)`/is', 'CREATE TABLE `'.$conf['tblprefix'].'\\1`', $query);		
			$wtcDB->query($query);
		}

		foreach($inserts[0] as $query) {
            $query = preg_replace('/INSERT INTO `(.+?)`/is', 'INSERT INTO `'.$conf['tblprefix'].'\\1`', $query);		
			$wtcDB->query($query);
		}

		new Redirect('step=2');
	}

	new AdminHTML('header', $lang['install_step1'], true);

	new AdminHTML('tableBegin', $lang['install_step1'], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_dbtype'],
								'desc' => $lang['install_step1_dbtype_desc'],
								'type' => 'select',
								'name' => 'config[dbtype]',
								'select' => Array('fields' => $DBTYPES, 'select' => 'MySQLi')
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_username'],
								'desc' => $lang['install_step1_username_desc'],
								'type' => 'text',
								'name' => 'config[username]',
								'value' => 'root'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_password'],
								'desc' => $lang['install_step1_password_desc'],
								'type' => 'text',
								'name' => 'config[password]',
								'value' => ''
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_dbname'],
								'desc' => $lang['install_step1_dbname_desc'],
								'type' => 'text',
								'name' => 'config[dbname]',
								'value' => 'n2'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_host'],
								'desc' => $lang['install_step1_host_desc'],
								'type' => 'text',
								'name' => 'config[host]',
								'value' => 'localhost'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_tblprefix'],
								'desc' => $lang['install_step1_tblprefix_desc'],
								'type' => 'text',
								'name' => 'config[tblprefix]',
								'value' => 'n2_'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step1_cookprefix'],
								'desc' => $lang['install_step1_cookprefix_desc'],
								'type' => 'text',
								'name' => 'config[cookprefix]',
								'value' => 'n2_'
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

else if($_GET['step'] == 2) {
	if($_POST['formSet']) {
		Forum::init();

		$admin = $_POST['admin'];
		$insert = Array();

		// get password
		$passObj = new Password($admin['password']);
		$insert['password'] = $passObj->getHashedPassword();
		$insert['salt'] = $passObj->getSalt();
		$insert['passTime'] = NOW;
		$insert['username'] = $admin['username'];
		$insert['email'] = $admin['email'];
		$insert['timezone'] = $admin['timezone'];
		$insert['dst'] = $admin['dst'];
		//$insert['usertitle'] = User::getUserTitle(0, 0, '', 8);

		// start setting default values...
		$insert['joined'] = NOW;
		$insert['ip'] = $_SERVER['REMOTE_ADDR'];
		$insert['posts'] = 0;
		$insert['threads'] = 0;
		$insert['referrals'] = 0;
		$insert['styleid'] = 0;
		$insert['toolbar'] = 1;
		$insert['allowHtml'] = 0;
		$insert['banSig'] = 0;
		$insert['disSigs'] = 1;
		$insert['disImgs'] = 1;
		$insert['disAttach'] = 1;
		$insert['disAv'] = 1;
		$insert['disSmi'] = 1;
		$insert['emailContact'] = 1;
		$insert['adminEmails'] = 1;
		$insert['receivePm'] = 1;
		$insert['receivePmEmail'] = 1;
		$insert['receivePmAlert'] = 1;
		$insert['displayOrder'] = 'ASC';
		$insert['postsPerPage'] = 0;
		$insert['censor'] = 0;
		$insert['lang'] = -1;
		$insert['markedRead'] = NOW;
		$insert['lastvisit'] = NOW;
		$insert['lastactivity'] = NOW;
		$insert['usertitle_opt'] = 0;
		$insert['usergroupid'] = 8;

		User::insert($insert);

		new Query($query['admin']['options_update'], Array(
														1 => $insert['email'],
														2 => 19
													), 'unbuffered');

		new Redirect('step=3');
	}

	new AdminHTML('header', $lang['install_step2'], true);

	new AdminHTML('tableBegin', $lang['install_step2'], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step2_username'],
								'desc' => $lang['install_step2_username_desc'],
								'type' => 'text',
								'name' => 'admin[username]',
								'value' => 'admin'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step2_password'],
								'desc' => $lang['install_step2_password_desc'],
								'type' => 'text',
								'name' => 'admin[password]',
								'value' => ''
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['install_step2_email'],
								'desc' => $lang['install_step2_email_desc'],
								'type' => 'text',
								'name' => 'admin[email]',
								'value' => 'webmaster@' . str_replace('www.', '', $_SERVER['HTTP_HOST'])
							), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['install_step2_timezone'],
									'desc' => $lang['install_step2_timezone_desc'],
									'type' => 'select',
									'name' => 'admin[timezone]',
									'select' => Array('fields' => array_flip(WtcDate::buildTimeZones()), 'select' => '-5')
								), true);

	new AdminHTML('tableRow', Array(
									'title' => $lang['install_step2_dst'],
									'desc' => $lang['install_step2_dst_desc'],
									'type' => 'checkbox',
									'name' => 'admin[dst]',
									'value' => 1
								), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

else if($_GET['step'] == 3) {
	if($_POST['formSet']) {
		$setts = $_POST['setting'];

		foreach($setts as $setid => $val) {
			$t = new Query($query['admin']['options_update'], Array(
														1 => $val,
														2 => $setid
													), 'unbuffered');
		}

		// start finishing up... import style info...
		$xml = file_get_contents('./install/style_export_1.xml');

		$DOM = new DomDocument();
		$DOM->loadXML($xml);

		$fragments = $DOM->getElementsByTagName('fragment');

		foreach($fragments as $frag) {
			$template = $frag->getElementsByTagName('template');
			$templatePHP = $frag->getElementsByTagName('templatephp');

			foreach($template as $t) {
				$myFrag = $t->nodeValue;
				break;
			}

			foreach($templatePHP as $tp) {
				$myFragPHP = $tp->nodeValue;
				break;
			}

			$myFrag = str_replace("\n", "\r\n", $myFrag);

			StyleFragment::insert(Array(
				'fragmentid' => $frag->getAttribute('fragmentid'),
				'styleid' => $frag->getAttribute('styleid'),
				'groupid' => $frag->getAttribute('groupid'),
				'fragmentName' => $frag->getAttribute('fragmentName'),
				'fragmentVarName' => $frag->getAttribute('fragmentVarName'),
				'fragmentType' => $frag->getAttribute('fragmentType'),
				'defaultid' => $frag->getAttribute('defaultid'),
				'disOrder' => $frag->getAttribute('disOrder'),
				'fragment' => $myFrag,
				'template_php' => $myFragPHP
				), true
			);
		}

		$styles = $DOM->getElementsByTagName('style');

		foreach($styles as $style) {
			$css = $style->getElementsByTagName('css');

			foreach($css as $sheet) {
				$cssContent = $sheet->nodeValue;
				break;
			}

			Style::insert(Array(
				'styleid' => $style->getAttribute('styleid'),
				'parentid' => $style->getAttribute('parentid'),
				'name' => $style->getAttribute('name'),
				'disOrder' => $style->getAttribute('disOrder'),
				'selectable' => $style->getAttribute('selectable'),
				'enabled' => $style->getAttribute('enabled'),
				'fragmentids' => $style->getAttribute('fragmentids'),
				'css' => $cssContent
				), true
			);
		}

		// build the cache
		$dir = new DirectoryIterator('./lib/Cache');

		foreach($dir as $file) {
			if(!is_file($file->getPathname()) OR strpos($file->getPathname(), '.php') === false) {
				continue;
			}

			new Cache(substr($file->getFilename(), 0, strpos($file->getFilename(), '.')));
		}

		new Redirect('step=4');
	}

	new AdminHTML('header', $lang['install_step3'], true);

	new AdminHTML('tableBegin', $lang['install_step3'], true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_options_information_boardName'],
								'desc' => $lang['admin_options_information_boardName_desc'],
								'type' => 'text',
								'name' => 'setting[2]',
								'value' => 'n2'
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_options_cookieSettings_cookDomain'],
								'desc' => $lang['admin_options_cookieSettings_cookDomain_desc'],
								'type' => 'text',
								'name' => 'setting[16]',
								'value' => '.' . str_replace('www.', '', $_SERVER['HTTP_HOST'])
							), true);

	new AdminHTML('tableRow', Array(
								'title' => $lang['admin_options_cookieSettings_cookPath'],
								'desc' => $lang['admin_options_cookieSettings_cookPath_desc'],
								'type' => 'text',
								'name' => 'setting[17]',
								'value' => '/'
							), true);

	new AdminHTML('tableEnd', '', true);

	new AdminHTML('footer', '', true);
}

else if($_GET['step'] == 4) {
	if(@unlink('install.php'))
		$xtra = '';
	else
		$xtra = ' Please remove the <strong>install.php</strong> file from your root install for security precautions.';
	new WtcBBThanks('<em>n2</em> has successfully been installed!' . $xtra . '<span style="display: block; text-align: center; margin-top: 15px;"><a href="./admin.php">Administrator Control Panel</a> - <a href="./index.php">Forum Homepage</a></span>', false, false);
}

?>