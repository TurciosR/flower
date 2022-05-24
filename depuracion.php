<?php
include_once "_core.php";

function initial()
{
  $title = "Depuracion de productos";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';

  $_PAGE ['links'] .= '<link href="css/pagination.css" rel="stylesheet">';

  include_once "header.php";
  include_once "main_menu.php";
  $origen=0;
  if (isset($_REQUEST['id_origen'])) {
    $origen=$_REQUEST['id_origen'];
  }

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
          <?php if (true) { ?>
            <div class="ibox-content">
              <div class="ibox">
                <div class="row">
                  <div class="ibox-content">
                    <!--load datables estructure html-->
                    <header>
                      <h4 class="text-navy">Lista de Productos</h4>
                    </header>

                    <form id="frm1" class="" target="_self" action="agregar_asignacion.php" method="POST">
                      <input type="hidden" id="params" name="params" value="">
                      <input type="hidden" id="id_origen" name="id_origen" value="<?php echo $origen; ?>">
                      <input type="hidden" id="fecha" name="fecha" value="">
                      <input type="hidden" id="con" name="con" value="">
                    </form>

                  <div  class='widget-content' id="content">
                    <div class="row">
                  <div class="col-md-12">

                    <table class="table table-striped" id='loadtable'>
                      <thead class='thead1'>
                        <tr class='tr1'>
                          <th class="text-success col-lg-1">Id</th>
													<th class="text-success col-lg-1 text-center">Barcode</th>
                          <th class="text-success col-lg-5">Descripción</th>
                          <th class="text-success col-lg-1 text-center">Asignaciones</th>
                        </tr>
                      </thead>
                      <tbody class='tbody1 ' id="mostrardatos">
												<?php

												  	$sql_final = "SELECT * FROM producto WHERE estado != 0";
														$query = _query($sql_final);
													  $num_rows = _num_rows($query);
													  $filas=0;
													  if ($num_rows > 0)
													  {
													    while ($row = _fetch_array($query))
													    {
													      $id_producto = $row['id_producto'];
													      $descripcion=$row["descripcion"];
													      $barcode = $row['barcode'];

													      ?>
													      <tr>
													        <td class="col-lg-1" class="id_p"><?php echo $id_producto; ?></td>
													        <td class="col-lg-1" class="id_p"><?php echo $barcode; ?></td>
													        <td class='col-lg-5'><input type='hidden' class='unidad' value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
													        <td class='col-lg-1 text-center'> <input type="checkbox" class='form-control cheke' id='myCheckboxes' name='myCheckboxes' value='<?php echo $id_producto; ?>'></td>
													      </tr>
													      <?php
													      $filas+=1;
													    }
													  }
												?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--/div-->

              </div>
              <div id="paginador"></div>
                    <input type="hidden" name="process" id="process" value="insert"><br>
                    <div>
                      <input type="submit" id="btnCambio" name="btnCambio" value="Desactivar" class="btn btn-primary m-t-n-xs pull-right" />
                      <input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename ?> ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div><!--div class='ibox-content'-->
        </div>
      </div>
    </div>
  </div>
<?php
  include_once ("footer.php");
  echo "<script src='js/funciones/depuracion.js'></script>";
} //permiso del script
else
{
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
}
}
function depurar()
{
  $cuantos = $_POST["cuantos"];
  $array_Check = $_POST["myCheckboxes"];
  $array_c = json_decode($array_Check, true);
  $n = 0;
  foreach ($array_c as $fila)
  {
    $id_producto = $fila["id_producto"];
    $tabla = 'producto';
    $for_dta = array(
      'estado' => 0,
    );
    $wp = "id_producto='".$id_producto."'";
    $update = _update($tabla, $for_dta, $wp);
    if($update)
    {
      $n += 1;
    }
  }
  if($cuantos == $n)
  {
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Productos desactivados correctamente!';
  }
  else
  {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Algo fallo al intentar desactivar los productos!';
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
    case 'depurar':
    depurar();
    break;
  }
}
?>
