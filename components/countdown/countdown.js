(function () {
  const second = 1000,
    minute     = second * 60,
    hour       = minute * 60,
    day        = hour * 24;

  setInterval(function () {
    $(".countdown").each(function () {
      let time = $(this).data("time");

      if (is_apple()) {
        var dateParts = time.substring(0, 10).split("-");
        var timePart = time.substr(11);
        time =
          dateParts[0] + "/" +
          dateParts[1] + "/" +
          dateParts[2] + " " +
          timePart; // Y/m/d

        $(this).attr("data-time", time);
      }

      let countDown = new Date(time).getTime(),
        now = new Date().getTime(),
        distance = countDown - now;

      let days = Math.floor(distance / day),
        hours = Math.floor((distance % day) / hour),
        minutes = Math.floor((distance % hour) / minute),
        seconds = Math.floor((distance % minute) / second);

      if (days > 0) {
        $(".countdown-days", $(this)).show();
        $(".countdown-days", $(this)).html( '<span class="value">' + days + '</span>' + '<span class="text">' + (days == 1 ? " dia" : " dias") + '</span>');
      } else {
        $(".countdown-days", $(this)).hide();
      }

      if (hours != -1) {
        $(".countdown-hours", $(this)).show();
        $(".countdown-hours", $(this)).html( '<span class="value">' + hours + '</span>' + '<span class="text">' + (hours == 1 ? " hora" : " horas") + '</span>');
      } else {
        $(".countdown-hours", $(this)).hide();
      }

      if (minutes != -1) {
        $(".countdown-minutes", $(this)).show();
        $(".countdown-minutes", $(this)).html( '<span class="value">' + minutes + '</span>' + '<span class="text">' + (minutes == 1 ? " minuto" : " minutos") + '</span>');
      } else {
        $(".countdown-minutes", $(this)).hide();
      }

      if (seconds != -1) {
        $(".countdown-seconds", $(this)).show();
        $(".countdown-seconds", $(this)).html( '<span class="value">' + seconds + '</span>' + '<span class="text">' + (seconds == 1 ? " segundo" : " segundos") + '</span>');
      } else {
        $(".countdown-seconds", $(this)).hide();
      }

      // do something later when date is reached
      if (distance < 0) {
        let information = $(".countdown-info", $(this)),
          timer = $(".timer", $(this));

        information.html($(this).data("text"));
        timer.hide();
      }
    });
  }, 0);
})();
