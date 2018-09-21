$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
		$('.navbar-profile').toggle();
		$('#main-menu ul li').toggle();
		if($('body').hasClass('open')){
			$('.right-panel').css("width","calc(100vw - 90px)");
			$('.right-panel-l').css("width","calc(100vw - 95px)");
			$('.navbar .navbar-brand img').css("padding-bottom","25px");
			$('.navbar-lec').hide();
		} else {
			$('.right-panel').css("width","calc(100vw - 420px)");
			$('.right-panel-l').css("width","calc(100vw - 300px)");
			$('.navbar .navbar-brand img').css("padding-bottom","15px");
			$('.navbar-lec').show();
		}
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});
});