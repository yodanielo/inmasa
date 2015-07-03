/* if user is using IE6 offer Google Chrome */
if(!window.XMLHttpRequest) {
    alert('Your browser is obsolete. Click OK to download Google Chrome, a faster and safer browser.');
    window.location = 'http://www.google.com/chrome/';
}
    //document.title=$(".nohay").text().length
    if($(".nohay").text()==""){
        $(".nohay").hide();
    }

$(document).ready(function(){
    if($(".tabs").length>0){
        if($(".tabs a:first").text()=="+ info"){
            $("#content").addClass("bgblanco");
            $(".tabs a:last").css("text-indent",25)
            $(".tab-content td").css({
                "padding-top":15,
                "padding-bottom":15
            });
        }
    }
    $(".sub-menu:first li:eq(3) a").removeAttr("href");
    if($("#grace").length>0){
        //estoy en home
        jQuery(".td-breadcrumb").css("display","none");
        jQuery("#content").css("background","none");
        jQuery("#payoff").css("background","url(/wp-content/themes/screen1.2/images/sellos.png) no-repeat right #4bcfd1");
    }
    $(".Dgallerymore").Dgallerymore();
})
$.fn.Dgallerymore=function(){
    $(this).each(function(){
        todo=this;
        const_img=275;
        ancho_cont=$(this).find("img").length*const_img;
        //document.title=ancho_cont;
        cad='';
        animando=false;
        img0={
            top:0,
            height:136,
            width:230,
            left:0
        };
        img1={
            top:-20,
            height:185,
            width:313,
            left:-41
        };
        imgstr=$(this).html();
        cad+='<div class="dgm_visor"><div class="dgm_slider" style="width:'+ancho_cont+'px">'+imgstr+'</div></div><div class="dgm_navegador"><div class="dgm_fizq"></div><div class="dgm_fder"></div></div>';
        $(this).html(cad);
        if($(this).find("a").length>0){
            $(this).find("a").each(function(){
                $(todo).find(".dgm_slider").append('<div class="dgm_img"></div>');
                $(this).appendTo($(todo).find(".dgm_img:last"));
            });
        }else{
            $(this).find("img").each(function(){
                $(todo).find(".dgm_slider").append('<div class="dgm_img"></div>');
                $(this).appendTo($(todo).find(".dgm_img:last"));
            });
        }
        $(this).find("img").width(230);
        $(this).find("img").height(136);
        if($(this).find("img, a").length==0){
            $(this).html('<div style="text-align:center">No hay fotos para mostrar.</div>');
        }
        $(this).find(".dgm_slider .dgm_img:last").css({
            "margin-right":0
        });
        $(this).find(".dgm_slider .dgm_img:eq(1)").addClass("selected").find("img").css(img1);
        $(this).find(".dgm_fizq").click(function(){
            pos=$(todo).find(".dgm_slider").position().left;
            if(pos<=0-const_img && animando==false){
                animando=true;
                $(todo).find(".dgm_slider").animate({
                    left:"+="+const_img
                }, 450, "linear", function(){
                    animando=false;
                });
            }
            if($(todo).find(".dgm_slider .dgm_img.selected").prev().prev().length>0){
                $(todo).find(".dgm_slider .dgm_img.selected img").animate(img0, 450, "linear", function(){
                    first=$(todo).find(".dgm_slider .dgm_img.selected").removeClass("selected");
                    first.prev().find("img").animate(img1, 450, "linear", function(){});
                    first.prev().addClass("selected");
                });
            }
        });
        $(this).find(".dgm_fder").click(function(){
            pos=$(todo).find(".dgm_slider").position().left;
            wsl=$(todo).find(".dgm_slider").width();
            vis=$(todo).find(".dgm_visor").width();
            if(wsl+pos>=vis && animando==false){
                animando=true;
                $(todo).find(".dgm_slider").animate({
                    left:"-="+const_img
                }, 450, "linear", function(){
                    animando=false
                });
            }
            if($(todo).find(".dgm_slider .dgm_img.selected").next().next().length>0){
                $(todo).find(".dgm_slider .dgm_img.selected img").animate(img0, 450, "linear", function(){
                    first=$(todo).find(".dgm_slider .dgm_img.selected").removeClass("selected");
                    first.next().find("img").animate(img1, 450, "linear", function(){});
                    first.next().addClass("selected");
                });
            }
        });
    })
    $(".dgm_slider br").remove();
}
function sendComment() {
    $('#commentform').submit();
}
function validateContactForm() {
    var ok = true;
    $.each($('.required-field'), function() {
        if($(this).val() == '') {
            ok = false;
            $(this).css({
                'border':'#c00 solid 1px'
            });
        } else {
            $(this).css({
                'border':'0'
            });
        }
    });
    if(ok) {
        return true;
    } else {
        $('#contact-error').fadeIn();
    }
    return false;
}
function addHover() {
/*$('#grabber').hover(function() {
        $('#topbar-holder').animate({
            'top':'-70px'
        }, {
            queue:false,
            duration:200,
            easing:'easeOutCubic'
        });
    }, function() {
        $('#topbar-holder').animate({
            'top':'-75px'
        }, {
            queue:false,
            duration:200,
            easing:'easeOutCubic'
        });
    });
    $('#grabber').animate({
        'background-position':'0px -30px'
    }, {
        queue:false,
        duration:300
    });*/
}
function backgroundResize() {
    if($('#bgimg').length > 0) {
        var oImg = new Image();
        oImg.src = $('#bgimg').attr('src');
        $(oImg).ready(function() {
            var orgW = oImg.width;
            var orgH = oImg.height;
            if(orgW != 0 && orgH != 0) {
                var h = $(window).height();
                var w = $(window).width();
                var ratioW = w / orgW;
                var ratioH = h / orgH;
                if(ratioW > ratioH) {
                    $('#bgimg').css({
                        'height':(w * orgH / orgW),
                        'width':w
                    });
                } else {
                    $('#bgimg').css({
                        'height':h,
                        'width':(h * orgW / orgH)
                    });
                }
                $('#bgholder').css({
                    'display':'block'
                });
            }
            setTimeout(function() {
                $('#bgholder').css({
                    'display':'block'
                });
            }, 1000);
        });
    }
}
function initializeGoogleMaps(gLat, gLng) {
    if(gLat == undefined || gLng == undefined) {
        var gLat = 51.190098;
        var gLng = 5.9974175;
    }
    var latlng = new google.maps.LatLng(gLat, gLng);
    var myOptions = {
        zoom:zoom,
        center:latlng,
        navigationControl:true,
        mapTypeControl:false,
        scaleControl:false,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById('googlemaps'), myOptions);
    var marker = new google.maps.Marker({
        position:latlng,
        map:map,
        icon:'http://www.google.com/intl/en_us/mapfiles/ms/micons/orange-dot.png'
    });
}

$(document).ready(function() {
    /* Resize background image */
    if($('#bgimg').length > 0) {
        $(window).resize(backgroundResize);
        $('#bgimg').ready(backgroundResize);
        setTimeout(backgroundResize, 1000);
    }
  
    /* Center the logo vertically */
    /*if($('#logo a img').length > 0) {
        $('#logo a img').ready(function() {
            $('#logo a img').css({
                'margin':((110 - $('#logo a img').height()) / 2) + 'px 0 0 0'
                });
            setTimeout(function() {
                $('#logo a img').css({
                    'margin':((110 - $('#logo a img').height()) / 2) + 'px 0 0 0'
                    });
            }, 1000);
        });
    }*/
  
    /* Fix content height if sidebar is higher */
    if($('.one-third-right').height() > $('.two-thirds-left').height()) {
        $('.sidebarmiddle').css({
            'height':($('.one-third-right').height() - 40) + 'px'
        });
    }
    if($('.one-third-left').height() > $('.two-thirds-right').height()) {
        $('.sidebarmiddle').css({
            'height':($('.one-third-left').height() - 40) + 'px'
        });
    }
  
    /* Fix padding for any multiline heading or payoff */
    if($('#payoff h2').height() > 26) {
        $('#payoff h2').css({
            'padding':'3px 0px 0 10px'
        });
    }
    if($('#heading h1').height() > 35) {
        $('#heading h1').css({
            'padding':'10px 0px 0 10px'
        });
    }
  
    /* Fix widget layout */
    $.each($('.widget'), function() {
        if(($('.widget').index($(this)) + 1) % 4 == 0) {
            $(this).after('<div class="floatfix"></div>');
        }
    });
  
    /* Shortcode toggle */
    $('.toggle_content').hide();
    $('h4.toggle').toggle(function() {
        $(this).addClass('active');
    }, function() {
        $(this).removeClass('active');
    });
    $('h4.toggle').click(function() {
        $(this).next('.toggle-content').slideToggle();
    });
	
    /* Shortcode tabs */

    $('.framed-tab-set .tab-content').eq(0).show();
    padtabs=$('.framed-tab-set .tabs').width()-$('.framed-tab-set .tabs li').length*180-31;
    $('.framed-tab-set .tabs li:first').css("margin-left",padtabs);
    $('.framed-tab-set .tabs li a').eq(0).parent().addClass('curlitab');
    $('.framed-tab-set .tabs li a').eq(0).addClass('current');
    $('.framed-tab-set .tabs li a').click(function() {
        $('.framed-tab-set .tabs li').removeClass('curlitab');
        $('.framed-tab-set .tabs li a').removeClass('current');
        $(this).addClass('current');
        $(this).parent().addClass('curlitab');
        $('.framed-tab-set .tab-content').hide();
        $('.framed-tab-set .tab-content').eq($('.framed-tab-set .tabs li a').index($(this))).show();
    });
	
    /* Google Maps */
    if($('#googlemaps').length > 0) {
        var geocoder = new google.maps.Geocoder();
        if(geocoder) {
            geocoder.geocode({
                'address':address
            }, function(results, status) {
                if(status == google.maps.GeocoderStatus.OK) {
                    var gLat = results[0].geometry.location.lat();
                    var gLng = results[0].geometry.location.lng();
                }
                initializeGoogleMaps(gLat, gLng);
            });
        }
    }
  
    /* Blog category image hover */
    if($('.hoverimg').length > 0) {
        if(!$.browser.opera) {
            $('.hoverimg').hover(function() {
                $(this).stop(true, true).animate({
                    'opacity':'.7'
                }, {
                    queue:false,
                    duration:300,
                    easing:'easeOutCubic'
                });
            }, function() {
                $(this).stop(true, true).animate({
                    'opacity':'1'
                }, {
                    queue:false,
                    duration:200,
                    easing:'easeOutCubic'
                });
            });
        }
    }
  
    /* TD button hover */
    if($('.td-button').length > 0) {
        if(!$.browser.opera) {
            $('.td-button').hover(function() {
                $(this).stop(true, true).animate({
                    'opacity':'.75'
                }, {
                    queue:false,
                    duration:400,
                    easing:'easeOutCubic'
                });
            }, function() {
                $(this).stop(true, true).animate({
                    'opacity':'1'
                }, {
                    queue:false,
                    duration:500,
                    easing:'easeOutCubic'
                });
            });
        }
    }
  
    /* Contact form validation */
    if($('#contactform').length > 0) {
        $('#contactform').submit(function() {
            return validateContactForm();
        });
        $('#contact-submit').click(function() {
            $('#contactform').submit();
        });
    }
  
    /* Topbar */
    //addHover();
    /*$('#grabber').click(function() {
        if($('#topbar-holder').css('top') != '-20px') {
            $(this).unbind('mouseenter').unbind('mouseleave');
            $('#s').focus();
            $('#topbar-holder').animate({
                'top':'-20px'
            }, {
                queue:false,
                duration:400,
                easing:'easeOutBack',
                complete:function() {
                    $('#grabber').animate({
                        'background-position':'0px -5px'
                    }, {
                        queue:false,
                        duration:300
                    });
                }
            });
    } else {
        $('#topbar-holder').animate({
            'top':'-75px'
        }, {
            queue:false,
            duration:200,
            easing:'easeOutCubic',
            complete:
            addHover
        });
    }
    });*/
    $('#sociables img').css({
        'opacity':.5
    });
    $('#sociables img').hover(function() {
        $(this).animate({
            'opacity':1
        }, {
            queue:false,
            duration:200,
            easing:'easeOutCubic'
        });
    }, function() {
        $(this).animate({
            'opacity':.5
        }, {
            queue:false,
            duration:200,
            easing:'easeOutCubic'
        });
    });
  
    /* Main menu */
    Cufon.replace('#header-container .menu ul li a', {
        hover:true
    });
    $('#header-container .menu > ul > li > a').css({
        'opacity':.7
    });
    $('#header-container .menu > ul > li').hover(function() {
        $('> a', this).stop(true, true).animate({
            'opacity':1
        }, {
            queue:false,
            duration:500,
            easing:'easeOutCubic'
        });
        $('> ul > li > a', this).stop(true, true).animate({
            'opacity':.7
        }, {
            queue:false,
            duration:500,
            easing:'easeOutCubic'
        });
        Cufon.replace('#header-container .menu > ul > li > a', {
            hover:true
        });
    }, function() {
        $('> a', this).stop(true, true).animate({
            'opacity':.7
        }, {
            queue:false,
            duration:1500,
            easing:'easeOutCubic'
        });
        $('> ul > li > a', this).stop(true, true).animate({
            'opacity':.2
        }, {
            queue:false,
            duration:1500,
            easing:'easeOutCubic'
        });
        Cufon.replace('#header-container .menu > ul > li > a', {
            hover:false
        });
    });
  
    /* Sub menu */
    if($('#header-container .menu > ul > li > ul').length > 0) {
        $('#header').hover(function() {
            $(this).animate({
                'height':(50 + hH) + 'px'
            }, {
                queue:false,
                duration:600,
                easing:'easeInOutExpo'
            });
            $('#header-s').animate({
                'top':(170 + hH) + 'px'
            }, {
                queue:false,
                duration:600,
                easing:'easeInOutExpo'
            });
            Cufon.replace('#header-container .menu > ul > li > a', {
                hover:true
            });
        }, function() {
            $('#header-s').animate({
                'top':'160px'
            }, {
                queue:false,
                duration:600,
                easing:'easeInOutExpo'
            });
            $(this).animate({
                'height':'40px'
            }, {
                queue:false,
                duration:600,
                easing:'easeInOutExpo'
            });
            Cufon.replace('#header-container .menu > ul > li > a', {
                hover:false
            });
        });
        $('#header-container .menu > ul > li > ul > li > a').css({
            'opacity':.2
        });
        $('#header-container .menu > ul > li > ul > li > a').hover(function() {
            $(this).css({
                'opacity':1
            });
        }, function() {
            $(this).css({
                'opacity':.7
            });
        });
        /* Fix submenu width and height */
        var first = true;
        var hH = 0;
        $.each($('#header-container .menu > ul > li'), function() {
            if($('ul', this).length == 0) {
                if(first) {
                    $('ul', this).css({
                        'background':'none'
                    });
                    first = false;
                } else {
                    $(this).append('<ul></ul>');
                }
            }
            $.each($('ul', this), function() {
                if(first) {
                    $(this).css({
                        'background':'none'
                    });
                    first = false;
                }
                var m = $(this).width();
                var h = 0;
                $.each($(this).children(), function() {
                    if(m < $(this).width()) {
                        m = $(this).width();
                    }
                });
                $('a', this).css({
                    'width':(m - 30) + 'px'
                });
                $.each($(this).children(), function() {
                    h += $(this).height();
                });
                if(hH < h) {
                    hH = h;
                }
            });
            $('#header-container .menu ul li ul').css({
                'height':(hH + 10) + 'px'
            });
        });
    };
  
    /* Footer */
    $('#footer a').css({
        'opacity':0.7
    });
    $('#footer a').hover(function() {
        $(this).stop(true, true).animate({
            'opacity':1
        }, {
            queue:false,
            duration:500,
            easing:'easeOutCubic'
        });
        Cufon.replace('#footer a', {
            hover:true
        });
    }, function() {
        $(this).stop(true, true).animate({
            'opacity':.7
        }, {
            queue:false,
            duration:1500,
            easing:'easeOutCubic'
        });
        Cufon.replace('#footer a', {
            hover:false
        });
    });
});

/* Background-position fix  */
(function($) {
    if(!document.defaultView || !document.defaultView.getComputedStyle){ // IE6-IE8
        var oldCurCSS = jQuery.curCSS;
        jQuery.curCSS = function(elem, name, force){
            if(name === 'background-position'){
                name = 'backgroundPosition';
            }
            if(name !== 'backgroundPosition' || !elem.currentStyle || elem.currentStyle[ name ]){
                return oldCurCSS.apply(this, arguments);
            }
            var style = elem.style;
            if ( !force && style && style[ name ] ){
                return style[ name ];
            }
            return oldCurCSS(elem, 'backgroundPositionX', force) +' '+ oldCurCSS(elem, 'backgroundPositionY', force);
        };
    }
	
    var oldAnim = $.fn.animate;
    $.fn.animate = function(prop){
        if('background-position' in prop){
            prop.backgroundPosition = prop['background-position'];
            delete prop['background-position'];
        }
        if('backgroundPosition' in prop){
            prop.backgroundPosition = '('+ prop.backgroundPosition;
        }
        return oldAnim.apply(this, arguments);
    };
	
    function toArray(strg){
        strg = strg.replace(/left|top/g,'0px');
        strg = strg.replace(/right|bottom/g,'100%');
        strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,'$1px$2');
        var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
        return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
    }
	
    $.fx.step. backgroundPosition = function(fx) {
        if (!fx.bgPosReady) {
            var start = $.curCSS(fx.elem,'backgroundPosition');
			
            if(!start){//FF2 no inline-style fallback
                start = '0px 0px';
            }
			
            start = toArray(start);
			
            fx.start = [start[0],start[2]];
			
            var end = toArray(fx.options.curAnim.backgroundPosition);
            fx.end = [end[0],end[2]];
			
            fx.unit = [end[1],end[3]];
            fx.bgPosReady = true;
        }
        //return;
        var nowPosX = [];
        nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
        nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
        fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1];

    };
})(jQuery);