<?php
	include ("_core.php");

	$requestData= $_REQUEST;
	$fechai= $_REQUEST['fechai'];
	$fechaf= $_REQUEST['fechaf'];



	require('ssp.customized.class.php' );
	// DB table to use
	$table = 'factura';
	// Table's primary key
	$primaryKey = 'id_factura';

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
	FROM  factura  AS fac
	JOIN cliente AS cli ON (fac.id_cliente=cli.id_cliente)
	JOIN usuario AS usr ON (fac.id_empleado=usr.id_usuario)
	";
	$extraWhere = " fac.fecha BETWEEN '$fechai' AND '$fechaf' AND finalizada = 0 AND anulada = 0";
	$columns = array(
	array( 'db' => '`fac`.`id_factura`', 'dt' => 0, 'field' => 'id_factura' ),
	array( 'db' => '`fac`.`fecha`', 'dt' =>1, 'field' => 'fecha' ),
	//array( 'db' => '`cli`.`nombre`', 'dt' => 2, 'field' => 'nombrecli', 'as' => 'nombrecli'),
	array( 'db' => '`fac`.`nombre_facturar`', 'dt' => 2, 'field' => 'nombre_facturar', 'as' => 'nombre_facturar'),
	array( 'db' => '`fac`.`numero_doc`', 'dt' => 3, 'field' => 'numero_doc' ),
	array( 'db' => '`usr`.`nombre`', 'dt' => 4, 'field' => 'nombreuser' , 'as' => 'nombreuser' ),
	array( 'db' => '`fac`.`total`', 'dt' =>5, 'field' => 'total' ),
	array( 'db' => '`fac`.`id_factura`', 'dt' => 6, 'formatter' => function( $id_factura, $row ){
		 $anulada_finalizada=finalizada($id_factura);
		list($anulada,$finalizada)=explode('-',$anulada_finalizada);
		$txt_estado="";
		if($finalizada==0 && $anulada==0)
			$txt_estado="<h5 class='text-danger'>".'PENDIENTE'."</h5>";
		return $txt_estado;
		},
		'field' => 'id_factura'),
		array( 'db' => '`fac`.`id_factura`', 'dt' => 7, 'formatter' => function( $id_factura, $row ){
			$id_user=$_SESSION["id_usuario"];
			$admin=$_SESSION["admin"];

			$anulada_finalizada=finalizada($id_factura);
			$ape = apertura();
		 list($anulada,$finalizada)=explode('-',$anulada_finalizada);

		$menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";
			$filename='finalizar_fact.php';
			$link=permission_usr($id_user,$filename);

			if ($link!='NOT' || $admin=='1'){
				if($finalizada==0 && $anulada==0){
					if($ape == 1){
						$menudrop.="<li><a  href='$filename?id_factura=$id_factura' ><i class='fa fa-money'></i> Cobrar</a></li>";
					}

				}
			}
			/*
							$filename='editar_factura.php';
							$link=permission_usr($id_user,$filename);
							if ($link!='NOT' || $admin=='1'){
								if($finalizada==0 && $anulada==0){
									$menudrop.="<li><a  href='$filename?id_factura=$id_factura&process=formEdit' ><i class='fa fa-pencil'></i> Editar</a></li>";
								}
							}
							*/
							$filename='devolucion.php';
							$link=permission_usr($id_user,$filename);
							if ($link!='NOT' || $admin=='1'){
								if($finalizada==1 && $anulada==0){
									$menudrop.="<li><a  href='$filename?id_factura=$id_factura' ><i class='fa fa-check'></i> Devolucion</a></li>";
								}
							}
							$filename='ver_factura.php';
							$link=permission_usr($id_user,$filename);
							if ($link!='NOT' || $admin=='1' )
								$menudrop.="<li><a data-toggle='modal' href='$filename?id_factura=$id_factura'  data-target='#viewModalFact' data-refresh='true'><i class='fa fa-eye'></i> Ver Factura</a></li>";
							//Reimprimir factura
							$filename='reimprimir_factura.php';
							$link=permission_usr($id_user,$filename);
							if ($link!='NOT' || $admin=='1' ){
								if($finalizada==1)
									$menudrop.="<li><a data-toggle='modal' href='$filename?id_factura=".$row['id_factura']."' data-target='#viewModal' data-refresh='true'><i class='fa fa-print'></i> Reimprimir</a></li>";
							}
							$filename='anular_factura.php';
							$link=permission_usr($id_user,$filename);
							if ($link!='NOT' || $admin=='1' ){
								if( $anulada==0){
									$menudrop.="<li><a data-toggle='modal' href='$filename?id_factura=" .  $row ['id_factura']."&process=formDelete"."' data-target='#deleteModal' data-refresh='true'><i class='fa fa-eraser'></i> Anular</a></li>";
								}
							}
			$menudrop.="</ul>
						</div>";
		return $menudrop;},
		'field' => 'id_factura' ),

	);
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
	);
function finalizada($id_factura){
	$sql="select finalizada,anulada from factura where id_factura='$id_factura'";
	$result=_query($sql);
	$count=_num_rows($result);
	$row=_fetch_array($result);
	$anulada=$row['anulada'];
	$finalizada=$row['finalizada'];
	return $anulada."-".$finalizada;

}
function apertura()
{
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_user=$_SESSION["id_usuario"];
	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE id_sucursal = '$id_sucursal' AND id_empleado = '$id_user' AND vigente = 1");
    $cuentax = _num_rows($sql_apertura);
    return $cuentax;
}
function cliente($id_cliente)
{
	$sql="SELECT nombre, apellido FROM cliente WHERE id_cliente='$id_cliente'";
	$result=_query($sql);
	$count=_num_rows($result);
	$row=_fetch_array($result);
	$nombre=$row['nombre'];
	$apellido=$row['apellido'];
	return $nombre." ".$apellido;
}
?>
