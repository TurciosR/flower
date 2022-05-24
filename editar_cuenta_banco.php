<?php
include_once "_core.php";
function initial()
{
	$id_banco = $_REQUEST["id_banco"];
	$id_cuenta = $_REQUEST["id_cuenta"];
	$sql = _query("SELECT * FROM cuenta_banco WHERE id_cuenta='$id_cuenta'");
	$datos = _fetch_array($sql);
	$nombre = $datos["nombre_cuenta"];
	$numero = $datos["numero_cuenta"];

	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Editar Cuenta</h4>
	</div>
	<div class="modal-body">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<?php if ($links!='NOT' || $admin=='1' ){	?>
					<div class="form-group has-info single-line">
						<label>Nombre de la cuenta</label>
						<input type="text" placeholder="Nombre" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
					</div>
					<div class="form-group has-info single-line">
						<label>Numero de Cuenta</label>
						<input type="text" placeholder="Numero" class="form-control" id="numero" name="numero" value="<?php echo $numero; ?>">
					</div>
					<input type="hidden" name="process" id="process" value="edited">
					<input type="hidden" name="id_banco" id="id_banco" value="<?php echo $id_banco; ?>">
					<input type="hidden" name="id_cuenta" id="id_cuenta" value="<?php echo $id_cuenta; ?>">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="submit1">Guardar</button>
			<button type="button" class="btn btn-danger" id="clos" data-dismiss="modal">Salir</button>
		</div>
		<?php
	} //permiso del script
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div>";
	}
}
function edited()
{
	$id_banco=$_POST["id_banco"];
	$id_cuenta=$_POST["id_cuenta"];
	$nombre=$_POST["nombre"];
	$numero=$_POST["numero"];

	$sql_result= _query("SELECT * FROM cuenta_banco WHERE numero_cuenta='$numero' AND id_cuenta!='$id_cuenta'");
	$row_update=_fetch_array($sql_result);
	$numrows=_num_rows($sql_result);
	$table = 'cuenta_banco';
	$form_data = array (
		'id_banco' => $id_banco,
		'nombre_cuenta' => $nombre,
		'numero_cuenta' => $numero
	);
	$where = "id_cuenta='".$id_cuenta."'";
	if($numrows == 0)
	{

		$insertar = _update($table,$form_data,$where);

		if($insertar)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Datos modificados correctamente !';
			$xdatos['process']='insert';
			$xdatos['id_banco']=$id_banco;
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Datos no pudieron ser modificados !';
			$xdatos['process']='none';
		}
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Este numero de cuenta ya fue registrado !';
		$xdatos['process']='none';
	}
	echo json_encode($xdatos);
}

if(!isset($_REQUEST['process'])){
	initial();
}
else
{
	if(isset($_REQUEST['process'])){
		switch ($_REQUEST['process']) {
			case 'edited':
			edited();
			break;
			case 'formEdit' :
				initial();
				break;
			}
		}
	}
	?>
