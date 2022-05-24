<?php
include_once "_core.php";
include ('num2letras.php');

include ('facturacion_funcion_imprimir.php');
//include("escpos-php/Escpos.php");
function initial() {
		$title="Venta ";
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/bootstrap-checkbox/bootstrap-checkbox.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	//$_PAGE ['links'] .= '<link href="css/style_fact.css" rel="stylesheet">';
  	$_PAGE ['links'] .= '<link href="css/style_table3.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";
	$sql="SELECT * FROM producto";
	$result=_query($sql);
	$count=_num_rows($result);
	$id_usuario=$_SESSION["id_usuario"];



	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$id_sucursal=$_SESSION['id_sucursal'];

	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'");
	$cuenta = _num_rows($sql_apertura);

	$turno_vigente=0;
	if($cuenta>0){
		$row_apertura = _fetch_array($sql_apertura);
		$id_apertura = $row_apertura["id_apertura"];
		$turno = $row_apertura["turno"];
		$fecha_apertura = $row_apertura["fecha"];
		$hora_apertura = $row_apertura["hora"];
		$turno_vigente = $row_apertura["turno_vigente"];
	}

	// cliente
	$array0= array();
	$sql0=_query("SELECT * FROM cliente ORDER BY id_cliente");
	$count0=_num_rows($sql0);
	for ($j=0;$j<$count0;$j++) {
			$row_cliente=_fetch_array($sql0);
			$id_cliente=$row_cliente['id_cliente'];
			$description=$row_cliente['nombre']." ".$row_cliente['apellido'];
			$array0[$id_cliente] = $description;
	}
	//
	$sql3="SELECT * FROM presentacion_producto";
$result3=_query($sql3);
$count3=_num_rows($result3);
$arrayx = array(-1=>"Seleccione");
for ($x=0;$x<$count3;$x++){
	$row3=_fetch_array($result3);
	$id1=$row3['id_presentacion'];
	$description=$row3['descripcion'];
	$arrayx[$id1] = $description;
}
?>

	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<?php
						//permiso del script
						if ($links!='NOT' || $admin=='1' ){
							if ($turno_vigente=='1'){

			            ?>
				<input type='hidden' name='urlprocess' id='urlprocess' value="<?php echo $filename;?>">
				<input type="hidden" name="process" id="process" value="insert">

			<div class="ibox-content">
				<section>
					<?php
		$fecha_actual=date("Y-m-d");
	?>
					<div class="panel">

						<div class="widget stacked widget-table action-table">
							<!-- buscador Superior -->
							<div class="widget-header">
								<div class="row">
									<div class="col-md-6">&nbsp;&nbsp;
										<i class="fa fa-search"> </i>
										<h3 class="text-navy" id='title-table'>&nbsp;Buscar Productos</h3>
									</div>
									<div class="col-md-3">
										<label class="pull-right">Fecha: </label>
									</div>
									<div class="col-md-3 text-center">
										<input type='text' style="height: 32px; margin-top:1.5%; width: 90%;" placeholder='Fecha' class='datepick form-control' id='fecha' name='fecha' value='<?php echo $fecha_actual;?>'>
									</div>
								</div>
							</div>
							<!-- /widget-header   -->

							<div class="widget-content">
								<div class="row">
									<div class="col-md-12">

										<div id='form_datos_cliente' class="form-group col-md-3">
											<div class="form-group has-info single-line">
												<label>Seleccione tipo Impresi&oacuten</label>
												<select name='tipo_impresion' id='tipo_impresion' class='select2 form-control'>
												 <option value='TIK' selected>TICKET</option>
												 <option value='COF'>FACTURA CONSUMIDOR FINAL</option>
												 <option value='ENV'>NOTA DE ENVIO</option>
												 <option value='CCF'>CREDITO FISCAL</option>
											 </select>
											</div>
										</div>


										<div  class="form-group col-md-3">
											<div class="form-group has-info single-line">

												<label>Seleccione tipo de pago</label><br>
												<select name='con_pago' id='con_pago' class=' select2 form-control'>
													<option value='0' selected>Contado</option>
													<option value='1' >Credito</option>
												</select>
											</div>
										</div>
										<div  class="form-group col-md-3">
											<div class="form-group has-info single-line">

												<label>Seleccione Vendedor</label><br>
												<select name='vendedor' id='vendedor' class=' select2 form-control'>
													<?php
													$sql=_query("SELECT empleado.id_empleado, concat(empleado.nombre,' ',empleado.apellido) AS nombre FROM empleado WHERE id_tipo_empleado=2 ");
													while ($row=_fetch_array($sql)) {
														# code...
														?>
														<option value="<?php echo $row['id_empleado'] ?>"><?php echo $row['nombre'] ?></option>
														<?php
													}
													 ?>
												</select>
											</div>
										</div>
										<div id='form_datos_cliente' class="form-group col-md-3">
											<div class="form-group has-info single-line">

												<label>Seleccione cliente&nbsp;</label>
												<?php
												 //$style='width:300px';
												 $select=crear_select2("id_cliente",$array0,-1,'');
												 echo $select;
												 ?>
											</div>
										</div>
										<!--/div-->
									</div>
								</div>
							</div>

						</div>
						<!-- fin buscador Superior -->


						<div class="widget">
							<div class="widget-header">
								<div class="row">

									<div class="col-md-6">&nbsp;&nbsp;
										<i class="fa fa-th-list"> </i>
										<h3 class="text-navy" id='title-table'>&nbsp;Lista  de Productos para Venta</h3>
									</div>
									<div class="form-group col-md-3">
										<label>Items&nbsp;
											<input type="text"  class='form-control input_header_panel'  id="items" value=0 readOnly /></label>
									</div>
									<div class="form-group col-md-3">
										<label>Cantidad total&nbsp;
											<input type="text"  class='form-control input_header_panel'  id="cantotal" value=0 readOnly /></label>
									</div>
								</div>

							</div>
							<!-- /widget-header -->

							<div class="widget-content">
								<div class="widget-content">
										<div class="row search-header">
											<table class="table-condensed table4">
												<tr>
													<td class='td_gde1'><input type="text" id="keywords" class='form-control' placeholder="Descripción"/></td>
													<td class='td_med1'> <input type="text" id="barcode" class='form-control' placeholder="Código Barra" /></td>
													<td class='td_med1'><input type="text" id="presentacion" class='form-control' placeholder="Presentación" /></td>
													<td class='td_med1'><label>Límite búsqueda</label></td>
													<td class='td_peq0'><input type="text"  class=' input_header_panel'  id="limite" value=400 /></td>
													<td class='td_med0'><label>Reg. Encontrados</label></td>
													<td class='td_peq0'><input type="text"  class='input_header_panel' id='reg_count' value=0 readOnly /></td>
													<td class='td_peq1'><button type="submit" id="submit1" name="submit1" class="btn btn-primary"><i class="fa fa-save"></i> F9 Guardar</button></td>
												</tr>
											</table>
											<table class="table-condensed table4">
												<tr>
												</tr>
											</table>
										</div>
									<div class="widget-content2">
									<div class="row">
									<div class="loading-overlay col-md-6">
									<div class="overlay-content" id='reg_count0'>Cargando.....</div>
									</div>

									</div>
									</div>

									<div  class='widget-content2' id="content">
									<div class="row">
									<div class="col-md-12">

									<table class="table table-fixed " id='loadtable'>
									<thead class='thead1'>
									<tr class='tr1'>
										<th class='text-info col-md-1'>Id</th>
										<th class='text-success col-md-1'>Barcode</th>
										<th class='text-success  col-md-3'>Descripci&oacute;n</th>
										<th class='text-success  col-md-1'>Stock</th>
										<th class='text-success  col-md-1'>Pr-Venta</th>
										<th class='text-success  col-md-1'>Seleccionar.</th>

									</tr>
									</thead>
									<tbody class='tbody1 tbody4' id="mostrardatos">
									</tbody>
									</table>
									</div>
									</div>
									</div>
								</div>
					<table class="table table2 table-fixed table-striped "id="inventable">
							<thead class='thead1'>
							<tr class='tr1'>

											<th class='text-success col7'>Id</th>
											<th class='text-success col23'>Descripci&oacute;n</th>
											<th class='text-success  col10'>Stock</th>
											<th class='text-success  col10'>Presentaci&oacute;n</th>
											<th class='text-success  col10'>Desc/Present.</th>
											<th class='text-success  col10'>Pr-Venta</th>
											<th class='text-success  col10'>Cantidad</th>
											<th class='text-success  col10 text-right'>Subtotal</th>
											<th class='text-success  col10 text-right'>Acci&oacute;n</th>
										</tr>
									</thead>
									<tbody class='tbody1 tbody2'></tbody>

								</table>
								<table class="table table2">
									<tbody class='tbody3'>
										<tr>
											<td class="thick-line col70 text-danger" id='totaltexto'></td>
											<td class="thick-line col10 "><strong>TOTAL $:</strong></td>
											<td class="thick-line col10 text-danger text-right" id='total_dinero'></td>
											<td class="thick-line col10"></td>
										</tr>
									</tbody>
								</table>
							</div>

									<!--/div>
									</div>

								</div-->

							</div>
							<input type='hidden' name='totalfactura' id='totalfactura' value='0'>

					</div>
				</section>
			</div>
			<!--div class='ibox-content'-->
			<!-- Modal -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content modal-md">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Pago y Cambio</h4>
						</div>
						<div class="modal-body">
							<div class="wrapper wrapper-content  animated fadeInRight">
								<div class="row">
									<input type='hidden' name='id_factura' id='id_factura' value=''>
									<div class="col-md-6">
										<div class="form-group">
											<label><h5 class='text-navy'>Numero factura Interno:</h5></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" id='fact_num'></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label><h5 class='text-navy'>Facturado $:</h5></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id="facturado" name="facturado" value=0 class="form-control decimal" readonly>
										</div>
									</div>
								</div>

								<div class="row" id='fact_cf'>
									<div class="col-md-6">
										<div class="form-group">
											<label><strong><h5 class='text-danger'>Numero Factura o Credito Fiscal: </h5></strong></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id='num_doc_fact' name='num_doc_fact' value='' class="form-control">
										</div>
									</div>
								</div>
								<div class="row" id='cff_nota'>
									<div class="col-md-6">
										<div class="form-group">
											<label><strong><h5 class='text-navy'>Nombre de Cliente: </h5></strong></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id='nombreape' name='nombreape' value='' class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label><strong><h5 class='text-navy'>Direccion Cliente: </h5></strong></label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id='direccion' name='direccion' value='' class="form-control">
										</div>
									</div>
								</div>
								<div class="row" id='ccf'>

									<div class="col-md-6">
										<div class="form-group">
											<label>NIT Cliente</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type='text' placeholder='NIT Cliente' class='form-control' id='nit' name='nit' value=''>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Registro Cliente(NRC)</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type='text' placeholder='Registro (NRC) Cliente' class='form-control' id='nrc' name='nrc' value=''>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Efectivo $</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id="efectivo" name="efectivo" value="" class="form-control decimal">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Cambio $</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" id="cambio" name="cambio" value=0 placeholder="cambio" class="form-control decimal" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="btnPrintFact">Imprimir</button>
							<button type="button" class="btn btn-warning" id="btnEsc">Salir</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-container">
				<div class="modal fade" id="clienteModal" tabindex="-2" role="dialog" aria-labelledby="myModalCliente" aria-hidden="true">
					<div class="modal-dialog model-sm">
						<div class="modal-content"> </div>
					</div>
				</div>
			</div>

			<!-- Modal -->

		</div>
		<!--<div class='ibox float-e-margins' -->
	</div>
	<!--div class='col-lg-12'-->
	</div>
	<!--div class='row'-->
	</div>
	<!--div class='wrapper wrapper-content  animated fadeInRight'-->

	<?php

}   //apertura de caja
else
{
	echo "<div></div></div></div></div></div><div class='alert alert-warning'><h3 class='text-danger'>No Hay Apertura de Caja vigente para este turno!!!</h3></div>";
}  //apertura de caja
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
	include_once ("footer.php");
	echo "<script src='js/plugins/arrowtable/arrow-table.js'></script>";
	echo "<script src='js/plugins/bootstrap-checkbox/bootstrap-checkbox.js'></script>";
	echo "<script src='js/funciones/ventas.js'></script>";
}
function numero_tiquete($ult_doc,$tipo_doc){
	$ult_doc=trim($ult_doc);
	$len_ult_valor=strlen($ult_doc);
	$long_num_fact=10;
	$long_increment=$long_num_fact-$len_ult_valor;
	$valor_txt="";
	if ($len_ult_valor<$long_num_fact){
		for ($j=0;$j<$long_increment;$j++){
			$valor_txt.="0";
		}
	}
	else{
			$valor_txt="";
	}
	$valor_txt=$valor_txt.$ult_doc."_".$tipo_doc;
	return $valor_txt;
}
function insertar(){
	$id_sucursal = $_SESSION['id_sucursal'];
	date_default_timezone_set('America/El_Salvador');
	$fecha_actual = date('Y-m-d');
	$sql_apertura = "SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND fecha = '$fecha_actual' AND turno_vigente = 1";
	$result_aper=_query($sql_apertura);
	$nrows_aper=_num_rows($result_aper);
	if($nrows_aper>0){
		$row_aper = _fetch_array($result_aper);
		$id_apertura = $row_aper["id_apertura"];
		$turno = $row_aper["turno"];
	}
	else{
		$turno = 1;
		$id_apertura = 0;
	}
	$id_empleado=$_POST['id_empleado'];

	//echo $id_apertura."\n";
	//echo $turno."\n";
	$cuantos = $_POST['cuantos'];
	//$stringdatos = $_POST['stringdatos'];
	$tipo_impresion= $_POST['tipo_impresion'];
	$array_json=$_POST['json_arr'];
	$id = '1';
	$id_usuario=$_SESSION["id_usuario"];
	$id_sucursal=$_SESSION["id_sucursal"];


	$fecha_movimiento= $_POST['fecha_movimiento'];
	$id_cliente=$_POST['id_cliente'];
	$total_venta = $_POST['total_ventas'];

	$abono=0;
	$saldo=0;

	$credito=$_POST["credito"];

	if($credito==1)
	{
		$saldo=$total_venta;
	}


	$insertar1=false;
	$insertar2=false;
	$insertar_fact=false;
	$insertar_fact_det=false;
	$insertar_numdoc =false;
	$insertar4 =false;
	$insertarM = false;
	$fecha=date("Y-m-d");
  $hora=date("H:i:s");
	$xdatos['typeinfo']='';
	$xdatos['msg']='';
	$xdatos['process']='';
	$tipoprodserv='PRODUCTO';
		_begin();

		$table='movimientos';
		$form_data = array(
			'id_usuario' => $id_usuario,
			'concepto' => 'VENTA',
			'total' => $total_venta,
			'fecha' => $fecha,
			'hora' => $hora,
		);
		$insertarM = _insert($table,$form_data);
		$id_movimiento=_insert_id();

		$sql="select * from ultimo_numdoc where id_sucursal='$id_sucursal'";
		$result= _query($sql);
		$rows=_fetch_array($result);
		$nrows=_num_rows($result);
		$ult_cof=$rows['ult_cof'];
		$ult_ccf=$rows['ult_ccf'];
		$ult_tik=$rows['ult_tik'];
		$ult_flc=$rows['ult_flc'];
		$ult_ref=$rows['ult_ref'];
		$ult_env=$rows['ult_env']+1;
		$fecha_guardada=$rows['fecha'];
		$fecha_actual=date('Y-m-d');
		$id_sucursal=$rows['id_sucursal'];
		$ult_cof=$ult_cof+1;
		$ult_ccf=$ult_ccf+1;
		$ult_tik=$ult_tik+1;
		$ult_flc=$ult_flc+1;
		$ult_ref=$ult_ref+1;

		$datetime1 = date_create($fecha_guardada);
		$datetime2 = date_create($fecha_actual);
		$interval = date_diff($datetime1, $datetime2);
		$diadiferencia=$interval->d;

		$table_numdoc="ultimo_numdoc";

		switch ($tipo_impresion) {
			case 'REF':
				$tipo_entrada_salida='NUM. REFERENCIA INTERNA';
				if($diadiferencia>0){
					$ult_ref=1;
					$data_numdoc = array(
					'ult_ref' => $ult_ref,
					'fecha'=> $fecha_actual,
					);
					$where_clause_n="WHERE  id_sucursal='$id_sucursal'";
					$insertar_numdoc = _update($table_numdoc,$data_numdoc,$where_clause_n );
				}
				$data_numdoc = array(
				'ult_ref' => $ult_ref,
				);
				$tipo_doc='REF';
				$numero_doc=numero_tiquete($ult_ref,$tipo_doc);
				break;
			case 'COF':
				$tipo_entrada_salida='FACTURA CONSUMIDOR';
				$data_numdoc = array(
				'ult_cof' => $ult_cof
				);
				$tipo_doc='COF';
				$numero_doc=numero_tiquete($ult_cof,$tipo_doc);
				break;
			case 'TIK':
				$tipo_entrada_salida='TICKET';
				$tipo_doc='TIK';
				$data_numdoc = array(
				'ult_tik' => $ult_tik
				);
				$numero_doc=numero_tiquete($ult_tik,$tipo_doc);
				break;
			case 'FLC':
				$tipo_entrada_salida='FACTURA LOTE CONSUMIDOR';
				$data_numdoc = array(
				'ult_flc' => $ult_flc
				);
				$tipo_doc='FLC';
				$numero_doc=numero_tiquete($ult_flc,$tipo_doc);
				break;
				case 'CCF':
				$tipo_entrada_salida='CREDITO FISCAL';
				$data_numdoc = array(
					'ult_ccf' => $ult_ccf
				);
				$tipo_doc='CCF';
				$numero_doc=numero_tiquete($ult_ccf,$tipo_doc);
				break;
				case 'ENV':
				$tipo_doc='ENV';
		    $tipo_entrada_salida='NOTA DE ENVIO';
		    $data_numdoc = array(
		       'ult_env' => $ult_env,
		     );
		    $numero_doc=numero_tiquete($ult_env, $tipo_doc);
		    break;
		}

		if ($nrows==0){
			$insertar_numdoc = _insert($table_numdoc,$data_numdoc );
		}
		else {
			$where_clause_n="WHERE  id_sucursal='$id_sucursal'";
			$insertar_numdoc = _update($table_numdoc,$data_numdoc,$where_clause_n );
		}

		$observaciones=$tipo_entrada_salida;
		if ($cuantos>0){
			//select a la tabla factura
			$sql_fact="SELECT * FROM factura WHERE numero_doc='$numero_doc'  and id_sucursal='$id_sucursal'
				AND fecha='$fecha_movimiento'
			";
			$result_fact=_query($sql_fact);

			$nrows_fact=_num_rows($result_fact);
			if($nrows_fact==0){
				$table_fact= 'factura';
				$form_data_fact = array(
				'id_cliente' => $id_cliente,
				'fecha' => $fecha_movimiento,
				'numero_doc' => $numero_doc,
				'total' => $total_venta,
				'id_usuario'=>$id_usuario,
				'id_empleado' => $id_empleado,
				'id_sucursal' => $id_sucursal,
				'tipo' => $tipo_entrada_salida,
				'hora' => $hora,
				'turno' => $turno,
				'id_apertura' => $id_apertura,
			 	//'num_fact_impresa'=>$numero_factura_consumidor,
				'finalizada' => '1',
				'credito' => $credito,
				'abono'=>$abono,
				'saldo' => $saldo,
				);
				$insertar_fact = _insert($table_fact,$form_data_fact );
				$id_fact= _insert_id();
			}
			else{
				$row_fact=_fetch_array($result_fact);
			}
			$array = json_decode($array_json,true);
			//$listadatos=explode('#',$stringdatos);
			foreach ($array as $fila){
        if( $fila['precio']>=0 && $fila['subtotal']>=0  && $fila['cantidad']>0){
			//for ($i=0;$i<$cuantos;$i++){

				$subcantidad=0;
				$existencias=0;
				$nrow2=0;
				$id_producto=$fila['id'];
        $cantidad=$fila['cantidad'];
        $precio_venta=$fila['precio'];
				$id_presentacion=$fila['id_presentacion'];
				$subcantidad=0;
				$unidades=$fila['unidades'];
				$subtotal=$fila['subtotal'];
				$cantidado=$cantidad;
				$cantidad=round(($unidades*$cantidad),0);
				//list($id_producto,$precio_venta,$cantidad,$subcantidad,$unidades,$subtotal)=explode('|',$listadatos[$i]);

				//Primero revisar stock y q me facture solo las existencias reales
				$sql2="select producto.id_producto, producto.unidad,producto.perecedero,
					stock.stock as existencias, stock.costo_promedio
					from producto,stock
					where producto.id_producto='$id_producto'
					and producto.id_producto=stock.id_producto
					and stock.id_sucursal='$id_sucursal'";
					$stock2=_query($sql2);
					$nrow2=_num_rows($stock2);

					//Actualizar en stock si  hay registro del producto
					$cant_facturar=0;
					if ($nrow2>0){
						$row2=_fetch_array($stock2);
						//$unidad=$row2['unidad'];
						$unidad=1;
						$existencias=$row2['existencias'];
						$perecedero=$row2['perecedero'];

						$cantidad_stock=$existencias-$cantidad;
						if($cantidad_stock<0){
							$cantidad_stock=0;
						}
						$cant_facturar=$cantidad;

						$table2= 'stock';
						$where_clause2="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";

						$form_data2 = array(
						'stock' => $cantidad_stock,
						);
						$insertar2 = _update($table2,$form_data2, $where_clause2 );
					}

						$precio_venta_unit=$precio_venta;
						$subtotal=round($precio_venta_unit*$cantidado,2);
				$table_fact_det= 'factura_detalle';
				$data_fact_det = array(
				'id_factura' => $id_fact,
				'id_prod_serv' => $id_producto,
				'cantidad' => $cantidado,
				'precio_venta' => $precio_venta,
				'subtotal' => $subtotal,
				'tipo_prod_serv' => $tipoprodserv,
				'id_empleado' => $id_empleado,
				'id_sucursal' => $id_sucursal,
				'fecha' => $fecha_movimiento,
				'id_presentacion'=> $id_presentacion,
				);
				if ($cantidad>0){
					$insertar_fact_det = _insert($table_fact_det,$data_fact_det );

				}

					$sql1="select * from movimiento_producto
					where id_producto='$id_producto'
					and tipo_entrada_salida='$tipo_entrada_salida'
					AND numero_doc='$numero_doc'
					AND fecha_movimiento='$fecha_movimiento'
					AND id_sucursal_origen='$id_sucursal'";

					$stock1=_query($sql1);
					$nrow1=_num_rows($stock1);
					if($nrow1>0){
						$row1=_fetch_array($stock1);
					}


					$table1= 'movimiento_producto';
					$form_data1 = array(
					'id_producto' => $id_producto,
					'fecha_movimiento' => $fecha_movimiento,
					'salida' => $cantidad,
					'observaciones' => $observaciones,
					'tipo_entrada_salida' => $tipo_entrada_salida,
					'numero_doc' => $numero_doc,
					'precio_venta' => $precio_venta,
					'stock_anterior' => $existencias,
					'stock_actual' => $cantidad_stock,
					'id_sucursal_origen' => $id_sucursal,
					'id_presentacion'=> $id_presentacion,
					'id_movimiento'=>$id_movimiento,
					);
						if ($cantidad>0){
						$insertar_mov_prod = _insert($table1,$form_data1 );
					}

					//si es perecedero
				if($perecedero==1){
					$sql_perecedero="SELECT id_lote_prod, id_producto, fecha_entrada, fecha_caducidad, entrada,
					salida, estado, numero_doc, id_sucursal
					FROM lote
					WHERE id_producto='$id_producto'
					AND id_sucursal='$id_sucursal'
					AND entrada>=salida
					AND estado='VIGENTE'
					ORDER BY fecha_caducidad";
					$result_perecedero=_query($sql_perecedero);

					$table_pp='lote';
					$nrow_perecedero=_num_rows($result_perecedero);
					$fecha_mov=ED($fecha_movimiento);
					$diferencia=0;
					if($nrow_perecedero>0){
						for($j=0;$j<$nrow_perecedero;$j++){
							$row_perecedero=_fetch_array($result_perecedero);
							$entrada=$row_perecedero['entrada'];
							$salida=$row_perecedero['salida'];
							$fecha_caducidad=$row_perecedero['fecha_caducidad'];
							$id_prod_perecedero=$row_perecedero['id_lote_prod'];
							$fecha_caducidad=ED($fecha_caducidad);

							$stock_fecha=$entrada-$salida;
							if ($fecha_caducidad!="0000-00-00" || $fecha_caducidad!="00-00-0000" || $fecha_caducidad!=NULL || $fecha_caducidad!=""  || $fecha_caducidad!==null ||$fecha_caducidad!==NULL){
								$comparafecha=compararFechas("-",$fecha_caducidad,$fecha_mov);
							}
							else {
								$comparafecha=99;
							}
							if ($fecha_caducidad===null || $fecha_caducidad===NULL){
								$comparafecha=99;
								}
							if($cantidad<$stock_fecha){
								$cant_sale=$cantidad+$salida;
								$diferencia=0;
								//$cantidad=0;
								$estado='VIGENTE';

							}
							if($cantidad>=$stock_fecha){
								$cant_sale=$entrada;
								$diferencia=$cantidad-$stock_fecha;
								$cantidad=$diferencia;
								$estado='FINALIZADO';

							}
							//valida si la fecha de vencimineto ya expiro
							if($comparafecha<0)
								$estado='VENCIDO';

							$where_clause_pp="WHERE id_producto='$id_producto'
								AND id_sucursal='$id_sucursal'
								AND entrada>=salida
								AND id_lote_prod='$id_prod_perecedero'";
							$form_data_pp = array(
							'salida' => $cant_sale,
							'estado' => $estado
							);
						$insertar4 = _update($table_pp,$form_data_pp, $where_clause_pp );
						//si la cantidad vendida no se pasa de la existencia de x lote perecedero  se sale del bucle for
						if ($diferencia==0)
							break;
							}
					}
				} //si es perecedero

				else{
				$insertar4 =true;
				}

			//}//for
		} // if($fila['cantidad']>0 && $fila['precio']>0){
	 } //foreach ($array as $fila){
			if($insertar_numdoc  && $insertar2  && $insertar_fact && $insertar_fact_det && $insertar_mov_prod){
						_commit(); // transaction is committed
						$xdatos['typeinfo']='Success';
						$xdatos['msg']='Documento Numero: <strong>'.$numero_doc.'</strong>  Guardado con Exito !';
						$xdatos['process']='insert';
						//$xdatos['factura']=$numero_doc;
						$xdatos['factura']=$id_fact;
					  $xdatos['numero_doc']=$numero_doc;
						$xdatos['insertados']=" num_doc :".$numero_doc." factura :".$insertar_fact." factura detalle:".$insertar_fact_det." mov prod:".$insertar1." stock:".$insertar2." lote:".$insertar4  ;
						//$xdatos['insertados']=" factura :".$insertar_fact." factura detalle:".$insertar_fact_det." mov prod:".$insertar1." stock:".$insertar2 ;
					}else{
						_rollback(); // transaction rolls back
						$xdatos['typeinfo']='Error';
						$xdatos['msg']='Registro de Factura no pudo ser Actualizado !';
						$xdatos['process']='noinsert';
						$xdatos['insertados']=" num_doc :".$numero_doc." factura :".$insertar_fact." factura detalle:".$insertar_fact_det." mov prod:".$insertar1." stock:".$insertar2." lote:".$insertar4  ;
					}
			}//if

	echo json_encode($xdatos);
}
function consultar_stock(){
	$id_producto = $_REQUEST['id_producto'];
	$id_usuario=$_SESSION["id_usuario"];
	$id_sucursal=$_SESSION['id_sucursal'];

	$iva=0;
	$sql_iva="select iva from empresa";
	$result=_query($sql_iva);
	$row=_fetch_array($result);
	$iva=$row['iva']/100;
	$precio=0;

	//if ($tipo =='PRODUCTO'){
	//ojo !!!!!!!!!!!!!!!!!!!!!!
	//utilidad teneindo precio venta y costo  : utlidad=(precio_venta-costo)/costo;
	$sql1="SELECT producto.id_producto,producto.descripcion,producto.mayoreo,producto.unidad,producto.exento,producto.id_posicion,
		producto.utilidad_activa,producto.utilidad_seleccion,producto.porcentaje_utilidad1,producto.descripcion,
		producto.porcentaje_utilidad2,producto.porcentaje_utilidad3,
		producto.porcentaje_utilidad4,producto.imagen,producto.combo,producto.perecedero,
		stock.stock,stock.costo_promedio,
		stock.utilidad, stock.pv_base, stock.precio_mayoreo,  stock.porc_desc_base , stock.stock_minimo,
		stock.pv_desc_base ,  stock.porc_desc_max ,  stock.pv_desc_max,
		stock.precio_oferta,stock.fecha_ini_oferta,stock.fecha_fin_oferta
		FROM producto JOIN stock ON producto.id_producto=stock.id_producto
		WHERE producto.id_producto='$id_producto'
		AND stock.id_sucursal='$id_sucursal'
		";
		$stock1=_query($sql1);
		$row1=_fetch_array($stock1);
		$nrow1=_num_rows($stock1);
		if ($nrow1>0){
		$unidades=$row1['unidad'];
		$utilidad_activa=$row1['utilidad_activa'];
		$utilidad_seleccion=$row1['utilidad_seleccion'];
		$perecedero=$row1['perecedero'];

		$pu1=$row1['porcentaje_utilidad1']/100;
		$pu2=$row1['porcentaje_utilidad2']/100;
		$pu3=$row1['porcentaje_utilidad3']/100;
		$pu4=$row1['porcentaje_utilidad4']/100;
		$combo=$row1['combo'];
		$cp=$row1['costo_promedio'];
		$existencias=$row1['stock'];
		$exento=$row1['exento'];
		$descripcion=$row1['descripcion'];
		$id_posicion=$row1['id_posicion'];

		$imagen=$row1['imagen'];
		//costos y precios
		$utilidad=$row1['utilidad'];
		$pv_base=$row1['pv_base'];
		$precio_mayoreo=$row1['precio_mayoreo'];
		$porc_desc_base=$row1['porc_desc_base'];
		$pv_desc_base=$row1['pv_desc_base'];
		$porc_desc_max=$row1['porc_desc_max'];
		$pv_desc_max=$row1['pv_desc_max'];
		$fecha_ini_oferta=$row1['fecha_ini_oferta'];
		$fecha_fin_oferta=$row1['fecha_fin_oferta'];
		$precio_oferta=$row1['precio_oferta'];
		$stock_minimo=$row1['stock_minimo'];
		$mayoreo=$row1['mayoreo'];

		$pv_base_unit=round($pv_base,4);
		$precio_oferta_unit=$precio_oferta;

		//precio de venta
		$fecha_hoy=date("Y-m-d");
		$fecha_hoy2=date("d-m-Y");
		$fecha_fin_oferta2=ed($fecha_fin_oferta);
		$tiene_oferta=compararFechas('-',$fecha_fin_oferta2, $fecha_hoy2);
		if ($tiene_oferta>0){
			$precio_venta=$precio_oferta_unit;
			$oferta=1;

		}
		else{
			$oferta=0;
			$precio_venta=$pv_base_unit;
		}
		if ($precio_mayoreo>0) {
			$precios=array($precio_venta,$precio_mayoreo);
		}
		else {
			$precios=array($precio_venta);
		}
		//consultar si es perecedero
		$fecha_caducidad="0000-00-00";
		$stock_fecha=0;
		if($perecedero==1){
			$sql_perecedero="SELECT id_lote_prod, id_producto, fecha_entrada, fecha_caducidad, entrada,
			salida, estado, numero_doc, id_sucursal
			FROM lote
			WHERE id_producto='$id_producto'
			AND id_sucursal='$id_sucursal'
			AND entrada>salida
			AND estado='VIGENTE'
			AND (fecha_caducidad>='$fecha_hoy'
			OR  fecha_caducidad='0000-00-00')
			ORDER BY fecha_caducidad ASC";
			$result_perecedero=_query($sql_perecedero);
			$array_fecha=array();
			$array_stock=array();
			$nrow_perecedero=_num_rows($result_perecedero);
			if($nrow_perecedero>0){
				for ($i=0;$i<$nrow_perecedero;$i++){
					$row_perecedero=_fetch_array($result_perecedero);
					//$costos_pu=array($pu1,$pu2,$pu3,$pu4);
					$entrada=$row_perecedero['entrada'];
					$salida=$row_perecedero['salida'];
					$id_lote_prod=$row_perecedero['id_lote_prod'];
					$fecha_caducidad=$row_perecedero['fecha_caducidad'];
					if($fecha_caducidad=="")
						$fecha_caducidad="0000-00-00";
					$fecha_caducidad=ED($fecha_caducidad);
					$stock_fecha=$entrada-$salida;
					$array_fecha[] =$id_lote_prod."|".$fecha_caducidad;
					$array_stock[] =$id_lote_prod."|".$fecha_caducidad."|".$stock_fecha;
				}
			}

		}
		else{
			$array_fecha="";
			$array_stock="";
		}
		}
			$ubicacion=ubicacionn($id_posicion);
		//si no hay stock devuelve cero a todos los valores !!!
		if ($nrow1==0){
		$existencias=0;
		$precio_venta=0;
		$costos_pu=array(0,0,0,0);
		$precios_vta=array(0,0,0,0);
		$cp=0;
		$iva=0;
		$unidades=" ";
		$imagen='';
	    $combo=0;
		$fecha_caducidad='0000-00-00';
		$stock_fecha=0;
		$oferta=0;
		}
	//}
		$xdatos['mayoreo'] = $mayoreo;
		if($mayoreo)
		{
			$sql = _query("SELECT precio FROM precio_producto WHERE id_producto='$id_producto' AND '1' BETWEEN desde AND hasta");
			if(_num_rows($sql)>0)
			{
				$datos = _fetch_array($sql);
				$precio = $datos["precio"];
				$xdatos["precio"] = $precio;
			}
			else
			{
				$xdatos["precio"] = 0;
			}
		}
		if(!$mayoreo && $precio>0)
		{

			$xdatos["typeinfo"] = 'Success';
		}
		/*inicio modificacion presentacion*/
		$i=0;
		$unidadp=0;
		$preciop=0;
		$descripcionp=0;

		$sql_p=_query("SELECT presentacion.descripcion_pr, presentacion_producto.descripcion,presentacion_producto.id_presentacion,presentacion_producto.unidad,presentacion_producto.precio FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE presentacion_producto.id_producto=$id_producto AND presentacion_producto.activo=1");
		$select="<select class='sel' style='width:100%'>";
		while ($row=_fetch_array($sql_p)) {
			# code...
			if ($i==0) {
				# code...
				$unidadp=$row['unidad'];
				$preciop=$row['precio'];
				$descripcionp=$row['descripcion'];
			}


			$select.="<option value='".$row["id_presentacion"]."'>".$row["descripcion_pr"]." (".$row["unidad"].")</option>";
			$i=$i+1;

		}
		$select.="</select>";
		/*fin modificacion presentacion*/

		//$precio_venta=round($precio_venta,2);
		$xdatos['existencias'] = $existencias;
		$xdatos['precio_venta'] = $precio_venta;
		$xdatos['costo_prom'] = $cp;
		$xdatos['iva'] = $iva;
		$xdatos['unidades'] = $unidades;
		$xdatos['imagen'] = $imagen;
		$xdatos['combo'] = $combo;
		$xdatos['fecha_caducidad'] = $fecha_caducidad;
		$xdatos['stock_fecha'] =$stock_fecha;
		$xdatos['oferta'] =$oferta;
		$xdatos['precio_oferta'] =$precio_oferta;
		$xdatos['porc_desc_base']=$porc_desc_base;
		$xdatos['porc_desc_max']=$porc_desc_max;
		$xdatos['perecedero']=$perecedero;
		$xdatos['fechas_vence'] = $array_fecha;
		$xdatos['stock_vence'] = $array_stock;
		$xdatos['fecha_ini_oferta']=$fecha_ini_oferta;
		$xdatos['fecha_fin_oferta']=$fecha_fin_oferta2;
		$xdatos['fecha_hoy']= $fecha_hoy;
		$xdatos['precios_vta']= $precios;
		$xdatos['ubicacion']= $ubicacion;
		$xdatos['descripcion']= $descripcion;
		$xdatos['select']= $select;
		$xdatos['preciop']= $preciop;
		$xdatos['unidadp']= $unidadp;
		$xdatos['descripcionp']= $descripcionp;

	echo json_encode($xdatos); //Return the JSON Array
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

function mostrar_datos_cliente()
{
    $id_cliente=$_POST['id_client'];

    $sql="SELECT * FROM cliente
	WHERE
	id_cliente='$id_cliente'";
    $result=_query($sql);
    $count=_num_rows($result);
    if ($count > 0) {
        for ($i = 0; $i < $count; $i ++) {
            $row = _fetch_array($result);
            $id_cliente=$row["id_cliente"];
            $nombre=$row["nombre"];
            $apellido=$row["apellido"];
            $nit=$row["nit"];
            $dui=$row["dui"];
            $direccion=$row["direccion"];
            $telefono1=$row["telefono1"];
            $giro=$row["giro"];
            $registro=$row["nrc"];
            $email=$row["email"];
            $facebook=$row["facebook"];
        }
    }
    $xdatos['nit']= $nit;
    $xdatos['registro']= $registro;
		$xdatos['nombreape']=   $nombre." ".$apellido;
		$xdatos['direccion']=   $direccion;
    echo json_encode($xdatos); //Return the JSON Array
}
function imprimir_fact() {
	$numero_doc = $_POST['numero_doc'];
  $tipo_impresion= $_POST['tipo_impresion'];
  $id_factura= $_POST['num_doc_fact'];
	$id_sucursal=$_SESSION['id_sucursal'];
	$numero_factura_consumidor = $_POST['numero_factura_consumidor'];
	if   ($tipo_impresion=='COF'){
		$tipo_entrada_salida="FACTURA CONSUMIDOR";
	}
	if   ($tipo_impresion=='ENV'){
		$tipo_entrada_salida="NOTA DE ENVIO";
		if (isset($_POST['direccion'])){
		$direccion= $_POST['direccion'];
	}
	}
	if   ($tipo_impresion=='TIK'){
		$tipo_entrada_salida="TICKET";
	}
	if  ($tipo_impresion=='CCF'){
		$tipo_entrada_salida="CREDITO FISCAL";
		$nit= $_POST['nit'];
		$nrc= $_POST['nrc'];
	}
	if (isset($_POST['nombreape'])){
		$nombreape= $_POST['nombreape'];
	}
	if (isset($_POST['direccion'])){
		$direccion= $_POST['direccion'];
	}

	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';

	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$fecha_movimiento=$row_fact['fecha'];
		$table_fact= 'factura';

		$form_data_fact = array(
			'finalizada' => '1',
			'impresa' => '1',
			'num_fact_impresa'=>$numero_factura_consumidor,
			'nombre' => $nombreape,
			'direccion' => $direccion,

		);
		$where_clause="id_factura='$id_factura'";
		$actualizar = _update($table_fact,$form_data_fact, $where_clause );
	}
//cambiar numero documento impreso para mostrar en reporte kardex
$where_clause1="
tipo_entrada_salida='$tipo_entrada_salida'
AND numero_doc='$numero_doc'
AND fecha_movimiento='$fecha_movimiento'
";

$table1= 'movimiento_producto';
$form_data1 = array(
'numero_doc'=>$id_factura,
);
$insertar1 = _update($table1,$form_data1,$where_clause1);

if ($tipo_impresion=='COF'){
	$info_facturas=print_fact($id_factura,$tipo_impresion,$nombreape,$direccion);
}
if ($tipo_impresion=='CCF'){
		$info_facturas=print_ccf($id_factura,$tipo_impresion,$nit,$nrc,$nombreape,$direccion);
}
if ($tipo_impresion=='ENV'){
	$info_facturas=print_envio($id_factura,$tipo_impresion,$nombreape,$direccion);
}

//directorio de script impresion cliente
$headers="";
$footers="";
if ($tipo_impresion=='TIK') {
		$info_facturas=print_ticket($id_factura, $tipo_impresion);
		$sql_pos="SELECT *  FROM config_pos  WHERE id_sucursal='$id_sucursal' AND alias_tipodoc='TIK'";
		$result_pos=_query($sql_pos);
		$row1=_fetch_array($result_pos);
		$headers=$row1['header1']."|".$row1['header2']."|".$row1['header3']."|".$row1['header4']."|".$row1['header5']."|";
		$headers.=$row1['header6']."|".$row1['header7']."|".$row1['header8']."|".$row1['header9']."|".$row1['header10'];
		$footers=$row1['footer1']."|".$row1['footer2']."|".$row1['footer3']."|".$row1['footer4']."|".$row1['footer5']."|";
		$footers.=$row1['footer6']."|".$row1['footer7']."|".$row1['footer8']."|".$row1['footer8']."|".$row1['footer10']."|";
}

$sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
$result_dir_print=_query($sql_dir_print);
$row_dir_print=_fetch_array($result_dir_print);
$dir_print=$row_dir_print['dir_print_script'];
$shared_printer_win=$row_dir_print['shared_printer_matrix'];
$shared_printer_pos=$row_dir_print['shared_printer_pos'];
$nreg_encode['shared_printer_win'] =$shared_printer_win;
$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
$nreg_encode['dir_print'] =$dir_print;
$nreg_encode['facturar'] =$info_facturas;
$nreg_encode['sist_ope'] =$so_cliente;
$nreg_encode['headers'] =$headers;
$nreg_encode['footers'] =$footers;

echo json_encode($nreg_encode);

}

function finalizar_fact(){
	$numero_doc = $_POST['numero_doc'];
	$id_sucursal=$_SESSION['id_sucursal'];

	$sql_fact="SELECT * FROM factura WHERE numero_doc='$numero_doc' and id_sucursal='$id_sucursal'";

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
		$table_fact= 'factura';
		$form_data_fact = array(
			'finalizada' => '1'
		);
		$where_clause="WHERE numero_doc='$numero_doc' and id_sucursal='$id_sucursal'";
		$actualizar = _update($table_fact,$form_data_fact, $where_clause );
		//$numero_doc=trim($row_fact['numero_doc']);
	}



	if ($actualizar){
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Venta Numero: <strong>'.$numero_doc.'</strong>  Finalizada con Exito !';
		$xdatos['process']='Finalizar';

	}
	else{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Venta Numero: <strong>'.$numero_doc.'</strong>  no pudo ser Finalizada !';
		$xdatos['process']='Finalizar';

	}
	echo json_encode($xdatos); //Return the JSON Array
}
function buscarBarcode(){
	$query = trim($_POST['id_producto']);
	$sql0="SELECT id_producto as id, descripcion, barcode, tipo_prod_servicio FROM producto  WHERE barcode='$query'";
	$result = _query($sql0);
	$numrows= _num_rows($result);

	$array_prod = array();
  $array_prod="";
	while ($row = _fetch_array($result)) {
				$barcod=" [".$row['barcode']."] ";
				$id_prod =$row['id'];
	}
$xdatos['id_prod']=$id_prod;
	echo json_encode ($xdatos); //Return the JSON Array
}

function traerdatos() {

    $keywords = $_POST['keywords'];
    $presentacion= $_POST['presentacion'];
    $barcode= $_POST['barcode'];
		$limite= $_POST['limite'];
		$id_sucursal=$_SESSION['id_sucursal'];
    $sqlJoined="SELECT pr.id_producto,pr.descripcion, pr.exento, pr.barcode,
		 st.costo_promedio,st.pv_base , st.stock,
		  pe.id_presentacion,pe.descripcion as descpre
		 FROM producto AS pr
		JOIN stock AS st ON pr.id_producto=st.id_producto
		JOIN presentacion_producto AS pe ON pr.id_producto=pe.id_producto
		";
    $sqlParcial=get_sql($keywords,$barcode , $presentacion,$limite);
    $sql_final= $sqlJoined." ".$sqlParcial." ";
    $query = _query($sql_final);

		$num_rows = _num_rows($query);
		$filas=0;
    if($num_rows > 0){
            while($row = _fetch_array($query)) {
                $id_producto = $row['id_producto'];
                $descripcion=$row["descripcion"];
                $presentacion = $row['descpre'];
								$exento = $row['exento'];
								$cp = $row['costo_promedio'];
								$precio = $row['pv_base'];
								$id_presentacion=$row['id_presentacion'];
								$barcode = $row['barcode'];
								$stock= $row['stock'];


								$btnSelect='<input type="button" id="btnSelect" class="btn btn-primary fa" value="&#xf00c;">';
						?>
		<tr class='tr1' tabindex="<?php echo $filas;?>">
			<td style="width: 13%;"><input type='hidden' id='exento' name='exento' value='<?php echo $exento;?>'><h5><?php echo $id_producto;?></h5></td>
			<td style="width: 12%;"><h5><?php echo $barcode;?></h5></td>
			<td style="width: 40%;"><h5><?php echo $descripcion;?></h5></td>
			<td style="width: 14.5%;"><h5><?php echo $stock;?></h5></td>
			<td style="width: 14.5%;"><h5><?php echo $precio;?></h5></td>
			<td style="width: 18%;"><h5><?php echo $btnSelect; ?></h5></td>
		</tr>

		<?php
					$filas+=1;
          }
				}
  echo '<input type="hidden" id="cuantos_reg"  value="'.$num_rows.'">';
}
function get_sql($keywords,$barcode, $presentacion,$limite){
	$id_sucursal=$_SESSION['id_sucursal'];
	$andSQL='';

 $whereSQL="WHERE st.id_sucursal='$id_sucursal'
 AND st.stock>0
 AND st.pv_base>0.0";

	$keywords=trim($keywords);
	//$andSQL.= " AND ma.id_presentacion='$id_presentacion'";

	if(!empty($barcode)){
			$andSQL.= " AND  pr.barcode LIKE '{$barcode}%'";
	}
	else{
  if(!empty($keywords)){
  $andSQL.= " AND  pr.descripcion LIKE '%".$keywords."%'";
      if(!empty($presentacion)){
          $andSQL.= " AND pe.descripcion LIKE '%".$presentacion."%'";
      }
  }

  if(empty($keywords)  && !empty($presentacion)){
		$andSQL.= "AND pe.descripcion LIKE '%".$presentacion."%'";

   }

	 if(empty($keywords)  && empty($presentacion)) {
		$limite=100;
		$andSQL.= " ";
 	}

	}

	$orderBy=" ";
	$limitSQL=" LIMIT ".$limite;
	$orderBy=" GROUP BY pr.id_producto ORDER BY pr.id_producto,pr.descripcion, pr.barcode,pe.presentacion";

	$sql_parcial=$whereSQL.$andSQL.$orderBy.$limitSQL;
  return $sql_parcial;
}

function agregar_cliente()
{
    //$id_cliente=$_POST["id_cliente"];
    $nombre=$_POST["nombress"];
		$apellido=$_POST["apellidos"];
    $dui=$_POST["dui"];
    $tel1=$_POST["tel1"];
		$tel2=$_POST["tel2"];


    $var1=preg_match('/\x{27}/u', $nombre);
    $var2=preg_match('/\x{22}/u', $nombre);
    if ($var1==true || $var2==true) {
        $nombre =stripslashes($nombre);
    }
    $sql_result=_query("SELECT * FROM cliente WHERE nombre='$nombre'");
    $numrows=_num_rows($sql_result);
    $row_update=_fetch_array($sql_result);
    $id_cliente=$row_update["id_cliente"];
    $name_cliente=$row_update["nombre"];


    //'id_cliente' => $id_cliente,
    $table = 'cliente';
    $form_data = array(
    'nombre' => $nombre,
		'apellido' => $apellido,
    'dui' => $dui,
    'telefono1' => $tel1,
		'telefono2' => $tel2,
    );

    if ($numrows == 0 && trim($nombre)!='') {
        $insertar = _insert($table, $form_data);
        $id_cliente=_insert_id();
        if ($insertar) {
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Registro insertado con exito!';
            $xdatos['process']='insert';
            $xdatos['id_client']=  $id_cliente;
        } else {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='Registro no insertado !';
        }
    } else {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Registro no insertado !';
    }
    echo json_encode($xdatos);
}
function getpresentacion()
{
	$id_presentacion =$_REQUEST['id_presentacion'];
	$sql=_fetch_array(_query("SELECT * FROM `presentacion_producto` WHERE id_presentacion=$id_presentacion"));
	$precio=$sql['precio'];
	$unidad=$sql['unidad'];
	$descripcion=$sql['descripcion'];
	$xdatos['precio']=$precio;
	$xdatos['unidad']=$unidad;
	$xdatos['descripcion']=$descripcion;
	echo json_encode($xdatos);
}

function rev_prec()
{
	$id_producto = $_POST["id_producto"];
	$cantidad = $_POST["cantidad"];
	$sql = _query("SELECT precio FROM precio_producto WHERE id_producto='$id_producto' AND '$cantidad' BETWEEN desde AND hasta");
	if(_num_rows($sql)>0)
	{
		$datos = _fetch_array($sql);
		$precio = $datos["precio"];
		$xdatos["typeinfo"] = "Success";
		$xdatos["precio"] = $precio;
	}
	else
	{
		$xdatos["typeinfo"] = "Error";
	}
	echo json_encode($xdatos);
}
//functions to load
if(!isset($_REQUEST['process'])){
	initial();
}
//else {
if (isset($_REQUEST['process'])) {

	switch ($_REQUEST['process']) {
	case 'insert':
		insertar();
		break;
	case 'mostrar_datos_cliente':
		mostrar_datos_cliente();
		break;
	case 'consultar_stock':
		consultar_stock();
		break;
	case 'cargar_empleados':
		cargar_empleados();
		break;
	case 'cargar_precios':
		cargar_precios();
		break;
	case 'total_texto':
		total_texto();
		break;
	case 'imprimir_fact':
		imprimir_fact();
		break;
	case 'print2':
		print2(); //Generacion de los datos de factura que se retornan para otro script que imprime!!!
		break;
	case 'mostrar_numfact':
		mostrar_numfact();
		break;
	case 'reimprimir' :
		reimprimir();
		break;
	case 'finalizar_fact' :
		finalizar_fact();
		break;
	case 'buscarBarcode' :
			buscarBarcode();
			break;
	case 'cons' :
			rev_prec();
			break;
	case 'mostrar_datos_cliente':
			mostrar_datos_cliente();
			break;
	case 'traerdatos':
		traerdatos();
		break;
	case 'agregar_cliente':
			agregar_cliente();
			break;
	case 'getpresentacion':
			getpresentacion();
			break;
	}


 //}
}
?>
