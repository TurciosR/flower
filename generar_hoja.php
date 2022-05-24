<?php
include_once "_core.php";

function initial()
{
  $title = "Generar hoja de conteo";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
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

  include_once "header.php";
  include_once "main_menu.php";

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

  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2"></div>
  </div>
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <h5><?php echo $title;?></h5>
          </div>
          <?php if ($links!='NOT' || $admin=='1') { ?>
            <div class="ibox-content">



              <div class="row" id='buscador'>
                <form id="frm1" class="" target="_blank" action="hoja_conteo.php" method="post">
                  <input type="hidden" id="params" name="params" value="a">
                  <input type="hidden" id="cu" name="cu" value="a">
                <div class="col-lg-4">
                  <div class="form-group has-info">
                    <label>Origen</label>
                    <select class="form-control select" id="destino" name="destino">
                      <?php
                      $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group has-info">
                    <label>Categoría</label>
                    <select class="form-control select" id="categoria" name="categoria">
                      <option value="">NINGUNA</option>
                      <?php
                      $sql = _query("SELECT * FROM categoria ORDER BY nombre_cat ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_categoria"]."'>".$row["nombre_cat"]."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-2  ">

                </div>
                <div class="col-lg-2">
                  <?php
                  $filename='hoja_conteo.php';
                  $link=permission_usr($id_user,$filename);
                  if ($link!='NOT' || $admin=='1' )
                  ?>
                  <label>Hoja de Conteo</label>
                  <button type="button" class="btn btn-info form-control" id="generar" name="generar">Generar</button>
                  <?php
                   ?>
                </div>
              </form>
              </div>
          </div><!--div class='ibox-content'-->
        </div>
      </div>
    </div>
  </div>

  <?php
  include_once ("footer.php");
  echo "<script src='js/funciones/funciones_generar_hoja.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  include_once ("footer.php");
}
}

if (!isset($_REQUEST['process']))
{
  initial();
}
if (isset($_REQUEST['process']))
{
}
?>
