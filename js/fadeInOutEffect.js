  function getReduction($distance, $percentage) {
    let $returnValue = $distance - (($distance * $percentage) / 100);

    $returnValue = $distance <= $(window).innerHeight() ? $returnValue : $distance - $returnValue;

    return $returnValue;
  }

  function hasTransition(item) {
    setTimeout(() => {
      item.css({
        transition: '.3s all'
      });
    }, 500);
  }

  checkDistance = (scrollMove, distance, itemAnimate) => {
    let scroll = scrollMove.scrollTop();

    if (distance <= $(window).innerHeight()) {
      if (scroll <= getReduction(distance, 100)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(0)',
          opacity: 1
        });
      } else if (scroll <= getReduction(distance, 80)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(20px)',
          opacity: .85
        });
      } else if (scroll <= getReduction(distance, 60)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(40px)',
          opacity: .65
        });
      } else if (scroll <= getReduction(distance, 40)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(60px)',
          opacity: .45
        });
      } else if (scroll <= getReduction(distance, 20)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(80px)',
          opacity: .25
        });
      } else {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(100px)',
          opacity: 0
        });
      }
    } else {
      if (scroll >= 0 && scroll <= getReduction(distance, 20)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(0)',
          opacity: 1
        });
      } else if (scroll > getReduction(distance, 20) && scroll <= getReduction(distance, 40)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(20px)',
          opacity: .85
        });
      } else if (scroll > getReduction(distance, 40) && scroll <= getReduction(distance, 60)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(40px)',
          opacity: .65
        });
      } else if (scroll > getReduction(distance, 60) && scroll <= getReduction(distance, 80)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(60px)',
          opacity: .45
        });
      } else if (scroll > getReduction(distance, 80) && scroll <= getReduction(distance, 100)) {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(80px)',
          opacity: .25
        });
      } else {
        hasTransition(itemAnimate);
        itemAnimate.css({
          transform: 'translateY(100px)',
          opacity: 0
        });
      }
    }
  }

  mainCallback = () => {
    let element = $('.offset-top'),
      scroll;

    element.each(function () {
      let distance = $(this).offset().top,
        itemAnimate = $(this);

      distance = distance < $(window).innerHeight() ? distance + ($(this).innerHeight() * 1.5) : distance;

      $(window).scroll(function () {
        scroll = $(this);
        checkDistance(scroll, distance, itemAnimate);
      });
    });
  }
