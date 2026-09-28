99%+ <?php
/**
 * Template Name: Shop Page
 */
get_header();

$sort           = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
$current_cat_id = isset($_GET['cat'])     ? intval($_GET['cat'])                  : 0;
$search_query   = isset($_GET['s'])       ? sanitize_text_field($_GET['s'])       : '';

$orderby = 'date'; $order = 'DESC'; $meta_key = '';
switch($sort) {
    case 'price':      $orderby = 'meta_value_num'; $order = 'ASC';  $meta_key = '_price'; break;
    case 'price-desc': $orderby = 'meta_value_num'; $order = 'DESC'; $meta_key = '_price'; break;
    case 'title':      $orderby = 'title';           $order = 'ASC';  break;
}

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 9,
    'paged'          => 1,
    'post_status'    => 'publish',
    'orderby'        => $orderby,
    'order'          => $order,
);
if ( $meta_key )        $args['meta_key']  = $meta_key;
if ( $current_cat_id )  $args['tax_query'] = array(array('taxonomy'=>'product_cat','field'=>'term_id','terms'=>$current_cat_id));
if ( $search_query )    $args['s']         = $search_query;

$products_query = new WP_Query($args);
$categories     = get_terms('product_cat', array('hide_empty'=>true,'parent'=>0));
$all_count      = wp_count_posts('product')->publish;
?>

<!-- SHOP HERO -->
<section class="shop-hero">
    <div class="shop-hero-overlay"></div>
    <div class="shop-hero-content">
        <span>OUR CATALOG</span>
        <h1>The Full Collection</h1>
        <p>Research-grade peptides, supplements &amp; compounds — third-party tested, every batch.</p>
    </div>
    <div class="shop-trust-bar">
        <div class="trust-pill">99%+ Purity</div>
        <div class="trust-pill">3rd Party Tested</div>
        <div class="trust-pill">48h Dispatch</div>
        <div class="trust-pill">Secure Checkout</div>
    </div>
</section>

<!-- SHOP BODY -->
<section class="shop-body">
    <div class="shop-wrap">

        <!-- SIDEBAR -->
        <aside class="shop-sidebar">

            <!-- SEARCH -->
            <div class="sidebar-widget">
                <h5>SEARCH PRODUCTS</h5>
                <div class="live-search-wrap">
                    <input type="text" id="live-search-input" placeholder="Search products…" autocomplete="off" value="<?php echo esc_attr($search_query); ?>">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <div class="live-search-results" id="live-search-results"></div>
                </div>
            </div>

            <!-- CATEGORIES -->
            <!--<div class="sidebar-widget">-->
            <!--    <h5>CATEGORIES</h5>-->
            <!--    <ul class="sidebar-cats">-->
            <!--        <li class="<?php echo !$current_cat_id ? 'active' : ''; ?>">-->
            <!--            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">-->
            <!--                <span>All Products</span>-->
            <!--                <span class="cat-count"><?php echo $all_count; ?></span>-->
            <!--            </a>-->
            <!--        </li>-->
            <!--        <?php foreach($categories as $cat): ?>-->
            <!--        <li class="<?php echo $current_cat_id === $cat->term_id ? 'active' : ''; ?>">-->
            <!--            <a href="<?php echo esc_url(add_query_arg('cat', $cat->term_id, get_permalink(wc_get_page_id('shop')))); ?>">-->
            <!--                <span><?php echo esc_html($cat->name); ?></span>-->
            <!--                <span class="cat-count"><?php echo $cat->count; ?></span>-->
            <!--            </a>-->
            <!--        </li>-->
            <!--        <?php endforeach; ?>-->
            <!--    </ul>-->
            <!--</div>-->

        </aside>

        <!-- PRODUCTS AREA -->
        <div class="shop-main">

            <!-- TOPBAR -->
            <div class="shop-topbar">
                <p class="product-count">
                    Showing <strong><?php echo $products_query->post_count; ?></strong> of <strong><?php echo $products_query->found_posts; ?></strong> products
                    <?php if($current_cat_id): $cat_obj = get_term($current_cat_id,'product_cat'); if($cat_obj): ?>
                        in <strong><?php echo esc_html($cat_obj->name); ?></strong>
                    <?php endif; endif; ?>
                </p>
                <div class="topbar-right">
                    <div class="sort-wrap">
                        <label>Sort by:</label>
                        <select onchange="window.location=this.value">
                            <option value="<?php echo esc_url(add_query_arg('orderby','date',  get_permalink(wc_get_page_id('shop')))); ?>" <?php selected($sort,'date'); ?>>Latest</option>
                            <option value="<?php echo esc_url(add_query_arg('orderby','title', get_permalink(wc_get_page_id('shop')))); ?>" <?php selected($sort,'title'); ?>>Name A–Z</option>
                            <option value="<?php echo esc_url(add_query_arg('orderby','price', get_permalink(wc_get_page_id('shop')))); ?>" <?php selected($sort,'price'); ?>>Price: Low–High</option>
                            <option value="<?php echo esc_url(add_query_arg('orderby','price-desc',get_permalink(wc_get_page_id('shop')))); ?>" <?php selected($sort,'price-desc'); ?>>Price: High–Low</option>
                        </select>
                    </div>
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="Grid">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" stroke="currentColor" stroke-width="2"/></svg>
                        </button>
                        <button class="view-btn" data-view="list" title="List">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ACTIVE FILTERS -->
            <?php if($current_cat_id || ($sort && $sort !== 'date') || $search_query): ?>
            <div class="active-filters">
                <?php if($search_query): ?>
                    <span class="filter-tag">Search: "<?php echo esc_html($search_query); ?>" <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">×</a></span>
                <?php endif; ?>
                <?php if($current_cat_id): $cat_obj = get_term($current_cat_id,'product_cat'); if($cat_obj): ?>
                    <span class="filter-tag"><?php echo esc_html($cat_obj->name); ?> <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">×</a></span>
                <?php endif; endif; ?>
                <?php if($sort && $sort !== 'date'): ?>
                    <span class="filter-tag">Sort: <?php echo esc_html(ucfirst(str_replace('-',' ',$sort))); ?> <a href="<?php echo remove_query_arg('orderby'); ?>">×</a></span>
                <?php endif; ?>
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="clear-filters">Clear all</a>
            </div>
            <?php endif; ?>

            <!-- PRODUCT GRID -->
            <div class="shop-grid" id="shop-products-grid">
                <?php if($products_query->have_posts()):
                    while($products_query->have_posts()): $products_query->the_post();
                        global $product;
                        if(!$product) continue;
                        get_template_part('template-parts/product-card');
                    endwhile;
                    wp_reset_postdata();
                else: ?>
                    <div class="shop-empty">
                        <div class="empty-icon">🔬</div>
                        <h3>No products found</h3>
                        <p>Try a different category or clear your filters.</p>
                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="shop-empty-btn">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- LOAD MORE -->
            <?php if($products_query->max_num_pages > 1): ?>
            <div class="shop-load-more">
                <button id="load-more-products" class="load-more-btn"
                    data-page="1"
                    data-max-pages="<?php echo $products_query->max_num_pages; ?>"
                    data-cat="<?php echo $current_cat_id; ?>">
                    Load More Products
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12l7 7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="shop-loader" style="display:none;"></div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<script>
jQuery(function ($) {

    $('#load-more-products').on('click', function () {

        var button = $(this);

        var page = parseInt(button.attr('data-page'));
        var max = parseInt(button.attr('data-max-pages'));
        var cat = button.data('cat');

        if (page >= max) {
            button.hide();
            return;
        }

        $('.shop-loader').show();

        $.ajax({

            url: shop_ajax.ajax_url,

            type: 'POST',

            data: {

                action: 'load_more_products',

                page: page + 1,

                cat: cat

            },

            success: function (response) {

                $('.shop-loader').hide();

                if (response) {

                    $('#shop-products-grid').append(response);

                    button.attr('data-page', page + 1);

                    if (page + 1 >= max) {

                        button.hide();

                    }

                }

            }

        });

    });

});
</script>

<?php get_footer(); ?>
