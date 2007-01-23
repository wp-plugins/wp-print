<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.1 Plugin: WP-Print 2.10										|
|	Copyright (c) 2007 Lester "GaMerZ" Chan									|
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
	<p id="CommentTitle"><?php print_comments_number(); ?> <?php _e('To', 'wp-print'); ?> "<?php the_title(); ?>"</p>				
	<?php foreach ($comments as $comment) : ?>					
		<p class="CommentDate">
			<strong>#<?php echo $comment_count; ?> <?php comment_type(); ?></strong> <?php _e('By', 'wp-print'); ?> <u><?php comment_author(); ?></u> <?php _e('On', 'wp-print'); ?> <?php comment_date(get_settings("date_format").' @ '.get_settings("time_format")); ?></p>
		<div class="CommentContent">
			<?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php _e('Your comment is awaiting moderation.', 'wp-print'); ?></em></p>
			<?php endif; ?>
			<?php print_comments_content(); ?>
		</div>
		<?php $comment_count++; ?>
	<?php endforeach; ?>
	<hr class="Divider" align="center" />
<?php endif; ?>