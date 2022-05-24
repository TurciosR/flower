<?php
include_once "_core.php";
function initial()
{
  $title = 'Agregar Precio de venta producto';
  $_PAGE = array ();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  $id_producto=$_REQUEST['id_producto'];
  include_once "header.php";
  include_once "main_menu.php";
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);

  ?>
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2">
    </div>
  </div>
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <?php
          //permiso del script
          if ($links!='NOT' || $admin=='1' ){
            ?>
            <div class="ibox-title">
              <h5><?php echo $title; ?></h5>
            </div>
            <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $id_producto ?>">
            <div class="ibox-content">
              <div class="row">
                <div class="col-lg-4">
                  <select class="form-control" id="id_presentacion" name="id_presentacion">
                    <?php
                    $sql_pre=_query("SELECT presentacion.nombre, presentacion_producto.id_presentacion, presentacion_producto.unidad FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE presentacion_producto.id_producto=$id_producto AND presentacion_producto.id_sucursal=$_SESSION[id_sucursal]");
                    $i=1;
                    $pre=0;
                    while($row=_fetch_array($sql_pre))
                    {
                      if ($i==1) {
                        # code...
                        $pre=$row['id_presentacion'];
                      }
                      ?>
                      <option value="<?php echo $row['id_presentacion'] ?>"><?php echo $row['nombre']."($row[unidad])" ?></option>

                      <?php
                      $i++;
                    }
                     ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <label>Desde</label>
                  <input id="desde" class="form-control int" type="text" name="" value="">
                </div>
                <div class="col-lg-3">
                  <label>Hasta</label>
                  <input id="hasta" class="form-control int" type="text" name="" value="">
                </div>
                <div class="col-lg-3">
                  <label>Precio</label>
                  <input id="precio" class="form-control " type="text" name="" value="">
                </div>
                <div class="col-lg-3">
                  <label>Agregar</label> <br>
                  <button type="button" class="btn btn-primary" id="add" name="add">Agregar</button>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <br>
                  <table id="precios" class="table table-striped table-bordered  table-sm">
                    <thead>
                      <th>Desde</th>
                      <th>Hasta</th>
                      <th>Precio</th>
                      <th>Accion</th>
                    </thead>
                    <tbody>
                      <?php
                      $sql_a=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$pre AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] ORDER BY presentacion_producto_precio.desde ASC");

                      while ($row=_fetch_array($sql_a)) {
                        # code...
                        ?>
                        <tr>
                          <td><?php echo $row['desde'] ?>  <input type="hidden" class="id_prepp" value="<?php echo $row['id_prepd'] ?>"> </td>
                          <td><?php echo $row['hasta'] ?></td>
                          <td><?php echo $row['precio'] ?></td>
                          <td> <a class="btn del"><i class="fa fa-trash"></i></a> </td>
                        </tr>
                        <?php
                      }
                       ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_precio_producto.js'></script>";
  } //permiso del script
  else
  {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div>";
    include_once ("footer.php");
  }
}

function insertar()
{
  _begin();
  $id_presentacion=$_REQUEST['id_presentacion'];
  $desde=$_REQUEST['desde'];
  $hasta=$_REQUEST['hasta'];
  $precio=$_REQUEST['precio'];
  $id_producto=$_REQUEST['id_producto'];
  $id_sucursal=$_SESSION['id_sucursal'];

  $table="presentacion_producto_precio";
  $form_data = array(
    'id_producto' => $id_producto,
    'id_presentacion' => $id_presentacion,
    'id_sucursal' => $id_sucursal,
    'precio' => $precio,
    'desde' => $desde,
    'hasta' => $hasta,
  );

  $insertar=_insert($table,$form_data);

  if ($insertar) {
    # code...
    _commit();
    $xdatos['typeinfo']="Success";
    $xdatos['msg']="Registro insertado correctamente";
  }
  else {
    # code..
    _rollback();
    $xdatos['typeinfo']="Error";
    $xdatos['msg']="Error no se pudo insertar el registro";
  }
  echo json_encode($xdatos);

}
function chan()
{
  $id_presentacion=$_REQUEST['id_presentacion'];

  $sql=_query("SELECT * FROM presentacion_producto_precio WHERE id_presentacion=$id_presentacion AND id_sucursal=$_SESSION[id_sucursal]");

  $tbody="";
  while ($row=_fetch_array($sql)) {
    # code...

    $tbody.="
    <tr>
      <td> $row[desde] <input type='hidden' class='id_prepp' value='$row[id_prepd]'> </td>
      <td> $row[hasta]</td>
      <td> $row[precio] </td>
      <td> <a class='btn del'><i class='fa fa-trash'></i></a> </td>
    </tr>
    ";

  }

  $xdatos['valores']=$tbody;
  echo json_encode($xdatos);
}

function del()
{
  $id_prepd=$_REQUEST['id_prepd'];

  $table="presentacion_producto_precio";
  $where_clause="id_prepd='".$id_prepd."'";
  $del=_delete($table,$where_clause);
  if ($del) {
    _commit();
    $xdatos['typeinfo']="Success";
    $xdatos['msg']="Registro Eliminado correctamente";

  }
  else {
    # code...
    _rollback();
    $xdatos['typeinfo']="Error";
    $xdatos['msg']="Error no se pudo eliminar el registro";
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
      insertar();
      break;

      case 'change':
      chan();
      break;

      case 'del':
      del();
      break;
    }
  }
}
?>
