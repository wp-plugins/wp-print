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
|	- Printer Friendly Page For Comments										|
|	- wp-print-comments.php														|
|																							|
+----------------------------------------------------------------+
*/
?>
<?php if($comments) : ?>
	<?php $comment_count = 1; ?>
	<p id="CommentTitle"><?php print_comments_number(); ?> To "<?php the_title(); ?>"</p>				
	<?php foreach ($comments as $comment) : ?>					
		<p class="CommentDate"><b>#<?php echo $comment_count; ?> <?php comment_type(); ?></b> By <u><?php comment_author(); ?></u> On <?php comment_date('jS F Y @ H:i'); ?></p>
		<p class="CommentContent"><?php print_comments_content(); ?></p>
		<?php $comment_count++; ?>
	<?php endforeach; ?>
	<hr id="Divider" align="center" />
<?php endif; ?>