-- 
-- Table structure for table `admins`
-- 

CREATE TABLE `admins` (
  `adminid` smallint(5) unsigned NOT NULL auto_increment,
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
  `announceid` smallint(5) unsigned NOT NULL auto_increment,
  `userid` mediumint(9) default NULL,
  `forumid` smallint(6) default NULL,
  `title` varchar(255) default NULL,
  `dateUpdated` int(11) default NULL,
  `dateStart` int(11) default NULL,
  `dateEnd` int(11) default NULL,
  `message` mediumtext,
  `parseBBCode` tinyint(1) default NULL,
  `parseSmilies` tinyint(1) default NULL,
  `parseHtml` tinyint(1) default NULL,
  `views` mediumint(9) default NULL,
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
  `storeid` smallint(5) unsigned NOT NULL auto_increment,
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
  `attachid` smallint(5) unsigned NOT NULL auto_increment,
  `pathName` varchar(255) default NULL,
  `fileName` varchar(255) default NULL,
  `hash` varchar(32) default NULL,
  `mime` varchar(255) default NULL,
  `fileSize` int(11) default NULL,
  `image` tinyint(1) default NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `threadid` smallint(5) unsigned NOT NULL default '0',
  `postid` smallint(5) unsigned NOT NULL default '0',
  `thumbFileName` varchar(255) default NULL,
  `downloads` mediumint(9) default '0',
  `convoid` mediumint(8) unsigned NOT NULL default '0',
  `messageid` mediumint(8) unsigned NOT NULL default '0',
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
  `avatarid` smallint(5) unsigned NOT NULL auto_increment,
  `groupid` smallint(6) default NULL,
  `title` varchar(255) default NULL,
  `imgPath` varchar(255) default NULL,
  `disOrder` smallint(6) default NULL,
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
  `bbcodeid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `tag` varchar(255) default NULL,
  `replacement` text,
  `example` text,
  `description` text,
  `display` tinyint(1) default NULL,
  `disOrder` smallint(6) NOT NULL default '99',
  PRIMARY KEY  (`bbcodeid`)
);

-- 
-- Dumping data for table `bbcode`
-- 

INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (1, 'Bold', 'b', '<strong>{param}</strong>', '[b]Bolded Text.[/b]', 'This will bold text.', 1, 1);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (2, 'Italic', 'i', '<em>{param}</em>', '[i]Italic text.[/i]', 'Makes text italic.', 1, 2);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (3, 'Underline', 'u', '<span class="underline">{param}</span>', '[u]Underlined text.[/u]', 'Underlines text.', 1, 3);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (4, 'Font Color', 'color', '<span style="color: {option};">{param}</span>', '[color=blue]This is blue text.[/color]', 'This will color text to the color specified.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (5, 'Link', 'url', '<a href="{param}">{param}</a>', '[url]http://wtcbb.com[/url]', 'This will provide a way to link to another web page.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (6, 'Advanced Link', 'url', '<a href="{option}">{param}</a>', '[url=http://wtcbb.com]wtcbb.com[/url]', 'Allows the ability to make a named link.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (7, 'Image', 'img', '<img src="{param}" alt="{param}" />', '[img]http://www.webtrickscentral.com/images/supportWTC.gif[/img]', 'This will allow the display of images.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (9, 'Align Left', 'left', '<div class="left">{param}</div>', '[left]Left aligned text![/left]', 'This will align text to the left.', 1, 4);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (10, 'Align to Right', 'right', '<div class="right">{param}</div>', '[right]Right aligned text![/right]', 'Aligns text to the right.', 1, 6);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (11, 'Align to Center', 'center', '<div class="center">{param}</div>', '[center]Center aligned text![/center]', 'Aligns text to the center.', 1, 5);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (12, 'Font Family', 'font', '<span style="font-family: ''{option}'';">{param}</span>', '[font=comic sans ms]Goofy font![/font]', 'This changes the font family of the specified text.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (13, 'Font Size', 'size', '<span style="font-size: {option}pt;">{param}</span>', '[size=22]Large Font Size![/size]', 'This changes the font size of the specified text.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (14, 'Quote', 'quote', '<div class="quote marCenter">\r\n  <p class="small">Quote:</p>\r\n  <div class="quoted alt1">\r\n    {param}\r\n  </div>\r\n</div>', '[quote]The unexamined life isn''t worth living.[/quote]', 'You can quote some text.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (15, 'Advanced Quote', 'quote', '<div class="quote marCenter">\r\n  <p class="small">Quote By: <strong>{option}</strong></p>\r\n  <div class="quoted alt1">\r\n    {param}\r\n  </div>\r\n</div>', '[quote=Socrates]The unexamined life isn''t worth living.[/quote]', 'Now you can identify who said the quote.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (16, 'Code', 'code', '<div class="quote marCenter">\r\n  <p class="small">Code:</p>\r\n  <div class="quoted alt1" style="font-family: ''courier new'';">\r\n    {param}\r\n  </div>\r\n</div>', '[code]This is some <html> code![/code]', 'A nice code formatting tag.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (17, 'PHP', 'php', '<div class="quote marCenter">\r\n  <p class="small">PHP:</p>\r\n  <div class="quoted alt1" style="font-family: ''courier new''; font-size: 120%;">\r\n    {param}\r\n  </div>\r\n</div>', '[php]Pretty-lookin PHP![/php]', 'Syntax highlighting for PHP code.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (18, 'Numbered List', 'ol', '<ol class="noMar">{param}</ol>', '[ol][!]List Item 1[/!][!]List Item 2[/!][!]List Item 3[/!][/ol]', 'This will allow you to make a numbered (ordered) list.', 1, 7);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (19, 'Bulleted List', 'ul', '<ul class="noMar">{param}</ul>', '[ul][!]List Item 1[/!][!]List Item 2[/!][!]List Item 3[/!][/ul]', 'This will allow you to make a bulleted (unordered) list.', 1, 7);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (20, 'List Item', '!', '<li class="smallMarBot">{param}</li>', '[ul][!]List Item[/!][/ul]', 'This is a list item which works in conjunction with the "ul" and "ol" BB Codes.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (21, 'Email', 'email', '<a href="mailto:{param}">{param}</a>', '[email]contact@wtcbb.com[/email]', 'Provides an easy way to link to an email address.', 1, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (22, 'Advanced Email', 'email', '<a href="mailto:{option}">{param}</a>', '[email=contact@wtcbb.com]Contact Me![/email]', 'Advanced email linking.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (23, 'Strike-Through', 'strike', '<span style="text-decoration: line-through;">{param}</span>', '[strike]Striked text.[/strike]', 'This will put a line through text.', 0, 99);
INSERT INTO `bbcode` (`bbcodeid`, `name`, `tag`, `replacement`, `example`, `description`, `display`, `disOrder`) VALUES (24, 'Me', 'me', '<span style="color: #730073; font-weight: bold;">* {poster} {param}</span>', '[me]loves wtcBB![/me]', 'A cheap imitation of IRC''s "/me"', 0, 99);

-- --------------------------------------------------------

-- 
-- Table structure for table `cron`
-- 

CREATE TABLE `cron` (
  `cronid` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `path` mediumtext,
  `log` tinyint(1) default NULL,
  `dayOfWeek` tinyint(6) default NULL,
  `dayOfMonth` tinyint(31) default NULL,
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
  `proid` smallint(5) unsigned NOT NULL auto_increment,
  `fieldName` varchar(255) default NULL,
  `fieldDesc` text,
  `fieldType` enum('text','select','multi-select','radio','checkbox','textarea') default NULL,
  `defValue` varchar(255) default NULL,
  `optionText` text,
  `groupid` smallint(6) default NULL,
  `disOrder` smallint(6) default '0',
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
  `faqid` smallint(5) unsigned NOT NULL auto_increment,
  `parent` varchar(255) default NULL,
  `varname` varchar(255) default NULL,
  `disOrder` smallint(6) default NULL,
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
  `permid` smallint(5) unsigned NOT NULL auto_increment,
  `forumid` smallint(6) default NULL,
  `usergroupid` mediumint(9) default NULL,
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
  `forumid` smallint(5) unsigned NOT NULL auto_increment,
  `depth` tinyint(255) default NULL,
  `name` varchar(255) default NULL,
  `parent` smallint(6) default NULL,
  `directSubs` mediumtext,
  `disOrder` smallint(6) default NULL,
  `link` varchar(255) default NULL,
  `linkCount` int(11) default NULL,
  `forumPass` varchar(255) default NULL,
  `isCat` tinyint(1) default NULL,
  `isAct` tinyint(1) default NULL,
  `countPosts` tinyint(1) default NULL,
  `viewAge` mediumint(9) default NULL,
  `dateMade` int(11) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` varchar(255) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_threadid` smallint(6) default NULL,
  `last_reply_threadtitle` varchar(255) default NULL,
  `posts` mediumint(9) default NULL,
  `threads` smallint(6) default NULL,
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
  `groupid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupName` varchar(255) default NULL,
  `groupType` varchar(255) default NULL,
  `usergroupids` mediumtext,
  `parentid` mediumint(9) NOT NULL default '-1',
  `deletable` tinyint(1) NOT NULL default '1',
  `groupOrder` smallint(6) default '0',
  PRIMARY KEY  (`groupid`)
);

-- 
-- Dumping data for table `groups`
-- 

INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (1, 'Admin wtcBB Options', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (2, 'Board Access', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (3, 'Information', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (4, 'Setup', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (5, 'Admin General', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (6, 'Admin Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (7, 'Admin Languages', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (8, 'Add Category', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (10, 'Add Words', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (11, 'Language Manager', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (12, 'Edit Words', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (15, 'Edit Category', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (16, 'Search', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (17, 'Admin Search', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (18, 'Admin Navigation', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (20, 'wtcBB Options', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (21, 'Language', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (22, 'Add/Edit Language', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (23, 'Import/Export', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (24, 'View Default', 'lang_words', NULL, 7, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (71, 'Usergroup Manager', 'lang_words', NULL, 69, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (35, 'Errors', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (34, 'Users', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (58, 'User Options', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (65, 'Show Threads', 'lang_words', NULL, 61, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (64, 'Global', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (63, 'Thread Settings', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (62, 'Date and Time', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (61, 'Dates', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (60, 'Add/Edit/Search User', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (59, 'Admin Users', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (66, 'Search Results', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (67, 'Users', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (68, 'Usergroups', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (69, 'Admin Usergroups', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (70, 'Add/Edit Usergroup', 'lang_words', NULL, 69, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (72, 'Administrative Permissions', 'lang_words', NULL, 69, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (73, 'Cookie Settings', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (74, 'Automation', 'lang_words', NULL, 69, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (75, 'wtcBB Cron System', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (76, 'Add / Edit', 'lang_words', NULL, 78, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (78, 'Admin Cron', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (79, 'Cron Manager', 'lang_words', NULL, 78, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (80, 'Ban User', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (81, 'Log', 'lang_words', NULL, 78, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (82, 'Prune/Move', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (83, 'Search IP Addresses', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (84, 'Merge', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (85, 'Mass Email', 'lang_words', NULL, 59, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (86, 'Forums', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (87, 'Admin Forums', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (88, 'Add/Edit Forum', 'lang_words', NULL, 87, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (89, 'Forum Manager', 'lang_words', NULL, 87, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (90, 'Moderators', 'lang_words', NULL, 87, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (91, 'Forum Blocking', 'lang_words', NULL, 87, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (92, 'Permissions', 'lang_words', NULL, 87, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (93, 'Announcements', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (94, 'Admin Announcements', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (95, 'Add/Edit Announcement', 'lang_words', NULL, 94, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (96, 'Announcements Manager', 'lang_words', NULL, 94, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (97, 'Logs', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (98, 'Admin Logs', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (99, 'Administrative', 'lang_words', NULL, 98, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (100, 'Cron', 'lang_words', NULL, 98, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (101, 'Moderator', 'lang_words', NULL, 98, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (102, 'File Actions', 'lang_words', NULL, 98, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (103, 'FAQ', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (104, 'User Ranks', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (105, 'Attachments', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (106, 'Admin Ranks', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (107, 'Add/Edit Ranks', 'lang_words', NULL, 106, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (108, 'Rank Manager', 'lang_words', NULL, 106, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (109, 'User Images', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (110, 'Admin Rank Images', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (111, 'Add/Edit Rank Images', 'lang_words', NULL, 110, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (112, 'Rank Images Manager', 'lang_words', NULL, 110, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (113, 'Admin Attachments', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (114, 'Add/Edit Extension', 'lang_words', NULL, 113, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (115, 'Extensions Manager', 'lang_words', NULL, 113, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (116, 'Attachment Storage Type', 'lang_words', NULL, 113, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (117, 'Admin FAQ', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (118, 'Add/Edit FAQ', 'lang_words', NULL, 117, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (119, 'FAQ Entries', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (120, 'FAQ Manager', 'lang_words', NULL, 117, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (121, 'Admin Smilies', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (122, 'Add/Edit Smilies', 'lang_words', NULL, 121, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (123, 'Smilies', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (124, 'Add Multiple Smilies', 'lang_words', NULL, 121, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (125, 'Admin Groups', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (126, 'Smiley Manager', 'lang_words', NULL, 121, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (127, 'Post Icons', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (128, 'Admin Post Icons', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (129, 'Add/Edit Post Icon', 'lang_words', NULL, 128, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (130, 'Add Multiple Post Icons', 'lang_words', NULL, 128, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (131, 'Post Icon Manager', 'lang_words', NULL, 128, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (132, 'Admin Avatars', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (133, 'Add/Edit Avatars', 'lang_words', NULL, 132, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (134, 'Avatar Manager', 'lang_words', NULL, 132, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (135, 'Add Multiple Avatars', 'lang_words', NULL, 132, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (136, 'Avatars', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (137, 'Maitenance', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (138, 'Admin Maintenance', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (139, 'Cache Manager', 'lang_words', NULL, 138, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (140, 'Execute Query', 'lang_words', NULL, 138, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (141, 'Update Counters', 'lang_words', NULL, 138, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (142, 'Style System', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (143, 'Admin Styles', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (144, 'Add/Edit Style', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (145, 'Style Manager', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (149, 'Default Smilies', 'smilies', 'a:1:{i:0;i:-1;}', -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (150, 'Default Avatars', 'avatar', 'a:1:{i:0;i:-1;}', -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (154, 'Admin Control Panel', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (156, 'Global', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (158, 'Templates', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (159, 'Template Manager', 'lang_words', NULL, 158, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (269, 'Member Profile', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (161, 'Add/Edit Template', 'lang_words', NULL, 158, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (162, 'View Default', 'lang_words', NULL, 158, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (186, 'Stylesheets', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (179, 'Colors & Style Options', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (180, 'Categories', 'lang_words', NULL, 179, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (181, 'Key', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (182, 'Visual Settings', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (183, 'Replacement Variables', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (185, 'Style Search', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (187, 'Forum Home List', 'styles_fragments', NULL, 189, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (188, 'Error', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (189, 'Forum Home', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (190, 'User Interface', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (191, 'Board Index', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (192, 'Login Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (193, 'Thanks', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (194, 'Thanks Redirect', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (195, 'Who''s Online Details', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (196, 'Forum Home Settings', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (197, 'Forum Settings', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (198, 'Who''s Online', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (199, 'Who''s Online', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (200, 'Robots', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (201, 'Permission Error', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (202, 'Forum Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (203, 'Forum', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (204, 'Forum Display', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (205, 'Forum Display', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (206, 'Forum Display List', 'styles_fragments', NULL, 204, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (207, 'Post Message', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (208, 'Message Interface', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (209, 'Message Interface', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (210, 'Smiley', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (211, 'Post Icon', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (212, 'Thread Display', 'styles_fragments', NULL, 241, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (213, 'Moderators', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (214, 'Navigation', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (215, 'Navigation', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (216, 'Thread Display', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (217, 'BB Code', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (218, 'Admin BB Code', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (219, 'BB Code Manager', 'lang_words', NULL, 218, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (220, 'Add/Edit BB Code', 'lang_words', NULL, 218, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (221, 'Parse BB Code', 'lang_words', NULL, 218, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (222, 'BB Code', 'styles_fragments', NULL, 207, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (223, 'Color Names', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (224, 'Fonts', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (225, 'Posting Options', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (226, 'Message Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (227, 'Image Names', 'lang_words', NULL, 143, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (228, 'Page Numbers', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (229, 'Update Information', 'lang_words', NULL, 138, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (230, 'User Status', 'styles_fragments', NULL, 156, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (231, 'Moving Types', 'lang_words', NULL, 216, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (232, 'Forum Select', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (233, 'Splitting Thread', 'lang_words', NULL, 216, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (234, 'Merge Thread', 'lang_words', NULL, 216, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (236, 'Attachments', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (237, 'Attachment Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (238, 'Upload Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (239, 'Announcement Display', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (240, 'Announcement Display', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (241, 'Thread', 'styles_fragments', NULL, 203, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (242, 'Poll Management', 'styles_fragments', NULL, 241, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (243, 'Poll Management', 'lang_words', NULL, 216, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (244, 'Searching', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (245, 'Searching', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (246, 'Searching Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (247, 'User CP', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (248, 'User Control Panel', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (249, 'User CP Profile', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (250, 'User CP Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (251, 'User CP Preferences', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (252, 'Registration', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (253, 'Registration', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (254, 'Registration Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (255, 'User CP Email', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (256, 'User CP Password', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (257, 'User CP Avatar', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (258, 'User CP Signature', 'lang_words', NULL, 247, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (260, 'Personal Messages', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (261, 'Send Message', 'lang_words', NULL, 260, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (262, 'View Messages', 'lang_words', NULL, 260, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (263, 'Personal Messages', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (264, 'Personal Messaging Errors', 'lang_words', NULL, 35, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (265, 'Folders', 'lang_words', NULL, 260, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (266, 'Member List', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (267, 'Member''s List', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (268, 'Member Profile', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (270, 'Send Email', 'lang_words', NULL, 190, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (271, 'Send Email', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (273, 'Attachments', 'lang_words', NULL, 1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (274, 'Email', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (275, 'Report Post Bits', 'lang_words', NULL, 274, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (276, 'Custom Profile Fields', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (277, 'Admin Profile Fields', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (278, 'Add/Edit Profile Fields', 'lang_words', NULL, 277, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (279, 'Profile Field Manager', 'lang_words', NULL, 277, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (280, 'Field Types', 'lang_words', NULL, 277, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (284, 'Instant Messengers', 'custom_pro', NULL, -1, 1, 1);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (287, 'Profile Field HTML', 'styles_fragments', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (288, 'Threads/Posts', 'lang_words', NULL, 18, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (290, 'Admin Threads/Posts', 'lang_words', NULL, 154, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (291, 'Mass Move', 'lang_words', NULL, 290, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (292, 'Mass Prune Threads', 'lang_words', NULL, 290, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (293, 'Mass Prune Posts', 'lang_words', NULL, 290, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (294, 'Installation', 'lang_words', NULL, -1, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (295, 'Step 1', 'lang_words', NULL, 294, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (296, 'Step 2', 'lang_words', NULL, 294, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (297, 'Step 3', 'lang_words', NULL, 294, 1, 0);
INSERT INTO `groups` (`groupid`, `groupName`, `groupType`, `usergroupids`, `parentid`, `deletable`, `groupOrder`) VALUES (298, 'Errors', 'lang_words', NULL, 294, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `lang`
-- 

CREATE TABLE `lang` (
  `langid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`langid`)
);

-- 
-- Dumping data for table `lang`
-- 

INSERT INTO `lang` (`langid`, `name`) VALUES (1, 'English');

-- --------------------------------------------------------

-- 
-- Table structure for table `lang_categories`
-- 

CREATE TABLE `lang_categories` (
  `catid` mediumint(8) unsigned NOT NULL auto_increment,
  `catName` varchar(255) default NULL,
  `depth` tinyint(255) default NULL,
  `parentid` mediumint(9) default NULL,
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
  `wordsid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` text,
  `words` text,
  `langid` smallint(5) NOT NULL default '0',
  `catid` mediumint(8) unsigned NOT NULL default '0',
  `displayName` varchar(255) default NULL,
  `defaultid` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`wordsid`),
  KEY `langid` (`langid`),
  KEY `catid` (`catid`),
  KEY `defaultid` (`defaultid`)
);

-- 
-- Dumping data for table `lang_words`
-- 

INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1, 'admin_title', 'wtcBB Admin Panel', 0, 5, 'Main Admin Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2, 'admin_nav_title', 'Administrative Navigation Panel', 0, 5, 'Navigation Page Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (3, 'admin_options_boardAccess_floodcheck', 'Floodcheck (seconds)', 0, 2, 'Floodcheck Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (4, 'admin_options_boardAccess_floodcheck_desc', 'This will allow you to set a "Flood Check" sort of speak. It will take effect globally, and anyone trying to perform an action under the given amount of time, will be given an error. Actions include posting, personal messaging, emailing, etc.', 0, 2, 'Floodcheck Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (5, 'admin_error_title', 'There Was an Error in Your Request', 0, 5, 'Error Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (6, 'admin_error_invalidPage', 'Sorry, the page you are trying to view does not exist.', 0, 6, 'Invalid Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (7, 'admin_goBack', 'Go Back.', 0, 5, 'Go Back', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (8, 'admin_error_note', 'If you were processing a request, and filled out a significant amount of data, you may press the "Back" button on your web browser, and attempt to regain information you had type in. If not, you may click the link below.', 0, 6, 'Error Note', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (9, 'admin_options_boardAccess', 'Board Access', 0, 2, 'Board Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (10, 'admin_save', 'Submit', 0, 5, 'Submit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (11, 'admin_reset', 'Reset', 0, 5, 'Reset', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (12, 'admin_enable', 'Enable', 0, 5, 'Enable', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (13, 'admin_thanks_msg', 'Thank you for your request. Your information has been processed.', 0, 5, 'Thanks Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (14, 'admin_thanks_title', 'Thanks', 0, 5, 'Thanks Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (15, 'admin_redirection', 'Click Here If You Are Not Redirected', 0, 5, 'Click If Not Redirected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (16, 'admin_options_information_boardName', 'Board Name Title:', 0, 3, 'Board Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (17, 'admin_options_information_boardName_desc', 'Put the name of your message board here.', 0, 3, 'Board Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (18, 'admin_options_information', 'Information', 0, 3, 'Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (19, 'admin_options_setup_forumJump', 'Use Forum Jump?', 0, 4, 'Forum Jump', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (20, 'admin_options_setup_forumJump_desc', 'Selecting yes here will enable the forum jump on all pages, which will display a drop down menu with links to every forum. On boards with a large amount of forums, it could slow down performance due to the amount of HTML produced.', 0, 4, 'Forum Jump Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (21, 'admin_options_setup', 'Setup', 0, 4, 'Setup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (22, 'admin_options_all', 'Options', 0, 1, 'All Options Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (23, 'admin_language_addCat_title', 'Add Language Category', 0, 8, 'Add Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (24, 'admin_language_addCat_catName', 'Category Name:', 0, 8, 'Category Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (25, 'admin_language_addCat_catName_desc', 'This is the title of the language category. This is for structural and sorting purposes.', 0, 8, 'Add Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (26, 'admin_language_addCat_lang', 'Language:', 0, 8, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (27, 'admin_language_addCat_lang_desc', 'Select the language set that this category will belong to.', 0, 8, 'Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (28, 'admin_language_addCat_parent', 'Parent Category:', 0, 8, 'Parent Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (29, 'admin_language_addCat_parent_desc', 'This is the parent category of this category. You may make this a top level category by selecting "No Parent".', 0, 8, 'Parent Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (30, 'admin_language_addWords_display', 'Display Name:', 0, 10, 'Display Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (31, 'admin_language_addWords_display_desc', 'This is the display name of these words. This is for structural purposes only.', 0, 10, 'Display Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (32, 'admin_language_addWords_var', 'Variable Name:', 0, 10, 'Variable Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (33, 'admin_language_addWords_var_desc', 'This is the variable name of these words. This variable name is used to access these words via the scripting backend. Make sure you use good naming conventions.', 0, 10, 'Variable Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (34, 'admin_language_addWords_lang', 'Language:', 0, 10, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (35, 'admin_language_addWords_lang_desc', 'This is the language group that these words will belong to.', 0, 10, 'Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (36, 'admin_language_addWords_cat', 'Language Category:', 0, 10, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (37, 'admin_language_addWords_cat_desc', 'This is the category that these words will belong too. This is for structural purposes only.', 0, 10, 'Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (38, 'admin_language_addWords_title', 'Add Words', 0, 10, 'Add Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (39, 'admin_language_addWords_words', 'Words:', 0, 10, 'Words Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (40, 'admin_language_addWords_words_desc', 'This is where you may enter the words to be used.', 0, 10, 'Words Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (41, 'admin_error_duplicateVarName', 'Sorry, but you cannot have duplicate variable names.', 0, 6, 'Duplicate Var Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (43, 'admin_language_manager_title', 'Language Manager', 0, 11, 'Manager Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (44, 'admin_edit', 'Edit', 0, 5, 'Edit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (45, 'admin_delete', 'Delete', 0, 5, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (48, 'admin_language_editWords_title', 'Edit Word:', 0, 12, 'Edit Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (49, 'admin_delete_areYouSure', 'Are you sure you want to delete?', 0, 5, 'Are You Sure Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (50, 'admin_yes', 'Yes', 0, 5, 'Yes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (51, 'admin_no', 'No', 0, 5, 'No', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (56, 'admin_language_editCat_title', 'Edit Category:', 0, 15, 'Edit Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (57, 'admin_add', 'Add', 0, 5, 'Add', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (58, 'admin_language_search_searchIn', 'Search In:', 0, 16, 'Search In', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (59, 'admin_language_search_searchIn_desc', 'This will allow you to chose where this will search with the query given below.', 0, 16, 'Search In Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (60, 'admin_language_search_query', 'Search Query:', 0, 16, 'Search Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (61, 'admin_language_search_query_desc', 'You may enter here what you want to search for.', 0, 16, 'Search Query Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (62, 'admin_search_language', 'Search Languages', 0, 16, 'Languages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (63, 'admin_language_search_lang', 'Language:', 0, 16, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (64, 'admin_language_search_lang_desc', 'Please chose the language set you would like to search.', 0, 16, 'Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (65, 'admin_error_noResults', 'Sorry, there were no results found with the given information.', 0, 6, 'No Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (66, 'admin_search_submit', 'Search', 0, 5, 'Submit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (67, 'admin_manage', 'Manage', 0, 5, 'Manage', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (68, 'admin_language_manager_add', 'Add Language', 0, 11, 'Add', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (69, 'admin_language_manager_lang', 'Language:', 0, 11, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (71, 'admin_error_deleteDefault', 'Sorry, you cannot delete a default word.', 0, 6, 'Can''t Delete Default Word', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (79, 'admin_nav_wtcBBOpt_allOpt', 'All Options', 0, 20, 'All Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (78, 'admin_nav_wtcBBOpt_title', 'wtcBB Options', 0, 20, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (80, 'admin_nav_wtcBBOpt_boardAccess', 'Board Access', 0, 20, 'Board Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (81, 'admin_nav_wtcBBOpt_information', 'Information', 0, 20, 'Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (82, 'admin_nav_wtcBBOpt_setup', 'Setup', 0, 20, 'Setup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (84, 'admin_nav_lang_title', 'Language', 0, 21, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (85, 'admin_nav_lang_langMan', 'Language Manager', 0, 21, 'Language Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (86, 'admin_nav_lang_searchWords', 'Search Words', 0, 21, 'Search Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (87, 'admin_nav_lang_addCat', 'Add Category', 0, 21, 'Add Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (88, 'admin_nav_lang_addWords', 'Add Words', 0, 21, 'Add Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (89, 'admin_nav_lang_addLang', 'Add Language', 0, 21, 'Add Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (90, 'admin_options_information_defLang', 'Default Language:', 0, 4, 'Default Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (91, 'admin_options_information_defLang_desc', 'This is the default language used on the bulletin board. All guests will see this language, but users (if given the permission) will be able to override this, and select a different language if others are added.', 0, 4, 'Default Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (92, 'admin_nav_expandAll', 'Expand All', 0, 18, 'Expand All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (93, 'admin_nav_collapseAll', 'Collapse All', 0, 18, 'Collapse All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (94, 'admin_nav_savePrefs', 'Save Preferences', 0, 18, 'Save Preferences', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (95, 'admin_language_add', 'Add Language', 0, 22, 'Add Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (96, 'admin_language_addLang_langName', 'Language Name:', 0, 22, 'Language Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (97, 'admin_language_addLang_langName_desc', 'You may enter the name of the new language you want to add here.', 0, 22, 'Language Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (101, 'admin_error_leaveOneLangLeft', 'Sorry, but you must have at least one language installed in order for wtcBB to run correctly.', 0, 6, 'Last Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (108, 'admin_language_imEx_title', 'Import/Export Languages', 0, 23, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (109, 'admin_language_imEx_import', 'Import', 0, 23, 'Import', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (110, 'admin_language_imEx_export', 'Export', 0, 23, 'Export', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (111, 'admin_language_imEx_category', 'Category:', 0, 23, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (112, 'admin_language_imEx_category_desc', 'You may export a certain set of words by selecting their category here. You may export all words by selecting "Whole Language." It will also include their child categories as well. You may select multiple categories by holding down the "ctrl" button on your keyboard, and clicking on the desired categories. <strong>Note:</strong> You cannot select only sub-categories, as it is not a gurantee that wherever this data is imported, that there will be a parent category with a correct ID.', 0, 23, 'Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (113, 'admin_export', 'Export', 0, 5, 'Export', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (114, 'admin_import', 'Import', 0, 5, 'Import', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (115, 'admin_download', 'Download?', 0, 5, 'Download', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (116, 'admin_download_desc', 'If you choose to download, you will be able to save the XML (a type of file, in which information can be transported) file to your computer. If you choose not to download, then the XML file will automatically be stored in the <strong>exports</strong> directory, located inside the root folder of your wtcBB installation.', 0, 5, 'Download Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (119, 'admin_viewDefault', 'View Default', 0, 5, 'View Default', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (123, 'admin_error_notEnoughInfo', 'Sorry, but you must supply more information in order to complete your request.', 0, 6, 'Not Enough Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (121, 'admin_language_viewDef', 'View Default Word', 0, 24, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (124, 'admin_language_imEx_lang', 'Language:', 0, 23, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (125, 'admin_language_imEx_lang_desc', 'Please select the language that you would like to export from.', 0, 23, 'Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (126, 'admin_error_noCustomWords', 'Sorry, but you have no custom words to export in the selected language set.', 0, 6, 'No Custom Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (166, 'admin_nav_users_mergeUsers', 'Merge Users', 0, 34, 'Merge Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (128, 'admin_error_fileOpen', 'Sorry, but in an attempt to open, read, or write to a file, wtcBB failed. Most commonly, this is due to insufficient privileges on *nix systems. Please make sure that you have chmodded the files/directories in question to either 755 or 777.', 0, 6, 'File Open/Create', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (130, 'admin_language_imEx_filePath', 'File Path to XML File: OR...', 0, 23, 'File Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (131, 'admin_language_imEx_filePath_desc', 'You may enter the file path of the language XML file you would like to import. Please note that this is not a URL, it is a file path. You may also upload an XML below.', 0, 23, 'File Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (132, 'admin_language_imEx_upload', 'Upload XML File:', 0, 23, 'Upload', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (133, 'admin_language_imEx_upload_desc', 'You may upload any XML file on your computer with this field', 0, 23, 'Upload Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (135, 'admin_language_imEx_newLang', 'New Language or Overwrite?', 0, 23, 'New Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (136, 'admin_language_imEx_newLang_desc', 'You may select to create a new language set with the given XML file. You can also overwrite an existing language set (only words and categories in the XML file that match up with words and categories in the selected language set will be overwritten). If you chose to overwrite, I highly suggest you take a current backup (if you''ve made any changes) to the language set you''re overwriting, so you can restore it if things go awry.', 0, 23, 'New Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (137, 'admin_language_imEx_langTitle', 'New Language Title:', 0, 23, 'Language Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (138, 'admin_language_imEx_langTitle_desc', 'If you have chosen "Create New Language" in the above option, you may enter the name of the new language set here.', 0, 23, 'Language Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (165, 'admin_nav_users_search', 'Search Users', 0, 34, 'Search Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (164, 'admin_nav_users_addUser', 'Add User', 0, 34, 'Add User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (163, 'admin_nav_users_title', 'Users', 0, 34, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (167, 'admin_nav_users_pruneMove', 'Prune/Move Users', 0, 34, 'Prune/Move Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (168, 'admin_nav_users_banUser', 'Ban User', 0, 34, 'Ban User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (169, 'admin_nav_users_viewBannedUsers', 'View Banned Users', 0, 34, 'View Banned Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (170, 'admin_nav_users_searchIp', 'Search IP Addresses', 0, 34, 'Search IP Addresses', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (171, 'admin_nav_users_massEmail', 'Mass Email', 0, 34, 'Mass Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (172, 'error_noUsernameOrId', 'Sorry, but no user id or username were supplied. Information could not be gathered.', 0, 35, 'No Username or Id', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (310, 'admin_language_manager_key', 'Key', 0, 11, 'Manager Key', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (182, 'error_userDoesNotExist', 'Sorry, but the specified user does not exist.', 0, 35, 'User Doesn''t Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (308, 'admin_nav_lang_im', 'Import', 0, 21, 'Import', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (309, 'admin_nav_lang_ex', 'Export', 0, 21, 'Export', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (307, 'admin_language_manager_key_blue', 'Blue - Default Word', 0, 11, 'Manager Key Blue', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (311, 'admin_language_manager_key_red', 'Red - Customized Word', 0, 11, 'Manager Key Red', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (312, 'admin_options_userOptions', 'User Options', 0, 58, 'User Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (313, 'admin_nav_wtcBBOpt_userOptions', 'User Options', 0, 20, 'User Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (314, 'admin_options_userOptions_verifyEmail', 'Verify Email Address?', 0, 58, 'Verify Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (315, 'admin_options_userOptions_verifyEmail_desc', 'When this option is enabled, users will be kept in the "Awaiting Activation"  usergroup until they have verified their email address by clicking on a link in an automatically generated email sent by wtcBB.', 0, 58, 'Verify Email Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2043, 'admin_options_userOptions_usernameMax', 'Maximum Character Count for Username:', 0, 58, 'Username Max Char', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (316, 'admin_options_userOptions_uniqueEmail', 'Require Unique Email Address?', 0, 58, 'Unique Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (317, 'admin_options_userOptions_uniqueEmail_desc', 'When this is enabled, new registrants will be forced to enter a unique email address. When this is disabled, multiple user accounts will be permitted to have the same email address.', 0, 58, 'Unique Email Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (318, 'admin_options_userOptions_newReg', 'Allow New Registrations?', 0, 58, 'New Registrations', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (319, 'admin_options_userOptions_newReg_desc', 'Disabling this option will disallow any new registrations from being made in your community.', 0, 58, 'New Registrations Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (321, 'admin_users_add_title', 'Add User', 0, 60, 'Add User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (322, 'admin_users_edit_title', 'Edit User', 0, 60, 'Edit User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (323, 'admin_users_ae_username', 'Username:', 0, 60, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (324, 'admin_users_ae_username_desc', 'This is the username by which a user will be referenced by the bulletin board system.', 0, 60, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (325, 'admin_users_ae_required', 'Required Fields', 0, 60, 'Required Fields', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (326, 'admin_users_ae_password', 'Password:', 0, 60, 'Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (327, 'admin_users_ae_password_desc', 'This is the password that this user will need to know in order to login to their account and post. Passwords are hashed before they enter the database.', 0, 60, 'Password Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (328, 'admin_users_ae_email', 'Email Address:', 0, 60, 'Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (329, 'admin_users_ae_email_desc', 'This is the email address by which this user is to receive administrative, subscription, and notification emails.', 0, 60, 'Email Address Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (330, 'admin_users_ae_usergroup', 'Primary Usergroup:', 0, 60, 'Primary Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (331, 'admin_users_ae_usergroup_desc', 'This is the primary usergroup in which this user will belong. Remember, if a permission is enabled in any of the usergroups a user is in (including secondary), that "Yes" takes precedence (even if 4 out of the 5 usergroups a user is in has that permission disabled).', 0, 60, 'Primary Usergroup Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (332, 'admin_users_ae_adminOpt', 'Administrative Options', 0, 60, 'Administrative Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (333, 'admin_users_ae_usertitle', 'User Title:', 0, 60, 'User Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (335, 'admin_users_ae_usertitleOpt', 'User Title Option:', 0, 60, 'User Title Option', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (334, 'admin_users_ae_usertitle_desc', 'This is the user''s user title. And will appear under the user''s username (in the default postbit template).', 0, 60, 'User Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (336, 'admin_users_ae_usertitleOpt_desc', 'You can control whether or not to force this user title to override this user''s usergroup''s title, or a default user title assigned by post count (controlled in the "User Titles" section of the admin control panel). Selecting "Inherit User Title" will then use this user''s usergroup''s user title, and if the usergroup does not have a title designated, then it will revert to a title assigned by post count. If you select one of the "Force User Title" options, this will force the user title entered here.', 0, 60, 'User Title Option Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (337, 'admin_users_ae_usertitleOpt_no', 'Inherit User Title', 0, 60, 'User Title Option: "No"', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (338, 'admin_users_ae_usertitleOpt_yes', 'Force User Title', 0, 60, 'User Title Option: "Yes"', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (339, 'admin_users_ae_usertitleOpt_yesNoHtml', 'Force User Title, No HTML', 0, 60, 'User Title Option: "No HTML"', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (340, 'admin_users_ae_htmlBegin', 'Username HTML Begin:', 0, 60, 'Username HTML Begin', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (341, 'admin_users_ae_htmlBegin_desc', 'This is the HTML that will come before a user''s username when displayed on the message board. This will override username markup specified by the usergroup that this user belongs to.', 0, 60, 'Username HTML Begin Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (342, 'admin_users_ae_htmlEnd', 'Username HTML End:', 0, 60, 'Username HTML End', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (343, 'admin_users_ae_htmlEnd_desc', 'This is the HTML that will come after a user''s username when displayed on the message board.  This will override username markup specified by the usergroup that this user belongs to.', 0, 60, 'Username HTML End Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (344, 'admin_users_ae_coppaOpt', 'Coppa Options', 0, 60, 'Coppa Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (345, 'admin_users_ae_parentEmail', 'Parent/Guardian Email Address:', 0, 60, 'Parent Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (346, 'admin_users_ae_parentEmail_desc', 'This is the parent/guardian''s email address for this user. All email sent to this user, will also be sent to this user''s parent. This email address is also used to verify a parent''s permission for children under the age of 13, in order to register.', 0, 60, 'Parent Email Address Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (347, 'admin_users_ae_coppa', 'Is COPPA User?', 0, 60, 'Coppa User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (348, 'admin_users_ae_coppa_desc', 'When a user is designated as a "COPPA User," the respecting user will be unable to post, receive emails, and their profiles will be blocked from other members. When a COPPA user registers, this option will be enabled until a parent verifies their registration. This has nothing to do with the "COPPA Usergroup."', 0, 60, 'Coppa User Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (349, 'admin_users_ae_warn', 'Warning Level:', 0, 60, 'Warning Level', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (350, 'admin_users_ae_warn_desc', 'This is the warning level of the user. It is highly recommended that you do not change the warning level here, as it will not reflect in the warning system logs, and thus the warning level will either be more or less than it should be.', 0, 60, 'Warning Level Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (351, 'admin_users_ae_timeOpt', 'Time Options', 0, 60, 'Time Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (352, 'admin_users_ae_dst', 'Enable DST?', 0, 60, 'Enable DST', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (353, 'admin_users_ae_dst_description', 'This will enable Daylight Savings Time for this user. (Pushes all times forward one hour.)', 0, 60, 'Enable DST Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (354, 'admin_users_ae_timeZone', 'Time Zone:', 0, 60, 'Time Zone', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (355, 'admin_users_ae_timeZone_desc', 'Select the time zone that this user is in. The current time in each time zone is listed next to it.', 0, 60, 'Time Zone Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (356, 'dates_today', 'Today', 0, 61, 'Today', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (357, 'dates_yesterday', 'Yesterday', 0, 61, 'Yesterday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (358, 'dates_tomorrow', 'Tomorrow', 0, 61, 'Tomorrow', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (359, 'dates_gmt', 'GMT', 0, 61, 'GMT', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (360, 'admin_options_dateTime_date', 'Date Format:', 0, 62, 'Date Format', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (361, 'admin_options_dateTime_date_desc', 'This is the format in which the date will be presented on all wtcBB pages. It uses the PHP <a href="http://www.php.net/date">Date</a> function format.', 0, 62, 'Date Format Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (362, 'admin_options_dateTime_time', 'Time Format:', 0, 62, 'Time Format', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (363, 'admin_options_dateTime_time_desc', 'This is the format in which the time will be presented on all wtcBB pages. It uses the PHP <a href="http://www.php.net/date">Date</a> function format.', 0, 62, 'Time Format Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (364, 'admin_options_dateTime', 'Date and Time Options', 0, 62, 'Date and Time', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (365, 'admin_nav_wtcBBOpt_dateTime', 'Date and Time Options', 0, 20, 'Date and Time', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (366, 'admin_options_dateTime_timezone', 'Default Time Zone:', 0, 62, 'Default Time Zone', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (367, 'admin_options_dateTime_timezone_desc', 'This is the default time zone offset set for the message board. Members will be able to override this in their preferences.', 0, 62, 'Default Time Zone Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (368, 'admin_options_dateTime_dst', 'Enable DST?', 0, 62, 'Enable DST', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (369, 'admin_options_dateTime_dst_desc', 'This is the default DST (Daylight Savings Time) setting for the message board. Users will be able to override this in their preferences. Enabling this will push all times on the forum ahead one hour.', 0, 62, 'Enable DST Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (370, 'dates_january', 'January', 0, 61, 'January', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (371, 'dates_february', 'February', 0, 61, 'February', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (372, 'dates_march', 'March', 0, 61, 'March', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (373, 'dates_april', 'April', 0, 61, 'April', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (374, 'dates_may', 'May', 0, 61, 'May', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (375, 'dates_june', 'June', 0, 61, 'June', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (376, 'dates_july', 'July', 0, 61, 'July', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (377, 'dates_august', 'August', 0, 61, 'August', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (378, 'dates_september', 'September', 0, 61, 'September', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (379, 'dates_october', 'October', 0, 61, 'October', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (380, 'dates_november', 'November', 0, 61, 'November', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (381, 'dates_december', 'December', 0, 61, 'December', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (382, 'admin_users_ae_joined', 'Join Date:', 0, 60, 'Join Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (383, 'admin_users_ae_joined_desc', 'This is the join date of this user. You may override it.', 0, 60, 'Join Date Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (384, 'dates_month', 'Month', 0, 61, 'Month', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (385, 'dates_day', 'Day', 0, 61, 'Day', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (386, 'dates_year', 'Year', 0, 61, 'Year', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (387, 'dates_hour', 'Hour', 0, 61, 'Hour', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (388, 'dates_minute', 'Minute', 0, 61, 'Minute', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (389, 'dates_pm', 'PM', 0, 61, 'PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (390, 'dates_am', 'AM', 0, 61, 'AM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (391, 'dates_ampm', 'AM/PM', 0, 61, 'AM/PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (392, 'admin_users_ae_lastvisit', 'Last Visit:', 0, 60, 'Last Visit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (393, 'admin_users_ae_lastvisit_desc', 'You may alter this user''s date and time of their last visit to the forum.', 0, 60, 'Last Visit Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (394, 'admin_users_ae_lastactivity', 'Last Activity:', 0, 60, 'Last Activity', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (395, 'admin_users_ae_lastactivity_desc', 'You may alter this user''s date and time of their last activity to the forum.', 0, 60, 'Last Activity Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (396, 'admin_users_ae_lastpost_desc', 'You may alter this user''s date and time of their last post on the forum.', 0, 60, 'Last Post Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (397, 'admin_users_ae_lastpost', 'Last Post:', 0, 60, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (398, 'admin_users_ae_birthday', 'Birthday:', 0, 60, 'Birthday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (399, 'admin_users_ae_biography', 'Biography:', 0, 60, 'Biography', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (400, 'admin_users_ae_occupation', 'Occupation:', 0, 60, 'Occupation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (401, 'admin_users_ae_interests', 'Interests:', 0, 60, 'Interests', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (402, 'admin_users_ae_location', 'Location:', 0, 60, 'Location', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (403, 'admin_users_ae_aim', 'AOL Instant Messenger Handle:', 0, 60, 'AIM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (404, 'admin_users_ae_msn', 'MSN Messenger Handle:', 0, 60, 'MSN', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (405, 'admin_users_ae_icq', 'ICQ Number:', 0, 60, 'ICQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (406, 'admin_users_ae_yahoo', 'Yahoo Messenger Handle:', 0, 60, 'Yahoo', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (407, 'admin_users_ae_homepage', 'Homepage:', 0, 60, 'Homepage', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (408, 'admin_users_ae_profileFields', 'Profile Fields', 0, 60, 'Profile Fields', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (409, 'admin_users_ae_posts', 'Post Count:', 0, 60, 'Post Count', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (410, 'admin_users_ae_threads', 'Thread Count:', 0, 60, 'Thread Count', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (411, 'admin_users_ae_ip', 'IP Address:', 0, 60, 'IP Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (412, 'admin_users_ae_ip_desc', 'This is the most recently logged IP address this user logged in under.', 0, 60, 'IP Address Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (413, 'admin_users_ae_referrer', 'Referrer:', 0, 60, 'Referrer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (414, 'admin_users_ae_referrer_desc', 'This is the username of the user who referred this user to your community.', 0, 60, 'Referrer Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (415, 'admin_users_ae_referrals', 'Referrals:', 0, 60, 'Referrals', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (416, 'admin_users_ae_referrals_desc', 'This is the number of users this user has referred to your community.', 0, 60, 'Referrals Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (417, 'admin_users_ae_sig', 'Signature:', 0, 60, 'Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (418, 'admin_users_ae_sig_desc', 'A user''s signature consists of text and/or images, of which will appear below each post.', 0, 60, 'Signature Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (419, 'admin_users_ae_defMessageText', 'Default Message Text', 0, 60, 'Default Message Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (420, 'admin_users_ae_defFont', 'Default Font:', 0, 60, 'Default Font', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (421, 'admin_users_ae_defFont_desc', 'This is the default font that messages posted by this user will appear in, if this feature is enabled by both the administrator and the user.', 0, 60, 'Default Font Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (422, 'admin_users_ae_defColor', 'Default Color:', 0, 60, 'Default Color', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (423, 'admin_users_ae_defColor_desc', 'This is the default color of text that messages posted by this user will appear in, if this feature is enabled by both the administrator and the user.', 0, 60, 'Default Color Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (424, 'admin_users_ae_defSize', 'Default Font Size:', 0, 60, 'Default Font Size', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (425, 'admin_users_ae_defSize_desc', 'This is the default font size that messages posted by this user will appear in, if this feature is enabled by both the administrator and the user.', 0, 60, 'Default Font Size Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (426, 'admin_options_threadSettings', 'Thread Settings', 0, 63, 'Thread Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (427, 'admin_options_threadSettings_settablePostsPerPage', 'User Settable Posts Per Page:', 0, 63, 'User Settable Posts Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (428, 'admin_options_threadSettings_settablePostsPerPage_desc', 'This will allow you to limit what users can set for how many posts are displayed per page inside of each thread. As the higher the number a user choses, the more resources are used. Separate each amount by a space.', 0, 63, 'User Settable Posts Per Page Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (429, 'admin_options_threadSettings_postsPerPage', 'Default Posts Per Page:', 0, 63, 'Default Posts Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (430, 'admin_options_threadSettings_postsPerPage_desc', 'This will allow you to set the default amount of posts shown per page in each thread. This will apply to guests, and users who have not changed this preference in their User Control Panel.', 0, 63, 'Default Posts Per Page Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (431, 'admin_options_threadSettings_browsingThread', 'Show Users Browsing Current Thread:', 0, 63, 'Show Users Browsing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (432, 'admin_options_threadSettings_browsingThread_desc', 'When this option is enabled, a box will appear at the bottom of each thread that will display the users who are currently viewing that thread. <strong>Note:</strong> This can be quite server intensive if there are many simultaneous users.', 0, 63, 'Show Users Browsing Thread Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1548, 'admin_options_forumSettings', 'Forum Settings', 0, 197, 'Forum Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1549, 'admin_nav_wtcBBOpt_forumSettings', 'Forum Settings', 0, 20, 'Forum Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1550, 'user_online', 'Viewing Who''s Online', 0, 195, 'Who''s Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (435, 'admin_nav_wtcBBOpt_threadSettings', 'Thread Settings', 0, 63, 'Thread Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (436, 'admin_users_ae_toolbar', 'Enable Toolbar?', 0, 60, 'Toolbar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (437, 'admin_users_ae_preferences', 'Preferences', 0, 60, 'Preferences', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (438, 'admin_users_ae_toolbar_desc', 'This will enable a javascript toolbar when this user is posting a message on the bulletin board. The toolbar consists of quick and easy access to BB Code (allows you to format text in messages, without HTML), so you don''t have to memorize it. If this user doesn''t have javascript enabled, or doesn''t use a javascript enabled browser, it is recommended that this option be disabled.', 0, 60, 'Toolbar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (439, 'admin_users_ae_displayOrder', 'Post Display Order:', 0, 60, 'Post Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (440, 'admin_users_ae_displayOrder_desc', 'This controls the order in which posts are displayed for this user in any given thread. The conventional order is "Oldest First."', 0, 60, 'Post Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (441, 'admin_users_ae_displayOrder_desce', 'Newest First', 0, 60, 'Post Display Order "Newest First"', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (442, 'admin_users_ae_displayOrder_asc', 'Oldest First', 0, 60, 'Post Display Order "Oldest First"', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (443, 'global_useForumDefault', 'Use Forum Default', 0, 64, 'Use Forum Default', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (444, 'dates_showThread_oneDay', 'Show Threads From the Last Day', 0, 65, 'One Day', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (445, 'dates_showThread_twoDays', 'Show Threads From the Last Two Days', 0, 65, 'Two Days', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (446, 'dates_showThread_oneWeek', 'Show Threads From the Last Week', 0, 65, 'One Week', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (447, 'dates_showThread_twoWeeks', 'Show Threads From the Last Two Weeks', 0, 65, 'Two Weeks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (448, 'dates_showThread_oneMonth', 'Show Threads From the Last Month', 0, 65, 'One Month', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (449, 'dates_showThread_45Days', 'Show Threads From the Last 45 Days', 0, 65, '45 Days', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (450, 'dates_showThread_twoMonths', 'Show Threads From the Last Two Months', 0, 65, 'Two Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (451, 'dates_showThread_75Days', 'Show Threads From the Last 75 Days', 0, 65, '75 Days', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (452, 'dates_showThread_threeMonths', 'Show Threads From the Last Three Months', 0, 65, 'Three Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (453, 'dates_showThread_sixMonths', 'Show Threads From the Last Six Months', 0, 65, 'Six Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (454, 'dates_showThread_oneYear', 'Show Threads From the Last Year', 0, 65, 'One Year', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (455, 'dates_showThread_all', 'Show All Threads', 0, 65, 'All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (456, 'admin_users_ae_allowHtml', 'Allow HTML:', 0, 60, 'Allow HTML', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (457, 'admin_users_ae_allowHtml_desc', 'This will allow this user to use HTML anywhere on the message board (including signatures, posts, personal messages, etc). Be very careful with this option, as it will override all other options (if enabled), users can do very serious damage if HTML is allowed.', 0, 60, 'Allow HTML Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (458, 'admin_users_ae_banSig', 'Ban Signature:', 0, 60, 'Ban Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (459, 'admin_users_ae_banSig_desc', 'This will completely disallow this user from having a signature. This will override any other setting (if enabled).', 0, 60, 'Ban Signature Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (460, 'admin_users_ae_disSigs', 'Display Signatures:', 0, 60, 'Display Signatures', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (461, 'admin_users_ae_disSigs_desc', 'If this option is disabled, this user will not be able to view any signatures of any other users, including their own.', 0, 60, 'Display Signatures Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (462, 'admin_users_ae_disAv', 'Display Avatars:', 0, 60, 'Display Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (463, 'admin_users_ae_disAv_desc', 'If this option is disabled, this user will not be able to view any other users'' avatars, including their own.', 0, 60, 'Display Avatars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (464, 'admin_users_ae_disImgs', 'Display Images:', 0, 60, 'Display Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (465, 'admin_users_ae_disImgs_desc', 'If this options is disabled, this user will not be able to see any images implemented in a message using the <strong>[img]</strong> BB Code.', 0, 60, 'Display Images Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (466, 'admin_users_ae_disAttach', 'Display Attachments:', 0, 60, 'Display Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (467, 'admin_users_ae_disAttach_desc', 'If this is disabled, this user will not be able to download or view any attachments posted by themselves or other users. They will still be allowed to upload attachments, however.', 0, 60, 'Display Attachments Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (468, 'admin_users_ae_disSmi', 'Display Emoticons:', 0, 60, 'Display Emoticons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (469, 'admin_users_ae_disSmi_desc', 'If this is disabled, users will not be able to see any emoticons in any messages, including their own.', 0, 60, 'Display Emoticons Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (470, 'admin_users_ae_invis', 'Invisible:', 0, 60, 'Invisible', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (471, 'admin_users_ae_invis_desc', 'When a user is "invisible," no user except for administrators  and global moderators will be able to see them in the "Who''s Online" box, of if they are browsing a specific forum or thread. The user will be able to surf the forum as a ghost to all but global moderators and administrators.', 0, 60, 'Invisible Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (472, 'admin_users_ae_adminEmails', 'Receive Administrative Emails:', 0, 60, 'Admin Emails', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (473, 'admin_users_ae_adminEmails_desc', 'If this is disabled, this user will not receive any (mass) emails sent by the administrator. They may however, receive emails from users via the message board.', 0, 60, 'Admin Emails Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (474, 'admin_users_ae_emailContact', 'Can Be Contacted By Other Users:', 0, 60, 'Email Contact', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (475, 'admin_users_ae_emailContact_desc', 'If this is disabled, no user will be able to send this user an email. This user may however, still receive administrative (mass) emails.', 0, 60, 'Email Contact Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (476, 'admin_users_ae_receivePm', 'Receive Personal Messages:', 0, 60, 'Receive Personal Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (477, 'admin_users_ae_receivePm_desc', 'If this is disabled, this user will not be able to receive personal messages. If a user attempts to send a personal message to this user, it will bounce back and will never reach it''s destination.', 0, 60, 'Receive Personal Messages Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (478, 'admin_users_ae_receivePmEmail', 'Receive New Personal Message Email Notification:', 0, 60, 'Personal Message Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (479, 'admin_users_ae_receivePmEmail_desc', 'If this is disabled, a user will not receive an email notification alerting them of a new incoming personal message.', 0, 60, 'Personal Message Email Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (480, 'admin_users_ae_receivePmAlert', 'Receive Popup Alert When New Personal Messages Arrive:', 0, 60, 'Personal Message Alert', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (481, 'admin_users_ae_receivePmAlert_desc', 'If this is enabled, users will receive a javascript popup alert notifying them of a new incoming personal message.', 0, 60, 'Personal Message Alert Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (484, 'admin_users_ae_postsPerPage', 'Posts Per Page:', 0, 60, 'Posts Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (485, 'admin_users_ae_postsPerPage_desc', 'This is the number of posts that will be displayed on each page in any given thread.', 0, 60, 'Posts Per Page Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (486, 'admin_users_ae_styleid', 'Style:', 0, 60, 'Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (487, 'admin_users_ae_styleid_desc', 'You may select a style different from the default for this user to use. They will see this style wherever they go on the message board, unless it is overridden in one of the forums.', 0, 60, 'Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (488, 'admin_users_ae_threadViewAge', 'Thread View Age:', 0, 60, 'Thread View Age', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (489, 'admin_users_ae_threadViewAge_desc', 'Only threads conforming to this time frame will be displayed in the thread list, unless overridden by a specific forum.', 0, 60, 'Thread View Age Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (490, 'admin_error_uniqueEmailInEffect', 'Sorry, but you have specified that you want all users to have unique email addresses. If you want to use this email address for the user you are adding, you will need to either change the user''s email address that is already using it, or disable the option.', 0, 6, 'Unique Email Check Fail', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (491, 'admin_users_ae_insertUser', 'Insert User', 0, 60, 'Insert User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (492, 'admin_users_ae_updateUser', 'Update User', 0, 60, 'Update User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (493, 'admin_users_ae_searchUser', 'Search', 0, 60, 'Search User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (494, 'admin_users_search_title', 'Search for Users', 0, 60, 'Search Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (495, 'admin_users_ae_defAuto', 'Use Default BB Code Automatically:', 0, 60, 'Default BB Code Auto', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (496, 'admin_users_ae_defAuto_desc', 'The option to use it when posting and sending personal messages will simply automatically be checked. You can uncheck it to not use the default BB Code. If this is set to off, you can also always check it to use it occasionally.', 0, 60, 'Default BB Code Auto Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (497, 'admin_users_searchResults', 'Search Results', 0, 66, 'Search Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (498, 'users_username', 'Username', 0, 67, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (499, 'admin_options', 'Options', 0, 5, 'Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (500, 'users_regDate', 'Registration Date', 0, 67, 'Registration Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (501, 'users_posts', 'Posts', 0, 67, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (502, 'admin_users_ae_opts', 'User Options', 0, 60, 'User Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (503, 'admin_users_ae_opts_delUser', 'Delete User', 0, 60, 'Delete User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (504, 'admin_go', 'Go', 0, 5, 'Go', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (505, 'admin_users_ae_censor', 'Disable Censor:', 0, 60, 'Disable Censor', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (506, 'admin_users_ae_censor_desc', 'This will completely disable the forum censor (specified in the ''Censorship'' options, under the ''wtcBB Options'' menu) for this user.', 0, 60, 'Disable Censor Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (507, 'error_invalidGroupId', 'Sorry, but the provided usergroup ID is incorrect.', 0, 35, 'Invalid Usergroup Id', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (508, 'error_groupDoesNotExit', 'Sorry, but the requested usergroup does not exist.', 0, 35, 'Usergroup Doesn''t Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (509, 'admin_nav_usergroups_title', 'Usergroups', 0, 68, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (510, 'error_noInfo', 'Sorry, but the requested information does not exist.', 0, 35, 'Requested Info Does Not Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (512, 'admin_nav_usergroups_addGroup', 'Add Usergroup', 0, 68, 'Add Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (513, 'admin_nav_usergroups_groupManager', 'Usergroup Manager', 0, 68, 'Usergroup Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (514, 'admin_usergroups_add', 'Add Usergroup', 0, 70, 'Add Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (515, 'admin_usergroups_add_insertGroup', 'Insert Usergroup', 0, 70, 'Insert Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (516, 'admin_usergroups_edit_updateGroup', 'Update Usergroup', 0, 70, 'Update Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (517, 'admin_usergroups_ae_title', 'Title:', 0, 70, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (518, 'admin_usergroups_ae_title_desc', 'This is the title of this usergroup, and is how it will be referred to throughout the message board.', 0, 70, 'Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (519, 'admin_usergroups_ae_description', 'Description:', 0, 70, 'Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (520, 'admin_usergroups_ae_description_desc', 'Used as a reminder of the responsibility/purpose this usergroup serves.', 0, 70, 'Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (521, 'admin_usergroups_ae_usertitle', 'User Title:', 0, 70, 'Usertitle', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (522, 'admin_usergroups_ae_usertitle_desc', 'This is the title that will appear beside a user''s username, which allows anyone to identify which group a user belongs to.', 0, 70, 'Usertitle Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (523, 'admin_usergroups_ae_htmlBegin_desc', 'This is the HTML that will come before a user''s username when displayed on the message board. This can be overridden on a per user basis by administrators only.', 0, 70, 'HTML Begin Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (524, 'admin_usergroups_ae_htmlEnd_desc', 'This is the HTML that will come after a user''s username when displayed on the message board. This can be overridden on a per user basis by administrators only.', 0, 70, 'HTML End Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (525, 'admin_usergroups_ae_htmlBegin', 'Username HTML Begin:', 0, 70, 'HTML Begin', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (526, 'admin_usergroups_ae_htmlEnd', 'Username HTML End:', 0, 70, 'HTML End', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (527, 'admin_usergroups_ae_information', 'General Information', 0, 70, 'General Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (528, 'admin_usergroups_ae_type', 'Usergroup Type', 0, 70, 'Usergroup Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (529, 'admin_usergroups_ae_admin', 'Administrator:', 0, 70, 'Admin', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (530, 'admin_usergroups_ae_admin_desc', 'If this is enabled, users of this group will have administrative privileges and access to the Administrator Control Panel.', 0, 70, 'Admin Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (531, 'admin_usergroups_ae_global', 'Global Moderator:', 0, 70, 'Global', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (532, 'admin_usergroups_ae_global_desc', 'If this is enabled users of this group will be Global Moderators. Global Moderators have the same permissions as regular moderators, except they automatically have those permissions for all forums.', 0, 70, 'Global Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (533, 'admin_usergroups_ae_isBanned', 'Banned:', 0, 70, 'Banned', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (534, 'admin_usergroups_ae_isBanned_desc', 'Making a group a "Banned Usergroup" will simply put this on the list of "Banned Usergroups" (ie: when you''re banning a user, you have a choice of which banned usergroup to ban the user to). In effect, this is simply a label, unlike the above two options.', 0, 70, 'Banned Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (535, 'admin_usergroups_ae_viewable', 'Viewable Options', 0, 70, 'Viewable Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (536, 'admin_usergroups_ae_listedGroups', 'Show on Listed Usergroups:', 0, 70, 'Listed Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (537, 'admin_usergroups_ae_listedGroups_desc', 'If this is enabled, members of this usergroup will be listed on the "Listed Usergroups" page (linked to from the Forum Home page).', 0, 70, 'Listed Usergroups Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (538, 'admin_usergroups_ae_memberList', 'Show on Member List:', 0, 70, 'Member List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (539, 'admin_usergroups_ae_memberList_desc', 'If this is disabled, members of this group will not be shown on the member''s list.', 0, 70, 'Member List Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (540, 'admin_usergroups_ae_birthdays', 'Show Birthdays:', 0, 70, 'Birthdays', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (541, 'admin_usergroups_ae_birthdays_desc', 'If this is enabled, members'' birthdays in this usergroup will be shown on the bottom of the Forum Home page (if the birthdays box is enabled).', 0, 70, 'Birthdays Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (542, 'admin_usergroups_ae_genDisAccess', 'General Display Access', 0, 70, 'General Display Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (543, 'admin_usergroups_ae_viewBoard', 'Message Board:', 0, 70, 'Message Board', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (544, 'admin_usergroups_ae_viewBoard_desc', 'Disabling this will completely deny access to the whole message board.', 0, 70, 'Message Board Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (545, 'admin_usergroups_ae_viewForums', 'Forums:', 0, 70, 'Forums', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (546, 'admin_usergroups_ae_viewForums_desc', 'If this is disabled, users of this group will not be able to view any forums. This is useful for message boards that disallow all content to guests, yet want them to be able to register. (Using the above option, will block the whole message board, including the registration page. This will only block the forums.)', 0, 70, 'Forums Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (547, 'admin_usergroups_ae_search', 'Search:', 0, 70, 'Search', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (548, 'admin_usergroups_ae_search_desc', 'If this is disabled, members of this group will be disallowed from using any of the search functions on the message board.', 0, 70, 'Search Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (549, 'admin_usergroups_ae_viewInvis', 'See Invisible Users:', 0, 70, 'See Invisible Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (550, 'admin_usergroups_ae_viewInvis_desc', 'If this option is enabled, members of this group will be allowed to view users that have specified themselves as invisible in the "Currently Active Users" boxes.', 0, 70, 'See Invisible Users Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (551, 'admin_usergroups_ae_viewProfile', 'Profile:', 0, 70, 'User Profiles', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (552, 'admin_usergroups_ae_viewProfile_desc', 'If this is disabled, this user will only be allowed to view their own profile.', 0, 70, 'User Profiles Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (553, 'admin_usergroups_ae_viewMemberList', 'Member List:', 0, 70, 'Member List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (554, 'admin_usergroups_ae_viewMemberList_desc', 'If this is disabled, members of this group will be disallowed access from viewing the member''s list.', 0, 70, 'Member List Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (555, 'admin_usergroups_ae_viewThreads', 'View Others'' Threads:', 0, 70, 'View Others'' Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (556, 'admin_usergroups_ae_viewThreads_desc', 'If this is disabled, members of this group will not be able to view threads made by other users.', 0, 70, 'View Others'' Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (557, 'admin_usergroups_ae_viewOwnThreads', 'View Own Threads:', 0, 70, 'View Own Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (558, 'admin_usergroups_ae_viewOwnThreads_desc', 'If this is disabled, members of this group will not be able to view threads made by themselves.', 0, 70, 'View Own Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (559, 'admin_usergroups_ae_viewDelNotices', 'Deletion Notices:', 0, 70, 'Deletion Notices', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (560, 'admin_usergroups_ae_viewDelNotices_desc', 'If this is enabled, members of this group will be granted access to see <strong>all</strong> deletion notices (if posts are deleted, but not permanently deleted, there will be a notification that replaces that post and would normally be hidden to all users, to give the effect that it actually was deleted).', 0, 70, 'Deletion Notices Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (561, 'admin_usergroups_ae_forumOptions', 'Forum Access', 0, 70, 'Forum Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (562, 'admin_usergroups_ae_showEditedNotice', 'Show Edited Notice:', 0, 70, 'Show Edited Notice', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (563, 'admin_usergroups_ae_showEditedNotice_desc', 'If this is enabled, a small notification will be displayed at the bottom of a post if it was edited, and will supply the date, time, and the user who edited the post.', 0, 70, 'Show Edited Notice Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (564, 'admin_usergroups_ae_invis', 'Be Invisible:', 0, 70, 'Be Invisible', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (565, 'admin_usergroups_ae_invis_desc', 'If this is enabled, members of this group will be able to make themselves invisible in the "Currently Active Users" boxes.', 0, 70, 'Be Invisible Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (566, 'admin_usergroups_ae_editedNotice', 'Toggle Edited Notice:', 0, 70, 'Toggle Edited Notice', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (567, 'admin_usergroups_ae_editedNotice_desc', 'This will allow members of this group to show or hide the "Edited By" notice on a per post basis.', 0, 70, 'Toggle Edited Notice Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (568, 'admin_usergroups_ae_canUsertitle', 'Change User Title:', 0, 70, 'Change User Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (569, 'admin_usergroups_ae_canUsertitle_desc', 'This will allow members of this group to change their user title.', 0, 70, 'Change User Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (570, 'admin_usergroups_ae_defBBCode', 'Use Default BB Code:', 0, 70, 'Use Default BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (571, 'admin_usergroups_ae_defBBCode_desc', 'If this is enabled, members of this group will be able to specify a default font, color, and size for messages that they post.', 0, 70, 'Use Default BB Code Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (572, 'admin_usergroups_ae_postThreads', 'Post Threads:', 0, 70, 'Post Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (573, 'admin_usergroups_ae_postThreads_desc', 'If this is disabled, members of this group will not be able to post new threads.', 0, 70, 'Post Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (574, 'admin_usergroups_ae_reply', 'Reply to Others'' Threads:', 0, 70, 'Reply to Others'' Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (575, 'admin_usergroups_ae_reply_desc', 'If this is disabled, members of this group will not be able to reply to threads made by other users.', 0, 70, 'Reply to Others'' Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (576, 'admin_usergroups_ae_replyOwn', 'Reply to Own Threads:', 0, 70, 'Reply to Own Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (577, 'admin_usergroups_ae_replyOwn_desc', 'If this is disabled, members of this group will not be able to reply to their own threads.', 0, 70, 'Reply to Own Thread Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (578, 'admin_usergroups_ae_edit', 'Edit Posts:', 0, 70, 'Edit Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (579, 'admin_usergroups_ae_edit_desc', 'If this is disabled, members of this group will not be able to edit their own posts.', 0, 70, 'Edit Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (580, 'admin_usergroups_ae_editThreadTitle', 'Edit Thread Title:', 0, 70, 'Edit Thread Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (581, 'admin_usergroups_ae_editThreadTitle_desc', 'If this is enabled, members of this group will be able to edit the title of threads they have made.', 0, 70, 'Edit Thread Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (582, 'admin_usergroups_ae_delPosts', 'Delete Posts:', 0, 70, 'Delete Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (583, 'admin_usergroups_ae_delPosts_desc', 'If this is enabled, members of this group will be allowed to delete their own posts.', 0, 70, 'Delete Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (584, 'admin_usergroups_ae_permPosts', 'Permanently Delete Posts:', 0, 70, 'Permanently Delete Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (585, 'admin_usergroups_ae_permPosts_desc', 'If this is enabled, members of this group will be able to permanently delete their posts from the database.', 0, 70, 'Permanently Delete Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (586, 'admin_usergroups_ae_delThreads', 'Delete Threads:', 0, 70, 'Delete Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (587, 'admin_usergroups_ae_delThreads_desc', 'If this is enabled, members of this group will be able to delete their own threads.', 0, 70, 'Delete Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (588, 'admin_usergroups_ae_permThreads', 'Permanently Delete Threads:', 0, 70, 'Permanently Delete Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (589, 'admin_usergroups_ae_permThreads_desc', 'If this is enabled, members of this group will be able to permanently delete their threads from the database.', 0, 70, 'Permanently Delete Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (590, 'admin_usergroups_ae_close', 'Close Own Threads:', 0, 70, 'Close Own Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (591, 'admin_usergroups_ae_close_desc', 'If this is enabled, members of this group will be able to close their own threads.', 0, 70, 'Close Own Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (592, 'admin_usergroups_ae_editProfile_desc', 'If this is disabled, members of this group will not be able to edit their profile.', 0, 70, 'Edit Profile Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (593, 'admin_usergroups_ae_censor', 'Disable Censor:', 0, 70, 'Disable Censor', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (594, 'admin_usergroups_ae_censor_desc', 'If this is enabled, members of this group will be allowed to disable the forum wide censor for messages.', 0, 70, 'Disable Censor Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (595, 'admin_usergroups_ae_ignore', 'Use Ignore List:', 0, 70, 'Use Ignore List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (596, 'admin_usergroups_ae_ignore_desc', 'If this is enabled, members of this group will be able to create an ignore list. Members of their ignore list will not be able to PM or email them, and by default their posts will be hidden from members that chose to ignore him/her.', 0, 70, 'Use Ignore List Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (597, 'admin_usergroups_ae_styles', 'Switch Styles:', 0, 70, 'Switch Styles', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (598, 'admin_usergroups_ae_styles_desc', 'If this is disabled, members of this group will not be able to switch styles.', 0, 70, 'Switch Styles Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (599, 'admin_usergroups_ae_editProfile', 'Edit Profile:', 0, 70, 'Edit Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (600, 'admin_usergroups_ae_sig', 'Use Signature:', 0, 70, 'Use Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (601, 'admin_usergroups_ae_sig_desc', 'If this is disabled, members of this group will not be allowed to have a signature.', 0, 70, 'Use Signature Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (602, 'admin_usergroups_ae_genOptions', 'General Options', 0, 70, 'General Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (603, 'admin_usergroups_ae_personal', 'Personal Messaging', 0, 70, 'Personal Messaging', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (604, 'admin_usergroups_ae_receipts', 'Can Send Message Receipts:', 0, 70, 'Message Receipts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (605, 'admin_usergroups_ae_receipts_desc', 'If this is enabled, members of this group will be able to send a receipt with their message. This will allow them to track which messages have been read or not by the recipient.', 0, 70, 'Message Receipts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (606, 'admin_usergroups_ae_denyReceipts', 'Can Deny Message Receipts:', 0, 70, 'Deny Receipts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (607, 'admin_usergroups_ae_denyReceipts_desc', 'If this is enabled, members of this group will be able to deny a receipt request. In effect, members of this group can read a message but make it appear as though they didn''t read it in the eyes of the sender.', 0, 70, 'Deny Receipts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (608, 'admin_usergroups_ae_folders', 'Can Manage Folders:', 0, 70, 'Manager Folders', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (609, 'admin_usergroups_ae_folders_desc', 'If this is enabled, members of this group will be able to add, edit, and delete folders in order to keep a more organized inbox.', 0, 70, 'Manager Folders Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (610, 'admin_usergroups_ae_maxMessages', 'Maximum Amount of Messages:', 0, 70, 'Max Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (611, 'admin_usergroups_ae_maxMessages_desc', 'This is the maximum amount of messages members of this group will be able to store in their inbox. <strong>Enter 0 here if you want to disable personal messaging entirely for members of this group.</strong>', 0, 70, 'Max Messages Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (612, 'admin_usergroups_ae_sendUsers', 'Maximum Amount of Recipients:', 0, 70, 'Max Recipients', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (613, 'admin_usergroups_ae_sendUsers_desc', 'This is the maximum amount of recipients members of this group can send one message to at a time. Don''t set this too high, as it can be quite costly in resources.', 0, 70, 'Max Recipients Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (614, 'admin_usergroups_ae_rules', 'Maximum Amount of Message Rules:', 0, 70, 'Message Rules', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (615, 'admin_usergroups_ae_rules_desc', 'This is the maximum amount of message rules members of this group can have at any one time. Message rules allow users to move (to a different folder) or delete incoming messages based upon the user sending them, or the usergroup that the user is in. This can also be costly in resources if set too high. <strong>Set this to 0 if you want message rules disabled entirely for members of this group.</strong>', 0, 70, 'Message Rules Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (616, 'admin_usergroups_ae_warnSystem', 'Warning System Permissions', 0, 70, 'Warning System', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (617, 'admin_usergroups_ae_warnOthers', 'Can Warn Others:', 0, 70, 'Warn Others', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (618, 'admin_usergroups_ae_warnOthers_desc', 'If this is enabled, members of this group will be able to issue warning points to other members.', 0, 70, 'Warn Others Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (619, 'admin_usergroups_ae_warnImmune', 'Has Warning Immunity:', 0, 70, 'Warn Immunity', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (620, 'admin_usergroups_ae_warnImmune_desc', 'If this is enabled, members of this group cannot be issued warnings.', 0, 70, 'Warn Immunity Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (621, 'admin_usergroups_ae_warnViewOwn', 'Can View Own Warning Level:', 0, 70, 'View Own Warning Level', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (622, 'admin_usergroups_ae_warnViewOwn_desc', 'If this is enabled, members of this group will be able to view their own warning level.', 0, 70, 'View Own Warning Level Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (623, 'admin_usergroups_ae_warnViewOthers', 'Can View Others'' Warning Levels:', 0, 70, 'View Other Warning Levels', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (624, 'admin_usergroups_ae_warnViewOthers_desc', 'If this is enabled, members of this group will be able to view warning levels of other members.', 0, 70, 'View Other Warning Levels Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (625, 'admin_usergroups_ae_av', 'Enable Avatars:', 0, 70, 'Enable Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (626, 'admin_usergroups_ae_av_desc', 'If this is disabled, members of this group will not be allowed to have an avatar. Avatars are images displayed in each user''s post, which are usually used as a symbol of identification.', 0, 70, 'Enable Avatars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (627, 'admin_usergroups_ae_avatar', 'Avatar Options', 0, 70, 'Avatar Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (628, 'admin_usergroups_ae_uploadAv', 'Can Upload Avatar:', 0, 70, 'Upload Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (629, 'admin_usergroups_ae_uploadAv_desc', 'If this is enabled, members of this group will be able to upload avatars from their computer onto your server.', 0, 70, 'Upload Avatar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (630, 'admin_usergroups_ae_maxFilesizeAv', 'Maximum File Size:', 0, 70, 'Avatar Max File Size', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (631, 'admin_usergroups_ae_maxFilesizeAv_desc', 'This is the maximum file size an uploaded avatar can be, in <strong>bytes</strong>.', 0, 70, 'Avatar Max File Size Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (632, 'admin_usergroups_ae_maxWidth', 'Maximum Width:', 0, 70, 'Avatar Max Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (633, 'admin_usergroups_ae_maxWidth_desc', 'This is the maximum width for uploaded avatars, in pixels.', 0, 70, 'Avatar Max Width Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (634, 'admin_usergroups_ae_maxHeight', 'Maximum Height:', 0, 70, 'Avatar Max Height', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (635, 'admin_usergroups_ae_maxHeight_desc', 'This is the maximum height for uploaded avatars, in pixels.', 0, 70, 'Avatar Max Height Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (636, 'admin_usergroups_ae_attach', 'Attachment Options', 0, 70, 'Attachment Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (637, 'admin_usergroups_ae_upAttach', 'Can Upload Attachments:', 0, 70, 'Upload Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (638, 'admin_usergroups_ae_upAttach_desc', 'If this is disabled, members of this group will not be able to upload attachments in messages.', 0, 70, 'Upload Attachments Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (639, 'admin_usergroups_ae_downAttach', 'Can Download Attachments:', 0, 70, 'Download Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (640, 'admin_usergroups_ae_downAttach_desc', 'If this is disabled, members of this group will not be allowed to download attachments.', 0, 70, 'Download Attachments Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (641, 'admin_usergroups_ae_maxFilesizeAttach', 'Maximum File Size:', 0, 70, 'Attachment Max Filesize', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (642, 'admin_usergroups_ae_maxFilesizeAttach_desc', 'This is the maximum file size that any attachment uploaded by this user can be, in bytes. There are already max file size restrictions for each extension uploaded, however if you want to implicity set a file size cap for this usergroup, set it here. <strong>Set this to 0 if you do not want to set an implicit cap.</strong>', 0, 70, 'Attachment Max Filesize Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (643, 'admin_usergroups_ae_overrides', 'Overrides', 0, 70, 'Overrides', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (644, 'admin_usergroups_ae_flood', 'Flood Immunity:', 0, 70, 'Flood Immunity', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (645, 'admin_usergroups_ae_flood_desc', 'If this is enabled, members of this group will not be subject to the flood check.', 0, 70, 'Flood Immunity Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (646, 'admin_usergroups_ae_mesMinChars', 'Minimum Characters in Message:', 0, 70, 'Message Min Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (647, 'admin_usergroups_ae_mesMinChars_desc', 'If this is enabled, members of this group will not be subjected to the minimum characters in post restriction.', 0, 70, 'Message Min Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (648, 'admin_usergroups_ae_mesMaxChars', 'Maximum Characters in Message:', 0, 70, 'Message Max Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (649, 'admin_usergroups_ae_mesMaxChars_desc', 'If this is enabled, members of this group will not be subject to the maximum amount of characters restriction.', 0, 70, 'Message Max Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (650, 'admin_usergroups_ae_mesMaxImgs', 'Maximum Images in Message:', 0, 70, 'Message Max Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (651, 'admin_usergroups_ae_mesMaxImgs_desc', 'If this is enabled, members of this group will not be subject the maximum amount of images in a message restriction.', 0, 70, 'Message Max Images Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (652, 'admin_usergroups_ae_searchMinChars', 'Minimum Characters in Search Query:', 0, 70, 'Search Min Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (653, 'admin_usergroups_ae_searchMinChars_desc', 'If this is enabled, members of this group will not be subject to the minimum amount of characters in a search query restriction.', 0, 70, 'Search Min Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (654, 'admin_usergroups_ae_searchMaxChars', 'Maximum Characters in Search Query:', 0, 70, 'Search Max Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (655, 'admin_usergroups_ae_searchMaxChars_desc', 'If this is enabled, members of this group will not be subject to the maximum amount of characters in a search query restriction.', 0, 70, 'Search Max Chars Desc', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (656, 'admin_usergroups_ae_whosOnline', 'Who''s Online Permissions', 0, 70, 'Who''s Online Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (657, 'admin_usergroups_ae_viewOnline', 'Can View Who''s Online:', 0, 70, 'View Who''s Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (658, 'admin_usergroups_ae_viewOnline_desc', 'If this is disabled, members of this group will not be able to see the "Who''s Online" page. However, they will be able to still see "Currently Active Users" boxes.', 0, 70, 'View Who''s Online Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (659, 'admin_usergroups_ae_onlineDetails', 'Can View Details:', 0, 70, 'View Who''s Online Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (660, 'admin_usergroups_ae_onlineDetails_desc', 'If this is enabled, members of this group will be able to view detailed locations of each user. This may include thread names in forums that this user does not have access to.', 0, 70, 'View Who''s Online Details Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (661, 'admin_usergroups_ae_onlineIp', 'Can View IP Address:', 0, 70, 'View Who''s Online IP', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (662, 'admin_usergroups_ae_onlineIp_desc', 'If this is enabled, members of this group will be able to view users'' IP addresses on the "Who''s Online" page. <strong>Note:</strong> This will also display the User Agent string.', 0, 70, 'View Who''s Online IP Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (663, 'admin_usergroups_ae_poll', 'Poll Options', 0, 70, 'Poll Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (664, 'admin_usergroups_ae_createPolls', 'Can Create Polls:', 0, 70, 'Create Polls', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (665, 'admin_usergroups_ae_createPolls_desc', 'If this is disabled, members of this group will not be allowed to create polls.', 0, 70, 'Create Polls Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (666, 'admin_usergroups_ae_vote', 'Can Vote on Polls:', 0, 70, 'Vote on Polls', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (667, 'admin_usergroups_ae_vote_desc', 'If this is disabled, members of this group will not be able to vote on polls.', 0, 70, 'Vote on Polls Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (668, 'admin_usergroups_ae_model', 'Base Group Options Off of', 0, 70, 'Usergroup Model', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (669, 'admin_usergroups_edit', 'Edit Usergroup', 0, 70, 'Edit Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (670, 'admin_error_uniqueGroupTitle', 'Sorry, but you must specify a unique usergroup title. wtcBB has detected that there is already a usergroup that exists with the specified title.', 0, 6, 'Unique Usergroup Title Failed', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (671, 'admin_usergroups_man', 'Usergroup Manager', 0, 71, 'Usergroup Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (672, 'admin_usergroups_man_def', 'Default Usergroups', 0, 71, 'Default Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (673, 'admin_usergroups_man_custom', 'Custom Usergroups', 0, 71, 'Custom Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (674, 'admin_usergroups_man_showAllPrim', 'Primary Users', 0, 71, 'Show All Primary Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (675, 'admin_usergroups_man_title', 'Title', 0, 71, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (676, 'admin_usergroups_man_primUsers', 'Primary Users', 0, 71, 'Primary Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (677, 'admin_users_ae_secGroups', 'Secondary Usergroups', 0, 60, 'Secondary Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (678, 'admin_users_ae_secUsergroup', 'Secondary Usergroups:', 0, 60, 'Secondary Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (679, 'admin_users_ae_secUsergroup_desc', 'You may select multiple secondary usergroups for this user. Secondary usergroups are useful when you want to tack on extra rights (or remove rights) to a specific set of users, while still maintaining the main usergroup base.', 0, 60, 'Secondary Usergroups Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (680, 'admin_usergroups_man_secUsers', 'Secondary Users', 0, 71, 'Secondary Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (681, 'admin_usergroups_man_showAllSec', 'Secondary Users', 0, 71, 'Show All Secondary Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (682, 'admin_usergroups_man_addGroup', 'Add Usergroup', 0, 71, 'Add Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (683, 'admin_error_cannotDelDefGroup', 'Sorry, but you cannot delete a default usergroup, as they are required for wtcBB to run properly.', 0, 6, 'Can''t Delete Default Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (684, 'admin_error_noAdmins', 'Sorry, but there are no administrators added... So umm... How can you see this!?!?', 0, 6, 'No Admins', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (685, 'admin_error_uniqueName', 'Sorry, but you must specify a unique name/title.', 0, 6, 'Unique Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (686, 'admin_usergroups_admins_viewLog', 'View Administrative Log', 0, 72, 'View Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (687, 'admin_usergroups_admins', 'Edit Administrative Permissions', 0, 72, 'Edit Admin Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (688, 'admin_nav_usergroups_adminPerms', 'Administrative Permissions', 0, 68, 'Administrative Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (689, 'admin_usergroups_admins_options', 'wtcBB Options:', 0, 72, 'wtcBB Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (690, 'admin_usergroups_admins_language', 'Languages:', 0, 72, 'Languages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (691, 'admin_usergroups_admins_users', 'Users:', 0, 72, 'Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (692, 'admin_usergroups_admins_usergroups', 'Usergroups:', 0, 72, 'Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (693, 'admin_usergroups_admins_admin', 'Edit Administrator', 0, 72, 'Edit Admin', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (694, 'admin_allYes', 'All Yes', 0, 5, 'All Yes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (695, 'admin_allNo', 'All No', 0, 5, 'All No', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (696, 'admin_options_cookieSettings_cookTimeout', 'Timeout:', 0, 73, 'Timeout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (697, 'admin_options_cookieSettings_cookTimeout_desc', 'Put the cookie timeout here, in which this is the amount of time a user must remain inactive before all posts are marked as read, and how long a user will stay in the "Who''s Online" after their last activity.', 0, 73, 'Timeout Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (698, 'admin_options_cookieSettings_cookPath', 'Path:', 0, 73, 'Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (699, 'admin_options_cookieSettings_cookPath_desc', 'This is the path in which cookies will be set. This is useful if you have multiple instances of wtcBB on one domain. Please remember to keep the <strong>trailing slash</strong>.', 0, 73, 'Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (700, 'admin_options_cookieSettings_cookDomain', 'Domain:', 0, 73, 'Domain', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (701, 'admin_options_cookieSettings_cookDomain_desc', 'This is the domain in which cookies will be in effect. This is useful if you have multiple sub-domains running different instances of wtcBB. Remember to keep the <strong>preceeding dot</strong>. If you are running wtcBB on your localhost, leave the cookie domain field <strong>blank</strong>.', 0, 73, 'Domain Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (702, 'admin_options_cookieSettings', 'Cookie Settings', 0, 73, 'Cookie Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (703, 'admin_nav_wtcBBOpt_cookieSettings', 'Cookie Settings', 0, 20, 'Cookie Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (704, 'users_password', 'Password', 0, 67, 'Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (705, 'admin_login', 'Login to wtcBB 2 Admin Panel', 0, 5, 'Login Screen Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (706, 'error_invalidPassword', 'Sorry, but you have entered an invalid password.', 0, 6, 'Invalid Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (707, 'admin_error_privileges', 'Sorry, but the user account you are attempting to use has insufficient privileges for the action you are trying to perform.', 0, 6, 'Insufficient Privileges', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (708, 'admin_error_privilegesAdmin', 'Sorry, but your administrative account has been restricted from performing this action.\n<br /><br />\nIn order to unrestrict access to this action, you''ll need to ask your head administrator to do so. If you are the head administrator, you can edit the <strong>config.php</strong> file found in the <strong>includes</strong> directory. Add your userid to the "$superAdministrators" variable, and separate any additional userids by a comma. After you have done that, expand the "Usergroups" menu, and click on "Admin Permissions". You will then be able to edit administrative permissions for your administrators.', 0, 6, 'Insufficient Admin Privileges', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (709, 'admin_error_untouchable', 'Sorry, but this user is "Uneditable". If you wish to edit this user, you will need to modify the <strong>$uneditableUsers</strong> variable in the <strong>includes/config.php</strong> file.', 0, 6, 'Untouchable User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (710, 'admin_error_untouchableGroup', 'Sorry, but this usergroup contains an "Uneditable" user. If you wish to edit this usergroup, you will need to modify the <strong>$uneditableUsers</strong> variable in the <strong>includes/config.php</strong> file.', 0, 6, 'Untouchable User in Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (711, 'admin_users_ae_allUsers', 'All Users', 0, 60, 'All Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (713, 'admin_nav_usergroups_automation', 'Usergroup Automation', 0, 68, 'Automation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (714, 'admin_usergroups_auto_add', 'Add Usergroup Automation', 0, 74, 'Usergroup Automation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (715, 'admin_usergroups_auto_affected', 'Apply Automation To:', 0, 74, 'Affected Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (716, 'admin_usergroups_auto_affected_desc', 'This is the group that you apply this automation to. Only users in the usergroup selected and fit the criteria specified below will be automatically set into a new usergroup.', 0, 74, 'Affected Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (717, 'admin_usergroups_auto_moveTo', 'Move User To Usergroup:', 0, 74, 'Move To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (718, 'admin_usergroups_auto_moveTo_desc', 'Please select the usergroup that you would like to move (or add) this user to.', 0, 74, 'Move To Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (719, 'admin_usergroups_auto_secondary', 'Add User To Secondary Group:', 0, 74, 'Secondary', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (720, 'admin_usergroups_auto_secondary_desc', 'If this is ticked as "Yes", the users will be added as secondary users to the usergroups chosen below. If this is ticked as "No", this user''s primary usergroup will be changed to the usergroup selected below.', 0, 74, 'Secondary Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (721, 'admin_usergroups_auto_posts', 'Posts:', 0, 74, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (722, 'admin_usergroups_auto_posts_desc', 'This is the cut off point for posts a user has. Either the user can have greater than or equal to, or less than this amount, and depending upon the option below, only users meeting this criteria will be automated.', 0, 74, 'Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (723, 'admin_usergroups_auto_reg_desc', 'This is the cut off for how many days the user has to be registered for. The same concept for posts applies to this.', 0, 74, 'Days Registered Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (724, 'admin_usergroups_auto_reg', 'Days Registered:', 0, 74, 'Days Registered', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (725, 'admin_usergroups_auto_postsComp', 'Post Comparison:', 0, 74, 'Post Compare', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (726, 'admin_usergroups_auto_postsComp_desc', 'The post cut off can either be "Greater Than or Equal To" the above value, or "Less Than" the above value.', 0, 74, 'Post Compare Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (727, 'admin_usergroups_auto_regComp', 'Days Registered Comparison Type:', 0, 74, 'Days Registered Compare', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (728, 'admin_usergroups_auto_regComp_desc', 'The registration day cut off can either be "Greater Than or Equal To" the above value, or "Less Than" the above value.', 0, 74, 'Days Registered Compare Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (729, 'admin_usergroups_auto_type', 'Automation Comparison Type:', 0, 74, 'Automation Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (730, 'admin_usergroups_auto_type_desc', 'This is how the posts and number of days registered values will be handled.', 0, 74, 'Automation Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (731, 'admin_usergroups_auto_details', 'Usergroup Automation allows you to automatically assign users to different groups based off of a certain set of criteria (namely, how many posts a user has and how many days a user has been registered). Every day, using wtcBB''s Cron System, wtcBB will search for users meeting the following criteria and either change their primary usergroup, or add them to secondary usergroups (depending on which you pick below).', 0, 74, 'Automation Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (732, 'admin_usergroups_auto_man', 'Usergroup Automation Manager', 0, 74, 'Automation Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (733, 'admin_usergroups_auto_man_affected', 'Affected Group', 0, 74, 'Affected Groups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (734, 'admin_usergroups_auto_man_moveTo', 'Users Moved To', 0, 74, 'Gets Moved To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (735, 'admin_usergroups_auto_man_seconday', 'Is Secondary', 0, 74, 'Is Secondary', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (736, 'admin_usergroups_auto_edit', 'Edit Usergroup Automation', 0, 74, 'Edit Automation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (737, 'admin_nav_cron_title', 'wtcBB Cron System', 0, 75, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (738, 'admin_nav_cron_add', 'Add wtcBB Cron', 0, 75, 'Add wtcBB Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (739, 'admin_nav_cron_man', 'wtcBB Cron Manager', 0, 75, 'wtcBB Cron Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (740, 'admin_usergroups_admins_cron', 'wtcBB Cron System:', 0, 72, 'wtcBB Cron System', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (741, 'admin_cron_add', 'Add wtcBB Cron', 0, 76, 'Add Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (742, 'admin_cron_edit', 'Edit wtcBB Cron', 0, 76, 'Edit Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (743, 'admin_cron_ae_title', 'Title:', 0, 76, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (744, 'admin_cron_ae_title_desc', 'This is the title of this cron, of which it will be referred to as.', 0, 76, 'Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (745, 'admin_cron_ae_path', 'Filename Path:', 0, 76, 'Filename Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (746, 'admin_cron_ae_path_desc', 'This is the filename of the file you wish for wtcBB to run. Please make sure that this is a <strong>path</strong> and <strong>not</strong> a URL.', 0, 76, 'Filename Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (747, 'admin_cron_ae_log', 'Log wtcBB Cron:', 0, 76, 'Log Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (748, 'admin_cron_ae_log_desc', 'If this is enabled, every time this cron is ran the date, time, and results of the cron will be logged.', 0, 76, 'Log Cron Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (774, 'admin_users_ban_username', 'Username:', 0, 80, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (772, 'admin_cron_man_exec', 'Execute Cron', 0, 79, 'Execute Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (773, 'admin_users_ban', 'Ban User', 0, 80, 'Ban User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (751, 'dates_sunday', 'Sunday', 0, 61, 'Sunday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (752, 'dates_monday', 'Monday', 0, 61, 'Monday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (753, 'dates_tuesday', 'Tuesday', 0, 61, 'Tuesday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (754, 'dates_wednesday', 'Wednesday', 0, 61, 'Wednesday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (755, 'dates_thursday', 'Thursday', 0, 61, 'Thursday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (756, 'dates_friday', 'Friday', 0, 61, 'Friday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (757, 'dates_saturday', 'Saturday', 0, 61, 'Saturday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (758, 'admin_cron_ae_dayOfWeek', 'Day of Week:', 0, 76, 'Day of Week', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (759, 'admin_cron_ae_dayOfWeek_desc', 'Please select the week day in which this cron will run. Select the "*" for this cron to ignore the weekday option. Please note that a week day will automatically override the day of the month. Thusly, when the day of the week is set, the day of the month option is completely ignored.', 0, 76, 'Day of Week Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (760, 'admin_cron_ae_dayOfMonth', 'Day of Month:', 0, 76, 'Day of Month', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (761, 'admin_cron_ae_dayOfMonth_desc', 'Please select the day of the month in which this cron will run. Select the "*" for this cron to ignore the day of the month option.', 0, 76, 'Day of Month Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (762, 'admin_cron_ae_hour', 'Hour:', 0, 76, 'Hour', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (763, 'admin_cron_ae_hour_desc', 'Please select the hour in which this cron will run. Select the "*" for this cron to ignore the hour option.', 0, 76, 'Hour Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (764, 'admin_cron_ae_minute', 'Minute:', 0, 76, 'Minute', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (765, 'admin_cron_ae_minute_desc', 'Please select the minute in which this cron will run. Select the "*" for this cron to ignore the minute option.', 0, 76, 'Minute Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (766, 'admin_error_fileDoesNotExist', 'Sorry, but the requested file name does not exist.', 0, 6, 'File Does Not Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (767, 'admin_error_cron_noCrons', 'Sorry, but there are currently no wtcBB Crons in the database.', 0, 6, 'No Crons Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (768, 'admin_cron_man', 'wtcBB Cron Manager', 0, 79, 'Cron Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (769, 'admin_cron_man_title', 'Title', 0, 79, 'Cron Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (770, 'admin_cron_man_fileName', 'Filename', 0, 79, 'Filename', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (771, 'admin_cron_man_nextRun', 'Time of Next Execution', 0, 79, 'Next Run', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (775, 'admin_users_ban_username_desc', 'Enter the username of the user you would like to ban.', 0, 80, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (776, 'admin_users_ban_group', 'Banned Usergroup:', 0, 80, 'Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (777, 'admin_users_ban_group_desc', 'Please select the usergroup you would like to ban this user to.', 0, 80, 'Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (778, 'admin_users_ban_type', 'Type of Banishment:', 0, 80, 'Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (779, 'admin_users_ban_type_desc', 'Please select the type of banishment for this user (either permanent, which can be undone manually, or temporary).', 0, 80, 'Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (780, 'admin_users_ban_types_perm', 'Permanent Ban', 0, 80, 'Permanent Ban', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (781, 'admin_users_ban_types_temp_1day', 'Temporary Ban - 1 Day', 0, 80, '1 Day', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (782, 'admin_users_ban_types_temp_2days', 'Temporary Ban - 2 Days', 0, 80, '2 Days', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (783, 'admin_users_ban_types_temp_3days', 'Temporary Ban - 3 Days', 0, 80, '3 Days', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (784, 'admin_users_ban_types_temp_1week', 'Temporary Ban - 1 Week', 0, 80, '1 Week', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (785, 'admin_users_ban_types_temp_2weeks', 'Temporary Ban - 2 Weeks', 0, 80, '2 Weeks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (786, 'admin_users_ban_types_temp_3weeks', 'Temporary Ban - 3 Weeks', 0, 80, '3 Weeks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (787, 'admin_users_ban_types_temp_1month', 'Temporary Ban - 1 Month', 0, 80, '1 Month', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (788, 'admin_users_ban_types_temp_2months', 'Temporary Ban - 2 Months', 0, 80, '2 Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (789, 'admin_users_ban_types_temp_3months', 'Temporary Ban - 3 Months', 0, 80, '3 Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (790, 'admin_users_ban_types_temp_6months', 'Temporary Ban - 6 Months', 0, 80, '6 Months', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (791, 'admin_users_ban_types_temp_1year', 'Temporary Ban - 1 Year', 0, 80, '1 Year', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (792, 'admin_error_alreadyBanned', 'Sorry, but our records show that this user has already been banned.', 0, 6, 'Already Banned', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (793, 'admin_error_noBannedUsers', 'There are currently no banned users. You have a great community!', 0, 6, 'No Banned Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (794, 'admin_users_viewBan_inGroup', 'Banned Users in Group:', 0, 80, 'Users in Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (795, 'admin_users_viewBan', 'View Banned Users', 0, 80, 'View Banned Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (796, 'admin_users_viewBan_temp', 'Temporary', 0, 80, 'Tempoary', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (797, 'admin_users_viewBan_perm', 'Permanent', 0, 80, 'Permanent', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (798, 'global_at', 'at', 0, 64, 'At', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (799, 'global_perpetual', 'Perpetual', 0, 64, 'Perpetual', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (800, 'admin_users_viewBan_type', 'Type of Ban', 0, 80, 'Type of Ban', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (801, 'admin_users_viewBan_liftDate', 'Ban Lift Date', 0, 80, 'Ban Lift Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (802, 'admin_users_viewBan_lift', 'Lift Ban', 0, 80, 'Lift Ban', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (803, 'admin_users_editBan', 'Edit Banned User Options', 0, 80, 'Edit Ban', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (804, 'admin_users_editBan_details', 'If you change the "Type of Banishment" option (which is in effect changing how long the user is banned), then the ban timer will reset, and the user will serve another term of banishment. If the type of banishment is left the same, then the banishment term will continue and will not restart.', 0, 80, 'Edit Ban Options Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (805, 'global_approx', 'approximately', 0, 64, 'Approximately', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (806, 'admin_usergroups_man_addAuto', 'Add Automation', 0, 71, 'Add Automation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (807, 'admin_cron_log_banLifted', 'Bans were lifted from the following users:', 0, 81, 'Ban Lifted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (808, 'admin_cron_log_changeGroup', 'The following users'' usergroups were changed:', 0, 81, 'Changed Groups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (809, 'admin_cron_log_noAffect', 'No users were affected.', 0, 81, 'No Users Affected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (810, 'admin_users_pm_search', 'Search for Users to Prune/Move', 0, 82, 'Search', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (811, 'admin_users_pm_criteria', 'Search Criteria', 0, 82, 'Criteria', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (812, 'admin_users_pm_posts', 'Has Posts Less Than:', 0, 82, 'Less Than Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (813, 'admin_users_pm_posts_desc', 'This field will limit the results to users who have posts less than this amount. Specify <strong>0</strong> here if you want the search to ignore post counts.', 0, 82, 'Less Than Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (814, 'admin_users_pm_usergroup', 'Usergroup:', 0, 82, 'Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (815, 'admin_users_pm_usergroup_desc', 'Selecting a usergroup will filter the result set to users who have their primary usergroup to set to the selected group. Selecting "All Usergroups" will instruct the search to ignore a user''s usergroup when forming the result set.', 0, 82, 'Usergroup Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (816, 'admin_users_pm_joined', 'Joined Before:', 0, 82, 'Join Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (817, 'admin_users_pm_joined_desc', 'This will filter out the results to users who have registered before the date specified. To have the search ignore this criteria, simply omitt either the year or day fields.', 0, 82, 'Join Date Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (818, 'admin_users_pm_logged', 'Days Since Last Visit:', 0, 82, 'Last Visit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (819, 'admin_users_pm_logged_desc', 'This will filter the result set to users who haven''t logged on to your community in duration (in days) specified here. Leave as <strong>0</strong> for the search to ignore this.', 0, 82, 'Last Visit Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (820, 'users_lastvisit', 'Last Visit', 0, 67, 'Last Visit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (821, 'global_invalidDate', 'Invalid Date/Time', 0, 64, 'Invalid Date/Time', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (822, 'admin_users_pm_moveTo', 'Move To', 0, 82, 'Move To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (823, 'admin_users_pm_move', 'Move', 0, 82, 'Move', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (824, 'admin_users_pm_move_areYouSure', 'Are you sure you want to move the selected users?', 0, 82, 'Move Are You Sure', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (825, 'users_usergroup', 'Usergroup', 0, 67, 'Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (826, 'admin_users_ip', 'Search User IP Addresses', 0, 83, 'Search User IP Addresses', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (827, 'admin_users_ip_ip', 'Search For Users By IP Address:', 0, 83, 'Search By IP', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (828, 'admin_users_ip_ip_desc', 'Enter a complete or partial IP Address here. A list of users will be shown that have logged on using the specified IP Address.', 0, 83, 'Search By IP Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (829, 'admin_users_ip_username', 'Search For IP Addresses By Username:', 0, 83, 'Search By Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (830, 'admin_users_ip_username_desc', 'This will allow you to locate all IP Addresses that a user has logged in under.', 0, 83, 'Search By Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (831, 'users_ip', 'IP Address', 0, 67, 'IP Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (832, 'admin_users_ip_ipResults', 'IP Search Results', 0, 83, 'IP Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (833, 'admin_users_ip_usernameResults', 'Username Search Results', 0, 83, 'Username Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (834, 'admin_users_pm_alert', 'You cannot modify this users status via this method because of one of the following reasons:\\n\\n- This user is an Administrator\\n- This user is a Global Moderator\\n- This user is a Moderator\\n- This user is protected by the $uneditableUsers variable in the config.php file', 0, 82, 'Alert Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (835, 'admin_users_merge_into_desc', 'This is the user that will stay in tact, and all information from the specified account above will be transferred into this one.', 0, 84, 'Merge Into Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (836, 'admin_users_merge_into', 'Merge Above User Into:', 0, 84, 'Merge Into', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (837, 'admin_users_merge_merged', 'Merge User Into Below Account:', 0, 84, 'Merged', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (838, 'admin_users_merge_merged_desc', 'This is the account that will be merged into the one specified below. After all information is merged, this account will be deleted.', 0, 84, 'Merged Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (839, 'admin_users_merge', 'Merge Users', 0, 84, 'Merge Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (840, 'admin_users_mail_test', 'Test Email:', 0, 85, 'Test Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (841, 'admin_users_mail_test_desc', 'If this is enabled, this will only show you the results of the mass email, but will not actually send the email to the users.', 0, 85, 'Test Email Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (842, 'admin_users_mail', 'Mass Email Options', 0, 85, 'Mass Email Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (843, 'admin_options_information_adminContact', 'Administative Contact:', 0, 3, 'Admin Contact', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (844, 'admin_options_information_adminContact_desc', 'This is the administrative contact email address. It will be used to send board emails.', 0, 3, 'Admin Contact Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (845, 'admin_users_mail_mes', 'Email Message:', 0, 85, 'Email Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (846, 'admin_users_mail_mes_desc', 'This is the content of the email that will be sent to the users meeting the below criteria.<br /><br />\n\nYou may also use certain variables to personalize each email:<br /><br />\n\n<strong>$userid</strong> - Shows the userid<br />\n<strong>$username</strong> - Shows the username<br />\n<strong>$email</strong> - Shows the user''s email address', 0, 85, 'Email Message Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (847, 'admin_users_mail_sub', 'Subject:', 0, 85, 'Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (848, 'admin_users_mail_sub_desc', 'This is the subject of each email sent.', 0, 85, 'Subject Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (849, 'admin_users_mail_from', 'From:', 0, 85, 'From', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (850, 'admin_users_mail_from_desc', 'This is the email address used to show who has sent the email.', 0, 85, 'From Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (851, 'admin_users_mail_num', 'Number of Emails to Send at Once:', 0, 85, 'Number of Emails', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (852, 'admin_users_mail_num_desc', 'This is the number of emails that will be sent in each batch. This will help prevent from mail overflow.', 0, 85, 'Number of Emails Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (853, 'admin_users_mail_status', 'Email Status', 0, 85, 'Email Status', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (854, 'admin_users_mail_status_success', 'Success', 0, 85, 'Success', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (855, 'admin_users_mail_status_failed', '<span class="important">Failed</span>', 0, 85, 'Failed', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (856, 'admin_users_mail_nextBatch', 'Send Next Batch', 0, 85, 'Next Batch', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (857, 'admin_users_mail_backToEmail', 'Go Back to Mass Email Search Page', 0, 85, 'Back to Mass Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (858, 'admin_nav_forums_title', 'Forums/Moderators', 0, 86, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (859, 'admin_nav_forums_add', 'Add Forum', 0, 86, 'Add Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (860, 'admin_nav_forums_manager', 'Forum Manager', 0, 86, 'Forum Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (861, 'admin_nav_forums_perms', 'Forum Permissions', 0, 86, 'Forum Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (862, 'admin_nav_forums_addMod', 'Add Moderator', 0, 86, 'Add Moderator', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (863, 'admin_nav_forums_showMods', 'Show All Moderators', 0, 86, 'Show All Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (864, 'admin_usergroups_admins_forums', 'Forums & Moderators:', 0, 72, 'Forums & Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (865, 'admin_forums_add', 'Add Forum', 0, 88, 'Add Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (866, 'admin_forums_edit', 'Edit Forum', 0, 88, 'Edit Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (867, 'admin_forums_noParent', 'No Parent Forum', 0, 87, 'No Parent Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (868, 'admin_forums_ae_name', 'Forum Name:', 0, 88, 'Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (869, 'admin_forums_ae_name_desc', 'This is the name of the forum, and how it will be referenced to throughout your community.', 0, 88, 'Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (870, 'admin_forums_ae_desc', 'Forum Description:', 0, 88, 'Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (871, 'admin_forums_ae_desc_desc', 'This is the description for this forum, and will be displayed underneathe the forum name on the forum list.', 0, 88, 'Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (872, 'admin_forums_ae_order', 'Display Order:', 0, 88, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (873, 'admin_forums_ae_order_desc', 'This field allows you to control where this forum is placed on the forum list. <strong>Note: This is not the global display order of all forums, this number is relative to other forums on the same level of this forum with the same parent forum.</strong>', 0, 88, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (874, 'admin_forums_ae_viewAge', 'View Age:', 0, 88, 'View Age', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (875, 'admin_forums_ae_viewAge_desc', 'This is the cut off (in days) for threads listed in the forum. Any threads older than the specified amount of days will not be shown by default. This setting will not override a user''s setting, but only the default setting set in wtcBB Options.', 0, 88, 'View Age Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (876, 'admin_forums_ae_parent', 'Parent Forum:', 0, 88, 'Parent Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (877, 'admin_forums_ae_parent_desc', 'You can set the parent forum for this forum here. If you want to make this forum a top-level forum, simply select "No Parent Forum".', 0, 88, 'Parent Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (878, 'admin_forums_ae_generalInfo', 'General Information', 0, 88, 'General Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (879, 'admin_forums_ae_pass', 'Forum Password:', 0, 88, 'Forum Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (880, 'admin_forums_ae_pass_desc', 'This is the password that will be required to gain entry to this forum. All users will be prompted for a password. If you do not want to password protect this forum, leave this field empty.', 0, 88, 'Forum Password Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (881, 'admin_forums_ae_link', 'Link:', 0, 88, 'Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (882, 'admin_forums_ae_link_desc', 'If you would like for this forum to become a link, enter the URL here. Leave this field empty for the forum to retain normal behavior. (Note: When a forum becomes a link, no posts can be made or viewed, and when it is attempted to be viewed the viewer will be redirected to this link.)', 0, 88, 'Link Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (883, 'admin_forums_ae_style', 'Style:', 0, 88, 'Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (884, 'admin_forums_ae_style_desc', 'If you would like to set a default style for this forum that is different from your global default style, you may set it here. Select "Use Forum Default" for this option to have no effect.', 0, 88, 'Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (885, 'admin_forums_ae_override', 'Override User Selected Style:', 0, 88, 'Override Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (886, 'admin_forums_ae_override_desc', 'If this is enabled, the style selected above (if it isn''t "Use Forum Default") will be forced upon the user, no matter what setting the user has.', 0, 88, 'Override Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (887, 'admin_forums_ae_config', 'Forum Configuration', 0, 88, 'Forum Configuration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (888, 'admin_forums_ae_type', 'Forum Type', 0, 88, 'Forum Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (889, 'admin_forums_ae_cat', 'Is Category:', 0, 88, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (890, 'admin_forums_ae_cat_desc', 'If this is set to yes, this forum will become a category. Generally categories are used to group other forums together. A category cannot directly contain posts, nor can any posts existing in a category be viewed.', 0, 88, 'Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (891, 'admin_forums_ae_act', 'Is Active:', 0, 88, 'Active', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (892, 'admin_forums_ae_act_desc', 'If this is disabled, this forum will simply not be displayed. It will be like this forum has been deleted.', 0, 88, 'Active Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (893, 'admin_forums_ae_open', 'Is Open:', 0, 88, 'Open', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (894, 'admin_forums_ae_open_desc', 'If this is disabled, the forum and the threads &amp; posts contained inside of it will still be viewable. However, no new posts or threads will be accepted.', 0, 88, 'Open Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (895, 'admin_forums_ae_count', 'Count Posts:', 0, 88, 'Count Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (896, 'admin_forums_ae_count_desc', 'If this is disabled, posts made in this forum will not be added to a user''s post count.', 0, 88, 'Count Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (897, 'admin_forums_ae_jump', 'Show on Forum Jump:', 0, 88, 'Forum Jump', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (898, 'admin_forums_ae_jump_desc', 'If this is disabled, this forum will not be listed on the forum jump selection menu at the bottom of each page (if the forum jump is enabled).', 0, 88, 'Forum Jump Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (899, 'admin_forums_ae_perms', 'Forum Permissions', 0, 88, 'Forum Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (900, 'admin_usergroups_ae_bb', 'Allow BB Code:', 0, 70, 'Allow BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (901, 'admin_usergroups_ae_smilies', 'Allow Emoticons:', 0, 70, 'Allow Emoticons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (902, 'admin_usergroups_ae_img', 'Allow Images:', 0, 70, 'Allow Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (903, 'admin_usergroups_ae_icons', 'Allow Post Icons:', 0, 70, 'Allow Post Icons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (906, 'admin_forums_man', 'Forum Manager', 0, 89, 'Forum Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (907, 'admin_forums_man_name', 'Forum Name', 0, 89, 'Forum Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (908, 'admin_forums_man_disOrder', 'Display Order', 0, 89, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (909, 'admin_forums_man_mods', 'Moderators', 0, 89, 'Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (910, 'admin_forums_man_add', 'Add Forum', 0, 89, 'Add Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (911, 'admin_forums_man_addMod', 'Add Moderator', 0, 89, 'Add Moderator', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (912, 'admin_forums_man_addAnnounce', 'Add Announcement', 0, 89, 'Add Announcement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (913, 'admin_forums_man_addChild', 'Add Child Forum', 0, 89, 'Add Child Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (914, 'admin_forums_man_saveDis', 'Save Display Order', 0, 89, 'Save Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (915, 'admin_error_childOfChild', 'Sorry, but you are attempting to make this a child of one of its current childs. You cannot do this.', 0, 6, 'Can''t Make Child of Child', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (919, 'admin_forums_mods_add', 'Add Moderator', 0, 90, 'Add Moderator', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (920, 'admin_forums_mod_ae_doNotChange', 'Do Not Change Usergroup', 0, 90, 'Do Not Change Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (921, 'admin_forums_mods_ae_setup', 'Setup', 0, 90, 'Setup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (922, 'admin_forums_mod_ae_user', 'Moderator Username:', 0, 90, 'Moderator Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (923, 'admin_forums_mod_ae_user_desc', 'This is the username of the user you wish to make a moderator.', 0, 90, 'Moderator Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (924, 'admin_forums_mod_ae_forum', 'Forum:', 0, 90, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (925, 'admin_forums_mod_ae_forum_desc', 'You can select which forum(s) you wish this moderator to have moderator privileges in.', 0, 90, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (926, 'admin_forums_mod_ae_changeGroup', 'Change Usergroup:', 0, 90, 'Change Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (927, 'admin_forums_mod_ae_changeGroup_desc', 'This option is useful if you are promoting a "Registered User" to a "Moderator." With this option, you can automatically move this user to the "Moderators" usergroup, and make this user a moderator in one step.', 0, 90, 'Change Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (928, 'admin_forums_mod_ae_subs', 'Moderate Sub-Forums:', 0, 90, 'Moderate Subs', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (929, 'admin_forums_mod_ae_subs_desc', 'If this is disabled, this moderator will only moderate the forum you assign, and his/her privileges will not automatically inherit to sub-forums.', 0, 90, 'Moderate Subs Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (930, 'admin_forums_mod_ae_forumPrivs', 'Forum Privileges', 0, 90, 'Forum Privileges', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (931, 'admin_forums_mod_ae_editPosts', 'Edit Posts:', 0, 90, 'Edit Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (932, 'admin_forums_mod_ae_editPosts_desc', 'If this is disabled, this moderator will not be permitted to edit posts in this forum.', 0, 90, 'Edit Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (933, 'admin_forums_mod_ae_editThreads', 'Edit Threads:', 0, 90, 'Edit Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (934, 'admin_forums_mod_ae_editThreads_desc', 'If this is disabled, moderators will not be permitted to edit threads in this forum. Editing threads entales changing the thread title, the post icons, and leaving notes.', 0, 90, 'Edit Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (935, 'admin_forums_mod_ae_editPolls', 'Edit Polls:', 0, 90, 'Edit Polls', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (936, 'admin_forums_mod_ae_editPolls_desc', 'If this is disabled, this moderator will not be able to edit polls in this forum. Editing a poll grants permission to change the vote choices, who voted, and the vote counts.', 0, 90, 'Edit Polls Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (937, 'admin_forums_mod_ae_delete', 'Delete Posts/Threads:', 0, 90, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (938, 'admin_forums_mod_ae_delete_desc', 'If this is disabled, this moderator will not be able to delete posts or threads in this forum.', 0, 90, 'Delete Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (939, 'admin_forums_mod_ae_permDelete', 'Permanently Delete:', 0, 90, 'Permanently Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (940, 'admin_forums_mod_ae_permDelete_desc', 'If this is enabled, this moderator will be able to <em>permanently delete</em> posts and threads from this forum. Permanently deleting translates into completely wiping it from the database. Whereas regular deleting simply hides it from users who don''t have rights (''View Deletion Notices'') to see it.', 0, 90, 'Permanently Delete Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (941, 'admin_forums_mod_ae_openClose', 'Open/Close Threads:', 0, 90, 'Open/Close', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (942, 'admin_forums_mod_ae_openClose_desc', 'If this is disabled, this moderator will not be able to open or close threads in this forum.', 0, 90, 'Open/Close Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (943, 'admin_forums_mod_ae_move', 'Move Threads:', 0, 90, 'Move', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (944, 'admin_forums_mod_ae_move_desc', 'If this is disabled, this moderator will not be able to move threads from this forum into another one.', 0, 90, 'Move Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (945, 'admin_forums_mod_ae_merge', 'Merge Threads:', 0, 90, 'Merge', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (946, 'admin_forums_mod_ae_merge_desc', 'If this is disabled, this moderator will not be able to merge two threads into one in this forum.', 0, 90, 'Merge Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (947, 'admin_forums_mod_ae_split', 'Split Threads:', 0, 90, 'Split', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (948, 'admin_forums_mod_ae_split_desc', 'If this is disabled, this moderator will not be able to split one thread into two in this forum.', 0, 90, 'Split Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (949, 'admin_forums_mod_ae_ip', 'View IP Address:', 0, 90, 'IP', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (950, 'admin_forums_mod_ae_ip_desc', 'If this is disabled, this moderator will not be able view users'' IP addresses in this forum.', 0, 90, 'IP Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (951, 'admin_forums_mod_ae_modPanel', 'Moderator Control Panel Privileges', 0, 90, 'Moderator Panel Privileges', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (952, 'admin_forums_mod_ae_access', 'Control Panel Access:', 0, 90, 'Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (953, 'admin_forums_mod_ae_access_desc', 'If this is disabled, this moderator will be denied access to the Moderator Control Panel.', 0, 90, 'Access Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (954, 'admin_forums_mod_ae_announce', 'Make Announcements:', 0, 90, 'Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (955, 'admin_forums_mod_ae_announce_desc', 'If this is enabled, this moderator will be able to add/edit/delete announcements for this forum only.', 0, 90, 'Announcements Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (956, 'admin_forums_mod_ae_massMove', 'Mass Move Threads:', 0, 90, 'Mass Move', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (957, 'admin_forums_mod_ae_massMove_desc', 'If this is enabled, this moderator will be able to mass move threads from this forum to another one.', 0, 90, 'Mass Move Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (958, 'admin_forums_mod_ae_massPrune', 'Mass Prune Threads/Posts:', 0, 90, 'Mass Prune', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (959, 'admin_forums_mod_ae_massPrune_desc', 'If this is enabled, this moderator will be able to mass delete posts or threads in this forum.', 0, 90, 'Mass Prune Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (960, 'admin_forums_mod_ae_profile_desc', 'If this is disabled, this moderator will not be able to view a users full profile in the control panel.', 0, 90, 'Profile Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (961, 'admin_forums_mod_ae_profile', 'View Users'' Full Profile:', 0, 90, 'Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (962, 'admin_forums_mod_ae_ban', 'Ban Users:', 0, 90, 'Ban', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (963, 'admin_forums_mod_ae_ban_desc', 'If this is enabled, this moderator will be able to ban users from the moderator control panel. (Note: This is not referring to banishment from the community as a whole, but rather, banishment from the forum that this moderator has been granted privileges to.)', 0, 90, 'Ban Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (964, 'admin_forums_mod_ae_restore', 'Restore Users:', 0, 90, 'Restore', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (965, 'admin_forums_mod_ae_restore_desc', 'If this is enabled, this moderator will be able to restore users to be able to view this forum.', 0, 90, 'Restore Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (966, 'admin_forums_mod_ae_sigs', 'Edit User Signatures:', 0, 90, 'Signatures', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (967, 'admin_forums_mod_ae_sigs_desc', 'If this is enabled, this moderator will be able to edit user signatures from the control panel.', 0, 90, 'Signatures Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (968, 'admin_forums_mod_ae_avs', 'Edit User Avatars:', 0, 90, 'Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (969, 'admin_forums_mod_ae_avs_desc', 'If this is enabled, this moderator will be able to change user avatars.', 0, 90, 'Avatars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (970, 'admin_forums_mod_ae_emailPosts', 'Receive Post Email Notification:', 0, 90, 'Email Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (971, 'admin_forums_mod_ae_emailPosts_desc', 'If this is enabled, this moderator will receive an email notification every time a post is made in this forum.', 0, 90, 'Email Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (972, 'admin_forums_mod_ae_emailThreads', 'Receive Thread Email Notification:', 0, 90, 'Email Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (973, 'admin_forums_mod_ae_emailThreads_desc', 'If this is enabled, this moderator will receive an email notification for every new thread created in this forum.', 0, 90, 'Email Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (974, 'admin_forums_mods_ae_emailNotif', 'Email Notifications', 0, 90, 'Email Notifications', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (975, 'admin_error_selectForum', 'You must select at least one forum for this moderator to gain moderator privileges for.', 0, 6, 'Select a Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (976, 'admin_forums_man_modMenu', '-- Moderators --', 0, 89, 'Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (977, 'admin_forums_mods_edit', 'Edit Moderator', 0, 90, 'Edit Moderator', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (978, 'admin_forums_man_noMods', 'Add Moderator', 0, 89, 'No Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (979, 'admin_users_viewInfo', 'View User Info', 0, 59, 'View Info', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (980, 'admin_forums_mods_all', 'All Moderators', 0, 90, 'All Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (981, 'admin_forums_mods_moddedForums', 'Forums', 0, 90, 'Forums', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (984, 'admin_nav_forums_block', 'User Forum Access', 0, 86, 'User Forum Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (983, 'admin_forums_mods_removeAll', 'Remove Moderator From All Forums', 0, 90, 'Remove Mod From All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (985, 'admin_forums_block_username', 'Username:', 0, 91, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (986, 'admin_forums_block_username_desc', 'Please enter the username of the user you would like to grant access/block from forums.', 0, 91, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (987, 'admin_forums_block', 'User Forum Access', 0, 91, 'User Forum Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (988, 'admin_inherit', 'Inherit', 0, 5, 'Inherit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (989, 'admin_forums_block_accessLvl', 'Access Level', 0, 91, 'Access Level', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (990, 'admin_forums_block_msg', 'Please note that this is the ultimate override. If you have a specific forum set to "No", that user account will not be able to view that forum no matter what. The opposite goes if a specific forum is set to "Yes". If a forum is set to "Inherit", then the access level for that forum will be ignored (this is the default action). Unless overridden, child forums will inherit their parent forums setting.', 0, 91, 'Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (991, 'admin_error_lastForum', 'Sorry, but you cannot delete the last forum. At least one forum is required to exist for wtcBB to run properly.', 0, 6, 'Last Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (992, 'admin_users_ae_opts_access', 'Forum Access', 0, 60, 'Forum Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (993, 'admin_forums_perms', 'Forum Permissions', 0, 92, 'Forum Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (994, 'admin_forums_perms_keyBlack', 'Black - Inherits normal permissions.', 0, 92, 'Key Black', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (995, 'admin_forums_perms_keyRed', 'Red - Has custom permissions (not inherited).', 0, 92, 'Key Red', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (996, 'admin_forums_perms_keyBlue', 'Blue - Has custom permissions that have been inherited.', 0, 92, 'Key Blue', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (997, 'admin_forums_perms_groupName', 'Usergroup Name', 0, 92, 'Usergroup Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (998, 'admin_forums_mod_ae_modThreads', 'Supervise Threads:', 0, 90, 'Supervise Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (999, 'admin_forums_mod_ae_modThreads_desc', 'If this is enabled, this moderator will be able to "Approve" or "Disapprove" any threads made by users whose threads require supervision before they are posted.', 0, 90, 'Supervise Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1000, 'admin_forums_mod_ae_modPosts', 'Supervise Posts:', 0, 90, 'Supervise Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1001, 'admin_forums_mod_ae_modPosts_desc', 'If this is enabled, this moderator will be able to "Approve" or "Disapprove" any posts made by users whose posts require supervision before they are posted.', 0, 90, 'Supervise Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1002, 'admin_usergroups_ae_supervision', 'Thread/Post Supervision', 0, 70, 'Thread/Post Supervision', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1003, 'admin_usergroups_ae_supPosts', 'Posts Under Supervision:', 0, 70, 'Supervise Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1004, 'admin_usergroups_ae_supPosts_desc', 'If this is enabled, posts made by users of this group will be entered into a que (of which, moderators with access and administrators will be able to access). While posts are in this que, they will not be displayed on the message board. They will stay in the que until someone with access approves the post (it shows in the forum), or disapproves of the post (the post is deleted).', 0, 70, 'Supervise Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1005, 'admin_usergroups_ae_supThreads_desc', 'If this is enabled, threads made by users of this group will be entered into a que (of which, moderators with access and administrators will be able to access). While threads are in this que, they will not be displayed on the message board. They will stay in the que until someone with access approves the thread (it shows in the forum), or disapproves of the thread (the thread is deleted from the database).', 0, 70, 'Supervise Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1006, 'admin_usergroups_ae_supThreads', 'Threads Under Supervision:', 0, 70, 'Supervise Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1007, 'admin_cron_log_optimized', 'Optimized', 0, 81, 'Optimized Tables', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1008, 'admin_forums_perms_ae_setup', 'Setup', 0, 92, 'Setup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1009, 'admin_forums_perms_add', 'Add Forum Permission', 0, 92, 'Add Forum Permission', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1010, 'admin_forums_perms_ae_group', 'Usergroup:', 0, 92, 'Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1011, 'admin_forums_perms_ae_group_desc', 'This is the usergroup that the following permissions will be applied to.', 0, 92, 'Usergroup Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1012, 'admin_forums_perms_ae_forum', 'Forum:', 0, 92, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1013, 'admin_forums_perms_ae_forum_desc', 'This is the forum that the below permissions will be applied to. <strong>Remember, permissions are inherited to child forums. It''s much more managable to add permissions to a parent forum, and let them inherit to their child forums, instead of creating custom permissions for each child forum.', 0, 92, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1014, 'admin_forums_perms_ae_forumViewing', 'Forum Viewing', 0, 92, 'Forum Viewing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1015, 'admin_forums_perms_ae_forumAccess', 'Forum Access', 0, 92, 'Forum Access', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1016, 'admin_error_noGroupOrForum', 'Sorry, but you must at least select one usergroup <strong>and</strong> one forum to apply these permissions to.', 0, 6, 'No Group or Forum Selected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1017, 'admin_forums_perms_ae_viewBoard', 'View Forum:', 0, 92, 'View Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1018, 'admin_forums_perms_ae_viewBoard_desc', 'If this is disabled, users will not be able to see the forum at all (it will appear as though it doesn''t exist).', 0, 92, 'View Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1019, 'admin_forums_perms_edit', 'Edit Forum Permission', 0, 92, 'Edit Forum Permission', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1020, 'admin_error_doublePerms', 'Sorry, but forum permissions for the selected usergroup and forum already exist.', 0, 6, 'Double Permission', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1021, 'admin_nav_announce_title', 'Announcements', 0, 93, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1022, 'admin_nav_announce_add', 'Add Announcement', 0, 93, 'Add Annnouncement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1023, 'admin_nav_announce_manager', 'Announcements Manager', 0, 93, 'Announcements Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1024, 'admin_usergroups_admins_announcements', 'Announcements:', 0, 72, 'Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1025, 'admin_announce_add', 'Add Announcement', 0, 95, 'Add Announcement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1026, 'admin_announce_ae_config', 'Announcement Configuration', 0, 95, 'Announcement Config', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1027, 'admin_announce_ae_announcement', 'Announcement Text', 0, 95, 'Announcement Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1028, 'admin_announce_ae_title', 'Title:', 0, 95, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1029, 'admin_announce_ae_title_desc', 'This is the title of this announcement, and this will be used to reference this announcement in your community.', 0, 95, 'Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1030, 'admin_allForums', 'All Forums', 0, 5, 'All Forums', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1031, 'admin_announce_ae_forum', 'Forum:', 0, 95, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1032, 'admin_announce_ae_forum_desc', 'This is the forum that this announcement will be displayed it. Select "All Forums" for this announcement to be displayed in all forums.', 0, 95, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1033, 'admin_announce_ae_dateStart', 'Start Date:', 0, 95, 'Start Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1034, 'admin_announce_ae_dateStart_desc', 'This announcement will not be displayed on your community until this date.', 0, 95, 'Start Date Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1035, 'admin_announce_ae_dateEnd', 'End Date:', 0, 95, 'End Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1036, 'admin_announce_ae_dateEnd_desc', 'This announcement will only be displayed to your community <em>until</em> this date.', 0, 95, 'End Date Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1037, 'admin_announce_ae_bb', 'BB Code:', 0, 95, 'BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1038, 'admin_announce_ae_bb_desc', 'If this is disabled, BB Code will not be parsed.', 0, 95, 'BB Code Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1039, 'admin_announce_ae_smi', 'Emoticons:', 0, 95, 'Emoticons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1040, 'admin_announce_ae_smi_desc', 'If this is disabled, emoticons will not be displayed.', 0, 95, 'Emoticon Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1041, 'admin_announce_ae_html', 'HTML:', 0, 95, 'HTML', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1042, 'admin_announce_ae_html_desc', 'If this is enabled, HTML will be parsed.', 0, 95, 'HTML Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1043, 'admin_error_noTitle', 'Sorry, but you must provide a title to continue.', 0, 6, 'No Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1044, 'admin_error_invalidDates', 'You must specify valid dates in order to continue.', 0, 6, 'Invalid Dates', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1045, 'admin_announce_man', 'Announcements Manager', 0, 96, 'Announcements Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1046, 'admin_announce_man_announce', 'Announcements', 0, 96, 'Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1047, 'admin_lastUpdated', 'Last Updated', 0, 5, 'Last Updated', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1048, 'admin_announce_ae_inherit', 'Announcement Inherited in Sub-Forums:', 0, 95, 'Inherit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1049, 'admin_announce_ae_inherit_desc', 'If this is enabled, this announcement will also be displayed in all sub-forums of the selected forum in your community. This option is not applicable if this is a global announcement (all forums).', 0, 95, 'Inherit Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1050, 'admin_announce_man_specific', 'Forum Specific Announcements', 0, 96, 'Forum Specific Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1051, 'admin_announce_man_addGlobal', 'Add Global Announcement', 0, 96, 'Add Global Announcement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1052, 'admin_announce_man_global', 'Global Announcements', 0, 96, 'Global Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1053, 'admin_nav_logs_title', 'Logs', 0, 97, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1054, 'admin_nav_logs_admin', 'Administrators'' Log', 0, 97, 'Administrators'' Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1055, 'admin_nav_logs_mod', 'Moderators'' Log', 0, 97, 'Moderators'' Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1056, 'admin_nav_logs_cron', 'wtcBB Cron Log', 0, 97, 'wtcBB Cron Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1057, 'admin_usergroups_admins_logAdmin', 'Logs - Administrative', 0, 72, 'Logs - Administrative', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1058, 'admin_usergroups_admins_logMod', 'Logs - Moderator', 0, 72, 'Logs - Moderator', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1059, 'admin_usergroups_admins_logCron', 'Logs - wtcBB Cron', 0, 72, 'Logs - wtcBB Cron', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1060, 'admin_usergroups_admins_pruneLogs', 'Prune Logs:', 0, 72, 'Prune Logs', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1061, 'admin_log_admin', 'Administrative Logs', 0, 99, 'Administrative Logs', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1062, 'admin_log_view', 'View Log', 0, 98, 'View Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1063, 'admin_log_prune', 'Prune Log', 0, 98, 'Prune Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1064, 'admin_log_perpage', 'Log Entries Per Page', 0, 98, 'Log Entries Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1065, 'admin_log_perpage_desc', 'This is the number of log entries that will be shown per page. Be careful not to set this too high, as the larger this number is the longer it will take to load.', 0, 98, 'Log Entries Per Page Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1066, 'admin_allUsers', 'All Users', 0, 5, 'All Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1067, 'admin_log_admin_user', 'Only Show Log Entries Made By:', 0, 99, 'Made By', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1068, 'admin_log_admin_user_desc', 'You may narrow your log viewing down to a specific user by selecting the user here.', 0, 99, 'Made By Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1069, 'admin_log_allScripts', 'All Scripts', 0, 98, 'All Scripts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1070, 'admin_log_admin_script', 'Only Show Log Entries For This Script:', 0, 99, 'Script', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1071, 'admin_log_admin_script_desc', 'You can narrow down your log viewing by opting to view log entries generated by a specific script.', 0, 99, 'Script Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1072, 'admin_log_orderBy', 'Order By:', 0, 98, 'Order By', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1073, 'admin_log_orderBy_desc', 'This allows you to sort your logs for easier viewing.', 0, 98, 'Order By Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1074, 'admin_log_date', 'Date', 0, 98, 'Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1075, 'admin_log_username', 'Username', 0, 98, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1076, 'admin_log_ip', 'IP Address', 0, 98, 'IP Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1077, 'admin_log_admin_results', 'Administrative Log Search Results:', 0, 99, 'Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1078, 'admin_log_admin_showing', 'Showing Log Entries', 0, 99, 'Showing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1079, 'admin_log_logid', 'Log ID', 0, 98, 'Log ID', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1080, 'admin_log_admin_filePath', 'File Path', 0, 99, 'File Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1081, 'admin_log_admin_fileAction', 'File Action', 0, 99, 'File Action', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1082, 'global_page', 'Page', 0, 64, 'Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1083, 'global_of', 'of', 0, 64, 'Of', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1084, 'admin_log_delete', 'Delete Log Entries Made Before:', 0, 98, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1085, 'admin_log_delete_desc', 'You can select a date cut off in which entries will be pruned.', 0, 98, 'Delete Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1086, 'admin_log_cron_allCrons', 'All Crons', 0, 100, 'All Crons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1087, 'admin_log_cron', 'wtcBB Cron Log', 0, 100, 'wtcBB Cron Log', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1088, 'admin_log_cron_cron', 'Cron Script:', 0, 100, 'Cron Script', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1089, 'admin_log_cron_cron_desc', 'You can narrow your log entry viewing to any given cron script.', 0, 100, 'Cron Script Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1090, 'admin_log_cron_file', 'Filename', 0, 100, 'Filename', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1091, 'admin_log_cron_title', 'Cron Title', 0, 100, 'Cron Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1092, 'admin_log_cron_results', 'wtcBB Cron Log Search Results:', 0, 100, 'Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1093, 'admin_log_cron_cronResult', 'Results', 0, 100, 'Cron Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1094, 'admin_log_mod_allActions', 'All Moderator Actions', 0, 101, 'All Moderator Actions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1095, 'admin_log_mod_oAction', 'Moderator Action', 0, 101, 'Action', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1096, 'admin_log_mod_action', 'Moderator Action:', 0, 101, 'Moderator Action', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1097, 'admin_log_mod_action_desc', 'You may narrow down the entries you view to which type of moderator action.', 0, 101, 'Moderator Action Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1098, 'admin_log_mod_results', 'Moderator Log Search Results:', 0, 101, 'Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1099, 'admin_fileActions_Logs', 'Logs', 0, 102, 'Logs', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1100, 'admin_fileActions_Announcements', 'Announcements', 0, 102, 'Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1101, 'admin_fileActions_wtcBB-Cron-System', 'wtcBB Cron System', 0, 102, 'wtcBB Cron System', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1102, 'admin_fileActions_Forums/Moderators', 'Forums/Moderators', 0, 102, 'Forums/Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1103, 'admin_fileActions_Languages', 'Languages', 0, 102, 'Languages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1104, 'admin_fileActions_Options', 'Options', 0, 102, 'Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1105, 'admin_fileActions_Users', 'Users', 0, 102, 'Users', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1106, 'admin_fileActions_Usergroups', 'Usergroups', 0, 102, 'Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1107, 'admin_nav_attach_title', 'Attachments', 0, 105, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1108, 'admin_nav_attach_man', 'Extensions Manager', 0, 105, 'Extensions Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1109, 'admin_nav_attach_add', 'Add Extension', 0, 105, 'Add Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1110, 'admin_nav_attach_storageType', 'Attachment Storage Type', 0, 105, 'Attachment Storage Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1111, 'admin_nav_faq_title', 'FAQ', 0, 103, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1112, 'admin_nav_faq_man', 'FAQ Manager', 0, 103, 'FAQ Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1113, 'admin_nav_faq_add', 'Add FAQ Entry', 0, 103, 'Add FAQ Entry', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1114, 'admin_nav_ranks_man', 'Ranks Manager', 0, 104, 'Ranks Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1115, 'admin_nav_ranks_title', 'User Ranks', 0, 104, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1116, 'admin_nav_ranks_add', 'Add Rank', 0, 104, 'Add Rank', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1117, 'admin_usergroups_admins_faq', 'Manage Forum FAQ:', 0, 72, 'FAQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1118, 'admin_usergroups_admins_ranks', 'User Ranks:', 0, 72, 'User Ranks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1119, 'admin_usergroups_admins_attachments', 'Attachments:', 0, 72, 'Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1120, 'admin_ranks_add', 'Add Rank', 0, 107, 'Add Rank', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1121, 'admin_ranks_ae_rankTitle', 'Rank Title:', 0, 107, 'Rank Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1122, 'admin_ranks_ae_rankTitle_desc', 'This is the rank that will appear near a user''s username when posting if the minimum post requirement set below is met. HTML is allowed. (If you want to repeat an image a certain amount of times based on someone''s post count, use "User Images".)', 0, 107, 'Add Rank Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1123, 'admin_ranks_ae_minPosts', 'Minimum Posts:', 0, 107, 'Minimum Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1124, 'admin_ranks_ae_minPosts_desc', 'If a user meets this minimum post requirement, the above rank will be assigned to this user.', 0, 107, 'Minimum Posts Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1125, 'admin_ranks_man', 'Rank Manager', 0, 108, 'Rank Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1126, 'admin_ranks_man_rankTitle', 'Rank Title', 0, 108, 'Rank Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1127, 'admin_ranks_man_minPosts', 'Minimum Posts', 0, 108, 'Minimum Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1128, 'admin_ranks_edit', 'Edit Rank', 0, 107, 'Edit Rank', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1129, 'admin_nav_userImages_title', 'User Rank Images', 0, 109, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1130, 'admin_nav_userImages_add', 'Add User Rank Image', 0, 109, 'Add User Rank Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1131, 'admin_nav_userImages_man', 'User Rank Images Manager', 0, 109, 'User Rank Images Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1132, 'admin_usergroups_admins_ranks_images', 'User Rank Images', 0, 72, 'User Rank Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1133, 'admin_rankImages_man', 'User Rank ImagesManager', 0, 112, 'User Rank Images Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1134, 'admin_rankImages_ae_imgPath', 'Rank Image Path:', 0, 111, 'Rank Image Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1135, 'admin_rankImages_ae_imgPath_desc', 'This is the path to the image that will be used to repeat the specified number of times below.', 0, 111, 'Rank Image Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1136, 'admin_rankImages_ae_repeat', 'Image Repition:', 0, 111, 'Image Repition', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1137, 'admin_rankImages_ae_repeat_desc', 'This is the number of times that the image will be repeated.', 0, 111, 'Image Repition Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1138, 'admin_rankImages_ae_group', 'Usergroup:', 0, 111, 'Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1139, 'admin_rankImages_ae_group_desc', 'This will allow you to chose specifically which usergroup will have these ranks displayed. Select "All Usergroups" for these ranks to be displayed for everyone.', 0, 111, 'Usergroup Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1140, 'admin_rankImages_add', 'Add User Rank Image', 0, 111, 'Add User Rank Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1141, 'admin_rankImages_edit', 'Edit User Rank Image', 0, 111, 'Edit User Rank Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1142, 'admin_allGroups', 'All Usergroups', 0, 5, 'All Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1143, 'admin_fileActions_User-Ranks', 'User Ranks', 0, 102, 'User Ranks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1144, 'admin_fileActions_User-Rank-Images', 'User Rank Images', 0, 102, 'User Rank Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1145, 'admin_rankImages_man_imgs', 'Image(s) Shown', 0, 112, 'Image(s) Shown', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1146, 'admin_rankImages_man_minPosts', 'Minimum Posts', 0, 112, 'Minimum Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1147, 'admin_fileActions_Attachments', 'Attachments', 0, 102, 'Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1148, 'admin_attach_add', 'Add Attachment Extension', 0, 114, 'Add Attachment Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1149, 'admin_attach_edit', 'Edit Attachment Extension', 0, 114, 'Edit Attachment Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1150, 'admin_attach_ae_ext', 'Extension:', 0, 114, 'Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1151, 'admin_attach_ae_ext_desc', 'This is the actual extension that will be paired up with the given mime type(s) below (do not include the ''.'').', 0, 114, 'Extension Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1152, 'admin_attach_ae_size', 'Max Filesize:', 0, 114, 'Max Filesize', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1153, 'admin_attach_ae_size_desc', 'This is the maximum filesize of an attachment of this type that can be uploaded. Set to <strong>0</strong> to not have a limit.', 0, 114, 'Max Filesize Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1154, 'admin_attach_ae_height', 'Maximum Image Height:', 0, 114, 'Max Image Height', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1155, 'admin_attach_ae_height_desc', 'This is the maximum height dimension of this given attachment. Only applicable to attachments uploaded as images.', 0, 114, 'Max Image Height Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1156, 'admin_attach_ae_width', 'Maximum Image Width:', 0, 114, 'Max Image Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1157, 'admin_attach_ae_width_desc', 'This is the maximum width dimension of this given attachment. Only applicable to attachments uploaded as images.', 0, 114, 'Max Image Width Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1158, 'admin_attach_ae_enabled', 'Enabled:', 0, 114, 'Enabled', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1159, 'admin_attach_ae_enabled_desc', 'If this is set to "No", then it will be as if this attachment extension does not exist. Nobody will be permitted to upload an attachment matching the given extension and mime type.', 0, 114, 'Enabled Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1160, 'admin_attach_ae_mime', 'Mime Type:', 0, 114, 'Mime Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1161, 'admin_attach_ae_mime_desc', 'This is the mime type of this extension. For example, the mime type of a plain text document is "text/plain". You can associate multiple mime types for the specified attachment extension by separating each mime type by a carriage return (hit enter after each mime type).', 0, 114, 'Mime Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1162, 'admin_ext_man_ext', 'Extension', 0, 115, 'Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1163, 'admin_ext_man_size', 'Max Filesize (bytes)', 0, 115, 'Max Filesize', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1164, 'admin_ext_man_height', 'Max Height (pixels)', 0, 115, 'Max Height', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1165, 'admin_ext_man_width', 'Max Width (pixels)', 0, 115, 'Max Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1166, 'admin_ext_man_enabled', 'Enabled', 0, 115, 'Enabled', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1167, 'global_noLimit', 'No Limit', 0, 64, 'No Limit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1168, 'admin_ext_man', 'Extensions Manager', 0, 115, 'Extensions Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1169, 'admin_error_doubleExt', 'Sorry, but you cannot have more than one of the same extension. You can associate multiple mime types with a single extension by following the directions found in the description of the "Mime Type" field.', 0, 6, 'Double Extension', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1170, 'admin_attach_store', 'Attachment Storage Type', 0, 116, 'Attachment Storage Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1171, 'admin_attach_store_type', 'Store Attachments in File System:', 0, 116, 'Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1172, 'admin_attach_store_type_desc', 'This option allows you to chose where the attachments uploaded on your bulletin board are stored. It is generally recommended to store attachments in the file system (as the number of attachments grows, the overhead in database stored attachments grows, and thusly perforamce decreases). It may be useful to store attachments in the database for security reasons, if you''re moving your community to another account, or possibly because you have a small community and/or a small number of attachments. Selecting "Yes" he will store all attachments in the file system, and selecting "No" will store all attachments in the database. <strong>Note:</strong> this will move all current attachments over to the selected medium.', 0, 116, 'Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1173, 'admin_error_currMedium', 'Sorry, but the medium you have selected is already in effect.', 0, 6, 'Already Current Medium', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1174, 'admin_attach_store_fileSystem', 'Attachments are currently stored in the <em>File System</em>.', 0, 116, 'File System Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1175, 'admin_attach_store_database', 'Attachments are currently stored in the <em>database</em>.', 0, 116, 'Database Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1177, 'admin_users_ae_lang', 'Language:', 0, 60, 'Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1178, 'admin_users_ae_lang_desc', 'This is the language that will be used for this user. Select "Use Forum Default" for this user to use the language specified as the default language in the "Setup" area of "wtcBB Options".', 0, 60, 'Language Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1179, 'admin_faq_add', 'Add FAQ Entry', 0, 118, 'Add FAQ Entry', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1180, 'admin_faq_edit', 'Edit FAQ Entry', 0, 118, 'Edit FAQ Entry', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1181, 'admin_faq_ae_var', 'Variable Name:', 0, 118, 'Variable Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1182, 'admin_faq_ae_var_desc', 'This is the <em>variable</em> name of this FAQ entry, and will never actually be displayed to your users. This is used soley to correlate this FAQ entry with those in the language system. (For standards purposes, you should prefix all variable names for FAQ entries with "faq_".)', 0, 118, 'Variable Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1183, 'admin_faq_ae_order', 'Display Order:', 0, 118, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1184, 'admin_faq_ae_order_desc', 'This is the display order relative to it''s siblings (other FAQ entries with the same parent entry).', 0, 118, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1185, 'admin_faq_ae_parent', 'Parent FAQ Entry:', 0, 118, 'Parent Entry', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1186, 'admin_faq_ae_parent_desc', 'This is the parent FAQ entry of this entry. This serves as a way to organize your FAQ entries.', 0, 118, 'Parent Entry Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1187, 'admin_faq_ae_translations', 'Language Translations', 0, 118, 'Language Translations', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1188, 'admin_faq_ae_title', 'FAQ Entry Title:', 0, 118, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1189, 'admin_faq_ae_title_desc', 'This is the title of this FAQ entry for this language. End users <em>will</em> see this.', 0, 118, 'Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1190, 'admin_faq_ae_content', 'FAQ Entry Content:', 0, 118, 'Content', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1191, 'admin_faq_ae_content_desc', 'This is the actual content of this FAQ entry for this language.', 0, 118, 'Content Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1197, 'admin_error_allLangs', 'Sorry, but you must provide <em>at least</em> an FAQ entry title for <strong>each</strong> language.', 0, 6, 'All Languages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1206, 'faq_top__title', 'wtcBB FAQ', 1, 119, 'wtcBB FAQ - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1207, 'faq_support__title', 'Support', 1, 119, 'Support - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1208, 'admin_faq_man', 'FAQ Entry Manager', 0, 120, 'FAQ Entry Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1209, 'admin_faq_man_faqTitle', 'Title', 0, 120, 'FAQ Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1210, 'admin_faq_man_disOrder', 'Display Order', 0, 120, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1211, 'admin_faq_noParent', 'No FAQ Entry Parent', 0, 117, 'No FAQ Entry Parent', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1212, 'admin_error_noFaqWords', 'Sorry, but the language words for this FAQ entry have been deleted externally. You will need to delete and re-create this FAQ entry.', 0, 6, 'No FAQ Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1213, 'admin_faq_man_addChild', 'Add Child', 0, 120, 'Add Child', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1214, 'faq_bbcode__title', 'BB Code', 1, 119, 'BB Code - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1217, 'faq_support__content', 'If you need help, contact me.', 1, 119, 'Support - Content', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1221, 'faq_bbcode__content', 'xghh', 1, 119, 'BB Code - Content', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1224, 'faq_bbcode_url__title', 'URL', 1, 119, 'URL - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1225, 'faq_bbcode_url__content', 'Description of the URL BB Code.', 1, 119, 'URL - Content', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1228, 'faq_bbcode_img__title', 'IMG', 1, 119, 'IMG - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1229, 'faq_bbcode_img__content', 'Description of the IMG BB Code.', 1, 119, 'IMG - Content', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1232, 'admin_error_faqRoot', 'Sorry, but you cannot delete the FAQ Root entry. If you do not want the FAQ page to show on your message board, then you can disable it in the "Setup" section of "wtcBB Options".', 0, 6, 'FAQ Root', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1257, 'admin_rankImages_ae_imgUp_desc', 'You may also upload an image from your computer by clicking the "Browse" button and finding the image on your local computer. <strong>In order for this upload feature to work, the "ranks" folder inside the "images" folder must have writeable access (usually a chmod to "0777" will work).', 0, 111, 'Upload Image Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1256, 'admin_rankImages_ae_imgUp', '<em>OR</em> Upload Image:', 0, 111, 'Upload Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1255, 'admin_error_mustUploadImage', 'Sorry, but you are required to upload an image.', 0, 6, 'Must Upload Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1420, 'faq_support__content', 'Contact me for support.', 1, 119, 'Support - Content', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1419, 'faq_support__title', 'Support', 1, 119, 'Support - Title', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1258, 'admin_smilies_add', 'Add Smiley', 0, 122, 'Add Smiley', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1259, 'admin_smilies_edit', 'Edit Smiley', 0, 122, 'Edit Smiley', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1260, 'admin_smilies_ae_title', 'Smiley Name:', 0, 122, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1261, 'admin_smilies_ae_title_desc', 'This is the name of the smiley and is how it will be referenced.', 0, 122, 'Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1320, 'admin_icons_addMultiple', 'Add Multiple Post Icons', 0, 130, 'Add Multiple Post Icons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1262, 'admin_smilies_ae_filePath', 'File Path:', 0, 122, 'File Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1263, 'admin_smilies_ae_filePath_desc', 'This is the local file path location of the desired image for this smiley. You may also upload a smiley from your computer using the option below.', 0, 122, 'File Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1264, 'admin_smilies_ae_imgUp', 'Upload Smiley:', 0, 122, 'Upload Smiley', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1265, 'admin_smilies_ae_imgUp_desc', '<strong>OR</strong> you may upload a smiley here. This will put the image you upload in the <strong>images/smilies</strong> directory. Make sure that the directory is chmodded to <strong>0777</strong> on *nix operating systems.', 0, 122, 'Upload Smiley Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1266, 'admin_smilies_ae_replace', 'Replacement:', 0, 122, 'Replacement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1267, 'admin_smilies_ae_replace_desc', 'This is what will be used in plain text to represent this smiley. If smilies are enabled in the context of posting, this replacement text will be replaced with the actual smiley.', 0, 122, 'Replacement Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1268, 'admin_smilies_ae_disOrder', 'Display Order:', 0, 122, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1269, 'admin_smilies_ae_disOrder_desc', 'This is the order that this smiley will be displayed, relative to its group.', 0, 122, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1270, 'admin_nav_smilies_title', 'Smilies', 0, 123, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1271, 'admin_nav_smilies_man', 'Smiley Manager', 0, 123, 'Smiley Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1272, 'admin_nav_smilies_add', 'Add Smiley', 0, 123, 'Add Smiley', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1273, 'admin_nav_smilies_addMultiple', 'Add Multiple Smilies', 0, 123, 'Add Multiple Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1274, 'admin_nav_smilies_addGroup', 'Add Smiley Group', 0, 123, 'Add Smiley Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1275, 'admin_usergroups_admins_smilies', 'Smilies:', 0, 72, 'Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1276, 'admin_smilies_ae_group', 'Smiley Group:', 0, 122, 'Smiley Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1277, 'admin_smilies_ae_group_desc', 'This is the group that this smiley will belong to. Groups can be used to organized differing smiley sets, and they can also be hidden from desired usergroups.', 0, 122, 'Smiley Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1278, 'admin_smilies_addMultiple', 'Add Multiple Smilies', 0, 124, 'Add Multiple Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1279, 'admin_smilies_addMultiple_path', 'Directory:', 0, 124, 'Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1280, 'admin_smilies_addMultiple_path_desc', 'Please enter the local path to the directory containing smilies you would like to add. (<strong>Note:</strong> smilies that are already added in the database will not appear.)', 0, 124, 'Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1281, 'admin_error_noDir', 'Sorry, but you are required to enter a path to a directory. You either entered a path to a file, or a location that doesn''t exist.', 0, 6, 'Not a Directory', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1282, 'admin_smilies_addMultiple_img', 'Image', 0, 124, 'Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1283, 'admin_smilies_addMultiple_name', 'Smiley Name', 0, 124, 'Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1284, 'admin_smilies_addMultiple_disOrder', 'Display Order', 0, 124, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1285, 'admin_smilies_addMultiple_replace', 'Replacement', 0, 124, 'Replacement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1286, 'admin_smilies_addMultiple_details', 'This screen will show you all images contained inside the directory path you entered (except for smilies already in the database). You can chose to <strong>not</strong> add an image as a smiley by omitting <em>either</em> the "Smiley Name" or "Replacement" fields, or by unticking the checkbox to the left of any image.', 0, 124, 'Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1287, 'admin_smilies_addMultiple_group', 'Select Smiley Group', 0, 124, 'Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1288, 'admin_smilies_addMultiple_group_desc', 'This is the group that the following added smilies will belong to. Groups can be used to organized differing smiley sets, and they can also be hidden from desired usergroups.', 0, 124, 'Smiley Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1289, 'admin_groups_ae_add', 'Add Group', 0, 125, 'Add Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1290, 'admin_groups_ae_edit', 'Edit Group', 0, 125, 'Edit Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1291, 'admin_groups_ae_name', 'Group Name:', 0, 125, 'Group Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1292, 'admin_groups_ae_name_desc', 'This is the name of the group and this is also how this group will be referenced throughout your bulletin board.', 0, 125, 'Group Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1293, 'admin_groups_ae_usergroup', 'Usergroups:', 0, 125, 'Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1294, 'admin_groups_ae_usergroup_desc', 'These are the usergroups that are allowed to use the smilies contained in this group. Please note that only people in the selected usergroup(s) will be able to use it <strong>and</strong> see it. Therefore, it will look like plain text to users outside of the selected usergroups. Select all usergroups to have this group shown to everybody.', 0, 125, 'Usergroups Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1295, 'admin_error_cannotDelGroup', 'Sorry, but this group cannot be deleted, as it is required for the message board to function correctly.', 0, 6, 'Cannot Delete Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1296, 'admin_error_mustSelectGroup', 'Sorry, but you must select at least one usergroup.', 0, 6, 'Must Select Usergroup', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1297, 'admin_smilies_man', 'Smiley Manager', 0, 126, 'Smiley Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1298, 'admin_smilies_man_img', 'Smiley Image', 0, 126, 'Smiley Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1299, 'admin_smilies_man_disOrder', 'Display Order', 0, 126, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1300, 'admin_smilies_man_replacement', 'Text Replacement', 0, 126, 'Replacement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1301, 'admin_smilies_man_groupName', 'Group Name', 0, 126, 'Group Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1303, 'admin_smilies_delete_msg', 'Deleting this smiley group will also delete all smilies belonging to this group from the database. The smiley images however, will remain in their current location.', 0, 121, 'Delete Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1305, 'admin_usergroups_admins_posticons', 'Post Icons:', 0, 72, 'Post Icons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1306, 'admin_nav_icons_title', 'Post Icons', 0, 127, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1307, 'admin_nav_icons_man', 'Post Icon Manager', 0, 127, 'Post Icon Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1308, 'admin_nav_icons_add', 'Add Post Icon', 0, 127, 'Add Post Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1309, 'admin_nav_icons_addMultiple', 'Add Multiple Post Icons', 0, 127, 'Add Multiple Post Icons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1310, 'admin_icons_add', 'Add Post Icon', 0, 129, 'Add Post Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1311, 'admin_icons_edit', 'Edit Post Icon', 0, 129, 'Edit Post Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1312, 'admin_icons_ae_title', 'Post Icon Name:', 0, 129, 'Post Icon Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1313, 'admin_icons_ae_title_desc', 'This is the name of the post icon and how it will be referenced (ie: if you hover over a post icon, you will see this name).', 0, 129, 'Post Icon Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1314, 'admin_icons_ae_filePath', 'File Path:', 0, 129, 'File Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1315, 'admin_icons_ae_filePath_desc', 'This is the local file path location of the desired image for this post icon. You may also upload a post icon from your computer using the option below.', 0, 129, 'File Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1316, 'admin_icons_ae_imgUp', 'Upload Post Icon:', 0, 129, 'Upload Post Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1317, 'admin_icons_ae_imgUp_desc', '<strong>OR</strong> you may upload a post icon here. This will put the image you upload in the <strong>images/icons</strong> directory. Make sure that the directory is chmodded to <strong>0777</strong> on *nix operating systems.', 0, 129, 'Upload Post Icon Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1318, 'admin_icons_ae_disOrder', 'Display Order:', 0, 129, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1319, 'admin_icons_ae_disOrder_desc', 'This is the order in which this post icon will be displayed.', 0, 129, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1321, 'admin_icons_addMultiple_path', 'Directory:', 0, 130, 'Directory', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1322, 'admin_icons_addMultiple_path_desc', 'Please enter the local path to the directory containing post icons you would like to add. (<strong>Note:</strong> post icons that are already in the database will not appear.)', 0, 130, 'Directory Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1323, 'admin_icons_addMultiple_img', 'Image', 0, 130, 'Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1324, 'admin_icons_addMultiple_name', 'Post Icon Name', 0, 130, 'Post Icon Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1325, 'admin_icons_addMultiple_disOrder', 'Display Order', 0, 130, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1326, 'admin_icons_addMultiple_details', 'This screen will show you all images contained inside the directory path you entered (except for post icons already in the database). You can chose to not add an image as a post icon by omitting the "Post Icon Name" field or by unticking the checkbox to the left of any image.', 0, 130, 'Post Icon Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1327, 'admin_icons_man', 'Post Icon Manager', 0, 131, 'Post Icon Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1328, 'admin_icons_man_img', 'Image', 0, 131, 'Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1330, 'admin_icons_man_disOrder', 'Display Order', 0, 131, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1331, 'admin_avatar_add', 'Add Avatar', 0, 133, 'Add Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1332, 'admin_avatar_edit', 'Edit Avatar', 0, 133, 'Edit Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1333, 'admin_avatar_ae_title', 'Avatar Name:', 0, 133, 'Avatar Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1334, 'admin_avatar_ae_title_desc', 'This is the name of the avatar and how it will be referenced. (This will also be the <strong>alt</strong> text, which is what appears when an image cannot be displayed or when you hover over an image.)', 0, 133, 'Avatar Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1335, 'admin_avatar_ae_filePath', 'File Path:', 0, 133, 'File Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1336, 'admin_avatar_ae_filePath_desc', 'You can specify a local file path to your desired avatar here.', 0, 133, 'File Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1337, 'admin_avatar_ae_imgUp', 'Upload Avatar', 0, 133, 'Upload Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1338, 'admin_avatar_ae_imgUp_desc', '<strong>OR</strong> you may upload an avatar from your computer here. Please make sure that the <strong>images/avatars</strong> folder is chmodded to <strong>0777</strong> on *nix systems.', 0, 133, 'Upload Avatar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1339, 'admin_avatar_ae_disOrder', 'Display Order', 0, 133, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1340, 'admin_avatar_ae_disOrder_desc', 'This is the order in which this avatar will be displayed in relation to it''s category.', 0, 133, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1341, 'admin_avatar_ae_group', 'Avatar Group', 0, 133, 'Avatar Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1342, 'admin_avatar_ae_group_desc', 'This grouping feature will enable you to organize your avatars for better usability on your user''s behalf. Also, groups can be hidden from desired usergroups.', 0, 133, 'Avatar Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1343, 'admin_usergroups_admins_avatars', 'Avatars:', 0, 72, 'Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1344, 'admin_nav_avatars_title', 'Avatars', 0, 136, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1345, 'admin_nav_avatars_man', 'Avatar Manager', 0, 136, 'Avatar Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1346, 'admin_nav_avatars_add', 'Add Avatar', 0, 136, 'Add Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1347, 'admin_nav_avatars_addMultiple', 'Add Multiple Avatars', 0, 136, 'Add Multiple Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1348, 'admin_nav_avatars_addGroup', 'Add Avatar Group', 0, 136, 'Add Avatar Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1349, 'admin_smilies_man_usergroups', 'Affected Usergroups', 0, 126, 'Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1350, 'admin_avatars_delete_msg', 'Deleting this avatar group will also delete all avatars belonging to this group from the database. The avatar images however, will remain in their current location.', 0, 132, 'Delete Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1351, 'admin_avatar_addMultiple', 'Add Multiple Avatars', 0, 135, 'Add Multiple Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1352, 'admin_avatar_addMultiple_path', 'Path:', 0, 135, 'Add Multiple Path', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1353, 'admin_avatar_addMultiple_path_desc', 'This is the <strong>local</strong> path in which wtcBB will look for avatars. You will be displayed a listing of avatars in this directory, except for avatars already added in the database.', 0, 135, 'Add Multiple Path Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1354, 'admin_avatar_addMultiple_details', 'This screen will show you all images contained inside the directory path you entered (except for avatars already in the database). You can chose to <strong>not</strong> add an image as an avatar by unticking the checkbox to the left of each image. If an avatar name is omitted, that avatar will also not be added- even if it is ticked.', 0, 135, 'Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1355, 'admin_avatar_addMultiple_group', 'Select Avatar Group', 0, 135, 'Avatar Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1356, 'admin_avatar_addMultiple_group_desc', 'This is the group that the following added avatars will belong to. Groups can be used to organize different avatar sets, and they can also be hidden from desired usergroups.', 0, 135, 'Avatar Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1357, 'admin_avatar_addMultiple_img', 'Image', 0, 135, 'Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1358, 'admin_avatar_addMultiple_name', 'Avatar Name', 0, 135, 'Avatar Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1359, 'admin_avatar_addMultiple_disOrder', 'Display Order', 0, 135, 'Dsiplay Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1360, 'admin_avatar_man_img', 'Image', 0, 134, 'Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1361, 'admin_avatar_man_disOrder', 'Display Order', 0, 134, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1362, 'admin_avatar_man_groupName', 'Group Name', 0, 134, 'Group Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1363, 'admin_avatar_man_usergroups', 'Affected Usergroups', 0, 134, 'Usergroups', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1364, 'admin_avatar_man', 'Avatar Manager', 0, 134, 'Avatar Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1365, 'admin_nav_restorePrefs', 'Restore', 0, 18, 'Restore', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1366, 'admin_usergroups_admins_maintenance', 'Maintenance:', 0, 72, 'Maintenance', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1367, 'admin_nav_main_title', 'Maintenance', 0, 137, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1368, 'admin_nav_main_cache', 'Cache Manager', 0, 137, 'Cache Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1369, 'admin_nav_main_query', 'Execute Query', 0, 137, 'Execute Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1370, 'admin_nav_main_counters', 'Update Database Information', 0, 137, 'Update Database Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1371, 'admin_maint_cache', 'Cache Manager', 0, 139, 'Cache Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1372, 'admin_maint_cache_cacheName', 'Cache Name', 0, 139, 'Cache Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1373, 'admin_maint_cache_cacheData', 'Cache Data', 0, 139, 'Cache Data', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1374, 'admin_maint_cache_trim', 'Trim Cache Data', 0, 139, 'Trim', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1375, 'admin_maint_cache_notrim', 'Don''t Trim Cache Data', 0, 139, 'Don''t Trim', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1376, 'admin_maint_cache_update', 'Update Cache', 0, 139, 'Update Cache', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1377, 'admin_maint_cache_clear', 'Clear Cache', 0, 139, 'Clear Cache', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1378, 'admin_maint_cache_updateAll', 'Update All Cache Data', 0, 139, 'Update All Cache Data', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1379, 'admin_maint_cache_clearAll', 'Clear All Cache Data', 0, 139, 'Clear All Cache Data', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1380, 'admin_maint_query', 'Execute Query', 0, 140, 'Execute Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1381, 'admin_usergroups_admins_styles', 'Styles:', 0, 72, 'Styles', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1382, 'admin_nav_style_title', 'Style System', 0, 142, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1383, 'admin_nav_style_man', 'Style Manager', 0, 142, 'Style Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1384, 'admin_nav_style_addTemplate', 'Add Template', 0, 142, 'Add Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1385, 'admin_nav_style_addTemplateGroup', 'Add Template Group', 0, 142, 'Add Template Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1386, 'admin_nav_style_addRepVar', 'Add Replacement Variable', 0, 142, 'Add Replacement Variable', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1387, 'admin_style_add', 'Add Style', 0, 143, 'Add Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1388, 'admin_style_edit', 'Edit Style', 0, 143, 'Edit Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1389, 'admin_style_noParent', 'No Parent Style', 0, 144, 'No Parent Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1390, 'admin_nav_style_add', 'Add Style', 0, 142, 'Add Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1391, 'admin_style_ae_name', 'Style Name:', 0, 144, 'Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1392, 'admin_style_ae_name_desc', 'This is the name of this style, and this is how it will be referenced throughout wtcBB.', 0, 144, 'Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1393, 'admin_style_ae_parent', 'Parent Style:', 0, 144, 'Parent Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1394, 'admin_style_ae_parent_desc', 'This is the parent style of this style. This new style will inherit all template modifications, color changes, and replacement variables from the specified parent style. You may also opt to have no parent and start out fresh.', 0, 144, 'Parent Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1395, 'admin_style_ae_disOrder', 'Display Order:', 0, 144, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1396, 'admin_style_ae_disOrder_desc', 'This is the display order of this style relating to it''s direct siblings. This will control the order in which this style is presented in any given list of styles.', 0, 144, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1397, 'admin_style_ae_selectable', 'User Selectable:', 0, 144, 'Selectable', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1398, 'admin_style_ae_selectable_desc', 'If this is enabled, then this style will be able to be selected for use via the User Control Panel (granted that the user has access to change styles). Keep in mind, that even if this style isn''t selectable it can still be accessed via the "styleid" variable in any URL on the bulletin board.', 0, 144, 'Selectable Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1399, 'admin_style_ae_enabled', 'Enabled:', 0, 144, 'Enabled', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1400, 'admin_style_ae_enabled_desc', 'This is different from the above option in that this completely disables this style from viewing by anyone other than Administrators (specified in usergroup settings). Disabled styles will not be listed nor will they be accessible via the "styleid" variable in a URL by anyone other than Administrators.', 0, 144, 'Enabled Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1401, 'admin_style_man', 'Style Manager', 0, 145, 'Style Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1402, 'admin_style_man_name', 'Style Name', 0, 145, 'Style Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1403, 'admin_style_man_disOrder', 'Display Order', 0, 145, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1404, 'admin_style_addTemplate', 'Add Template', 0, 143, 'Add Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1405, 'admin_style_editTemplate', 'Edit Template', 0, 143, 'Edit Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1406, 'admin_style_addChild', 'Add Child Style', 0, 143, 'Add Child Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1407, 'admin_style_man_templates', 'Manage Templates', 0, 145, 'Manage Templates', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1408, 'admin_style_man_colors', 'Colors &amp; Style Options', 0, 145, 'Colors &amp; Style Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1409, 'admin_style_man_repVars', 'Replacement Variables', 0, 145, 'Replacement Variables', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1410, 'admin_style_man_saveDis', 'Save Display Order', 0, 144, 'Save Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1411, 'admin_style_man_edit', 'Edit Style Information', 0, 145, 'Edit Style Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1412, 'admin_groups_noParent', 'No Parent Group', 0, 125, 'No Parent Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1413, 'admin_language_edit', 'Edit Language', 0, 22, 'Edit Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1414, 'admin_language_delete', 'Deleting this language group will also delete all language words belonging to this group from the database.', 0, 7, 'Delete Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1416, '1', 'Test', 1, 151, 'Sweet', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1417, 'sdg', 'sdghgsdh', 1, 153, 'Yarr', -1);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1425, 'admin_error_lastStyle', 'Sorry, but you cannot delete the last style. At least one style is required to exist for wtcBB to run properly.', 0, 6, 'Last Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1426, 'admin_groups_ae_parent', 'Parent Group:', 0, 125, 'Parent Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1427, 'admin_groups_ae_parentTemplate_desc', 'This is the parent group. This provides a way to neatly organize templates in a fashion that makes the system as a whole more extensible and easier to navigate.', 0, 125, 'Parent Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1428, 'admin_styles_delete', 'Are you sure you want to delete this style template group? All templates existing in this group (and child-groups) will be moved all into the "Custom Templates" group.', 0, 143, 'Delete Message (Groups)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1429, 'admin_style_templates_man', 'Templates for Style:', 0, 159, 'Template Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1430, 'admin_error_cannotDeleteGroup', 'Sorry, but wtcBB requires this group to preserve the functionality of the bulletin board.', 0, 6, 'Cannot Delete Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1431, 'admin_style_template_ae_add', 'Add Template', 0, 161, 'Add Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1432, 'admin_style_template_ae_edit', 'Edit Template', 0, 161, 'Edit Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1433, 'admin_style_template_ae_name', 'Template Name:', 0, 161, 'Template Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1434, 'admin_style_template_ae_name_desc', 'This is the name of the template and how it will be referenced throughout the style system and also how it will be accessed in the PHP code. It is usually best to prefix the name of the template with consistency of the rest of the templates (as in, specifying the parent group names delimited by underscores before the template name itself). This however is not required, but is simply suggested as a best practice.', 0, 161, 'Template Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1435, 'admin_style_template_ae_style', 'Style:', 0, 161, 'Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1436, 'admin_style_template_ae_style_desc', 'This is the style that this template will belong too. Remember, this style will be inherited into any child styles of the style that is selected here. Inherited templates override the standard default templates, but can also be overrided by editing the template itself in that style, or editing the same template further down the tree.', 0, 161, 'Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1437, 'admin_style_template_ae_group', 'Template Group:', 0, 161, 'Template Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1438, 'admin_style_template_ae_group_desc', 'This is the template group that this template will belong to. Template groups are for <em>organizational</em> purposes only. They serve as no extra functionality to the bulletin board, but rather a convenience when keeping hundreds of templates organized so they are easy to find.', 0, 161, 'Template Group Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1439, 'admin_style_template_ae_template', 'Template', 0, 161, 'Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1440, 'admin_nav_main_phpInfo', 'PHP Info', 0, 137, 'PHP Info', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1441, 'admin_fileActions_Maintenance', 'Maintenance', 0, 102, 'Maintenance', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1442, 'admin_fileActions_Style-System', 'Style System', 0, 102, 'Style System', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1443, 'admin_fileActions_FAQ', 'FAQ', 0, 102, 'FAQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1444, 'admin_fileActions_Avatars', 'Avatars', 0, 102, 'Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1445, 'admin_fileActions_Post-Icons', 'Post Icons', 0, 102, 'Post Icons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1446, 'admin_fileActions_Smilies', 'Smilies', 0, 102, 'Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1447, 'admin_style_template_viewDef', 'View Default Template', 0, 162, 'View Default Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1448, 'admin_style_template_viewDef_group', 'Template Group:', 0, 162, 'Template Group', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1449, 'admin_style_template_viewDef_name', 'Template Name:', 0, 162, 'Template Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1450, 'admin_style_template_viewDef_template', 'Template:', 0, 162, 'Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1451, 'admin_style_c_bgColor', 'Background Color:', 0, 179, 'Background Color', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1452, 'admin_style_c_fontColor', 'Font Color', 0, 179, 'Font Color', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1453, 'admin_style_c_fontFamily', 'Font Family:', 0, 179, 'Font Family', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1454, 'admin_style_c_fontSize', 'Font Size:', 0, 179, 'Font Size', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1455, 'admin_style_c_fontWeight', 'Font Weight:', 0, 179, 'Font Weight', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1456, 'admin_style_c_fontStyle', 'Font Style:', 0, 179, 'Font Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1457, 'admin_style_c_textDec', 'Text Decoration:', 0, 179, 'Text Decoration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1458, 'admin_style_c_extra', 'Extra Properties', 0, 179, 'Extra CSS Properties', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1459, 'admin_style_g_body', 'Body', 0, 180, 'Body', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1460, 'admin_style_g_page', 'Page', 0, 180, 'Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1461, 'admin_style_g_category', 'Category', 0, 180, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1462, 'admin_style_g_headerFooter', 'Header/Footer', 0, 180, 'Header/Footer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1463, 'admin_style_g_firstAlteration', 'First Alteration', 0, 180, 'First Alteration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1464, 'admin_style_g_secondAlteration', 'Second Alteration', 0, 180, 'Second Alteration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1465, 'admin_style_g_textInput', 'Text Input', 0, 180, 'Text Input', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1466, 'admin_style_g_radioCheck', 'Radio/Checkbox', 0, 180, 'Radio/Checkbox', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1467, 'admin_style_g_button', 'Button', 0, 180, 'Button', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1468, 'admin_style_g_selectMenu', 'Select Menu', 0, 180, 'Select Menu', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1469, 'admin_style_g_smallFont', 'Small Font', 0, 180, 'Small Font', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1470, 'admin_style_g_timeFont', 'Time Font', 0, 180, 'Time Font', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1477, 'admin_style_colors_note', '<strong>Note:</strong> You may browse between tabs without losing previously entered data.', 0, 179, 'Browse Between Tabs', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1472, 'admin_style_colors', 'Colors & Style Options', 0, 179, 'Colors & Style Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1473, 'admin_style_c_main', 'Main', 0, 179, 'Main', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1474, 'admin_style_c_regLink', 'Regular Link', 0, 179, 'Regular Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1475, 'admin_style_c_visitLink', 'Visited Link', 0, 179, 'Visited Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1476, 'admin_style_c_hoverLink', 'Hover Link', 0, 179, 'Hover Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1478, 'admin_style_colors_extraNote', '<em>Note:</em> These CSS declarations are placed inside the main selector group for this portion of the style. This means that if you incorporate curly braces ("{" and "}") into the code below, you may receive unexpected results. <span class="important">This is for advanced users only.</span>', 0, 179, 'Extra Properties Note', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1479, 'admin_style_key', 'Color Coding Key', 0, 181, 'Key', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1480, 'admin_style_key_blue', 'Blue - Default Template (Unchanged)', 0, 181, 'Blue - Default Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1481, 'admin_style_key_red', 'Red - Custom Template', 0, 181, 'Red - Custom Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1482, 'admin_style_key_green', 'Green - Inherited Template', 0, 181, 'Green - Inherited Template', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1483, 'admin_style_colors_cssCat', 'CSS Category:', 0, 179, 'CSS Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1484, 'admin_style_man_visual', 'Visual Settings', 0, 145, 'Visual Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1485, 'admin_style_v_pageWidth', 'Page Width:', 0, 182, 'Page Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1486, 'admin_style_v_innerWidth', 'Inner Page Width:', 0, 182, 'Inner Page Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1487, 'admin_style_v_docType', 'Document Type Definition:', 0, 182, 'Document Type Definition', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1488, 'admin_style_v_borderColor', 'Border Color:', 0, 182, 'Border Color', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1489, 'admin_style_v_borderStyle', 'Border Style:', 0, 182, 'Border Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1490, 'admin_style_v_borderWidth', 'Border Width:', 0, 182, 'Border Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1491, 'admin_style_v_images', 'Images Folder:', 0, 182, 'Images Folder', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1492, 'admin_style_v_padding', 'Padding:', 0, 182, 'Padding', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1493, 'admin_style_v_titleImage', 'Title Image:', 0, 182, 'Title Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1494, 'admin_style_visual', 'Visual Settings', 0, 182, 'Visual Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1496, 'admin_style_revert', 'Revert to Default', 0, 143, 'Revert to Default', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1497, 'admin_style_repVars', 'Replacement Variables', 0, 183, 'Replacement Variables', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1498, 'admin_style_r_none', 'Sorry, but no replacement variables exist. <a href="admin.php?file=style&do=addRepVar">Add a Replacement Variable.</a>', 0, 183, 'None Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1499, 'admin_style_repVars_add', 'Add Replacement Variable', 0, 183, 'Add Replacement Variable', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1500, 'admin_style_repVars_find', 'Text to Find', 0, 183, 'Text to Find', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1501, 'admin_style_repVars_replace', 'Text to Replace', 0, 183, 'Text to Replace', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1502, 'admin_style_repVars_cannotRevert', 'Inherited; Cannot Revert', 0, 183, 'Cannot Revert', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1503, 'admin_style_repVars_effect', 'Replacement variables are a way to automatically find and replace text throughout your community. These replacement variables affect all <strong>user</strong> text. That means posts, thread titles, personal messages, etc. Replacement variables are not applied to templates or any areas of the administration panel. Remember, the text will only be replaced for users using the appropriate style.', 0, 183, 'Effect', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1504, 'admin_nav_style_searchTemplates', 'Search Templates', 0, 142, 'Search Templates', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1505, 'admin_search_templates', 'Search Style Templates', 0, 185, 'Style Templates', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1506, 'admin_style_search_style', 'Style to Search:', 0, 185, 'Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1507, 'admin_style_search_style_desc', 'This is the style to search. Only results from this style will be shown (including custom and inherited templates).', 0, 185, 'Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1508, 'admin_style_search_query', 'Search Query:', 0, 185, 'Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1509, 'admin_style_search_query_desc', 'This query will be searched in template titles and content.', 0, 185, 'Query Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1510, 'error_noTemplate', 'Sorry, but you have made a call to a fragment that doesn''t exist for this style.', 0, 35, 'Fragment Doesn''t Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1512, 'admin_style_t_saveReload', 'Save & Reload', 0, 161, 'Save & Reload', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1513, 'global_error', 'Error in Request', 0, 64, 'Error in Request', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1514, 'global_threads', 'Threads', 0, 64, 'Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1515, 'global_posts', 'Posts', 0, 64, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1516, 'global_forum', 'Forum', 0, 64, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1517, 'global_lastPost', 'Last Post', 0, 64, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1518, 'user_index_whosOnline', 'Who''s Online', 0, 191, 'Who''s Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1519, 'user_index_stats', 'Forum Stats', 0, 191, 'Forum Stats', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1524, 'error_login_noInfo', 'Sorry, but you must fill in your username <strong>and</strong> password in order complete the login process.', 0, 192, 'Not Enough Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1525, 'global_previousPage', 'Go back to the previous page.', 0, 64, 'Previous Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1526, 'global_notRed', 'Click here if you are not redirected.', 0, 64, 'Not Redirected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1527, 'global_thanks', 'Thank You', 0, 64, 'Thanks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1528, 'thanks_login', 'Your login was successful, and is currently being processed.', 0, 194, 'Login', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1529, 'error_login_notLoggedIn', 'Sorry, but you are not logged in and thusly cannot log out.', 0, 192, 'Not Logged In', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1530, 'thanks_logout', 'Thank you for logging out.', 0, 194, 'Logout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1531, 'admin_options_setup_redirect', 'Use Redirects:', 0, 4, 'Board Redirect', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1532, 'admin_options_setup_redirect_desc', 'When this is enabled, users will be presented with a redirect screen to confirm their request. If this is disabled, this screen will be omitted and the user will be redirected to the next screen immediately. When disabled it allows for faster surfing and less bandwidth usage.', 0, 4, 'Board Redirect Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1533, 'global_guest', 'Guest', 0, 64, 'Guest', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1534, 'error_invalidLink', 'Sorry, but you have followed an invalid link or are trying to view a page that doesn''t exist.', 0, 35, 'Invalid Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1535, 'user_index', 'Browsing Board Index', 0, 195, 'Board Index', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1536, 'user_login', 'Logging In', 0, 195, 'Login', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1537, 'user_logout', 'Logging Out', 0, 195, 'Logout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1538, 'user_invalidlink', 'Invalid Link', 0, 195, 'Invalid Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1539, 'admin_options_cookieSettings_cookLogin', 'Require Cookies to Login:', 0, 73, 'No Cookie Login', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1540, 'admin_options_cookieSettings_cookLogin_desc', 'This is a security option only. If users are allowed to login with cookie disabled browsers, then they can only be logged in via a session ID carried through the URL. Because of this, sessions <strong>can</strong> be hijacked, and thus users can login as others. Although unlikely, this does open up the possibility of it happening.', 0, 73, 'No Cookie Login Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1541, 'error_login_cookiesRequired', 'Sorry, but the administrator has specified that you need cookies in order to login.', 0, 192, 'Cookies Required', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1542, 'admin_options_forumHome', 'Forum Home Settings', 0, 196, 'Forum Home Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1543, 'admin_nav_wtcBBOpt_forumHome', 'Forum Home Settings', 0, 20, 'Forum Home Settings', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1544, 'admin_options_forumHome_whosOnline', 'Show Who''s Online:', 0, 196, 'Who''s Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1545, 'admin_options_forumHome_whosOnline_desc', 'This is a global directive for toggling the viewing of Who''s Online. If this is disabled, you will not be able to view it on the Forum Home page. This however does not stop users from viewing the Who''s Online page (this is controlled via usergroups).', 0, 196, 'Who''s Online Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1546, 'admin_options_forumHome_stats', 'Show Forum Stats:', 0, 196, 'Forum Stats', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1547, 'admin_options_forumHome_stats_desc', 'When disabled, the forum stats will not be displayed on the Forum Home page. You might disable this if you want you forum home page to load faster.', 0, 196, 'Forum Stats Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1551, 'user_whosOnline_user', 'User', 0, 199, 'User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1552, 'user_whosOnline_lastActivity', 'Last Activity', 0, 199, 'Last Activity', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1553, 'user_whosOnline_loc', 'Location', 0, 199, 'Location', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1554, 'user_ip', 'IP Address', 0, 190, 'IP Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1710, 'user_message_postUsername', 'User Name:', 0, 209, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1711, 'error_message_uniqueName', 'Sorry, but as a guest you must supply a unique user name. You cannot use a user name that has already been registered by someone.', 0, 226, 'Unique User Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1557, 'admin_options_robots_robotDetect', 'Robot Detection:', 0, 200, 'Robot Detection', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1558, 'admin_options_robots_robotDetect_desc', 'This field will allow you to differentiate guests from robots browsing your message board. You should input here something that can be found in the robot''s User Agent and is unique to that robot. Make you separate each robot with a new line.', 0, 200, 'Robot Detection Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1559, 'admin_options_robots_robotDesc', 'Robot Description:', 0, 200, 'Robot Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1560, 'admin_options_robots_robotDesc_desc', 'This is the description matching the robots listed above. This name will be displayed wherever plausible. Remember to have the robots and their descriptions coordinated on the same line.', 0, 200, 'Robot Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1561, 'admin_nav_wtcBBOpt_robots', 'Robot Detection', 0, 20, 'Robots', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1562, 'admin_options_robots', 'Robot Detection', 0, 200, 'Robot Detection', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1563, 'error_perms', 'Permissions Error', 0, 201, 'Permissions Error', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1564, 'error_perms_message_loggedOut', 'You do not have access to view this page. You are currently logged out, and your problem could be resolved by either logging in or registering a new account.', 0, 201, 'Message (Logged Out)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1566, 'user_whosOnline_members', 'Members', 0, 199, 'Members', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1567, 'user_whosOnline_guests', 'Guests', 0, 199, 'Guests', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1568, 'user_whosOnline_robots', 'Robots', 0, 199, 'Robots', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1565, 'error_perms_message_loggedIn', 'You do not have access to view this page. It could be due to many things:\r\n\r\n<ol>\r\n  <li>You do not have the privileges to access this page. You could be trying to perform an administrative action, or trying to edit someone else''s post.</li>\r\n  <li>The administrator could have disabled your account, or your account may be awaiting activation.</li>\r\n</ol>', 0, 201, 'Message (Logged In)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1569, 'user_whosOnline_display', 'Display:', 0, 199, 'Display', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1570, 'user_whosOnline_resolve', 'Resolve IP:', 0, 199, 'Resolve IP', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1571, 'user_whosOnline_perpage', 'Per Page:', 0, 199, 'Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1572, 'global_login', 'Login', 0, 64, 'Login', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1573, 'global_yes', 'Yes', 0, 64, 'Yes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1574, 'global_no', 'No', 0, 64, 'No', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1575, 'global_all', 'All', 0, 64, 'All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1576, 'global_go', 'Go', 0, 64, 'Go', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1577, 'user_forums', 'Viewing Forum', 0, 195, 'Viewing Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1578, 'error_forum_invalidForum', 'Sorry, but the forum you are trying to access does not exist.', 0, 202, 'Invalid Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1579, 'user_error', 'Error', 0, 195, 'Error', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1580, 'user_forum_threadDisplay', 'Thread Display', 0, 205, 'Thread Display', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1581, 'user_forum_forumDisplay', 'Forum Display', 0, 205, 'Forum Display', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1582, 'user_forum_postThread', 'Post Thread', 0, 205, 'Post Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1583, 'user_postthread', 'Posting Thread', 0, 195, 'Posting Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1584, 'admin_style_v_inBorderColor', 'Inner Border Color', 0, 182, 'Inner Border Color', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1585, 'admin_style_v_inBorderWidth', 'Inner Border Width', 0, 182, 'Inner Border Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1586, 'global_message', 'Message', 0, 64, 'Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1587, 'global_submit', 'Submit', 0, 64, 'Submit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1588, 'global_reset', 'Reset', 0, 64, 'Reset', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1589, 'admin_options_message', 'Message Interface', 0, 208, 'Message Interface', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1590, 'admin_nav_wtcBBOpt_message', 'Message Interface', 0, 20, 'Message Interface', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1591, 'admin_options_message_smilies', 'Smiley Display:', 0, 208, 'Smiley Display', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1592, 'admin_options_message_smilies_desc', 'This is the number of smilies displayed in the message interface. You might want to increase/decrease this number based on the average size of each smiley. <strong>Set this to 0 to disable the display of smilies in the message interface. There will still be a link to access all smilies.</strong>', 0, 208, 'Smiley Display Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1593, 'admin_options_message_threadReview', 'Thread Review:', 0, 208, 'Thread Review', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1594, 'admin_options_message_threadReview_desc', 'This option will toggle the display of the thread review in the message interface. Disable this if you have a busy community and would like to reserve resources.', 0, 208, 'Thread Review Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1595, 'admin_options_message_toolbar', 'Toolbar:', 0, 208, 'Toolbar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1596, 'admin_options_message_toolbar_desc', 'This will toggle the display of the toolbar in the message interface. Note that this is also a user configuration option, and if this is disabled the user will not be able to view the toolbar- regardless of their setting.', 0, 208, 'Toolbar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1597, 'user_message_threadTitle', 'Thread Title:', 0, 209, 'Thread Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1598, 'user_message_description', 'Description:', 0, 209, 'Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1599, 'user_message_description_desc', 'This is the description/subject of this message. If this is left blank, it will be filled with the first segment of the message.', 0, 209, 'Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1600, 'user_message_postIcon', 'Post Icon:', 0, 209, 'Post Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1601, 'user_message_noIcon', 'None', 0, 209, 'No Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1602, 'thanks_postThread', 'Your thread has been submitted successfully. You will now be redirected to your newly created thread. If your posts are under supervision, there may be a delay between the time you submitted your thread and the time it is displayed.', 0, 194, 'Post Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1603, 'user_forum_threadName', 'Thread Title', 0, 205, 'Thread Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1604, 'user_forum_replies', 'Replies', 0, 205, 'Replies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1605, 'user_forum_views', 'Views', 0, 205, 'Views', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1606, 'global_by', 'By', 0, 64, 'By', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1607, 'global_noneAvailable', 'None Available', 0, 64, 'None Available', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1608, 'user_forum_noThreads', 'Sorry, but there are no threads to be displayed.', 0, 205, 'No Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1609, 'global_moderators', 'Moderators', 0, 64, 'Moderators', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1610, 'user_nav_login', 'Login', 0, 215, 'Login', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1611, 'user_nav_logout', 'Logout', 0, 215, 'Logout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1612, 'user_nav_error', 'Error', 0, 215, 'Error', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1613, 'user_thread', 'Viewing Thread', 0, 195, 'Viewing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1614, 'error_thread_invalidThread', 'Sorry, but you either followed a broken link or are trying to view a thread that doesn''t exist.', 0, 216, 'Invalid Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1615, 'user_postreply', 'Posting Reply', 0, 195, 'Posting Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1616, 'user_thread_postReply', 'Post Reply', 0, 216, 'Post Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1617, 'thanks_postReply', 'Your post has been submitted successfully. You will now be redirected to the thread in which you replied. If your posts are under supervision, there may be a delay between the time you submitted your post and the time it is displayed.', 0, 194, 'Post Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1618, 'user_message_postTitle', 'Post Title:', 0, 209, 'Post Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1619, 'admin_usergroups_admins_bbcode', 'BB Code:', 0, 72, 'BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1620, 'admin_nav_bbcode_title', 'BB Code', 0, 217, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1621, 'admin_nav_bbcode_manager', 'BB Code Manager', 0, 217, 'BB Code Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1622, 'admin_nav_bbcode_add', 'Add BB Code', 0, 217, 'Add BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1623, 'admin_bbcode_add', 'Add BB Code', 0, 218, 'Add BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1624, 'admin_bbcode_edit', 'Edit BB Code', 0, 218, 'Edit BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1625, 'admin_bbcode_ae_name', 'Name:', 0, 220, 'Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1626, 'admin_bbcode_ae_name_desc', 'This is simply the name of this BB Code. This is only used to reference the BB Code (ie: if this is displayed in the message area, this name is what will be written to signify this BB Code).', 0, 220, 'Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1627, 'admin_bbcode_ae_tag', 'Tag Name:', 0, 220, 'Tag', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1628, 'admin_bbcode_ae_tag_desc', 'This is the tag <strong>name</strong> (don''t include the "[" and "]"). This will be used as "[<strong>tag name</strong>]" in the message area.', 0, 220, 'Tag Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1629, 'admin_bbcode_ae_replace', 'Replacement:', 0, 220, 'Replacement', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1630, 'admin_bbcode_ae_replace_desc', 'This is the actual HTML code used to replace the above BB Code tag in messages. <strong>{param}</strong> represents the text between the BB Code: [tag]<strong>this is the param text</strong>[/tag]. And <strong>{option}</strong> represents the text used in this: [tag=<strong>option text</strong>]<strong>this is still the param text</strong>[/tag]. Basically, if you use "{option}" in your replacement, then your BB Code will look like "[bbcode=<strong>option</strong>]", otherwise it will look like "[bbcode]."', 0, 220, 'Replacement Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1631, 'admin_bbcode_ae_example', 'Example:', 0, 220, 'Example', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1632, 'admin_bbcode_ae_example_desc', 'The example should include the intended usage of this BB Code. This example will only be viewable via the admin panel and is for referencing by users with administrative privileges only.', 0, 220, 'Example Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1633, 'admin_bbcode_ae_desc', 'Description:', 0, 220, 'Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1634, 'admin_bbcode_ae_desc_desc', 'The description is simply a way for you to enter some text that will describe the usage of this BB Code. Like the example field, this is optional and is only displayed to users with administrative privileges in the control panel.', 0, 220, 'Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1635, 'admin_bbcode_ae_opt', 'Use Option:', 0, 220, 'Use Option', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1636, 'admin_bbcode_ae_opt_desc', 'This will enable the usage of <strong>{option}</strong> in your replacement code. If this option is enabled, this BB Code should be written as: [tag=<strong>this is the option text</strong>]<strong>param text</strong>[/tag].', 0, 220, 'Use Option Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1637, 'admin_bbcode_ae_display', 'Display in Message Interface:', 0, 220, 'Display', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1638, 'admin_bbcode_ae_display_desc', 'If this is enabled a button representing this BB Code will be displayed in the toolbar which is displayed in all message editing interfaces. <strong>If this is disabled, this BB Code will still be able to be used.</strong>', 0, 220, 'Display Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1639, 'admin_bbcode_man_name', 'Name', 0, 219, 'Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1640, 'admin_bbcode_man_tag', 'Tag', 0, 219, 'Tag', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1641, 'admin_bbcode_man_ex', 'Example', 0, 219, 'Example', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1642, 'admin_bbcode_man', 'BB Code Manager', 0, 219, 'BB Code Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1643, 'admin_bbcode_parse', 'Parse BB Code', 0, 221, 'Parse BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1644, 'admin_nav_bbcode_parse', 'Parse BB Code', 0, 217, 'Parse BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1645, 'admin_bbcode_parse_details', 'This will allow you to test out the BB Code you have added via the <a href="./admin.php?file=bbcode">BB Code Manager</a>. You can enter text here with BB Code just like you would in a post.', 0, 221, 'Details', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1646, 'admin_bbcode_parse_message', 'Parsed Message', 0, 221, 'Parsed Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1647, 'admin_usergroups_ae_messageOpt', 'Message Options', 0, 70, 'Message Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1648, 'user_color_red', 'Red', 0, 223, 'Red', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1649, 'user_color_blue', 'Blue', 0, 223, 'Blue', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1650, 'user_color_green', 'Green', 0, 223, 'Green', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1651, 'user_color_purple', 'Purple', 0, 223, 'Purple', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1652, 'user_color_pink', 'Pink', 0, 223, 'Pink', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1653, 'user_color_black', 'Black', 0, 223, 'Black', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1654, 'user_color_white', 'White', 0, 223, 'White', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1655, 'user_color_yellow', 'Yellow', 0, 223, 'Yellow', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1656, 'user_color_brown', 'Brown', 0, 223, 'Brown', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1657, 'user_color_cyan', 'Cyan', 0, 223, 'Cyan', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1658, 'user_color_magenta', 'Magenta', 0, 223, 'Magenta', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1659, 'user_color_steelBlue', 'Steel Blue', 0, 223, 'Steel Blue', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1660, 'user_color_orange', 'Orange', 0, 223, 'Orange', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1661, 'user_color_turquoise', 'Turquoise', 0, 223, 'Turquoise', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1662, 'user_color_orangeRed', 'Orange Red', 0, 223, 'Orange Red', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1663, 'user_color_navy', 'Navy', 0, 223, 'Navy', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1664, 'user_color_limeGreen', 'Lime Green', 0, 223, 'Lime Green', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1665, 'user_color_lightCoral', 'Light Coral', 0, 223, 'Light Coral', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1666, 'user_color_fireBrick', 'Fire Brick', 0, 223, 'Fire Brick', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1667, 'user_color_gold', 'Gold', 0, 223, 'Gold', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1668, 'user_color_silver', 'Silver', 0, 223, 'Silver', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1669, 'user_color_orchid', 'Orchid', 0, 223, 'Orchid', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1670, 'user_color_indianRed', 'Indian Red', 0, 223, 'Indian Red', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1671, 'user_color_lime', 'Lime', 0, 223, 'Lime', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1672, 'user_color_indigo', 'Indigo', 0, 223, 'Indigo', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1673, 'user_font_verdana', 'Verdana', 0, 224, 'Verdana', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1674, 'user_font_arial', 'Arial', 0, 224, 'Arial', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1675, 'user_font_tahoma', 'Tahoma', 0, 224, 'Tahoma', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1676, 'user_font_century', 'Century', 0, 224, 'Century', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1677, 'user_font_comicSansMS', 'Comic Sans MS', 0, 224, 'Comic Sans MS', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1678, 'user_font_jester', 'Jester', 0, 224, 'Jester', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1679, 'user_font_trebuchetMS', 'Trebuchet MS', 0, 224, 'Trebuchet MS', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1680, 'user_font_timesNewRoman', 'Times New Roman', 0, 224, 'Times New Roman', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1681, 'user_font_lucidaSans', 'Lucida Sans', 0, 224, 'Lucida Sans', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1682, 'user_font_teletype', 'Teletype', 0, 224, 'Teletype', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1683, 'admin_options_posting', 'Posting Options', 0, 225, 'Posting Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1684, 'admin_nav_wtcBBOpt_posting', 'Posting Options', 0, 20, 'Posting Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1685, 'admin_options_posting_minMessageChars', 'Minimum Characters in Message:', 0, 225, 'Minimum Message Characters', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1686, 'admin_options_posting_minMessageChars_desc', 'This is the minimum amount of characters required in any given message in order for it to be posted/sent.', 0, 225, 'Minimum Message Characters Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1687, 'admin_options_posting_maxMessageChars', 'Maximum Characters in Message:', 0, 225, 'Maximum Message Characters', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1688, 'admin_options_posting_maxMessageChars_desc', 'This is the maximum amount of characters allowed in any given message for it to be posted/sent.', 0, 225, 'Maximum Message Characters Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1689, 'admin_options_posting_maxMessageImgs', 'Maximum Images in Message:', 0, 225, 'Maximum Images in Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1690, 'admin_options_posting_maxMessageImgs_desc', 'This is the maximum amount of images allowed in any given message in order for it to be posted/sent. This does  include smilies.', 0, 225, 'Maximum Images in Message Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1691, 'error_message_underMinChars', 'Sorry, but you are under the minimum character count of:', 0, 226, 'Under Min Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1692, 'error_message_overMaxChars', 'Sorry, but you are over the maximum character count of:', 0, 226, 'Over Max Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1693, 'error_message_overMaxImgs', 'Sorry, but you are over the maximum image amount of:', 0, 226, 'Over Max Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1694, 'error_message_overMaxChars_title', 'Sorry, but your title/subject is over the maximum character amount of:', 0, 226, 'Over Max Chars Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1695, 'error_message_underMinChars_title', 'Sorry, but your title is under the minimum character amount of:', 0, 226, 'Under Max Chars Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1696, 'admin_options_posting_maxTitleChars', 'Maximum Characters in Title/Subject:', 0, 225, 'Max Title Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1697, 'admin_options_posting_maxTitleChars_desc', 'This is the maximum amount of characters allowed in the subject/title of any message.', 0, 225, 'Max Title Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1698, 'admin_options_posting_minTitleChars', 'Minimum Characters in Title:', 0, 225, 'Min Title Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1699, 'admin_options_posting_minTitleChars_desc', 'This is the minimum amount of characters allowed in the title/subject of any message.', 0, 225, 'Min Title Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1700, 'global_preview', 'Preview', 0, 64, 'Preview', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1701, 'error_message_empty', 'Sorry, but you must have at least one character in your title/subject and your message.', 0, 226, 'Empty', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1702, 'user_postedit', 'Editing Message', 0, 195, 'Editing Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1703, 'user_thread_postEdit', 'Editing Message', 0, 216, 'Editing Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1704, 'thanks_postEdit', 'Your post has been edited successfully. You will now be redirected to the thread in which your post is. If your posts are under supervision, there may be a delay between the time you submitted your modifications and the time it is displayed.', 0, 194, 'Edited Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1705, 'global_edit', 'Edit', 0, 64, 'Edit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1706, 'user_message_editedReason', 'Reason for Modification/Deletion:', 0, 209, 'Reason', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1707, 'user_thread_reply', 'Reply', 0, 216, 'Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1708, 'admin_options_dateTime_todYes', 'Use Today/Yesterday Date Stamps:', 0, 62, 'Today/Yesterday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1709, 'admin_options_dateTime_todYes_desc', 'If this is enabled, dates that are "Today" or "Yesterday" will be labeled as such.', 0, 62, 'Today/Yesterday Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1712, 'user_message_displayOptions', 'Display Options:', 0, 209, 'Display Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1713, 'user_message_showSig', 'Show Signature', 0, 209, 'Show Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1714, 'user_message_parseBB', 'Parse BB Code', 0, 209, 'Parse BB Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1715, 'user_message_parseSmilies', 'Parse Smilies', 0, 209, 'Parse Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1716, 'admin_style_man_images', 'Image Names', 0, 145, 'Image Names', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1717, 'admin_style_images', 'Image Names', 0, 227, 'Image Names', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1718, 'admin_style_i_expand', 'Expand:', 0, 227, 'Expand', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1719, 'admin_style_i_collapse', 'Collapse:', 0, 227, 'Collapse', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1720, 'admin_style_images_desc', 'This page allows you to modify the names of images that you otherwise would need to edit templates to do. It provides one central location for the management of image names used in templates. <strong>Note:</strong> Images listed here are for styles only (found in your style images folder, not in folders such as "message" and "ranks"). If you cannot find your image here it''s either because it isn''t a style image, or it can be found in the "Visual Settings" or "Colors &amp; Style Options" sections of managing a style.', 0, 227, 'Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1721, 'admin_style_i_postthread', 'Post Thread:', 0, 227, 'Post Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1722, 'admin_style_i_postreply', 'Post Reply', 0, 227, 'Post Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1723, 'admin_style_i_postbit_edit', 'Postbit Edit:', 0, 227, 'Edit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1724, 'admin_style_i_postbit_reply', 'Postbit Reply:', 0, 227, 'Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1725, 'admin_options_forumSettings_threadsPerPage', 'Threads Per Page:', 0, 197, 'Threads Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1726, 'admin_options_forumSettings_threadsPerPage_desc', 'This is the amount of threads that will be listed on each page when viewing a forum.', 0, 197, 'Threads Per Page Desc', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1727, 'admin_options_setup_readTimeout', 'Forum/Topic Read Indicator Timeout:', 0, 4, 'Read Timeout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1728, 'admin_options_setup_readTimeout_desc', 'This is the number of <strong>days</strong> that the forum/topic read indicators will stay in the database. Effectively, this option should negatively correlate with the traffic on your forum (the busier the forum, the less the read timeout should be).', 0, 4, 'Read Timeout Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1729, 'admin_style_i_indicatorOn', 'Forum Indicator (On):', 0, 227, 'Forum Indicator On', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1730, 'admin_style_i_indicatorOff', 'Forum Indicator (Off):', 0, 227, 'Forum Indicator Off', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1731, 'admin_style_i_indicatorPrivate', 'Forum Indicator (Private):', 0, 227, 'Private Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1732, 'user_forum_unread', 'Unread', 0, 205, 'Unread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1733, 'user_forum_read', 'Read', 0, 205, 'Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1734, 'user_forum_private', 'Private', 0, 205, 'Private', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1735, 'admin_style_i_lastPost', 'Last Post Icon:', 0, 227, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1736, 'admin_style_i_newestPost', 'Newest Post Icon:', 0, 227, 'Newest Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1737, 'user_forum_lastPost', 'Go to Last Post', 0, 205, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1738, 'user_forum_newestPost', 'Go to Newest Post Since Last Visit', 0, 205, 'Newest Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1739, 'admin_style_i_stats', 'Stats Icon:', 0, 227, 'Stats', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1740, 'admin_style_i_whosOnline', 'Who''s Online Icon:', 0, 227, 'Who''s Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1741, 'user_misc_markread', 'Marking Forums Read', 0, 195, 'Marking Forums Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1742, 'thanks_markRead', 'You have successfully marked the selected forums read. You will now be redirected to the previous page of viewing.', 0, 194, 'Mark Forums Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1743, 'user_index_markRead', 'Mark All Forums Read', 0, 191, 'Mark All Forums Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1744, 'admin_style_i_upIcon', 'Top of Page Icon:', 0, 227, 'Top of Page Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1745, 'user_topPage', 'Go to Top of Page', 0, 190, 'Go to Top of Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1746, 'admin_maint_update', 'Update Database Information', 0, 229, 'Update Database Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1747, 'admin_maint_forums', 'Forum Information:', 0, 229, 'Forum Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1748, 'admin_maint_update_button', 'Update', 0, 229, 'Update', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1749, 'admin_maint_users', 'User Information:', 0, 229, 'User Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1750, 'admin_maint_users_desc', 'This will reset all user post counts to that of the actual number of posts in the database.', 0, 229, 'User Information Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1751, 'user_thread_editedBy', 'Edited By:', 0, 190, 'Edited By', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1752, 'admin_style_i_aimIcon', 'AIM IM Icon:', 0, 227, 'AIM Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1753, 'admin_style_i_yahooIcon', 'Yahoo IM Icon:', 0, 227, 'Yahoo Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1754, 'admin_style_i_icqIcon', 'ICQ IM Icon:', 0, 227, 'ICQ Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1755, 'admin_style_i_msnIcon', 'MSN IM Icon:', 0, 227, 'MSN Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1756, 'user_message_showEdited', 'Show Edited Notice', 0, 209, 'Show Edited Notice', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1757, 'admin_style_i_profileIcon', 'Profile Icon:', 0, 227, 'Profile Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1758, 'user_message_delete', 'Delete Post:', 0, 209, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1759, 'user_message_delete_perm', 'Permanently Delete', 0, 209, 'Permanently Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1760, 'admin_style_i_postbit_pm', 'Postbit PM:', 0, 227, 'Postbit PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1761, 'user_thread_sendPm', 'Send Personal Message', 0, 216, 'Send PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1762, 'user_status_online', 'Online', 0, 190, 'Online', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1763, 'user_status_offline', 'Offline', 0, 190, 'Offline', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1764, 'admin_style_i_online', 'Online Icon:', 0, 227, 'Online Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1765, 'admin_style_i_offline', 'Offline Icon:', 0, 227, 'Offline Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1766, 'thanks_postDelete', 'You have successfully deleted the requested post.', 0, 194, 'Post Deletion', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1767, 'user_post_restore', 'Restoring Post', 0, 195, 'Restoring Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1768, 'user_post', 'Viewing Post', 0, 195, 'Viewing Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1773, 'user_thread_restorePost', 'Restore', 0, 216, 'Restore Thread/Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1771, 'error_forum_postNotDel', 'Sorry, but you can''t restore a post that isn''t deleted.', 0, 202, 'Post Isn''t Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1772, 'thanks_restoredPost', 'You have successfully restored the selected post.', 0, 194, 'Restored Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1774, 'user_thread_restore', 'Restoring Thread', 0, 195, 'Restoring Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1775, 'error_forum_threadNotDel', 'Sorry, but the thread you are trying to restore isn''t deleted.', 0, 202, 'Thread Isn''t Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1776, 'thanks_restoredThread', 'You have successfully restored the requested thread.', 0, 194, 'Restored Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1777, 'thanks_threadDelete', 'You have successfully deleted the requested thread.', 0, 194, 'Thread Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1778, 'error_forum_threadDel', 'Sorry, but you cannont perform the requested action because this thread is deleted.', 0, 202, 'Thread Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1779, 'error_forum_postDel', 'Sorry, but you cannot perform the requested action because the post is deleted.', 0, 202, 'Post Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1780, 'user_thread_delMessage', 'This thread is currently deleted. This means that posts cannot be added, edited or deleted. Nor can this thread be moved, closed, opened, split, etc. When a thread is deleted, it is locked in its current state. The thread must be restored before any changes can be made.', 0, 216, 'Deleted Thread Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1781, 'user_thread_delThread', 'Deleted Thread Notice', 0, 216, 'Deleted Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1782, 'admin_style_i_postbit_quoteP', 'Postbit Quote (Plus):', 0, 227, 'Postbit Quote (Plus)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1783, 'admin_style_i_postbit_quoteM', 'Postbit Quote (Minus):', 0, 227, 'Postbit Quote (Minus)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1784, 'user_thread_quote', 'Quote this Post', 0, 216, 'Quote', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1785, 'admin_options_threadSettings_maxQuote', 'Maximum Number of Quotes:', 0, 63, 'Max Quotes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1786, 'admin_options_threadSettings_maxQuote_desc', 'This is more of a security check in place to stop malscious users from sucking up too many resources.', 0, 63, 'Max Quotes Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1787, 'user_thread_quickReply', 'Quick Reply', 0, 216, 'Quick Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1788, 'admin_forums_mod_ae_stick', 'Stick Threads:', 0, 90, 'Stick Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1789, 'admin_forums_mod_ae_stick_desc', 'If this is disabled, this moderator will not be able stick threads in their forum.', 0, 90, 'Stick Threads Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1790, 'user_message_modOpts', 'Moderation Options:', 0, 209, 'Moderation Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1791, 'user_message_openThread', 'Open Thread', 0, 209, 'Open Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1792, 'user_message_closeThread', 'Close Thread', 0, 209, 'Close Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1793, 'user_message_stick', 'Stick Thread', 0, 209, 'Stick Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1794, 'user_message_unstick', 'Unstick Thread', 0, 209, 'Unstick Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1795, 'admin_style_i_closed', 'Closed:', 0, 227, 'Closed Button', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1796, 'user_thread_closed', 'Closed - No New Replies', 0, 216, 'Closed - No New Replies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1797, 'user_forum_preClosed', 'Closed:', 0, 205, 'Prefix - Closed', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1798, 'user_forum_preSticky', 'Sticky:', 0, 205, 'Prefix - Sticky', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1799, 'user_thread_openclose', 'Opening/Closing Thread', 0, 195, 'Opening/Closing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1800, 'thanks_openClose', 'You have successfully opened/closed the specified thread.', 0, 194, 'Opening/Closing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1801, 'thanks_stickUnstick', 'You have successfully Stuck/Unstuck the specified thread.', 0, 194, 'Stick/Unstick', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1802, 'user_thread_stickunstick', 'Sticking/Unsticking Thread', 0, 195, 'Stick/Unstick Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1803, 'user_thread_options', '- Thread Options -', 0, 216, 'Thread Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1804, 'admin_style_i_postbit_quickReply', 'Postbit Quick Reply:', 0, 227, 'Postbit Quick Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1805, 'admin_style_i_postbit_www', 'Postbit WWW:', 0, 227, 'Postbit WWW', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1806, 'user_thread_jumpToQuick', 'Jump to Quick Reply', 0, 216, 'Jump to Quick Reply', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1807, 'user_thread_goToHome', 'Go to this user''s home page', 0, 216, 'Go to Homepage', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1808, 'admin_style_i_navIcon', 'Navigation Icon:', 0, 227, 'Navigation Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1809, 'user_forumNav', 'Forum Navigation', 0, 190, 'Forum Navigation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1810, 'user_thread_editThread', 'Edit Thread', 0, 216, 'Edit Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1811, 'user_thread_notes', 'Notes:', 0, 216, 'Notes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1812, 'thanks_editThread', 'You have successfully edited the specified thread.', 0, 194, 'Editing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1813, 'user_thread_editing', 'Editing Thread', 0, 195, 'Editing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1814, 'user_thread_deleteThread', 'Delete Thread', 0, 216, 'Delete Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1815, 'user_thread_deleting', 'Deleting Thread', 0, 195, 'Deleting Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1817, 'error_noSelection', 'Sorry, but no action was performed as nothing was selected. Please make a selection and try again.', 0, 35, 'No Selection', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1818, 'user_delete', 'Delete', 0, 190, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1819, 'user_thread_restoreThread', 'Restore Thread', 0, 216, 'Restore Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1821, 'user_thread_moveCopyThread', 'Move/Copy Thread', 0, 216, 'Move/Copy Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1822, 'user_thread_moving', 'Moving/Copying Thread', 0, 195, 'Moving/Copying Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1823, 'thanks_movedThread', 'You have successfully moved/copied the specified thread to the requested forum.', 0, 194, 'Moved Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1824, 'user_thread_moveType', 'Move Type:', 0, 216, 'Move Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1825, 'user_thread_moveType_redirect', 'Move with Redirection', 0, 231, 'Move with Redirection', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1826, 'user_thread_moveType_regMove', 'Move with No Redirection', 0, 231, 'Regular Move', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1827, 'user_thread_moveType_copy', 'Copy', 0, 231, 'Copy', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1828, 'user_thread_forum', 'Forum:', 0, 216, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1829, 'user_thread_forum_desc', 'Please select the forum you wish to move or copy this thread to.', 0, 216, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1830, 'user_thread_category', '(Category)', 0, 216, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1831, 'user_forum_preMoved', 'Moved:', 0, 205, 'Prefix - Moved', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1832, 'error_forum_moveToCat', 'Sorry, but you cannot move/copy a thread to a category.', 0, 202, 'No Posting in Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1833, 'admin_style_i_threadPre_closed', 'Thread Prefix (Closed):', 0, 227, 'Thread Prefix (Closed)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1834, 'admin_style_i_threadPre_sticky', 'Thread Prefix (Sticky):', 0, 227, 'Thread Prefix (Sticky)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1835, 'admin_style_i_threadPre_moved', 'Thread Prefix (Moved):', 0, 227, 'Thread Prefix (Moved)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1836, 'user_thread_currentlyBrowsing', 'Currently Browsing this Thread', 0, 216, 'Currently Browing Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1837, 'admin_options_forumSettings_browsingForum', 'Show Users Browsing Current Forum:', 0, 197, 'Browsing Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1838, 'admin_options_forumSettings_browsingForum_desc', 'When this option is enabled, a box will appear at the bottom of each forum that will display the users who are currently viewing that thread. <strong>Note:</strong> This can be quite server intensive if there are many simultaneous users.', 0, 197, 'Browsing Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1839, 'user_forum_currentlyBrowsing', 'Currently Browsing this Forum', 0, 205, 'Currently Browsing Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1840, 'user_thread_splitThread', 'Split Thread', 0, 216, 'Split Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1841, 'user_thread_splitting', 'Splitting Thread', 0, 195, 'Splitting Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1842, 'user_thread_splitThread_titleDesc', 'This is the title of the <strong>new</strong> thread created.', 0, 233, 'New Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1843, 'user_thread_splitThread_action', 'Moderator Action:', 0, 233, 'Action', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1844, 'user_thread_splitThread_action_desc', 'You can perform a moderator action on the old thread by specifying it here. The "new" thread is the thread created with the selected posts below, and the "old" thread is the thread where the posts below originated from.', 0, 233, 'Action Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1845, 'user_thread_splitThread_nothing', 'Nothing', 0, 233, 'Nothing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1846, 'user_thread_splitThread_split', 'Split', 0, 233, 'Split', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1847, 'user_thread_splitThread_instruct', 'Splitting a thread consists of popping out posts from a current thread in the database and creating a new thread with the posts selected. This is ideal for threads that reach a very high post count, or if two different discussions are going on at the same time.  Simply select the posts below from which you want to make your new post with, and configure any options above.', 0, 233, 'Instructions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1848, 'user_checkAll', 'Check All', 0, 190, 'Check All', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1849, 'thanks_splitThread', 'You have successfully split the requested thread. You will now be taken to the newly generated thread.', 0, 194, 'Splitted Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1850, 'admin_close', 'Close', 0, 5, 'Close', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1851, 'user_thread_mergeThread', 'Merge Thread', 0, 216, 'Merge Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1852, 'user_thread_mergeThread_url', 'URL to Merging Thread:', 0, 234, 'URL', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1853, 'user_thread_mergeThread_url_desc', 'You can enter the link to the thread you wish to merge into this one. When you merge the thread you specify here, it will be deleted and all of its posts will be inserted chronologically into the current thread.', 0, 234, 'URL Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1854, 'user_thread_merging', 'Merging Thread', 0, 195, 'Merging Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1855, 'error_forum_mergingToSelf', 'Sorry, but you cannot merge a thread into itself.', 0, 202, 'Merging Thread into Self', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1856, 'user_thread_splitThread_open', '(Open Forum View)', 0, 233, 'Open Forum View', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1857, 'thanks_mergedThread', 'You have successfully merged the selected threads.', 0, 194, 'Merged Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1858, 'admin_style_i_postbit_dPlus', 'Postbit Delete (Plus):', 0, 227, 'Postbit Delete (Plus)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1859, 'admin_style_i_postbit_dMinus', 'Postbit Delete (Minus):', 0, 227, 'Postbit Delete (Minus)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1860, 'admin_style_i_postbit_delIcon', 'Postbit Delete Icon:', 0, 227, 'Postbit Delete Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1861, 'user_post_deleting', 'Deleting Posts', 0, 195, 'Deleting Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1862, 'thanks_postsDeleted', 'You have successfully deleted the selected posts.', 0, 194, 'Posts Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1863, 'user_thread_deletePost', 'Delete Post', 0, 216, 'Delete Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1864, 'admin_style_i_subscribed', 'Subscribed Icon:', 0, 227, 'Subscribed', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1865, 'user_forum_subscribed', 'You are Subscribed to this Thread', 0, 205, 'Subscribed', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1866, 'user_thread_subscribe', 'Subscribe', 0, 216, 'Subscribe', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1867, 'user_thread_unsubscribe', 'Unsubscribe', 0, 216, 'Unsubscribe', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1868, 'thanks_subscribe', 'You have successfully subscribed to the selected forum/thread.', 0, 194, 'Subscribe', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1869, 'thanks_unsubscribe', 'You have successfully unsubscribed from the selected forum/thread.', 0, 194, 'Unsubscribe', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1870, 'user_thread_subscribing', '(Un)Subscribing', 0, 195, 'Subscribing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1871, 'admin_style_i_postbit_email', 'Postbit Email:', 0, 227, 'Postbit Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1872, 'user_forum_options', '- Forum Options -', 0, 205, 'Forum Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1873, 'user_message_subscribe', 'Subscriptions:', 0, 209, 'Subscription', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1874, 'user_message_attach', 'Manage Attachments', 0, 209, 'Manage Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1875, 'error_attach_badLink', 'Sorry, but the specified hash or postid is invalid. Please try again.', 0, 237, 'Bad Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1876, 'global_upload', 'Upload', 0, 64, 'Upload', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1877, 'error_upload_imageHeightOrWidthTooBig', 'Sorry, but the height or width of the image specified exceends the maximum allowed dimensions.', 0, 238, 'Image Restrictions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1878, 'error_upload_filesizeTooBig', 'Sorry, but the file you are trying to upload exceeds the maximum allowed size.', 0, 238, 'File Size Too Big', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1879, 'error_upload_invalidAttachmentType', 'Sorry, but the file you are trying to upload does not match one of the allowable file extensions.', 0, 238, 'Invalid File Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1880, 'error_upload_errorMovingUploadedFile', 'Sorry, but we could not process your upload right now. Please contact the site administrator.', 0, 238, 'Error Moving', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1881, 'user_message_allowAttach', 'Allowed Extensions:', 0, 209, 'Allowed Extensions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1882, 'user_close', 'Close', 0, 190, 'Close', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1883, 'user_message_currentAttach', 'Current Attachments', 0, 209, 'Current Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1884, 'admin_usergroups_ae_maxAttach', 'Maximum Attachments Per Post:', 0, 70, 'Max Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1885, 'admin_usergroups_ae_maxAttach_desc', 'This is the maximum amount of attachments any user in this usergroup can upload.', 0, 70, 'Max Attachments Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1886, 'error_attach_tooMany', 'Sorry, but you can''t upload any more attachments as you have reached the per post limit.', 0, 237, 'Too Many', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1887, 'user_message_attachCap', 'Maximum Filesize Cap:', 0, 209, 'Max Filesize Cap', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1888, 'user_message_attachCap_note', 'Some extensions may be lower.', 0, 209, 'Max Filesize Cap Note', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1889, 'user_thread_attachments', 'Attachments:', 0, 216, 'Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1890, 'user_forum_removeRedirects', 'Remove Thread Redirects', 0, 205, 'Remove Redirects', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1891, 'user_forum_redirects', 'Removing Thread Redirects', 0, 195, 'Removing Thread Redirects', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1892, 'thanks_redirects', 'You have successfully removed all thread redirects for this forum.', 0, 194, 'Removing Redirects', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1893, 'admin_options_forumHome_hidePrivateForums', 'Hide Private Forums:', 0, 196, 'Hide Private Forums', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1894, 'admin_options_forumHome_hidePrivateForums_desc', 'If this is disabled, then users without access to any particular forum will be able to see that it exists. However they will not be able to view the contents.', 0, 196, 'Hide Private Forums Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1895, 'admin_style_i_folderReg', 'Folder Icon (Regular):', 0, 227, 'Folder Icon (Regular)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1896, 'admin_style_i_folderRegDot', 'Folder Icon (Regular - Dot):', 0, 227, 'Folder Icon (Regular - Dot)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1897, 'admin_style_i_folderHot', 'Folder Icon (Hot):', 0, 227, 'Folder Icon (Hot)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1898, 'admin_style_i_folderHotDot', 'Folder Icon (Hot - Dot):', 0, 227, 'Folder Icon (Hot - Dot)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1899, 'admin_options_forumSettings_hotReplies', 'Hot Thread - Replies:', 0, 197, 'Hot Thread - Replies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1900, 'admin_options_forumSettings_hotReplies_desc', 'This is the number of replies a thread can receive to be considered "hot." (Thread can be come hot through replies <strong>or</strong> views.)', 0, 197, 'Hot Thread - Replies Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1901, 'admin_options_forumSettings_hotViews', 'Hot Thread - Views:', 0, 197, 'Hot Thread - Views', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1902, 'admin_options_forumSettings_hotViews_desc', 'This is the number of views a thread can receive to be considered "hot." (Thread can be come hot through replies <strong>or</strong> views.)', 0, 197, 'Hot Thread - Views Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1903, 'user_forum_announcements', 'Announcements', 0, 205, 'Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1904, 'user_forum_announceTitle', 'Title', 0, 205, 'Announcement Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1905, 'user_forum_announceUpdate', 'Last Updated', 0, 205, 'Last Updated', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1906, 'user_announce_showing', 'Announcements for:', 0, 240, 'Showing Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1907, 'user_announcement', 'Viewing Announcements', 0, 195, 'Viewing Announcements', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1908, 'admin_style_i_announceIcon', 'Announcement Icon:', 0, 227, 'Announcement Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1909, 'user_collapse', 'Collapse', 0, 190, 'Collapse', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1910, 'user_expand', 'Expand', 0, 190, 'Expand', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1911, 'user_createpoll', 'Creating Poll', 0, 195, 'Creating Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1912, 'user_editpoll', 'Editing Poll', 0, 195, 'Editing Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1913, 'user_thread_poll_manage', 'Poll Management', 0, 243, 'Poll Management', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1914, 'user_thread_poll_options', 'Poll Options:', 0, 243, 'Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1915, 'user_thread_poll_title', 'Poll Question:', 0, 243, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1916, 'user_thread_poll_multiple', 'Multiple Choice', 0, 243, 'Multiple Choice', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1917, 'user_thread_poll_disabled', 'Disabled', 0, 243, 'Disabled', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1918, 'user_thread_addpoll', 'Add Poll', 0, 216, 'Add Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1919, 'admin_options_threadSettings_pollLimit', 'Poll Options Limit:', 0, 63, 'Poll Options Limit', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1920, 'admin_options_threadSettings_pollLimit_desc', 'This is the maximum number of poll options that can be added for any user.', 0, 63, 'Poll Options Limit Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1921, 'user_thread_poll_timeout', 'Poll Timeout:', 0, 243, 'Timeout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1922, 'user_thread_poll_timeout_desc', 'This is the number of <strong>days</strong> that this poll will remain open after it is created. If <strong>0</strong> is used, the poll will be perpetual.', 0, 243, 'Timeout Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1923, 'user_thread_poll_timeoutBlurb', 'Days after', 0, 243, 'Timeout Blurb', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1924, 'user_thread_poll_numOptions', 'Number of Poll Options:', 0, 243, 'Poll Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1925, 'user_thread_poll_update', 'Update', 0, 243, 'Update', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1926, 'user_thread_poll_updateBlurb', '(Current settings will not be erased.)', 0, 243, 'Update Blurb', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1927, 'user_thread_poll_option', 'Option', 0, 243, 'Poll Option', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1928, 'thanks_polladd', 'You have successfully created a poll. You will now be redirected back to the originating thread.', 0, 194, 'Poll Creation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1929, 'user_thread_poll_public', 'Show Voter Names', 0, 243, 'Public', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1930, 'admin_style_i_threadPre_poll', 'Thread Prefix (Poll):', 0, 227, 'Thread Prefix (Poll)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1931, 'user_forum_prePoll', 'Poll:', 0, 205, 'Prefix - Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1932, 'error_forum_doublePoll', 'Sorry, but there is already a poll in existance for this thread. If you are a moderator and have privleges, you can edit an existing poll or delete it.', 0, 202, 'Double Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1933, 'user_thread_editpoll', 'Edit Poll', 0, 216, 'Edit Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1934, 'user_votepoll', 'Voting', 0, 195, 'Voting', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1935, 'error_forum_invalidChoice', 'Sorry, but you have voted for an invalid option.', 0, 202, 'Invalid Vote Choice', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1936, 'thanks_pollvoted', 'You have successfully voted on the selected poll. You will now be redirected back to the originating thread.', 0, 194, 'Voted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1937, 'user_thread_delpoll', 'Delete Poll', 0, 216, 'Delete Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1938, 'thanks_deletepoll', 'You have successfully deleted the selected poll. You will now be redirected back to the originating thread.', 0, 194, 'Deleted Poll', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1939, 'user_thread_pollResults', 'Show Poll Results', 0, 216, 'Show Poll Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1940, 'user_thread_hidePollResults', 'Hide Poll Results', 0, 216, 'Hide Poll Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1941, 'user_thread_totalVotes', 'Total Votes:', 0, 216, 'Total Votes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1942, 'user_thread_poll_votes', 'Votes:', 0, 243, 'Votes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1943, 'user_thread_poll_voters', 'Voters:', 0, 243, 'Voters', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1944, 'thanks_pollupdate', 'You have successfully updated the requested poll. You will now be redirected back to the originating thread.', 0, 194, 'Poll Updated', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1945, 'error_forum_noPollTitle', 'Sorry, but you must enter a title for your poll.', 0, 202, 'Poll Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1946, 'error_forum_noPollOptions', 'Sorry, but you must specify at least one poll option.', 0, 202, 'No Poll Options', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1947, 'user_index_membersArea', 'Control Panel', 0, 191, 'User Control Panel', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1948, 'user_index_search', 'Search', 0, 191, 'Search', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1949, 'user_index_register', 'Register', 0, 191, 'Register', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1950, 'user_index_faq', 'FAQ', 0, 191, 'FAQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1951, 'user_index_home', 'Home', 0, 191, 'Home', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1952, 'user_index_logout', 'Logout', 0, 191, 'Logout', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1953, 'user_searching', 'Searching', 0, 195, 'Searching', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1954, 'user_viewsearch', 'Viewing Search Results', 0, 195, 'Viewing Search Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1955, 'user_search', 'Searching', 0, 244, 'Searching', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1956, 'user_search_query', 'Search Query:', 0, 244, 'Search Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1957, 'user_search_titlesOnly', 'Search Thread Titles Only', 0, 244, 'Search Titles Only', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1958, 'user_search_username', 'Threads/Posts Made by User:', 0, 244, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1959, 'user_search_matchExact', 'Match Exactly', 0, 244, 'Match Exactly', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1960, 'user_search_byUser', 'Only Search Threads Made by This User', 0, 244, 'Threads by User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1961, 'user_search_advanced', 'Advanced Search', 0, 244, 'Advanced Search', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1962, 'user_search_showResults', 'Show Results As:', 0, 244, 'Show Results As', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1963, 'user_search_threads', 'Threads', 0, 244, 'Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1964, 'user_search_posts', 'Posts', 0, 244, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1965, 'user_search_sort', 'Sort By:', 0, 244, 'Sort By', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1966, 'user_search_sort_author', 'Author', 0, 244, 'Sort By - Author', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1967, 'user_search_sort_date', 'Date', 0, 244, 'Sort By - Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1968, 'user_search_sort_replies', 'Replies (Threads)', 0, 244, 'Sort By - Replies (Threads)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1969, 'user_search_order', 'Order:', 0, 244, 'Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1970, 'user_search_order_asc', 'Ascending', 0, 244, 'Order - Ascending', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1971, 'user_search_order_desc', 'Descending', 0, 244, 'Order - Descending', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1972, 'user_search_cutoff', 'Date Cutoff:', 0, 244, 'Date Cutoff', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1973, 'user_search_cutoff_newer', 'And Newer', 0, 244, 'Date Cutoff - Newer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1974, 'user_search_cutoff_older', 'And Older', 0, 244, 'Date Cutoff - Older', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1975, 'user_search_forum', 'Forum:', 0, 244, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1976, 'error_search_userQuery', 'Sorry, but you must at least supply a search query or a username.', 0, 246, 'No Username or Query', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1977, 'user_search_results', 'Results:', 0, 244, 'Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1978, 'error_search_noResults', 'Sorry, your search returned no results.', 0, 246, 'No Results', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1979, 'admin_style_i_homeIcon', 'Home Icon:', 0, 227, 'Home Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1980, 'user_cp_cp', 'User Control Panel', 0, 247, 'User Control Panel', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1981, 'user_cp', 'User Control Panel', 0, 195, 'User Control Panel', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1982, 'user_cp_profile', 'Profile', 0, 247, 'Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1983, 'user_cp_preferences', 'Preferences', 0, 247, 'Preferences', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1984, 'user_cp_email', 'Email', 0, 247, 'Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1985, 'user_cp_avatar', 'Avatar', 0, 247, 'Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1986, 'user_cp_signature', 'Signature', 0, 247, 'Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1987, 'user_cp_password', 'Password', 0, 247, 'Change Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1988, 'user_cp_messages', 'Messages', 0, 247, 'Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1989, 'user_cp_pro_aim', 'AOL Instant Messenger Handle:', 0, 249, 'AIM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1990, 'user_cp_pro_icq', 'ICQ Number:', 0, 249, 'ICQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1991, 'user_cp_pro_yahoo', 'Yahoo! Messenger Handle:', 0, 249, 'Yahoo!', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1992, 'user_cp_pro_msn', 'MSN Messenger Handle:', 0, 249, 'MSN', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1993, 'user_cp_pro_homepage', 'Homepage:', 0, 249, 'Homepage', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1994, 'user_cp_pro_location', 'Location:', 0, 249, 'Location', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1995, 'thanks_profile', 'You have successfully updated your public profile. You will now be redirected back.', 0, 194, 'Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1996, 'user_cp_pro_birthday', 'Birthday:', 0, 249, 'Birthday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1997, 'user_cp_pro_custTitle', 'Custom Title:', 0, 249, 'Custom Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1998, 'user_cp_pro_custTitle_desc', 'This title will appear below your username when posting.', 0, 249, 'Custom Title Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (1999, 'user_cp_pro_revert', 'Revert to Default', 0, 249, 'Revert to Default', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2000, 'user_cp_pro_current', 'Current Custom Title:', 0, 249, 'Current Custom Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2001, 'admin_options_userOptions_maxTitle', 'Maximum Character Count for Custom Title:', 0, 58, 'Custom Title Max Char', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2002, 'admin_options_userOptions_maxTitle_desc', 'This is the maximum amount of characters that can be entered in the custom title input field in the User Control Panel.', 0, 58, 'Custom Title Max Char Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2003, 'admin_options_userOptions_minTitle', 'Minimum Character Count for Custom Title:', 0, 58, 'Custom Title Min Char', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2004, 'admin_options_userOptions_minTitle_desc', 'This is the minimum amount of characters that can be entered in the custom title input field in the User Control Panel.', 0, 58, 'Custom Title Min Char Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2005, 'error_cp_maxTitle', 'Sorry, but you have exceeded the maximum amount of characters for a custom title:', 0, 250, 'Max Chars Custom Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2006, 'error_cp_minTitle', 'Sorry, but you are under the minimum amount of characters for a custom title:', 0, 250, 'Min Chars Custom Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2007, 'user_cp_pref_timezone', 'Timezone:', 0, 251, 'Timezone', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2008, 'user_cp_pref_dst', 'Daylight Savings Time:', 0, 251, 'Daylight Savings Time', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2009, 'thanks_preferences', 'You have successfully updated your preferences. You will now be redirected back.', 0, 194, 'Preferences', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2010, 'user_cp_pref_disImgs', 'Disable Image Viewing:', 0, 251, 'Disable Images', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2011, 'user_cp_pref_disAv', 'Disable Avatar Viewing:', 0, 251, 'Disable Avatars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2012, 'user_cp_pref_disSmi', 'Disable Smiley Viewing:', 0, 251, 'Disable Smilies', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2013, 'user_cp_pref_disAttach', 'Disable Attachment Thumbnail Viewing:', 0, 251, 'Disable Attachment Viewing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2014, 'user_cp_pref_disSigs', 'Disable Signature Viewing:', 0, 251, 'Disable Signatures', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2015, 'user_cp_pref_toolbar', 'Enable BB Code Toolbar:', 0, 251, 'BB Code Toolbar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2016, 'user_cp_pref_toolbar_desc', 'If this is enabled, you will be able to use a toolbar that will automatically insert text/image formatting codes for you.', 0, 251, 'BB Code Toolbar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2017, 'user_cp_pref_invis', 'Invisible:', 0, 251, 'Invisible', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2018, 'user_cp_pref_invis_desc', 'If you are invisible, other users will not be able to see that you are browsing the forums.', 0, 251, 'Invisible Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2019, 'user_cp_pref_emailContact', 'Allow Contact by Email:', 0, 251, 'Email Contact', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2020, 'user_cp_pref_emailContact_desc', 'If this is enabled, other members will be able to contact you by email through the message board.', 0, 251, 'Email Contact Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2021, 'user_cp_pref_adminEmails', 'Allow Administrator Emails:', 0, 251, 'Admin Emails', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2022, 'user_cp_pref_adminEmails_desc', 'If this is disabled, any emails that an administrator sends will not be sent to you.', 0, 251, 'Admin Emails Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2023, 'user_cp_pref_receivePm', 'Receive Personal Messages:', 0, 251, 'Receive Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2024, 'user_cp_pref_receivePm_desc', 'If this is disabled, users will not be able to send you personal messages through the bulletin board. You will still be able to send messages, however.', 0, 251, 'Receive Messages Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2025, 'user_cp_pref_receivePmEmail', 'Receive Personal Message Notifications:', 0, 251, 'Receive Message Notification', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2026, 'user_cp_pref_receivePmEmail_desc', 'If this is enabled, you will receive an email notification whenever someone sends you a new personal message.', 0, 251, 'Receive Message Notification Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2027, 'user_cp_pref_receivePmAlert', 'Receive Personal Message Alerts:', 0, 251, 'Receive Message Alert', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2028, 'user_cp_pref_receivePmAlert_desc', 'If this is enabled, you will be alerted of any new personal messages upon visiting the message board.', 0, 251, 'Receive Message Alert Notification', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2029, 'user_cp_pref_censor', 'Disable Forum-Wide Censor:', 0, 251, 'Disable Censor', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2030, 'user_cp_pref_postsPerPage', 'Posts Per Page:', 0, 251, 'Posts Per Page', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2031, 'user_cp_pref_styleid', 'Forum Style:', 0, 251, 'Forum Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2032, 'user_cp_pref_defaultStyle', 'Forum Default Style', 0, 251, 'Forum Default Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2033, 'admin_options_setup_defStyle', 'Default Style:', 0, 4, 'Default Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2034, 'admin_options_setup_defStyle_desc', 'If a user hasn''t selected a style, or a guest is visiting, then this style will be used.', 0, 4, 'Default Style Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2035, 'user_cp_pref_langid', 'Default Language:', 0, 251, 'Default Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2036, 'user_cp_pref_defaultLang', 'Forum Default Language', 0, 251, 'Forum Default Language', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2042, 'user_reg', 'Forum Registration', 0, 252, 'Forum Registration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2041, 'user_registering', 'Registering', 0, 195, 'Registering', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2044, 'admin_options_userOptions_usernameMax_desc', 'This is the maximum amount of characters a user can have in their username when registering.', 0, 58, 'Username Max Char Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2045, 'admin_options_userOptions_usernameMin', 'Minimum Character Count for Username:', 0, 58, 'Username Min Char', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2046, 'admin_options_userOptions_usernameMin_desc', 'This is the minimum amount of characters a user can have in their username when registering.', 0, 58, 'Username Min Char Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2047, 'admin_options_userOptions_coppa', 'Allow COPPA Registrations:', 0, 58, 'Allow COPPA Registrations', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2048, 'admin_options_userOptions_coppa_desc', 'It is required by law to get parental consent when collecting information from children under the age of 13. When this is enabled, wtcBB will collect a parent''s email address, and send them the activation email instead of sending it to the user''s email. If you do not have to conform to the COPPA regulations, then you may disable this and the user will not be asked for their birthday (making for a quicker registration).\r\n\r\n<br /><br />\r\n\r\nSee <a href="http://www.ftc.gov/bcp/conline/pubs/buspubs/coppa.htm">http://www.ftc.gov/bcp/conline/pubs/buspubs/coppa.htm</a> for more details.', 0, 58, 'Allow COPPA Registrations Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2049, 'error_reg_invalidRequest', 'Sorry, but you have made an invalid request to our registration system. This might be caused by an invalid link, or an attempt to bypass a step. Please try again by using a link found on the message board.', 0, 254, 'Invalid Registration Request', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2050, 'user_reg_birthday', 'Birthday', 0, 252, 'Birthday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2051, 'user_reg_tos', 'Terms of Service', 0, 252, 'Terms of Service', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2052, 'user_reg_tos_mustAgree', 'You must agree to the following Terms of Service in order to register:', 0, 252, 'Must Agree', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2053, 'user_reg_tos_text', 'Registration is free, and you do so under your own free will. In order to proceed with the registration and keep a membership, you must agree that you have acknowledged these forum rules.\r\n\r\n<br /><br />\r\n\r\nThe forum Administrators and Moderators try to keep this forum clean, however they cannot moderate everything. The adminstrators, owners, developers of wtcBB, and moderators of this bulletin board are not responsible for the content of any message posted here. Only the author of a respecting post is responsible for its contents. Therefore, only the author of a message can be held accountable for the content of that message. Owners, administrators, or moderators have the right to remove, edit, add, or alter anyone''s account or messages for any reason they deem necessary.\r\n\r\n<br /><br />\r\n\r\nBy clicking the "I Agree" link below, you agree to follow the rules stated here, and any rules, regulations, or guidelines stated by the administrators, owners, or moderators of this forum.', 0, 252, 'Terms of Service Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2054, 'user_reg_tos_agree', 'I Agree', 0, 252, 'I Agree', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2055, 'user_reg_tos_disagree', 'I Disagree', 0, 252, 'I Disagree', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2056, 'user_reg_info', 'Registration Information', 0, 252, 'Registration Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2057, 'user_reg_info_required', 'Required Information', 0, 252, 'Required Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2058, 'user_reg_info_additional', 'Additional Information', 0, 252, 'Additional Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2059, 'user_reg_info_username', 'Username:', 0, 252, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2060, 'user_reg_info_password', 'Password:', 0, 252, 'Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2061, 'user_reg_info_confPassword', 'Confirm Password:', 0, 252, 'Confirm Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2062, 'user_reg_info_email', 'Email Address:', 0, 252, 'Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2063, 'user_reg_info_parentEmail', 'Parent''s Email Address:', 0, 252, 'Parent''s Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2064, 'user_reg_info_referrer', 'Referrer:', 0, 252, 'Referrer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2065, 'error_reg_usernameMax', 'Sorry, but the username you have chosen exceeds the maximum amount of allowed characters:', 0, 254, 'Username Max Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2066, 'error_reg_usernameMin', 'Sorry, but the username you have chosen is under the minimum amount of allowed characters:', 0, 254, 'Username Min Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2067, 'error_reg_usernameInvalid', 'Sorry, but a username can only contain numbers, letters, hypens, underscores, and spaces.', 0, 254, 'Invalid Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2068, 'error_reg_uniqueUsername', 'Sorry, but you must specify a unique username.', 0, 254, 'Unique Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2069, 'error_reg_uniqueEmail', 'Sorry, but someone has already registered with the email address specified. Please supply a different email address.', 0, 254, 'Unique Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2070, 'error_reg_passMatch', 'Sorry, but the passwords you have entered do not match.', 0, 254, 'Password Mismatch', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2071, 'error_reg_requiredFields', 'Sorry, but you must fill in all required fields.', 0, 254, 'Required Fields', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2072, 'error_reg_parentEmail', 'Sorry, but your user email address cannot be the same as your parent email address.', 0, 254, 'Parent Email Match', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2073, 'user_cp_pref_displayOrder', 'Posts'' Display Order:', 0, 251, 'Posts Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2074, 'user_cp_pref_displayOrder_asc', 'Oldest Posts First', 0, 251, 'Posts Display Order - ASC', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2075, 'user_cp_pref_displayOrder_desc', 'Newest Posts First', 0, 251, 'Posts Display Order - DESC', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2076, 'thanks_registration', 'You have successfully registered. Please visit your User Control Panel to customize your forum experience.', 0, 194, 'Registration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2077, 'user_activating', 'Activating Account', 0, 195, 'Activating Account', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2078, 'thanks_activation', 'You have successfully activated your account.', 0, 194, 'Activation Complete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2079, 'error_reg_activated', 'Sorry, but our records show that your account is already activated.', 0, 254, 'Already Activated', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2080, 'error_reg_invalidActivate', 'Sorry, but you have followed a broken link or specified an invalid activation code.', 0, 254, 'Invalid Activation Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2081, 'user_reg_activating', 'Account Activation', 0, 252, 'Account Activation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2082, 'user_cp_emailChange', 'Change Email Address', 0, 255, 'Change Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2083, 'user_cp_email_current', 'Current Email Address:', 0, 255, 'Current Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2084, 'user_cp_email_new', 'New Email Address:', 0, 255, 'New Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2085, 'user_cp_email_newConf', 'Confirm New Email Address:', 0, 255, 'Confirm New Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2086, 'user_cp_email_actRequired', 'Activation Required', 0, 255, 'Activation Required', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2087, 'user_cp_email_act', 'In order to change your email address, you must activate it by responding to an automatic email sent to your current email address. If it is not activated in 24 hours or less, you must fill out this form again. No information will be changed until you activate the new email address.', 0, 255, 'Activation Required Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2088, 'error_cp_emailMatch', 'Sorry, but the email addresses you have specified do not match each other.', 0, 250, 'Emails Don''t Match', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2089, 'thanks_emailActivation', 'You have sucessfully changed your email address. You will now be redirected to your User Control Panel.', 0, 194, 'Email Activation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2090, 'thanks_passActivation', 'You have successfully changed your password. You will now be redirected to your User Control Panel.', 0, 194, 'Password Activation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2091, 'thanks_actSent', 'Your activation email has been sent. Follow the directions in the email to complete your activation.', 0, 194, 'Activation Email Sent', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2092, 'error_cp_badActCode', 'Sorry, but you have followed a dead link or have used an invalid activation code.', 0, 250, 'Bad Activation Code', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2093, 'error_cp_actCodeExpire', 'Sorry, but the activation you are trying to complete has expired. Please try again.', 0, 250, 'Activation Expiration', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2094, 'error_cp_passMatch', 'The passwords you have provided do not match. Please try again.', 0, 250, 'Password Mismatch', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2095, 'user_cp_pass_act', 'In order to change your password, you must activate it by responding to an automatic email sent to your email address. If it is not activated in 24 hours or less, you must fill out this form again. No information will be changed until you activate the new password. You are also required to provide your current password.', 0, 256, 'Activation Required Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2096, 'user_cp_pass_actRequired', 'Activation Required', 0, 256, 'Activation Required', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2097, 'user_cp_passChange', 'Change Password', 0, 256, 'Change Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2098, 'user_cp_pass_current', 'Current Password:', 0, 256, 'Current Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2099, 'user_cp_pass_new', 'New Password:', 0, 256, 'New Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2100, 'user_cp_pass_newConf', 'Confirm New Password:', 0, 256, 'Confirm New Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2101, 'error_cp_currentMatch', 'Sorry, but the current password you provided does not match your real password.', 0, 250, 'Current Password Mismatch', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2102, 'user_cp_pref_forumDefault', 'Forum Default', 0, 251, 'Forum Default', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2103, 'user_cp_sig', 'Edit Signature', 0, 258, 'Edit Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2104, 'admin_options_userOptions_maxSig', 'Maximum Characters Allowed in Signature:', 0, 58, 'Max Chars for Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2105, 'admin_options_userOptions_maxSig_desc', 'Users will not be able to use more characters than the limit specified here in their signature. Enter <strong>0</strong> here to not impose a limit.', 0, 58, 'Max Chars for Signature Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2106, 'admin_usergroups_ae_sigMaxChars', 'Maximum Characters in Signature:', 0, 70, 'Override Max Signature Chars', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2107, 'admin_usergroups_ae_sigMaxChars_desc', 'If this is enabled, members of this group will not be subject to the maximum amount of characters in a signature restriction.', 0, 70, 'Override Max Signature Chars Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2108, 'error_cp_sigRestrict', 'Sorry, but the maximum allowed characters for a signature is:', 0, 250, 'Character Sig Restriction', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2109, 'thanks_sig', 'You have sucessfully changed your signature. You will now be redirected back.', 0, 194, 'Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2110, 'user_cp_av', 'Edit Avatar', 0, 257, 'Edit Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2111, 'global_avatar', 'Avatar', 0, 64, 'Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2112, 'global_delete', 'Delete', 0, 64, 'Delete', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2113, 'user_cp_av_current', 'Current Avatar:', 0, 257, 'Current Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2114, 'user_cp_av_custom', 'Custom Avatar', 0, 257, 'Custom Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2115, 'user_cp_av_url', 'URL Address:', 0, 257, 'URL Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2116, 'user_cp_av_url_desc', 'You can specify a URL location to your avatar of choice (beginning with "http://"). This avatar will be treated like one that is uploaded, and the same restrictions will be applied.', 0, 257, 'URL Address Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2117, 'user_cp_av_upload', 'Upload Avatar:', 0, 257, 'Upload Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2118, 'user_cp_av_upload_desc', 'If the avatar you want to use isn''t already on the internet, you may upload an image from your computer to use as an avatar.', 0, 257, 'Upload Avatar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2119, 'user_cp_av_choose', 'Choose Avatar', 0, 257, 'Choose Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2120, 'thanks_avatar', 'You have successfully update your avatar. You will now be redirected back.', 0, 194, 'Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2121, 'error_cp_avNothing', 'Sorry, but there is nothing to do here. There are no avatars available, you do not have permission to upload avatars, and you do not currently have an avatar set.', 0, 250, 'Nothing to Do', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2122, 'error_cp_mustUploadImage', 'Sorry, but you must specify an image for an avatar.', 0, 250, 'Must Upload Image', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2123, 'user_cp_av_maxSize', 'Maximum Filesize (Kilobytes):', 0, 257, 'Maximum Filesize', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2124, 'user_cp_av_maxHeight', 'Maximum Height (pixels):', 0, 257, 'Maximum Height', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2125, 'user_cp_av_maxWidth', 'Maximum Width (pixels):', 0, 257, 'Maximum Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2126, 'error_cp_retrieval', 'Sorry, but wtcBB could not obtain the contents of the specified file.', 0, 250, 'File Retrieval Error', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2127, 'admin_users_ae_av', 'Avatar:', 0, 60, 'Avatar', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2128, 'admin_users_ae_av_desc', 'This is the user''s avatar. As an adminstrator, you can specify any image here.', 0, 60, 'Avatar Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2129, 'user_per_send', 'Send Message', 0, 260, 'Send Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2130, 'user_per_convo', 'Conversations', 0, 260, 'Conversations', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2131, 'user_per_folders', 'Folders', 0, 260, 'Folders', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2132, 'user_per_rules', 'Message Rules', 0, 260, 'Message Rules', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2133, 'user_per_per', 'Personal Messages', 0, 260, 'Personal Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2134, 'user_per', 'Personal Messaging', 0, 195, 'Personal Messaging', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2135, 'user_per_send_subject', 'Subject:', 0, 261, 'Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2136, 'user_per_send_to', 'Send To:', 0, 261, 'Send To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2137, 'user_per_send_to_desc', 'You may specify more than one user here. Please separate usernames by commas. If you are replying to a current conversation, you may specify more users here and they will be given access to the whole conversation. You are limited to the amount of simultaneous messages that you can send at one time to:', 0, 261, 'Send To Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2138, 'user_per_noSend', 'Sorry, but you must specify at least one user to send a message too.', 0, 264, 'No Users Specified', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2139, 'error_per_badUser', 'Sorry, but one of the usernames you specified is invalid:', 0, 264, 'Bad Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2140, 'thanks_sentPerMessage', 'You have successfully sent your message to all recipients specified.', 0, 194, 'Sent Personal Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2141, 'user_per_convo_name', 'Title', 0, 262, 'Conversation Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2142, 'user_per_convo_messages', 'Messages', 0, 262, 'Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2143, 'user_per_convo_last', 'Last Message', 0, 262, 'Last Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2144, 'error_per_emptyFolder', 'Sorry, but there are currently no conversations in the folder you are trying to view.', 0, 264, 'Empty Folder', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2145, 'user_per_convo_members', 'Members in Conversation: ', 0, 262, 'Members in Convo', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2146, 'user_per_folders_desc', 'Folders are a way to organize your conversations. Folders act strictly as an organizational means, and allow you to classify your messages. You may also use them to mass-delete all messages (in a particular folder by deleting the folder).', 0, 265, 'Folder Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2147, 'user_per_folders_manage', 'Manage Folders', 0, 265, 'Manage Folders', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2148, 'global_delSel', 'Delete Selected', 0, 64, 'Delete Selected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2149, 'user_per_folders_messages', 'Conversations:', 0, 265, 'Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2150, 'user_per_folders_add', 'Add Folder', 0, 265, 'Add Folder', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2151, 'user_per_folders_name', 'Folder Name:', 0, 265, 'Folder Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2152, 'thanks_addFolder', 'You have successfully added a folder. You will now be redirected back.', 0, 194, 'Added Folder', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2153, 'thanks_updateFolders', 'You have successfully updated your folders. You will now be redirected back.', 0, 194, 'Updated Folders', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2154, 'admin_style_i_closeAll', 'Close All Icon:', 0, 227, 'Close All Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2155, 'user_per_folder', 'Folder:', 0, 260, 'Folder', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2156, 'user_per_convo_none', 'Sorry, but there are no messages in the selected folder at this time.', 0, 262, 'No Messages', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2157, 'user_per_convo_withSelected', 'With Selected:', 0, 262, 'With Selected', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2158, 'user_per_convo_moveTo', 'Move To', 0, 262, 'Move To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2159, 'thanks_convoDelete', 'The selected conversations were successfully deleted. You will now be redirected back.', 0, 194, 'Conversations Deleted', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2160, 'thanks_convoMoved', 'Your conversations were successfully moved to the desginated folder. You will now be redirected back.', 0, 194, 'Conversations Moved', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2161, 'error_per_noSend', 'Sorry, but you did not specify any recipients.', 0, 264, 'No Recipients', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2162, 'user_per_folders_viewMessages', 'View Conversations', 0, 265, 'View Conversations', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2163, 'user_index_members', 'Member List', 0, 191, 'Member List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2164, 'user_memberlist', 'Viewing Member List', 0, 195, 'Member List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2165, 'user_memList_memList', 'Member''s List', 0, 266, 'Member''s List', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2166, 'user_memList_username', 'Username', 0, 266, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2167, 'user_memList_posts', 'Posts', 0, 266, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2168, 'user_memList_lastpost', 'Last Post', 0, 266, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2169, 'user_memList_contact', 'Contact', 0, 266, 'Contact', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2170, 'user_memList_joined', 'Join Date', 0, 266, 'Join Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2171, 'user_memList_sendEmail', 'Send Email', 0, 266, 'Send Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2172, 'user_memList_sendPm', 'Send Personal Message', 0, 266, 'Send PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2173, 'user_memList_never', 'Never', 0, 266, 'Never', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2174, 'user_memList_findLastPost', 'Find Last Post', 0, 266, 'Find Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2175, 'user_index_newPosts', 'New Posts', 0, 191, 'New Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2176, 'user_newposts', 'Viewing New Posts', 0, 195, 'New Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2177, 'error_noNewPosts', 'Sorry, but there are no new posts.', 0, 202, 'No New Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2178, 'user_viewingpost', 'Viewing Post', 0, 195, 'Viewing Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2179, 'user_thread_viewingPost', 'Single Post View', 0, 216, 'Single Post View', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2180, 'user_profile', 'Viewing Member Profile', 0, 195, 'Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2181, 'user_profile_profile', 'Member Profile', 0, 268, 'Member Profile', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2182, 'user_profile_email', 'Send Email', 0, 268, 'Send Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2183, 'user_profile_pm', 'Send Personal Message', 0, 268, 'Send PM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2184, 'user_profile_username', 'Username:', 0, 268, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2185, 'user_profile_title', 'Title:', 0, 268, 'Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2186, 'user_profile_contact', 'Contact:', 0, 268, 'Contact', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2187, 'user_profile_joined', 'Join Date:', 0, 268, 'Join Date', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2188, 'user_profile_lastPost', 'Last Post:', 0, 268, 'Last Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2189, 'user_profile_lastActive', 'Last Activity:', 0, 268, 'Last Activity', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2190, 'user_profile_threads', 'Thread Count:', 0, 268, 'Thread Count', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2191, 'user_profile_posts', 'Post Count:', 0, 268, 'Post Count', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2192, 'user_profile_birthday', 'Birthday:', 0, 268, 'Birthday', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2193, 'user_profile_contactInfo', 'Contact Information', 0, 268, 'Contact Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2194, 'user_profile_aim', 'AIM:', 0, 268, 'AIM', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2195, 'user_profile_msn', 'MSN:', 0, 268, 'MSN', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2196, 'user_profile_yahoo', 'Yahoo:', 0, 268, 'Yahoo', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2197, 'user_profile_icq', 'ICQ:', 0, 268, 'ICQ', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2198, 'user_sendemail', 'Sending Email', 0, 195, 'Sending Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2199, 'user_sende_sende', 'Send Email', 0, 270, 'Send Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2200, 'user_sende_username', 'Send To:', 0, 270, 'Send To', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2201, 'user_sende_message', 'Message:', 0, 270, 'Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2202, 'error_sende_noUser', 'Sorry, but you did not specify a user to send an email to.', 0, 226, 'Email No User Specified', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2203, 'error_sende_noMessage', 'Sorry, but you must specify a message to send to a recipient.', 0, 226, 'Email No Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2204, 'thanks_sendEmail', 'You have successfully sent an email to the specified user. You will now be redirected back.', 0, 194, 'Send Email', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2205, 'user_sende_boardMailer', 'Board Mailer', 0, 270, 'Board Mailer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2206, 'user_pmAlertConf', 'You have new messages. Would you like to view them now?', 0, 190, 'PM Alert Message', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2207, 'user_lastVisitHere', 'Last Visit', 0, 190, 'Last Visit Here', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2208, 'user_viewerror', 'Error', 0, 195, 'Viewing Error', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2209, 'user_rememberMe', 'Remember Me', 0, 190, 'Remember Me', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2210, 'user_index_threads', 'Threads:', 0, 191, 'Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2211, 'user_index_posts', 'Posts:', 0, 191, 'Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2212, 'user_index_memberCount', 'Members:', 0, 191, 'Members', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2213, 'user_index_welcome', 'Welcome our newest member, ', 0, 191, 'Welcome', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2214, 'user_forumJump', 'Forum Jump', 0, 190, 'Forum Jump', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2215, 'user_forum_hits', 'Hits:', 0, 205, 'Hits:', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2216, 'error_message_nameLengthMin', 'Sorry, but your username is under the required minimum length.', 0, 226, 'Username Length Minimum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2217, 'error_message_nameLengthMax', 'Sorry, but your username is over the maximum amount of characters.', 0, 226, 'Username Length Maximum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2218, 'admin_maint_forums_desc', 'This will update all forum information, such as the last reply fields as well as post and thread counts.', 0, 229, 'Forum Information Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2219, 'admin_maint_usernames', 'Usernames:', 0, 229, 'Usernames', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2220, 'admin_maint_usernames_desc', 'This will reset all usernames stored to match current usernames. For example, this will update thread and post usernames, as well as usernames that appear in the "last reply" fields.', 0, 229, 'Usernames Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2221, 'user_thread_downloads', 'Downloads:', 0, 216, 'Downloads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2222, 'admin_style_i_attachIcon', 'Attachment Icon:', 0, 154, 'Attachment Icon', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2223, 'admin_nav_wtcBBOpt_attachments', 'Attachments', 0, 20, 'Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2224, 'admin_options_attachments', 'Attachment Settings', 0, 273, 'Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2225, 'admin_options_attachments_thumbWidth', 'Thumbnail Max Width:', 0, 273, 'Thumbnail Max Width', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2226, 'admin_options_attachments_thumbWidth_desc', 'This is the maximum width (in pixels) that any thumbnail can be. If an image is uploaded and is greater than this width, it will be resized proportionally (for the thumbnail only). <strong>Be careful not set this value too high, as it could heavily consume resources.</strong>', 0, 273, 'Thumbnail Max Width Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2227, 'admin_options_attachments_thumbHeight', 'Thumbnail Max Height:', 0, 273, 'Thumbnail Max Height', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2228, 'admin_options_attachments_thumbHeight_desc', 'This is the maximum height (in pixels) that any thumbnail can be. If an image is uploaded and is greater than this height, it will be resized proportionally (for the thumbnail only). <strong>Be careful not set this value too high, as it could heavily consume resources.</strong>', 0, 273, 'Thumbnail Max Height Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2229, 'admin_options_attachments_thumbnails', 'Thumbnail Generation:', 0, 273, 'Thumbnail Generation', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2230, 'admin_options_attachments_thumbnails_desc', 'If this is disabled, thumbnails will not be generated for images uploaded as attachments. Please note that <strong>GD 2.0.28</strong> must be installed. If you do not know what this is, or do not know which version is installed, please contact your host or server administrator.', 0, 273, 'Thumbnail Generation Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2231, 'user_thread_thumbnails', 'Thumbnails:', 0, 216, 'Thumbnails', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2232, 'admin_usergroups_ae_showRanks', 'Show User Ranks:', 0, 70, 'Show Ranks', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2233, 'admin_usergroups_ae_showRanks_desc', 'If this is disabled, user rank images will not show for this usergroup.', 0, 70, 'Show Ranks Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2234, 'user_rankAlt', 'Rank Image', 0, 190, 'Rank Image Alt', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2235, 'user_index_messaging', 'Messaging', 0, 191, 'Messaging', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2236, 'user_thread_reportPost', 'Report Post', 0, 216, 'Report Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2237, 'user_sende_reportReason', 'Why are you reporting this message?', 0, 270, 'Report Reason', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2238, 'user_sende_report', 'When you report a message, a link to the post and your reason are emailed to all administrators and moderators of the respected forum.', 0, 270, 'Report Instructions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2239, 'error_sende_userNoExist', 'Sorry, but the username you entered does not match any account on file.', 0, 226, 'User Does Not Exist', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2240, 'email_notOfficial', 'This is not an official board mailer, and has been sent to you from another member through the forum mailing system.', 0, 274, 'Not Official Board Mailer', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2241, 'email_stop', 'If you do not wish to receive anymore emails, please login to your account and disable all appropriate email options.', 0, 274, 'Stop Emails', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2242, 'admin_options_information_emailSig', 'Email Signature:', 0, 3, 'Email Signature', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2243, 'admin_options_information_emailSig_desc', 'This text will be signed at the bottom of every board mailer.', 0, 3, 'Email Signature Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2244, 'email_noSub', 'No Subject', 0, 274, 'No Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2245, 'email_subSub', 'Subscription Notification', 0, 274, 'Subscription Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2246, 'email_adminSub', 'Email from Administrator', 0, 274, 'Admin Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2247, 'email_reportSub', 'Reported Post', 0, 274, 'Report Post Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2248, 'email_userSub', 'Email from User', 0, 274, 'User Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2249, 'email_regMessageAct', 'Hello,\r\n\r\nYou have successfully registered for our community message board. We ask that you complete the final step of our registration process by clicking on the link below to validate your email address. (If you cannot click on the link below, then please copy and paste it into your address bar.)', 0, 274, 'Message - Registration (Activation)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2250, 'email_regMessageComp', 'Hello,\r\n\r\nCongratulations! You have successfully completed the registration process to our community message board.', 0, 274, 'Message - Registration (Complete)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2251, 'email_regActSub', 'Email Activation', 0, 274, 'Registration (Activation) Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2252, 'email_regCompSub', 'Registration Complete', 0, 274, 'Registration (Complete) Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2253, 'email_repPost', 'Hello,\r\n\r\nA post has been reported. Details are listed below:', 0, 274, 'Message - Report Post', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2254, 'email_repPost_user', 'Reported By:', 0, 275, 'User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2255, 'email_repPost_forum', 'Forum:', 0, 275, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2256, 'email_repPost_thread', 'Thread:', 0, 275, 'Thread', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2257, 'email_repPost_link', 'Post Link:', 0, 275, 'Post Link', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2258, 'email_repPostReason', 'Reason:', 0, 275, 'Reason', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2259, 'email_subscribe', 'Hello,\r\n\r\nThis is a subscription notification for a forum or thread that you subscribed for. This means that there has been a new thread or reply made since the last time you visited. You may click on the link below to view the new thread/reply. (If you cannot click on the link below, then please copy and paste it to your address bar.)', 0, 274, 'Message - Subscription Notification', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2260, 'email_regMessageCoppa', 'Hello,\r\n\r\nYour child has recently registered for our community message board. In order to allow your child to become a full and complete member, you must first verify their membership in compliance with the Child Online Privacy Protection Act by clicking the link below. (If you cannot click on the link below, please copy and paste it into your address bar.)', 0, 274, 'Message - Registration (COPPA Activation)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2261, 'email_regCoppaSub', 'Parental Verification', 0, 274, 'Registration (COPPA Activation) Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2262, 'thanks_registration_act', 'You have successfully registered. Please visit your User Control Panel to customize your forum experience. <strong>Please note that you must verify your email address by clicking on the link in the email that was sent. Until you do this, you will not achieve full member status.</strong> If you do not receive an email, please contact the site administrator.', 0, 194, 'Registration (Activation)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2263, 'thanks_registration_coppa', 'You have successfully registered. Please visit your User Control Panel to customize your forum experience. <strong>Please note that your parent/guardian must verify your registration by clicking on the link in the email that was sent. Until you do this, you will not achieve full member status.</strong> If you do not receive an email, please contact the site administrator.', 0, 194, 'Registration (COPPA Activation)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2264, 'email_passVerify', 'Hello,\r\n\r\nIn order to modify your password, you must first confirm that you want to change it. If you did not request that your password be changed, then simply do nothing as the ability to confirm this email only lasts for 24 hours. After 24 hours, any attempt to confirm your new password will be invalid.\r\n\r\nIn order to verify the password change, please click on the following link. (If you cannot click on the link below, then please copy and paste it into your address bar.)', 0, 274, 'Message - Verify Password Change', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2265, 'email_verifyPassSub', 'Activate New Password', 0, 274, 'Verify Password Change Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2266, 'email_verifyEmailSub', 'Activate New Email Address', 0, 274, 'Verify Email Change Subject', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2267, 'email_emailVerify', 'Hello,\r\n\r\nIn order to modify your email address, you must first confirm that you want to change it. If you did not request that your email address be changed, then simply do nothing as the ability to confirm this email only lasts for 24 hours. After 24 hours, any attempt to confirm your new email address will be invalid.\r\n\r\nIn order to verify the email address change, please click on the following link. (If you cannot click on the link below, then please copy and paste it into your address bar.)', 0, 274, 'Message - Verify Email Change', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2268, 'error_sende_noReason', 'Sorry, but in order to report a post, you must first give a reason as to why you are reporting the post.', 0, 226, 'Email No Reason', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2269, 'user_sende_reportTitle', 'Reporting a Post', 0, 270, 'Report Instructions Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2270, 'user_sende_reason', 'Post Report Reason', 0, 270, 'Post Report Reason', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2271, 'thanks_sendReport', 'You have successfully reported a post. This report will be sent to all administrators of the community, and to all the moderators of the forum that the post was in.', 0, 194, 'Sent Post Report', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2272, 'admin_style_i_threadPre_attach', 'Thread Prefix (Attachment Icon):', 0, 227, 'Thread Prefix (Attachment Icon)', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2273, 'user_forum_preAttach', 'Attachments in Thread', 0, 205, 'Prefix - Has Attachments', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2274, 'admin_nav_cusPro_title', 'Profile Fields', 0, 276, 'Main Title', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2275, 'admin_nav_cusPro_man', 'Custom Profile Field Manager', 0, 276, 'Custom Profile Field Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2276, 'admin_nav_cusPro_add', 'Add Custom Profile Field', 0, 276, 'Add Custom Profile Field', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2277, 'admin_usergroups_admins_cus_pro', 'Custom Profile Fields:', 0, 72, 'Custom Profile Fields', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2278, 'admin_cusPro_add', 'Add Profile Field', 0, 277, 'Add Profile Field', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2279, 'admin_cusPro_edit', 'Edit Profile Field', 0, 277, 'Edit Profile Field', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2280, 'admin_cusPro_ae_fieldName', 'Field Name:', 0, 278, 'Field Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2281, 'admin_cusPro_ae_fieldName_desc', 'This is the name of the field, and will be displayed to the user.', 0, 278, 'Field Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2282, 'admin_cusPro_ae_fieldDesc', 'Field Description:', 0, 278, 'Field Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2283, 'admin_cusPro_ae_fieldDesc_desc', 'This is the description of the field, and will be shown underneathe the field name to the user.', 0, 278, 'Field Description Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2284, 'admin_cusPro_ae_fieldType', 'Field Type:', 0, 278, 'Field Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2285, 'admin_cusPro_ae_fieldType_desc', 'This option governs how the user modifies this data. They can either enter their own free-form text, select one choice using a drop down menu or a set of radio buttons, or select many choices using a multi-select menu or a set of checkboxes.', 0, 278, 'Field Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2286, 'admin_cusPro_ae_defValue', 'Default Value:', 0, 278, 'Default Value', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2287, 'admin_cusPro_ae_defValue_desc', 'The default value for a field is the text that will automatically be displayed, or the choice that will already be selected. (If you are using a multi-select/checkbox option, you can separate multi-selected default items with a new line.) If you are using anything but a normal text box or a textarea, please make sure the default value text matches exactly the items you want selected, or else they will not be selected.', 0, 278, 'Default Value Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2288, 'admin_cusPro_ae_optionText', 'Options:', 0, 278, 'Option Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2289, 'admin_cusPro_ae_optionText_desc', 'If you have selected anything but "text" for the field type, then please list all of the different options you want for this field (they will be shown in select menus, multi-select menus, checkboxes, or radio buttons). Please put each item on its own line.', 0, 278, 'Option Text Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2290, 'admin_cusPro_f_text', 'Text', 0, 280, 'Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2291, 'admin_cusPro_f_select', 'Select Menu', 0, 280, 'Select Menu', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2292, 'admin_cusPro_f_multi-select', 'Multi-Select Menu', 0, 280, 'Multi-Select Menu', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2293, 'admin_cusPro_f_radio', 'Radio Buttons', 0, 280, 'Radio Buttons', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2294, 'admin_cusPro_f_checkbox', 'Checkboxes', 0, 280, 'Checkboxes', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2295, 'admin_error_noName', 'Sorry, but you must provide a name in order to continue.', 0, 6, 'No Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2296, 'admin_error_optionText', 'Sorry, but since you did not select a field type of "text" or "textarea", you must provide at least one option in order to continue.', 0, 6, 'Must Have Option Text', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2297, 'admin_nav_cusPro_addCat', 'Add Category', 0, 276, 'Add Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2298, 'admin_cusPro_man', 'Profile Field Manager', 0, 279, 'Profile Field Manager', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2299, 'admin_cusPro_man_fieldName', 'Field Name', 0, 279, 'Field Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2300, 'admin_cusPro_man_disOrder', 'Display Order', 0, 279, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2301, 'admin_cusPro_man_fieldType', 'Field Type', 0, 279, 'Field Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2302, 'admin_cusPro_man_groupName', 'Category Name', 0, 279, 'Category Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2303, 'admin_cusPro_ae_group', 'Category:', 0, 278, 'Category', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2304, 'admin_cusPro_ae_group_desc', 'Each profile field must be categorized. The profile field will be displayed inside a box labeled as the category selected here (along with other profile fields in the category).', 0, 278, 'Category Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2305, 'admin_cusPro_ae_disOrder', 'Display Order:', 0, 278, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2306, 'admin_cusPro_ae_disOrder_desc', 'Profile fields can be displayed in whichever order you chose.', 0, 278, 'Display Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2307, 'admin_groups_ae_groupOrder', 'Display Order:', 0, 125, 'Display Order', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2308, 'admin_groups_ae_groupOrder_desc', 'This is the order position in which this group will be listed.', 0, 125, 'Displar Order Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2309, 'admin_cusPro_f_textarea', 'Textarea', 0, 280, 'Textarea', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2310, 'admin_options_forumSettings_censor', 'Censored Words:', 0, 197, 'Censored Words', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2311, 'admin_options_forumSettings_censor_desc', 'You can enter words to censor here. All user input is passed through a censorship function that will replace each character in a censored word with the character specified below. Please separate each word with a space.', 0, 197, 'Censored Words Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2312, 'admin_options_forumSettings_censorChar', 'Censor Character:', 0, 197, 'Censor Character', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2313, 'admin_options_forumSettings_censorChar_desc', 'Each character in a censored word will be replaced with this character (or characters).', 0, 197, 'Censor Character Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2314, 'admin_style_i_postbit_report', 'Postbit Report:', 0, 227, 'Postbit Report', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2315, 'error_flood', 'Sorry, but the administrator has specified that you must wait before trying to send a message, or run a search again.', 0, 35, 'Flood Check', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2316, 'admin_nav_threadsPosts_title', 'Threads & Posts', 0, 288, 'Threads/Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2317, 'admin_nav_threadsPosts_massMove', 'Mass Move Threads', 0, 288, 'Mass Move Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2318, 'admin_nav_threadsPosts_massPruneThreads', 'Mass Prune Threads', 0, 288, 'Mass Prune Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2319, 'admin_fileActions_Threads-&-Posts', 'Threads & Posts', 0, 102, 'Threads/Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2320, 'admin_threadsPosts_massMove', 'Mass Move Threads', 0, 291, 'Mass Move', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2321, 'admin_threadsPosts_massMove_threadAfter', 'Last Reply After:', 0, 291, 'Last Reply After', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2322, 'admin_threadsPosts_massMove_threadAfter_desc', 'Selecting a date here will only move threads that have a last reply made <strong>after</strong> this date.', 0, 291, 'Last Reply After Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2323, 'admin_threadsPosts_massMove_threadBefore_desc', 'Selecting a date here will only move threads that have a last reply made <strong>before</strong> this date.', 0, 291, 'Last Reply Before Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2324, 'admin_threadsPosts_massMove_threadBefore', 'Last Reply Before:', 0, 291, 'Last Reply Before', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2325, 'admin_threadsPosts_massMove_user', 'Username:', 0, 291, 'User', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2326, 'admin_threadsPosts_massMove_user_desc', 'Entering a username here will constain only threads <strong>made</strong> by this user to be moved.', 0, 291, 'User Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2327, 'admin_threadsPosts_massMove_startForum', 'Start Forum:', 0, 291, 'Start Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2328, 'admin_threadsPosts_massMove_startForum_desc', 'Only threads in this forum will be moved. You can select "All Forums" if you do not want it to be forum specific.', 0, 291, 'Start Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2329, 'admin_threadsPosts_massMove_destination', 'Destination Forum:', 0, 291, 'Destination Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2330, 'admin_threadsPosts_massMove_destination_desc', 'This is the forum in which threads will be moved to.', 0, 291, 'Destination Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2331, 'admin_nav_threadsPosts_massPrunePosts', 'Mass Prune Posts', 0, 288, 'Mass Prune Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2332, 'admin_threadsPosts_massPruneT', 'Mass Prune Threads', 0, 292, 'Mass Prune Threads', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2333, 'admin_threadsPosts_massPruneP', 'Mass Prune Posts', 0, 293, 'Mass Prune Posts', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2334, 'admin_threadsPosts_massPrune_threadAfter', 'Last Reply After:', 0, 292, 'Last Reply After', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2335, 'admin_threadsPosts_massPrune_threadAfter_desc', 'Selecting a date here will only prune threads that have a last reply made <strong>after</strong> this date.', 0, 292, 'Last Reply After Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2336, 'admin_threadsPosts_massPrune_threadBefore_desc', 'Selecting a date here will only prune threads that have a last reply made <strong>before</strong> this date.', 0, 292, 'Last Reply Before Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2337, 'admin_threadsPosts_massPrune_threadBefore', 'Last Reply Before:', 0, 292, 'Last Reply Before', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2338, 'admin_threadsPosts_massPrune_user', 'Username:', 0, 292, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2339, 'admin_threadsPosts_massPrune_user_desc', 'Entering a username here will constain only threads <strong>made</strong> by this user to be pruned.', 0, 292, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2340, 'admin_threadsPosts_massPrune_startForum', 'Forum:', 0, 292, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2341, 'admin_threadsPosts_massPrune_startForum_desc', 'Only threads in this forum will be pruned. You can select "All Forums" if you do not want it to be forum specific.', 0, 292, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2342, 'email_passwordChange', 'Verify Password Change', 0, 274, 'Verify Password Change', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2343, 'admin_threadsPosts_massPrune_postAfter', 'Post Made After:', 0, 293, 'Post After', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2344, 'admin_threadsPosts_massPrune_postAfter_desc', 'Selecting a date here will only prune posts that were made <strong>after</strong> this date.', 0, 293, 'Post After Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2345, 'admin_threadsPosts_massPrune_postBefore', 'Post Made Before:', 0, 293, 'Post Before', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2346, 'admin_threadsPosts_massPrune_postBefore_desc', 'Selecting a date here will only prune posts that were made <strong>before</strong> this date.', 0, 293, 'Post Before Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2347, 'admin_threadsPosts_massPrune_postUser', 'Username:', 0, 293, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2348, 'admin_threadsPosts_massPrune_postUser_desc', 'Entering a username here will constain only posts <strong>made</strong> by this user to be pruned.', 0, 293, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2349, 'admin_threadsPosts_massPrune_postStartForum', 'Forum:', 0, 293, 'Forum', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2350, 'admin_threadsPosts_massPrune_postStartForum_desc', 'Only posts in this forum will be pruned. You can select "All Forums" if you do not want it to be forum specific.', 0, 293, 'Forum Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2351, 'admin_maint_threads', 'Thread Information', 0, 229, 'Thread Information', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2352, 'admin_maint_threads_desc', 'This will update all thread information, such as reply counts and last reply data.', 0, 229, 'Thread Information Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2353, 'user_per_convo_markRead', 'Mark Read', 0, 262, 'Mark Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2354, 'thanks_convoRead', 'You have successfully marked the selected conversations read.', 0, 194, 'Marked Read', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2355, 'admin_style_man_export', 'Export Style', 0, 145, 'Export Style', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2356, 'email_from', 'From: ', 0, 274, 'From', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2357, 'install_step1', 'Install - Step 1 - Configuration', 0, 294, 'Install - Step 1', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2358, 'install_step1_username', 'Database Username:', 0, 295, 'Database Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2359, 'install_step1_username_desc', 'This is the username you use to access your database. If you are not sure of this, please contact your host.', 0, 295, 'Database Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2360, 'install_step1_password', 'Database Password:', 0, 295, 'Database Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2361, 'install_step1_password_desc', 'This is the password you use to access your database. If you are not sure of this, please contact your host.', 0, 295, 'Database Password Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2362, 'install_step1_dbname', 'Database Name:', 0, 295, 'Database Name', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2363, 'install_step1_dbname_desc', 'This is the name of the database you have created for wtcBB 2.', 0, 295, 'Database Name Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2364, 'install_step1_host', 'Database Host:', 0, 295, 'Database Host', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2365, 'install_step1_host_desc', 'This is the host of your database. If you are not sure of this, leave it as "localhost". (This should only be changed if your database is on a remote server.)', 0, 295, 'Database Host Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2366, 'install_step1_tblprefix', 'Table Prefix:', 0, 295, 'Table Prefix', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2367, 'install_step1_tblprefix_desc', 'This is the prefix that will be used to create the tables in your database. This is useful if you want more than one instance of wtcBB in one database, or if you want wtcBB in the same database as another application. Otherwise, you can leave this blank.', 0, 295, 'Table Prefix Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2368, 'install_step1_cookprefix', 'Cookie Prefix:', 0, 295, 'Cookie Prefix', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2369, 'install_step1_cookprefix_desc', 'This is the prefix that will be appened to the beginning of all cookie names set by wtcBB. This is useful if you are running more than one instance of wtcBB on a domain. Otherwise you can leave this as "wtcBB_".', 0, 295, 'Cookie Prefix Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2370, 'install_step1_dbtype', 'Database Type:', 0, 295, 'Database Type', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2371, 'install_step1_dbtype_desc', 'This is the type of database you will be using. The best option is selected for you.', 0, 295, 'Database Type Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2372, 'install_error_nodatabasing', 'Sorry, but wtcBB could not detect a valid database extension.', 0, 298, 'No Databasing', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2373, 'install_error_fileperms', 'Sorry, but the following directories/files must be chmodded to <strong>0777</strong> before you can continue with the installation process.', 0, 298, 'File Permissions', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2374, 'install_step2', 'Install - Step 2 - Administrator Account', 0, 294, 'Install - Step 2', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2375, 'install_step2_username', 'Username:', 0, 296, 'Username', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2376, 'install_step2_username_desc', 'This is the username of your administrator account.', 0, 296, 'Username Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2377, 'install_step2_password', 'Password:', 0, 296, 'Password', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2378, 'install_step2_password_desc', 'This is the password to your administrator account that you will use to login to the admin panel and your account on the message board.', 0, 296, 'Password Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2379, 'install_step2_email', 'Email Address:', 0, 296, 'Email Address', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2380, 'install_step2_email_desc', 'This is your account email address. It will also be used to send forum email to members.', 0, 296, 'Email Address Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2381, 'install_step2_timezone_desc', 'Select the time zone that you are in. The current time in each time zone is listed next to it.', 0, 296, 'Timezone Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2382, 'install_step2_timezone', 'Timezone', 0, 296, 'Timezone', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2383, 'install_step2_dst', 'Enable DST:', 0, 296, 'DST', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2384, 'install_step2_dst_desc', 'If Daylight Savings Time is enabled, all times will be pushed ahead one hour.', 0, 296, 'DST Description', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2385, 'install_step3', 'Install - Step 3 - Board Setup', 0, 294, 'Install - Step 3', 0);
INSERT INTO `lang_words` (`wordsid`, `name`, `words`, `langid`, `catid`, `displayName`, `defaultid`) VALUES (2386, 'user_message_moreSmilies', 'More', 0, 209, 'More Smilies', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `logger_admin`
-- 

CREATE TABLE `logger_admin` (
  `log_adminid` int(10) unsigned NOT NULL auto_increment,
  `log_userid` mediumint(9) default NULL,
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
  `log_cronid` int(10) unsigned NOT NULL auto_increment,
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
  `log_ipid` int(10) unsigned NOT NULL auto_increment,
  `ip_address` varchar(255) default NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
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
  `log_modid` int(10) unsigned NOT NULL auto_increment,
  `log_userid` mediumint(9) default NULL,
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
  `modid` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `forumid` mediumint(8) unsigned NOT NULL default '0',
  `modSubs` tinyint(1) default NULL,
  `canEditPosts` tinyint(1) default NULL,
  `canEditThreads` tinyint(1) default NULL,
  `canEditPolls` tinyint(1) default NULL,
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
-- Table structure for table `personal_convo`
-- 

CREATE TABLE `personal_convo` (
  `convoid` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `convoTimeline` int(11) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` smallint(6) default NULL,
  `last_reply_messageid` mediumint(9) default NULL,
  `messages` smallint(6) default NULL,
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
  `convodataid` mediumint(8) unsigned NOT NULL auto_increment,
  `convoid` mediumint(8) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `folderid` mediumint(8) unsigned NOT NULL default '0',
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
  `folderid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `userid` smallint(5) unsigned NOT NULL default '0',
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
  `messageid` mediumint(8) unsigned NOT NULL auto_increment,
  `convoid` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(255) default NULL,
  `userid` smallint(5) unsigned NOT NULL default '0',
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
  `pollid` mediumint(8) unsigned NOT NULL auto_increment,
  `threadid` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(255) default NULL,
  `poll_timeline` int(11) default NULL,
  `options` smallint(6) default NULL,
  `multiple` tinyint(1) default NULL,
  `public` tinyint(1) default NULL,
  `votes` smallint(6) default NULL,
  `timeout` int(11) default NULL,
  `polloptions` mediumtext,
  `forumid` smallint(6) default NULL,
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
  `iconid` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `imgPath` mediumtext,
  `disOrder` smallint(6) default NULL,
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
  `postid` mediumint(8) unsigned NOT NULL auto_increment,
  `threadid` mediumint(8) unsigned NOT NULL default '0',
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `postby` mediumint(8) unsigned NOT NULL default '0',
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
-- Table structure for table `ranks`
-- 

CREATE TABLE `ranks` (
  `rankid` smallint(5) unsigned NOT NULL auto_increment,
  `title` mediumtext,
  `minPosts` mediumint(9) default NULL,
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
  `rankiid` smallint(5) unsigned NOT NULL auto_increment,
  `rankRepeat` smallint(6) default NULL,
  `minPosts` mediumint(9) default NULL,
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
  `readUserId` mediumint(8) unsigned NOT NULL default '0',
  `readForumId` smallint(5) unsigned NOT NULL default '0',
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
  `readUserId` mediumint(8) unsigned NOT NULL default '0',
  `readThreadId` smallint(5) unsigned NOT NULL default '0',
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
  `userid` mediumint(8) unsigned NOT NULL default '0',
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
  `smileyid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(6) default NULL,
  `title` varchar(255) default NULL,
  `replacement` varchar(255) default NULL,
  `imgPath` varchar(255) default NULL,
  `disOrder` smallint(6) default NULL,
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
  `styleid` mediumint(8) unsigned NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `disOrder` smallint(6) default NULL,
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
  `fragmentid` mediumint(8) unsigned NOT NULL auto_increment,
  `styleid` mediumint(8) unsigned default NULL,
  `groupid` smallint(6) default NULL,
  `fragmentName` varchar(255) default NULL,
  `fragmentVarName` varchar(255) default NULL,
  `fragmentType` varchar(255) default NULL,
  `fragment` mediumtext,
  `template_php` mediumtext,
  `defaultid` mediumint(9) NOT NULL default '0',
  `disOrder` tinyint(4) NOT NULL default '0',
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
  `subid` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `threadid` mediumint(8) unsigned default NULL,
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
  `threadid` mediumint(8) unsigned NOT NULL auto_increment,
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) default NULL,
  `madeby` mediumint(8) unsigned NOT NULL default '0',
  `threadUsername` varchar(255) default NULL,
  `views` mediumint(9) default NULL,
  `replies` smallint(6) default NULL,
  `last_reply_username` varchar(255) default NULL,
  `last_reply_userid` varchar(255) default NULL,
  `last_reply_date` int(11) default NULL,
  `last_reply_postid` mediumint(9) default NULL,
  `posticon` varchar(255) default NULL,
  `deleted` tinyint(1) default NULL,
  `deleted_by` varchar(255) default NULL,
  `deleted_reason` text,
  `deleted_timeline` int(11) default NULL,
  `moved` mediumint(9) default NULL,
  `sticky` tinyint(1) default NULL,
  `closed` tinyint(1) default NULL,
  `poll` tinyint(1) default NULL,
  `thread_timeline` int(11) default NULL,
  `descript` varchar(255) default NULL,
  `first_postid` mediumint(8) unsigned NOT NULL default '0',
  `deleted_replies` smallint(6) default NULL,
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
  `usergroupid` mediumint(8) unsigned NOT NULL auto_increment,
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
  `attachFilesize` mediumint(9) default NULL,
  `avatarFilesize` mediumint(9) default NULL,
  `avatarWidth` mediumint(9) default NULL,
  `avatarHeight` mediumint(9) default NULL,
  `personalMaxMessages` mediumint(9) default NULL,
  `personalSendUsers` smallint(6) default NULL,
  `personalRules` smallint(6) default NULL,
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
  `maxAttach` mediumint(9) default NULL,
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
  `autoid` mediumint(8) unsigned NOT NULL auto_increment,
  `affectedId` mediumtext,
  `moveTo` mediumint(9) default NULL,
  `daysReg` smallint(6) default NULL,
  `daysRegComp` tinyint(1) default NULL,
  `postsa` smallint(6) default NULL,
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
  `userid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `usergroupid` mediumint(8) unsigned NOT NULL default '0',
  `secgroupids` mediumtext,
  `joined` int(11) default NULL,
  `ip` varchar(255) default NULL,
  `posts` mediumint(8) unsigned NOT NULL default '0',
  `threads` mediumint(8) unsigned NOT NULL default '0',
  `lastvisit` int(11) default NULL,
  `lastactivity` int(11) default NULL,
  `lastpost` int(11) default NULL,
  `lastpostid` mediumint(8) unsigned NOT NULL default '0',
  `birthday` int(11) default NULL,
  `warn` smallint(5) unsigned NOT NULL default '0',
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
  `usertitle_opt` tinyint(3) default NULL,
  `htmlBegin` mediumtext,
  `htmlEnd` mediumtext,
  `email` varchar(255) default NULL,
  `parentEmail` varchar(255) default NULL,
  `coppa` tinyint(1) default NULL,
  `dst` tinyint(1) default NULL,
  `timezone` tinyint(12) default NULL,
  `referrer` varchar(255) default NULL,
  `referrals` smallint(6) default NULL,
  `sig` mediumtext,
  `defFont` varchar(255) default NULL,
  `defColor` varchar(255) default NULL,
  `defSize` varchar(255) default NULL,
  `passTime` int(11) default NULL,
  `salt` varchar(255) default NULL,
  `styleid` smallint(6) default NULL,
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
  `postsPerPage` smallint(6) default NULL,
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
  `banid` smallint(5) unsigned NOT NULL auto_increment,
  `userid` mediumint(9) default NULL,
  `usergroupid` smallint(6) default NULL,
  `banLength` int(11) default NULL,
  `banStart` int(11) default NULL,
  `previousGroupId` smallint(6) default NULL,
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
  `user_id` mediumint(8) unsigned NOT NULL default '0',
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
  `titleid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `minposts` mediumint(9) default NULL,
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
  `warnid` smallint(5) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `whoWarned` mediumint(8) unsigned NOT NULL default '0',
  `postid` mediumint(8) unsigned NOT NULL default '0',
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
  `typeid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `points` smallint(5) unsigned NOT NULL default '0',
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
  `settingid` mediumint(8) unsigned NOT NULL auto_increment,
  `settingType` varchar(255) default NULL,
  `value` mediumtext NOT NULL,
  `settingName` varchar(255) default NULL,
  `settingGroup` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `displayOrder` smallint(6) default NULL,
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
INSERT INTO `wtcbboptions` (`settingid`, `settingType`, `value`, `settingName`, `settingGroup`, `name`, `displayOrder`, `hidden`) VALUES (4, 'select', '1', 'admin_options_information_defLang', 'setup', 'defLang', 1, 0);
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
