<?php 
/**
 * syntherabio Theme Customizer support
 *
 * @package Theme Horse
 * @subpackage syntherabio
 * @since syntherabio 1.0
 */
?>
<?php
/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since syntherabio 1.0
 *
 */
if ( ! class_exists( 'WP_Customize_Section' ) ) {
	return null;
}

function syntherabio_textarea_register($wp_customize){
	class syntherabio_Customize_syntherabio_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
		<div class="theme-info">
			<a title="<?php esc_attr_e( 'Review syntherabio', 'syntherabio' ); ?>" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/syntherabio' ); ?>" target="_blank" rel="noopener noreferrer">
			<?php _e( 'Rate syntherabio', 'syntherabio' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/theme-instruction/syntherabio/' ); ?>" title="<?php esc_attr_e( 'syntherabio Theme Instructions', 'syntherabio' ); ?>" target="_blank" rel="noopener noreferrer">
			<?php _e( 'Theme Instructions', 'syntherabio' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/support-forum/' ); ?>" title="<?php esc_attr_e( 'Support Forum', 'superior' ); ?>" target="_blank" rel="noopener noreferrer">
			<?php _e( 'Support Forum', 'superior' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/preview/syntherabio/' ); ?>" title="<?php esc_attr_e( 'syntherabio Demo', 'syntherabio' ); ?>" target="_blank" rel="noopener noreferrer">
			<?php _e( 'View Demo', 'syntherabio' ); ?>
			</a>
		</div>
		<?php
		}
	}
	class syntherabio_Customize_Category_Control extends WP_Customize_Control {
		/**
		* The type of customize control being rendered.
		*/
		public $type = 'multiple-select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $syntherabio_settings, $syntherabio_array_of_default_settings;
		$syntherabio_settings = wp_parse_args(  get_option( 'syntherabio_theme_settings', array() ),  syntherabio_get_option_defaults());
		$categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> multiple="multiple">
				<?php
					foreach ( $categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $syntherabio_settings[ 'syntherabio_categories' ]) ) { echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php 
		}
	}
}
/**
 * Upsell customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class syntherabio_Customize_Section_Upsell extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'upsell';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_text = '';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $pro_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}

				<# if ( data.pro_text && data.pro_url ) { #>
					<a href="{{ data.pro_url }}" class="upgrade-to-pro" target="_blank" rel="noopener noreferrer">{{ data.pro_text }}</a>
				<# } #>
			</h3>
		</li>
	<?php }
}
function syntherabio_customize_register($wp_customize){
	$wp_customize->add_panel( 'syntherabio_theme_settings', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'title'          => __('syntherabio Theme Options', 'syntherabio')
	));
	global $syntherabio_settings, $syntherabio_array_of_default_settings;
	$syntherabio_settings = wp_parse_args(  get_option( 'syntherabio_theme_settings', array() ),  syntherabio_get_option_defaults());
/********************syntherabio Upgrade ******************************************/
	$wp_customize->add_section('syntherabio_upgrade', array(
		'title'					=> __('syntherabio Support', 'syntherabio'),
		'priority'				=> 500,
	));
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new syntherabio_Customize_syntherabio_upgrade(
		$wp_customize,
		'syntherabio_upgrade',
			array(
				'label'					=> __('syntherabio Upgrade','syntherabio'),
				'section'				=> 'syntherabio_upgrade',
				'settings'				=> 'syntherabio_theme_settings[syntherabio_upgrade]',
			)
		)
	);
	/********************Layout Options ******************************************/
	$wp_customize->add_section('syntherabio_layout_options', array(
		'title'					=> __('Layout Options', 'syntherabio'),
		'priority'				=> 110,
		'panel'					=>'syntherabio_theme_settings'
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_design_layout]', array(
		'default'				=> 'on',
		'sanitize_callback'	=> 'syntherabio_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_theme_settings[syntherabio_design_layout]', array(
		'label'					=> __('Site Layout','syntherabio'),
		'section'				=> 'syntherabio_layout_options',
		'settings'				=> 'syntherabio_theme_settings[syntherabio_design_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'on'					=> __('Wide Layout','syntherabio'),
			'off'					=> __('Narrow Layout','syntherabio'),
		),
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_content_layout]', array(
		'default'				=> 'right',
		'sanitize_callback'	=> 'syntherabio_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_theme_settings[syntherabio_content_layout]', array(
		'label'					=> __('Content Layout','syntherabio'),
		'description'			=> __('Below options are global setting. Set individual layout from specific page/ post.','syntherabio'),
		'section'				=> 'syntherabio_layout_options',
		'settings'				=> 'syntherabio_theme_settings[syntherabio_content_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'right'				=> __('Right Sidebar','syntherabio'),
			'left'				=> __('Left Sidebar','syntherabio'),
			'nosidebar'			=> __('No Sidebar','syntherabio'),
			'fullwidth'			=> __('No Sidebar Full Width','syntherabio'),
		),
	));
	/********************Custom Header ******************************************/
	$wp_customize->add_section('syntherabio_custom_header_setting', array(
		'title'					=> __('Header Options', 'syntherabio'),
		'priority'				=> 120,
		'panel'					=>'syntherabio_theme_settings'
	));
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio_site_title_setting]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'syntherabio_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_site_title_setting', array(
		'label'					=> __('Check to disable', 'syntherabio'),
		'section'				=> 'syntherabio_custom_header_setting',
		'settings'				=> 'syntherabio_theme_settings[syntherabio_site_title_setting]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio-img-upload-site-title]',array(
		'sanitize_callback'	=> 'esc_url_raw',
		'panel'					=>'syntherabio_theme_settings',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
			'syntherabio-img-upload-site-title',
			array(
			'label'				=> __('Post/Page Title Background Image','syntherabio'),
			'section'			=> 'syntherabio_custom_header_setting',
			'settings'			=> 'syntherabio_theme_settings[syntherabio-img-upload-site-title]',
			)
		)
	);
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_header_settings]', array(
		'default'				=> 'header_text',
		'sanitize_callback'	=> 'syntherabio_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_theme_settings[syntherabio_header_settings]', array(
		'label'					=> __('Display Site Title', 'syntherabio'),
		'section'				=> 'syntherabio_custom_header_setting',
		'settings'				=> 'syntherabio_theme_settings[syntherabio_header_settings]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
			'choices'			=> array(
			'header_text'		=> __('Header Text Only','syntherabio'),
			'header_logo'		=> __('Header Logo Only','syntherabio'),
			'disable_both'		=> __('Disable Both','syntherabio'),
			),
	));
/********************Home Page Blog Category Setting ******************************************/
	$wp_customize->add_section(
		'syntherabio_category_section', array(
		'title' 						=> __('Home Page Blog Category Setting','syntherabio'),
		'description'				=> __('Only posts that belong to the categories selected here will be displayed on the front page. ( You may select multiple categories by holding down the Ctrl/Command key. ) ','syntherabio'),
		'priority'					=> 160,
		'panel'					=>'syntherabio_theme_settings'
	));
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio_categories]', array(
		'default'					=>array(),
		'sanitize_callback'		=> 'syntherabio_sanitize_category',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new syntherabio_Customize_Category_Control(
		$wp_customize,
			'syntherabio_theme_settings[syntherabio_categories]',
			array(
			'label'					=> __('Front page posts categories','syntherabio'),
			'section'				=> 'syntherabio_category_section',
			'settings'				=> 'syntherabio_theme_settings[syntherabio_categories]',
			'type'					=> 'multiple-select',
			)
		)
	);
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio_disable_setting]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_disable_setting', array(
		'label'						=> __('Check to Default Settings', 'syntherabio'),
		'section'					=> 'syntherabio_category_section',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_disable_setting]',
		'type'						=> 'checkbox',
	));
	/********************Featured Slider Options ******************************************************/
	$wp_customize->add_section( 'syntherabio_slider_options_setting', array(
		'title'					=> __('Featured Slider Options', 'syntherabio'),
		'priority'				=> 200,
		'panel'					=>'syntherabio_theme_settings'
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_slider_quantity]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'syntherabio_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_slider_quantity', array(
		'priority'					=>60,
		'label'						=> __('Number of Slides', 'syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_slider_quantity]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_transition_effect]', array(
		'default'					=> 'fade',
		'sanitize_callback'		=> 'syntherabio_sanitize_effect',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_transition_effect', array(
		'priority'					=>70,
		'label'						=> __('Transition Effect', 'syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_transition_effect]',
		'type'						=> 'select',
		'choices'					=> array(
			'fade'					=> __('Fade','syntherabio'),
			'wipe'					=> __('Wipe','syntherabio'),
			'scrollUp'				=> __('Scroll Up','syntherabio' ),
			'scrollDown'			=> __('Scroll Down','syntherabio' ),
			'scrollLeft'			=> __('Scroll Left','syntherabio' ),
			'scrollRight'			=> __('Scroll Right','syntherabio' ),
			'blindX'					=> __('Blind X','syntherabio' ),
			'blindY'					=> __('Blind Y','syntherabio' ),
			'blindZ'					=> __('Blind Z','syntherabio' ),
			'cover'					=> __('Cover','syntherabio' ),
			'shuffle'				=> __('Shuffle','syntherabio' ),
		),
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_transition_delay]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'syntherabio_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_transition_delay', array(
		'priority'					=>80,
		'label'						=> __('Transition Delay', 'syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_transition_delay]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_transition_duration]', array(
		'default'					=> '1',
		'sanitize_callback'		=> 'syntherabio_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('syntherabio_transition_duration', array(
		'priority'					=>90,
		'label'						=> __('Transition Length', 'syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_transition_duration]',
		'type'						=> 'text',
	) );
	// featured post
	for ( $i=1; $i <= $syntherabio_settings['syntherabio_slider_quantity'] ; $i++ ) {
		$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_featured_post_slider]['. $i.']', array(
			'default'					=>'',
			'sanitize_callback'		=>'syntherabio_sanitize_integer',
			'type' 						=> 'option',
			'capability' 				=> 'manage_options'
		));
		$wp_customize->add_control( 'syntherabio_featured_post_slider]['. $i .']', array(
			'priority'					=> 10 . $i,
			'label'						=> __(' Enter Post ID #', 'syntherabio') . $i ,
			'section'					=> 'syntherabio_slider_options_setting',
			'settings'					=> 'syntherabio_theme_settings[syntherabio_featured_post_slider]['. $i .']',
			'type'						=> 'text',
		));
	}
	$wp_customize->add_setting( 'syntherabio_theme_settings[syntherabio_disable_slider]', array(
		'default'					=> 1,
		'sanitize_callback'		=> 'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_disable_slider', array(
		'priority'					=>270,
		'label'						=> __('Disable Slider', 'syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_disable_slider]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_exclude_slider_post]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_exclude_slider_post', array(
		'priority'					=>280,
		'label'						=> __('Check to exclude', 'syntherabio'),
		'description'				=>__('Exclude Slider post from Homepage posts?','syntherabio'),
		'section'					=> 'syntherabio_slider_options_setting',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_exclude_slider_post]',
		'type'						=> 'checkbox',
	));
	/******************** Post Meta Options  ***********************************/
	$wp_customize->add_section( 'syntherabio_post_meta_options', array(
		'title' 						=> __('Post Meta Display Options','syntherabio'),
		'priority'					=> 300,
		'panel'					=>'syntherabio_theme_settings'
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_post_category]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_post_category', array(
		'priority'					=>305,
		'label'						=> __('Disable Categories', 'syntherabio'),
		'section'					=> 'syntherabio_post_meta_options',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_post_category]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_post_author]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_post_author', array(
		'priority'					=>310,
		'label'						=> __('Disable Author', 'syntherabio'),
		'section'					=> 'syntherabio_post_meta_options',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_post_author]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_post_date]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_post_date', array(
		'priority'					=>320,
		'label'						=> __('Disable Date', 'syntherabio'),
		'section'					=> 'syntherabio_post_meta_options',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_post_date]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_post_comments]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_post_comments', array(
		'priority'					=>330,
		'label'						=> __('Disable Comment Link', 'syntherabio'),
		'section'					=> 'syntherabio_post_meta_options',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_post_comments]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('syntherabio_theme_settings[syntherabio_post_tags]', array(
		'default'					=>0,
		'sanitize_callback'		=>'syntherabio_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'syntherabio_post_tags', array(
		'priority'					=>350,
		'label'						=> __('Disable Tags', 'syntherabio'),
		'section'					=> 'syntherabio_post_meta_options',
		'settings'					=> 'syntherabio_theme_settings[syntherabio_post_tags]',
		'type'						=> 'checkbox',
	));
}
/********************Sanitize the values ******************************************/
function syntherabio_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
function syntherabio_sanitize_integer( $input) {
    return absint($input);
}
function syntherabio_sanitize_effect( $input ) {
	if ( ! in_array( $input, array( 'fade', 'wipe', 'scrollUp', 'scrollDown', 'scrollLeft', 'scrollRight', 'blindX', 'blindY', 'blindZ', 'cover', 'shuffle' ) ) ) {
		$input = 'fade';
	}
	return $input;
}
function syntherabio_sanitize_delay_transition( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}
function syntherabio_sanitize_category( $input ) {
	if ( $input != '' ) { 
		$args = array(
						'type'			=> 'post',
						'child_of'      => 0,
						'parent'        => '',
						'orderby'       => 'name',
						'order'         => 'ASC',
						'hide_empty'    => 0,
						'hierarchical'  => 0,
						'taxonomy'      => 'category',
					); 
		
		$categories = ( get_categories( $args ) );

		$category_list 	=	array();
		
		foreach ( $categories as $category )
			$category_list 	=	array_merge( $category_list, array( $category->term_id ) );

		if ( count( array_intersect( $input, $category_list ) ) == count( $input ) ) {
	    	return $input;
	    } 
	    else {
    		return '';
   		}
    }
    else {
    	return '';
    }
}
function syntherabio_customizer_control_scripts() {

	wp_enqueue_script(
		'syntherabio-customize-controls',
		get_template_directory_uri() . '/inc/admin/js/syntherabio_customizer.js',
		array(), '3.0',
		true
	);

	wp_enqueue_style( 'syntherabio-customize-controls',
	 get_template_directory_uri() . '/inc/admin/css/customize-controls.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'syntherabio_customizer_control_scripts', 0 );


function syntherabio_customize_custom_sections( $wp_customize ) {

	// Register custom section types.
	$wp_customize->register_section_type( 'syntherabio_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new syntherabio_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'syntherabio Pro', 'syntherabio' ),
				'pro_text' => esc_html__( 'Upgrade to Pro', 'syntherabio' ),
				'pro_url'  => 'http://themehorse.com/themes/syntherabio-pro',
				'priority' => 1,
			)
		)
	);

}

add_action( 'customize_register', 'syntherabio_customize_custom_sections');
add_action('customize_register', 'syntherabio_textarea_register');
add_action('customize_register', 'syntherabio_customize_register');
?>
