<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.1 Plugin: WP-Print 2.11										|
|	Copyright (c) 2007 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://www.lesterchan.net													|
|																							|
|	File Information:																	|
|	- Printer Friendly Page															|
|	- wp-print.php																		|
|																							|
+----------------------------------------------------------------+
*/


### Variables
$links_text = '';

### Actions
add_action('init', 'print_content');

### Filters
add_filter('wp_title', 'print_pagetitle');
add_filter('comments_template', 'print_template_comments');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Robots" content="noindex, nofollow" />
<style type="text/css" media="screen, print">
Body {
	font-family: Verdana, Arial, Tahoma;
	font-size: 12px;
	color: #000000;
}
#Outline {
	text-align: left;
	width: 90%;
	margin-left: auto; 
	margin-right: auto;
	padding: 10px;
	border: 1px solid #000000;
}
#BlogTitle {
	font-weight: bold;
	font-size: 16px;
	margin-bottom: 5px;
}
#BlogDate {
	margin-top: 5px;
	margin-bottom: 10px;	
}
#BlogContent {
	padding: 10px;
	margin-top: 10px;
}
HR.Divider {
	width: 80%; 
	height: 1px; 
	color: #000000;
}
#CommentTitle {
	font-weight: bold;
	font-size: 16px;
	padding-bottom: 10px;
}
.CommentDate {
	margin-top: 5px;
	margin-bottom: 10px;
}
.CommentContent {
	padding: 2px 10px 10px 10px;
}
@media print {
    #print-link {
        display: none;
    }
}
</style>
</head>
<body>
<p style="text-align: center;"><strong>- <?php bloginfo('name'); ?> - <?php bloginfo('url')?> -</strong></p>
<center>
	<div id="Outline">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
					<p id="BlogTitle"><?php the_title(); ?></p>
					<p id="BlogDate"><?php _e('Posted By', 'wp-print'); ?> <u><?php the_author(); ?></u> <?php _e('On', 'wp-print'); ?> <?php the_time(get_option("date_format").' @ '.get_option("time_format")); ?> <?php _e('In', 'wp-print'); ?> <?php print_categories('<u>', '</u>'); ?> | <u><?php print_comments_number(); ?></u></p>
					<div id="BlogContent"><?php print_content(); ?></div>
			<?php endwhile; ?>
			<hr class="Divider" style="text-align: center;" />
			<?php if(print_can('comments')): ?>
				<?php comments_template(); ?>
			<?php endif; ?>
			<p style="text-align: left;"><?php _e('Article printed from', 'wp-print'); ?> <?php bloginfo('name'); ?>: <strong><?php bloginfo('url'); ?></strong></p>
			<p style="text-align: left;"><?php _e('URL to article', 'wp-print'); ?>: <strong><?php the_permalink(); ?></strong></p>
			<?php if(print_can('links')): ?>
				<p style="text-align: left;"><?php print_links(); ?></p>
			<?php endif; ?>
			<p style="text-align: right;" id="print-link"><?php _e('Click', 'wp-print'); ?> <a href="#Print" onclick="window.print(); return false;" title="<?php _e('Click here to print.', 'wp-print'); ?>"><?php _e('here', 'wp-print'); ?></a> <?php _e('to print.', 'wp-print'); ?></p>
		<?php else: ?>
				<p style="text-align: left;"><?php _e('No posts matched your criteria.', 'wp-print'); ?></p>
		<?php endif; ?>
	</div>
</center>
</body>
</html>