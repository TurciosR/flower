<?php
include_once "_core.php";
function initial()
{

	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Agregar Garantia</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="nombre">IMEI</label>
						<input type="text" placeholder="" class="form-control" id="imei" name="imei">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<table class="table table-bordered table-striped table-responsive" id="tab_dt">

					</table>
				</div>
			</div>
			<input type="hidden" name="process" id="process" value="insert">
		</div>
	</div>
	<?php
	echo "<input type='hidden' nombre='id_producto' id='id_producto'>";
	?>
</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnsave">Guardar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal" id="salir">Cerrar</button>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#imei").typeahead({
			source: function(query, process) {
				$.ajax({
					type: 'POST',
					url: 'autocomplete_imei.php',
					data: 'query=' + query,
					dataType: 'JSON',
					async: true,
					success: function(data) {
						process(data);
					}
				});
			},
			updater: function(selection) {
				var producto = selection;
				var detalle = producto.split("|");
				var id_producto = detalle[0];
				if (id_producto != 0) {
					add_prod(id_producto);
				}
				// agregar_producto_lista(id_prod, descrip, isbarcode);
			}
		});
		$("#btnsave").click(function(){
			sennd();
		});
	});
	function add_prod(id_producto)
	{
		$.ajax({
      type: 'POST',
      url: 'garantia.php',
      data: 'process=cons&id_producto='+id_producto,
      dataType: 'JSON',
      success: function(datax)
			{
				$("#tab_dt").html(datax.table);
				$("#id_producto").val(id_producto);
				if(datax.garantia == '1')
				{
					$("#btnsave").attr("disabled", true);
				}
				else {
					$("#btnsave").attr("disabled", false);
				}
      }
    });
	}
	function sennd()
	{
		var id_producto = $("#id_producto").val();
		$.ajax({
			type: 'POST',
			url: 'garantia.php',
			data: 'process=insert&id_producto='+id_producto,
			dataType: 'JSON',
			success: function(datax)
			{
				display_notify(datax.typeinfo, datax.msg);
				if(datax.typeinfo == "Success")
				{
					$("#salir").click();
					setInterval("location.reload();",1000);
				}
			}
		});
	}
</script>
<?php
}
function insert()
{
	$id_producto = $_POST["id_producto"];

	$table = 'producto';
	$form_data = array (
		'garantia' => 1,
		'fecha_garantia' => date("Y-m-d")
	);
	$where = "id_producto='".$id_producto."'";
	$insertar = _update($table,$form_data,$where);
	if($insertar)
	{
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Datos procesados correctamente!';
		$xdatos['process']='insert';
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Datos no pudieron ser procesados!';
		$xdatos['process']='none';
	}
	echo json_encode($xdatos);
}
function consultar_imei()
{
  $id_producto = $_POST["id_producto"];
  $sql = _query("SELECT p.*, c.nombre as cliente, v.nombre as vendedor, s.nombre as sucursal, l.nombre as local
								 FROM producto as p JOIN cliente as c ON p.id_cliente=c.id_cliente
								 LEFT JOIN vendedor as v ON p.id_vendedor=v.id_vendedor
								 LEFT JOIN sucursal as s ON p.id_sucursal=s.id_sucursal
								 LEFT JOIN local as l ON p.id_local=l.id_local
								 WHERE p.id_producto='$id_producto'");
  $datos = _fetch_array($sql);
	$xdatos["garantia"] = $datos["garantia"];
  $table = '<tr>
		<td style="width:20%;">Marca</td>
		<td style="width:30%;">'.$datos["marca"].'</td>
		<td style="width:20%;">Modelo</td>
		<td style="width:30%;">'.$datos["modelo"].'</td>
	</tr>
	<tr>
		<td>IMEI</td>
		<td>'.$datos["imei"].'</td>
		<td>Comisión</td>
		<td>'.$datos["comision"].'</td>
	</tr>
	<tr>
		<td>Cliente</td>
		<td>'.$datos["cliente"].'</td>
		<td>Fecha Entrega</td>
		<td>'.ED($datos["fecha_asignado"]).'</td>
	</tr>
	<tr>
		<td>Fecha Venta</td>
		<td>'.$datos["fecha_venta"].'</td>
		<td>Sucursal</td>
		<td>'.$datos["sucursal"].'</td>
	</tr>
	<tr>
		<td>Local</td>
		<td>'.$datos["local"].'</td>
		<td>Vendedor</td>
		<td>'.$datos["vendedor"].'</td>
	</tr>';
	if($datos["cobrado"])
	{
		$table.='
		<tr class="success">
			<td colspan="2">Esta Comisión ya fue Pagada</td>
			<td>Fecha Pago</td>
			<td>'.$datos["fecha_cobro"].'</td>
		</tr>';
	}
	if($datos["garantia"])
	{
		$table.='
		<tr>
			<td colspan="4" class="danger text-center">Ya se dio garantia de este IMEI</td>
		</tr>';
	}
	$xdatos["table"] = $table;
  echo json_encode($xdatos);
}
if(!isset($_POST['process']))
{
	initial();
}
else
{
	if(isset($_POST['process']))
	{
		switch ($_POST['process'])
		{
			case 'insert':
			insert();
			break;
			case 'cons':
			consultar_imei();
			break;
		}
	}
}
?>
