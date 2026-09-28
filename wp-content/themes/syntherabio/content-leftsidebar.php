<?php
/**
 * This file displays page with left sidebar.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
	<?php
	/**
	 * superior_before_primary
	 */
	do_action('superior_before_primary');
	if (is_page() || is_single() || is_search()) :?>
	<div id="primary">
	  <?php
	endif;
	/**
	 * superior_before_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_loop_before 10
	 */
	do_action('superior_before_loop_content');
	/**
	 * superior_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_theloop 10
	 */
	do_action('superior_loop_content');
	/**
	 * superior_after_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_next_previous 5
	 * superior_loop_after 10
	 */
	do_action('superior_after_loop_content');
	if (is_page() || is_single() || is_search()) :?>
	</div><!-- #primary -->
	<?php
	endif;
	/**
	 * superior_after_primary
	 */
	do_action('superior_after_primary');
	if (is_page() || is_single() || is_search()) :?>
		<div id="secondary">
	<?php
		  if (is_page_template('page-templates/page-template-contact.php')) {
		  	get_sidebar( 'contact-page' );
		  }else{
			get_sidebar('left');
			} ?>
		</div><!-- #secondary -->
	<?php endif; ?>