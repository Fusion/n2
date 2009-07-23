<?php
$path = URL;
define('ABSPATH', str_replace('index.php', '', $_SERVER['PATH_TRANSLATED']));
define('WPINC', 'includes');
define('WP_CONTENT_DIR', '.');
define('WP_PLUGIN_DIR', 'modules');
define('WP_PLUGIN_URL', 'modules');

define('LOW_FILTERS',  'L');
define('HIGH_FILTERS', 'H');
define('ALL_FILTERS',  'A');

if(false !== strpos($path, 'wp-content'))
{
	$path = str_replace('/wp-content/plugins/', '/modules/', $path);
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $path);
	exit;
}

global $mod_filters, $mod_shortcodes;
$mod_filters    = array();
$mod_shortcodes = array();
$scripts_list   = array();
$mod_scripts    = array();

// ---------------------------
// Actions + Filters

// Register functions that will be invoked when a plugin is enabled
// Note: these functions are typically used to create new tables, etc.
// We should be very wary of such methods in n2 since we use a
// different structure than WP
function register_activation_hook($file, $function)
{
        $file = plugin_basename($file);
        add_action('activate_' . $file, $function);
}

// Register function that will be invoked when a plugin is disabled
function register_deactivation_hook($file, $function)
{
        $file = plugin_basename($file);
        add_action('deactivate_' . $file, $function);
}

function SOME_FM_WHEN_ACTIVATING_A_PLUGIN($file)
{
        $file = plugin_basename($file);
		apply_filters('activate_' . $file);
}

function apply_filters($action, $data = null, $priority = ALL_FILTERS)
{
	global $mod_filters;

	// $data = func_get_args();
	// array_shift($data);

	// $simple = (func_num_args() < 3);
	
	if(!empty($mod_filters[$action]))
	{
		foreach($mod_filters[$action] as $filter)
		{
			// Check priority
			if($priority == LOW_FILTERS)
			{
				if($filter[0] >= 6)
					continue;
			}
			elseif($priority == HIGH_FILTERS)
			{
				if($filter[0] < 6)
					continue;
			}
			/* It seems that in the olden times I thought I would do some currying
			if($callback)
			{
					$data = $callback($filter($data));
			}
			else
			{
				$data = $filter($data);
			}
			*/
			/* Old way: I could revive if necessary but it was creating issues with classes
			if($simple) {
				$data = $filter($data);
			}
			else {
				$args = func_get_args();
				array_shift($args);
				$data = call_user_func_array($filter, $args);
			}
			*/
			$data = call_user_func_array($filter[1], $data);
		}
	}
	
	return $data;	
}

function do_action($name, $callback = null)
{
	apply_filters($name);
}

/** @todo Handle priority and accepted_args */
// When a filter is invoked, all registered functions will be called back
function add_filter($action, $callback, $priority = 10, $accepted_args = 1)
{
	global $mod_filters;

	if(!isset($mod_filters[$action]))
		$mod_filters[$action] = array();
	$mod_filters[$action][_action_uid($priority, $callback)] = array($priority, $callback);
}

// When an action is invoked, all registered functions will be called back
function add_action($action, $callback, $priority = 10, $accepted_args = 1)
{
	return add_filter($action, $callback, $priority, $accepted_args);
}

function remove_filter($action, $callback, $priority = 10, $accepted_args = 1)
{
	global $mod_filters;

	$uid = _action_uid($priority, $callback);
	
	if(isset($mod_filters[$action]) && isset($mod_filters[$action][$uid]))
	{
		unset($mod_filters[$action][$uid]);
	}
}

function remove_action($action, $callback, $priority = 10, $accepted_args = 1)
{
	remove_filter($action, $callback, $priority, $accepted_args);
}

function _action_uid($priority, $callback)
{
	if(is_string($callback))
	{
		return $priority . $callback;
	}
	return $priority . serialize($callback);
}

/** @todo */
function do_action_ref_array($action, $args = array())
{
}

/** @todo Load translations */
function load_plugin_textdomain($domain, $abs_rel_path = false, $plugin_rel_path = false)
{
}

function add_shortcode($code, $callback)
{
	global $mod_shortcodes;
	
	$mod_shortcodes[$code] = $callback;
}

function do_shortcode($data)
{
	global $mod_shortcodes;
	
	if(empty($mod_shortcodes))
	{
		return $data;
	}
	
	$shortcodes = join('|', array_map('preg_quote', array_keys($mod_shortcodes)));
	$data = preg_replace_callback('/\[('.$shortcodes.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\1\])?/', '_do_shortcode', $data);
	
	return $data;
}

function shortcode_atts($pairs, $arg)
{
	$ret = array();
	
	foreach($pairs as $name => $defvalue)
	{
		if(isset($arg[$name]))
		{
			$ret[$name] = $arg[$name];
			continue;
		}
		$ret[$name] = $defvalue;
	}
	
	return $ret;
}

function _do_shortcode($matches)
{
	global $mod_shortcodes;
	
	$code = $matches[1]; 
	$arg1 = shortcode_parse_atts($matches[2]);
	$arg2 = isset($matches[4]) ? $matches[4] : null;
	return call_user_func($mod_shortcodes[$code], $arg1, $arg2, $code);
}

function wp_declare_script( $handle, $src = false, $deps = array(), $ver = false )
{
	global $scripts_list;
	
	$scripts_list[$handle] = array('src' => str_replace('/wp-content/plugins/', '/modules/', $src), 'deps' => $deps, 'ver' => $ver);
}

function wp_enqueue_script( $handle, $src = false, $deps = array(), $ver = false )
{
	wp_declare_script($handle, $src, $deps, $ver);
	_wp_enqueue_script($handle);
}

function _wp_enqueue_script($handle)
{
	global $scripts_list, $mod_scripts;

	if(!$scripts_list[$handle])
	{
		die("Error: Script '$handle' is undeclared");
	}
	
	if(!empty($scripts_list[$handle]['deps']))
	{
		$dependencies = $scripts_list[$handle]['deps'];
		if(!is_array($dependencies))
		{
			$dependencies = array($dependencies);
		}
		foreach($dependencies as $dependency)
		{
			_wp_enqueue_script($dependency);
		}
	}
	
	if(!empty($scripts_list[$handle]['src']))
	{
		$mod_scripts[] = $scripts_list[$handle]['src'];
	}
}

function apply_scripts()
{
	global $mod_scripts;

	$out = '';
	foreach($mod_scripts as $script)
	{
		$out .= '<script type="text/javascript" src="' . $script . "\"></script>\n";

	}
	
	return $out;
}

// ---------------------------
// Helpers

function __($text, $domain)
{
	return $text;
}

function bloginfo($name = '')
{
	return get_bloginfo($name, 'display');
}

function get_bloginfo($name = '', $filter = 'raw')
{
	switch($name)
	{
		case 'wpurl':
			return HOME;
			#return Config::$path;
	}
	return '';
}

function get_option($name, $default = false)
{
	global $query;
	$getOption = new Query($query['options']['get'], array(1 => $name));
	if(!$getOption->numRows())
	{
		return $default;
	}
	$optioninfo = $getOption->fetchArray();
	return maybe_unserialize($optioninfo['value']);
}

function add_option($name, $value = '', $deprecated = '', $autoload = false)
{
	global $query;
	new Query($query['options']['insert'], array(1 => $name, 2 => maybe_serialize($value)));
}

function update_option($name, $value)
{
	global $query;
	$optioninfo = get_option($name, false);
	if(!$optioninfo) {
		add_option($name, $value);
	}
	else {
		new Query($query['options']['update'], array(1 => maybe_serialize($value), 2 => $name));
	}
}

function delete_option($name)
{
	global $query;
	new Query($query['options']['delete'], array(1 => $name));
}

function get_settings($name)
{
	return '';
}

function get_the_title() { return 'n2'; }
function get_permalink() { return URL; }

// Is single post displayed? For now, let's assume it is...I know it's a lie.
function is_single()
{
	return true;
}

function is_home()
{
	return true;
}

function is_category()
{
	return true;
}

function is_search()
{
	return false;
}

function is_tag()
{
	return false;
}

function is_date()
{
	return false;
}

function is_author()
{
	return true;
}

/** @todo If true, then, for instance, some widgets will be displayed */
function is_page()
{
	return false;
}

/** @todo Did you know? is_page is true when is_feed */
function is_feed()
{
	return false;
}

function is_admin()
{
	if(ADMIN)
		return true;
	return false;
}

function plugin_basename($file)
{
	$prefix = 'modules/';
	$p = strpos($file, $prefix);
	if(false === $p)
		return $file;
	$file = substr($file, $p + strlen($prefix));
	return $file;
}

function plugins_url()
{
	return HOME . 'modules';
}

/**
 * Lifted, as-is, from Wordpress source tree
 */
function maybe_serialize( $data )
{
	if ( is_array( $data ) || is_object( $data ) )
		return serialize( $data );
	
	if ( is_serialized( $data ) )
		return serialize( $data );
	
	return $data;
}
function maybe_unserialize( $original )
{
        if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
                if ( false !== $gm = @unserialize( $original ) )
                        return $gm;
        return $original;
}
function is_serialized( $data )
{
        // if it isn't a string, it isn't serialized
        if ( !is_string( $data ) )
                return false;
        $data = trim( $data );
        if ( 'N;' == $data )
                return true;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
                return false;
        switch ( $badions[1] )
        {
                case 'a' :
                case 'O' :
                case 's' :
                        if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                                return true;
                        break;
                case 'b' :
                case 'i' :
                case 'd' :
                        if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                                return true;
                        break;
        }
        return false;
}

function sanitize_title($title, $default = '')
{
	$title = apply_filters('sanitize_title', strip_tags($title));
	
	if(empty($title))
	{
		$title = $default;
	}
	
	return $title;
}

// Three functions for keeping urls clean...
// Introduced/depecrated with various versions of WP.
function esc_url($url, $protocols = null)
{
        return clean_url($url, $protocols, 'db');
}

function sanitize_url($url, $protocols = null)
{
        return clean_url($url, $protocols, 'db');
}

function clean_url( $url, $protocols = null, $context = 'display' )
{
	return $url;
}

/**
 * Lifted, as-is, from Wordpress source tree
 */
function js_escape($text)
{
        $safe_text = wp_specialchars($text, 'double');
        $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
        $safe_text = preg_replace("/\r?\n/", "\\n", addslashes($safe_text));
        return apply_filters('js_escape', $safe_text, $text);
}
function wp_specialchars( $text, $quotes = 0 )
{
	// Like htmlspecialchars except don't double-encode HTML entities
	$text = str_replace('&&', '&#038;&', $text);
	$text = str_replace('&&', '&#038;&', $text);
	$text = preg_replace('/&(?:$|([^#])(?![a-z1-4]{1,8};))/', '&#038;$1', $text);
	$text = str_replace('<', '&lt;', $text);
	$text = str_replace('>', '&gt;', $text);
	if ( 'double' === $quotes ) {
			$text = str_replace('"', '&quot;', $text);
	} elseif ( 'single' === $quotes ) {
			$text = str_replace("'", '&#039;', $text);
	} elseif ( $quotes ) {
			$text = str_replace('"', '&quot;', $text);
			$text = str_replace("'", '&#039;', $text);
	}
	return $text;
}

function trailingslashit($string)
{
	return untrailingslashit($string) . '/';
}

function untrailingslashit($string)
{
	return rtrim($string, '/');
}

function shortcode_parse_atts($text) {
        $atts = array();
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
        if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
                foreach ($match as $m) {
                        if (!empty($m[1]))
                                $atts[strtolower($m[1])] = stripcslashes($m[2]);
                        elseif (!empty($m[3]))
                                $atts[strtolower($m[3])] = stripcslashes($m[4]);
                        elseif (!empty($m[5]))
                                $atts[strtolower($m[5])] = stripcslashes($m[6]);
                        elseif (isset($m[7]) and strlen($m[7]))
                                $atts[] = stripcslashes($m[7]);
                        elseif (isset($m[8]))
                                $atts[] = stripcslashes($m[8]);
                }
        } else {
                $atts = ltrim($text);
        }
        return $atts;
}
?>
