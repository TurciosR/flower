<?php
include ("_core.php");
function initial()
{
	$title = 'Administrar Comisiones';
	include_once "header.php";
	include_once "menu.php";

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$fini = ED(restar_dias(date("Y-m-d"),30));
	$fin = ED(date("Y-m-d"));
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
								<div class="col-lg-3 col-md-3 col-sm-3">
									<label>Mes</label>
									<select id="mes" name="mes" class="form-control select">
										<?php
											for($i=1; $i<13; $i++)
											{
												echo "<option value='".($i)."'";
												if($i == date('m'))
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
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="form-group">
									<label>Cliente</label>
									<select class="form-control select" name="id_cliente" id="id_cliente" style="width:100%;">
										<option value="GENERAL">CONSOLIDADO</option>
										<?php
										$sql = _query("SELECT id_cliente, nombre FROM cliente ORDER BY nombre ASC");
										while ($row = _fetch_array($sql))
										{
											echo "<option value='".$row["id_cliente"]."'>".$row["nombre"]."</option>";
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
								<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="editable2">
									<thead>
										<tr>
											<th class="col-lg-1 text-primary font-bold">Id</th>
											<th class="col-lg-4 text-primary font-bold">Cliente</th>
											<th class="col-lg-2 text-primary font-bold">Mes</th>
											<th class="col-lg-2 text-primary font-bold">Año</th>
											<th class="col-lg-2 text-primary font-bold">Comisión</th>
											<th class="col-lg-1 text-primary font-bold">Pagar</th>
											<th class="col-lg-1 text-primary font-bold">Detalle</th>
										</tr>
									</thead>
									</table>
								</div>
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
			echo" <script type='text/javascript' src='js/funciones/funciones_comision.js'></script>";
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
		_begin();
		$where_clause = "id_cliente='" . $id_cliente . "' AND mes_venta='".$mes."' AND anio_venta='".$anio."'";
		$update = _update($tabla,$form_data,$where_clause);
		if($update)
		{
			$sql_aux = _query("SELECT id_producto FROM producto WHERE id_cliente='$id_cliente' AND garantia=1 AND descuento = 0");
			$n = 0;
			$num = _num_rows($sql_aux);
			while($data = _fetch_array($sql_aux))
			{
				$id_producto = $data["id_producto"];
				$form_data_aux = array(
					'descuento' => 1,
					'mes_descuento' => date("m"),
					'anio_descuento' => date("Y"),
				);
				$where_clause_aux = "id_producto='".$id_producto."'";
				$update_aux = _update($tabla,$form_data_aux, $where_clause_aux);
				if($update_aux)
				{
					$n++;
				}
			}
			if($n == $num)
			{
				_commit();
				$xdatos["typeinfo"]="Success";
				$xdatos["msg"]="Pago efectuado correctamente!";
			}
			else
			{
				_rollback();
				$xdatos["typeinfo"]="Error";
				$xdatos["msg"]="Pago no pudo ser efectuado!"._error();
			}
		}
		else
		{
			_rollback();
			$xdatos["typeinfo"]="Error";
			$xdatos["msg"]="Pago no pudo ser efectuado!"._error();
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
			}
		}
	}
	?>
