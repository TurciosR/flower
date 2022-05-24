<?php
include ("_core.php");
function initial(){
	$id_empleado = $_REQUEST ['id_empleado'];
	$id_sucursal = $_SESSION["id_sucursal"];
	$sql="SELECT *FROM empleado WHERE id_empleado='$id_empleado' AND id_sucursal='$id_sucursal'";
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
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Borrar Empleado</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<?php if ($links!='NOT' || $admin=='1' ){ ?>
						<table class="table table-bordered table-striped" id="tableview">
							<thead>
								<tr>
									<th class="col-lg-3">Campo</th>
									<th class="col-lg-9">Descripción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$row = _fetch_array ($result);
								echo "<tr><td>Id</th><td>$id_empleado</td></tr>";
								echo "<tr><td>Nombre</td><td>".$row ['nombre']." ".$row ['apellido']."</td>";
								echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_empleado' id='id_empleado' value='$id_empleado'>";
				?>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
		<!--/modal-footer -->
<?php
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function deleted()
{
	$id_empleado = $_POST ['id_empleado'];
	$table = 'empleado';

	$id_sucursal = $_SESSION["id_sucursal"];
	$where_clause = "id_empleado='".$id_empleado."' AND id_sucursal='$id_sucursal'";
	$delete = _delete ($table,$where_clause);
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro borrado con exito!';
	}
	else
	{
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser borrado!';
	}
	echo json_encode ( $xdatos );
}
if (! isset ( $_REQUEST ['process'] ))
{
	initial();
} else {
	if (isset ( $_REQUEST ['process'] ))
	{
		switch ($_REQUEST ['process'])
		{
			case 'formDelete' :
				initial();
				break;
			case 'deleted' :
				deleted();
				break;
		}
	}
}
?>
