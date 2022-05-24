<?php
include_once "_core.php";
function initial()
{
	?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
		<h4 class="modal-title">Agregar Vendedor</h4>
	</div>
	<div class="modal-body">
		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="form-group has-info single-line">
				<label class="control-label" for="cliente">Cliente</label>
				<select name="cliente" id="cliente" class="select form-control" style="width: 100%;">
					<option value="">Seleccione</option>
					<?php
					$sql = _query("SELECT * FROM cliente ORDER BY nombre ASC");
					while($row = _fetch_array($sql))
					{
						echo "<option value='".$row["id_cliente"]."'";
						echo ">".$row["nombre"]."</option>";
					}
					?>
				</select>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="nombre">Nombre</label>
						<input type="text" placeholder="vendedor 1" class="form-control" id="nombre" name="nombre">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="direcion">Dirección</label>
						<input type="text" placeholder="San Miguel" class="form-control" id="direccion" name="direccion">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group has-info single-line">
						<label class="control-label" for="usuario">Usuario</label>
						<input type="text" placeholder="user001" class="form-control" id="usuario" name="usuario">
					</div>
				</div>
			</div>
			<input type="hidden" name="process" id="process" value="insert">
		</div>
	</div>
	<?php
	//echo "<input type='hidden' nombre='id_garantia' id='id_garantia' value='$id_garantia'>";
	?>
</div>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btnsave">Guardar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal" id="salir">Cerrar</button>

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

function insert()
{
	$nombre = $_POST["nombre"];
	$direccion = $_POST["direccion"];
	$cliente = $_POST["cliente"];
	$usuario = $_POST["usuario"];
	_begin();
	$sql_result= _query("SELECT * FROM vendedor WHERE nombre='$nombre' AND direccion='$direccion' AND id_cliente='$cliente'");
	$row_update=_fetch_array($sql_result);
	$numrows=_num_rows($sql_result);

	$table = 'vendedor';
	$form_data = array (
		'id_cliente' => $cliente,
		'nombre' => $nombre,
		'direccion' => $direccion
	);

	if($numrows == 0)
	{
		$insertar = _insert($table,$form_data);
		if($insertar)
		{
			$id_vendedor = _insert_id();
			$sql_val = _query("SELECT * FROM usuario WHERE usuario='$usuario'");
			if(_num_rows($sql_val)==0)
			{
				$pass = md5("vend1234");
				$table_b = "usuario";
				$form_data_u = array(
					'id_vendedor' => $id_vendedor,
					'id_cliente' => $cliente,
					'nombre' => $nombre,
					'usuario' => $usuario,
					'password' => $pass,
					'tipo_usuario' => 0,
					'admin' => 0,
				);
				$insertar_b = _insert($table_b, $form_data_u);
				if($insertar_b)
				{
					_commit();
					$xdatos['typeinfo']='Success';
					$xdatos['msg']='Datos ingresados correctamente!';
					$xdatos['process']='insert';
				}
				else
				{
					_rollback();
					$xdatos['typeinfo']='Error';
					$xdatos['msg']='Datos no pudieron ser ingresados!';
					$xdatos['process']='none';
				}
			}
			else
			{
				_rollback();
				$xdatos['typeinfo']='Error';
				$xdatos['msg']='Datos no pudieron ser ingresados!';
				$xdatos['process']='none';
			}
		}
		else
		{
			_rollback();
			$xdatos['typeinfo']='Error';
			$xdatos['msg']='Datos no pudieron ser ingresados!';
			$xdatos['process']='none';
		}
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Esta vendedor ya fue ingresada!';
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
			case 'insert':
			insert();
			break;
		}
	}
}
?>
