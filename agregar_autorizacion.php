<?php
include_once "_core.php";
function initial()
{
  $title = 'Agregar Autorizacion';
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
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';

  include_once "header.php";
  include_once "main_menu.php";
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);

  ?>

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
            <div class="ibox-content">
              <form name="formulario" id="formulario">
                <div class="row">
                  <div class="col-lg-3">
                    <label>Seleccione el precio a autorizar</label>
                    <select class="form-control select" name="precio" id="precio">
                      <?php
                      for ($i=2; $i<8; $i++)
                      {
                        echo "<option value='$i'";

                        echo ">Precio $i</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <br>
                    <button class="btn btn-primary" type="button" name="button" id="guardar">Guardar</button>
                  </div>
                </div>
                <input type="hidden" name="process" id="process" value="insert"><br>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_autorizacion.js'></script>";
  } //permiso del script
  else
  {
    echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
  }
}

function insertar()
{
  _begin();
  $precio = $_REQUEST['precio'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $id_usuario = $_SESSION['id_usuario'];
  $clave = generarclave(6);

  $table='precio_aut';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'clave' => $clave,
    'aplicado' => 0,
    'fecha_generado' => date("Y-m-d"),
    'precio' => $precio,
    'id_server' => '0',
    'id_usuario' => $id_usuario,
    'fecha_aplicado' => date("Y-m-d")
  );

  $insertar = _insert($table,$form_data );
  if($insertar)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['clave']=$clave;
    $xdatos['msg']='Registro guardado con exito!';
    $xdatos['process']='insert';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro no pudo ser guardado !'._error();
  }

  echo json_encode($xdatos);
}

function generarclave($longitud)
{
  // code...
  $key = '';
  while ($key=='') {
    // code...
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
    $max = strlen($pattern)-1;
    for($i=0;$i < $longitud;$i++){
        $key .= $pattern[mt_rand(0,$max)];
    }
    $sql = _query("SELECT * FROM precio_aut where clave='$key'");

    if(!_num_rows($sql)==0)
    {
      $key='';
    }
  }

  return $key;
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
    }
  }
}
?>
