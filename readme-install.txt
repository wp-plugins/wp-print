-> Installation Instructions
--------------------------------------------------
// Open wp-content/plugins folder

Put:
------------------------------------------------------------------
print.php
------------------------------------------------------------------


// Open root Wordpress folder

Put
------------------------------------------------------------------
wp-print.php
------------------------------------------------------------------


// Activate WP-Print plugin

Note: 
------------------------------------------------------------------
You MAY Need To Re-Generate The Permalink.
Options -> Permalinks Options -> Update Permalink Structure
------------------------------------------------------------------


// Open wp-content/themes/<YOUR THEME NAME>/index.php

Find:
------------------------------------------------------------------
<?php while (have_posts()) : the_post(); ?>
------------------------------------------------------------------
Add Anywhere Below It:
------------------------------------------------------------------
<?php if(function_exists('wp_print')) { print_link(); } ?>
------------------------------------------------------------------
Note:
------------------------------------------------------------------
The first value you pass in is the text for printing post.
The second value is the text for printing page.
Default: print_link('Print This Post', 'Print This Page')
------------------------------------------------------------------
