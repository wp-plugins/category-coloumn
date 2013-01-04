<?php
/*
Plugin Name: Category Column
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.5. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets. You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts. And much more.
Version: 3.8
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
Text Domain: category_column
*/

/*  Copyright 2010 - 2013  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

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
if (!function_exists('a5_textarea')) require_once CC_PATH.'includes/A5_field-functions.php';
if (!class_exists('Category_Column_Widget')) require_once CC_PATH.'class-lib/CC_WidgetClass.php';

class CategoryColumn {

const language_file = 'category_column';

	function __construct() {
		
		// import laguage files
	
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');	
		
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_filter('plugin_row_meta', array($this, 'register_links'),10,2);
		
		add_action('init', array ($this, 'add_rewrite'));
		add_action('template_redirect', array ($this, 'css_template'));
		add_action ('wp_enqueue_scripts', array ($this, 'enqueue_css'));
		
		register_activation_hook(  __FILE__, array($this, 'set_options') );
		register_deactivation_hook(  __FILE__, array($this, 'unset_options') );
		
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
	
	function add_rewrite() {
		
	   global $wp;
	   $wp->add_query_var('ccfile');
	
	}
	
	function css_template() {
		
	   if (get_query_var('ccfile') == 'css') {
			   
		   header('Content-type: text/css');
		   echo $this->write_dss();
		   
		   exit;
	   }
	}

	function enqueue_css () {
		
		$cc_css_file=get_bloginfo('url').'/?ccfile=css';
			
		wp_register_style(self::language_file, $cc_css_file, false, '3.8', 'all');
		wp_enqueue_style(self::language_file);
		
	}
	
	// writing dss file
		
	function write_dss() {
		
		$eol = "\r\n";
		$tab = "\t";
		
		$css_text='@charset "UTF-8";'.$eol.'/* CSS Document */'.$eol.$eol;
		
		$css_text.='p[id^="acc_byline"] {'.$eol.'font-size: 0.9em;'.$eol.'}'.$eol;
		
		$css_text.='p[id^="acc_byline"] a {'.$eol.'text-decoration: none !important;'.$eol.'font-weight: normal !important;'.$eol.'}'.$eol;
		
		return $css_text;
		
	}

} // end of class

$CategoryColumn = new CategoryColumn;

?>