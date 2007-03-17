-> Print Plugin For WordPress
--------------------------------------------------
Author	-> Lester 'GaMerZ' Chan
Email	-> lesterch@singnet.com.sg
Website	-> http://www.lesterchan.net/
Demo	-> http://www.lesterchan.net/blogs/wp-print.php?p=647
Updated	-> 3rd September 2005
--------------------------------------------------


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
RewriteRule ^archives/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/?([0-9]+)?/?$ <BLOG URL>/index.php?year=$1&monthnum=$2&day=$3&name=$4&page=$5 [QSA,L]
------------------------------------------------------------------
Add Below It:
------------------------------------------------------------------
RewriteRule ^archives/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/print/?$ <BLOG URL>/wp-print.php?year=$1&monthnum=$2&day=$3&name=$4 [QSA,L]
------------------------------------------------------------------

// Open wp-content/themes/<YOUR THEME NAME>/index.php 

Find:
------------------------------------------------------------------
<?php while (have_posts()) : the_post(); ?>
------------------------------------------------------------------
Add Below It:
------------------------------------------------------------------
<a href="<?php the_permalink(); ?>print/">Print This Article</a>
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