<?php
  include 'src/main.php';
  include 'src/save.php'
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
              <input type="file" class="form-control" id="file1" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-1' required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <p>Docentes:</p>
              <input type="file" class="form-control" id="file2" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-2' required>
            </div>
            <div class="input-group input-group-sm mb-3">
              <p>Alumnos:</p>
              <input type="file" class="form-control" id="file3" aria-describedby="inputGroupFileAddon03" aria-label="Upload" name='file-3' required>
            </div>

          </fieldset>
          <button type="submit" name="Submit">ACEPTAR</button>
        </form>
      </div>
      <div id="main-right">
        <?php
          if(isset($_POST['Submit'])){
            $archivo1 = $_FILES['file-1'];
            $archivo2 = $_FILES['file-2'];
            $archivo3 = $_FILES['file-3'];

            $data1 = cargar_doc2($archivo1['tmp_name'],5,0);
            $data2 = cargar_doc1($archivo2['tmp_name'],0,1);
            $data3 = cargar_doc1($archivo3['tmp_name'],0,1);
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
                      echo $archivo1['name'];
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
                      if(isset($data1)){
                        mostrar2($data1);
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
                      echo $archivo2['name'];
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
                      if(isset($data2)){
                        usort($data2, "cmp_codigo");
                        mostrar($data2);
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
                      echo $archivo3['name'];
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
                      if (isset($data3)) {
                        usort($data3, "cmp_codigo");
                        mostrar($data3);
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
                      if(isset($data1) && isset($data3) && isset($data2)){
                        $no_matriculados = alumnos_no_matriculados($data1, $data3);
                        $no_matriculados_sin_tutor = [];
                        $i=0;
                        foreach ($no_matriculados as $alumno){
                          $no_matriculados_sin_tutor[$i++] = [$alumno[0], $alumno[1]];
                        }
                        guardar_csv($no_matriculados_sin_tutor, "src/no_matriculados.csv");
                        mostrar($no_matriculados);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <a  href="src/descarga.php?archivo=1">Descargar csv</a>
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
                      if(isset($data1) && isset($data3) && isset($data2)){
                        $nueva_dist = nueva_distribucion($data1, $data3, $data2);
                        guardar_csv($nueva_dist, "src/nueva_distribucion.csv");
                        mostrar2($nueva_dist);
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <a href="src/descarga.php?archivo=2">Descargar csv</a>
              </div>
            </div>

          </div>  
        </div>
        
      </div>
    </main>
  </body>
</html>