<?php
include_once "_core.php";
include ('num2letras.php');
//include ('facturacion_funcion_imprimir.php');
//include("escpos-php/Escpos.php");
function initial() {
	$id_factura=$_REQUEST["id_factura"];
	$id_sucursal=$_REQUEST['id_sucursal'];
	$numero_docx=$_REQUEST['numero_doc'];
		//permiso del script
 	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	//$id_sucursal=$_SESSION['id_sucursal'];

	echo "<style type='text/css'>
    #inventable{
    	font-family: 'Open Sans';
    	 font-style: normal;
    	 font-size: small;
		font-weight: 400;
		src: local('Open Sans'), local('OpenSans'), url(fonts/apache/opensans/OpenSans-Regular.ttf) format('truetype'), url(fonts/apache/opensans/OpenSans.woff) format('woff');
    }
    .table thead tr > th.success{
		background-color: #428bca !important;
		color: white !important;
	}
	.table > tfoot > tr > .thick-line {
		border-top: 2px solid;
	}
	</style>";


	$sql="SELECT * FROM producto";
	$result=_query($sql);
	$count=_num_rows($result);

	$id_usuario=$_SESSION["id_usuario"];
	$id_sucursal=$_SESSION['id_sucursal'];
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$sql_fact="SELECT factura.*, cliente.nombre FROM factura JOIN cliente
	ON factura.id_cliente=cliente.id_cliente
	WHERE id_factura='$id_factura'
	AND factura.id_sucursal='$id_sucursal'
	";
	$result_fact = _query( $sql_fact);
	$count_fact = _num_rows( $result_fact);

?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Ver factura</h4>
</div>

<div class="modal-body">
		<div class="row" id="row1">
				<?php

						if ($links!='NOT' || $admin=='1' ){
					?>

						<?php
						if ($count_fact > 0) {
									for($i = 0; $i < $count_fact; $i ++) {
										$row = _fetch_array ( $result_fact, $i );
										$cliente=$row['nombre'];
										$factnum=$row['numero_doc'];
										$fecha=$row['fecha'];
							}
						}
						?>

						<!--div class="ibox "-->
						<div>
							<!--load datables estructure html-->
							<header><h4 class="text-danger">Factura No: &nbsp;<?php echo $factnum;  ?></h4>
							<h4  class='text-navy'>Fecha:<?php echo $fecha;  ?>&nbsp;
							Cliente:<?php echo $cliente; ?></h4>
							</header>
							<section>
								<div class="table-responsive m-t">
									<table class="table table-condensed table-striped" id="inventable">
									<thead class="thead-inverse">
										<tr>
										<th class='success'>Id</th>
										<th class='success'>Descripci&oacute;n</th>
										<th class='success'>Precio Vta.</th>
										<th class='success'>Cantidad</th>
										<th class='success'>Presentación</th>
										<th class='success' >Subtotal</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql_fact_det="SELECT factura.id_factura,producto.descripcion,
										presentacion_producto.descripcion AS preprodesc, presentacion_producto.unidad,
										presentacion.descripcion AS predesc,
										factura.id_cliente, factura.fecha,
										factura.numero_doc, factura.total,
										factura.id_usuario, factura.anulada,
										factura.id_usuario, factura.finalizada,
										factura.id_sucursal,
										factura_detalle.id_factura_detalle,
										factura_detalle.id_prod_serv,factura_detalle.cantidad,
										factura_detalle.precio_venta, factura_detalle.subtotal,
										factura_detalle.tipo_prod_serv, factura.tipo_documento,
										factura.sumas,factura.iva
										FROM factura
										JOIN factura_detalle  ON factura.id_factura=factura_detalle.id_factura
										JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
										JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
										JOIN presentacion ON presentacion_producto.id_presentacion=presentacion.id_presentacion
										WHERE
										factura.id_factura='$id_factura'
										AND factura.id_sucursal='$id_sucursal'";

										$result_fact_det=_query($sql_fact_det);
										$count_fact_det=_num_rows($result_fact_det);
										for($i=0;$i<$count_fact_det;$i++){
											$row=_fetch_array($result_fact_det);
											$numero_doc=$row['numero_doc'];
											$id_factura=$row['id_factura'];
											$id_producto=$row['id_prod_serv'];
											$tipo_prod=$row['tipo_prod_serv'];
											$anulada=$row['anulada'];
											$cantidad=$row['cantidad'];
											$precio_venta=$row['precio_venta'];
											$subtotal=$row['subtotal'];
											$total=$row['total'];
											$id_usuario=$row['id_usuario'];
											$total=sprintf("%.2f", $total);
											$descprod=$row['descripcion'];
											$preprodesc=$row['preprodesc'];
											$predesc=$row['predesc'];
											$unidad=$row['unidad'];
											$tipo=$row['tipo_documento'];
											$sumas=$row['sumas'];
											$iva=$row['iva'];




											echo "<tr>";
											echo "<td>".$id_producto."</td>";
											echo "<td>".$descprod."</td>";
											echo "<td id='pv' class='text-right'>".$precio_venta."</td>";
											echo "<td id='cant1' class='text-right'>".$cantidad/$unidad."</td>";
											echo "<td id='cant1' class='text-right'>".$predesc." ".$preprodesc."</td>";
											echo "<td id='subtot' class='text-right'>".number_format($subtotal,2)."</td>";
											//echo "<td id='combos' class='text-center'>".$combo_chk."</td>";
											echo "</tr>";
										}
										$sql_servicios = _query("SELECT * FROM  factura_detalle where id_factura=$id_factura AND id_prod_serv=-9999 AND id_presentacion=-9999");

								    while ($row_serv = _fetch_array($sql_servicios)) {
											echo "<tr>";
											echo "<td>"."</td>";
											echo "<td>".$row_serv['description']."</td>";
											echo "<td id='pv' class='text-right'>".$row_serv['precio_venta']."</td>";
											echo "<td id='cant1' class='text-right'>1"."</td>";
											echo "<td id='cant1' class='text-right'>"."</td>";
											echo "<td id='subtot' class='text-right'>".number_format($row_serv['subtotal'],2)."</td>";
										}

										?>

									</tbody>
									<tfoot>
										<?php
										$result_fact_det = _fetch_array(_query("SELECT * FROM factura where id_factura=$id_factura"));
										$tipo=$result_fact_det['tipo_documento'];
										$total=$result_fact_det['total_menos_retencion'];
										$total=sprintf("%.2f", $total);
										$sumas=$result_fact_det['sumas'];
										$iva=$result_fact_det['iva'];
										$retencion=$result_fact_det['retencion'];

										if ($tipo=="CCF") {
											# code...
											?>
											<tr>
												<td class=""></td>
												<td class=""></td>
												<td class=""></td>
												<td class=""></td>
												<td class="text-right"><strong>SUMAS $:</strong></td>
												<td  class="text-right" id='total_dinero' ><strong><?php echo $sumas; ?></strong></td>
											</tr>
											<tr>
												<td class=""></td>
												<td class=""></td>
												<td class=""></td>
												<td class=""></td>
												<td class=" text-right"><strong>IVA $:</strong></td>
												<td  class=" text-right" id='total_dinero' ><strong><?php echo $iva; ?></strong></td>
											</tr>

											<?php
										}
										 ?>
										<tr>
											<td class="thick-line"></td>
											<td class="thick-line"></td>
											<td class="thick-line"></td>
											<td class="thick-line"></td>
											<td class="thick-line text-right"><strong>TOTAL $:</strong></td>
											<td  class="thick-line text-right" id='total_dinero' ><strong><?php echo $total; ?></strong></td>
										</tr>
									</tfoot>
								</table>
								<?php
								list($entero,$decimal)=explode('.',$total);
								$enteros_txt=num2letras($entero);
							$decimales_txt=num2letras($decimal);

							if($entero>1)
								$dolar=" dolares";
							else
								$dolar=" dolar";
							$cadena_salida= "Son: <strong>".$enteros_txt.$dolar." con ".$decimal."/100 ctvs.</strong>";
							echo "<div class='well m-t'  id='totaltexto'>".$cadena_salida." </div>";

								?>


					</section>

						</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
				</div>
		</div>
	</div>


<?php
//include_once ("footer.php");
//echo "<script src='js/funciones/genera_venta.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}


function total_texto(){
	$total=$_REQUEST['total'];
	list($entero,$decimal)=explode('.',$total);
	$enteros_txt=num2letras($entero);
	$decimales_txt=num2letras($decimal);

	if($entero>1)
		$dolar=" dolares";
	else
		$dolar=" dolar";
	$cadena_salida= "Son: <strong>".$enteros_txt.$dolar." con ".$decimal."/100 ctvs.</strong>";
	echo $cadena_salida;
}

//functions to load
if(!isset($_REQUEST['process'])){
	initial();
}
//else {
if (isset($_REQUEST['process'])) {


	switch ($_REQUEST['process']) {
	case 'formEdit':
		initial();
		break;
	case 'consultar_stock':
		consultar_stock();
		break;
	}

 //}
}
?>
