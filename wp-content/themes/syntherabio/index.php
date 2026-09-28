<?php
/**
 * Displays the index section of the theme.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
<?php get_header(); ?>
	<?php
		/** 
		 * superior_before_main_container hook
		 */
		do_action( 'superior_before_main_container' );
		/** 
		 * superior_main_container hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * superior_content 10
		 */
		do_action( 'superior_main_container' );
		/** 
		 * superior_after_main_container hook
		 */
		do_action( 'superior_after_main_container' );
	?>
<?php get_footer(); ?>
