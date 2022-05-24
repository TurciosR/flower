<?php
include ("_core.php");

function initial()
{
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$id_sucursal=$_SESSION['id_sucursal'];
	date_default_timezone_set('America/El_Salvador');
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script

	//include ('facturacion_funcion_imprimir.php');
	//$sql="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user'");
	$cuenta = 1;
	$row_apertura = _fetch_array($sql_apertura);
	$id_apertura = $row_apertura["id_apertura"];
	$empleado = $row_apertura["id_empleado"];
	$turno = $row_apertura["turno"];
	$fecha_apertura = $row_apertura["fecha"];
	$hora_apertura = $row_apertura["hora"];
	$monto_apertura = $row_apertura["monto_apertura"];

	$hora_actual = date('H:i:s');
	if($cuenta > 0)
	{
	$id_movimiento = $_REQUEST["id_movimiento"];
	$sql_movimiento = _query("SELECT * FROM mov_caja WHERE id_movimiento = '$id_movimiento'");
	$rr = _fetch_array($sql_movimiento);
	$entrada = $rr["entrada"];
	$salida = $rr["salida"];
	$concepto = $rr["concepto"];
	$monto = $rr["valor"];
	$detalle = "";
	if($entrada == 1 && $salida == 0)
	{
		$detalle = "Entrada";
		$alert = "alert-success";
	}
	else if($salida == 1 && $entrada == 0)
	{
		$detalle = "Salida";
		$alert = "alert-warning";
	}
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Imprimir</h4>
</div>
<div class="modal-body">
	<!--div class="wrapper wrapper-content  animated fadeInRight"-->
	<div class="row" id="row1">
		<!--div class="col-lg-12"-->
		<?php
					//permiso del script
			if ($links!='NOT' || $admin=='1' ){
		?>
		<div class="row">
			<div class="col-md-12">
	          <div class="form-group has-info text-center alert <?php echo $alert; ?>">
	          	<label><?php echo $detalle; ?></label>
	          </div>
			</div>
    	</div>
    	<table class="table">
    		<tr>
    			<td><label>Concepto:</label></td>
    			<td><?php echo $concepto; ?></td>
    		</tr>
    		<tr>
    			<td><label>Monto:</label></td>
    			<td><?php echo "$".$monto; ?></td>
    		</tr>
    	</table>
	</div>
		<!--/div-->
		<!--/div-->
	<input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $empleado;?>">
	<input type="hidden" name="turno" id="turno" value="<?php echo $turno;?>">
	<input type="hidden" name="id_apertura" id="id_apertura" value="<?php echo $id_apertura;?>">
	<input type="hidden" name="id_movimiento" id="id_movimiento" value="<?php echo $id_movimiento;?>">
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnReimprimir">Imprimir</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
<!--/modal-footer -->

<?php

} //permiso del script
	else
	{
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
else
{
	echo "<div></div><br><br><div class='alert alert-warning text-center'>No se ha encontrado una apertura vigente.</div>";
}
}

function editar()
{
	date_default_timezone_set("America/El_Salvador");
	$id_empleado = $_POST["id_empleado"];
	$id_apertura = $_POST["id_apertura"];
	$turno = $_POST["turno"];
	$concepto = $_POST["concepto"];
	$monto = $_POST["monto"];
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_movimiento = $_POST["id_movimiento"];

	$fecha = date("Y-m-d");
	$hora = date("H:i:s");

	$tabla = "mov_caja";
	$form_data = array(
		'valor' => $monto,
		'concepto' => $concepto,
		);
	$where_mov = "id_movimiento='".$id_movimiento."'";
	$update = _update($tabla, $form_data, $where_mov);
	if($update)
	{
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Movimiento editado correctamente !';
		$xdatos['process']='insert';
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Error al editar el movimiento !'._error();
	}
	echo json_encode($xdatos);
}

if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'formDelete' :
				initial();
				break;
			case 'editar' :
				editar();
				break;
		}
	}
}

?>
