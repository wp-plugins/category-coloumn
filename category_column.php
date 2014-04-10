<?php
/*
Plugin Name: Category Column
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.9. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets. You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts. And much more.
Version: 4.1
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

defined('ABSPATH') OR exit;

if (!defined('CC_PATH')) define( 'CC_PATH', plugin_dir_path(__FILE__) );
if (!defined('CC_BASE')) define( 'CC_BASE', plugin_basename(__FILE__) );

# loading the framework
if (!class_exists('A5_Image')) require_once CC_PATH.'class-lib/A5_ImageClass.php';
if (!class_exists('A5_Excerpt')) require_once CC_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('A5_FormField')) require_once CC_PATH.'class-lib/A5_FormFieldClass.php';
if (!class_exists('A5_OptionPage')) require_once CC_PATH.'class-lib/A5_OptionPageClass.php';
if (!class_exists('A5_DynamicFiles')) require_once CC_PATH.'class-lib/A5_DynamicFileClass.php';

#loading plugin specific classes
if (!class_exists('CC_Admin')) require_once CC_PATH.'class-lib/CC_AdminClass.php';
if (!class_exists('CC_DynamicCSS')) require_once CC_PATH.'class-lib/CC_DynamicCSSClass.php';
if (!class_exists('Category_Column_Widget')) require_once CC_PATH.'class-lib/CC_WidgetClass.php';

class CategoryColumn {

	const language_file = 'category_column';

	private static $options;

	function __construct() {
		
		// import laguage files
	
		load_plugin_textdomain(self::language_file, false , basename(dirname(__FILE__)).'/languages');
		
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
		
		add_filter('plugin_row_meta', array(&$this, 'register_links'), 10, 2);	
		add_filter( 'plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
				
		register_activation_hook(  __FILE__, array(&$this, '_install') );
		register_deactivation_hook(  __FILE__, array(&$this, '_uninstall') );
		
		self::$options = get_option('cc_options');
		
		if (isset(self::$options['tags'])) $this->update_plugin_options();
		
		$CC_DynamicCSS = new CC_DynamicCSS;
		$CC_Admin = new CC_Admin;
		
	}

	/* attach JavaScript file for textarea resizing */
	
	function enqueue_scripts($hook) {
		
		if ($hook != 'settings_page_category-column-settings' && $hook != 'widgets.php') return;
		
		wp_register_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '2.0', true);
		wp_enqueue_script('ta-expander-script');
	
	}
	
	//Additional links on the plugin page
	
	function register_links($links, $file) {
		
		if ($file == CC_BASE) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/category-coloumn/faq/" target="_blank">'.__('FAQ', self::language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TQ9M9VJMAWA3Q" target="_blank">'.__('Donate', self::language_file).'</a>';
		}
		
		return $links;
		
	}
		
	function plugin_action_links( $links, $file ) {
		
		if ($file == CC_BASE) array_unshift($links, '<a href="'.admin_url( 'options-general.php?page=category-column-settings' ).'">'.__('Settings', self::language_file).'</a>');
	
		return $links;
	
	}
	
	// Creating default options on activation
	
	function _install() {
		
		$default = array(
			'cache' => array(),
			'inline' => false
		);
		
		add_option('cc_options', $default);
		
	}
	
	// Cleaning on deactivation
	
	function _uninstall() {
		
		delete_option('cc_options');
		
	}
	
	// updating options in case they are outdated
	
	function update_plugin_options() {	
		
			self::$options['cache'] = array();
			
			self::$options['inline'] = false;
			
			unset(self::$options['tags'], self::$options['sizes']);
			
			update_option('cc_options', self::$options);
	
	}

} // end of class

$CategoryColumn = new CategoryColumn;

?>