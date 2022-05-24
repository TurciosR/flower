<?php
include_once "_core.php";

function initial()
{
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Agregar Estante</h4>
</div>
<div class="modal-body">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row" id="row1">
            <div class="col-lg-12">
                <?php if($links != 'NOT' || $admin == '1'){ ?>
                <form name="formulario" id="formulario" autocomplete="off">
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="estante">Estante</label>
                        <input type="text" placeholder="Estante" class="form-control" id="estante" name="estante">
                    </div>
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="">Ubicación</label>
                        <select name="ubicacion" id="ubicacion" class="" style="width: 100%;">
                            <option value="">Seleccione</option>
                            <?php
			            $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal=$_SESSION[id_sucursal] ORDER BY descripcion ASC");
          				while($row = _fetch_array($sql))
          				{
          					echo "<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
                  }
          			?>
                        </select>
                    </div>
                    <div>&nbsp;</div>
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="npos">Posiciones</label>
                        <input type="text" placeholder="Posiciones" class="form-control numeric" id="npos" name="npos">
                    </div>
                    <div><br>
                        <input type="submit" id="submit1" name="submit1" value="Guardar"
                            class="btn btn-primary m-t-n-xs" />
                    </div>
                    <input type="hidden" name="process" id="process" value="insert">
                </form>
            </div>
        </div>
        <?php
					//echo "<input type='hidden' nombre='id_garantia' id='id_garantia' value='$id_garantia'>";
				?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    $('#ubicacion').select2();
    $('#formulario').validate({
        rules: {
            estante: {
                required: true,
            },
            npos: {
                required: true,
            },
            ubicacion: {
                required: true,
            },
        },
        messages: {
            estante: "Por favor ingrese el estante",
            npos: "Ingrese la cantidad de posiciones",
            ubicacion: "Ingrese la ubicacion",
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
    $(".numeric").numeric({
        decimal: false,
        negative: false
    });
});
</script>
<?php
  }
  else
  {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  }
}
function insert()
{
    $estante = $_POST["estante"];
    $ubicacion = $_POST["ubicacion"];
    $npos = $_POST["npos"];
    $id_sucursal = $_SESSION['id_sucursal'];
    $sql_result= _query("SELECT * FROM estante WHERE descripcion='$estante' AND id_ubicacion='$ubicacion'");
    $row_update=_fetch_array($sql_result);
    $numrows=_num_rows($sql_result);

    $table = 'estante';
    $form_data = array (
      'id_server' => 0,
    	'id_ubicacion' => $ubicacion,
    	'descripcion' => $estante,
      'id_sucursal' => $id_sucursal
    );
    _begin();
    if($numrows == 0 && trim($estante)!='' && $ubicacion !="")
    {

    	$insertar = _insert($table,$form_data);
	    if($insertar)
	    {
	    	$id_estante = _insert_id();
	    	$table_aux = "posicion";
	    	$j=0;
	    	for($i=0; $i<$npos; $i++)
	    	{
	    		$posicion = $i+1;
	    		$form_data_aux = array(
            'id_server' => 0,
	    			'id_ubicacion' => $ubicacion,
	    			'id_estante' => $id_estante,
	    			'posicion' => $posicion,
            'id_sucursal' => $id_sucursal,
	    		);
	    		$insert_aux = _insert($table_aux, $form_data_aux);
	    		if($insert_aux)
	    		{
	    			$j++;
	    		}
	    	}
	    	if($j==$npos)
	    	{
	    		_commit();
		        $xdatos['typeinfo']='Success';
		        $xdatos['msg']='Registro ingresado correctamente!';
		        $xdatos['process']='insert';
		    }
		    else
		    {
		    	_rollback();
		    	$xdatos['typeinfo']='Error';
		       	$xdatos['msg']='Registro no pudo ser ingresado !';
		       	$xdatos['process']='none';
		    }
	    }
	    else
	    {
	    	_rollback();
	       $xdatos['typeinfo']='Error';
	       $xdatos['msg']='Registro no pudo ser ingresado !';
	       $xdatos['process']='none';
		}
    }
   	else
   	{
   		$xdatos['typeinfo']='Error';
       	$xdatos['msg']='Ya se registro un estante con estos datos!';
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