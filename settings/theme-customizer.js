(function( $ ) {
	"use strict";

	// Header Background Color - Color Control
	wp.customize( 'header_background_color_setting', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'backgroundColor', to );
		} );
	});

	// Header Background Image - Image Control
	wp.customize( 'header_background_image_setting', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});

	// Header Background Image Repeat - Checkbox
	wp.customize( 'header_background_image_repeat_setting', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'background-repeat', true === to ? 'repeat' : 'no-repeat' );
		} );
	} );

	// Header Background Image Size - Checkbox
	wp.customize( 'header_background_image_size_setting', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'background-size', true === to ? 'cover' : 'auto auto' );
		} );
	} );

})( jQuery );
