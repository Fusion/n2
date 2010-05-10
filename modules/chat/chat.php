<?php
/*
Plugin Name: Chat
Plugin URI: http://n2.nextbbs.com
Description: Chat module
Version: 1.0
Author: Chris F. Ravenscroft
Author URI: http://nexus.zteo.com
N2Type: L
*/

function chat_code() {
	global $n2chat, $User;
	$home = HOME;
	$n2url = URL;
	$n2url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php?';

	if($User->isGuest()) {
		$ncform = '';
	}
	else {
		$ncform = <<<EOB
	<tr>
		<td id="ys-stf">
			<form name="smiletagform" method="post" action="{$home}index.php?oob=chat&do=post&session={$_REQUEST['session']}" target="iframetag">
			<span>Message&nbsp;</span>
			<input type="text" id="ys-input-message" name="message_box" />&nbsp;
			<input type="hidden" name="message" value="" />
			<input type="submit" name="submit" value="Send" onclick="clearMessage()" />
			</form>
		</td>
	</tr>
EOB;
	}

	$n2chat = <<<EOB
<link rel="stylesheet" href="{$home}modules/chat/yshout.css" type="text/css" />
<script type="text/javascript" language="JavaScript">
	var smiletagURL = '{$n2url}oob=chat&do=';
</script>
<script type="text/javascript" language="JavaScript" src="{$home}modules/chat/smiletag-script.js"></script>
<table border="0" cellpadding="0" cellspacing="0" id="yshout">
	<tr>
		<td valign="top">
			<iframe name="iframetag" marginwidth="0" marginheight="0" src="{$home}index.php?oob=chat&do=view&session={$_REQUEST['session']}" style="width:100%; height:96px;">
			Your Browser must support IFRAME to view the Chat!
			</iframe>
		</td>
	</tr>
{$ncform}
</table>
EOB;
}

function chat_oob() {
	global $User;

	if($_GET['oob'] != 'chat') {
		return;
	}
	switch($_GET['do']) {
		case 'view':
			chdir('modules/chat');
			require_once('lib/domit/xml_domit_lite_include.php');
			require_once('lib/St_XmlParser.class.php');
			require_once('lib/St_ConfigManager.class.php');
			require_once('lib/St_FileDao.class.php');
			require_once('lib/St_PersistenceManager.class.php');
			require_once('lib/St_TemplateParser.class.php');
			require_once('lib/St_ViewManager.class.php');
			$viewManager =& new St_ViewManager();
			$viewManager->display();
			break;
		case 'post':
			if($User->isGuest()) {
				die("Error posting. Damn.");
			}
			// @todo Check if user is allowed to post
			chdir('modules/chat');
			session_start();	// @todo Maybe not???
			require_once('lib/domit/xml_domit_lite_include.php');
			require_once('lib/St_XmlParser.class.php');	
			require_once('lib/St_ConfigManager.class.php');
			require_once('lib/St_FileDao.class.php');
			require_once('lib/St_PersistenceManager.class.php');
			require_once('lib/St_RuleProcessor.class.php');
			require_once('lib/St_InputProcessor.class.php');
			require_once('lib/St_PostManager.class.php');
			$HttpRequest['name'] = $USER->name; // @todo
			$HttpRequest['url'] =  '';
			$HttpRequest['message'] = trim($_POST['message']);
			$postManager =& new St_PostManager();
			$errorMessage = null;
			if(empty($HttpRequest['message'])){ // CFR
				$errorMessage = null; // CFR
			}else{
				if($postManager->doPost($HttpRequest) === false){
					$errorMessage = $postManager->getErrorMessage();
				}
			}
			if(empty($errorMessage)){
				header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php?oob=chat&do=view&session='.$_REQUEST['session']);
			}else{
				echo '<center>';
				echo $errorMessage;
				echo '<br/><br/><a href="'.$home.'index.php?oob=chat&do=view&session='.$_REQUEST['session'].'">[Back]</a></center>';
			}
			break;
		case 'backend':
			require_once('lib/domit/xml_domit_lite_include.php');
			require_once('lib/St_XmlParser.class.php');	
			require_once('lib/St_ConfigManager.class.php');
			require_once('lib/St_FileDao.class.php');
			require_once('lib/St_PersistenceManager.class.php');
			session_start(); // @todo Maybe not?
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");		        // expires in the past
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");     // Last modified, right now
			header("Cache-Control: no-cache, must-revalidate");	        // Prevent caching, HTTP/1.1
			header("Pragma: no-cache");
			//query the latest message timestamp from persistence
			//compare it with the last timestamp in the session
			//if there is no session,then create it
			//if the timestamp is different, then send 1
			//so the iframe should reload
			//load data from persistence object
			$configManager		=& new St_ConfigManager();
			$persistenceManager =& new St_PersistenceManager();
			$storageType 		=  $configManager->getStorageType();
			if(strtolower($storageType) == 'file'){
				$fileName = $configManager->getDataDir().'/'.$configManager->getMessageFileName();
				$persistenceManager->setStorageType('file');
				$persistenceManager->setMessageFile($fileName);
			}elseif(strtolower($storageType) == 'mysql'){
				die("MySQL storage type, not implemented yet!");
			}else{
				die("Unknown storage type!");
			}
			$latestTimeStamp = $persistenceManager->getLatestTimestamp();
			if(empty($_SESSION['timestamp'])){
				$_SESSION['timestamp'] = $latestTimeStamp;
			}
			if($_SESSION['timestamp'] != $latestTimeStamp){
				$_SESSION['timestamp'] = $latestTimeStamp;
				echo '1'; //new message exist
			}else{
				echo '0';
			}
			break;
	}
	exit;
}

add_action('wp_head', 'chat_code');
add_action('n2_oob', 'chat_oob');
?>
