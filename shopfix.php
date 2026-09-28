<?php
require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo '<style>body{font-family:sans-serif;padding:30px;max-width:700px;} .ok{color:green;font-weight:bold;} .bad{color:red;font-weight:bold;}</style>';

// 1. Point WooCommerce shop page to ID 24 (the real published Shop page)
update_option('woocommerce_shop_page_id', 24);
echo '<p class="ok">✓ woocommerce_shop_page_id set to 24 (Shop / page-shop.php)</p>';

// 2. Fix cart page - ID 13 is correct
update_option('woocommerce_cart_page_id', 13);
echo '<p class="ok">✓ woocommerce_cart_page_id set to 13</p>';

// 3. Fix checkout page - ID 14 is correct
update_option('woocommerce_checkout_page_id', 14);
echo '<p class="ok">✓ woocommerce_checkout_page_id set to 14</p>';

// 4. Fix my account page - set to ID 67 (our new Account page)
update_option('woocommerce_myaccount_page_id', 67);
echo '<p class="ok">✓ woocommerce_myaccount_page_id set to 67 (Account / page-account.php)</p>';

// 5. Make sure shop page template is correct
update_post_meta(24, '_wp_page_template', 'page-shop.php');
echo '<p class="ok">✓ Shop page (ID 24) template set to page-shop.php</p>';

// 6. Make sure cart page template is correct
update_post_meta(13, '_wp_page_template', 'page-cart.php');
echo '<p class="ok">✓ Cart page (ID 13) template set to page-cart.php</p>';

// 7. Make sure checkout page has no custom template (use WooCommerce default)
update_post_meta(14, '_wp_page_template', 'default');
echo '<p class="ok">✓ Checkout page (ID 14) template set to default</p>';

// 8. Trash the duplicate my-account page (ID 56) to avoid conflicts
wp_trash_post(56);
echo '<p class="ok">✓ Duplicate My Account page (ID 56) trashed</p>';

// 9. Flush rewrite rules
global $wp_rewrite;
$wp_rewrite->flush_rules(true);
echo '<p class="ok">✓ Rewrite rules flushed</p>';

// 10. Clear WooCommerce transients
wc_delete_product_transients();
delete_transient('wc_products_onsale');
echo '<p class="ok">✓ WooCommerce transients cleared</p>';

echo '<h3>Verify URLs</h3>';
echo '<p>Shop: <a href="'.get_permalink(24).'" target="_blank">'.get_permalink(24).'</a></p>';
echo '<p>Cart: <a href="'.get_permalink(13).'" target="_blank">'.get_permalink(13).'</a></p>';
echo '<p>Checkout: <a href="'.get_permalink(14).'" target="_blank">'.get_permalink(14).'</a></p>';
echo '<p>Account: <a href="'.get_permalink(67).'" target="_blank">'.get_permalink(67).'</a></p>';
echo '<p>Wishlist: <a href="'.get_permalink(59).'" target="_blank">'.get_permalink(59).'</a></p>';

echo '<hr><p style="color:red;font-weight:bold;">✓ All done! DELETE this file now: shopcheck.php and shopfix.php</p>';
