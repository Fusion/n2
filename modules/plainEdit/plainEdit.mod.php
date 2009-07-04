<?php
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
