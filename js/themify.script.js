;// Themify Theme Scripts - http://themify.me/

// Initialize object literals
var FixedHeader = {}, ParallaxHeader = {};

/////////////////////////////////////////////
// jQuery functions					
/////////////////////////////////////////////
(function($){

// Test if touch event exists //////////////////////////////
function is_touch_device() {
	return 'true' == themifyScript.isTouch;
}

//////////////////////////////
// Fixed Header
//////////////////////////////
FixedHeader = {
	init: function() {
		var cons = is_touch_device() ? 10 : 0;
		this.headerHeight = $('#headerwrap').height() - cons;
		this.activate();
		$(window)
		.on('scroll', this.activate)
		.on('touchstart.touchScroll', this.activate)
		.on('touchmove.touchScroll', this.activate);
	},

	activate: function() {
		var $window = $(window),
			scrollTop = $window.scrollTop();

		if( scrollTop > FixedHeader.headerHeight ) {
			FixedHeader.scrollEnabled();
		} else {
			FixedHeader.scrollDisabled();
		}
	},

	scrollDisabled: function() {
		$('#headerwrap').removeClass('fixed-header');
		$('#header').removeClass('header-on-scroll');
		$('body').removeClass('fixed-header-on');
	},

	scrollEnabled: function() {
		$('#headerwrap').addClass('fixed-header');
		$('#header').addClass('header-on-scroll');
		$('body').addClass('fixed-header-on');
	}
};

function themify_transition(){
	var selector = '.grid2 .products .product, .grid3 .products .product, .grid4 .products .product',
		transitionClass = themifyScript.transitionEffect ? 'transition-one-up' : 'no-transition';
	$(selector).each(function(){
		if($(this).find('.'+transitionClass).length == 0){
			var prodId = $(this).data('product-id'),
				prodStyle = 'product-style-'+prodId;
			$(this).wrapInner('<div class="'+transitionClass+'" />')
			.prepend('<div class="product-bg-container"><div class="product-bg '+prodStyle+'"></div></div>').removeClass(prodStyle);
		}
	});

	// Transition Effect
	if ( themifyScript.transitionEffect ) {
		// shortcode columns add class
		$('.col2-1.first, .col3-1.first, .col3-2.first, .col4-1.first, .col4-2.first, .col4-3.first').each(function(){
			var $this = $(this);
			if($this.hasClass('col2-1')) {
				$this.next('.col2-1').addClass('last');
				$this.next('.col4-1').addClass('third').next('.col4-1').addClass('last');
			} else if($this.hasClass('col3-1')) {
				$this.next('.col3-1').addClass('second').next('.col3-1').addClass('last');
				$this.next('.col3-2').addClass('last');
			} else if($this.hasClass('col3-2')) {
				$this.next('.col3-1').addClass('last');
			} else if($this.hasClass('col4-1')) {
				$this.next('.col4-1').addClass('second').next('.col4-1').addClass('third').next('.col4-1').addClass('last');
			} else if($this.hasClass('col4-2')) {
				$this.next('.col4-2').addClass('last');
				$this.next('.col4-1').addClass('third').next('.col4-1').addClass('last');
			} else if($this.hasClass('col4-3')) {
				$this.next('.col4-1').addClass('last');
			}
		});
		var col_nums = 1;
		$('.col-full').each(function(){
			var $this = $(this);
			if( col_nums % 2 == 0) {
				$this.addClass('animate-last');
			} else {
				$this.addClass('animate-first');
			}
			col_nums += 1;
		});
	}
}

ParallaxHeader = {
	init: function(){
		if(!themifyScript.headerParallax) return;
		this.sliderWrapper = ['#sliderwrap', '.single-post #pagewrap .single-media-wrap'];

		$(window).load(this.onLoaded);
	},

	onLoaded: function(){
		var self = ParallaxHeader, resizeId;
		$('body').addClass('parallax-header');
		
		$.each(self.sliderWrapper, function(i,v){
			if($(v).length > 0)	{
				var $layoutWrap = $(v).nextAll('div').first();
				$layoutWrap.css('marginTop', $(v).height());

				$(window).on('scroll', function(){
					self.transition(v);
				}).on('touchmove.touchScroll', function(){
					self.transition(v);
				}).on('resize', function(){
					clearTimeout(resizeId);
					resizeId = setTimeout(function(){
						$layoutWrap.css('marginTop', $(v).height());
					}, 500);
				}).on('orientationchange', function(){
					self.transition(v);
				});
			}
		});
	},

	transition: function(obj){
		var n = Math.ceil($(window).scrollTop() / 3);
		$(obj).css({
			'-webkit-transform' : 'translateY(-'+n+'px)',
			'-moz-transform' : 'translateY(-'+n+'px)',
			'-o-transform' : 'translateY(-'+n+'px)',
			'-ms-transform' : 'translateY(-'+n+'px)',
			'transform' : 'translateY(-'+n+'px)'
		});
		if($(window).scrollTop() > $(obj).height()){
			$(obj).hide();
		} else {
			$(obj).show();
		}
	}
};

function setSlidersHeight() {
	// Set fixed slider height based on the heighest slide
	var $slider = $('#slider'),
		sliderHeight = 0;
	$slider.find('.slides > li').css('height','');
	if($(window).width() > 780) return;
	$slider.find('.slides > li').each(function(){
		slideHeight = $(this).height();
		if (sliderHeight < slideHeight) {
			sliderHeight = slideHeight;
		}
	});
	$slider.find('.slides > li').css({'height' : sliderHeight});
}

// Transition Effect
// Call earlier than $.ready or $.load
themify_transition();

// DOCUMENT READY
$(document).ready(function() {

	// Fixed header
	if ( themifyScript.fixedHeader ) {
		FixedHeader.init();
	}

	/////////////////////////////////////////////
	// Scroll to top
	/////////////////////////////////////////////
	$('.back-top a').click(function() {
		$('body,html').animate({ scrollTop: 0 }, 800);
		return false;
	});

	/////////////////////////////////////////////
	// Google map width
	/////////////////////////////////////////////
	var w = $(document).width();
	$('.google-map iframe').width(w);


	/////////////////////////////////////////////
	// Toggle main nav on mobile
	/////////////////////////////////////////////
	$('#menu-icon-close').on('click', function(e){
		e.preventDefault();
		$.UIkit.offcanvas.hide();
	});

	$('#cart-icon-close').on('click', function(e){
		e.preventDefault();
		$.UIkit.offcanvas.hide();
	});

	/////////////////////////////////////////////
	// NiceScroll plugin
	/////////////////////////////////////////////
	if ( typeof $.fn.niceScroll !== 'undefined' ) {
		$('#menu-icon').on('click', function(){
			var nice = $('#slide-nav').getNiceScroll();
			if ( nice.length == 0 ) {
				$('#slide-nav').niceScroll({
					autohidemode: false,
					cursorcolor: '#fff',
					cursorwidth: '7px'
				});
			}
		});
	}

	//////////////////////////////////////////////////////////
	// Show/Hide search form and unfold/fold search options
	//////////////////////////////////////////////////////////
	$('.search-option').each(function(index){
		$this = $(this);
		if( null == readCookie('themify-search-option') ){
			createCookie('themify-search-option', '.search-blog');
			$choice = $('.search-blog', $this);
		}
		else{
			$choice = $(readCookie('themify-search-option'), $this);
		}
		$choice.each(function(){
			$(this).prop('checked', true);
		});
		$('.search-type').each(function(){
			$(this).val( $choice.val() );
		});
		$('input', $this).change(function(e){
			searchValue = $(this).val();
			$(this).parent().siblings('.search-type').val( searchValue );
			createCookie('themify-search-option', '.'+$(this).attr('class'));
		});
	});

	function createCookie(name,value) {
		document.cookie = name+"="+value+"; path=/";
	}

	function readCookie(name) {
		name = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return null;
	}

	$(window).resize(function(){
		setSlidersHeight(); // slider equal height
	});

	// Lightbox / Fullscreen initialization ///////////
	if(typeof ThemifyGallery !== 'undefined') {
		ThemifyGallery.init({'context': $(themifyScript.lightboxContext)});
	}
});

function infiniteIsotope(containerSelector, itemSelectorIso, itemSelectorInf, containerInfinite, isoCallback){

	// Get max pages for regular category pages and home
	var scrollMaxPages = parseInt(themifyScript.maxPages),
		$container = $(containerSelector),
		$containerInfinite = $(containerInfinite),
		isProductLayout = ( itemSelectorIso === '.product' );

	// Get max pages for Query Category pages
	if( typeof qp_max_pages != 'undefined')
		scrollMaxPages = qp_max_pages;

	if ( isProductLayout ) {
		if ( themifyScript.masonryLayout ) {
			// isotope init
			$container.isotope({
				itemSelector : itemSelectorIso,
				transformsEnabled : false
			});
		}
	} else {
		// isotope init
		$container.isotope({
			itemSelector : itemSelectorIso,
			transformsEnabled : false
		});
	}

	$(window).resize();
	// load callback
	if( $.isFunction(isoCallback) ){
		isoCallback.call(this, $container);
	}
	// infinite scroll
	$containerInfinite.infinitescroll({
		navSelector  : '#load-more a', 		// selector for the paged navigation
		nextSelector : '#load-more a', 		// selector for the NEXT link (to page 2)
		itemSelector : itemSelectorInf, 	// selector for all items you'll retrieve
		loadingText  : '',
		donetext     : '',
		loading 	 : { img: themifyScript.loadingImg },
		maxPage      : scrollMaxPages,
		behavior	 : 'auto' != themifyScript.autoInfinite? 'twitter' : '',
		bufferPx	 : parseInt(themifyScript.bufferPx),
		pathParse 	 : function (path, nextPage) {
			return path.match(/^(.*?)\b2\b(?!.*\b2\b)(.*?$)/).slice(1);
		}
	}, function(newElements) {
		// call Isotope for new elements
		var $newElems = $(newElements).wrapInner('<div class="product-inner"/>').hide();
		$newElems.imagesLoaded(function(){

			$newElems.fadeIn();
			if ( isProductLayout ) {
				if ( themifyScript.masonryLayout ) {
					$container.isotope('appended', $newElems );
				}
			} else {
				$container.isotope('appended', $newElems );
			}

			$('#infscr-loading').fadeOut('normal');
			if( 1 == scrollMaxPages ){
				jQuery('#load-more, #infscr-loading').remove();
			}

			// Apply lightbox/fullscreen gallery to new items
			if(typeof ThemifyGallery !== 'undefined') {
				ThemifyGallery.init({'context': $(themifyScript.lightboxContext)});
			}

			// Remove tag to recently new elements
			$('.infscr_newElements').removeClass('infscr_newElements');

			// Tag elements added as new
			$newElems.addClass('infscr_newElements');

			// FlyIn Effect
			themify_transition();
			if ( 'undefined' !== typeof ThemifyBuilderModuleJs ) {
				ThemifyBuilderModuleJs.doAnimation(true);
			}

			// Tell everyone we have new elements
			$(document).trigger('newElements');

		});
		//$container.isotope('insert', $(newElements)).delay(400).isotope('reLayout');
		scrollMaxPages = scrollMaxPages - 1;
		if( 1 < scrollMaxPages && 'auto' != themifyScript.autoInfinite)
			$('#load-more a').show();
	});

	// disable auto infinite scroll based on user selection
	if( 'auto' == themifyScript.autoInfinite ){
		jQuery('#load-more, #load-more a').hide();
	}
}

// WINDOW LOAD
$(window).load(function() {

	/////////////////////////////////////////////
	// Masonry layout
	/////////////////////////////////////////////
	if ( $( '.products' ).length > 0 ) {
		var prodCols = parseInt($('#loops-wrapper').width() / $('.products .product').width());
		prodCols = prodCols > 4 ? 4 : prodCols;
		var prodW = $('#loops-wrapper').width() / prodCols;
		// isotope container, isotope item, item fetched by infinite scroll, infinite scroll
		infiniteIsotope('.grid2:not(.noisotope) .products, .grid3:not(.noisotope) .products, .grid4:not(.noisotope) .products', '.product', '#content .product', ' .products', function(container){
			if ( themifyScript.masonryLayout ) {
				container.isotope({resizable: false});
			}
			// update columnWidth on window resize
			$(window).smartresize(function(){
				prodW = parseInt(container.width() / prodCols);
				if ( themifyScript.masonryLayout ) {
					container.isotope({
						// update columnWidth to a percentage of container width
						masonry: { columnWidth: prodW }
					}).isotope('reLayout');
				}
			});
		});
	}
	if ( $( '.post' ).length > 0 && ! $('body').hasClass('query-product') ) {
		// isotope container, isotope item, item fetched by infinite scroll, infinite scroll
		infiniteIsotope(null, '.post', '#content .post', '#loops-wrapper');
	}

	// Main Slider
	$('#slider').flexslider( {
		animation: themifyScript.animation,
		animationSpeed: parseInt( themifyScript.animationDuration ),
		slideshow: !('false' == themifyScript.slideshowSpeed),
		slideshowSpeed: parseInt( themifyScript.slideshowSpeed ),
		animationLoop: true,
		directionNav: true,
		prevText: "&laquo;",
		nextText: "&raquo;",
		pauseOnHover: true,
		start: function() {
			$('#slider').fadeIn(800);
			$(window).resize();
		},
		before: function() {
			if ( $('.edit-button').length > 0 ) {
				$('.edit-button').stop().fadeOut(10, function(){
					$('.slide-excerpt').fadeOut(300, function(){
						$('.slide-post-title').fadeOut(300);
					});
				});
			} else {
				$('.slide-excerpt').stop().fadeOut(300, function(){
					$('.slide-post-title').fadeOut(300);
				});
			}
		},
		after: function() {
			var $activeSlide = $('.flex-active-slide');
			if ( $activeSlide.find('.slide-post-title').length > 0 ) {
				$activeSlide.find('.slide-post-title' ).stop().fadeIn(400, function(){
					$activeSlide.find('.slide-excerpt').fadeIn(400, function(){
						if ( $activeSlide.find('.edit-button').length > 0 )
							$activeSlide.find('.edit-button').fadeIn(400);
					});
				});
			} else {
				$activeSlide.find('.slide-excerpt').fadeIn(400, function(){
					if ( $activeSlide.find('.edit-button').length > 0 )
						$activeSlide.find('.edit-button').fadeIn(400);
				});
			}
		}
	} );

	// Slider Height
	setSlidersHeight();

	// Move menu into side panel on small screens
	var $hMenu = $('#horizontal-menu');
	if ( $hMenu.length > 0 ) {
		themifyScript.smallScreen = parseInt( themifyScript.smallScreen, 10 );
		themifyScript.resizeRefresh = parseInt( themifyScript.resizeRefresh, 10 );
		var isSmallScreen = function() { return $(window).width() <= themifyScript.smallScreen; },
			didResize = false,
			$mainNavWrap = $('.main-nav-wrap'),
			$horizontalWrap = $('.horizontal-menu-wrap');

		if ( isSmallScreen() ) {
			$hMenu.detach().insertBefore( $mainNavWrap );
		}

		$(window).resize(function() {
			didResize = true;
		});

		setInterval(function() {
			if ( didResize ) {
				didResize = false;
				if ( isSmallScreen() ) {
					$hMenu.detach().insertBefore( $mainNavWrap );
				} else {
					$hMenu.detach().prependTo( $horizontalWrap );
				}
			}
		}, themifyScript.resizeRefresh);
	}

});

// Parallax Header
ParallaxHeader.init();
	
})(jQuery);