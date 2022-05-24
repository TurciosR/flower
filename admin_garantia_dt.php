<?php
include ("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php' );
$table = 'producto';

$fini=MD($_REQUEST['fini']);
$fin=MD($_REQUEST['fin']);
$id_cliente=$_REQUEST['id_cliente'];

$primaryKey = 'id_producto';

$sql_details = array(
	'user' => $username,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $hostname
);
$joinQuery=" FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente";

$extraWhere="  producto.garantia=1 AND producto.fecha_garantia BETWEEN '$fini' AND '$fin'";
if($id_cliente != "GENERAL")
{
	$extraWhere .=" AND producto.id_cliente='$id_cliente'";
}
$columns = array(
	array( 'db' => 'producto.id_producto',  'dt' => 0, 'field' => 'id_producto'),
	array( 'db' => 'producto.marca', 'dt' => 1,'field' => 'marca'),
	array( 'db' => 'producto.modelo', 'dt' => 2,'field' => 'modelo'),
	array( 'db' => 'producto.imei', 'dt' => 3, 'field' => 'imei'),
	array( 'db' => 'producto.comision', 'dt' => 4, 'field' => 'comision'),
	array( 'db' => 'producto.fecha_garantia', 'dt' => 5, 'field' => 'fecha_garantia'),
	array( 'db' => 'producto.descuento', 'dt' => 6, 'formatter' => function($descuento)
	{
		if($descuento)
		return "SI";
		else
		return "NO";
		}, 'field' => 'descuento'),
);
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);
?>
