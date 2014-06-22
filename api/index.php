<?php

require 'Slim/Slim.php';

use Slim\Slim;

Slim::registerAutoloader();

$app = new Slim();

$app->get('/facturas', 'getFacturas');
$app->get('/facturas/:id', 'getFactura');
$app->get('/facturas/search/:query', 'findFacturaByRFC');
$app->post('/facturas', 'addFactura');
$app->put('/facturas/:id', 'updateFactura');
$app->delete('/facturas/:id',  'deleteFactura');

$app->get('/usuarios', 'getUsuarios');
$app->get('/usuarios/:id', 'getUsuario');
$app->get('/usuarios/search/:query', 'findUsuarioByRFC');
$app->post('/usuarios', 'addUsuario');
$app->put('/usuarios/:id', 'updateUsuario');
$app->delete('/usuarios/:id', 'deleteUsuario');

$app->run();

function getFacturas(){
    $sql = "SELECT * FROM facturas ORDER BY fecha_correspondiente";
        try {
            $db = getConnection();
            $stmt = $db->query($sql);
            $facturas = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"facturas": ' . json_encode($facturas) . '}';
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
}

function getFactura($id) {
    $sql = "SELECT * FROM facturas WHERE id_factura=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $factura = $stmt->fetchObject();
        $db = null;
        echo json_encode($factura);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addFactura() {
    $request = Slim::getInstance()->request();
    $factura = json_decode( $request->getBody());
    $sql = "INSERT INTO facturas (id_usuario, nombre_nota, nombre_pdf, nombre_xml, rfc_cliente, fecha_correspondiente) VALUES (:id_usuario, :nombre_nota, :nombre_pdf, :nombre_xml, :rfc_cliente, :fecha_correspondiente)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id_usuario", $factura->id_usuario);
        $stmt->bindParam("nombre_nota", $factura->nombre_nota);
        $stmt->bindParam("nombre_pdf", $factura->nombre_pdf);
        $stmt->bindParam("nombre_xml", $factura->nombre_xml);
        $stmt->bindParam("rfc_cliente", $factura->rfc_cliente);
        $stmt->bindParam("fecha_correspondiente", $factura->fecha_correspondiente);
        $stmt->execute();
        $factura->id = $db->lastInsertId();
        $db = null;
        echo json_encode($factura);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateFactura($id) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $factura = json_decode($body);
    $sql = "UPDATE facturas SET id_usuario=:id_usuario, nombre_nota=:nombre_nota, nombre_pdf=:nombre_pdf, nombre_xml=:nombre_xml, rfc_cliente=:rfc_cliente, fecha_correspondiente=:fecha_correspondiente WHERE id_factura=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id_usuario", $factura->id_usuario);
        $stmt->bindParam("nombre_nota", $factura->nombre_nota);
        $stmt->bindParam("nombre_pdf", $factura->nombre_pdf);
        $stmt->bindParam("nombre_xml", $factura->nombre_xml);
        $stmt->bindParam("rfc_cliente", $factura->rfc_cliente);
        $stmt->bindParam("fecha_correspondiente", $factura->fecha_correspondiente);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($factura);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function deleteFactura($id) {
    $sql = "DELETE FROM facturas WHERE id_factura=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function findFacturaByRFC($query) {
    $sql = "SELECT * FROM facturas WHERE UPPER(rfc_cliente) LIKE :query ORDER BY rfc_cliente";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $facturas = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"factura": ' . json_encode($facturas) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getUsuarios(){
    $sql = "SELECT * FROM usuarios ORDER BY nombre";
        try {
            $db = getConnection();
            $stmt = $db->query($sql);
            $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"usuarios": ' . json_encode($usuarios) . '}';
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
}

function getUsuario($id){
    $sql = "SELECT * FROM usuarios WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $usuario = $stmt->fetchObject();
        $db = null;
        echo json_encode($usuario);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function addUsuario(){
    $request = Slim::getInstance()->request();
    $usuario = json_decode( $request->getBody());
    $sql = "INSERT INTO usuarios (nombre, pass, rfc, user) VALUES (:nombre, :pass, :rfc, :user)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nombre", $usuario->nombre);
        $stmt->bindParam("pass", $usuario->pass);
        $stmt->bindParam("rfc", $usuario->rfc);
        $stmt->bindParam("user", $usuario->user);
        $stmt->execute();
        $usuario->id = $db->lastInsertId();
        $db = null;
        echo json_encode($usuario);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateUsuario($id){
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $usuario = json_decode($body);
    $sql = "UPDATE usuarios SET nombre=:nombre, pass=:pass, rfc=:rfc, user=:user WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nombre", $usuario->nombre);
        $stmt->bindParam("pass", $usuario->pass);
        $stmt->bindParam("rfc", $usuario->rfc);
        $stmt->bindParam("user", $usuario->user);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($usuario);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function deleteUsuario($id){
    $sql = "DELETE FROM usuarios WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function findUsuarioByRFC($query){
    $sql = "SELECT * FROM usuarios WHERE UPPER(rfc)=UPPER(:query) ORDER BY rfc";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = $query;
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $usuario = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"usuario": ' . json_encode($usuario) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="covegusa_user";
    $dbpass="c0v3gusQ";
    $dbname="covegusa_db";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>
