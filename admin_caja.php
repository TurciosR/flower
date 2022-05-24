<?php
	include ("_core.php");
	// Page setup
  function initial(){
	$_PAGE = array ();
	$title='Administrar Cajas';
	$_PAGE ['title'] = $title;
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
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);

	$fechahoy=date("Y-m-d");
	$fechaanterior=restar_dias($fechahoy,30);
?>

	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
				$filename='facturacion.php';
				$link=permission_usr($id_user,$filename);
				//permiso del script
						if ($links!='NOT' || $admin=='1' ){
						echo"
                        <div class='ibox-title'>
													<h4>$title</h4>
                        </div>";
                        ?>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<section>
								<table class="table table-striped table-bordered table-hover" id="editable">
									<thead>
										<tr>
											<th class="col-lg-1">Id </th>
											<th class="col-lg-2">Nombre</th>
											<th class="col-lg-1">Resolución</th>
											<th class="col-lg-1">Fecha</th>
											<th class="col-lg-1">Serie</th>
											<th class="col-lg-1">Desde</th>
											<th class="col-lg-1">Hasta</th>
											<th class="col-lg-1">Estado</th>
											<th class="col-lg-1">Acci&oacute;n</th>
										</tr>
									</thead>
									<tbody>
                    <?php
                      $sql_caja = _query("SELECT * FROM caja WHERE id_sucursal=$_SESSION[id_sucursal]");
                      $cuenta = _num_rows($sql_caja);
                      if($cuenta > 0)
                      {
                        while($row = _fetch_array($sql_caja))
                        {
                          $id_caja = $row["id_caja"];
                          $nombre = $row["nombre"];
                          $serie = $row["serie"];
                          $resolucion = $row["resolucion"];
                          $desde = $row["desde"];
                          $fecha = $row["fecha"];
                          $hasta = $row["hasta"];
                          $estado = $row["activa"];
                          if($estado == 1)
                          {
                            $text = "Activa";
                            $text1 = "Desactivar";
                            $fa = "fa fa-eye-slash";
                          }
                          else
                          {
                            $text = "Inactiva";
                            $text1 = "Activar";
                            $fa = "fa fa-eye";
                          }

                          echo "<tr>";
                          echo "<td><input type='hidden' id='id_caja' value='".$id_caja."'>".$id_caja."</td>";
                          echo "<td>".$nombre."</td>";
                          echo "<td>".$resolucion."</td>";
                          echo "<td>".ED($fecha)."</td>";
                          echo "<td>".$serie."</td>";
                          echo "<td>".$desde."</td>";
                          echo "<td>".$hasta."</td>";
                          echo "<td><input type='hidden' id='estado1' value='".$estado."'>".$text."</td>";

                          echo"<td>
                          <div class=\"btn-group\">
      										  <a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
        										<ul class=\"dropdown-menu dropdown-primary\">";
          										$filename='editar_proveedor.php';
          										$link=permission_usr($id_user,$filename);
          										if ($link!='NOT' || $admin=='1' )
          										echo "<li><a href=\"editar_caja.php?id_caja=".$id_caja."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";

          										$filename='borrar_proveedor.php';
          										$link=permission_usr($id_user,$filename);
          										if ($link!='NOT' || $admin=='1' )
          										echo "<li><a id='estado' ><i class='".$fa."'></i> ".$text1."</a></li>";

          										//$filename='ver_proveedor.php';
          										//$link=permission_usr($id_user,$filename);
          										//if ($link!='NOT' || $admin=='1' )
          										//echo "<li><a data-toggle='modal' href='ver_.php?id_caja=".$id_caja."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";

        										echo "
                            </ul>
      										</div>
      										</td>
      										</tr>";
                        }
                      }
                    ?>
                  </tbody>
								</table>
								<input type="hidden" name="autosave" id="autosave" value="false-0">
							</section>
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
							<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade' id='viewModalFact' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-md'></div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->

						</div>
						<!--div class='ibox-content'-->
				</div>
				<!--<div class='ibox float-e-margins' -->
			</div>
			<!--div class='col-lg-12'-->
		</div>
		<!--div class='row'-->
	</div>
	<!--div class='wrapper wrapper-content  animated fadeInRight'-->
	<?php
	include("footer.php");
	echo" <script type='text/javascript' src='js/funciones/funciones_caja.js'></script>";
		} //permiso del script
else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div><div></div><div></div>";
	}
}
function estado_caja() {
	$id_caja = $_POST ['id_caja'];
	$estado = $_POST["estado"];
	if($estado == 1)
	{
		$n = 0;
	}
	else
	{
		$n = 1;
	}
	$table = 'caja';
	$id_sucursal = $_SESSION["id_sucursal"];
	$form_data = array(
		'activa' => $n,
	);
	$where_clause = "id_caja='".$id_caja."' AND id_sucursal='".$id_sucursal."'";
  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE caja = '$id_caja' AND vigente = 1");
  $cuenta_caja = _num_rows($sql_apertura);
  if($cuenta_caja == 0)
  {
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
  }
  else
  {
    $xdatos ['typeinfo'] = 'Error';
    $xdatos ['msg'] = 'Esta caja esta en uso en este momento!';
  }

	echo json_encode ( $xdatos );
}
if (! isset ( $_REQUEST ['process'] ))
{
  initial();
}
else
{
  if (isset ( $_REQUEST ['process'] ))
  {
    switch ($_REQUEST ['process'])
    {
      case 'formDelete' :
        initial();
        break;
        case 'estado' :
        estado_caja();
        break;
    }
  }
}
?>
