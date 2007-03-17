-> Installation Instructions
--------------------------------------------------
// Open root Wordpress folder

Put
------------------------------------------------------------------
wp-print.php
------------------------------------------------------------------


// Go to Manage > Files > Common -> .htaccess (for rewrite rules)
// Note: If you ARE using nice permalink url
Find:
------------------------------------------------------------------
# END WordPress
------------------------------------------------------------------
Add Below It:
------------------------------------------------------------------
RewriteRule ^archives/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/print/?$ <BLOG URL>/wp-print.php?year=$1&monthnum=$2&day=$3&name=$4 [QSA,L]
RewriteRule ^(.+)/printpage/?$ <BLOG URL>/wp-print.php?pagename=$1 [QSA,L]
------------------------------------------------------------------


// Open wp-content/themes/<YOUR THEME NAME>/index.php 

Find:
------------------------------------------------------------------
<?php while (have_posts()) : the_post(); ?>
------------------------------------------------------------------
Add Below It:
------------------------------------------------------------------
<?php if(is_page()) : ?>
<a href="<?php the_permalink(); ?>printpage/">Print This Article</a>
<?php else : ?>
<a href="<?php the_permalink(); ?>print/">Print This Article</a>
<?php endif; ?>
------------------------------------------------------------------


// Note: If you ARE NOT using nice permalink url
// Open wp-content/themes/<YOUR THEME NAME>/index.php 

Find:
------------------------------------------------------------------
<?php while (have_posts()) : the_post(); ?>
------------------------------------------------------------------
Add Below It:
------------------------------------------------------------------
<?php if(is_page()) : ?>
<a href="wp-print.php?page_id=<?=the_ID()?>">Print This Article</a>
<?php else : ?>
<a href="wp-print.php?p=<?=the_ID()?>">Print This Article</a>
<?php endif; ?>
------------------------------------------------------------------