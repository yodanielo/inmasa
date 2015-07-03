<?php
/* Register Wordpress 3.0 menus */
add_action('init', 'register_my_menus');
function register_my_menus() {
  register_nav_menu('screen-main-menu', 'Screen main-menu');
  $footermenus = get_option('_screen-footermenus');
  if(is_string($footermenus)) {
    $footermenus = unserialize($footermenus);
  } else {
    $footermenus = array();
  }
  if($footermenus) {
    foreach($footermenus AS $f) {
      register_nav_menu($f, $f);
    }
  }
}

/* Display Wordpress 3.0 menu */
class ThemeDutchMenuWalker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth, $args) {
	  global $wp_query, $customMenu;
	  $indent = ($depth) ? str_repeat("\t", $depth) : '';
    $output .= $indent . '<li>';
    
    $attributes  = (!empty($item->attr_title)) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= (!empty($item->target)) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= (!empty($item->xfn)) ? ' rel="' . esc_attr($item->xfn ) . '"' : '';
    $attributes .= (!empty($item->url)) ? ' href="' . esc_attr($item->url) . '"' : '';
        
    $subtitle = '';
    if($depth == 0) {
      if(!empty($item->attr_title)) {
        $subtitle = '<i class="menu-subtitle">' . $item->attr_title . '</i>';
      }
    }
    
    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
    $item_output .= $subtitle;
    $item_output .= '</a>';
    $item_output .= $args->after;
    
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

/* If no Wordpress 3.0 menu is set, fall back to the oldschool menu */
function oldSchoolWordpressMenu() {
  wp_page_menu(array('show_home' => true));
}
?>