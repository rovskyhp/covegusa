<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/facturas', 'getFacturas');
$app->get('/facturas/:id', 'getFactura');
$app->get('/facturas/search/:query', 'findByRFC');
$app->post('/facturas', 'addFactura');
$app->put('/facturas/:id', 'updateFactura');
$app->delete('/facturas/:id',  'deleteFactura');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();

function getFacturas(){
    $sql = "select * FROM facturas ORDER BY fecha_correspondiente";
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
    $request = \Slim\Slim::getInstance()->request();
    $factura = json_decode($request->getBody());
    var_dump($factura);
    exit;
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
    $request = \Slim\Slim::getInstance()->request();
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

function findByRFC($query) {
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

function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="covegusa_user";
    $dbpass="c0v3gusQ";
    $dbname="covegusa_db";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>
