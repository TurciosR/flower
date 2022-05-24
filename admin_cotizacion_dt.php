<?php
	include ("_core.php");

	$requestData= $_REQUEST;
	$fechai= $_REQUEST['fechai'];
	$fechaf= $_REQUEST['fechaf'];

	require('ssp.customized.class.php' );
	// DB table to use
	$table = 'cotizacion';
	// Table's primary key
	$primaryKey = 'id_cotizacion';

	// MySQL server connection information
	$sql_details = array(
	'user' => $username,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $hostname
	);

	$id_sucursal=$_SESSION['id_sucursal'];

	$joinQuery = "
	FROM cotizacion
	JOIN cliente  ON cotizacion.id_cliente=cliente.id_cliente
	LEFT JOIN usuario  ON cotizacion.id_empleado=usuario.id_usuario
	";
	$extraWhere = " cotizacion.fecha BETWEEN '$fechai' AND '$fechaf' AND cotizacion.id_sucursal = '$id_sucursal'";
	$columns = array(
	array( 'db' => '`cotizacion`.`id_cotizacion`', 'dt' => 0, 'field' => 'id_cotizacion' ),
	array( 'db' => 'DATE_FORMAT(`cotizacion`.`fecha`, "%d-%m-%Y")', 'dt' =>1, 'field' => 'fecha', 'as' => 'fecha'),
	array( 'db' => '`cliente`.`nombre`', 'dt' => 2, 'field' => 'nombrecli', 'as' => 'nombrecli'),
	array( 'db' => '`cotizacion`.`numero_doc`', 'dt' => 3, 'field' => 'numero_doc' ),
	array( 'db' => '`usuario`.`nombre`', 'dt' => 4, 'field' => 'nombreuser' , 'as' => 'nombreuser'),
	array( 'db' => 'FORMAT(`cotizacion`.`total`,2)', 'dt' =>5, 'field' => 'total', 'as' => 'total'),
	array( 'db' => '`cotizacion`.`impresa`', 'dt' => 6, 'formatter' => function( $impresa, $row ){
		$imp = "NO";
		if($impresa)
		{
			$imp = "SI";
		}
		return $imp; },	'field' => 'impresa'),
	array( 'db' => '`cotizacion`.`id_cotizacion`', 'dt' => 7, 'formatter' => function( $id_cotizacion, $row ){
			$id_user=$_SESSION["id_usuario"];
			$admin=$_SESSION["admin"];
			$menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";
			$filename='editar_cotizacion.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1'){
				$menudrop.="<li><a  href='$filename?id_cotizacion=$id_cotizacion' ><i class='fa fa-pencil'></i> Editar</a></li>";
			}
			$filename='ver_cotizacion.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' ){
				$menudrop.="<li><a data-toggle='modal' href='$filename?id_cotizacion=$id_cotizacion'  data-target='#viewModalCot' data-refresh='true'><i class='fa fa-eye'></i> Ver detalles</a></li>";
			}
			$filename='cotizacion.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' ){
					$menudrop.="<li><a target='_blank' href='$filename?id_cotizacion=$id_cotizacion'><i class='fa fa-print'></i> Impimir</a></li>";
			}
			$filename='borrar_cotizacion.php';
			$link=permission_usr($id_user,$filename);
			if ($link!='NOT' || $admin=='1' ){
					$menudrop.="<li><a data-toggle='modal' href='$filename?id_cotizacion=$id_cotizacion' data-target='#deleteModal' data-refresh='true'><i class='fa fa-eraser'></i> Borrar</a></li>";
			}
		$menudrop.="</ul>
				</div>";
		return $menudrop;}, 'field' => 'id_cotizacion'),
	);
	echo json_encode(
		SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
	);
?>
