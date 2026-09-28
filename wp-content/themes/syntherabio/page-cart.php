<?php
/**
 * Template Name: Cart
 */
get_header();
?>

<!-- CART HERO -->
<div class="cart-hero">
    <div class="cart-hero-inner">
        <span>YOUR CART</span>
        <h1>Shopping Bag</h1>
        <p>Review your items and proceed to checkout</p>
    </div>
</div>

<section class="cart-section">
  <div class="cart-wrap">
    <?php wc_print_notices(); ?>
    <?php echo do_shortcode('[woocommerce_cart]'); ?>
  </div>
</section>

<script>
jQuery(function($) {

    // Wrap qty inputs with custom +/- buttons
    function wrapQty() {
        $('.woocommerce-cart-form input.qty').each(function() {
            if (!$(this).parent().hasClass('qty-control')) {
                $(this).wrap('<div class="qty-control"></div>');
                $(this).before('<button type="button" class="qty-down">−</button>');
                $(this).after('<button type="button" class="qty-up">+</button>');
            }
        });
    }
    wrapQty();
    $(document.body).on('updated_cart_totals wc_fragments_refreshed', wrapQty);

    // Auto update on qty change
    var updateTimer;
    $(document).on('change', '.woocommerce-cart-form input.qty', function() {
        clearTimeout(updateTimer);
        var $form = $(this).closest('form');
        updateTimer = setTimeout(function() {
            $form.find('[name="update_cart"]').prop('disabled', false).trigger('click');
        }, 700);
    });

    // +/- click handlers
    $(document).on('click', '.qty-up', function() {
        var $input = $(this).siblings('input.qty');
        $input.val(parseInt($input.val() || 1) + 1).trigger('change');
    });
    $(document).on('click', '.qty-down', function() {
        var $input = $(this).siblings('input.qty');
        var val = parseInt($input.val() || 1);
        if (val > 1) $input.val(val - 1).trigger('change');
    });

    // Add trust badges after cart totals loads
    function addTrustBadges() {
        if ($('.cart-trust').length === 0 && $('.cart_totals').length > 0) {
            $('.cart_totals').append(
                '<div class="cart-trust">' +
                '<div class="cart-trust-item"><span>🔒</span> Secure Checkout</div>' +
                '<div class="cart-trust-item"><span>🚚</span> Fast Dispatch</div>' +
                '<div class="cart-trust-item"><span>🛡</span> 3rd Party Tested</div>' +
                '<div class="cart-trust-item"><span>↩</span> Easy Returns</div>' +
                '</div>'
            );
        }
    }
    addTrustBadges();
    $(document.body).on('updated_cart_totals', addTrustBadges);

});
</script>

<?php get_footer(); ?>
