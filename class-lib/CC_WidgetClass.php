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
	
const language_file = 'category_column';
 
function Category_Column_Widget() {

	$widget_opts = array( 'description' => __('Configure the output and looks of the widget. Then display thumbnails and excerpts of posts in your sidebars.', self::language_file) );
	$control_opts = array( 'width' => 400 );
	
	parent::WP_Widget(false, $name = 'Category Column', $widget_opts, $control_opts);

}
 
function form($instance) {
	
	// setup some default settings
	
	$defaults = array( 'postcount' => 5, 'offset' => 3, 'home' => 1, 'wordcount' => 3, 'line' => 1, 'line_color' => '#dddddd', 'h' => 3);
	
	$instance = wp_parse_args( (array) $instance, $defaults );
	
	$title = esc_attr($instance['title']);
	$postcount = esc_attr($instance['postcount']);
	$offset = esc_attr($instance['offset']);
	$home = esc_attr($instance['home']);
	$list = esc_attr($instance['list']);
	$showcat = esc_attr($instance['showcat']);
	$showcat_txt = esc_attr($instance['showcat_txt']);
	$wordcount = esc_attr($instance['wordcount']);
	$linespace = esc_attr($instance['linespace']);
	$width = esc_attr($instance['width']);
	$words = esc_attr($instance['words']);
	$line=esc_attr($instance['line']);
	$line_color=esc_attr($instance['line_color']);
	$style=esc_attr($instance['style']);
	$h = esc_attr($instance['h']);
	
	$base_id = 'widget-'.$this->id_base.'-'.$this->number.'-';
	$base_name = 'widget-'.$this->id_base.'['.$this->number.']';
	
	$headings = array(array('1', 'h1'), array('2', 'h2'), array('3', 'h3'), array('4', 'h4'), array('5', 'h5'), array('6', 'h6'));
	
	a5_text_field($base_id.'title', $base_name.'[title]', $title, __('Title:', self::language_file), array('space' => true, 'class' => 'widefat'));
	a5_text_field($base_id.'list', $base_name.'[list]', $list, sprintf(__('To exclude certain categories or to show just a special category, simply write their ID&#39;s separated by comma (e.g. %s-5, 2, 4%s will show categories 2 and 4 and will exclude category 5):', self::language_file), '<strong>', '</strong>'), array('space' => true, 'class' => 'widefat'));
	a5_checkbox($base_id.'showcat', $base_name.'[showcat]', $showcat, __('Check to show the categories in which the post is filed.', self::language_file), array('space' => true));
	a5_text_field($base_id.'showcat_txt', $base_name.'[showcat_txt]', $showcat_txt, __('Give some text that you want in front of the post&#39;s categtories (i.e &#39;filed under&#39;:', self::language_file), array('space' => true, 'class' => 'widefat'));
	a5_number_field($base_id.'postcount', $base_name.'[postcount]', $postcount, __('How many posts will be displayed in the sidebar:', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
	a5_number_field($base_id.'offset', $base_name.'[offset]', $offset, __('Offset (how many posts are spared out in the beginning):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
	a5_checkbox($base_id.'home', $base_name.'[home]', $home, __('Check to have the offset only on your homepage.', self::language_file), array('space' => true));
	a5_number_field($base_id.'width', $base_name.'[width]', $width, __('Width of the thumbnail (in px):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
	a5_select($base_id.'h', $base_name.'[h]', $headings, $h, __('Weight of the Post Title:', self::language_file), false, array('space' => true));
	a5_number_field($base_id.'wordcount', $base_name.'[wordcount]', $wordcount, __('In case there is no excerpt defined, how many sentences are displayed:', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
	a5_checkbox($base_id.'words', $base_name.'[words]', $words, __('Check to display words instead of sentences.', self::language_file), array('space' => true));
	a5_checkbox($base_id.'linespace', $base_name.'[linespace]', $linespace, __('Check to have each sentense in a new line.', self::language_file), array('space' => true));
	a5_number_field($base_id.'line', $base_name.'[line]', $line, __('If you want a line between the posts, this is the height in px (if not wanting a line, leave emtpy):', self::language_file), array('space' => true, 'size' => 4, 'step' => 1));
	a5_color_field($base_id.'line_color', $base_name.'[line_color]', $line_color, __('The color of the line (e.g. #cccccc):', self::language_file), array('space' => true, 'size' => 13));
	a5_textarea($base_id.'style', $base_name.'[style]', $style, sprintf(__('Here you can finally style the widget. Simply type something like%1$s%2$sborder-left: 1px dashed;%2$sborder-color: #000000;%3$s%2$sto get just a dashed black line on the left. If you leave that section empty, your theme will style the widget.', self::language_file), '<strong>', '<br />', '</strong>'), array('space' => true, 'class' => 'widefat', 'style' => 'height: 60px;'));
	a5_resize_textarea(array($base_id.'style'), true);

} // form

function update($new_instance, $old_instance) {

	$instance = $old_instance;
	
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['postcount'] = strip_tags($new_instance['postcount']);
	$instance['offset'] = strip_tags($new_instance['offset']);
	$instance['home'] = strip_tags($new_instance['home']);
	$instance['list'] = strip_tags($new_instance['list']);
	$instance['showcat'] = strip_tags($new_instance['showcat']);
	$instance['showcat_txt'] = strip_tags($new_instance['showcat_txt']); 	
	$instance['wordcount'] = strip_tags($new_instance['wordcount']);
	$instance['width'] = strip_tags($new_instance['width']);
	$instance['words'] = strip_tags($new_instance['words']);
	$instance['adsense'] = strip_tags($new_instance['adsense']);
	$instance['linespace'] = strip_tags($new_instance['linespace']);
	$instance['line'] = strip_tags($new_instance['line']);
	$instance['line_color'] = strip_tags($new_instance['line_color']);
	$instance['style'] = strip_tags($new_instance['style']);
	$instance['h'] = strip_tags($new_instance['h']);
	
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
	
	echo $cc_before_widget;
	
	if ( $title ) echo $before_title . $title . $after_title;
 
	/* This is the actual function of the plugin, it fills the sidebar with the customized excerpts */
	
	$i=1;
	
	$cc_setup="posts_per_page=".$instance['postcount'];
	
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
	
	$cc_posts = new WP_Query($cc_setup);
	
	while($cc_posts->have_posts()) :
		
		$cc_posts->the_post();
	
		if ($instance['showcat']) :
		
			$post_categories = wp_get_post_categories( $post->ID);
			
			$cats = array();
		
			foreach($post_categories as $c) :
			
				$cat = get_category( $c );
			
				$cats[] = $eol.'<a href="'.get_category_link( $c ).'" title="'.$cat->name.'">'.$cat->name.'</a>';
			
			endforeach;
			
			$post_byline = ($instance['showcat_txt']) ? $eol.'<p id="acc_byline-'.$widget_id.'-'.$count.'">'.$eol.$instance['showcat_txt'].' ' : $eol.'<p id="acc_byline-'.$widget_id.'-'.$count.'">';
			
			$post_byline .= implode(', ', $cats);
		
			$post_byline .= $eol.'</p>'.$eol;
		
			echo $post_byline;
		
		endif;
	
		$cc_tags = A5_Image::tags($post, 'cc_options', self::language_file);
		
		$cc_image_alt = $cc_tags['image_alt'];
		$cc_image_title = $cc_tags['image_title'];
		$cc_title_tag = $cc_tags['title_tag'];
		
		$eol = "\r\n";
		$cc_headline = '<h'.$instance['h'].'>'.$eol.'<a href="'.get_permalink().'" title="'.$cc_title_tag.'">'.get_the_title().'</a>'.$eol.'</h'.$instance['h'].'>';
		
		// get thumbnail
			
		if (!$instance['width']) :
		
			$width = get_option('thumbnail_size_w');
			
			if (!empty($width)) $width = 150;
			
			$height = get_option('thumbnail_size_h');
			
			if (!empty($height)) :
			
				$height = 150;
				
			endif;
			
		else : 
		
			$width = $instance['width'];
			
			$height = false;
			
			if (has_post_thumbnail()) :
			
				$img_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
					
				$source = $img_url[0];
				
			endif;
		
		endif;
		
		if (has_post_thumbnail() && !$instance['width']) :
		
			$cc_img = get_the_post_thumbnail($post->ID, 'thumbnail');
			
		else :
		
			$args = array (
			'thumb' => $source,
			'content' => $post->post_content,
			'width' => $width,
			'height' => $height, 
			'option' => 'cc_options'
			);	
		   
			$image_info = A5_Image::thumbnail($args);
			
			$cc_thumb = $image_info['thumb'];
			
			$cc_width = $image_info['thumb_width'];
	
			$cc_height = $image_info['thumb_height'];
			
			if ($cc_thumb) :
			
				if ($cc_width) $cc_img = '<img title="'.$cc_image_title.'" src="'.$cc_thumb.'" alt="'.$cc_image_alt.'" class="wp-post-image" width="'.$cc_width.'" height="'.$cc_height.'" />';
					
				else $cc_img = '<img title="'.$cc_image_title.'" src="'.$cc_thumb.'" alt="'.$cc_image_alt.'" class="wp-post-image" style="maxwidth: '.$width.'; maxheight: '.$height.';" />';
				
			endif;
			
		endif;
				
		if ($cc_img) :
			
			echo '<a href="'.get_permalink().'">'.$cc_img.'</a>'.$eol.'<div style="clear: both;"></div>'.$eol.$cc_headline;
	
		else :
				
			/* If there is no picture, show headline and excerpt of the post */
			
			echo $cc_headline;
			
			/* in case the excerpt is not definded by theme or anything else, the first x sentences of the content are given */
			
			$type = (empty($instance['words'])) ? 'sentences' : 'words';
				
			$args = array(
			'excerpt' => $post->post_excerpt,
			'content' => $post->post_content,
			'type' => $type,
			'count' => $instance['wordcount'],
			'linespace' => $instance['linespace'],
			'filter' => true
			);
			
			echo A5_Excerpt::text($args);
			
		endif;
		
		if (!empty($instance['line']) && $i <  $instance['postcount']) :
			
			echo '<hr style="color: '.$instance['line_color'].'; background-color: '.$instance['line_color'].'; height: '.$instance['line'].'px;" />';
			
			$i++;
			
		endif;
		
		unset($cc_img, $source);
			
		$count++;
			
	endwhile;
		
	// Restore original Query & Post Data
	wp_reset_query();
	wp_reset_postdata();
	
	echo $cc_after_widget;

}
 
} // end of class

add_action('widgets_init', create_function('', 'return register_widget("Category_Column_Widget");'));

?>