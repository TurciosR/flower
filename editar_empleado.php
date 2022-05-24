<?php
include_once "_core.php";
function initial()
{
	$title = "Editar Empleado";
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
	$id_empleado= $_REQUEST['id_empleado'];

	$id_sucursal = $_SESSION["id_sucursal"];
	$sql="SELECT * FROM empleado WHERE id_empleado='$id_empleado' AND id_sucursal='$id_sucursal'";
	$result=_query($sql);
	$count=_num_rows($result);
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
	?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2">
		</div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<?php if ($links!='NOT' || $admin=='1' ){ ?>
						<div class="ibox-title">
							<h5><?php echo $title; ?></h5>
						</div>
						<div class="ibox-content">
							<form name="formulario" id="formulario" autocomplete="off">
								<?php
								$row = _fetch_array ( $result);
								$id_empleado=$row["id_empleado"];
								$nombre=$row["nombre"];
								$apellido=$row["apellido"];
								$nit=$row["nit"];
								$dui=$row["dui"];
								$direccion=$row["direccion"];
								$telefono1=$row["telefono1"];
								$telefono2=$row["telefono2"];
								$email=$row["email"];
								$salariobase=$row["salariobase"];
								$id_tipo_empleado=$row["id_tipo_empleado"];
								?>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Nombre</label>
											<input type="text" placeholder="Nombre" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Apellido</label>
											<input type="text" placeholder="Apellido" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group has-info single-line">
											<label>Dirección</label>
											<input type="text" placeholder="Dirección" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>DUI</label>
											<input type="text" placeholder="DUI" class="form-control" id="dui" name="dui" value="<?php echo $dui; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>NIT</label>
											<input type="text" placeholder="NIT" class="form-control" id="nit" name="nit" value="<?php echo $nit; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Teléfono 1</label>
											<input type="text" placeholder="Teléfono 1" class="form-control tel" id="telefono1" name="telefono1" value="<?php echo $telefono1; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Teléfono 2</label>
											<input type="text" placeholder="Teléfono 2" class="form-control tel" id="telefono2" name="telefono2" value="<?php echo $telefono2; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Correo</label>
											<input type="text" placeholder="Correo" class="form-control" id="email" name="email"  value="<?php echo $email; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Salario Base</label>
											<input type="text" placeholder="salariobase" class="form-control" id="salariobase" name="salariobase"  value="<?php echo $salariobase; ?>">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Tipo de Empleado</label>
											<select  name='tipo_empleado' id='tipo_empleado' style='width:100%;'>
												<?php
												$qtipo_empleado2=_query("SELECT * FROM tipo_empleado ORDER BY descripcion ASC");
												while($row_tipo_empleado2=_fetch_array($qtipo_empleado2))
												{
													$id_tipo_empleado2=$row_tipo_empleado2["id_tipo_empleado"];
													$nombrecat2=$row_tipo_empleado2["descripcion"];
													if($id_tipo_empleado2 == $id_tipo_empleado)
													{
														echo "<option value='$id_tipo_empleado2' selected>$nombrecat2</option>";
													}
													else
													{
														echo "<option value='$id_tipo_empleado2'>$nombrecat2</option>";
													}

												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div>
									<input type="hidden" name="process" id="process" value="edited">
									<input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $id_empleado; ?> ">
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
		echo "<script src='js/funciones/funciones_empleado.js'></script>";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include_once ("footer.php");
	}
}
function edited()
{
	$id_empleado=$_POST["id_empleado"];
	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$nit=$_POST["nit"];
	$dui=$_POST["dui"];
	$direccion=$_POST["direccion"];
	$telefono1=$_POST["telefono1"];
	$telefono2=$_POST["telefono2"];
	$email=$_POST["email"];
	$salariobase=$_POST["salariobase"];
	$id_tipo_empleado= $_POST["id_tipo_empleado"];

	$id_sucursal = $_SESSION["id_sucursal"];
	//'id_empleado' => $id_empleado,
	$table = 'empleado';
	$form_data = array(
		'id_empleado'=> $id_empleado,
		'nombre' => $nombre,
		'apellido' => $apellido,
		'nit' => $nit,
		'dui' => $dui,
		'direccion' => $direccion,
		'telefono1' => $telefono1,
		'telefono2' => $telefono2,
		'email' => $email,
		'salariobase' => $salariobase,
		'id_tipo_empleado'=> $id_tipo_empleado,
		'id_sucursal'=> $id_sucursal,
	);
	$where_clause = "id_empleado='" . $id_empleado . "'";
	$updates = _update($table, $form_data, $where_clause);
	if($updates)
	{
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Registro editado con exito!';
		$xdatos['process']='insert';
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Registro no pudo ser editado!';
	}
	echo json_encode($xdatos);
}

if(!isset($_REQUEST['process']))
{
	initial();
}
else
{
	if(isset($_REQUEST['process']))
	{
		switch ($_REQUEST['process'])
		{
			case 'edited':
			edited();
			break;
			case 'formEdit' :
				initial();
				break;
			}
		}
	}
	?>
