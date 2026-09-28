<?php
/**
 * Adds header structures.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/superior
 */
/****************************************************************************************/
add_action('superior_title', 'superior_viewport', 5);
/**
 * Add meta tags.
 */
function superior_viewport() { ?>
		<meta name="viewport" content="width=device-width">
<?php
}
/****************************************************************************************/
add_action('superior_header', 'superior_headercontent_details', 10);
/**
 * Shows Header content details
 *
 * Shows the site logo, title, description, searchbar, social icons and many more
 */
function superior_headercontent_details() {
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	$superior_header_image = get_header_image();
	if (!empty($superior_header_image)):?>
			<a href="<?php echo esc_url(home_url('/'));?>"><img src="<?php echo esc_url($superior_header_image);?>" class="header-image" width="<?php echo get_custom_header()->width;?>" height="<?php echo get_custom_header()->height;?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display'));?>"> 
			</a>
	<?php endif;?>
	<div class="hgroup-wrap">
		<div class="container clearfix">
		<?php $superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
			$header_display = $superior_settings['superior_header_settings'];
			if ($header_display != 'disable_both' && $header_display == 'header_text') { ?>
			<section id="site-logo" class="clearfix">
			<?php if(is_single() || !is_home()){ ?>
				<h2 id="site-title"> 
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
				</h2><!-- #site-title -->
				<?php } else { ?>
				<h1 id="site-title"> 
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
				</h1><!-- #site-title -->
				<?php }
				$site_description = get_bloginfo( 'description', 'display' );
				if($site_description){?>
					<h2 id="site-description"><?php bloginfo('description');?> </h2>
				<?php } ?>
			</section><!-- #site-logo -->
				<?php
			}	elseif ($header_display != 'disable_both' && $header_display == 'header_logo') {
				?>
				<section id="site-logo" class="clearfix">
				<?php if(is_single() || !is_home()){ ?>
				<h2 id="site-title">
				     <?php superior_the_custom_logo(); ?><!-- #site-logo -->
				</h2>
				<?php }else{ ?>
				<h1 id="site-title">
				     <?php superior_the_custom_logo(); ?><!-- #site-logo -->
				</h1>
				<?php } ?>
				</section>
			<?php }?>
			<button class="menu-toggle"><?php _e('Responsive Menu', 'superior' ); ?></button>
			<?php  
			if (has_nav_menu('primary')) {// if there is nav menu then content displayed from nav menu else from pages ?>
			<?php $args = array(
						'theme_location' => 'primary',
						'container'      => '',
						'items_wrap'     => '<ul class="nav-menu">%3$s</ul>',
					); ?>
			<section class="hgroup-right">
				<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
					<?php wp_nav_menu($args);//extract the content from apperance-> nav menu ?>
				</nav><!-- #access -->
			<?php } else {// extract the content from page menu only ?>
			<section class="hgroup-right">
				<nav id="site-navigation" class="main-navigation clearfix" role="navigation">
					<?php	wp_page_menu(array('menu_class' => 'nav-menu')); ?>
				</nav><!-- #access -->
					<?php	} 
				$search_form = $superior_settings['superior_search_header_settings'];
				if (1 != $search_form) { ?>
				<div class="search-toggle"></div><!-- .search-toggle -->
				<div id="search-box" class="hide">
					<?php get_search_form();?>
					<span class="arrow"></span>
				</div><!-- #search-box -->
				<?php } ?>
			</section><!-- .hgroup-right -->
		</div><!-- .container -->
	</div><!-- .hgroup-wrap -->
<?php global $superior_disable_slider;
	global $superior_settings;
	if (is_front_page()) {
		$superior_disable_slider = $superior_settings['superior_disable_slider'];
		if ($superior_disable_slider ==0) {
			if (function_exists('superior_pass_slider_effect_cycle_parameters')) {
				superior_pass_slider_effect_cycle_parameters();
			}
			if (function_exists('superior_featured_sliders')) {
				superior_featured_sliders();
			}
		}
	} else{
		if (('' != superior_header_title()) || function_exists('bcn_display_list')) {
			$sitetitle_img_setting = $superior_settings['superior_site_title_setting'];

			$sitetitle_image = $superior_settings['superior-img-upload-site-title']; ?>
			<div class="page-title-wrap" <?php if ( $sitetitle_img_setting != '1'  && $sitetitle_image != '' ){ ?> style="background-image:url('<?php echo esc_url($sitetitle_image);?>');" <?php } ?> >
				<div class="container clearfix">
				<?php if(is_home()){?>
					<h2 class="page-title"><?php echo superior_header_title();?></h2><!-- .page-title -->
				<?php } else { ?>
					<h1 class="page-title"><?php echo superior_header_title();?></h1><!-- .page-title -->
				<?php }
					if (function_exists('superior_breadcrumb')) {
						superior_breadcrumb();
					} ?>
				</div><!-- .container -->
			</div><!-- .page-title-wrap -->
		<?php
		}
	}
}
/****************************************************************************************/

if (!function_exists('superior_featured_sliders')):
/**
 * displaying the featured image in home page
 *
 */
function superior_featured_sliders() { 
	global $post;
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	$superior_featured_sliders = '';
	$get_featured_posts 		= new WP_Query(array(
		'posts_per_page'      	=> $superior_settings['superior_slider_quantity'],
		'post_type'           	=> array('post'),
		'post__in'            	=> $superior_settings['superior_featured_post_slider'],
		'orderby'             	=> 'post__in',
		'ignore_sticky_posts' 	=> 1
	));
	if($get_featured_posts->have_posts() || $superior_featured_sliders !=''){
		$slider_size = 'slider';
		$superior_featured_sliders 	.= '<section class="featured-slider"><div class="slider-cycle">';
		$i = 0;
		while ($get_featured_posts->have_posts()):$get_featured_posts->the_post();
					$i++;
					$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
					$excerpt               	 	 = get_the_excerpt();
					$categories = get_the_category();
					$attachment_id = get_post_thumbnail_id();
					$image_attributes = wp_get_attachment_image_src($attachment_id,'full'); // returns an array
					if (1 == $i) {$classes   	 = "slides clearfix displayblock";} else { $classes = "slides clearfix displaynone";}
			$superior_featured_sliders    	.= '<div class="'.$classes.' clearfix">';
			if ($image_attributes) {
				$superior_featured_sliders 	.= '<figure class="featured-slider-image">';
				$superior_featured_sliders 	.= '<a title="'.$title_attribute.'" href="'.esc_url(get_permalink()).'" style="'.'background-image:url('."'".esc_url($image_attributes[0])."'".');"></a>
				</figure><!-- .post-featured-image -->';
			}
			$superior_featured_sliders 	.= '<div class="featured-slider-content">';
			
			$superior_featured_sliders 	.= '<article><header class="entry-header">';
				if ($title_attribute != '' || $excerpt != '') {
					if ($title_attribute != '') {
						$superior_featured_sliders .= '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'" title="'.the_title('', '', false).'">'.esc_html(get_the_title()).'</a></h2><!-- .entry-title -->';
					}
					$superior_featured_sliders 	.= '</header><!-- .entry-header -->';
					$superior_featured_sliders 	.= '<div class="entry-content">';
					if ($excerpt != '') {
						$superior_featured_sliders .= '<p>'.esc_html($excerpt).'</p>';
					}
					$superior_featured_sliders 	.= '<div class="featured-slider-button"><a title='.__('"Continue Reading"','superior').' '.'href="'.esc_url(get_permalink()).'"'.' class="readmore">'.__('Continue Reading','superior').'</a></div><!-- .featured-slider-button -->';
					$superior_featured_sliders 	.= '</div><!-- .entry-content -->';
				}
				$superior_featured_sliders 	.= '</article></div><!-- .featured-slider-content -->';
				$superior_featured_sliders 	.= '</div><!-- .slides -->';
		endwhile;
				wp_reset_query();
				$superior_featured_sliders .= '</div>	<!-- .slider-cycle --><nav id="controllers" class="clearfix"></nav><!-- #controllers --></section><!-- .featured-slider -->';
	}
				echo $superior_featured_sliders;
}
endif;
/****************************************************************************************/
if (!function_exists('superior_breadcrumb')):
/**
 * Display breadcrumb on header.
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
 */
function superior_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
endif;
/****************************************************************************************/
if (!function_exists('superior_header_title')):
/**
 * Show the title in header
 *
 * @since Superior 1.0
 */
function superior_header_title() {
	if (is_archive()) {
		if( class_exists( 'WooCommerce' ) && is_woocommerce()){
			$superior_header_title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}else{
			$superior_header_title = get_the_archive_title('', FALSE);
		}
	} elseif (is_home()){
		$superior_header_title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif (is_404()) {
		$superior_header_title = __('Page NOT Found', 'superior');
	} elseif (is_search()) {
		$superior_header_title = __('Search Results', 'superior');
	} elseif (is_page_template()) {
		$superior_header_title = get_the_title();
	} else {
		$superior_header_title = get_the_title();
	}
	return $superior_header_title;
}
endif;
?>
