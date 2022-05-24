<?php
include_once "_core.php";
function initial()
{
	$title = 'Editar Cliente';
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

	$id_cliente = $_REQUEST["id_cliente"];
	$sql = _query("SELECT * FROM cliente WHERE id_cliente='$id_cliente'");
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
	$percibe = $datos["percibe"];
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
					//permiso del script
					if ($links!='NOT' || $admin=='1' ){
						?>
						<div class="ibox-title">
							<h5><?php echo $title; ?></h5>
						</div>
						<div class="ibox-content">
							<form name="formulario" id="formulario">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group has-info single-line">
											<label>Nombre  <span style="color:red;">*</span></label>
											<input type="text" placeholder="Nombre del cliente" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group has-info single-line">
											<label>Dirección</label>
                      <textarea placeholder="Dirección" class="form-control" id="direccion" name="direccion" rows="3" cols="80"><?php echo $direccion; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
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
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Categoria del Cliente <span style="color:red;">*</span></label>
											<select class="col-md-12 select" id="categoria" name="categoria">
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
											<label>DUI</label>
											<input type="text" placeholder="00000000-0" class="form-control" id="dui" name="dui" value="<?php echo $dui; ?>">
										</div>
									</div>
								</div>
								<div class="row">
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
											<input type="text" placeholder="Giro del cliente" class="form-control" id="giro" name="giro" value="<?php echo $giro; ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<div class='checkbox i-checks'><label><input id='retiene' name='retiene' type='checkbox' <?php if($retiene || $retiene10){ echo " checked "; }?>> <span class="label-text"><b>Retiene</b></span></label></div>
											<input type="hidden" name="hi_retiene" id="hi_retiene" value="<?php echo $retie;?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3" id="retiene_select" <?php if(!$retiene && !$retiene10) { echo " hidden "; }?>>
										<div class="form-group has-info single-line">
											<label>Porcentaje de Retención <span style="color:red;">*</span></label>
											<select class="col-md-12 select" id="porcentaje" name="porcentaje">
												<option value="0">Sin Retención</option>
												<option value="1" <?php if($retiene){ echo " selected "; }?>>1%</option>
												<option value="10" <?php if($retiene10){ echo " selected "; }?>>10%</option>
											</select>
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
											<label>Fax</label>
											<input type="text" placeholder="0000-0000" class="form-control tel" id="fax" name="fax" value="<?php echo $fax; ?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Correo</label>
											<input type="text" placeholder="mail@server.com" class="form-control" id="correo" name="correo" value="<?php echo $email; ?>">
										</div>
									</div>
								</div>
								<input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $id_cliente; ?>">
								<input type="hidden" name="process" id="process" value="edit"><br>
								<div>
									<input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		include_once ("footer.php");
		echo "<script src='js/funciones/funciones_cliente.js'></script>";
	} //permiso del script
	else
	{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function insertar()
{
	$id_cliente=$_POST["id_cliente"];
	$nombre=$_POST["nombre"];
	$direccion=$_POST["direccion"];
	$departamento=$_POST["departamento"];
	$municipio=$_POST["municipio"];
	$dui=$_POST["dui"];
	$nit=$_POST["nit"];
	$nrc=$_POST["nrc"];
	$giro=$_POST["giro"];
	$categoria=$_POST["categoria"];
	$porcentaje=$_POST["porcentaje"];

	if($porcentaje == 1)
	{
		$retiene = 1;
		$retiene10 = 0;
	}
	else if($porcentaje == 0)
	{
		$retiene = 0;
		$retiene10 = 0;
	}
	else
	{
		$retiene = 0;
		$retiene10 = 1;
	}
	if(isset($_POST['percibe']))
	{
		$percibe = 1;
	}
	else
	{
		$percibe = 0;
	}

	$telefono1=$_POST["telefono1"];
	$telefono2=$_POST["telefono2"];
	$fax=$_POST["fax"];
	$correo=$_POST["correo"];

	$sql_exis=_query("SELECT id_cliente FROM cliente WHERE nombre='$nombre' AND nit ='$nit' AND id_cliente != '$id_cliente'");
	$num_exis = _num_rows($sql_exis);
	if($num_exis > 0)
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Ya se registro un cliente con estos datos!';
	}
	else
	{
		$table = 'cliente';
		$form_data = array(
			'categoria' => $categoria,
			'nombre' => $nombre,
			'direccion' => $direccion,
			'municipio' => $municipio,
			'depto' => $departamento,
			'nrc' => $nrc,
			'nit' => $nit,
			'dui' => $dui,
			'giro' => $giro,
			'telefono1' => $telefono1,
			'telefono2' => $telefono2,
			'fax' => $fax,
			'email' => $correo,
			'percibe' => $percibe,
			'retiene' => $retiene,
			'retiene10' => $retiene10,
		);
		$where = "id_cliente='".$id_cliente."'";
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
		}
	}
}
?>
