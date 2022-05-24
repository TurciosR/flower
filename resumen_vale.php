<?php
include ("_core.php");
// Page setup
function initial() {
	$title = 'Resumen de Vales/ Ingresos';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
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
								<h4><?php echo $title; ?></h4>
							</header>
							<section>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Fecha</label>
											<input type="text"  class="form-control datepick" id="fecha" name="fecha" value="<?php echo date('Y-m-d');?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Tipo</label>
											<select class="form-control select" name="tipo" id="tipo">
												<option value="Vales">Vales</option>
												<option value="Ingresos">Ingresos</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label class="control-label">Sucursal</label>
											<?php
											if ($admin==1) {
												// code... ?>
												<select class="col-md-12 select" id="sucursal" name="sucursal">
													<?php
													$sqld = "SELECT * FROM sucursal";
													$resultd=_query($sqld);
													while ($depto = _fetch_array($resultd)) {
														echo "<option value='".$depto["id_sucursal"]."'";

														echo">".$depto["descripcion"]."</option>";
													} ?>
												</select>
												<?php
											} else {
												?>
												<select class="col-md-12 select" id="sucursal" name="sucursal">
													<?php
													$sqld = "SELECT * FROM sucursal WHERE id_sucursal=$id_sucursal";
													$resultd=_query($sqld);
													while ($depto = _fetch_array($resultd)) {
														echo "<option value='".$depto["id_sucursal"]."'";

														echo">".$depto["descripcion"]."</option>";
													} ?>
												</select>
												<?php
											} ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<br>
											<a class="btn btn-primary pull-right" id="submit" name="submit"><i class="fa fa-print"></i> Imprimir</a>
											<input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal; ?>">
										</div>
									</div>
								</div>
							</section>
							<section>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<th class="col-lg-1">N°</th>
										<th class="col-lg-3">Hora</th>
										<th class="col-lg-6">Concepto</th>
										<th class="col-lg-2">Total</th>
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
			echo" <script type='text/javascript' src='js/funciones/resumen_vale.js'></script>";
		} //permiso del script
		else {
			echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
		}
	}
	function cargar()
	{
		$fecha = ($_POST["fecha"]);
		$tipo = $_POST["tipo"];
		if($tipo == "Vales")
		{
			$tcon = "salida";
		}
		else {
				$tcon = "entrada";
		}
		$lista = '';
		$id_sucursal = $_POST["id_sucursal"];
		$sql_lista = _query("SELECT * FROM mov_caja WHERE idtransace=0 AND fecha = '$fecha' AND id_sucursal = '$id_sucursal'  AND $tcon = '1' ORDER BY alias_tipodoc,numero_doc ASC");
		$cuenta = _num_rows($sql_lista);
		if($cuenta > 0)
		{
			$tot = 0;
			while ($row = _fetch_array($sql_lista))
			{
				$numero_doc = intval($row["id_movimiento"]);
				$concepto = $row["concepto"];
				$hora = hora($row["hora"]);
				$tot += $row["valor"];
				$total = number_format($row["valor"],2,".",",");

				$lista.= "<tr>";
				$lista.= "<td>".$numero_doc."</td>";
				$lista.= "<td>".$hora."</td>";
				$lista.= "<td>".$concepto."</td>";
				$lista.= "<td>$".$total."</td></tr>";
			}
			$lista.= "<tr><td colspan='3' class='text-center'>TOTAL</td><td>$".number_format($tot,2,".",",")."</td></tr>";
		}
		echo $lista;
	}
	function  imprimir()
	{
		$fecha = $_POST["fecha"];
		$tipo = $_POST["tipo"];
		$id_sucursal=$_POST['id_sucursal'];
		//directorio de script impresion cliente
		$sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
		//$sql_dir_print="SELECT * FROM `config_dir` WHERE `id_sucursal`=1 ";
		$result_dir_print=_query($sql_dir_print);
		$row0=_fetch_array($result_dir_print);
		$dir_print=$row0['dir_print_script'];
		$shared_printer_win=$row0['shared_printer_matrix'];
		$shared_printer_pos=$row0['shared_printer_pos'];

		if($tipo == "Vales")
		{
			$tcon = "salida";
		}
		else {
				$tcon = "entrada";
		}
		$hora_pre = date_create(date('H:i:s'));
	  $hora_pos = date_format($hora_pre, 'g:i A');
		$sql=_fetch_array(_query("SELECT * FROM sucursal WHERE id_sucursal=$_SESSION[id_sucursal]"));
		$info_mov = "".trim($sql['descripcion'])."\n";
		$info_mov .= "RESUMEN DE ".strtoupper($tipo)."\n";
		$info_mov .= "".$fecha."\n";
		$info_mov .= "".$hora_pos."\n";

		$fecha = ($fecha);
		$sql_lista = _query("SELECT * FROM mov_caja WHERE  idtransace=0 AND fecha = '$fecha' AND id_sucursal = '$id_sucursal'  AND $tcon = '1' AND alias_tipodoc!='DEV' ORDER BY numero_doc ASC");
		echo _error();
		$cuenta = _num_rows($sql_lista);
		if($cuenta > 0)
		{
			$info_mov .=str_pad("VALE",39," ",STR_PAD_RIGHT)."\n";
			$info_mov .= "No.       HORA            VALOR\n";
			$info_mov .= "---------------------------------\n";
			$tot = 0;
			while ($row = _fetch_array($sql_lista))
			{
				$numero_doc = intval($row["id_movimiento"]);
				$concepto = $row["concepto"];
				$hora = hora($row["hora"]);
				$tot += $row["valor"];
				$total = number_format($row["valor"],2,".",",");
				$lca = strlen($total);
				$esp =str_repeat(" ",(14 - $lca));
				$lcn = strlen($numero_doc);
				$espn =str_repeat(" ",(10 - $lcn));
				$lch = strlen($hora);
				$esph =str_repeat(" ",(6 - $lch));
				$info_mov.= $numero_doc.$espn.$hora.$esph.$esp."$".$total."\n";
			}
			$info_mov .= "---------------------------------\n";
			$lct = strlen($tot);
			$espt =str_repeat(" ",(29 - $lct));
			$info_mov.= str_pad("TOTAL VALES",20," ",STR_PAD_RIGHT).str_pad("$".number_format($tot,2,".",","),13," ",STR_PAD_LEFT)." \n\n\n";


		}

		$sql_lista = _query("SELECT * FROM mov_caja WHERE  idtransace=0 AND fecha = '$fecha' AND id_sucursal = '$id_sucursal'  AND $tcon = '1' AND alias_tipodoc='DEV' ORDER BY numero_doc ASC");
		$cuenta = _num_rows($sql_lista);
		if($cuenta > 0)
		{
			$info_mov .=str_pad("DEVOLUCION",39," ",STR_PAD_RIGHT)."\n";
			$info_mov .= "No.         HORA                VALOR\n";
			$info_mov .= "---------------------------------\n";
			$tot = 0;
			while ($row = _fetch_array($sql_lista))
			{
				$numero_doc = intval($row["numero_doc"]);
				$concepto = $row["concepto"];
				$hora = hora($row["hora"]);
				$tot += $row["valor"];
				$total = number_format($row["valor"],2,".",",");
				$lca = strlen($total);
				$esp =str_repeat(" ",(14 - $lca));
				$lcn = strlen($numero_doc);
				$espn =str_repeat(" ",(10 - $lcn));
				$lch = strlen($hora);
				$esph =str_repeat(" ",(6 - $lch));
				$info_mov.= $numero_doc.$espn.$hora.$esph.$esp."$".$total."\n";
			}
			$info_mov .= "---------------------------------\n";
			$lct = strlen($tot);
			$espt =str_repeat(" ",(29 - $lct));
			$info_mov.= str_pad("TOTAL DEV",20," ",STR_PAD_RIGHT).str_pad("$".number_format($tot,2,".",","),13," ",STR_PAD_LEFT)." \n\n\n";


		}

		$info_mov .= "F._____________________\n\n";
		//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
		$info = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($info, 'Windows') == TRUE)
			$so_cliente='win';
		else
			$so_cliente='lin';
		$nreg_encode['shared_printer_win'] =$shared_printer_win;
		$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
		$nreg_encode['dir_print'] =$dir_print;
		$nreg_encode['movimiento'] =$info_mov;
		$nreg_encode['sist_ope'] =$so_cliente;
	echo json_encode($nreg_encode);
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
				case 'vale':
				cargar();
				break;
				case 'imprimir':
				imprimir();
				break;
			}
		}
	}
	?>
