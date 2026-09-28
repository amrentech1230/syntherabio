<?php
/**
 * WooCommerce archive-product override
 * Forces our custom page-shop.php to load instead
 */
$custom_template = locate_template( 'page-shop.php' );
if ( $custom_template ) {
    include $custom_template;
    return;
}
