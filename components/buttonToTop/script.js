/***********************************************
 * Scroll to top
 ***********************************************/
(function($) {

	'use strict';

	function show_btn() {
		$('.btn-to-top').removeClass('hidden').addClass('visible');
	}

	function hide_btn() {
		$('.btn-to-top').removeClass('visible').addClass('hidden');
	}

	hide_btn();

	throttleScroll(function(type, scroll) {
		var offset = $(window).height() + 100;

		if ( scroll > offset) {
			if (type === 'down') {
				hide_btn();
			} else if (type === 'up') {
				show_btn();
			}
		} else {
			hide_btn();
		}
	});

	$(document).on('click', '.btn-to-top', function(e) {
		e.preventDefault();
		$('html').scrollTo(0, 500);
	});

})(jQuery);