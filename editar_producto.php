<?php
include_once "_core.php";
function initial()
{
	$_PAGE = array ();
	$title='Editar Producto';
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/upload_file/fileinput.css" rel="stylesheet">';

	include_once "header.php";
	//permiso del script

	$id_sucursal=$_SESSION['id_sucursal'];
	$id_producto = $_REQUEST['id_producto'];

	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user, $filename);

	// Producto, si existe
	$sql="SELECT * FROM producto WHERE id_producto='$id_producto'";
	$result=_query($sql);
	$row=_fetch_array($result);
	$descripcion=$row['descripcion'];
	$barcode=$row['barcode'];
	$marca=$row['marca'];
	$estado=$row['estado'];
	$exento=$row['exento'];
	$decimals=$row['decimals'];
	$id_proveedor=$row['id_proveedor'];
	$minimo=$row['minimo'];
	$perecedero=$row['perecedero'];
	$id_categoria=$row['id_categoria'];
	$imagen=$row['imagen'];

	// categoria
	$arrayCat = array();
	$qcategoria=_query("SELECT * FROM categoria ORDER BY nombre_cat ASC");
	while($row_cat=_fetch_array($qcategoria))
	{
		$idCat=$row_cat['id_categoria'];
		$description=$row_cat['nombre_cat'];
		$arrayCat[$idCat] = $description;
	}
	//presentacion
	$qpresentacion=_query("SELECT * FROM presentacion ORDER BY nombre ASC");
	while($row_pr=_fetch_array($qpresentacion))
	{
		$idPr=$row_pr['id_presentacion'];
		$description=$row_pr['nombre'];
		$arrayPr[$idPr] = $description;
	}

	$provssa=_query("SELECT * FROM proveedor ORDER BY nombre ASC");
	while($row_pr=_fetch_array($provssa))
	{
		$idPr=$row_pr['id_proveedor'];
		$description=$row_pr['nombre'];
		$arrayPro[$idPr] = $description;
	}
	?>
	<style media="screen">
	table tbody td.ed::before{
		content:'\f044';
		position:relative;
		top: -10px;
		right: 9px;

		font: normal normal normal 14px/1 FontAwesome
	}
	.fileinput-upload-button
	{
		display:none;
	}
	</style>
	<div class="gray-bg">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<?php	if ($links!='NOT' || $admin=='1' ){ ?>
						<div class="ibox-title">
							<div class="row">
                <div class="col-lg-9">
                  <h5><?php echo $title; ?> </h5>
                </div>
                <div class="col-lg-3">
                  <a href="admin_producto.php">
                    <button style="margin:0px;" type="button" class="btn btn-danger pull-right" name="button"> <i class="fa  fa-mail-reply"></i> Salir</button>
                  </a>
									<a id="btn_img" name="btn_img" class="btn btn-primary m-t-n-xs pull-right" style="margin-right:10px; margin-top: 1px;"><i class="fa fa-image"></i> Agregar Imagen</a>
                </div>
              </div>
						</div>
						<div class="ibox-content">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Código de Barra </label>
											<input type="text" placeholder="Digite Código de Barra" class="form-control" id="barcode" name="barcode" value="<?php echo $barcode ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Descripción</label>
											<input type="text" placeholder="Descripcion" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion?>">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group has-info single-line">
											<label>Marca</label>
											<input type="text" placeholder="Marca" class="form-control" id="marca" name="marca" value="<?php echo $marca?>">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group has-info single-line">
											<label>Stock Minimo</label>
											<input type="text" placeholder="Minimo" class="form-control" id="minimo" name="minimo" value="<?php echo $minimo?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-3">
										<div class="form-group has-info single-line">
											<label>Proveedor &nbsp;</label>
											<?php
											$select=crear_select2("proveedor",$arrayPro,$id_proveedor,"width:100%;");
											echo $select;
											?>
										</div>
									</div>
									<div class="form-group col-sm-3">
										<div class="form-group has-info single-line">
											<label>Categoria &nbsp;</label>
											<?php
											$select=crear_select2("id_categoria",$arrayCat,$id_categoria,"width:100%;");
											echo $select;
											?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group has-info single-line">
													<label class="control-label">Exento de IVA </label>
													<?php
													if($exento==1)
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='exento' name='exento' value='1' checked> <i></i>  </label></div>";
													}
													else
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='exento' name='exento' value='1'> <i></i>  </label></div>";
													}
													?>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group has-info single-line">
													<label class="control-label">Producto perecedero </label>
													<?php
													if($perecedero==1)
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='perecedero' name='perecedero' value='1' checked> <i></i>  </label></div>";
													}
													else
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='perecedero' name='perecedero' value='1'> <i></i>  </label></div>";
													}
													?>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group has-info single-line">
													<label class="control-label">Activo </label>
													<?php
													if($estado==1 or $estado==true)
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='activo' name='activo' value='1' checked> <i></i>  </label></div>";
													}
													else
													{
														echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='activo' name='activo' value='1'> <i></i>  </label></div>";
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group has-info single-line">
											<label class="control-label">Venta decimal</label>
											<?php
											if($decimals==1 or $decimals==true)
											{
												echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='decimal' name='decimal' value='1' checked> <i></i>  </label></div>";
											}
											else
											{
												echo "<div class='checkbox i-checks'><label> <input type='checkbox'  id='decimal' name='decimal' value='1'> <i></i>  </label></div>";
											}
											?>

										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12"><br>
										<div class=" alert-warning text-center " style="font-weight: bold; border: 2px solid #8a6d3b; border-radius: 25px; margin-bottom:20px;"><h3>Presentaciones</h3></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Presentación</label>
											<?php
											$select=crear_select2("id_presentacion",$arrayPr,"","width:100%;");
											echo $select;
											?>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Descripción</label>
											<input type="text" name="desc_pre" id="desc_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Unidades</label>
											<input type="text" name="unidad_pre" id="unidad_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Costo</label>
											<input type="text" name="costo_pre" id="costo_pre" class="form-control clear">
										</div>
									</div>
									<div hidden class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Precio</label>
											<input type="text" name="precio_pre" id="precio_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Código de Barra</label>
											<br>
											<input type="text" name="bar" id="bar" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info">
											<br>
											<br>
											<a  class="btn btn-primary" id="add_pre"><i class="fa fa-plus"></i> Agregar</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-hover table-bordered">
											<thead>
												<tr>
													<th class="col-md-1">Cod. de Barra</th>
													<th class="col-md-1">Presentación</th>
													<th class="col-md-1">Descripción</th>
													<th class="col-md-1">Unidad</th>
													<th class="col-md-1">Costo</th>
													<th class="col-md-1">Precio 1</th>
													<th class="col-md-1">Precio 2</th>
													<th class="col-md-1">Precio 3</th>
													<th class="col-md-1">Precio 4</th>
													<th class="col-md-1">Precio 5</th>
													<th class="col-md-1">Precio 6</th>
													<th class="col-md-1">Precio 7</th>
													<th class="col-md-1">Acción</th>
												</tr>
											</thead>
											<tbody id="presentacion_table">
												<?php
												$sql_p = _query("SELECT * FROM presentacion_producto WHERE id_producto = '$id_producto'");
												$n = 0;
												while ($row_p = _fetch_array($sql_p))
												{
													$id_presentacion_pro = $row_p["id_pp"];
													$pres = $row_p["id_presentacion"];
													$sql_present1 = _query("SELECT * FROM presentacion WHERE id_presentacion = '$pres'");
													$pr = _fetch_array($sql_present1);
													$descrip_pr = $pr["nombre"];
													$des = $row_p["descripcion"];
													$uni = $row_p["unidad"];
													$pre = $row_p["precio"];
													$costo = $row_p["costo"];
													$activo = $row_p["activo"];
													$bar = $row_p["barcode"];
													if($activo)
													{
														echo "<tr class='exis' style='background: #BDECB6;'>";
													}
													else
													{
														echo "<tr class='exis' style='background: #CDCDCD;'>";
													}
													echo "<td class='bar ed3'>".$bar."</td>";
													echo "<td><input type='hidden' class='id_pres_prod' value='".$id_presentacion_pro."'><input type='hidden' class='presentacion' value='".$pres."'>".$descrip_pr."</td>";
													echo "<td class='descripcion_p ed3'>".$des."</td>";
													echo "<td class='unidad_p'>".$uni."</td>";
													echo "<td class='costo ed'>".$costo."</td>";

													$array_precios = _getPrecios($id_presentacion_pro);

													foreach ($array_precios as $key => $value) {
														// code...
														echo "<td class='precio$key ed'>".$value."</td>";
													}
													if($activo)
													{
														echo "<td class='text-center'><a class='deactive' id='".$id_presentacion_pro."'><i class='fa fa-eye iconsa'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a></td>";
													}
													else
													{
														echo "<td class='text-center'><a class='activate' id='".$id_presentacion_pro."'><i class='fa fa-eye-slash iconsa'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a> </td>";
													}
													$n++;
												}

												?>
											</tbody>
										</table>
									</div>
								</div>
								<input type="hidden" name="process" id="process" value="edited">
								<input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename;?>">
								<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto; ?> ">
								<div class="row">
									<div class="col-lg-12">
										<button type="button" class="btn btn-primary m-t-n-xs" id="submit1" name="submit1">Guardar</button>
									</div>
								</div>

							<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-md'>
									<div class='modal-content modal-md'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->

							<div class='modal fade' id='viewProducto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class="modal-header">
											<button type="button" class="close" id='cerrar_ven' data-dismiss="modal"
											aria-hidden="true">&times;</button>
											<h4 class="modal-title">Editar Imagen de Producto</h4>
										</div>
										<div class="modal-body">
											<div class="wrapper wrapper-content  animated fadeInRight">
									            <form name="formulario_pro" id="formulario_pro" enctype='multipart/form-data' method="POST">
									              <div class="row">
									                <div class="col-md-12">
									                  <div class="form-group has-info single-line">
									                      <label>Producto</label>
									                      <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
																				<input type="hidden" name="id_id_p" id="id_id_p" value="<?php echo $id_producto; ?> ">
																				<input type="hidden" name="process" id="process" value="editar_img">
									                  </div>
									                </div>
									              </div>
									            </form>
															<div class="row">
																<div class="col-md-12">
																	<div class="col-lg-12 center-block">
												            <div class="widget style1 gray-bg text-center">
												              <div class="m-b-md" id='imagen'>
												                <img alt="image" class="img-rounded" src=<?php echo $imagen; ?> width="250px" height="150px" border='1'>
												              </div>
												            </div>
												          </div>
																</div>
															</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary" id="btnGimg">Aceptar</button>
												<button type="button" class="btn btn-default bb" data-dismiss="modal">Cerrar</button>
											</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->

						</div><!--div class='ibox-content'-->
					</div><!--<div class='ibox float-e-margins' -->
					</div> <!--div class='col-lg-12'-->
			<?php
			include 'footer.php';
			echo "<script src='js/funciones/funciones_producto.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include_once ("footer.php");
		}
	}
	function editar1()
	{
		global $precios_sistema;

		$id_sucursal=$_SESSION["id_sucursal"];
		$id_producto=$_POST['id_producto'];
		$descripcion=$_POST['descripcion'];
		$barcode=$_POST['barcode'];
		$marca=$_POST['marca'];
		$minimo=$_POST['minimo'];
		if($minimo == "undefined" || $minimo == ""){
			$minimo = 0;
		}
		$exento=$_POST['exento'];
		if($exento == "undefined" || $exento == ""){
			$exento = 0;
		}
		$estado=$_POST['estado'];
		$perecedero=$_POST['perecedero'];
		if ($perecedero=="undefined" || $perecedero == "") {
			$fecha_vencimiento=null;
			$perecedero = 0;
		}
		$id_categoria=$_POST['id_categoria'];
		$proveedor=$_POST['proveedor'];
		$lista = $_POST["lista"];
		$cuantos = $_POST["cuantos"];

		$decimals=$_POST["decimals"];
		if($decimals == "undefined" || $decimals == ""){
			$decimals = 0;
		}

		$descripcion=trim($descripcion);
		$descripcion=strtoupper($descripcion);
		$barcode=trim($barcode);
		$name_producto="";

		$selec = _query("SELECT * FROM presentacion_producto WHERE id_producto=$id_producto");
		$verp=1;

		if ($verp==1) {
			# code...
		//$descripcion = stripslashes($descripcion);
		//$descripcion = addslashes($descripcion);
		$descripcionN = _escapar_caracteres($descripcion);
		//echo $descripcionN;
		$sql_result=_query("SELECT id_producto,descripcion,barcode FROM producto WHERE descripcion='$descripcionN' AND id_producto!='$id_producto'");
		//echo "dskdsjksdkj";
		$name_producto = "";
		$numrows=_num_rows($sql_result);
		if($numrows > 0){
			$row_update=_fetch_array($sql_result);
			//echo $descripcion;
			//var_dump($row_update);
			$id_update=$row_update["id_producto"];
			$name_producto=trim($row_update["descripcion"]);
		}


		$descrip_producto_existe=false;

		if($name_producto!="" && $descripcion!="" )
		{
			$descrip_producto_existe=true;
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Registro no insertado, Descripción de Producto ya existe! ';
			$xdatos['process']='noinsert';
		}
		if ($barcode=="")
		{
			$barcodeexiste=false;
		}

		if ($barcode!="")
		{
			$sql_barcode="SELECT id_producto,descripcion,barcode FROM producto WHERE barcode='$barcode'  AND id_producto!='$id_producto' ";
			$sql_result_barcode=_query($sql_barcode);
			$numrows_barcode=_num_rows($sql_result_barcode);
			//echo $numrows_barcode."#";
			if($numrows_barcode>0)
			{
				$xdatos['typeinfo']='Error';
				$xdatos['msg']='El Barcode ya está asignado a otro producto !';
				$xdatos['process']='existbarcode';
				$barcodeexiste=true;
			}
			else
			{
				$barcodeexiste=false;
			}
		}
		_begin();
		$table = 'producto';
		$form_data = array (
			'descripcion' => $descripcion,
			'barcode' => $barcode,
			'marca' => $marca,
			'minimo' => $minimo,
			'id_proveedor' => $proveedor,
			'estado' => $estado,
			'exento' => $exento,
			'id_categoria' => $id_categoria,
			'perecedero' => $perecedero,
			'decimals' => $decimals,
		);
		$where_clause = "id_producto='" . $id_producto . "'";

		if(!$descrip_producto_existe)
		{
			if(!$barcodeexiste)
			{
				$updates = _update ($table, $form_data, $where_clause );

				$table_cambio="log_cambio_local";
				$form_data = array(
					'id_server' => '0',
					'process' => 'update',
					'tabla' =>  "producto",
					'fecha' => date("Y-m-d"),
					'hora' => date('H:i:s'),
					'id_usuario' => $_SESSION['id_usuario'],
					'id_sucursal' => $_SESSION['id_sucursal'],
					'id_primario' =>$id_producto,
					'prioridad' => "2",
					'subido' => '1',
					'verificado' => '0',
				);
				$insert_cambio=_insert($table_cambio,$form_data);
				$id_cambio=_insert_id();

				if($updates)
				{
					$explora = explode(";", $lista);
					$c = count($explora);
					$n=0;

					$inp=0;
					$acp=0;

					for ($i=0; $i < $c-1 ; $i++)
					{
						$ex = explode(",", $explora[$i]);
						$id_presen = $ex[0];
						$des = $ex[1];
						$uni = $ex[2];
						$pre = $ex[3];
						$id_x = $ex[4];
						$costo = $ex[5];
						$bar = $ex[6];
						$precios = explode("#", $ex[7]);
						$tabla_p = "presentacion_producto";

						$form_pre = array(
							'id_producto' => $id_producto,
							'id_presentacion' => $id_presen,
							'descripcion' => $des,
							'unidad' => $uni,
							'costo' => $costo,
							'barcode' => $bar,
						);

						foreach ($precios_sistema as $key => $value) {
							// code...
							$form_pre[$value]=$precios[$key];
						}

						$where_p = "id_pp='".$id_x."'";
						$presentax = _update($tabla_p, $form_pre, $where_p);

						$table_cambio="log_cambio_local";
						$form_data = array(
							'process' => 'update',
							'tabla' =>  "presentacion_producto",
							'fecha' => date("Y-m-d"),
							'hora' => date('H:i:s'),
							'id_usuario' => $_SESSION['id_usuario'],
							'id_sucursal' => $_SESSION['id_sucursal'],
							'id_primario' =>$id_x,
							'prioridad' => "2",
							'subido' => '1',
							'verificado' => '0',
						);
						$insert_cambio=_insert($table_cambio,$form_data);
						$id_cambio=_insert_id();

						$table_detalle_cambio="log_detalle_cambio_local";
						$form_data = array(
							'id_server' => '0',
							'id_log_cambio' => 	$id_cambio,
							'tabla' => 'presentacion_producto',
							'id_verificador' => $id_x
						);
						_insert($table_detalle_cambio,$form_data);

						if($presentax)
						{
							$n++;
						}
					}
					if($n == $c-1)
					{
						_commit();
						$xdatos["typeinfo"] = "Success";
						$xdatos["msg"] = "Producto editado correctamente";
					}
				}
				else
				{
					_rollback();
					$xdatos["typeinfo"] = "Error";
					$xdatos["msg"] = "El Barcode ya fue registrado en otro producto";
				}
			}
			else
			{
				_rollback();
				$xdatos["typeinfo"] = "Error";
				$xdatos["msg"] = "Producto no pudo ser actualizado, El Barcode ya fue registrado en otro producto";
			}
		}
		else
		{
			_rollback();
			$xdatos["typeinfo"] = "Error";
			$xdatos["msg"] = "La descripcion del producto ya fue registrada en otro producto";
		}
	}
	else
	{

		_rollback();
		$xdatos["typeinfo"] = "Error";
		$xdatos["msg"] = "Hay una presentación a la que no se le han asignado precios verifique";
	}
		echo json_encode($xdatos);
	}
	function deactive()
	{
		$id_pres = $_POST["id_pres"];
		$table ="presentacion_producto";
		$form_data = array(
			'activo' => 0,
		);
		$where ="id_pp='".$id_pres."'";
		$del = _update($table, $form_data, $where);
		if($del)
		{
			$xdatos["typeinfo"] = "Success";
		}
		else
		{
			$xdatos["typeinfo"] = "Error";
		}
		echo json_encode($xdatos);
	}
	function active()
	{
		$id_pres = $_POST["id_pres"];
		$table ="presentacion_producto";
		$form_data = array(
			'activo' => 1,
		);
		$where ="id_pp='".$id_pres."'";
		$del = _update($table, $form_data, $where);
		if($del)
		{
			$xdatos["typeinfo"] = "Success";
		}
		else
		{
			$xdatos["typeinfo"] = "Error";
		}
		echo json_encode($xdatos);
	}
	function add_pre()
	{
		$id_producto=$_REQUEST['id_producto'];
		$presentacion=$_REQUEST['presentacion'];
		$descripcion=$_REQUEST['descripcion'];
		$unidad=$_REQUEST['unidad'];
		$costo=$_REQUEST['costo'];
		$precio1=$_REQUEST['precio1'];
		$barcode=$_REQUEST['barcode'];
		$id_sucursal=$_SESSION['id_sucursal'];

		$table="presentacion_producto";
		$form_data = array(
			'id_server' => '0',
			'id_server_prod' => '0',
			'id_producto' => $id_producto,
			'id_presentacion' =>$presentacion,
			'descripcion' => $descripcion,
			'unidad' => $unidad,
			'activo' => 1,
			'costo' => $costo,
			'precio'=>$precio1,
			'barcode'=>$barcode,
			'costo_s_iva' => $costo,
			'precio1' => '0',
			'precio2' => '0',
			'precio3' => '0',
			'precio4' => '0',
			'precio5' => '0',
			'precio6' => '0',
		);
		$insert=_insert($table,$form_data);
		$id_pp=_insert_id();
		if ($insert)
		{
			$table_cambio="log_cambio_local";
			$form_data = array(
				'process' => 'insert',
				'tabla' =>  "presentacion_producto",
				'fecha' => date("Y-m-d"),
				'hora' => date('H:i:s'),
				'id_usuario' => $_SESSION['id_usuario'],
				'id_sucursal' => $_SESSION['id_sucursal'],
				'id_primario' =>$id_pp,
				'prioridad' => "1",
				'subido' => '1',
				'verificado' => '0'

			);
			$insert_cambio=_insert($table_cambio,$form_data);
			$id_cambio=_insert_id();

			$table_detalle_cambio="log_detalle_cambio_local";
			$form_data = array(
				'id_server' => '0',
				'id_log_cambio' => 	$id_cambio,
				'tabla' => 'presentacion_producto',
				'id_verificador' => $id_pp
			);
			_insert($table_detalle_cambio,$form_data);
			_commit();
			$xdatos['typeinfo']="Success";
			$xdatos['msg']="Registro insertado correctamente";
		}
		else {
			_rollback();
			$xdatos['typeinfo']="Error";
			$xdatos['msg']="Registro no pudo ser insertado";
		}

		echo json_encode($xdatos);

	}
	function datos()
	{
		$id_producto=$_REQUEST['id_producto'];
		$id_sucursal=$_SESSION['id_sucursal'];

		$dat="";
		$sql_p = _query("SELECT * FROM presentacion_producto WHERE id_producto = '$id_producto'");
		$n = 0;
		while ($row_p = _fetch_array($sql_p))
		{
			$id_presentacion_pro = $row_p["id_pp"];
			$pres = $row_p["id_presentacion"];
			$sql_present1 = _query("SELECT * FROM presentacion WHERE id_presentacion = '$pres'");
			$pr = _fetch_array($sql_present1);
			$descrip_pr = $pr["nombre"];
			$des = $row_p["descripcion"];
			$uni = $row_p["unidad"];
			$pre = $row_p["precio"];
			$costo = $row_p["costo"];
			$activo = $row_p["activo"];
			$bar = $row_p["barcode"];

			if($activo)
			{
				$dat.= "<tr class='exis' style='background: #BDECB6;'>";
			}
			else
			{
				$dat.= "<tr class='exis' style='background: #CDCDCD;'>";
			}

			$dat.= "<td class='bar ed3'>".$bar."</td>";
			$dat.= "<td><input type='hidden' class='id_pres_prod' value='".$id_presentacion_pro."'><input type='hidden' class='presentacion' value='".$pres."'>".$descrip_pr."</td>";
			$dat.= "<td class='descripcion_p ed3'>".$des."</td>";
			$dat.= "<td class='unidad_p'>".$uni."</td>";
			$dat.= "<td class='costo ed'>".$costo."</td>";

			$array_precios = _getPrecios($id_presentacion_pro);
			foreach ($array_precios as $key => $value) {
				// code...
				$dat.= "<td class='precio$key ed'>".$value."</td>";
			}

			if($activo)
			{
				$dat.= "<td class='text-center'><a class='deactive' id='".$id_presentacion_pro."'><i class='fa fa-eye iconsa'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a></td>";
			}
			else
			{
				$dat.= "<td class='text-center'><a class='activate' id='".$id_presentacion_pro."'><i class='fa fa-eye-slash iconsa'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a> </td>";
			}
			$n++;
		}

		$xdatos['datos']=$dat;

		echo json_encode($xdatos);
	}

	function insertar_pre()
	{
	  _begin();
	  $id_presentacion=$_REQUEST['id_presentacion'];
	  $desde=$_REQUEST['desde'];
	  $hasta=$_REQUEST['hasta'];
	  $precio=$_REQUEST['precio'];
	  $id_producto=$_REQUEST['id_producto'];
	  $id_sucursal=$_SESSION['id_sucursal'];

	  $table="presentacion_producto_precio";
	  $form_data = array(
	    'id_producto' => $id_producto,
	    'id_presentacion' => $id_presentacion,
	    'id_sucursal' => $id_sucursal,
	    'precio' => $precio,
	    'desde' => $desde,
	    'hasta' => $hasta,
	  );

	  $insertar=_insert($table,$form_data);
	  $id_ppp=_insert_id();

	  if ($insertar)
		{
			$table_cambio="log_cambio_local";
	    $form_data = array(
	      'process' => 'insert',
	      'tabla' =>  "presentacion_producto_precio",
	      'fecha' => date("Y-m-d"),
	      'hora' => date('H:i:s'),
	      'id_usuario' => $_SESSION['id_usuario'],
	      'id_sucursal' => $_SESSION['id_sucursal'],
	      'id_primario' =>$id_ppp,
	      'prioridad' => "1"
	    );
	    $insert_cambio=_insert($table_cambio,$form_data);
	    $id_cambio=_insert_id();

	    $table_detalle_cambio="log_detalle_cambio_local";
	    $form_data = array(
	      'id_log_cambio' => 	$id_cambio,
	      'tabla' => 'presentacion_producto_precio',
	      'id_verificador' => $id_ppp
	    );
	    _insert($table_detalle_cambio,$form_data);

	    _commit();
	    $xdatos['typeinfo']="Success";
	    $xdatos['msg']="Registro insertado correctamente";
	  }
	  else
		{
	    # code..
	    _rollback();
	    $xdatos['typeinfo']="Error";
	    $xdatos['msg']="Error no se pudo insertar el registro";
	  }
	  echo json_encode($xdatos);

	}

	function actualizar_p()
	{
		$id_ppp=$_REQUEST['id_ppp'];
		$precio=$_REQUEST['precio'];

		$table="presentacion_producto_precio";
		$form_data = array(
			'precio' => $precio
		);

		$where_clause="id_prepd = $id_ppp";
		$insertar=_update($table,$form_data,$where_clause);

		if ($insertar) {
			// code...
			$table_cambio="log_cambio_local";
				$form_data = array(
					'process' => 'update',
					'tabla' =>  "presentacion_producto_precio",
					'fecha' => date("Y-m-d"),
					'hora' => date('H:i:s'),
					'id_usuario' => $_SESSION['id_usuario'],
					'id_sucursal' => $_SESSION['id_sucursal'],
					'id_primario' =>$id_ppp,
					'prioridad' => "2"
				);
				$insert_cambio=_insert($table_cambio,$form_data);
				$id_cambio=_insert_id();

				$table_detalle_cambio="log_detalle_cambio_local";
				$form_data = array(
					'id_log_cambio' => 	$id_cambio,
					'tabla' => 'presentacion_producto_precio',
					'id_verificador' => $id_ppp
				);
				_insert($table_detalle_cambio,$form_data);


				$xdatos['typeinfo']="Success";
				$xdatos['msg']="Registro insertado correctamente";
		}
		else {
			$xdatos['typeinfo']="Error";
	    $xdatos['msg']="Error no se pudo insertar el registro";
		}

			echo json_encode($xdatos);
	}

	function borrar_presentacion()
	{
		_begin();
		$id_presentacion=$_REQUEST['id_presentacion'];
		$borra=false;
		$borra2=false;
		$dependencias=false;
		$sql1=_query("SELECT * FROM movimiento_producto_detalle WHERE movimiento_producto_detalle.id_presentacion=$id_presentacion");
		$sql2=_query("SELECT * FROM movimiento_producto_pendiente WHERE movimiento_producto_pendiente.id_presentacion=$id_presentacion");
		$sql3=_query("SELECT * FROM movimiento_stock_ubicacion WHERE movimiento_stock_ubicacion.id_presentacion=$id_presentacion");
		if (_num_rows($sql1)==0&&_num_rows($sql2)==0&&_num_rows($sql3)==0) {
			// code...
			$dependencias=true;

			$table="presentacion_producto";
			$where_clause="id_pp=$id_presentacion";
			//$borra=_delete($table,$where_clause);
			$borrar = true;
		}
		if ($borra&&$dependencias) {
			// code...
			_commit();
				$xdatos['typeinfo']="Success";
				$xdatos['msg']="No se puede realizar esta operacion";
		}
		else {
			_rollback();
			$xdatos['typeinfo']="Error";
	    $xdatos['msg']="Error no se pudo eliminar el registro ya se realizaron movimientos con el.";
		}

		echo json_encode($xdatos);
	}

function editar_img()
{
		require_once 'class.upload.php';
		$id_producto = $_POST["id_id_p"];
		if ($_FILES["logo"]["name"]!="")
		{
		$foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
		if ($foo->uploaded) {
				$pref = uniqid()."_";
				$foo->file_force_extension = false;
				$foo->no_script = false;
				$foo->file_name_body_pre = $pref;
			 // save uploaded image with no changes
			 $foo->Process('img/productos/');
			 if ($foo->processed)
			 {
				 $query = _query("SELECT imagen FROM producto WHERE id_producto='$id_producto'");
				 $result = _fetch_array($query);
				 $urlb=$result["imagen"];
				 if($urlb!="")
				 {
						 unlink($urlb);
				 }
				$cuerpo=quitar_tildes($foo->file_src_name_body);
				$cuerpo=trim($cuerpo);
				$url = 'img/productos/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
				$table = 'producto';
				$form_data = array (
				'imagen' => $url,
				);
				$where_clause = "id_producto='".$id_producto."'";
				$editar =_update($table, $form_data, $where_clause);
				if($editar)
				{
					 $xdatos['typeinfo']='Success';
					 $xdatos['msg']='Datos editados correctamente !';
					 $xdatos['process']='edit';
					 $xdatos['img'] = $url;
				}
				else
				{
					 $xdatos['typeinfo']='Error';
					 $xdatos['msg']='Error al editar los datos!'._error();
				}
			 }
			 else
			 {
					$xdatos['typeinfo']='Error';
					$xdatos['msg']='Error al editar la imagen!';
			 }
		}
		else
		{
				$xdatos['typeinfo']='Error';
				$xdatos['msg']='Error al subir la imagen!';
		}
		}
		else
		{
			 $xdatos['typeinfo']='Success';
			 $xdatos['msg']='Datos editados correctamente !';
			 $xdatos['process']='edit';
		}
		echo json_encode($xdatos);
}

	if (!isset($_POST['process'])) {
		initial();
	} else {
		if (isset($_POST['process'])) {
			switch ($_POST['process'])
			{
				case 'edited':
				editar1();
				break;
				case 'deactive':
				deactive();
				break;
				case 'active':
				active();
				break;
				case 'add_pre':
				add_pre();
				break;
				case 'datos':
				datos();
				break;
				case 'actu_ppp':
				actualizar_p();
				break;
				case 'borrar_presentacion':
				borrar_presentacion();
				break;
				case 'editar_img':
				editar_img();
				break;
			}
		}
	}
	?>
