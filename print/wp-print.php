<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.0 Plugin: WP-Print 2.04										|
|	Copyright (c) 2005 Lester "GaMerZ" Chan									|
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
$can_print_comments = false;
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
HR#Divider {
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
	padding: 10px;
	margin-top: 10px;
}
</style>
</head>
<body>
<p align="center"><b>- <?php bloginfo('name'); ?> - <?php bloginfo('url')?> -</b></p>
<center>
	<div id="Outline">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
					<p id="BlogTitle"><?php the_title(); ?></p>
					<p id="BlogDate">Posted By <u><?php the_author(); ?></u> On <?php the_time('jS F Y @ H:i'); ?> In <?php print_categories('<u>', '</u>'); ?> | <u><?php print_comments_number(); ?></u></p>
					<div id="BlogContent"><?php print_content(); ?></div>
			<?php endwhile; ?>
			<hr id="Divider" align="center" />
			<?php if($can_print_comments) { comments_template(); } ?>
			<p align="left">Article printed from <?php bloginfo('name'); ?>: <b><?php bloginfo('url'); ?></b></p>
			<p align="left">URL to article: <b><?php the_permalink(); ?></b></p>
			<p align="left"><?php print_links(); ?></p>
			<p align="right">Click <a href="javascript:window.print();">here</a> to print.</p>
		<?php else: ?>
				<p align="center">No posts matched your criteria.</p>
		<?php endif; ?>
	</div>
</center>
</body>
</html>