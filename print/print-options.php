<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.0 Plugin: WP-Print 2.06										|
|	Copyright (c) 2005 Lester "GaMerZ" Chan									|
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
	$print_options['comments'] = intval($_POST['print_comments']);
	$print_options['links'] = intval($_POST['print_links']);
	$print_options['images'] = intval($_POST['print_images']);
	$update_print_queries = array();
	$update_print_text = array();
	$update_print_queries[] = update_option('print_options', $print_options);
	$update_print_text[] = __('Print Options');
	$i=0;
	$text = '';
	foreach($update_print_queries as $update_print_query) {
		if($update_print_query) {
			$text .= '<font color="green">'.$update_print_text[$i].' '.__('Updated').'</font><br />';
		}
		$i++;
	}
	if(empty($text)) {
		$text = '<font color="red">'.__('No Print Option Updated').'</font>';
	}
}

### Get Print Options
$print_options = get_settings('print_options');
?>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<div class="wrap"> 
	<h2><?php _e('Print Options'); ?></h2> 
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
		<fieldset class="options">
			<legend><?php _e('Print Options'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Print Comments?'); ?></th>
					<td align="left">
						<select name="print_comments" size="1">
							<option value="1"<?php selected('1', $print_options['comments']); ?>><?php _e('Yes'); ?></option>
							<option value="0"<?php selected('0', $print_options['comments']); ?>><?php _e('No'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Print Links?'); ?></th>
					<td align="left">
						<select name="print_links" size="1">
							<option value="1"<?php selected('1', $print_options['links']); ?>><?php _e('Yes'); ?></option>
							<option value="0"<?php selected('0', $print_options['links']); ?>><?php _e('No'); ?></option>
						</select>
					</td> 
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Print Images?'); ?></th>
					<td align="left">
						<select name="print_images" size="1">
							<option value="1"<?php selected('1', $print_options['images']); ?>><?php _e('Yes'); ?></option>
							<option value="0"<?php selected('0', $print_options['images']); ?>><?php _e('No'); ?></option>
						</select>
					</td> 
				</tr>
			</table>
		</fieldset>
		<div align="center">
			<input type="submit" name="Submit" class="button" value="<?php _e('Update Options'); ?>" />&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript:history.go(-1)" /> 
		</div>
	</form> 
</div> 