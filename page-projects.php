<?php
/*
Template Name: Projects Page
*/
get_header();
?>

<div id="content" class="span12" role="main">
	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php edit_post_link(__('Edit This Page', 'largo'), '<h5 class="byline"><span class="edit-link">', '</span></h5>'); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				$tax_args = array(
					'orderby' 	=> 'name',
					'taxonomy' 	=> 'series',
					'name'		=> 'term_id',
					'id'		=> 'term_id'
		    	);

				$series = get_categories($tax_args);
				foreach ( $series as $out ) {

					$args = array(
						'tax_query' => array(
							array(
								'taxonomy' 	=> 'series',
								'field' 	=> 'slug',
								'terms' 	=> $out->slug
							)
						),
						'showposts'		=> 1
					);
					$query = new WP_Query($args);
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : $query->the_post();
					?>
						<div class="item">
							<a href="<?php echo get_term_link( $out, $out->taxonomy ); ?>"><?php the_post_thumbnail(); ?></a>
							<h3><a href="<?php echo get_term_link( $out, $out->taxonomy ); ?>"><?php echo $out->name; ?></a></h3>
							<?php if ($out->category_description) echo '<p>' . $out->category_description . '</p>'; ?>
							<p class="recent"><strong>Latest Update:</strong> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
						</div>
					<?php
						endwhile;
					endif;
				}
			?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>