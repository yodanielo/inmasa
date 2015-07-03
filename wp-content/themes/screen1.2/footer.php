<?php
/* Check which background/footer menu should be placed */
if (isset($_SESSION['isCategory'])) {
    session_unregister('isCategory');
    $footermenu = get_option('_screen-category-footermenu');
    $bgType = get_option('_screen-category-bgType');
    $bgImg = get_option('_screen-category-bgImg');
} elseif ($post->ID && !is_home()) {
    $footermenu = get_post_meta($post->ID, '_screen-footermenu', true);
    $bgType = get_post_meta($post->ID, '_screen-bgType', true);
    $bgImg = get_post_meta($post->ID, '_screen-bgImg', true);
} else {
    $footermenu = get_option('_screen-home-footermenu');
    $bgType = get_option('_screen-home-bgType');
    $bgImg = get_option('_screen-home-bgImg');
}

/* Get copyright information */
$copyrightName = get_option('_screen-copyright-name');
if (!copyrightName || trim($copyrightName) == '') {
    $copyrightName = 'Theme Dutch';
}
$copyrightLink = get_option('_screen-copyright-link');
if (!copyrightLink || trim($copyrightLink) == '') {
    $copyrightLink = '';
}

/* Get Google Analytics code */
$analytics = get_option('_screen-analytics');
?>
<div id="footer-s"></div>
<div id="footer-container">
    <div id="footer">
        <?php
        /* Place the Wordpress 3.0 menu for the footer */
        if ($footermenu != "")
            $footermenu = 'footer';
        if ($footermenu != 'false') {
            wp_nav_menu(array('theme_location' => $footermenu, 'container_class' => 'footermenu', 'menu_class' => '', 'depth' => 1));
        }
        ?>
        <div class="footercopyright">
            <ul>
                <li><a>&copy; <?php echo date('Y') . ' ' . $copyrightName; ?></a></li>
            </ul>
        </div>
    </div>
</div>

<?php
        /* Check which background/footer menu should be placed */
        if (isset($_SESSION['isGallery'])) {
            if ($_SESSION['galleryFirst'][3] != '') {
                echo '<div id="bgholder" style="display:block;"><iframe src="' . $_SESSION['galleryFirst'][3] . '"></iframe></div>';
            } elseif ($_SESSION['galleryFirst'][2] != '') {
                echo '<div id="bgholder" style="display:block;"><object width="1280" height="1024"><param name="movie" value="' . $_SESSION['template_url'] . 'tdplayer.swf?moviefile=' . $_SESSION['galleryFirst'][2] . '&autoplay=1" /><param name="wmode" value="opaque"></param><embed src="' . $_SESSION['template_url'] . 'tdplayer.swf?moviefile=' . $_SESSION['galleryFirst'][2] . '&autoplay=1" type="application/x-shockwave-flash" wmode="opaque" width="1280" height="1024"></embed></object></div>';
            } elseif ($_SESSION['galleryFirst'][1] != '') {
                echo '<div id="bgholder"><img src="' . makePathAbsolute($_SESSION['galleryFirst'][1]) . '" id="bgimg" alt="' . $_SESSION['galleryFirst'][0] . '" /></div>';
            }
        } else {
            /* Check which background type has been chosen */
            switch ($bgType) {
                case 'image':
                    if (trim($bgImg) != '') {
                        $bgImg = makePathAbsolute($bgImg);
                        echo '<div id="bgholder"><img src="' . $bgImg . '" id="bgimg" alt="' . get_post_meta($post->ID, '_screen-seo-imgalt', true) . '" /></div>';
                    }
                    break;
                case 'dark':
                    echo '<div id="bgholder" style="background:#333 url(\'' . get_bloginfo('template_url') . '/images/bg0.jpg\') center; display:block;"></div>';
                    break;
                case 'medium':
                    echo '<div id="bgholder" style="background:#999 url(\'' . get_bloginfo('template_url') . '/images/bg-pattern-medium.gif\'); display:block;"></div>';
                    break;
                case 'light':
                    echo '<div id="bgholder" style="background:#eee url(\'' . get_bloginfo('template_url') . '/images/bg-pattern-light.gif\'); display:block;"></div>';
                    break;
            }
        }
?>

        <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.easing.1.3.js"></script>
<?php
        $cufonEnabled = get_option('_screen-cufonEnabled');
        if ($cufonEnabled == 'true') {
?>
            <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/cufon.js"></script>
            <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/<?php
            $cufonFont = get_option('_screen-cufonFont');
            if ($cufonFont !== false) {
                echo $cufonFont;
            } else {
                echo 'Museo';
            }
?>.font.js"></script>
            <script type="text/javascript">
                /* A font by Jos Buivenga (exljbris) -> www.exljbris.com */
                Cufon.replace('#logo p')('#logo span')('#footer a')('h1')('h3')('.menu > ul > li > a', {hover:true})('h2', {hover:true})('.postnavigation a', {hover:true});
            </script>
<?php } ?>
        <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/functions.js"></script>
        <script type="text/javascript">
            //jQuery(".dgm_img a").fancybox();
        </script>
<?php
        if (isset($_SESSION['isGallery'])) {
            session_unregister('isGallery');
?><script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/gallery.js.php"></script><?php
        }
        /* If Grace slider should be shown */
        if ($_SESSION['showGrace'] == 'slides') {
?><script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/grace.js.php"></script>
<?php
        }
        if ($analytics) {
            echo stripslashes_deep($analytics);
        }
?>
        <script type="text/javascript" src="<?= bloginfo("template_directory") ?>/fancybox/jquery.fancybox-1.3.1.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".dgm_img a").fancybox({
            overlayOpacity:0.8,
            overlayColor:"#000"
        });
    })
</script>

