<?php
include ("_core.php");

$requestData= $_REQUEST;
$fechai= $_REQUEST['fechai'];
$fechaf= $_REQUEST['fechaf'];

require('ssp.customized.class.php' );
// DB table to use
$table = 'voucher';
// Table's primary key
$primaryKey = 'id_voucher';

// MySQL server connection information
$sql_details = array(
	'user' => $username,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $hostname
);
/*
<th>Id factura</th>
<th>Tipo Doc</th>
<th>Numero Doc</th>
<th>Proveedor</th>
<th>Empleado</th>
<th>Total</th>
<th>Fecha Doc</th>
<th>Fecha Vence</th>
<th>Estado</th>
*/
//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];
$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);

$id_sucursal=$_SESSION['id_sucursal'];

$joinQuery = "";
//FROM  cuenta_pagar
//JOIN proveedores AS pro ON (cuenta_pagar.id_proveedor = pro.id_proveedor)
//";
$extraWhere = " fecha BETWEEN '$fechai' AND '$fechaf' AND id_sucursal='$id_sucursal'";
//$extraWhere = "";
$columns = array(
	array( 'db' => 'id_voucher', 'dt' => 0, 'field' => 'id_voucher' ),
	array( 'db' => 'fecha', 'dt' =>1, 'field' => 'fecha' ),
	array( 'db' => 'responsable', 'dt' => 2, 'field' => 'responsable'),
	array( 'db' => 'forma_pago', 'dt' => 3, 'field' => 'forma_pago'),
	array( 'db' => 'numero_doc', 'dt' => 4, 'field' => 'numero_doc' ),
	array( 'db' => 'monto', 'dt' => 5, 'field' => 'monto' ),
	array( 'db' => 'estado', 'dt' => 6, 'field' => 'estado' ),
	array( 'db' => 'id_voucher', 'dt' => 7, 'formatter' => function( $id_voucher, $row ){
		$menudrop = crear_menu($id_voucher);
		return $menudrop;
		},
		'field' => 'id_voucher' ),
	);
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
	);
	function crear_menu($id_voucher)
	{
		$menudrop="<div class='btn-group'>
		<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
		<ul class='dropdown-menu dropdown-primary'>";
		$sql_princ = _query("SELECT forma_pago, id_movimiento FROM voucher WHERE id_voucher='$id_voucher'");
		$dats_princ = _fetch_array($sql_princ);
		$forma = $dats_princ["forma_pago"];
		$id_user=$_SESSION["id_usuario"];
		$id_sucursal=$_SESSION["id_sucursal"];
		$admin=$_SESSION["admin"];
		$a=0;
		$sql = _query("SELECT cuenta_pagar.saldo_pend, voucher.estado FROM voucher JOIN voucher_mov ON voucher_mov.id_movimiento=voucher.id_voucher JOIN cuenta_pagar ON cuenta_pagar.id_cuenta_pagar=voucher_mov.id_cuenta_pagar WHERE voucher.id_voucher = $id_voucher");
		$id_cuenta = 0;
		$id_movimiento = 0;
		if($forma != "Efectivo")
		{
			$id_movimiento = $dats_princ["id_movimiento"];
			$sqla=_fetch_array(_query("SELECT * FROM mov_cta_banco WHERE id_movimiento='$id_movimiento'"));
			$id_cuenta=$sqla["id_cuenta"];
		}
		while ($row=_fetch_array($sql))
		{
			if ($row['estado'] == "PENDIENTE")
			{
				$a=1;
			}
		}
		if ($a)
		{
			$filename='editar_pago_proveedor.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' )
			{
				$menudrop.="<li><a  href='$filename?id_movimiento=$id_movimiento&id_voucher=$id_voucher&id_cuenta=$id_cuenta'><i class=\"fa fa-pencil\"></i> Editar</a></li>";
			}
			$filename='finalizar_mov_cta_banco.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' )
			{
				$menudrop.="<li><a data-toggle='modal' href='$filename?id_voucher=$id_voucher'  data-target='#viewModal' data-refresh='true'><i class=\"fa fa-check\"></i> Finalizar</a></li>";
			}
		}
		else
		{
			$filename='editar_voucher.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' )
			{
				$menudrop.="<li><a  href='$filename?id_movimiento=$id_movimiento&id_voucher=$id_voucher&id_cuenta=$id_cuenta'><i class=\"fa fa-pencil\"></i> Editar</a></li>";
			}
			$filename='voucher.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' )
			{
				$menudrop.="<li><a href=\"voucher.php?id_voucher=$id_voucher"."\" target='_blank'><i class=\"fa fa-print\"></i> Imprimir</a></li>";
			}
		}
		$menudrop.="</ul>
		</div>";
		return $menudrop;
	}
	?>
