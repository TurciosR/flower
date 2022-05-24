<?php
include ("_core.php");
function initial(){
	$id_banco = $_REQUEST ['id_banco'];
	$id_cuenta = $_REQUEST ['id_cuenta'];
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
		<h4 class="modal-title">Borrar Cuenta</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<?php if ($links!='NOT' || $admin=='1' ){	?>
						<div class="alert alert-warning">
							Esta seguro que desea eliminar esta cuenta?
						</div>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_banco' id='id_banco' value='$id_banco'>";
				echo "<input type='hidden' nombre='id_cuenta' id='id_cuenta' value='$id_cuenta'>";
				?>
			</div>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="btnDelete">Borrar</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="clos">Salir</button>

		</div>
		<!--/modal-footer -->

		<?php
	} //permiso del script
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div>";
	}
}
function deleted()
{
	$id_banco = $_POST['id_banco'];
	$id_cuenta = $_POST['id_cuenta'];
	$table = 'cuenta_banco';
	$where_clause = "id_cuenta='" . $id_cuenta . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro borrado con exito!';
		$xdatos['id_banco']=$id_banco;
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
