<?php
/**
 * Template Name: Checkout Page
 * The front page template for WordPress
 */
get_header();
?>
<!-- CHECKOUT HERO -->
<div class="checkout-hero">
    <div class="checkout-hero-inner">
        <span>FINALIZE YOUR ORDER</span>
        <h1>Checkout</h1>
        <p>Please provide your shipping and payment details to complete your purchase.</p>
    </div>
</div>

<section class="checkout-section">
  <div class="checkout-wrap">
    <?php echo do_shortcode('[woocommerce_checkout]'); ?>
  </div>
</section>

<?php get_footer(); ?>