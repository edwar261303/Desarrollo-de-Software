<?php
  if($_GET['archivo'] === 'no_matriculados'){
    header("Content-disposition: attachment; filename=no_matriculados.csv");
    header("Content-type: text/plain");
    readfile("no_matriculados.csv");
  }
  if($_GET['archivo'] === 'nueva_distribucion'){
    header("Content-disposition: attachment; filename=nueva_distribucion.csv");
    header("Content-type: text/plain");
    readfile("nueva_distribucion.csv");
  }
?>