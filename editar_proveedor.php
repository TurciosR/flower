<?php
include_once "_core.php";
function initial()
{
	$title = 'Ficha del Proveedor';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
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
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
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

	$id_proveedor = $_REQUEST["id_proveedor"];
	$id_sucursal = $_SESSION["id_sucursal"];
	$sql = _query("SELECT * FROM proveedor WHERE id_proveedor='$id_proveedor' AND id_sucursal='$id_sucursal'");
	$datos = _fetch_array($sql);

	$nombre = $datos["nombre"];
	$direccion = $datos["direccion"];
	$departamento = $datos["depto"];
	$municipio = $datos["municipio"];
	$dui = $datos["dui"];
	$nit = $datos["nit"];
	$nrc = $datos["nrc"];
	$giro = $datos["giro"];
	$categoria = $datos["categoria"];
	$retiene = $datos["retiene"];
	$retiene10 = $datos["retiene10"];
	$tipo = $datos["tipo"];
	$nacionalidad = $datos["nacionalidad"];
	$percibe = $datos["percibe"];
	$nombre_contacto = $datos["contacto"];
	$nombre_cheque = $datos["nombreche"];
	$telefono1 = $datos["telefono1"];
	$telefono2 = $datos["telefono2"];
	$fax = $datos["fax"];
	$email = $datos["email"];
	$no_retiene = 0;
	$retie = 0;
	if($percibe == 0 && $retiene == 0 && $retiene10 == 0)
	{
		$no_retiene = 1;
	}
	if($retiene == 1 || $retiene10 == 1)
	{
		$retie = 1;
	}

	$mes = date("m");
	$anio = date("Y");
	$primer = $anio."-".$mes."-01";
	$actu = date("Y-m-d");
	?>
	<style>
	/* Center the loader */
	.sect
	{
		height: 400px;
	}
	#loader {
		position: absolute;
		left: 50%;
		top: 50%;
		z-index: 1;
		width: 150px;
		height: 150px;
		margin: -75px 0 0 -75px;
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}

	/* Add animation to "page content" */
	.animate-bottom {
		position: relative;
		-webkit-animation-name: animatebottom;
		-webkit-animation-duration: 1s;
		animation-name: animatebottom;
		animation-duration: 1s
	}

	@-webkit-keyframes animatebottom {
		from { bottom:-100px; opacity:0 }
		to { bottom:0px; opacity:1 }
	}

	@keyframes animatebottom {
		from{ bottom:-100px; opacity:0 }
		to{ bottom:0; opacity:1 }
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-2">
	</div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<?php
				//permiso del script
				if ($links!='NOT' || $admin=='1' ){
					?>
					<div class="ibox-title">
						<h5><?php echo $title; ?></h5>
					</div>
					<div class="ibox-content">
						<ul class="nav nav-tabs">
							<li class="active" id="hom"><a data-toggle="tab" href="#home">Editar</a></li>
							 <!--
							 <li id="hcxpp"><a data-toggle="tab" href="#cxpp">Cuentas x Pagar</a></li>
 							<li id="hcacum"><a data-toggle="tab" href="#cacum">Compra Acumulada</a></li> 
						  -->

						</ul>
						<div class="row">
							<div class="tab-content">
								<div id="home" class="tab-pane fade in active"><br>
									<div class="col-lg-12">
										<form name="formulario" id="formulario">
											<div class="row">
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Nombre  <span style="color:red;">*</span></label>
														<input type="text" placeholder="Nombre del Proveedor" class="form-control" id="nombre_proveedor" name="nombre_proveedor" value="<?php echo $nombre; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Dirección</label>
														<input type="text" placeholder="Dirección" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
													</div>
												</div>

												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Departamento <span style="color:red;">*</span></label>
														<select class="col-md-12 select" id="departamento" name="departamento">
															<?php
															$sqld = "SELECT * FROM departamento";
															$resultd=_query($sqld);
															while($depto = _fetch_array($resultd))
															{
																echo "<option value='".$depto["id_departamento"]."'";
																if($departamento == $depto["id_departamento"])
																{
																	echo " selected ";
																}
																echo">".$depto["nombre_departamento"]."</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Municipio <span style="color:red;">*</span></label>
														<select class="col-md-12 select" id="municipio" name="municipio">
															<?php
															$sqld = "SELECT * FROM municipio";
															$resultd=_query($sqld);
															while($depto = _fetch_array($resultd))
															{
																echo "<option value='".$depto["id_municipio"]."'";
																if($municipio == $depto["id_municipio"])
																{
																	echo " selected ";
																}
																echo">".$depto["nombre_municipio"]."</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>DUI</label>
														<input type="text" placeholder="00000000-0" class="form-control" id="dui" name="dui" value="<?php echo $dui; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>NIT </label>
														<input type="text" placeholder="0000-000000-000-0" class="form-control" id="nit" name="nit" value="<?php echo $nit; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>NRC </label>
														<input type="text" placeholder="Registro" class="form-control" id="nrc" name="nrc" value="<?php echo $nrc; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Giro </label>
														<input type="text" placeholder="Giro del negocio" class="form-control" id="giro" name="giro" value="<?php echo $giro; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Categoria del Proveedor <span style="color:red;">*</span></label>
														<select class="col-md-12 select" id="categoria_proveedor" name="categoria_proveedor">
															<?php
															$sqld = "SELECT * FROM categoria_proveedor";
															$resultd=_query($sqld);
															while($depto = _fetch_array($resultd))
															{
																echo "<option value='".$depto["id_categoria"]."'";
																if($categoria == $depto["id_categoria"])
																{
																	echo " selected ";
																}
																echo">".$depto["nombre"]."</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<div class='checkbox i-checks'><label><input id='percibe' name='percibe' type='checkbox' <?php if($percibe){ echo " checked "; }?>> <span class="label-text"><b>Percibe 1%</b></span></label></div>
														<input type="hidden" name="hi_percibe" id="hi_percibe" value="<?php echo $percibe;?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Nombre del Contacto </label>
														<input type="text" placeholder="Nombre del Contacto" class="form-control" id="nombre_contacto" name="nombre_contacto" value="<?php echo $nombre_contacto; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Nombre para Cheques </label>
														<input type="text" placeholder="Nombre para cheques" class="form-control" id="nombre_cheque" name="nombre_cheque" value="<?php echo $nombre_cheque; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Teléfono 1 </label>
														<input type="text" placeholder="0000-0000" class="form-control tel" id="telefono1" name="telefono1" value="<?php echo $telefono1; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Teléfono 2</label>
														<input type="text" placeholder="0000-0000" class="form-control tel" id="telefono2" name="telefono2" value="<?php echo $telefono2; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Tipo de Proveedor <span style="color:red;">*</span></label>
														<select class="col-md-12 select" id="tipo" name="tipo">
															<option value="1" <?php if($tipo == "1"){ echo " selected "; }?>>Costo</option>
															<option value="2" <?php if($tipo == "2"){ echo " selected "; }?>>Gasto</option>
														</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Fax</label>
														<input type="text" placeholder="0000-0000" class="form-control tel" id="fax" name="fax" value="<?php echo $fax; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>Correo</label>
														<input type="text" placeholder="mail@server.com" class="form-control" id="correo" name="correo" value="<?php echo $email; ?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group has-info single-line">
														<label>País de Origen</label>
														<select  name='pais' id='pais'  style="width:100%;" class="select">
															<option value=''>Seleccione</option>
															<?php
															$qpais=_query("SELECT * FROM paises WHERE iso!='SV' ORDER BY nombre ");
															echo " <option value='68' selected>El Salvador</option>";
															while($row_pais=_fetch_array($qpais))
															{
																$id_pais=$row_categoria["id"];
																$pais=$row_pais["nombre"];
																echo "<option value='$id_pais'";
																if($id_pais  == $nacionalidad)
																{
																	echo " selected ";
																}
																echo ">$pais</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<input type="hidden" name="id_proveedor" id="id_proveedor" value="<?php echo $id_proveedor; ?>">
											<input type="hidden" name="process" id="process" value="edit"><br>
											<div>
												<input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
											</div>
										</form>
									</div>
								</div>
								<div id="cxpp" class="tab-pane fade"><br><br>
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group has-info">
													<label>Fecha Inicio</label>
													<input type="text" name="fini" id="fini" class="form-control datepick" value="<?php echo $primer; ?>">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-info">
													<label>Fecha Fin</label>
													<input type="text" name="fin" id="fin" class="form-control datepick" value="<?php echo $actu; ?>">
												</div>
											</div>
											<div class="col-lg-3">

											</div>
											<div class="col-lg-3">
												<div class="form-group has-info"><br>
													<button type="button" class="btn btn-primary pull-right" id="scxpp"><i class="fa fa-search"></i> Buscar</button>
												</div>
											</div>
										</div>
										<div class="row" id="res" hidden><br>
											<div class="col-lg-12 pre-scrollable">
												<table class="table table-bordered">
													<thead>
														<tr>
															<td class="text-center">Fecha</td>
															<td class="text-center">Tipo Doc.</td>
															<td class="text-center">Numero Doc.</td>
															<td class="text-center">Total</td>
															<td class="text-center">Saldo</td>
															<td class="text-center">Vencimiento</td>
															<td class="text-center">Detalle</td>
														</tr>
													</thead>
													<tbody id="resultado">

													</tbody>
												</table>
											</div>
										</div>
										<div class="row" id="no-data" hidden><br>
											<div class="col-lg-12">
												<div class="alert alert-warning">
													No se encontraron resultados que coincidan con los criterios de busqueda
												</div>
											</div>
										</div>
										<div class="row" style="display: none;" id="divh">
											<div class="col-lg-12">
												<div class="ibox float-e-margins">
													<div class="ibox-content">
														<section class="sect">
															<div id="loader">
															</div>
														</section>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="cacum" class="tab-pane fade"><br>
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group has-info">
													<label>Fecha Inicio</label>
													<input type="text" name="fini1" id="fini1" class="form-control datepick" value="<?php echo $primer; ?>">
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group has-info">
													<label>Fecha Fin</label>
													<input type="text" name="fin1" id="fin1" class="form-control datepick" value="<?php echo $actu; ?>">
												</div>
											</div>
											<div class="col-lg-3">

											</div>
											<div class="col-lg-3">
												<div class="form-group has-info"><br>
													<button type="button" class="btn btn-primary pull-right" id="scacum"><i class="fa fa-search"></i> Buscar</button>
												</div>
											</div>
										</div>
										<div class="row" id="res1">
											<div class="col-lg-12">
												<div class=" pre-scrollable">
													<table class="table table-bordered">
														<thead>
															<tr>
																<td class="text-center">Fecha</td>
																<td class="text-center">Tipo Doc.</td>
																<td class="text-center">Numero Doc.</td>
																<td class="text-center">Total</td>
																<td class="text-center">Detalle</td>
															</tr>
														</thead>
														<tbody id="resultado1">

														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row" id="no-data1" hidden><br>
											<div class="col-lg-12">
												<div class="alert alert-warning">
													No se encontraron resultados que coincidan con los criterios de busqueda
												</div>
											</div>
										</div>
										<div class="row" style="display: none;" id="divh1">
											<div class="col-lg-12">
												<div class="ibox float-e-margins">
													<div class="ibox-content">
														<section class="sect">
															<div id="loader">
															</div>
														</section>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Show Modal Popups View & Delete -->
						<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog'>
								<div class='modal-content'></div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	include_once ("footer.php");
	echo "<script src='js/funciones/funciones_proveedor.js'></script>";
} //permiso del script
else
{
	echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
}
}

function insertar()
{
	$id_sucursal = $_SESSION["id_sucursal"];
	$id_proveedor=$_POST["id_proveedor"];
	$nombre_proveedor=$_POST["nombre_proveedor"];
	$direccion=$_POST["direccion"];
	$departamento=$_POST["departamento"];
	$municipio=$_POST["municipio"];
	$dui=$_POST["dui"];
	$nit=$_POST["nit"];
	$nrc=$_POST["nrc"];
	$giro=$_POST["giro"];
	$nacionalidad=$_POST["pais"];
	$categoria_proveedor=$_POST["categoria_proveedor"];

	$tipo=$_POST["tipo"];
	if(isset($_POST['percibe']))
	{
		$percibe = 1;
	}
	else
	{
		$percibe = 0;
	}
	$nombre_contacto=$_POST["nombre_contacto"];
	$nombre_cheque=$_POST["nombre_cheque"];
	$telefono1=$_POST["telefono1"];
	$telefono2=$_POST["telefono2"];
	$fax=$_POST["fax"];
	$correo=$_POST["correo"];

	//echo "SELECT id_proveedor FROM proveedor WHERE nit ='$nit' AND id_proveedor != '$id_proveedor' AND id_sucursal='$id_sucursal'";
	$sql_exis=_query("SELECT id_proveedor FROM proveedor WHERE nombre = '".mb_strtoupper($nombre_proveedor)."' AND nit ='$nit' AND id_proveedor != '$id_proveedor' AND id_sucursal='$id_sucursal'");
	$num_exis = _num_rows($sql_exis);
	if($num_exis > 0)
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Ya se registro un proveedor con estos datos!';
	}
	else
	{
		$table = 'proveedor';
		$form_data = array(
			'categoria' => $categoria_proveedor,
			'tipo' => $tipo,
			'nombre' => mb_strtoupper($nombre_proveedor),
			'direccion' => $direccion,
			'municipio' => $municipio,
			'depto' => $departamento,
			'contacto' => $nombre_contacto,
			'nrc' => $nrc,
			'nit' => $nit,
			'dui' => $dui,
			'giro' => $giro,
			'telefono1' => $telefono1,
			'telefono2' => $telefono2,
			'fax' => $fax,
			'email' => $correo,
			'percibe' => $percibe,
			'nombreche' => $nombre_cheque,
			'nacionalidad' => $nacionalidad,
			'id_sucursal' => $id_sucursal,
		);
		$where = "id_proveedor='".$id_proveedor."' AND id_sucursal='".$id_sucursal."'";
		$upadte = _update($table,$form_data,$where);
		if($upadte)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Registro modificado con exito!';
			$xdatos['process']='insert';
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Registro no pudo ser modificado !';
		}
	}
	echo json_encode($xdatos);
}
function cxpp()
{
	$id_sucursal = $_SESSION["id_sucursal"];
	$fini = $_POST["fini"];
	$fin = $_POST["fin"];
	$id_proveedor = $_POST["id_proveedor"];
	$table = "";
	$sql = _query("SELECT * FROM cuenta_pagar WHERE id_proveedor='$id_proveedor' AND id_sucursal='$id_sucursal' AND saldo_pend>0 AND CAST(fecha AS DATE) BETWEEN '$fini' AND '$fin' ORDER BY CAST(fecha as DATE) DESC");
	if(_num_rows($sql)>0)
	{
		$entrada = 0;
		$salida = 0;
		while ($row = _fetch_array($sql))
		{
			$table.= "<tr>
			<td>".ED($row["fecha"])."</td>
			<td>".$row["alias_tipodoc"]."</td>
			<td>".$row["numero_doc"]."</td>
			<td>".$row["monto"]."</td>
			<td>".$row["saldo_pend"]."</td>
			<td>".ED($row["fecha_vence"])."</td>
			<td><a href='ver_compras.php?id_compras=".$row["id_compras"]."' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fa fa-eye'></i> Ver</a></td>";
			$table.="</tr>";
		}
		$xdatos["typeinfo"] = "Success";
		$xdatos["table"] = $table;
	}
	else
	{
		$xdatos["typeinfo"] = "Error";
	}
	echo json_encode($xdatos);
}
function cacum()
{
	$id_sucursal = $_SESSION["id_sucursal"];
	$fini = $_POST["fini"];
	$fin = $_POST["fin"];
	$id_proveedor = $_POST["id_proveedor"];
	$table = "";
	$sql = _query("SELECT * FROM cuenta_pagar WHERE id_proveedor='$id_proveedor' AND id_sucursal='$id_sucursal' AND saldo_pend=0 AND CAST(fecha AS DATE) BETWEEN '$fini' AND '$fin' ORDER BY CAST(fecha as DATE) DESC");
	if(_num_rows($sql)>0)
	{
		$entrada = 0;
		$salida = 0;
		while ($row = _fetch_array($sql))
		{
			$table.= "<tr>
			<td>".ED($row["fecha"])."</td>
			<td>".$row["alias_tipodoc"]."</td>
			<td>".$row["numero_doc"]."</td>
			<td>".$row["monto"]."</td>
			<td><a href='ver_compra.php?id_compra=".$row["id_compra"]."' data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class='fa fa-eye'></i> Ver</a></td>";
			$table.="</tr>";
		}
		$xdatos["typeinfo"] = "Success";
		$xdatos["table"] = $table;
	}
	else
	{
		$xdatos["typeinfo"] = "Error";
	}
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
			case 'edit':
			insertar();
			break;
			case 'cxpp':
			cxpp();
			break;
			case 'cacum':
			cacum();
			break;
		}
	}
}
?>
