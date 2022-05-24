<?php
include_once "_core.php";
function initial()
{
	$title = "Agregar Empleado";
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
	$links=permission_usr($id_user, $filename);
	//permiso del script
	?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2">
		</div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<?php if ($links!='NOT' || $admin=='1' ){ ?>
						<div class="ibox-title">
							<h5><?php echo $title; ?></h5>
						</div>
						<div class="ibox-content">
							<form name="formulario" id="formulario" autocomplete="off">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Nombre <span style="color:red;">*</span></label>
											<input type="text" placeholder="Nombre" class="form-control" id="nombre" name="nombre">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Apellido <span style="color:red;">*</span></label>
											<input type="text" placeholder="Apellido" class="form-control" id="apellido" name="apellido">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group has-info single-line">
											<label>Dirección</label>
											<input type="text" placeholder="Dirección" class="form-control" id="direccion" name="direccion">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>DUI</label>
											<input type="text" placeholder="DUI" class="form-control" id="dui" name="dui">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>NIT</label>
											<input type="text" placeholder="NIT" class="form-control" id="nit" name="nit">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Teléfono 1</label>
											<input type="text" placeholder="Teléfono 1" class="form-control tel" id="telefono1" name="telefono1">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Teléfono 2</label>
											<input type="text" placeholder="Teléfono 2" class="form-control tel" id="telefono2" name="telefono2">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Correo</label>
											<input type="text" placeholder="Correo" class="form-control" id="email" name="email">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Salario Base</label>
											<input type="text" placeholder="0.00" class="form-control" id="salariobase" name="salariobase">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Tipo de Empleado <span style="color:red;">*</span></label>
											<select  name='tipo_empleado' id='tipo_empleado' style="width:100%;">
												<option value=''>Seleccione</option>
												<?php
												$qtipo_empleado=_query("SELECT * FROM tipo_empleado ORDER BY descripcion ");
												while($row_tipo_empleado=_fetch_array($qtipo_empleado))
												{
													$id_tipo_empleado=$row_tipo_empleado["id_tipo_empleado"];
													$nombrecat=$row_tipo_empleado["descripcion"];
													echo "
													<option value='$id_tipo_empleado'>$nombrecat</option>
													";
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div>
									<input type="hidden" name="process" id="process" value="insert"><br>
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
function insertar()
{
	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$nit=$_POST["nit"];
	$dui=$_POST["dui"];
	$direccion=$_POST["direccion"];
	$telefono1=$_POST["telefono1"];
	$telefono2=$_POST["telefono2"];
	$email=$_POST["email"];
	$salariobase=$_POST["salariobase"];
	if($salariobase == "" || $salariobase == "undefined"){
		$salariobase = 0;
	}

	$id_tipo_empleado= $_POST["id_tipo_empleado"];

	$id_sucursal = $_SESSION["id_sucursal"];
	$sql_result=_query("SELECT id_empleado FROM empleado WHERE nombre='$nombre' AND apellido='$apellido'  AND id_sucursal='$id_sucursal'");
	$row_update=_fetch_array($sql_result);
	$numrows=_num_rows($sql_result);

	$table = 'empleado';
	$form_data = array(
		'id_server' => '0',
		'nombre' => $nombre,
		'apellido' => $apellido,
		'direccion' => $direccion,
		'nit' => $nit,
		'dui' => $dui,
		'telefono1' => $telefono1,
		'telefono2' => $telefono2,
		'email' => $email,
		'salariobase' => $salariobase,
		'id_tipo_empleado'=>$id_tipo_empleado,
		'id_sucursal'=>$id_sucursal,
	);
	if($numrows == 0)
	{
		$insertar = _insert($table,$form_data );
		if($insertar)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Registro ingresado con exito!';
			$xdatos['process']='insert';
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Registro no pudo ser ingresado!';
		}
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Ya existe un empleado registrado con estos datos!';
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
			case 'insert':
				insertar();
				break;
		}
	}
}
?>
