<?php
include ("_core.php");
include ('num2letras.php');
include ('facturacion_funcion_imprimir.php');
function initial(){
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$id_sucursal=$_SESSION['id_sucursal'];
	date_default_timezone_set('America/El_Salvador');
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script

	//include ('facturacion_funcion_imprimir.php');
	//$sql="SELECT * FROM factura WHERE id_factura='$id_factura'";
	//echo "SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado=$id_user";
	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado=$id_user");
	$cuenta = _num_rows($sql_apertura);
	$row_apertura = _fetch_array($sql_apertura);
	$id_apertura = $row_apertura["id_apertura"];
	$empleado = $row_apertura["id_empleado"];
	$turno = $row_apertura["turno"];
	$fecha_apertura = $row_apertura["fecha"];
	$hora_apertura = $row_apertura["hora"];
	$monto_apertura = $row_apertura["monto_apertura"];

	$hora_actual = date('H:i:s');
	$array_u = array(
		'nombre' => uniqid(),
		'monto' => uniqid(),
		'cerrar' => uniqid(),
		'submit' => uniqid(),
	);
	if($cuenta > 0)
	{
		?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">&times;</button>
			<h4 class="modal-title">Agregar Servicio</h4>
		</div>
		<div class="modal-body">
			<!--div class="wrapper wrapper-content  animated fadeInRight"-->
			<div class="row" id="row1">
				<!--div class="col-lg-12"-->
				<?php

				?>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group has-info single-line">
							<label>Servicio</label>
							<input type="" class='<?=$array_u['nombre'] ?> form-control' name="" value="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group has-info single-line">
							<label>Monto </label> <input type='text'  class='<?=$array_u['monto'] ?> form-control numeric'>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<button type="button"  class="btn btn-primary <?=$array_u['submit'] ?>">Agregar</button>
			<button type="button" class="btn btn-default <?=$array_u['cerrar'] ?>" data-dismiss="modal">Cerrar</button>
		</div>
		<script type="text/javascript">

		$(document).on('click', '.<?=$array_u['submit'] ?>', function(event) {
			event.preventDefault();
			nombre = $(".<?=$array_u['nombre'] ?>").val();
			monto = parseFloat($(".<?=$array_u['monto'] ?>").val());
			if (isNaN(monto))
			{
				monto = 0;
			}

			if(nombre!="" && monto!="" && monto!=0)
			{
				$.ajax({
					url: 'agregar_servicio.php',
					type: 'POST',
					dataType: 'json',
					data: {process: 'obtener',monto:monto,nombre:nombre},
					success: function(xdatos)
					{
						$(".<?=$array_u['nombre'] ?>").val("");
						$(".<?=$array_u['monto'] ?>").val("");
						$("#inventable").prepend(xdatos.servicio);

						$(".decimal2").numeric({
								negative: false,
								decimal: false
						});
						$(".86").numeric({
								negative: false,
								decimalPlaces: 4
						});
						$(".sel").select2();
						$(".sel_r").select2();
						totales();
						$("#tipo_impresion").trigger('change');

						$(".<?=$array_u['cerrar'] ?>").click();



					}
				});
			}
			else
			{
				display_notify("Warning","Complete los campos");
			}

		});
		$(".numeric").numeric(
			{
				negative:false,
				decimalPlaces:2,
			}
		);
	</script>
	<!--/modal-footer -->

	<?php

}
else
{
	echo "<div></div><br><br><div class='alert alert-warning text-center'>No se ha encontrado una apertura vigente.</div>";
}
}

function obtener()
{
	$id_servicio  = -9999;
	$nombre_servicio = $_REQUEST['nombre'];
	$monto =  $_REQUEST['monto'];
	$monto = round($monto, 4);
	$subtotal = $monto;
	$uni = uniqid();
	$lista="";
	$lista.= "<tr class='row100 head service $uni'>";
	$lista.="<td class='cell100 column10 text-success id_pps' hidden=''>";
	$lista.="<input id='unidades' name='unidades' value='1' type='hidden'>".+$id_servicio."";
	$lista.="</td>";
	$lista.="<td class='cell100 column30 text-success descripcion_insumo' >".$nombre_servicio."";
	$lista.="<input id='exento' name='exento' value='0' type='hidden'>";
	$lista.="</td>";
	$lista.="<td class='cell100 column10 text-success' id='cant_stock'>1";
	$lista.="</td>";
	$lista.="<td class='cell100 column10 text-success'>";
	$lista.="<div><input disabled class=form-control decimal2 cant' id='cant' name='cant' value='1' style='width:60px;' type='text'>";
	$lista.="</div>";
	$lista.="</td>";
	$lista.="<td class='cell100 column10 text-success preccs'>";
	$lista.="<select disabled class='sel form-control'>";
	$lista.="<option value='-9999'>UNIDAD</option>";
	$lista.="</select>";
	$lista.="</td>";
	$lista.="<td style='display:none' class='cell100 column10 text-success descp'>";
	$lista.="<input type'text'='' id='dsd' class='form-control' value='SERVICIO' readonly=''>";
	$lista.="</td>";
	$lista.="<td class='cell100 column10 text-success rank_s'>";
	$lista.="<select disabled class='sel_r precio_r form-control '>";
	$lista.="<option value='".$monto."' selected=''>".$monto."</option>";
	$lista.="</select>";
	$lista.="</td>";
	$lista.="<td class='cell100 column10 text-success'>";
	$lista.="<input id='precio_venta_inicial' name='precio_venta_inicial' value='".$monto."' type='hidden'>";
	$lista.="<input id='precio_sin_iva' name='precio_sin_iva' value='".round(($monto/1.13),4)."' type='hidden'>";
	$lista.="<input class='form-control decimal' readonly='' id='precio_venta' name='precio_venta' value='".$monto."' type='text'>";
	$lista.="</td>";
	$lista.="<td class='ccell100 column10'>";
	$lista.="<input id='subtotal_fin' name='subtotal_fin' value='".$monto."' type='hidden'>";
	$lista.="<input class='decimal txt_box form-control' id='subtotal_mostrar' name='subtotal_mostrar' value='".$monto."' readonly='' type='text'>";
	$lista.="</td>";
	$lista.="<td class='cell100 column10  text-center'>";
	$lista.="<input id='delprod' class='btn btn-danger fa fa-trash Delete' value='' type='button'>";
	$lista.="</td>";
	$lista.="</tr>";

	$xdatos['servicio'] = $lista;

	echo json_encode($xdatos);
}

if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'formDelete' :
				initial();
			break;
			case 'obtener' :
				obtener();
			break;
			}
		}
	}

	?>
