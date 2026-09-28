<?php
/**
 * Displays the searchform of the theme.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form clearfix">
		<label class="assistive-text"> <?php _e( 'Search', 'superior' ); ?> </label>
		<input type="search" placeholder="<?php esc_attr_e( 'Search', 'superior' ); ?>" class="s field" name="s">
		<input type="submit" value="<?php esc_attr_e( 'Search', 'superior' ); ?>" class="search-submit">
	</form><!-- .search-form -->
