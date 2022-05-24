<?php
include ("_core.php");
// Page setup
function initial() {


	$_PAGE = array ();
	$_PAGE ['title'] = 'Reporte Ticket del Dia';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_user = $_SESSION["id_usuario"];
	date_default_timezone_set('America/El_Salvador');
	$fecha_actual = date("Y-m-d");
	$hora_actual = date("H:i:s");
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
	if ($links!='NOT' || $admin=='1' ){
		?>

		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-content">
							<!--load datables estructure html-->
							<header>
								<h4>TICKETS DEL DIA</h4>
							</header>
							<section>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group has-info single-line">
											<label>Fecha</label>
											<input type="text"  class="form-control datepick" id="fecha" name="fecha" value="<?php echo date('Y-m-d');?>">
										</div>
									</div>
									<div hidden class="col-md-4">
										<div class="form-group has-info single-line">
											<label>Tipo</label>
											<select class="form-control" id="tipo"  name="tipo">
												<option value="0">GRAVADO</option>
												<option value="1">EXENTO</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">

									</div>
									<div class="col-md-4">
										<div class="form-group has-info ">
											<br>
											<a href="" class="btn btn-primary pull-right" id="submit" name="submit"><i class="fa fa-print"></i> Imprimir Reporte</a>
											<input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal; ?>">
										</div>
									</div>
								</div>
							</section>
							<section>
								<table class="table table-striped table-bordered table-hover" id="">
									<thead>
										<th class="col-lg-1">N°</th>
										<th class="col-lg-1">N° Ticket</th>
										<th class="col-lg-1">Hora</th>
										<th class="col-lg-3">Empleado</th>
										<th class="col-lg-1">Total</th>
									</thead>
									<tbody id="t_mov">

									</tbody>
								</table>
								<input type="hidden" name="autosave" id="autosave" value="false-0">
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
			include("footer.php");
			echo" <script type='text/javascript' src='js/funciones/tike_dia.js'></script>";
		} //permiso del script
		else {
			echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
		}
	}
	function cargar()
	{
		$lista = "";
		$n = 1;
		$fecha = ($_POST["fecha"]);
		$id_sucursal = $_SESSION["id_sucursal"];
		$exento=$_REQUEST['tipo'];

		$condicion="";
		$condicion2="";

		$sql_lista = _query("SELECT * FROM factura WHERE fecha = '$fecha' $condicion AND id_sucursal = '$id_sucursal'  AND tipo_documento LIKE '%TIK%'  and finalizada=1 ORDER BY CAST(num_fact_impresa as UNSIGNED) ASC");
		$cuenta = _num_rows($sql_lista);
		if($cuenta > 0)
		{

			while ($row = _fetch_array($sql_lista))
			{
				  $numero_doc = intval($row["num_fact_impresa"]);




				$hora = $row["hora"];
				$id_empleado = $row["id_empleado"];
				$total = $row["total"];
				$total_exento = $row["venta_exenta"];



				$sql_empleado = _query("SELECT * FROM empleado WHERE id_empleado = '$id_empleado'");
				$row_empleado = _fetch_array($sql_empleado);
				$nombre_em = $row_empleado["nombre"];

				$lista.= "<tr>";
				$lista.= "<td>".$n."</td>";
				$lista.= "<td>".$numero_doc."</td>";
				$lista.= "<td>".$hora."</td>";
				$lista.= "<td>".$nombre_em."</td>";
				$lista.= "<td>$".$total."</td>";

				$n += 1;
			}

		}
		echo $lista;
	}
	if(!isset($_POST['process'])){
		initial();
	}
	else
	{
		if(isset($_POST['process']))
		{
			switch ($_POST['process'])
			{
				case 'tiket':
				cargar();
				break;
			}
		}
	}
	?>
