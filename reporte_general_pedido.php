<?php
include_once "_core.php";

function initial() {
	// Page setup
	$id_user=$_SESSION["id_usuario"];

	$_PAGE = array ();
	$_PAGE ['title'] = 'Reporte Pedido';
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
  $_PAGE ['links'] .= '<link href="css/plugins/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";
	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user, $filename);


	//permiso del script
	if ($links!='NOT' || $admin=='1' ){
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
                            <h5>Reporte Pedido</h5>
                        </div>
                        <div class="ibox-content">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group has-info single-line">
																<label>Pedidos <span style="color:red;">*</span></label>
																<select class="col-md-12 select2" id="tipo_pedido" name="tipo_pedido">
																	<option value="todos">Todos</option>
																	<option value="pendiente">Pendientes</option>
																	<option value="anulado">Anulados</option>
																	<option value="finalizado">Finalizados</option>
																</select>
															</div>
														</div>
													</div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group has-info single-line">
                                  <label>Fecha Inicio</label>
                                  <input type="text" class="form-control datepick" id="fini" name="fini" value="<?php echo date('Y-m-01');?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group has-info single-line">
                                  <label>Fecha Fin</label>
                                  <input type="text" class="form-control datepick" id="ffin" name="ffin" value="<?php echo date('Y-m-d');?>">
                                </div>
                              </div>
                            </div>
                  				  <input type="hidden" name="process" id="process" value="imprime_pedi_todo">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <input type="hidden" name="id_sucursal" id="id_sucursal">
                                  <input type="submit" id="submit1" name="submit1" value="Imprimir" class="btn btn-primary m-t-n-xs pull-right" />
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php
include_once ("footer.php");
echo "<script src='js/funciones/funciones_reporte_general.js'></script>";
		} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
		include_once ("footer.php");
	}
}



if(!isset($_POST['process'])){
	initial();
}
else
{
if(isset($_POST['process'])){
switch ($_POST['process']) {
	case 'edit':
		//insertar_empresa();
    editar();
		break;

	}
}
}
?>
