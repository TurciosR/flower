<?php
include_once "_core.php";

include ('num2letras.php');
include ('facturacion_funcion_imprimir.php');

function initial() {


	$_PAGE = array ();
	$_PAGE ['title'] = 'Devolucion de productos';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user, $filename);
	//permiso del script
	$id_factura = $_REQUEST['id_factura'];
	$fecha_actual=date("Y-m-d");

	$sql=_fetch_array(_query("SELECT * FROM `factura` WHERE factura.id_factura=$id_factura"));
	$numero_doc=$sql['numero_doc'];
	$numero_doc=$sql['numero_doc'];
	list($numero,$tipo)=explode('_',$numero_doc);
	$numero = round($numero,0);
	$id_cliente=$sql['id_cliente'];
	$sqlc=_fetch_array(_query("SELECT CONCAT(cliente.nombre) as nombre FROM cliente WHERE id_cliente=$id_cliente"));
	$nombre_cliente=$sqlc['nombre'];

	$id_user=$_SESSION["id_usuario"];
  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND fecha='$fecha_actual' AND id_empleado = '$id_user'");
  $cuenta = _num_rows($sql_apertura);

  $turno_vigente=0;
  if ($cuenta>0) {
    $row_apertura = _fetch_array($sql_apertura);
    $id_apertura = $row_apertura["id_apertura"];
    $turno = $row_apertura["turno"];
    $caja = $row_apertura["caja"];
    $fecha_apertura = $row_apertura["fecha"];
    $hora_apertura = $row_apertura["hora"];
    $turno_vigente = $row_apertura["vigente"];
  }





?>

	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2">
		</div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<?php
					if ($links!='NOT' || $admin=='1' ){
						if ($turno_vigente=='1' ){

					 ?>
					<div class="ibox-title">
						<h5>Devolución de productos: <label class="text-success"><?php echo $numero_doc ?></label></h5>
						<input type="hidden" id="numero_doc" name="numero_doc" value=" <?php echo $numero_doc ?>">
						<input type="hidden" name="id_factura" id="id_factura" value="<?php echo $id_factura ?>">
						<input type="hidden" id="id_apertura" name="id_apertura" value="<?php echo $id_apertura ?>">
						<input type="hidden" id="caja" name="caja" value="<?php echo $caja ?>">
						<input type="hidden" id="turno" name="turno" value="<?php echo $turno ?>">
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<label>Tipo de documento: <?php echo $tipo ?></label>
								<br>
								<input type="hidden" id="tipo_doc" name="tipo_doc" value="<?php echo $tipo ?>">
								<label>Numero: <?php echo $numero ?></label>
								<br>
								<label>Cliente: <?php echo $nombre_cliente ?></label>
								<input type="hidden" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente ?>">
							</div>

							<div class="col-lg-12">
								<table id="tabla" class=" table table-hover table-striped">
									<tr>
										<td class='text-success col-lg-1'>ID</td>
										<td class='text-success col-lg-2'>Producto</td>
										<td class='text-success col-lg-2'>Presentación</td>
										<td class='text-success col-lg-2'>Descripción</td>
										<td class='text-success col-lg-1'>Precio de venta</td>
										<td class='text-success col-lg-1'>Cant. vendida</td>
										<td class='text-success col-lg-1'>Dev. Anteriores</td>
										<td class='text-success col-lg-1'>Cant. a devolver</td>
										<td class='text-success col-lg-1'>Subtotal a devolver</td>
									</tr>
									<?php
									$sql=_query("SELECT factura_detalle.id_factura_detalle, factura_detalle.id_prod_serv,producto.descripcion,presentacion.nombre as descripcion_pr,presentacion_producto.descripcion AS descripcion_p, factura_detalle.precio_venta,factura_detalle.cantidad,presentacion_producto.unidad,presentacion_producto.id_pp as id_presentacion FROM factura_detalle JOIN producto ON producto.id_producto=factura_detalle.id_prod_serv JOIN presentacion_producto ON presentacion_producto.id_pp=factura_detalle.id_presentacion JOIN presentacion ON presentacion_producto.id_presentacion=presentacion.id_presentacion WHERE factura_detalle.id_factura=$id_factura");
									while ($row=_fetch_array($sql)) {
										# code...
										$sqldev_a= _fetch_array(_query("SELECT SUM(devoluciones_det.cant) as cant FROM devoluciones_det WHERE devoluciones_det.id_factura=$id_factura AND devoluciones_det.id_producto=$row[id_prod_serv] AND devoluciones_det.id_factura_detalle=$row[id_factura_detalle]"));
										$dev_ant=$sqldev_a['cant'];

										?>
										<tr>
											<td class='text-success col-lg-1'><?php echo $row['id_prod_serv'] ?></td>
											<td class='text-success col-lg-2'><?php echo $row['descripcion'] ?>
												<input type="hidden" id="unidades" name="unidades" value="<?php echo $row['unidad'] ?>">
												<input type="hidden" id="id_presentacion" name="id_presentacion" value="<?php echo $row['id_presentacion'] ?>">
												<input type="hidden" id="id_factura_detalle" name="id_factura_detalle" value="<?php echo $row['id_factura_detalle'] ?>">
											</td>
											<td class='text-success col-lg-2'><?php echo $row['descripcion_pr'] ?> </td>
											<td class='text-success col-lg-2'><?php echo $row['descripcion_p'] ?> </td>
											<td class='text-success col-lg-1'><?php echo $row['precio_venta'] ?></td>
											<td class='text-success col-lg-1'><?php echo $row['cantidad']/$row['unidad'] ?></td>
											<td class='text-success col-lg-1'><?php echo $dev_ant ?></td>
											<td class='text-success col-lg-1'> <input class="form-control int" type="text" id="cant" name="cant" value=""> </td>
											<td class='text-success col-lg-1'> <input readOnly class="form-control" type="text" id="subtotal" name="subtotal" value=""> </td>
										</tr>
										<?php
									}
									 ?>
								</table>
							</div>
							<div class="col-lg-12">
								<table class="table">
									<tr>
										<td class='text-success col-lg-10' colspan="5">Total</td>
										<td id="totcant" class='text-success col-lg-1'>0</td>
										<td id="montodev" class='text-success col-lg-1'>0</td>
									</tr>
								</table>
							</div>
							<div class="col-lg-12">
								<button class="btn btn-primary" type="button" id="btnGuardar" name="btnGuardar">Guardar</button>
							</div>


						</div>
					</div>

					<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content modal-md">
								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Impresion</h4>
								</div>
								<div class="modal-body">
									<div class="wrapper wrapper-content  animated fadeInRight">
										<div class="row">
											<input type='hidden' name='id_factura_n' id='id_factura_n' value=''>
											<div class="col-md-6">
												<div class="form-group">
													<label><h5 class='text-navy'>Numero control Interno:</h5></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group" id='fact_num'></div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label><h5 class='text-navy'>Facturado $:</h5></label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" id="facturado" name="facturado" value=0 class="form-control decimal" readonly>
												</div>
											</div>
										</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label><h5 class='text-navy'>Numero nota de credito:</h5></label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<input class="form_control" type="text" id="numero" name="numero" value="">
													</div>
												</div>
											</div>


									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" id="btnPrintFact">Imprimir</button>
									<button type="button" class="btn btn-warning" id="btnEsc">Salir</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	<?php
	include_once ("footer.php");
	echo "<script src='js/funciones/devolucion.js'></script>";
}   //apertura de caja
else {
	echo "<br><br><div class='alert alert-warning'><h3 class='text-danger'> No Hay Apertura de Caja vigente para este turno!!!</h3></div></div></div></div></div>";
	include_once("footer.php");
}  //apertura de caja

		} //permiso del script
else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div><div></div>";
		include_once("footer.php");
	}
}

function insert_sucursal(){
	//$id_sucursal=$_POST["id_sucursal"];
	$descripcion=$_POST["nombre"];
    $direccion=$_POST["direccion"];
    $casa=$_POST["casa"];


    $sql_result= _query("SELECT * FROM sucursal WHERE descripcion='$descripcion'");
    $numrows=_num_rows($sql_result);


    $table = 'sucursal';
    $form_data = array (
    	'descripcion' => $descripcion,
    	'direccion' => $direccion,
    	'casa_matriz' => $casa
    );

    if($numrows == 0){

    $insertar = _insert($table,$form_data);

    if($insertar){
       $xdatos['typeinfo']='Success';
       $xdatos['msg']='Registro insertado con éxito !';
       $xdatos['process']='insert';
    }
    else{
       $xdatos['typeinfo']='Error';
       $xdatos['msg']='Error al insertar!';
        $xdatos['process']='none';
		}
    }
   //  $xdatos['process']='none';
    /*
    else{
		$xdatos['max_id']=$id_update;
		$where_clause = "name='" . $name . "' AND id_country='$id_update'";
		$update = update ( $table, $form_data, $where_clause );
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='The country name already exists!';
		$xdatos['process']='edited';
    }
    */
	echo json_encode($xdatos);
}

function devolucion()
{
	# code...
	$totcant=$_POST['totcant'];
	$monto_a_devolver=$_POST['montodev'];
	$id_factura=$_POST['id_factura'];
	$id_cliente=$_POST['id_cliente'];
	$array_json=$_POST['array_json'];
	$tipo=$_POST['tipo'];
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_usuario=$_SESSION['id_usuario'];

	$ver1=0;
	$ver2=0;
	$ver4=0;
	$ver5=0;
	$ver6=0;
	$ver7=0;

	$j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;
	$z = 1 ;

	$id_dev=0;

	_begin();

	$fecha=date("Y-m-d");
	$hora=date("H:i:s");


	$array = json_decode($array_json,true);
	//$listadatos=explode('#',$stringdatos);

	/*insertar la devolucion*/
	$table="devoluciones";
	$form_data = array(
		'id_factura' => $id_factura,
		'cant' => $totcant,
		'monto'=> $monto_a_devolver,
		'fecha'=> $fecha,
		'hora'=>$hora,

	);
	$insertar=_insert($table,$form_data);
	if ($insertar) {
		# code...
		$id_dev=_insert_id();
	}
	else
	{
		$ver1=1;
	}

	$correlative=0;
	$ult_dev=0;
	$tipo_documento="";

	if ($tipo=="CCF") {
		# code...
		/*obtener correlativo y actualizarlo*/
		$sql="select * from correlativo where id_sucursal='$id_sucursal'";
		$result= _query($sql);
		$rows=_fetch_array($result);
		$ult_dev=$rows['nc'];
		$ult_dev=$ult_dev+1;



		$correlative=str_pad($ult_dev, 7, '0', STR_PAD_LEFT);

		$correlative.='_NC';

		$table='correlativo';
		$form_data = array(
			'nc' => $ult_dev,
		);
		$where_clause="id_sucursal='".$id_sucursal."'";
		$update=_update($table,$form_data,$where_clause);
		if ($update) {
			# code...
		}
		else {
			# code...
			$ver4=1;
		}
		$tipo_documento="NC";
	}
	if(false) {
		# code...
		/*obtener correlativo y actualizarlo DEV*/
		$sql="select * from correlativo where id_sucursal='$id_sucursal'";
		$result= _query($sql);
		$rows=_fetch_array($result);
		$ult_dev=$rows['dev'];
		$ult_dev=$ult_dev+1;



		$correlative=str_pad($ult_dev, 7, '0', STR_PAD_LEFT);

		$correlative.='_DEV';

		$table='correlativo';
		$form_data = array(
			'dev' => $ult_dev,
		);
		$where_clause="id_sucursal='".$id_sucursal."'";
		$update=_update($table,$form_data,$where_clause);
		if ($update) {
			# code...
		}
		else {
			# code...
			$ver4=1;
		}
		$tipo_documento="DEV";
	}

	$id_user=$_SESSION['id_usuario'];

	$num_fact_impresa="";

	/*agregar la factura*/
	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND fecha='$fecha' AND id_empleado = '$id_user'");
	$row_apertura = _fetch_array($sql_apertura);
	$id_apertura = $row_apertura["id_apertura"];
	$turno = $row_apertura["turno"];
	$caja= $row_apertura['caja'];

	if ($tipo !='CCF') {
		$sql_corre = _query("SELECT * FROM caja WHERE id_caja = '$caja'");
		$row_corre = _fetch_array($sql_corre);
		$correlativo_dispo = $row_corre["correlativo_dispo"];
		$tipo_entrada_salida='TICKET';
		$data_numdoc = array(
			'correlativo_dispo' => $correlativo_dispo+1,
		);
		$num_fact_impresa=$correlativo_dispo;
		$numero_doc=numero_tiquete($correlativo_dispo, "DEV");
		$correlative = $numero_doc;
		$tab = 'caja';
		$where_clause_c=" WHERE id_caja='$caja'";
		$insertar_numdoc = _update($tab, $data_numdoc, $where_clause_c);
		$tipo_documento='DEV';
	}

	$numero_doc=$correlative;

	$id_factura_nueva=0;
	$table='factura';
	$form_data = array(
		'id_cliente' => $id_cliente,
		'fecha' => $fecha,
		'numero_doc' => $numero_doc,
		'subtotal' => $monto_a_devolver,
		'sumas'=>$monto_a_devolver,
		'suma_gravado'=>$monto_a_devolver,
		'iva' =>0,
		'retencion'=>0,
		'venta_exenta'=>0,
		'total_menos_retencion'=>$monto_a_devolver,
		'total' => $monto_a_devolver,
		'id_usuario'=>$id_user,
		'id_empleado' => 0,
		'id_sucursal' => $id_sucursal,
		'tipo' => "DEVOLUCION",
		'hora' => $hora,
		'finalizada' => '1',
		'abono'=>0,
		'saldo' => 0,
		'tipo_documento' => $tipo_documento,
		'id_apertura' => $id_apertura,
		'id_apertura_pagada' => $id_apertura,
		'caja' => $caja,
		'credito' => 0,
		'turno' => $turno,
		'afecta' => $id_factura,
		'num_fact_impresa' => $num_fact_impresa,
	);
	$insertar=_insert($table,$form_data);
	if ($insertar) {
		# code...
		$id_factura_nueva=_insert_id();
	}
	else {
		$ver5=1;
	}

	$table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => "DEVOLUCION",
    'total' => $monto_a_devolver,
    'tipo' => 'ENTRADA',
    'proceso' => 'DEV',
    'referencia' => $numero_doc,
    'id_empleado' => $_SESSION['id_usuario'],
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    'id_suc_destino' => $id_sucursal,
    'id_proveedor' => 0,
		'id_factura' => $id_factura_nueva,
  );
	$insertarM = _insert($table,$form_data);

	$id_movimiento=-1;
	if ($insertarM) {
		# code...
		$id_movimiento=_insert_id();
	}
	else {
		# code...
		$ver7=1;

	}

	/*fcactura detalle*/
	foreach ($array as $fila){
		$id_producto=$fila['id_producto'];
		$cant=$fila['cant'];
		$monto=$fila['monto'];
		$unidades=$fila['unidades'];
		$id_fatura_detalle=$fila['id_factura_detalle'];
		$id_presentacion=$fila['id_presentacion'];
		$precio_venta=$fila['precio_venta'];
		$cant=$cant*$unidades;

		$sql_e= _fetch_array(_query("SELECT exento FROM producto WHERE id_producto='$id_producto'"));

		$table='factura_detalle';
		$form_data = array(
			'id_factura' => $id_factura_nueva,
			'id_prod_serv' => $id_producto,
			'cantidad' => $cant,
			'precio_venta' => $precio_venta,
			'subtotal' => $monto,
			'tipo_prod_serv' => "PRODUCTO",
			'id_empleado' => $_SESSION['id_usuario'],
			'id_sucursal' => $id_sucursal,
			'fecha' => $fecha,
			'id_presentacion'=> $id_presentacion,
			'exento' => $sql_e['exento'],
		);
		$insertar=_insert($table,$form_data);
		if ($insertar) {
			# code...

		}
		else {
			# code...
			$ver6=1;
		}
	}



	/*insertar los detalles de la devolucion*/
	foreach ($array as $fila){
		$id_producto=$fila['id_producto'];
		$cant=$fila['cant'];
		$monto=$fila['monto'];
		$unidades=$fila['unidades'];
		$id_fatura_detalle=$fila['id_factura_detalle'];
		$cantidad=$cant;
		$id_presentacion=$fila['id_presentacion'];
		$precio_venta=$fila['precio_venta'];

		$sql_lote = _query("SELECT MAX(lote.vencimiento) as vence FROM lote WHERE lote.id_producto='$id_producto'");
    $datos_lote = _fetch_array($sql_lote);
    $fecha_caduca = $datos_lote["vence"];

    $sql_costo = _query("SELECT costo FROM presentacion_producto WHERE id_presentacion=$id_presentacion");
    $datos_costo = _fetch_array($sql_costo);
    $precio_costo = $datos_costo["costo"];

		$table='devoluciones_det';
		$form_data = array(
			'id_dev' => $id_dev,
			'id_factura' => $id_factura,
			'id_producto' => $id_producto,
			'cant' => $cant,
			'monto' => $monto,
			'id_factura_detalle'=>$id_fatura_detalle,
		);
		$insertar=_insert($table,$form_data);
		if ($insertar) {
			# code...

		}
		else {
			# code...
			$ver2=1;
		}

		/*meterlo al local sin asignarlo*/

		$orig=_fetch_array(_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE ubicacion.bodega=0 AND ubicacion.id_sucursal=$id_sucursal"));
		$destino=$orig['id_ubicacion'];

		$sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";
    $stock_su=_query($sql_su);
    $nrow_su=_num_rows($stock_su);
    $id_su="";
		/*cantidad de una presentacion por la unidades que tiene*/
		$cantidad=$cantidad*$unidades;
		if($nrow_su >0)
		{
			$row_su=_fetch_array($stock_su);
			$cant_exis = $row_su["cantidad"];
			$id_su = $row_su["id_su"];
			$cant_new = $cant_exis + $cantidad;
			$form_data_su = array(
				'cantidad' => $cant_new,
			);
			$table_su = "stock_ubicacion";
			$where_su = "id_su='".$id_su."'";
			$insert_su = _update($table_su, $form_data_su, $where_su);
		}
		else {
			$form_data_su = array(
				'id_producto' => $id_producto,
        'id_sucursal' => $id_sucursal,
        'cantidad' => $cantidad,
        'id_ubicacion' => $destino,
        'id_estante' => 0,
        'id_posicion' => 0,
			);
			$table_su = "stock_ubicacion";
			$insert_su = _insert($table_su, $form_data_su);

			$id_su = _insert_id();

		}

		if(!$insert_su)
		{
			$m=0;
		}

		$sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
    $stock2=_query($sql2);
    $row2=_fetch_array($stock2);
    $nrow2=_num_rows($stock2);
    if ($nrow2>0)
    {
      $existencias=$row2['stock'];
		}

		$sql_lot = _query("SELECT MAX(numero) AS ultimo FROM lote WHERE id_producto='$id_producto'");
    $datos_lot = _fetch_array($sql_lot);
    $lote = $datos_lot["ultimo"]+1;
    $table1= 'movimiento_producto_detalle';
    $cant_total=$cantidad+$existencias;
    $form_data1 = array(
      'id_movimiento'=>$id_movimiento,
      'id_producto' => $id_producto,
      'cantidad' => $cantidad,
      'costo' => $precio_costo,
      'precio' => $precio_venta,
      'stock_anterior'=>$existencias,
      'stock_actual'=>$cant_total,
      'lote' => $lote,
      'id_presentacion' => $id_presentacion,
			'fecha' => $fecha,
			'hora' => $hora,
    );
    $insert_mov_det = _insert($table1,$form_data1);
    if(!$insert_mov_det)
    {
      $j = 0;
    }

		$table2= 'stock';
		$cant_total=$cantidad+$existencias;
		$form_data2 = array(
			'id_producto' => $id_producto,
			'stock' => $cant_total,
			'costo_unitario'=>round(($precio_costo/$unidades),2),
			'precio_unitario'=>round(($precio_venta/$unidades),2),
			'update_date'=>$fecha,
			'id_sucursal' => $id_sucursal
		);
		$where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
		$insert_stock = _update($table2,$form_data2, $where_clause );

		if(!$insert_stock)
		{
			$k = 0;
		}



    $estado='VIGENTE';
    $table_perece='lote';
    $form_data_perece = array(
      'id_producto' => $id_producto,
      'referencia' => $id_movimiento,
      'numero' => $lote,
      'fecha_entrada' => date("Y-m-d"),
      'vencimiento'=>$fecha_caduca,
      'precio' => $precio_costo,
      'cantidad' => $cantidad,
      'estado'=>$estado,
      'id_sucursal' => $_SESSION['id_sucursal'],
      'id_presentacion' => $id_presentacion,
    );
    $insert_lote = _insert($table_perece,$form_data_perece );

		if(!$insert_lote)
		{
			$l = 0;
		}

		$table="movimiento_stock_ubicacion";
    $form_data = array(
      'id_producto' => $id_producto,
      'id_origen' => 0,
      'id_destino'=> $id_su,
      'cantidad' => $cantidad,
      'fecha' => $fecha,
      'hora' => $hora,
      'anulada' => 0,
      'afecta' => 0,
      'id_sucursal' => $id_sucursal,
      'id_presentacion'=> $id_presentacion,
      'id_mov_prod' => $id_movimiento,
    );

    $insert_mss =_insert($table,$form_data);

    if ($insert_mss) {
      # code...
    }
    else {
      # code...
      $z=0;
    }


	}






	if($ver1==0&&$ver2==0&&$ver4==0&&$ver4==0&&$ver5==0&&$ver6==0&&$ver7==0&&$j&&$k&&$l&&$m&&$z){
			_commit();
		 $xdatos['typeinfo']='Success';
		 $xdatos['msg']='Registro insertado con éxito !';
		 $xdatos['process']='insert';
		 $xdatos['id_factura']=$id_factura_nueva;
		 $xdatos['numdoc']=$correlative;
	}
	else{
		_rollback();
		 $xdatos['typeinfo']='Error';
		 $xdatos['msg']='Error al insertar!'.$ver1.$ver2.$ver4.$ver5.$ver6.$ver7.$j.$k.$l.$m.$z;
			$xdatos['process']='none';
	}

	echo json_encode($xdatos);

}

function numero_tiquete($ult_doc, $tipo)
{
  $ult_doc=trim($ult_doc);
  $len_ult_valor=strlen($ult_doc);
  $long_num_fact=10;
  $long_increment=$long_num_fact-$len_ult_valor;
  $valor_txt="";
  if ($len_ult_valor<$long_num_fact) {
    for ($j=0;$j<$long_increment;$j++) {
      $valor_txt.="0";
    }
  } else {
    $valor_txt="";
  }
  $valor_txt=$valor_txt.$ult_doc."_".$tipo;
  return $valor_txt;
}

function act()
{
	$numero = $_POST['numero'];
	$id_factura = $_POST['id_factura'];
	$table='factura';
	$form_data = array(
		'num_fact_impresa' => $numero,
	);
	$where_clause="id_factura = '".$id_factura."'";
	$update = _update($table,$form_data,$where_clause);
	if ($update) {
		# code...
		$xdatos['ok']='ok';
	}

	echo json_encode($xdatos);

}

function imprimir_fact(){
	$numero_doc = $_POST['numero_doc'];
  $id_factura= $_POST['num_doc_fact'];
	$id_sucursal=$_SESSION['id_sucursal'];
	$tipo_impresion= 'DEV';
	$tipo_entrada_salida="DEVOLUCION NOTA DE CREDITO";
	$numero_factura_imprimir = $_POST['numero_factura_imprimir'];
	if   ($tipo_impresion=='COF'){
		$tipo_entrada_salida="FACTURA CONSUMIDOR";
	}
	if   ($tipo_impresion=='ENV'){
		$tipo_entrada_salida="NOTA DE ENVIO";
	}
	if   ($tipo_impresion=='NCR'){
		$tipo_entrada_salida="NOTA DE CREDITO";
	}
	if   ($tipo_impresion=='TIK'){
		$tipo_entrada_salida="TICKET";
	}
	if  ($tipo_impresion=='CCF'){
		$tipo_entrada_salida="CREDITO FISCAL";
		$nit= $_POST['nit'];
		$nrc= $_POST['nrc'];
	}
	if (isset($_POST['nombreape'])){
		$nombreape= $_POST['nombreape'];
	}
	if (isset($_POST['direccion'])){
		$direccion= $_POST['direccion'];
	}

	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';

	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$fecha_movimiento=$row_fact['fecha'];
			$id_cliente=$row_fact['id_cliente'];
		$table_fact= 'factura';

		$form_data_fact = array(
			'finalizada' => '1',
			'impresa' => '1',
			'num_fact_impresa'=>$numero_factura_imprimir,
		);

		$where_clause="WHERE id_factura='$id_factura'";
		$actualizar = _update($table_fact,$form_data_fact, $where_clause );
	}
	//cambiar numero documento impreso para mostrar en reporte kardeX
	$where_clause1=" WHERE
	tipo_entrada_salida='$tipo_entrada_salida'
	AND numero_doc='$numero_doc'
	AND fecha_movimiento='$fecha_movimiento'
	";

	$table1= 'movimiento_producto';
	$form_data1 = array(
		'numero_doc'=>$id_factura,
	);
	$insertar1 = _update($table1,$form_data1,$where_clause1);
	$sql="SELECT * FROM cliente
	WHERE
	id_cliente='$id_cliente'";

	$result=_query($sql);
	$count=_num_rows($result);
	if ($count > 0) {
		for($i = 0; $i < $count; $i ++) {
			$row = _fetch_array ( $result);
			$id_cliente=$row["id_cliente"];
			$nombre=$row["nombre"];
			$direccion=$row["direccion"];
			$nit=$row["nit"];
			$dui=$row["dui"];
			$nrc=$row["nrc"];
			$nombreape=$nombre;
		}
	}
	if ($tipo_impresion=='COF'){
		$info_facturas=print_fact($id_factura,$tipo_impresion,$nombreape,$direccion);
	}
	if ($tipo_impresion=='CCF'){
		$info_facturas=print_ccf($id_factura,$tipo_impresion,$nit,$nrc,$nombreape,$direccion);
	}
	if ($tipo_impresion=='ENV'){
		$info_facturas=print_envio($id_factura,$tipo_impresion,$nombreape,$direccion);
	}
	if ($tipo_impresion=='DEV'){
		$info_facturas=print_ncr($id_factura,$tipo_impresion,$nombreape,$direccion);
	}
	//directorio de script impresion cliente
	$headers="";
	$footers="";
	if ($tipo_impresion=='TIK') {
		$info_facturas=print_ticket($id_factura, $tipo_impresion);
		$sql_pos="SELECT *  FROM sucursal  WHERE id_sucursal='$id_sucursal' ";
		$result_pos=_query($sql_pos);
		$row1=_fetch_array($result_pos);
		$headers=$row1['descripcion']."|".Mayu($row1['direccion'])."|".$row1['giro']."|";
		$footers="GRACIAS POR SU COMPRA, VUELVA PRONTO......"."|";
	}

	$sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
	$result_dir_print=_query($sql_dir_print);
	$row_dir_print=_fetch_array($result_dir_print);
	$dir_print=$row_dir_print['dir_print_script'];
	$shared_printer_win=$row_dir_print['shared_printer_matrix'];
	$shared_printer_pos=$row_dir_print['shared_printer_pos'];
	$nreg_encode['shared_printer_win'] =$shared_printer_win;
	$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
	$nreg_encode['dir_print'] =$dir_print;
	$nreg_encode['facturar'] =$info_facturas;
	$nreg_encode['sist_ope'] =$so_cliente;
	$nreg_encode['headers'] =$headers;
	$nreg_encode['footers'] =$footers;
	echo json_encode($nreg_encode);
}

if(!isset($_POST['process'])){
	initial();
}
else
{
if(isset($_POST['process'])){
switch ($_POST['process']) {
	case 'insert':
		insert_sucursal();
		break;
	case 'devolver':
		devolucion();
		break;
	case 'act':
		act();
		break;
	case 'imprimir_fact':
		imprimir_fact();
		break;

	}
}
}
?>
