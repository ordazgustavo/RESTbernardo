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

// Agregar Alumno
// $app->post('/api/alumnos/agregar', function(Request $request, Response $response){
//   $cedula = $request->getParam('cedula');
//   $nombre = $request->getParam('nombre');
//   $apellido = $request->getParam('apellido');
//   $parentesco = $request->getParam('parentesco');
//   $direccion = $request->getParam('direccion');
//   $telefono = $request->getParam('telefono');
//   $tipo = $request->getParam('tipo');
//
//   $sql = "INSERT INTO REPRESENTANTES (cedula, nombre, apellido, parentesco, direccion, telefono, tipo) VALUES (:cedula, :nombre, :apellido, :parentesco, :direccion, :telefono, :tipo)";
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
//     $stmt->bindParam(':parentesco', $parentesco);
//     $stmt->bindParam(':direccion', $direccion);
//     $stmt->bindParam(':telefono', $telefono);
//     $stmt->bindParam(':tipo', $tipo);
//
//     $stmt->execute();
//
//     echo '{"notice": {"text": Representante Agregado}}';
//
//   } catch (PDOException $e) {
//     echo '{"error": {"text": '.$e->getMessage().'}}';
//   }
// });

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
