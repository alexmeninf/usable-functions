<div class="parallax-box">
		<div class="parallax-image" style="background-image: url('http://via.placeholder.com/1920x600')"></div>

      <div class="post-overlay-inner">
        <h1 class="post-title"><?php the_title() ?></h1>				
    </div>
	</div>
  
  
  <style>
  .parallax-box {
    width: 100%;
    position: relative;
    height: 460px;
    overflow: hidden;
    top: 0;
  }
  
  .parallax-image {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    position: relative;
    width: 100%;
    height: 760px;
    border-radius: 3px;
    min-height: 660px;
    margin-top: -150px;
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
  }
</style>
  
  
  <script>
var makeParallax = function () {
	var scrollTop = $(this).scrollTop();
	if (scrollTop < 400)
		$('.parallax-box .parallax-image').css({
			'transform': 'translate3d(0px, ' + (scrollTop / 2) + 'px, 0px)'
		});

	var opacity = 1,
		filter = 0;
	if (scrollTop > 10 && scrollTop < 50) {
		opacity = 0.9;
	} else if (scrollTop >= 50 && scrollTop < 100) {
		opacity = 0.8;
	} else if (scrollTop >= 100 && scrollTop < 150) {
		opacity = 0.7;
	} else if (scrollTop >= 150 && scrollTop < 200) {
		opacity = 0.6;
		filter = 3;
	} else if (scrollTop >= 200 && scrollTop < 250) {
		opacity = 0.5;
		filter = 5;
	} else if (scrollTop >= 250 && scrollTop < 300) {
		opacity = 0.4;
		filter = 8;
	} else if (scrollTop >= 300 && scrollTop < 350) {
		opacity = 0.3;
		filter = 12;
	} else if (scrollTop >= 350 && scrollTop < 400) {
		opacity = 0.2;
		filter = 16;
	} else if (scrollTop >= 400) {
		opacity = 0;
		filter = 24;
	}

	$('.parallax-box .post-overlay-inner').css({
		'opacity': opacity
	});

	$('.parallax-box .parallax-image').css({
		'filter': 'blur(' + filter + 'px)',
	});
}

</script>
