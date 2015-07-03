<?php
/* Include Grace frontend */
include_once('lib/grace_frontend.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once(TEMPLATEPATH . '/head.php'); ?>
        <link rel='stylesheet' title='fancy' href='<?=bloginfo("template_directory")?>/fancybox/jquery.fancybox-1.3.1.css' />
    </head>

    <body>

        <div id="container">
            <?php
            /* Check whether Grace should be displayed */
            if ($_SESSION['showGrace'] == 'slides' || $_SESSION['showGrace'] == 'video') {
            ?>
                <div id="grace" style="width:<?php echo $_SESSION['slideW']; ?>px; height:<?php echo ($_SESSION['slideH'] + 25); ?>px;">
                <?php /* <div id="grace-mask" style="width:<?php echo $_SESSION['slideW']; ?>px; height:<?php echo $_SESSION['slideH']; ?>px;">
                  <div id="grace-holder"><?php echo $video; ?></div>
                  </div> */ ?>
                <script type="text/javascript">
                    runSWF2("<?php bloginfo('template_url'); ?>/images/intro.swf", 960, 425, "9.0.0", "transparent")
                </script>
            </div>

            <?php
            }
            /* Get payoff color */
            $payoffColor = get_option('_screen-payoffColor');
            $payoffColor = ($payoffColor !== false) ? ' style="background:#' . $payoffColor . ';"' : '';

            /* Display Page/Post information */
            if (!is_home() && have_posts()) {
                the_post();
                $payoff = get_post_meta($post->ID, '_screen-payoff', true);
                $nuestros_trabajos = array(6, 7, 8, 9, 10, 11, 12, 13, 14);
                $miscats = wp_get_post_categories($post->ID);
                $estrabajos = false;
                foreach ($miscats as $nt) {
                    if (in_array($nt, $nuestros_trabajos)) {
                        $estrabajos = true;
                    }
                }
                //obtengo el padre
                if ($post->post_parent == 0 || $post->post_parent == "") {
                    $padre = get_cat_name($miscats[0]);
                } else {
                    $aux = get_post($post->post_parent);
                    $padre = $aux->post_title;
                }
                $lado2 = false;
            ?>
                <div id="heading">
                    <h1><?php
                if ($padre != "")
                    echo $padre;
                else {
                    echo the_title();
                    $lado2 = true;
                }
            ?></h1>
            </div>
            <div id="payoff"<?php echo $payoffColor ?>>
                <h2><?php
                    if ($estrabajos == false && $lado2 == false) {
                        the_title();
                    }
                    $volver = get_post_meta($post->ID, 'volver', true);

                    if ($volver == "no")
                        $lado2 = true;
            ?></h2>
            </div>
            <div class="floatfix ie7"></div>
            <div id="content" class="nohay">
                <div class="innerborder">
                    <div>
                        <div class="td-breadcrumb<?php
                    /* Display content according to chosen layout */
                    switch (get_post_meta($post->ID, '_screen-showSidebar', true)) {
                        case 'left':
                            echo ' sidebartop-l';
                            break;
                        case 'right':
                            echo ' sidebartop-r';
                            break;
                    }
            ?>"><span><?php
                             if ($_SERVER['REQUEST_URI'] == '/') {

                             } else {
            ?><a href="<?php bloginfo('url'); ?>"><?php echo trnslt('Home'); ?></a>
                                <?php
                                 $tempPost = $post;
                                 $breadcrumb = array();
                                 /* Find all the parent Posts/Pages for the breadcrumb */
                                 while ($tempPost->post_parent != 0) {
                                     $postPost = $tempPost->post_parent;
                                     $tempPost = get_page($postPost);
                                     $breadcrumb[] = array('title' => $tempPost->post_title, 'link' => get_permalink($tempPost->ID));
                                 }
                                 /* Fix breadcrumb direction */
                                 $breadcrumb = array_reverse($breadcrumb);

                                 /* Display breadcrumb */
                                 foreach ($breadcrumb AS $bc) {
                                ?>
                                     / <a href="<?php echo $bc['link']; ?>"><?php echo $bc['title']; ?></a>
                                <?php
                                 }
                                ?>/ <?php } the_title
                             (); ?></span></div>
                        <?php
                             /* Get sidebar */
                             $sidebar = get_post_meta($post->ID, '_screen-sidebar', true);
                             /* Display content according to chosen layout */
                             switch (get_post_meta($post->ID, '_screen-showSidebar', true)) {
                                 /* Right sidebar */
                                 case 'right':
                        ?>
                                     <div class="two-thirds-left">
                                         <div class="sidebarmiddle">
                                <?php
                                     //here is image width 575
                                     $imgmini = get_post_meta($post->ID, "imagen_de_articulo", true);
                                     if ($imgmini && $imgmini != "") {
                                ?>
                                         <div id="imgarticulo">
                                             <img src="<?= $imgmini ?>" width="575" class="imgarticulo"/>
                                             <img src="<?php bloginfo('template_url'); ?>/images/bgt-575sombra.png" class="imgsombra" />
                                         </div>
                                <?php
                                     }
                                ?>
                                <?php if ($post->post_type == 'post') {
 ?>
                                         <div class="blogmeta"><?php the_author_link(); ?> | <?php the_date(); ?> | <a href="#comments"><?php comments_number(trnslt('no comments'), '1 ' . trnslt('comment'), '% ' . trnslt('comments')); ?></a></div>
                                <?php } ?>
                                <?php
                                     if ($estrabajos == true) {
                                         echo '<div id="titlecuerpo">';
                                         the_title();
                                         echo '</div>';
                                     }
                                ?>
                                <?php
                                     echo str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
                                     if (!is_home() && $lado2 == false) {
 ?>
                                         <div class="readmore" style="text-align: right; clear:both;">
                                             <a href="javascript:history.back()" style=" clear:both;">&laquo; Volver</a>
                                         </div>
                                <?php
                                     }
                                     require_once(TEMPLATEPATH . '/contact.php');
                                     require_once(TEMPLATEPATH . '/ofertas.php');
                                     comments_template();
                                     echo '
              </div>
              <div class="sidebarbottom"></div>
            </div>
            <div class="one-third-right widgets">';
                                     if (!function_exists("dynamic_sidebar") || !dynamic_sidebar('S: ' . $sidebar)) {
                                         
                                     }
                                     echo '</div>';
                                     break;

                                 /* Left sidebar */
                                 case 'left':
                                     echo '<div class="one-third-left widgets">';
                                     if (!function_exists("dynamic_sidebar") || !dynamic_sidebar('S: ' . $sidebar)) {
                                         
                                     }
                                ?></div>
                                 <div class="two-thirds-right">
                                     <div class="sidebarmiddle">
                                    <?php if ($post->post_type == 'post') {
 ?>
                                         <div class="blogmeta"><?php the_author_link(); ?> | <?php the_date(); ?> | <a href="#comments"><?php comments_number(trnslt('no comments'), '1 ' . trnslt('comment'), '% ' . trnslt('comments')); ?></a></div>
                                    <?php } ?>
<?php
                                     echo str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
                                     if (!is_home() && $lado2 == false) {
?>
                                         <div class="readmore" style="text-align: right;">
                                             <a href="javascript:history.back()">&laquo; Volver</a>
                                         </div>
                                    <?php
                                     }
                                     require_once(TEMPLATEPATH . '/contact.php');
                                     require_once(TEMPLATEPATH . '/ofertas.php');
                                     comments_template();
                                     echo '
              </div>
              <div class="sidebarbottom"></div>
            </div>';
                                     break;

                                 /* Full width */
                                 default:
                                     if ($post->post_type == 'post') {
 ?>
                                         <div class="blogmeta"><?php the_author_link(); ?> | <?php the_date(); ?> | <a href="#comments"><?php comments_number(trnslt('no comments'), '1 ' . trnslt('comment'), '% ' . trnslt('comments')); ?></a></div>
                                    <?php
                                         if ($estrabajos == true) {
                                             echo '<div id="titlecuerpo">';
                                             the_title();
                                             echo '</div>';
                                         }
                                     }
                                    ?>
<?php
                                     echo str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));

                                     if (!is_home() && $lado2 == false) {
 ?>
                                         <div class="readmore" style="text-align: right;">
                                             <a href="javascript:history.back()">&laquo; Volver</a>
                                         </div>
                                    <?php
                                     }
                                     if ($post->ID == 16) {
                                         require_once(TEMPLATEPATH . '/sincontacto.php');
                                         require_once(TEMPLATEPATH . '/ofertas.php');
                                         comments_template();
                                     }
                                     break;
                             }
                                    ?>
                                    <div class="floatfix"></div>

                                        <?php
                                        /* Display footer */
                                        $footersidebar = get_post_meta($post->ID, '_screen-footersidebar', true);
                                        if ($footersidebar !== false && $footersidebar != 'false') {
                                        ?>
                                            <div class="divider"></div>
                                            <div class="widgets"><?php
                                            if (!function_exists("dynamic_sidebar") || !dynamic_sidebar('F: ' . $footersidebar)) {
                                                
                                            }
                                        ?></div>
                                            <div class="floatfix"></div><?php
                                        }
                                        ?>

                                                </div>

                                            </div>
                                        </div>
                                        <div id="content-s"></div>
<?php
                                        /* Display home information */
                                    } elseif (is_home ()) {
                                        /* Get home information */
                                        $homeTitle = get_option('_screen-home-title');
                                        $homeText = get_option('_screen-home-text');
                                        if (trim($homeTitle) != '') {
?>
                                            <div id="heading">
                                                <h1>HOME</h1>
                                            </div>
                                            <div id="payoff"<?php echo $payoffColor ?>>
                                                <h2><?php echo $homeTitle; ?></h2>
                                            </div>
<?php
                                        }
                                        if (trim($homeText) != '') {
?><div class="floatfix ie7"></div>
                                <div id="content" class="nohay">
                                    <div class="innerborder">
                                        <div>
                    <?php echo teamDutchShortcodeConverter(str_replace(']]>', ']]&gt;', apply_filters('the_content', stripslashes_deep($homeText)))); ?>
                                                            <div class="floatfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="content-s"></div>
                                            </div>

                <?php
                                        }
                                    }
                ?>
                                    </div>

<?php get_header(); ?>

<?php get_footer(); ?>

                </body>
                </html>
