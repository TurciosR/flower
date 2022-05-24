<?php
include ("_core.php");
// Page setup
$title='Administrar Presentaciones';
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
include_once "header.php";
include_once "main_menu.php";

$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);

$sql="SELECT * FROM presentacion ORDER BY nombre ASC";
$result=_query($sql);
?>
<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row" id="row1">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php
				if($links != 'NOT' || $admin == '1'){
				echo"<div class='ibox-title'>";
				$filename='agregar_presentacion.php';
				$link=permission_usr($id_user,$filename);
				if ($link!='NOT' || $admin=='1' )
				echo "<a  data-toggle='modal' href='agregar_presentacion.php' class='btn btn-primary' role='button' data-target='#viewModal' data-refresh='true'><i class='fa fa-plus icon-large'></i> Agregar Presentación</a>";
				echo "</div>";
				?>
				<div class="ibox-content">
					<!--load datables estructure html-->
					<header>
						<h4><?php echo $title; ?></h4>
					</header>
					<section>
						<table class="table table-striped table-bordered table-hover"id="editable">
							<thead>
								<tr>
									<th class="col-lg-1">Id</th>
									<th class="col-lg-4">Nombre</th>
									<th class="col-lg-4">Descripción</th>
									<th class="col-lg-1">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								while($row=_fetch_array($result))
								{
									echo "<tr>";
									echo"<td>".$row['id_presentacion']."</td>
									<td>".$row['nombre']."</td>
									<td>".$row['descripcion']."</td>
									";
									echo"<td><div class='btn-group'>
									<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
									<ul class='dropdown-menu dropdown-primary'>";
									$filename='editar_presentacion.php';
									$link=permission_usr($id_user,$filename);
									if ($link!='NOT' || $admin=='1' )
									echo"<li><a data-toggle='modal' href=\"editar_presentacion.php?id_presentacion=".$row['id_presentacion']."\" data-target='#viewModal' data-refresh='true'><i class=\"fa fa-pencil\"></i> Editar</a></li>";
									$filename='borrar_presentacion.php';
									$link=permission_usr($id_user,$filename);
									if ($link!='NOT' || $admin=='1' )
									//echo "<li><a data-toggle='modal' href='borrar_presentacion.php?id_presentacion=".$row ['id_presentacion']."&process=formDelete"."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-eraser\"></i> Eliminar</a></li>";
									echo "	</ul>
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
							<div class='modal-content'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<div class='modal fade' id='viewModal2'  role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
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
	include ("footer.php");
	echo" <script type='text/javascript' src='js/funciones/funciones_presentacion.js'></script>";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include ("footer.php");
	}
	?>
