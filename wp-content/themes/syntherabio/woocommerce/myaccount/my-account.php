<?php
/**
 * WooCommerce My Account page override
 * Wraps in our theme's account section styling
 */
get_header();
?>
<section class="account-section">
  <div class="account-container" style="max-width:900px;">
    <?php
    /**
     * woocommerce_account_content hook.
     */
    do_action( 'woocommerce_account_content' );
    ?>
  </div>
</section>
<?php get_footer(); ?>
