<?php
include ("_core.php");
function initial(){
	$id_voucher = $_REQUEST ['id_voucher'];
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$sql=_fetch_array(_query("SELECT monto, forma_pago FROM voucher WHERE id_voucher=$id_voucher"));
	$monto=$sql['monto'];	//permiso del script
	$forma=$sql['forma_pago'];	//permiso del script
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title"></h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<?php	if ($links!='NOT' || $admin=='1' ){
					if($forma != "Efectivo"){
						if($forma == "Cheque"){
				?>
				<div class="alert alert-warning">
					Para finalizar la transacción ingrese la cantidad de cheques con los que se pagara, sus numeros  y los montos de los mismos
				</div>
			<?php } else if($forma == "Transferencia"){ ?>
			<div class="alert alert-warning">
				Para finalizar la transacción ingrese el numero de referencia de la Transferencia
			</div>
		<?php }?>
				<div class="row">
					<div class="col-lg-6">
						<label>Monto a verificar</label>
						<input class="form-control" readonly type="text" id="monto" name="monto" value="<?php echo $monto ?>">
					</div>
					<?php 	if($forma == "Cheque"){ ?>
					<div class="col-lg-6">
						<label>Cant. de cheques</label>
						<input class="form-control" type="text" id="cn" name="cn" value="">
						<br>
						<button class="btn btn-success" type="button" id="cns" name="cns">Agregar cheques</button>
					</div>
				<?php } else if($forma == "Transferencia"){?>
					<div class="col-lg-6">
						<label>Numero de Transferencia</label>
						<input class="form-control" type="text" id="nt" name="nt" value="">
					</div>
				<?php }?>
				</div>
				<?php if($forma == "Cheque"){?>
				<div class="row">
					<br>
					<table id='tabla' class="table table-striped">
						<tr>
							<td>Numero</td>
							<td>Monto</td>
						</tr>

					</table>
				</div>
				<?php }
			} else{
			?>
			<div class="alert alert-warning">
			Esta seguro que desea finalizar este pago?
			</div>
		<?php }?>
			</div>
		</div>
			<?php
			echo "<input type='hidden' nombre='id_voucher' id='id_voucher' value='$id_voucher'>";
			echo "<input type='hidden' nombre='forma' id='forma' value='$forma'>";
			?>
		</div>

</div>
<div class="modal-footer">
	<button type="button" <?php if($forma == "Cheque"){ echo " disabled "; }?> class="btn btn-primary" id="btnFin">Finalizar</button>
	<button type="button" class="btn btn-warning" data-dismiss="modal" id="clos">Salir</button>

</div>
<!--/modal-footer -->
<script type="text/javascript">
$(document).ready(function() {
	$('#cn').numeric({negative:false,decimal:false});
	$('#nt').numeric({negative:false,decimal:false});
});
</script>

<?php
	} //permiso del script
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function finalizar()
{
	$ver1=0;
	$ver2=0;
	$id_voucher=$_POST['id_voucher'];
	$forma=$_POST['forma'];

	$referencia = "";
	$pass = 1;
	_begin();
	$sql_moo = _query("SELECT id_movimiento FROM voucher WHERE id_voucher='$id_voucher'");
	$dats = _fetch_array($sql_moo);
	$id_movimiento = $dats["id_movimiento"];
	$rs=_query("SELECT * FROM voucher_mov WHERE id_movimiento=$id_voucher");
	while ($row2=_fetch_array($rs))
	{
		$table='cuenta_pagar';
		$form_data = array(
			'saldo_pend' => 0,
		);
		$where_clause="id_cuenta_pagar='".$row2['id_cuenta_pagar']."'";
		$update= _update($table,$form_data,$where_clause);
		if(!$update)
		{
			$ver1=1;
		}
	}
	if($forma == "Cheque")
	{
		$array_json=$_POST["array_json"];
		$array = json_decode($array_json,true);
		$comentario = 'Abono con cheque numero: ';
		foreach ($array as $fila) {
			$table='cheque';
			$form_data= array(
				'cheque' => $fila['cheque'],
				'monto' => $fila['monto'],
				'id_movimiento' => $id_movimiento,
			);
			$comentario.="#".$fila['cheque']." .";
			$referencia = "#".$fila['cheque']." ";
			$insertar = _insert($table,$form_data);
			if (!$insertar)
			{
				$ver2=1;
			}
		}
		$table='mov_cta_banco';
		$form_data=array(
			'concepto' => $comentario,
		);
		$where_clause="id_movimiento='".$id_movimiento."'";
		$update = _update($table,$form_data,$where_clause);
		$ver3=0;
		if(!$update)
		{
			$ver3=1;
		}
		if ($ver1==0&&$ver2==0&&$ver2==0)
		{

		}
		else
		{
			$pass = 0;
		}
	}
	else if($forma == "Transferencia")
	{
		$referencia=$_POST['nt'];
	}
	else
	{
	}
	$table_up = "voucher";
	$form_dat_up = array(
		'referencia_pago' => $referencia,
		'estado' => 'FINALIZADO',
	);
	$where_up = "id_voucher='".$id_voucher."'";
	$upd = _update($table_up, $form_dat_up, $where_up);
	if($upd && $pass)
	{
		_commit();
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro finalizado con exito!';
	}
	else
	{
		_rollback();
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser finalizado!';
	}
	echo json_encode ( $xdatos );

}
function deleted()
{
	$id_movimiento = $_POST ['id_movimiento'];
	$table = 'mov_cta_banco';
	$where_clause = "id_movimiento='" . $id_movimiento . "'";
	$delete = _delete ( $table, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro eliminado con exito!';
	}
	else
	{
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser eliminado!';
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
			case 'finalizar' :
				finalizar();
				break;
		}
	}
}

?>
