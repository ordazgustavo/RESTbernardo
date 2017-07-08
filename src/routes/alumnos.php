<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
   return $response;
});
$app->add(function ($req, $res, $next) {
   $response = $next($req, $res);
   return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Obtener todos los Alumnos
$app->get('/api/alumnos', function(Request $request, Response $response) {
  $sql = "SELECT * FROM ALUMNOS";

  try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($customers);
  } catch (PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

// Obtener un solo Alumno
$app->get('/api/alumnos/{cedula_escolar}', function(Request $request, Response $response){
   $cedula_escolar = $request->getAttribute('cedula_escolar');

   $sql = "SELECT * FROM ALUMNOS WHERE cedula_escolar = $cedula_escolar";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $customer = $stmt->fetch(PDO::FETCH_OBJ);
      $db = null;
      echo json_encode($customer);
   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Agregar Alumno
$app->post('/api/alumnos/agregar', function(Request $request, Response $response){
   $cedula_escolar = $request->getParam('cedula_escolar');
   $nombre = $request->getParam('nombre');
   $apellido = $request->getParam('apellido');
   $l_nacimiento = $request->getParam('l_nacimiento');
   $f_nacimiento = $request->getParam('f_nacimiento');
   $edad = $request->getParam('edad');
   $sexo = $request->getParam('sexo');
   $procedencia = $request->getParam('procedencia');
   $habitacion = $request->getParam('habitacion');
   $grado = $request->getParam('grado');
   $seccion = $request->getParam('seccion');

   $sql = "INSERT INTO ALUMNOS (cedula_escolar, nombre, apellido, l_nacimiento, f_nacimiento, edad, sexo, procedencia, habitacion, grado, seccion) VALUES (:cedula_escolar, :nombre, :apellido, :l_nacimiento, :f_nacimiento, :edad, :sexo, :procedencia, :habitacion, :grado, :seccion)";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':cedula_escolar', $cedula_escolar);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':l_nacimiento', $l_nacimiento);
      $stmt->bindParam(':f_nacimiento', $f_nacimiento);
      $stmt->bindParam(':edad', $edad);
      $stmt->bindParam(':sexo', $sexo);
      $stmt->bindParam(':procedencia', $procedencia);
      $stmt->bindParam(':habitacion', $habitacion);
      $stmt->bindParam(':grado', $grado);
      $stmt->bindParam(':seccion', $seccion);

      $stmt->execute();

      echo '{"notice": {"text": Alumno Agregado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Actualizar ALumno
$app->put('/api/alumnos/editar/{cedula_escolar}', function(Request $request, Response $response){
  $cedula_escolar = $request->getParam('cedula_escolar');
  $nombre = $request->getParam('nombre');
  $apellido = $request->getParam('apellido');
  $l_nacimiento = $request->getParam('l_nacimiento');
  $f_nacimiento = $request->getParam('f_nacimiento');
  $edad = $request->getParam('edad');
  $sexo = $request->getParam('sexo');
  $procedencia = $request->getParam('procedencia');
  $habitacion = $request->getParam('habitacion');
  $grado = $request->getParam('grado');
  $seccion = $request->getParam('seccion');

  $sql = "UPDATE ALUMNOS SET
            nombre = :nombre,
            apellido = :apellido,
            l_nacimiento = :l_nacimiento,
            f_nacimiento = :f_nacimiento,
            edad = :edad,
            sexo = :sexo
            procedencia = :procedencia
            habitacion = :habitacion
            grado = :grado
            seccion = :seccion
         WHERE cedula_escolar = $cedula_escolar";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':cedula_escolar', $cedula_escolar);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':l_nacimiento', $l_nacimiento);
      $stmt->bindParam(':f_nacimiento', $f_nacimiento);
      $stmt->bindParam(':edad', $edad);
      $stmt->bindParam(':sexo', $sexo);
      $stmt->bindParam(':procedencia', $procedencia);
      $stmt->bindParam(':habitacion', $habitacion);
      $stmt->bindParam(':grado', $grado);
      $stmt->bindParam(':seccion', $seccion);

      $stmt->execute();

      echo '{"notice": {"text": Alumno Editado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Eliminar Alumno
$app->delete('/api/alumnos/eliminar/{cedula_escolar}', function(Request $request, Response $response){
   $cedula_escolar = $request->getAttribute('cedula_escolar');

   $sql = "DELETE FROM ALUMNOS WHERE cedula_escolar = $cedula_escolar";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;

      echo '{"notice": {"text": Alumno Eliminado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});



// MADRES

// Obtener todos las Madres
$app->get('/api/madres', function(Request $request, Response $response) {
  $sql = "SELECT * FROM MADRES";

  try {
     // Get DB Object
     $db = new db();
     // Connect
     $db = $db->connect();

     $stmt = $db->query($sql);
     $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
     $db = null;
     echo json_encode($customers);
  } catch (PDOException $e) {
     echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

// Obtener una sola Madre
$app->get('/api/madres/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "SELECT * FROM MADRES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $customer = $stmt->fetch(PDO::FETCH_OBJ);
      $db = null;
      echo json_encode($customer);
   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Actualizar ALumno
$app->put('/api/madres/editar/{cedula}', function(Request $request, Response $response){
  $cedula = $request->getParam('cedula');
  $nombre = $request->getParam('nombre');
  $apellido = $request->getParam('apellido');
  $nacionalidad = $request->getParam('nacionalidad');
  $estado_civil = $request->getParam('estado_civil');
  $instruccion = $request->getParam('instruccion');
  $profesion = $request->getParam('profesion');
  $trabaja = $request->getParam('trabaja');
  $l_trabajo = $request->getParam('l_trabajo');
  $d_trabajo = $request->getParam('d_trabajo');
  $tlf_trabajo = $request->getParam('tlf_trabajo');
  $tlf_habitacion = $request->getParam('tlf_habitacion');
  $tlf_movil = $request->getParam('tlf_movil');
  $otros_alumnos = $request->getParam('otros_alumnos');
  $cantidad = $request->getParam('cantidad');
  $grados = $request->getParam('grados');

  $sql = "UPDATE MADRES SET
            nombre = :nombre,
            apellido = :apellido,
            nacionalidad = :nacionalidad,
            estado_civil = :estado_civil,
            instruccion = :instruccion,
            profesion = :profesion
            trabaja = :trabaja
            l_trabajo = :l_trabajo
            d_trabajo = :d_trabajo
            tlf_trabajo = :tlf_trabajo
            tlf_habitacion = :tlf_habitacion
            tlf_movil = :tlf_movil
            otros_alumnos = :otros_alumnos
            cantidad = :cantidad
            grados = :grados
         WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':cedula', $cedula);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':nacionalidad', $nacionalidad);
      $stmt->bindParam(':estado_civil', $estado_civil);
      $stmt->bindParam(':instruccion', $instruccion);
      $stmt->bindParam(':profesion', $profesion);
      $stmt->bindParam(':trabaja', $trabaja);
      $stmt->bindParam(':l_trabajo', $l_trabajo);
      $stmt->bindParam(':d_trabajo', $d_trabajo);
      $stmt->bindParam(':tlf_trabajo', $tlf_trabajo);
      $stmt->bindParam(':tlf_habitacion', $tlf_habitacion);
      $stmt->bindParam(':tlf_movil', $tlf_movil);
      $stmt->bindParam(':otros_alumnos', $otros_alumnos);
      $stmt->bindParam(':cantidad', $cantidad);
      $stmt->bindParam(':grados', $grados);
      $stmt->execute();

      echo '{"notice": {"text": Alumno Editado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Eliminar Madre
$app->delete('/api/madres/eliminar/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "DELETE FROM MADRES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;

      echo '{"notice": {"text": Madre Eliminada}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});






// PADRES

// Obtener todos los Padres
$app->get('/api/padres', function(Request $request, Response $response) {
  $sql = "SELECT * FROM PADRES";

  try {
     // Get DB Object
     $db = new db();
     // Connect
     $db = $db->connect();

     $stmt = $db->query($sql);
     $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
     $db = null;
     echo json_encode($customers);
  } catch (PDOException $e) {
     echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

// Obtener un solo Padre
$app->get('/api/padres/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "SELECT * FROM PADRES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $customer = $stmt->fetch(PDO::FETCH_OBJ);
      $db = null;
      echo json_encode($customer);
   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Actualizar Padre
$app->put('/api/padres/editar/{cedula}', function(Request $request, Response $response){
  $cedula = $request->getParam('cedula');
  $nombre = $request->getParam('nombre');
  $apellido = $request->getParam('apellido');
  $nacionalidad = $request->getParam('nacionalidad');
  $estado_civil = $request->getParam('estado_civil');
  $instruccion = $request->getParam('instruccion');
  $profesion = $request->getParam('profesion');
  $trabaja = $request->getParam('trabaja');
  $l_trabajo = $request->getParam('l_trabajo');
  $d_trabajo = $request->getParam('d_trabajo');
  $tlf_trabajo = $request->getParam('tlf_trabajo');
  $tlf_habitacion = $request->getParam('tlf_habitacion');
  $tlf_movil = $request->getParam('tlf_movil');

  $sql = "UPDATE PADRES SET
            nombre = :nombre,
            apellido = :apellido,
            nacionalidad = :nacionalidad,
            estado_civil = :estado_civil,
            instruccion = :instruccion,
            profesion = :profesion
            trabaja = :trabaja
            l_trabajo = :l_trabajo
            d_trabajo = :d_trabajo
            tlf_trabajo = :tlf_trabajo
            tlf_habitacion = :tlf_habitacion
            tlf_movil = :tlf_movil
         WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':cedula', $cedula);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':nacionalidad', $nacionalidad);
      $stmt->bindParam(':estado_civil', $estado_civil);
      $stmt->bindParam(':instruccion', $instruccion);
      $stmt->bindParam(':profesion', $profesion);
      $stmt->bindParam(':trabaja', $trabaja);
      $stmt->bindParam(':l_trabajo', $l_trabajo);
      $stmt->bindParam(':d_trabajo', $d_trabajo);
      $stmt->bindParam(':tlf_trabajo', $tlf_trabajo);
      $stmt->bindParam(':tlf_habitacion', $tlf_habitacion);
      $stmt->bindParam(':tlf_movil', $tlf_movil);

      $stmt->execute();

      echo '{"notice": {"text": Padre Editado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Eliminar Padre
$app->delete('/api/padres/eliminar/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "DELETE FROM PADRES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;

      echo '{"notice": {"text": Padre Eliminado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});






// REPRESENTANTES

// Obtener todos los Representantes
$app->get('/api/representantes', function(Request $request, Response $response) {
  $sql = "SELECT * FROM REPRESENTANTES";

  try {
     // Get DB Object
     $db = new db();
     // Connect
     $db = $db->connect();

     $stmt = $db->query($sql);
     $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
     $db = null;
     echo json_encode($customers);
  } catch (PDOException $e) {
     echo '{"error": {"text": '.$e->getMessage().'}}';
  }
});

// Obtener un solo Alumno
$app->get('/api/representantes/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "SELECT * FROM REPRESENTANTES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $customer = $stmt->fetch(PDO::FETCH_OBJ);
      $db = null;
      echo json_encode($customer);
   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Actualizar Representante
$app->put('/api/representantes/editar/{cedula}', function(Request $request, Response $response){
  $cedula = $request->getParam('cedula');
  $nombre = $request->getParam('nombre');
  $apellido = $request->getParam('apellido');
  $parentesco = $request->getParam('parentesco');
  $direccion = $request->getParam('direccion');
  $telefono = $request->getParam('telefono');
  $tipo = $request->getParam('tipo');

  $sql = "UPDATE REPRESENTANTES SET
            nombre = :nombre,
            apellido = :apellido,
            parentesco = :parentesco,
            direccion = :direccion,
            telefono = :telefono,
            tipo = :tipo
         WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $cedula = $request->getParam('cedula');
      $nombre = $request->getParam('nombre');
      $apellido = $request->getParam('apellido');
      $parentesco = $request->getParam('parentesco');
      $direccion = $request->getParam('direccion');
      $telefono = $request->getParam('telefono');
      $tipo = $request->getParam('tipo');

      $stmt->execute();

      echo '{"notice": {"text": Representante Editado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});

// Eliminar Representante
$app->delete('/api/representantes/eliminar/{cedula}', function(Request $request, Response $response){
   $cedula = $request->getAttribute('cedula');

   $sql = "DELETE FROM REPRESENTANTES WHERE cedula = $cedula";

   try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;

      echo '{"notice": {"text": Representante Eliminado}}';

   } catch (PDOException $e) {
      echo '{"error": {"text": '.$e->getMessage().'}}';
   }
});
