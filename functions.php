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
 * Don't remove leading images in posts when the lead image matches the featured image
 * @see largo_remove_hero
 * @since Largo 0.5.5.3
 */
function kycir_largo_remove_hero( $whether, $post = null ) {
	return false;
}
add_action( 'largo_remove_hero', 'kycir_largo_remove_hero' );
