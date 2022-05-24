<?php
include_once "_core.php";

function initial()
{
	$title = 'Permisos de Usuario';
	// Page setup
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
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
	$id_usuario= $_REQUEST['id_usuario'];

	$sql="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
	$result=_query($sql);
	$count=_num_rows($result);

	//permiso del script
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri=$_SERVER['REQUEST_URI'];
	list($uri1,$uri2,$filename)=explode("/",$uri);
	$poschar = strpos($filename, '?');
	if ($poschar !== false)
	{
		list($namelink1,$namelink1)=explode("?",$filename);
		$links=permission_usr($id_user,$namelink1);
	}
	else
	{
		$links=permission_usr($id_user,$filename);
	}
	?>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2">
		</div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<?php
					//permiso del script
					if ($links!='NOT' || $admin=='1' )
					{
						?>
						<div class="ibox-title">
							<h3><i class="fa fa-lock"></i> <b><?php echo $title;?></b></h3>
						</div>
						<div class="ibox-content">
							<form name="formulario" id="formulario">
								<?php
								if ($count>0)
								{
									for($i=0;$i<$count;$i++)
									{
										$row=_fetch_array($result);
										$nombre=$row['nombre'];
										$usuario=$row['usuario'];
										$password=$row['password'];
										//$tipo_usuario=$row['tipo_usuario'];
										$administrador=$row['admin'];
										$precios=$row['precios'];
									}
								}
								?>
								<div class="row">
									<div class="form-group col-lg-3">
										<label>Nombre</label>
										<input type="text" placeholder="Ingresa nombre" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre ?>" readonly>
									</div>
									<div class="form-group col-lg-3">
										<label>Usuario</label>
										<input type="text" placeholder="Ingrese el usuario" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario ?>"  readonly>
									</div>
									<div class="form-group col-lg-3">
										<div class="form-group">
											<div class='checkbox i-checks'><br>
												<label id='frentex'>
													<input type='checkbox' id='admi' name='admi' <?php if($administrador) echo " checked "; ?>> <strong> Administrador</strong>
												</label>
											</div>
											<input type='hidden'  id='admin' name='admin' <?php if($administrador) echo " value='1' "; else echo " value='0' "; ?>>
										</div>
									</div>
									<div class="form-group col-lg-3">
										<div class="form-group">
											<label>Precios</label>
											<select class="form-control select" name="precio" id="precio">
												<?php
												for ($i=1; $i<8; $i++)
												{
													echo "<option value='$i'";
													if($i == $precios)
													{
														echo " selected ";
													}
													echo ">$i</option>";
												}
												?>
											</select>
										</div>
									</div>

								</div>
								<div class="row"><br><br>
									<?php
									echo"
									<div class='form-group col-lg-12' id='div_modules_edit'>
									";
									$sql_menus="SELECT menu.* FROM menu, modulo WHERE modulo.id_menu=menu.id_menu AND menu.visible='1' GROUP BY modulo.id_menu ORDER BY count(modulo.id_modulo) ASC";
									//order by prioridad
									$result=_query($sql_menus);
									$numrows=_num_rows($result);
									$main_lnk='dashboard.php';
									echo"<div class='row'>";
									$contador = 1;
									for($i=0;$i<$numrows;$i++)
									{
										$row=_fetch_array($result);
										$menuname=$row['nombre'];
										$id_menu=$row['id_menu'];
										$icono=$row['icono'];


										if ($contador > 4) {
											$contador = 1;
											echo "</div>";
											echo"<div class='row'>";
											echo "<hr>";
										}

										echo"<div class='col-md-3'>";
										echo"<div class='panel panel-primary'>";
										echo"<div class='panel-heading'>$menuname</div>";
										echo "<div class='panel-body'>";

										if ($administrador=='1'){
											if($admin=='1'){
												$sql_links="SELECT distinct menu.id_menu, menu.nombre as nombremenu, menu.prioridad,
												modulo.id_modulo, modulo.nombre as nombremodulo, modulo.descripcion, modulo.filename
												FROM menu, modulo
												WHERE menu.id_menu='$id_menu'
												AND menu.id_menu=modulo.id_menu

												";
												$result_modules=_query($sql_links);
												$numrow2=_num_rows($result_modules);
												if($numrow2>0){
													for($j=0;$j<$numrow2;$j++){
														$row_modules=_fetch_array($result_modules);
														$lnk=strtolower($row_modules['filename']);
														$modulo=$row_modules['nombremodulo'];
														$id_modulo=$row_modules['id_modulo'];

														echo"<p>";
														echo"<div class='checkbox i-checks'><label> <input  id='myCheckboxes' name='myCheckboxes' type='checkbox' value='$id_modulo' checked class='i-checks'> <i></i>".ucfirst($modulo)."</label></div>";
														echo"</p>";
													}

												}

											}
										}
										else{
											if($admin=='1'){
												$sql_links="SELECT distinct menu.id_menu, menu.nombre as nombremenu, menu.prioridad,
												modulo.id_modulo, modulo.nombre as nombremodulo, modulo.descripcion, modulo.filename
												FROM menu, modulo
												WHERE menu.id_menu='$id_menu'
												AND menu.id_menu=modulo.id_menu

												";
												$result_modules=_query($sql_links);
												$numrow2=_num_rows($result_modules);
												if($numrow2>0){
													for($j=0;$j<$numrow2;$j++){
														$row_modules=_fetch_array($result_modules);
														$lnk=strtolower($row_modules['filename']);
														$modulo=$row_modules['nombremodulo'];
														$id_modulo=$row_modules['id_modulo'];
														$sql_link_user="SELECT menu.id_menu, menu.nombre as nombremenu, menu.prioridad, modulo.id_modulo,
														modulo.nombre as nombremodulo, modulo.descripcion, modulo.filename, usuario_modulo.id_usuario
														FROM menu, modulo, usuario_modulo, usuario
														WHERE usuario.id_usuario='$id_usuario'
														AND usuario.id_usuario=usuario_modulo.id_usuario
														AND usuario_modulo.id_modulo=modulo.id_modulo
														AND menu.id_menu=modulo.id_menu
														AND usuario_modulo.id_modulo='$id_modulo'
														";
														$result_link_user=_query($sql_link_user);
														$numrow3=_num_rows($result_link_user);
														$row_link_user=_fetch_array($result_link_user);
														$id_modulo_user=$row_link_user['id_modulo'];
														if ($id_modulo==$id_modulo_user){
															echo"<p>";
															echo"<div class='checkbox i-checks'><label> <input id='myCheckboxes' name='myCheckboxes' type='checkbox' value='$id_modulo' checked> <i></i>".ucfirst($modulo)."</label></div>";
															echo"</p>";

														}
														else{
															echo"<p>";
															echo"<div class='checkbox i-checks'><label> <input id='myCheckboxes' name='myCheckboxes' type='checkbox' value='$id_modulo'> <i></i>".ucfirst($modulo)."</label></div>";
															echo"</p>";
														}

													}

												}

											}
										}
										echo"</div>"; //panel-body
										echo"</div>";//panel panel-primary';
										echo"</div>"; //  <div class='col-lg-4'>
										$contador++;
									} //fin de los panel
									// }

									echo"</div>" ;//row;
									echo"</div>" ;//<div class='form-group' id='div_modules_edit'>;
									?>
									<!--/div-->
								</div>
								<div class="row">
									<div class="form-actions col-lg-12">
										<input type="hidden" name="process" id="process" value="permissions">
										<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario;?>">
										<input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs pull-right" />
									</div>
								</div>
							</form>
						</div>
						</div>
						</div>
						</div>
						</div>
						<?php
						include_once ("footer.php");
						echo "<script src='js/funciones/funciones_usuarios.js'></script>";
					} //permiso del script
					else {
						echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
						include_once ("footer.php");
					}
				}
				function permissions()
				{
					$id_usuario=$_POST["id_usuario"];
					$mod = $_POST ["myCheckboxes"];
					$cuantos = $_POST ["qty"];
					$admin = $_POST ["admin"];
					$precio =$_POST['precio'];
					$listadatos=explode(',',$mod);
					$table='usuario';
					$form_data = array (
						'admin' => $admin,
						'precios' => $precio,
					);

					$where_clause = "id_usuario='" . $id_usuario . "'";
					$updates = _update ( $table, $form_data, $where_clause );

					$table='usuario_modulo';
					$insertar1 = _delete($table, $where_clause );
					for ($i=0;$i<$cuantos ;$i++)
					{
						$id_modulo=$listadatos[$i];
						$sql1="SELECT * FROM usuario_modulo WHERE id_usuario='$id_usuario' AND id_modulo='$id_modulo'";
						$result1=_query($sql1);
						$row1=_fetch_array($result1);
						$nrow1=_num_rows($result1);

						$table='usuario_modulo';
						$form_data = array (
							'id_modulo' => $id_modulo,
							'id_usuario' => $id_usuario
						);
						if ($nrow1==0)
						{
							$insertar1 = _insert($table,$form_data );
						}
						else
						{
							$where_clause="id_usuario='$id_usuario' AND id_modulo='$id_modulo'";
							$insertar1 = _update($table,$form_data, $where_clause );
						}
					}
					if($insertar1)
					{
						$xdatos['typeinfo']='Success';
						$xdatos['msg']='Permisos asignados correctamente!';
						$xdatos['process']='edited';
					}
					else
					{
						$xdatos['typeinfo']='Error';
						$xdatos['msg']='Permisos no pudieron ser asignados!';
					}
					echo json_encode($xdatos);
				}



				if(!isset($_POST['process']))
				{
					initial();
				}
				else
				{
					if(isset($_POST['process']))
					{
						switch ($_POST['process'])
						{
							case 'permissions':
							permissions();
							break;

						}
					}
				}
				?>
