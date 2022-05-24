<?php
include ("_core.php");
function initial(){
	$id_presentacion = $_REQUEST ['id_presentacion'];
	$sql="SELECT *FROM presentacion WHERE id_presentacion='$id_presentacion'";
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
		<h4 class="modal-title">Borrar Presentación</h4>
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
								echo "<tr><td>Id</th><td>$id_presentacion</td></tr>";
								echo "<tr><td>Nombre</td><td>".$row ['nombre']."</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<?php
			echo "<input type='hidden' nombre='id_presentacion' id='id_presentacion' value='$id_presentacion'>";
			?>
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

	</div>
	<!--/modal-footer -->

	<?php

	}
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function deleted() {
	$id_presentacion = $_POST ['id_presentacion'];
	$table = 'presentacion';
	$where_clause = "id_presentacion='" . $id_presentacion . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro eliminado con exito!';
	}
	else
	{
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
