// Start Wrapper
jQuery(document).ready( function($) {
	'use strict';

	// Mobile Nav Toggle
	$('#ht-navtoggle').on( 'click', function(e) {
		$('#ht-navtoggle').toggleClass("active");
		e.preventDefault();
    } );

	// HKB searching event
	$('.hkb-site-search__field').keypress( function() {
		$('body').addClass( 'htevent-hkb-searching' );
	} );
	$( '.hkb-site-search__field' ).blur( function() {
   		$('body').removeClass( 'htevent-hkb-searching' );
	} );

	// Setup for mobile nav
	function setSiteHeaderVariables() {
		var headerHeight = $('.site-header__banner').outerHeight(true);
	  	var adminBarHeight = $('#wpadminbar').outerHeight(true);

		$('.nav-header__menuwrapper').css({ 'top': headerHeight });
	}

		
	//inital load
	$( window ).ready( function () {
	  setSiteHeaderVariables();
	  kbArchiveHeights();
	} ); 


	//window resize
	$( window ).resize( function() {
	  setSiteHeaderVariables();
	  kbArchiveHeights();
	} );
 

	// Attachments Toggle
	$('.hkb-article-attachments__title').click(function () {
		$(this).parent('.hkb-article-attachments').toggleClass('hkb-article-attachments--active');	  
	});

	function kbArchiveHeights(){
		// archive category height equalling
		if ( $( '.hkb-archive--style1 .hkb-archive--style3 .hkb-archive--style4 .hkb-archive--style5 .hkb-archive--style6' ).length ) {
	 
	    	var maxHeight = -1;

			$('.hkb-archive li').each(function() {
			 maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
			});

			$('.hkb-archive li').each(function() {
			 $('.hkb-archive .hkb-category.hkb-category--hasdesc a').css('min-height', maxHeight);
			});

		}
	}

	// Ensure first item in TOC is always active
	$(document.body).on('ht.nav.process', function(){
		if($('#navtoc li.active').length<1){
			$('#navtoc li').first().addClass('active');
		}
	});


// End Wrapper
} );