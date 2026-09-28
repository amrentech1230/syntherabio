<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
/****************************************************************************************/
add_action('widgets_init', 'superior_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function superior_widgets_init()
{
	// Registering main left sidebar
	register_sidebar(array(
		'name' => __('Left Sidebar', 'superior') ,
		'id' => 'superior_left_sidebar',
		'description' => __('Shows widgets at Left side.', 'superior') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	// Registering main right sidebar
	register_sidebar(array(
		'name' => __('Right Sidebar', 'superior') ,
		'id' => 'superior_right_sidebar',
		'description' => __('Shows widgets at Right side.', 'superior') ,
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
} ?>