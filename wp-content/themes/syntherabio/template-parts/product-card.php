<?php
/**
 * Template Part: Product Card
 */
global $product;
if ( ! $product ) return;

$product_id    = $product->get_id();
$image_id      = get_post_thumbnail_id( $product_id );
$image         = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
if ( ! $image ) $image = wp_get_attachment_image_src( $image_id, 'full' );
$product_image = ! empty( $image[0] ) ? $image[0] : wc_placeholder_img_src();
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();
$short_desc    = $product->get_short_description();
$wishlist      = syntherabio_get_wishlist();
$in_wishlist   = in_array( $product_id, $wishlist );
$permalink     = get_permalink( $product_id );
$is_purchasable = $product->is_purchasable() && $product->is_in_stock();
?>
<div class="product-card">

    <!-- IMAGE -->
    <div class="product-image">

        <?php if ( $product->is_on_sale() ) : ?>
            <span class="badge sale">SALE</span>
        <?php endif; ?>

        <?php
        $tags = get_the_terms( $product_id, 'product_tag' );
        if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
            foreach ( $tags as $tag ) {
                if ( strtolower( $tag->name ) === 'bestseller' ) {
                    echo '<span class="badge bestseller">BESTSELLER</span>';
                    break;
                }
            }
        }
        ?>

        <a href="<?php echo esc_url( $permalink ); ?>" class="product-img-link">
            <img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
        </a>

        <!-- WISHLIST -->
        <button class="wishlist-toggle <?php echo $in_wishlist ? 'active' : ''; ?>"
                data-id="<?php echo esc_attr( $product_id ); ?>"
                title="<?php echo $in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist'; ?>">
            <svg viewBox="0 0 24 24" fill="<?php echo $in_wishlist ? 'currentColor' : 'none'; ?>">
                <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
        </button>

    </div>

    <!-- CONTENT -->
    <div class="product-content">

        <?php
        $cats = wc_get_product_category_list( $product_id );
        if ( $cats ) : ?>
            <div class="product-cat"><?php echo strip_tags( $cats ); ?></div>
        <?php endif; ?>

        <h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>

        <?php if ( $short_desc ) : ?>
            <p class="product-desc"><?php echo wp_trim_words( $short_desc, 12 ); ?></p>
        <?php endif; ?>

        <div class="price-wrap">
            <?php if ( $sale_price ) : ?>
                <span class="sale-price"><?php echo wc_price( $sale_price ); ?></span>
                <span class="old-price"><?php echo wc_price( $regular_price ); ?></span>
            <?php else : ?>
                <span class="sale-price"><?php echo $product->get_price_html(); ?></span>
            <?php endif; ?>
        </div>

        <div class="card-actions">
            <?php if ( $is_purchasable ) : ?>
            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
               class="add-to-cart-btn ajax_add_to_cart"
               data-product_id="<?php echo esc_attr( $product_id ); ?>"
               data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
               data-quantity="1"
               aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
               rel="nofollow">
                <svg viewBox="0 0 24 24" fill="none"><path d="M6 7H21L19 17H8L6 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M6 7L5 4H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="20" r="1" fill="currentColor"/><circle cx="18" cy="20" r="1" fill="currentColor"/></svg>
                Add to Cart
            </a>
            <?php else : ?>
            <a href="<?php echo esc_url( $permalink ); ?>" class="add-to-cart-btn out-of-stock-btn">View Product</a>
            <?php endif; ?>
            <a href="<?php echo esc_url( $permalink ); ?>" class="read-more-btn">Details</a>
        </div>

    </div>

</div>
