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
|	- Print Options Page																|
|	- wp-content/plugins/print/print-options.php								|
|																							|
+----------------------------------------------------------------+
*/


### Variables Variables Variables
$base_name = plugin_basename('print/print-options.php');
$base_page = 'admin.php?page='.$base_name;
$id = intval($_GET['id']);

### If Form Is Submitted
if($_POST['Submit']) {
	$print_options = array();
	$print_options['post_text'] = addslashes(trim($_POST['print_post_text']));
	$print_options['page_text'] = addslashes(trim($_POST['print_page_text']));
	$print_options['print_icon'] = trim($_POST['print_icon']);
	$print_options['print_style'] = intval($_POST['print_style']);
	$print_options['print_html'] = trim($_POST['print_html']);
	$print_options['comments'] = intval($_POST['print_comments']);
	$print_options['links'] = intval($_POST['print_links']);
	$print_options['images'] = intval($_POST['print_images']);
	$update_print_queries = array();
	$update_print_text = array();
	$update_print_queries[] = update_option('print_options', $print_options);
	$update_print_text[] = __('Print Options', 'wp-print');
	$i=0;
	$text = '';
	foreach($update_print_queries as $update_print_query) {
		if($update_print_query) {
			$text .= '<font color="green">'.$update_print_text[$i].' '.__('Updated', 'wp-print').'</font><br />';
		}
		$i++;
	}
	if(empty($text)) {
		$text = '<font color="red">'.__('No Print Option Updated', 'wp-print').'</font>';
	}
}

### Get Print Options
$print_options = get_option('print_options');
?>
<script type="text/javascript">
	/* <![CDATA[*/
	function check_print_style() {
		print_style_options = document.getElementById("print_style").value;
		if (print_style_options == 4) {
				document.getElementById("print_style_custom").style.display = 'block';
		} else {
			if(document.getElementById("print_style_custom").style.display == 'block') {
				document.getElementById("print_style_custom").style.display = 'none';
			}
		}
	}
	function print_default_templates(template) {
		var default_template;
		switch(template) {
			case 'html':
				default_template = '<a href="%PRINT_URL%" rel="nofollow" title="%PRINT_TEXT%">%PRINT_TEXT%</a>';
				break;
		}
		document.getElementById("print_template_" + template).value = default_template;
	}
	/* ]]> */
</script>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<div class="wrap"> 
	<h2><?php _e('Print Options', 'wp-print'); ?></h2> 
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
		<fieldset class="options">
			<legend><?php _e('Print Styles', 'wp-print'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Print Text Link For Post', 'wp-print'); ?></th>
					<td align="left">
						<input type="text" name="print_post_text" value="<?php echo stripslashes($print_options['post_text']); ?>" size="30" />
					</td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Print Text Link For Page', 'wp-print'); ?></th>
					<td align="left">
						<input type="text" name="print_page_text" value="<?php echo stripslashes($print_options['page_text']); ?>" size="30" />
					</td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Print Icon', 'wp-print'); ?></th>
					<td align="left">
						<?php
							$print_icon = $print_options['print_icon'];
							$print_icon_url = get_option('siteurl').'/wp-content/plugins/print/images';
							$print_icon_path = ABSPATH.'/wp-content/plugins/print/images';
							if($handle = @opendir($print_icon_path)) {     
								while (false !== ($filename = readdir($handle))) {  
									if ($filename != '.' && $filename != '..') {
										if(is_file($print_icon_path.'/'.$filename)) {
											if($print_icon == $filename) {
												echo '<input type="radio" name="print_icon" value="'.$filename.'" checked="checked" />'."\n";										
											} else {
												echo '<input type="radio" name="print_icon" value="'.$filename.'" />'."\n";
											}
											echo '&nbsp;&nbsp;&nbsp;';
											echo '<img src="'.$print_icon_url.'/'.$filename.'" alt="'.$filename.'" />'."\n";
											echo '&nbsp;&nbsp;&nbsp;('.$filename.')';
											echo '<br /><br />'."\n";
										}
									} 
								} 
								closedir($handle);
							}
						?>
					</td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Print Text Link Style', 'wp-print'); ?></th>
					<td align="left">
						<select name="print_style" id="print_style" size="1" onchange="check_print_style();">
							<option value="1"<?php selected('1', $print_options['print_style']); ?>><?php _e('Print Icon With Text Link', 'wp-print'); ?></option>
							<option value="2"<?php selected('2', $print_options['print_style']); ?>><?php _e('Print Icon Only', 'wp-print'); ?></option>
							<option value="3"<?php selected('3', $print_options['print_style']); ?>><?php _e('Print Text Link Only', 'wp-print'); ?></option>
							<option value="4"<?php selected('4', $print_options['print_style']); ?>><?php _e('Custom', 'wp-print'); ?></option>
						</select>
						<div id="print_style_custom" style="display: <?php if(intval($print_options['print_style']) == 4) { echo 'block'; } else { echo 'none'; } ?>; margin-top: 20px;">
							<textarea rows="2" cols="80" name="print_html" id="print_template_html"><?php echo htmlspecialchars(stripslashes($print_options['print_html'])); ?></textarea><br />
							<?php _e('HTML is allowed.', 'wp-print'); ?><br />
							%PRINT_URL% - <?php _e('URL to the printable post/page.', 'wp-print'); ?><br />
							%PRINT_TEXT% - <?php _e('Print text link of the post/page that you have typed in above.', 'wp-print'); ?><br />
							%PRINT_ICON_URL% - <?php _e('URL to the print icon you have chosen above.', 'wp-print'); ?><br />
							<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-print'); ?>" onclick="javascript: print_default_templates('html');" class="button" />
						</div>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Print Options', 'wp-print'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Print Comments?', 'wp-print'); ?></th>
					<td align="left">
						<select name="print_comments" size="1">
							<option value="1"<?php selected('1', $print_options['comments']); ?>><?php _e('Yes', 'wp-print'); ?></option>
							<option value="0"<?php selected('0', $print_options['comments']); ?>><?php _e('No', 'wp-print'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Print Links?', 'wp-print'); ?></th>
					<td align="left">
						<select name="print_links" size="1">
							<option value="1"<?php selected('1', $print_options['links']); ?>><?php _e('Yes', 'wp-print'); ?></option>
							<option value="0"<?php selected('0', $print_options['links']); ?>><?php _e('No', 'wp-print'); ?></option>
						</select>
					</td> 
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Print Images?', 'wp-print'); ?></th>
					<td align="left">
						<select name="print_images" size="1">
							<option value="1"<?php selected('1', $print_options['images']); ?>><?php _e('Yes', 'wp-print'); ?></option>
							<option value="0"<?php selected('0', $print_options['images']); ?>><?php _e('No', 'wp-print'); ?></option>
						</select>
					</td> 
				</tr>
			</table>
		</fieldset>
		<div align="center">
			<input type="submit" name="Submit" class="button" value="<?php _e('Update Options', 'wp-print'); ?>" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Cancel', 'wp-print'); ?>" class="button" onclick="javascript:history.go(-1)" /> 
		</div>
	</form> 
</div> 