<?php
/**
 * Displays the 404 error page of the theme.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 */
?>
<?php get_header(); ?>
	<div id="main">
		<header class="entry-header">
			<h1 class="entry-title">
				<?php _e('Error 404-Page NOT Found', 'superior'); ?>
			</h1>
		</header>
		<div class="entry-content clearfix" >
			<p>
				<?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'superior'); ?>
			</p>
			<h3>
				<?php _e('This might be because:', 'superior'); ?>
			</h3>
			<p>
				<?php _e('You have typed the web address incorrectly, or the page you were looking for may have been moved, updated or deleted.', 'superior'); ?>
			</p>
			<h3>
				<?php _e('Please try the following instead:', 'superior'); ?>
			</h3>
			<p>
				<?php _e('Check for a mis-typed URL error, then press the refresh button on your browser.', 'superior'); ?>
			</p>
		</div> <!-- .entry-content --> 
	</div><!-- #main -->
<?php get_footer(); ?>