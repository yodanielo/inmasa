<?php
/* Team Dutch Google Maps Widgets */
class ThemeDutchGoogleMapsWidget extends WP_Widget {
    function ThemeDutchGoogleMapsWidget() {
        parent::WP_Widget(false, $name = 'TD Google Maps Widget');
    }
    
    /* Frontend */
    function widget($args, $instance) {
        extract($args);
        $title = esc_attr($instance['title']);
        $name = esc_attr($instance['name']);
        $address = esc_attr($instance['address']);
        $city = esc_attr($instance['city']);
        $postalcode = esc_attr($instance['postalcode']);
        $country = esc_attr($instance['country']);
        $telephone = esc_attr($instance['telephone']);
        $email = esc_attr($instance['email']);
        $showInfo = esc_attr($instance['showInfo']);
        $zoom = esc_attr($instance['zoom']);
        
        $contactInfo = '';
        if($showInfo == 'true') {
          if(trim($name) != '') { $contactInfo .= $name . '<br />'; }
          if(trim($address) != '') { $contactInfo .= $address . '<br />'; } 
          if(trim($postalcode) != '') { $contactInfo .= $postalcode . '<br />'; }
          if(trim($city) != '') { $contactInfo .= $city . '<br />'; }
          if(trim($country) != '') { $contactInfo .= $country; }
          if(trim($telephone) != '' || trim($email) != '') { $contactInfo .= '</p><p class="contactinfo clear">'; }
          if(trim($telephone) != '') { $contactInfo .= '<span class="contact-widget-phone">' . $telephone . '</span><br />'; }
          if(trim($email) != '') { $contactInfo .= '<span class="contact-widget-email"><a href="mailto:' . $email . '">' . $email . '</a></span>'; }
        }
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title . $title . $after_title; ?>
                  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
                  <script type="text/javascript">
                    var address = '<?php echo $address; ?>, <?php echo $city; ?>, <?php echo $country; ?>';
                    var zoom = <?php echo ($zoom != '') ? $zoom : 10; ?>;
                  </script>
                  <div id="googlemaps-container"><div id="googlemaps"></div></div>
                  <?php if($showInfo == 'true') { ?>
                  <p class="contact-widget-name"><?php echo $contactInfo; ?></p>
                  <?php } ?>
              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /* Backend */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $name = esc_attr($instance['name']);
        $address = esc_attr($instance['address']);
        $postalcode = esc_attr($instance['postalcode']);
        $city = esc_attr($instance['city']);
        $country = esc_attr($instance['country']);
        $telephone = esc_attr($instance['telephone']);
        $email = esc_attr($instance['email']);
        $showInfo = esc_attr($instance['showInfo']);
        $zoom = esc_attr($instance['zoom']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('name'); ?>"><?php echo 'Name:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" value="<?php echo $name; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('address'); ?>"><?php echo 'Address:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('address'); ?>" id="<?php echo $this->get_field_id('address'); ?>" value="<?php echo $address; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('postalcode'); ?>"><?php echo 'Postal code:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('postalcode'); ?>" id="<?php echo $this->get_field_id('postalcode'); ?>" value="<?php echo $postalcode; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('city'); ?>"><?php echo 'City:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('city'); ?>" id="<?php echo $this->get_field_id('city'); ?>" value="<?php echo $city; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('country'); ?>"><?php echo 'Country:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('country'); ?>" id="<?php echo $this->get_field_id('country'); ?>" value="<?php echo $country; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('telephone'); ?>"><?php echo 'Telephone:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('telephone'); ?>" id="<?php echo $this->get_field_id('telephone'); ?>" value="<?php echo $telephone; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('email'); ?>"><?php echo 'E-mail:'; ?><br /><input type="text" name="<?php echo $this->get_field_name('email'); ?>" id="<?php echo $this->get_field_id('email'); ?>" value="<?php echo $email; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('showInfo'); ?>"><?php echo 'Show info:'; ?><br /><select id="<?php echo $this->get_field_id('showInfo'); ?>" name="<?php echo $this->get_field_name('showInfo'); ?>"><option value="false"<?php if($showInfo == "false") { echo " selected"; } ?>>no</option><option value="true"<?php if($showInfo == "true") { echo " selected"; } ?>>yes</option></select></label></p>
            
            <p><label for="<?php echo $this->get_field_id('zoom'); ?>"><?php echo 'Zoom level (1-20):'; ?><br /><input type="text" name="<?php echo $this->get_field_name('zoom'); ?>" id="<?php echo $this->get_field_id('zoom'); ?>" value="<?php echo $zoom; ?>" /></label></p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ThemeDutchGoogleMapsWidget");'));

/* Team Dutch Page Widgets */
class ThemeDutchPageWidget extends WP_Widget {
    function ThemeDutchPageWidget() {
        parent::WP_Widget(false, $name = 'TD Page Widget');
    }
    
    /* Frontend */
    function widget($args, $instance) {
        extract($args);
        $page_id = $instance['page_id'];
        $page = get_page($page_id);
        $title = $page->post_title;
        $excerpt = shorten($page->post_content, 250);
        $link = get_page_link($page_id);
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title . $title . $after_title; ?>
                  <div class="textwidget">
                  <?php echo '<p>'.$excerpt.'</p>'; ?>
                  <a href="<?php echo $link; ?>" class="readmore"><?php echo trnslt('read more'); ?> &raquo;</a>
                  </div>
              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /* Backend */
    function form($instance) {
        $page_id = esc_attr($instance['page_id']);
        ?>
            <p><label for="<?php echo $this->get_field_id('page_id'); ?>"><?php echo 'Page:'; ?> <select name="<?php echo $this->get_field_name('page_id'); ?>" id="<?php echo $this->get_field_id('page_id'); ?>">
            <?php
            $pages = get_pages(); 
            foreach($pages as $p) {
            	if($p->ID == $page_id) {
            	  $option = '<option value="'.$p->ID.'" selected="selected">';
            	} else {
            	  $option = '<option value="'.$p->ID.'">';
            	}
          	  $option .= $p->post_title;
          	  $option .= '</option>';
          	  echo $option;
            }
          
          ?>
            </select></label></p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ThemeDutchPageWidget");'));

/* Team Dutch Post Widgets */
class ThemeDutchPostWidget extends WP_Widget {
    function ThemeDutchPostWidget() {
        parent::WP_Widget(false, $name = 'TD Post Widget');
    }

    /* Frontend */
    function widget($args, $instance) {
        extract($args);
        $post_id = $instance['post_id'];
        $post = get_post($post_id);
        setup_postdata($post);
        $content = shorten(get_the_content(), 250);
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title; ?><?php the_title(); ?><?php echo $after_title; ?>
                  <div class="textwidget">
                  <p><?php echo $content; ?></p>
                  <a href="<?php echo $link; ?>" class="readmore"><?php echo trnslt('read more'); ?> &raquo;</a>
                  </div>
              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /* Backend */
    function form($instance) {
        $post_id = esc_attr($instance['post_id']);
        ?>
            <p><label for="<?php echo $this->get_field_id('post_id'); ?>"><?php echo 'Post:'; ?> <select name="<?php echo $this->get_field_name('post_id'); ?>" id="<?php echo $this->get_field_id('post_id'); ?>">
            <?php
            $posts = get_posts();
            print_r($posts);
            foreach($posts as $p) {
            	if($p->ID == $post_id) {
            	  $option = '<option value="'.$p->ID.'" selected="selected">';
            	} else {
            	  $option = '<option value="'.$p->ID.'">';
            	}
          	  $option .= $p->post_title;
          	  $option .= '</option>';
          	  echo $option;
            }
          
          ?>
            </select></label></p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ThemeDutchPostWidget");'));

/* Register custom sidebars */
if(function_exists('register_sidebar')) {
  /* Sidebars */
  $sidebars = get_option('_screen-sidebars');
  if(is_string($sidebars)) {
    $sidebars = unserialize($sidebars);
  } else {
    $sidebars = array();
  }
  if($sidebars) {
    foreach($sidebars AS $sb) {
      register_sidebar(array('name' => 'S: ' . $sb, 'id' => 'theme-dutch-sidebar-' . $sb, 'before_widget' => '', 'after_widget' => '', 'before_title' => '<h3>', 'after_title' => '</h3>'));
    }
  }
  
  /* Footer sidebars */
  $footersidebars = get_option('_screen-footersidebars');
  if(is_string($footersidebars)) {
    $footersidebars = unserialize($footersidebars);
  } else {
    $footersidebars = array();
  }
  if($footersidebars) {
    foreach($footersidebars AS $f) {
      register_sidebar(array('name' => 'F: ' . $f, 'id' => 'theme-dutch-footersidebar-' . $f, 'before_widget' => '<div class="widget">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
    }
  }
}
add_filter('widget_text', 'do_shortcode');
?>