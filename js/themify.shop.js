; //defensive semicolon
//////////////////////////////
// Test if touch event exists
//////////////////////////////
function is_touch_device() {
	return 'true' == themifyScript.isTouch;
}

function getParameterByName(name, url) {
	name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	var regexS = "[\\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(url);
	if(results == null)
	  return "";
	else
	  return decodeURIComponent(results[1].replace(/\+/g, " "));
}

// Begin jQuery functions
(function($) {

$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(window).load(function() {

	/////////////////////////////////////////////
	// Product slider
	/////////////////////////////////////////////
	if ($('.product-slides').length > 0) {

		// Parse data from wp_localize_script
		themifyShop.autoplay = parseInt(themifyShop.autoplay);
		themifyShop.speed = parseInt(themifyShop.speed);
		themifyShop.scroll = parseInt(themifyShop.scroll);
		themifyShop.visible = parseInt(themifyShop.visible);
		themifyShop.wrap = null != themifyShop.wrap;
		themifyShop.play = 0 != themifyShop.autoplay;

		$('.product-slides').carouFredSel({
			responsive : true,
			prev : '#product-slider .carousel-prev',
			next : '#product-slider .carousel-next',
			pagination : "#product-slider .carousel-pager",
			width : '100%',
			circular : themifyShop.wrap,
			infinite : themifyShop.wrap,
			auto : {
				play : themifyShop.play,
				pauseDuration : themifyShop.autoplay * 1000,
				duration : themifyShop.speed
			},
			swipe: true,
			scroll : {
				items : themifyShop.scroll,
				duration : themifyShop.speed
			},
			items : {
				visible : {
					min : 1,
					max : themifyShop.visible
				},
				width : 150
			},
			onCreate : function() {
				$('.product-sliderwrap').css({
					'height' : 'auto',
					'visibility' : 'visible'
				});
			}
		});
	}
});

$(document).ready(function() {

	/////////////////////////////////////////////
	// Check is_mobile
	/////////////////////////////////////////////
	$('body').addClass(is_touch_device() ? 'is_mobile' : 'is_desktop');

	/////////////////////////////////////////////
	// Toggle sorting nav
	/////////////////////////////////////////////
	$("body").on("click", '.sort-by', function(e){
		if($(this).next().is(':visible')) {
			$(this).next().slideUp();
			$(this).removeClass('active');
		}
		else{
			$(this).next().slideDown();
			$(this).addClass('active');
		}
		e.preventDefault();
	});

	$("body").on("hover", '.orderby-wrap', function(e){
		if(e.type == 'mouseenter') {
			if(!$(this).find('.orderby').is(':visible')) {
				$(this).find('.orderby').slideDown();
				$(this).find('.sort-by').addClass('active');
			}
		}
		if(e.type == 'mouseleave') {
			if($(this).find('.orderby').is(':visible') && $(this).find('.sort-by').hasClass('active')) {
				$(this).find('.orderby').slideUp();
				$(this).find('.sort-by').removeClass('active');
			}
		}
		e.preventDefault();
	});

	$('body').on('wc_fragments_refreshed', function(){
		$('.is_mobile #cart-wrap').show();
	});

	/////////////////////////////////////////////
	// Add to cart ajax
	/////////////////////////////////////////////
	if(woocommerce_params.option_ajax_add_to_cart == 'yes') {

		// Ajax add to cart
		var $loadingIcon;
		$('body').on('adding_to_cart', function(e, $button, data ){
			var cart = $('#cart-wrap');
			// hide cart wrap
			cart.hide();
			// This loading icon
			$loadingIcon = $('.loading-product', $button.closest('.product')).first();
			$loadingIcon.show();
		}).on('added_to_cart removed_from_cart', function(e, fragments, cart_hash){
			$('.is_mobile #cart-wrap').show();
			
			if( typeof $loadingIcon !== 'undefined' ) {
				// Hides loading animation
				$loadingIcon.hide(300, function(){
					$(this).addClass('loading-done');
				});
				$loadingIcon
					.fadeIn()
					.delay(500)
					.fadeOut(300, function(){
						$(this).removeClass('loading-done');
				});
			}

			// close lightbox
			if( $('.pp_inline').is(':visible') ) {
				$.prettyPhoto.close();
			}
			$('form.cart').find(':submit').removeAttr( 'disabled' );
		});

		// remove item ajax
		$(document).on( 'click', '.remove-item-js', function() {
			var href = $(this).attr('href'),
				shopdock = $('#shopdock');

			// AJAX add to cart request
			var $thisbutton = $(this);

			var data = {
				action: 		'theme_delete_cart',
				remove_item: 	$thisbutton.attr('data-product-key'),
				security: themifyShop.nonce
			};

			// Ajax action
			$.post( woocommerce_params.ajax_url, data, function( response ) {

				var this_page = window.location.toString();
				this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

				fragments = response.fragments;
				cart_hash = response.cart_hash;

				// Block fragments class
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).addClass('updating');
					});
				}

				// Block widgets and fragments
				$('.shop_table.cart, .updating, .cart_totals, .widget_shopping_cart').fadeTo('400', '0.6').block({message: null, overlayCSS: {background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );

				// Changes button classes
				if ( $thisbutton.parent().find('.added_to_cart').size() == 0 )
					$thisbutton.addClass('added');

				// Replace fragments
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).replaceWith(value);
					});
				}

				// Unblock
				$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();

				// Cart page elements
				$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {

					$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" id="add1" class="plus" />' ).prepend( '<input type="button" value="-" id="minus1" class="minus" />' );

					$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();

					$( 'body' ).trigger( 'cart_page_refreshed' );
				});

				$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
					$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
				});

				// Trigger event so themes can refresh other areas
				$( 'body' ).trigger( 'removed_from_cart', [ fragments, cart_hash ] );

			});

			return false;
		});

		// Ajax add to cart in single page
		ajax_add_to_cart_single_page();

	}

	// reply review
	$('.reply-review').click(function() {
		$('#respond').slideToggle('slow');
		return false;
	});

	// add review
	$('.add-reply-js').click(function() {
		$(this).hide();
		$('#respond').slideDown('slow');
		$('#cancel-comment-reply-link').show();
		return false;
	});
	$('#reviews #cancel-comment-reply-link').click(function() {
		$(this).hide();
		$('#respond').slideUp();
		$('.add-reply-js').show();
		return false;
	});

	/*function ajax add to cart in single page */
	function ajax_add_to_cart_single_page() {
		$(document).on('submit', 'form.cart', function() {
			var quantity = $(this).find('.quantity input.qty').val(),
				shopdock = $('#shopdock');
			
			// This loading icon
			var $loadingIcon = $(this).closest('.product').find('.loading-product').first();
			$loadingIcon.show();

			var data = $(this).serializeObject(),
				data2 = {
					action: 'theme_add_to_cart'
				};
			$.extend(true, data, data2);

			// Trigger event
			$( 'body' ).trigger( 'adding_to_cart', [ $(this), data ] );

			// Ajax action
			$.post( woocommerce_params.ajax_url, data, function( response ) {

				if ( ! response )
					return;

				var this_page = window.location.toString();
				this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

				fragments = response.fragments;
				cart_hash = response.cart_hash;

				// Block fragments class
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).addClass('updating');
					});
				}

				// Block widgets and fragments
				$('.shop_table.cart, .updating, .cart_totals, .widget_shopping_cart').fadeTo('400', '0.6').block({message: null, overlayCSS: {background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );

				// Replace fragments
				if ( fragments ) {
					$.each(fragments, function(key, value) {
						$(key).replaceWith(value);
					});
				}

				// Unblock
				$('.widget_shopping_cart, .updating').stop(true).css('opacity', '1').unblock();

				// Cart page elements
				$('.shop_table.cart').load( this_page + ' .shop_table.cart:eq(0) > *', function() {

					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

					$('.shop_table.cart').stop(true).css('opacity', '1').unblock();

					$('body').trigger('cart_page_refreshed');
				});

				$('.cart_totals').load( this_page + ' .cart_totals:eq(0) > *', function() {
					$('.cart_totals').stop(true).css('opacity', '1').unblock();
				});

				// Trigger event so themes can refresh other areas
				$( 'body' ).trigger( 'added_to_cart', [ fragments, cart_hash ] );

			});
			return false;
		});
	}

	/**
	 * Limit the number entered in the quantity field.
	 * @param $obj The quantity field object.
	 * @param max_qty The max quantity allowed per the inventory current stock.
	 */
	function limitQuantityByInventory( $obj, max_qty ) {
		var qty = $obj.val();
		if ( qty > max_qty ) {
			$obj.val( max_qty );
		}
	}

	/////////////////////////////////////////////
	// Themibox - Themify Lightbox
	/////////////////////////////////////////////
	var $body = $('body');
	/* Initialize Themibox */
	Themibox.init();

	/* Initialize variations when Themibox is loaded */
	$body.on('themiboxloaded', function(e){
		ajax_variation_callback();
		var $lightboxItem = $('.lightbox-item');

		$('.thumbnails', $lightboxItem).on('click', 'a', function(e){
			e.preventDefault();
			var $self = $(this);
			$('.product-image img', $lightboxItem).fadeOut(400, function(){
				$(this).attr({
					src : $self.attr('href'),
					width : '',
					height : ''
				}).fadeIn();
			});
		});


		// Limit number entered manually in quantity field in single view
		if ( $body.hasClass('single-product') || $body.hasClass('post-lightbox') ) {
			$('.entry-summary').on('keyup', 'input[name=quantity][max]', function() {
				limitQuantityByInventory($('input[name=quantity]'), parseInt( $(this).attr('max'), 10 ));
			});
		}

	});

	$body.on('themiboxclosed themiboxcanceled', function(e){
		$('#post-lightbox-wrap').removeClass('lightbox-message');
	});

	var $lightboxAdded;

	$body.on('added_to_cart', function(e){
		var $postLightboxContainer = $('#post-lightbox-container');

		if ( $('.lightbox-added').length > 0 ) {
			$lightboxAdded = $('.lightbox-added');
		}

		$('#post-lightbox-wrap').addClass('lightbox-message');
		$postLightboxContainer.slideUp(400, function(){
			var $self = $(this);
			$('.close-themibox', $lightboxAdded).on('click', function(e) {
				Themibox.closeLightBox(e);
			});
			$self.empty();
			$lightboxAdded.appendTo($self).show();
			$self.slideDown();
		});

		$('.added_to_cart:not(.button)').addClass('button');
	});

	// Limit number entered manually in quantity field in single view
	if ( $body.hasClass('single-product') ) {
		$('.entry-summary').on('keyup', 'input[name=quantity][max]', function() {
			limitQuantityByInventory($('input[name=quantity]'), parseInt( $(this).attr('max'), 10 ));
		});
	}

	/* function ajax variation callback */
	function ajax_variation_callback() {
		var themify_product_variations = $.parseJSON($('#themify_product_vars').text());

		//check if two arrays of attributes match
		function variations_match(attrs1, attrs2) {
			var match = true;
			for (name in attrs1) {
				var val1 = attrs1[name];
				var val2 = attrs2[name];

				if (val1.length != 0 && val2.length != 0 && val1 != val2) {
					match = false;
				}
			}
			return match;
		}

		//show single variation details (price, stock, image)
		function show_variation(variation) {
			var img = $('div.images img:eq(0)');
			var link = $('div.images a.zoom:eq(0)');
			var o_src = $(img).attr('original-src');
			var o_link = $(link).attr('original-href');

			var variation_image = variation.image_src;
			var variation_link = variation.image_link;

			if( true == variation.is_in_stock ) {
				$('.variations_button').show();
			} else {
				$('.variations_button').hide();
			}
			$('.single_variation').html(variation.price_html + variation.availability_html);

			if(!o_src) {
				$(img).attr('original-src', $(img).attr('src'));
			}

			if(!o_link) {
				$(link).attr('original-href', $(link).attr('href'));
			}

			if(variation_image && variation_image.length > 1) {
				$(img).attr('src', variation_image);
				$(link).attr('href', variation_link);
			} else {
				$(img).attr('src', o_src);
				$(link).attr('href', o_link);
			}

			if(variation.sku) {
				$('.product_meta').find('.sku').text(variation.sku);
			} else {
				$('.product_meta').find('.sku').text('');
			}

			if ( variation.max_qty > 0 ) {
				var $variationWrap = $('.single_variation_wrap');
				// Limit number entered manually in quantity field
				$variationWrap.on('keyup', 'input[name=quantity]', function() {
					limitQuantityByInventory($('input[name=quantity]'), parseInt( variation.max_qty, 10 ));
				});
				// Limit number in quantity field when plus button is clicked
				$variationWrap.on('click', 'input.plus', function() {
					limitQuantityByInventory($('input[name=quantity]'), parseInt( variation.max_qty, 10 ) - 1);
				});
			}

			$('.single_variation_wrap').slideDown('200').trigger('variationWrapShown').trigger('show_variation');
			// depreciated variationWrapShown
		}

		//disable option fields that are unavaiable for current set of attributes
		function update_variation_values(variations) {

			// Loop through selects and disable/enable options based on selections
			$('.variations select').each(function(index, el) {

				current_attr_select = $(el);

				// Disable all
				current_attr_select.find('option:gt(0)').attr('disabled', 'disabled');

				// Get name
				var current_attr_name = current_attr_select.attr('name');

				// Loop through variations
				for(num in variations) {
					var attributes = variations[num].attributes;

					for(attr_name in attributes) {
						var attr_val = attributes[attr_name];

						if(attr_name == current_attr_name) {
							if(attr_val) {

								// Decode entities
								attr_val = $("<div/>").html(attr_val).text();

								// Add slashes
								attr_val = attr_val.replace(/'/g, "\\'");
								attr_val = attr_val.replace(/"/g, "\\\"");

								// Compare the meercat
								current_attr_select.find('option[value="' + attr_val + '"]').removeAttr('disabled');

							} else {
								current_attr_select.find('option').removeAttr('disabled');
							}
						}
					}
				}
			});
		}

		//search for matching variations for given set of attributes
		function find_matching_variations(settings) {
			var matching = [];

			for(var i = 0; i < themify_product_variations.length; i++) {
				var variation = themify_product_variations[i];
				var variation_id = variation.variation_id;

				if(variations_match(variation.attributes, settings)) {
					matching.push(variation);
				}
			}
			return matching;
		}

		//when one of attributes is changed - check everything to show only valid options
		function check_variations(exclude) {
			var all_set = true;
			var current_settings = {};

			$('.variations select').each(function() {

				if(exclude && $(this).attr('name') == exclude) {

					all_set = false;
					current_settings[$(this).attr('name')] = '';

				} else {
					if($(this).val().length == 0)
						all_set = false;

					// Encode entities
					value = $(this).val().replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

					// Add to settings array
					current_settings[$(this).attr('name')] = value;
				}

			});

			var matching_variations = find_matching_variations(current_settings);

			if(all_set) {
				var variation = matching_variations.pop();
				if(variation) {
					$('form input[name=variation_id]').val(variation.variation_id);
					show_variation(variation);
				} else {
					// Nothing found - reset fields
					$('.variations select').val('');
				}
			} else {
				update_variation_values(matching_variations);
			}
		}

		$('body').off('change', '.variations select');

		$('body').on('change', '.variations select', function(e) {
			$('form input[name=variation_id]').val('');
			$('.single_variation_wrap').hide();
			$('.single_variation').text('');
			check_variations();
			$(this).blur();
			if($().uniform && $.isFunction($.uniform.update)) {
				$.uniform.update();
			}
		}).change();

		$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

	}

});

}(jQuery));