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
//   $otros_alumnos = $request->getParam('otros_alumnos');
//   $cantidad = $request->getParam('cantidad');
//   $grados = $request->getParam('grados');
//
//   $sql = "INSERT INTO MADRES (cedula, nombre, apellido, nacionalidad, estado_civil, instruccion, profesion, trabaja, l_trabajo, d_trabajo, tlf_trabajo, tlf_habitacion, tlf_movil, otros_alumnos, cantidad, grados) VALUES (:cedula, :nombre, :apellido, :nacionalidad, :estado_civil, :instruccion, :profesion, :trabaja, :l_trabajo, :d_trabajo, :tlf_trabajo, :tlf_habitacion, :tlf_movil, :otros_alumnos, :cantidad, :grados)";
//
//   try {
//     // Get DB Object
//     $db = new db();
//     // Connect
//     $db = $db->connect();
//
//     $stmt = $db->prepare($sql);
//     $stmt->bindParam(':cedula', $cedula);
//     $stmt->bindParam(':nombre', $nombre);
//     $stmt->bindParam(':apellido', $apellido);
//     $stmt->bindParam(':nacionalidad', $nacionalidad);
//     $stmt->bindParam(':estado_civil', $estado_civil);
//     $stmt->bindParam(':instruccion', $instruccion);
//     $stmt->bindParam(':profesion', $profesion);
//     $stmt->bindParam(':trabaja', $trabaja);
//     $stmt->bindParam(':l_trabajo', $l_trabajo);
//     $stmt->bindParam(':d_trabajo', $d_trabajo);
//     $stmt->bindParam(':tlf_trabajo', $tlf_trabajo);
//     $stmt->bindParam(':tlf_habitacion', $tlf_habitacion);
//     $stmt->bindParam(':tlf_movil', $tlf_movil);
//     $stmt->bindParam(':otros_alumnos', $otros_alumnos);
//     $stmt->bindParam(':cantidad', $cantidad);
//     $stmt->bindParam(':grados', $grados);
//
//     $stmt->execute();
//
//     echo '{"notice": {"text": Madre Agregada}}';
//
//   } catch (PDOException $e) {
//     echo '{"error": {"text": '.$e->getMessage().'}}';
//   }
// });

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
