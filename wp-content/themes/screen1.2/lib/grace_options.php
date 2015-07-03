<?php
/* Update Grace field */
function updateGraceField($post_id, $field) {
  $current_data = get_post_meta($post_id, $field, true);
	$new_data = $_POST[$field];
	
  if($current_data !== false) {
    if($new_data == '') {
    	delete_post_meta($post_id, $field);
    } elseif ($new_data != $current_data) {
    	update_post_meta($post_id, $field, $new_data);
    }
  }	elseif($new_data != '') {
  	add_post_meta($post_id, $field, $new_data, true);
  }
}

/* Update Grace options */
function graceUpdateOptions($post_id) {
  /* Update fields */
  $optionFields = array('_grace-videoW', '_grace-videoH', '_grace-vimeo', '_grace-youtube', '_grace-custom', '_grace-autoplay', '_grace-showGrace', '_grace-slideW', '_grace-slideH', '_grace-slideTime', '_grace-showSlides', '_grace-showTimer');
  foreach($optionFields AS $m) {
    updateGraceField($post_id, $m);
	}
	
	/* Remove old slides */
	for($i = 1; get_post_meta($post_id, '_grace-type_' . $i, true); $i++) {
		delete_post_meta($post_id, '_grace-type_' . $i);
	  delete_post_meta($post_id, '_grace-img_' . $i);
	  delete_post_meta($post_id, '_grace-nr_' . $i);
	  delete_post_meta($post_id, '_grace-delay_' . $i);
	  delete_post_meta($post_id, '_grace-time_' . $i);
	  delete_post_meta($post_id, '_grace-easing_' . $i);
	  delete_post_meta($post_id, '_grace-invert_' . $i);
	  delete_post_meta($post_id, '_grace-directionx_' . $i);
	  delete_post_meta($post_id, '_grace-directiony_' . $i);
	  delete_post_meta($post_id, '_grace-fade_' . $i);
	  delete_post_meta($post_id, '_grace-title_' . $i);
	  delete_post_meta($post_id, '_grace-text_' . $i);
	  delete_post_meta($post_id, '_grace-link_' . $i);
	}
	
	/* Save new slides */
  for($i = 1; isset($_POST['_grace-type_' . $i]); $i++) {
    updateGraceField($post_id, '_grace-type_' . $i);
    updateGraceField($post_id, '_grace-img_' . $i);
    if($_POST['_grace-nr_' . $i] > 100) { $_POST['_grace-nr_' . $i] = 100; }
    updateGraceField($post_id, '_grace-nr_' . $i);
    updateGraceField($post_id, '_grace-delay_' . $i);
    updateGraceField($post_id, '_grace-time_' . $i);
    updateGraceField($post_id, '_grace-easing_' . $i);
    updateGraceField($post_id, '_grace-invert_' . $i);
    updateGraceField($post_id, '_grace-directionx_' . $i);
    updateGraceField($post_id, '_grace-directiony_' . $i);
    updateGraceField($post_id, '_grace-fade_' . $i);
    updateGraceField($post_id, '_grace-title_' . $i);
    $_POST['_grace-text_' . $i] = shorten($_POST['_grace-text_' . $i], 250);
    updateGraceField($post_id, '_grace-text_' . $i);
    $_POST['_grace-link_' . $i] = checkLinkForHttp($_POST['_grace-link_' . $i]);
	  updateGraceField($post_id, '_grace-link_' . $i);
	}
}

/* Display Grace options */
function placeGraceOptions() {
  global $post, $jQueryLoaded;
  
  /* General options */
  $showGrace = get_post_meta($post->ID, '_grace-showGrace', true);
  $slideW = 960; //get_post_meta($post->ID, '_grace-slideW', true);
  $slideH = get_post_meta($post->ID, '_grace-slideH', true);
  $slideTime = get_post_meta($post->ID, '_grace-slideTime', true);
  $showSlides = get_post_meta($post->ID, '_grace-showSlides', true);
  $showTimer = get_post_meta($post->ID, '_grace-showTimer', true);
	?>
  <table cellpadding="0" cellspacing="5">
    <tr>
      <td width="150">Grace this page:</td>
      <td><select id="grace-showGrace" name="_grace-showGrace" onChange="showGraceFields();"><option value="false"<?php
      if($showGrace == "false") { echo " selected"; }
      ?>>no</option><option<?php
      if($showGrace == "slides") { echo " selected"; }
      ?>>slides</option><option<?php
      if($showGrace == "video") { echo " selected"; }
      ?>>video</option></select></td>
    </tr>
  </table>
  <div id="grace-slides-options"<?php
  /* Grace slide options */
  if($showGrace != 'slides') { echo ' style="display:none;"'; }
  ?>>
  <table cellpadding="0" cellspacing="5" style="margin-top:10px; border-top:#eee solid 1px; width:100%;">
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">Slides options</p>
    </tr>
    <tr>
      <td width="150">Slide width:</td>
      <td><input type="text" id="grace-slideW" name="_grace-slideW" value="<?php echo $slideW; ?>" style="width:70px;" readonly /> px</td>
    </tr>
    <tr>
      <td>Slide height:</td>
      <td><input type="text" id="grace-slideH" name="_grace-slideH" value="<?php echo $slideH; ?>" style="width:70px;" /> px</td>
    </tr>
    <tr>
      <td>Time between slides:</td>
      <td><input type="text" id="grace-slideTime" name="_grace-slideTime" value="<?php echo $slideTime; ?>" style="width:70px;" /> ms</td>
    </tr>
    <tr>
      <td>Show slides:</td>
      <td><select id="grace-showSlides" name="_grace-showSlides"><option value="thumbnails"<?php
      if($showSlides == "thumbnails") { echo " selected"; }
      ?>>as thumbnails</option><option value="squares"<?php
      if($showSlides == "squares") { echo " selected"; }
      ?>>as squares</option><option value="false"<?php
      if($showSlides == "false") { echo " selected"; }
      ?>>no</option></select></td>
    </tr>
    <tr>
      <td>Show time indicator:</td>
      <td><select id="grace-showTimer" name="_grace-showTimer"><option value="true"<?php
      if($showTimer == "true") { echo " selected"; }
      ?>>yes</option><option value="false"<?php
      if($showTimer == "false") { echo " selected"; }
      ?>>no</option></select></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Select slide to edit:</td>
      <td><select id="grace-slides" name="grace-slides" onChange="toggleGraceSlide();"><?php
      $i = 1;
      while(get_post_meta($post->ID, '_grace-type_' . $i, true)) {
        echo '<option value="' . $i . '">Slide #' . $i . '</option>';
        $i++;
      }
      ?></select></td>
    </tr>
    <tr>
      <td colspan="2"><input type="button" id="grace-addNewSlide" name="grace-addNewSlide" value="Add new slide" /></td>
    </tr>
  </table>
  <div id="grace-slidetables">
  <?php
  /* Slide options */
$i = 0;
while($i == 0 || get_post_meta($post->ID, '_grace-type_' . $i, true)) {
  $type = $img = $nr = $delay = $time = $easing = $invert = $directionx = $directiony = $fade = $title = $text = $hide = '';
  if($i > 0) {
    $type = get_post_meta($post->ID, '_grace-type_' . $i, true);
    $img = get_post_meta($post->ID, '_grace-img_' . $i, true);
    $nr = get_post_meta($post->ID, '_grace-nr_' . $i, true);
    $delay = get_post_meta($post->ID, '_grace-delay_' . $i, true);
    $time = get_post_meta($post->ID, '_grace-time_' . $i, true);
    $easing = get_post_meta($post->ID, '_grace-easing_' . $i, true);
    $invert = get_post_meta($post->ID, '_grace-invert_' . $i, true);
    $directionx = get_post_meta($post->ID, '_grace-directionx_' . $i, true);
    $directiony = get_post_meta($post->ID, '_grace-directiony_' . $i, true);
    $fade = get_post_meta($post->ID, '_grace-fade_' . $i, true);
    $title = get_post_meta($post->ID, '_grace-title_' . $i, true);
    $text = get_post_meta($post->ID, '_grace-text_' . $i, true);
    $link = get_post_meta($post->ID, '_grace-link_' . $i, true);
  } 
  if($i != 1) {
    $hide = ' display:none;"';
  }
  ?>
  <table cellpadding="0" cellspacing="5" style="margin-top:10px; border-top:#eee solid 1px; width:100%;<?php echo $hide; ?>" id="grace-slidetable_<?php echo $i; ?>">
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">Slide #<span id="grace-slide-number"><?php echo $i; ?></span></td>
    </tr>
    <tr>
      <td colspan="2"><input type="button" id="grace-removeSlide_<?php echo $i; ?>" name="grace-removeSlide_<?php echo $i; ?>" value="Remove this slide" /></td>
    </tr>
    <tr>
      <td width="150">Transition type:</td>
      <td><select id="grace-type_<?php echo $i; ?>" name="_grace-type_<?php echo $i; ?>" onChange="updateGraceFields(this.id);"><option value="vertical"<?php
      if($type == "vertical") { echo " selected"; }
      ?>>Move vertical</option><option value="horizontal"<?php
      if($type == "horizontal") { echo " selected"; }
      ?>>Move horizontal</option><option value="fade"<?php
      if($type == "fade") { echo " selected"; }
      ?>>Fade in</option></select></td>
    </tr>
    <tr>
      <td valign="top" style="padding:3px 0 0 0;">Image:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="grace-img_<?php echo $i; ?>" name="_grace-img_<?php echo $i; ?>" value="<?php echo $img; ?>" style="width:350px; margin:0 0 5px 0;" /><br /><span style="color:#999; font-size:10px;">Enter the full URL of your slide image (e.g. http://www.yoursite.com/images/slide.jpg)</span></td>
    </tr>
    <tr id="grace-tr-nr_<?php echo $i; ?>">
      <td>Number of slices:</td>
      <td><input type="text" id="grace-nr_<?php echo $i; ?>" name="_grace-nr_<?php echo $i; ?>" value="<?php echo $nr; ?>" style="width:70px;"/><span style="color:#999; margin:5px 0 0 5px;">max. 50</span></td>
    </tr>
    <tr id="grace-tr-delay_<?php echo $i; ?>">
      <td>Delay between slices:</td>
      <td><input type="text" id="grace-delay_<?php echo $i; ?>" name="_grace-delay_<?php echo $i; ?>" value="<?php echo $delay; ?>" style="width:70px;" /> ms</td>
    </tr
    <tr>
      <td valign="top" style="padding:5px 0 0 0;">Transition time:</td>
      <td style="padding:0 0 5px 0;"><input type="text" id="grace-time_<?php echo $i; ?>" name="_grace-time_<?php echo $i; ?>" value="<?php echo $time; ?>" style="width:70px; margin:0 0 5px 0;" /> ms<br /><span style="color:#999; font-size:10px; line-height:16px;">For a smooth animation, make sure the time between slides exceeds the number of slices times the<br />delay per slice, plus the slice transition time.<br /> (e.g. 10 slices x (50 ms delay + 450 ms transition time) = a minimum of 5000 ms time between slides.</span></td>
    </tr>
    <tr>
      <td>Transition easing:</td>
      <td><select id="grace-easing_<?php echo $i; ?>" name="_grace-easing_<?php echo $i; ?>"><option<?php
      if($easing == "linear") { echo " selected"; }
      ?>>linear</option><option<?php
      if($easing == "easeInCubic") { echo " selected"; }
      ?>>easeInCubic</option><option<?php
      if($easing == "easeOutCubic") { echo " selected"; }
      ?>>easeOutCubic</option><option<?php
      if($easing == "easeInExpo") { echo " selected"; }
      ?>>easeInExpo</option><option<?php
      if($easing == "easeOutExpo") { echo " selected"; }
      ?>>easeOutExpo</option><option<?php
      if($easing == "easeInElastic") { echo " selected"; }
      ?>>easeInElastic</option><option<?php
      if($easing == "easeOutElastic") { echo " selected"; }
      ?>>easeOutElastic</option><option<?php
      if($easing == "easeInBack") { echo " selected"; }
      ?>>easeInBack</option><option<?php
      if($easing == "easeOutBack") { echo " selected"; }
      ?>>easeOutBack</option><option<?php
      if($easing == "easeInBounce") { echo " selected"; }
      ?>>easeInBounce</option><option<?php
      if($easing == "easeOutBounce") { echo " selected"; }
      ?>>easeOutBounce</option></select></td>
    </tr>
    <tr id="grace-tr-invert_<?php echo $i; ?>">
      <td>Invert <span id="grace-labelx-invert_<?php echo $i; ?>" style="display:none;">x</span><span id="grace-labely-invert_<?php echo $i; ?>">y</span>-axis:</td>
      <td><select id="grace-invert_<?php echo $i; ?>" name="_grace-invert_<?php echo $i; ?>"><option value="false"<?php
      if($invert == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($invert == "true") { echo " selected"; }
      ?>>yes</option></select></td>
    </tr>
    <tr id="grace-tr-direction_<?php echo $i; ?>">
      <td>Transition direction:</td>
      <td><select id="grace-directionx_<?php echo $i; ?>" name="_grace-directionx_<?php echo $i; ?>"><option value="fromleft"<?php
      if($directionx == "fromleft") { echo " selected"; }
      ?>>From left</option><option value="fromright"<?php
      if($directionx == "fromright") { echo " selected"; }
      ?>>From right</option><option value="frommiddle"<?php
      if($directionx == "frommiddle") { echo " selected"; }
      ?>>From middle</option><option value="tomiddle"<?php
      if($directionx == "tomiddle") { echo " selected"; }
      ?>>To middle</option><option value="random"<?php
      if($directionx == "random") { echo " selected"; }
      ?>>Random</option></select>
      <select id="grace-directiony_<?php echo $i; ?>" name="_grace-directiony_<?php echo $i; ?>" style="display:none;"><option value="fromtop"<?php
      if($directiony == "fromtop") { echo " selected"; }
      ?>>From top</option><option value="frombottom"<?php
      if($directiony == "frombottom") { echo " selected"; }
      ?>>From bottom</option><option value="frommiddle"<?php
      if($directiony == "frommiddle") { echo " selected"; }
      ?>>From middle</option><option value="tomiddle"<?php
      if($directiony == "tomiddle") { echo " selected"; }
      ?>>To middle</option><option value="random"<?php
      if($directiony == "random") { echo " selected"; }
      ?>>Random</option></select></td>
    </tr>
    <tr id="grace-tr-fade_<?php echo $i; ?>">
      <td>Fade in slices:</td>
      <td><select id="grace-fade_<?php echo $i; ?>" name="_grace-fade_<?php echo $i; ?>"><option value="true"<?php
      if($fade == "true") { echo " selected"; }
      ?>>yes</option><option value="false"<?php
      if($fade == "false") { echo " selected"; }
      ?>>no</option></select></td>
    </tr>
    <tr>
      <td>Overlay title: <span style="color:#ccc;">(optional)</span></td>
      <td><input type="text" id="grace-title_<?php echo $i; ?>" name="_grace-title_<?php echo $i; ?>" value="<?php echo $title; ?>" style="width:350px;" /></td>
    </tr>
    <tr>
      <td valign="top" style="padding:5px 0 0 0;">Overlay text: <span style="color:#ccc; line-height:18px;">(optional)</span></td>
      <td><textarea id="grace-text_<?php echo $i; ?>" name="_grace-text_<?php echo $i; ?>" style="height:120px; width:350px; float:left;"><?php echo $text; ?></textarea><span style="color:#999; float:left; margin:5px 0 0 5px;"><strong id="grace-text_<?php echo $i; ?>-count">250</strong> characters left</span></td>
    </tr>
    <tr>
      <td>Overlay link: <span style="color:#ccc;">(optional)</span></td>
      <td><input type="text" id="grace-link_<?php echo $i; ?>" name="_grace-link_<?php echo $i; ?>" value="<?php echo $link; ?>" style="width:350px;" /></td>
    </tr>
  </table><?php
  $i++;
}
  ?>
  </div>
  </div><?php
  /* Grace video options */
  $videoW = 960; //get_post_meta($post->ID, '_grace-videoW', true);
  $videoH = get_post_meta($post->ID, '_grace-videoH', true);
  $vimeo = get_post_meta($post->ID, '_grace-vimeo', true);
  $youtube = get_post_meta($post->ID, '_grace-youtube', true);
  $custom = get_post_meta($post->ID, '_grace-custom', true);
  $autoplay = get_post_meta($post->ID, '_grace-autoplay', true);
  ?><div id="grace-video-options"<?php
  if($showGrace != 'video') { echo ' style="display:none;"'; }
  ?>>
  <table cellpadding="0" cellspacing="5" style="margin-top:10px; border-top:#eee solid 1px; width:100%;">
    <tr>
      <td colspan="2" style="color:#bbb; padding:10px 0;">Video options</p>
    </tr>
    <tr>
      <td width="150">Video width:</td>
      <td><input type="text" id="grace-videoW" name="_grace-videoW" value="<?php echo $videoW; ?>" style="width:70px;" readonly /> px</td>
    </tr>
    <tr>
      <td>Video height:</td>
      <td><input type="text" id="grace-videoH" name="_grace-videoH" value="<?php echo $videoH; ?>" style="width:70px;" /> px</td>
    </tr>
    <tr>
      <td>Vimeo:</td>
        <td style="color:#bbb;">www.vimeo.com/<input type="text" id="grace-vimeo" name="_grace-vimeo" value="<?php echo $vimeo; ?>" style="width:240px;" /></td>
    </tr>
    <tr>
      <td>YouTube:</td>
        <td style="color:#bbb;">www.youtube.com/watch?v=<input type="text" id="grace-youtube" name="_grace-youtube" value="<?php echo $youtube; ?>" style="width:168px;" /></td>
    </tr>
    <tr>
      <td valign="top" style="padding:5px 0 0 0;">Custom:</td>
        <td style="color:#bbb;"><input type="text" id="grace-custom" name="_grace-custom" value="<?php echo $custom; ?>" style="width:350px;" /><br /><span style="color:#999; font-size:10px; line-height:14px;">Enter the full URL of your background video (e.g. http://www.yoursite.com/videos/video.flv)<br />Supported file types: flv, f4v, mp4, mov</span></td>
    </tr>
    <tr>
      <td>Autoplay:</td>
      <td><select id="grace-autoplay" name="_grace-autoplay"><option value="false"<?php
      if($autoplay == "false") { echo " selected"; }
      ?>>no</option><option value="true"<?php
      if($autoplay == "true") { echo " selected"; }
      ?>>yes</option></select></td>
    </tr>
  </table>
  </div>
  <?php
  /* Check whether jQuery was already loaded */
  if(!isset($jQueryLoaded) || !$jQueryLoaded) { ?><script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/jquery-1.4.2.min.js"></script><?php }
  ?>
  <script type="text/javascript">
    var nrOfSlides = <?php echo ($i - 1); ?>;
    $(document).ready(function() {
      $('#grace-addNewSlide').css('cursor', 'pointer');
      $('#grace-addNewSlide').click(addNewGraceSlide);
      for(var i = 1; i <= nrOfSlides; i++) {
        $('#grace-removeSlide_' + i).css('cursor', 'pointer');
        $('#grace-removeSlide_' + i).click(function() { removeGraceSlide(this.id); $(this).unbind('click'); });
        if($('#grace-type_' + i).val() == 'fade') {
          $('#grace-tr-nr_' + i).fadeOut(200);
          $('#grace-tr-delay_' + i).fadeOut(200);
          $('#grace-tr-invert_' + i).fadeOut(200);
          $('#grace-tr-direction_' + i).fadeOut(200);
          $('#grace-tr-fade_' + i).fadeOut(200);
        }
        $('#grace-text_' + i).keyup(function() { updateGraceCharCounter('#' + $(this).attr('id'), 250); } );
        updateGraceCharCounter('#grace-text_' + i, 250);
      }
    });
    function updateGraceCharCounter(id, max) {
      var l = max - $(id).val().length;
      var c = '';
      if(l < 10) {
        c = '#be0000';
      } else if(l < 25) {
        c = '#ac4c4c';
      } else {
        c = '#999';
      }
      $(id + '-count').html(l).css('color', c);
    }
    function showGraceFields() {
      switch($('#grace-showGrace').val()) {
        case 'slides':
          $('#grace-video-options').fadeOut(200);
          $('#grace-slides-options').fadeIn();
          break;
        case 'video':
          $('#grace-slides-options').fadeOut(200);
          $('#grace-video-options').fadeIn();
          break;
        default:
          $('#grace-slides-options').fadeOut(200);
          $('#grace-video-options').fadeOut(200);
          break;
      }
    }
    function removeGraceSlide(id) {
      var i = Number(id.replace('grace-removeSlide_', ''));
      $('#grace-slidetable_' + i).animate({'opacity':0}, {queue:false, duration:600, complete:function() {
        $(this).remove();
        $('#grace-slides option[value="' + nrOfSlides + '"]').remove(); 
        $('#grace-slides').val(1);
        nrOfSlides--;
        toggleGraceSlide();
      }});
      for(var j = (i + 1); j <= nrOfSlides; j++) {
        var obj = document.getElementById('grace-slidetable_' + j);
        fixGraceSlideNumber(obj, j, (j - 1));
      }
    }
    function fixGraceSlideNumber(node, oldI, newI) {
      var n = node.name;
      if(n) {
        node.setAttribute('name', n.replace('_' + oldI, '_' + newI));
      }
      var id = node.id;
      if(id) {
        node.setAttribute('id', id.replace('_' + oldI, '_' + newI));
        if(id == 'grace-slide-number') {
          node.innerHTML = newI;
        }
      }
      if(node.hasChildNodes()) {
        for(var j = 0; j < node.childNodes.length && node.childNodes[j] != undefined; j++) {
          fixGraceSlideNumber(node.childNodes[j], oldI, newI);
        }
      }
    };
    function addNewGraceSlide() {
      if($('#grace-slidetable_0').length > 0) {
        nrOfSlides++
        $('#grace-slidetable_0').clone().appendTo('#grace-slidetables').css('display', '').attr('id', 'grace-slidetable_' + nrOfSlides);
        fixGraceSlideNumber(document.getElementById('grace-slidetable_' + nrOfSlides), 0, nrOfSlides);
        $('#grace-slides').append('<option value="' + nrOfSlides + '">Slide #' + nrOfSlides + '</option>');
        $('#grace-slides').val(nrOfSlides);
        toggleGraceSlide();
        for(var i = 1; i <= nrOfSlides; i++) {
          $('#grace-removeSlide_' + i).css('cursor', 'pointer');
          $('#grace-removeSlide_' + i).click(function() { removeGraceSlide(this.id); });
        }
      }
    };
    function toggleGraceSlide() {
      for(var i = 1; i <= nrOfSlides; i++) {
        $('#grace-slidetable_' + i).css('display', 'none');
      }
      $('#grace-slidetable_' + $('#grace-slides').val()).css('display', 'block');
    }
    function updateGraceFields(id) {
      var i = id.replace('grace-type_', '');
      switch($('#grace-type_' + i).val()) {
        case 'vertical':
          $('#grace-labelx-invert_' + i).hide();
          $('#grace-labely-invert_' + i).show();
          $('#grace-directionx_' + i).show();
          $('#grace-directiony_' + i).hide();
          
          $('#grace-tr-nr_' + i).fadeIn();
          $('#grace-tr-delay_' + i).fadeIn();
          $('#grace-tr-invert_' + i).fadeIn();
          $('#grace-tr-direction_' + i).fadeIn();
          $('#grace-tr-fade_' + i).fadeIn();
          break;
        case 'horizontal':
          $('#grace-labelx-invert_' + i).show();
          $('#grace-labely-invert_' + i).hide();
          $('#grace-directionx_' + i).hide();
          $('#grace-directiony_' + i).show();
          
          $('#grace-tr-nr_' + i).fadeIn();
          $('#grace-tr-delay_' + i).fadeIn();
          $('#grace-tr-invert_' + i).fadeIn();
          $('#grace-tr-direction_' + i).fadeIn();
          $('#grace-tr-fade_' + i).fadeIn();
          break;
        case 'fade':
          $('#grace-tr-nr_' + i).fadeOut(200);
          $('#grace-tr-delay_' + i).fadeOut(200);
          $('#grace-tr-invert_' + i).fadeOut(200);
          $('#grace-tr-direction_' + i).fadeOut(200);
          $('#grace-tr-fade_' + i).fadeOut(200);
          break;
      }
    }
  </script>
  <?php
}
?>