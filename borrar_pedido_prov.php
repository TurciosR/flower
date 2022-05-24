<?php
include ("_core.php");
function initial()
{
	$id_pedido_prov = $_REQUEST ['id_pedido_prov'];
	$id_sucursal = $_SESSION["id_sucursal"];
	$sql="SELECT pp.total, pv.nombre, pp.fecha, pp.fecha_entrega FROM pedido_prov as pp
				JOIN proveedor as pv ON(pp.id_proveedor=pv.id_proveedor)
				WHERE pp.id_pedido_prov='$id_pedido_prov' AND pp.id_sucursal='$id_sucursal'";
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
		<h4 class="modal-title">Borrar Pedido</h4>
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
								echo "<tr><td>Id</th><td>$id_pedido_prov</td></tr>";
								echo "<tr><td>Fecha Creación</td><td>".ED($row['fecha'])."</td>";
								echo "<tr><td>Fecha Pedido</td><td>".ED($row['fecha_entrega'])."</td>";
								echo "<tr><td>Proveedor</td><td>".$row['nombre']."</td>";
								echo "<tr><td>Total</td><td>$".number_format($row['total'],2,".",",")."</td>";
								echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_pedido_prov' id='id_pedido_prov' value='$id_pedido_prov'>";
				?>
			</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" id="cerrr">Cerrar</button>

		</div>
		<!--/modal-footer -->

		<?php
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function deleted() {
	$id_pedido_prov = $_POST ['id_pedido_prov'];
	$table = 'pedido_prov';
	$table1 = 'pedido_prov_detalle';
	$id_sucursal = $_SESSION["id_sucursal"];
	$where_clause = "id_pedido_prov='".$id_pedido_prov."' AND id_sucursal='$id_sucursal'";
	$where_clause1 = "id_pedido='".$id_pedido_prov."'";
	_begin();
	$delete = _delete ( $table, $where_clause );
	$delete1 = _delete ( $table1, $where_clause1 );
	if ($delete && $delete1)
	{
		_commit();
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro borrado con exito!';
	}
	else
	{
		_rollback();
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser borrado'._error();
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
