<?php
include ("_core.php");
// Page setup
$_PAGE = array ();
$title = "Administrar Empleados";
$_PAGE ['title'] = $title;
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
$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
include_once "header.php";
include_once "main_menu.php";

$id_sucursal = $_SESSION["id_sucursal"];
$sql="SELECT e.*, te.descripcion FROM empleado AS e, tipo_empleado AS te WHERE e.id_tipo_empleado=te.id_tipo_empleado AND id_sucursal='$id_sucursal' ORDER BY e.nombre ASC, e.apellido ASC";
$result=_query($sql);

//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);
//permiso del script
?>

<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row" id="row1">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php
				if ($links!='NOT' || $admin=='1' ) {
					echo "<div class='ibox-title'>";
					//permiso del script
					$filename='agregar_tipo_empleado.php';
					$link=permission_usr($id_user,$filename);
					if ($link!='NOT' || $admin=='1' )
					echo "<a href='agregar_empleado.php' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Empleado</a>";
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
										<th class="col-lg-1">Id </th>
										<th class="col-lg-4">Nombre</th>
										<th class="col-lg-2">Tipo</th>
										<th class="col-lg-2">Telefonos</th>
										<th class="col-lg-2">Correo</th>
										<th class="col-lg-1">Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<?php
									while($row=_fetch_array($result))
									{
										$contacto=$row['nombre']."  ".$row['apellido'];
										$telefonos=$row['telefono1']." -- ".$row['telefono2'];
										$salariobase=$row['salariobase'];
										$correo=$row['email'];
										$tipo=$row['descripcion'];
										echo "<tr>";
										echo"<td>".$row['id_empleado']."</td>
										<td>".$contacto."</td>
										<td>".$tipo."</td>
										<td>".$telefonos."</td>
										<td>".$correo."</td>";
										echo"<td><div class=\"btn-group\">
										<a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
										<ul class=\"dropdown-menu dropdown-primary\">";
										$filename='editar_empleado.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
										echo "<li><a href=\"editar_empleado.php?id_empleado=".$row['id_empleado']."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
										$filename='borrar_empleado.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
										echo "<li><a data-toggle='modal' href='borrar_empleado.php?id_empleado=" .  $row ['id_empleado']."&process=formDelete"."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-eraser\"></i> Eliminar</a></li>";
										$filename='ver_empleado.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
										echo "<li><a data-toggle='modal' href='ver_empleado.php?id_empleado=".$row['id_empleado']."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
										echo "</ul>
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
							<div class='modal-dialog modal-md'>
								<div class='modal-content modal-md'></div><!-- /.modal-content -->
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
		echo" <script type='text/javascript' src='js/funciones/funciones_empleado.js'></script>";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include_once ("footer.php");
	}
	?>
