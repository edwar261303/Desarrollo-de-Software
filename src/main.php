<?php
  include 'upload.php';
  include 'querys.php';

  function separar_tabla_2_Col($data) {
    $i = 1;
    foreach($data as $alumno){
      echo '<tr>';
      echo '<td>'.$i++.'</td>';
      echo '<td>'.$alumno[0].'</td>';
      echo '<td>'.$alumno[1].'</td>';
      echo '</tr>';
    }
  }

  function separar_tabla_3_Col($data) {
    $i = 1;
    foreach($data as $alumno){
      echo '<tr>';
      echo '<td>'.$i++.'</td>';
      echo '<td>'.$alumno[0].'</td>';
      echo '<td>'.$alumno[1].'</td>';
      echo '<td>'.$alumno[2].'</td>';
      echo '</tr>';
    }
  }

  function Alumnos_Sin_Tutor2($data1, $data3){
    $data_aux = [];
    $idx = 0;
    foreach($data1 as $alumno_con_tutor){
      $data_aux[$idx++] = [$alumno_con_tutor[0], $alumno_con_tutor[1]];
    }
    $data_nt = alumnos_sin_tutor($data_aux, $data3);
    usort($data_nt,"cmp_codigo");
    return ($data_nt);
  }

  function get_codigo($codigo_alumno){
    if(strlen($codigo_alumno)===6){
      return substr($codigo_alumno, 0, 2);
    }else{
      return "00";
    }
  }
  
  function nueva_distribucion($data1, $data3, $data2){
    $dataAST = Alumnos_Sin_Tutor2($data1, $data3);
    $promedio_alumnos = (integer) ceil((count($data3))/ count($data2));
    $nueva_dist = array_uintersect($data1, $data3, "cmp_codigo");

    $alumnos_no_matriculados = array_udiff($data1, $data3, "cmp_codigo");
    $nueva_dist = array_udiff($data1, $alumnos_no_matriculados, "cmp_codigo");
    
    $alumnosXtutor = [];
    $i = 0;
    foreach($nueva_dist as $alumno){
      if(array_key_exists($alumno[2],$alumnosXtutor)){
        $alumnosXtutor[$alumno[2]]+=1;
      }else {
        $alumnosXtutor[$alumno[2]]=1;
      }
    }
    foreach($dataAST as $alumno_sin_tutor) {
      $codigo1 = get_codigo($alumno_sin_tutor[0]);
      foreach($alumnosXtutor as $tutor => $cant){
        $asignado = FALSE;
        if($cant < $promedio_alumnos){
          $cont_codigos = 0;
          foreach($nueva_dist as $datos){
            if($datos[2] === $tutor){
              if(get_codigo($datos[0])===$codigo1) $cont_codigos += 1;
            }
          }
          if($cont_codigos < 3) {
            $asignado = TRUE;
            $alumnosXtutor[$tutor]+=1;
            array_push($nueva_dist, [$alumno_sin_tutor[0], $alumno_sin_tutor[1], $tutor]);
            if($asignado){
              break;
            }
          }
        }
      }
    }    
    usort($nueva_dist, "cmp_tutor");
    return $nueva_dist;
  }
?>