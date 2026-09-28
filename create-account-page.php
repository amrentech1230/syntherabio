<?php
/**
 * One-time setup script: creates Account page with My Account template
 * DELETE THIS FILE after running it once.
 * Access via: http://localhost/syntherabio/create-account-page.php
 */

define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';

// Security: only run if not already done
if ( get_page_by_path('account') ) {
    echo '<p style="font-family:sans-serif;color:green;">✓ Account page already exists. You can delete this file.</p>';
    exit;
}

// Create the Account page
$page_id = wp_insert_post( array(
    'post_title'   => 'Account',
    'post_name'    => 'account',
    'post_content' => '',
    'post_status'  => 'publish',
    'post_type'    => 'page',
    'post_author'  => 1,
) );

if ( is_wp_error( $page_id ) ) {
    echo '<p style="font-family:sans-serif;color:red;">✗ Error: ' . $page_id->get_error_message() . '</p>';
    exit;
}

// Assign the page-account.php template
update_post_meta( $page_id, '_wp_page_template', 'page-account.php' );

// Also create Wishlist page if missing
if ( ! get_page_by_path('wishlist') ) {
    $wishlist_id = wp_insert_post( array(
        'post_title'  => 'Wishlist',
        'post_name'   => 'wishlist',
        'post_content'=> '',
        'post_status' => 'publish',
        'post_type'   => 'page',
        'post_author' => 1,
    ) );
    if ( ! is_wp_error( $wishlist_id ) ) {
        update_post_meta( $wishlist_id, '_wp_page_template', 'page-wishlist.php' );
    }
}

echo '
<style>body{font-family:sans-serif;max-width:600px;margin:60px auto;padding:20px;}</style>
<h2 style="color:#009bb0;">✓ Pages Created Successfully</h2>
<ul>
  <li><strong>Account page</strong> (ID: ' . $page_id . ') → template: page-account.php</li>
  <li><strong>Wishlist page</strong> → template: page-wishlist.php</li>
</ul>
<p>URLs:</p>
<ul>
  <li><a href="' . home_url('/account') . '">' . home_url('/account') . '</a></li>
  <li><a href="' . home_url('/wishlist') . '">' . home_url('/wishlist') . '</a></li>
</ul>
<p style="color:red;font-weight:bold;">⚠ DELETE this file now: <code>create-account-page.php</code></p>
';
