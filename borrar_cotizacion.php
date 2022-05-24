<?php
include ("_core.php");
function initial(){
	$id_cotizacion = $_REQUEST ['id_cotizacion'];
	$sql="SELECT c.nombre as cliente, co.numero_doc, co.total FROM cotizacion as co, cliente as c WHERE co.id_cliente=c.id_cliente AND id_cotizacion='$id_cotizacion'";
	$result = _query($sql);

	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Borrar Cotización</h4>
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
							while($row = _fetch_array ($result))
							{
								echo "<tr><td>Id</th><td>$id_cotizacion</td></tr>";
								echo "<tr><td>Numero</td><td>".$row ['numero_doc']."</td>";
								echo "<tr><td>Cliente</td><td>".$row ['cliente']."</td>";
								echo "<tr><td>Total</td><td>$".number_format($row ['total'],2,".",",")."</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			echo "<input type='hidden' nombre='id_cotizacion' id='id_cotizacion' value='$id_cotizacion'>";
			?>
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal" id="btncerr">Cerrar</button>
	</div>
	<!--/modal-footer -->

	<?php

	}
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function deleted()
{
	$id_cotizacion = $_POST ['id_cotizacion'];
	$table = 'cotizacion';
	$table1 = 'cotizacion_detalle';
	$where_clause = "id_cotizacion='" . $id_cotizacion . "'";
	_begin();
	$delete = _delete ( $table, $where_clause );
	$delete1 = _delete ( $table1, $where_clause );
	if ($delete && $delete1)
	{
		_commit();
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro eliminado con exito!';
	}
	else
	{
		_rollback();
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser eliminado!';
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
