-- 
-- Table structure for table `admins`
-- 

CREATE TABLE `admins` (
  `adminid` int(11) unsigned NOT NULL auto_increment,
  `userid` varchar(255) default NULL,
  `options` tinyint(1) default NULL,
  `language` tinyint(1) default NULL,
  `users` tinyint(1) default NULL,
  `usergroups` tinyint(1) default NULL,
  `cron` tinyint(1) default NULL,
  `forums` tinyint(1) default NULL,
  `announcements` tinyint(1) default NULL,
  `logAdmin` tinyint(1) default NULL,
  `logMod` tinyint(1) default NULL,
  `logCron` tinyint(1) default NULL,
  `pruneLogs` tinyint(1) default NULL,
  `ranks` tinyint(1) default NULL,
  `attachments` tinyint(1) default NULL,
  `faq` tinyint(1) default NULL,
  `ranks_images` tinyint(1) default NULL,
  `smilies` tinyint(1) default NULL,
  `posticons` tinyint(1) default NULL,
  `avatars` tinyint(1) default NULL,
  `maintenance` tinyint(1) default NULL,
  `modules` tinyint(1) default NULL,
  `styles` tinyint(1) default NULL,
  `bbcode` tinyint(1) default NULL,
  `threads_posts` tinyint(1) default NULL,
  `cus_pro` tinyint(1) default NULL,
  PRIMARY KEY  (`adminid`),
  KEY `userid` (`userid`)
);

-- 
-- Dumping data for table `admins`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `announcements`
-- 

CREATE TABLE `announcements` (
  `announceid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `forumid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `dateUpdated` int(11) default NULL,
  `dateStart` int(11) default NULL,
  `dateEnd` int(11) default NULL,
  `message` mediumtext,
  `parseBBCode` tinyint(1) default NULL,
  `parseSmilies` tinyint(1) default NULL,
  `parseHtml` tinyint(1) default NULL,
  `views` int(11) default NULL,
  `inherit` tinyint(1) default NULL,
  PRIMARY KEY  (`announceid`),
  KEY `userid` (`userid`),
  KEY `forumid` (`forumid`),
  KEY `dateUpdated` (`dateUpdated`)
);

-- 
-- Dumping data for table `announcements`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `attach_store`
-- 

CREATE TABLE `attach_store` (
  `storeid` int(11) unsigned NOT NULL auto_increment,
  `ext` varchar(255) default NULL,
  `mime` varchar(255) default NULL,
  `maxSize` int(11) default NULL,
  `maxWidth` int(11) default NULL,
  `maxHeight` int(11) default NULL,
  `enabled` tinyint(1) default NULL,
  PRIMARY KEY  (`storeid`),
  KEY `enabled` (`enabled`)
);

-- 
-- Dumping data for table `attach_store`
-- 

INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (1, 'jpg', 'image/jpeg\r\nimage/jpg\r\nimage/pjpeg', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (2, 'bmp', 'image/bmp\r\nimage/vnd.wap.wbmp', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (3, 'gif', 'image/gif', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (4, 'png', 'image/png\r\nimage/x-png', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (5, 'jpeg', 'image/jpeg', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (6, 'zip', 'application/zip\r\napplication/x-zip-compressed', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (7, 'rar', 'application/octet-stream', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (8, 'mov', 'video/quicktime', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (9, 'mpeg', 'video/mpeg', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (10, 'mp3', 'audio/mpeg', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (11, 'pdf', 'application/pdf', 5000000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (12, 'txt', 'text/plain', 500000, 0, 0, 1);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (13, 'swf', 'application/x-shockwave-flash', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (14, 'css', 'text/css', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (15, 'doc', 'application/msword', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (16, 'html', 'text/html', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (17, 'phps', 'application/x-httpd-php-source\r\napplication/octet-stream', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (18, 'php', 'application/x-httpd-php\r\napplication/octet-stream', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (19, 'xml', 'text/xml', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (20, 'ico', 'image/x-icon', 500000, 0, 0, 0);
INSERT INTO `attach_store` (`storeid`, `ext`, `mime`, `maxSize`, `maxWidth`, `maxHeight`, `enabled`) VALUES (24, 'xls', 'application/vnd.ms-excel', 10000000, 0, 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `attachments`
-- 

CREATE TABLE `attachments` (
  `attachid` int(11) unsigned NOT NULL auto_increment,
  `pathName` varchar(255) default NULL,
  `fileName` varchar(255) default NULL,
  `hash` varchar(32) default NULL,
  `mime` varchar(255) default NULL,
  `fileSize` int(11) default NULL,
  `image` tinyint(1) default NULL,
  `userid` int(11) unsigned NOT NULL default '0',
  `forumid` int(11) unsigned NOT NULL default '0',
  `threadid` int(11) unsigned NOT NULL default '0',
  `postid` int(11) unsigned NOT NULL default '0',
  `thumbFileName` varchar(255) default NULL,
  `downloads` int(11) default '0',
  `convoid` int(11) unsigned NOT NULL default '0',
  `messageid` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`attachid`),
  KEY `userid` (`userid`),
  KEY `postid` (`postid`)
);

-- 
-- Dumping data for table `attachments`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `avatar`
-- 

CREATE TABLE `avatar` (
  `avatarid` int(11) unsigned NOT NULL auto_increment,
  `groupid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `imgPath` varchar(255) default NULL,
  `disOrder` int(11) default NULL,
  PRIMARY KEY  (`avatarid`),
  KEY `groupid` (`groupid`)
);

-- 
-- Dumping data for table `avatar`
-- 

INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (17, 150, 'Girl', './images/avatars/girl.gif', 4);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (16, 150, 'Eraser', './images/avatars/eraser.gif', 3);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (28, 150, 'Talker', './images/avatars/talker.gif', 11);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (14, 150, 'Boy', './images/avatars/boy.gif', 1);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (18, 150, 'Hat', './images/avatars/hat.gif', 5);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (19, 150, 'Magnify', './images/avatars/magnify.gif', 6);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (20, 150, 'Notepad', './images/avatars/notepad.gif', 7);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (21, 150, 'Pencil', './images/avatars/pencil.gif', 8);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (22, 150, 'Picture', './images/avatars/picture.gif', 9);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (26, 150, 'Brush', './images/avatars/brush.gif', 2);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (27, 150, 'Sign', './images/avatars/sign.gif', 10);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (29, 150, 'Wtcbb', './images/avatars/wtcbb.gif', 12);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (36, 150, 'knives', './images/avatars/knives.gif', 13);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (37, 150, 'folder', './images/avatars/folder.gif', 14);
INSERT INTO `avatar` (`avatarid`, `groupid`, `title`, `imgPath`, `disOrder`) VALUES (38, 150, 'hammer', './images/avatars/hammers.gif', 15);

-- --------------------------------------------------------

-- 
-- Table structure for table `bbcode`
-- 

CREATE TABLE `bbcode` (
  `bbcodeid` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `tag` varchar(255) default NULL,
  `replacement` text,
  `example` text,
  `description` text,
  `display` tinyint(1) default NULL,
  `disOrder` int(11) NOT NULL default '99',
  PRIMARY KEY  (`bbcodeid`)
);

-- 
-- Dumping data for table `bbcode`
-- 

INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (1,'Bold','b','<strong>{param}</strong>','[b]Bolded Text.[/b]','This will bold text.',1,1);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (2,'Italic','i','<em>{param}</em>','[i]Italic text.[/i]','Makes text italic.',1,2);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (3,'Underline','u','<span class="underline">{param}</span>','[u]Underlined text.[/u]','Underlines text.',1,3);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (4,'Font Color','color','<span style="color: {option};">{param}</span>','[color=blue]This is blue text.[/color]','This will color text to the color specified.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (5,'Link','url','<a href="{param}">{param}</a>','[url]http://wtcbb.com[/url]','This will provide a way to link to another web page.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (6,'Advanced Link','url','<a href="{option}">{param}</a>','[url=http://wtcbb.com]wtcbb.com[/url]','Allows the ability to make a named link.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (7,'Image','img','<img src="{param}" alt="{param}" />','[img]http://www.webtrickscentral.com/images/supportWTC.gif[/img]','This will allow the display of images.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (9,'Align','align','<div style="text-align:{option};">{param}</div>','[align=center]Center aligned text![/align]','This will align text to the left, center or right.',1,4);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (25,'Paragraph','p','<p>{param}</p>','[p]A paragraph of text[/p]','Create a new paragraph of text. This paragraph can be modded in a stylesheet.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (26,'Preformatted Text','pre','<pre>{param}</pre>','[pre]This is some preformated text.[/pre]','Preformat text so that your browser displays it "as is."',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (12,'Font Family','font','<span style="font-family: ''{option}'';">{param}</span>','[font=comic sans ms]Goofy font![/font]','This changes the font family of the specified text.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (13,'Font Size','size','<span style="font-size: {option}pt;">{param}</span>','[size=22]Large Font Size![/size]','This changes the font size of the specified text.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (14,'Quote','quote','<div class="quote marCenter">\r\n  <p class="small">Quote:</p>\r\n  <div class="quoted alt1">\r\n    {param}\r\n  </div>\r\n</div>','[quote]The unexamined life isn''t worth living.[/quote]','You can quote some text.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (15,'Advanced Quote','quote','<div class="quote marCenter">\r\n  <p class="small">Quote By: <strong>{option}</strong></p>\r\n  <div class="quoted alt1">\r\n    {param}\r\n  </div>\r\n</div>','[quote=Socrates]The unexamined life isn''t worth living.[/quote]','Now you can identify who said the quote.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (16,'Code','code','<div class="quote marCenter">\r\n  <p class="small">Code:</p>\r\n  <div class="quoted alt1" style="font-family: ''courier new'';">\r\n    {param}\r\n  </div>\r\n</div>','[code]This is some <html> code![/code]','A nice code formatting tag.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (17,'PHP','php','<div class="quote marCenter">\r\n  <p class="small">PHP:</p>\r\n  <div class="quoted alt1" style="font-family: ''courier new''; font-size: 120%;">\r\n    {param}\r\n  </div>\r\n</div>','[php]if("test" == $a) { echo "Pretty-lookin PHP!\\n";  }[/php]','Syntax highlighting for PHP code.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (18,'Numbered List','ol','<ol class="noMar">{param}</ol>','[ol][*]List Item 1[/*][*]List Item 2[/*][*]List Item 3[/*][/ol]','This will allow you to make a numbered (ordered) list.',1,7);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (19,'Bulleted List','ul','<ul class="noMar">{param}</ul>','[ul][*]List Item 1[/*][*]List Item 2[/*][*]List Item 3[/*][/ul]','This will allow you to make a bulleted (unordered) list.',1,7);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (20,'List Item','*','<li class="smallMarBot">{param}</li>','[ul] [*]List Item[/*] [/ul]','This is a list item which works in conjunction with the "ul" and "ol" BB Codes.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (21,'Email','email','<a href="mailto:{param}">{param}</a>','[email]contact@wtcbb.com[/email]','Provides an easy way to link to an email address.',1,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (22,'Advanced Email','email','<a href="mailto:{option}">{param}</a>','[email=contact@wtcbb.com]Contact Me![/email]','Advanced email linking.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (23,'Strike-Through','strike','<span style="text-decoration: line-through;">{param}</span>','[strike]Striked text.[/strike]','This will put a line through text.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (24,'Me','me','<span style="color: #730073; font-weight: bold;">* {poster} {param}</span>','[me]loves n2![/me]','A cheap imitation of IRC''s "/me"',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (27,'Background Color','background','<span style="background-color: {option};">{param}</span>','[background=blue]This is a blue background.[/background]','This will color your text background to the color specified.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (28,'Header','header','<h{option}>{param}</h{option}>','[header=2]Header "2" Text[/header]','Your text will be displayed using header formattings.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (29,'Horizontal Rule','hr','<hr style="width:100%;height:2px;">','[hr] [/hr]','Display a horizontal ruler. Note that the tag must be closed.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (30,'Indent','indent','<div style="margin-left:{option}px;">{param}</div>','[indent=40]Indented text[/indent]','Indent your text by "option" pixels.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (31,'Subtext','sub','<sub>{param}</sub>','X[sub]2[/sub]','Create subtext.',0,99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (32,'Supertext','sup','<sup>{param}</sup>','X[sup]2[/sup]','Create supertext.',0,99);

-- --------------------------------------------------------

-- 
-- Table structure for table `cron`
-- 

CREATE TABLE `cron` (
  `cronid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `path` mediumtext,
  `log` tinyint(1) default NULL,
  `dayOfWeek` int(11) default NULL,
  `dayOfMonth` int(11) default NULL,
  `hour` tinyint(23) default NULL,
  `minute` tinyint(59) default NULL,
  `nextRun` int(11) default NULL,
  PRIMARY KEY  (`cronid`),
  KEY `nextRun` (`nextRun`)
);

-- 
-- Dumping data for table `cron`
-- 

INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (8, 'Lift Temporary Bans', './cron/liftbans.php', 1, -1, -1, -1, 30, 1156818600);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (7, 'Usergroup Automations', './cron/automations.php', 1, -1, -1, 2, 0, 1156831200);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (9, 'End of the Day Clean Up', './cron/cleanup.php', 0, 0, -1, 2, 1, 1157266860);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (11, 'Session Timeout', './cron/timeout.php', 0, -1, -1, -1, -1, 1156815060);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (12, 'Read/Unread Indicator Cleanup', './cron/readIndicatorCleanup.php', 0, 1, -1, 2, 10, 1157350200);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (13, 'Subscriptions', './cron/subscriptions.php', 0, -1, -1, -1, -1, 1156815060);
INSERT INTO `cron` (`cronid`, `title`, `path`, `log`, `dayOfWeek`, `dayOfMonth`, `hour`, `minute`, `nextRun`) VALUES (14, 'Attachment Clean Up', './cron/cleanAttachments.php', 0, 0, -1, 2, 0, 1157266800);

-- --------------------------------------------------------

-- 
-- Table structure for table `custom_pro`
-- 

CREATE TABLE `custom_pro` (
  `proid` int(11) unsigned NOT NULL auto_increment,
  `fieldName` varchar(255) default NULL,
  `fieldDesc` text,
  `fieldType` enum('text','select','multi-select','radio','checkbox','textarea') default NULL,
  `defValue` varchar(255) default NULL,
  `optionText` text,
  `groupid` int(11) default NULL,
  `disOrder` int(11) default '0',
  `colName` varchar(255) default NULL,
  PRIMARY KEY  (`proid`)
);

-- 
-- Dumping data for table `custom_pro`
-- 

INSERT INTO `custom_pro` (`proid`, `fieldName`, `fieldDesc`, `fieldType`, `defValue`, `optionText`, `groupid`, `disOrder`, `colName`) VALUES (3, 'AOL Instant Messenger Handle', '', 'text', '', '', 284, 1, 'profile3');
INSERT INTO `custom_pro` (`proid`, `fieldName`, `fieldDesc`, `fieldType`, `defValue`, `optionText`, `groupid`, `disOrder`, `colName`) VALUES (2, 'MSN Messenger Handle', '', 'text', '', '', 284, 2, 'profile2');
INSERT INTO `custom_pro` (`proid`, `fieldName`, `fieldDesc`, `fieldType`, `defValue`, `optionText`, `groupid`, `disOrder`, `colName`) VALUES (4, 'Yahoo!', '', 'text', '', '', 284, 3, 'profile4');
INSERT INTO `custom_pro` (`proid`, `fieldName`, `fieldDesc`, `fieldType`, `defValue`, `optionText`, `groupid`, `disOrder`, `colName`) VALUES (5, 'ICQ Number', '', 'text', '', '', 284, 4, 'profile5');
INSERT INTO `custom_pro` (`proid`, `fieldName`, `fieldDesc`, `fieldType`, `defValue`, `optionText`, `groupid`, `disOrder`, `colName`) VALUES (6, 'Google Talk', '', 'text', '', '', 284, 5, 'profile6');

-- --------------------------------------------------------

-- 
-- Table structure for table `faq`
-- 

CREATE TABLE `faq` (
  `faqid` int(11) unsigned NOT NULL auto_increment,
  `parent` varchar(255) default NULL,
  `varname` varchar(255) default NULL,
  `disOrder` int(11) default NULL,
  PRIMARY KEY  (`faqid`),
  KEY `parent` (`parent`)
);

-- 
-- Dumping data for table `faq`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `forumperms`
-- 

CREATE TABLE `forumperms` (
  `permid` int(11) unsigned NOT NULL auto_increment,
  `forumid` int(11) default NULL,
  `usergroupid` int(11) default NULL,
  `canEditedNotice` tinyint(1) default NULL,
  `canDownAttach` tinyint(1) default NULL,
  `canUpAttach` tinyint(1) default NULL,
  `canViewBoard` tinyint(1) default NULL,
  `canViewThreads` tinyint(1) default NULL,
  `canViewOwnThreads` tinyint(1) default NULL,
  `canPostThreads` tinyint(1) default NULL,
  `canReplyOwn` tinyint(1) default NULL,
  `canReplyOthers` tinyint(1) default NULL,
  `canEditOwn` tinyint(1) default NULL,
  `canEditOwnThreadTitle` tinyint(1) default NULL,
  `canDelOwnPosts` tinyint(1) default NULL,
  `canDelOwnThreads` tinyint(1) default NULL,
  `canPermDelOwnPosts` tinyint(1) default NULL,
  `canPermDelOwnThreads` tinyint(1) default NULL,
  `canCloseOwn` tinyint(1) default NULL,
  `canViewDelNotices` tinyint(1) default NULL,
  `canSearch` tinyint(1) default NULL,
  `canCreatePolls` tinyint(1) default NULL,
  `canVotePolls` tinyint(1) default NULL,
  `superThreads` tinyint(1) default NULL,
  `superPosts` tinyint(1) default NULL,
  `overrideFlood` tinyint(1) default NULL,
  `canBBCode` tinyint(1) default NULL,
  `canImg` tinyint(1) default NULL,
  `canSmilies` tinyint(1) default NULL,
  `canIcons` tinyint(1) default NULL,
  PRIMARY KEY  (`permid`),
  KEY `forumid` (`forumid`),
  KEY `usergroupid` (`usergroupid`)
);

-- 
-- Dumping data for table `forumperms`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `forums`
-- 

CREATE TABLE `forums` (
  `forumid` int(11) unsigned NOT NULL auto_increment,
  `depth` tinyint(255) default NULL,
  `name` varchar(255) default NULL,
  `parent` int(11) default NULL,
  `directSubs` mediumtext,
  `disOrder` int(11) default NULL,
  `link` varchar(255) default NULL,
  `linkCount` int(11) default NULL,
  `forumPass` varchar(255) default NULL,
  `isCat` tinyint(1) default NULL,
  `isAct` tinyint(1) default NULL,
  `countPosts` tinyint(1) default NULL,
  `viewAge` int(11) default NULL,
  `dateMade` int(11) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` varchar(255) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_threadid` int(11) default NULL,
  `last_reply_threadtitle` varchar(255) default NULL,
  `posts` int(11) default NULL,
  `threads` int(11) default NULL,
  `description` mediumtext,
  PRIMARY KEY  (`forumid`),
  KEY `last_reply_userid` (`last_reply_userid`),
  KEY `last_reply_date` (`last_reply_date`),
  KEY `last_reply_threadtitle` (`last_reply_threadtitle`),
  KEY `parent` (`parent`)
);

-- 
-- Dumping data for table `forums`
-- 

INSERT INTO `forums` (`forumid`, `depth`, `name`, `parent`, `directSubs`, `disOrder`, `link`, `linkCount`, `forumPass`, `isCat`, `isAct`, `countPosts`, `viewAge`, `dateMade`, `last_reply_username`, `last_reply_userid`, `last_reply_date`, `last_reply_threadid`, `last_reply_threadtitle`, `posts`, `threads`, `description`) VALUES (1, 1, 'General Category', -1, 'a:1:{i:0;i:2;}', 1, '', 1, '', 1, 1, 1, 0, 1156759058, 'Chris Ravenscroft', '0', 1156759252, 1, 'Successful Installation!', 1, 1, '');
INSERT INTO `forums` (`forumid`, `depth`, `name`, `parent`, `directSubs`, `disOrder`, `link`, `linkCount`, `forumPass`, `isCat`, `isAct`, `countPosts`, `viewAge`, `dateMade`, `last_reply_username`, `last_reply_userid`, `last_reply_date`, `last_reply_threadid`, `last_reply_threadtitle`, `posts`, `threads`, `description`) VALUES (2, 2, 'General Forum', 1, NULL, 1, '', 0, '', 0, 1, 1, 0, 1156759075, 'Chris Ravenscroft', '0', 1156759252, 1, 'Successful Installation!', 1, 1, 'This is a forum inside the "General Category".');

-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

CREATE TABLE `groups` (
  `groupid` int(11) unsigned NOT NULL auto_increment,
  `groupuuid` varchar(32) default '',
  `groupName` varchar(255) default NULL,
  `groupType` varchar(255) default NULL,
  `usergroupids` mediumtext,
  `parentid` int(11) NOT NULL default '-1',
  `parentuuid` varchar(32) default '',
  `deletable` tinyint(1) NOT NULL default '1',
  `groupOrder` int(11) default '0',
  PRIMARY KEY  (`groupid`)
);

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (149, 'Default Smilies', 'smilies', 'a:1:{i:0;i:-1;}', -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (150, 'Default Avatars', 'avatar', 'a:1:{i:0;i:-1;}', -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (156, 'Global', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (269, 'Member Profile', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (186, 'Stylesheets', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (187, 'Forum Home List', 'styles_fragments', NULL, 189, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (188, 'Error', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (189, 'Forum Home', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (193, 'Thanks', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (198, 'Who''s Online', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (203, 'Forum', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (204, 'Forum Display', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (206, 'Forum Display List', 'styles_fragments', NULL, 204, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (207, 'Post Message', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (210, 'Smiley', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (211, 'Post Icon', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (212, 'Thread Display', 'styles_fragments', NULL, 241, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (213, 'Moderators', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (214, 'Navigation', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (222, 'BB Code', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (228, 'Page Numbers', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (230, 'User Status', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (232, 'Forum Select', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (236, 'Attachments', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (239, 'Announcement Display', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (241, 'Thread', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (242, 'Poll Management', 'styles_fragments', NULL, 241, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (245, 'Searching', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (248, 'User Control Panel', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (253, 'Registration', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (263, 'Personal Messages', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (267, 'Member''s List', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (271, 'Send Email', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (284, 'Instant Messengers', 'custom_pro', NULL, -1, 1, 1);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (287, 'Profile Field HTML', 'styles_fragments', NULL, -1, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `lang`
-- 

CREATE TABLE `lang` (
  `langid` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`langid`)
);

-- 
-- Dumping data for table `lang`
-- 
INSERT INTO `lang` (`langid`, `name`) VALUES (0, 'English');

-- --------------------------------------------------------

-- 
-- Table structure for table `lang_categories`
-- 

CREATE TABLE `lang_categories` (
  `catid` int(11) unsigned NOT NULL auto_increment,
  `catName` varchar(255) default NULL,
  `depth` tinyint(255) default NULL,
  `parentid` int(11) default NULL,
  PRIMARY KEY  (`catid`),
  KEY `parentid` (`parentid`)
);

-- 
-- Dumping data for table `lang_categories`
-- 

INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (1, 'Admin wtcBB Options', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (2, 'Board Access', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (3, 'Information', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (4, 'Setup', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (5, 'Admin General', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (6, 'Admin Errors', 2, 35);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (7, 'Admin Languages', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (8, 'Add Category', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (10, 'Add Words', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (11, 'Language Manager', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (12, 'Edit Words', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (15, 'Edit Category', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (16, 'Search', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (17, 'Admin Search', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (18, 'Admin Navigation', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (20, 'wtcBB Options', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (21, 'Language', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (22, 'Add Language', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (23, 'Import/Export', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (24, 'View Default', 2, 7);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (71, 'Usergroup Manager', 2, 69);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (35, 'Errors', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (34, 'Users', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (58, 'User Options', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (65, 'Show Threads', 2, 61);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (64, 'Global', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (63, 'Thread Settings', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (62, 'Date and Time', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (61, 'Dates', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (60, 'Add/Edit/Search User', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (59, 'Admin Users', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (66, 'Search Results', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (67, 'Users', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (68, 'Usergroups', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (69, 'Admin Usergroups', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (70, 'Add/Edit Usergroup', 2, 69);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (72, 'Administrative Permissions', 2, 69);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (73, 'Cookie Settings', 2, 1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (74, 'Automation', 2, 69);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (75, 'wtcBB Cron System', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (76, 'Add / Edit', 2, 78);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (78, 'Admin Cron', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (79, 'Cron Manager', 2, 78);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (80, 'Ban User', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (81, 'Log', 2, 78);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (82, 'Prune/Move', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (83, 'Search IP Addresses', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (84, 'Merge', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (85, 'Mass Email', 2, 59);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (86, 'Forums', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (87, 'Admin Forums', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (88, 'Add/Edit Forum', 2, 87);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (89, 'Forum Manager', 2, 87);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (90, 'Moderators', 2, 87);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (91, 'Forum Blocking', 2, 87);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (92, 'Permissions', 2, 87);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (93, 'Announcements', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (94, 'Admin Announcements', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (95, 'Add/Edit Announcement', 2, 94);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (96, 'Announcements Manager', 2, 94);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (97, 'Logs', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (98, 'Admin Logs', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (99, 'Administrative', 2, 98);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (100, 'Cron', 2, 98);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (101, 'Moderator', 2, 98);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (102, 'File Actions', 2, 98);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (103, 'FAQ', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (104, 'User Ranks', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (105, 'Attachments', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (106, 'Admin Ranks', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (107, 'Add/Edit Ranks', 2, 106);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (108, 'Rank Manager', 2, 106);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (109, 'User Images', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (110, 'Admin Rank Images', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (111, 'Add/Edit Rank Images', 2, 110);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (112, 'Rank Images Manager', 2, 110);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (113, 'Admin Attachments', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (114, 'Add/Edit Extension', 2, 113);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (115, 'Extensions Manager', 2, 113);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (116, 'Attachment Storage Type', 2, 113);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (117, 'Admin FAQ', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (118, 'Add/Edit FAQ', 2, 117);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (119, 'FAQ Entries', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (120, 'FAQ Manager', 2, 117);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (121, 'Admin Smilies', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (122, 'Add/Edit Smilies', 2, 121);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (123, 'Smilies', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (124, 'Add Multiple Smilies', 2, 121);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (125, 'Admin Groups', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (126, 'Smiley Manager', 2, 121);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (127, 'Post Icons', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (128, 'Admin Post Icons', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (129, 'Add/Edit Post Icon', 2, 128);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (130, 'Add Multiple Post Icons', 2, 128);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (131, 'Post Icon Manager', 2, 128);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (132, 'Admin Avatars', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (133, 'Add/Edit Avatars', 2, 132);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (134, 'Avatar Manager', 2, 132);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (135, 'Add Multiple Avatars', 2, 132);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (136, 'Avatars', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (137, 'Maitenance', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (138, 'Admin Maintenance', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (139, 'Cache Manager', 2, 138);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (140, 'Execute Query', 2, 138);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (141, 'Update Counters', 2, 138);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (142, 'Style System', 2, 18);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (143, 'Admin Styles', 1, -1);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (144, 'Add/Edit Style', 2, 143);
INSERT INTO `lang_categories` (`catid`, `catName`, `depth`, `parentid`) VALUES (145, 'Style Manager', 2, 143);

-- --------------------------------------------------------

-- 
-- Table structure for table `lang_words`
-- 

CREATE TABLE `lang_words` (
  `wordsid` int(11) unsigned NOT NULL auto_increment,
  `name` text,
  `words` text,
  `langid` int(11) NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `displayName` varchar(255) default NULL,
  `defaultid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wordsid`),
  KEY `langid` (`langid`),
  KEY `catid` (`catid`),
  KEY `defaultid` (`defaultid`)
);

-- 
-- Dumping data for table `lang_words`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `logger_admin`
-- 

CREATE TABLE `logger_admin` (
  `log_adminid` int(11) unsigned NOT NULL auto_increment,
  `log_userid` int(11) default NULL,
  `log_date` int(11) default NULL,
  `log_ip` varchar(255) default NULL,
  `log_filePath` varchar(255) default NULL,
  `log_fileAction` varchar(255) default NULL,
  `log_username` varchar(255) default NULL,
  PRIMARY KEY  (`log_adminid`),
  KEY `log_userid` (`log_userid`)
);

-- 
-- Dumping data for table `logger_admin`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `logger_cron`
-- 

CREATE TABLE `logger_cron` (
  `log_cronid` int(11) unsigned NOT NULL auto_increment,
  `log_crontitle` varchar(255) default NULL,
  `log_nextRun` int(11) default NULL,
  `log_date` int(11) default NULL,
  `log_results` mediumtext,
  `log_file` varchar(255) default NULL,
  PRIMARY KEY  (`log_cronid`)
);

-- 
-- Dumping data for table `logger_cron`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `logger_ips`
-- 

CREATE TABLE `logger_ips` (
  `log_ipid` int(11) unsigned NOT NULL auto_increment,
  `ip_address` varchar(255) default NULL,
  `userid` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`log_ipid`),
  KEY `userid` (`userid`),
  KEY `ip_address` (`ip_address`)
);

-- 
-- Dumping data for table `logger_ips`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `logger_mods`
-- 

CREATE TABLE `logger_mods` (
  `log_modid` int(11) unsigned NOT NULL auto_increment,
  `log_userid` int(11) default NULL,
  `log_date` int(11) default NULL,
  `log_ip` varchar(255) default NULL,
  `log_modAction` varchar(255) default NULL,
  `log_username` varchar(255) default NULL,
  `log_results` mediumtext,
  PRIMARY KEY  (`log_modid`),
  KEY `log_userid` (`log_userid`)
);

-- 
-- Dumping data for table `logger_mods`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `moderators`
-- 

CREATE TABLE `moderators` (
  `modid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `forumid` int(11) unsigned NOT NULL default '0',
  `modSubs` tinyint(1) default NULL,
  `canEditPosts` tinyint(1) default NULL,
  `canEditThreads` tinyint(1) default NULL,
  `canEditPolls` tinyint(1) default NULL,
  `canEditReputations` tinyint(1) default NULL,  
  `canDelete` tinyint(1) default NULL,
  `canPermDelete` tinyint(1) default NULL,
  `canOpenClose` tinyint(1) default NULL,
  `canMove` tinyint(1) default NULL,
  `canMerge` tinyint(1) default NULL,
  `canSplit` tinyint(1) default NULL,
  `canIp` tinyint(1) default NULL,
  `modAnnounce` tinyint(1) default NULL,
  `modMassMove` tinyint(1) default NULL,
  `modMassPrune` tinyint(1) default NULL,
  `modProfile` tinyint(1) default NULL,
  `modBan` tinyint(1) default NULL,
  `modRestore` tinyint(1) default NULL,
  `modSigs` tinyint(1) default NULL,
  `modAvatars` tinyint(1) default NULL,
  `emailThread` tinyint(1) default NULL,
  `emailPost` tinyint(1) default NULL,
  `modAccess` tinyint(1) default NULL,
  `modThreads` tinyint(1) default NULL,
  `modPosts` tinyint(1) default NULL,
  `canStick` tinyint(1) default NULL,
  PRIMARY KEY  (`modid`),
  KEY `userid` (`userid`),
  KEY `forumid` (`forumid`)
);

-- 
-- Dumping data for table `moderators`
-- 


-- --------------------------------------------------------


--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `moduleid` int(11) NOT NULL auto_increment,
  `type` char(1) default NULL,
  `name` varchar(64) default NULL,
  `path` text,
  `default` tinyint(1) default NULL,
  `long_name` varchar(128) default NULL,
  `enabled` tinyint(1) default 0,
  PRIMARY KEY  (`moduleid`)
);

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`moduleid`,`type`,`name`,`path`,`default`,`long_name`,`enabled`) VALUES (1,'E','nicEdit','modules/nicEdit/nicEdit.mod.php',1,'WYSIWYG',1);
INSERT INTO `modules` (`moduleid`,`type`,`name`,`path`,`default`,`long_name`,`enabled`) VALUES (2,'E','plainEdit','modules/plainEdit/plainEdit.mod.php',0,'Plain',1);

-- --------------------------------------------------------

-- 
-- Table structure for table `personal_convo`
-- 

CREATE TABLE `personal_convo` (
  `convoid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `convoTimeline` int(11) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` int(11) default NULL,
  `last_reply_messageid` int(11) default NULL,
  `messages` int(11) default NULL,
  PRIMARY KEY  (`convoid`),
  KEY `last_reply_date` (`last_reply_date`),
  KEY `convoTimeline` (`convoTimeline`)
);

-- 
-- Dumping data for table `personal_convo`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `personal_convodata`
-- 

CREATE TABLE `personal_convodata` (
  `convodataid` int(11) unsigned NOT NULL auto_increment,
  `convoid` int(11) unsigned NOT NULL default '0',
  `userid` int(11) unsigned NOT NULL default '0',
  `folderid` int(11) unsigned NOT NULL default '0',
  `lastRead` int(10) unsigned NOT NULL default '0',
  `hasAlert` tinyint(1) default '1',
  `username` varchar(255) default NULL,
  PRIMARY KEY  (`convodataid`),
  KEY `convoid` (`convoid`,`userid`),
  KEY `convoid_2` (`convoid`,`userid`,`folderid`)
);

-- 
-- Dumping data for table `personal_convodata`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `personal_folders`
-- 

CREATE TABLE `personal_folders` (
  `folderid` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `userid` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`folderid`),
  KEY `userid` (`userid`)
);

-- 
-- Dumping data for table `personal_folders`
-- 

INSERT INTO `personal_folders` (`folderid`, `name`, `userid`) VALUES (1, 'Inbox', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `personal_msg`
-- 

CREATE TABLE `personal_msg` (
  `messageid` int(11) unsigned NOT NULL auto_increment,
  `convoid` int(11) unsigned NOT NULL default '0',
  `title` varchar(255) default NULL,
  `userid` int(11) unsigned NOT NULL default '0',
  `message` mediumtext,
  `ip_address` varchar(255) default NULL,
  `msg_timeline` int(11) default NULL,
  `readby` text,
  `pmHash` varchar(32) default NULL,
  `sig` tinyint(1) default NULL,
  `smilies` tinyint(1) default NULL,
  `bbcode` tinyint(1) default NULL,
  PRIMARY KEY  (`messageid`),
  KEY `userid` (`userid`),
  KEY `convoid` (`convoid`)
);

-- 
-- Dumping data for table `personal_msg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `polls`
-- 

CREATE TABLE `polls` (
  `pollid` int(11) unsigned NOT NULL auto_increment,
  `threadid` int(11) unsigned NOT NULL default '0',
  `title` varchar(255) default NULL,
  `poll_timeline` int(11) default NULL,
  `options` int(11) default NULL,
  `multiple` tinyint(1) default NULL,
  `public` tinyint(1) default NULL,
  `votes` int(11) default NULL,
  `timeout` int(11) default NULL,
  `polloptions` mediumtext,
  `forumid` int(11) default NULL,
  `disabled` tinyint(1) default NULL,
  PRIMARY KEY  (`pollid`),
  KEY `threadid` (`threadid`)
);

-- 
-- Dumping data for table `polls`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `posticons`
-- 

CREATE TABLE `posticons` (
  `iconid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `imgPath` mediumtext,
  `disOrder` int(11) default NULL,
  PRIMARY KEY  (`iconid`)
);

-- 
-- Dumping data for table `posticons`
-- 

INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (68, 'Icon1', 'images/icons/icon1.gif', 1);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (69, 'Icon2', 'images/icons/icon2.gif', 3);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (55, 'icon_04', './images/icons/icon_04.gif', 2);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (58, 'icon_05', './images/icons/icon_05.gif', 6);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (59, 'icon_06', './images/icons/icon_06.gif', 7);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (60, 'icon_07', './images/icons/icon_07.gif', 8);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (61, 'icon_08', './images/icons/icon_08.gif', 9);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (62, 'icon_09', './images/icons/icon_09.gif', 5);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (63, 'icon_10', './images/icons/icon_10.gif', 10);
INSERT INTO `posticons` (`iconid`, `title`, `imgPath`, `disOrder`) VALUES (70, 'Icon3', 'images/icons/icon3.gif', 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `posts`
-- 

CREATE TABLE `posts` (
  `postid` int(11) unsigned NOT NULL auto_increment,
  `threadid` int(11) unsigned NOT NULL default '0',
  `forumid` int(11) unsigned NOT NULL default '0',
  `postby` int(11) unsigned NOT NULL default '0',
  `postUsername` varchar(255) default NULL,
  `message` mediumtext,
  `title` varchar(255) default NULL,
  `ip_address` varchar(255) default NULL,
  `posts_timeline` int(11) default NULL,
  `posticon` varchar(255) default NULL,
  `deleted` tinyint(1) default NULL,
  `edited_by` varchar(255) default NULL,
  `edited_timeline` int(11) default NULL,
  `edited_reason` varchar(255) default NULL,
  `sig` tinyint(1) default NULL,
  `smilies` tinyint(1) default NULL,
  `bbcode` tinyint(1) default NULL,
  `defBBCode` tinyint(1) default NULL,
  `edited_show` tinyint(1) default NULL,
  PRIMARY KEY  (`postid`),
  KEY `threadid` (`threadid`),
  KEY `forumid` (`forumid`),
  KEY `userid` (`postby`),
  KEY `deleted` (`deleted`)
);

-- 
-- Dumping data for table `posts`
-- 

INSERT INTO `posts` (`postid`, `threadid`, `forumid`, `postby`, `postUsername`, `message`, `title`, `ip_address`, `posts_timeline`, `posticon`, `deleted`, `edited_by`, `edited_timeline`, `edited_reason`, `sig`, `smilies`, `bbcode`, `defBBCode`, `edited_show`) VALUES (1, 1, 2, 0, 'Chris Ravenscroft', 'Hello,\r\n\r\nThank you for trying out [i]n2[/i].\r\n\r\nPlease report any issue at [url=http://nextbbs.com]http://nextbbs.com[/url]\r\n\r\n-Chris.', 'Successful Installation!', '192.168.1.1', 1242605371, '', 0, '', 0, NULL, 1, 1, 1, 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `reputations`
-- 

CREATE TABLE `reputations` (
  `repid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `repby` int(11) unsigned NOT NULL default '0',
  `repUsername` varchar(255) default NULL,
  `message` mediumtext,
  `up` tinyint(1) default 1,
  `ip_address` varchar(255) default NULL,
  `rep_timeline` int(11) default NULL,
  `deleted` tinyint(1) default NULL,
  `edited_by` varchar(255) default NULL,
  `edited_timeline` int(11) default NULL,
  `edited_reason` varchar(255) default NULL,
  primary key(`repid`),
  key `repby` (`repby`),
  key `deleted` (`deleted`)
);

-- 
-- Dumping data for table `reputations`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ranks`
-- 

CREATE TABLE `ranks` (
  `rankid` int(11) unsigned NOT NULL auto_increment,
  `title` mediumtext,
  `minPosts` int(11) default NULL,
  PRIMARY KEY  (`rankid`)
);

-- 
-- Dumping data for table `ranks`
-- 

INSERT INTO `ranks` (`rankid`, `title`, `minPosts`) VALUES (1, 'Junior Member', 20);
INSERT INTO `ranks` (`rankid`, `title`, `minPosts`) VALUES (2, 'New Member', 0);
INSERT INTO `ranks` (`rankid`, `title`, `minPosts`) VALUES (3, 'Member', 100);
INSERT INTO `ranks` (`rankid`, `title`, `minPosts`) VALUES (4, 'Senior Member', 1000);

-- --------------------------------------------------------

-- 
-- Table structure for table `ranks_images`
-- 

CREATE TABLE `ranks_images` (
  `rankiid` int(11) unsigned NOT NULL auto_increment,
  `rankRepeat` int(11) default NULL,
  `minPosts` int(11) default NULL,
  `imgPath` varchar(255) default NULL,
  PRIMARY KEY  (`rankiid`)
);

-- 
-- Dumping data for table `ranks_images`
-- 

INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (6, 1, 0, './images/ranks/rank_1.gif');
INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (7, 1, 50, './images/ranks/rank_2.gif');
INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (8, 1, 100, './images/ranks/rank_3.gif');
INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (9, 1, 300, './images/ranks/rank_4.gif');
INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (10, 1, 500, './images/ranks/rank_5.gif');
INSERT INTO `ranks_images` (`rankiid`, `rankRepeat`, `minPosts`, `imgPath`) VALUES (11, 1, 1000, './images/ranks/rank_6.gif');

-- --------------------------------------------------------

-- 
-- Table structure for table `read_forums`
-- 

CREATE TABLE `read_forums` (
  `readUserId` int(11) unsigned NOT NULL default '0',
  `readForumId` int(11) unsigned NOT NULL default '0',
  `dateRead` int(11) default NULL,
  PRIMARY KEY  (`readForumId`,`readUserId`)
);

-- 
-- Dumping data for table `read_forums`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `read_threads`
-- 

CREATE TABLE `read_threads` (
  `readUserId` int(11) unsigned NOT NULL default '0',
  `readThreadId` int(11) unsigned NOT NULL default '0',
  `dateRead` int(11) default NULL,
  PRIMARY KEY  (`readThreadId`,`readUserId`)
);

-- 
-- Dumping data for table `read_threads`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sessions`
-- 

CREATE TABLE `sessions` (
  `sessionid` varchar(32) NOT NULL default '',
  `username` varchar(255) default NULL,
  `userid` int(11) unsigned NOT NULL default '0',
  `lastactive` int(11) default NULL,
  `loc` varchar(255) default NULL,
  `details` varchar(255) default NULL,
  `ip` varchar(255) default NULL,
  `userAgent` varchar(255) default NULL,
  `lastaction` int(11) default NULL,
  PRIMARY KEY  (`sessionid`),
  KEY `lastactive` (`lastactive`),
  KEY `userid` (`userid`)
);

-- 
-- Dumping data for table `sessions`
-- 

INSERT INTO `sessions` (`sessionid`, `username`, `userid`, `lastactive`, `loc`, `details`, `ip`, `userAgent`, `lastaction`) VALUES ('144b8dceb2474cdcba43cabddc63079e', 'Guest', 0, 1156836752, '/index.php?', 'Error', '192.168.1.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5.0.6', 1156815208);

-- --------------------------------------------------------

-- 
-- Table structure for table `smilies`
-- 

CREATE TABLE `smilies` (
  `smileyid` int(11) unsigned NOT NULL auto_increment,
  `groupid` int(11) default NULL,
  `title` varchar(255) default NULL,
  `replacement` varchar(255) default NULL,
  `imgPath` varchar(255) default NULL,
  `disOrder` int(11) default NULL,
  PRIMARY KEY  (`smileyid`),
  KEY `groupid` (`groupid`)
);

-- 
-- Dumping data for table `smilies`
-- 

INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (32, 149, ':eek:', ':eek:', './images/smilies/eek.gif', 6);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (15, 149, 'Happy', ':)', './images/smilies/happy.gif', 5);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (14, 149, 'Embarrassed', ':o', './images/smilies/embarrassed.gif', 4);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (25, 149, 'Cool', ':cool:', './images/smilies/cool.gif', 3);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (12, 149, 'Confused', ':?', './images/smilies/confused.gif', 2);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (11, 149, 'Biggrin', ':D', './images/smilies/biggrin.gif', 1);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (17, 149, 'Mad', ':mad:', './images/smilies/mad.gif', 7);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (18, 149, 'No', ':no:', './images/smilies/no.gif', 8);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (19, 149, 'P', ':p', './images/smilies/P.gif', 9);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (20, 149, 'Rolleyes', ':rolleyes:', './images/smilies/rolleyes.gif', 10);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (21, 149, 'Sad', ':(', './images/smilies/sad.gif', 11);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (22, 149, 'Wink', ';)', './images/smilies/wink.gif', 12);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (23, 149, 'Yes', ':yes:', './images/smilies/yes.gif', 13);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (26, 149, 'ROFL', ':rofl:', './images/smilies/rofl.gif', 14);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (27, 149, 'dull', ':dull:', './images/smilies/dull.gif', 15);
INSERT INTO `smilies` (`smileyid`, `groupid`, `title`, `replacement`, `imgPath`, `disOrder`) VALUES (33, 149, 'o_O', ':bug:', './images/smilies/o_O.gif', 16);

-- --------------------------------------------------------

-- 
-- Table structure for table `styles`
-- 

CREATE TABLE `styles` (
  `styleid` int(11) unsigned NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `disOrder` int(11) default NULL,
  `selectable` tinyint(1) default NULL,
  `enabled` tinyint(1) default NULL,
  `fragmentids` mediumtext,
  `css` mediumtext,
  PRIMARY KEY  (`styleid`),
  KEY `selectable` (`selectable`),
  KEY `parentid` (`parentid`),
  KEY `enabled` (`enabled`)
);

-- 
-- Dumping data for table `styles`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `styles_fragments`
-- 

CREATE TABLE `styles_fragments` (
  `fragmentid` int(11) unsigned NOT NULL auto_increment,
  `styleid` int(11) unsigned default NULL,
  `groupid` int(11) default NULL,
  `fragmentName` varchar(255) default NULL,
  `fragmentVarName` varchar(255) default NULL,
  `fragmentType` varchar(255) default NULL,
  `fragment` mediumtext,
  `template_php` mediumtext,
  `defaultid` int(11) NOT NULL default '0',
  `disOrder` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fragmentid`),
  KEY `styleid` (`styleid`),
  KEY `groupid` (`groupid`)
);

-- 
-- Dumping data for table `styles_fragments`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `subscribe`
-- 

CREATE TABLE `subscribe` (
  `subid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `forumid` int(11) unsigned NOT NULL default '0',
  `threadid` int(11) unsigned default NULL,
  `subType` varchar(255) default NULL,
  `lastEmail` int(11) default NULL,
  `lastView` int(11) default NULL,
  PRIMARY KEY  (`subid`),
  KEY `userid` (`userid`,`forumid`),
  KEY `userid_2` (`userid`,`threadid`)
);

-- 
-- Dumping data for table `subscribe`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `threads`
-- 

CREATE TABLE `threads` (
  `threadid` int(11) unsigned NOT NULL auto_increment,
  `forumid` int(11) unsigned NOT NULL default '0',
  `name` varchar(255) default NULL,
  `madeby` int(11) unsigned NOT NULL default '0',
  `threadUsername` varchar(255) default NULL,
  `views` int(11) default NULL,
  `replies` int(11) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` varchar(255) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_postid` int(11) default NULL,
  `posticon` varchar(255) default NULL,
  `deleted` tinyint(1) default NULL,
  `deleted_by` varchar(255) default NULL,
  `deleted_reason` text,
  `deleted_timeline` int(11) default NULL,
  `moved` int(11) default NULL,
  `sticky` tinyint(1) default NULL,
  `closed` tinyint(1) default NULL,
  `poll` tinyint(1) default NULL,
  `thread_timeline` int(11) default NULL,
  `descript` varchar(255) default NULL,
  `first_postid` int(11) unsigned NOT NULL default '0',
  `deleted_replies` int(11) default NULL,
  PRIMARY KEY  (`threadid`),
  KEY `forumid` (`forumid`),
  KEY `madeby` (`madeby`),
  KEY `last_reply_userid` (`last_reply_userid`),
  KEY `last_reply_date` (`last_reply_date`),
  KEY `last_reply_postid` (`last_reply_postid`),
  KEY `deleted` (`deleted`),
  KEY `moved` (`moved`),
  KEY `closed` (`closed`),
  KEY `first_postid` (`first_postid`)
);

-- 
-- Dumping data for table `threads`
-- 

INSERT INTO `threads` (`threadid`, `forumid`, `name`, `madeby`, `threadUsername`, `views`, `replies`, `last_reply_username`, `last_reply_userid`, `last_reply_date`, `last_reply_postid`, `posticon`, `deleted`, `deleted_by`, `deleted_reason`, `deleted_timeline`, `moved`, `sticky`, `closed`, `poll`, `thread_timeline`, `descript`, `first_postid`, `deleted_replies`) VALUES (1, 2, 'Successful Installation!', 0, 'Chris Ravenscroft', 1, 0, 'Chris Ravenscroft', '0', 1242605371, 1, '', 0, NULL, NULL, NULL, 0, 0, 0, 0, 1242605371, 'Hello,', 1, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `usergroups`
-- 

CREATE TABLE `usergroups` (
  `usergroupid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `description` mediumtext,
  `usertitle` mediumtext,
  `htmlBegin` mediumtext,
  `htmlEnd` mediumtext,
  `global` tinyint(1) default NULL,
  `admin` tinyint(1) default NULL,
  `isBanned` tinyint(1) default NULL,
  `showListedGroups` tinyint(1) default NULL,
  `showMemberList` tinyint(1) default NULL,
  `showBirthdays` tinyint(1) default NULL,
  `showEditedNotice` tinyint(1) default NULL,
  `canInvis` tinyint(1) default NULL,
  `canEditedNotice` tinyint(1) default NULL,
  `canUsertitle` tinyint(1) default NULL,
  `canSig` tinyint(1) default NULL,
  `canAv` tinyint(1) default NULL,
  `canDownAttach` tinyint(1) default NULL,
  `canUpAttach` tinyint(1) default NULL,
  `canDefBBCode` tinyint(1) default NULL,
  `canViewOnline` tinyint(1) default NULL,
  `canViewOnlineIp` tinyint(1) default NULL,
  `canViewInvis` tinyint(1) default NULL,
  `canViewProfile` tinyint(1) default NULL,
  `canViewBoard` tinyint(1) default NULL,
  `canViewForums` tinyint(1) default NULL,
  `canViewThreads` tinyint(1) default NULL,
  `canPostThreads` tinyint(1) default NULL,
  `canReplyOwn` tinyint(1) default NULL,
  `canReplyOthers` tinyint(1) default NULL,
  `canEditOwn` tinyint(1) default NULL,
  `canDelOwnPosts` tinyint(1) default NULL,
  `canDelOwnThreads` tinyint(1) default NULL,
  `canCloseOwn` tinyint(1) default NULL,
  `canViewDelNotices` tinyint(1) default NULL,
  `canPermDelOwnPosts` tinyint(1) default NULL,
  `canSearch` tinyint(1) default NULL,
  `canEditProfile` tinyint(1) default NULL,
  `canReceipts` tinyint(1) default NULL,
  `canDenyReceipts` tinyint(1) default NULL,
  `canFolders` tinyint(1) default NULL,
  `canWarnOthers` tinyint(1) default NULL,
  `canWarnImmune` tinyint(1) default NULL,
  `canWarnViewOwn` tinyint(1) default NULL,
  `canWarnViewOthers` tinyint(1) default NULL,
  `canDisableCensor` tinyint(1) default NULL,
  `canIgnoreList` tinyint(1) default NULL,
  `canSwitchStyles` tinyint(1) default NULL,
  `overrideFlood` tinyint(1) default NULL,
  `overrideSearchMinChars` tinyint(1) default NULL,
  `overrideSearchMaxChars` tinyint(1) default NULL,
  `overridePostMinChars` tinyint(1) default NULL,
  `overridePostMaxChars` tinyint(1) default NULL,
  `overridePostMaxImages` tinyint(1) default NULL,
  `attachFilesize` int(11) default NULL,
  `avatarFilesize` int(11) default NULL,
  `avatarWidth` int(11) default NULL,
  `avatarHeight` int(11) default NULL,
  `personalMaxMessages` int(11) default NULL,
  `personalSendUsers` int(11) default NULL,
  `personalRules` int(11) default NULL,
  `canCreatePolls` tinyint(1) default NULL,
  `canVotePolls` tinyint(1) default NULL,
  `canViewOwnThreads` tinyint(1) default NULL,
  `canViewMemberList` tinyint(1) default NULL,
  `canPermDelOwnThreads` tinyint(1) default NULL,
  `canEditOwnThreadTitle` tinyint(1) default NULL,
  `canUploadAv` tinyint(1) default NULL,
  `superThreads` tinyint(1) default NULL,
  `superPosts` tinyint(1) default NULL,
  `canBBCode` tinyint(1) default NULL,
  `canImg` tinyint(1) default NULL,
  `canSmilies` tinyint(1) default NULL,
  `canIcons` tinyint(1) default NULL,
  `maxAttach` int(11) default NULL,
  `overrideMaxSig` tinyint(1) default NULL,
  `showRanks` tinyint(1) default NULL,
  PRIMARY KEY  (`usergroupid`),
  KEY `global` (`global`),
  KEY `admin` (`admin`),
  KEY `isBanned` (`isBanned`),
  KEY `showListedGroups` (`showListedGroups`)
);

-- 
-- Dumping data for table `usergroups`
-- 

INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (4, 'Registered Users', 'This is the default usergroup for all users. This comes with the most basic options.', '', '', '', 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 200000, 20000, 64, 64, 100, 5, 5, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 5, 0, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (8, 'Administrators', 'This is the usergroup for administrators, with the highest level of permissions.', '<strong style="color: #b00;">Administrator</strong>', '<em style="color: #e44214; text-decoration: underline;">', '</em>', 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 100000, 100, 100, 500, 20, 5, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 50, 1, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (7, 'Global Moderators', 'This is the usergroup for Global Moderators, who are automatically enabled to moderate all forums.', 'Global Moderator', '', '', 1, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 20000, 64, 64, 250, 10, 5, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 5, 0, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (6, 'Moderators', 'This is the usergroup for Moderators. They have slightly higher permissions than regular members.', 'Moderator', '', '', 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 20000, 64, 64, 200, 10, 5, 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 5, 0, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (2, 'COPPA Users', 'This is the COPPA Users group. They have slightly more limited privileges than Registered Users.', 'COPPA User', '', '', 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 20000, 64, 64, 100, 5, 5, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 5, NULL, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (1, 'Guests', 'The default usergroup for all unregistered or logged out users. Very limited privleges.', 'Guest', '', '', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (3, 'Users Awaiting Activation', 'Usergroup for users who have reigstered, but are still waiting to get their email address activation. Very limited privleges.', 'Awaiting Activation', '', '', 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 20000, 64, 64, 100, 20, 5, 1, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 0, 1);
INSERT INTO `usergroups` (`usergroupid`, `title`, `description`, `usertitle`, `htmlBegin`, `htmlEnd`, `global`, `admin`, `isBanned`, `showListedGroups`, `showMemberList`, `showBirthdays`, `showEditedNotice`, `canInvis`, `canEditedNotice`, `canUsertitle`, `canSig`, `canAv`, `canDownAttach`, `canUpAttach`, `canDefBBCode`, `canViewOnline`, `canViewOnlineIp`, `canViewInvis`, `canViewProfile`, `canViewBoard`, `canViewForums`, `canViewThreads`, `canPostThreads`, `canReplyOwn`, `canReplyOthers`, `canEditOwn`, `canDelOwnPosts`, `canDelOwnThreads`, `canCloseOwn`, `canViewDelNotices`, `canPermDelOwnPosts`, `canSearch`, `canEditProfile`, `canReceipts`, `canDenyReceipts`, `canFolders`, `canWarnOthers`, `canWarnImmune`, `canWarnViewOwn`, `canWarnViewOthers`, `canDisableCensor`, `canIgnoreList`, `canSwitchStyles`, `overrideFlood`, `overrideSearchMinChars`, `overrideSearchMaxChars`, `overridePostMinChars`, `overridePostMaxChars`, `overridePostMaxImages`, `attachFilesize`, `avatarFilesize`, `avatarWidth`, `avatarHeight`, `personalMaxMessages`, `personalSendUsers`, `personalRules`, `canCreatePolls`, `canVotePolls`, `canViewOwnThreads`, `canViewMemberList`, `canPermDelOwnThreads`, `canEditOwnThreadTitle`, `canUploadAv`, `superThreads`, `superPosts`, `canBBCode`, `canImg`, `canSmilies`, `canIcons`, `maxAttach`, `overrideMaxSig`, `showRanks`) VALUES (5, 'Banned', 'This usergroup is for banned members. They have no access to the message board.', 'Banned', '', '', 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `usergroups_auto`
-- 

CREATE TABLE `usergroups_auto` (
  `autoid` int(11) unsigned NOT NULL auto_increment,
  `affectedId` mediumtext,
  `moveTo` int(11) default NULL,
  `daysReg` int(11) default NULL,
  `daysRegComp` tinyint(1) default NULL,
  `postsa` int(11) default NULL,
  `postsComp` tinyint(1) default NULL,
  `type` tinyint(1) default NULL,
  `secondary` tinyint(1) default NULL,
  PRIMARY KEY  (`autoid`),
  KEY `moveTo` (`moveTo`)
);

-- 
-- Dumping data for table `usergroups_auto`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `userinfo`
-- 

CREATE TABLE `userinfo` (
  `userid` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `usergroupid` int(11) unsigned NOT NULL default '0',
  `secgroupids` mediumtext,
  `joined` int(11) default NULL,
  `ip` varchar(255) default NULL,
  `posts` int(11) unsigned NOT NULL default '0',
  `threads` int(11) unsigned NOT NULL default '0',
  `lastvisit` int(11) default NULL,
  `lastactivity` int(11) default NULL,
  `lastpost` int(11) default NULL,
  `lastpostid` int(11) unsigned NOT NULL default '0',
  `birthday` int(11) default NULL,
  `warn` int(11) unsigned NOT NULL default '0',
  `aim` varchar(255) default NULL,
  `msn` varchar(255) default NULL,
  `yahoo` varchar(255) default NULL,
  `icq` varchar(255) default NULL,
  `homepage` varchar(255) default NULL,
  `location` varchar(255) default NULL,
  `interests` mediumtext,
  `occupation` mediumtext,
  `biography` mediumtext,
  `usertitle` mediumtext,
  `usertitle_opt` int(11) default NULL,
  `htmlBegin` mediumtext,
  `htmlEnd` mediumtext,
  `email` varchar(255) default NULL,
  `parentEmail` varchar(255) default NULL,
  `coppa` tinyint(1) default NULL,
  `dst` tinyint(1) default NULL,
  `timezone` tinyint(12) default NULL,
  `referrer` varchar(255) default NULL,
  `referrals` int(11) default NULL,
  `sig` mediumtext,
  `defFont` varchar(255) default NULL,
  `defColor` varchar(255) default NULL,
  `defSize` varchar(255) default NULL,
  `passTime` int(11) default NULL,
  `salt` varchar(255) default NULL,
  `styleid` int(11) default NULL,
  `toolbar` tinyint(1) default NULL,
  `allowHtml` tinyint(1) default NULL,
  `banSig` tinyint(1) default NULL,
  `disSigs` tinyint(1) default NULL,
  `disImgs` tinyint(1) default NULL,
  `disAttach` tinyint(1) default NULL,
  `disAv` tinyint(1) default NULL,
  `disSmi` tinyint(1) default NULL,
  `invis` tinyint(1) default NULL,
  `emailContact` tinyint(1) default NULL,
  `adminEmails` tinyint(1) default NULL,
  `receivePm` tinyint(1) default NULL,
  `receivePmEmail` tinyint(1) default NULL,
  `receivePmAlert` tinyint(1) default NULL,
  `displayOrder` varchar(255) NOT NULL default 'ASC',
  `postsPerPage` int(11) default NULL,
  `threadViewAge` int(11) default NULL,
  `password` varchar(255) default NULL,
  `defAuto` tinyint(1) default NULL,
  `censor` tinyint(1) default NULL,
  `blockedForums` mediumtext,
  `lang` varchar(255) default NULL,
  `markedRead` int(11) default NULL,
  `emailActivate` int(11) default NULL,
  `passActivate` int(11) default NULL,
  `emailNew` varchar(255) default NULL,
  `passNew` varchar(255) default NULL,
  `saltNew` varchar(255) default NULL,
  `passTimeNew` int(11) default NULL,
  `avatar` text,
  `oldPass` tinyint(1) NOT NULL default '0',
  `reputation` int(11) default 0,
  `editor` varchar(16) default 'default',
  PRIMARY KEY  (`userid`),
  KEY `usergroupid` (`usergroupid`),
  KEY `joined` (`joined`)
);

-- 
-- Dumping data for table `userinfo`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `userinfo_ban`
-- 

CREATE TABLE `userinfo_ban` (
  `banid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `usergroupid` int(11) default NULL,
  `banLength` int(11) default NULL,
  `banStart` int(11) default NULL,
  `previousGroupId` int(11) default NULL,
  PRIMARY KEY  (`banid`),
  KEY `userid` (`userid`),
  KEY `usergroupid` (`usergroupid`)
);

-- 
-- Dumping data for table `userinfo_ban`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `userinfo_pro`
-- 

CREATE TABLE `userinfo_pro` (
  `user_id` int(11) unsigned NOT NULL default '0',
  `profile2` text,
  `profile3` text,
  `profile4` text,
  `profile5` text,
  `profile6` text,
  `profile13` text,
  PRIMARY KEY  (`user_id`)
);

-- 
-- Dumping data for table `userinfo_pro`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `usertitles`
-- 

CREATE TABLE `usertitles` (
  `titleid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `minposts` int(11) default NULL,
  PRIMARY KEY  (`titleid`)
);

-- 
-- Dumping data for table `usertitles`
-- 

INSERT INTO `usertitles` (`titleid`, `title`, `minposts`) VALUES (1, 'New Member', 0);
INSERT INTO `usertitles` (`titleid`, `title`, `minposts`) VALUES (2, 'Member', 100);
INSERT INTO `usertitles` (`titleid`, `title`, `minposts`) VALUES (3, 'Senior Member', 500);

-- --------------------------------------------------------

-- 
-- Table structure for table `warn`
-- 

CREATE TABLE `warn` (
  `warnid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `typeid` int(11) unsigned NOT NULL default '0',
  `whoWarned` int(11) unsigned NOT NULL default '0',
  `postid` int(11) unsigned NOT NULL default '0',
  `note` mediumtext,
  `warn_timeline` int(11) default NULL,
  PRIMARY KEY  (`warnid`),
  KEY `userid` (`userid`),
  KEY `typeid` (`typeid`),
  KEY `whoWarned` (`whoWarned`),
  KEY `postid` (`postid`)
);

-- 
-- Dumping data for table `warn`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `warn_type`
-- 

CREATE TABLE `warn_type` (
  `typeid` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `points` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`typeid`)
);

-- 
-- Dumping data for table `warn_type`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `wtcbboptions`
-- 

CREATE TABLE `wtcbboptions` (
  `settingid` int(11) unsigned NOT NULL auto_increment,
  `settingType` varchar(255) default NULL,
  `value` mediumtext NOT NULL,
  `settingName` varchar(255) default NULL,
  `settingGroup` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `displayOrder` int(11) default NULL,
  `hidden` tinyint(1) default NULL,
  PRIMARY KEY  (`settingid`),
  KEY `settingType` (`settingType`)
);

-- 
-- Dumping data for table `wtcbboptions`
-- 

INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (1, 'text', '30', 'admin_options_boardAccess_floodcheck', 'boardAccess', 'floodcheck', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (2, 'text', 'Our House', 'admin_options_information_boardName', 'information', 'boardName', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (3, 'checkbox', '1', 'admin_options_setup_forumJump', 'setup', 'forumJump', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (4, 'select', '0', 'admin_options_information_defLang', 'setup', 'defLang', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (5, 'checkbox', '1', 'admin_options_userOptions_verifyEmail', 'userOptions', 'verifyEmail', 3, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (6, 'checkbox', '1', 'admin_options_userOptions_newReg', 'userOptions', 'newReg', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (7, 'checkbox', '0', 'admin_options_userOptions_uniqueEmail', 'userOptions', 'uniqueEmail', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (8, 'text', 'h:i A', 'admin_options_dateTime_time', 'dateTime', 'timeFormat_time', 5, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (9, 'text', 'm-d-Y', 'admin_options_dateTime_date', 'dateTime', 'timeFormat_date', 4, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (10, 'select', '-5', 'admin_options_dateTime_timezone', 'dateTime', 'timezone', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (11, 'checkbox', '1', 'admin_options_dateTime_dst', 'dateTime', 'dst', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (38, 'text', '5 10 15 20 25 30 45', 'admin_options_threadSettings_settablePostsPerPage', 'threadSettings', 'settablePostsPerPage', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (13, 'text', '15', 'admin_options_threadSettings_postsPerPage', 'threadSettings', 'postsPerPage', 4, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (14, 'checkbox', '1', 'admin_options_threadSettings_browsingThread', 'threadSettings', 'browsingThread', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (16, 'text', '.wtcbb2.com', 'admin_options_cookieSettings_cookDomain', 'cookieSettings', 'cookDomain', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (17, 'text', '/', 'admin_options_cookieSettings_cookPath', 'cookieSettings', 'cookPath', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (18, 'text', '900', 'admin_options_cookieSettings_cookTimeout', 'cookieSettings', 'cookTimeout', 3, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (19, 'text', 'webmaster@wtcbb2.com', 'admin_options_information_adminContact', 'information', 'adminContact', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (20, NULL, '1', NULL, NULL, 'attachStorageType', NULL, 1);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (21, 'checkbox', '1', 'admin_options_setup_redirect', 'setup', 'redirect', 3, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (22, 'checkbox', '0', 'admin_options_cookieSettings_cookLogin', 'cookieSettings', 'cookLogin', 4, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (23, 'checkbox', '1', 'admin_options_forumHome_whosOnline', 'forumHome', 'whosOnline', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (24, 'checkbox', '1', 'admin_options_forumHome_stats', 'forumHome', 'stats', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (26, 'textarea', 'lycos\r\nask jeeves\r\ngooglebot\r\nslurp@inktomi\r\nfast-webcrawler\r\nyahoo\r\nmsnbot', 'admin_options_robots_robotDetect', 'robots', 'robotDetect', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (27, 'textarea', 'Lycos\r\nAsk Jeeves\r\nGoogle Bot\r\nInktomi\r\nAll The Web\r\nYahoo!\r\nMSN Bot', 'admin_options_robots_robotDesc', 'robots', 'robotDesc', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (28, 'text', '16', 'admin_options_message_smilies', 'message', 'smilies', 1, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (29, 'checkbox', '1', 'admin_options_message_threadReview', 'message', 'threadReview', 2, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (30, 'checkbox', '1', 'admin_options_message_toolbar', 'message', 'toolbar', 3, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (31, 'text', '5', 'admin_options_posting_minMessageChars', 'posting', 'minMessageChars', 1, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (32, 'text', '60000', 'admin_options_posting_maxMessageChars', 'posting', 'maxMessageChars', 2, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (33, 'text', '30', 'admin_options_posting_maxMessageImgs', 'posting', 'maxMessageImgs', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (34, 'text', '50', 'admin_options_posting_maxTitleChars', 'posting', 'maxTitleChars', 5, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (35, 'text', '3', 'admin_options_posting_minTitleChars', 'posting', 'minTitleChars', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (36, 'checkbox', '1', 'admin_options_dateTime_todYes', 'dateTime', 'timeFormat_todYes', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (37, 'text', '20', 'admin_options_forumSettings_threadsPerPage', 'forumSettings', 'threadsPerPage', 2, 0);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (39, 'text', '7', 'admin_options_setup_readTimeout', 'setup', 'readTimeout', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (40, 'text', '15', 'admin_options_threadSettings_maxQuote', 'threadSettings', 'maxQuote', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (41, 'checkbox', '1', 'admin_options_forumSettings_browsingForum', 'forumSettings', 'browsingForum', 1, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (42, NULL, '0', NULL, NULL, 'lastSubEmail', NULL, 1);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (43, 'checkbox', '0', 'admin_options_forumHome_hidePrivateForums', 'forumHome', 'hidePrivateForums', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (44, 'text', '15', 'admin_options_forumSettings_hotReplies', 'forumSettings', 'hotReplies', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (45, 'text', '200', 'admin_options_forumSettings_hotViews', 'forumSettings', 'hotViews', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (46, 'text', '10', 'admin_options_threadSettings_pollLimit', 'threadSettings', 'pollLimit', 5, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (47, 'text', '3', 'admin_options_userOptions_minTitle', 'userOptions', 'minTitle', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (48, 'text', '35', 'admin_options_userOptions_maxTitle', 'userOptions', 'maxTitle', 5, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (49, 'select', '1', 'admin_options_setup_defStyle', 'setup', 'defStyle', 2, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (50, 'text', '3', 'admin_options_userOptions_usernameMin', 'userOptions', 'usernameMin', 6, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (51, 'text', '20', 'admin_options_userOptions_usernameMax', 'userOptions', 'usernameMax', 7, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (52, 'checkbox', '1', 'admin_options_userOptions_coppa', 'userOptions', 'coppa', 4, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (53, 'text', '500', 'admin_options_userOptions_maxSig', 'userOptions', 'maxSig', 7, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (54, 'text', '100', 'admin_options_attachments_thumbHeight', 'attachments', 'thumbHeight', 2, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (55, 'text', '100', 'admin_options_attachments_thumbWidth', 'attachments', 'thumbWidth', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (56, 'checkbox', '1', 'admin_options_attachments_thumbnails', 'attachments', 'thumbnails', 1, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (57, 'text', 'The wtcBB Staff', 'admin_options_information_emailSig', 'information', 'emailSig', 3, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (58, 'textarea', 'fuck', 'admin_options_forumSettings_censor', 'forumSettings', 'censor', 5, NULL);
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (59, 'text', '*', 'admin_options_forumSettings_censorChar', 'forumSettings', 'censorChar', 6, NULL);
