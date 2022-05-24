<?php
include ("_core.php");
function initial()
{
	$id_producto = $_REQUEST ['id_producto'];
	$id_sucursal = $_SESSION["id_sucursal"];
	$sql="SELECT *FROM producto WHERE id_producto='$id_producto'";
	$result = _query($sql);
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Borrar Producto</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<?php if ($links!='NOT' || $admin=='1' ){	?>
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
								echo "<tr><td>Id</th><td>$id_producto</td></tr>";
								echo "<tr><td>Barcode</td><td>".$row['barcode']."</td>";
								echo "<tr><td>Nombre</td><td>".$row['descripcion']."</td>";
								echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_producto' id='id_producto' value='$id_producto'>";
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
function deleted() {
	$id_producto = $_POST ['id_producto'];
	$table = 'producto';
	$table1 = 'presentacion_producto';
	$where_clause = "id_producto='".$id_producto."'";
	$delete = _delete ( $table, $where_clause );
	$delete1 = _delete ( $table1, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro borrado con exito!';
	}
	else
	{
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser borrado ';
	}
	echo json_encode ( $xdatos );
}
if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
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
