<?php
include_once "_core.php";

function initial() {
	// Page setup
	$id_user=$_SESSION["id_usuario"];

	$_PAGE = array ();
	$_PAGE ['title'] = 'Reporte Productos y Precios';
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
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Reporte Productos y Precios</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
															<div class="col-lg-6">
																<label>Tipo</label>
																<select id="tipo" style="width:100%;" class="" name="">
																	<option value="1">Exento</option>
																	<option value="0">Gravados</option>
																</select>
															</div>
															<div class="col-lg-6">
																<label>Mostrar hasta</label>
																<select id="precios" style="width:100%;" class="" name="">
																	<option value="1">Precio 1</option>
																	<option value="2">Precio 2</option>
																	<option value="3">Precio 3</option>
																	<option value="4">Precio 4</option>
																</select>
															</div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <input type="hidden" name="id_sucursal" id="id_sucursal">
																	<!--
                                  <button type="submit" id="btn_excel_IN" name="btn_excel"  class="btn btn-primary m-t-n-xs pull-right" style="margin-left:10px"><i class="fa fa-file-excel-o"></i> Imprimir Excel</button>
																	-->
																	<br>
                                  <button type="submit" id="submit1" name="submit1" class="btn btn-primary m-t-n-xs pull-right"><i class="fa fa-file-pdf-o"></i> Imprimir PDF</button>
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
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#tipo").select2();
	$("#precios").select2();

	$(document).on('click', '#submit1', function(event) {

		exento = $("#tipo").val();
		precios = $("#precios").val();
		var cadena = 'reporte_producto_precios.php?exento='+exento+"&precios="+precios;
		window.open(cadena, "", "");

	});
});
</script>
<?php
		} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
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
