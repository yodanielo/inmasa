<?php
if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
  die ('Please do not load this page directly. Thanks!');
}
?>
<?php
if(post_password_required()) {
?>
<div class="floatfix"></div>
  <p id="comments"><?php echo trnslt('passwordProtectedPost'); ?></p>
<?php
  return;
}
if(have_comments()) { ?>
<div class="floatfix"></div>
  <p id="comments"><?php comments_number(trnslt('no comments'), '1 ' . trnslt('comment'), '% ' . trnslt('comments')); ?></p>
  <div class="navigation">
    <div class="alignleft"><?php previous_comments_link(); ?></div>
    <div class="alignright"><?php next_comments_link(); ?></div>
  </div>
  <ul class="commentlist">
    <?php wp_list_comments(array('avatar_size' => 40, 'style' => 'ul')); ?>
  </ul>
  <div class="navigation">
    <div class="alignleft"><?php previous_comments_link(); ?></div>
    <div class="alignright"><?php next_comments_link(); ?></div>
  </div>
<?php }
if(comments_open()) { ?>
  <div id="respond">
    <h3><?php echo trnslt('Add comment'); ?></h3>
    <p><?php cancel_comment_reply_link(); ?></p>
    
  <?php if(get_option('comment_registration') && !is_user_logged_in()) { ?>
  
    <p><a href="<?php echo wp_login_url(get_permalink()); ?>"><?php echo trnslt('Please login to place a comment.'); ?></a></p>
    
  <?php } else { ?>
  
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    
      <?php if(is_user_logged_in()) { ?>

        <p><?php echo trnslt('Logged in as'); ?>
        <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" id="username"><?php echo $user_identity; ?></a> <a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php echo trnslt('Logout'); ?> &raquo;</a></p>

      <?php } else { ?>

        <p><span><?php echo trnslt('Name'); ?></span>
        <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" /></p>
        <p><span><?php echo trnslt('E-mail'); ?></span>
        <input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" /></p>
        <p><span><?php echo trnslt('Website'); ?></span>
        <input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" /></p>

      <?php } ?>

      <p class="comment-textarea"><span><?php echo ucfirst(trnslt('comment')); ?></span>
      <textarea name="comment" id="comment" rows="" cols=""></textarea>
      <a href="javascript:sendComment();" class="cp td-button"><span><?php echo trnslt('Submit'); ?></span></a></p>
      <?php comment_id_fields(); ?>
      <?php do_action('comment_form', $post->ID); ?>
    </form>

  <?php } ?>

  </div>

<?php } ?>
