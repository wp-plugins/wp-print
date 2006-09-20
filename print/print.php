<?php
/*
Plugin Name: WP-Print
Plugin URI: http://www.lesterchan.net/portfolio/programming.php
Description: Displays A Printable Version Of Your WordPress Weblog Post.
Version: 2.05
Author: GaMerZ
Author URI: http://www.lesterchan.net
*/


/*  Copyright 2006  Lester Chan  (email : gamerz84@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


### Function: Print Option Menu
add_action('admin_menu', 'print_menu');
function print_menu() {
	if (function_exists('add_options_page')) {
		add_options_page(__('Print'), __('Print'), 'manage_options', 'print/print-options.php') ;
	}
}


### Function: Print htaccess ReWrite Rules
add_filter('generate_rewrite_rules', 'print_rewrite');
function print_rewrite($wp_rewrite) {
	$r_rule = '';
	$r_link = '';
	$rewrite_rules2 = $wp_rewrite->generate_rewrite_rule($wp_rewrite->permalink_structure.'print');
	array_splice($rewrite_rules2, 1);
	$r_rule = array_keys($rewrite_rules2);
	$r_rule = array_shift($r_rule);
	$r_rule = str_replace('/trackback', '',$r_rule);
	$r_link = array_values($rewrite_rules2);
	$r_link = array_shift($r_link);
	$r_link = str_replace('tb=1', 'print=1', $r_link); 
    $print_rules = array($r_rule => $r_link, '(.+)/printpage/?$' => 'index.php?pagename='.$wp_rewrite->preg_index(1).'&print=1');
    $wp_rewrite->rules = $print_rules + $wp_rewrite->rules;
}


### Function: Print Public Variables
add_filter('query_vars', 'print_variables');
function print_variables($public_query_vars) {
	$public_query_vars[] = 'print';
	return $public_query_vars;
}


### Function: Display Print Link
function print_link($text_post = 'Print This Post', $text_page = 'Print This Page') {
	global $id;
	$using_permalink = get_settings('permalink_structure');
	$permalink = get_permalink();
	if(!empty($using_permalink)) {
		if(is_page()) {
			echo '<a href="'.$permalink.'printpage/" title="'.$text_page.'" rel="nofollow">'.$text_page.'</a>';
		} else {
			echo '<a href="'.$permalink.'print/" title="'.$text_post.'" rel="nofollow">'.$text_post.'</a>';
		}
	} else {
		echo '<a href="'.$permalink.'&amp;print=1" title="'.$text_post.'" rel="nofollow">'.$text_post.'</a>';
	}
}


### Function: Display Print Image Link
function print_link_image() {
	global $id;
	$using_permalink = get_settings('permalink_structure');
	$permalink = get_permalink();
	if(file_exists(ABSPATH.'/wp-content/plugins/print/images/print.gif')) {
		$print_image = '<img src="'.get_settings('siteurl').'/wp-content/plugins/print/images/print.gif" alt="Print This Post/Page" />';
	} else {
		$print_image = 'Print';
	}
	if(!empty($using_permalink)) {
		if(is_page()) {
			echo '<a href="'.$permalink.'printpage/" title="Print This Page" rel="nofollow">'.$print_image.'</a>';
		} else {
			echo '<a href="'.$permalink.'print/" title="Print This Post" rel="nofollow">'.$print_image.'</a>';
		}
	} else {
		echo '<a href="'.$permalink.'&amp;print=1" title="Print This Post/Page" rel="nofollow">'.$print_image.'</a>';
	}
}


### Function: Print Content
function print_content($display = true) {
	global $links_text, $link_number, $pages, $multipage, $numpages, $post;
	$max_url_char = 80;
	if(!empty($post->post_password) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) != $post->post_password) {
		$content = get_the_password_form();
	} else {
		if($multipage) {
			for($page = 0; $page < $numpages; $page++) {
				$content .= $pages[$page];
			}
		} else {
			$content = $pages[0];
		}
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		if(!print_can('images')) {
			$content = remove_image($content);
		}
		if(print_can('links')) {
			preg_match_all('/<a%20(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/', $content, $matches);
			for ($i=0; $i < count($matches[0]); $i++) {
				$link_match = $matches[0][$i];
				$link_number++;
				$link_url = $matches[2][$i];
				$link_url = (strtolower(substr($link_url,0,7)) != 'http://') ? get_settings('home') . $link_url : $link_url;
				$link_text = $matches[4][$i];
				$content = str_replace($link_match, '['.$link_number."] <a href=\"$link_url\" target=\"_blank\">".$link_text.'</a>', $content);
				$link_url = chunk_split($link_url, 100, "<br />\n");
				if(preg_match('/<img(.+?)src=\"(.+?)\"(.*?)>/',$link_text)) {
					$links_text .= '<br />['.$link_number.'] '.__('Image').': <b>'.$link_url.'</b>';
				} else {
					$links_text .= '<br />['.$link_number.'] '.$link_text.': <b>'.$link_url.'</b>';
				}
			}
		}
	}
	if($display) {
		echo $content;
	} else {
		return $content;
	}
}


### Function: Print Categories
function print_categories($before = '', $after = '') {
	$temp_cat = strip_tags(get_the_category_list(',' , $parents));
	$temp_cat = explode(', ', $temp_cat);
	$temp_cat = implode($after.', '.$before, $temp_cat);
	echo $before.$temp_cat.$after;
}


### Function: Print Comments Content
function print_comments_content($display = true) {
	global $links_text, $link_number;
	$content  = get_comment_text();
	$content = apply_filters('comment_text', $content);
	if(!print_can('images')) {
		$content = remove_image($content);
	}
	if(print_can('links')) {
		preg_match_all('/<a%20(.+?)href=\"(.+?)\"(.*?)>(.+?)<\/a>/', $content, $matches);
		for ($i=0; $i < count($matches[0]); $i++) {
			$link_match = $matches[0][$i];
			$link_number++;
			$link_url = $matches[2][$i];
			$link_url = (strtolower(substr($link_url,0,7)) != 'http://') ? get_settings('home') . $link_url : $link_url;
			$link_text = $matches[4][$i];
			$content = str_replace($link_match, '['.$link_number."] <a href=\"$link_url\" target=\"_blank\">".$link_text.'</a>', $content);
			$link_url = chunk_split($link_url, 100, "<br />\n");
			if(preg_match('/<img(.+?)src=\"(.+?)\"(.*?)>/',$link_text)) {
				$links_text .= '<br />['.$link_number.'] '.__('Image').': <b>'.$link_url.'</b>';
			} else {
				$links_text .= '<br />['.$link_number.'] '.$link_text.': <b>'.$link_url.'</b>';
			}
		}
	}
	if($display) {
		echo $content;
	} else {
		return $content;
	}
}


### Function: Print Comments
function print_comments_number() {
	global $post;
	$comment_text = '';
	$comment_status = $post->comment_status;
	if($comment_status == 'open') {
		$num_comments = get_comments_number();
		if($num_comments == 0) {
			$comment_text = __('No Comments');
		} elseif($num_comments == 1) {
			$comment_text = __('1 Comment');
		} else {
			$comment_text = __($num_comments.' Comments');
		}
	} else {
		$comment_text = __('Comments Disabled');
	}
	if(!empty($post->post_password) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) != $post->post_password) {
		_e('Comments Hidden');
	} else {
		echo $comment_text;
	}
}


### Function: Print Links
function print_links($text_links = 'URLs in this post:') {
	global $links_text;
	if(!empty($links_text)) { 
		echo $text_links.$links_text; 
	}
}


### Function: Load WP-Print
add_action('template_redirect', 'wp_print');
function wp_print() {
	if(intval(get_query_var('print')) == 1) {
		include(ABSPATH.'wp-content/plugins/print/wp-print.php');
		exit;
	}
}


### Function: Add Print Comments Template
function print_template_comments($file = '') {
	$file = ABSPATH.'wp-content/plugins/print/wp-print-comments.php';
	return $file;
}


### Function: Print Page Title
function print_pagetitle($print_pagetitle) {
	return '&raquo; Print'.$print_pagetitle;
}


### Function: Can Print?
function print_can($type) {
	$print_options = get_settings('print_options');
	return intval($print_options[$type]);
}


### Function: Remove Image From Text
function remove_image($content) {
	$content= preg_replace('/<img(.+?)src=\"(.+?)\"(.*?)>/', '',$content);
	return $content;
}


### Function: Print Options
add_action('activate_print/print.php', 'print_init');
function print_init() {
	// Add Options
	$print_options = array();
	$print_options['comments'] = 0;
	$print_options['links'] = 1;
	$print_options['images'] = 1;
	add_option('print_options', $print_options, 'Print Options');
}
?>