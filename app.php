<?php
  include 'src/main.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SISTEMA DE TUTORIA</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
  </head>
  <body>
    <header>
      <h1>SISTEMA DE TUTORIA UNSSAAC</h1>
    </header>
    <main>
      <div id="main-left">
        <form method="POST" action="app.php" enctype="multipart/form-data" >
          <fieldset id="upload-files">
            <legend>Subir archivos</legend>
            <div class="input-group input-group-sm mb-3">
              <p>Distribucion de tutores:</p>
              <input type="file" class="form-control" id="file1" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-distribucion' required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <p>Docentes tutores:</p>
              <input type="file" class="form-control" id="file2" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-docentes' required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <p>Alumnos matriculados:</p>
              <input type="file" class="form-control" id="file3" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-alumnos' required>
            </div>
          </fieldset>
          <button type="submit" name="Submit">ACEPTAR</button>
        </form>
      </div>
      <div id="main-right">
        <?php
          if(isset($_POST['Submit'])){
            $distribucion = $_FILES['file-distribucion'];
            $lista_docentes = $_FILES['file-docentes'];
            $lista_alumnos = $_FILES['file-alumnos'];

            $distribucion_anterior = cargar_doc($distribucion['tmp_name'],5,0,TRUE);
            $docentes = cargar_doc($lista_docentes['tmp_name'],0,1);
            $alumnos = cargar_doc($lista_alumnos['tmp_name'],0,1);
          }
        ?>
        <div class='row'>
          <div class='col-6 p-3'>
            <ul class="nav nav-tabs pb-3">
              <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#DistTutor">Distribucion de tutores</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#Docentes">Docentes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#Alumnos">Alumnos</a>
              </li>
            </ul>
            <div class='tab-content p-3'>
              <div class='contenedor tab-pane active' id='DistTutor'>
                <h2>
                  <?php
                    if(isset($_POST['Submit'])){
                      echo $distribucion['name'];
                    }else{
                      echo 'TABLA 1';
                    }
                  ?>
                </h2>
                <div id="tabla-1">
                  <table>
                    <thead class='tabla-header'>
                      <tr>
                        <th>Nro</th>
                        <th>Codigo</th>
                        <th>Apellidos y Nombres</th>
                        <th>Tutor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($distribucion_anterior)){
                        mostrar($distribucion_anterior,2);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              
              <div class='contenedor tab-pane fade' id='Docentes'>
                <h2>
                  <?php 
                    if(isset($_POST['Submit'])){
                      echo $lista_docentes['name'];
                    }else{
                      echo 'TABLA 2';
                    }
                  ?>
                </h2>
                <div id="tabla-2">
                  <table>
                    <thead class='tabla-header'>
                      <tr>
                        <th>Nro</th>
                        <th>Nombres</th>
                        <th>Categoria</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($docentes)){
                        usort($docentes, "cmp_codigo");
                        mostrar($docentes,1);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class='contenedor tab-pane fade' id='Alumnos'>
                <h2>
                  <?php 
                    if(isset($_POST['Submit'])){
                      echo $lista_alumnos['name'];
                    }else{
                      echo 'TABLA 3';
                    }
                  ?>
                </h2>
                <div id="tabla-3">
                  <table>
                    <thead class='tabla-header'>
                      <tr>
                        <th>Nro</th>
                        <th>Codigo</th>
                        <th>Apellidos y Nombres</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($alumnos)) {
                        usort($alumnos, "cmp_codigo");
                        mostrar($alumnos,1);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class='col-6 p-3'>
            <ul class="nav nav-tabs pb-3">
              <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#NoMatricula">Alumnos No Matriculados</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#NuevaDistribucion">Nueva Distribucion</a>
              </li>
            </ul>
            <div class='tab-content p-3'>
              <div class='contenedor tab-pane active' id='NoMatricula'>
                <h2>
                  NO MATRICULADOS
                </h2>
                <div id="tabla-4">
                  <table>
                    <thead class='tabla-header'>
                      <tr>
                        <th>Nro</th>
                        <th>Codigo</th>
                        <th>Apellidos y Nombres</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($distribucion_anterior) && isset($alumnos) && isset($docentes)){
                        // $no_matriculados = alumnos_no_matriculados($distribucion_anterior, $alumnos);
                        $no_matriculados = array_udiff($distribucion_anterior, $alumnos, "cmp_codigo");
                        $no_matriculados_sin_tutor = [];
                        $i=0;
                        foreach ($no_matriculados as $alumno){
                          $no_matriculados_sin_tutor[$i++] = [$alumno[0], $alumno[1]];
                        }
                        guardar_csv($no_matriculados_sin_tutor, "src/no_matriculados.csv");
                        mostrar($no_matriculados,1);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <a  href="src/descarga.php?archivo=no_matriculados">Descargar csv</a>
              </div>

              <div class='contenedor tab-pane fade' id='NuevaDistribucion'>
                <h2>
                  NUEVA DISTRIBUCION
                </h2>
                <div id="tabla-5">
                  <table>
                    <thead class='tabla-header'>
                      <tr>
                        <th>Nro</th>
                        <th>Codigo</th>
                        <th>Apellidos y Nombres</th>
                        <th>Tutor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(isset($distribucion_anterior) && isset($alumnos) && isset($docentes)){
                        $nueva_dist = nueva_distribucion($distribucion_anterior, $alumnos, $docentes);
                        usort($nueva_dist, "cmp_codigo");
                        guardar_csv($nueva_dist, "src/nueva_distribucion.csv");
                        mostrar($nueva_dist,2);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <a href="src/descarga.php?archivo=nueva_distribucion">Descargar csv</a>
              </div>
            </div>
          </div>  
        </div>        
      </div>
    </main>
  </body>
</html>