<?php
/*
Plugin Name: WP-JS
Plugin URI: http://n2.nextbbs.com
Description: This plugin provides the Javascript files normally available on-demand to WordPress, such as Prototype and Scriptaculous.
Version: 1.0
Author: Chris F. Ravenscroft
Author URI: http://nexus.zteo.com
N2Type: L
*/

/* Where our theme reside: */
$my_path = dirname(__FILE__);

if (!is_admin()) {
        wp_declare_script('sack', (get_bloginfo('wpurl').'/modules/wp_js/tw-sack.js'), false, '1.6.1');
        wp_declare_script('quicktags', (get_bloginfo('wpurl').'/modules/wp_js/quicktags.js'), false, '20081103');
        wp_declare_script('colorpicker', (get_bloginfo('wpurl').'/modules/wp_js/colorpicker.js'), array('prototype'), '3517');
        wp_declare_script('editor', (get_bloginfo('wpurl').'/modules/wp_js/editor.js'), false, '1.0' );
        wp_declare_script('prototype', (get_bloginfo('wpurl').'/modules/wp_js/prototype.js'), false, '1.6');
        wp_declare_script('wp-ajax-response', (get_bloginfo('wpurl').'/modules/wp_js/wp-ajax-response.js'), array('jquery'), '20080316');
        wp_declare_script('autosave', (get_bloginfo('wpurl').'/modules/wp_js/autosave.js'), array('schedule', 'wp-ajax-response'), '20081102');
        wp_declare_script('wp-lists', (get_bloginfo('wpurl').'/modules/wp_js/wp-lists.js'), array('wp-ajax-response'), '20080729');
                                                
        wp_declare_script('scriptaculous-root', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/scriptaculous.js'), array('prototype'), '1.8.0');
        wp_declare_script('scriptaculous-builder', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/builder.js'), array('scriptaculous-root'), '1.8.0');
        wp_declare_script('scriptaculous-dragdrop', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/dragdrop.js'), array('scriptaculous-builder', 'scriptaculous-effects'), '1.8.0');
        wp_declare_script('scriptaculous-effects', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/effects.js'), array('scriptaculous-root'), '1.8.0');
        wp_declare_script('scriptaculous-slider', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/slider.js'), array('scriptaculous-effects'), '1.8.0');
        wp_declare_script('scriptaculous-sound', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/sound.js'), array( 'scriptaculous-root' ), '1.8.0');
        wp_declare_script('scriptaculous-controls', (get_bloginfo('wpurl').'/modules/wp_js/scriptaculous/controls.js'), array('scriptaculous-root'), '1.8.0');
        wp_declare_script('scriptaculous', '', array('scriptaculous-dragdrop', 'scriptaculous-slider', 'scriptaculous-controls'), '1.8.0');

        wp_declare_script('cropper', (get_bloginfo('wpurl').'/modules/wp_js/crop/cropper.js'), array('scriptaculous-dragdrop'), '20070118');
        wp_declare_script('jquery', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.js'), false, '1.2.6');
        wp_declare_script('jquery-form', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.form.js'), array('jquery'), '2.02');
        wp_declare_script('jquery-color', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.color.js'), array('jquery'), '2.0-4561');
        wp_declare_script('interface', (get_bloginfo('wpurl').'/modules/wp_js/jquery/interface.js'), array('jquery'), '1.2');
        wp_declare_script('suggest', (get_bloginfo('wpurl').'/modules/wp_js/jquery/suggest.js'), array('jquery'), '1.1b');
        wp_declare_script('schedule', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.schedule.js'), array('jquery'), '20');
        wp_declare_script('jquery-hotkeys', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.hotkeys.js'), array('jquery'), '0.0.2');
        wp_declare_script('jquery-table-hotkeys', (get_bloginfo('wpurl').'/modules/wp_js/jquery/jquery.table-hotkeys.js'), array('jquery', 'jquery-hotkeys'), '20081001');
        wp_declare_script('thickbox', (get_bloginfo('wpurl').'/modules/wp_js/thickbox/thickbox.js'), array('jquery'), '3.1-20080430');

        wp_declare_script('swfupload', (get_bloginfo('wpurl').'/modules/wp_js/swfupload/swfupload.js'), false, '2.2.0-20081031');
        wp_declare_script('swfupload-degrade', (get_bloginfo('wpurl').'/modules/wp_js/swfupload/plugins/swfupload.graceful_degradation.js'), array('swfupload'), '2.2.0-20081031');
        wp_declare_script('swfupload-swfobject', (get_bloginfo('wpurl').'/modules/wp_js/swfupload/plugins/swfupload.swfobject.js'), array('swfupload'), '2.2.0-20081031');        
        wp_declare_script('swfupload-queue', (get_bloginfo('wpurl').'/modules/wp_js/swfupload/plugins/swfupload.queue.js'), array('swfupload'), '2.2.0-20081031');
        wp_declare_script('swfupload-handlers', (get_bloginfo('wpurl').'/modules/wp_js/swfupload/handlers.js'), array('swfupload'), '2.2.0-20081101');

        wp_declare_script('jquery-ui-core', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.core.js'), array('jquery'), '1.5.2');
        wp_declare_script('jquery-ui-tabs', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.tabs.js'), array('jquery-ui-core'), '1.5.2');
        wp_declare_script('jquery-ui-sortable', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.sortable.js'), array('jquery-ui-core'), '1.5.2');
        wp_declare_script('jquery-ui-draggable', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.draggable.js'), array('jquery-ui-core'), '1.5.2');
        wp_declare_script('jquery-ui-resizable', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.resizable.js'), array('jquery-ui-core'), '1.5.2');
        wp_declare_script('jquery-ui-dialog', (get_bloginfo('wpurl').'/modules/wp_js/jquery/ui.dialog.js'), array('jquery-ui-resizable', 'jquery-ui-draggable'), '1.5.2');

        wp_declare_script('comment-reply', (get_bloginfo('wpurl').'/modules/wp_js/comment-reply.js'), false, '20081009');
}

?>
