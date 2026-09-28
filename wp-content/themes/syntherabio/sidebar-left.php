<?php
/**
 * Displays the left sidebar of the theme.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
<?php
// Calling the left sidebar
	if ( is_active_sidebar( 'superior_left_sidebar' ) ) :
		dynamic_sidebar( 'superior_left_sidebar' );
	endif;
?>
