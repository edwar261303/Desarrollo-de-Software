<?php
  function guardar_csv($list, $ruta){
    $fp = fopen($ruta, 'w');
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
  }
  // header('Location: app.php ? estado=1');
  // exit();
?>

