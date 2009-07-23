<?php
/*
Plugin Name: plainEdit
Plugin URI: http://n2.nextbbs.com
Description: This is the default plain-text editor.
Author: Chris F Ravenscroft
Version: 1.0
Author URI: http://nexus.zteo.com
Long Name: Plain
N2Type: E
*/

function getModule_plainEdit()
{
	return new plainEdit();
}

class plainEdit implements EditorModule
{
	function __construct()
	{
	}

	function encode($text)
	{
		return $text;
	}

	function decode($text)
	{
		return $text;
	}

	function render($content, $areaId, $class = null)
	{
		$out = "<textarea name=\"{$areaId}\" id=\"{$areaId}\"";
		if(!empty($class))
			$out .= " class=\"{$class}\"";
		$out .= '>' . $content . '</textarea>';
		return $out;
	}
}
?>
