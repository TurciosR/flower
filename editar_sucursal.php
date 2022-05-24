	<?php
	include_once "_core.php";

	function initial() {


		$_PAGE = array ();
		$_PAGE ['title'] = 'Editar Sucursal';
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
	  $_PAGE ['links'] .= '<link href="css/plugins/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css"/>';

		include_once "header.php";
		include_once "main_menu.php";
		$id_sucursal= $_REQUEST['id_sucursal'];
		$text = "";

	     $sql="SELECT * FROM sucursal
	     WHERE
	     id_sucursal='$id_sucursal'";
	     $result=_query($sql);
	     $count=_num_rows($result);
			 $row = _fetch_array($result);
			 $nombre = $row["descripcion"];
			 $logo = $row["logo"];
	     $razon=$row["razonsocial"];
	     $direccion=$row["direccion"];
	     $telefono1=$row["telefono1"];
	     $telefono2=$row["telefono2"];
	     $nit=$row["nit"];
	     $nrc=$row["nrc"];
	     $iva=$row["iva"];
	     $giro = $row["giro"];
	     $monto_retencion1 = $row["monto_retencion1"];
	     $monto_retencion10 = $row["monto_retencion10"];
	     $monto_percepcion = $row["monto_percepcion"];
			 $comision = $row["comision"];
			 $comision_doc = $row["comision_doc"];
			 $tipo_sucursal = $row["tipo_sucursal"];
			 //permiso del script
		  	$id_user=$_SESSION["id_usuario"];
		 	$admin=$_SESSION["admin"];

		 	$uri = $_SERVER['SCRIPT_NAME'];
		 	$filename=get_name_script($uri);
		 	$links=permission_usr($id_user,$filename);
		 	//permiso del script

		if ($links!='NOT' || $admin=='1' ){

	?>

	            <div class="row wrapper border-bottom white-bg page-heading">

	                <div class="col-lg-2">

	                </div>
	            </div>
	        <div class="wrapper wrapper-content  animated fadeInRight">
	            <div class="row">
	                <div class="col-lg-12">
	                    <div class="ibox ">
	                        <div class="ibox-title">
	                            <h5>Editar Sucursal</h5>
	                        </div>
	                        <div class="ibox-content">


	                          <form name="formulario" id="formulario">
														<div class="row">
															<div class="row">
																	<div class="col-lg-6">
																		<div class="form-group has-info single-line">
																			<label class="control-label" for="Nombre">Descripción</label>
																			<input type="text" placeholder="Digite Nombre" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre;?>">
																		</div>
																	</div>
																	<div class="col-md-6">
	                                  <div class="form-group has-info single-line">
	                                    <label>Razón Social</label>
	                                    <input type="text" placeholder="Razón Social" class="form-control dis" id="razon" name="razon" value="<?php echo $razon;?>">
	                                  </div>
	                                </div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group has-info single-line">
																		<label class="control-label" for="Dirección">Dirección</label>
																		<input type="text" placeholder="Dirección" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion;?>">
																	</div>
																</div>
															</div>
															<div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                      <label>Teléfono 1</label>
                                      <input type="text" placeholder="Teléfono 1" class="form-control dis" id="telefono1" name="telefono1" value="<?php echo $telefono1;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>Teléfono 2</label>
                                    <input type="text" placeholder="Teléfono 2" class="form-control dis" id="telefono2" name="telefono2" value="<?php echo $telefono2;?>">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>NIT</label>
                                    <input type="text" placeholder="NIT" class="form-control dis" id="nit" name="nit" value="<?php echo $nit;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>NRC</label>
                                    <input type="text" placeholder="NRC" class="form-control dis" id="nrc" name="nrc" value="<?php echo $nrc;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>IVA</label>
                                    <input type="text" placeholder="IVA" class="form-control dis" id="iva" name="iva" value="<?php echo $iva;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>Giro</label>
                                    <input type="text" placeholder="Giro" class="form-control dis" id="giro" name="giro" value="<?php echo $giro;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>Monto inicial de retención 1%</label>
                                    <input type="text" placeholder="Monto inicial de retencion 1%" class="form-control dis" id="monto_retencion1" name="monto_retencion1" value="<?php echo $monto_retencion1;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>Monto inicial de retención 10%</label>
                                    <input type="text" placeholder="Monto inicial de retencion 10%" class="form-control dis" id="monto_retencion10" name="monto_retencion10" value="<?php echo $monto_retencion10;?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                    <label>Monto inicial de percepción</label>
                                    <input type="text" placeholder="Monto inicial de percepción" class="form-control dis" id="monto_percepcion" name="monto_percepcion" value="<?php echo $monto_percepcion;?>">
                                  </div>
                                </div>
                              </div>
															<div class="row">
																	<div class="col-md-6">
																		<div class="form-group has-info single-line">
																			<label>Tipo Sucursal</label>
																			<select class="select form-control" name="tipo_sucursal" id='tipo_sucursal'>
																				<option value="">Seleccione</option>
																				<option value="0"
																				<?php if($tipo_sucursal == 0)
																				{
																					echo "selected";
																				}?>
																				>Laboratorio</option>
																				<option value="1"
																				<?php if($tipo_sucursal == 1)
																				{
																					echo "selected";
																				}?>>Distribuidora</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-6" hidden id="com_ven">
																		<div class="form-group has-info single-line">
																			<label>Comisión Vendedor (%)</label>
																			<input type="text" name="comision" id="comision" class="form-control" placeholder="Digite la comisión" value="<?php echo $comision;?>">
																		</div>
																	</div>
																	<div class="col-md-6" hidden id="com_doc">
																		<div class="form-group has-info single-line">
																			<label>Comisión Doctor (%)</label>
																			<input type="text" name="comision_doc" id="comision_doc" class="form-control" placeholder="Digite la comisión" value="<?php echo $comision_doc;?>">
																		</div>
																	</div>
															</div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group has-info single-line">
                                      <label>Logo</label>
                                      <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
                                  </div>
                                </div>
																<div class="col-md-6">
                                  <div class="form-group has-info">
                                      <img id="logo_view" src="<?php echo $logo;?>" style='width: 200px; height: 100px;'>
                                  </div>
                                </div>
                              </div>
															<input type="hidden" name="process" id="process" value="editar">
														<!----->
																 <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $_REQUEST['id_sucursal']?> ">
	                                    <div>

	                                       <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs pull-right" />

	                                    </div>
	                                </form>
	                        </div>
	                    </div>
	                </div>
	            </div>

	        </div>

	<?php
	include_once ("footer.php");
	echo "<script src='js/funciones/funciones_sucursal.js'></script>";
			} //permiso del script
	else {
			echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
		}

	}

	function editar()
	{
	    require_once 'class.upload.php';
			$id_sucursal = $_POST["id_sucursal"];
			$nombre=$_POST["nombre"];
			$razon=$_POST["razon"];
			$direccion=$_POST["direccion"];
			$telefono1=$_POST["telefono1"];
			$telefono2=$_POST["telefono2"];
			$nit=$_POST["nit"];
			$nrc=$_POST["nrc"];
			$iva=$_POST["iva"];
			$giro = $_POST["giro"];
			$comision_ven = $_POST["comision"];
			$comision_doc = $_POST["comision_doc"];
			$tipo_sucursal = $_POST["tipo_sucursal"];
			$monto_retencion1 = $_POST["monto_retencion1"];
			$monto_retencion10 = $_POST["monto_retencion10"];
			$monto_percepcion = $_POST["monto_percepcion"];
	    if ($_FILES["logo"]["name"]!="")
	    {
	    $foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
	    if ($foo->uploaded) {
	        $pref = uniqid()."_";
	        $foo->file_force_extension = false;
	        $foo->no_script = false;
	        $foo->file_name_body_pre = $pref;
	       // save uploaded image with no changes
	       $foo->Process('img/');
	       if ($foo->processed)
	       {
					 $query = _query("SELECT logo FROM sucursal WHERE id_sucursal='$id_sucursal'");
	         $result = _fetch_array($query);
	         $urlb=$result["logo"];
	         if($urlb!="")
	         {
	             unlink($urlb);
	         }
	        $cuerpo=quitar_tildes($foo->file_src_name_body);
	        $cuerpo=trim($cuerpo);
	        $url = 'img/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
	        $table = 'sucursal';
	        $form_data = array (
	        'descripcion' => $nombre,
	        'razonsocial' => $razon,
	        'direccion' => $direccion,
	        'telefono1' => $telefono1,
	        'telefono2' => $telefono2,
	        'nit' => $nit,
	        'nrc' => $nrc,
	        'iva' => $iva,
	        'giro' => $giro,
	        'monto_retencion1' => $monto_retencion1,
	        'monto_retencion10' => $monto_retencion10,
	        'monto_percepcion' => $monto_percepcion,
	        'logo' => $url,
					'comision' => $comision_ven,
					'comision_doc' => $comision_doc,
					'tipo_sucursal' => $tipo_sucursal,
	        );
					$where_clause = "id_sucursal='".$id_sucursal."'";
	        $editar =_update($table, $form_data, $where_clause);
	        if($editar)
	        {
	           $xdatos['typeinfo']='Success';
	           $xdatos['msg']='Datos de sucursal editados correctamente !';
	           $xdatos['process']='edit';
	        }
	        else
	        {
	           $xdatos['typeinfo']='Error';
	           $xdatos['msg']='Datos de sucursal no pudieron ser editados!'._error();
	        }
	       }
	       else
	       {
	          $xdatos['typeinfo']='Error';
	          $xdatos['msg']='Error al guardar la imagen!';
	       }
	    }
	    else
	    {
	        $xdatos['typeinfo']='Error';
	        $xdatos['msg']='Error al subir la imagen!';
	    }
	    }
	    else
	    {
	        $table = 'sucursal';
	        $form_data = array (
						'descripcion' => $nombre,
		        'razonsocial' => $razon,
		        'direccion' => $direccion,
		        'telefono1' => $telefono1,
		        'telefono2' => $telefono2,
		        'nit' => $nit,
		        'nrc' => $nrc,
		        'iva' => $iva,
		        'giro' => $giro,
		        'monto_retencion1' => $monto_retencion1,
		        'monto_retencion10' => $monto_retencion10,
		        'monto_percepcion' => $monto_percepcion,
						'comision' => $comision_ven,
						'comision_doc' => $comision_doc,
						'tipo_sucursal' => $tipo_sucursal,
	        );
					$where_clause = "id_sucursal='".$id_sucursal."'";
	        $editar =_update($table, $form_data, $where_clause);
	        if($editar)
	        {
	           $xdatos['typeinfo']='Success';
	           $xdatos['msg']='Datos de sucursal editados correctamente !';
	           $xdatos['process']='edit';
	        }
	        else
	        {
	           $xdatos['typeinfo']='Error';
	           $xdatos['msg']='Datos de sucursal no pudieron ser editados!';
	        }
	    }
	    echo json_encode($xdatos);
	}


	if(!isset($_REQUEST['process'])){
		initial();
	}
	else
	{
	if(isset($_REQUEST['process'])){
	switch ($_REQUEST['process']) {
		case 'editar':
			editar();
			break;
		case 'formEdit' :
			initial();
			break;
		}
	}
	}
	?>
