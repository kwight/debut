jQuery( document ).ready( function( $ ) {

	// Small menu for screen sizes under 480px wide
	$( '.menu-button' ).click( function() {
		$( '.menu' ).slideToggle();
	})

	if ( 'flexslider' in $ ) {
		$('.flexslider').flexslider({
			animation: 'slide',
			smoothHeight: true
		}); 
	}
	
});