<?php
include ("_core.php");
function initial()
{
	$title = 'Administrar Sucursales';
	include_once "header.php";
	include_once "menu.php";

	$sql="SELECT s.id_sucursal, s.nombre as sucursal, s.direccion, c.nombre as cliente FROM sucursal as s, cliente as c WHERE s.id_cliente=c.id_cliente ORDER BY c.nombre ASC";
	$result=_query($sql);
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
					if ($links!='NOT' || $admin=='1' )
					{
						echo "<div class='ibox-title'>";
						//permiso del script
						$filename='agregar_sucursal.php';
						$link=permission_usr($id_user,$filename);
						if ($link!='NOT' || $admin=='1' )
						echo "<a data-toggle='modal' href='agregar_sucursal.php' class='btn btn-primary' role='button' data-target='#viewModal' data-refresh='true'><i class='fa fa-plus icon-large'></i> Agregar sucursal</a>";
						echo "</div>";

						?>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<header>
								<h4><?php echo $title; ?></h4>
							</header>
							<section>
								<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="editable">
									<thead>
										<tr>
											<th class="col-lg-1 text-primary font-bold">Id</th>
											<th class="col-lg-3 text-primary font-bold">Cliente</th>
											<th class="col-lg-3 text-primary font-bold">Nombre</th>
											<th class="col-lg-4 text-primary font-bold">Dirección</th>
											<th class="col-lg-1 text-primary font-bold">Acci&oacute;n</th>
										</tr>
									</thead>
									<tbody>
										<?php
										while($row=_fetch_array($result))
										{
												$id_sucursal = $row["id_sucursal"];
												$sucursal = $row["sucursal"];
												$direccion = $row["direccion"];
												$cliente = $row["cliente"];
												echo "<tr>";
												echo"<td>".$id_sucursal."</td>
												<td>".$cliente."</td>
												<td>".$sucursal."</td>
												<td>".$direccion."</td>";
												echo"<td class='text-center'><div class='btn-group'>
												<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
												<ul class='dropdown-menu dropdown-primary'>";
												$filename='local_sucursal.php';
												$link=permission_usr($id_user,$filename);
												if ($link!='NOT' || $admin=='1' )
												echo "<li><a data-toggle='modal' href='local_sucursal.php?id_sucursal=$id_sucursal' data-target='#viewModal' data-refresh='true'><i class='fa fa-home'></i> Locales</a></li>";
												$filename='editar_sucursal.php';
												$link=permission_usr($id_user,$filename);
												if ($link!='NOT' || $admin=='1' )
												echo "<li><a data-toggle='modal' href='editar_sucursal.php?id_sucursal=$id_sucursal' data-target='#viewModal' data-refresh='true'><i class='fa fa-pencil'></i> Editar</a></li>";
												$filename='borrar_sucursal.php';
												$link=permission_usr($id_user,$filename);
												if ($link!='NOT' || $admin=='1' )
												echo "<li><a id_sucursal='$id_sucursal' class='elim'><i class='fa fa-eraser'></i> Eliminar</a></li>";
												echo "	</ul>
												</div>
												</td>
												</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
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
			echo" <script type='text/javascript' src='js/funciones/funciones_sucursal.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include("footer.php");
		}
	}
	function eliminar_sucursal()
	{
		$id_sucursal = $_POST["id_sucursal"];
		$tabla ="sucursal";
		$where_clause = "id_sucursal='" . $id_sucursal . "'";
		$delete = _delete($tabla,$where_clause);
		if($delete)
		{
			$xdatos["typeinfo"]="Success";
			$xdatos["msg"]="Sucursal eliminada correctamente!";
		}
		else
		{
			$xdatos["typeinfo"]="Error";
			$xdatos["msg"]="Sucursal no pudo ser eliminada!"._error();
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
				case 'elim_sucursal':
				eliminar_sucursal();
				break;
			}
		}
	}
	?>
