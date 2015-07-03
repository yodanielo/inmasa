<?php
session_start();
?>
var galleryInfo = [
  <?php
  $comma = '';
  foreach($_SESSION['galleryInfo'] AS $g) {
    echo $comma . '[' . $g . ']';
    $comma = ', ';
  } ?>
];
var galleryIndex = 0;

/* Load new Gallery item */
function loadGalleryItem(id) {
  if(id != undefined) {
    galleryIndex = id;
  }
  $('#gallery').fadeOut(400, function() {
    $('#gallery-main h2').html(galleryInfo[galleryIndex][0]);
    $('#gallery-main p').html(galleryInfo[galleryIndex][1]);
    <?php if($_SESSION['cufonEnabled'] == 'true') { ?>
      Cufon.replace('#gallery-main h2');
    <?php } ?>
    $('#bgholder').fadeOut(400, function() {
      if(galleryInfo[galleryIndex][4] != '' && galleryInfo[galleryIndex][4] != 'false') {
        $(this).html('<iframe src="' + galleryInfo[galleryIndex][4] + '"></iframe>');
        iframeResize();
        $(this).fadeIn(800);
        $('#gallery').delay(500).fadeIn(300);
      } else if(galleryInfo[galleryIndex][3] != '' && galleryInfo[galleryIndex][3] != 'false') {
        $(this).html('<object width="" height=""><param name="movie" value="<?php echo $_SESSION['template_url']; ?>tdplayer.swf?moviefile=' + galleryInfo[galleryIndex][3] + '&autoplay=1" /><param name="wmode" value="opaque"></param><embed src="<?php echo $_SESSION['template_url']; ?>tdplayer.swf?moviefile=' + galleryInfo[galleryIndex][3] + '&autoplay=1" type="application/x-shockwave-flash" wmode="opaque" width="" height=""></embed></object>');
        videoResize();
        $(this).fadeIn(800);
        $('#gallery').delay(500).fadeIn(300);
      } else if(galleryInfo[galleryIndex][2] != '' && galleryInfo[galleryIndex][2] != 'false') {
        $(this).html('<img src="' + galleryInfo[galleryIndex][2] + '" id="bgimg" alt="' + galleryInfo[galleryIndex][0] + '" />');
        var oImg = new Image();
        oImg.src = galleryInfo[galleryIndex][2];
        oImg.onload = function() {
          var orgW = oImg.width;
          var orgH = oImg.height;
          if(orgW != 0 && orgH != 0) {
          	var h = $(window).height();
          	var w = $(window).width();
          	var ratioW = w / orgW;
          	var ratioH = h / orgH;
          	if(ratioW > ratioH) {
          		$('#bgimg').css({'height':(w * orgH / orgW), 'width':w});
          	} else {
          		$('#bgimg').css({'height':h, 'width':(h * orgW / orgH)});
          	}
        	}
          $('#bgholder').fadeIn(800);
          $('#gallery').delay(500).fadeIn(300);
      	}
      }
    });
  });
}

/* Resize video player to match screen size */
function videoResize() {
  $('#bgholder object').attr('width', $(window).width());
  $('#bgholder object').attr('height', $(window).height());
  $('#bgholder object embed').attr('width', $(window).width());
  $('#bgholder object embed').attr('height', $(window).height());
}

/* Resize iframe to match screen size */
function iframeResize() {
  $('#bgholder iframe').attr('width', $(window).width());
  $('#bgholder iframe').attr('height', $(window).height());
}

$(document).ready(function() {
  /* Set Gallery controls slide in/out */
  setTimeout(function() {
    $('#gallery-holder').animate({'height':'280px'}, {queue:false, duration:400, easing:'easeInOutCubic', complete:function() {
      $('.gallery-toggle').stop(true, true).animate({'background-position':'left -27px'}, {queue:false, duration:300});
    }});
  }, 800);
  $('.gallery-toggle').click(function() {
    if($('#gallery-holder').css('height').replace('px', '') > 30) {
      $('#gallery-holder').stop(true, true).animate({'height':'30px'}, {queue:false, duration:400, easing:'easeInOutCubic', complete:function() {
        $('.gallery-toggle').stop(true, true).animate({'background-position':'left 3px'}, {queue:false, duration:500});      
      }});
    } else {
      $('#gallery-holder').stop(true, true).animate({'height':'280px'}, {queue:false, duration:500, easing:'easeInOutCubic', complete:function() {
        $('.gallery-toggle').stop(true, true).animate({'background-position':'left -27px'}, {queue:false, duration:500}); 
      }});
    }
  });
  
  /* Toggle everything */
  $('.gallery-hide-all').click(function() {
    if($('#gallery-holder').css('z-index') != 2) {
      $('#topbar-holder').stop(true, true).animate({'top':'-150px', 'opacity':0}, {queue:false, duration:1000});
      $('#logo-container').stop(true, true).animate({'top':'-200px', 'opacity':0}, {queue:false, duration:1000});
      $('#header').stop(true, true).animate({'top':'-250px', 'opacity':0}, {queue:false, duration:1000});
      $('#header-s').stop(true, true).animate({'top':'-250px', 'opacity':0}, {queue:false, duration:1000});
      setTimeout(function() {
        $('#gallery-holder').css({'z-index':2});
        $('#gallery-holder').stop(true, true).animate({'bottom':0, 'height':'30px'}, {queue:false, duration:1000});
      }, 400);
      setTimeout(function() {
        $('#footer-s').stop(true, true).animate({'bottom':'-50px', 'opacity':0}, {queue:false, duration:1000});
        $('#footer-container').stop(true, true).animate({'bottom':'-50px', 'opacity':0}, {queue:false, duration:1000});
      }, 900);
    } else {
      $('#footer-container').stop(true, true).animate({'bottom':0, 'opacity':1}, {queue:false, duration:1000});
      $('#footer-s').stop(true, true).animate({'bottom':'40px', 'opacity':1}, {queue:false, duration:1000});
      setTimeout(function() {
        $('#gallery-holder').stop(true, true).animate({'bottom':'40px', 'height':'280px'}, {queue:false, duration:1000, complete:function() {
          $('#gallery-holder').css({'z-index':5});
        }});
      }, 400);
      setTimeout(function() {
        $('#header-s').stop(true, true).animate({'top':'160px', 'opacity':1}, {queue:false, duration:1000});
        $('#header').stop(true, true).animate({'top':0, 'opacity':1}, {queue:false, duration:1000});
        $('#logo-container').stop(true, true).animate({'top':0, 'opacity':1}, {queue:false, duration:1000});
        $('#topbar-holder').stop(true, true).animate({'top':'-75px', 'opacity':1}, {queue:false, duration:1000});
      }, 800);
    }
  });
  
  /* Set thumbnail scrollers click and hover */
  $('.gallery-thumbnails-prev').click(function() {
    if($('.gallery-thumbnails-holder').css('left') != '0px') {
      $('.gallery-thumbnails-holder').stop(true, true).animate({'left':'+=270px'}, {queue:false, duration:800, easing:'easeInOutCubic'});
    }
  });
  $('.gallery-thumbnails-next').click(function() {
    if($('.gallery-thumbnails-holder').css('left').replace('px', '') > -((Math.ceil(galleryInfo.length/5) - 1) * 270)) {
      $('.gallery-thumbnails-holder').stop(true, true).animate({'left':'-=270px'}, {queue:false, duration:800, easing:'easeInOutCubic'});
    }
  });
  
  /* Set thumbnail hover */
  $('.gallery-thumbnails-holder img').hover(function() {
    $(this).stop(true, true).animate({'opacity':.5}, {queue:false, duration:400});
  }, function() {
    $(this).stop(true, true).animate({'opacity':1}, {queue:false, duration:400});
  });
  
  $(window).resize(backgroundResize);
  $(window).resize(videoResize);
  $(window).resize(iframeResize);
  $('#bgholder').css({'z-index':1});
  videoResize();
  iframeResize();
});