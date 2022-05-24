<?php
include ("_core.php");
// Page setup
function initial()
{
	$title =  'Actualización de Precios';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
	include_once "header.php";
	include_once "main_menu.php";

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	$a = date("Y");
	$m = date("m");
	$fin = $a."-".$m."-01";
	$fini = date("Y-m-d");
	?>
	<style>

	.blink_me
	{
	  animation: blinker 1s linear infinite;
	}
	@keyframes blinker {
	  50%{
	    opacity: 0;
	  }
	}
	/* Center the loader */
	.sect
	{
	  height: 400px;
	}
	#loader {
	  position: absolute;
	  left: 50%;
	  top: 50%;
	  z-index: 1;
	  width: 150px;
	  height: 150px;
	  margin: -75px 0 0 -75px;
	  border: 16px solid #f3f3f3;
	  border-radius: 50%;
	  border-top: 16px solid #3498db;
	  width: 120px;
	  height: 120px;
	  -webkit-animation: spin 2s linear infinite;
	  animation: spin 2s linear infinite;
	}

	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}

	/* Add animation to "page content" */
	.animate-bottom {
	  position: relative;
	  -webkit-animation-name: animatebottom;
	  -webkit-animation-duration: 1s;
	  animation-name: animatebottom;
	  animation-duration: 1s
	}

	@-webkit-keyframes animatebottom {
	  from { bottom:-100px; opacity:0 }
	  to { bottom:0px; opacity:1 }
	}

	@keyframes animatebottom {
	  from{ bottom:-100px; opacity:0 }
	  to{ bottom:0; opacity:1 }
	}
	.loading, .loading > td, .loading > th, .nav li.loading.active > a, .pagination li.loading, .pagination > li.active.loading > a, .pager > li.loading > a {
	    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 0));
	    background-size: 40px 40px;
	    animation: 2s linear 0s normal none infinite progress-bar-stripes;
	    -webkit-animation: progress-bar-stripes 2s linear infinite;
	}
	</style>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
					if ($links!='NOT' || $admin=='1' )
					{
						?>
						<div class='ibox-title'>
              <div class="row">
                <div class="col-lg-12">
                  <header>
    								<h4><?php echo  $title; ?></h4>
    							</header>
                </div>
              </div>
						</div>
						<div class="ibox-content">
              <div class="row">
                <div class="col-lg-12">
                  <form <?php if (isset($_POST['action']) == "upload"){ ?> style="display:none" <?php  } ?> id="importa" name="importa" method="post" action="<?php echo $filename; ?>" enctype="multipart/form-data" >
                    <div class="col-lg-6">
                      <input class="btn btn-primary" required style="width:100%" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="excel" />
                    </div>
										<div class="col-lg-6">
											<input type='submit' class="btn btn-primary" style="height:43px !important"  name='enviar' value="Importar" />
										</div>
                    <input type="hidden" value="upload" name="action" />
                  </form>
                </div>
								<div id="divl" class="row alert alert-primary " style="display:none" role="alert">
                	<a href="#" class="btn btn-warning loading col-lg-12 blink_me">Guardando Archivo de Excel por favor espere</a>
              	</div>

								<?php if (isset($_POST['action']) == "upload"){ ?>
									<div id="divh" class="row alert alert-primary " role="alert">
	                	<a href="#" class="btn btn-warning loading col-lg-12 blink_me">Realizando cambios en la base de datos esto puede tardar un rato</a>
	              	</div>
								<?php  } ?>

								<div id="divI" class="row alert alert-primary " style="display:none" role="alert">
                	<a href="#" class="btn btn-warning loading col-lg-12 blink_me">Agregando productos nuevos</a>
              	</div>
								<div id="divJ" class="row alert alert-primary " style="display:none" role="alert">
                	<a href="#" class="btn btn-warning loading col-lg-12 blink_me">Actualizando Precios</a>
              	</div>

              </div>
              <?php
                extract($_POST);
                if (isset($_POST['action']) == "upload"){
                  ini_set("memory_limit","500M");
                  //cargamos el archivo al servidor con el mismo nombre
                  //solo le agregue el sufijo bak_
                  $archivo = $_FILES['excel']['name'];
                  $tipo = $_FILES['excel']['type'];
                  $destino = "bak_".$archivo;
                  if (copy($_FILES['excel']['tmp_name'],$destino));
                  else echo "Error Al Cargar el Archivo";
                  ////////////////////////////////////////////////////////
                  if (file_exists ("bak_".$archivo)){
                  /** Clases necesarias */

                  require_once ('php_excel/Classes/PHPExcel.php');
                  require_once('php_excel/Classes/PHPExcel/Reader/Excel2007.php');

                  /*vaciar la tabla Hoja1*/

                  $sql_query=_query("TRUNCATE TABLE Hoja1" );

                  // Cargando la hoja de cálculo
                  $objReader = new PHPExcel_Reader_Excel2007();
                  $objPHPExcel = $objReader->load("bak_".$archivo);
                  $objFecha = new PHPExcel_Shared_Date();

                  // Asignar hoja de excel activa
                  $sheet = $objPHPExcel->getSheet(0);
                  $highestRow = $sheet->getHighestRow();
                  $highestColumn = $sheet->getHighestColumn();

									$validacionH1=1;
									_begin();
									if ($sheet->getCell("A1")->getValue()!="Nombre") {
										?>
										<div class="alert alert-danger" role="alert">
										  El archivo de Excel no esta adecuadamente alineado verifique que la celda <i>Nombre</i> se encuente en la columna <i>A</i> en la fila <i>1</i>
										</div>
										<script type="text/javascript">
										 document.getElementById( 'divh' ).style.display = 'none';
										</script>
										<?php
									}
									else {
										$table="Hoja1";
										for ($row = 2; $row <= $highestRow; $row++){
											if ($sheet->getCell("G".$row)->getValue()!="") {
												# code...
												$form_data = array(
													'Nombre' => preg_replace('/( ){2,}/u',' ',$sheet->getCell("A".$row)->getValue()),
													'Costo_Iva' => str_replace("$","",$sheet->getCell("B".$row)->getValue()),
													'Precio1' => $sheet->getCell("C".$row)->getValue(),
													'Precio2' => $sheet->getCell("D".$row)->getValue(),
													'Precio3' => $sheet->getCell("E".$row)->getValue(),
													'Precio4' => $sheet->getCell("F".$row)->getValue(),
													'Codigo' => $sheet->getCell("G".$row)->getValue(),
													'Costo' => $sheet->getCell("H".$row)->getValue(),
													'Cod_Bar_1' => $sheet->getCell("I".$row)->getValue(),
													'Precio5' => $sheet->getCell("K".$row)->getValue(),
													'Familia' => $sheet->getCell("L".$row)->getValue(),
													'Precio6' => $sheet->getCell("M".$row)->getValue(),
													'Precio7' => $sheet->getCell("N".$row)->getValue(),
													'Casa' => $sheet->getCell("O".$row)->getValue(),
													'FechaAct' => date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("W".$row)->getValue())),
												);
												/*
												echo $sheet->getCell("A".$row)->getValue();
												echo $sheet->getCell("B".$row)->getValue();
												echo $sheet->getCell("C".$row)->getValue();
												echo $sheet->getCell("D".$row)->getValue();
												echo $sheet->getCell("E".$row)->getValue();
												echo $sheet->getCell("F".$row)->getValue();
												echo $sheet->getCell("H".$row)->getValue();
												echo $sheet->getCell("I".$row)->getValue();
												echo $sheet->getCell("K".$row)->getValue();
												echo $sheet->getCell("L".$row)->getValue();
												echo $sheet->getCell("M".$row)->getValue();
												echo $sheet->getCell("N".$row)->getValue();
												echo $sheet->getCell("O".$row)->getValue();
												echo date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("W".$row)->getValue()));
												echo "<br>";
												*/
												$insertar=_insert($table,$form_data);
												if (!$insertar) {
													$validacionH1=0;
												}

											}

										}
										if ($validacionH1==1) {

											?>
											<script type="text/javascript">
											 document.getElementById( 'divh' ).style.display = 'none';
											 document.getElementById( 'divI' ).style.display = 'block';
											</script>
											<?php
											/*agregando productos nuevos*/
											$sql=_query("SELECT Hoja1.Cod_Bar_1,Hoja1.Nombre,Hoja1.Costo_Iva AS costo,Hoja1.Precio1 AS precio,Hoja1.Precio1,Hoja1.Precio2,Hoja1.Precio3,Hoja1.Precio4,Hoja1.Precio5,Hoja1.Precio6,Hoja1.Precio7,proveedor.id_proveedor,categoria.id_categoria FROM Hoja1 JOIN proveedor ON proveedor.nombre=Hoja1.Casa JOIN categoria ON categoria.nombre_cat=Hoja1.Familia WHERE Hoja1.Nombre IS NOT NULL AND Hoja1.Nombre!='' AND UPPER(Hoja1.Nombre) NOT IN (SELECT UPPER(producto.descripcion) FROM producto)");

											$validacionAP=1;
											while ($row=_fetch_array($sql)) {
											  # code...

											  $table = 'producto';
												$form_data = array(
													'descripcion' => $row['Nombre'],
													'barcode' => $row['Cod_Bar_1'],
													'marca' => "",
													'minimo' => 0,
													'exento' => 0,
													'estado' => 1,
													'id_proveedor' => $row['id_proveedor'],
													'id_categoria' => $row['id_categoria'],
													'perecedero' => 0,
												);
											  $insertar=_insert($table,$form_data);
											  $id_producto=_insert_id();

											  $sql_suc=_query("SELECT id_sucursal FROM sucursal");
											  $a=_num_rows($sql_suc);

											  while($row_su=_fetch_array($sql_suc))
											  {
											    $tabla_p = "presentacion_producto";
											    $form_pre = array(
											      'id_producto' => $id_producto,
											      'presentacion' => 1,
											      'descripcion' => "1x1",
											      'unidad' => "1",
											      'precio' => $row['precio'],
											      'costo' => $row['costo'],
											      'activo' => 1,
											      'id_sucursal'=>$row_su['id_sucursal']
											    );
											    $insert_pre = _insert($tabla_p, $form_pre);
													$id_presentacion=_insert_id();
													if (!$insert_pre) {
														$validacionAP=0;
													}

													for ($i=1; $i < 8; $i++) {
														# code...
														$desde=0;
														$hasta=0;
														if ($i==1) {
															# code...
															$desde=0;
															$hasta=3;
														}
														else {
															# code...
															if ($i==2) {
																# code...
																$desde=3;
																$hasta=6;
															}
															else {
																# code...
																if ($i==3) {
																	# code...
																	$desde=6;
																	$hasta=12;
																}
																else {
																	# code...

																	$desde=12;
																	$hasta=999;

																}

															}
														}
														$sql_suc=_query("SELECT * FROM sucursal");

														while ($rs=_fetch_array($sql_suc)) {
															# code...
															$precio="Precio".$i;
															$table="presentacion_producto_precio";
															$form_data = array(
																'id_producto' => $id_producto,
																'id_presentacion' => $id_presentacion,
																'id_sucursal' => $rs['id_sucursal'],
																'precio' => $row[$precio],
																'desde' => $desde,
																'hasta' => $hasta,
															);

															$insertar=_insert($table,$form_data);

															if ($insertar) {
																# code...
															}
															else {
																$a=0;
															}
														}

													}
											  }
											}
											if ($validacionAP==1) {
												/*Actualizando Precios*/
												?>
												<script type="text/javascript">
												 document.getElementById( 'divh' ).style.display = 'none';
												 document.getElementById( 'divI' ).style.display = 'none';
												 document.getElementById( 'divI' ).style.display = 'block';
												</script>
												<?php
												$ultm_r=_fetch_array(_query("SELECT ultima_act FROM sucursal"));
												$ultima=$ultm_r['ultima_act'];
												$sql=_query("
												SELECT DISTINCT (producto.id_producto), producto.descripcion,presentacion_producto.id_presentacion,presentacion_producto.id_sucursal,
												Hoja1.Precio1,
												Hoja1.Precio2,
												Hoja1.Precio3,
												Hoja1.Precio4,
												Hoja1.Precio5,
												Hoja1.Precio6,
												Hoja1.Precio7,
												Hoja1.Costo_Iva  as costo_iva,
												presentacion_producto.costo,
												presentacion.nombre
												FROM producto
												INNER JOIN Hoja1 ON UPPER(producto.descripcion)=UPPER(Hoja1.Nombre)
												JOIN presentacion_producto ON presentacion_producto.id_producto=producto.id_producto
												JOIN presentacion ON presentacion.id_presentacion = presentacion_producto.presentacion
												WHERE
												Hoja1.Precio1!=0
												AND presentacion_producto.costo
												BETWEEN (Hoja1.Costo_Iva/1.4) AND (Hoja1.Costo_Iva*1.4) AND Costo_Iva!=presentacion_producto.costo");

												$a=1;

												while ($row=_fetch_array($sql)) {
												  # code...
													$table="presentacion_producto";
													$form_data = array(
														'costo' => $row['costo_iva'],
													);
													$where_clause="id_presentacion=$row[id_presentacion] AND id_sucursal=$row[id_sucursal]";
													$update=_update($table,$form_data);

												  $table="presentacion_producto_precio";
												  $where_clause="id_presentacion=$row[id_presentacion] AND id_sucursal=$row[id_sucursal] ";
												  $delete = _delete($table,$where_clause);

												  for ($i=1; $i < 8; $i++) {
												    # code...
												    $desde=0;
												    $hasta=0;
												    if ($i==1) {
												      # code...
												      $desde=0;
												      $hasta=3;
												    }
												    else {
												      # code...
												      if ($i==2) {
												        # code...
												        $desde=3;
												        $hasta=6;
												      }
												      else {
												        # code...
												        if ($i==3) {
												          # code...
												          $desde=6;
												          $hasta=12;
												        }
												        else {
												          # code...

												          $desde=12;
												          $hasta=999;

												        }

												      }
												    }
												    $precio="Precio".$i;
												    $table="presentacion_producto_precio";
												    $form_data = array(
												      'id_producto' => $row['id_producto'],
												      'id_presentacion' => $row['id_presentacion'],
												      'id_sucursal' => $row['id_sucursal'],
												      'precio' => $row[$precio],
												      'desde' => $desde,
												      'hasta' => $hasta,
												    );

												    $insertar=_insert($table,$form_data);
												    if ($insertar) {
												      # code...
												    }
												    else {
												      $a=0;
												    }
												  }
												}

												if ($a==1) {
												  # code...
													$sql_ul=_query("UPDATE sucursal SET ultima_act='".date("Y-m-d")."'");
												  _commit();

													?>
													<script type="text/javascript">
													 document.getElementById( 'divh' ).style.display = 'none';
													 document.getElementById( 'divI' ).style.display = 'none';
													 document.getElementById( 'divI' ).style.display = 'none';
													</script>
													<?php

													?>
													<div class="alert alert-info" role="alert">
													  Todos los productos se actualizaron adecuadamente
													</div>
													<script type="text/javascript">
													 document.getElementById( 'divh' ).style.display = 'none';
													</script>
													<?php

												}
												else {
												  # code...
												  _rollback();
													?>
													<script type="text/javascript">
													 document.getElementById( 'divh' ).style.display = 'none';
													 document.getElementById( 'divI' ).style.display = 'none';
													 document.getElementById( 'divI' ).style.display = 'none';
													</script>
													<?php

													?>
													<div class="alert alert-danger" role="alert">
														Error
													</div>
													<script type="text/javascript">
													 document.getElementById( 'divh' ).style.display = 'none';
													</script>
													<?php
												}
											}
											else {
												_rollback();
												?>
												<script type="text/javascript">
												 document.getElementById( 'divh' ).style.display = 'none';
												 document.getElementById( 'divI' ).style.display = 'none';
												 document.getElementById( 'divI' ).style.display = 'none';
												</script>
												<?php

												?>
												<div class="alert alert-danger" role="alert">
													Error
												</div>
												<script type="text/javascript">
												 document.getElementById( 'divh' ).style.display = 'none';
												</script>
												<?php
											}

										}
										else
										{
											_rollback();

											?>
											<script type="text/javascript">
											 document.getElementById( 'divh' ).style.display = 'none';
											 document.getElementById( 'divI' ).style.display = 'none';
											 document.getElementById( 'divI' ).style.display = 'none';
											</script>
											<?php

											?>
											<div class="alert alert-danger" role="alert">
												Error
											</div>
											<script type="text/javascript">
											 document.getElementById( 'divh' ).style.display = 'none';
											</script>
											<?php

										}

									}
                  //archivo que esta en el servidor el bak_
                  unlink($destino);
                }
                  else{
                    echo "Necesitas primero importar el archivo";
                  }
                }
                ?>

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

			<script type="text/javascript">
				document.getElementById("importa").onsubmit = function() {myFunction()};

				function myFunction() {
					$("#importa").hide();
					$("#divl").show();
				}
			</script>
			<?php
			include ("footer.php");
			echo" <script type='text/javascript' src='js/funciones/funciones_mov_cta_banco.js'></script>";
		} //permiso del script
		else {
			echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
			include ("footer.php");
		}
	}

	if (!isset($_REQUEST['process'])) {
		initial();
	}
	//else {
	if (isset($_REQUEST['process'])) {
		switch ($_REQUEST['process']) {
			case 'val':
			cuentas_b();
			break;
		}
	}
	?>
