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
## **************** ADMIN NAVIGATION **************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// Do CONSTANTS
define('AREA', 'ADMIN-NAVIGATION');

// require files
require_once('./includes/global_admin.php');

$header = new AdminHTML('header', $lang['admin_nav_title'], false, Array('showTitle' => false));
$header->setStylesheet('./css/adminNav.css');
// jQuery scrollbar
$extra = <<<EOB
<script type="text/javascript"> var adminNav = true; </script>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="scripts/jScrollPane.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="scripts/jScrollPane.css" />
	<script type="text/javascript">
	jQuery(function()
	{
		var busy = false;
		var jsc = function()
		{
			if (!busy) {
				busy = true;
//				var w = jQuery(window);
				var c = jQuery('#container');
//				var p = (parseInt(c.css('paddingLeft')) || 0) + (parseInt(c.css('paddingRight')) || 0);
//				jQuery('body>.jScrollPaneContainer').css({'height': w.height() + 'px', 'width': w.width() + 'px'});
//				c.css({'height': (w.height()-p) + 'px', 'width': (w.width() - p) + 'px', 'overflow':'auto'});
				c.jScrollPane();
				busy = false;	
			}
		}
//		jQuery(window).bind('resize', jsc);
//		jsc();
//		jsc();
	});
	jQuery(document).ready(function () {
		var w = jQuery(window);
		var c = jQuery('#container');
		if (typeof window.innerWidth != 'undefined') {
			var vh= window.innerHeight
		}
		else if (typeof document.documentElement != 'undefined'
			&& typeof document.documentElement.clientHeight != 'undefined') {
			var vh = document.documentElement.clientHeight
		}
		else {
			var vh = 0;
		}
		if(vh) {
			c.css({'height': vh + 'px', 'width': '220px', 'overflow':'auto'});
		}
		c.jScrollPane();
	});
	</script>

EOB;
$header->setExtra($extra);
$header->dump(); /* Prints HTML */

print("\t" . '<div id="links" class="small">' . "\n");
	print("\t\t" . '<div class="center"><a href="javascript:exCol.build(\'close\');">' . $lang['admin_nav_expandAll'] . '</a> - <a href="javascript:exCol.build();">' . $lang['admin_nav_collapseAll'] . '</a></div>' . "\n");
	print("\t\t" . '<div class="center"><a href="javascript:exCol.savePrefs();">' . $lang['admin_nav_savePrefs'] . '</a> - <a href="javascript:window.location = window.location;">' . $lang['admin_nav_restorePrefs'] . '</a></div>' . "\n");
print("\t" . '</div>' . "\n\n");

if($User->canAdmin('options')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_wtcBBOpt_title'],
								$lang['admin_nav_wtcBBOpt_allOpt'] => 'admin.php?file=options',
								$lang['admin_nav_wtcBBOpt_attachments'] => 'admin.php?file=options&amp;do=attachments',
								$lang['admin_nav_wtcBBOpt_boardAccess'] => 'admin.php?file=options&amp;do=boardAccess',
								$lang['admin_nav_wtcBBOpt_cookieSettings'] => 'admin.php?file=options&amp;do=cookieSettings',
								$lang['admin_nav_wtcBBOpt_dateTime'] => 'admin.php?file=options&amp;do=dateTime',
								$lang['admin_nav_wtcBBOpt_forumHome'] => 'admin.php?file=options&amp;do=forumHome',
								$lang['admin_nav_wtcBBOpt_forumSettings'] => 'admin.php?file=options&amp;do=forumSettings',
								$lang['admin_nav_wtcBBOpt_information'] => 'admin.php?file=options&amp;do=information',
								$lang['admin_nav_wtcBBOpt_message'] => 'admin.php?file=options&amp;do=message',
								$lang['admin_nav_wtcBBOpt_posting'] => 'admin.php?file=options&amp;do=posting',
								$lang['admin_nav_wtcBBOpt_robots'] => 'admin.php?file=options&amp;do=robots',
								$lang['admin_nav_wtcBBOpt_setup'] => 'admin.php?file=options&amp;do=setup',
								$lang['admin_nav_wtcBBOpt_threadSettings'] => 'admin.php?file=options&amp;do=threadSettings',
								$lang['admin_nav_wtcBBOpt_userOptions'] => 'admin.php?file=options&amp;do=userOptions'
							), true);
}

/*
 * CFR: insert the line below to the end of your navBox if you are a developer who needs
 * to reload the default style arbitrarily
 *								'Dev Import' => 'admin.php?file=style&amp;do=devimport',
 */
if($User->canAdmin('styles')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_style_title'],
								$lang['admin_nav_style_man'] => 'admin.php?file=style',
								$lang['admin_nav_style_add'] => 'admin.php?file=style&amp;do=add',
								$lang['admin_nav_style_addTemplate'] => 'admin.php?file=style&amp;do=addTemplate',
								$lang['admin_nav_style_addTemplateGroup'] => 'admin.php?file=style&amp;do=addGroup',
								$lang['admin_nav_style_searchTemplates'] => 'admin.php?file=style&amp;do=search',
								$lang['admin_nav_style_importStyle'] => 'admin.php?file=style&amp;do=import',
							), true);
}

if($User->canAdmin('forums')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_forums_title'],
								$lang['admin_nav_forums_add'] => 'admin.php?file=forum&amp;do=addForum',
								$lang['admin_nav_forums_manager'] => 'admin.php?file=forum',
								$lang['admin_nav_forums_perms'] => 'admin.php?file=forum&amp;do=perms',
								$lang['admin_nav_forums_block'] => 'admin.php?file=forum&amp;do=block',
								$lang['admin_nav_forums_addMod'] => 'admin.php?file=forum&amp;do=addMod',
								$lang['admin_nav_forums_showMods'] => 'admin.php?file=forum&amp;do=showMods'
							), true);
}

if($User->canAdmin('announcements')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_announce_title'],
								$lang['admin_nav_announce_add'] => 'admin.php?file=announce&amp;do=add',
								$lang['admin_nav_announce_manager'] => 'admin.php?file=announce'
							), true);
}

if($User->canAdmin('language')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_lang_title'],
								$lang['admin_nav_lang_langMan'] => 'admin.php?file=language',
								$lang['admin_nav_lang_im'] => 'admin.php?file=language&amp;do=im',
								$lang['admin_nav_lang_ex'] => 'admin.php?file=language&amp;do=ex',
								$lang['admin_nav_lang_searchWords'] => 'admin.php?file=language&amp;do=search',
								$lang['admin_nav_lang_addCat'] => 'admin.php?file=language&amp;do=addCat',
								$lang['admin_nav_lang_addWords'] => 'admin.php?file=language&amp;do=addWords',
								$lang['admin_nav_lang_addLang'] => 'admin.php?file=language&amp;do=addLang'
							), true);
}

if($User->canAdmin('users')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_users_title'],
								$lang['admin_nav_users_addUser'] => 'admin.php?file=user&amp;do=add',
								$lang['admin_nav_users_search'] => 'admin.php?file=user&amp;do=search',
								$lang['admin_nav_users_searchIp'] => 'admin.php?file=user&amp;do=searchIp',
								$lang['admin_nav_users_pruneMove'] => 'admin.php?file=user&amp;do=pruneMove',
								$lang['admin_nav_users_mergeUsers'] => 'admin.php?file=user&amp;do=merge',
								$lang['admin_nav_users_banUser'] => 'admin.php?file=user&amp;do=ban',
								$lang['admin_nav_users_viewBannedUsers'] => 'admin.php?file=user&amp;do=viewBanned',
								$lang['admin_nav_users_massEmail'] => 'admin.php?file=user&amp;do=search&amp;go=email'
							), true);
}

if($User->canAdmin('usergroups') OR $User->isSuperAdmin()) {
	if($User->isSuperAdmin() AND !$User->canAdmin('usergroups')) {
		new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_usergroups_title'],
								$lang['admin_nav_usergroups_adminPerms'] => 'admin.php?file=usergroup&amp;do=admins'
							), true);
	}

	else if(!$User->isSuperAdmin()) {
		new AdminHTML('navBox', Array(
									'main' => $lang['admin_nav_usergroups_title'],
									$lang['admin_nav_usergroups_addGroup'] => 'admin.php?file=usergroup&amp;do=add',
									$lang['admin_nav_usergroups_groupManager'] => 'admin.php?file=usergroup&amp;do=manager',
									$lang['admin_nav_usergroups_automation'] => 'admin.php?file=usergroup&amp;do=automation'
								), true);
	}

	else {
		new AdminHTML('navBox', Array(
									'main' => $lang['admin_nav_usergroups_title'],
									$lang['admin_nav_usergroups_addGroup'] => 'admin.php?file=usergroup&amp;do=add',
									$lang['admin_nav_usergroups_groupManager'] => 'admin.php?file=usergroup&amp;do=manager',
									$lang['admin_nav_usergroups_automation'] => 'admin.php?file=usergroup&amp;do=automation',
									$lang['admin_nav_usergroups_adminPerms'] => 'admin.php?file=usergroup&amp;do=admins'
								), true);
	}
}

if($User->canAdmin('threads_posts')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_threadsPosts_title'],
								$lang['admin_nav_threadsPosts_massMove'] => 'admin.php?file=threadsPosts',
								$lang['admin_nav_threadsPosts_massPruneThreads'] => 'admin.php?file=threadsPosts&amp;do=pruneThreads',
								$lang['admin_nav_threadsPosts_massPrunePosts'] => 'admin.php?file=threadsPosts&amp;do=prunePosts'
							), true);
}

if($User->canAdmin('bbcode')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_bbcode_title'],
								$lang['admin_nav_bbcode_manager'] => 'admin.php?file=bbcode',
								$lang['admin_nav_bbcode_add'] => 'admin.php?file=bbcode&amp;do=add',
								$lang['admin_nav_bbcode_parse'] => 'admin.php?file=bbcode&amp;do=parse'
							), true);
}

if($User->canAdmin('cron')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_cron_title'],
								$lang['admin_nav_cron_man'] => 'admin.php?file=cron',
								$lang['admin_nav_cron_add'] => 'admin.php?file=cron&amp;do=add'
							), true);
}

if($User->canAdmin('cus_pro')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_cusPro_title'],
								$lang['admin_nav_cusPro_man'] => 'admin.php?file=cusPro',
								$lang['admin_nav_cusPro_addCat'] => 'admin.php?file=cusPro&amp;do=addGroup',
								$lang['admin_nav_cusPro_add'] => 'admin.php?file=cusPro&amp;do=add'
							), true);
}

if($User->canAdmin('ranks')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_ranks_title'],
								$lang['admin_nav_ranks_man'] => 'admin.php?file=ranks',
								$lang['admin_nav_ranks_add'] => 'admin.php?file=ranks&amp;do=add'
							), true);
}

if($User->canAdmin('ranks_images')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_userImages_title'],
								$lang['admin_nav_userImages_man'] => 'admin.php?file=rankImages',
								$lang['admin_nav_userImages_add'] => 'admin.php?file=rankImages&amp;do=add'
							), true);
}

if($User->canAdmin('avatars')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_avatars_title'],
								$lang['admin_nav_avatars_man'] => 'admin.php?file=avatar',
								$lang['admin_nav_avatars_add'] => 'admin.php?file=avatar&amp;do=add',
								$lang['admin_nav_avatars_addMultiple'] => 'admin.php?file=avatar&amp;do=addMultiple',
								$lang['admin_nav_avatars_addGroup'] => 'admin.php?file=avatar&amp;do=addGroup'
							), true);
}

if($User->canAdmin('smilies')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_smilies_title'],
								$lang['admin_nav_smilies_man'] => 'admin.php?file=smilies',
								$lang['admin_nav_smilies_add'] => 'admin.php?file=smilies&amp;do=add',
								$lang['admin_nav_smilies_addMultiple'] => 'admin.php?file=smilies&amp;do=addMultiple',
								$lang['admin_nav_smilies_addGroup'] => 'admin.php?file=smilies&amp;do=addGroup'
							), true);
}

if($User->canAdmin('posticons')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_icons_title'],
								$lang['admin_nav_icons_man'] => 'admin.php?file=posticons',
								$lang['admin_nav_icons_add'] => 'admin.php?file=posticons&amp;do=add',
								$lang['admin_nav_icons_addMultiple'] => 'admin.php?file=posticons&amp;do=addMultiple'
							), true);
}

if($User->canAdmin('attachments')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_attach_title'],
								$lang['admin_nav_attach_man'] => 'admin.php?file=attachments',
								$lang['admin_nav_attach_add'] => 'admin.php?file=attachments&amp;do=add',
								$lang['admin_nav_attach_storageType'] => 'admin.php?file=attachments&amp;do=storageType'
							), true);
}

if($User->canAdmin('faq')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_faq_title'],
								$lang['admin_nav_faq_man'] => 'admin.php?file=faq',
								$lang['admin_nav_faq_add'] => 'admin.php?file=faq&amp;do=add'
							), true);
}

if($User->canAdmin('modules')) {
	new AdminHTML('navBox', Array(
								'main' => 'Modules',
								'Modules Manager' => 'admin.php?file=modules'
							), true);
}

if($User->canAdmin('maintenance')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_main_title'],
								$lang['admin_nav_main_cache'] => 'admin.php?file=maintenance&amp;do=cache',
								$lang['admin_nav_main_phpInfo'] => 'admin.php?file=maintenance&amp;do=phpinfo',
								$lang['admin_nav_main_query'] => 'admin.php?file=maintenance&amp;do=query',
								$lang['admin_nav_main_counters'] => 'admin.php?file=maintenance&amp;do=update'
							), true);
}

if($User->canAdmin('logAdmin') OR $User->canAdmin('logMod') OR $User->canAdmin('logCron') OR $User->canAdmin('pruneLogs')) {
	new AdminHTML('navBox', Array(
								'main' => $lang['admin_nav_logs_title'],
								$lang['admin_nav_logs_admin'] => 'admin.php?file=log&amp;do=admin',
								$lang['admin_nav_logs_mod'] => 'admin.php?file=log&amp;do=mod',
								$lang['admin_nav_logs_cron'] => 'admin.php?file=log&amp;do=cron'
							), true);
}


$footer = new AdminHTML('footer', '', true);

?>
