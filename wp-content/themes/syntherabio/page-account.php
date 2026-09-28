<?php
/**
 * Template Name: My Account
 * Custom Login / Register / Forgot Password / Dashboard
 */

// Handle form submissions BEFORE headers are sent
if ( ! is_user_logged_in() ) {

    // --- LOGIN ---
    if ( isset( $_POST['synth_login_submit'] ) ) {
        $creds = array(
            'user_login'    => sanitize_text_field( $_POST['synth_username'] ),
            'user_password' => $_POST['synth_password'],
            'remember'      => isset( $_POST['synth_remember'] ),
        );
        $user = wp_signon( $creds, false );
        if ( is_wp_error( $user ) ) {
            $login_error = 'Invalid username or password. Please try again.';
        } else {
            wp_redirect( get_permalink() );
            exit;
        }
    }

    // --- REGISTER ---
    if ( isset( $_POST['synth_register_submit'] ) ) {
        $reg_username = sanitize_user( $_POST['synth_reg_username'] );
        $reg_email    = sanitize_email( $_POST['synth_reg_email'] );
        $reg_password = $_POST['synth_reg_password'];
        $reg_confirm  = $_POST['synth_reg_confirm'];

        if ( empty( $reg_username ) || empty( $reg_email ) || empty( $reg_password ) ) {
            $reg_error = 'All fields are required.';
        } elseif ( ! is_email( $reg_email ) ) {
            $reg_error = 'Please enter a valid email address.';
        } elseif ( $reg_password !== $reg_confirm ) {
            $reg_error = 'Passwords do not match.';
        } elseif ( strlen( $reg_password ) < 6 ) {
            $reg_error = 'Password must be at least 6 characters.';
        } elseif ( username_exists( $reg_username ) ) {
            $reg_error = 'That username is already taken.';
        } elseif ( email_exists( $reg_email ) ) {
            $reg_error = 'An account with that email already exists.';
        } else {
            $user_id = wp_create_user( $reg_username, $reg_password, $reg_email );
            if ( is_wp_error( $user_id ) ) {
                $reg_error = $user_id->get_error_message();
            } else {
                // Auto login after register
                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );
                wp_redirect( get_permalink() );
                exit;
            }
        }
    }

    // --- FORGOT PASSWORD ---
    if ( isset( $_POST['synth_forgot_submit'] ) ) {
        $forgot_email = sanitize_email( $_POST['synth_forgot_email'] );
        if ( empty( $forgot_email ) || ! is_email( $forgot_email ) ) {
            $forgot_error = 'Please enter a valid email address.';
        } else {
            $user = get_user_by( 'email', $forgot_email );
            if ( ! $user ) {
                $forgot_error = 'No account found with that email address.';
            } else {
                // Use WordPress password reset
                $key = get_password_reset_key( $user );
                if ( ! is_wp_error( $key ) ) {
                    $reset_link = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' );
                    $message  = "Hi " . $user->display_name . ",\n\n";
                    $message .= "Someone requested a password reset for your Synthera account.\n\n";
                    $message .= "Click the link below to reset your password:\n\n";
                    $message .= $reset_link . "\n\n";
                    $message .= "If you did not request this, ignore this email.\n\n";
                    $message .= "— Synthera Therapeutics";
                    wp_mail( $forgot_email, 'Reset Your Synthera Password', $message );
                    $forgot_success = 'Password reset link sent! Check your email.';
                } else {
                    $forgot_error = 'Could not generate reset link. Please try again.';
                }
            }
        }
    }
}

// --- LOGOUT ---
if ( isset( $_GET['action'] ) && $_GET['action'] === 'logout' ) {
    wp_logout();
    wp_redirect( get_permalink() );
    exit;
}

get_header();

$action = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : 'login';
if ( isset( $_POST['synth_register_submit'] ) && isset( $reg_error ) ) $action = 'register';
if ( isset( $_POST['synth_forgot_submit'] ) ) $action = 'forgot';
?>

<section class="account-section">
  <div class="account-wrap">

    <?php if ( is_user_logged_in() ) :
        $current_user = wp_get_current_user();
        $orders = wc_get_orders( array( 'customer' => $current_user->ID, 'limit' => 5 ) );
    ?>

    <!-- ===== DASHBOARD ===== -->
    <div class="dashboard-layout">

      <!-- SIDEBAR -->
      <aside class="dashboard-sidebar">
        <div class="dashboard-avatar">
          <div class="avatar-circle"><?php echo strtoupper( substr( $current_user->display_name, 0, 1 ) ); ?></div>
          <div>
            <strong><?php echo esc_html( $current_user->display_name ); ?></strong>
            <span><?php echo esc_html( $current_user->user_email ); ?></span>
          </div>
        </div>
        <nav class="dashboard-nav">
          <a href="?tab=dashboard" class="<?php echo ( ! isset($_GET['tab']) || $_GET['tab'] === 'dashboard' ) ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" stroke="currentColor" stroke-width="2"/></svg>
            Dashboard
          </a>
          <a href="?tab=orders" class="<?php echo ( isset($_GET['tab']) && $_GET['tab'] === 'orders' ) ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="currentColor" stroke-width="2"/><rect x="9" y="3" width="6" height="4" rx="1" stroke="currentColor" stroke-width="2"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            My Orders
          </a>
          <a href="<?php echo home_url('/wishlist'); ?>">
            <svg viewBox="0 0 24 24" fill="none"><path d="M12 21C12 21 3 14.5 3 8.5C3 5.42 5.42 3 8.5 3C10.24 3 11.91 3.81 13 5.08C14.09 3.81 15.76 3 17.5 3C20.58 3 23 5.42 23 8.5C23 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="2"/></svg>
            Wishlist
          </a>
          <a href="?tab=address" class="<?php echo ( isset($_GET['tab']) && $_GET['tab'] === 'address' ) ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="2"/></svg>
            Addresses
          </a>
          <a href="?tab=password" class="<?php echo ( isset($_GET['tab']) && $_GET['tab'] === 'password' ) ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="2"/><path d="M7 11V7a5 5 0 0110 0v4" stroke="currentColor" stroke-width="2"/></svg>
            Password
          </a>
          <a href="?action=logout" class="logout-link">
            <svg viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Sign Out
          </a>
        </nav>
      </aside>

      <!-- MAIN CONTENT -->
      <div class="dashboard-main">

        <?php
        $tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'dashboard';

        // ---- DASHBOARD TAB ----
        if ( $tab === 'dashboard' ) : ?>
          <div class="dash-section">
            <h2>Welcome back, <?php echo esc_html( $current_user->first_name ?: $current_user->display_name ); ?></h2>
            <p class="dash-sub">Manage your orders, addresses and account details below.</p>
            <div class="dash-stats">
              <div class="dash-stat">
                <span><?php echo count( $orders ); ?></span>
                <p>Total Orders</p>
              </div>
              <div class="dash-stat">
                <span><?php echo count( syntherabio_get_wishlist() ); ?></span>
                <p>Wishlist Items</p>
              </div>
              <div class="dash-stat">
                <span><?php echo date( 'Y' ) - date( 'Y', strtotime( $current_user->user_registered ) ); ?>y</span>
                <p>Member Since</p>
              </div>
            </div>
          </div>

          <?php if ( ! empty( $orders ) ) : ?>
          <div class="dash-section">
            <h3>Recent Orders</h3>
            <div class="orders-table-wrap">
              <table class="orders-table">
                <thead>
                  <tr><th>Order</th><th>Date</th><th>Status</th><th>Total</th><th></th></tr>
                </thead>
                <tbody>
                  <?php foreach ( $orders as $order ) : ?>
                  <tr>
                    <td>#<?php echo $order->get_order_number(); ?></td>
                    <td><?php echo wc_format_datetime( $order->get_date_created() ); ?></td>
                    <td><span class="order-status status-<?php echo $order->get_status(); ?>"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span></td>
                    <td><?php echo $order->get_formatted_order_total(); ?></td>
                    <td><a href="<?php echo $order->get_view_order_url(); ?>" class="view-order-btn">View</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php endif; ?>

        <?php // ---- ORDERS TAB ----
        elseif ( $tab === 'orders' ) :
            $all_orders = wc_get_orders( array( 'customer' => $current_user->ID, 'limit' => -1 ) );
        ?>
          <div class="dash-section">
            <h2>My Orders</h2>
            <?php if ( empty( $all_orders ) ) : ?>
              <div class="dash-empty">
                <p>You haven't placed any orders yet.</p>
                <a href="<?php echo get_permalink( wc_get_page_id('shop') ); ?>" class="dash-btn">Start Shopping</a>
              </div>
            <?php else : ?>
            <div class="orders-table-wrap">
              <table class="orders-table">
                <thead>
                  <tr><th>Order</th><th>Date</th><th>Status</th><th>Total</th><th></th></tr>
                </thead>
                <tbody>
                  <?php foreach ( $all_orders as $order ) : ?>
                  <tr>
                    <td>#<?php echo $order->get_order_number(); ?></td>
                    <td><?php echo wc_format_datetime( $order->get_date_created() ); ?></td>
                    <td><span class="order-status status-<?php echo $order->get_status(); ?>"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span></td>
                    <td><?php echo $order->get_formatted_order_total(); ?></td>
                    <td><a href="<?php echo $order->get_view_order_url(); ?>" class="view-order-btn">View</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?php endif; ?>
          </div>

        <?php // ---- ADDRESS TAB ----
        elseif ( $tab === 'address' ) : ?>
          <div class="dash-section">
            <h2>My Addresses</h2>
            <div class="address-grid">
              <div class="address-card">
                <h4>Billing Address</h4>
                <?php
                $billing = array(
                    get_user_meta( $current_user->ID, 'billing_first_name', true ) . ' ' . get_user_meta( $current_user->ID, 'billing_last_name', true ),
                    get_user_meta( $current_user->ID, 'billing_address_1', true ),
                    get_user_meta( $current_user->ID, 'billing_city', true ) . ', ' . get_user_meta( $current_user->ID, 'billing_postcode', true ),
                    get_user_meta( $current_user->ID, 'billing_country', true ),
                );
                $billing_str = implode( '<br>', array_filter( array_map( 'trim', $billing ) ) );
                echo $billing_str ? '<address>' . $billing_str . '</address>' : '<p class="no-address">No billing address saved.</p>';
                ?>
                <a href="<?php echo wc_get_endpoint_url( 'edit-address', 'billing', wc_get_page_permalink('myaccount') ); ?>" class="dash-btn-sm">Edit</a>
              </div>
              <div class="address-card">
                <h4>Shipping Address</h4>
                <?php
                $shipping = array(
                    get_user_meta( $current_user->ID, 'shipping_first_name', true ) . ' ' . get_user_meta( $current_user->ID, 'shipping_last_name', true ),
                    get_user_meta( $current_user->ID, 'shipping_address_1', true ),
                    get_user_meta( $current_user->ID, 'shipping_city', true ) . ', ' . get_user_meta( $current_user->ID, 'shipping_postcode', true ),
                    get_user_meta( $current_user->ID, 'shipping_country', true ),
                );
                $shipping_str = implode( '<br>', array_filter( array_map( 'trim', $shipping ) ) );
                echo $shipping_str ? '<address>' . $shipping_str . '</address>' : '<p class="no-address">No shipping address saved.</p>';
                ?>
                <a href="<?php echo wc_get_endpoint_url( 'edit-address', 'shipping', wc_get_page_permalink('myaccount') ); ?>" class="dash-btn-sm">Edit</a>
              </div>
            </div>
          </div>

        <?php // ---- PASSWORD TAB ----
        elseif ( $tab === 'password' ) :
            $pw_error = '';
            $pw_success = '';
            if ( isset( $_POST['synth_pw_submit'] ) ) {
                $current_pw = $_POST['synth_current_pw'];
                $new_pw     = $_POST['synth_new_pw'];
                $confirm_pw = $_POST['synth_confirm_pw'];
                if ( ! wp_check_password( $current_pw, $current_user->user_pass, $current_user->ID ) ) {
                    $pw_error = 'Current password is incorrect.';
                } elseif ( strlen( $new_pw ) < 6 ) {
                    $pw_error = 'New password must be at least 6 characters.';
                } elseif ( $new_pw !== $confirm_pw ) {
                    $pw_error = 'New passwords do not match.';
                } else {
                    wp_set_password( $new_pw, $current_user->ID );
                    wp_set_auth_cookie( $current_user->ID );
                    $pw_success = 'Password updated successfully.';
                }
            }
        ?>
          <div class="dash-section">
            <h2>Change Password</h2>
            <?php if ( $pw_error ) : ?><div class="auth-alert error"><?php echo esc_html( $pw_error ); ?></div><?php endif; ?>
            <?php if ( $pw_success ) : ?><div class="auth-alert success"><?php echo esc_html( $pw_success ); ?></div><?php endif; ?>
            <form method="post" class="auth-form">
              <div class="form-field">
                <label>Current Password</label>
                <input type="password" name="synth_current_pw" required placeholder="Enter current password">
              </div>
              <div class="form-field">
                <label>New Password</label>
                <input type="password" name="synth_new_pw" required placeholder="Min. 6 characters">
              </div>
              <div class="form-field">
                <label>Confirm New Password</label>
                <input type="password" name="synth_confirm_pw" required placeholder="Repeat new password">
              </div>
              <button type="submit" name="synth_pw_submit" class="auth-submit">Update Password</button>
            </form>
          </div>
        <?php endif; ?>

      </div><!-- .dashboard-main -->
    </div><!-- .dashboard-layout -->

    <?php else : ?>

    <!-- ===== AUTH FORMS (NOT LOGGED IN) ===== -->
    <div class="auth-panel">

      <!-- LOGO -->
      <div class="auth-logo">
        <a href="<?php echo home_url('/'); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/image/syntherabio-logo.jpeg" alt="Synthera">
        </a>
      </div>

      <?php if ( $action === 'login' ) : ?>

        <!-- LOGIN FORM -->
        <div class="auth-card">
          <h1>Welcome Back</h1>
          <p class="auth-sub">Sign in to your Synthera account</p>

          <?php if ( isset( $login_error ) ) : ?>
            <div class="auth-alert error"><?php echo esc_html( $login_error ); ?></div>
          <?php endif; ?>

          <form method="post" class="auth-form">
            <div class="form-field">
              <label for="synth_username">Username or Email</label>
              <input type="text" id="synth_username" name="synth_username" required
                placeholder="Enter your username or email"
                value="<?php echo isset($_POST['synth_username']) ? esc_attr($_POST['synth_username']) : ''; ?>">
            </div>
            <div class="form-field">
              <label for="synth_password">
                Password
                <a href="?action=forgot" class="label-link">Forgot password?</a>
              </label>
              <div class="input-wrap">
                <input type="password" id="synth_password" name="synth_password" required placeholder="Enter your password">
                <button type="button" class="toggle-pw" data-target="synth_password">
                  <svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                </button>
              </div>
            </div>
            <div class="form-check">
              <label><input type="checkbox" name="synth_remember"> Keep me signed in</label>
            </div>
            <button type="submit" name="synth_login_submit" class="auth-submit">Sign In</button>
          </form>

          <p class="auth-switch">Don't have an account? <a href="?action=register">Create one</a></p>
        </div>

      <?php elseif ( $action === 'register' ) : ?>

        <!-- REGISTER FORM -->
        <div class="auth-card">
          <h1>Create Account</h1>
          <p class="auth-sub">Join Synthera Therapeutics today</p>

          <?php if ( isset( $reg_error ) ) : ?>
            <div class="auth-alert error"><?php echo esc_html( $reg_error ); ?></div>
          <?php endif; ?>

          <form method="post" class="auth-form">
            <div class="form-field">
              <label for="synth_reg_username">Username</label>
              <input type="text" id="synth_reg_username" name="synth_reg_username" required
                placeholder="Choose a username"
                value="<?php echo isset($_POST['synth_reg_username']) ? esc_attr($_POST['synth_reg_username']) : ''; ?>">
            </div>
            <div class="form-field">
              <label for="synth_reg_email">Email Address</label>
              <input type="email" id="synth_reg_email" name="synth_reg_email" required
                placeholder="your@email.com"
                value="<?php echo isset($_POST['synth_reg_email']) ? esc_attr($_POST['synth_reg_email']) : ''; ?>">
            </div>
            <div class="form-field">
              <label for="synth_reg_password">Password</label>
              <div class="input-wrap">
                <input type="password" id="synth_reg_password" name="synth_reg_password" required placeholder="Min. 6 characters">
                <button type="button" class="toggle-pw" data-target="synth_reg_password">
                  <svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                </button>
              </div>
            </div>
            <div class="form-field">
              <label for="synth_reg_confirm">Confirm Password</label>
              <div class="input-wrap">
                <input type="password" id="synth_reg_confirm" name="synth_reg_confirm" required placeholder="Repeat password">
                <button type="button" class="toggle-pw" data-target="synth_reg_confirm">
                  <svg viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                </button>
              </div>
            </div>
            <div class="form-check">
              <label><input type="checkbox" required> I agree to the <a href="#" target="_blank">Terms of Use</a></label>
            </div>
            <button type="submit" name="synth_register_submit" class="auth-submit">Create Account</button>
          </form>

          <p class="auth-switch">Already have an account? <a href="?action=login">Sign in</a></p>
        </div>

      <?php elseif ( $action === 'forgot' ) : ?>

        <!-- FORGOT PASSWORD FORM -->
        <div class="auth-card">
          <h1>Reset Password</h1>
          <p class="auth-sub">Enter your email and we'll send you a reset link</p>

          <?php if ( isset( $forgot_error ) ) : ?>
            <div class="auth-alert error"><?php echo esc_html( $forgot_error ); ?></div>
          <?php endif; ?>
          <?php if ( isset( $forgot_success ) ) : ?>
            <div class="auth-alert success"><?php echo esc_html( $forgot_success ); ?></div>
          <?php endif; ?>

          <?php if ( ! isset( $forgot_success ) ) : ?>
          <form method="post" class="auth-form">
            <div class="form-field">
              <label for="synth_forgot_email">Email Address</label>
              <input type="email" id="synth_forgot_email" name="synth_forgot_email" required
                placeholder="your@email.com"
                value="<?php echo isset($_POST['synth_forgot_email']) ? esc_attr($_POST['synth_forgot_email']) : ''; ?>">
            </div>
            <button type="submit" name="synth_forgot_submit" class="auth-submit">Send Reset Link</button>
          </form>
          <?php endif; ?>

          <p class="auth-switch"><a href="?action=login">← Back to Sign In</a></p>
        </div>

      <?php endif; ?>

    </div><!-- .auth-panel -->

    <?php endif; ?>

  </div><!-- .account-wrap -->
</section>

<?php get_footer(); ?>
