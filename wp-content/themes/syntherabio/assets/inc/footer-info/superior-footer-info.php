<?php
/**
 * Contains all the current date, year of the theme.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
<?php
	/**
	 * To display the current year.
	 *
	 * @uses date() Gets the current year.
	 * @return string
	 */
	function superior_the_year() {
	   return date( 'Y' );
	}
	/**
	 * To display a link back to the site.
	 *
	 * @uses get_bloginfo() Gets the site link
	 * @return string
	 */
	function superior_site_link() {
	   return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	}
	/**
	 * To display a link to WordPress.org.
	 *
	 * @return string
	 */
	function superior_wp_link() {
	return sprintf( __('Proudly Powered by: %s', 'superior'), '<a href="' . esc_url( 'http://wordpress.org/', 'superior' ). '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__( 'WordPress', 'superior' ). '"><span>' . __( 'WordPress', 'superior' ) . '</span></a>');
	}
	/**
	 * To display a link to themehorse.com
	 *
	 * @return string
	 */
	function superior_themehorse_link() {
	return sprintf( __('Theme by: %s', 'superior'), '<a href="'.esc_url( 'http://themehorse.com','superior' ).'" target="_blank" rel="noopener noreferrer" title="' . esc_attr__( 'Theme Horse', 'superior' ).'" ><span>'. __( 'Theme Horse', 'superior' ) .'</span></a>');
	}

	/**
	 * To display a link to privacy policy.
	 *
	 * @return string
	 */
	function superior_themehorse_privacy() {
		if (function_exists('get_the_privacy_policy_link')) {
			return get_the_privacy_policy_link('', ' | ');
		}
	}
?>
