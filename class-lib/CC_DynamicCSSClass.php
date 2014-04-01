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
		
		self::$options = get_option('cc_options', array('cache' => array(), 'inline'=> false));
		
		if (!isset(self::$options['inline'])) self::$options['inline'] = false;
		
		parent::A5_DynamicFiles('wp', 'css', false, self::$options['inline']);
		
		$eol = "\r\n";
		$tab = "\t";
		
		$css_selector = '.widget_category_column_widget[id^="category_column_widget"]';
		
		parent::$styles .= $eol.'/* CSS portion of the Category Column */'.$eol.$eol;
		
		$style = '-moz-hyphens: auto;'.$eol.$tab.'-o-hyphens: auto;'.$eol.$tab.'-webkit-hyphens: auto;'.$eol.$tab.'-ms-hyphens: auto;'.$eol.$tab.'hyphens: auto;';
		
		if (array_key_exists('css', self::$options) && !empty(self::$options['css'])) $style.=$eol.$tab.str_replace('; ', ';'.$eol.$tab, str_replace(array("\r\n", "\n", "\r"), ' ', self::$options['css']));
		
		parent::$styles.='div'.$css_selector.','.$eol.'li'.$css_selector.','.$eol.'aside'.$css_selector.' {'.$eol.$tab.$style.$eol.'}'.$eol;
		
		parent::$styles.='div'.$css_selector.' img,'.$eol.'li'.$css_selector.' img,'.$eol.'aside'.$css_selector.' img {'.$eol.$tab.'height: auto;'.$eol.$tab.'max-width: 100%;'.$eol.'}'.$eol;

	}
	
} // CC_Dynamic CSS

?>