<?php
$nbbs_vars = array();
$used_vars = array();
$runner = 0;

function handleShutdown()
{
	if($err = error_get_last())
		displayErrorScreen($err['type'], $err['message'], $err['file'], $err['line']);
}

function displayExceptionScreen($ex)
{
	displayErrorScreen(
		E_ERROR,
		$ex->getMessage(),
		$ex->getFile(),
		$ex->getLine(),
		array('Exception'=>true));
}

function displayErrorScreen($type, $message, $file, $line, $context = false)
{
	global $nbbs_vars, $used_vars;

	if(0 == (error_reporting() & $type))
		return;

	@ob_end_clean(); // get rid of any half-parsed page

	// Fix for exceptions
	if(!empty($context) && !empty($context['Exception']))
	{
		$type = -1;
	}

	$backTrace = debug_backtrace();

	$ERROR_TYPES = array(
		-1 => 'Exception',
		E_ERROR => 'Error',
		E_WARNING => 'Warning',
		E_PARSE => 'Parse',
		E_NOTICE => 'Notice',
		E_CORE_ERROR => 'Core Error',
		E_CORE_WARNING => 'Core Warning',
		E_COMPILE_ERROR => 'Compile Error',
		E_COMPILE_WARNING => 'Compile Warning',
		E_USER_ERROR => 'User Error',
		E_USER_WARNING => 'User Warning',
		E_USER_NOTICE => 'User Notice',
		E_STRICT => 'Strict Notice',
		E_RECOVERABLE_ERROR => 'Recoverable Error');

	$splitSourceCode = preg_split('#<br />#i', highlight_string(file_get_contents($file, true), true));
	$formattedSourceCode = '';
	$lb = $line - 10; if ($lb < 0) $lb = 0; // < 10 lines before?
	for($i = $lb; $i < ($line + 10); $i ++)
	{
		if(!isset($splitSourceCode[$i])) // < 10 lines after?
			break;
		$curLine = rtrim($splitSourceCode[$i]);
		$formattedSourceCode .=
			($line == ($i + 1)
				? '<div style="background-color:red;">' : '<div>') .
				'<strong>' . sprintf('%03s', ($i+1)) . '</strong>' . $curLine . '</div>';
	}

	$stackTrace = '';
	for($i=1; $i<count($backTrace); $i++) // 1 == Ignore this function
	{
		switch($backTrace[$i]['type'])
		{
			case '->': // Instance
				if($backTrace[$i]['class']==$backTrace[$i]['function'])
					$s1 = $backTrace[$i]['class'].'()';
				else
					$s1 = $backTrace[$i]['class'].'->'.$backTrace[$i]['function'];
				break;
			case '::': // Static
				$s1 = $backTrace[$i]['class'].'::'.$backTrace[$i]['function'];
				break;
			default:   // Function
				$s1 = $backTrace[$i]['function'];
		}
		$s3 = ''; $comma = '';
		for($j=0; $j<count($backTrace[$i]['args']); $j++)
		{
			if(0==strlen($backTrace[$i]['args'][$j]))
				$s3 .= '""';
			else if(is_numeric($backTrace[$i]['args'][$j]))
				$s3 .= $comma.$backTrace[$i]['args'][$j];
			else
				$s3 .= $comma.'"'.$backTrace[$i]['args'][$j].'"';
			$comma = ', ';
		}
		if(empty($backTrace[$i]['file']))
			$s2 = '(?)';
		else
			$s2 = '('.$backTrace[$i]['file'].':'.$backTrace[$i]['line'].')';
		$stackTrace .= 'at '.$s1.'('.$s3.') '.$s2.'<br />';
	}

	_canonizeVars('', $GLOBALS, true);
	foreach($nbbs_vars as $key=>$value)
	{
		$formattedSourceCode = preg_replace_callback(
			'/\$'.str_replace(array('/', '-'), array('\/', '\-'), $key).'/',
			create_function(
				'$matches',
				'global $used_vars, $runner; $runner++; print "<hr><pre>"; print_r($matches); print "</pre>"; $used_vars[$matches[0]] = $runner; return "<a href=\'#v{$runner}\'>{$matches[0]}</a>";'),
			$formattedSourceCode);
	}

	$varValues = '';
	foreach($used_vars as $key=>$value)
	{
		$varValues .= '<a name="v'.$value.'">'.$key.'</a> == '.$nbbs_vars[substr($key,1)].'<br />';
	}

	$r = <<<EOB
[n2]<br /><br />
<strong>{$ERROR_TYPES[$type]}: {$message} in {$file} ({$line})</strong><br />
{$stackTrace}<br />
<strong>Source Code:</strong><br />
{$formattedSourceCode}<br />
<strong>Global Variables:</strong><br />
{$varValues}
EOB;

	die($r);
}

function _canonizeVars($whos, $daddy, $isArray)
{
	global $nbbs_vars;

	foreach($daddy as $key=>$value)
	{
		// Note regarding the following exception list:
		// Only GLOBALS and nbbs_var must absolutely be removed.
		// Other variables are memory hogs that you think may kill php
		if($key == '_' || $key=='GLOBALS' || $key=='nbbs_vars')
			continue;
		// Wouldn't we look stupid, trying to dump an iterator?
		if($value instanceof Traversable)
			continue;
		if(is_array($value) || is_object($value))
		{
			if(empty($whos))
				$idx = $key;
			else if($isArray)
				$idx = $whos.'['.$key.']';
			else
				$idx = $whos.'-&gt;'.$key;
			_canonizeVars($idx, $value, is_array($value));
		}
		else
		{
			if(empty($whos))
				$idx = $key;
			else if($isArray)
				$idx = $whos.'['.$key.']';
			else
				$idx = $whos.'-&gt;'.$key;
			$nbbs_vars[$idx] = $value;
		}
	}
}
?>
