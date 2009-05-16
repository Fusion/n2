<?php
 /*

 * wtcBB Community Software (Open Source Freeware Version)

 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software
Solutions.

 * http://www.wtcbb.com/

 *

 * Licensed under the terms of the GNU Lesser General Public License:

 * http://www.wtcbb.com/wtcbb-license-general-public-license

 *

 * For support visit:

 * http://forums.wtcbb.com/

 *

 * Powered by wtcBB - http://www.wtcbb.com/

 * Protected by ChargebackFile - http://www.chargebackfile.com/

 *

*/
 

$bbcode['1'] = new BBCode('', Array('bbcodeid' => '1', 'name' => 'Bold', 'tag' => 'b', 'replacement' => '<strong>{param}</strong>', 'example' => '[b]Bolded Text.[/b]', 'description' => 'This will bold text.', 'display' => '1'));
$bbcode['2'] = new BBCode('', Array('bbcodeid' => '2', 'name' => 'Italic', 'tag' => 'i', 'replacement' => '<em>{param}</em>', 'example' => '[i]Italic text.[/i]', 'description' => 'Makes text italic.', 'display' => '1'));
$bbcode['3'] = new BBCode('', Array('bbcodeid' => '3', 'name' => 'Underline', 'tag' => 'u', 'replacement' => '<span class="underline">{param}</span>', 'example' => '[u]Underlined text.[/u]', 'description' => 'Underlines text.', 'display' => '1'));
$bbcode['9'] = new BBCode('', Array('bbcodeid' => '9', 'name' => 'Align Left', 'tag' => 'left', 'replacement' => '<div class="left">{param}</div>', 'example' => '[left]Left aligned text![/left]', 'description' => 'This will align text to the left.', 'display' => '1'));
$bbcode['11'] = new BBCode('', Array('bbcodeid' => '11', 'name' => 'Align to Center', 'tag' => 'center', 'replacement' => '<div class="center">{param}</div>', 'example' => '[center]Center aligned text![/center]', 'description' => 'Aligns text to the center.', 'display' => '1'));
$bbcode['10'] = new BBCode('', Array('bbcodeid' => '10', 'name' => 'Align to Right', 'tag' => 'right', 'replacement' => '<div class="right">{param}</div>', 'example' => '[right]Right aligned text![/right]', 'description' => 'Aligns text to the right.', 'display' => '1'));
$bbcode['19'] = new BBCode('', Array('bbcodeid' => '19', 'name' => 'Bulleted List', 'tag' => 'ul', 'replacement' => '<ul class="noMar">{param}</ul>', 'example' => '[ul][!]List Item 1[/!][!]List Item 2[/!][!]List Item 3[/!][/ul]', 'description' => 'This will allow you to make a bulleted (unordered) list.', 'display' => '1'));
$bbcode['18'] = new BBCode('', Array('bbcodeid' => '18', 'name' => 'Numbered List', 'tag' => 'ol', 'replacement' => '<ol class="noMar">{param}</ol>', 'example' => '[ol][!]List Item 1[/!][!]List Item 2[/!][!]List Item 3[/!][/ol]', 'description' => 'This will allow you to make a numbered (ordered) list.', 'display' => '1'));
$bbcode['22'] = new BBCode('', Array('bbcodeid' => '22', 'name' => 'Advanced Email', 'tag' => 'email', 'replacement' => '<a href="mailto:{option}">{param}</a>', 'example' => '[email=contact@wtcbb.com]Contact Me![/email]', 'description' => 'Advanced email linking.', 'display' => '0'));
$bbcode['6'] = new BBCode('', Array('bbcodeid' => '6', 'name' => 'Advanced Link', 'tag' => 'url', 'replacement' => '<a href="{option}">{param}</a>', 'example' => '[url=http://wtcbb.com]wtcbb.com[/url]', 'description' => 'Allows the ability to make a named link.', 'display' => '1'));
$bbcode['15'] = new BBCode('', Array('bbcodeid' => '15', 'name' => 'Advanced Quote', 'tag' => 'quote', 'replacement' => '<div class="quote marCenter">
  <p class="small">Quote By: <strong>{option}</strong></p>
  <div class="quoted alt1">
    {param}
  </div>
</div>', 'example' => '[quote=Socrates]The unexamined life isn\'t worth living.[/quote]', 'description' => 'Now you can identify who said the quote.', 'display' => '0'));
$bbcode['16'] = new BBCode('', Array('bbcodeid' => '16', 'name' => 'Code', 'tag' => 'code', 'replacement' => '<div class="quote marCenter">
  <p class="small">Code:</p>
  <div class="quoted alt1" style="font-family: \'courier new\';">
    {param}
  </div>
</div>', 'example' => '[code]This is some <html> code![/code]', 'description' => 'A nice code formatting tag.', 'display' => '1'));
$bbcode['21'] = new BBCode('', Array('bbcodeid' => '21', 'name' => 'Email', 'tag' => 'email', 'replacement' => '<a href="mailto:{param}">{param}</a>', 'example' => '[email]contact@wtcbb.com[/email]', 'description' => 'Provides an easy way to link to an email address.', 'display' => '1'));
$bbcode['4'] = new BBCode('', Array('bbcodeid' => '4', 'name' => 'Font Color', 'tag' => 'color', 'replacement' => '<span style="color: {option};">{param}</span>', 'example' => '[color=blue]This is blue text.[/color]', 'description' => 'This will color text to the color specified.', 'display' => '0'));
$bbcode['12'] = new BBCode('', Array('bbcodeid' => '12', 'name' => 'Font Family', 'tag' => 'font', 'replacement' => '<span style="font-family: \'{option}\';">{param}</span>', 'example' => '[font=comic sans ms]Goofy font![/font]', 'description' => 'This changes the font family of the specified text.', 'display' => '0'));
$bbcode['13'] = new BBCode('', Array('bbcodeid' => '13', 'name' => 'Font Size', 'tag' => 'size', 'replacement' => '<span style="font-size: {option}pt;">{param}</span>', 'example' => '[size=22]Large Font Size![/size]', 'description' => 'This changes the font size of the specified text.', 'display' => '0'));
$bbcode['7'] = new BBCode('', Array('bbcodeid' => '7', 'name' => 'Image', 'tag' => 'img', 'replacement' => '<img src="{param}" alt="{param}" />', 'example' => '[img]http://www.webtrickscentral.com/images/supportWTC.gif[/img]', 'description' => 'This will allow the display of images.', 'display' => '1'));
$bbcode['5'] = new BBCode('', Array('bbcodeid' => '5', 'name' => 'Link', 'tag' => 'url', 'replacement' => '<a href="{param}">{param}</a>', 'example' => '[url]http://wtcbb.com[/url]', 'description' => 'This will provide a way to link to another web page.', 'display' => '0'));
$bbcode['20'] = new BBCode('', Array('bbcodeid' => '20', 'name' => 'List Item', 'tag' => '!', 'replacement' => '<li class="smallMarBot">{param}</li>', 'example' => '[ul][!]List Item[/!][/ul]', 'description' => 'This is a list item which works in conjunction with the "ul" and "ol" BB Codes.', 'display' => '0'));
$bbcode['24'] = new BBCode('', Array('bbcodeid' => '24', 'name' => 'Me', 'tag' => 'me', 'replacement' => '<span style="color: #730073; font-weight: bold;">* {poster} {param}</span>', 'example' => '[me]loves wtcBB![/me]', 'description' => 'A cheap imitation of IRC\'s "/me"', 'display' => '0'));
$bbcode['17'] = new BBCode('', Array('bbcodeid' => '17', 'name' => 'PHP', 'tag' => 'php', 'replacement' => '<div class="quote marCenter">
  <p class="small">PHP:</p>
  <div class="quoted alt1" style="font-family: \'courier new\'; font-size: 120%;">
    {param}
  </div>
</div>', 'example' => '[php]Pretty-lookin PHP![/php]', 'description' => 'Syntax highlighting for PHP code.', 'display' => '1'));
$bbcode['14'] = new BBCode('', Array('bbcodeid' => '14', 'name' => 'Quote', 'tag' => 'quote', 'replacement' => '<div class="quote marCenter">
  <p class="small">Quote:</p>
  <div class="quoted alt1">
    {param}
  </div>
</div>', 'example' => '[quote]The unexamined life isn\'t worth living.[/quote]', 'description' => 'You can quote some text.', 'display' => '1'));
$bbcode['23'] = new BBCode('', Array('bbcodeid' => '23', 'name' => 'Strike-Through', 'tag' => 'strike', 'replacement' => '<span style="text-decoration: line-through;">{param}</span>', 'example' => '[strike]Striked text.[/strike]', 'description' => 'This will put a line through text.', 'display' => '0'));

?>