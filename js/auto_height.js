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
