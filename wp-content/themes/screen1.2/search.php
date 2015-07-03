<?php
  session_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once(TEMPLATEPATH . '/head.php'); ?>
</head>

<body>

  <div id="container">
  
    <div id="content">
      <div class="innerborder">
        <h2><?php echo trnslt('Results for'); ?> "<?php the_search_query(); ?>"</h2>
        <ul>
        <?php
        /* Display search results */
        if(have_posts()) {
          while(have_posts()) {
            the_post(); ?>
          <li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> <span class="date"> | <?php the_time('j.m.Y'); ?></span></a></li>
        <?php
          }
        } else {
        ?>
        <li><?php echo trnslt('No results'); ?>.</li>
        <?php
        }
        ?>
        </ul>
      </div>
    </div>
    <div id="content-s"></div>
  </div>
  
<?php get_header(); ?>
  
<?php get_footer(); ?>

</body>
</html>