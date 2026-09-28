<?php
/**
 * Single Product Template
 */
get_header();

// Ensure WooCommerce scripts are loaded for add to cart
if ( function_exists( 'WC' ) ) {
    wp_enqueue_script( 'wc-add-to-cart' );
    wp_enqueue_script( 'wc-add-to-cart-variation' );
}

the_post();
global $product;
$product = wc_get_product( get_the_ID() );
if ( ! $product ) { get_footer(); return; }

$product_id    = $product->get_id();
$images        = $product->get_gallery_image_ids();
$main_image_id = get_post_thumbnail_id( $product_id );
$main_image    = wp_get_attachment_image_src( $main_image_id, 'large' );
$main_src      = ! empty( $main_image[0] ) ? $main_image[0] : wc_placeholder_img_src();
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();
$wishlist      = syntherabio_get_wishlist();
$in_wishlist   = in_array( $product_id, $wishlist );
$categories    = wc_get_product_category_list( $product_id, ', ' );
$tags          = wc_get_product_tag_list( $product_id, ', ' );
?>

<section class="product-detail-section">
  <div class="product-detail-container">

    <!-- BREADCRUMB -->
    <nav class="breadcrumb">
      <a href="<?php echo home_url('/'); ?>">Home</a>
      <span>/</span>
      <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>">Shop</a>
      <span>/</span>
      <span><?php the_title(); ?></span>
    </nav>

    <div class="product-detail-grid">

      <!-- LEFT: GALLERY -->
      <div class="product-gallery">
        <div class="gallery-main">
          <img id="main-product-img" src="<?php echo esc_url( $main_src ); ?>" alt="<?php the_title_attribute(); ?>">
          <?php if ( $product->is_on_sale() ) : ?>
            <span class="detail-badge sale">SALE</span>
          <?php endif; ?>
          <!-- WISHLIST ON IMAGE -->
          <button class="wishlist-toggle detail-img-wishlist <?php echo $in_wishlist ? 'active' : ''; ?>" data-id="<?php echo $product_id; ?>">
            <svg viewBox="0 0 24 24" fill="<?php echo $in_wishlist ? 'currentColor' : 'none'; ?>">
              <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <?php if ( ! empty( $images ) ) : ?>
        <div class="gallery-thumbs">
          <div class="thumb active" data-src="<?php echo esc_url( $main_src ); ?>">
            <img src="<?php echo esc_url( $main_src ); ?>" alt="">
          </div>
          <?php foreach ( $images as $img_id ) :
            $thumb = wp_get_attachment_image_src( $img_id, 'medium' );
            $full  = wp_get_attachment_image_src( $img_id, 'large' );
            if ( ! $thumb ) continue;
          ?>
          <div class="thumb" data-src="<?php echo esc_url( $full[0] ); ?>">
            <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="">
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT: INFO -->
      <div class="product-info">

        <?php if ( $categories ) : ?>
          <span class="product-cat-label"><?php echo strip_tags( $categories ); ?></span>
        <?php endif; ?>

        <h1><?php the_title(); ?></h1>

        <!-- RATING -->
        <?php if ( $product->get_review_count() > 0 ) : ?>
          <div class="product-rating">
            <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
            <span>(<?php echo $product->get_review_count(); ?> reviews)</span>
          </div>
        <?php endif; ?>

        <!-- PRICE -->
        <div class="detail-price">
          <?php if ( $sale_price ) : ?>
            <span class="detail-sale-price"><?php echo wc_price( $sale_price ); ?></span>
            <span class="detail-regular-price"><?php echo wc_price( $regular_price ); ?></span>
          <?php else : ?>
            <span class="detail-sale-price"><?php echo $product->get_price_html(); ?></span>
          <?php endif; ?>
        </div>

        <!-- SHORT DESCRIPTION -->
        <?php if ( $product->get_short_description() ) : ?>
          <div class="product-short-desc"><?php echo wpautop( $product->get_short_description() ); ?></div>
        <?php endif; ?>

        <!-- ADD TO CART -->
        <div class="detail-actions">
          <?php if ( $product->is_type( 'variable' ) ) :
            woocommerce_template_single_add_to_cart();
          elseif ( ! $product->is_in_stock() ) : ?>
            <div class="out-of-stock-msg">⚠ Out of Stock — check back soon</div>
          <?php else : ?>
            <form class="cart detail-cart-form" action="<?php echo esc_url( home_url('/') ); ?>" method="post" enctype="multipart/form-data">
              <div class="qty-wrap">
                <button type="button" class="qty-minus">−</button>
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product->get_stock_quantity() ? $product->get_stock_quantity() : 999; ?>" class="qty-input">
                <button type="button" class="qty-plus">+</button>
              </div>
              <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>" class="detail-add-to-cart-btn">
                <svg viewBox="0 0 24 24" fill="none"><path d="M6 7H21L19 17H8L6 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M6 7L5 4H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="20" r="1" fill="currentColor"/><circle cx="18" cy="20" r="1" fill="currentColor"/></svg>
                Add to Cart
              </button>
              <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
              <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </form>
          <?php endif; ?>

          <!-- WISHLIST BUTTON -->
          <button class="wishlist-toggle detail-wishlist <?php echo $in_wishlist ? 'active' : ''; ?>" data-id="<?php echo $product_id; ?>">
            <svg viewBox="0 0 24 24" fill="<?php echo $in_wishlist ? 'currentColor' : 'none'; ?>">
              <path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
            <?php echo $in_wishlist ? 'Saved' : 'Wishlist'; ?>
          </button>
        </div>

        <!-- META -->
        <div class="product-meta">
          <?php if ( $product->get_sku() ) : ?>
            <p><strong>SKU:</strong> <?php echo esc_html( $product->get_sku() ); ?></p>
          <?php endif; ?>
          <?php if ( $categories ) : ?>
            <p><strong>Category:</strong> <?php echo $categories; ?></p>
          <?php endif; ?>
          <?php if ( $tags ) : ?>
            <p><strong>Tags:</strong> <?php echo $tags; ?></p>
          <?php endif; ?>
        </div>

        <!-- TRUST BADGES -->
        <div class="trust-badges">
          <div class="trust-item"><span>🧪</span> 99%+ Purity</div>
          <div class="trust-item"><span>🛡</span> 3rd Party Tested</div>
          <div class="trust-item"><span>🚚</span> 48h Dispatch</div>
          <div class="trust-item"><span>🔒</span> Secure Checkout</div>
        </div>

      </div>
    </div>

    <!-- TABS -->
    <div class="product-tabs">
      <div class="tab-nav">
        <button class="tab-btn active" data-tab="description">Description</button>
        <button class="tab-btn" data-tab="reviews">Reviews (<?php echo $product->get_review_count(); ?>)</button>
      </div>
      <div class="tab-content active" id="tab-description">
        <?php
        $content = get_the_content();
        $desc    = $product->get_description();
        echo $content ? apply_filters( 'the_content', $content ) : ( $desc ? wpautop( $desc ) : '<p>No description available.</p>' );
        ?>
      </div>
      <div class="tab-content" id="tab-reviews">
        <?php comments_template(); ?>
      </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <?php
    $related_ids = wc_get_related_products( $product_id, 4 );
    if ( ! empty( $related_ids ) ) : ?>
    <div class="related-products">
      <h2>You May Also Like</h2>
      <div class="related-grid">
        <?php foreach ( $related_ids as $related_id ) :
            $related = wc_get_product( $related_id );
            if ( ! $related ) continue;
            setup_postdata( get_post( $related_id ) );
            get_template_part( 'template-parts/product-card' );
            wp_reset_postdata();
        endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery thumbnails
    document.querySelectorAll('.thumb').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            document.getElementById('main-product-img').src = this.dataset.src;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Tabs
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('tab-' + this.dataset.tab).classList.add('active');
        });
    });

    // Qty +/-
    document.querySelectorAll('.qty-plus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        });
    });
    document.querySelectorAll('.qty-minus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.nextElementSibling;
            if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        });
    });

    // Wishlist toggle text update
    document.querySelectorAll('.detail-wishlist, .detail-img-wishlist').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var svg = this.querySelector('svg path');
            if (this.classList.contains('active')) {
                if (svg) svg.setAttribute('fill', 'none');
                var textNode = this.childNodes[this.childNodes.length - 1];
                if (textNode && textNode.nodeType === 3) textNode.textContent = ' Wishlist';
            } else {
                if (svg) svg.setAttribute('fill', 'currentColor');
                var textNode = this.childNodes[this.childNodes.length - 1];
                if (textNode && textNode.nodeType === 3) textNode.textContent = ' Saved';
            }
        });
    });
});
</script>

<?php get_footer(); ?>
