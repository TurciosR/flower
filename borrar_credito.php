<?php
include ("_core.php");
function initial(){
	$id_credito = $_REQUEST ['id_credito'];
	$sql="SELECT *FROM credito WHERE id_credito='$id_credito'";
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
		<h4 class="modal-title">Borrar Credito</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<div class="alert alert-warning">
						Esta seguro que desea eliminar este Credito ???
					</div>
				</div>
			</div>
			<?php
			echo "<input type='hidden' nombre='id_credito' id='id_credito' value='$id_credito'>";
			?>
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-danger" id="btnDelete">Borrar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal" id="btnSal">Cerrar</button>
	</div>
	<!--/modal-footer -->

	<?php
}
function deleted() {
	$id_credito = $_POST ['id_credito'];
	$table = 'credito';
	$table1 = 'abono_credito';
	$where_clause = "id_credito='" . $id_credito . "'";
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
