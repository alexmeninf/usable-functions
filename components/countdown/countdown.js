(function () {
  const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

  let birthday = $('#countdown').data('time'),
      countDown = new Date(birthday).getTime(),
      x = setInterval(function() { 

        let now = new Date().getTime(),
            distance = countDown - now;

        document.getElementById("countdown-days").innerText = Math.floor(distance / (day)) + " dias",
        document.getElementById("countdown-hours").innerText = Math.floor((distance % (day)) / (hour)) + " h",
        document.getElementById("countdown-minutes").innerText = Math.floor((distance % (hour)) / (minute)) + " min",
        document.getElementById("countdown-seconds").innerText = Math.floor((distance % (minute)) / second) + " seg";

        // do something later when date is reached
        if (distance < 0) {
          let information = document.getElementById("countdown-info"),
              countdown = document.getElementById("timer");

          information.innerText =  $('#countdown').data('text');
          countdown.style.display = "none";

          clearInterval(x);
        }
        //seconds
      }, 0)
  }());
