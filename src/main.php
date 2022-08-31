<?php
  include 'upload.php';

  // Funciones para comparar
  function cmp_codigo ($alumno1, $alumno2) {return $alumno1[0] <=> $alumno2[0];}
  function cmp_nombre ($alumno1, $alumno2) {return $alumno1[1] <=> $alumno2[1];}
  function cmp_tutor ($alumno1, $alumno2) {return $alumno1[2] <=> $alumno2[2];}

  // funcion para guardar en formato csv una lista
  function guardar_csv($list, $ruta){
    $fp = fopen($ruta, 'w');
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
  }

  // muestra en pantalla la lista que se le pase hasta un limite de columnas
  function mostrar($lista, $limite){
    $idx = 1;
    foreach($lista as $alumno){
      echo '<tr>';
      echo '<td>'.$idx++.'</td>';
      for($i = 0; $i <= $limite; $i++) echo '<td>'.$alumno[$i].'</td>';
      echo '</tr>';
    }
  }

  // Calcula que alumnos matriculados no tienen asignado un tutor
  // devuelve una lista con las columnas [codigo, alumno]
  function alumnos_sin_tutor($alumnos_con_tutor, $alumnos_matriculados){
    $data_aux = [];
    $idx = 0;
    foreach($alumnos_con_tutor as $alumno_con_tutor){
      $data_aux[$idx++] = [$alumno_con_tutor[0], $alumno_con_tutor[1]];
    }
    $sin_tutor = array_udiff($alumnos_matriculados,$data_aux, 'cmp_codigo');    
    usort($sin_tutor,"cmp_codigo");
    return ($sin_tutor);
  }

  // devuelve los 2 primeros digitos del codigo
  function get_codigo($codigo_alumno){
    if(strlen($codigo_alumno)===6){
      return substr($codigo_alumno, 0, 2);
    }else if (strlen($codigo_alumno)===5){
      return "0"+ $codigo_alumno[0];
    }else{
      return "00";
    }
  }
  
  // funcion que realiza la nueva distribucion respetando las restricciones de distribucion balanceada
  // , no mas de 3 alumnos del mismo codigo por tutor y que tengan alumnos nuevos y antiguos.
  function nueva_distribucion($distribucion_anterior, $alumnos_matriculados, $docentes_tutores){
    $alumnos_sin_tutor = alumnos_sin_tutor($distribucion_anterior, $alumnos_matriculados);
    $promedio_alumnos = (integer) ceil((count($alumnos_matriculados))/ count($docentes_tutores));
    $alumnos_no_matriculados = array_udiff($distribucion_anterior, $alumnos_matriculados, "cmp_codigo");
    $nueva_distribucion = array_udiff($distribucion_anterior, $alumnos_no_matriculados, "cmp_codigo");
    
    $alumnos_por_tutor = [];
    $i = 0;
    foreach($nueva_distribucion as $alumno){
      if(array_key_exists($alumno[2],$alumnos_por_tutor)){
        $alumnos_por_tutor[$alumno[2]]+=1;
      }else {
        $alumnos_por_tutor[$alumno[2]]=1;
      }
    }
    foreach($alumnos_sin_tutor as $alumno_sin_tutor) {
      $codigo1 = get_codigo($alumno_sin_tutor[0]);
      foreach($alumnos_por_tutor as $tutor => $cant){
        $asignado = FALSE;
        if($cant < $promedio_alumnos){
          $cont_codigos = 0;
          foreach($nueva_distribucion as $datos){
            if($datos[2] === $tutor){
              if(get_codigo($datos[0])===$codigo1) $cont_codigos += 1;
            }
          }
          if($cont_codigos < 3) {
            $asignado = TRUE;
            $alumnos_por_tutor[$tutor]+=1;
            array_push($nueva_distribucion, [$alumno_sin_tutor[0], $alumno_sin_tutor[1], $tutor]);
            if($asignado){
              break;
            }
          }
        }
      }
    }    
    usort($nueva_distribucion, "cmp_tutor");
    return $nueva_distribucion;
  }
?>