/*----------  AUTO HEIGHT  ----------*/
$(window).on('load resize', function () {
	var proposalHeight = $('.NAME_CLASS_OR_ID_HERE').innerHeight();
	var proposalWidth = $(window).innerWidth();
	// Set height
	if (proposalWidth >= 768) {
		$('.NAME_CLASS_OR_ID_HERE').css('height', proposalHeight + 'px');
	} else {
		$('.NAME_CLASS_OR_ID_HERE').css('height', 'auto');
	}
}).trigger('resize');


/*----------  AUTO HEIGHT  ----------*/
$(window).on('load resize', function () {
	var proposalHeight = 0;
	$('.card').each(function () {
		if ($(this).innerHeight() > proposalHeight) {
			proposalHeight = $(this).innerHeight();
		}
	});
	// Set height
	if ($(document).innerWidth() >= 500) {
		$('.card').css('height', proposalHeight + 'px');
	} else {
		$('.card').css('height', 'auto');
	}
}).trigger('resize');