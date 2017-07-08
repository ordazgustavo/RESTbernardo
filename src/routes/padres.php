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

// Agregar Alumno
// $app->post('/api/alumnos/agregar', function(Request $request, Response $response){
//   $cedula = $request->getParam('cedula');
//   $nombre = $request->getParam('nombre');
//   $apellido = $request->getParam('apellido');
//   $nacionalidad = $request->getParam('nacionalidad');
//   $estado_civil = $request->getParam('estado_civil');
//   $instruccion = $request->getParam('instruccion');
//   $profesion = $request->getParam('profesion');
//   $trabaja = $request->getParam('trabaja');
//   $l_trabajo = $request->getParam('l_trabajo');
//   $d_trabajo = $request->getParam('d_trabajo');
//   $tlf_trabajo = $request->getParam('tlf_trabajo');
//   $tlf_habitacion = $request->getParam('tlf_habitacion');
//   $tlf_movil = $request->getParam('tlf_movil');
//
//   $sql = "INSERT INTO PADRES (cedula, nombre, apellido, nacionalidad, estado_civil, instruccion, profesion, trabaja, l_trabajo, d_trabajo, tlf_trabajo, tlf_habitacion, tlf_movil) VALUES (:cedula, :nombre, :apellido, :nacionalidad, :estado_civil, :instruccion, :profesion, :trabaja, :l_trabajo, :d_trabajo, :tlf_trabajo, :tlf_habitacion, :tlf_movil)";
//
//
//    try {
//       // Get DB Object
//       $db = new db();
//       // Connect
//       $db = $db->connect();
//
//       $stmt = $db->prepare($sql);
//       $stmt->bindParam(':cedula', $cedula);
//       $stmt->bindParam(':nombre', $nombre);
//       $stmt->bindParam(':apellido', $apellido);
//       $stmt->bindParam(':nacionalidad', $nacionalidad);
//       $stmt->bindParam(':estado_civil', $estado_civil);
//       $stmt->bindParam(':instruccion', $instruccion);
//       $stmt->bindParam(':profesion', $profesion);
//       $stmt->bindParam(':trabaja', $trabaja);
//       $stmt->bindParam(':l_trabajo', $l_trabajo);
//       $stmt->bindParam(':d_trabajo', $d_trabajo);
//       $stmt->bindParam(':tlf_trabajo', $tlf_trabajo);
//       $stmt->bindParam(':tlf_habitacion', $tlf_habitacion);
//       $stmt->bindParam(':tlf_movil', $tlf_movil);
//
//       $stmt->execute();
//
//       echo '{"notice": {"text": Padre Agregado}}';
//
//    } catch (PDOException $e) {
//       echo '{"error": {"text": '.$e->getMessage().'}}';
//    }
// });

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
