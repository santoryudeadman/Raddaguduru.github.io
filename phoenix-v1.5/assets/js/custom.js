var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function checkPermalinks(){
    var currentHash = window.location.hash;
    if(typeof currentHash == 'undefined' || currentHash.length < 5)
        return;
    if(currentHash.substring(0,6) !== '#view-')
        return;

    var projecstlug = currentHash.substring(6);
    var projectLinkItem = jQuery('.captionWrapper [data-slug="'+projecstlug+'"]');
    var holder = projectLinkItem.closest('.portfolio-holder');
    if(projectLinkItem.length != 0 && holder.length != 0){
        jQuery('html, body').animate({scrollTop: holder.offset().top});
        projectLinkItem.trigger('click');
    }
}

var portfolios = {};

jQuery(document).ready(function ($) {

    "use strict";
    /* Check permalinks and load project popup if project exists */
    checkPermalinks();

    if(isMobile.any()){
        $('body').addClass('is-mobile');
    }

    $(window).on('preloadComplete', function(){
        var hash = window.location.hash;
        if(typeof hash != 'string' || hash.length < 3)
            return;

        var menuEl = jQuery('a[href="'+hash+'"]');
        var divEl = jQuery(hash);
        if(menuEl.length == 1 && divEl.length == 1){
            var currentPosition = divEl.offset().top - jQuery('nav.navbar').height();
            jQuery("html, body").animate({ scrollTop: currentPosition});
        }
    });

    var menuItems = $('.navbar-nav a');
    if(menuItems.length > 0){
        menuItems.on('click', function(e){
            if($(window).innerWidth() < 768){
                if($(this).attr('href') != '' && $(this).attr('href') != '#' && !($(this).parent().hasClass('parent')))
                $('.navbar-toggle').trigger('click');
            }
        });
    }
    /*
Check if mailchimp form is submitted
    */
    if(typeof mc4wpFormRequestData != 'undefined'){
      //  debugger;
        if(typeof mc4wpFormRequestData.postData.EMAIL != 'undefined'){
            var _em = mc4wpFormRequestData.postData.EMAIL;
            var _status = mc4wpFormRequestData.success;
            var _selector = '.fwpMC4WP_fail';
            var _timeout = 8000;
            if(_status == '1'){
                _selector = '.fwpMC4WP_success';
                _timeout = 5000;
            }
            jQuery(_selector).modal({keyboard:true});
            setTimeout(function(){
                jQuery(_selector).modal('hide');
            }, _timeout);
        }
    }

    jQuery('form.fwpMC4WPForm').on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        var currentEmail = jQuery(this).find('input[type="email"]').val();
        var realForm = jQuery(this).next('.fwpMC4WPRealForm');
        var emailField = realForm.find('input[type="email"]');
        emailField.val(currentEmail);
        realForm.find('form').submit();
    })

    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Intro Height  */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    function introHeight() {
        var wh = $(window).height();
        $('#intro').css({height: wh});
    }

    introHeight();
    $(window).bind('resize',function () {
        //Update slider height on resize
        introHeight();
    });

    if(typeof $('body').matchHeight == 'function' && $(".heightItem").length > 0){
        jQuery(".row").each(function() {
                jQuery(this).children(".heightItem").matchHeight();
            });
    }


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Magnific pupup initialization  */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    if(typeof $('body').magnificPopup != 'undefined'){
        $('.popup-link').magnificPopup({
        /*    delegate: ' .popup-link',*/
            gallery: {
            enabled: true, // set to true to enable gallery
            navigateByImgClick: true,
            arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
                tPrev: 'Previous (Left arrow key)', // title for left button
                tNext: 'Next (Right arrow key)', // title for right button
            },
            type: 'image',
            mainClass: 'mfp-fade',
            tLoading: 'Loading...'
        });
        $('.fwpvideotrigger').magnificPopup({
            type: 'iframe',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            mainClass: 'mfp-with-zoom', // this class is for CSS animation below
            closeBtnInside: false
        });

    }
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* click switched with touch for mobile  */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


    $('.gallery-inner img').bind('touchstart', function() {
        $(this).addClass('.gallery-inner  .captionWrapper');
    });

    $('.gallery-inner  img').bind('touchend', function() {
        $(this).removeClass('.gallery-inner  .captionWrapper');
    });


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Parallax init  */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $(function() {
            $('.captionWrapper.valign').css({
                top: '120px'
            });

            $('.parallaxLetter').css({
                display: 'none'
            });
        });


    }
    else{
        $(window).stellar({
            responsive: true,
            horizontalOffset: 0,
            horizontalScrolling:false
        });
    }

    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Isotope */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    if(typeof fastwp != 'undefined' && typeof fastwp.portfolio != 'undefined'){
        for(var index in fastwp['portfolio']){
            var _portfolioConfig    = fastwp['portfolio'][index];
            var _defaultFilterValue = _portfolioConfig.default_cat;
            var _pID                = _portfolioConfig.id;
            portfolios[_pID]        = $('.js-isotope', '#' + _pID).imagesLoaded( function() {
                portfolios[_pID].isotope({
                    filter: _defaultFilterValue
                });
            });

            $('.js-filters','#' + _pID)
                .off('click')
                .on('click', 'button', function() {
                    var filterValue = $(this).attr('data-filter');
                    var _ID = jQuery(this).closest('.portfolio-holder').attr('id');
                    jQuery(this).closest('.js-filters').find('[data-filter]').not(this).removeClass('active');
                    jQuery(this).addClass('active');
                    portfolios[_ID].isotope({ filter: filterValue });
            })
            .find('[data-filter="'+_defaultFilterValue+'"]').addClass('active');

            portfolios[_pID].isotope({
                filter: _defaultFilterValue
            });
        }
    }

    //    masonry 3 columns
    $( function() {
        var $container2 = $('.blogPostsWrapper');
        // initialize Masonry after all images have loaded
        $container2.imagesLoaded(function () {
            $container2.isotope({
                itemSelector: '.blogPost',
                masonry: {
                    columnWidth: '.grid-sizer-blog-3'
                }
            });
        });
    });


    //    masonry 2 columns
    $( function() {
        var $container3 = $('.blogPostsWrapper2');
        // initialize Masonry after all images have loaded
        $container3.imagesLoaded(function () {
            $container3.isotope({
                itemSelector: '.blogPost2',
                masonry: {
                    columnWidth: '.grid-sizer-blog-2'
                }
            });
        });
    });




    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* overlay portfolio */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    $("a.overlay-ajax").click(function(){
        var url = $(this).attr("href");
        $(".overlay-section #transmitter").html('');
        $(".js-project-overlay").addClass('is-loading');
        $(".js-loading-msg").show();
        $(".overlay-section").load(url + ' #transmitter', function(a, b){
            var myScripts = $(a).find('script');
            var currentScriptsOnPage = getCurrentScriptsFromPage();
            myScripts.each(function(){
                var scriptSrc = $(this).attr('src');
                var scriptId = $(this).attr('id');
                if((typeof scriptSrc != 'undefined' && $('[src="' + scriptSrc + '"]').length == 0) || (typeof scriptId != 'undefined' && $('[id="' + scriptId + '"]').length == 0)){
                    $('body').append($(this));
                }
            });

            $(".fwp-owl-carousel").owlCarousel({
                singleItem: true,
                autoPlay:   true,
                navigation: true,
                navigationText: [
                    "<i class='fa fa-angle-left fa-2x itemNav'></i>",
                    "<i class='fa fa-angle-right fa-2x itemNav'></i>"
                ]
            });

            $(".js-project-overlay").removeClass('is-loading');
            $(".js-loading-msg").hide();
        });
        $('.overlay-close img').tooltip();
        return false;
    });


    // no scroll on body when overlay is up
    $(function () {

        $('a.overlay-ajax').click(function(){
            $( "body" ).addClass( "noscroll" );
        });

        $('a.overlay-close').click(function(){
            $( "body" ).removeClass( "noscroll" );
            setTimeout(function(){
                $('#transmitter').empty();
            },250);
        });
    });


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* smoothscroll */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    smoothScroll.init({
        speed: 1000
    });


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* scrollreveal */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        // some code..
    }

    else{
        window.scrollReveal = new scrollReveal();
    }



    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* Animated-Services */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


    $('.CubeWrapper').on({
        mouseenter: function () {
            $(this).removeClass( 'show-front' );
            $(this).addClass( 'show-bottom' );
        },
        mouseleave: function () {
            $(this).removeClass( 'show-bottom' );
            $(this).addClass( 'show-front' );
        }
    });



    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* owl-carousels */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


    var cst_team = $("#owl-team").data("carousel-settings");
    if (typeof cst_team != 'undefined') {
    if ( typeof cst_team.autoPlay != 'undefined' && cst_team.autoPlay == 'true') {
        if (typeof cst_team.autoPlayTimeout != 'undefined' && cst_team.autoPlayTimeout !='' ) {
        var autoplay_cst_team = cst_team.autoPlayTimeout;
        } else {
        var autoplay_cst_team = true;
        }
    } else {
        var autoplay_cst_team = false;      
    } 
    var navigation_cst_team = ( typeof cst_team.showControls != 'undefined' && cst_team.showControls == 'true')? true : false;
    var hover_cst_team = ( typeof cst_team.stopOnHover != 'undefined' && cst_team.stopOnHover == 'true')? true : false;
    $("#owl-team").owlCarousel({
        singleItem:    true,
        autoPlay: autoplay_cst_team,
        stopOnHover: hover_cst_team,
        navigation: navigation_cst_team,
        navigationText: [
            "<i class='fa fa-angle-left fa-4x'></i>",
            "<i class='fa fa-angle-right fa-4x'></i>"
        ]
    });
}

    var cst_clients = $("#owl-clients").data("carousel-settings");
    if (typeof cst_clients != 'undefined') {
    if ( typeof cst_clients.autoPlay != 'undefined' && cst_clients.autoPlay == 'true') {
        if (typeof cst_clients.autoPlayTimeout != 'undefined' && cst_clients.autoPlayTimeout !='' ) {
        var autoplay_cst_clients = cst_clients.autoPlayTimeout;
        } else {
        var autoplay_cst_clients = true;
        }
    } else {
        var autoplay_cst_clients = false;      
    } 
    var navigation_cst_clients = ( typeof cst_clients.showControls != 'undefined' && cst_clients.showControls == 'true')? true : false;
    var hover_cst_clients = ( typeof cst_clients.stopOnHover != 'undefined' && cst_clients.stopOnHover == 'true')? true : false;
    $("#owl-clients").owlCarousel({
        items:3,
        autoPlay: autoplay_cst_clients,
        stopOnHover: hover_cst_clients,
        navigation: navigation_cst_clients,
        navigationText: [
            "<i class='fa fa-angle-left fa-3x'></i>",
            "<i class='fa fa-angle-right fa-3x'></i>"
        ],
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,2],
        itemsMobile : [479,1]
    });
}


    var cst_testi = $("#owl-testimonials").data("carousel-settings");
    if (typeof cst_testi != 'undefined') { 
    if (typeof cst_testi.autoPlay != 'undefined' && cst_testi.autoPlay == 'true') {
        if (typeof cst_testi.autoPlayTimeout != 'undefined' && cst_testi.autoPlayTimeout !='' ) {
        var autoplay_cst_testi = cst_testi.autoPlayTimeout;
        } else {
        var autoplay_cst_testi = true;
        }
    } else {
        var autoplay_cst_testi = false;      
    } 
    var navigation_cst_testi = ( typeof cst_testi.showControls != 'undefined' && cst_testi.showControls == 'true')? true : false;
   	var hover_cst_testi = ( typeof cst_testi.stopOnHover != 'undefined' && cst_testi.stopOnHover == 'true')? true : false;
    $("#owl-testimonials").owlCarousel({
        singleItem:	true,
        autoPlay:autoplay_cst_testi,
        navigation: navigation_cst_testi,
        stopOnHover: hover_cst_testi,
        navigationText: [
            "<i class='fa fa-angle-left fa-3x'></i>",
            "<i class='fa fa-angle-right fa-3x'></i>"
        ],
    });
}


    $("#owl-featured, #owl-posts").owlCarousel({
        items:3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [980,2],
        itemsTablet: [768,2],
        itemsMobile : [479,1],
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x featuredNav'></i>",
            "<i class='fa fa-angle-right fa-2x featuredNav'></i>"
        ]
    });

    $("#owl-blog-single").owlCarousel({
        singleItem:	true,
        navigation: true,
        autoHeight: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x blogNav'></i>",
            "<i class='fa fa-angle-right fa-2x blogNav'></i>"
        ]
    });

    $(".fwp-owl-carousel").owlCarousel({
        singleItem: true,
        autoPlay:   true,
        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x itemNav'></i>",
            "<i class='fa fa-angle-right fa-2x itemNav'></i>"
        ]
    });


    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    /* timers */
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    
    $('.timer-item').waypoint(function() {
        "use strict";
        var settings = eval('(' + $(this).attr('data-settings') + ')');
        if(typeof settings.max != 'undefined'){
            $('.timer', this).countTo({
                from: settings.start, 
                to: settings.max, 
                speed: settings.speed,
                refreshInterval: settings.interval
            });
        }
    },
    {
        offset: '500',
        triggerOnce: true
    });


    $('a[data-scroll-top]').bind('click', function(e){ 
        e.preventDefault(); 
        var el = $($(this).attr('href'));
        if(typeof el.html() == 'string'){
            var scrollPosition = el.offset().top;
            $('body,html').animate({scrollTop: scrollPosition}, 2000, 'swing');
 //           animateScrollTop(scrollPosition);
        }
        
    });

    /* Typed script initialization */
    if(typeof $('body').typed == 'function' && typeof initializeTypedScript == 'function'){
        initializeTypedScript();
    }
});

function animateScrollTop(target, duration) {
    duration = duration || 16;

    var $window = $(window);
    var scrollTopProxy = { value: $window.scrollTop() };
    var expectedScrollTop = scrollTopProxy.value;

    if (scrollTopProxy.value != target) {
        $(scrollTopProxy).animate(
            { value: target },
            {
                duration: duration,

                step: function (stepValue) {
                    var roundedValue = Math.round(stepValue);
                    if ($window.scrollTop() !== expectedScrollTop) {
                        // The user has tried to scroll the page
                        $(scrollTopProxy).stop();
                    }
                    $window.scrollTop(roundedValue);
                    expectedScrollTop = roundedValue;
                },

                complete: function () {
                    if ($window.scrollTop() != target) {
                        setTimeout(function () {
                            animateScrollTop(target);
                        }, 16);
                    }
                }
            }
        );
    }
}


function getCurrentScriptsFromPage(){
    var myScripts = [];
    jQuery('script').each(function(){
        var tmpscript = jQuery(this).attr('src');
        if(typeof tmpscript == 'string' && tmpscript.length > 4){
            if(!(tmpscript in myScripts))
                myScripts.push(tmpscript);
        }
    });
    return myScripts;
}



function initializeTypedScript(){
    var fakeTexts = jQuery('.js-fake-text');
    if(fakeTexts.length < 1)
        return;

    fakeTexts.each(function(){
        var htmltext = jQuery(this).html();
        var textHolder = jQuery(this).closest('.js-shortcode-parent').find('.js-typed-text-holder');
        var items = jQuery(this).closest('.js-shortcode-parent').data('typing-items');
        var settings = jQuery(this).closest('.js-shortcode-parent').data('settings');

        if(textHolder.length == 1){
            if(typeof items != 'undefined'){
                textHolder.typed({
                    strings: items,
                    typeSpeed: settings.typeSpeed,
                    backDelay: settings.backDelay,
                    loop: settings.loop
            });
            }else {
                textHolder.typed({
                    strings: [htmltext],
                    contentType: 'html',
                    typeSpeed: settings.typeSpeed,
                    backDelay: settings.backDelay,
                    loop: settings.loop
                });
            }
        }
    });
}