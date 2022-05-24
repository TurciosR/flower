<?php
include ("_core.php");
function initial()
{
	$id_pedido = $_REQUEST ['id_pedido'];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links="yes";//permission_usr($id_user,$filename);
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Procesar Pedido</h4>
	</div>
	<div class="modal-body">
			<div class="row">
					<div class="col-lg-12">
						<?php if ($links!='NOT' || $admin=='1' ){ ?>
							<div class="alert alert-warning">
								Esta seguro que desea Procesar este pedido??
							</div>
					</div>
				</div>
				<?php
				echo "<input type='hidden' nombre='id_pedido' id='id_pedido' value='$id_pedido'>";
				?>
			</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="btnProc" >Procesar</button>
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
	$id_pedido = $_POST ['id_pedido'];
	$table = 'pedido';
	$form_data = array(
		'estado' => 'FINALIZADO',
	);
	$where_clause = "id_pedido='" . $id_pedido . "'";
	$delete = _update( $table, $form_data, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro procesado con exito!';
	}
	else
	{
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser procesado!';
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
