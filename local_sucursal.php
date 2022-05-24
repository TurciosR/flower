<?php
include_once "_core.php";
function initial()
{
  $id_sucursal=$_REQUEST["id_sucursal"];

  $sql =_query("SELECT sucursal.*, cliente.nombre as cliente  FROM sucursal LEFT JOIN cliente ON cliente.id_cliente=sucursal.id_cliente WHERE sucursal.id_sucursal=$id_sucursal");
  $row = _fetch_array($sql);
  $cliente=$row['cliente'];
  $nombre=$row['nombre'];
  $direccion=$row['direccion'];
  ?>

  <div class="modal-header">
    <h4 class="modal-title">Locales de Sucursal</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="form-group col-md-6">
        <label>Sucursal</label>
        <input type="text" class='form-control' value='<?php echo $nombre; ?>' readOnly />
      </div>
      <div class="form-group col-md-6">
        <label>Propietario</label>
        <input type="text" class='form-control' value='<?php echo $cliente; ?>' readOnly />
      </div>
    </div>
    <div class="row">
      <div class="form-group col-md-12">
        <label>Dirección</label>
        <input type="text" class='form-control' value='<?php echo $direccion; ?>' readOnly>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-4">
        <label>Nombre</label>
        <input type="text" class='form-control clear' id="nombre">
      </div>
      <div class="col-md-4">
        <label>Dirección</label>
        <input type="text" class='form-control clear' id="direccion">
      </div>
      <div class="col-md-4">
        <br>
        <button type="button" name="button" class="btn btn-primary" id="add_loc"><i class="fa fa-plus"></i>Agregar</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <section>
          <table class="table  table-striped">
            <thead>
              <tr>
                <th class="text-success col-md-5">Nombre</th>
                <th class="text-success col-md-6">Dirección</th>
                <th class="text-success col-md-1">Acción</th>
              </tr>
            </thead>
            <tbody id="appas">
              <?php
              $sql = _query("SELECT * FROM local WHERE id_sucursal=$id_sucursal ORDER BY nombre ASC");
              $tot = 0;
              while ($row = _fetch_array($sql)) {
                echo "<tr>";
                echo "<td>".$row["nombre"]."</td>";
                echo "<td>".$row["direccion"]."</td>";
                echo "<td><a class='btn dele' id='".$row["id_local"]."'><i class='fa fa-trash'></i></a></td>";
                echo "</tr>";
              } ?>
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="row">
      <div class="col-lg-12">
        <input type='hidden' name='id_sucursal' id='id_sucursal' value='<?php echo $id_sucursal; ?>'>
        <button type="button" class="btn btn-danger" id="clos" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $(".select").select2();
    $("#monto").numeric({negative:false,decimalPlaces:2});
  });
</script>
<?php
}
function insert()
{
  $id_sucursal = $_POST["id_sucursal"];
  $nombre = $_POST["nombre"];
  $direccion = $_POST["direccion"];

  $sql=_query("SELECT * FROM local WHERE nombre='$nombre' AND direccion='$direccion' AND id_sucursal='$id_sucursal'");
  if (_num_rows($sql)==0)
  {
    $table = 'local';
    $form_data = array(
      'id_sucursal' => $id_sucursal,
      'nombre' => $nombre,
      'direccion' => $direccion
    );
    $insertar = _insert($table, $form_data);
    if($insertar)
    {
      $xdatos["id_local"] = _insert_id();
      $xdatos["typeinfo"] = "Success";
    }
    else
    {
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Datos no ingresados!';
    }
  }
  else
  {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Ya se registro este local!';
  }

  echo json_encode($xdatos);
}
function elim_sucursal()
{
  $id_local = $_POST["id_local"];
  $tabla = "local";
  $where = "id_local='".$id_local."'";
  $delete = _delete($tabla, $where);
  if($delete)
  {
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Abono eliminado correctamente!';
  }
  else
  {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Abono no pudo ser eliminado!';
  }
  echo json_encode($xdatos);
}
//functions to load
if (!isset($_REQUEST['process'])) {
  initial();
}
//else {
if (isset($_REQUEST['process'])) {
  switch ($_REQUEST['process']) {
    case 'formEdit':
      initial();
      break;
      case 'insert':
      insert();
      break;
      case 'elim_sucursal':
      elim_sucursal();
      break;
    }

    //}
  }
  ?>
