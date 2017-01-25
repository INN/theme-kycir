<?php

/* This theme uses Adobe Typekit for a few custom fonts (https://typekit.com).
 * The ID is unique to this particular site so if you wanted to use this theme for another site
 * you would need to register with Typekit and get your own ID.
 * @since 0.1.0
 */
function kycir_head() { ?>
	<!--typekit-->
	<script type="text/javascript" src="//use.typekit.net/zsh4siz.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

	<!--DFP-->
	<script type='text/javascript'>
	(function() {
	var useSSL = 'https:' == document.location.protocol;
	var src = (useSSL ? 'https:' : 'http:') +
	'//www.googletagservices.com/tag/js/gpt.js';
	document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
	})();
	</script>

	<script type='text/javascript'>
	googletag.defineSlot('/13076449/KYCIR-Bottom', [300, 250], 'div-gpt-ad-1390966279948-0').addService(googletag.pubads());
	googletag.defineSlot('/13076449/KYCIR-Top', [300, 250], 'div-gpt-ad-1390966279948-1').addService(googletag.pubads());
	googletag.pubads().enableSyncRendering();
	googletag.pubads().enableSingleRequest();
	googletag.enableServices();
	</script>

	<!--NPR network GA-->
	<script type="text/javascript">(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = '//stream.publicbroadcasting.net/analytics/aadc.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
<?php
}
add_action( 'wp_head', 'kycir_head' );

/**
 * Include compiled child.css
 * @since 0.1.1
 */
function largo_child_stylesheet() {
	wp_dequeue_style( 'largo-child-styles' );
	wp_enqueue_style( 'largoproject', get_stylesheet_directory_uri() . '/css/child.css' );
}
add_action( 'wp_enqueue_scripts', 'largo_child_stylesheet', 20 );

/**
 * Custom image sizes
 * @since 0.1.0
 */
add_image_size( 'homepage_thumb', 800, 600, true );

/**
 * Custom function to get post thumbnails
 * @since 0.1.0
 */
function kycir_get_post_thumbnail_caption() {
	if ( $thumb = get_post_thumbnail_id() ) {
		return get_post( $thumb )->post_excerpt;
	}
}

/**
 * Add excerpt support to pages
 * @since 0.1.0
 */
function kycir_add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'kycir_add_excerpts_to_pages' );

/**
 * Plugging a largo function because ???
 * @since 0.1.0
 */
function largo_content_nav( $nav_id ) {
	global $wp_query;

	if ( $nav_id === 'single-post-nav-below' ) { ?>

		<nav id="nav-below" class="pager post-nav clearfix">
			<?php
				if ( $prev = get_previous_post() ) {
					if( get_the_post_thumbnail( $prev->ID ) ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev->ID ) );
						printf( __('<div class="previous"><a href="%1$s"><img class="thumb" src="%4$s" /><h5>Previous %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
							get_permalink( $prev->ID ),
							of_get_option( 'posts_term_singular' ),
							$prev->post_title,
							$image[0]
						);
					} else {
						printf( __('<div class="previous"><a href="%1$s"><h5>Previous %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
							get_permalink( $prev->ID ),
							of_get_option( 'posts_term_singular' ),
							$prev->post_title
						);
					}
				}
				if ( $next = get_next_post() ) {
					if( get_the_post_thumbnail( $next->ID ) ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ) );
						printf( __('<div class="next"><a href="%1$s"><img class="thumb" src="%4$s" /><h5>Next %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
							get_permalink( $next->ID ),
							of_get_option( 'posts_term_singular' ),
							$next->post_title,
							$image[0]
						);
					} else {
						printf( __('<div class="next"><a href="%1$s"><h5>Next %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
							get_permalink( $next->ID ),
							of_get_option( 'posts_term_singular' ),
							$next->post_title
						);
					}
				}
				?>
		</nav><!-- #nav-below -->

	<?php } elseif ( $wp_query->max_num_pages > 1 ) {
		$posts_term = of_get_option( 'posts_term_plural' );
		if ( !$posts_term ) $posts_term = 'Posts';
		$previous_posts_term = sprintf( __( 'Newer %s &rarr;', 'largo' ), $posts_term );
		$next_posts_term =  sprintf( __( '&larr; Older %s', 'largo' ), $posts_term );
	?>

		<nav id="<?php echo $nav_id; ?>" class="pager post-nav">
			<div class="next"><?php previous_posts_link( $previous_posts_term ); ?></div>
			<div class="previous"><?php next_posts_link( $next_posts_term ); ?></div>
		</nav><!-- .post-nav -->

	<?php }
}
