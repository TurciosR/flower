<?php
include_once "_core.php";

function initial()
{
	$id_vendedor = $_REQUEST["id_vendedor"];
	$sql = _query("SELECT v.*, u.usuario FROM vendedor AS v, usuario as u WHERE v.id_vendedor=u.id_vendedor AND v.id_vendedor ='$id_vendedor'");
	$row = _fetch_array($sql);
	$nombre = $row["nombre"];
	$direccion = $row["direccion"];
	$usuario = $row["usuario"];
	$id_cliente = $row["id_cliente"];
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Editar Vendedor</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="cliente">Cliente</label>
						<select name="cliente" id="cliente" class="select form-control" style="width: 100%;">
							<option value="">Seleccione</option>
							<?php
							$sql = _query("SELECT * FROM cliente ORDER BY nombre ASC");
							while($row = _fetch_array($sql))
							{
								echo "<option value='".$row["id_cliente"]."'";
								if($row["id_cliente"] == $id_cliente)
								{
									echo " selected ";
								}
								echo ">".$row["nombre"]."</option>";
							}
							?>
						</select>
					</div>
					<input type="hidden" name="process" id="process" value="edited">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="nombre">Nombre</label>
						<input type="text" placeholder="vendedor 1" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="direccion">Dirección</label>
						<input type="text" placeholder="San Miguel" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="usuario">Usuario</label>
						<input type="text" placeholder="user001" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>">
					</div>
				</div>
			</div>
			<?php
			echo "<input type='hidden' nombre='id_vendedor' id='id_vendedor' value='$id_vendedor'>";
			?>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary" id="btnsave">Guardar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".select").select2();
		$("#usuario").keyup(function(){
			$(this).val($(this).val().toLowerCase());
		});
	});
	</script>
	<?php
}
function edit()
{
	$id_vendedor = $_POST["id_vendedor"];
	$nombre = $_POST["nombre"];
	$direccion = $_POST["direccion"];
	$cliente = $_POST["cliente"];
	$usuario = $_POST["usuario"];

	$table = 'vendedor';
	$table_b = 'usuario';
	$form_data = array (
		'id_cliente' => $cliente,
		'nombre' => $nombre,
		'direccion' => $direccion
	);
	$form_data_u = array (
		'id_cliente' => $cliente,
		'nombre' => $nombre,
		'usuario' => $usuario,
	);
	$where = "id_vendedor='".$id_vendedor."'";
	_begin();
	$update = _update($table,$form_data, $where);
	$update1 = _update($table_b,$form_data_u, $where);
	if($update && $update1)
	{
		_commit();
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='Datos modificados correctamente!';
		$xdatos['process']='insert';
	}
	else
	{
		_rollback();
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Datos no pudieron ser modificados!';
		$xdatos['process']='none';
	}
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
			case 'edited':
			edit();
			break;
		}
	}
}
?>
