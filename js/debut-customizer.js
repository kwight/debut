jQuery( document ).ready( function( $ ) {

	// Allow real-time updating of the theme customizer
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );
    wp.customize( 'debut_link_color', function( value ) {
        value.bind( function( to ) {
            $('body').css('border-color', to );
            $('a').not('.main-navigation .current-menu-item > a').css('color', to );
            $('.main-navigation .current-menu-item > a').css({
            	'background-color': to,
            	'color': '#fff'
            });
            $('.menu li > a').hover(
				function () {
					$(this).css({
						'background-color': to,
						'color': '#fff',
						'text-shadow': '0 1px 0 rgba(0,0,0,.8)'
					});
				}, 
				function () {
					$(this).css({
						'background-color': '#efefef',
						'color': to,
						'text-shadow': 'none'
					});
					$('.main-navigation .current-menu-item > a').css({
		            	'background-color': to,
		            	'color': '#fff'
		            });
					$('.sub-menu li a').css({
						'background-color': '#ddd',
						'color': to,
						'text-shadow': 'none'
		            });
				}
			);
            $('.sub-menu').hover(
				function () {
					$(this).prev().css({
						'background-color': '#ddd'
					});
				}, 
				function () {
					$(this).prev().css({
						'background-color': '#efefef'
					});
				}
			);
        });
    });

});