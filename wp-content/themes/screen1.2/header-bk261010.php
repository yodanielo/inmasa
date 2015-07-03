  <div id="topbar-holder">
    <div id="topbar">
      <div id="sociables">
        <?php
        /* Display sociables */
        $facebook = get_option('_screen-facebook');
        if($facebook) {
        ?>
        <a href="http://www.facebook.com/<?php echo $facebook; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/facebook.png" alt="Facebook" title="Facebook" /></a>
        <?php }
        $flickr = get_option('_screen-flickr');
        if($flickr) {
        ?>
        <a href="http://www.flickr.com/<?php echo $flickr; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/flickr.png" alt="Flickr" title="Flickr" /></a>
        <?php }
        $linkedin = get_option('_screen-linkedin');
        if($linkedin) {
        ?>
        <a href="http://www.linkedin.com/in/<?php echo $linkedin; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/linkedin.png" alt="LinkedIn" title="LinkedIn" /></a>
        <?php }
        $rss = get_option('_screen-rss');
        if($rss) {
        ?>
        <a href="<?php echo $rss; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/rss.png" alt="RSS Feed" title="RSS Feed" /></a>
        <?php }
        $twitter = get_option('_screen-twitter');
        if($twitter) {
        ?>
        <a href="http://www.twitter.com/<?php echo $twitter; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/twitter.png" alt="Twitter" title="Twitter" /></a>
        <?php }
        $youtube = get_option('_screen-youtube');
        if($youtube) {
        ?>
        <a href="http://www.youtube.com/<?php echo $youtube; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/youtube.png" alt="YouTube" title="YouTube" /></a>
        <?php } ?>
      </div>
      <div id="search">
        <form action="<?php bloginfo('url'); ?>/" method="get" id="searchform">
          <input type="text" value="" name="s" id="s" />
          <input type="submit" value="<?php echo trnslt('search'); ?>" class="submit cp" />
        </form>
      </div>
      <div id="grabber"></div>
    </div>
  </div>
  
  <div id="logo-container">
    <div id="logo">
    <?php
    /* Check whether to display logo image, logo text or default Wordpress blogname */
    $logoImg = get_option('_screen-logo-img');
    $logoText = get_option('_screen-logo-text');
    if(trim($logoText) == '') { $logoText = get_bloginfo('name'); }
    if(trim($logoImg) != '') {
      $logoImg = makePathAbsolute($logoImg);
    ?>
      <a href="<?php bloginfo('url'); ?>"><img src="<?php echo $logoImg; ?>" alt="<?php echo $logoText; ?>" /></a>
    <?php
    } elseif($logoText != get_bloginfo('name')) {
    ?>
    <a href="<?php bloginfo('url'); ?>"><p style="margin:45px 0 0 0;"><?php echo $logoText; ?></p></a>
    <?php
    } else {
    ?>
    <a href="<?php bloginfo('url'); ?>"><p><?php bloginfo('name'); ?></p><span><?php bloginfo('description'); ?></span></a>
    <?php
    }
    ?>
    </div>
  </div>
  
  <div id="header">
    <div id="header-container">
      <?php
      /* Display Wordpress 3.0 menu */
      $menuwalker = new ThemeDutchMenuWalker;
      wp_nav_menu(array('theme_location' => 'screen-main-menu', 'container_class' => 'menu', 'depth' => 2, 'walker' => $menuwalker, 'fallback_cb' => 'oldSchoolWordpressMenu'));
      ?>
      
    </div>
  </div>
  <div id="header-s"></div>
  