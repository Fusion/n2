<?php

if(!mysql_connect('localhost', 'testn2', 'testn2')) {
	die("NOT CONNECTED\n");
}
if(!mysql_select_db('testn2')) {
	die("NOT SELECTED\n");
}

// If a string is not found we will try matching it against this table
$cats = array(
		'faq' => 104,
		'_cp_' => 247,
		'eputation' => 247,
		'error_reg' => 254,
		'admin_action' => 5,
		'admin_import_imEx' => 142,
		'admin_style_' => 142,
		'admin_info_advanced' => 142,
		'admin_nav_style' => 142,
);

// Load db data
$db = array();
$qry = "SELECT * FROM n2_lang_words where langid=0";
if(!($result = mysql_query($qry))) {
	die("FIRST QUERY FAILED\n");
}
while ($row = mysql_fetch_assoc($result)) {
	$db[] = array($row['wordsid'], $row['name'], $row['words'], $row['langid'], $row['catid'], $row['displayName'], $row['defaultid']);
}

// Load language file to compare...
require "language/english.php";

foreach($lang as $key => $value) {
	$found = false;
	foreach($db as $tupple) {
		if($tupple[1] == $key) {
			if($found) echo "*** DUPLICATE: $key = $value / $firstValue\n";
			$found = true;
			$cleanValue = str_replace(array("\\\"","wtcBB","\n","\r",'\n','\r'), array('"','n2','','','',''), $value);
			$firstValue = $value;
			$tuppleValue = str_replace(array("\\\"","wtcBB","\n","\r",'\n','\r'), array('"','n2','','','',''), $tupple[2]);
			if($cleanValue != $tuppleValue) {
				echo "*** CONFLICT $key:\n$cleanValue\n!=\n$tuppleValue\n";
				$qry = "UPDATE n2_lang_words SET words='".mysql_real_escape_string($value)."' WHERE wordsid=".$tupple[0];
				if(!mysql_query($qry)) {
					die("QUERY FAILED\n");
				}
			}
		}
	}
	if(!$found) {
		echo "*** NOT FOUND: $key ($value)\n";
		foreach($cats as $ckey => $cvalue) {
			if(false !== strpos($key, $ckey)) {
				$qry = "INSERT INTO n2_lang_words(name,words,langid,catid,displayName,defaultid) VALUES('".mysql_real_escape_string($key)."', '".mysql_real_escape_string($value)."', 0, $cvalue, '".mysql_real_escape_string($key)."', 0)";
				if(!mysql_query($qry)) {
					die("QUERY FAILED\n");
				}
				echo "+++ But inserted in category #{$cvalue} ($qry)\n";
				break;
			}
		}
	}
}

foreach($db as $tupple) {
	if(substr($tupple[1], 0, 6) == 'admin_') {
		continue;
	}
	if(!isset($lang[$tupple[1]])) {
		echo "*** EXTRANEOUS: {$tupple[1]}\n";
	}
}

unset($lang);
require "language/english_admin.php";

foreach($lang as $key => $value) {
	$found = false;
	foreach($db as $tupple) {
		if($tupple[1] == $key) {
			if($found) echo "*** DUPLICATE: $key = $value / $firstValue\n";
			$found = true;
			$cleanValue = str_replace(array("\\\"","wtcBB","\n","\r",'\n','\r'), array('"','n2','','','',''), $value);
			$firstValue = $value;
			$tuppleValue = str_replace(array("\\\"","wtcBB","\n","\r",'\n','\r'), array('"','n2','','','',''), $tupple[2]);
			if($cleanValue != $tuppleValue) {
				echo "*** CONFLICT $key:\n$cleanValue\n!=\n$tuppleValue\n";
				$qry = "UPDATE n2_lang_words SET words='".mysql_real_escape_string($value)."' WHERE wordsid=".$tupple[0];
				echo "QRY=$qry\n";
				if(!mysql_query($qry)) {
					die("QUERY FAILED\n");
				}
			}
		}
	}
	if(!$found) {
		echo "*** NOT FOUND: $key ($value)\n";
		foreach($cats as $ckey => $cvalue) {
			if(false !== strpos($key, $ckey)) {
				$qry = "INSERT INTO n2_lang_words(name,words,langid,catid,displayName,defaultid) VALUES('".mysql_real_escape_string($key)."', '".mysql_real_escape_string($value)."', 0, $cvalue, '".mysql_real_escape_string($key)."', 0)";
				if(!mysql_query($qry)) {
					die("QUERY FAILED\n");
				}
				echo "+++ But inserted in category #{$cvalue} ($qry)\n";
				break;
			}
		}
	}
}

foreach($db as $tupple) {
	if(substr($tupple[1], 0, 6) != 'admin_') {
		continue;
	}
	if(!isset($lang[$tupple[1]])) {
		echo "*** EXTRANEOUS: {$tupple[1]}\n";
	}
}
?>
