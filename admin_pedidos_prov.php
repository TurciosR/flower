<?php
include ("_core.php");
// Page setup
$_PAGE = array ();
$_PAGE ['title'] = 'Administrar Pedidos a Proveedores';
$_PAGE ['links'] = null;
$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
include_once "header.php";
include_once "main_menu.php";
$id_sucur=$_SESSION["id_sucursal"];

$hoy=date("Y-m-d");
$antes=restar_dias($hoy,30);


//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);
//permiso del script
$fini = date("Y")."-".date("m")."-01";
$fin = date("Y-m-d");
?>
<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row" id="row1">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php	if ($links!='NOT' || $admin=='1' ) {
					echo"<div class='ibox-title'>";
					$filename='agregar_pedido_prov.php';
					$link=permission_usr($id_user,$filename);
					if ($link!='NOT' || $admin=='1' )
					echo "<a href='agregar_pedido_prov.php' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Pedido</a>";
					echo "</div>";
					?>
					<div class="ibox-content">
						<!--load datables estructure html-->
						<style>
						#row11 {
							overflow:scroll;
							height:200px;
							width:650px;
						}
						</style>
						<header>
							<h4>Administrar Pedidos a Proveedores</h4>
						</header>
						<section>
							<div class="row" id="filter">
								<div class="col-lg-2">
									<div class="form-group has-info">
										<label class="control-label">Desde</label>
										<input type="text" class="form-control datepick" name="fini" id="fini" value="<?php echo $antes ?>">
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group has-info">
										<label class="control-label">Hasta</label>
										<input type="text" class="form-control datepick" name="fin" id="fin" value="<?php echo $hoy ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group has-info">
										<label class="control-label">Buscar</label><br>
										<button type="button" name="button" class="btn btn-primary" id="search"><i class="fa fa-search"></i> Buscar</button>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-lg-12">
							<table class="table table-striped table-bordered table-hover" id="editable2">
								<thead>
									<tr>
										<th class="col-lg-1">No.</th>
										<th class="col-lg-1">Fecha Creación</th>
										<th class="col-lg-1">Fecha Pedido</th>
										<th class="col-lg-4">Proveedor</th>
										<th class="col-lg-3">Empleado</th>
										<th class="col-lg-1">Total</th>
										<th class="col-lg-1">Acci&oacute;n</th>
									</tr>
								</thead>
								<tfoot>
								</tfoot>
							</table>
							<input type="hidden" name="autosave" id="autosave" value="false-0">
						</div>
						</div>
						</section>
						<!--Show Modal Popups View & Delete -->
						<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog modal-lg'>
								<div class='modal-content modal-lg'></div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
						<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog modal-sm'>
								<div class='modal-content modal-sm'></div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
						<!--Show Modal Popup View Fact -->
					</div><!--div class='ibox-content'-->
				</div><!--<div class='ibox float-e-margins' -->
				</div> <!--div class='col-lg-12'-->
			</div> <!--div class='row'-->
		</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
		<?php
		include ("footer.php");
		echo" <script type='text/javascript' src='js/funciones/funciones_pedido_prov.js'></script>";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include ("footer.php");
	}
	?>
