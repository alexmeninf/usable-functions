<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    .btn {
      display: inline-block;
      padding: 20px 10px;
      border-radius: 12px;
      color:#fff;
      background-color: #222;
      text-decoration: none;
    }
  </style>
</head>
<body>
  
<!--- mes-dia-ano hora:min:seg --->
<div class="countdown spacing-section" 
  data-time="10-29-2020 15:00:00">
  <a href="" class="btn count-btn">
    <span class="countdown-row">
      <span class="years"></span>
      <span class="days"></span>
      <span class="hours"></span>
      <span class="min"></span>
      <span class="sec"></span>
    </span><!-- /.countdown-row -->
  </a>
  <div class="info"></div>
</div><!-- /.countdown	 -->


<script src="jquery.js"></script>
<script src="countdown.js"></script>
<script>  
  function iOSDevice() {
    const isIOS = /Mac|iPad|iPhone|iPod/.test(navigator.userAgent);
    const isMacOS = navigator.platform.indexOf('Mac') != -1;
    const isSafari = navigator.platform.indexOf('Safari') != -1;

    if (isIOS || isMacOS || isSafari) {
      return true;
    }

    return false;
  }
	jQuery(function(){
    /*----------  Countdown  ----------*/
    $('.countdown').each(function () {
      var element = $(this);
      var endDate = $(this).attr('data-time');

      if (iOSDevice()) {
        var dateParts = endDate.substring(0,10).split('-');
        var timePart = endDate.substr(11);
        endDate = dateParts[2] + '/' + dateParts[0] + '/' + dateParts[1] + ' ' + timePart;

        $(this).attr('data-time', endDate);
      }

      element.countdown({
        date: endDate,
        render: function (data) {
          if (this.leadingZeros(data.days, 2) == "00" &&
            this.leadingZeros(data.hours, 2) == "00" &&
            this.leadingZeros(data.min, 2) == "00" &&
            this.leadingZeros(data.sec, 2) == "00") {
            $('.info').html(`<a href="" target="_blank" rel="noopener" class="btn">QUERO ME CADASTRAR</a>`);
            $('.count-btn').hide();
          } else {
            let txt;

            if (this.leadingZeros(data.years, 2) > "00") {              
              if (this.leadingZeros(data.years, 2) > "01") {
                txt = 'Anos';
              } else {
                txt = 'Ano';
              }
              
              $(' .years', this.el).html(`
                  <span class="countdown-section">
                      <span class="countdown-amount">${this.leadingZeros(data.years, 2)}</span>
                      <span class="countdown-period">${txt}</span>
                  </span>`);
            }

            if (this.leadingZeros(data.days, 2) > "00") {
              if (this.leadingZeros(data.days, 2) > "01") {
                txt = 'dias, ';
              } else {
                txt = 'dia, ';
              }

              $(' .days', this.el).html(`
                  <span class="countdown-section">
                      <span class="countdown-amount">${this.leadingZeros(data.days, 2)}</span>
                      <span class="countdown-period">${txt}</span>
                  </span>`);
            }

            if (this.leadingZeros(data.hours, 2) > "00") {
              if (this.leadingZeros(data.hours, 2) > "01") {
                txt = 'h :';
              } else {
                txt = 'h :';
              }

              $(' .hours', this.el).html(`
                  <span class="countdown-section">
                      <span class="countdown-amount">${this.leadingZeros(data.hours, 2)}</span>
                      <span class="countdown-period">${txt}</span>
                  </span>`);
            }

            if (this.leadingZeros(data.min, 2) > "00") {
              if (this.leadingZeros(data.min, 2) > "01") {
                txt = 'm :';
              } else {
                txt = 'm :';
              }

              $(' .min', this.el).html(`
                  <span class="countdown-section">
                      <span class="countdown-amount">${this.leadingZeros(data.min, 2)}</span>
                      <span class="countdown-period">${txt}</span>
                  </span>`);
            }

            if (this.leadingZeros(data.sec, 2) > "00") {
              if (this.leadingZeros(data.sec, 2) > "01") {
                txt = 's';
              } else {
                txt = 's';
              }

              $(' .sec', this.el).html(`
                  <span class="countdown-section">
                      <span class="countdown-amount">${this.leadingZeros(data.sec, 2)}</span>
                      <span class="countdown-period">${txt}</span>
                  </span>`);
            }
          }
        }
      });
    });
	})
</script>




</body>
</html>