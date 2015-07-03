<?php
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
  $wp_include = "../$wp_include";
}
require($wp_include);

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Theme Dutch Shortcode</title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/lib/shortcodes/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display:none">
	<fieldset>
	  <legend>Select the shortcode you would like to insert</legend>
	  <table border="0" cellpadding="4" cellspacing="0">
     <tr>
      <td><select id="style_shortcode" name="style_shortcode" style="width: 200px">
          <option value="0">No Style</option>
	        <optgroup label="Boxes">
						<option value="header_box">Header Box</option>
						<option value="download_box">Download Box</option>
						<option value="td_titled_box">TD Titled Box</option>
						<option value="info_box">Info Box</option>
					</optgroup>
	        <optgroup label="Dropcaps">
						<option value="dropcap1">Dropcap 1</option>
						<option value="dropcap2">Dropcap 2</option>
						<option value="dropcap3">Dropcap 3</option>
					</optgroup>
	        <optgroup label="Layouts">
						<option value="one_half_layout">Two Column Layout</option>
						<option value="one_third_layout">Three Column Layout</option>
						<option value="one_third_two_third">One Third - Two Third</option>
						<option value="two_third_one_third">Two Third - One Third</option>
					</optgroup>
	        <optgroup label="Links">
						<option value="download_link">Download Link</option>
						<option value="email_link">E-mail Link</option>
						<option value="td_link">TD Link</option>
					</optgroup>
	        <optgroup label="Lists">
						<option value="bullet_list">Bullet List</option>
						<option value="check_list">Check List</option>
					</optgroup>
	        <optgroup label="Misc.">
						<option value="button">Button</option>
						<option value="contact_info">Contact Info</option>
						<option value="framed_tabs">Framed Tabs</option>
					</optgroup>
	        <optgroup label="Pullquotes">
						<option value="pullquote_left">Pullquote Left</option>
						<option value="pullquote_right">Pullquote Right</option>
					</optgroup>
	        <optgroup label="Toggles">
						<option value="toggle">Toggle</option>
						<option value="toggle_framed">Toggle Framed</option>
					</optgroup>
        </select></td>
      </tr>
    </table>
	</fieldset>

  <div class="mceActionPanel">
  	<div style="float:left">
  		<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
  	</div>
  	<div style="float:right">
  		<input type="submit" id="insert" name="insert" value="Insert" onclick="insertTeamDutchShortcode();" />
  	</div>
	</div>
	
</body>
</html>
