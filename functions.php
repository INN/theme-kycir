<?php

/* This theme uses Adobe Typekit for a few custom fonts (https://typekit.com).
 * The ID is unique to this particular site so if you wanted to use this theme for another site
 * you would need to register with Typekit and get your own ID.
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

// Single sidebar is not used in this theme so we unregister it to avoid confusion
function kycir_sidebars() {
	unregister_sidebar( 'sidebar-single');
}
add_action( 'widgets_init', 'kycir_sidebars', 11 );

//Setup the image sizes and width variables
define( 'FULL_WIDTH', 1170 );
define( 'LARGE_WIDTH', 800 );
define( 'MEDIUM_WIDTH', 400 );

$content_width = 800;

add_image_size( 'homepage_thumb', 800, 600, true );

function inn_stories() {
	the_widget( 'largo_INN_RSS_widget', array(
		'title' 		=> __('Stories From Other INN Members', 'largo'),
		'num_posts'		=> 3
		)
	);
}
add_action( 'largo_after_post_footer', 'inn_stories' );

function kycir_get_post_thumbnail_caption() {
	if ( $thumb = get_post_thumbnail_id() )
		return get_post( $thumb )->post_excerpt;
}

function kycir_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'kycir_add_excerpts_to_pages' );

// New functionality that will be in the next release of the Largo parent theme, included here a bit early

/**
 * Add fields to Co-Authors Plus Guest Author
 */
add_filter( 'coauthors_guest_author_fields', 'kycir_filter_guest_author_fields', 10, 2 );
function kycir_filter_guest_author_fields( $fields_to_return, $groups ) {

	if ( in_array( 'all', $groups ) || in_array( 'contact-info', $groups ) ) {
		$fields_to_return[] = array(
					'key'      => 'twitter',
					'label'    => 'Twitter<br><em>https://twitter.com/username<em>',
					'group'    => 'contact-info',
				);
		$fields_to_return[] = array(
					'key'      => 'fb',
					'label'    => 'Facebook<br><em>https://www.facebook.com/username<em>',
					'group'    => 'contact-info',
				);
		$fields_to_return[] = array(
					'key'      => 'linkedin',
					'label'    => 'LinkedIn<br><em>http://www.linkedin.com/in/username<em>',
					'group'    => 'contact-info',
				);
		$fields_to_return[] = array(
					'key'      => 'googleplus',
					'label'    => 'Google+<br><em>https://plus.google.com/userID/<em>',
					'group'    => 'contact-info',
				);
	}
	if ( in_array( 'all', $groups ) || in_array( 'name', $groups ) ) {
		$fields_to_return[] = array(
					'key'      => 'organization',
					'label'    => 'Organization',
					'group'    => 'name',
				);

	}

	return $fields_to_return;
}

function largo_byline( $echo = true ) {
	global $post;
	$values = get_post_custom( $post->ID );

	if ( function_exists( 'get_coauthors' ) && !isset( $values['largo_byline_text'] ) ) {
		$coauthors = get_coauthors( $post->ID );
		count($coauthors);
		foreach( $coauthors as $author ) {
			$byline_text = $author->display_name;
			if ( $org = $author->organization )
				$byline_text .= ' (' . $org . ')';

			$out[]= sprintf('<a class="url fn n" href="/author/%1$s" title="Read All Posts By %2$s" rel="author">%3$s</a>',
				$author->user_login,
				$author->display_name,
				$byline_text
			);
		}

		if ( count($out) > 1 ) {
			end($out);
			$key = key($out);
			reset($array);
			$authors = implode( ', ', array_slice( $out, 0, -1 ) );
			$authors .= ' <span class="and">and</span> ' . $out[$key];
		} else {
			$authors = $out[0];
		}

	} else {
		$authors = largo_author_link( false );
	}

	$output = sprintf( __('<span class="by-author"><span class="by">By:</span> <span class="author vcard" itemprop="author">%1$s</span></span><span class="sep"> | </span><time class="entry-date updated dtstamp pubdate" datetime="%2$s">%3$s</time>', 'largo'),
		$authors,
		esc_attr( get_the_date( 'c' ) ),
		largo_time( false )
	);

	if ( current_user_can( 'edit_post', $post->ID ) )
		$output .=  sprintf( __('<span class="sep"> | </span><span class="edit-link"><a href="%1$s">Edit This Post</a></span>', 'largo'), get_edit_post_link() );

	if ( is_single() && of_get_option( 'clean_read' ) === 'byline' )
	 	$output .=	__('<a href="#" class="clean-read">View as "Clean Read"</a>', 'largo');

	if ( $echo )
		echo $output;
	return $output;
}

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