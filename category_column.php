<?php
/*
Plugin Name: Category Column
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.4. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets.  You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts. And much more.
Version: 3.7
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
Text Domain: category_column
*/

/*  Copyright 2010 - 2012  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

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

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die(__('Sorry, you don&#39;t have direct access to this page.'));

/* attach JavaScript file for textarea resizing */

function cc_js_sheet() {
	
	wp_enqueue_script('ta-expander-script', plugins_url('ta-expander.js', __FILE__), array('jquery'), '2.0', true);

}

add_action('admin_print_scripts-widgets.php', 'cc_js_sheet');

//Additional links on the plugin page

add_filter('plugin_row_meta', 'cc_register_links',10,2);

function cc_register_links($links, $file) {
	
	global $cc_language_file;
	
	$base = plugin_basename(__FILE__);
	if ($file == $base) {
		$links[] = '<a href="http://wordpress.org/extend/plugins/category-coloumn/faq/" target="_blank">'.__('FAQ', $cc_language_file).'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TQ9M9VJMAWA3Q" target="_blank">'.__('Donate', $cc_language_file).'</a>';
	}
	
	return $links;

}

define( 'CC_PATH', plugin_dir_path(__FILE__) );

if (!class_exists('A5_Thumbnail')) require_once CC_PATH.'class-lib/A5_ImageClasses.php';
if (!class_exists('A5_Excerpt')) require_once CC_PATH.'class-lib/A5_ExcerptClass.php';
if (!class_exists('Category_Column_Widget')) require_once CC_PATH.'class-lib/CC_WidgetClass.php';

// import laguage files

$cc_language_file = 'category_column';

load_plugin_textdomain($cc_language_file, false , basename(dirname(__FILE__)).'/languages');

?>