<?php
include ("_core.php");

function initial(){
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$id_sucursal=$_SESSION['id_sucursal'];
	date_default_timezone_set('America/El_Salvador');
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$id_corte = $_REQUEST["id_corte"];
	$sql_cc =_query("SELECT * FROM controlcaja WHERE id_corte = '$id_corte'");
	$row_cc = _fetch_array($sql_cc);

	$fecha_corte = ED($row_cc["fecha_corte"]);
	$hora_corte = $row_cc["hora_corte"];
	$id_empleado_c = $row_cc["id_empleado"];
	$id_apertura = $row_cc["id_apertura"];
	$tipo_corte = $row_cc["tipo_corte"];
	$total = $row_cc["cashfinal"];
	$diferencia = $row_cc["diferencia"];

	$sql_empleadox = _query("SELECT * FROM usuario WHERE id_usuario = '$id_empleado_c'");
	$rr = _fetch_array($sql_empleadox);
	$nombre = $rr["nombre"];

	$sql_ap = _query("SELECT * FROM apertura_caja WHERE id_apertura = '$id_apertura'");
	$ap = _fetch_array($sql_ap);
	$turno = $ap["turno"];
	//permiso del script



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

    	<table class="table">
    		<thead>
    			<tr>
    				<th>Campo</th>
    				<th>Descripción</th>
    			</tr>
    		</thead>
	    	<tbody>
	    		<tr>
	    			<td><label>Fecha:</label></td>
	    			<td><?php echo $fecha_corte; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Hora:</label></td>
	    			<td><?php echo $hora_corte; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Empleado:</label></td>
	    			<td><?php echo $nombre; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Turno:</label></td>
	    			<td><?php echo $turno; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Tipo corte:</label></td>
	    			<td><?php echo $tipo_corte; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Total:</label></td>
	    			<td><?php echo "$".$total; ?></td>
	    		</tr>
	    		<tr>
	    			<td><label>Diferencia:</label></td>
	    			<td><?php echo "$".$diferencia; ?></td>
	    		</tr>
    		</tbody>
    	</table>
	</div>
		<!--/div-->
		<!--/div-->
	<input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $empleado;?>">
	<input type="hidden" name="turno" id="turno" value="<?php echo $turno;?>">
	<input type="hidden" name="id_apertura" id="id_apertura" value="<?php echo $id_apertura;?>">
	<input type="hidden" name="id_corte" id="id_corte" value="<?php echo $id_corte;?>">
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnReimprimir">Imprimir</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
<!--/modal-footer -->

<?php


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
