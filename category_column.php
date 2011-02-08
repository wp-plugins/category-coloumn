<?php
/*
Plugin Name: Category Column
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/category-column-plugin
Description: The Category Column does simply, what the name says; it creates a widget, which you can drag to your sidebar and it will show excerpts of the posts of other categories than showed in the center-column. The plugin is tested with WP up to version 3.1. It might work with versions down to 2.7, but that will never be explicitly supported. The plugin has fully adjustable widgets.  You can choose the number of posts displayed, the offset (only on your homepage or always) and whether or not a line is displayed between the posts. And much more.
Version: 2.9.8
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
*/

/*  Copyright 2010 - 2011  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

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

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die("Sorry, you don't have direct access to this page."); }


// extending the widget class
 
class Category_Column_Widget extends WP_Widget {
 
 function Category_Column_Widget() {
	 
	 $widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your sidebars.', 'category_column') );
	 
	 parent::WP_Widget(false, $name = 'Category Column', $widget_opts);
 }
 
function form($instance) {
	
	// setup some default settings
    
	$defaults = array( 'postcount' => 5, 'offset' => 3, 'homepage' => true, 'wordcount' => 3, 'line' => 1, 'line_color' => '#dddddd');
    
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	$title = esc_attr($instance['title']);
	$postcount = esc_attr($instance['postcount']);
	$offset = esc_attr($instance['offset']);
	$homepage = esc_attr($instance['homepage']);
	$list = esc_attr($instance['list']);
	$wordcount = esc_attr($instance['wordcount']);
	$words = esc_attr($instance['words']);
	$line=esc_attr($instance['line']);
	$line_color=esc_attr($instance['line_color']);
	$style=esc_attr($instance['style']);
 
 ?>
 
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>">
 <?php _e('Title:', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('list'); ?>">
 <?php _e('To exclude certain categories or to show just a special category, simply write their ID&#39;s separated by comma (e.g. <strong>-5,2,4</strong> will show categories 2 and 4 and will exclude category 5):', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" value="<?php echo $list; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('postcount'); ?>">
 <?php _e('How many posts will be displayed in the sidebar:', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" type="text" value="<?php echo $postcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('offset'); ?>">
 <?php _e('Offset (how many posts are spared out in the beginning):', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('homepage'); ?>">
 <?php _e('Check to have the offset only on your homepage:', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('homepage'); ?>" name="<?php echo $this->get_field_name('homepage'); ?>" <?php if(!empty($homepage)) {echo "checked=\"checked\""; } ?> type="checkbox" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('wordcount'); ?>">
 <?php _e('In case there is no excerpt defined, how many sentences are displayed:', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('wordcount'); ?>" name="<?php echo $this->get_field_name('wordcount'); ?>" type="text" value="<?php echo $wordcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('words'); ?>">
 <?php _e('Check to display words instead of sentences:', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('words'); ?>" name="<?php echo $this->get_field_name('words'); ?>" <?php if(!empty($words)) {echo "checked=\"checked\""; } ?> type="checkbox" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line'); ?>">
 <?php _e('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('line'); ?>" name="<?php echo $this->get_field_name('line'); ?>" type="text" value="<?php echo $line; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line_color'); ?>">
 <?php _e('The color of the line (e.g. #cccccc):', 'category_column'); ?>
 <input id="<?php echo $this->get_field_id('line_color'); ?>" name="<?php echo $this->get_field_name('line_color'); ?>" type="text" value="<?php echo $line_color; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('style'); ?>">
 <?php _e('Here you can finally style the widget. Simply type something like<br /><strong>border-left: 1px dashed;<br />border-color: #000000;</strong><br />to get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', 'category_column'); ?>
 <textarea id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>"><?php echo $style; ?></textarea>
 </label>
</p>
<?php
 }
 

function update($new_instance, $old_instance) {
	 
	 $instance = $old_instance;
	 
	 $instance['title'] = strip_tags($new_instance['title']);
	 $instance['postcount'] = strip_tags($new_instance['postcount']);
	 $instance['offset'] = strip_tags($new_instance['offset']);
	 $instance['homepage'] = strip_tags($new_instance['homepage']);
	 $instance['list'] = strip_tags($new_instance['list']); 
	 $instance['wordcount'] = strip_tags($new_instance['wordcount']);
	 $instance['words'] = strip_tags($new_instance['words']);
	 $instance['line'] = strip_tags($new_instance['line']);
	 $instance['line_color'] = strip_tags($new_instance['line_color']);
	 $instance['style'] = strip_tags($new_instance['style']);
	 
	 return $instance;
}
 
function widget($args, $instance) {
	
	extract( $args );
	
	$title = apply_filters('widget_title', $instance['title']);
	
	if (empty($instance['style'])) {
		
		$cc_before_widget=$before_widget;
		$cc_after_widget=$after_widget;
		
	}
	
	else {
		
		$cc_before_widget="<div style=\"".$instance['style']."\">";
		$cc_after_widget="</div>";
		
	}
	
	echo $cc_before_widget;
	
	if ( $title ) {
		
		echo $before_title . $title . $after_title;
		
	}
 
/* This is the actual function of the plugin, it fills the sidebar with the customized excerpts */

$i=1;

$cc_setup="numberposts=".$instance['postcount'];

if (is_home() || empty($instance['homepage'])) {
	$cc_setup.='&offset='.$instance['offset'];
}

if (is_category() && !$instance['list']) {
	$cc_cat=get_query_var('cat');
}

if ($instance['list'] || $cc_cat) {
	$cc_setup.='&cat='.$instance['list'].',-'.$cc_cat;
}


 global $post;
 $myposts = get_posts($cc_setup);
 foreach($myposts as $post) :
 
   setup_postdata($post);
   
   if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
	   
/* If there is a picture, show thumbnail and headline */
	   
	   ?>
       <a href="<?php the_permalink(); ?>">
       <?php the_post_thumbnail(); ?>
       </a><p><a href="<?php the_permalink(); ?>">
       <?php the_title(); ?>
       </a></p>
       <?php 

}
	   
	   else {
		   
	   
	   $cc_thumb = '';
	   
	   #ob_start();
	   
	   #ob_end_clean();
	   
	   $cc_image = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	   $cc_thumb = $matches [1] [0];
	   
	   if (empty($cc_thumb)) {	   
		   
		   
/* If there is no picture, show headline and excerpt of the post */
		   
	
	?>
    <p><a href="<?php the_permalink(); ?>">
    <?php the_title(); ?>
    </a></p>
    <?php


	$cc_excerpt=$post->post_excerpt;
	
/* in case the excerpt is not definded by theme or anything else, the first x sentences of the content are given */
	
	if (empty($cc_excerpt)) {
		
		$cc_text=explode('[/caption]', get_the_content());
		
		if ($instance['words']) {
			
			$cc_short=array_slice(explode(" ", end ($cc_text)), 0, $instance['wordcount']);
			
			$cc_excerpt=implode(" ", $cc_short)."...";
			
		}
		
		else {
			
			$cc_short=array_slice(preg_split("/([\t.!?]+)/", end ($cc_text), -1, PREG_SPLIT_DELIM_CAPTURE), 0, $instance['wordcount']*2);
			
			$cc_excerpt=implode($cc_short);
			
		}
	
	}
	
	echo "<p>".$cc_excerpt."</p>";
	
	   }
	   
	else {
		
	   $cc_image_title=$post->get_the_title;
	   $cc_size=getimagesize($fpw_thumb);
	   
	   if (($cc_size[0]/$cc_size[1])>1) {
								   
			$cc_x=150;
			$cc_y=$fpw_size[1]/($cc_size[0]/$cc_x);
			
		}
		
		else {
											   
			$cc_y=150;
			$cc_x=$fpw_size[0]/($cc_size[1]/$cc_y);
			
		}
	   
	   ?>
       <a href="<?php the_permalink(); ?>">
	   <?php echo "<img title=\"".$cc_image_title."\" src=\"".$cc_thumb."\" alt=\"".$cc_image_title."\" width=\"".$cc_x."\" height=\"".$cc_y."\" />"; ?>
       </a><p><a href="<?php the_permalink(); ?>">
       <?php the_title(); ?>
       </a></p>
	   <?php
	   
	}}
	   
	if (!empty($instance['line']) && $i <  $instance['postcount']) {
		
		echo "<hr style=\"color: ".$instance['line_color']."; background-color: ".$instance['line_color']."; height: ".$instance['line']."px;\" />";
		
		$i++;
		
		}
	
	endforeach;

 
 echo $cc_after_widget;
 
 }
 
}

add_action('widgets_init', create_function('', 'return register_widget("Category_Column_Widget");'));


// import laguage files

load_plugin_textdomain('category_column', false , basename(dirname(__FILE__)).'/languages');

?>