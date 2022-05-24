<?php
include ("_core.php");
$id_empleado = $_REQUEST['id_empleado'];
$sql="SELECT e.*, te.descripcion FROM empleado AS e, tipo_empleado AS te WHERE e.id_tipo_empleado=te.id_tipo_empleado AND e.id_empleado='$id_empleado'";
$result = _query($sql);

//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);
//permiso del script
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos de Empleado</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<?php if ($links!='NOT' || $admin=='1' ){ ?>
					<table	class="table table-bordered table-striped" id="tableview">
						<thead>
							<tr>
								<th class="col-lg-3">Campo</th>
								<th class="col-lg-9">Detalle</th>
							</tr>
						</thead>
						<tbody>
							<?php
									$row = _fetch_array($result);
									$id_empleado=$row["id_empleado"];
									$nombre=$row["nombre"];
									$tipo=$row["descripcion"];
									$apellido=$row["apellido"];
									$nit=$row["nit"];
									$dui=$row["dui"];
									$telefono1=$row["telefono1"];
									$telefono2=$row["telefono2"];
									$email=$row["email"];
									$direccion=$row["direccion"];
									$salariobase=$row["salariobase"];

									echo"<tr><td>Id </td><td>".$id_empleado."</td></tr>";
									echo"<tr><td>Nombre</td><td>".$nombre." ".$apellido."</td></tr>";
									echo"<tr><td>Tipo</td><td>".$tipo."</td></tr>";
									echo"<tr><td>NIT</td><td>".$nit."</td></tr>";
									echo"<tr><td>DUI</td><td>".$dui."</td></tr>";
									echo"<tr><td>Dirección</td><td>".$direccion."</td></tr>";
									echo"<tr><td>Telefonos</td><td>".$telefono1." y ".$telefono2."</td></tr>";
									echo"<tr><td>Correo</td><td>".$email."</td></tr>";
									echo"<tr><td>Salario</td><td>".$salariobase."</td></tr>";
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<?php
		echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
		</div><!--/modal-footer -->";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
	?>
