/**
 * ytmenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var YTMenu = (function() {
	function init() {
		[].slice.call( document.querySelectorAll( '.dr-menu' ) ).forEach( function( el, i ) {
			var trigger = el.querySelector( 'div.dr-trigger' ),
				icon = trigger.querySelector( 'span.dr-icon-menu' ),
				open = false;
			trigger.addEventListener( 'click', function( event ) {
				if( !open ) {

					$('.dr-menu').css({
						'width':'400px',
						'overflow-y':'scroll',
						'height':'300px',
						'padding-top': '2em'
					});
					el.className += ' dr-menu-open';
					open = true;
				}
			}, false );
			icon.addEventListener( 'click', function( event ) {
				if( open ) {
					event.stopPropagation();

					$('.dr-menu').css({
						'width'	:'50px',
						'height':'50px',
						'overflow':'hidden',
						'padding-top': '0'
					});

					open = false;
					el.className = el.className.replace(/\bdr-menu-open\b/,'');
					return false;
				}
			}, false );
		} );
	}
	init();
})();