<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<style>
		/* Announcement Bar */
		.announcement-bar {
			background: #02131d;
			color: #fff;
			text-align: center;
			padding: 12px 40px 12px 20px;
			position: relative;
			font-family: 'Inter', sans-serif;
			font-size: 14px;
			font-weight: 500;
			display: block;
			border-bottom: 1px solid rgba(255,255,255,0.1);
		}
		.announcement-bar p {
			margin: 0;
			padding: 0;
			color: #d2d7dc;
		}
		.announcement-bar.hidden { display: none; }
		.close-announcement {
			position: absolute;
			top: 50%;
			right: 15px;
			transform: translateY(-50%);
			background: none;
			border: none;
			color: #fff;
			font-size: 22px;
			cursor: pointer;
			opacity: 0.6;
		}
		.close-announcement:hover { opacity: 1; }
		/* Age Verification Modal */
		.age-modal-hidden {
			display: none !important;
		}
		#age-verification-modal {
			position: fixed;
			z-index: 99999;
			inset: 0;
			background: rgba(4, 26, 34, 0.9);
			-webkit-backdrop-filter: blur(10px);
			backdrop-filter: blur(10px);
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
			font-family: 'Inter', sans-serif;
		}
		.age-verification-content {
			background: #081b23;
			color: #fff;
			padding: 40px;
			border: 1px solid rgba(0, 255, 255, 0.15);
			width: 90%;
			max-width: 480px;
			text-align: center;
			border-radius: 12px;
			box-shadow: 0 10px 40px rgba(0,0,0,0.4);
		}
		.age-verification-logo { width: 120px; margin-bottom: 25px; border-radius: 50%; }
		.age-verification-content h2 { font-family: serif; font-size: 32px; margin-bottom: 12px; color: #fff; }
		.age-verification-content p { color: rgba(255,255,255,0.7); margin-bottom: 30px; line-height: 1.6; }
		.age-verification-buttons { display: flex; justify-content: center; gap: 15px; }
		.age-verification-buttons button { font-weight: 700; font-size: 14px; padding: 14px 30px; border: none; cursor: pointer; border-radius: 6px; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease; min-width: 140px; }
		#age-verify-yes { background: linear-gradient(90deg, #009bb0, #00c5d8); color: #fff; box-shadow: 0 4px 20px rgba(0, 255, 255, 0.15); }
		#age-verify-yes:hover { transform: translateY(-2px); filter: brightness(1.1); }
		#age-verify-no { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,0.3); }
		#age-verify-no:hover { background: rgba(255,255,255,0.1); border-color: #e74c3c; color: #e74c3c; }
	</style>
</head>
<body <?php body_class(); ?>>

<!-- ANNOUNCEMENT BAR -->
<div id="announcement-bar" class="announcement-bar">
    <div class="announcement-content">
        <p>FREE SHIPPING ON ALL ORDERS OVER $150</p>
    </div>
    <button id="close-announcement" class="close-announcement" aria-label="Close announcement bar">&times;</button>
</div>

<!-- HEADER -->
<header class="main-header">
  <div class="header-container">

    <!-- LOGO -->
    <a href="<?php echo home_url('/'); ?>" class="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/image/syntherabio-logo.jpeg" alt="Synthera Logo">
    </a>

    <!-- NAVIGATION -->
    <nav class="navbar" id="navbar">
      <ul class="nav-links">
        <li><a href="<?php echo home_url('/'); ?>" class="<?php echo is_front_page() ? 'active' : ''; ?>">Home</a></li>
        <li><a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>" class="<?php echo is_shop() || is_product_category() ? 'active' : ''; ?>">Shop</a></li>
        <li><a href="<?php echo home_url('/about'); ?>" class="<?php echo is_page('about') ? 'active' : ''; ?>">About</a></li>
        <!--<li><a href="<?php echo home_url('/journal'); ?>" class="<?php echo is_page('journal') ? 'active' : ''; ?>">Journal</a></li>-->
        <li><a href="<?php echo home_url('/contact'); ?>" class="<?php echo is_page('contact') ? 'active' : ''; ?>">Contact</a></li>
      </ul>
    </nav>

    <!-- HEADER ICONS -->
    <div class="header-icons">

      <!-- Search -->
      <a href="<?php echo get_search_link(); ?>" aria-label="Search">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </a>

      <!-- Wishlist -->
      <a href="<?php echo home_url('/wishlist'); ?>" class="wishlist-header-icon" aria-label="Wishlist">
        <svg viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
        <span class="wishlist-count"><?php echo count( syntherabio_get_wishlist() ); ?></span>
      </a>

      <!-- User / My Account -->
      <a href="<?php echo esc_url( home_url('/account') ); ?>" aria-label="My Account">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 20C4 16.5 7 14 12 14C17 14 20 16.5 20 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </a>

      <!-- Cart -->
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon-wrap" aria-label="Cart">
        <svg viewBox="0 0 24 24" fill="none"><path d="M6 7H21L19 17H8L6 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M6 7L5 4H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="20" r="1" fill="currentColor"/><circle cx="18" cy="20" r="1" fill="currentColor"/></svg>
        <span class="cart-count"><?php echo function_exists('WC') ? WC()->cart->get_cart_contents_count() : 0; ?></span>
      </a>

      <!-- Mobile Menu Toggle -->
      <button class="menu-toggle" id="menuToggle" aria-label="Menu">&#9776;</button>
    </div>

  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const announcementBar = document.getElementById('announcement-bar');
    const closeButton = document.getElementById('close-announcement');

    if (announcementBar && closeButton) {
        if (sessionStorage.getItem('announcementClosed') === 'true') {
            announcementBar.classList.add('hidden');
        }
        closeButton.addEventListener('click', function() {
            announcementBar.classList.add('hidden');
            sessionStorage.setItem('announcementClosed', 'true');
        });
    }
});
</script>
