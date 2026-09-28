# TODO - WooCommerce site setup in syntherabio

## Step 1: Inspect current WooCommerce/theme integration
- [ ] Confirm theme template overrides directory (create `wp-content/themes/syntherabio/woocommerce/` only if needed)
- [ ] Check for existing WooCommerce template overrides in theme

## Step 2: Add My Account/Login & Cart pages via WooCommerce shorts (best-practice)
- [ ] Create WooCommerce page templates in theme if necessary
- [ ] Ensure header account/cart icons link to configured WooCommerce pages

## Step 3: Wishlist integration
- [ ] Confirm wishlist plugin support present
- [ ] If wishlist plugin is absent, add wishlist using a lightweight approach (or enable WooCommerce-supported wishlist flow)

## Step 4: Product detail page styling
- [ ] Ensure single product page uses WooCommerce default template
- [ ] Add CSS overrides (minimal) to match theme

## Step 5: Test user journeys
- [ ] Product page -> Add to cart
- [ ] Cart page -> update quantities -> proceed to checkout
- [ ] My Account -> login/register
- [ ] Wishlist -> add/remove/view

