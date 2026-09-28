<?php
/**
 * Superior Meta Boxes
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
 add_action( 'add_meta_boxes', 'superior_add_custom_box' );
/**
 * Add Meta Boxes.
 * 
 * Add Meta box in page and post post types.
 */ 
function superior_add_custom_box() {
	add_meta_box(
		'siderbar-layout',	//Unique ID
		__( 'Below setting will not reflect on Main Blog Layout', 'superior' ),	//Title
		'superior_sidebar_layout',	//Callback function
		'page'	//show metabox in pages
	); 
	add_meta_box(
		'siderbar-layout',	//Unique ID
		__( 'Select layout for this specific Post only', 'superior' ),	//Title
		'superior_sidebar_layout',	//Callback function
		'post'	//show metabox in posts
	);
}
/****************************************************************************************/
global $superior_sidebar_layout;
$superior_sidebar_layout = array(
							'default-sidebar' 		=> array(
															'id'			=> 'superior_sidebarlayout',
															'value' 		=> 'default',
															'label' 		=> __( 'Default Layout Set in Customizer', 'superior' ),
															'thumbnail' => ' '
															),
							'no-sidebar' 				=> array(
															'id'			=> 'superior_sidebarlayout',
															'value' 		=> 'no-sidebar',
															'label' 		=> __( 'No sidebar', 'superior' ),				
															), 
							'no-sidebar-full-width' => array(
															'id'			=> 'superior_sidebarlayout',
															'value' 		=> 'no-sidebar-full-width',
															'label' 		=> __( 'No sidebar, Full Width', 'superior' ),
															),
							
							'left-sidebar' => array(
															'id'			=> 'superior_sidebarlayout',
															'value' 		=> 'left-sidebar',
															'label' 		=> __( 'Left sidebar', 'superior' ),	
															),
							'right-sidebar' => array(
															'id' 			=> 'superior_sidebarlayout',
															'value' 		=> 'right-sidebar',
															'label' 		=> __( 'Right sidebar', 'superior' ),
															)
						);
/****************************************************************************************/
/**
 * Displays metabox to for sidebar layout
 */
function superior_sidebar_layout() {
	global $superior_sidebar_layout, $post;
	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'custom_meta_box_nonce' );	// for security purpose
	// Begin the field table and loop  ?>
<table id="sidebar-metabox" class="form-table" width="100%">
	<tbody>
		<tr>
			<?php
				foreach ($superior_sidebar_layout as $field) {
					$meta = get_post_meta( $post->ID, $field['id'], true );
					if(empty( $meta ) ){
						$meta='default';
					} ?>
			<td>
				<label class="description">
					<input type="radio" name="<?php echo esc_attr($field['id']); ?>" value="<?php echo esc_attr($field['value']); ?>" <?php checked( esc_attr($field['value']), $meta ); ?>/>
					&nbsp;&nbsp;<?php echo esc_html($field['label']); ?>
				</label>
			</td>
				<?php
				}	// end foreach ?>
		</tr>
	</tbody>
</table>
<?php 
}
/****************************************************************************************/
add_action('save_post', 'superior_save_custom_meta');
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function superior_save_custom_meta( $post_id ) {
	global $superior_sidebar_layout, $post;
	// Verify the nonce before proceeding.
	if ( !isset( $_POST[ 'custom_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'custom_meta_box_nonce' ], basename( __FILE__ ) ) )
      return;
	// Stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
      return;
	if ('page' == $_POST['post_type']) {
      if (!current_user_can( 'edit_page', $post_id ) )
         return $post_id;  
	}
   elseif (!current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
	}
	foreach ($superior_sidebar_layout as $field) {
		//Execute this saving function
		$old = get_post_meta( $post_id, $field['id'], true);
		$new = sanitize_key($_POST[$field['id']]);
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach   
}
?>
