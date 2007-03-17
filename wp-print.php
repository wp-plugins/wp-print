<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 1.5 Plugin: WP-Print 2.00										|
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


### Require WordPress Header
require('wp-blog-header.php');

### Variables
$links_text = '';
$page_title = single_post_title('', false);

### Print The Content With URLs Footer
function print_content() {
	global $links_text;
	// Default WordPress Way Of Getting Content
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	// Match Links
	preg_match_all('/<a(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/', $content, $matches);
	// Count The Number Of Matched Links
	for ($i=0; $i < count($matches[0]); $i++) {
		$link_match = $matches[0][$i];
		$link_number = '['.($i+1).']';
		$link_url = $matches[2][$i];
		$link_url = (strtolower(substr($link_url,0,7)) != 'http://') ? get_settings('home') . $link_url : $link_url;
		$link_text = $matches[4][$i];
		$content = str_replace($link_match, $link_number." <a href=\"$link_url\" target=\"_blank\">".$link_text.'</a>', $content);
		if(preg_match('/<img(.+?)src=\"(.+?)\"(.*?)>/',$link_text)) {
			$links_text .= '<br />'.$link_number.' Image: <b>'.$link_url.'</b>';
		} else {
			$links_text .= '<br />'.$link_number.' '.$link_text.': <b>'.$link_url.'</b>';
		}
	}
	// Print Out The Content
	echo $content;
}

### If Page Title Is Empty, Display Error As Page Title
if(empty($page_title)) {
	$page_title = 'Error';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//Dp HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dp">
<html>
<head>
<title><?php bloginfo('name')?> > Print > <?php echo $page_title; ?></title>
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
							<?php print_content(); ?>
						<?php } ?>
					</div>
			<?php endwhile; ?>
			<p><hr id="Divider" align="center"></p>
			<p align="left">Article printed from <?=get_bloginfo('name')?>: <b><?=get_bloginfo('url')?></b></p>
			<p align="left">URL to article: <b><?=get_permalink()?></b></p>
			<p align="left"><?php if(!empty($links_text)) { echo 'URLs in this post:'.$links_text; } ?></p>
			<p align="right">Click <a href="javascript:window.print();">here</a> to print.</p>
		<?php else : ?>
				<p align="center">No posts matched your criteria.</p>
		<?php endif; ?>
	</div>
</center>
</body>
</html>