<?php
/* Set array with translation strings */
$trnslt_vars = array('Home' => 'home', 'no comments' => 'noComments', 'comment' => 'comment', 'comments' => 'comments', 'search' => 'search', 'Results for' => 'resultsFor', 'No results' => 'noResults', 'Gender' => 'gender', 'Male' => 'male', 'Female' => 'female', 'Name' => 'name', 'Address' => 'address', 'Postal code' => 'postalcode', 'City' => 'city', 'Country' => 'country', 'Telephone' => 'telephone', 'E-mail' => 'email', 'Website' => 'website', 'Message' => 'message', 'Submit' => 'submit', 'Add comment' => 'addComment', 'Please login to place a comment.' => 'pleaseLogin', 'Logged in as' => 'loggedInAs', 'Logout' => 'logout', 'read more' => 'readMore', 'items' => 'items', 'Toggle fullscreen' => 'togglefullscreen', 'Toggle gallery info' => 'togglegalleryinfo', 'Previous category' => 'previouscategory', 'Next category' => 'nextcategory', 'Previous thumbnails' => 'previousthumbnails', 'Next thumbnails' => 'nextthumbnails', 'View this item' => 'viewthisitem', 'This message was sent from' => 'sentFrom', 'Please fill in all required (*) fields.' => 'requiredFields', 'Your information has been successfully sent.' => 'sendSuccess', 'Wrong CAPTCHA code entered.' => 'badCaptcha', 'Something went wrong whilst sending your information. Please try again at a later time.' => 'sendFailure', 'This post is password protected. Enter the password to view comments.' => 'passwordProtected');

require_once('lib/theme_options.php');
require_once('lib/post_options.php');
require_once('lib/widgets.php');
require_once('lib/menu.php');
require_once('lib/shortcodes.php');
require_once('lib/shortcodes/tinymce.php');

/* Translate string, returns input if no translation was found */
function trnslt($str) {
  global $trnslt_vars;
  if(array_key_exists($str, $trnslt_vars)) {
    $trnsltn = get_option('_screen-trnslt-' . $trnslt_vars[$str]);
    if($trnsltn !== false && trim($trnsltn) != '') {
      return $trnsltn;
    }
  }
  return $str;
}

/* Shorten a string */
function shorten($str, $chars) {
  $str = teamDutchShortcodeConverter(str_replace(']]>', ']]&gt;', apply_filters('the_content', $str)));
  $str = strip_tags($str);
  if(strlen($str) > $chars) {
    $str = substr($str, 0, $chars);
    $bits = explode(' ', $str);
    $last = strlen($bits[count($bits) - 1]) + 1;
    $str = substr($str, 0, -$last);
    while(in_array(substr($str, -1), array(' ', ',', '.', '?', '!'))) {
      $str = substr($str, 0, -1);
    }
    $str .= '...';
  }
  return $str;
}

/* Find first image in a post */
function get_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];
  return $first_img;
}

/* Remove all unsafe characters from a string */
function urlsafe($str) {
	$str = utf8_decode(html_entity_decode(html_entity_decode($str)));
	$str = str_replace(array(' ', ',', '.', '"', "'", '/', "\\", '+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`', '<', '>', '?', '[', ']', '{', '}', '|', ':'), '', $str);
	$bad = utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ');
	$bad_arr = array();
	for($i = 0; $i < strlen($bad); $i++) {
		$bad_arr[] = htmlentities($bad[$i]);
	}
	$good = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuuyybyRr';
	for($i = 0; $i < strlen($str); $i++) {
		for($j = 0; $j < count($bad_arr); $j++) {
			if(htmlentities($str[$i]) == $bad_arr[$j]) {
				$str[$i] = $good{$j};
			}
		}
	}
	for($i = 0; $i < strlen($str); $i++) {
		if(!ereg('[a-zA-Z0-9\-]', $str[$i])) {
			$str = str_replace($str[$i], '', $str);
		}
	}
	return $str;
}

/* Check if string contains http(s) and add if absent */
function checkLinkForHttp($str) {
  if(trim($str) != '' && strpos(strtolower($str), 'http://') === false && strpos(strtolower($str), 'https://') === false) {
		$str = 'http://' . $str;
	}
	return $str;
}

/* Make a relative path absolute */
function makePathAbsolute($str) {
  if(trim($str) != '' && strpos(strtolower($str), 'http://') === false && strpos(strtolower($str), 'https://') === false) {
		$str = get_bloginfo('template_url') . '/' . $str;
	}
	return $str;
}
/**--------------------------Dossier------------------------------------------*/
class Dossier extends WP_Widget {
    function Dossier() {
        //Constructor
        $widget_ops = array('classname' => 'Dossier', 'description' => 'Display an image with a only in one article' );
        $this->WP_Widget('Dossier', 'Dossier', $widget_ops);
    }
    function widget($args, $instance) {
        global $id;
        // prints the widget
        extract($args, EXTR_SKIP);
        if($id==169){
        ?>
<div class="widget">
    <div class="widgetdossier">
        <img src="<?php bloginfo('url'); ?>/wp-content/uploads/descargar-dossier.png"/>
    </div>
</div>
<?php
        }
    }
}
register_widget('Dossier');
?>