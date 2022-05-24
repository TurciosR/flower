<?php
include ("_core.php");
function initial()
{
	$title = 'Administrar Vendedores';
	include_once "header.php";
	include_once "menu.php";

	$sql="SELECT s.id_vendedor, s.nombre as vendedor, s.direccion, c.nombre as cliente FROM vendedor as s, cliente as c WHERE s.id_cliente=c.id_cliente ORDER BY c.nombre ASC";
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
						$filename='agregar_vendedor.php';
						$link=permission_usr($id_user,$filename);
						if ($link!='NOT' || $admin=='1' )
						echo "<a data-toggle='modal' href='agregar_vendedor.php' class='btn btn-primary' role='button' data-target='#viewModal' data-refresh='true'><i class='fa fa-plus icon-large'></i> Agregar Vendedor</a>";
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
												$id_vendedor = $row["id_vendedor"];
												$vendedor = $row["vendedor"];
												$direccion = $row["direccion"];
												$cliente = $row["cliente"];
												echo "<tr>";
												echo"<td>".$id_vendedor."</td>
												<td>".$cliente."</td>
												<td>".$vendedor."</td>
												<td>".$direccion."</td>";
												echo"<td class='text-center'><div class='btn-group'>
												<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
												<ul class='dropdown-menu dropdown-primary'>";
												$filename='editar_vendedor.php';
												$link=permission_usr($id_user,$filename);
												if ($link!='NOT' || $admin=='1' )
												echo "<li><a data-toggle='modal' href='editar_vendedor.php?id_vendedor=$id_vendedor' data-target='#viewModal' data-refresh='true'><i class='fa fa-pencil'></i> Editar</a></li>";
												$filename='borrar_vendedor.php';
												$link=permission_usr($id_user,$filename);
												if ($link!='NOT' || $admin=='1' )
												echo "<li><a id_vendedor='$id_vendedor' class='elim'><i class='fa fa-eraser'></i> Eliminar</a></li>";
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
			echo" <script type='text/javascript' src='js/funciones/funciones_vendedor.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include("footer.php");
		}
	}
	function eliminar_vendedor()
	{
		$id_vendedor = $_POST["id_vendedor"];
		$tabla ="vendedor";
		$where_clause = "id_vendedor='" . $id_vendedor . "'";
		$delete = _delete($tabla,$where_clause);
		if($delete)
		{
			$xdatos["typeinfo"]="Success";
			$xdatos["msg"]="vendedor eliminada correctamente!";
		}
		else
		{
			$xdatos["typeinfo"]="Error";
			$xdatos["msg"]="vendedor no pudo ser eliminada!"._error();
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
				case 'elim_vendedor':
				eliminar_vendedor();
				break;
			}
		}
	}
	?>
