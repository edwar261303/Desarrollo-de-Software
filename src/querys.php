<?php
  function cmp_codigo ($alumno1, $alumno2) {          
    return $alumno1[0] <=> $alumno2[0];
  }
  function cmp_nombre ($alumno1, $alumno2) {          
    return $alumno1[1] <=> $alumno2[1];
  }

  function cmp_tutor ($alumno1, $alumno2) {          
    return $alumno1[2] <=> $alumno2[2];
  }

  function alumnos_no_matriculados($alumnos_anterior, $alumnos_actual){
    return array_udiff($alumnos_anterior, $alumnos_actual, 'cmp_codigo');
  }
  function alumnos_sin_tutor($alumnos_anterior, $alumnos_actual) {
    return array_udiff($alumnos_actual, $alumnos_anterior, 'cmp_codigo');
  }
?>