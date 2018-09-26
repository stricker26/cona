$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;

	//itu iyun sandi
	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
		$('.navbar-profile').toggle();
		$('#main-menu ul li').toggle();
		if($('body').hasClass('open')){
			$('.right-panel').css("width","calc(100vw - 90px)");
			$('.navbar .navbar-brand img').css("padding-bottom","25px");
			$('aside.left-panel #main-menu a span').hide();
			$('.navbar-lec').hide();
		} else {
			$('.right-panel').css("width","calc(100vw - 420px)");
			$('.navbar .navbar-brand img').css("padding-bottom","15px");
			$('aside.left-panel #main-menu a span').show();
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