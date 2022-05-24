<?php
	include ("_core.php");
	/*
	SELECT movimientos.id_movimiento,movimientos.fecha,movimientos.hora,usuario.nombre,movimientos.concepto,movimientos.total,SUM(movimiento_producto.entrada) as entrada,SUM(mp.salida) AS salida FROM movimientos JOIN usuario ON usuario.id_usuario=movimientos.id_usuario JOIN movimiento_producto ON movimiento_producto.id_movimiento=movimientos.id_movimiento JOIN movimiento_producto as mp ON mp.id_movimiento=movimientos.id_movimiento GROUP BY movimiento_producto.id_movimiento
	*/

	$requestData= $_REQUEST;
	$fechai= $_REQUEST['fechai'];
	$fechaf= $_REQUEST['fechaf'];

	require('ssp.customized.class.php' );
	// DB table to use
	$table = 'compra';
	// Table's primary key
	$primaryKey = 'id_compra';

	// MySQL server connection information
	$sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
  );

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$id_sucursal=$_SESSION['id_sucursal'];

	$joinQuery = "
	FROM compra JOIN usuario ON usuario.id_usuario=compra.id_empleado JOIN movimiento_producto ON movimiento_producto.id_compra=compra.id_compra
	";
	$extraWhere = " compra.fecha_ingreso BETWEEN '$fechai' AND '$fechaf' AND compra.id_sucursal=$id_sucursal";
	$columns = array(
	array( 'db' => 'compra.id_compra', 'dt' => 0, 'field' => 'id_compra' ),
	array( 'db' => 'compra.fecha_ingreso', 'dt' => 1, 'field' => 'fecha_ingreso' ),
	array( 'db' => 'compra.hora', 'dt' => 2, 'field' => 'hora' ),
	array( 'db' => 'usuario.nombre', 'dt' => 3, 'field' => 'nombre'),
	array( 'db' => 'movimiento_producto.concepto', 'dt' => 4, 'field' => 'concepto' , ),
	array( 'db' => 'compra.total', 'dt' =>5, 'field' => 'total' ),
	array( 'db' => 'compra.alias_tipodoc', 'dt' =>6, 'field' => 'alias_tipodoc' ),
	array( 'db' => 'compra.numero_doc ', 'dt' =>7, 'field' => 'numero_doc' ),
		array( 'db' => 'compra.id_compra', 'dt' => 8, 'formatter' => function( $id_movimiento, $row ){
		$menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";
			include ("_core.php");
			$id_user=$_SESSION["id_usuario"];
			$id_sucursal=$_SESSION['id_sucursal'];
			$admin=$_SESSION["admin"];

								$filename='ver_compra.php';
								$link=permission_usr($id_user,$filename);
								if ($link!='NOT' || $admin=='1' )
									$menudrop.="<li><a data-toggle='modal' href='$filename?id_compra=$id_movimiento'  data-target='#viewModalFact' data-refresh='true'><i class=\"fa fa-check\"></i> Ver detalle</a></li>";
							$menudrop.="</ul>
						</div>";
						return $menudrop;},
						'field' => 'id_compra' ),
	);
	//echo json_encode(
	//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
	);
?>
