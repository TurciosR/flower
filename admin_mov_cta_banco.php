<?php
include ("_core.php");
// Page setup
function initial()
{
	$title =  'Movimientos de Cuenta de Banco';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$a = date("Y");
	$m = date("m");
	$fin = $a."-".$m."-01";
	$fini = date("Y-m-d");
	?>
	<style media="screen">
	span.select2-container {
	  z-index:10050;
	}
	</style>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
					if ($links!='NOT' || $admin=='1' )
					{
						?>
						<div class='ibox-title'>
							<div class="row">
								<div class="col-lg-2">
									<div>
										<label>Banco</label>
										<select id="banco" name="banco" class="form-control select">
											<option value="">Seleccione</option>
											<?php
											$sql = _query("SELECT * FROM banco ORDER BY nombre");
											while ($row = _fetch_array($sql))
											{
												echo "<option value='".$row["id_banco"]."'>".$row["nombre"]."</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-2">
									<div>
										<label>Cuenta</label>
										<select id="cuenta" name="cuenta" class="form-control select">
											<option value="">Seleccione un Banco</option>
										</select>
									</div>
								</div>
								<div class="col-lg-2">
									<div>
										<label>Desde</label>
										<input type="text" name="fin" id="fin" class="form-control datepick" value="<?php echo $fin; ?>">
									</div>
								</div>
								<div class="col-lg-2">
									<div>
										<label>Hasta</label>
										<input type="text" name="fini" id="fini" class="form-control datepick" value="<?php echo $fini; ?>">
									</div>
								</div>
								<div class="col-lg-1">
									<div>
										<br>
										<button type="button" id="btnMostrar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
									</div>
								</div>
								<div class="col-lg-1">
									<div>
										<br>
										<a data-toggle='modal' data-target='#viewModal' data-refresh='true' id="movie"></a>
										<a class='btn btn-primary' role='button' id="btnMov"><i class='fa fa-plus icon-large'></i> Movimiento</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div>
										<br>
										<button type='button' id='print1' class='btn btn-primary pull-right'><i class='fa fa-print icon-large'></i> Lib. Banco</button>
									</div>
								</div>
							</div>
						</div>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<header>
								<h4><?php echo  $title; ?></h4>
							</header>
							<section>
								<table class="table table-striped table-bordered table-hover" id="editable2">
									<thead>
										<tr>
											<th>Id</th>
											<th>Fecha</th>
											<th>Nombre</th>
											<th>Comentario</th>
											<th>Tipo Doc</th>
											<th>Numero Doc</th>
											<th>Entrada</th>
											<th>Salida</th>
											<th>Saldo</th>
											<th>Acci&oacute;n</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</section>
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						</div><!--div class='ibox-content'-->
					</div><!--<div class='ibox float-e-margins' -->
					</div> <!--div class='col-lg-12'-->
				</div> <!--div class='row'-->
			</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
			<?php
			include ("footer.php");
			echo" <script type='text/javascript' src='js/funciones/funciones_mov_cta_banco.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include ("footer.php");
		}
	}
	function cuentas_b()
	{
		$id_banco = $_POST["id_banco"];
		$sql = _query("SELECT * FROM cuenta_banco WHERE id_banco='$id_banco' ORDER BY nombre_cuenta");
		if(_num_rows($sql)>0)
		{
			$opt = "<option value=''>Seleccione</option>";
			while ($row = _fetch_array($sql)) {
				$opt .="<option value='".$row["id_cuenta"]."'>".$row["nombre_cuenta"]."</option>";
			}
			$xdatos["typeinfo"] = "Success";
			$xdatos["opt"] = $opt;
		}
		else
		{
			$xdatos["typeinfo"] = "Error";
		}
		echo json_encode($xdatos);
	}
	if (!isset($_REQUEST['process'])) {
		initial();
	}
	//else {
	if (isset($_REQUEST['process'])) {
		switch ($_REQUEST['process']) {
			case 'val':
			cuentas_b();
			break;
		}
	}
	?>
