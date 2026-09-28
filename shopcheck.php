<?php
require_once __DIR__ . '/wp-load.php';
global $wpdb;

echo '<style>body{font-family:sans-serif;padding:30px;max-width:900px;} .ok{color:green;font-weight:bold;} .bad{color:red;font-weight:bold;} table{width:100%;border-collapse:collapse;margin:10px 0;} td,th{border:1px solid #ddd;padding:8px;font-size:13px;}</style>';

// WooCommerce shop page setting
$wc_shop_id = wc_get_page_id('shop');
echo '<h3>WooCommerce Shop Page Setting</h3>';
echo '<p>WC shop page ID: <strong>'.$wc_shop_id.'</strong></p>';
if($wc_shop_id > 0){
    $shop_page = get_post($wc_shop_id);
    echo '<p>Title: <strong>'.esc_html($shop_page->post_title).'</strong> | Slug: <strong>'.esc_html($shop_page->post_name).'</strong> | Status: <strong>'.esc_html($shop_page->post_status).'</strong></p>';
    echo '<p>Template: <strong>'.get_post_meta($wc_shop_id,'_wp_page_template',true).'</strong></p>';
    echo '<p>URL: <a href="'.get_permalink($wc_shop_id).'" target="_blank">'.get_permalink($wc_shop_id).'</a></p>';
}

// All shop-related pages
echo '<h3>All Pages</h3><table><tr><th>ID</th><th>Title</th><th>Slug</th><th>Status</th><th>Template</th></tr>';
$pages = get_posts(array('post_type'=>'page','post_status'=>'any','numberposts'=>-1));
foreach($pages as $p){
    $t = get_post_meta($p->ID,'_wp_page_template',true);
    echo '<tr><td>'.$p->ID.'</td><td>'.esc_html($p->post_title).'</td><td>'.esc_html($p->post_name).'</td><td>'.esc_html($p->post_status).'</td><td>'.esc_html($t).'</td></tr>';
}
echo '</table>';

// WooCommerce options
echo '<h3>WooCommerce Page Options</h3>';
echo '<p>woocommerce_shop_page_id: <strong>'.get_option('woocommerce_shop_page_id').'</strong></p>';
echo '<p>woocommerce_cart_page_id: <strong>'.get_option('woocommerce_cart_page_id').'</strong></p>';
echo '<p>woocommerce_checkout_page_id: <strong>'.get_option('woocommerce_checkout_page_id').'</strong></p>';
echo '<p>woocommerce_myaccount_page_id: <strong>'.get_option('woocommerce_myaccount_page_id').'</strong></p>';

// Permalink
echo '<h3>Permalink Structure</h3>';
echo '<p>'.get_option('permalink_structure').'</p>';

echo '<hr><p style="color:red;font-weight:bold;">DELETE this file after use!</p>';
