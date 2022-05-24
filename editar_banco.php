<?php
include_once "_core.php";
function initial()
{
  $title = 'Editar Banco';
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

  include_once "header.php";
  include_once "main_menu.php";
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);

  $id_banco = $_REQUEST["id_banco"];
  $id_sucursal = $_SESSION["id_sucursal"];
  $sql = _query("SELECT * FROM banco WHERE id_banco='$id_banco' AND id_sucursal='$id_sucursal'");
  $datos = _fetch_array($sql);

  $nombre = $datos["nombre"];
  $logo = $datos["logo"];

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
            <div class="ibox-content">
              <form name="formulario" id="formulario">
                <div class="form-group has-info single-line">
                  <label>Nombre  <span style="color:red;">*</span></label>
                  <input type="text" placeholder="Nombre del Banco" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                </div>
                <div class="form-group has-info single-line">
                  <label>Logo <span style="color:red;">*</span></label>
                  <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
                </div>
                <div class="form-group has-info single-line text-center">
                  <?php
                  if($logo != "")
                  {
                    echo "<img style='width: 40%' src='".$logo."'>";
                  }
                  ?>
                </div>
                <input type="hidden" name="img_logo" id="img_logo" value="<?php echo $logo; ?>">
                <input type="hidden" name="id_banco" id="id_banco" value="<?php echo $id_banco; ?>">
                <input type="hidden" name="process" id="process" value="edit"><br>
                <div>
                  <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_banco.js'></script>";
    echo " <script src='js/plugins/fileinput/fileinput.js'></script>";

  } //permiso del script
  else
  {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
    include_once ("footer.php");
  }
}
function insertar()
{
  require_once 'class.upload.php';
  $id_banco=$_POST["id_banco"];
  $nombre=$_POST["nombre"];
  $logo=$_POST["img_logo"];

  $sql_exis=_query("SELECT id_banco FROM banco WHERE nombre='$nombre' AND id_banco != '$id_banco'");
  $num_exis = _num_rows($sql_exis);
  if($num_exis > 0)
  {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Ya se registro un banco con estos datos!';
  }
  else
  {
    if ($_FILES["logo"]["name"]!="")
    {
      $foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
      if ($foo->uploaded)
      {
        $pref = uniqid()."_";
        $foo->file_force_extension = false;
        $foo->no_script = false;
        $foo->file_name_body_pre = $pref;
        // save uploaded image with no changes
        $foo->Process('img/');
        if ($foo->processed)
        {
          $query = _query("SELECT logo FROM banco WHERE id_banco='$id_banco'");
          $result = _fetch_array($query);
          $urlb=$result["logo"];
          if($urlb!="" && file_exists($urlb))
          {
            unlink($urlb);
          }
          $cuerpo=quitar_tildes($foo->file_src_name_body);
          $cuerpo=trim($cuerpo);
          $logo = 'img/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
        }
      }
    }
    $table = 'banco';
    $form_data = array(
      'nombre' => $nombre,
      'logo' => $logo,
    );
    $where = "id_banco='".$id_banco."'";
    $upadte = _update($table,$form_data,$where);
    if($upadte)
    {
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Registro modificado con exito!';
      $xdatos['process']='insert';
    }
    else
    {
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Registro no pudo ser modificado!';
    }
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
      case 'edit':
      insertar();
      break;
    }
  }
}
?>
