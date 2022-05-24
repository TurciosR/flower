<?php
include("_core.php");
function initial()
{
  $title = 'Administrar Lotes';
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  include_once "header.php";
  include_once "main_menu.php";

  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  ?>
  <style media="screen">
  span.select2-container {
    z-index:10050;
  }
  </style>
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row" id="row1">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <?php
          if ($links!='NOT' || $admin=='1') {
             ?>
            <div class="ibox-content">
              <!--load datables estructure html-->
              <header>
                <h4><?php echo $title; ?></h4>
              </header>
              <section>
                <div class="row">
                  <div class="form-group col-md-5">
                    <div id="a">
                      <label id='buscar_habilitado'>Buscar Producto (Descripci&oacute;n)</label>
                      <div id="scrollable-dropdown-menu">
                      <input type="text" id="producto_buscar" name="producto_buscar"  style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese Descripcion de producto" data-provide="typeahead" style="border-radius:0px">
                      </div>
                    </div>

                    <div hidden id="b">
                      <label id='buscador_composicion'>Buscar Producto (Composición)</label>
                      <div id="scrollable-dropdown-menu">
                      <input type="text" id="composicion" name="composicion"  style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese la Composicion del producto" data-provide="typeahead" style="border-radius:0px">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">


                  <div class="form-group col-md-12">
                    <table class="table table-hover table-striped">
                      <thead>
                        <th class='col-lg-3'>Producto</th>
                        <th class='col-lg-2'>Fecha de Entrada</th>
                        <th class='col-lg-2'>Cantidad (A unidad minima)</th>
                        <th class='col-lg-2'>Estado</th>
                        <th class='col-lg-2'>Vencimiento</th>
                        <th class='col-lg-1'>Acción</th>
                      </thead>
                      <tbody id="inve">

                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="row">
                  <a class='btn btn-primary guardar'> <i class="fa fa-save"></i> Guardar</a>
                </div>
              </section>
              <!--Show Modal Popups View & Delete -->
              <div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'></div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-sm'>
                  <div class='modal-content modal-sm'></div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
            </div>
            <!--div class='ibox-content'-->
          </div>
          <!--<div class='ibox float-e-margins' -->
        </div>
        <!--div class='col-lg-12'-->
      </div>
      <!--div class='row'-->
    </div>
    <!--div class='wrapper wrapper-content  animated fadeInRight'-->
    <?php
    include ("footera.php");
    echo "<script src='js/funciones/funciones_admin_lote.js'></script>";
  } //permiso del script
  else {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
    include ("footer.php");
  }

}

function traerlotes()
{
  $id_producto=$_REQUEST['id_prod'];

  $sql=_query("SELECT lote.*,producto.descripcion FROM lote JOIN producto ON producto.id_producto=lote.id_producto WHERE lote.id_producto=$id_producto AND lote.estado='VIGENTE'");
  echo _error();

  $xdatos['lotes']="";
  if (_num_rows($sql)>0) {
    // code...

    while ($row=_fetch_array($sql)) {
      // code...
      $xdatos['lotes'].="
      <tr lote='$row[id_lote]'>
        <td>  ".htmlspecialchars($row['descripcion'])." </td>
        <td>$row[fecha_entrada]</td>
        <td>$row[cantidad]</td>
        <td>$row[estado]</td>
        <td><input class='date' type='' name='' value='$row[vencimiento]'></td>
        <td><a class='btn btn-danger trash'> <i class='fa fa-trash'></i></a></td>
      </tr>";

      /*<a class='btn btn-primary save'> <i class='fa fa-save'>*/

    }

  }
  else {
    $xdatos['lotes']="<tr><td colspan='4'>No se encontraron lotes</td></tr>";
  }
  // code...

  echo json_encode($xdatos);
}

function actualizar_todo()
{
  $array_json=$_REQUEST['json_arr'];

  $array = json_decode($array_json, true);

  foreach ($array as $fila)
  {
    $id_lote=$fila['id_lote'];
    $fecha=$fila['fecha'];

    $table='lote';
    $form_data = array(
      'vencimiento' => $fecha,
    );
    $where_clause="id_lote='".$id_lote."'";

    $update=_update($table,$form_data,$where_clause);

  }

  if ($update) {
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Fecha de vencimiento actualizada';
  }
  else {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Fecha de vencimiento no pudo ser actualizada';
  }
  echo json_encode($xdatos);



}

function actualizar()
{
  // code...
  $id_lote=$_REQUEST['id_lote'];
  $fecha=$_REQUEST['fecha'];

  $table='lote';
  $form_data = array(
    'vencimiento' => $fecha,
  );
  $where_clause="id_lote='".$id_lote."'";

  $update=_update($table,$form_data,$where_clause);

  if ($update) {
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Fecha de vencimiento actualizada';
  }
  else {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Fecha de vencimiento no pudo ser actualizada';
  }
  echo json_encode($xdatos);
}

if (!isset($_REQUEST['process']))
{
  initial();
}
if (isset($_REQUEST['process']))
{
  switch ($_REQUEST['process'])
  {
    case 'lotes':
    traerlotes();
    break;
    case 'actualizar':
    actualizar();
    break;
    case 'actualizar_todo':
    actualizar_todo();
    break;
  }
}
?>
