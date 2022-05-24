<?php
include_once "_core.php";

function initial()
{
  $id_estante = $_REQUEST["id_estante"];
  $sql = _query("SELECT * FROM estante WHERE id_estante ='$id_estante'");
  $row = _fetch_array($sql);
  $estante = $row["descripcion"];
  $id_ubicacion = $row["id_ubicacion"];
  $sql_aux = _query("SELECT * FROM posicion WHERE id_ubicacion = '$id_ubicacion' AND id_estante = '$id_estante'");
  $npos = _num_rows($sql_aux);
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
  ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Editar Estante</h4>
</div>
<form name="formulario" id="formulario">
    <div class="modal-body">
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row" id="row1">
                <div class="col-lg-12">
                    <?php if($links != 'NOT' || $admin == '1'){ ?>
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="estante">Estante</label>
                        <input type="text" placeholder="Estante" class="form-control" id="estante" name="estante"
                            value="<?php echo $estante; ?>">
                    </div>
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="ubicacion">Ubicación</label>
                        <select name="ubicacion" id="ubicacion" class="select form-control" style="width: 100%;">
                            <option value="">Seleccione</option>
                            <?php
                  $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal=$_SESSION[id_sucursal]  ORDER BY descripcion ASC");
                  while ($row = _fetch_array($sql)) {
                    echo "<option value='".$row["id_ubicacion"]."'";
                    if ($row["id_ubicacion"] == $id_ubicacion) {
                      echo " selected ";
                    }
                    echo ">".$row["descripcion"]."</option>";
                  } ?>
                        </select>
                    </div>
                    <div class="form-group has-info single-line">
                        <label class="control-label" for="npos">Posiciones</label>
                        <input type="text" placeholder="Posiciones" class="form-control numeric" id="npos" name="npos"
                            value="<?php echo $npos; ?>">
                    </div>
                    <input type="hidden" name="process" id="process" value="edited">
                </div>
            </div>
            <?php
          echo "<input type='hidden' nombre='id_estante' id='id_estante' value='$id_estante'>";
          ?>
        </div>

    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Guardar">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $("#ubicacion").select2();
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
            }
        },
        messages: {
            estante: "Por favor ingrese el estante",
            ubicacion: "Por seleccione el ubicacion",
            npos: "Ingrese el numero de posiciones"
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
function edit()
{
  $id_estante = $_POST["id_estante"];
  $estante = $_POST["estante"];
  $ubicacion = $_POST["ubicacion"];
  $npos = $_POST["npos"];
  $id_sucursal = $_SESSION['id_sucursal'];
  $table = 'estante';
  $form_data = array(
    'id_ubicacion' => $ubicacion,
    'descripcion' => $estante
  );
  $where = "id_estante='".$id_estante."'";
  _begin();
  $update = _update($table, $form_data, $where);
  if ($update) {
    $sql_aux = _query("SELECT * FROM posicion WHERE id_ubicacion = '$ubicacion' AND id_estante = '$id_estante'");
    $nact = _num_rows($sql_aux);
    $table_aux = "posicion";
    $pass = 0;
    if ($npos > $nact) {
      $sql_aux_a = _query("SELECT max(posicion) as posicion FROM posicion WHERE id_ubicacion = '$ubicacion' AND id_estante = '$id_estante'");

      $dats_aux_a = _fetch_array($sql_aux_a);
      $pos_exis = $dats_aux_a["posicion"];
      $faltantes = $npos - $pos_exis;
      $j = 0;
      for ($i=0; $i<$faltantes; $i++) {
        $posicion = $pos_exis + ($i+1);
        $form_data_aux = array(
          'id_server' => 0,
          'id_sucursal' => $id_sucursal,
          'id_ubicacion' => $ubicacion,
          'id_estante' => $id_estante,
          'posicion' => $posicion
        );
        $insert_aux = _insert($table_aux, $form_data_aux);
        if ($insert_aux) {
          $j++;
        }
      }
      if ($faltantes == $j) {
        $pass = 1;
      }
    }
    if ($npos < $nact) {
      $where_aux = "id_ubicacion = '$ubicacion' AND id_estante = '$id_estante' AND posicion > '$npos'";
      $delete = _delete($table_aux, $where_aux);
      if ($delete) {
        $pass = 1;
      }
    }
    else
    {
      $pass = 1;
    }
    if ($pass) {
      _commit();
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Registro editado con exito!';
      $xdatos['process']='insert';
    } else {
      _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Registro no pudo ser editado!'._error();
      $xdatos['process']='none';
    }
  } else {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro no pudo ser editado!'._error();
    $xdatos['process']='none';
  }
  echo json_encode($xdatos);
}

if (!isset($_POST['process'])) {
  initial();
} else {
  if (isset($_POST['process'])) {
    switch ($_POST['process']) {
      case 'edited':
      edit();
      break;
    }
  }
}
?>