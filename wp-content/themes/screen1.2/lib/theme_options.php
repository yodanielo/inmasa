<?php
/* Update option field */
function updateThemeOptionField($field) {
  $current_data = get_option($field);
	$new_data = $_POST[$field];

  if($current_data !== false) {
    if(trim($new_data) == '') {
    	delete_option($field);
    } elseif($new_data != $current_data) {
    	update_option($field, $new_data);
    }
  }	elseif($new_data != '') {
  	add_option($field, $new_data);
  }
}

/* If form was submitted */
if(isset($_POST['td-action'])) {
  /* Unset old sidebars and encode new ones */
  if($_POST['_screen-sidebars']) {
    foreach($_POST['_screen-sidebars'] AS $k => $sidebar) {
      if(trim($sidebar) == '') {
        unset($_POST['_screen-sidebars'][$k]);
      } else {
        $_POST['_screen-sidebars'][$k] = urlsafe(strtolower($sidebar));
      }
    }
    $_POST['_screen-sidebars'] = serialize($_POST['_screen-sidebars']);
  }
  /* Unset old footer sidebars and encode new ones */
  if($_POST['_screen-footersidebars']) {
    foreach($_POST['_screen-footersidebars'] AS $k => $f) {
      if(trim($f) == '') {
        unset($_POST['_screen-footersidebars'][$k]);
      } else {
        $_POST['_screen-footersidebars'][$k] = urlsafe(strtolower($f));
      }
    }
    $_POST['_screen-footersidebars'] = serialize($_POST['_screen-footersidebars']);
  }
  /* Unset old footer menus and encode new ones */
  if($_POST['_screen-footermenus']) {
    foreach($_POST['_screen-footermenus'] AS $k => $f) {
      if(trim($f) == '') {
        unset($_POST['_screen-footermenus'][$k]);
      } else {
        $_POST['_screen-footermenus'][$k] = urlsafe($f);
      }
    }
    $_POST['_screen-footermenus'] = serialize($_POST['_screen-footermenus']);
  }
  /* Glue gallery categories together */
  if($_POST['_screen-galleryCategories']) {
    $_POST['_screen-galleryCategories'] = implode(';', $_POST['_screen-galleryCategories']);
  }
  
  /* Check link for http */
  if(isset($_POST['_screen-copyright-link'])) {
    $_POST['_screen-copyright-link'] = checkLinkForHttp($_POST['_screen-copyright-link']);
  }
  
  /* Update options */
  $optionFields = array('_screen-favicon', '_screen-cufonEnabled', '_screen-cufonFont', '_screen-payoffColor', '_screen-home-payoff', '_screen-home-text', '_screen-home-bgType', '_screen-home-bgImg', '_screen-home-footermenu', '_screen-category-layout', '_screen-category-bgType', '_screen-category-bgImg', '_screen-category-footermenu', '_screen-logo-img', '_screen-logo-text', '_screen-copyright-name', '_screen-copyright-link', '_screen-sidebars', '_screen-footersidebars', '_screen-footermenus', '_screen-facebook', '_screen-flickr', '_screen-linkedin', '_screen-rss', '_screen-twitter', '_screen-youtube', '_screen-analytics', '_screen-galleryCategories');
  foreach($optionFields AS $o) {
    updateThemeOptionField($o);
	}
  foreach($trnslt_vars AS $var) {
    updateThemeOptionField('_screen-trnslt-' . $var);
	}
}

/* Display theme options screen */
function teamDutchPlaceThemeOptions() {
  global $trnslt_vars;
  ?><div class="wrap">
    <h2>Screen, the next generation Wordpress theme!</h2>
    <form method="post" action="" id="screenform">
    <input type="button" value="General" onclick="showTab('tab-general');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Home" onclick="showTab('tab-home');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Blog" onclick="showTab('tab-category');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Logo" onclick="showTab('tab-logo');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Copyright" onclick="showTab('tab-copyright');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Sidebars" onclick="showTab('tab-sidebars');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Footer Sidebars" onclick="showTab('tab-footersidebars');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Footer Menus" onclick="showTab('tab-footermenus');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Sociables" onclick="showTab('tab-sociables');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Translations" onclick="showTab('tab-translations');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Gallery" onclick="showTab('tab-gallery');" style="margin:0 4px 0 0; cursor:pointer;" /><input type="button" value="Help" onclick="showTab('tab-help');" style="color:#e67400; cursor:pointer;" />
    
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-intro" class="tabs">
      <tr>
        <td><div style="background:#222; width:770px; padding:20px 0; text-align:center; margin:0 0 10px 0;"><img src="<?php echo get_bloginfo('template_url'); ?>/images/logo-themedutch.png" /></div>
          <u>Theme Description</u>
          <p>Screen is an impressive Wordpress 3.0 theme made for your business website, portfolio, blog or any other kind of website. Whether you want to present your corporate business or products, are a photographer who wants to display his photographs or even a musician who wants to showcase their videos; it's all possible with the powerful and professional Screen theme.</p>
          
          <p>Key features:<br />
          - Create and customise sidebars that can be placed on ANY page or post<br />
          - Create and customise footer sidebars that can be placed on ANY page or post<br />
          - Create and customise footer menus that can be placed on ANY page or post<br />
          - A built-in SEO module<br />
          - Grace; our slider with over 450 possible transition combinations<br />
          - Support for online video support (YouTube and Vimeo)<br />
          - Background image on ANY page or post, or one of three colours<br />
          - Fully customisable homepage<br />
          - Colorpicker to change the background color for the payoff<br />
          - 6 Cuf&oacute;n fonts to choose from</p>
          
          <p>Screen, a production of <a href="http://theme-dutch.com/" title="Wordpress themes">Theme Dutch</a></p></td>
      </tr>
    </table>
  <?php
  /* Get general options */
  $favicon = get_option('_screen-favicon');
  $cufonEnabled = get_option('_screen-cufonEnabled');
  $hide = ($cufonEnabled != 'true') ? ' style="display:none;"' : '';
  $cufonFont = get_option('_screen-cufonFont');
  $payoffColor = get_option('_screen-payoffColor');
  $analytics = get_option('_screen-analytics');
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-general" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">General</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:3px 0 0 0;">Favicon location:</td>
        <td><input type="text" id="screen-favicon" name="_screen-favicon" value="<?php echo $favicon; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL of your custom favicon image here (e.g. http://www.yoursite.com/favicon.ico)</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Cuf&oacute;n enabled:</td>
        <td><select id="screen-cufonEnabled" name="_screen-cufonEnabled" onChange="showCufonFonts();"><option value="true"<?php
        if($cufonEnabled == "true") { echo " selected"; }
        ?>>yes</option><option value="false"<?php
        if($cufonEnabled == "false") { echo " selected"; }
        ?>>no</option></select><br /><span style="color:#999; font-size:10px;">Here you can disable Cuf&oacute;n text replacement.</span></td>
      </tr>
      <tr id="screen-cufon-tr" <?php echo $hide; ?>>
        <td valign="top" style="padding:3px 0 0 0;">Cuf&oacute;n font:</td>
        <td><select id="screen-cufonFont" name="_screen-cufonFont"><option<?php
        if($cufonFont == "Calluna") { echo " selected"; }
        ?>>Calluna</option><option<?php
        if($cufonFont == "Delicious") { echo " selected"; }
        ?>>Delicious</option><option<?php
        if($cufonFont == "Eurostile") { echo " selected"; }
        ?>>Eurostile</option><option<?php
        if($cufonFont == "Fontin") { echo " selected"; }
        ?>>Fontin</option><option<?php
        if($cufonFont == "Museo") { echo " selected"; }
        ?>>Museo</option><option<?php
        if($cufonFont == "Tallys") { echo " selected"; }
        ?>>Tallys</option></select><br /><span style="color:#999; font-size:10px;">Select a font to be used for headings.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Payoff bg color:</td>
        <td><input type="text" id="screen-payoffColor" name="_screen-payoffColor" value="<?php echo $payoffColor; ?>" style="width:100px;" /><br /><span style="color:#999; font-size:10px;">Use the colorpicker to choose a background color for the payoff.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Google Analytics:</td>
        <td><textarea id="screen-analytics" name="_screen-analytics" style="height:120px; width:505px;"><?php echo stripslashes_deep($analytics); ?></textarea><br /><span style="color:#999; font-size:10px;">Past your Google Analytics code here.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Dummy content:</td>
        <td><select id="screen-dummycontent" name="_screen-dummycontent"><option value="false">Don't place dummy content</option><option value="true">Place dummy content</option></select><br /><span style="color:#999; font-size:10px;">This option will help you understand how Screen works.<br />Screen will automatic put dummy content into your website.<br />Please use with a new Wordpress 3.0+ installation.</span></td>
      </tr>
      <?php
      /* Import dummy content */
      if(isset($_POST['_screen-dummycontent']) && $_POST['_screen-dummycontent'] == 'true') {
      ?><tr>
        <td colspan="2"><?php
        require_once('importer/importer.php');
        ?></td>
        </tr><?php
      }
      ?>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
    <?php
    /* Get home options */
    $homePayoff = get_option('_screen-home-payoff');
    $homeText = get_option('_screen-home-text');
    $homeBgType = get_option('_screen-home-bgType');
    $homeBgImg = get_option('_screen-home-bgImg');
    $hide = ($homeBgType != 'image') ? ' style="display:none;"' : '';
    $homeFootermenu = get_option('_screen-home-footermenu');
    ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-home" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Home</strong></td>
      </tr>
      <tr>
        <td colspan="2" style="padding:0 0 20px 0;">Screen provides two ways to make a home page. For a minimalistic design with a full screen background, please select background type/image below.<br /><br />If you like more features to design your home page, create a page and design it they way you like, save changes and go to Settings &gt; Reading and select your home page at Front page display. Save changes again and voila!</td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Home payoff:</td>
        <td><input type="text" id="screen-home-payoff" name="_screen-home-payoff" value="<?php echo $homePayoff; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Here you can enter the payoff that will be displayed directly above the content.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:30px 0 0 0;">Home content:</td>
        <td><div id="poststuff"><div id="<?php
        echo user_can_richedit() ? 'postdivrich' : 'postdiv';
        ?>" class="postarea" style="margin:0 0 5px 0;"><?php
				the_editor(stripslashes_deep($homeText), '_screen-home-text', '_screen-home-title', true, 3);
				?></div></div><span style="color:#999; font-size:10px;">The Visual / HTML editor gives you total control of your homepage. You can even spice it up with the use of short codes!<br />
				Tip: Try setting a background image and leaving the content empty for a clean and beautiful homepage!</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Background type:</td>
        <td><select id="screen-home-bgType" name="_screen-home-bgType" onChange="showBgImgField();"><option<?php
        if($homeBgType == "dark") { echo " selected"; }
        ?>>dark</option><option<?php
        if($homeBgType == "medium") { echo " selected"; }
        ?>>medium</option><option<?php
        if($homeBgType == "light") { echo " selected"; }
        ?>>light</option><option<?php
        if($homeBgType == "image") { echo " selected"; }
        ?>>image</option></select><br /><span style="color:#999; font-size:10px;">Select a background type to use on the homepage.</span></td>
      </tr>
      <tr id="screen-home-bgImg-tr"<?php echo $hide; ?>>
        <td valign="top" style="padding:3px 0 0 0;">Background image:</td>
        <td><input type="text" id="screen-home-bgImg" name="_screen-home-bgImg" value="<?php echo $homeBgImg; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL to your background image here (e.g. http://www.yoursite.com/images/background.jpg). For the best result use images with a resolution of 1280 x 1024 pixels.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Choose footer menu:</td>
        <td><select id="screen-home-footermenu" name="_screen-home-footermenu"><option value="false"<?php
        if($homeFootermenu == "false") { echo " selected"; }
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
                if($homeFootermenu == $f) { echo " selected"; }
            echo '>' . $f . '</option>';
          }
        }
        ?></select><br /><span style="color:#999; font-size:10px;">Please select a footer menu. See the Footer menu section of the Help for more information.</span></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get category options */
  $categoryLayout = get_option('_screen-category-layout');
  $categoryBgType = get_option('_screen-category-bgType');
  $categoryBgImg = get_option('_screen-category-bgImg');
  $hide = ($categoryBgType != 'image') ? ' style="display:none;"' : '';
  $categoryFootermenu = get_option('_screen-category-footermenu');
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-category" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Blog</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:3px 0 0 0;">Page layout:</td>
        <td><select id="screen-category-layout" name="_screen-category-layout"><option value="1"<?php
        if($categoryLayout == 1) { echo " selected"; }
        ?>>1 column</option><option value="2"<?php
        if($categoryLayout == 2) { echo " selected"; }
        ?>>2 columns</option><option value="3"<?php
        if($categoryLayout == 3) { echo " selected"; }
        ?>>3 columns</option></select><br /><span style="color:#999; font-size:10px;">Select the amount of columns for the blog page.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Posts per page:</td>
        <td><span style="color:#999; font-size:10px;">You can edit this setting on the <a href="options-reading.php">Settings > Reading</a> page under <em>Blog pages show at most</em>.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Background type:</td>
        <td><select id="screen-category-bgType" name="_screen-category-bgType" onChange="showCategoryBgImgField();"><option<?php
        if($categoryBgType == "dark") { echo " selected"; }
        ?>>dark</option><option<?php
        if($categoryBgType == "medium") { echo " selected"; }
        ?>>medium</option><option<?php
        if($categoryBgType == "light") { echo " selected"; }
        ?>>light</option><option<?php
        if($categoryBgType == "image") { echo " selected"; }
        ?>>image</option></select><br /><span style="color:#999; font-size:10px;">Select a background type to use on the blog page.</span></td>
      </tr>
      <tr id="screen-category-bgImg-tr"<?php echo $hide; ?>>
        <td valign="top" style="padding:3px 0 0 0;">Background image:</td>
        <td><input type="text" id="screen-category-bgImg" name="_screen-category-bgImg" value="<?php echo $categoryBgImg; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL to your background image here (e.g. http://www.yoursite.com/images/background.jpg). For the best result use images with a resolution of 1280 x 1024 pixels.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Choose footer menu:</td>
        <td><select id="screen-category-footermenu" name="_screen-category-footermenu"><option value="false"<?php
        if($homeFootermenu == "false") { echo " selected"; }
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
                if($categoryFootermenu == $f) { echo " selected"; }
            echo '>' . $f . '</option>';
          }
        }
        ?></select><br /><span style="color:#999; font-size:10px;">Please select a footer menu. See the Footer menu section of the Help for more information.</span></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get logo options */
  $logoImg = get_option('_screen-logo-img');
  $logoText = get_option('_screen-logo-text');
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-logo" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Logo</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:3px 0 0 0;">Image:</td>
        <td><input type="text" name="_screen-logo-img" value="<?php echo $logoImg; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL of your logo image (e.g. http://www.yoursite.com/images/logo.png)<br />Logo Dimension advice: 315x 85px. Screen will automatically align your logo vertically.<br />If your logo is larger, you might need to modify style.css to align it perfectly.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Text:</td>
        <td><input type="text" name="_screen-logo-text" value="<?php echo $logoText; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">If the logo image is given, this text will be used as the alt text.<br />If no image is given this text is shown in the header.<br />If you leave both image and text fields empty, your Wordpress blog name will be shown in the header.</span></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get copyright options */
  $copyrightName = get_option('_screen-copyright-name');
  $copyrightLink = get_option('_screen-copyright-link');
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-copyright" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Copyright information</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:3px 0 0 0;">Name:</td>
        <td><input type="text" name="_screen-copyright-name" value="<?php echo $copyrightName; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter your copyright information here.</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding:3px 0 0 0;">Link:</td>
        <td><input type="text" name="_screen-copyright-link" value="<?php echo $copyrightLink; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px;">Enter your link here (e.g. http://www.yoursite.com).</span></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get sidebars */
  $sidebars = get_option('_screen-sidebars');
  if(is_array($sidebars)) {
    
  } elseif(is_string($sidebars)) {
    $sidebars = unserialize($sidebars);
  } else {
    $sidebars = array();
  }
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-sidebars" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Sidebars</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:8px 0 0 0;">Create new:</td>
        <td><input type="text" name="_screen-sidebars[]" style="width:307px;" /><input type="submit" name="save" value="Add" style="cursor:pointer; margin:5px 0 5px 5px;" /><br /><span style="color:#999; font-size:10px;">Here you can create custom sidebars which can be filled at the Widgets page. You can select the sidebar in the editor of the Page or Post where you want to show it.</span></td>
      </tr>
      <tr>
        <td valign="top">Available:</td>
        <td>
        <?php
        if($sidebars) {
          foreach($sidebars AS $sb) {
            ?><div id="screen-sidebar-<?php echo $sb; ?>" style="display:block; padding:5px; margin:0 0 5px 0; background:#eee;"><?php echo $sb; ?> <a href="javascript:removeSidebar('<?php echo $sb; ?>');" style="float:right;">remove</a><input type="hidden" name="_screen-sidebars[]" value="<?php echo $sb; ?>" /></div><?php
          }
        }
        ?>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get footer sidebars */
  $footersidebars = get_option('_screen-footersidebars');
  if(is_array($footersidebars)) {
    
  } elseif(is_string($footersidebars)) {
    $footersidebars = unserialize($footersidebars);
  } else {
    $footersidebars = array();
  }
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-footersidebars" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Footer Sidebars</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:8px 0 0 0;">Create new:</td>
        <td><input type="text" name="_screen-footersidebars[]" style="width:307px;" /><input type="submit" name="save" value="Add" style="cursor:pointer; margin:5px 0 5px 5px;" /><br /><span style="color:#999; font-size:10px;">Here you can create custom footer widget areas which can be filled at the Widgets page. You can select the footer widget area in the editor of the Page or Post where you want to show it.</span></td>
      </tr>
      <tr>
        <td valign="top">Available:</td>
        <td>
        <?php
        if($footersidebars) {
          foreach($footersidebars AS $f) {
            ?><div id="screen-footersidebar-<?php echo $f; ?>" style="display:block; padding:5px; margin:0 0 5px 0; background:#eee;"><?php echo $f; ?> <a href="javascript:removeFooterSidebar('<?php echo $f; ?>');" style="float:right;">remove</a><input type="hidden" name="_screen-footersidebars[]" value="<?php echo $f; ?>" /></div><?php
          }
        }
        ?>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get footer menus */
  $footermenus = get_option('_screen-footermenus');
  if(is_array($footermenus)) {
    
  } elseif(is_string($footermenus)) {
    $footermenus = unserialize($footermenus);
  } else {
    $footermenus = array();
  }
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-footermenus" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Footer Menus</strong></td>
      </tr>
      <tr>
        <td valign="top" width="150" style="padding:8px 0 0 0;">Create new:</td>
        <td><input type="text" name="_screen-footermenus[]" style="width:307px;" /><input type="submit" name="save" value="Add" style="cursor:pointer; margin:5px 0 5px 5px;" /><br /><span style="color:#999; font-size:10px;">Here you can create footer menus which can be filled with a Wordpress 3.0 menu at the Menus page. You can select the footer menu in the editor of the Page or Post where you want to show it.<br />This feature, like many features in the Screen theme, was added with SEO in mind.</span></td>
      </tr>
      <tr>
        <td valign="top">Available:</td>
        <td>
        <?php
        if($footermenus) {
          foreach($footermenus AS $f) {
            ?><div id="screen-footermenu-<?php echo $f; ?>" style="display:block; padding:5px; margin:0 0 5px 0; background:#eee;"><?php echo $f; ?> <a href="javascript:removeFootermenu('<?php echo $f; ?>');" style="float:right;">remove</a><input type="hidden" name="_screen-footermenus[]" value="<?php echo $f; ?>" /></div><?php
          }
        }
        ?>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Get sociables options */
  $facebook = get_option('_screen-facebook');
  $flickr = get_option('_screen-flickr');
  $linkedin = get_option('_screen-linkedin');
  $rss = get_option('_screen-rss');
  $twitter = get_option('_screen-twitter');
  $youtube = get_option('_screen-youtube');
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-sociables" class="tabs">
      <tr>
        <td colspan="2"><strong style="margin:15px 0 0 0;">Sociables</strong><br /><span style="color:#999; font-size:10px;">This feature enables you to link to your favourite social media websites.<br />If a field is left empty, the corresponding icon will not be displayed at the top of your website</span></td>
      </tr>
      <tr>
        <td width="150">Facebook:</td>
        <td style="color:#bbb;">www.facebook.com/<input type="text" id="screen-facebook" name="_screen-facebook" value="<?php echo $facebook; ?>" style="width:221px;" /></td>
      </tr>
      <tr>
        <td>Flickr:</td>
        <td style="color:#bbb;">www.flickr.com/<input type="text" id="screen-flickr" name="_screen-flickr" value="<?php echo $flickr; ?>" style="width:246px;" /></td>
      </tr>
      <tr>
        <td>LinkedIn:</td>
        <td style="color:#bbb;">www.linkedin.com/in/<input type="text" id="screen-linkedin" name="_screen-linkedin" value="<?php echo $linkedin; ?>" style="width:209px;" /></td>
      </tr>
      <tr>
        <td>RSS:</td>
        <td><input type="text" id="screen-rss" name="_screen-rss" value="<?php echo $rss; ?>" style="width:350px;" /></td>
      </tr>
      <tr>
        <td>Twitter:</td>
        <td style="color:#bbb;">www.twitter.com/<input type="text" id="screen-twitter" name="_screen-twitter" value="<?php echo $twitter; ?>" style="width:237px;" /></td>
      </tr>
      <tr>
        <td>YouTube:</td>
        <td style="color:#bbb;">www.youtube.com/<input type="text" id="screen-youtube" name="_screen-youtube" value="<?php echo $youtube; ?>" style="width:227px;" /></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Display translations */
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-translations" class="tabs">
      <tr>
        <td colspan="3"><strong style="margin:15px 0 0 0;">Translations</strong></td>
      </tr>
      <tr>
        <td colspan="3" style="padding:0 0 20px 0;">With this feature you can change the terms used throughout your website. Just translate the words of your choice to your language and save!</td>
      </tr>
      <tr>
      <?php
      $i = 0;
      foreach($trnslt_vars AS $key => $var) {
        $trnsltn = get_option('_screen-trnslt-' . $var);
        if($trnsltn === false || trim($trnsltn) == '') {
          $trnsltn = $key;
        }
        if(strlen($key) < 50) {
      ?>
        <td valign="top" width="355"><?php echo $key; ?><br /><input type="text" id="screen-trnslt-<?php echo $var; ?>" name="_screen-trnslt-<?php echo $var; ?>" value="<?php echo $trnsltn; ?>" style="width:350px;" /></td>
      <?php
        } else {
        ?>
        <td width="355"><?php echo $key; ?><br /><textarea id="screen-trnslt-<?php echo $var; ?>" name="_screen-trnslt-<?php echo $var; ?>" style="height:120px; width:350px;"><?php echo $trnsltn; ?></textarea></td>
        <?php
        }
        if($i % 2) {
          ?>
      </tr>
      <tr>
      <?php
        } else {
          ?>
      <td width="20"></td>
      <?php
        }
        $i++;
      }
      if($i % 2) {
        ?>
        <td></td>
      </tr>
      <tr>
        <?php
      }
      ?>
      </tr>
      <tr>
        <td colspan="3"><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Display gallery options */
  $galleryCategories = get_option('_screen-galleryCategories');
  $galleryCategories = explode(';', $galleryCategories);
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-gallery" class="tabs">
      <tr>
        <td><strong style="margin:15px 0 0 0;">Gallery</strong></td>
      </tr>
      <tr>
        <td>Choose categories to be used as gallery or portfolio:<br />
        <?php
        $categories = get_categories('hide_empty=0');
        foreach($categories AS $c) { ?>
          <input type="checkbox" name="_screen-galleryCategories[]" value="<?php echo $c->cat_ID; ?>" <?php if(in_array($c->cat_ID, $galleryCategories)) { ?> checked<?php } ?>/> <?php echo $c->name; ?><br />
        <?php
        }
        ?><br /><span style="color:#999; font-size:10px;">Don't forget to put the gallery categories into your main menu (Appearance &gt; Menus).</span>
        </td>
      </tr>
      <tr>
        <td><input type="submit" name="save" value="Save changes" style="cursor:pointer; margin:5px 0;" /></td>
      </tr>
    </table>
  <?php
  /* Display help videos */
  ?>
    <table cellpadding="0" cellspacing="5" style="margin:5px 0 0 0; display:none; background:#fff; border:#eee solid 1px; padding:10px; width:800px;" id="tab-help" class="tabs">
      <tr>
        <td><strong style="margin:15px 0 0 0;">Help</strong></td>
      </tr>
      <tr>
        <td style="padding:0 0 20px 0;">Below you will find the video manuals, if this information is not adequate please use your Screen manual. It's included in your Screen file, or visit for more information <a href="http://www.theme-dutch.com">www.theme-dutch.com</a></td>
      </tr>
      <tr>
        <td><strong>Screen admin panel</strong><br />
        <iframe class="youtube-player" width="770" height="510" src="http://www.youtube.com/embed/G5htvz3V4Ns" frameborder="0" style="margin:0 0 15px 0;"></iframe></td>
      </tr>
      <tr>
        <td><strong>Edit page</strong><br />
        <iframe class="youtube-player" width="770" height="510" src="http://www.youtube.com/embed/IA4cvdM9FdY" frameborder="0" class="iframe"></iframe>
        </td>
      </tr>
    </table>
  
  <input type="hidden" name="td-action" value="save" /></form>
  </div>
  <script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/jquery-1.4.2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_url'); ?>/js/cp/css/colorpicker.css" />
  <script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/cp/js/colorpicker.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var hash = window.location.hash.replace("#", "");
      if($("#tab-" + hash).length > 0) {
        $("#tab-" + hash).fadeIn();
      } else {
        $("#tab-intro").fadeIn();
      }
      $('#screen-payoffColor').ColorPicker({
      	onSubmit:function(hsb, hex, rgb, el) {
      		$(el).val(hex);
      		$(el).ColorPickerHide();
      	},
      	onBeforeShow:function() {
      		$(this).ColorPickerSetColor(this.value);
      	}
      });
    });
    function showTab(id) {
      $("#screenform").attr("action", "#" + id.replace("tab-", ""));
      $(".tabs").stop(true, true).fadeOut(200);
      $("#" + id).delay(300).fadeIn();
    }
    function removeSidebar(id) {
      if(confirm("Are you sure you want to remove this sidebar?")) {
        $("#screen-sidebar-" + id).fadeOut(300, function() {
          $(this).empty().remove();
          $("#screenform").submit();
        });
      }
    }
    function showCufonFonts() {
      if($("#screen-cufonEnabled").val() == "true") {
        $("#screen-cufon-tr").fadeIn();
      } else {
        $("#screen-cufon-tr").fadeOut(200);
      }
    }
    function showBgImgField() {
      if($("#screen-home-bgType").val() == "image") {
        $("#screen-home-bgImg-tr").fadeIn();
      } else {
        $("#screen-home-bgImg-tr").fadeOut(200);
      }
    }
    function showCategoryBgImgField() {
      if($("#screen-category-bgType").val() == "image") {
        $("#screen-category-bgImg-tr").fadeIn();
      } else {
        $("#screen-category-bgImg-tr").fadeOut(200);
      }
    }
    function removeFooterSidebar(id) {
      if(confirm("Are you sure you want to remove this footer sidebar?")) {
        $("#screen-footersidebar-" + id).fadeOut(300, function() {
          $(this).empty().remove();
          $("#screenform").submit();
        });
      }
    }
    function removeFootermenu(id) {
      if(confirm("Are you sure you want to remove this footermenu?")) {
        $("#screen-footermenu-" + id).fadeOut(300, function() {
          $(this).empty().remove();
          $("#screenform").submit();
        });
      }
    }
  </script>
  <?php
}

/* Add tinyMCE for homepage WYSIWYG editing */
if($_GET['page'] == 'theme_options.php') {
  add_filter('admin_head','showTinyMCE');
}
function showTinyMCE() {
	wp_enqueue_script('common');
	wp_enqueue_script('jquery-color');
	wp_print_scripts('editor');
	if(function_exists('add_thickbox')) { add_thickbox(); }
	wp_print_scripts('media-upload');
	if(function_exists('wp_tiny_mce')) { wp_tiny_mce(); }
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action('admin_print_styles-post-php');
	do_action('admin_print_styles');
	remove_all_filters('mce_external_plugins');
}

/* Add theme options page */
add_action('admin_menu', 'teamDutchAddThemeOptions');
function teamDutchAddThemeOptions() {
  add_menu_page('Screen options', '<span style="color:#e57300;">Screen</span>', 'edit_themes', 'theme_options.php', 'teamDutchPlaceThemeOptions', get_bloginfo('template_url') . '/images/td-icon.png');
}
?>