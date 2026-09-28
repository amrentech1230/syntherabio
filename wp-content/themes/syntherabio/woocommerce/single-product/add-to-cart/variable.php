<?php
/**
 * Variable product add to cart — Syntherabio theme override
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );
?>

<style>
/* ── Variable product form ── */
.variations_form .variations {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.variations_form .variations tr {
    border-bottom: 1px solid #eee;
}
.variations_form .variations .label {
    padding: 12px 0;
    width: 110px;
    vertical-align: middle;
}
.variations_form .variations .label label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #555;
    margin: 0;
}
.variations_form .variations .value {
    padding: 12px 0 12px 12px;
    vertical-align: middle;
}
.variations_form .variations .value select {
    height: 46px;
    border: 1px solid #ddd;
    padding: 0 36px 0 14px;
    font-size: 14px;
    color: #111;
    background: #fafafa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23555' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") no-repeat right 12px center;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: none;
    cursor: pointer;
    transition: border-color 0.25s, box-shadow 0.25s;
    min-width: 180px;
}
.variations_form .variations .value select:focus {
    border-color: #009bb0;
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(0,155,176,0.1);
}
.variations_form .reset_variations {
    display: inline-block;
    margin-left: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #999;
    text-decoration: none;
    transition: color 0.2s;
    vertical-align: middle;
}
.variations_form .reset_variations:hover { color: #e74c3c; }

/* Single variation price/stock display */
.woocommerce-variation.single_variation {
    margin-bottom: 16px;
    min-height: 28px;
}
.woocommerce-variation-price .price {
    font-size: 28px !important;
    font-weight: 700 !important;
    color: #007b7b !important;
}
.woocommerce-variation-price .price del {
    font-size: 16px !important;
    color: #999 !important;
    margin-left: 8px;
}
.woocommerce-variation-availability .stock {
    font-size: 13px;
    font-weight: 600;
    color: #007b7b;
    margin-top: 4px;
}
.woocommerce-variation-availability .out-of-stock {
    color: #e74c3c;
}

/* Qty + Add to cart row */
.woocommerce-variation-add-to-cart {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 4px;
}
.woocommerce-variation-add-to-cart .qty-wrap {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    overflow: hidden;
}
.woocommerce-variation-add-to-cart .qty-wrap button {
    width: 38px;
    height: 52px;
    background: #f5f5f5;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #333;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.woocommerce-variation-add-to-cart .qty-wrap button:hover {
    background: #009bb0;
    color: #fff;
}
.woocommerce-variation-add-to-cart .qty-wrap input.qty {
    width: 52px;
    height: 52px;
    border: none;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    outline: none;
    -moz-appearance: textfield;
}
.woocommerce-variation-add-to-cart .qty-wrap input.qty::-webkit-inner-spin-button,
.woocommerce-variation-add-to-cart .qty-wrap input.qty::-webkit-outer-spin-button {
    -webkit-appearance: none;
}
/* WooCommerce default qty (fallback) */
.woocommerce-variation-add-to-cart input.qty:not(.qty-wrap input) {
    height: 52px;
    width: 70px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    outline: none;
    padding: 0 10px;
}
.woocommerce-variation-add-to-cart .single_add_to_cart_button {
    height: 52px;
    padding: 0 28px;
    background: #001923;
    color: #fff;
    border: none;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 1px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    transition: background 0.3s;
    white-space: nowrap;
}
.woocommerce-variation-add-to-cart .single_add_to_cart_button:hover:not(:disabled) {
    background: #009bb0;
}
.woocommerce-variation-add-to-cart .single_add_to_cart_button:disabled {
    opacity: 0.45;
    cursor: not-allowed;
}
.woocommerce-variation-add-to-cart .single_add_to_cart_button::before {
    content: '';
    display: inline-block;
    width: 16px;
    height: 16px;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 7H21L19 17H8L6 7Z'/%3E%3Cpath d='M6 7L5 4H2'/%3E%3Ccircle cx='9' cy='20' r='1' fill='white'/%3E%3Ccircle cx='18' cy='20' r='1' fill='white'/%3E%3C/svg%3E") no-repeat center / contain;
    flex-shrink: 0;
}

/* Out of stock notice */
.stock.out-of-stock {
    padding: 14px 20px;
    background: #fff5f5;
    border: 1px solid #fcc;
    color: #c0392b;
    font-size: 14px;
    font-weight: 600;
}
</style>

<form class="variations_form cart"
      action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
      method="post"
      enctype="multipart/form-data"
      data-product_id="<?php echo absint( $product->get_id() ); ?>"
      data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">

    <?php do_action( 'woocommerce_before_variations_form' ); ?>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock">
            <?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?>
        </p>
    <?php else : ?>

        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                    <tr>
                        <th class="label">
                            <label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
                                <?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?>
                            </label>
                        </th>
                        <td class="value">
                            <?php
                            wc_dropdown_variation_attribute_options( array(
                                'options'   => $options,
                                'attribute' => $attribute_name,
                                'product'   => $product,
                            ) );
                            echo end( $attribute_keys ) === $attribute_name
                                ? wp_kses_post( apply_filters(
                                    'woocommerce_reset_variations_link',
                                    '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'woocommerce' ) . '">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>'
                                ) )
                                : '';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

        <?php do_action( 'woocommerce_after_variations_table' ); ?>

        <div class="single_variation_wrap">
            <?php do_action( 'woocommerce_before_single_variation' ); ?>
            <?php do_action( 'woocommerce_single_variation' ); ?>
            <?php do_action( 'woocommerce_after_single_variation' ); ?>
        </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        // Wrap the WooCommerce default qty input with custom +/- buttons
        var form = document.querySelector('.variations_form');
        if (!form) return;

        form.addEventListener('woocommerce_variation_has_changed', function() {
            wrapQty();
        });

        // Also observe DOM changes for when variation loads
        var observer = new MutationObserver(function() { wrapQty(); });
        var addToCartDiv = form.querySelector('.woocommerce-variation-add-to-cart');
        if (addToCartDiv) {
            observer.observe(addToCartDiv, { childList: true, subtree: true });
        }

        function wrapQty() {
            var qtyInput = form.querySelector('.woocommerce-variation-add-to-cart input.qty');
            if (!qtyInput || qtyInput.closest('.qty-wrap')) return;

            var wrap = document.createElement('div');
            wrap.className = 'qty-wrap';

            var minus = document.createElement('button');
            minus.type = 'button';
            minus.textContent = '−';
            minus.addEventListener('click', function() {
                var v = parseInt(qtyInput.value) || 1;
                var min = parseInt(qtyInput.getAttribute('min')) || 1;
                if (v > min) { qtyInput.value = v - 1; qtyInput.dispatchEvent(new Event('change')); }
            });

            var plus = document.createElement('button');
            plus.type = 'button';
            plus.textContent = '+';
            plus.addEventListener('click', function() {
                var v = parseInt(qtyInput.value) || 1;
                var max = parseInt(qtyInput.getAttribute('max')) || 9999;
                if (v < max) { qtyInput.value = v + 1; qtyInput.dispatchEvent(new Event('change')); }
            });

            qtyInput.parentNode.insertBefore(wrap, qtyInput);
            wrap.appendChild(minus);
            wrap.appendChild(qtyInput);
            wrap.appendChild(plus);
        }
    });
})();
</script>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
