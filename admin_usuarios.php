<?php
	include ("_core.php");
	// Page setup
	$_PAGE = array ();
	$_PAGE ['title'] = 'Administrar Usuarios';
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";
	$id_sucur=$_SESSION["id_sucursal"];
	//permiso del script
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
				<?php
				echo"<div class='ibox-title'>";
				$filename='agregar_usuario.php';
				$link=permission_usr($id_user,$filename);
				if ($link!='NOT' || $admin=='1' )
				echo "<a href='agregar_usuario.php' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Usuario</a>";
				echo "</div>";

				?>
				<div class="ibox-content">
					<!--load datables estructure html-->
					<header>
						<h4>Administrar Pedido</h4>
					</header>
					<section>
						<table class="table table-striped table-bordered table-hover"id="editable">
							<thead>
								<tr>
									<th class="col-lg-1">Id</th>
									<th class="col-lg-5">Nombre</th>
									<th class="col-lg-5">Usuario</th>
									<th class="col-lg-1">Acci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$sql_u=_query("SELECT *FROM usuario WHERE id_sucursal='$id_sucur' AND id_usuario!=-1 ");
							while($row = _fetch_array($sql_u))
							{
								echo "<tr>";
								echo"<td>".$row['id_usuario']."</td>";
								echo"<td>".$row['nombre']."</td>
								<td>".$row['usuario']."</td>";
								echo"<td class='text-center'><div class='btn-group'>
								<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
								<ul class='dropdown-menu dropdown-primary'>";
								$filename='editar_usuario.php';
								$link=permission_usr($id_user,$filename);
								if ($link!='NOT' || $admin=='1' )
								echo "<li><a  href='editar_usuario.php?id_usuario=".$row['id_usuario']."' data-refresh='true'><i class='fa fa-pencil'></i> Editar</a></li>";
								$filename='permiso_usuario.php';
								$link=permission_usr($id_user,$filename);
								if ($link!='NOT' || $admin=='1' )
								echo "<li><a  href='permiso_usuario.php?id_usuario=".$row['id_usuario']."' data-refresh='true'><i class='fa fa-pencil'></i> Permiso</a></li>";
								$filename='borrar_usuario.php';
								$link=permission_usr($id_user,$filename);
								if ($link!='NOT' || $admin=='1' )
								{
								if($id_user==$row['id_usuario'])
								{
								}else{
									echo "<li><a data-toggle='modal' href='borrar_usuario.php?id_usuario=".$row['id_usuario']."' data-target='#deleteModal' data-refresh='true'><i class='fa fa-eraser'></i> Eliminar</a></li>";

								}
								}
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
							<div class='modal-content modal-md'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content modal-xm'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<!--Show Modal Popup View Fact -->
					<div class='modal fade' id='viewModalFact' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
						<div class='modal-dialog'>
							<div class='modal-content'></div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

               	</div><!--div class='ibox-content'-->
       		</div><!--<div class='ibox float-e-margins' -->
		</div> <!--div class='col-lg-12'-->
	</div> <!--div class='row'-->
</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
<?php
	include("footer.php");
	echo" <script type='text/javascript' src='js/funciones/funciones_usuario.js'></script>";
		} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
?>
