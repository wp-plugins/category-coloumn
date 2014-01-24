<?php
/*
Plugin Name: Category Column
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.9. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets. You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts. And much more.
Version: 3.8.1
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
Text Domain: category_column
*/

/*  Copyright 2010 - 2014  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


/* Stop direct call */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Sorry, you don&#39;t have direct access to this page.');

define( 'CC_PATH', plugin_dir_path(__FILE__) );

if (!class_exists('A5_Image')) require_once CC_PATH.'class-lib/A5_ImageClass.php';
if (!class_exists('A5_Excerpt')) require_once CC_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('A5_FormField')) require_once CC_PATH.'class-lib/A5_FormFieldClass.php';
if (!class_exists('Category_Column_Widget')) require_once CC_PATH.'class-lib/CC_WidgetClass.php';
if (!class_exists('A5_DynamicCSS')) :

	require_once CC_PATH.'class-lib/A5_DynamicCSSClass.php';
	
	$dynamic_css = new A5_DynamicCSS;
	
endif;

class CategoryColumn {

const language_file = 'category_column';

	function __construct() {
		
		// import laguage files
	
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');	
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_filter('plugin_row_meta', array($this, 'register_links'),10,2);
		
		register_activation_hook(  __FILE__, array($this, 'set_options') );
		register_deactivation_hook(  __FILE__, array($this, 'unset_options') );
		
		$eol = "\r\n";
		$tab = "\t";
		
		A5_DynamicCSS::$styles .= $eol.'/* CSS portion of the Category Column */'.$eol.$eol;
		
		A5_DynamicCSS::$styles .= 'p[id^="cc_byline"] {'.$eol.$tab.'font-size: 0.9em;'.$eol.'}'.$eol;
		
		A5_DynamicCSS::$styles .= 'p[id^="cc_byline"] a {'.$eol.$tab.'text-decoration: none !important;'.$eol.$tab.'font-weight: normal !important;'.$eol.'}'.$eol;
		
		A5_DynamicCSS::$styles.='div[id^="category_column_widget"].widget_category_column_widget img {'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;
		
	}

	/* attach JavaScript file for textarea resizing */
	
	function enqueue_scripts($hook) {
		
		if ($hook != 'widgets.php') return;
		
		wp_register_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '2.0', true);
		wp_enqueue_script('ta-expander-script');
	
	}
	
	//Additional links on the plugin page
	
	function register_links($links, $file) {
		
		$base = plugin_basename(__FILE__);
		if ($file == $base) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/category-coloumn/faq/" target="_blank">'.__('FAQ', self::language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TQ9M9VJMAWA3Q" target="_blank">'.__('Donate', self::language_file).'</a>';
		}
		
		return $links;
	
	}
	
	// Creating default options on activation
	
	function set_options() {
		
		$default = array(
			'tags' => array(),
			'sizes' => array()
		);
		
		add_option('cc_options', $default);
		
	}
	
	// Cleaning on deactivation
	
	function unset_options() {
		
		delete_option('cc_options');
		
	}

} // end of class

$CategoryColumn = new CategoryColumn;

?>