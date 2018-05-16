/**
 * Add any custom theme JavaScript to this file.
 */

( function ( document, $ ) {
	
	'use strict';

	/**
	 * Add shrink class to header on scroll.
	 */
	$( window ).scroll( function() {
		var scroll = $( window ).scrollTop();
		var height = $( '.page-header' ).outerHeight();
		var header = $( '.site-header' ).outerHeight();
		if ( scroll >= header) {
			$( '.site-header' ).addClass( 'shrink' );
		} else {
			$( '.site-header' ).removeClass( 'shrink' );
		}
	} );

	/*
	 * Move header-right into nav on mobile.
	 */
	$( window ).on( "resize", function () {
		if ( $( window ).width() < 896 ) {
			$( '.header-widget-area' ).appendTo( '.nav-primary .wrap' );
		} else {
			$( '.header-widget-area' ).appendTo( '.site-header .wrap' );
			$( '.nav-primary .header-widget-area' ).remove();
		}
	} ).resize();

	/**
	 * Smooth scrolling.
	 */
	// Select all links with hashes
	$( 'a[href*="#"]' )

	// Remove links that don't actually link to anything
	.not( '[href="#"]' ).not( '[href="#0"]' )

	// Remove WooCommerce tabs
	.not( '[href*="#tab-"]' ).click( function ( event ) {

		// On-page links
		if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) && location.hostname == this.hostname ) {

			// Figure out element to scroll to
			var target = $( this.hash );
			target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );

			// Does a scroll target exist?
			if ( target.length ) {

				// Only prevent default if animation is actually gonna happen
				event.preventDefault();
				$( 'html, body' ).animate( {
					scrollTop: target.offset().top
				}, 1000, function () {

					// Callback after animation, must change focus!
					var $target = $( target );
					$target.focus();

					// Checking if the target was focused
					if ( $target.is( ":focus" ) ) {

						return false;
					} else {

						// Adding tabindex for elements not focusable
						$target.attr( 'tabindex', '-1' );

						// Set focus again
						$target.focus();
					};
				} );
			}
		}
	} );

} )( document, jQuery );
