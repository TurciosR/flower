<?php
include ("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php' );
$table = 'producto';

$mes=$_REQUEST['mes'];
$anio=$_REQUEST['anio'];
$id_cliente=$_REQUEST['id_cliente'];
$sucursal=$_REQUEST['sucursal'];
$local=$_REQUEST['local'];
$vendedor=$_REQUEST['vendedor'];
$pay=$_REQUEST['pay'];

$primaryKey = 'id_producto';

$sql_details = array(
	'user' => $username,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $hostname
);
$joinQuery=" FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente
						 LEFT JOIN vendedor ON producto.id_vendedor=vendedor.id_vendedor
						 LEFT JOIN sucursal ON producto.id_sucursal = sucursal.id_sucursal
						 LEFT JOIN local ON producto.id_local=local.id_local";

	$extraWhere=" producto.vendido=1 AND producto.mes_venta='$mes' AND producto.anio_venta='$anio'";
	if($pay == "si")
	{
		$extraWhere.=" AND producto.cobrado=1";
	}
	else
	{
		$extraWhere.=" AND producto.cobrado=0";
	}
	if($vendedor != "GENERAL")
	{
		$extraWhere.=" AND producto.id_vendedor='$vendedor'";
	}
	if($sucursal != "GENERAL")
	{
		$extraWhere.=" AND producto.id_sucursal='$sucursal'";
	}
	if($local != "GENERAL")
	{
		$extraWhere.=" AND producto.id_local='$local'";
	}

$columns = array(
	array( 'db' => 'producto.id_producto',  'dt' => 0, 'field' => 'id_producto'),
	array( 'db' => 'producto.marca', 'dt' => 1,'field' => 'marca'),
	array( 'db' => 'producto.modelo', 'dt' => 2, 'field' => 'modelo'),
	array( 'db' => 'producto.imei', 'dt' => 3, 'formatter' => function($imei){
		$sql_val = _query("SELECT garantia, descuento FROM producto WHERE imei = '$imei'");
		$dats = _fetch_array($sql_val);
		if($dats["garantia"])
		{
			if($dats["descuento"])
			{
				return "<p class='text-danger'><strong>$imei</strong></p>";
			}
			else {
				return "<p class='text-warning'><strong>$imei</strong></p>";
			}
		}
		else {
			return "<p class='text-success'><strong>$imei</strong></p>";
		}
	},'field' => 'imei'),
	array( 'db' => 'producto.comision', 'dt' => 4, 'field' => 'comision'),
	array( 'db' => 'producto.fecha_venta', 'dt' => 5, 'field' => 'fecha_venta'),
	array( 'db' => 'vendedor.nombre', 'dt' => 6, 'field' => 'vendedor', 'as' => 'vendedor'),
	array( 'db' => 'sucursal.nombre', 'dt' => 7, 'field' => 'sucursal', 'as' => 'sucursal'),
	array( 'db' => 'local.nombre', 'dt' => 8, 'field' => 'local', 'as' => 'local'),
);
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);
?>
