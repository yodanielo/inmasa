<?php
/* Get SEO fields */
$seoTitle = get_post_meta($post->ID, '_screen-seo-title', true);
$seoDescription = get_post_meta($post->ID, '_screen-seo-description', true);
$seoKeywords = get_post_meta($post->ID, '_screen-seo-keywords', true);
?>
<title><?php
  /* Display SEO title if set, else display default Wordpress style title */
  if($seoTitle !== false && trim($seoTitle) != '') {
    echo $seoTitle;
  } else {
    bloginfo('name') . wp_title();
  }
  ?></title>
<?php
  /* Display SEO description if set */
  if($seoDescription !== false && trim($seoDescription) != '') {
    echo '<meta name="description" content="' . $seoDescription . '" />
';
  }
  /* Display SEO keywords if set */
  if($seoKeywords) {
    echo '<meta name="keywords" content="' . $seoKeywords . '" />
';
  }
?>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/runD.js"></script>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if IE 7]>

<style>.ie7 { clear:none; }</style>

<![endif]-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
/* Display favicon if set */
$favicon = get_option('_screen-favicon');
if($favicon !== false && trim($favicon) != '') {
?>
<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<?php
}
?>
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>