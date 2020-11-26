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
  data-time="10-29-2021 15:00:00">
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


<script src="countdown.js"></script>

</body>
</html>
