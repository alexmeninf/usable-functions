<?php
session_start();

$file                       = isset($_GET['file']) && trim($_GET['file']) !== '' ? $_GET['file'] : null;
$file_dir                   = $file;
$files_exists               = true;
$delete_file_after_download = false;

if (!isset(parse_url($file)['host'])) {
  $file_dir                   = __DIR__ . '/' . $file;
  $files_exists               = file_exists($file_dir);
  $delete_file_after_download = (bool)isset($_GET['delete_file_after_download']) && trim($_GET['delete_file_after_download']) !== '' ? $_GET['delete_file_after_download'] : false;
}

if (!$file || !$files_exists) {
  header("Location: ./");
  exit;
}

// Limite de downloads (-1 ilimitado)
$limit = -1;

// Ou habilitar obter limite pela url
define('ENABLE_LIMIT_URL', true);

if (isset($_GET['limit']) && ENABLE_LIMIT_URL) {
  $download_limit = abs(intval($_GET['limit']));

  if ($download_limit > 10)
    $download_limit = 10;
} else {
  $download_limit = $limit;
}

if ($download_limit !== -1) {
  $exceeded_download_limit = isset($_SESSION['limit']) && intval($_SESSION['limit']) >= $download_limit;

  if (isset($_SESSION['last_download_time']) && $exceeded_download_limit) {
    $tempo_limite           = 180; // 3 minutos em segundos
    $tempo_atual            = time();
    $tempo_ultima_tentativa = intval($_SESSION['last_download_time']);

    if (($tempo_atual - $tempo_ultima_tentativa) < $tempo_limite) {
      $tempo_restante = $tempo_limite - ($tempo_atual - $tempo_ultima_tentativa);

      $time_left_h = gmdate("H", $tempo_restante);
      $time_left_m = gmdate("i", $tempo_restante);
      $time_left_s = gmdate("s", $tempo_restante);
      $time = 0;

      if (intval($time_left_h) == 0) {
        if (intval($time_left_m) !== 0) {
          $time = $time_left_m . " minuto(s)";
        } elseif (intval($time_left_m) == 0) {
          $time = $time_left_s . " segundo(s)";
        }
      }

      echo "Você deve aguardar " . $time . " antes de baixar o arquivo novamente.";
      exit;
    }
  }

  if (!$exceeded_download_limit) {
    $_SESSION['limit']++;
  } else {
    $_SESSION['limit'] = 1;
  }

  $_SESSION['last_download_time'] = time();
}

header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_dir) . "\"");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Lê e envia o arquivo para o cliente
readfile($file_dir);

// Deleta o arquivo após o download
if ($delete_file_after_download)
  unlink($file_dir);

exit;
