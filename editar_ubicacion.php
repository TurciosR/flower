<?php
include_once "_core.php";

function initial()
{
	$id_ubicacion = $_REQUEST["id_ubicacion"];
	$sql = _query("SELECT * FROM ubicacion WHERE id_ubicacion ='$id_ubicacion'");
	$row = _fetch_array($sql);
	$ubicacion = $row["descripcion"];
	$bodega = $row["bodega"];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Editar Ubicación</h4>
	</div>
		<div class="modal-body">
			<div class="wrapper wrapper-content  animated fadeInRight">
				<div class="row" id="row1">
					<div class="col-lg-12">
						<?php if($links != 'NOT' || $admin == '1'){ ?>
						<form name="formulario" id="formulario" autocomplete="off">
						<div class="form-group has-info single-line">
							<label class="control-label" for="Ubicacion">Ubicación</label>
							<input type="text" placeholder="Ubicacion" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $ubicacion; ?>">
						</div>
						<div>
							<input type="submit" class="btn btn-primary" value="Guardar">
							<input type="hidden" name="process" id="process" value="edited">
						</div>
					</form>
					</div>
				</div>
				<?php
					echo "<input type='hidden' nombre='id_ubicacion' id='id_ubicacion' value='$id_ubicacion'>";
				?>
			</div>
		</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#formulario').validate({
				rules: {
					ubicacion: {
						required: true,
					},
				},
				messages: {
					ubicacion: "Por favor ingrese la ubicacion",
				},
				highlight: function(element) {
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},
				success: function(element) {
					$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				},
				submitHandler: function(form) {
					senddata();
				}
			});
			$(".select").select2();

		});
	</script>
<?php
	}
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
}
function edit()
{
	$id_ubicacion = $_POST["id_ubicacion"];
	$bodega = 1;
	$ubicacion = $_POST["ubicacion"];

    $table = 'ubicacion';
    $form_data = array (
    	'descripcion' => $ubicacion,
			'bodega' => $bodega,
    );
    $where = "id_ubicacion='".$id_ubicacion."'";
	$update = _update($table,$form_data, $where);
    if($update)
    {
       $xdatos['typeinfo']='Success';
       $xdatos['msg']='Registro modificado correctamente!';
       $xdatos['process']='insert';
    }
    else
    {
       $xdatos['typeinfo']='Error';
       $xdatos['msg']='Registro no pudo se modificado!';
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
