<?php
	include ("_core.php");

	$requestData= $_REQUEST;

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
	JOIN cliente AS cte ON (fac.id_cliente = cte.id_cliente)
	JOIN usuario AS usr ON (fac.id_usuario=usr.id_usuario)
	";
	$extraWhere = "fac.id_sucursal='$id_sucursal'
	AND fac.fecha='".date('Y-m-d')."'AND fac.anulada=0 AND fac.finalizada=0";
	$columns = array(
	array( 'db' => '`fac`.`id_factura`', 'dt' => 0, 'field' => 'id_factura' ),
	array( 'db' => '`fac`.`numero_doc`', 'dt' => 1, 'field' => 'numero_doc' ),
	array( 'db' => '`fac`.`num_fact_impresa`', 'dt' => 2, 'field' => 'num_fact_impresa' ),
	array( 'db' => '`cte`.`nombre`', 'dt' => 3, 'field' => 'nombrecliente' , 'as' => 'nombrecliente'),
	array( 'db' => '`usr`.`nombre`', 'dt' => 4, 'field' => 'nombreuser' , 'as' => 'nombreuser' ),
	array( 'db' => '`fac`.`fecha`', 'dt' =>6, 'field' => 'fecha' ),
	array( 'db' => '`fac`.`total`', 'dt' =>5, 'field' => 'total' ),
	array( 'db' => '`fac`.`id_factura`', 'dt' => 7, 'formatter' => function( $id_factura, $row ){
		$sql="select finalizada,anulada from factura where id_factura='$id_factura'";
		$result=_query($sql);
		$count=_num_rows($result);
		$row=_fetch_array($result);
		$anulada=$row['anulada'];
		$finalizada=$row['finalizada'];
		$txt_estado="";
		if($finalizada==1 && $anulada==0)
			$txt_estado="<h5 class='text-mutted'>".'FINALIZADA'."</h5>";

		if($finalizada==0 && $anulada==1 )
			$txt_estado="<h5 class='text-warning'>".'NULA'."</h5>";

		if($finalizada==1 && $anulada==1 )
			$txt_estado="<h5 class='text-warning'>".'NULA'."</h5>";

		if($finalizada==0 && $anulada==0)
			$txt_estado="<h5 class='text-danger'>".'PENDIENTE'."</h5>";
		return $txt_estado;
		},
		'field' => 'id_factura'),
		array( 'db' => '`fac`.`id_factura`', 'dt' => 8, 'formatter' => function( $id_factura, $row ){
		$menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";
			include ("_core.php");
			$id_user=$_SESSION["id_usuario"];
			$id_sucursal=$_SESSION['id_sucursal'];
			$admin=$_SESSION["admin"];
			$sql="SELECT numero_doc,finalizada,anulada,tipo,id_apertura FROM factura WHERE id_factura='$id_factura'";
			$result=_query($sql);
			$count=_num_rows($result);
			$row=_fetch_array($result);
			$anulada=$row['anulada'];
			$finalizada=$row['finalizada'];
			$numero_doc=$row['numero_doc'];
			$tipo=$row['tipo'];
			$id_apertura=$row['id_apertura'];

			list($numero,$tipoa)=explode('_',$numero_doc);
			$id_sucursal=$_SESSION['id_sucursal'];
		  //permiso del script
		  $id_user=$_SESSION["id_usuario"];
		  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE id_apertura=$id_apertura");
		  $cuenta = _num_rows($sql_apertura);

		  $turno_vigente=0;
		  if ($cuenta>0) {
				$row_apertura = _fetch_array($sql_apertura);
		    $turno_vigente = $row_apertura["vigente"];
		  }

			if($tipo!='DEVOLUCION')
			{

				$filename='ver_factura.php';
				$link=permission_usr($id_user,$filename);
				if ($link!='NOT' || $admin=='1' )
				{
					$menudrop.="<li><a data-toggle='modal' href='$filename?id_factura=$id_factura&numero_doc=$numero_doc&id_sucursal=$id_sucursal'  data-target='#viewModalFact' data-refresh='true'><i class=\"fa fa-check\"></i> Ver Factura</a></li>";
				}

				$filename='reimprimir_factura.php';
				$link=permission_usr($id_user,$filename);
				if ($link!='NOT' || $admin=='1' ){
					if($finalizada==1)
						$menudrop.="<li><a data-toggle='modal' href='reimprimir_factura.php?id_factura=".$id_factura."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-print\"></i> Reimprimir</a></li>";
				}

				$filename='devolucion.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            if ( $anulada==0&&$finalizada==1) {
                $menudrop.="<li><a  href='$filename?id_factura=$id_factura' ><i class='fa fa-minus'></i> Devolucion</a></li>";
            }
        }
				$filename='anular_factura.php';
				$link=permission_usr($id_user,$filename);
				if ($link!='NOT' || $admin=='1' ){
					if ( $anulada==0&&$finalizada==1) {
						if ($turno_vigente==1) {
							$menudrop.="<li><a data-toggle='modal' href='anular_factura.php?id_factura=".$id_factura."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-close\"></i> Anular</a></li>";
						}
					}
				}

				}
				else {
					# code...
					if ($tipoa=='NC') {
						# code...
						$filename='reimprimir_factura.php';
						$link=permission_usr($id_user,$filename);
						if ($link!='NOT' || $admin=='1' ){
							if($finalizada==1)
								$menudrop.="<li><a data-toggle='modal' href='reimprimir_factura.php?id_factura=".$id_factura."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-print\"></i> Reimprimir</a></li>";
						}
					}
				}


			$menudrop.="</ul>
		</div>";
		return $menudrop;},
		'field' => 'id_factura' ),

	);
	//echo json_encode(
	//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
	);
?>
