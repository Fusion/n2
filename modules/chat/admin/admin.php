<?php
// CFR: Whole page's paths were adapted
        require_once('checkSession.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>SmileTAG - Administration Panel</title>
<meta http-equiv=content-type content="text/html; charset=utf-8">
<link href="modules/chat/admin/smiletag-admin.css" type=text/css rel=stylesheet>
<script type="text/javascript" language="JavaScript" src="modules/chat/admin/smiletag-admin.js"></script>
</head>

<body onLoad="MM_preloadImages('modules/chat/admin/images/messages.png','modules/chat/admin/images/moderation.png','modules/chat/admin/images/ban.png','modules/chat/admin/images/smilies.png','modules/chat/admin/images/badwords.png','modules/chat/admin/images/config.png')">
<br>
<div class=centermain align=center>
  <div class=main>
    <table border="0" cellpadding="0" cellspacing="0">
	<tr><td>
    <table class=adminheading>
      <tbody>
        <tr>
          <th class=cpanel><div align="center">SmileTAG/NBBS Administration Panel </div></th>
        </tr>
      </tbody>
    </table>
    <table class=adminform align="center" >
      <tbody>
        <tr>
          <!-- CFR: min-max to avoid wrap == ((110+(5+1)*2+(3*2))*6 == 768 px -->
          <td valign=top><div id=cpanel style="min-width:768px;">
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=messages"><img src="modules/chat/admin/images/messages.png" 
      alt="Messages" border=0 align=middle><span><b>Messages</b></span></a></div>
              </div>
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=moderation"><img src="modules/chat/admin/images/moderation.png" 
      alt="Awaiting Moderation"  
      border=0 align=middle> <span><b>Awaiting Moderation</b></span></a></div>
              </div>
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=ban"><img src="modules/chat/admin/images/ban.png" 
      alt="Ban List" name=""  
      border=0 align=middle><span><b>Ban List</b></span> </a></div>
              </div>
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=smilies"><img 
      alt="Smilies" src="modules/chat/admin/images/smilies.png" align=middle 
      border=0 name=""> <span><b>Smilies</b></span> </a></div>
              </div>
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=badwords"><img src="modules/chat/admin/images/badwords.png" 
      alt="Bad Words" 
      name=""  border=0 align=middle> <span><b>Bad Words</b></span> </a></div>
              </div>
              <div style="float: left">
                <div class=icon><a 
      href="index.php?act=admin&w=chat&show=configuration"><img 
      alt="Global Configuration" src="modules/chat/admin/images/config.png" align=middle 
      border=0 name=""> <span> <b>Configuration</b></span> </a></div>
              </div>
            </div></td>
        </tr>
      </tbody>
    </table>
	<br />
	<?php
		if(!empty($_SESSION['SMILETAG_MESSAGE'])){
	?>		<div align="center">
			<table width="50%" border="0" cellpadding="0" cellspacing="0" class="grid">
             <tr class="odd">
               <th valign="middle" nowrap scope="col"><img src="modules/chat/admin/images/info.png" align="absmiddle"><span class="infoText"><?php echo $_SESSION['SMILETAG_MESSAGE']; ?></span> </th>
             </tr>
           </table></div><br />
	<?php
           	$_SESSION['SMILETAG_MESSAGE'] = null;
		}
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		   <td align="center" valign="top">
		  	<?php
		  		$show = null;
		  		if(!empty($_GET['show'])){
		  		    $show = trim($_GET['show']);
		  		}
		  		
		  		if($show == 'messages'){ //show messages list
		  			require_once('showMessage.php');	
		  		}elseif($show == 'edit_message'){ //show edit message form
		  			require_once('showEditMessage.php');
		  		}elseif($show == 'moderation'){ //show messages moderation list
		  			require_once('showMessageModeration.php');
		  		}elseif($show == 'edit_message_moderation'){ //show edit message form in moderation list
		  			require_once('showEditMessageModeration.php');
		  		}elseif($show == 'ban'){ //show ban list
		  			require_once('showBan.php');
		  		}elseif($show == 'smilies'){ //show smilies list
		  			require_once('showSmilies.php');
		  		}elseif($show == 'badwords'){ //show badwords list
		  			require_once('showBadwords.php');
		  		}elseif($show == 'configuration'){ //show global configuration
		  			require_once('showConfiguration.php');
		  		}
		  	?>	
		   </td>
		</tr>
	</table>
	</td></tr>
   </table>
  </div>
</div>

</body>
</html>
