<?php

/**
 *
 * Class CC Dynamic CSS
 *
 * Extending A5 Dynamic Files
 *
 * Presses the dynamical CSS of the Category Column Widget into a virtual style sheet
 *
 */

class CC_DynamicCSS extends A5_DynamicFiles {
	
	private static $options = array();
	
	function __construct() {
		
		self::$options = get_option('cc_options');
		
		if (!isset(self::$options['inline'])) self::$options['inline'] = false;
		
		if (!isset(self::$options['compress'])) self::$options['compress'] = false;
		
		parent::A5_DynamicFiles('wp', 'css', 'all', false, self::$options['inline']);
		
		$eol = (self::$options['compress']) ? '' : "\r\n";
		$tab = (self::$options['compress']) ? '' : "\t";
		
		$css_selector = 'widget_category_column_widget[id^="category_column_widget"]';
		
		parent::$wp_styles .= (!self::$options['compress']) ? $eol.'/* CSS portion of the Category Column */'.$eol.$eol : '';
		
		if (!empty(self::$options['css'])) :
		
			$style = $eol.$tab.str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['css']));
		
			parent::$wp_styles .= parent::build_widget_css($css_selector, '').'{'.$eol.$tab.$style.$eol.'}'.$eol;
			
		endif;
		
		parent::$wp_styles .= parent::build_widget_css($css_selector, 'img').'{'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;

	}
	
} // CC_Dynamic CSS

?>