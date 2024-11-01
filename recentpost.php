<?php
/*
Plugin Name: Vina Posts Widget
Plugin URI: http://VinaThemes.biz
Description: A widget that show the posts with many choose to display.
Version: 1.0
Author: VinaThemes
Author URI: http://VinaThemes.biz
Author email: mr_hiennc@yahoo.com
Demo URI: http://VinaDemo.biz
Forum URI: http://VinaForum.biz
License: GPLv3+
*/

//Defined global variables
if(!defined('TCVN_RECENTPOST_DIRECTORY')) 		define('TCVN_RECENTPOST_DIRECTORY', dirname(__FILE__));
if(!defined('TCVN_RECENTPOST_INC_DIRECTORY')) 	define('TCVN_RECENTPOST_INC_DIRECTORY', TCVN_RECENTPOST_DIRECTORY . '/includes');
if(!defined('TCVN_RECENTPOST_URI')) 			define('TCVN_RECENTPOST_URI', get_bloginfo('url') . '/wp-content/plugins/tcvn-recentpost-widget');
if(!defined('TCVN_RECENTPOST_INC_URI')) 		define('TCVN_RECENTPOST_INC_URI', TCVN_RECENTPOST_URI . '/includes');

//Include library
if(!defined('TCVN_FUNCTIONS')) {
    include_once TCVN_RECENTPOST_INC_DIRECTORY . '/functions.php';
    define('TCVN_FUNCTIONS', 1);
}
if(!defined('TCVN_FIELDS')) {
    include_once TCVN_RECENTPOST_INC_DIRECTORY . '/fields.php';
    define('TCVN_FIELDS', 1);
}

class RecentPost_Widget extends WP_Widget 
{
	function RecentPost_Widget()
	{
		$widget_ops = array(
			'classname' => 'recentpost_widget',
			'description' => __('A widget that show the posts with many choose to display.')
		);
		$this->WP_Widget('recentpost_widget', __('Vina Posts Widget'), $widget_ops);
	}
	
	function form($instance)
	{
		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
				'title' 			=> '',
				'categoryId' 		=> '',
				'noItem' 			=> '5',
				'ordering' 			=> 'id',
				'orderingDirection' => 'desc',
				'postTitle' 		=> 'yes',
				'date' 				=> 'no',
				'category' 			=> 'no',
				'author' 			=> 'no',
				'comment' 			=> 'no',
				'showIntro' 		=> 'no',
				'showImage' 		=> 'no',
				'thumbnailWidth' 	=> '100',
				'thumbnailHeight' 	=> '100',
				'introLimit' 		=> '150',
				'showReadmore' 		=> 'no',
				'freeLicense'		=> 'yes',
			)
		);

		$title			= esc_attr($instance['title']);
		$categoryId		= esc_attr($instance['categoryId']);
		$noItem			= esc_attr($instance['noItem']);
		$ordering		= esc_attr($instance['ordering']);
		$orderingDirection = esc_attr($instance['orderingDirection']);
		$postTitle		= esc_attr($instance['postTitle']);
		$date			= esc_attr($instance['date']);
		$category		= esc_attr($instance['category']);
		$author			= esc_attr($instance['author']);
		$comment		= esc_attr($instance['comment']);
		$showIntro		= esc_attr($instance['showIntro']);
		$showImage		= esc_attr($instance['showImage']);
		$thumbnailWidth	 = esc_attr($instance['thumbnailWidth']);
		$thumbnailHeight = esc_attr($instance['thumbnailHeight']);
		$introLimit		= esc_attr($instance['introLimit']);
		$showReadmore	= esc_attr($instance['showReadmore']);
		$freeLicense 	= esc_attr($instance['freeLicense']);
		?>
        <div id="tcvn-recentpost" class="tcvn-plugins-container">
            <div style="color: red; padding: 0px 0px 10px; text-align: center;">You are using free version !</div>
            <div id="tcvn-tabs-container">
                <ul id="tcvn-tabs">
                    <li class="active"><a href="#basic"><?php _e('Basic'); ?></a></li>
                    <li><a href="#advanced"><?php _e('Advanced'); ?></a></li>
                </ul>
            </div>
            <div id="tcvn-elements-container">
                <!-- Basic Block -->
                <div id="basic" class="tcvn-telement" style="display: block;">
                    <p><?php echo eTextField($this, 'title', 'Title', $title); ?></p>
                    <p><?php echo eSelectOption($this, 'categoryId', 'Category', buildCategoriesList('Select all Categories.'), $categoryId); ?></p>
                    <p><?php echo eTextField($this, 'noItem', 'Number of Post', $noItem, 'Number of posts to show. Default is: 5.'); ?></p>
                	<p><?php echo eSelectOption($this, 'ordering', 'Post Field to Order By', 
						array('id'=>'ID', 'title'=>'Title', 'comment_count'=>'Comment Count', 'post_date'=>'Published Date'), $ordering); ?></p>
                    <p><?php echo eSelectOption($this, 'orderingDirection', 'Ordering Direction', 
						array('asc'=>'Ascending', 'desc'=>'Descending'), $orderingDirection, 
						'Select the direction you would like Articles to be ordered by.'); ?></p>
                    <p><?php echo eSelectOption($this, 'freeLicense', 'Use Free License', 
						array('yes'=>'Yes', 'no'=>'No'), $readmore); ?></p>
                </div>
                <!-- Advanced Block -->
                <div id="advanced" class="tcvn-telement">
                    <p><?php echo eSelectOption($this, 'postTitle', 'Post Title', 
						array('yes'=>'Show', 'no'=>'Hide'), $postTitle, 
						'Show post title.'); ?></p>
                    <p><?php echo eSelectOption($this, 'date', 'Date', 
						array('yes'=>'Show', 'no'=>'Hide'), $date, 
						'Select Show if you would like the date displayed.'); ?></p>
                    <p><?php echo eSelectOption($this, 'category', 'Category', 
						array('yes'=>'Show', 'no'=>'Hide'), $category, 
						'Select Show if you would like the category name displayed.'); ?></p>
                    <p><?php echo eSelectOption($this, 'author', 'Author', 
						array('yes'=>'Show', 'no'=>'Hide'), $author, 
						'Select Show if you would like the author (or author alias instead, if available) to be displayed.'); ?></p>
                    <p><?php echo eSelectOption($this, 'comment', 'Comment Count', 
						array('yes'=>'Show', 'no'=>'Hide'), $comment, 
						'Select Show if you would like the comment count displayed.'); ?></p>
                    <p><?php echo eSelectOption($this, 'showImage', 'Thumbnail Image', 
						array('yes'=>'Show', 'no'=>'Hide'), $showImage, 
						'Show thumbnail image of the post.'); ?></p>
                    <p><?php echo eTextField($this, 'thumbnailWidth', 'Thumbnail Image Width', $thumbnailWidth); ?></p>
                	<p><?php echo eTextField($this, 'thumbnailHeight', 'Thumbnail Image Height', $thumbnailHeight); ?></p>
                    <p><?php echo eSelectOption($this, 'showIntro', 'Introtext', 
						array('yes'=>'Show', 'no'=>'Hide'), $showIntro, 
						'Show intro text of the post.'); ?></p>
                    <p><?php echo eTextField($this, 'introLimit', 'Introtext Limit', $introLimit, 
						'Please enter in a numeric character limit value. The introtext will be trimmed to the number of characters you enter.'); ?></p>
                    <p><?php echo eSelectOption($this, 'showReadmore', 'Show "Read More"', 
						array('yes'=>'Show', 'no'=>'Hide'), $showReadmore, 
						'If set to Show, the Read more... Link will show if Main text has been provided for the Post.'); ?></p>
                </div>
            </div>
        </div>
		<script>
			jQuery(document).ready(function($){
				var prefix = '#tcvn-recentpost ';
				$(prefix + "li").click(function() {
					$(prefix + "li").removeClass('active');
					$(this).addClass("active");
					$(prefix + ".tcvn-telement").hide();
					
					var selectedTab = $(this).find("a").attr("href");
					$(prefix + selectedTab).show();
					
					return false;
				});
			});
        </script>
		<?php
	}
	
	function update($new_instance, $old_instance) 
	{
		return $new_instance;
	}
	
	function widget($args, $instance) 
	{
		extract($args);
		
		$title 			= getConfigValue($instance, 'title',		'');
		$categoryId		= getConfigValue($instance, 'categoryId',	'');
		$noItem			= getConfigValue($instance, 'noItem',		'5');
		$ordering		= getConfigValue($instance, 'ordering',		'id');
		$orderingDirection = getConfigValue($instance, 'orderingDirection',	'desc');
		$postTitle		= getConfigValue($instance, 'postTitle',	'yes');
		$date			= getConfigValue($instance, 'date',			'no');
		$showCategory	= getConfigValue($instance, 'category',		'no');
		$author			= getConfigValue($instance, 'author',		'no');
		$comment		= getConfigValue($instance, 'comment',		'no');
		$showIntro		= getConfigValue($instance, 'showIntro',	'no');
		$showImage		= getConfigValue($instance, 'showImage',	'no');
		$thumbnailWidth	 = getConfigValue($instance, 'thumbnailWidth',	'100');
		$thumbnailHeight = getConfigValue($instance, 'thumbnailHeight',	'100');
		$introLimit		= getConfigValue($instance, 'introLimit',	'250');
		$showReadmore	= getConfigValue($instance, 'showReadmore',	'no');
		$freeLicense	= getConfigValue($instance, 'freeLicense',	'yes');
		
		$params = array(
			'numberposts' 	=> $noItem, 
			'category' 		=> $categoryId, 
			'orderby' 		=> $order,
			'order' 		=> $orderingDirection,
		);
		
		if($categoryId == '') {
			$params = array(
				'numberposts' 	=> $noItem, 
				'orderby' 		=> $order,
				'order' 		=> $orderingDirection,
			);
		}
		
		$posts = get_posts($params);
		
		echo $before_widget;
		
		if($title) echo $before_title . $title . $after_title;
		
		if(!empty($posts)) : 
		?>
        <div id="tcvn-post-widget">
        	<ul class="menu">
        	<?php
				$i = 0;
				foreach($posts as $post) : 
				$thumbnailId 	= get_post_thumbnail_id($post->ID);				
				$thumbnail 		= wp_get_attachment_image_src($thumbnailId , '70x45');	
				$altText 		= get_post_meta($thumbnailId , '_wp_attachment_image_alt', true);
				$commentsNum 	= get_comments_number($post->ID);
				$category 		= get_the_category($post);
				$image 			= TCVN_RECENTPOST_INC_URI . '/timthumb.php?w='.$thumbnailWidth.'&h='.$thumbnailHeight.'&a=c&q=99&z=0&src=';
				$text   		= explode('<!--more-->', $post->post_content);
				$sumary = $text[0];
			?>
            	<li class="<?php echo ($i) ? 'odd' : 'event'; ?>">
                    <a class="title" href="<?php echo get_permalink($post->ID); ?>"> 
                        <?php echo $post->post_title; ?> 
                    </a>
                    
                    <?php if($showIntro == 'yes' || $showImage == 'yes') : ?>
                    <div class="post-introtext">
                    	<!-- show image -->
						<?php if(!empty($thumbnail) && $showImage == 'yes') : ?>
                        <a class="img-box1" href="<?php echo get_permalink($post->ID); ?>">
                        	<?php echo '<img src="' . $image.$thumbnail[0] . '" alt="'. $altText .'"/>'; ?>
                        </a>
                        <?php endif; ?>
						
						<div class="post-info">
                            <!-- show date -->
                            <?php if($date == 'yes') : ?>
                            <span class="date"><?php echo date(get_option('date_format'), strtotime($post->post_date)); ?></span>
                            <?php endif; ?>
                            
                            <!-- show category -->
                            <?php if($showCategory == 'yes') : ?>
                            <span class="category">
                                <?php _e(' in:'); ?>
                                <a href="<?php echo get_category_link($category[0]->cat_ID); ?>">
                                    <?php echo $category[0]->cat_name; ?>
                                </a>
                            </span>
                            <?php endif; ?>
                            
                            <!-- show author -->
                            <?php if($author == 'yes') : ?>
                            <span class="author"><?php _e('by:'); ?> <?php echo get_userdata($post->post_author)->user_login; ?></span>
                            <?php endif; ?>
						</div>
						
                        <!-- show introtext -->
						<?php if($showIntro == 'yes') : ?>
                    	<?php echo $sumary; ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($comment == 'yes' || $showReadmore == 'yes') : ?>
                    <div class="post-extra">
                        <!-- show comment -->
						<?php if($comment == 'yes') : ?>
                        <span class="comment">
                            <?php echo ($commentsNum > 1) ? $commentsNum . ' Comments' : $commentsNum . ' Comment'; ?>
                        </span>
                        <?php endif; ?>
                        <!-- show readmore -->
                        <?php if($showReadmore == 'yes') : ?>
                        <span class="readmore">
                        	<a class="readmore" href="<?php echo get_permalink($post->ID); ?>"><?php _e('Readmore  &rarr;'); ?></a>
                        </span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </li>
            <?php $i = 1 - $i; endforeach; ?>
            </ul>
        </div>
        <?php if($freeLicense == 'yes') : ?>
        <div id="tcvn-copyright">
        	<a href="http://vinathemes.biz" title="Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz">Free download Wordpress Themes, Wordpress Plugins - VinaThemes.biz</a>
        </div>
        <?php endif; ?>
		<?php
		endif;
		
		echo $after_widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("RecentPost_Widget");'));
wp_enqueue_style('tcvn-recentpost-css', TCVN_RECENTPOST_INC_URI . '/css/style.css', '', '1.0', 'screen' );
wp_enqueue_style('tcvn-recentpost-admin-css', TCVN_RECENTPOST_INC_URI . '/admin/css/style.css', '', '1.0', 'screen' );
wp_enqueue_script('tcvn-tooltips', TCVN_RECENTPOST_INC_URI . '/admin/js/jquery.simpletip-1.3.1.js', 'jquery', '1.0', true);
?>