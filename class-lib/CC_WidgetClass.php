<?php

/**
 *
 * Class CC Widget
 *
 * @ Advanced Featured Post Widget
 *
 * building the actual widget
 *
 */
class Category_Column_Widget extends WP_Widget {
 
function Category_Column_Widget() {

	global $cc_language_file;
	
	$widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your sidebars.', $cc_language_file) );
	$control_opts = array( 'width' => 400 );
	
	parent::WP_Widget(false, $name = 'Category Column', $widget_opts, $control_opts);

}
 
function form($instance) {
	
	global $cc_language_file;
	
	// setup some default settings
	
	$defaults = array( 'postcount' => 5, 'offset' => 3, 'homepage' => true, 'wordcount' => 3, 'line' => 1, 'line_color' => '#dddddd');
	
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	$title = esc_attr($instance['title']);
	$postcount = esc_attr($instance['postcount']);
	$offset = esc_attr($instance['offset']);
	$home = esc_attr($instance['home']);
	$list = esc_attr($instance['list']);
	$adsense = esc_attr($instance['adsense']);
	$linespace = esc_attr($instance['linespace']);
	$wordcount = esc_attr($instance['wordcount']);
	$words = esc_attr($instance['words']);
	$line=esc_attr($instance['line']);
	$line_color=esc_attr($instance['line_color']);
	$style=esc_attr($instance['style']);

?>
<p>
 <label for="<?php echo $this->get_field_id('title'); ?>">
 <?php _e('Title:', $cc_language_file); ?>
 <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('list'); ?>">
 <?php _e('To exclude certain categories or to show just a special category, simply write their ID&#39;s separated by comma (e.g. <strong>-5,2,4</strong> will show categories 2 and 4 and will exclude category 5):', $cc_language_file); ?>
 <input size="20" id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" value="<?php echo $list; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('postcount'); ?>">
 <?php _e('How many posts will be displayed in the sidebar:', $cc_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" type="text" value="<?php echo $postcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('offset'); ?>">
 <?php _e('Offset (how many posts are spared out in the beginning):', $cc_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('home'); ?>">
 <input id="<?php echo $this->get_field_id('home'); ?>" name="<?php echo $this->get_field_name('home'); ?>" <?php if($home) echo 'checked="checked"' ?> type="checkbox" />&nbsp;<?php _e('Check to have the offset only on your homepage.', $cc_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('wordcount'); ?>">
 <?php _e('In case there is no excerpt defined, how many sentenses of the content are displayed:', $cc_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('wordcount'); ?>" name="<?php echo $this->get_field_name('wordcount'); ?>" type="text" value="<?php echo $wordcount; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('linespace'); ?>">
 <input id="<?php echo $this->get_field_id('linespace'); ?>" name="<?php echo $this->get_field_name('linespace'); ?>" <?php if($linespace) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Check to have each sentense in a new line.', $cc_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('words'); ?>">
 <input id="<?php echo $this->get_field_id('words'); ?>" name="<?php echo $this->get_field_name('words'); ?>" <?php if($words) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Check to display words instead of sentences:', $cc_language_file); ?>
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line'); ?>">
 <?php _e('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', $cc_language_file); ?>
 <input size="4" id="<?php echo $this->get_field_id('line'); ?>" name="<?php echo $this->get_field_name('line'); ?>" type="text" value="<?php echo $line; ?>" />
 </label>
</p>
<p>
 <label for="<?php echo $this->get_field_id('line_color'); ?>">
 <?php _e('The color of the line (e.g. #cccccc):', $cc_language_file); ?>
 <input size="13" id="<?php echo $this->get_field_id('line_color'); ?>" name="<?php echo $this->get_field_name('line_color'); ?>" type="text" value="<?php echo $line_color; ?>" />
 </label>
</p>
<?php
if (defined('AE_AD_TAGS') && AE_AD_TAGS==1) :
?>
<p>
 <label for="<?php echo $this->get_field_id('adsense'); ?>">
 <input id="<?php echo $this->get_field_id('adsense'); ?>" name="<?php echo $this->get_field_name('adsense'); ?>" <?php if($adsense) echo 'checked="checked"'; ?> type="checkbox" />&nbsp;<?php _e('Check if you want to invert the Google AdSense Tags that are defined with the Ads Easy Plugin. E.g. when they are turned off for the sidebar, they will appear in the widget.', $cc_language_file); ?>
 </label>
</p>
<?php
endif;
?>
<p>
 <label for="<?php echo $this->get_field_id('style'); ?>">
 <?php echo __('Here you can finally style the widget. Simply type something like', $cc_language_file).'<br /><strong>border-left: 1px dashed;<br />border-color: #000000;</strong><br />'.__('to get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', $cc_language_file); ?>
 <textarea class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>"><?php echo $style; ?></textarea>
 </label>
</p>
<script type="text/javascript"><!--
jQuery(document).ready(function() {
	jQuery("#<?php echo $this->get_field_id('style'); ?>").autoResize();
});
--></script>
<?php
} // form

function update($new_instance, $old_instance) {

	$instance = $old_instance;
	
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['postcount'] = strip_tags($new_instance['postcount']);
	$instance['offset'] = strip_tags($new_instance['offset']);
	$instance['home'] = strip_tags($new_instance['home']);
	$instance['list'] = strip_tags($new_instance['list']); 
	$instance['wordcount'] = strip_tags($new_instance['wordcount']);
	$instance['words'] = strip_tags($new_instance['words']);
	$instance['adsense'] = strip_tags($new_instance['adsense']);
	$instance['linespace'] = strip_tags($new_instance['linespace']);
	$instance['line'] = strip_tags($new_instance['line']);
	$instance['line_color'] = strip_tags($new_instance['line_color']);
	$instance['style'] = strip_tags($new_instance['style']);
	
	return $instance;

}

function widget($args, $instance) {
	
	extract( $args );
	
	$title = apply_filters('widget_title', $instance['title']);
	
	if (empty($instance['style'])) :
	
		$cc_before_widget=$before_widget;
		$cc_after_widget=$after_widget;
	
	else :
	
		$cc_style=str_replace(array("\r\n", "\n", "\r"), '', $instance['style']);
		
		$cc_before_widget="<div id=\"".$widget_id."\" style=\"".$cc_style."\">";
		$cc_after_widget="</div>";
	
	endif;
	
	// hooking into ads easy for the google tags
	
	if (AE_AD_TAGS == 1 && $instance['adsense']) :
		
		do_action('google_end_tag');
		
		if ($ae_options['ae_sidebar']==1) do_action('google_ignore_tag');
	
		else do_action('google_start_tag');
		
	endif;	
	
	echo $cc_before_widget;
	
	if ( $title ) echo $before_title . $title . $after_title;
 
/* This is the actual function of the plugin, it fills the sidebar with the customized excerpts */

$i=1;

$cc_setup="numberposts=".$instance['postcount'];

if (is_home() || empty($instance['home'])) :
	
	global $wp_query;
	
	$cc_page = $wp_query->get( 'paged' );
	$cc_numberposts = $wp_query->get( 'posts_per_page' );
	
	if ($cc_page) $cc_offset=(($cc_page-1)*$cc_numberposts)+$instance['offset'];
		
	else $cc_offset=$instance['offset'];
	
	$cc_setup.='&offset='.$cc_offset;

endif;

if (is_category() && !$instance['list']) $cc_cat=get_query_var('cat');

if ($instance['list'] || $cc_cat) $cc_setup.='&cat='.$instance['list'].',-'.$cc_cat;

if (is_single()) :
	
	global $wp_query;
	
	$cc_setup.='&exclude='.$wp_query->get_queried_object_id();
	
endif;

global $post;

$cc_posts = get_posts($cc_setup);

foreach($cc_posts as $post) :

 	$imagetags = new A5_ImageTags;
	
	$cc_tags = $imagetags->get_tags($post, $cc_language_file);
	
	$cc_image_alt = $cc_tags['image_alt'];
	$cc_image_title = $cc_tags['image_title'];
	$cc_title_tag = $cc_tags['title_tag'];
	
	$eol = "\r\n";
	$cc_headline = '<p>'.$eol.'<a href="'.get_permalink().'" title="'.$cc_title_tag.'">'.get_the_title().'</a>'.$eol.'</p>';
	
	if (function_exists('has_post_thumbnail') && has_post_thumbnail()) :
	
	/* If there is a thumbnail, show thumbnail and headline */
	   
	echo '<a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a>'.$eol.'<div style="clear: both;"></div>'.$eol.$cc_headline;

	else :
	
		$args = array (
		'content' => $post->post_content,
		'width' => get_option('thumbnail_size_w'),
		'height' => get_option('thumbnail_size_h')
		);
		   
		$cc_image = new A5_Thumbnail;
	
	   	$cc_image_info = $cc_image->get_thumbnail($args);
		
		$cc_thumb = $cc_image_info['thumb'];
		
		$cc_width = $cc_image_info['thumb_width'];

		$cc_height = $cc_image_info['thumb_height'];	
	
		if (!empty($cc_thumb)) :
		
			if ($cc_width) $cc_img = '<img title="'.$cc_image_title.'" src="'.$cc_thumb.'" alt="'.$cc_image_alt.'" width="'.$cc_width.'" height="'.$cc_height.'" />';
				
			else $cc_img = '<img title="'.$cc_image_title.'" src="'.$cc_thumb.'" alt="'.$cc_image_alt.'" style="maxwidth: '.get_option('thumbnail_size_w').'; maxheight: '.get_option('thumbnail_size_h').';" />';
			
			?>
			<a href="<?php the_permalink(); ?>"> <?php echo $cc_img; ?></a>
            <div style="clear:both;"></div>
			<p><a href="<?php the_permalink(); ?>" title="<?php echo $cc_title_tag ?>"><?php the_title(); ?></a></p>
			<?php
			
		else :
			
			/* If there is no picture, show headline and excerpt of the post */
			
			echo $cc_headline;
			
			/* in case the excerpt is not definded by theme or anything else, the first x sentences of the content are given */
			
			$type = (empty($instance['words'])) ? 'sentenses' : 'words';
				
			$args = array(
			'excerpt' => $post->post_excerpt,
			'content' => $post->post_content,
			'type' => $type,
			'count' => $instance['wordcount'],
			'linespace' => $instance['linespace']
			);
	
			$cc_excerpt = new A5_Excerpt;
			
			$cc_text = $cc_excerpt->get_excerpt($args);

			echo '<p>'.$cc_text.'</p>';
		
		endif;
		
	endif;
	
	if (!empty($instance['line']) && $i <  $instance['postcount']) :
		
		echo '<hr style="color: '.$instance['line_color'].'; background-color: '.$instance['line_color'].'; height: '.$instance['line'].'px;" />';
		
		$i++;
		
	endif;
	
endforeach;

echo $cc_after_widget;

// hooking into ads easy for the google tags

if (AE_AD_TAGS == 1 && $instance['adsense']) :
	
	do_action('google_end_tag');
	
	if ($ae_options['ae_sidebar']==1) do_action('google_start_tag');

	else do_action('google_ignore_tag');
	
endif;

}
 
}

add_action('widgets_init', create_function('', 'return register_widget("Category_Column_Widget");'));

?>