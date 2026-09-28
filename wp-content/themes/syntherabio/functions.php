<?php
// =============================================
// THEME SETUP
// =============================================

add_action('wp_ajax_send_contact_email', 'send_contact_email');
add_action('wp_ajax_nopriv_send_contact_email', 'send_contact_email');

function send_contact_email() {

    parse_str($_POST['formData'], $data);

    $to = "info@syntheratherapeutics.com";
    $subject = "Website Contact Form: " . $data['subject'];

    $message = "
    Name: {$data['name']}

    Email: {$data['email']}

    Inquiry: {$data['inquiry']}

    Message:
    {$data['message']}
    ";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/plain;charset=UTF-8\r\n";
    $headers .= "From: Synthera Therapeutics <no-reply@syntheratherapeutics.com>\r\n";
    $headers .= "Reply-To: {$data['email']}\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "success";
    } else {
        echo "failed";
    }

    wp_die();
}


function shop_scripts()
{
    wp_enqueue_script(
        'load-more',
        get_template_directory_uri().'/assets/js/load-more.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('load-more', 'shop_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'shop_scripts');

add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

function load_more_products()
{

    $page = intval($_POST['page']);

    $cat = intval($_POST['cat']);

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 9,
        'paged' => $page,
        'post_status' => 'publish'
    );

    if ($cat) {

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $cat
            )
        );

    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {

        while ($query->have_posts()) {

            $query->the_post();

            global $product;

            get_template_part('template-parts/product-card');

        }

    }

    wp_reset_postdata();

    wp_die();
}

function syntherabio_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    register_nav_menus( array( 'primary' => 'Primary Menu' ) );
}
add_action( 'after_setup_theme', 'syntherabio_setup' );

// =============================================
// ENQUEUE STYLES & SCRIPTS
// =============================================
function syntherabio_scripts() {
    wp_enqueue_style( 'syntherabio-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0' );
    wp_enqueue_style( 'syntherabio-woo', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), '1.0' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'syntherabio-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true );
    wp_localize_script( 'syntherabio-scripts', 'syntherabio_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'syntherabio_nonce' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'syntherabio_scripts' );

// =============================================
// WOOCOMMERCE: FORCE CUSTOM SHOP TEMPLATE
// =============================================

// Override WooCommerce archive-product.php with our page-shop.php
add_filter( 'woocommerce_template_loader_files', function( $templates, $default_file ) {
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id ) {
            $template = get_post_meta( $shop_page_id, '_wp_page_template', true );
            if ( $template && $template !== 'default' && locate_template( $template ) ) {
                array_unshift( $templates, $template );
            }
        }
    }
    return $templates;
}, 10, 2 );

// Force page-shop.php to load for shop/category/tag archives
add_filter( 'template_include', function( $template ) {
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        $custom = locate_template( 'page-shop.php' );
        if ( $custom ) return $custom;
    }
    // Force single-product.php for product pages
    if ( is_product() ) {
        $custom = locate_template( 'single-product.php' );
        if ( $custom ) return $custom;
    }
    return $template;
}, 99 );

// Remove default WooCommerce wrappers (we handle layout ourselves)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_main_content', function() { echo '<div class="woo-wrapper">'; }, 10 );
add_action( 'woocommerce_after_main_content', function() { echo '</div>'; }, 10 );

// =============================================
// WOOCOMMERCE: CART COUNT IN HEADER
// =============================================
function syntherabio_cart_count() {
    if ( function_exists( 'WC' ) ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

// AJAX: Update cart fragments
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $count = WC()->cart->get_cart_contents_count();
    $fragments['.cart-count'] = '<span class="cart-count">' . $count . '</span>';
    return $fragments;
});

// =============================================
// WISHLIST FUNCTIONALITY
// =============================================
function syntherabio_get_wishlist() {
    return isset( $_COOKIE['syntherabio_wishlist'] ) ? json_decode( stripslashes( $_COOKIE['syntherabio_wishlist'] ), true ) : array();
}

// AJAX: Toggle wishlist
function syntherabio_toggle_wishlist() {
    check_ajax_referer( 'syntherabio_nonce', 'nonce' );
    $product_id = intval( $_POST['product_id'] );
    $wishlist   = syntherabio_get_wishlist();

    if ( in_array( $product_id, $wishlist ) ) {
        $wishlist = array_values( array_diff( $wishlist, array( $product_id ) ) );
        $action   = 'removed';
    } else {
        $wishlist[] = $product_id;
        $action     = 'added';
    }

    setcookie( 'syntherabio_wishlist', json_encode( $wishlist ), time() + ( 30 * DAY_IN_SECONDS ), '/' );
    wp_send_json_success( array( 'action' => $action, 'count' => count( $wishlist ) ) );
}
    add_action( 'wp_ajax_syntherabio_toggle_wishlist', 'syntherabio_toggle_wishlist' );
    add_action( 'wp_ajax_nopriv_syntherabio_toggle_wishlist', 'syntherabio_toggle_wishlist' );

// =============================================
// AJAX: LIVE SEARCH
// =============================================
function syntherabio_live_search() {
    $term = sanitize_text_field( $_POST['term'] ?? '' );
    if ( strlen( $term ) < 2 ) wp_send_json_success( array() );

    $query = new WP_Query( array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $term,
    ) );

    $results = array();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) continue;
            $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
            $results[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'price' => $product->get_price_html(),
                'img'   => ! empty( $img[0] ) ? $img[0] : wc_placeholder_img_src(),
                'cat'   => strip_tags( wc_get_product_category_list( get_the_ID() ) ),
            );
        }
        wp_reset_postdata();
    }
    wp_send_json_success( $results );
}
add_action( 'wp_ajax_syntherabio_live_search', 'syntherabio_live_search' );
add_action( 'wp_ajax_nopriv_syntherabio_live_search', 'syntherabio_live_search' );

// =============================================
// AJAX: LOAD MORE PRODUCTS
function syntherabio_load_more_products() {
    check_ajax_referer( 'syntherabio_nonce', 'nonce' );
    $paged    = intval( $_POST['page'] ) + 1;
    $cat_id   = intval( $_POST['cat_id'] );
    $orderby  = sanitize_text_field( $_POST['orderby'] ?? 'date' );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => $orderby,
    );

    if ( $cat_id ) {
        $args['tax_query'] = array( array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $cat_id,
        ));
    }

    $query = new WP_Query( $args );
    ob_start();

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            global $product;
            if ( ! $product ) continue;
            get_template_part( 'template-parts/product-card' );
        endwhile;
        wp_reset_postdata();
    endif;

    $html = ob_get_clean();
    wp_send_json_success( array( 'html' => $html, 'max_pages' => $query->max_num_pages ) );
}
add_action( 'wp_ajax_syntherabio_load_more', 'syntherabio_load_more_products' );
add_action( 'wp_ajax_nopriv_syntherabio_load_more', 'syntherabio_load_more_products' );

// =============================================
// WOOCOMMERCE: HANDLE CUSTOM ADD TO CART FORM
// =============================================
add_action( 'wp_loaded', function() {
    if ( isset( $_POST['add-to-cart'] ) && isset( $_POST['quantity'] ) ) {
        $product_id = absint( $_POST['add-to-cart'] );
        $quantity   = absint( $_POST['quantity'] );
        if ( $product_id && $quantity > 0 ) {
            WC()->cart->add_to_cart( $product_id, $quantity );
            wp_safe_redirect( wc_get_cart_url() );
            exit;
        }
    }
}, 20 );

// =============================================
// WOOCOMMERCE: REDIRECT AFTER LOGIN
// =============================================
add_filter( 'woocommerce_login_redirect', function( $redirect, $user ) {
    return home_url( '/account' );
}, 10, 2 );

// =============================================
// WOOCOMMERCE: CUSTOM CHECKOUT FIELDS
// =============================================
add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    unset( $fields['billing']['billing_company'] );
    return $fields;
});

// =============================================
// WOOCOMMERCE: DISABLE WOO CSS (we use our own)
// =============================================
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// =============================================
// REGISTER CUSTOM PAGES ON ACTIVATION
// =============================================
function syntherabio_create_pages() {
    $pages = array(
        'wishlist' => array( 'title' => 'Wishlist', 'template' => 'page-wishlist.php' ),
    );
    foreach ( $pages as $slug => $data ) {
        if ( ! get_page_by_path( $slug ) ) {
            $page_id = wp_insert_post( array(
                'post_title'  => $data['title'],
                'post_name'   => $slug,
                'post_status' => 'publish',
                'post_type'   => 'page',
            ));
            if ( $page_id && ! is_wp_error( $page_id ) ) {
                update_post_meta( $page_id, '_wp_page_template', $data['template'] );
            }
        }
    }
}
add_action( 'after_switch_theme', 'syntherabio_create_pages' );

// =============================================
// HELPER: PRODUCT CARD TEMPLATE TAG
// =============================================
function syntherabio_product_card( $product ) {
    if ( ! $product ) return;
    $product_id    = $product->get_id();
    $image         = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'large' );
    $product_image = ! empty( $image[0] ) ? $image[0] : wc_placeholder_img_src();
    $regular_price = $product->get_regular_price();
    $sale_price    = $product->get_sale_price();
    $short_desc    = $product->get_short_description();
    $wishlist      = syntherabio_get_wishlist();
    $in_wishlist   = in_array( $product_id, $wishlist );
    ?>
    <div class="product-card">
        <div class="product-image">
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="badge sale">SALE</span>
            <?php endif; ?>
            <?php
            $tags = get_the_terms( $product_id, 'product_tag' );
            if ( ! empty( $tags ) ) {
                foreach ( $tags as $tag ) {
                    if ( strtolower( $tag->name ) === 'bestseller' ) {
                        echo '<span class="badge bestseller">BESTSELLER</span>';
                        break;
                    }
                }
            }
            ?>
            <a href="<?php echo get_permalink( $product_id ); ?>">
                <img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
            </a>
            <button class="wishlist-toggle <?php echo $in_wishlist ? 'active' : ''; ?>" data-id="<?php echo $product_id; ?>" aria-label="Add to wishlist">
                <?php echo $in_wishlist ? '♥' : '♡'; ?>
            </button>
        </div>
        <div class="product-content">
            <h3><a href="<?php echo get_permalink( $product_id ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
            <p><?php echo wp_trim_words( ! empty( $short_desc ) ? $short_desc : $product->get_description(), 14 ); ?></p>
            <div class="price-wrap">
                <?php if ( $sale_price ) : ?>
                    <span class="sale-price"><?php echo wc_price( $sale_price ); ?></span>
                    <span class="old-price"><?php echo wc_price( $regular_price ); ?></span>
                <?php else : ?>
                    <span class="sale-price"><?php echo $product->get_price_html(); ?></span>
                <?php endif; ?>
            </div>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    </div>
    <?php
}
