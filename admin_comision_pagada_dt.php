<?php
include ("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php' );
$table = 'producto';

$mes=$_REQUEST['mes'];
$anio=$_REQUEST['anio'];
$id_cliente=$_REQUEST['id_cliente'];

$primaryKey = 'id_producto';

$sql_details = array(
	'user' => $username,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $hostname
);
$joinQuery=" FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente";

$extraWhere="  producto.cobrado=1 AND producto.mes_venta='$mes' AND producto.anio_venta='$anio' ";
if($id_cliente != "GENERAL")
{
	$extraWhere .=" AND producto.id_cliente='$id_cliente' ";
}
$extraWhere .= " GROUP BY producto.id_cliente";
$columns = array(
	array( 'db' => 'producto.id_cliente',  'dt' => 0, 'field' => 'id_cliente'),
	array( 'db' => 'cliente.nombre', 'dt' => 1,'field' => 'nombre'),
	array( 'db' => 'producto.mes_venta', 'dt' => 2, 'formatter' => function($mes){ return(meses($mes)); },'field' => 'mes_venta'),
	array( 'db' => 'producto.anio_venta', 'dt' => 3, 'field' => 'anio_venta'),
	array( 'db' => 'producto.id_cliente', 'dt' => 4, 'formatter' => function($id_cliente)
	{
		$mes=$_REQUEST['mes'];
		$anio=$_REQUEST['anio'];
		$sql_clip = _query("SELECT sum(comision) as comision FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente  WHERE producto.id_cliente='$id_cliente' AND producto.cobrado=1 AND producto.mes_venta='$mes' AND producto.anio_venta='$anio' GROUP BY producto.id_cliente");
		$sql_clig = _query("SELECT sum(comision) as comision FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente  WHERE producto.id_cliente='$id_cliente' AND producto.descuento=1 AND producto.mes_descuento='$mes' AND producto.anio_descuento='$anio' GROUP BY producto.id_cliente");
		$datos_clip = _fetch_array($sql_clip);
		$datos_clig = _fetch_array($sql_clig);
		$pagar = $datos_clip["comision"];
		$descuento = $datos_clig["comision"];
		return $pagar - $descuento;
	}, 'field' => 'id_cliente'),
	array( 'db' => 'producto.fecha_cobro', 'dt' => 5, 'field' => 'fecha_cobro'),
	array( 'db' => 'producto.id_cliente', 'dt' => 6, 'formatter' => function($id_cliente)
	{
		$mes=$_REQUEST['mes'];
		$anio=$_REQUEST['anio'];
		return "<a class='btn btn-primary det' href='detalle_comision.php?id_cliente=".$id_cliente."&mes=".$mes."&anio=".$anio."&pay=si'><i class='fa fa-eye'></i></a>";
		}, 'field' => 'id_cliente'),
);
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);
?>
