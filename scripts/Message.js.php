<?php

// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## ******************** MESSAGE JS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


// change directory!
chdir('..');

// set content type
header('Content-type: text/plain');

// include files...
require_once('./includes/init.php');

// get my BB Code... and write it as JS...
if(!($bbcode = Cache::load('bbcode'))) {
	$bbcode = BBCode::init();
}

$before = '';

print('var bbcode = Array(');

foreach($bbcode as $id => $BB) {
	$myId = $BB->getBBCodeId();
	
	if(strtolower($BB->getTag()) == 'color' OR strtolower($BB->getTag()) == 'size' OR strtolower($BB->getTag()) == 'font') {
		$myId = strtolower($BB->getTag());
	}
	
	print($before . "\n\t" . 'Array(\'' . $myId . '\', \'' . str_replace("'", "\'", $BB->getTag()) . '\', ' . ($BB->useOption() ? 'true' : 'false') . ')');
	$before = ',';
}

print("\n" . ');');

?>