<?php
include_once "_core.php";
function initial()
{
	$id_cuenta = $_REQUEST["id_cuenta"];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Agregar Movimiento</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row">
		<?php if ($links!='NOT' || $admin=='1' ){	?>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
			<label>Tipo de Movimiento</label>
				<select id="tipo" class="form-control select" style="width: 100%;">
					<option value="">Seleccione</option>
					<option value="Ingreso">Ingreso</option>
					<option value="Egreso">Egreso</option>
				</select>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
				<label>Fecha de Movimiento</label>
				<input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>">
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
			<label>Tipo de Documento</label>
				<select class="form-control select" id="alias_tipodoc" style="width: 100%;">
					<option value="">Seleccione</option>
					<option value="Cheque">Cheque</option>
					<option value="Remesa">Remesa</option>
					<option value="Voucher">Voucher</option>
					<option value="Transferencia">Transferencia</option>
					<option value="Otro">Otro</option>
				</select>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
				<label>Numero de documento</label>
				<input type="text" class="form-control" id="numero_doc" name="numero_doc">
			</div>
		</div>
		<div class="col-lg-12">
			<div class="form-group has-info single-line">
				<label>Comentario</label>
				<textarea class="form-control" id="concepto" cols="2"></textarea>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
			<label>A nombre de</label>
				<input type="text" name="responsable" id="responsable" class="form-control">
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group has-info single-line">
				<label>Monto</label>
				<input type="text" class="form-control numeric" id="monto" name="monto">
			</div>
			<input type="hidden" name="process" id="process" value="insert">
		</div>
	</div>
</div>
<div class="modal-footer">
  	<button type="button" class="btn btn-primary" id="submit1">Guardar</button>
  	<button type="button" class="btn btn-danger" id="clos" data-dismiss="modal">Salir</button>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select").select2();
		$(".numeric").numeric({negative:false});
		$("#fecha").datepicker({
			startDate: 'today',
			format: 'yyyy-mm-dd',
			language:'es',
		});
	});
</script>
<?php
} //permiso del script
else
{
	echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div>";
}
}
function insert()
{
	$id_cuenta=$_POST["id_cuenta"];
	$tipo=$_POST["tipo"];
	$fecha=$_POST["fecha"];
	$alias_tipodoc=$_POST["alias_tipodoc"];
	$numero_doc=$_POST["numero_doc"];
	$concepto=$_POST["concepto"];
	$responsable=$_POST["responsable"];
	$monto=$_POST["monto"];
	$id_sucursal=$_SESSION["id_sucursal"];

	$sql_result= _query("SELECT * FROM mov_cta_banco WHERE id_sucursal='$id_sucursal' AND id_cuenta='$id_cuenta' AND numero_doc='$numero_doc'");
	$numrows=_num_rows($sql_result);

	$sql = _query("SELECT saldo FROM mov_cta_banco WHERE id_sucursal='$id_sucursal' AND id_cuenta='$id_cuenta' ORDER BY id_movimiento DESC LIMIT 1");
	$row = _fetch_array($sql);
	$saldo = $row["saldo"];
	$nalc = 0;
	if($tipo == "Ingreso")
	{
		$entrada = $monto;
		$salida = 0;
		$nsal = $saldo + $monto;
	}
	else
	{
		$salida = $monto;
		$entrada = 0;
		if($salida > $saldo)
		{
			$nalc = 1;
			$nsal = 0;
		}
		else
		{
			$nsal = $saldo - $monto;
		}
	}
	$table = 'mov_cta_banco';
	$form_data = array (
		'id_cuenta' => $id_cuenta,
		'tipo' => $tipo,
		'alias_tipodoc' => $alias_tipodoc,
		'numero_doc' => $numero_doc,
		'entrada' => $entrada,
		'salida' => $salida,
		'saldo' => $nsal,
		'fecha' => $fecha,
		'responsable' => $responsable,
		'concepto' => $concepto,
		'id_sucursal' => $id_sucursal,
	);
	if($numrows == 0)
	{
		if(!$nalc)
		{
			$insertar = _insert($table,$form_data);

			if($insertar)
			{
				$xdatos['typeinfo']='Success';
				$xdatos['msg']='Registro ingresado correctamente !';
				$xdatos['process']='insert';
				$xdatos['id_cuenta']=$id_cuenta;
			}
			else
			{
				$xdatos['typeinfo']='Error';
				$xdatos['msg']='Registro no pudieron ser ingresado!';
				$xdatos['process']='none';
			}
		}
		else
		{
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='No hay suficiente dinero para hacer el Movimiento !';
			$xdatos['process']='none';
		}
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Este movimiento ya fue registrado !';
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
