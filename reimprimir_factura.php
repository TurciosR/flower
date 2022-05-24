<?php
include ("_core.php");
include ('num2letras.php');
include ('facturacion_funcion_imprimir.php');

function initial(){
	$id_factura = $_REQUEST ['id_factura'];
	//$sql="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$sql="SELECT factura.*, cliente.nombre FROM factura JOIN cliente
	ON factura.id_cliente=cliente.id_cliente
	WHERE id_factura='$id_factura'
	";
	$result = _query( $sql );
	$count = _num_rows( $result );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Imprimir factura</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<table class="table table-bordered table-striped" id="tableview">
					<thead>
						<tr>
							<th>Campo</th>
							<th>Descripcion</th>
						</tr>
					</thead>
					<tbody>
							<?php
								if ($count > 0) {
									for($i = 0; $i < $count; $i ++) {
										$row = _fetch_array ( $result, $i );
										$cliente=$row['nombre'];
										echo "<tr><td>Id factura</th><td>$id_factura</td></tr>";
										echo "<tr><td>Id Cliente</td><td>".$cliente."</td>";
										echo "<tr><td>Numero Doc</td><td>".$row['numero_doc']."</td>";
										echo "<tr><td>Total $:</td><td>".$row['total']."</td>";
										echo "</tr>";

									}
								}
							?>
						</tbody>
				</table>
			</div>
		</div>
			<?php
			echo "<input type='hidden' nombre='id_factura' id='id_factura' value='$id_factura'>";
			?>
		</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnPrint">Imprimir</button>
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
$id_sucursal=$_SESSION['id_sucursal'];
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
    $tipo_impresion=$row_fact['tipo_documento'];

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
				$direccion=$row["direccion"];
				$nit=$row["nit"];
				$dui=$row["dui"];
				$nrc=$row["nrc"];
				$nombreape=$nombre;
			}
		}

		if ($tipo_impresion=='COF'){
			$info_facturas=print_fact($id_factura, $tipo_impresion,"","");
		}
		if ($tipo_impresion=='CCF'){
				$info_facturas=print_ccf($id_factura,$tipo_impresion,$nit,$nrc,$nombreape,$direccion);
		}
		if ($tipo_impresion=='ENV'){
			$info_facturas=print_ccf($id_factura, $tipo_impresion, $nit, $nrc, $nombreape,"");
		}
		if ($tipo_impresion=='NC'){
			$tipo_impresion='DEV';
			$info_facturas=print_ncr($id_factura,$tipo_impresion,$nombreape,$direccion);
		}




		//directorio de script impresion cliente
		$headers="";
		$footers="";
		if ($tipo_impresion=='TIK') {
			$info_facturas=print_ticket($id_factura, $tipo_impresion);
			$sql_pos="SELECT *  FROM sucursal  WHERE id_sucursal='$id_sucursal' ";
			$result_pos=_query($sql_pos);
			$row1=_fetch_array($result_pos);
			$headers=$row1['descripcion']."|".Mayu($row1['direccion'])."|".$row1['giro']."|";
			$footers="GRACIAS POR SU COMPRA, VUELVA PRONTO......"."|";
		}

		if ($tipo_impresion=='DEV'){
			$tipo_impresion='TIK';
			$info_facturas=print_ticket_dev($id_factura);
			$sql_pos="SELECT *  FROM sucursal  WHERE id_sucursal='$id_sucursal' ";
			$result_pos=_query($sql_pos);
			$row1=_fetch_array($result_pos);
			$headers=$row1['descripcion']."|".Mayu($row1['direccion'])."|".$row1['giro']."|";
			$footers="DEVOLUCION DE PRODUCTO"."|";
		}

		$sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
		$result_dir_print=_query($sql_dir_print);
		$row_dir_print=_fetch_array($result_dir_print);
		$dir_print=$row_dir_print['dir_print_script'];
		$shared_printer_win=$row_dir_print['shared_printer_matrix'];
		$shared_printer_pos=$row_dir_print['shared_printer_pos'];
		$nreg_encode['tipo_impresion'] =$tipo_impresion;
		$nreg_encode['shared_printer_win'] =$shared_printer_win;
		$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
		$nreg_encode['dir_print'] =$dir_print;
		$nreg_encode['facturar'] =$info_facturas;
		$nreg_encode['sist_ope'] =$so_cliente;
		$nreg_encode['headers'] =$headers;
		$nreg_encode['footers'] =$footers;

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
