<?php
session_start();
/* If current category is selected for gallery, include gallery.php */
$galleryCategories = get_option('_screen-galleryCategories');
$galleryCategories = explode(';', $galleryCategories);
if(is_category($galleryCategories)) {
  require_once(TEMPLATEPATH . '/gallery.php');
  exit();
}
/* To make sure the footer include knows this is a category (the is_category() function always returns false in the footer...) */
$_SESSION['isCategory'] = true;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once(TEMPLATEPATH . '/head.php');
$payoffColor = get_option('_screen-payoffColor');
  $payoffColor = ($payoffColor !== false) ? ' style="background:#' . $payoffColor . ';"' : '';

  $padre=$wpdb->get_var("select wpt.name from wp_term_taxonomy as wptt
                        inner join wp_terms as wpt
                        on wptt.parent=wpt.term_id
                        where wptt.term_id=".$cat);

?>
</head>

<body>

  <div id="container">
      <div id="heading">
          <h1><?=$padre?></h1>
      </div>
      <div id="payoff"<?php echo $payoffColor ?>>
          <h2><?=get_cat_name($cat)?></h2>
      </div>
      <div class="floatfix ie7"></div>
    <div id="content">
      <div class="innerborder">
        <div>
        <?php
          for($i = 1; have_posts(); $i++) { the_post();
            /* Get class for chosen number of columns */
            $columns = get_option('_screen-category-layout');
            $class = 'one-third';
            $class = ($columns == 1) ? 'one-whole' : $class;
            $class = ($columns == 2) ? 'one-half' : $class;
            $class .= ($i % $columns == 0) ? ' last' : '';
          ?>
          <div class="<?php echo $class; ?> blog">
            <?php
               //Get and resize first post image
              $img = get_first_image();
              //echo $img;
              if($img != '') {
                $w = 270;
//                $w = ($columns == 1) ? 900 : $w;
//                $w = ($columns == 2) ? 432 : $w;
                $h = 185;
//                $h = ($columns == 1) ? 300 : $h;
//                $h = ($columns == 2) ? 150 : $h;
                echo '<a href="' . get_permalink() . '" class="hoverimg imagelist"><img src="' . get_bloginfo('template_url') . '/img.php?f=' . $img . '&w=' . $w . '&h=' . $h . '&a=c" alt="' . get_the_title() . '" /></a>';
              } else {
                echo '<p></p>';
              }
            ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="blogmeta"><?php the_author_link(); ?> | <?php echo get_the_date(); ?> | <a href="<?php the_permalink(); ?>#comments"><?php comments_number(trnslt('no comments'), '1 ' . trnslt('comment'), '% ' . trnslt('comments')); ?></a></div>
            <p><?php
              /* Shorten post content to 250 characters */
              echo shorten(str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content())), 250);
            ?></p>
            <!--<div class="blogdivider<?php echo $columns; ?>"></div>-->
            <div class="readmore"><a href="<?php the_permalink(); ?>"><?php echo trnslt('read more'); ?> &raquo;</a></div>
          </div>
        <?php
          }
        ?>
          <div class="floatfix"></div>
          <div class="postnavigation"><?php previous_posts_link(); ?></div>
          <div class="postnavigation alignright"><?php next_posts_link(); ?></div>
          <div class="floatfix"></div>
        </div>
      </div>
    </div>
    <div id="content-s"></div>
  </div>
  
<?php get_header(); ?>
  
<?php get_footer(); ?>

</body>
</html>