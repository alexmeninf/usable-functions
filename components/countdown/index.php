<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contador</title>
</head>
<body>

  <!--
    data-time : Sequencia da data: Y-m-d h:m:s
    data-text : Mensagem exibida no fim do contador
   -->
  <div class="countdown" 
  data-time="2021-01-07 22:22:30" 
  data-text="Tempo esgotado!">
    <div class="timer">
      <span class="countdown-days"></span>
      <span class="countdown-hours"></span>
      <span class="countdown-minutes"></span>
      <span class="countdown-seconds"></span>
    </div>
    <div class="countdown-info"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
  <script src='countdown.js'></script>  
</body>
</html>
