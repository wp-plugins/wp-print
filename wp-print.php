<?php
/*
 * Print Plugin For WordPress
 *	- wp-print.php
 *
 * Copyright © 2004-2005 Lester "GaMerZ" Chan
*/


// Require WordPress Header
require('wp-blog-header.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//Dp HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dp">
<html>
<head>
<title><?php bloginfo('name')?> > Print > <?php echo single_post_title('')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
</style>
</head>
<body>
<p align="center"><b>- <?php bloginfo('name'); ?> - <?php bloginfo('url')?> -</b></p>
<center>
	<div id="Outline">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
					<p id="BlogTitle"><?php the_title(); ?></p>
					<p id="BlogDate">Posted By <?php the_author(); ?> On <?php the_time('jS F Y @ H:i'); ?> In <?php the_category(', '); ?> | <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></p>
					<div id="BlogContent">
						<?php for($page = 1; $page <= $numpages; $page++) { ?>
							<?php the_content(); ?>
						<?php } ?>
					</div>
			<?php endwhile; ?>
		<?php else : ?>
				<p>No Posts Matched Your Criteria</p>
		<?php endif; ?>
		<p><hr id="Divider" align="center"></p>
		<p align="left">Article printed from <?=get_bloginfo('name')?>: <b><?=get_bloginfo('url')?></b></p>
		<p align="left">URL to article: <b><?=get_permalink()?></b></p>
		<p align="right">Click <a href="javascript:window.print();">here</a> to print.</p>
	</div>
</center>
</body>
</html>