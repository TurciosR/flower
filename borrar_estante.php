<?php
include ("_core.php");
function initial()
{
	$id_estante = $_REQUEST ['id_estante'];
	$sql="SELECT e.id_estante, e.descripcion as estante, a.id_ubicacion, a.descripcion as ubicacion FROM estante as e, ubicacion as a WHERE a.id_ubicacion=e.id_ubicacion AND e.id_estante='$id_estante'";
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
	<h4 class="modal-title">Borrar Estante</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<?php if($links != 'NOT' || $admin == '1'){ ?>
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
							$id_ubicacion = $row["id_ubicacion"];
							$sql_aux = _query("SELECT * FROM posicion WHERE id_ubicacion = '$id_ubicacion' AND id_estante = '$id_estante'");
							$npos = _num_rows($sql_aux);
							echo "<tr><td>Id</th><td>$id_estante</td></tr>";
							echo "<tr><td>Ubicación</td><td>".$row['ubicacion']."</td>";
							echo "<tr><td>Estante</td><td>".$row['estante']."</td>";
							echo "<tr><td>Posiciones</td><td>".$npos."</td>";
							echo "</tr>";
						?>
					</tbody>
				</table>
			</div>
		</div>
			<?php
				echo "<input type='hidden' nombre='id_estante' id='id_estante' value='$id_estante'>";
			?>
		</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
<?php
	}
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function deleted()
{
	_begin();
	$id_estante = $_POST ['id_estante'];
	$table = 'estante';
	$where_clause = "id_estante='" . $id_estante . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete)
	{
		$table = "posicion";
		$where_clause = "id_estante='".$id_estante."'";
		$delete = _delete ( $table, $where_clause );

		if ($delete)
		{
			_commit();
			$table = "posicion";
			$where_clause = "id_estante='".$id_estante."'";
			$xdatos ['typeinfo'] = 'Success';
			$xdatos ['msg'] = 'Registro borrado con exito!';
		}
		else
		{
			_rollback();
			$xdatos ['typeinfo'] = 'Error';
			$xdatos ['msg'] = 'Registro no pudo ser borrado!';
		}
	}
	else
	{
		_rollback();
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
