<?php
include_once "_core.php";
function initial()
{
	$title='Agregar Producto';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/upload_file/fileinput.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$valores="";
	$origen="";
	$concepto="";
	$fecha="";
	if (isset($_POST['id_origen']))
	{
		# code...
		if(isset($_POST['params']))
		{
			$valores=$_POST['params'];
			$origen=$_POST['id_origen'];
			$concepto=$_POST['con'];
			$fecha=$_POST['fecha'];
			$id_su=$_POST['stock_u'];

		}
	}
	?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2">
		</div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<?php
					if ($links!='NOT' || $admin=='1'  && $valores!="" && $origen!=""){
						?>
						<div class="ibox-title">
							<h5>Agregar Asignacion de Producto <?php /*echo $valores.$origen;*/ ?></h5>
						</div>
						<div class="ibox-content">
							<form name="formulario" id="formulario" autocomplete="off">
								<div class="row">
									<table class='table table-striped'>
										<thead>
											<tr>
												<th>Producto</th>
												<th>Estante</th>
												<th>Posición</th>
												<th>Presentación</th>
												<th>Cantidad</th>
											</tr>
										</thead>
										<tbody>

									<?php
									$array = json_decode($valores, true);
							    foreach ($array as $fila) {
										$sql=_fetch_array(_query("SELECT * FROM producto WHERE id_producto=$fila[id_prod]"));
									?>

												<?php
												for ($j=0; $j < $fila['cantidad']; $j++)
												{

												?>
												<tr>
													<td class="col-lg-4">
														<?php echo $sql['descripcion']." "; ?>
														, U. ASIGNABLES:
														<?php echo " ".$fila['existencia'] ?>


													</td>
													<td class="col-lg-2">
														<select class="estante select" style="width:100%" name="">
															<option value="">Seleccione</option>
															<?php
															$sql_e=_query("SELECT * FROM estante WHERE id_ubicacion=$origen");
															while ($row=_fetch_array($sql_e)) {
																# code...
																?>
																<option value="<?php echo $row['id_estante'] ?>"><?php echo $row['descripcion'] ?></option>
																<?php
															}
															 ?>
														</select>
														<input type="hidden" class="id_producto" name="" value="<?php echo $fila['id_prod'] ?>">
														<input type="hidden" class="existencia" name="" value="<?php echo $fila['existencia'] ?>">
													</td>
													<td class="col-lg-2">
														<select class="posicion select" style="width:100%" name="">
															<option value="">Seleccione</option>
														</select>
													</td>
													<td class="col-lg-2">
														<select class="sel" style="width:100%" name="">
															<?php
															$sql_p=_query("SELECT presentacion.nombre,producto.id_categoria, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio
																										FROM presentacion_producto AS prp
																										JOIN presentacion ON presentacion.id_presentacion=prp.presentacion
																										JOIN producto ON prp.id_producto=producto.id_producto
																										WHERE prp.id_producto=$fila[id_prod]
																										AND prp.activo=1 AND prp.id_sucursal=$_SESSION[id_sucursal]");
															$i=0;
															$unidadp=0;
															$costop=0;
															$preciop=0;
															$descripcionp="";
															$categoria="";
															while ($row=_fetch_array($sql_p))
															{
																if ($i==0)
																{
																	$unidadp=$row['unidad'];
																	$descripcionp=$row['descripcion'];
																	$categoria=$row['id_categoria'];
																}
																echo "<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
																$i=$i+1;
															}

															 ?>

														</select>
														<input type='hidden' class='unidad' value='<?php echo $unidadp; ?>'>
													</td>
													<td class="col-lg-2">
														<input type="text" class="form-control cant <?php echo $categoria ?>"  name="" value="">
													</td>
												</tr>
												<?php
												}
													# code...
												  ?>

										<?php
									}
									 ?>
								 </tbody>
							 </table>
								</div>
								<div>
									<input type="hidden" name="process" id="process" value="insert"><br>
									<input type="hidden" name="id_origen" id="id_origen" value="<?php echo $origen ?>">
									<input type="hidden" name="id_su" id="id_su" value="<?php echo $id_su ?>">
									<input type="hidden" name="fecha" id="fecha" value=" <?php echo date("Y-m-d") ?>">
									<input type="hidden" name="concepto" id="concepto" value="<?php echo $concepto ?>">
									<input type="button" id="insertar" name="insertar" value="Guardar" class="btn btn-primary m-t-n-xs" />
								</div>
							</form>
						</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include_once ("footer.php");
		echo "<script src='js/funciones/funciones_reasignacion.js'></script>";
	}
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include_once ("footer.php");
	}
}
function insertar()
{

	$concepto=$_POST['concepto'];
	$fecha=$_POST['fecha'];
	$id_ubicacion=$_POST['origen'];
	$id_sucursal=$_SESSION['id_sucursal'];
	$valores=$_POST['valores'];
	$id_empleado=$_SESSION['id_usuario'];

	$id_sua=$_POST['id_su'];
	$hora=date("H:i:s");
	$z=1;
	$m=1;

	_begin();

	$sql_num = _query("SELECT ai FROM correlativo WHERE id_sucursal='$id_sucursal'");
	$datos_num = _fetch_array($sql_num);
	$ult = $datos_num["ai"]+1;
	$numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_AI';
	$tipo_entrada_salida='ASIGNACION DE INVENTARIO';

	/*actualizar los correlativos de AI*/
	$corr=1;
	$up=1;

	$table="correlativo";
	$form_data = array(
		'ai' =>$ult
	);
	$where_clause_c="id_sucursal='".$id_sucursal."'";
	$up_corr=_update($table,$form_data,$where_clause_c);
	if ($up_corr) {
		# code...
	}
	else {
		$corr=0;
	}

	$table='movimiento_producto';
	$form_data = array(
		'id_sucursal' => $id_sucursal,
		'correlativo' => $numero_doc,
		'concepto' => $concepto,
		'total' => 0,
		'tipo' => 'ASIGNACION',
		'proceso' => 'AI',
		'referencia' => $numero_doc,
		'id_empleado' => $id_empleado,
		'fecha' => $fecha,
		'hora' => $hora,
		'id_suc_origen' => $id_sucursal,
		'id_suc_destino' => $id_sucursal,
		'id_proveedor' => 0,
	);
	$insert_mov =_insert($table,$form_data);
	$id_movimiento=_insert_id();
	$array = json_decode($valores, true);
	foreach ($array as $fila) {

		$id_producto=$fila['id_producto'];

		$sql=_fetch_array(_query("SELECT * FROM stock_ubicacion WHERE id_sucursal=$id_sucursal AND id_su=$id_sua"));

		$id_su1=$sql['id_su'];
		$stock_anterior=$sql['cantidad'];

		$nuevo_stock=$stock_anterior-$fila['cantidad'];

		$table="stock_ubicacion";
		$form_data = array(
			'cantidad' => $nuevo_stock,
		);
		$where_clause="id_su='".$id_su1."'";
		$update=_update($table,$form_data,$where_clause);
		if ($update) {
			# code...
		}
		else {
			$up=0;
		}

		/*Verificar tabla stock_ubicacion*/
		$sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$id_ubicacion' AND id_estante=$fila[id_estante] AND id_posicion=$fila[id_posicion] ";

		$stock_su=_query($sql_su);
		$nrow_su=_num_rows($stock_su);
		$id_su="";

		/*cantidad de una presentacion por la unidades que tiene desde javascript*/
		$cantidad=$fila['cantidad'];
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
		else
		{
			$form_data_su = array(
				'id_producto' => $id_producto,
				'id_sucursal' => $id_sucursal,
				'cantidad' => $cantidad,
				'id_ubicacion' => $id_ubicacion,
				'id_estante'=>$fila['id_estante'],
				'id_posicion'=>$fila['id_posicion'],
			);
			$table_su = "stock_ubicacion";
			$insert_su = _insert($table_su, $form_data_su);
			$id_su=_insert_id();
		}
		if(!$insert_su)
    {
      $m=0;
    }

		$table="movimiento_stock_ubicacion";
    $form_data = array(
      'id_producto' => $id_producto,
      'id_origen' => $id_su1,
      'id_destino'=> $id_su,
      'cantidad' => $cantidad,
      'fecha' => $fecha,
      'hora' => $hora,
      'anulada' => 0,
      'afecta' => 0,
      'id_sucursal' => $id_sucursal,
      'id_presentacion'=> $fila['id_presentacion'],
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

	if($corr&&$z&&$m)
	{
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Registro ingresado con exito!';
		$xdatos['process']='insert';
		_commit();
	}
	else
	{
		_rollback();
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Registro no pudo ser ingresado !';
		$xdatos['process']='insert';
	}

	echo json_encode($xdatos);
}
function lista()
{
	$lista = "";
	$sql_presentacion = _query("SELECT * FROM presentacion");
	$cuenta = _num_rows($sql_presentacion);
	if($cuenta > 0)
	{
		$lista.= "<select id='presen' class='col-md-12 select2 valcel'>";
		$lista.= "<option value='0'>Seleccione</option>";
		while ($row = _fetch_array($sql_presentacion))
		{
			$id_presentacion = $row["id_presentacion"];
			$descripcion = $row["descripcion_pr"];
			$lista.= "<option value=".$id_presentacion.">".$descripcion."</option>";
		}
		$lista.="</select>";
	}
	$xdatos['select'] = $lista;
	echo json_encode($xdatos);
}
function getpresentacion()
{
  $id_presentacion =$_REQUEST['id_presentacion'];
  $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
  $precio=$sql['precio'];
  $unidad=$sql['unidad'];
  $descripcion=$sql['descripcion'];
  $costo=$sql['costo'];
  $xdatos['precio']=$precio;
  $xdatos['costo']=$costo;
  $xdatos['unidad']=$unidad;
  $xdatos['descripcion']=$descripcion;
  echo json_encode($xdatos);
}

function posicion()
{
    $id_estante = $_POST["id_estante"];
		$id_origen = $_POST['id_origen'];
    $sql = _query("SELECT * FROM posicion WHERE id_estante='$id_estante' AND id_ubicacion='$id_origen'");
    $opt = "<option value=''>Seleccione</option>";
    while ($row = _fetch_array($sql)) {
        $opt .="<option value='".$row["id_posicion"]."'>".$row["posicion"]."</option>";
    }
    $xdatos["typeinfo"] = "Success";
    $xdatos["opt"] = $opt;
    echo json_encode($xdatos);
}

if(!isset($_POST['process']))
{
	initial();
}
else
{
	if(isset($_POST['process']))
	{
		switch ($_POST['process'])
		{
			case 'asignar':
			insertar();
			break;
			case 'lista':
			lista();
			break;
			case 'getpresentacion':
	    getpresentacion();
	    break;
			case 'val':
	    posicion();
	    break;
		}
	}
}
?>
