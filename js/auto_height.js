/*----------  AUTO HEIGHT  ----------*/
autoHeightElements = () => {
	$(window).on('load resize', function () {
		let proposalHeight = 0,
				selectorItem = 'add your class or id';
		$(selectorItem).each(function () {
			if ($(this).innerHeight() > proposalHeight) {
				proposalHeight = $(this).innerHeight();
			}
		});
		// Set height
		if ($(document).innerWidth() >= BREAKPOINT_HERE) {
			$(selectorItem).css('height', proposalHeight + 'px');
		} else {
			$(selectorItem).css('height', 'auto');
		}
	}).trigger('resize');
}
