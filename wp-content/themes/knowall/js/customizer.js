( function( $ ) {
    'use strict';

    var headerBgGradientAngle = htHeaderBgSettings.bgGradientAngle;
    var headerColor1 = htHeaderBgSettings.bgGradient1;
    var headerColor2 = htHeaderBgSettings.bgGradient2;

    var siteBgGradientAngle = htBodyBgSettings.bgGradientAngle;
    var siteColor1 = htBodyBgSettings.bgGradient1;
    var siteColor2 = htBodyBgSettings.bgGradient2;

    /**
    * Header Background Gradient 
    */
    wp.customize( 'ht_setting__headerbggrad_color1', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            headerColor1=newval;
            //recalc background gradient
            recalcHeaderBackgroundGradient();
        } );
    } );

    wp.customize( 'ht_setting__headerbggrad_color2', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            headerColor2=newval;
            //recalc background gradient
            recalcHeaderBackgroundGradient();
        } );
    } );

    wp.customize( 'ht_setting__headerbggrad_angle', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            headerBgGradientAngle=newval;
            //recalc background gradient
            recalcHeaderBackgroundGradient();
        } );
    } );


    function recalcHeaderBackgroundGradient(){
        $('.site-header').css('background', 'linear-gradient('+headerBgGradientAngle+'deg,'+headerColor1+' 0%,'+headerColor2+' 100%)' );
    }


    /**
    * Body / Site Background Gradient 
    */
    wp.customize( 'ht_setting__sitebggrad_color1', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            siteColor1=newval;
            //recalc background gradient
            recalcSiteBackgroundGradient();
        } );
    } );

    wp.customize( 'ht_setting__sitebggrad_color2', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            siteColor2=newval;
            //recalc background gradient
            recalcSiteBackgroundGradient();
        } );
    } );

    wp.customize( 'ht_setting__sitebggrad_angle', function( value ) {
        value.bind( function( newval ) {
            //set global bgGradient1
            siteBgGradientAngle=newval;
            //recalc background gradient
            recalcSiteBackgroundGradient();
        } );
    } );



    function recalcSiteBackgroundGradient(){
        $('body').css('background', 'linear-gradient('+siteBgGradientAngle+'deg,'+siteColor1+' 0%,'+siteColor2+' 100%)' );
    }

    wp.customize.bind( 'ready', function(){
        wp.customize( 'knowall_blog_support', function( value ) {
            showOrHideStaticPageSettings();
            value.bind( function( newval ) {
                wp.customize.previewer.refresh();
                showOrHideStaticPageSettings();
            } );
        } ); 

        wp.customize( 'show_on_front', function( value ) {
            //call initially when show on front setting enabled
            showOrHideStaticPageSettings();
        } );        

    });


    function showOrHideStaticPageSettings(){
        var blogSupport = wp.customize('knowall_blog_support')();
        if('enable'==blogSupport){
            wp.customize.control('show_on_front').container.slideDown();
            wp.customize.control('page_on_front').container.slideDown();
            wp.customize.control('page_for_posts').container.slideDown();           
        } else {
            wp.customize.control('show_on_front').container.slideUp();
            wp.customize.control('page_on_front').container.slideUp();
            wp.customize.control('page_for_posts').container.slideUp();
        }
    }
    
} )( jQuery );