<?php
include_once "_core.php";

function initial() {


	$_PAGE = array ();
	$_PAGE ['title'] = 'Reporte de Ingresos y Egresos por Fechas';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';

	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";

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
                            <h5>Generación de Reportes por Productos</h5>
                        </div>
                        <div class="ibox-content">
                              <form name="formulario" id="formulario" method="GET" action="ver_reporte_entrada_salida.php" target="_blank">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group has-info single-line"><label>Fecha Inicio</label> <input type="text" placeholder="Fecha Inicio" class="datepick form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo date("Y-m-d");?>"></div>
                                </div>
                                 <div class="col-md-4">
                                  <div class="form-group has-info single-line"><label>Fecha Fin</label> <input type="text" placeholder="Fecha Fin" class="datepick form-control" id="fecha_fin" name="fecha_fin" value="<?php echo date("Y-m-d");?>"></div>
                                </div>

                              </div>


                                <div>
                                  <input type="submit" name="submit1" value="Generar" class="btn btn-primary m-t-n-xs" />
                                </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


<?php
include_once ("footer.php");
//echo "<script src='js/plugins/typehead/bootstrap3-typeahead.js'></script>";
//echo "<script src='js/funciones/reporte_productos.js'></script>";
}

if(!isset($_POST['process'])){
	initial();
}
else
{
if(isset($_POST['process'])){
switch ($_POST['process']) {
	case 'insert':
		insertar();
		break;

	}
}
}
?>
