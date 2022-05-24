<?php
include ("_core.php");
function initial()
{
	$id_usuario = $_REQUEST['id_usuario'];
	$sql="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
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
		<h4 class="modal-title">Borrar Usuario</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<?php if ($links!='NOT' || $admin=='1' ){ ?>
						<table class="table table-bordered table-striped" id="tableview">
							<thead>
								<tr>
									<th class="col-xm-2">Campo</th>
									<th class="col-xm-4">Descripción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$row = _fetch_array($result);
								echo "<tr><td>Id</th><td>".$id_usuario."</td></tr>";
								echo "<tr><td>Nombre</td><td>".$row['nombre']."</td>";
                echo "<tr><td>Usuario</td><td>".$row['usuario']."</td>";
								echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_usuario' id='id_usuario' value='$id_usuario'>";
				?>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="btnDelete" name="btnDelete">Borrar</button>
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
	$id_usuario = $_POST ['id_usuario'];
	$table = 'usuario';
	$where_clause = "id_usuario='" . $id_usuario . "'";
	$delete = _delete ( $table, $where_clause );
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
