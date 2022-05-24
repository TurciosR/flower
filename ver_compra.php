<?php
include ("_core.php");
function initial(){
	$id_compra = $_REQUEST ['id_compra'];
	//$sql="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$sql="SELECT producto.descripcion,presentacion.nombre,presentacion_producto.unidad,detalle_compra.cantidad,detalle_compra.ultcosto,detalle_compra.subtotal FROM detalle_compra JOIN movimiento_producto ON movimiento_producto.id_compra=detalle_compra.id_compra JOIN producto ON producto.id_producto=detalle_compra.id_producto JOIN presentacion_producto ON presentacion_producto.id_pp=detalle_compra.id_presentacion JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE detalle_compra.id_compra=$id_compra
	";
	$result = _query( $sql );
	$count = _num_rows( $result );

	$sql_c=_query("SELECT * FROM compra WHERE id_compra=$id_compra");
	$row_c=_fetch_array($sql_c);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Ver detalle</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<table class="table table-bordered table-striped" id="tableview">
					<thead>
						<tr>
							<th>Descripción</th>
							<th>Presentación</th>
							<th>Cantidad</th>
							<th>Precio</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										?>
										<tr>
											<td><?php echo $row['descripcion'] ?></td>
											<td><?php echo $row['nombre'] ?></td>
											<td style="text-align: right"><?php $a=$row['cantidad']/$row['unidad']; echo $a ?></td>
											<td style="text-align: right"><?php echo number_format($row['ultcosto'],2,'.',',') ?></td>
											<td style="text-align: right"><?php echo number_format($row['subtotal'],2,'.',',') ?></td>
										</tr>
										<?php

									}
								}
							?>
							<?php
							if ($row_c['iva']!=0) {
								?>
								<tr>
									<td colspan="4">IVA</td>
									<td style="text-align: right"><?php echo number_format($row_c['iva'],2,'.',',') ?></td>
								</tr>
								<?php
							}
							 ?>
							<?php
 							if ($row_c['total_percepcion']!=0) {
 								?>
 								<tr>
 									<td colspan="4">Percepción</td>
 									<td style="text-align: right"><?php echo number_format($row_c['total_percepcion'],2,'.',',') ?></td>
 								</tr>
 								<?php
 							}
 							 ?>
						 <?php
							if ($row_c['total']!=0) {
								?>
								<tr>
									<td colspan="4">Total</td>
									<td style="text-align: right"><?php echo number_format($row_c['total'],2,'.',',') ?></td>
								</tr>
								<?php
							}
							 ?>

						</tbody>
				</table>
			</div>
		</div>
		</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>
<!--/modal-footer -->

<?php

}
function imprimir_fact() {
	$id_factura = $_REQUEST['id_factura'];
$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
$result_fact=_query($sql_fact);
$row_fact=_fetch_array($result_fact);
$nrows_fact=_num_rows($result_fact);
//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
$info = $_SERVER['HTTP_USER_AGENT'];
if(strpos($info, 'Windows') == TRUE)
	$so_cliente='win';
else
	$so_cliente='lin';

if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$fecha=$row_fact['fecha'];
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];
    $tipo_impresion = substr($numero_doc, -3);

		$sql="SELECT * FROM cliente
		WHERE
		id_cliente='$id_cliente'";

		$result=_query($sql);
		$count=_num_rows($result);
		if ($count > 0) {
			for($i = 0; $i < $count; $i ++) {
				$row = _fetch_array ( $result);
				$id_cliente=$row["id_cliente"];
				$nombre=$row["nombre"];
				$apellido=$row["apellido"];
				$nit=$row["nit"];
				$dui=$row["dui"];
				$nrc=$row["nrc"];
				$nombreape=$nombre." ".$apellido;
			}
		}
		if ($tipo_impresion=='COF'){
			$info_facturas=print_fact($id_factura,$tipo_impresion);
		}
		if ($tipo_impresion=='TIK'){
			$info_facturas=print_ticket($id_factura,$tipo_impresion);
		}

		if ($tipo_impresion=='CCF'){
			$info_facturas=print_ccf($id_factura,$tipo_impresion,$nit,$nrc,$nombreape);
		}
		if ($tipo_impresion=='ENV'){
			$info_facturas=print_envio($id_factura,$tipo_impresion);
		}

		//directorio de script impresion cliente
		$sql_dir_print="SELECT *  FROM empresa";
		$result_dir_print=_query($sql_dir_print);
		$row_dir_print=_fetch_array($result_dir_print);
		$dir_print=$row_dir_print['dir_print_script'];
		$shared_printer_win=$row_dir_print['shared_printer_win'];
		$shared_printer_pos=$row_dir_print['shared_printer_pos'];
		$nreg_encode['shared_printer_win'] =$shared_printer_win;
		$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
		$nreg_encode['dir_print'] =$dir_print;
		$nreg_encode['tipo_impresion'] =$tipo_impresion;
		$nreg_encode['facturar'] =$info_facturas;
		$nreg_encode['sist_ope'] =$so_cliente;
		echo json_encode($nreg_encode);

	}
}

if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'formDelete' :
				initial();
				break;
			case 'reimprimir' :
				reimprimir();
				break;
			case 'imprimir_fact' :
				imprimir_fact();
				break;
		}
	}
}

?>
