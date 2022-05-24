<?php
include("_core.php");
$title = 'Administrar Estantes';
$_PAGE = array();
$_PAGE ['title'] = $title;
$_PAGE ['links'] = null;
$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
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

$sql="SELECT e.id_estante, e.descripcion as estante, a.id_ubicacion, a.descripcion as ubicacion FROM estante as e, ubicacion as a WHERE a.id_ubicacion=e.id_ubicacion AND a.id_sucursal=$_SESSION[id_sucursal] ORDER BY ubicacion ASC";
$result=_query($sql);
$count=_num_rows($result);
//permiso del script
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
          echo "<div class='ibox-title'>";
          //permiso del script
          $filename='agregar_estante.php';
          $link=permission_usr($id_user, $filename);
          if ($link!='NOT' || $admin=='1') {
            echo "<a data-toggle='modal' href='agregar_estante.php' class='btn btn-primary' role='button' data-target='#viewModal' data-refresh='true'><i class='fa fa-plus icon-large'></i> Agregar Estante</a>";
          }
          echo "</div>"; ?>
          <div class="ibox-content">
            <!--load datables estructure html-->
            <header>
              <h4><?php echo $title; ?></h4>
            </header>
            <section>
              <table class="table table-striped table-bordered table-hover" id="editable">
                <thead>
                  <tr>
                    <th class="col-lg-2">Id</th>
                    <th class="col-lg-3">Ubicación</th>
                    <th class="col-lg-3">Estante</th>
                    <th class="col-lg-2">Posiciones</th>
                    <th class="col-lg-2">Acci&oacute;n</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row=_fetch_array($result))
                  {
                    $id_estante = $row["id_estante"];
                    $id_ubicacion = $row["id_ubicacion"];
                    $estante = $row["estante"];
                    $ubicacion = $row["ubicacion"];
                    $sql_aux = _query("SELECT * FROM posicion WHERE id_ubicacion = '$id_ubicacion' AND id_estante = '$id_estante'");
                    $npos = _num_rows($sql_aux);
                    echo "<tr>";
                    echo"<td>".$id_estante."</td>
                    <td>".$ubicacion."</td>
                    <td>".$estante."</td>
                    <td>".$npos."</td>";
                    echo"<td class='text-center'><div class='btn-group'>
                    <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
                    <ul class='dropdown-menu dropdown-primary'>";
                    $filename='editar_estante.php';
                    $link=permission_usr($id_user, $filename);
                    if ($link!='NOT' || $admin=='1') {
                      echo "<li><a data-toggle='modal' href='editar_estante.php?id_estante=$id_estante' data-target='#viewModal' data-refresh='true'><i class='fa fa-pencil'></i> Editar</a></li>";
                    }
                    $filename='borrar_estante.php';
                    $link=permission_usr($id_user, $filename);
                    if ($link!='NOT' || $admin=='1') {
                      echo "<li><a data-toggle='modal' href='borrar_estante.php?id_estante=$id_estante' data-target='#deleteModal' data-refresh='true'><i class='fa fa-eraser'></i> Eliminar</a></li>";
                    }
                    echo "</ul>
                    </div>
                    </td>
                    </tr>";
                  }
                  ?>
                </tbody>
              </table>
              <input type="hidden" name="autosave" id="autosave" value="false-0">
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
  include ("footer.php");
  echo" <script type='text/javascript' src='js/funciones/funciones_estante.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  include ("footer.php");
}
?>
