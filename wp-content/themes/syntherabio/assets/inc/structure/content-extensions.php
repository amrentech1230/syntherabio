<?php
/**
 * Adds content structures.
 *
 * @package Theme Horse
 * @subpackage Superior
 * @since Superior 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/superior
 */
/****************************************************************************************/
add_action( 'superior_main_container', 'superior_content', 10 );
/**
 * Function to display the content for the single post, single page, archive page, index page etc.
 */
function superior_content() {
	global $post;
	global $superior_site_layout, $superior_content_layout, $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	global $superior_content_layout;
	if( $post ) {
		$layout = get_post_meta( $post->ID, 'superior_sidebarlayout', true );
		$frontpage_id = get_option('page_on_front'); // for front page
		$banner = get_post_meta( $frontpage_id, 'superior_sidebarlayout', true );
		$page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
		$home_blog = get_post_meta( $page_id, 'superior_sidebarlayout', true ); 
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}
	if(is_front_page() && $banner):
		if( 'default' == $banner ) {//checked from the themeoptions.
		$themeoption_layout = $superior_content_layout;
			if( 'left' == $themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $themeoption_layout ) { 
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $banner ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $banner ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
		elseif(is_front_page()):
		if( 'default' == $layout ) {//checked from the themeoptions.
		$themeoption_layout = $superior_content_layout;
			if( 'left' == $themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $themeoption_layout ) { 
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $layout ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	elseif(is_home()):
		if( 'default' == $home_blog ) {//checked from the themeoptions.
		$themeoption_layout = $superior_content_layout;
			if( 'left' == $themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $themeoption_layout ) { 
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $home_blog ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $home_blog ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	else:
		if( 'default' == $layout ) { //checked from the themeoptions.
		$themeoption_layout = $superior_content_layout;
			if( 'left' == $themeoption_layout ) {

			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $themeoption_layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $layout ) {//checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	endif;
}

/****************************************************************************************/
add_action( 'superior_before_loop_content', 'superior_loop_before', 10 );
/**
 * Contains the opening div
 */
function superior_loop_before() {
	echo '<div id="main">';
}
/****************************************************************************************/
add_action( 'superior_loop_content', 'superior_theloop', 10 );
/**
 * Shows the loop content
 */
function superior_theloop() {
	if( is_page() ) {
		superior_theloop_for_page();
	}
	elseif( is_single() ) {
		superior_theloop_for_single();
	}
	elseif( is_search() ) {
		superior_theloop_for_search();
	}
	else {
		superior_theloop_for_archive();
	}
}
/****************************************************************************************/
if ( ! function_exists( 'superior_theloop_for_archive' ) ) :
/**
 * Fuction to show the archive loop content.
 */
function superior_theloop_for_archive() {
	global $post;
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	$i = 1;
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				do_action( 'superior_before_post' );
				if($i % 2 == 1){ 
					$classes = array(
						'clearfix',
						'odd',
					);
				}else{
					$classes = array(
						'clearfix',
					);
				}
				$attachment_id = get_post_thumbnail_id();
				$image_attributes = wp_get_attachment_image_src($attachment_id,'full'); // returns an array ?>
					<section id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
						<?php do_action( 'superior_before_post_header' );
							if ($image_attributes) {
								$image = '';
								$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
								$image 	.= '<figure class="post-featured-image">';
								$image 	.= '<a title="'.$title_attribute.'" href="'.esc_url(get_permalink()).'" style="'.'background-image:url('."'".esc_url($image_attributes[0])."'".');"></a>
								</figure><!-- .post-featured-image -->';
								echo $image;
							} ?>
							<div class="post-featured-content">
							<?php if(!empty($image_attributes)){?>
								<article>
								<?php }else{ ?>
								<article class="container">
								<?php }
								if(has_post_format( 'link' )){ // for format link?>
									<header class="entry-header">
										<h2 class="entry-title">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
													<?php the_title();?>
												</a>
											</h2><!-- .entry-title -->
									</header>
									<div class="entry-content clearfix">
										<?php the_excerpt(); ?>
									</div><!-- .entry-content -->
								<?php }elseif(has_post_format( 'quote' )){  // for format quote?>
									<div class="entry-content clearfix">
										<?php the_excerpt(); ?>
									</div><!-- .entry-content -->
									<?php }else{
									if(is_sticky()){ ?>
										<span class="sticky-post"><?php _e('Featured','superior');?></span>
									<?php } ?>
									<header class="entry-header">
										<?php if (get_the_author() !='' && $superior_settings['superior_post_category'] ==0){?>
											<div class="entry-meta">
												<span class="cat-links"><?php the_category(', '); ?></span><!-- .cat-links --> 
											</div> <!-- .entry-meta -->
											<?php }
								      	if (has_category() !=''){
									      	if($superior_settings['superior_post_author'] ==0 || $superior_settings['superior_post_date'] ==0 || $superior_settings['superior_post_comments'] ==0 ):?>
													<div class="entry-meta entry-meta-border clearfix">
													<?php if($superior_settings['superior_post_author'] ==0 ): ?>
														<div class="by-author vcard author">
															<span class="fn">
																<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>">
																<?php echo esc_html( get_the_author() ); ?> </a>
															</span>
														</div>
													<?php endif;
													if($superior_settings['superior_post_date'] ==0 ):  ?>
														<div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
															<?php the_time( get_option( 'date_format' ) ); ?></a>
														</div>
													<?php endif;
													if($superior_settings['superior_post_comments'] ==0 ):
														if ( comments_open() ) { ?>
														<div class="comments">
															<?php comments_popup_link( __( 'No Comments', 'superior' ), __( '1 Comment', 'superior' ), __( '% Comments', 'superior' ), '', __( 'Comments Off', 'superior' ) ); ?>
														</div>
														<?php
														}
													endif;?>
													</div><!-- .entry-meta -->
												<?php endif; ?>
												<h2 class="entry-title">
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
														<?php the_title();?>
													</a>
												</h2><!-- .entry-title -->
									</header><!-- .entry-header -->
									<div class="entry-content clearfix">
										<?php the_excerpt(); ?>
										<p><a href="<?php the_permalink();?>" class="readmore"><?php _e('Continue reading','superior')?></a>
										</p>
									</div><!-- .entry-content -->
									<?php $tag_list = get_the_tag_list( '', __( ', ', 'superior' ) );
									if(!empty($tag_list) && $superior_settings['superior_post_tags'] ==0){ ?>
									<footer class="entry-meta clearfix">
										<span class="tag-links">
											<?php   echo $tag_list; ?>
										</span><!-- .tag-links -->
									</footer><!-- .entry-meta -->
									<?php  }
									}else { ?>
										<p> <?php the_content(); ?> </p>
									</header><!-- .entry-header -->
									<?php }
									} ?>
							</article>
						</div>
					</section><!-- post -->
				<?php do_action( 'superior_after_post' );
				$i++;
			} 
		} else { ?>
			<h2 class="entry-title">
				<?php _e( 'No Posts Found.', 'superior' ); ?>
			</h2>
		<?php }
	}
endif;
/****************************************************************************************/
if ( ! function_exists( 'superior_theloop_for_page' ) ) :
/**
 * Fuction to show the page content.
 */
function superior_theloop_for_page() { ?>
	<div <?php post_class(); ?>>
	<?php global $post;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
				do_action( 'superior_before_post' ); ?>
				<?php
					if( is_home() || is_front_page() ) { ?>
				<header class="entry-header">
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2><!-- .entry-title -->
				</header>
				<?php
					}
				do_action( 'superior_after_post_header' );
				do_action( 'superior_before_post_content' ); ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
					wp_link_pages( array( 
					'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'superior' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1
					) );
				?>
				<?php 
					do_action( 'superior_after_post_content' );
					do_action( 'superior_before_comments_template' );
					comments_template(); 
					do_action ( 'superior_after_comments_template' );
				?>
		<?php
			do_action( 'superior_after_post' );
		}
	}
	else { ?>
	<h2 class="entry-title">
		<?php _e( 'No Posts Found.', 'superior' ); ?>
	</h2>
<?php
	}
		echo '</div><!-- .page -->';
}
endif;
/****************************************************************************************/
if ( ! function_exists( 'superior_theloop_for_single' ) ) :
/**
 * Fuction to show the single post content.
 */
function superior_theloop_for_single() {
	global $post;
	global $superior_settings,$superior_array_of_default_settings;
	$superior_settings = wp_parse_args(  get_option( 'superior_theme_settings', array() ),  superior_get_option_defaults() );
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			do_action( 'superior_before_post' ); ?>
			<section id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			<?php do_action( 'superior_before_post_header' ); ?>
				<article>
					<header class="entry-header">
						<?php if(get_the_time( get_option( 'date_format' ) )) { 
							if ($superior_settings['superior_post_category'] ==0){?>
							<div class="entry-meta">
								<span class="cat-links">
									<?php the_category(', '); ?>
								</span><!-- .cat-links --> 
							</div><!-- .entry-meta -->
							<?php } ?>
							<?php if($superior_settings['superior_post_author'] ==0 || $superior_settings['superior_post_date'] ==0 || $superior_settings['superior_post_comments'] ==0 ): ?>
								<div class="entry-meta entry-meta-border clearfix">
								<?php if($superior_settings['superior_post_author'] ==0 ):?>
									<div class="by-author vcard author">
										<span class="fn">
											<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>">
											<?php echo esc_html( get_the_author() ); ?> </a>
										</span>
									</div>
								<?php endif; 
								if($superior_settings['superior_post_date'] ==0 ):?>
									<div class="date updated"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
										<?php the_time( get_option( 'date_format' ) ); ?> </a>
									</div>
								<?php endif;
								if ( comments_open() ) {
									if($superior_settings['superior_post_comments'] ==0 ): ?>
									<div class="comments">
										<?php comments_popup_link( __( 'No Comments', 'superior' ), __( '1 Comment', 'superior' ), __( '% Comments', 'superior' ), '', __( 'Comments Off', 'superior' ) ); ?>
									</div>
									<?php endif; 
								} ?>
								</div><!-- .entry-meta -->
							<?php endif; ?>
							<h2 class="entry-title"><?php the_title();?> </h2> <!-- .entry-title -->
						<?php } ?>
					</header><!-- .entry-header -->
					<div class="entry-content clearfix">
						<?php the_content();
						wp_link_pages( array( 
							'before'			=> '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'superior' ),
							'after'			=> '</div>',
							'link_before'	=> '<span>',
							'link_after'	=> '</span>',
							'pagelink'		=> '%',
							'echo'			=> 1
						) ); ?>
					</div><!-- entry content clearfix -->
					<?php if( is_single() ) {
						$tag_list = get_the_tag_list( '', __( ', ', 'superior' ) );
					if($superior_settings['superior_post_tags'] ==0){ ?>
					<footer class="entry-meta clearfix">
						<?php if( !empty( $tag_list ) ) { ?>
							<span class="tag-links">
								<?php echo $tag_list;?>
							</span><!-- .tag-links -->
						<?php } ?>
					</footer><!-- .entry-meta -->
					<?php }
					}
						do_action( 'superior_before_comments_template' );
						comments_template();
						do_action ( 'superior_after_comments_template' );
						?>
				</article>
		</section><!-- .post -->
<?php
			do_action( 'superior_after_post_content' );
			do_action( 'superior_after_post' );
		}
	}
	else {
	?>
		<h2 class="entry-title">
			<?php _e( 'No Posts Found.', 'superior' ); ?>
		</h2>
	<?php
	}
}
endif;
/****************************************************************************************/
if ( ! function_exists( 'superior_theloop_for_search' ) ) :
/**
 * Fuction to show the search results.
 */
function superior_theloop_for_search() {
	global $post;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			do_action( 'superior_before_post' ); ?>
		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<article class="entry-wrap">
				<?php do_action( 'superior_before_post_header' ); ?>
					<div class="entry-main">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
									<?php the_title(); ?>
								</a>
							</h2><!-- .entry-title -->
						</header>
						<?php do_action( 'superior_after_post_header' ); ?>
						<?php do_action( 'superior_before_post_content' ); ?>
						<div class="entry-content clearfix">
							<?php the_excerpt(); ?>
						</div>
						<?php do_action( 'superior_after_post_content' ); ?>
					</div><!-- .entry-main -->
			</article>
		</section>
			<?php do_action( 'superior_after_post' );
		}
	}
	else {
		?>
	<h2 class="entry-title">
		<?php _e( 'No Posts Found.', 'superior' ); ?>
	</h2>
<?php
	}
}
endif;
/****************************************************************************************/
add_action( 'superior_after_loop_content', 'superior_next_previous', 5 );
/**
 * Shows the next or previous posts
 */
function superior_next_previous() {
	if( is_archive() || is_home() || is_search() ) {
		/**
		 * Checking WP-PageNaviplugin exist
		 */
		if ( function_exists('wp_pagenavi' ) ) :
			wp_pagenavi();
		else: 
			global $wp_query;
			if ( $wp_query->max_num_pages > 1 ) : ?>
				<div class="nav-links clearfix">
					<div class="nav-previous">
						<span class="meta-nav"><?php next_posts_link( __( 'Previous', 'superior' ) ); ?></span>
					</div>
					<div class="nav-next">
						<span class="meta-nav"><?php previous_posts_link( __( 'Next', 'superior' ) ); ?></span>
					</div>
				</div>
			<?php
			endif;
		endif;
	}
}
/****************************************************************************************/
add_action( 'superior_after_post_content', 'superior_next_previous_post_link', 10 );
/**
 * Shows the next or previous posts link with respective names.
 */
function superior_next_previous_post_link() {
	if ( is_single() ) {
		if( is_attachment() ) {
		?>
		<div class="nav-links clearfix">
			<div class="nav-previous">
				<span class="meta-nav"> <?php previous_image_link( false, __( 'Previous', 'superior' ) ); ?> </span>
			</div>
				<div class="nav-next">
					<span class="meta-nav"><?php next_image_link( false, __( 'Next', 'superior' ) ); ?></span>
				</div>
			</div>
		<?php
		}
		else {
		?>
		<div class="nav-links clearfix">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '<span class="meta-nav">' . __( 'Previous', 'superior' ) . '</span>'. '<span class="screen-reader-text">' . __( 'Previous post:','superior') . '</span>' . ' <span class="post-title">%title </span>' ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '<span class="meta-nav">' . __( 'Next', 'superior' ) . '</span>'. '<span class="screen-reader-text">' . __( 'Next post:','superior') . '</span>'.'<span class="post-title">%title </span>' ); ?>
			</div>
		</div>
<?php
		}
	}
}
/****************************************************************************************/
add_action( 'superior_after_loop_content', 'superior_loop_after', 10 );
/**
 * Contains the closing div
 */
function superior_loop_after() {
	echo '</div><!-- #main -->';
}
/****************************************************************************************/
if ( ! function_exists( 'superior_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own superior_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Superior 1.0
 */
function superior_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<p>
		<?php _e( 'Pingback:', 'superior' ); ?>
		<?php comment_author_link(); ?>
		<?php edit_comment_link( __( '(Edit)', 'superior' ), '<span class="edit-link">', '</span>' ); ?>
	</p>
	<?php
		break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment">
		<header class="comment-meta comment-author vcard">
			<?php
				echo get_avatar( $comment, 44 );
				printf( '<cite class="fn">%1$s %2$s</cite>',
				get_comment_author_link(),
				// If current post author is also comment author, make it known visually.
				( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'superior' ) . '</span>' : ''
				);
				printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
				esc_url( get_comment_link( $comment->comment_ID ) ),
				get_comment_time( 'c' ),
				/* translators: 1: date, 2: time */
				sprintf( __( '%1$s at %2$s', 'superior' ), get_comment_date(), get_comment_time() )
				);
			?>
		</header> <!-- .comment-meta -->
		<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation">
				<?php _e( 'Your comment is awaiting moderation.', 'superior' ); ?>
			</p>
		<?php endif; ?>
		<section class="comment-content comment">
			<?php comment_text(); ?>
			<?php edit_comment_link( __( 'Edit', 'superior' ), '<p class="edit-link">', '</p>' ); ?>
		</section><!-- .comment-content -->
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'superior' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply --> 
	</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
?>
