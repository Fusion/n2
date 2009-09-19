<?php
include "includes/functions.php";

if(!mysql_connect('localhost', 'testn2', 'testn2')) {
	die("NOT CONNECTED\n");
}
if(!mysql_select_db('testn2')) {
	die("NOT SELECTED\n");
}

// Load db data
$db = array();
$qry = "SELECT * FROM n2_groups where groupType='lang_words'";
if(!($result = mysql_query($qry))) {
	die("FIRST QUERY FAILED\n");
}
while ($row = mysql_fetch_assoc($result)) {
	$cat[$row['groupid']] = $row;
}
foreach($cat as $id => &$info) {
	$uuid = uuid();
	$qry = "UPDATE n2_groups SET groupuuid='".$uuid."' WHERE groupid=".$id;
	if(!mysql_query($qry)) {
		die("PANIC WHILE INSERTING GROUPUUIDS:".mysql_error());
	}
	$info['groupuuid'] = $uuid;
}
foreach($cat as $id => $info) {
	$qry = "UPDATE n2_groups SET parentuuid='".$cat[$info['parentid']]['groupuuid']."' WHERE groupid=".$id;
	if(!mysql_query($qry)) {
		die("PANIC WHILE INSERTING PARENTUUIDS:".mysql_error());
	}
}
echo "All done.\n";
