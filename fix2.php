<?php
require_once __DIR__ . '/wp-load.php';

// 1. Delete any existing account page and recreate clean
$existing = get_page_by_path('account');
if($existing) {
    wp_delete_post($existing->ID, true);
}

// 2. Create fresh account page
$page_id = wp_insert_post(array(
    'post_title'     => 'Account',
    'post_name'      => 'account',
    'post_content'   => '',
    'post_status'    => 'publish',
    'post_type'      => 'page',
    'post_author'    => 1,
    'comment_status' => 'closed',
));

update_post_meta($page_id, '_wp_page_template', 'page-account.php');

// 3. Hard flush rewrite rules
global $wp_rewrite;
$wp_rewrite->set_permalink_structure('/%postname%/');
$wp_rewrite->flush_rules(true);
update_option('rewrite_rules', '');

echo 'Done. Page ID: ' . $page_id . '<br>';
echo 'URL: <a href="' . get_permalink($page_id) . '">' . get_permalink($page_id) . '</a><br>';
echo 'Template: ' . get_post_meta($page_id, '_wp_page_template', true) . '<br>';
echo 'Permalink structure: ' . get_option('permalink_structure') . '<br>';
echo '<br><strong style="color:red">DELETE this file now!</strong>';
