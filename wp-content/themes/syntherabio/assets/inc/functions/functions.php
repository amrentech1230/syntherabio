<?php
/**
 * Superior functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
/****************************************************************************************/
add_action('wp_enqueue_scripts', 'superior_scripts_styles_method');
/**
 * Register jquery scripts
 */
function superior_scripts_styles_method() {
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	/**
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style('superior_style', get_stylesheet_uri());
	wp_enqueue_style('superior-font-awesome', get_template_directory_uri().'/font-awesome/css/all.min.css');
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_register_script('jquery_cycle', get_template_directory_uri().'/js/jquery.cycle.all.js', array('jquery'), '3.0.3', true);
	$superior_google_font_loads = array();
	array_push( $superior_google_font_loads, 'Lato:400,300,700');
	array_push( $superior_google_font_loads, 'Playfair+Display');
	$superior_google_font_load = implode("|", $superior_google_font_loads);
	wp_register_style( 'superior_google_fonts', '//fonts.googleapis.com/css?family='.$superior_google_font_load .'');
  	wp_enqueue_style( 'superior_google_fonts' );
	/**
	 * Enqueue Scripts js file.
	 * Enqueue Slider setup js file.
	 */
	if ((is_front_page()) && 1 != $superior_settings['superior_disable_slider']) {
		wp_enqueue_script('superior_slider', get_template_directory_uri().'/js/superior-slider-setting.js', array('jquery_cycle'), false, true);
	}
	wp_enqueue_script('superior_scripts', get_template_directory_uri().'/js/scripts.js', array('jquery'), false, true);
}
/****************************************************************************************/
add_filter('wp_page_menu', 'superior_wp_page_menu');
/**
 * Remove div from wp_page_menu() and replace with ul.
 * @uses wp_page_menu filter
 */
function superior_wp_page_menu($page_markup) {
	preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
	$divclass   = $matches[1];
	$replace    = array('<div class="'.$divclass.'">', '</div>');
	$new_markup = str_replace($replace, '', $page_markup);
	$new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
	return $new_markup;
}
/****************************************************************************************/
if (!function_exists('superior_pass_slider_effect_cycle_parameters')):
/**
 *Functions that Passes slider effect  parameters from php files to jquery file.
 */
function superior_pass_slider_effect_cycle_parameters() {
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	$transition_effect   = $superior_settings['superior_transition_effect'];
	$transition_delay    = $superior_settings['superior_transition_delay']*1000;
	$transition_duration = $superior_settings['superior_transition_duration']*1000;
	wp_localize_script(
		'superior_slider',
		'superior_slider_value',
		array(
			'transition_effect'   => $transition_effect,
			'transition_delay'    => $transition_delay,
			'transition_duration' => $transition_duration,
		)
	);
}
endif;
/****************************************************************************************/
add_filter('excerpt_length', 'superior_excerpt_length');
/**
 * Sets the post excerpt length to 50 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function superior_excerpt_length($length) {
	return 50;// this will return 50 words in the excerpt
}
add_filter('excerpt_more', 'superior_continue_reading');
/**
 * Returns a "Continue Reading" link for excerpts
 */
function superior_continue_reading() {
	return '&hellip; ';
}
/****************************************************************************************/
add_action('pre_get_posts', 'superior_alter_home');
/**
 * Alter the query for the main loop in home page
 *
 * @uses pre_get_posts hook
 */
function superior_alter_home($query) {
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	$superior_disable_setting = $superior_settings['superior_disable_setting'];
	if ($superior_settings['superior_exclude_slider_post'] != 0 && !empty($superior_settings['superior_featured_post_slider'])) {
		if ($query->is_main_query() && $query->is_home()) {
			$query->query_vars['post__not_in'] = $superior_settings['superior_featured_post_slider'];
		}
	}
	if ( $superior_disable_setting == 0 ) {
		$catID = $superior_settings['superior_categories'];
			if ( is_array( $catID ) && !in_array( '0', $catID ) ) {
				if( $query->is_main_query() && $query->is_home() ) {
					$query->query_vars['category__in'] = $superior_settings['superior_categories'];
				}
			}
	}
}
/****************************************************************************************/
add_filter('wp_page_menu', 'superior_wp_page_menu_filter');
/**
 * @uses wp_page_menu filter hook
 */
if (!function_exists('superior_wp_page_menu_filter')) {
	function superior_wp_page_menu_filter($text) {
		$replace = array(
			'current_page_item' => 'current-menu-item',
		);
		$text = str_replace(array_keys($replace), $replace, $text);
		return $text;
	}
}
/****************************************************************************************/
add_filter('body_class', 'superior_body_class');
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function superior_body_class($classes) {
	global $superior_site_layout, $superior_content_layout, $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	global $post;
	if ($post) {
		$layout = get_post_meta($post->ID, 'superior_sidebarlayout', true);
	}
	$superior_site_layout = $superior_settings['superior_design_layout'];
	$superior_content_layout = $superior_settings['superior_content_layout'];
	$frontpage_id = get_option('page_on_front'); // for front page
	$banner = get_post_meta( $frontpage_id, 'superior_sidebarlayout', true );
	$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
	$home_blog = get_post_meta( $page_id, 'superior_sidebarlayout', true ); 
	if (empty($layout) || is_archive() || is_search() || is_home()) {
		$layout = 'default';
	}
	if(!is_home() && !is_front_page() ):

		if ('default' == $layout) {
			$themeoption_layout = $superior_content_layout;
			if ('left' == $themeoption_layout) {
				$classes[] = 'left-sidebar-layout';
			}
			elseif ('right' == $themeoption_layout) {
				$classes[] = '';
			}
			elseif ('fullwidth' == $themeoption_layout) {
				$classes[] = 'full-width-layout';
			}
			elseif ('nosidebar' == $themeoption_layout) {
				$classes[] = 'no-sidebar-layout';
			}
		}elseif ('left-sidebar' == $layout) {

		$classes[] = 'left-sidebar-layout';
		}
		elseif ('right-sidebar' == $layout) {
			$classes[] = '';//css blank
		}
		elseif ('no-sidebar-full-width' == $layout) {
			$classes[] = 'full-width-layout';
		}
		elseif ('no-sidebar' == $layout) {
			$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
		}
	endif;
	if ( ((is_home() || is_front_page()) && is_home()) || is_archive()){
		if(class_exists( 'WooCommerce' ) && is_shop()){
			$classes[] = '';
		}else{
			$classes[] = 'main-blog-layout';
		}
	}
	if ($superior_site_layout =='off') {

		$classes[] = 'narrow-layout';
	}
	if(is_front_page() && $banner){
		if ('default' == $banner) {
			$themeoption_layout = $superior_content_layout;
			if ('left' == $themeoption_layout) {
				$classes[] = 'left-sidebar-layout';
			}
			elseif ('right' == $themeoption_layout) {
				$classes[] = '';
			}
			elseif ('fullwidth' == $themeoption_layout) {
				$classes[] = 'full-width-layout';
			}
			elseif ('nosidebar' == $themeoption_layout) {
				$classes[] = 'no-sidebar-layout';
			}
		}elseif ('left-sidebar' == $banner) {

		$classes[] = 'left-sidebar-layout';
		}
		elseif ('right-sidebar' == $banner) {
			$classes[] = '';//css blank
		}
		elseif ('no-sidebar-full-width' == $banner) {
			$classes[] = 'full-width-layout';
		}
		elseif ('no-sidebar' == $banner) {
			$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
		}
	} elseif(is_front_page() ) {
		if ('default' == $layout) { 
			$themeoption_layout = $superior_content_layout;
			if ('left' == $themeoption_layout) {
				$classes[] = 'left-sidebar-layout';
			}
			elseif ('right' == $themeoption_layout) {
				$classes[] = '';
			}
			elseif ('fullwidth' == $themeoption_layout) {
				$classes[] = 'full-width-layout';
			}
			elseif ('nosidebar' == $themeoption_layout) {
				$classes[] = 'no-sidebar-layout';
			}
		}elseif ('left-sidebar' == $layout) {

		$classes[] = 'left-sidebar-layout';
		}
		elseif ('right-sidebar' == $layout) {
			$classes[] = '';//css blank
		}
		elseif ('no-sidebar-full-width' == $layout) {
			$classes[] = 'full-width-layout';
		}
		elseif ('no-sidebar' == $layout) {
			$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
		}
	} elseif(is_home()){
		if ('default' == $home_blog) {
			$themeoption_layout = $superior_content_layout;
			if ('left' == $themeoption_layout) {
				$classes[] = 'left-sidebar-layout';
			}
			elseif ('right' == $themeoption_layout) {
				$classes[] = '';
			}
			elseif ('fullwidth' == $themeoption_layout) {
				$classes[] = 'full-width-layout';
			}
			elseif ('nosidebar' == $themeoption_layout) {
				$classes[] = 'no-sidebar-layout';
			}
		}elseif ('left-sidebar' == $home_blog) {

		$classes[] = 'left-sidebar-layout';
		}
		elseif ('right-sidebar' == $home_blog) {
			$classes[] = '';//css blank
		}
		elseif ('no-sidebar-full-width' == $home_blog) {
			$classes[] = 'full-width-layout';
		}
		elseif ('no-sidebar' == $home_blog) {
			$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
		}
	}
	return $classes;
}
?>
