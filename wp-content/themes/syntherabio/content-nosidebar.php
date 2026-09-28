<?php
/**
 * This file displays page with no sidebar.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
<?php
   /**
    * superior_before_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_loop_before 10
    */
   do_action( 'superior_before_loop_content' );
   /**
    * superior_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_theloop 10
    */
   do_action( 'superior_loop_content' );
   /**
    * superior_after_loop_content
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * superior_next_previous 5
	 * superior_loop_after 10
    */
   do_action( 'superior_after_loop_content' );
?>
