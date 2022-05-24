<?php
include ("_core.php");
// Page setup
function initial() {


	$_PAGE = array ();
	$_PAGE ['title'] = 'Reporte Ticket del Dia';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_user = $_SESSION["id_usuario"];
	date_default_timezone_set('America/El_Salvador');
	$fecha_actual = date("Y-m-d");
	$hora_actual = date("H:i:s");
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
	if ($links!='NOT' || $admin=='1' ){
		?>

		<div class="wrapper wrapper-content  animated fadeInRight">
			<div class="row" id="row1">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-content">

              <header>
                <h4>Cortez Z por dia</h4>
              </header>
              <section>
                <form class="" target="_blank" action="reportez_pdf.php" method="get">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group has-info single-line">
                        <label>Fecha Inicio</label>
                        <input type="text"  class="form-control datepick" id="fini" name="fini" value="<?php echo date('Y-m-d');?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group has-info single-line">
                        <label>Fecha Fin</label>
                        <input type="text"  class="form-control datepick" id="ffin" name="ffin" value="<?php echo date('Y-m-d');?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <button type="submit"   class="btn btn-primary m-t-n-xs pull-right"><i class="fa fa-file-pdf-o"></i> Imprimir PDF</button>
                      </div>
                    </div>
                  </div>
                </form>
              </section>
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						</div><!--div class='ibox-content'-->
					</div><!--<div class='ibox float-e-margins' -->
					</div> <!--div class='col-lg-12'-->
				</div> <!--div class='row'-->
			</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
			<?php
			include("footer.php");
			echo" <script type='text/javascript' src='js/funciones/tike_dia.js'></script>";
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
		if(isset($_POST['process']))
		{
			switch ($_POST['process'])
			{
        default:
        break;
			}
		}
	}
	?>
