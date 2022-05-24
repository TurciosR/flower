<?php
include ("_core.php");
function initial()
{
	$id_ubicacion = $_REQUEST ['id_ubicacion'];
	$sql="SELECT * FROM ubicacion WHERE id_ubicacion='$id_ubicacion'";
	$result = _query($sql);

	$sql_aux = _query("SELECT SUM(cantidad) as existencia FROM stock_ubicacion WHERE id_ubicacion='$id_ubicacion'");
	$dats_aux = _fetch_array($sql_aux);
	$existencia = $dats_aux["existencia"];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Borrar Ubicación</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row">
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
								echo "<tr><td>Id</th><td>$id_ubicacion</td></tr>";
								echo "<tr><td>Ubicación</td><td>".$row['descripcion']."</td>";
								echo "</tr>";
								?>
							</tbody>
						</table>
						<?php if($existencia>0){?>
						<div class="alert alert-warning">No puede eliminar esta ubicación por que posee existencias asignadas, por favor reasigne los productos de esta ubicación para luego proceder a borrarla</div>
					<?php }?>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_ubicacion' id='id_ubicacion' value='$id_ubicacion'>";
				?>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="btnDelete" <?php if($existencia>0){ echo " disabled "; } ?>>Borrar</button>
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
	$id_ubicacion = $_POST ['id_ubicacion'];
	$table = 'ubicacion';
	$form_data = array(
		'borrado' => 1,
	);
	$where_clause = "id_ubicacion='" . $id_ubicacion . "'";
	$delete = _update( $table, $form_data, $where_clause );
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
}
else
{
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
