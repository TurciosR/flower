<?php
include ("_core.php");
function initial()
{
	$title = 'Detalle de Comisiones';
	include_once "header.php";
	include_once "menu.php";

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$id_cliente = $_REQUEST["id_cliente"];
	$mes = $_REQUEST["mes"];
	$anio = $_REQUEST["anio"];
	$pay = $_REQUEST["pay"];
	?>

	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
					if ($links!='NOT' || $admin=='1' )
					{
						echo "<div class='ibox-title'>";
						//permiso del script
						echo "</div>";

						?>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<header>
								<h4><?php echo $title; ?></h4>
							</header>
							<div class="row">
								<input type="hidden" id="pay" value="<?php echo $pay; ?>">
								<div class="col-lg-3 col-md-3 col-sm-3">
									<label>Mes</label>
									<select id="mes" name="mes" class="form-control select">
										<?php
											for($i=1; $i<13; $i++)
											{
												echo "<option value='".($i)."'";
												if($i == $mes)
												{
													echo " selected ";
												}
												echo ">".meses($i)."</option>";
											}
										?>
									</select>
								</div>
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="form-group">
									<label>Año</label>
									<select id="anio" name="anio" class="form-control select">
										<?php
										echo "<option value='".date("Y")."' selected>".date("Y")."</option>";
										$sql = _query("SELECT DISTINCT(anio_venta) as anio_venta FROM producto WHERE anio_venta!='".date("Y")."' ORDER BY anio_venta DESC");
										while($row = _fetch_array($sql))
										{
											echo "<option value='".$row["anio_venta"]."'>".$row["anio_venta"]."</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
							<div class="row">
								<div class="form-group col-md-3">
									<label>Sucursal</label>
									<select id="sucursal" name="sucursal" class="form-control select">
										<?php
											echo "<option value='GENERAL'>CONSOLIDADO</option>";
											$sql = _query("SELECT id_sucursal, nombre FROM sucursal WHERE id_cliente='$id_cliente' ORDER BY nombre ASC");
											while($row = _fetch_array($sql))
											{
												echo "<option value='".$row["id_sucursal"]."'>".$row["nombre"]."</option>";
											}
										?>
									</select>
								</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>Local</label>
									<select id="local" name="local" class="form-control select">
										<?php
										echo "<option value='GENERAL'>CONSOLIDADO</option>";
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label>Vendedor</label>
									<select class="form-control select" name="vendedor" id="vendedor" style="width:100%;">
										<option value="GENERAL">CONSOLIDADO</option>
										<?php
										$sql = _query("SELECT id_vendedor, nombre FROM vendedor WHERE id_cliente='$id_cliente' ORDER BY nombre ASC");
										while ($row = _fetch_array($sql))
										{
											echo "<option value='".$row["id_vendedor"]."'>".$row["nombre"]."</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<br>
									<button type="button" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Mostrar</button>
								</div>
							</div>
							</div>
							<section>
								<table class="table table-striped table-bordered table-hover" id="editable2">
									<thead>
										<tr>
											<th class="text-success font-bold" style="width:5%;">Id</th>
											<th class="text-success font-bold" style="width:14%;">Marca</th>
											<th class="text-success font-bold" style="width:14%;">Modelo</th>
											<th class="text-success font-bold" style="width:10%;">IMEI</th>
											<th class="text-success font-bold" style="width:5%;">Comisión</th>
											<th class="text-success font-bold" style="width:10%;">Fecha</th>
											<th class="text-success font-bold" style="width:14%;">Vendedor</th>
											<th class="text-success font-bold" style="width:14%;">Sucursal</th>
											<th class="text-success font-bold" style="width:14%;">Local</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
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
			include("footer.php");
			echo" <script type='text/javascript' src='js/funciones/funciones_detalle_comision.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include("footer.php");
		}
	}
	function pagar_comision()
	{
		$id_cliente = $_POST["id_cliente"];
		$mes = $_POST["mes"];
		$anio = $_POST["anio"];
		$tabla ="producto";
		$form_data = array(
			'cobrado' => 1,
			'mes_cobro' => date("m"),
			'anio_cobro' => date("Y"),
			'fecha_cobro' => date("Y-m-d"),
		);
		$where_clause = "id_cliente='" . $id_cliente . "' AND mes_venta='".$mes."' AND anio_venta='".$anio."'";
		$delete = _update($tabla,$form_data,$where_clause);
		if($delete)
		{
			$xdatos["typeinfo"]="Success";
			$xdatos["msg"]="Pago efectuado correctamente!";
		}
		else
		{
			$xdatos["typeinfo"]="Error";
			$xdatos["msg"]="Pago no pudo ser efectuado!"._error();
		}
		echo json_encode($xdatos);
	}
	function getlocal()
	{
	  $id_sucursal =  $_POST["id_sucursal"];
	  $sql_loc = _query("SELECT * FROM local WHERE id_sucursal='$id_sucursal' ORDER BY nombre");
	  $xdatos["local"] = "<option value='GENERAL'>CONSOLIDADO</option>";
	  while($row2 = _fetch_array($sql_loc))
	  {
	    $xdatos["local"].="<option value='".$row2["id_local"]."'>".$row2["nombre"]."</option>";
	  }
	  echo json_encode($xdatos);
	}
	if(!isset($_POST['process'])){
		initial();
	}
	else
	{
		if(isset($_POST['process'])){
			switch ($_POST['process']) {
				case 'pagar':
				pagar_comision();
				break;
				case 'getlocal':
				getlocal();
				break;
			}
		}
	}
	?>
