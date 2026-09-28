<?php
/**
 * Adds footer structures.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/superior
 */
/****************************************************************************************/
add_action( 'superior_footer', 'superior_open_siteinfo_div', 20 );
/**
 * Opens the site generator div.
 */
function superior_open_siteinfo_div() { ?>
	<div class="site-info clearfix">
		<div class="container">
<?php }
/****************************************************************************************/
add_action( 'superior_footer', 'superior_socialnetworks', 25 );
/**
 * This function for social links display on footer
 *
 */
function superior_socialnetworks(){
	if ( has_nav_menu( 'social' ) ) : ?>
		<div class="social-profiles clearfix">
		<?php
					// Social links navigation menu.
					wp_nav_menu( array(
						'theme_location' 	=> 'social',
						'container' 		=> '',
						'depth'          	=> 1,
						'items_wrap'      => '<ul>%3$s</ul>',
						'link_before'    	=> '<span class="screen-reader-text">',
						'link_after'     	=> '</span>',
					) );
				?>
		</div><!-- .social-profiles -->
	<?php endif;
}
/****************************************************************************************/
add_action( 'superior_footer', 'superior_footer_info', 30 );
/**
 * function to show the footer info, copyright information
 */
function superior_footer_info() {      
	$output = '<div class="copyright">'.__( 'Copyright &copy;', 'superior' ).' '.superior_the_year().' '.superior_site_link().' | ' .superior_themehorse_privacy() .superior_themehorse_link().' | '.' ' .superior_wp_link() .'</div><!-- .copyright -->';
	echo $output;
}
/****************************************************************************************/
add_action( 'superior_footer', 'superior_close_siteinfo_div', 40 );
/**
 * Shows the back to top icon to go to top.
 */
function superior_close_siteinfo_div() { ?>
		</div><!-- .container -->
	</div><!-- .site-info -->
<?php }
/****************************************************************************************/
add_action( 'superior_footer', 'superior_backtotop_html', 45 );
/**
 * Shows the back to top icon to go to top.
 */
function superior_backtotop_html() { ?>
	<div class="back-to-top"><a title="<?php _e('Go to Top', 'superior');?>" href="#masthead"></a></div><!-- .back-to-top -->
<?php } ?>
