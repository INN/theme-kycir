<!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?php
	// get the current page url (used for rel canonical and open graph tags)
	global $current_url;
	$current_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>
<title>
	<?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' ); // Add the blog name.

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . 'Page ' . max( $paged, $page );
	?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php

	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="top"></div>
<div class="capital-campaign">
	<a href="http://campaign.louisvillepublicmedia.org"><img class="small-img" src="http://campaign.louisvillepublicmedia.org/wp-content/uploads/RYV16_lpm-app_640x202_inv.png"><img class="large-img" src="http://campaign.louisvillepublicmedia.org/wp-content/uploads/RYV16_940x120_inv.png"></a>
</div>
<div class="global-nav-bg">
	<div class="global-nav">
		<nav id="top-nav" class="span12">
        	<span class="visuallyhidden">
        		<a href="#main" title="Skip to content"><?php _e('Skip to content', 'largo'); ?></a>
        	</span>
        	<?php
				$args = array(
					'theme_location' => 'global-nav',
					'depth'		 => 1,
					'container'	 => false,
				);
				wp_nav_menu($args);
			?>
        	<div class="nav-right">

        		<?php if ( of_get_option( 'show_header_social') ) { ?>
	        		<ul id="header-social" class="social-icons visible-desktop">
						<?php largo_social_links(); ?>
					</ul>
				<?php } ?>

        		<?php if ( of_get_option( 'show_donate_button') )
        			largo_donate_button();
        		?>

				<div id="header-search">
					<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="input-append">
							<input type="text" placeholder="<?php _e('Search', 'largo'); ?>" class="input-medium appendedInputButton search-query" value="" name="s" /><button type="submit" class="search-submit btn"><?php _e('GO', 'largo'); ?></button>
						</div>
					</form>
				</div>


				<?php if ( INN_MEMBER === TRUE ) { ?>
				<div class="org-logo">
        			<a href="http://investigativenewsnetwork.org/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/inn-logo-80-55.jpg" height="55" alt="INN logo" /></a>
        			<a href="http://louisvillepublicmedia.org//" target="_blank"><img class="lpm" src="<?php echo get_stylesheet_directory_uri(); ?>/img/lpm-55.jpg" height="55" alt="LPM logo" /></a>
        			<a href="http://wfpl.org//" target="_blank"><img class="lpm" src="<?php echo get_stylesheet_directory_uri(); ?>/img/wfpl-55.jpg" height="55" alt="WFPL logo" /></a>

				</div>
				<?php } ?>

        	</div>
        </nav>
    </div> <!-- /.global-nav -->
</div> <!-- /.global-nav-bg -->


	<header class="print-header">
		<p><strong><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></strong> (<?php echo $current_url ?>)</p>
	</header>
	<header id="main">
		<div class="header-inside">
			<div class="logo">
			  	<a href="/">
			  		<img class="hidden-phone" src="<?php echo get_stylesheet_directory_uri(); ?>/img/kycir-120.png" alt="kycir logo" />
			  		<img class="visible-phone" src="<?php echo get_stylesheet_directory_uri(); ?>/img/kycir-60.png" alt="kycir logo" />
			  	</a>
			</div>
			<nav id="main-nav" class="navbar clearfix">
			  <div class="navbar-inner">
			    <div class="container">

			      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			        <div class="bars">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
			        </div>
			      </a>

			      <ul class="nav hidden-phone">
			        <?php
						$args = array(
							'theme_location' => 'navbar-supplemental',
							'depth'		 => 0,
							'container'	 => false,
							'items_wrap' => '%3$s',
							'menu_class' => 'nav',
							'walker'	 => new Bootstrap_Walker_Nav_Menu()
						);
						wp_nav_menu($args);
					?>
			      </ul>

			      <!-- Everything you want hidden at 940px or less, place within here -->
			      <div class="nav-collapse visible-phone">
			        <ul class="nav">
			        	<?php
							$args = array(
								'theme_location' => 'navbar-supplemental',
								'depth'		 => 1,
								'container'	 => false,
								'items_wrap' => '%3$s'
							);

							wp_nav_menu($args);
						?>
			        </ul>
			      </div>
			    </div>
			  </div>
			</nav>
			<?php if ( of_get_option( 'show_dont_miss_menu') ) : ?>
			<nav id="secondary-nav" class="clearfix">
		    	<div id="topics-bar" class="span12 hidden-phone">
					<?php wp_nav_menu( array( 'theme_location' => 'dont-miss', 'container' => false, 'depth' => 1 ) ); ?>
				</div>
			</nav>
			<?php endif; ?>
		</div>
	</header>
<div id="page" class="hfeed clearfix">
<div id="main" class="row-fluid clearfix">