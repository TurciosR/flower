<?php
include ("_core.php");
// Page setup
$title =  'Administrar Cuentas de Banco';
$_PAGE = array ();
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
$id_banco = $_REQUEST["id_banco"];
$sql="SELECT * FROM cuenta_banco WHERE id_banco='$id_banco'";
$sql1=_query("SELECT * FROM banco WHERE id_banco='$id_banco'");
$datos = _fetch_array($sql1);
$nombre = $datos["nombre"];
$logo = $datos["logo"];
if($logo == "")
{
	$logo = "img/place.png";
}

$result=_query($sql);
$count=_num_rows($result);

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
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6">
							<label><?php echo $nombre; ?></label>
						</div>
						<div class="col-lg-6">
							<img src="<?php echo $logo; ?>" style="width: 30%;" class='pull-right'>
						</div>
					</div>
				</div>
				<?php
				//permiso del script
				if ($links!='NOT' || $admin=='1' ){
					echo"<div class='ibox-title'>";
					$filename='agregar_cuenta_banco.php';
					$link=permission_usr($id_user,$filename);
					if ($link!='NOT' || $admin=='1' )
					echo "<a href='agregar_cuenta_banco.php?id_banco=$id_banco' data-toggle='modal' data-target='#viewModal' data-refresh='true' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Cuenta</a>";
					echo "</div>";

					?>
					<div class="ibox-content">
						<!--load datables estructure html-->
						<header>
							<h4><?php echo  $title; ?></h4>
						</header>
						<section>
							<table class="table table-striped table-bordered table-hover "id="editable">
								<thead>
									<tr>
										<th class="col-lg-2">Id</th>
										<th class="col-lg-5">Nombre</th>
										<th class="col-lg-4">Número</th>
										<th class="col-lg-1">Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<?php
									while($row=_fetch_array($result))
									{
										$id_cuenta = $row['id_cuenta'];
										$nombre=$row['nombre_cuenta'];
										$numero=$row['numero_cuenta'];

										echo "<tr>";
										echo"<td>".$id_cuenta."</td>
										<td>".$nombre."</td>
										<td>".$numero."</td>";

										echo"<td><div class=\"btn-group\">
										<a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
										<ul class=\"dropdown-menu dropdown-primary\">";
										$filename='editar_cuenta_banco.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
										echo "<li><a href=\"editar_cuenta_banco.php?id_cuenta=".$id_cuenta."&id_banco=".$id_banco."\" data-toggle='modal' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-pencil\"></i> Editar</a></li>";
										$filename='borrar_cuenta_banco.php';
										$link=permission_usr($id_user,$filename);
										if ($link!='NOT' || $admin=='1' )
										echo "<li><a data-toggle='modal' href='borrar_cuenta_banco.php?id_cuenta=".$id_cuenta."&id_banco=".$id_banco."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-eraser\"></i> Eliminar</a></li>";
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
		echo" <script type='text/javascript' src='js/funciones/funciones_cuenta_banco.js'></script>";
	} //permiso del script
	else
	{
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
		include ("footer.php");
	}
	?>
