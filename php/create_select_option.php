<?php

// Crie cada opção por linha, na seguinte sequencia: valor | Rotulo | atributos
$subject = ':Selecione uma opção:disabled selected
valor1:Exemplo 1
valor2:Exemplo 2
valor3:Exemplo 3
valor4:Exemplo 4:disabled';
  
 // remover mais de dois espaços vazios
$options = preg_replace('/(\s)+/s', '\\1', $subject);

// Obter cada linha
$options = preg_split('/\r\n|\r|\n|\s{2,}/', $options);

// Remove espaços em branco
$options = preg_replace('/\n/', '', $options);

// Fiiltrar linhas vazias
$options = array_filter($options, function($a) {return $a !== "";});

echo '<select>';
foreach ($options as $values) {

  // Separar cada campo da opção
  $args = preg_split('/\:/', $values);
  // Atributos
  $attr = array_key_exists(2, $args) ? $args[2] : '';
  
  echo '<option value="' . trim($args[0]) . '" ' . $attr . '>' . trim($args[1]) . '</option>';
}
echo '</select>';
