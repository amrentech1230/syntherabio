<?php
require_once __DIR__ . '/wp-load.php';

echo '<style>body{font-family:sans-serif;max-width:800px;margin:40px auto;padding:20px;} .ok{color:green;font-weight:bold;} .bad{color:red;font-weight:bold;} table{width:100%;border-collapse:collapse;margin-bottom:20px;} td,th{border:1px solid #ddd;padding:8px;font-size:13px;}</style>';
echo '<h2>Debug Info</h2>';

// 1. Show all pages
echo '<h3>All Pages</h3><table><tr><th>ID</th><th>Title</th><th>Slug</th><th>Status</th><th>Template</th></tr>';
$pages = get_posts(array('post_type'=>'page','post_status'=>'any','numberposts'=>-1));
foreach($pages as $p){
    $t = get_post_meta($p->ID,'_wp_page_template',true);
    echo '<tr><td>'.$p->ID.'</td><td>'.esc_html($p->post_title).'</td><td>'.esc_html($p->post_name).'</td><td>'.esc_html($p->post_status).'</td><td>'.esc_html($t).'</td></tr>';
}
echo '</table>';

// 2. Show home_url and site_url
echo '<p><strong>home_url:</strong> '.home_url().'</p>';
echo '<p><strong>site_url:</strong> '.site_url().'</p>';

// 3. Show permalink structure
echo '<p><strong>Permalink structure:</strong> '.get_option('permalink_structure').'</p>';

// 4. Check template file exists
$tpl_file = get_template_directory().'/page-account.php';
echo '<p><strong>Template file exists:</strong> '.(file_exists($tpl_file) ? '<span class="ok">YES</span>' : '<span class="bad">NO</span>').'</p>';

// 5. Force create/fix account page
$existing = get_page_by_path('account');
if($existing){
    wp_update_post(array('ID'=>$existing->ID,'post_status'=>'publish','post_name'=>'account'));
    update_post_meta($existing->ID,'_wp_page_template','page-account.php');
    echo '<p class="ok">✓ Account page fixed. ID: '.$existing->ID.' URL: <a href="'.get_permalink($existing->ID).'" target="_blank">'.get_permalink($existing->ID).'</a></p>';
} else {
    $new_id = wp_insert_post(array(
        'post_title'  =>'Account',
        'post_name'   =>'account',
        'post_content'=>'',
        'post_status' =>'publish',
        'post_type'   =>'page',
        'post_author' =>1,
    ));
    update_post_meta($new_id,'_wp_page_template','page-account.php');
    echo '<p class="ok">✓ Account page created. ID: '.$new_id.' URL: <a href="'.get_permalink($new_id).'" target="_blank">'.get_permalink($new_id).'</a></p>';
}

// 6. Flush rewrite rules
global $wp_rewrite;
$wp_rewrite->flush_rules(true);
echo '<p class="ok">✓ Rewrite rules flushed</p>';

echo '<hr><p style="color:red;font-weight:bold;">DELETE this file after use!</p>';
