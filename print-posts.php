<?php
/*
 * WordPress Plugin: WP-Print
 * Copyright (c) 2012 Lester "GaMerZ" Chan
 *
 * File Written By:
 * - Lester "GaMerZ" Chan
 * - http://lesterchan.net
 *
 * File Information:
 * - Printer Friendly Post/Page Template
 * - wp-content/plugins/wp-print/print-posts.php
 */

global $text_direction;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="Robots" content="noindex, nofollow" />
	<?php if(@file_exists(get_stylesheet_directory().'/print-css.css')): ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css.css" type="text/css" media="screen, print" />
	<?php else: ?>
		<link rel="stylesheet" href="<?php echo plugins_url('wp-print/print-css.css'); ?>" type="text/css" media="screen, print" />
	<?php endif; ?>
	<?php if('rtl' == $text_direction): ?>
		<?php if(@file_exists(get_stylesheet_directory().'/print-css-rtl.css')): ?>
			<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css-rtl.css" type="text/css" media="screen, print" />
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo plugins_url('wp-print/print-css-rtl.css'); ?>" type="text/css" media="screen, print" />
		<?php endif; ?>
	<?php endif; ?>
	<link rel="canonical" href="<?php the_permalink(); ?>" />
</head>
<body>

<main role="main" class="center">

	<?php if (have_posts()): ?>

		<header class="entry-header">

			<span class="hat">
				<strong>
					- <?php bloginfo('name'); ?> 
					- 
					<span dir="ltr"><?php bloginfo('url')?></span> 
					-
				</strong>
			</span>
			
			<?php while (have_posts()): the_post(); ?>

			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>

			<span class="entry-date">

				<?php _e('Posted By', 'wp-print'); ?> 

				<cite><?php the_author(); ?></cite> 

				<?php _e('On', 'wp-print'); ?> 

				<time>	
					<?php the_time(sprintf(__('%s @ %s', 'wp-print'), 
						get_option('date_format'), 
						get_option('time_format'))); 
					?> 
				</time>

			  	<span>
			  		<?php _e('In', 'wp-print'); ?> 
			  		<?php print_categories(); ?> | 
			  	</span>	

		  		<a href='#comments_controls'>
		  			<?php print_comments_number(); ?>
	  			</a>	  			

				</span>
			
		</header>	

		<div class="entry-content">

			<?php print_content(); ?>

		</div>

	<?php endwhile; ?>
	
	<div class="comments">
		<?php if(print_can('comments')): ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</div>
	
	<footer class="footer">
		<p>
			<?php _e('Article printed from', 'wp-print'); ?> 
			<?php bloginfo('name'); ?>: 

			<strong dir="ltr">
				<?php bloginfo('url'); ?>
			</strong>
		</p>

		<p>
			<?php _e('URL to article', 'wp-print'); ?>: 
			<strong dir="ltr">
				<?php the_permalink(); ?>
			</strong>
		</p>
		
		<?php if(print_can('links')): ?>
			<p><?php print_links(); ?></p>
		<?php endif; ?>

		<p style="text-align: <?php echo ('rtl' == $text_direction) ? 'left' : 'right'; ?>;" id="print-link">
			<a href="#Print" onclick="window.print(); return false;" title="<?php _e('Click here to print.', 'wp-print'); ?>">
				<?php _e('Click', 'wp-print'); ?> 
				<?php _e('here', 'wp-print'); ?>
				<?php _e('to print.', 'wp-print'); ?>
			</a> 
		</p>

		<?php else: ?>
			<p>
				<?php _e('No posts matched your criteria.', 'wp-print'); ?>
			</p>
		<?php endif; ?>

		<p style="text-align: center;">
			<?php echo stripslashes($print_options['disclaimer']); ?>
		</p>
	</footer>

</main>


</body>
</html>
