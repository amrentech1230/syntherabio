jQuery(function($) {

    // =============================================
    // LIVE SEARCH
    // =============================================
    var searchTimer;
    var $searchInput  = $('#live-search-input');
    var $searchResults = $('#live-search-results');

    $searchInput.on('input', function() {
        var term = $(this).val().trim();
        clearTimeout(searchTimer);

        if (term.length < 2) {
            $searchResults.hide().empty();
            return;
        }

        searchTimer = setTimeout(function() {
            $searchResults.html('<div class="ls-loading"><span></span><span></span><span></span></div>').show();

            $.post(syntherabio_ajax.ajax_url, {
                action: 'syntherabio_live_search',
                term:   term,
                nonce:  syntherabio_ajax.nonce
            }, function(res) {
                $searchResults.empty();
                if (res.success && res.data.length > 0) {
                    $.each(res.data, function(i, p) {
                        $searchResults.append(
                            '<a href="' + p.url + '" class="ls-item">' +
                                '<img src="' + p.img + '" alt="' + p.title + '">' +
                                '<div class="ls-info">' +
                                    '<span class="ls-cat">' + (p.cat || '') + '</span>' +
                                    '<strong class="ls-title">' + p.title + '</strong>' +
                                    '<span class="ls-price">' + p.price + '</span>' +
                                '</div>' +
                            '</a>'
                        );
                    });
                    $searchResults.append(
                        '<a href="' + window.location.pathname + '?s=' + encodeURIComponent(term) + '" class="ls-view-all">View all results for "' + term + '" →</a>'
                    );
                } else {
                    $searchResults.html('<div class="ls-no-results">No products found for "' + term + '"</div>');
                }
                $searchResults.show();
            });
        }, 300);
    });

    // Close on outside click
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.live-search-wrap').length) {
            $searchResults.hide();
        }
    });

    // Keyboard navigation
    $searchInput.on('keydown', function(e) {
        var $items = $searchResults.find('.ls-item');
        var $active = $items.filter('.ls-hover');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if ($active.length === 0) { $items.first().addClass('ls-hover'); }
            else { $active.removeClass('ls-hover').next('.ls-item').addClass('ls-hover'); }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if ($active.length) { $active.removeClass('ls-hover').prev('.ls-item').addClass('ls-hover'); }
        } else if (e.key === 'Enter' && $active.length) {
            e.preventDefault();
            window.location = $active.attr('href');
        } else if (e.key === 'Escape') {
            $searchResults.hide();
        }
    });

    // =============================================
    // MOBILE MENU TOGGLE
    // =============================================
    $('#menuToggle').on('click', function() {
        $('#navbar').toggleClass('active');
    });

    // =============================================
    // FAQ ACCORDION
    // =============================================
    $(document).on('click', '.faq-question', function() {
        var $item = $(this).closest('.faq-item');
        var isActive = $item.hasClass('active');
        $('.faq-item').removeClass('active');
        $('.faq-question span').text('+');
        if (!isActive) {
            $item.addClass('active');
            $(this).find('span').text('−');
        }
    });

    // =============================================
    // WISHLIST TOGGLE
    // =============================================
    $(document).on('click', '.wishlist-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $btn      = $(this);
        var productId = $btn.data('id');
        if ( $btn.hasClass('loading') ) return;
        $btn.addClass('loading');

        $.post(syntherabio_ajax.ajax_url, {
            action:     'syntherabio_toggle_wishlist',
            product_id: productId,
            nonce:      syntherabio_ajax.nonce
        }, function(res) {
            $btn.removeClass('loading');
            if ( res.success ) {
                var $svg = $btn.find('svg');
                if ( res.data.action === 'added' ) {
                    $btn.addClass('active');
                    $svg.attr('fill', 'currentColor');
                    // update text node for detail wishlist
                    $btn.filter('.detail-wishlist').contents().filter(function(){ return this.nodeType === 3; }).last().replaceWith(' Saved');
                } else {
                    $btn.removeClass('active');
                    $svg.attr('fill', 'none');
                    $btn.filter('.detail-wishlist').contents().filter(function(){ return this.nodeType === 3; }).last().replaceWith(' Wishlist');
                    // remove card on wishlist page
                    if ( $('body').hasClass('page-template-page-wishlist') ) {
                        $btn.closest('.product-card').fadeOut(300, function(){ $(this).remove(); });
                    }
                }
                // update header count
                var count = res.data.count;
                $('.wishlist-count').text( count > 0 ? count : '' );
            }
        }).fail(function(){
            $btn.removeClass('loading');
        });
    });

    // =============================================
    // SHOP GRID / LIST VIEW TOGGLE
    // =============================================
    $(document).on('click', '.view-btn', function() {
        var view = $(this).data('view');
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        if (view === 'list') {
            $('#shop-products-grid').addClass('list-view');
        } else {
            $('#shop-products-grid').removeClass('list-view');
        }
    });

    // =============================================
    // LOAD MORE PRODUCTS (SHOP PAGE)
    // =============================================
    $(document).on('click', '#load-more-products', function() {
        var $btn     = $(this);
        var page     = parseInt($btn.data('page'));
        var maxPages = parseInt($btn.data('max-pages'));
        var catId    = $btn.data('cat') || 0;

        if (page >= maxPages) return;

        $btn.hide();
        $('.loader').show();

        $.post(syntherabio_ajax.ajax_url, {
            action: 'syntherabio_load_more',
            page:   page,
            cat_id: catId,
            nonce:  syntherabio_ajax.nonce
        }, function(res) {
            $('.loader').hide();
            if (res.success) {
                $('.products-grid').append(res.data.html);
                var newPage = page + 1;
                $btn.data('page', newPage);
                if (newPage < res.data.max_pages) {
                    $btn.show();
                }
            }
        });
    });

    // =============================================
    // HOME FEATURED PRODUCT FILTER TABS
    // =============================================
    $(document).on('click', '.filter-tab', function() {
        var $btn  = $(this);
        var catId = $btn.data('cat');

        $('.filter-tab').removeClass('active');
        $btn.addClass('active');

        var $grid = $('#featured-products-grid');
        $grid.css('opacity', 0.5);

        $.post(syntherabio_ajax.ajax_url, {
            action: 'syntherabio_load_more',
            page:   0,
            cat_id: catId,
            nonce:  syntherabio_ajax.nonce
        }, function(res) {
            if (res.success) {
                $grid.html(res.data.html).css('opacity', 1);
            }
        });
    });

    // =============================================
    // PASSWORD SHOW/HIDE TOGGLE
    // =============================================
    $(document).on('click', '.toggle-pw', function() {
        var targetId = $(this).data('target');
        var $input   = $('#' + targetId);
        var type     = $input.attr('type') === 'password' ? 'text' : 'password';
        $input.attr('type', type);
        $(this).css('color', type === 'text' ? '#009bb0' : 'rgba(255,255,255,0.35)');
    });

    // =============================================
    // CART COUNT UPDATE (WooCommerce fragments)
    // =============================================
    $(document.body).on('wc_fragments_refreshed added_to_cart', function() {
        var count = parseInt($('.cart-count').text()) || 0;
        if (count === 0) {
            $('.cart-count').hide();
        } else {
            $('.cart-count').show();
        }
    });

});
