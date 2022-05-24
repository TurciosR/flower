<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8; mimetype=application/json");
ini_set('memory_limit', '512M');
include_once("../_conexion.php");

$sql = " SELECT  id_producto, barcode, descripcion, id_proveedor, imagen costo,id_categoria FROM producto";

$datos = _fetch_all($sql);
if(sizeof($datos) > 0){   
    http_response_code(200);
    echo json_encode($datos);
}else{
    http_response_code(500);
    echo json_encode(array("status"=>"ERROR"));
}
?>
