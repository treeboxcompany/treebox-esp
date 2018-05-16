(function (document, $, undefined) {

	/**
	 * Add shrink class to header on scroll.
	 */
	$(window).scroll(function () {
		var scroll = $(window).scrollTop();
		var height = $('.hero-section').outerHeight();
		var header = $('.site-header').outerHeight();
		if (scroll >= header) {
			$(".site-header").addClass("shrink");
		} else {
			$(".site-header").removeClass("shrink");
		}
	});

	/*
	 * Move before header into nav on mobile.
	 */
	$( window ).on( "resize", function () {
		if ( $( window ).width() < 896 ) {
			$( '.header-widget-area' ).appendTo( '.nav-primary .menu' );
		} else {
			$( '.header-widget-area' ).appendTo( '.site-header .wrap' );
			$( '.nav-primary .header-widget-area' ).remove();
		}
	} ).resize();

	/**
	 * Show/hide video lightbox.
	 */
	$('.front-page-4 .wp-video').append('<button class="hide-video">×</button>');
	$('.front-page-4 .wp-video').prepend('<div class="before"></div>');
	$('.show-video').on('click', function () {
		$('.widget_media_video').toggleClass('visible');
	});
	$('.hide-video, .before').on('click', function () {
		$('.front-page-4 .widget_media_video').toggleClass('visible');

        // First get the  iframe URL.
        var url = $('.front-page-4 iframe').attr('src');

		// Then assign the src to null, this then stops the video been playing.
		$('.front-page-4 iframe').attr('src', '');

		// Finally reassign the URL back to the iframe, so when you hide and load it again you still have the link.
		$('.front-page-4 iframe').attr('src', url);

	});

	// Append icon for enews footer widget.
	$('.footer-widgets .enews form').append('<i class="fa fa-send-o"></i>');

	// Add back to top button.
	$('.site-footer > .wrap').append('<a href="#top" class="back-to-top"></a>');

	// Add id to top of page for scrolling target.
	$('html').attr('id', 'top');

	// Hide menu when anchor link is clicked.
	$('.menu-item a[href*="#"]').on( 'click', function() {
		if( $( '.menu-toggle' ).hasClass( 'activated' ) ) {
			$('.nav-primary').fadeToggle();
			$('.menu-toggle').removeClass('activated');
		}
	});

	/**
	 * Smooth scrolling.
	 */
	// Select all links with hashes
	$('a[href*="#"]')
	// Remove links that don't actually link to anything
	.not('[href="#"]')
	.not('[href="#0"]')
	// Remove WooCommerce tabs
	.not('[href*="#tab-"]')
	.click(function (event) {
		// On-page links
		if (
			location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
			location.hostname == this.hostname
		) {
			// Figure out element to scroll to
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			// Does a scroll target exist?
			if (target.length) {
				// Only prevent default if animation is actually gonna happen
				event.preventDefault();
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 1000, function () {
					// Callback after animation
					// Must change focus!
					var $target = $(target);
					$target.focus();
					if ($target.is(":focus")) { // Checking if the target was focused
						return false;
					} else {
						$target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
						$target.focus(); // Set focus again
					};
				});
			}
		}
	});

})(document, jQuery);
