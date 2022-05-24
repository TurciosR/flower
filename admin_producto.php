<?php
include ("_core.php");
// Page setup
function initial()
{
$title='Administrar Productos';
$_PAGE = array ();
$_PAGE ['title'] = $title;
$_PAGE ['links'] = null;
$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
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
	<div class="row" id="row1">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php
				if ($links!='NOT' || $admin=='1' ){

					echo "<div class='ibox-title'>";
					$filename='agregar_producto.php';
					$link=permission_usr($id_user,$filename);
					if ($link!='NOT' || $admin=='1' )
					echo "<a href='agregar_producto.php' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Producto</a>";


					echo	"</div>";

					?>
					<div class="ibox-content">
						<!--load datables estructure html-->
						<header>
							<h4><?php echo $title; ?></h4>
						</header>
						<section>
							<table class="table table-striped table-bordered table-hover" id="editable2">
								<thead>
									<tr>
										<th class="col-lg-1">Id</th>
										<th class="col-lg-1">CodArt</th>
										<th class="col-lg-1">Barcode</th>
										<th class="col-lg-3">Descripcion</th>
										<th class="col-lg-2">Categoria</th>
										<th class="col-lg-2">Proveedor</th>
										<th class="col-lg-1">Exento</th>
										<th class="col-lg-1">Estado</th>
										<th class="col-lg-1">Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
							<input type="hidden" name="autosave" id="autosave" value="false-0">
						</section>
						<!--Show Modal Popups View & Delete -->
						<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog'>
								<div class='modal-content'></div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
						<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							<div class='modal-dialog modal-sm'>
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
		echo" <script type='text/javascript' src='js/funciones/funciones_producto.js'></script>";
		?>
		<script type="text/javascript">
		$(document).on('hidden.bs.modal', function(e) {
			var target = $(e.target);
			target.removeData('bs.modal').find(".modal-content").html('');
		});
		</script>
		<?php


	}
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include ("footer.php");
	}
}

function estado_producto() {
	$id_producto = $_POST ['id_producto'];
	$estado = $_POST["estado"];
	if($estado == 1)
	{
		$n = 0;
	}
	else
	{
		$n = 1;
	}
	$table = 'producto';
	$id_sucursal = $_SESSION["id_sucursal"];
	$form_data = array(
		'estado' => $n,
	);
	$where_clause = "id_producto='".$id_producto."'";
	$delete = _update ( $table, $form_data, $where_clause );
	if ($delete)
	{
		$xdatos ['typeinfo'] = 'Success';
		$xdatos ['msg'] = 'Registro actualizado con exito!';
	}
	else
	{
		$xdatos ['typeinfo'] = 'Error';
		$xdatos ['msg'] = 'Registro no pudo ser actualizado!';
	}
	echo json_encode ( $xdatos );
}

if (!isset($_POST['process'])) {
    initial();
} else {
    if (isset($_POST['process'])) {
        switch ($_POST['process']) {
            case 'insert':
            insertar();
            break;
            case 'lista':
            lista();
            break;
            case 'insert_img':
        		insert_img();
        		break;
						case 'estado':
        		estado_producto();
        		break;
        }
    }
}
?>
