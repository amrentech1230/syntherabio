<?php
/**
 * WooCommerce Checkout template override
 * Uses our theme header/footer with WooCommerce checkout shortcode
 */
get_header();
?>
<div class="checkout-hero">
    <div class="checkout-hero-inner">
        <span>SECURE CHECKOUT</span>
        <h1>Complete Your Order</h1>
    </div>
</div>
<section class="checkout-section">
    <div class="checkout-wrap">
        <?php wc_print_notices(); ?>
        <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <?php if ( $checkout->get_checkout_fields() ) : ?>
                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                <div class="checkout-grid">
                    <div class="checkout-left">
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                    </div>
                    <div class="checkout-right">
                        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                        <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
                        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>
                        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    </div>
                </div>
                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
            <?php endif; ?>
        </form>
        <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
    </div>
</section>
<?php get_footer(); ?>
