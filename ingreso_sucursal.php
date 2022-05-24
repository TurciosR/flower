<?php
include_once "_core.php";
include_once 'Encryption.php';
function initial()
{
  $title = "Carga de Productos a Inventario";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main_co.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util_co.css">';

  include_once "header.php";

  $sql="SELECT * FROM producto";

  $result=_query($sql);
  $count=_num_rows($result);
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $fecha_actual=date("Y-m-d");

  ?>

<div class="gray-bg">
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <h5><?php echo $title;?></h5>
          </div>
          <?php if ($links!='NOT' || $admin=='1') { ?>
          <div class="ibox-content">
            <div class='row focuss' id='form_invent_inicial'>
              <div class="col-lg-3">
                <div class="form-group has-info">
                  <label>Concepto</label>
                  <input type='text' class='form-control' value='INVENTARIO INICIAL' id='concepto' name='concepto'>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group has-info">
                  <label>Destino</label>
                  <select class="form-control select" id="destino" name="destino">
                    <?php
                      $id_sucursal=$_SESSION['id_sucursal'];
                      $sql = _query("SELECT * FROM sucursal WHERE id_sucursal!='$id_sucursal'");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_sucursal"]."'>".$row["descripcion"]."</option>";
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class='col-lg-3'>
                <div class='form-group has-info'>
                  <label>Fecha</label>
                  <input type='text' class='datepick form-control' value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                </div>
              </div>
              <div class="col-lg-3">
                <input type="hidden" name="process" id="process" value="insert">
                <br>
                <a class="btn btn-danger pull-right" style="margin-left:2%;" href="dashboard.php" id='salir'><i class="fa fa-mail-reply"></i> F4 Salir</a>
                <button type="button" id="submit1" class="btn btn-primary pull-right"><i class="fa fa-save"></i> F2 Guardar</button>
                <input type='hidden' name='urlprocess' id='urlprocess' value="<?php echo $filename ?> ">
              </div>
            </div>
            <div class="row" id='buscador'>
              <div class="col-lg-4">
                <div id="a">
                  <label>Buscar Producto (Código)</label>
                  <input type="text" id="codigo" name="codigo" style="width:100% !important" class="form-control usage" placeholder="Ingrese Código de producto" style="border-radius:0px">
                </div>
                <div hidden id="b">
                  <label id='buscar_habilitado'>Buscar Producto (Descripción)</label>
                  <div id="scrollable-dropdown-menu">
                    <input type="text" id="producto_buscar" name="producto_buscar" style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese la Descripción de producto" data-provide="typeahead"
                      style="border-radius:0px">
                  </div>
                </div><br>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <header>
                  <h4 class="text-navy">Lista de Productos</h4>
                </header>
                <div class='widget-content' id="content">
                  <div class="wrap-table1001">
                    <div class="table100 ver1 m-b-10">
                      <div class="table100-head">
                        <table class="table table-striped" id='inventable1'>
                          <thead>
                            <tr class='row100 head'>
                              <th class="col-lg-1">Id</th>
                              <th class="col-lg-3">Nombre</th>
                              <th class="col-lg-1 text-left">Presentación</th>
                              <th class="col-lg-1">Descripción</th>
                              <th class="col-lg-1">Cantidad</th>
                              <th class="col-lg-1">Costo</th>
                              <th class="col-lg-1">Precio</th>
                              <th class="col-lg-1">Subtotal</th>
                              <th class="col-lg-1">Vence</th>
                              <th class="col-lg-1">Acci&oacute;n</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="table100-body js-pscroll">
                        <table>
                          <tbody id="inventable">
                          </tbody>
                        </table>
                      </div>
                      <div class="table101-body">
                        <table>
                          <tbody>
                            <tr>
                              <td class='cell100 column100 text-bluegrey font-bold' id='totaltexto'>&nbsp;</td>
                            </tr>
                            <tr>
                              <td class='cell100 column50' id='totaltexto'>&nbsp;</td>
                              <td class='cell100 column15 leftt  text-bluegrey font-bold'>CANT. PROD:</td>
                              <td class='cell100 column10 text-right text-danger font-bold' id='totcant'>0.00</td>
                              <td class="cell100 column10 leftt text-bluegrey font-bold">TOTALES $:</td>
                              <td class='cell100 column15 text-right text-green font-bold' id='total_dinero'>0.00</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>
                <div>
                </div>
                </form>
                <input type="hidden" id="filas" value="0">
              </div>
            </div>
          </div>
          <!--div class='ibox-content'-->
        </div>
      </div>


      <?php
  include_once ("footer.php");
  echo "<script src='js/funciones/funciones_inventario_sucursal.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
}
}

function insertar()
{
  _begin();
  // code...
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $destino = $_POST['destino'];
  $fecha = $_POST['fecha'];
  $total_compras = $_POST['total'];
  $concepto=$_POST['concepto'];

  $id_sucursal = $_SESSION["id_sucursal"];

  $array_data = array(
    'process' => "carga_directa",
    'cuantos' => $cuantos,
    'datos' => $datos,
    'fecha' => $fecha,
    'total' => $total_compras,
    'concepto' => "DESDE $id_sucursal, ".$concepto,
  );

  $encrypt_val = new Encryption();
  $data_encript = json_encode($array_data);
  $hash = $encrypt_val->encrypt($data_encript, $encrypt_val->pre_key);

  $tabla = "altclitocli";
  $form_data = array(
    'datax' => $hash,
    'id_sucursal_origen' => $id_sucursal,
    'id_sucursal_destino' => $destino,
    'ejecutado' => 0,
  );

  $insert_dat = _insert($tabla,$form_data);

  if($insert_dat)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con exito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!';
  }
  echo json_encode($xdatos);
}

function consultar_stock()
{
  echo json_encode(getStock());
}
function getpresentacion()
{
  echo json_encode(getPre());
}
if (!isset($_REQUEST['process']))
{
  initial();
}
if (isset($_REQUEST['process']))
{
  switch ($_REQUEST['process'])
  {
    case 'insert':
    insertar();
    break;
    case 'consultar_stock':
    consultar_stock();
    break;
    case 'getpresentacion':
    getpresentacion();
    break;
    case'traerpaginador':
    traerpaginador();
    break;
  }
}
?>
