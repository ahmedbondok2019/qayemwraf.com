(function($) {
	
	"use strict";

	function marginClc() {
		if ($(".side-container").length) {
			var windowSize = $(window).width();

			if (windowSize >= 1200) {
				var width = ($(window).width() - 1200),
					margin = (width / 2);
				$(".industries-covered .outer-box").css("margin-right", margin);
				$(".industries-covered-two .nav-tabs-wrapper").css("margin-left", margin);
			}			
		}
	}
	marginClc();
	
	//Hide Loading Box (Preloader)
	function handlePreloader() {
		if($('.loader-wrap').length){
			$('.loader-wrap').delay(1000).fadeOut(500);
		}
		TweenMax.to($(".loader-wrap .overlay"), 1.2, {
            force3D: true,
            left: "100%",
            ease: Expo.easeInOut,
        });
	}

	//Event Countdown Timer
	if($('.time-countdown').length){  
		$('.time-countdown').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
			var $this = $(this).html(event.strftime('' + '<div class="counter-column"><span class="count">%D</span>Days</div> ' + '<div class="counter-column"><span class="count">%H</span>Hours</div>  ' + '<div class="counter-column"><span class="count">%M</span>Minutes</div>  ' + '<div class="counter-column"><span class="count">%S</span>Seconds</div>'));
		});
	 });
	}

	if ($(".preloader-close").length) {
        $(".preloader-close").on("click", function(){
            $('.loader-wrap').delay(200).fadeOut(500);
        })
    }

    function dynamicCurrentMenuClass(selector) {
        let FileName = window.location.href.split('/').reverse()[0];

        selector.find('li').each(function () {
            let anchor = $(this).find('a');
            if ($(anchor).attr('href') == FileName) {
                $(this).addClass('current');
            }
        });
        // if any li has .current elmnt add class
        selector.children('li').each(function () {
            if ($(this).find('.current').length) {
                $(this).addClass('current');
            }
        });
        // if no file name return 
        if ('' == FileName) {
            selector.find('li').eq(0).addClass('current');
        }
    }

    // dynamic current class        
    let mainNavUL = $('.main-menu').find('.navigation');
    dynamicCurrentMenuClass(mainNavUL);
	
	//Update Header Style and Scroll to Top
	function headerStyle() {
		if($('.main-header').length){
			var windowpos = $(window).scrollTop();
			var siteHeader = $('.main-header');
			var scrollLink = $('.scroll-to-top');
			var sticky_header = $('.main-header .sticky-header');
			var onepageMenu = $('.main-header .onepage-menu');
			if (windowpos > 100) {
				siteHeader.addClass('fixed-header');
				sticky_header.addClass("animated slideInDown");
				onepageMenu.addClass("animated slideInDown");
				scrollLink.fadeIn(300);
				$('.main-menu .navigation>li>a').css('color', 'black');
			} else {
				siteHeader.removeClass('fixed-header');
				sticky_header.removeClass("animated slideInDown");
				onepageMenu.removeClass("animated slideInDown");
				scrollLink.fadeOut(300);
				$('.main-menu .navigation>li>a').css('color', 'white');
			}
		}
	}
	
	headerStyle();

	//Submenu Dropdown Toggle
	if($('.main-header li.dropdown ul').length){
		$('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-right"></span></div>');
	}

	//Hidden Sidebar
	if($('.hidden-sidebar').length){

		var animButton = $(".sidemenu-nav-toggler"),
	        hiddenBar = $(".hidden-sidebar"),
	        navOverlay = $(".nav-overlay"),
	        hiddenBarClose = $(".hidden-sidebar-close");

	    function showMenu() {
	        TweenMax.to(hiddenBar, 0.6, {
	            force3D: false,
	            left: "0",
	            ease: Expo.easeInOut
	        });
	        hiddenBar.removeClass("close-sidebar");
	    	navOverlay.fadeIn(500);
	    }

	    function hideMenu() {
	        TweenMax.to(hiddenBar, 0.6, {
	            force3D: false,
	            left: "-480px",
	            ease: Expo.easeInOut
	        });
	        hiddenBar.addClass("close-sidebar");
	        navOverlay.fadeOut(500);
	    }
	    animButton.on("click", function() {
	        if (hiddenBar.hasClass("close-sidebar")) showMenu();
	        else hideMenu();
	    });
	    navOverlay.on("click", function() {
	    	hideMenu();
	    });
	    hiddenBarClose.on("click", function() {
	    	hideMenu();
	    });
	}

	if ($('.nav-overlay').length) {
		// / cursor /
		var cursor = $(".nav-overlay .cursor"),
		follower = $(".nav-overlay .cursor-follower");

		var posX = 0,
		posY = 0;

		var mouseX = 0,
		mouseY = 0;

		TweenMax.to({}, 0.016, {
			repeat: -1,
			onRepeat: function() {
				posX += (mouseX - posX) / 9;
				posY += (mouseY - posY) / 9;

				TweenMax.set(follower, {
					css: { 
						left: posX - 22,
						top: posY - 22
					}
				});

				TweenMax.set(cursor, {
					css: { 
						left: mouseX,
						top: mouseY
					}
				});

			}
		});

		$(document).on("mousemove", function(e) {
			var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			mouseX = e.pageX;
			mouseY = e.pageY - scrollTop;
		});
		$("button, a").on("mouseenter", function() {
			cursor.addClass("active");
			follower.addClass("active");
		});
		$("button, a").on("mouseleave", function() {
			cursor.removeClass("active");
			follower.removeClass("active");
		});
		$(".nav-overlay").on("mouseenter", function() {
			cursor.addClass("close-cursor");
			follower.addClass("close-cursor");
		});
		$(".nav-overlay").on("mouseleave", function() {
			cursor.removeClass("close-cursor");
			follower.removeClass("close-cursor");
		});
	}

	//Mobile Nav Hide Show
	if($('.mobile-menu').length){
		
		$('.mobile-menu .menu-box').mCustomScrollbar();
		
		var mobileMenuContent = $('.main-header .nav-outer .main-menu').html();
		$('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);
		$('.sticky-header .main-menu').append(mobileMenuContent);
		
		//Dropdown Button
		$('.mobile-menu li.dropdown .dropdown-btn').on('click', function() {
			$(this).toggleClass('open');
			$(this).prev('ul').slideToggle(500);
		});
		//Menu Toggle Btn
		$('.mobile-nav-toggler').on('click', function() {
			$('body').addClass('mobile-menu-visible');
		});

		//Menu Toggle Btn
		$('.mobile-menu .menu-backdrop,.mobile-menu .close-btn,.scroll-nav li a').on('click', function() {
			$('body').removeClass('mobile-menu-visible');
		});
	}

	//Sidemenu Nav Hide Show
	if($('.side-menu').length){
		
		$('.side-menu .menu-box').mCustomScrollbar();
		
		//Dropdown Button
		$('.side-menu li.dropdown .dropdown-btn').on('click', function() {
			$(this).toggleClass('open');
			$(this).prev('ul').slideToggle(500);
		});

		$('body').addClass('side-menu-visible');
		//Menu Toggle Btn
		$('.side-nav-toggler').on('click', function() {
			$('body').addClass('side-menu-visible');
		});

		//Menu Toggle Btn
		$('.side-menu .side-menu-resize').on('click', function() {
			$('body').toggleClass('side-menu-visible');
		});

		//Menu Toggle Btn
		$('.main-header .mobile-nav-toggler-two').on('click', function() {
			$('body').addClass('side-menu-visible-s2');
		});

		//Menu Overlay
		$('.main-header .side-menu-overlay').on('click', function() {
			$('body').removeClass('side-menu-visible-s2');
		});
	}
	
	//Search Popup
	if($('#search-popup').length){
		
		//Show Popup
		$('.search-toggler').on('click', function() {
			$('#search-popup').addClass('popup-visible');
		});
		$(document).keydown(function(e){
	        if(e.keyCode === 27) {
	            $('#search-popup').removeClass('popup-visible');
	        }
	    });
		//Hide Popup
		$('.close-search,.search-popup .overlay-layer').on('click', function() {
			$('#search-popup').removeClass('popup-visible');
		});
	}

	// Language Selector
	$(".languages").click(function(){
       $(".languages ul").show();
    })
	$(".languages ul").mouseleave(function(){
	    $(".languages ul").hide(); 
	});
   
	$(".languages li a").click(function(){
       $(".languages li a").removeClass('sel');
       $(this).addClass('sel');
       var selectedValue = $(this).text();
       var showLang = selectedValue.substring(0, 2);
       $('.languages .current').html(showLang);
       $('.languages .current').attr("title", selectedValue);
       $('.languages .hover').html(selectedValue);
	})
	
	if ($('.time-countdown-two').length) {
		$('.time-countdown-two').each(function() {
			var Self = $(this);
			var countDate = Self.data('countdown-time'); // getting date
			Self.countdown(countDate, function(event) {
				$(this).html('<li> <div class="box"> <span class="days">' + event.strftime('%D') + '</span> <span class="timeRef">days</span> </div> </li> <li> <div class="box"> <span class="hours">' + event.strftime('%H') + '</span> <span class="timeRef clr-1">hours</span> </div> </li> <li> <div class="box"> <span class="minutes">' + event.strftime('%M') + '</span> <span class="timeRef clr-2">minutes</span> </div> </li>');
			});
		});
	};

	function bannerSlider() {
	    if ($(".banner-slider").length > 0) {

		    // Banner Slider
			var bannerSlider = new Swiper('.banner-slider', {
				preloadImages: false,
                loop: true,
                grabCursor: true,
                centeredSlides: false,
                resistance: true,
                resistanceRatio: 0.6,
                speed: 1400,
                spaceBetween: 0,
                parallax: false,
                effect: "slide",
				autoplay: {
				    delay: 4000,
                    disableOnInteraction: false
				},
				pagination: {
	                el: '.banner-slider-pagination',
	                clickable: true,
	            },
	            navigation: {
	                nextEl: '.banner-slider-button-next',
	                prevEl: '.banner-slider-button-prev',
	            },
			});
		}
	}

	var swiper = new Swiper('.single-column-slider', {
		preloadImages: false,
		loop: false,
		grabCursor: true,
		centeredSlides: false,
		resistance: true,
		resistanceRatio: 0.6,
		speed: 1400,
		spaceBetween: 0,
		parallax: false,
		autoplay: {
			delay: 6000,
			disableOnInteraction: false
		},
		slidesPerView: 1,
		navigation: {
			nextEl: '.single-column-slider-button-next',
			prevEl: '.single-column-slider-button-prev',
		},
	});

	var swiper = new Swiper('.two-column-slider', {
		preloadImages: false,
		loop: false,
		grabCursor: true,
		centeredSlides: false,
		resistance: true,
		resistanceRatio: 0.6,
		speed: 1400,
		spaceBetween: 0,
		parallax: false,
		autoplay: {
			delay: 4000,
			disableOnInteraction: false
		},
		slidesPerView: 2,
		slidesPerColumn: 3,
		navigation: {
			nextEl: '.two-column-slider-button-next',
			prevEl: '.two-column-slider-button-prev',
		},
		breakpoints: {
			768: {
			  slidesPerView: 1,
			},
		  }
	  });

	  var swiper = new Swiper('.three-column-slider', {
		preloadImages: false,
		loop: false,
		grabCursor: true,
		centeredSlides: false,
		resistance: true,
		resistanceRatio: 0.6,
		speed: 1400,
		spaceBetween: 0,
		parallax: false,
		autoplay: {
			delay: 4000,
			disableOnInteraction: false
		},
		slidesPerView: 3,
		slidesPerColumn: 2,
		navigation: {
			nextEl: '.three-column-slider-button-next',
			prevEl: '.three-column-slider-button-prev',
		},
		breakpoints: {
			768: {
			  slidesPerView: 1,
			},
			1200: {
			  slidesPerView: 2,
			},
		  }
	  });

	// Single Product 
	var productThumb = new Swiper('.product-thumb', {
		loop: true,
		spaceBetween: 30,
		slidesPerView: 5,
		allowTouchMove: false,
		freeMode: true,
		speed: 1400,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		autoplay: {
			delay: 5000,
		},
		breakpoints: {
			600: {
				slidesPerView: 2,
			  },
			700: {
			  slidesPerView: 3,
			},
			800: {
			  slidesPerView: 4,
			},
		  }
	});

	var singleProduct = new Swiper('.single-product', {
		spaceBetween: 0,
		slidesPerView: 1,
		mousewheel: true,
		autoplay: {
			delay: 5000,
		},
		loop: true,
		speed: 1400,
		thumbs: {
			swiper: productThumb
		}
	});


	//Price Range Slider
	if ($('.price-ranger').length) {
		$('.price-ranger #slider-range').slider({
			range: true,
			min: 10,
			max: 200,
			values: [11, 99],
			slide: function(event, ui) {
				$('.price-ranger .ranger-min-max-block .min').val('$' + ui.values[0]);
				$('.price-ranger .ranger-min-max-block .max').val('$' + ui.values[1]);
			}
		});
		$('.price-ranger .ranger-min-max-block .min').val('$' + $('.price-ranger #slider-range').slider('values', 0));
		$('.price-ranger .ranger-min-max-block .max').val('$' + $('.price-ranger #slider-range').slider('values', 1));
	};

	// Lazyload Images
	if($('.lazy-image').length){
		new LazyLoad({
			elements_selector: ".lazy-image",
			load_delay: 0,
			threshold: 300
		});
	}
	
	/////////////////////////////
		//Universal Code for All Owl Carousel Sliders
	/////////////////////////////
	
	if ($('.theme_carousel').length) {
			$(".theme_carousel").each(function (index) {
			var $owlAttr = {},
			$extraAttr = $(this).data("options");
			$.extend($owlAttr, $extraAttr);
			$(this).owlCarousel($owlAttr);
		});
	}
	
	// Donation Progress Bar
	if ($('.count-bar').length) {
		$('.count-bar').appear(function(){
			var el = $(this);
			var percent = el.data('percent');
			$(el).css('width',percent).addClass('counted');
		},{accY: -50});

	}

	//Jquery Spinner / Quantity Spinner
	if($('.quantity-spinner').length){
		$("input.quantity-spinner").TouchSpin({
		  verticalbuttons: true
		});
	}

	//Tabs Box
	if($('.tabs-box').length){
		$('.tabs-box .tab-buttons .tab-btn').on('click', function(e) {
			e.preventDefault();
			var target = $($(this).attr('data-tab'));
			
			if ($(target).is(':visible')){
				return false;
			}else{
				target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
				$(this).addClass('active-btn');
				target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
				target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
				$(target).fadeIn(300);
				$(target).addClass('active-tab');
			}
		});
	}
	
	//Fact Counter + Text Count
	if($('.count-box').length){
		$('.count-box').appear(function(){
	
			var $t = $(this),
				n = $t.find(".count-text").attr("data-stop"),
				r = parseInt($t.find(".count-text").attr("data-speed"), 10);
				
			if (!$t.hasClass("counted")) {
				$t.addClass("counted");
				$({
					countNum: $t.find(".count-text").text()
				}).animate({
					countNum: n
				}, {
					duration: r,
					easing: "linear",
					step: function() {
						$t.find(".count-text").text(Math.floor(this.countNum));
					},
					complete: function() {
						$t.find(".count-text").text(this.countNum);
					}
				});
			}
			
		},{accY: 0});
	}
	
	//Accordion Box
	if($('.accordion-box').length){
		$(".accordion-box").on('click', '.acc-btn', function() {
			
			var outerBox = $(this).parents('.accordion-box');
			var target = $(this).parents('.accordion');
			
			if($(this).hasClass('active')!==true){
				$(outerBox).find('.accordion .acc-btn').removeClass('active');
			}
			
			if ($(this).next('.acc-content').is(':visible')){
				return false;
			}else{
				$(this).addClass('active');
				$(outerBox).children('.accordion').removeClass('active-block');
				$(outerBox).find('.accordion').children('.acc-content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.acc-content').slideDown(300);	
			}
		});	
	}
	

	//LightBox / Fancybox
	if($('.lightbox-image').length) {
		$('.lightbox-image').fancybox({
			openEffect  : 'fade',
			closeEffect : 'fade',
			helpers : {
				media : {}
			}
		});
	}

	//Sortable Masonary with Filters
	function sortableMasonry() {
		if ($('.sortable-masonry').length) {
			var winDow = $(window);
			// Needed variables
			var $container = $('.sortable-masonry .items-container');
			var $filter = $('.filter-btns');
			$container.isotope({
				filter: '.all',
				animationOptions: {
					duration: 500,
					easing: 'linear'
				}
			});
			// Isotope Filter 
			$filter.find('li').on('click', function() {
				var selector = $(this).attr('data-filter');
				try {
					$container.isotope({
						filter: selector,
						animationOptions: {
							duration: 500,
							easing: 'linear',
							queue: false
						}
					});
				} catch (err) {}
				return false;
			});
			winDow.on('resize', function() {
				var selector = $filter.find('li.active').attr('data-filter');
				$container.isotope({
					filter: selector,
					animationOptions: {
						duration: 500,
						easing: 'linear',
						queue: false
					}
				});
				$container.isotope()
			});
			var filterItemA = $('.filter-btns li');
			filterItemA.on('click', function() {
				var $this = $(this);
				if (!$this.hasClass('active')) {
					filterItemA.removeClass('active');
					$this.addClass('active');
				}
			});
			$container.isotope("on", "layoutComplete", function(a, b) {
                var a = b.length,
                pcn = $(".filters .count");
                pcn.html(a);                
            }); 
		}
	}
	sortableMasonry();

	// Isotop Layout
	function isotopeBlock() {
		if($(".isotope-block").length){
			var $grid = $('.isotope-block').isotope();
	
		}
	}

	isotopeBlock();


	//Progress Bar / Levels
	if ($('.progress-levels .progress-box .bar-fill').length) {
		$(".progress-box .bar-fill").each(function() {
			var progressWidth = $(this).attr('data-percent');
			$(this).css('width', progressWidth + '%');
			$(this).children('.percent').html(progressWidth + '%');
		});
	}

	//Progress Bar
	if($('.progress-line').length){
		$('.progress-line').appear(function(){
			var el = $(this);
			var percent = el.data('width');
			$(el).css('width',percent+'%');
		},{accY: 0});
	}

	// Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 1500);
		});
	}

	//Jquery Knob animation 
	if ($('.dial').length) {
		$('.dial').appear(function() {
			var elm = $(this);
			var color = elm.attr('data-fgColor');
			var perc = elm.attr('value');
			elm.knob({
				'value': 0,
				'min': 0,
				'max': 100,
				'skin': 'tron',
				'readOnly': true,
				'thickness': 0.12,
				'dynamicDraw': true,
				'displayInput': false
			});
			$({
				value: 0
			}).animate({
				value: perc
			}, {
				duration: 2000,
				easing: 'swing',
				progress: function() {
					elm.val(Math.ceil(this.value)).trigger('change');
				}
			});
			//circular progress bar color
			$(this).append(function() {
				// elm.parent().parent().find('.circular-bar-content').css('color',color);
				//elm.parent().parent().find('.circular-bar-content .txt').text(perc);
			});
		}, {
			accY: 20
		});
	}

	if ($('.ajax-sub-form').length > 0) {
	    $('.ajax-sub-form').ajaxChimp({
	          language: 'es',
	          url: "https://gmail.us17.list-manage.com/subscribe/post?u=8a43765a655b07d21fa500e4e&amp;id=2eda0a58a7" //Replace this with your mailchimp post URL.
	    });

	    $.ajaxChimp.translations.es = {
	        'submit': 'Submitting...',
	        0: 'Thanks for your subscription',
	        1: 'Please enter a valid email',
	        2: 'An email address must contain a single @',
	        3: 'The domain portion of the email address is invalid (the portion after the @: )',
	        4: 'The username portion of the email address is invalid (the portion before the @: )',
	        5: 'This email address looks fake or invalid. Please enter a real email address'
	    };
	}


	
	// Elements Animation
	if($('.wow').length){
		var wow = new WOW(
		  {
			boxClass:     'wow',      // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset:       0,          // distance to the element when triggering the animation (default is 0)
			mobile:       true,       // trigger animations on mobile devices (default is true)
			live:         true       // act on asynchronously loaded content (default is true)
		  }
		);
		wow.init();
	}

	//Add One Page nav
	if($('.scroll-nav').length) {
		$('.scroll-nav ul').onePageNav();
	}


/* ==========================================================================
   When document is Resize, do
   ========================================================================== */
	
	$(window).on('resize', function() {
		marginClc();
	});

/* ==========================================================================
   When document is Scrollig, do
   ========================================================================== */
	
	$(window).on('scroll', function() {
		headerStyle();
	});
	
/* ==========================================================================
   When document is loading, do
   ========================================================================== */
	
	$(window).on('load', function() {
		handlePreloader();
		sortableMasonry();
		isotopeBlock();
		bannerSlider();		
	});	

})(window.jQuery);