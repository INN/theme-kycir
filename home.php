<?php
get_header();
$ids = array();
$tags = of_get_option ('tag_display');
?>

<div id="content" class="stories span12" role="main">

<div id="homepage-featured" class="row-fluid clearfix">

	<div class="top-story span8">

	<?php
		// get one story from the top-page term in the prominence taxonomy
		$topstory = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'top-story'
				)
			),
			'showposts' => 1
		) );
		if ( $topstory->have_posts() ) :
			while ( $topstory->have_posts() ) : $topstory->the_post(); $ids[] = get_the_ID(); ?>

				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
				<?php
					if ( $thumb = get_post_thumbnail_id() ) {
						$thumb_content = get_post( $thumb );
						$thumb_custom = get_post_custom( $thumb );
							$out = '<p class="photo-credit">' . $thumb_content->post_excerpt;
							if ( $thumb_custom['_media_credit'][0] ) {
								$out .= ' <span class="credit">Photo: ' . $thumb_custom['_media_credit'][0];
								if ( $thumb_custom['_navis_media_credit_org'][0] ) {
									$out .= '/' . $thumb_custom['_navis_media_credit_org'][0];
								}
								$out .= '</span>';
							}
						echo $out;
					}
				?>
				<div class="top-story-copy-block">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				    <?php largo_excerpt( $post, 4, false ); ?>
				    <h5 class="byline"><?php largo_byline(); ?></h5>
				</div>
			<?php endwhile;
		endif; // end top story ?>
	</div>

	<div class="river span4">
		<?php
		$args = array(
			'post_status'	=> 'publish',
			'post_type'		=> array( 'post', 'argolinks' ),
			'showposts'		=> 6,
			'post__not_in' 	=> $ids
			);
		if ( of_get_option('num_posts_home') )
			$args['posts_per_page'] = of_get_option('num_posts_home');
		if ( of_get_option('cats_home') )
			$args['cat'] = of_get_option('cats_home');
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
			echo '<h3>Latest News</h3>';
			while ( $query->have_posts() ) : $query->the_post();
				if ( get_post_type( $post ) == 'argolinks' ) {
					$custom = get_post_custom( $post->ID );
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						<header>
							<?php
								if ( isset($custom["argo_link_source"][0] ) && ( $custom["argo_link_source"][0] != '' ) ) {
							        echo '<h5 class="top-tag">';
							        echo ( isset( $custom["argo_link_url"][0] ) ) ? '<a href="' . $custom["argo_link_url"][0] . '">' . $custom["argo_link_source"][0] . '</a>' : $custom["argo_link_source"][0];
							        echo '</h5>';
							    }
							?>
							<h2 class="entry-title"><?php echo ( isset( $custom["argo_link_url"][0] ) ) ? '<a href="' . $custom["argo_link_url"][0] . '">' . get_the_title() . '</a>' : get_the_title(); ?></h2>
						</header>
					</article>

				<?php } else { ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						<header>
						 	<h5 class="top-tag"><?php largo_categories_and_tags( 1 ); ?></h5>
					 		<h2 class="entry-title">
					 			<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
					 		</h2>
						</header><!-- / entry header -->
					</article><!-- #post-<?php the_ID(); ?> -->

			<?php }
			endwhile; ?>

			<div class="ad" id='div-gpt-ad-1390966279948-1'>
				<script type='text/javascript'>
				googletag.display('div-gpt-ad-1390966279948-1');
				</script>
			</div>
		<?php
		endif;
		?>
	</div>

	<div class="signup span12">
		<div class="explain span5">
			<p><i class="icon-mail"></i>Sign up for our newsletter</p>
		</div>
		<div class="chevron span1"></div>
		<div class="form span6">
			<form action="//kycir.us7.list-manage.com/subscribe/post?u=0e9871c599e6afe1122a0a60d&amp;id=3fe1cce7ce" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
				<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">
				<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div style="position: absolute; left: -5000px;"><input type="text" name="b_0e9871c599e6afe1122a0a60d_3fe1cce7ce" tabindex="-1" value=""></div>
			</form>
		</div>
	</div>

	<div class="sub-stories span12">
		<?php
		$story_count = 0;
		// get three stories from the homepage-featured term in the prominence taxonomy (with photos)
		$substories = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'homepage-featured'
				)
			),
			'showposts'		=> 4,
			'post__not_in' 	=> $ids
		) );
		if ( $substories->have_posts() ) {
			while ( $substories->have_posts() ) : $substories->the_post(); $ids[] = get_the_ID(); $story_count++; ?>
				<div class="story span3 <?php echo 'story-' . $story_count; ?>">
			        <?php if ( largo_has_categories_or_tags() && $tags === 'top' ) : ?>
			        	<h5 class="top-tag"><?php largo_categories_and_tags(1); ?></h5>
			        <?php endif; ?>
			        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'homepage_thumb' ); ?></a>
			        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    </div>
		<?php
			endwhile;
		}


		// fill the bottom row with recent posts if we didn't find enough featured stories
		if ( $story_count < 4 ) {
			$recent_posts = 4 - $story_count;
			$args = array(
				'post_status'	=> 'publish',
				'showposts'		=> $recent_posts,
				'post__not_in' 	=> $ids
				);
			// in some cases we might want to limit or filter this loop by category, let's add that arg if set in the theme options
			if ( of_get_option('cats_home') )
				$args['cat'] = of_get_option('cats_home');
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) : $query->the_post(); $ids[] = get_the_ID(); $story_count++; ?>
						<div class="story span3 <?php echo 'story-' . $story_count; ?>">
				        	<?php if ( largo_has_categories_or_tags() && $tags === 'top' ) : ?>
				        		<h5 class="top-tag"><?php largo_categories_and_tags(1); ?></h5>
				        	<?php endif; ?>
				        	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'homepage_thumb'); ?></a>
				        	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				        </div>
					<?php
				endwhile;
			}
		} ?>

	</div>


	<?php //get_sidebar(); ?>

</div><!-- #homepage-featured -->
</div><!-- #content -->

<?php get_footer(); ?>