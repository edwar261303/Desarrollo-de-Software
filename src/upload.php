<?php
  // funcion que evalua si una cadena empieza con otra cadena dada
  function startsWith ($string, $startString){
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
  }        
  
  // funcion que abre un archivo y lo lee desde la fila y columna indicadas
  // el parametro es_distribucion indica un tratamiento especial para este
  // documento, por lo que debe ser true solo si se lee el archivo de distribucion
  function cargar_doc($ruta, $from_row, $from_column, $es_distribucion=FALSE) {
    $datos = [];
    $file = fopen($ruta, 'r');
    $i = $from_row;
    $idx = 0;
    $tutor_actual = '';
    while (($line = fgetcsv($file)) !== FALSE) {
      if($i-- >= 0) continue;
      if($es_distribucion){
        if( $line[0] === '' || $line[0] === 'CODIGO') continue;
        if(startsWith($line[0],'Docente') ){
          $tutor_actual = $line[1];
        }else {
          $datos[$idx++] = [$line[$from_column], $line[$from_column+1], $tutor_actual];
        }
      }else{
        if( $line[0] === '' || $line[0] === 'CODIGO' || startsWith($line[0],'Docente')) continue;
        $datos[$idx++] = [$line[$from_column], $line[$from_column+1]];
      }
    }
    fclose($file);
    return $datos;
  }
?>
