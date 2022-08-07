<?php
  function startsWith ($string, $startString){
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
  }        
  function cargar_doc1($ruta, $from_row, $from_column) {
    $data = [];
    $file = fopen($ruta, 'r');
    $i = $from_row;
    $idx = 0;
    while (($line = fgetcsv($file)) !== FALSE) {
      if($i-- >= 0) continue;
      if( $line[0] === '' || $line[0] === 'CODIGO' || startsWith($line[0],'Docente')) continue;
      $data[$idx++] = [$line[$from_column], $line[$from_column+1]];
    }
    fclose($file);
    return $data;
  }

  function cargar_doc2($ruta, $from_row, $from_column) {
    $data = [];
    $file = fopen($ruta, 'r');
    $i = $from_row;
    $idx = 0;
    $tutor_actual = '';
    while (($line = fgetcsv($file)) !== FALSE) {
      if($i-- >= 0) continue;
      if( $line[0] === '' || $line[0] === 'CODIGO') continue;
      if(startsWith($line[0],'Docente') ){
        $tutor_actual = $line[1];
      }else {
        $data[$idx++] = [$line[$from_column], $line[$from_column+1], $tutor_actual];
      }
    }
    fclose($file);
    return $data;
  }
?>