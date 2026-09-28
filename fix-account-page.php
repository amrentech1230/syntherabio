<?php
/**
 * Diagnostic + Fix script for Account page
 * Visit: http://localhost/syntherabio/fix-account-page.php
 * DELETE after use.
 */
require_once __DIR__ . '/wp-load.php';

echo '<style>body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:20px;} table{width:100%;border-collapse:collapse;} td,th{border:1px solid #ddd;padding:8px 12px;font-size:13px;} th{background:#f5f5f5;} .ok{color:green;font-weight:bold;} .bad{color:red;font-weight:bold;}</style>';
echo '<h2>Synthera — Page Diagnostic & Fix</h2>';

// Show all pages
echo '<h3>All Pages in Database</h3><table><tr><th>ID</th><th>Title</th><th>Slug</th><th>Status</th><th>Template</th><th>URL</th></tr>';
$pages = get_posts(array('post_type' => 'page', 'post_status' => 'any', 'numberposts' => -1));
foreach ($pages as $p) {
    $tpl = get_post_meta($p->ID, '_wp_page_template', true);
    echo '<tr><td>'.$p->ID.'</td><td>'.esc_html($p->post_title).'</td><td>'.esc_html($p->post_name).'</td><td>'.esc_html($p->post_status).'</td><td>'.esc_html($tpl ?: 'default').'</td><td><a href="'.get_permalink($p->ID).'" target="_blank">'.get_permalink($p->ID).'</a></td></tr>';
}
echo '</table>';

// Check/fix Account page
echo '<h3>Fix: Account Page</h3>';
$account_page = get_page_by_path('account');
if ($account_page) {
    echo '<p class="ok">✓ Account page exists (ID: '.$account_page->ID.', status: '.$account_page->post_status.')</p>';
    $tpl = get_post_meta($account_page->ID, '_wp_page_template', true);
    echo '<p>Current template: <strong>'.($tpl ?: 'default').'</strong></p>';
    // Force correct template and published status
    wp_update_post(array('ID' => $account_page->ID, 'post_status' => 'publish'));
    update_post_meta($account_page->ID, '_wp_page_template', 'page-account.php');
    echo '<p class="ok">✓ Forced template to page-account.php and status to publish</p>';
} else {
    echo '<p class="bad">✗ Account page NOT found — creating now...</p>';
    $id = wp_insert_post(array(
        'post_title'   => 'Account',
        'post_name'    => 'account',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => 1,
    ));
    if (!is_wp_error($id)) {
        update_post_meta($id, '_wp_page_template', 'page-account.php');
        echo '<p class="ok">✓ Created Account page (ID: '.$id.')</p>';
    } else {
        echo '<p class="bad">✗ Error: '.$id->get_error_message().'</p>';
    }
}

// Check/fix Wishlist page
echo '<h3>Fix: Wishlist Page</h3>';
$wishlist_page = get_page_by_path('wishlist');
if ($wishlist_page) {
    wp_update_post(array('ID' => $wishlist_page->ID, 'post_status' => 'publish'));
    update_post_meta($wishlist_page->ID, '_wp_page_template', 'page-wishlist.php');
    echo '<p class="ok">✓ Wishlist page exists and fixed (ID: '.$wishlist_page->ID.')</p>';
} else {
    $id = wp_insert_post(array(
        'post_title'  => 'Wishlist',
        'post_name'   => 'wishlist',
        'post_content'=> '',
        'post_status' => 'publish',
        'post_type'   => 'page',
        'post_author' => 1,
    ));
    if (!is_wp_error($id)) {
        update_post_meta($id, '_wp_page_template', 'page-wishlist.php');
        echo '<p class="ok">✓ Created Wishlist page (ID: '.$id.')</p>';
    }
}

// Flush rewrite rules
flush_rewrite_rules();
echo '<h3>Rewrite Rules</h3><p class="ok">✓ Rewrite rules flushed</p>';

// Show final URLs
echo '<h3>Your Pages</h3>';
$account  = get_page_by_path('account');
$wishlist = get_page_by_path('wishlist');
if ($account)  echo '<p>Account: <a href="'.get_permalink($account->ID).'" target="_blank">'.get_permalink($account->ID).'</a></p>';
if ($wishlist) echo '<p>Wishlist: <a href="'.get_permalink($wishlist->ID).'" target="_blank">'.get_permalink($wishlist->ID).'</a></p>';

echo '<hr><p style="color:red;font-weight:bold;">⚠ DELETE this file now: fix-account-page.php</p>';
