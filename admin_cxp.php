<?php
	include ("_core.php");
	// Page setup
	$_PAGE = array ();
	$title='Administrar Cuentas Por Pagar';
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";

	$id_sucursal=$_SESSION["id_sucursal"];
	$id_proveedor = $_REQUEST['id_proveedor'];

	$sql1="SELECT cxp.id_proveedor,proveedor.nombre, SUM(cxp.saldo_pend) as deuda FROM  cuenta_pagar as cxp JOIN proveedor ON proveedor.id_proveedor=cxp.id_proveedor WHERE cxp.id_sucursal=$id_sucursal AND cxp.id_proveedor=$id_proveedor GROUP BY cxp.id_proveedor ";
	$result1=_query($sql1);

	echo _error();
	$deuda_total=0;
	while($row2=_fetch_array($result1))
	{
		$deuda2=$row2['deuda'];
		$deuda_total+=$deuda2;
	}
	//echo $deuda_total."####";
		//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$deuda = $_REQUEST['d'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$fechahoy=ED(date("Y-m-d"));
	$fechaanterior=ED(restar_dias($fechahoy,365));
	$sql_p=_query("SELECT proveedor.nombre FROM proveedor WHERE id_proveedor=$id_proveedor");
	$row_p=_fetch_array($sql_p);
	$n_proveedor=$row_p['nombre']
?>

	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
					//permiso del script
					if ($links!='NOT' || $admin=='1' ){
					echo"
	                <div class='ibox-title'>
	                    <h5>$title: $n_proveedor</h5>
	                </div>";
                ?>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<input type="hidden" placeholder="Fecha Inicio" class="datepick form-control" id="id_proveedor" name="id_proveedor" value="<?php echo  $id_proveedor;?>">
							<div class="row">
								<div class="input-group">
									<div class="col-md-4">
										<div class="form-group">
											<label>Fecha Inicio</label>
											<input type="text" placeholder="Fecha Inicio" class="datepick form-control date" id="fecha_inicio" name="fecha_inicio" value="<?php echo  $fechaanterior;?>">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label>Fecha Fin</label>
											<input type="text" placeholder="Fecha Fin" class="datepick form-control date" id="fecha_fin" name="fecha_fin" value="<?php echo $fechahoy;?>">
										</div>
									</div>
									<!--div class="col-lg-8"-->

									<div class="col-md-4">
										<div class="form-group">
											<div><label>Buscar Cuentas Por Pagar</label> </div>
											<button type="button" id="btnMostrar" name="btnMostrar" class="btn btn-primary"><i class="fa fa-search"></i> Mostrar</button>
										</div>

									</div>

									<!--div class="col-md-4">

										<div class="form-group">
											<div><label>Abonar Cuentas Por Pagar</label> </div>
											<a href="<?php echo "admin_cxp_abonar.php?id_proveedor=$id_proveedor" ?>">
											<button href="<?php echo "admin_cxp_abonar.php?id_proveedor=$id_proveedor" ?>" type="button"  id="btnAbonar" name="btnAbonar" class="btn btn-primary"><i class="fa fa-money"></i> Abonar</button>
											</a>
										</div>
									</div>
									<div class="col-md-4">

										<div class="form-group">
											<div><label>Imprimir Voucher</label> </div>
											<a href="<?php echo "admin_cxp_c.php?id_proveedor=$id_proveedor" ?>">
											<button href="<?php echo "admin_cxp_abonar.php?id_proveedor=$id_proveedor" ?>" type="button"  id="btnAbonar" name="btnAbonar" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>
											</a>
										</div>
									</div>
								</div-->
								</div>
								<span class="pull-right" style="font-size:18px;"> <strong>Deuda Total $<?php echo number_format($deuda_total,2); ?></strong></span>

							</div>
							<section>
								<table class="table table-striped table-bordered table-hover" id="editable2">
									<thead>
										<tr>
											<th>Id</th>
											<th>Fecha Comp</th>
											<th>Tipo Doc</th>
											<th>Numero Doc</th>
											<th>Total</th>
											<th>Saldo</th>
											<th>Fecha Vence</th>
											<th>Estado</th>
											<th>Acci&oacute;n</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<input type="hidden" name="autosave" id="autosave" value="false-0">
							</section>
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModal' tabindex='-1' data-backdrop="static" data-keyboard="false" role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-md'>
									<div class='modal-content modal-md'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
							<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModalFact' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-md'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->

						</div>
						<!--div class='ibox-content'-->
				</div>
				<!--<div class='ibox float-e-margins' -->
			</div>
			<!--div class='col-lg-12'-->
		</div>
		<!--div class='row'-->
	</div>
	<!--div class='wrapper wrapper-content  animated fadeInRight'-->
	<?php
	include("footer.php");
	echo" <script type='text/javascript' src='js/funciones/funciones_cxp.js'></script>";
		} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}

?>
