<?php
include_once "_core.php";

function initial()
{
	$_PAGE = array ();
	$_PAGE ['title'] = 'Editar Caja';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";
  $id_caja = $_REQUEST["id_caja"];
  $sql_caja = _query("SELECT * FROM caja WHERE id_caja = '$id_caja'");
  $row = _fetch_array($sql_caja);
  $nombre = $row["nombre"];
  $serie = $row["serie"];
  $desde = $row["desde"];
  $resolucion = $row["resolucion"];
  $fecha = $row["fecha"];
  $hasta = $row["hasta"];
  $id_sucursal = $row["id_sucursal"];

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri=$_SERVER['REQUEST_URI'];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
	if ($links!='NOT' || $admin=='1' )
	{
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Editar Caja</h5>
                        </div>
                        <div class="ibox-content">
                              <form name="formulario" id="formulario">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group has-info single-line">
                                      <label>Nombre:</label>
                                      <input type="text" class="form-control" name="name_caja" id="name_caja" value="<?php echo $nombre;?>">
																			<input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal;?>">
                                    </div>
                                  </div>
                                	<div class="col-md-6">
	                                  <div class="form-group has-info single-line">
	                                    <label>Serie:</label>
	                                    <input type="text" class="form-control" name="serie" id="serie" value="<?php echo $serie;?>">
	                                  </div>
	                                </div>

                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group has-info single-line">
                                      <label>Resolución:</label>
                                      <input type="text" class="form-control" name="resolucion" id="resolucion" value="<?php echo $resolucion;?>">
                                    </div>
                                  </div>
																	<div class="col-md-6">
	                                  <div class="form-group has-info single-line">
	                                    <label>Fecha de Resolución:</label>
	                                    <input type="text" class="form-control datepick" name="fecha" id="fecha" value="<?php echo $fecha;?>">
	                                  </div>
	                                </div>
                                </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                      <label class="control-label" for="observaciones">Desde:</label>
                                      <input type="text" id="desde" name="desde" class="form-control numeric" value="<?php echo $desde;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                      <label class="control-label" for="observaciones">Hasta:</label>
                                      <input type="text" id="hasta" name="hasta" class="form-control numeric" value="<?php echo $hasta;?>">
                                  </div>
                                </div>
                              </div>

                                    <input type="hidden" name="process" id="process" value="editar"><br>
                                    <input type="hidden" name="id_caja" id="id_caja" value="<?php echo $id_caja;?>"><br>
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
echo "<script src='js/funciones/funciones_caja.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}
function editar()
{
  $nombre_caja = $_POST["nombre_caja"];
  $serie = $_POST["serie"];
  $desde = $_POST["desde"];
  $hasta = $_POST["hasta"];
  $resolucion = $_POST["resolucion"];
  $fecha = $_POST["fecha"];
  $hasta = $_POST["hasta"];
  $id_caja = $_POST["id_caja"];

  $sql_caja = _query("SELECT * FROM caja WHERE nombre = '$nombre_caja' AND id_caja != '$id_caja'");
  $cuenta = _num_rows($sql_caja);
  if($cuenta == 0)
  {
    $table = 'caja';
    $form_caja = array(
      'nombre' => $nombre_caja,
      'serie' => $serie,
      'desde' => $desde,
      'resolucion' => $resolucion,
      'fecha' => $fecha,
      'hasta' => $hasta,
    );
    $where = "id_caja='".$id_caja."'";
    $update = _update($table, $form_caja, $where);
    if($update)
    {
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Registro editado con exito!';
      $xdatos['process']='insert';
    }
    else
    {
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Error al editar el registro !'._error();
    }
  }
  else
  {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Ya existe un registro con ese mismo nombre !';
  }
  echo json_encode($xdatos);
}

if(!isset($_POST['process'])){
	initial();
}
else
{
if(isset($_POST['process'])){
switch ($_POST['process']) {
	case 'editar':
		editar();
		break;

	}
}
}
?>
