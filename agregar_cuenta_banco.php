<?php
include_once "_core.php";
function initial()
{
	$id_banco = $_REQUEST["id_banco"];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Agregar Cuenta de Banco</h4>
	</div>
	<div class="modal-body">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<?php if ($links!='NOT' || $admin=='1' ){ ?>
				<div class="form-group has-info single-line">
					<label>Nombre</label>
					<input type="text" placeholder="Nombre" class="form-control" id="nombre" name="nombre" value="">
				</div>
				<div class="form-group has-info single-line">
					<label>Número</label>
					<input type="text" placeholder="Numero" class="form-control" id="numero" name="numero" value="">
				</div>
				<input type="hidden" name="process" id="process" value="insert">
				<input type="hidden" name="id_banco" id="id_banco" value="<?php echo $id_banco; ?>">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="submit1">Guardar</button>
		<button type="button" class="btn btn-danger" id="clos" data-dismiss="modal">Salir</button>
	</div>
	<?php
}
else
{
	echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
}
}
function insert()
{
	$id_banco=$_POST["id_banco"];
	$nombre=$_POST["nombre"];
	$numero=$_POST["numero"];
	$id_sucursal = $_SESSION['id_sucursal'];

	$sql_result= _query("SELECT * FROM cuenta_banco WHERE numero_cuenta='$numero'");
	$row_update=_fetch_array($sql_result);
	$numrows=_num_rows($sql_result);
	$table = 'cuenta_banco';
	$form_data = array (
		'id_banco' => $id_banco,
		'nombre_cuenta' => $nombre,
		'numero_cuenta' => $numero,
		'id_server' => '0',
		'id_sucursal' => $id_sucursal,
		'observaciones' => ''
	);
	if($numrows == 0)
	{
		$insertar = _insert($table,$form_data);
		if($insertar)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Datos ingresados correctamente !';
			$xdatos['process']='insert';
			$xdatos['id_banco']=$id_banco;
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Datos no pudieron ser ingresados !';
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
			case 'insert':
			insert();
			break;
			case 'formEdit' :
				initial();
				break;
			}
		}
	}
	?>
