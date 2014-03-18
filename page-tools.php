<?php
/**
 * Template Name: Tools Page
 * Description: Custom Page Template for the Tools Page
 */
get_header();
?>

<div id="content" class="span12" role="main">
	<?php
		while ( have_posts() ) : the_post();
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php edit_post_link(__('Edit This Page', 'largo'), '<h5 class="byline"><span class="edit-link">', '</span></h5>'); ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
				$args = array(
					'post_parent'	=> $post->ID,
					'post_type'		=> 'page',
					'numberposts'	=> -1,
					'post_status'	=> 'publish'
				);
				$children = get_children( $args );

				foreach ( $children as $page ) {
					//print_r($page);
					$permalink = get_permalink( $page->ID );
					echo '<div class="span4">';
					echo '<a href="' . $permalink . '" title="' . $page->post_title .'">' . get_the_post_thumbnail( $page->ID, 'homepage_thumb' ) . '</a>';
					echo '<h3><a href="' . $permalink . '" title="' . $page->post_title .'">' . $page->post_title . '</h3></a>';
					echo '<p>' . $page->post_excerpt . '</p>';
					echo '</div>';
				}
				?>

			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php
		endwhile; // end of the loop.
	?>
</div><!--#content-->

<?php get_footer(); ?>