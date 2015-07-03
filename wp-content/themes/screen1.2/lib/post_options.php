<?php
/* This variable prevents jQuery from being loaded a second time */
$jQueryLoaded = true;
include_once('grace_options.php');

/* Update option field */
function updateOptionField($post_id, $field) {
  $current_data = get_post_meta($post_id, $field, true);
	$new_data = $_POST[$field];
	
  if($current_data !== false) {
    if($new_data == '') {
    	delete_post_meta($post_id, $field);
    } elseif ($new_data != $current_data) {
    	update_post_meta($post_id, $field, $new_data);
    }
  }	elseif($new_data != '') {
  	add_post_meta($post_id, $field, $new_data, true);
  }
}

/* Update option fields */
function screenUpdateOptions($post_id) {
  $optionFields = array('_screen-bgType', '_screen-bgImg', '_screen-payoff', '_screen-showSidebar', '_screen-sidebar', '_screen-footersidebar', '_screen-footermenu', '_screen-seo-title', '_screen-seo-description', '_screen-seo-keywords', '_screen-seo-imgalt', '_screen-showContact', '_screen-contact-title', '_screen-contact-emailto', '_screen-contact-showGender', '_screen-contact-showName', '_screen-contact-nameRequired', '_screen-contact-showAddress', '_screen-contact-addressRequired', '_screen-contact-showPostalcode', '_screen-contact-postalcodeRequired', '_screen-contact-showCity', '_screen-contact-cityRequired', '_screen-contact-showCountry', '_screen-contact-countryRequired', '_screen-contact-showTelephone', '_screen-contact-telephoneRequired', '_screen-contact-showEmail', '_screen-contact-emailRequired', '_screen-contact-showMessage', '_screen-contact-messageRequired', '_screen-contact-captcha');
  foreach($optionFields AS $m) {
    updateOptionField($post_id, $m);
	}
}

/* Update option fields */
function galleryUpdateOptions($post_id) {
  $optionFields = array('_screen-gallery-img', '_screen-gallery-video', '_screen-gallery-website');
  foreach($optionFields AS $m) {
    updateOptionField($post_id, $m);
	}
}

/* Display Gallery options */
function placeScreenGalleryOptions() {
  global $post;
  
  $img = get_post_meta($post->ID, '_screen-gallery-img', true);
  $video = get_post_meta($post->ID, '_screen-gallery-video', true);
  $website = get_post_meta($post->ID, '_screen-gallery-website', true);
  ?>
  <table cellpadding="0" cellspacing="5">
     <tr>
      <td valign="top" style="padding:5px 0 0 0;" width="150">Gallery image:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="screen-gallery-img" name="_screen-gallery-img" value="<?php echo $img; ?>" style="width:350px; margin:0 0 5px 0;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL of your background image (e.g. http://www.yoursite.com/images/background.jpg)</span></td>
    </tr>
     <tr>
      <td valign="top" style="padding:5px 0 0 0;">Gallery video:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="screen-gallery-video" name="_screen-gallery-video" value="<?php echo $video; ?>" style="width:350px; margin:0 0 5px 0;" /><br /><span style="color:#999; font-size:10px; line-height:14px;">Enter the full URL of your background video (e.g. http://www.yoursite.com/videos/video.flv)<br />Supported file types: flv, f4v, mp4, mov</span></td>
    </tr>
     <tr>
      <td valign="top" style="padding:5px 0 0 0;">Gallery website:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="screen-gallery-website" name="_screen-gallery-website" value="<?php echo $website; ?>" style="width:350px; margin:0 0 5px 0;" /><br /><span style="color:#999; font-size:10px; line-height:14px;">Enter the full URL of your website (e.g. http://www.yoursite.com)</span></td>
    </tr>
    <tr>
      <td></td>
      <td style="color:#999; font-size:10px;">For a thumb image of your video / website, provide the ( Gallery image:) with your image.<br />Any size will do, Screen will automatic resize them for you.</td>
    </tr>
  </table>
  <?php
}

/* Display Screen options */
function placeScreenOptions() {
  global $post;

  /* General options */
  $bgType = get_post_meta($post->ID, '_screen-bgType', true);
  $bgImg = get_post_meta($post->ID, '_screen-bgImg', true);
  $payoff = get_post_meta($post->ID, '_screen-payoff', true);
  $showSidebar = get_post_meta($post->ID, '_screen-showSidebar', true);
  $sidebar = get_post_meta($post->ID, '_screen-sidebar', true);
  $footersidebar = get_post_meta($post->ID, '_screen-footersidebar', true);
  $footermenu = get_post_meta($post->ID, '_screen-footermenu', true);
  $hideBgImg = ($bgType != 'image') ? ' style="display:none;"' : '';
  $hideSidebar = ($showSidebar == 'false') ? ' style="display:none;"' : '';
	?>
	<input type="hidden" name="theme-dutch_options_box_nonce" value="<?php echo wp_create_nonce('post_options.php'); ?>" />
  <table cellpadding="0" cellspacing="5">
     <tr>
      <td width="150">Payoff:</td>
      <td><input type="text" id="screen-payoff" name="_screen-payoff" value="<?php echo $payoff; ?>" style="width:350px;" /></td>
    </tr>
    <tr>
      <td>Background type:</td>
      <td><select id="screen-bgType" name="_screen-bgType" onChange="showBgImgField();"><option<?php
      if($bgType == "dark") { echo ' selected'; }
  ?>>dark</option><option<?php
      if($bgType == "medium") { echo ' selected'; }
  ?>>medium</option><option<?php
      if($bgType == "light") { echo ' selected'; }
  ?>>light</option><option<?php
      if($bgType == "image") { echo ' selected'; }
  ?>>image</option></select></td>
    </tr>
    <tr id="screen-bgImg-tr"<?php echo $hideBgImg; ?>>
      <td valign="top" style="padding:5px 0 0 0;">Background image:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="screen-bgImg" name="_screen-bgImg" value="<?php echo $bgImg; ?>" style="width:350px; margin:0 0 5px 0;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL of your background image (e.g. http://www.yoursite.com/images/background.jpg)</span></td>
    </tr>
    <tr>
      <td>Page layout:</td>
      <td><select id="screen-showSidebar" name="_screen-showSidebar" onChange="showSidebarField();"><option value="left"<?php
      if($showSidebar == "left") { echo " selected"; }
  ?>>Sidebar left</option><option value="right"<?php
      if($showSidebar == "right") { echo " selected"; }
  ?>>Sidebar right</option><option value="false"<?php
      if($showSidebar == "false") { echo " selected"; }
  ?>>Full width</option></select></td>
    </tr>
    <tr id="screen-showSidebar-tr"<?php echo $hideSidebar; ?>>
      <td>Sidebar:</td>
      <td><select id="screen-sidebar" name="_screen-sidebar"><option value="false"<?php
      if($sidebar == "false") { echo " selected"; }
  ?>>none</option><?php
  $sidebars = get_option('_screen-sidebars');
  if(is_string($sidebars)) {
    $sidebars = unserialize($sidebars);
  } else {
    $sidebars = array();
  }
  if($sidebars) {
    foreach($sidebars AS $sb) {
      echo '<option';
          if($sidebar == $sb) { echo " selected"; }
      echo '>' . $sb . '</option>';
    }
  }
  ?></select></td>
    </tr>
    <tr>
      <td>Footer sidebar:</td>
      <td><select id="screen-footersidebar" name="_screen-footersidebar"><option value="false"<?php
      if($footersidebar == "false") { echo " selected"; }
  ?>>none</option><?php
  $footersidebars = get_option('_screen-footersidebars');
  if(is_string($footersidebars)) {
    $footersidebars = unserialize($footersidebars);
  } else {
    $footersidebars = array();
  }
  if($footersidebars) {
    foreach($footersidebars AS $f) {
      echo '<option';
          if($footersidebar == $f) { echo " selected"; }
      echo '>' . $f . '</option>';
    }
  }
  ?></select></td>
    </tr>
    <tr>
      <td>Footer menu:</td>
      <td><select id="screen-footermenu" name="_screen-footermenu"><option value="false"<?php
      if($footermenu == "false") { echo " selected"; }
  ?>>none</option><?php
  $footermenus = get_option('_screen-footermenus');
  if(is_string($footermenus)) {
    $footermenus = unserialize($footermenus);
  } else {
    $footermenus = array();
  }
  if($footermenus) {
    foreach($footermenus AS $f) {
      echo '<option';
          if($footermenu == $f) { echo " selected"; }
      echo '>' . $f . '</option>';
    }
  }
  ?></select></td>
    </tr>
  </table><?php
  /* SEO options */
  $seoTitle = get_post_meta($post->ID, '_screen-seo-title', true);
  $seoDescription = get_post_meta($post->ID, '_screen-seo-description', true);
  $seoKeywords = get_post_meta($post->ID, '_screen-seo-keywords', true);
  $seoImgalt = get_post_meta($post->ID, '_screen-seo-imgalt', true);
  ?>
  <table cellpadding="0" cellspacing="5" style="margin-top:10px; border-top:#eee solid 1px; width:100%;">
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">SEO</td>
    </tr>    
    <tr>
      <td width="150"><?php echo ucfirst($post->post_type); ?> Title:</td>
      <td><input type="text" id="screen-seo-title" name="_screen-seo-title" value="<?php echo $seoTitle; ?>" style="width:350px;" /> <span style="color:#999;"><strong id="screen-seo-title-count">80</strong> characters left</span></td>
    </tr>
    <tr>
      <td valign="top" style="padding:7px 0 0 0;">Meta Description:</td>
      <td><textarea id="screen-seo-description" name="_screen-seo-description" style="height:120px; width:350px; float:left;"><?php echo $seoDescription; ?></textarea><span style="color:#999; float:left; margin:5px 0 0 5px;"><strong id="screen-seo-description-count">160</strong> characters left</span></td>
    </tr>
    <tr>
      <td>Meta Keywords:</td>
      <td><input type="text" id="screen-seo-keywords" name="_screen-seo-keywords" value="<?php echo $seoKeywords; ?>" style="width:350px;" /></td>
    </tr>
    <tr>
      <td>Background image alt:</td>
      <td><input type="text" id="screen-seo-imgalt" name="_screen-seo-imgalt" value="<?php echo $seoImgalt; ?>" style="width:350px;" /></td>
    </tr>
  </table><?php
  /* Contact options */
  $showContact = get_post_meta($post->ID, '_screen-showContact', true);
  $hideContact = ($showContact != 'true') ? ' display:none;' : '';
  $contactTitle = get_post_meta($post->ID, '_screen-contact-title', true);
  $emailTo = get_post_meta($post->ID, '_screen-contact-emailto', true);
  $showGender = get_post_meta($post->ID, '_screen-contact-showGender', true);
  $showName = get_post_meta($post->ID, '_screen-contact-showName', true);
  $contactNameRequired = get_post_meta($post->ID, '_screen-contact-nameRequired', true);
  $showAddress = get_post_meta($post->ID, '_screen-contact-showAddress', true);
  $contactAddressRequired = get_post_meta($post->ID, '_screen-contact-addressRequired', true);
  $showPostalcode = get_post_meta($post->ID, '_screen-contact-showPostalcode', true);
  $contactPostalcodeRequired = get_post_meta($post->ID, '_screen-contact-postalcodeRequired', true);
  $showCity = get_post_meta($post->ID, '_screen-contact-showCity', true);
  $contactCityRequired = get_post_meta($post->ID, '_screen-contact-cityRequired', true);
  $showCountry = get_post_meta($post->ID, '_screen-contact-showCountry', true);
  $contactCountryRequired = get_post_meta($post->ID, '_screen-contact-countryRequired', true);
  $showTelephone = get_post_meta($post->ID, '_screen-contact-showTelephone', true);
  $contactTelephoneRequired = get_post_meta($post->ID, '_screen-contact-telephoneRequired', true);
  $showEmail = get_post_meta($post->ID, '_screen-contact-showEmail', true);
  $contactEmailRequired = get_post_meta($post->ID, '_screen-contact-emailRequired', true);
  $showMessage = get_post_meta($post->ID, '_screen-contact-showMessage', true);
  $contactMessageRequired = get_post_meta($post->ID, '_screen-contact-messageRequired', true);
  $contactCaptcha = get_post_meta($post->ID, '_screen-contact-captcha', true);
  ?>
  <table cellpadding="0" cellspacing="5" style="margin-top:10px; border-top:#eee solid 1px; width:100%;">
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">Contact form</td>
    </tr>
    <tr>
      <td width="150">Show contact form:</td>
      <td><select id="screen-showContact" name="_screen-showContact" onChange="showContactFields();"><option value="false"<?php
      if($showContact == "false") { echo " selected"; }
  ?>>no</option><option value="true"<?php
      if($showContact == "true") { echo " selected"; }
  ?>>yes</option></select></td>
    </tr>
  </table>
  <table cellpadding="0" cellspacing="5" style="width:100%;<?php echo $hideContact; ?>" id="screen-showContact-table">
    <tr>
      <td width="150">Title: <span style="color:#ccc;">(optional)</span></td>
      <td><input type="text" id="screen-contact-title" name="_screen-contact-title" value="<?php echo $contactTitle; ?>" style="width:350px;" /></td>
    </tr>
    <tr>
      <td>Send to e-mail:</td>
      <td><input type="text" id="screen-contact-emailto" name="_screen-contact-emailto" value="<?php echo $emailTo; ?>" style="width:350px;" /></td>
    </tr>
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">Fields</td>
    </tr>
    <tr>
      <td>Show Gender:</td>
      <td><select id="screen-contact-showGender" name="_screen-contact-showGender"><option value="false"<?php
      if($showGender == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showGender == "true") { echo " selected"; }
      ?>>yes</option></select></td>
    </tr>
    <tr>
      <td>Show Name:</td>
      <td><select id="screen-contact-showName" name="_screen-contact-showName"><option value="false"<?php
      if($showName == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showName == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-nameRequired" name="_screen-contact-nameRequired"><option value="false"<?php
      if($contactNameRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactNameRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show Address:</td>
      <td><select id="screen-contact-showAddress" name="_screen-contact-showAddress"><option value="false"<?php
      if($showAddress == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showAddress == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-addressRequired" name="_screen-contact-addressRequired"><option value="false"<?php
      if($contactAddressRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactAddressRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show Postal code:</td>
      <td><select id="screen-contact-showPostalcode" name="_screen-contact-showPostalcode"><option value="false"<?php
      if($showPostalcode == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showPostalcode == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-postalcodeRequired" name="_screen-contact-postalcodeRequired"><option value="false"<?php
      if($contactPostalcodeRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactPostalcodeRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show City:</td>
      <td><select id="screen-contact-showCity" name="_screen-contact-showCity"><option value="false"<?php
      if($showCity == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showCity == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-cityRequired" name="_screen-contact-cityRequired"><option value="false"<?php
      if($contactCityRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactCityRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show Country:</td>
      <td><select id="screen-contact-showCountry" name="_screen-contact-showCountry"><option value="false"<?php
      if($showCountry == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showCountry == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-countryRequired" name="_screen-contact-countryRequired"><option value="false"<?php
      if($contactCountryRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactCountryRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show Telephone:</td>
      <td><select id="screen-contact-showTelephone" name="_screen-contact-showTelephone"><option value="false"<?php
      if($showTelephone == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showTelephone == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-telephoneRequired" name="_screen-contact-telephoneRequired"><option value="false"<?php
      if($contactTelephoneRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactTelephoneRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show E-mail:</td>
      <td><select id="screen-contact-showEmail" name="_screen-contact-showEmail"><option value="false"<?php
      if($showEmail == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showEmail == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-emailRequired" name="_screen-contact-emailRequired"><option value="false"<?php
      if($contactEmailRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactEmailRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Show Message:</td>
      <td><select id="screen-contact-showMessage" name="_screen-contact-showMessage"><option value="false"<?php
      if($showMessage == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($showMessage == "true") { echo " selected"; }
      ?>>yes</option></select><select id="screen-contact-messageRequired" name="_screen-contact-messageRequired"><option value="false"<?php
      if($contactMessageRequired == "false") { echo " selected"; }
      ?>>optional</option><option value="true"<?php
      if($contactMessageRequired == "true") { echo " selected"; }
      ?>>required</option></select></td>
    </tr>
    <tr>
      <td>Use CAPTCHA</td>
      <td><select id="screen-contact-captcha" name="_screen-contact-captcha"><option value="false"<?php
      if($contactCaptcha == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($contactCaptcha == "true") { echo " selected"; }
      ?>>yes</option></select></td>
    </tr>
  </table>
  <script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#screen-seo-title").keyup(function() { updateCharCounter("#screen-seo-title", 80); } );
      updateCharCounter("#screen-seo-title", 80);
      $("#screen-seo-description").keyup(function() { updateCharCounter("#screen-seo-description", 160); } );
      updateCharCounter("#screen-seo-description", 160);
    });
    function showContactFields() {
      if($("#screen-showContact").val() == "false") {
        $("#screen-showContact-table").fadeOut(200);
      } else {
        $("#screen-showContact-table").fadeIn();
      }
    }
    function showSidebarField() {
      if($("#screen-showSidebar").val() == "false") {
        $("#screen-showSidebar-tr").fadeOut(200);
      } else {
        $("#screen-showSidebar-tr").fadeIn();
      }
    }
    function showBgImgField() {
      if($("#screen-bgType").val() == "image") {
        $("#screen-bgImg-tr").fadeIn();
      } else {
        $("#screen-bgImg-tr").fadeOut(200);
      }
    }
    function updateCharCounter(id, max) {
      var l = max - $(id).val().length;
      var c = "";
      if(l < 10) {
        c = "#be0000";
      } else if(l < 25) {
        c = "#ac4c4c";
      } else {
        c = "#999";
      }
      $(id + "-count").html(l).css("color", c);
    }
    function ucfirst(str) {
      var f = str.charAt(0).toUpperCase();
      return f + str.substr(1);
    }
  </script>
  <?php
}

/* Update all Post/Page options */
add_action('save_post', 'themeDutchUpdateOptions');
function themeDutchUpdateOptions($post_id) {
	if(!wp_verify_nonce($_POST['theme-dutch_options_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	/* Check autosave */
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	/* Check permissions */
	if('page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif(!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
  graceUpdateOptions($post_id);
  screenUpdateOptions($post_id);
  galleryUpdateOptions($post_id);
}

/* Add the options on the Page and Post edit page */
add_action('admin_menu', 'teamDutchAddOptions');
function teamDutchAddOptions() {
  add_meta_box('gallery_options', 'Gallery options', 'placeScreenGalleryOptions', 'post', 'normal', 'high');
  add_meta_box('screen_options', 'Screen page options', 'placeScreenOptions', 'page', 'normal', 'high');
  add_meta_box('screen_options', 'Screen post options', 'placeScreenOptions', 'post', 'normal', 'high');  
  add_meta_box('grace_options', 'Grace options', 'placeGraceOptions', 'page', 'normal', 'high');
  add_meta_box('grace_options', 'Grace options', 'placeGraceOptions', 'post', 'normal', 'high');
}
?>