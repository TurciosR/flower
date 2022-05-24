<?php
include_once "_core.php";
function initial()
{
	$id_movimiento = $_REQUEST["id_movimiento"];
	$id_sucursal = $_SESSION["id_sucursal"];
	$sql = _query("SELECT * FROM mov_cta_banco WHERE id_movimiento='$id_movimiento' AND id_sucursal='$id_sucursal'");
	$datos = _fetch_array($sql);
	$tipo  = $datos["tipo"];
	$fecha  = $datos["fecha"];
	$alias_tipodoc  = $datos["alias_tipodoc"];
	$numero_doc  = $datos["numero_doc"];
	$concepto  = $datos["concepto"];
	$responsable  = $datos["responsable"];
	$entrada  = $datos["entrada"];
	$salida  = $datos["salida"];
	if($tipo == "Ingreso")
	$monto = $entrada;
	else
	$monto = $salida;
	$fecha_v = $fecha;
	if($fecha > date("Y-m-d"))
	$fecha_v = date("Y-m-d");

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script

	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Editar Movimiento</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<?php if ($links!='NOT' || $admin=='1' ) { ?>		<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Tipo de Movimiento</label>
					<select id="tipo" class="form-control select" style="width: 100%;">
						<option value="">Seleccione</option>
						<option value="Ingreso" <?php if($tipo == "Ingreso"){ echo " selected "; }?>>Ingreso</option>
						<option value="Egreso" <?php if($tipo == "Egreso"){ echo " selected "; }?>>Egreso</option>
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Fecha de Movimiento</label>
					<input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Tipo de Documento</label>
					<select class="form-control select" id="alias_tipodoc" style="width: 100%;">
						<option value="">Seleccione</option>
						<option value="Cheque" <?php if($alias_tipodoc == "Cheque"){ echo " selected "; }?>>Cheque</option>
						<option value="Remesa" <?php if($alias_tipodoc == "Remesa"){ echo " selected "; }?>>Remesa</option>
						<option value="Voucher" <?php if($alias_tipodoc == "Voucher"){ echo " selected "; }?>>Voucher</option>
						<option value="Transferencia" <?php if($alias_tipodoc == "Transferencia"){ echo " selected "; }?>>Transferencia</option>
						<option value="Otro" <?php if($alias_tipodoc == "Otro"){ echo " selected "; }?>>Otro</option>
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Numero de documento</label>
					<input type="text" class="form-control" id="numero_doc" name="numero_doc" value="<?php echo $numero_doc; ?>">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group has-info single-line">
					<label>Concepto</label>
					<textarea class="form-control" id="concepto" cols="2"><?php echo $concepto; ?></textarea>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Responsable</label>
					<input type="text" name="responsable" id="responsable" class="form-control" value="<?php echo $responsable; ?>">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group has-info single-line">
					<label>Monto</label>
					<input type="text" class="form-control numeric" id="monto" name="monto" value="<?php echo $monto; ?>">
				</div>
				<input type="hidden" name="process" id="process" value="edited">
				<input type="hidden" name="id_movimiento" id="id_movimiento" value="<?php echo $id_movimiento; ?>">
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
			startDate: '<?php echo $fecha_v; ?>',
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
	$id_movimiento=$_POST["id_movimiento"];
	$id_cuenta=$_POST["id_cuenta"];
	$tipo=$_POST["tipo"];
	$fecha=$_POST["fecha"];
	$alias_tipodoc=$_POST["alias_tipodoc"];
	$numero_doc=$_POST["numero_doc"];
	$concepto=$_POST["concepto"];
	$responsable=$_POST["responsable"];
	$monto=$_POST["monto"];

	$sql_result= _query("SELECT * FROM mov_cta_banco WHERE id_cuenta='$id_cuenta' AND numero_doc='$numero_doc' AND id_movimiento!='$id_movimiento'");
	$numrows=_num_rows($sql_result);

	$sql = _query("SELECT saldo FROM mov_cta_banco WHERE id_movimiento<'$id_movimiento' AND id_cuenta='$id_cuenta' ORDER BY id_movimiento DESC LIMIT 1");
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
		'concepto' => $concepto
	);

	if($numrows == 0)
	{
		if(!$nalc)
		{
			$insertar = _update($table,$form_data,"id_movimiento='$id_movimiento'");

			if($insertar)
			{
				$xdatos['typeinfo']='Success';
				$xdatos['msg']='Datos modificados correctamente !';
				$xdatos['process']='insert';
				$xdatos['id_cuenta']=$id_cuenta;
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
			case 'edited':
			insert();
			break;
			case 'formEdit' :
				initial();
				break;
			}
		}
	}
	?>
