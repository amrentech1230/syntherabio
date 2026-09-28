<?php
/**
 * Template Name: Wishlist
 */
get_header();
$wishlist = syntherabio_get_wishlist();
?>
<section class="wishlist-section">
  <div class="wishlist-container">
    <div class="page-heading">
      <span>MY WISHLIST</span>
      <h1>Saved Items</h1>
    </div>

    <?php if ( empty( $wishlist ) ) : ?>
      <div class="empty-state">
        <div class="empty-icon">♡</div>
        <h3>Your wishlist is empty</h3>
        <p>Browse our products and save your favourites.</p>
        <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>" class="auth-btn">Shop Now</a>
      </div>
    <?php else : ?>
      <div class="wishlist-grid">
        <?php
        foreach ( $wishlist as $product_id ) {
            $product = wc_get_product( $product_id );
            if ( ! $product || ! $product->is_visible() ) continue;
            setup_postdata( get_post( $product_id ) );
            get_template_part( 'template-parts/product-card' );
            wp_reset_postdata();
        }
        ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
