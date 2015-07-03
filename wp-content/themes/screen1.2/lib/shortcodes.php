<?php
@ini_set('pcre.backtrack_limit', 500000);

/* Converts shortcodes */
function teamDutchShortcodeConverter($content) {
	$new_content = '';
	
	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	
	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	
	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach($pieces as $piece) {
		/* Look for presence of the shortcode */
		if(preg_match($pattern_contents, $piece, $matches)) {
			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {
			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}
remove_filter('the_content',	'wpautop');
remove_filter('the_content',	'wptexturize');
add_filter('the_content', 'teamDutchShortcodeConverter', 99);

/* Shortcode conversion functions */
function teamDutchButton($atts, $content = null) {
  extract(shortcode_atts(array(
    'link' => '#',
    'target' => ''
  ), $atts));
	$target = ($target == 'blank' || $target == 'parent' || $target == 'self' || $target == 'top') ? $target : '';
	$target = ($target == 'blank') ? ' target="_blank"' : $target;
	$target = ($target == 'parent') ? ' target="_parent"' : $target;
	$target = ($target == 'self') ? ' target="_self"' : $target;
	$target = ($target == 'top') ? ' target="_top"' : $target;
	$out = '<a' .$target. ' class="td-button" href="' . $link . '"><span>' . do_shortcode($content) . '</span></a>';
  return $out;
}
add_shortcode('button', 'teamDutchButton');

function teamDutchTDLink( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'link' => '#',
	  'target'  => ''
  ), $atts));
	$target = ($target == 'blank' || $target == 'parent' || $target == 'self' || $target == 'top') ? $target : '';
	$target = ($target == 'blank') ? ' target="_blank"' : $target;
	$target = ($target == 'parent') ? ' target="_parent"' : $target;
	$target = ($target == 'self') ? ' target="_self"' : $target;
	$target = ($target == 'top') ? ' target="_top"' : $target;
	$out = '<a' .$target. ' class="td-link" href="' .$link. '">' .do_shortcode($content). '</a>';
  return $out;
}
add_shortcode('td_link', 'teamDutchTDLink');

function teamDutchDownloadLink( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'link' => '#'
  ), $atts));
	$out = '<a class="download-link" href="' .$link. '">' .do_shortcode($content). '</a>';  
  return $out;
}
add_shortcode('download_link', 'teamDutchDownloadLink');

function teamDutchEmailLink( $atts, $content = null ) {
  extract(shortcode_atts(array(
    'email' => '#',
	  'variation' => ''
  ), $atts));
	$out = '<a class="email-link" href="mailto:' . $email . '">' .do_shortcode($content). '</a>';
  return $out;
}
add_shortcode('email_link', 'teamDutchEmailLink');

function teamDutchDownloadBox( $atts, $content = null ) {
  return '<div class="download-box">' . do_shortcode($content) . '</div>';
}
add_shortcode('download_box', 'teamDutchDownloadBox');

function teamDutchInfoBox( $atts, $content = null ) {
  return '<div class="info-box">' . do_shortcode($content) . '</div>';
}
add_shortcode('info_box', 'teamDutchInfoBox');

function teamDutchTDTitledBox( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'title' => ''
  ), $atts));
	$out .= '<div class="td-titled-box">';
	$out .= '<h4 class="td-titled-box-header">' .$title. '</h4>';
	$out .= '<div class="td-titled-box-content">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	$out .= '</div>';
	return $out;
}
add_shortcode('td_titled_box', 'teamDutchTDTitledBox');

function teamDutchHeaderBox( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'title' => ''
  ), $atts));
	$out .= '<div class="box">';
	$out .= '<h6 class="box-header' .$style. '"><span>' .$title. '</span></h6>';
	$out .= '<div class="box-content">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	$out .= '</div>';
	return $out;
}
add_shortcode('header_box', 'teamDutchHeaderBox');

function teamDutchCheckList( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="check-list">', do_shortcode($content));
	$content = str_replace('<li>', '<li>', do_shortcode($content));
	return $content;
}
add_shortcode('check_list', 'teamDutchCheckList');

function teamDutchBulletList( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="bullet-list">', do_shortcode($content));
	return $content;	
}
add_shortcode('bullet_list', 'teamDutchBulletList');

function teamDutchToggleContent( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'title' => ''
  ), $atts));	
	$out .= '<h4 class="toggle"><a href="javascript:;">' .$title. '</a></h4>';
	$out .= '<div class="toggle-content" style="display: none;">';
	$out .= do_shortcode($content);
	$out .= '</div>';	
  return $out;
}
add_shortcode('toggle', 'teamDutchToggleContent');

function teamDutchToggleFramedContent( $atts, $content = null ) {
	extract(shortcode_atts(array(
    'title' => ''
  ), $atts));	
	$out .= '<div class="toggle-frame">';
	$out .= '<h4 class="toggle"><a href="javascript:;">' .$title. '</a></h4>';
	$out .= '<div class="toggle-content" style="display: none;">';
	$out .= '<div class="block">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	$out .= '</div>';
	$out .= '</div>';
	return $out;
}
add_shortcode('toggle_framed', 'teamDutchToggleFramedContent');

function teamDutchFramedTabsSet($atts, $content = null) {
	extract(shortcode_atts(array(), $atts));
	$out .= '[raw]<div class="framed-tab-set">[/raw]';
	$out .= '<ul class="tabs">';
	foreach ($atts as $tab) {
		$out .= '<li><a href="javascript:;">' .$tab. '</a></li>';
	}
	$out .= '</ul>';
        $out.='<div class="tabsombra1"></div>';
	$out .= do_shortcode($content) .'[raw]</div>[/raw]';	
	return $out;
}
add_shortcode('framed_tabs', 'teamDutchFramedTabsSet');

function teamDutchCustomTabs( $atts, $content = null ) {
	extract(shortcode_atts(array(), $atts));	
	$out .= '[raw]<div class="tab-content">[/raw]' . do_shortcode($content) .'</div>';
	return $out;
}
add_shortcode('tab', 'teamDutchCustomTabs');

function teamDutchContactInfo($atts) {
	extract(shortcode_atts(array(
	  'name' => '',
		'address' => '',
		'city' => '',
		'state' => '',
		'zip' => '',
		'phone' => '',
		'email' => ''		
  ), $atts));
	$out .= '[raw]';
	$out .= '<span class="contact-widget-name">' .$name. '</span><br />';
	$out .= '<span class="contact-widget-address">' .$address. '</span><br />';
	$out .= '<span class="contact-widget-city">' .$city. ',&nbsp;' .$state. '</span>&nbsp;';
	$out .= '<span class="contact-widget-zip">' .$zip. '</span><br />';
	$out .= '<span class="contact-widget-phone">' .$phone. '</span><br />';
	$out .= '<span class="contact-widget-email"><a href="mailto:' . $email . '" class="email-widget">' . $email. '</a></span><br />';
	$out .= '[/raw]';
	return $out;	
}
add_shortcode('contact_info', 'teamDutchContactInfo');

function teamDutchDropcap1( $atts, $content = null ) {
   return '<span class="dropcap1">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap1', 'teamDutchDropcap1');

function teamDutchDropcap2( $atts, $content = null ) {
   return '<span class="dropcap2">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap2', 'teamDutchDropcap2');

function teamDutchDropcap3( $atts, $content = null ) {
   return '<span class="dropcap3">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap3', 'teamDutchDropcap3');

function teamDutchPullquoteRight( $atts, $content = null ) {
   return '<span class="pullquote-right">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_right', 'teamDutchPullquoteRight');

function teamDutchPullquoteLeft( $atts, $content = null ) {
   return '<span class="pullquote-left">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_left', 'teamDutchPullquoteLeft');

function teamDutchOneThird( $atts, $content = null ) {
   return '<div class="one-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'teamDutchOneThird');

function teamDutchOneThirdLast( $atts, $content = null ) {
   return '<div class="one-third last">' . do_shortcode($content) . '</div><div class="floatfix"></div>';
}
add_shortcode('one_third_last', 'teamDutchOneThirdLast');

function teamDutchTwoThird( $atts, $content = null ) {
   return '<div class="two-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'teamDutchTwoThird');

function teamDutchTwoThirdLast( $atts, $content = null ) {
   return '<div class="two-third last">' . do_shortcode($content) . '</div><div class="floatfix"></div>';
}
add_shortcode('two_third_last', 'teamDutchTwoThirdLast');

function teamDutchOneHalf( $atts, $content = null ) {
   return '<div class="one-half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'teamDutchOneHalf');

function teamDutchOneHalfLast( $atts, $content = null ) {
   return '<div class="one-half last">' . do_shortcode($content) . '</div><div class="floatfix"></div>';
}
add_shortcode('one_half_last', 'teamDutchOneHalfLast');
?>