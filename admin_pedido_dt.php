<?php
	include ("_core.php");
	/*
	SELECT movimientos.id_movimiento,movimientos.fecha,movimientos.hora,usuario.nombre,movimientos.concepto,movimientos.total,SUM(movimiento_producto.entrada) as entrada,SUM(mp.salida) AS salida FROM movimientos JOIN usuario ON usuario.id_usuario=movimientos.id_usuario JOIN movimiento_producto ON movimiento_producto.id_movimiento=movimientos.id_movimiento JOIN movimiento_producto as mp ON mp.id_movimiento=movimientos.id_movimiento GROUP BY movimiento_producto.id_movimiento
	*/
	$requestData= $_REQUEST;
	$fechai= MD($_REQUEST['fechai']);
	$fechaf= MD($_REQUEST['fechaf']);

	require('ssp.customized.class.php' );
	// DB table to use
	$table = 'pedido';
	// Table's primary key
	$primaryKey = 'id_pedido';

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
	$id_sucursal = $_SESSION["id_sucursal"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);


	$joinQuery = "FROM pedido as m JOIN cliente as c ON m.id_cliente = c.id_cliente";
	$extraWhere = " m.fecha BETWEEN '$fechai' AND '$fechaf'";
	$columns = array(
	array( 'db' => 'm.id_pedido', 'dt' => 0, 'field' => 'id_pedido' ),
	array( 'db' => 'm.fecha', 'dt' => 1, 'field' => 'fecha' ),
	array( 'db' => 'c.nombre', 'dt' => 2, 'field' => 'nombre' ),
	array( 'db' => 'm.lugar_entrega', 'dt' => 3, 'field' => 'lugar_entrega' ),
	array( 'db' => 'm.total', 'dt' => 4, 'field' => 'total'),
	array( 'db' => 'm.finalizada', 'dt' => 5, 'formatter' => function( $tipo, $row )
	{
		if($tipo == 1)
		{
			return "FINALIZADA";
		}
		else
		{
			return "PENDIENTE";
		}
	},'field' => 'finalizada' ),
	array( 'db' => 'm.id_pedido', 'dt' => 6, 'formatter' => function( $id_movimiento, $row ){
		$menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";
			include ("_core.php");
			$id_user=$_SESSION["id_usuario"];
			$id_sucursal=1;
			$admin=$_SESSION["admin"];

      $sql_pedido = _query("SELECT * FROM pedido WHERE id_pedido = '$id_movimiento'");
      $row_p = _fetch_array($sql_pedido);
      $finalizada = $row_p["finalizada"];

			$filename='ver_pedido.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' )
				$menudrop.="<li><a data-toggle='modal' href='$filename?id_pedido=$id_movimiento'  data-target='#viewModalFact' data-refresh='true'><i class=\"fa fa-check\"></i> Ver detalle</a></li>";
      if($finalizada == 0)
      {
        $filename='pedido_pdf.php';
        if ($link!='NOT' || $admin=='1' )
  				$menudrop.="<li><a href='$filename?id_pedido=$id_movimiento'target='_blank' ><i class=\"fa fa-spinner\"></i> Imprimir</a></li>";
      }
  			$menudrop.="</ul>
  		</div>";
  		return $menudrop;},
  		'field' => 'id_pedido' ),

	);
	//echo json_encode(
	//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
	);
?>
