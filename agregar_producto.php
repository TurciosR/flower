<?php
include_once "_core.php";
function initial()
{
    $title='Agregar Producto';
    $_PAGE = array();
    $_PAGE ['title'] = $title;
    $_PAGE ['links'] = null;
    $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/upload_file/fileinput.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

    include_once "header.php";
    $id_sucursal=$_SESSION['id_sucursal'];
    //permiso del script
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];

    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user, $filename);

    $arrayPr = array();
    $qpresentacion=_query("SELECT * FROM presentacion ORDER BY nombre");
    $arrayPr[""] = "Seleccione";
    while ($row_pr=_fetch_array($qpresentacion)) {
        $idPr=$row_pr['id_presentacion'];
        $description=$row_pr['nombre'];
        $arrayPr[$idPr] = $description;
    }
    $arrayCat = array();
    $arrayCat[""] = "Seleccione";
    $qcategoria=_query("SELECT * FROM categoria ORDER BY nombre_cat");
    while ($row_cat=_fetch_array($qcategoria)) {
        $idCat=$row_cat['id_categoria'];
        $description=$row_cat['nombre_cat'];
        $arrayCat[$idCat] = $description;
    } ?>
    <style media="screen">
    table tbody td.ed::before{
      content:'\f044';
      position:relative;
      top: -10px;
      right: 9px;

      font: normal normal normal 14px/1 FontAwesome
    }
    .fileinput-upload-button
    {
      display:none;
    }
    </style>
	<div class="gray-bg">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<?php
                    if ($links!='NOT' || $admin=='1') {
                        ?>
						<div class="ibox-title">
							<div class="row">
                <div class="col-lg-9">
                  <h5><?php echo $title; ?> </h5>
                </div>
                <div class="col-lg-3">
                  <a href="admin_producto.php">
                    <button style="margin:0px;" type="button" class="btn btn-danger pull-right" name="button"> <i class="fa  fa-mail-reply"></i> Salir</button>
                  </a>
                  <a id="btn_img" name="btn_img" class="btn btn-primary m-t-n-xs pull-right" style="margin-right:10px; margin-top: 1px;"><i class="fa fa-image"></i> Agregar Imagen</a>
                </div>
              </div>
						</div>
						<input type="hidden" id="id_producto" name="id_producto" value="0">
						<input type="hidden" id="actual" name="actual" value="">
						<div class="ibox-content">
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Código de Barra</label>
											<input type="text" placeholder="Digite Código de Barra" class="form-control" id="barcode" name="barcode">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-info single-line">
											<label>Descripción</label>
											<input type="text" placeholder="Descripcion" class="form-control" id="descripcion" name="descripcion">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group has-info single-line">
											<label>Marca</label>
											<input type="text" placeholder="Marca" class="form-control" id="marca" name="marca">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group has-info single-line">
											<label>Stock Minimo</label>
											<input type="text" placeholder="Minimo" class="form-control" id="minimo" name="minimo">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Proveedor</label>
											<select class="form-control select2" id="proveedor" name='proveedor'>
												<option value="">Seleccione</option>
												<?php
                                                $sql = _query("SELECT * FROM proveedor ORDER BY nombre ASC");
                        while ($row = _fetch_array($sql)) {
                            echo "<option value='".$row["id_proveedor"]."'>".$row["nombre"]."</option>";
                        } ?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group has-info single-line">
											<label>Categoría</label>
											<?php
                                            $select=crear_select2("id_categoria", $arrayCat, "", "width:100%;", 1);
                        echo $select; ?>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group has-info single-line">
											<label class="control-label">Exento IVA</label>
											<div class='checkbox i-checks'>
												<label>
													<input type='checkbox'  id='exento' name='exento' value='1'><i></i>
												</label>
											</div>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group has-info single-line">
											<label class="control-label">Producto perecedero</label>
											<div class='checkbox i-checks'>
												<label>
													<input type='checkbox'  id='perecedero' name='perecedero' value='1'><i></i>
												</label>
											</div>
										</div>
									</div>
                  <div class="col-sm-2">
										<div class="form-group has-info single-line">
											<label class="control-label">Venta decimal</label>
											<div class='checkbox i-checks'>
												<label>
													<input type='checkbox'  id='decimal' name='decimal' value='1'><i></i>
												</label>
											</div>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-lg-12"><br>
										<div class="alert alert-warning text-center"><h3>Presentaciones</h3></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Presentación</label>
											<?php
                                            $select=crear_select2("id_presentacion", $arrayPr, "", "width:100%;", 1);
                        echo $select; ?>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Descripción</label>
											<input type="text" name="desc_pre" id="desc_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Unidades</label>
											<input type="text" name="unidad_pre" id="unidad_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Costo</label>
											<input type="text" name="costo_pre" id="costo_pre" class="form-control clear">
										</div>
									</div>
									<div hidden class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Precio</label>
											<input type="text" name="precio_pre" id="precio_pre" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info single-line">
											<label>Código de Barra</label>
											<br>
											<input type="text" name="bar" id="bar" class="form-control clear">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group has-info">
											<br>
											<br>
											<a  class="btn btn-primary" id="add_pre"><i class="fa fa-plus"></i> Agregar</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th class="col-md-1">Cod. de Barra</th>
													<th class="col-md-1">Presentación</th>
													<th class="col-md-1">Descripción</th>
													<th class="col-md-1">Unidad</th>
													<th class="col-md-1">Costo</th>
													<th class="col-md-1">Precio 1</th>
													<th class="col-md-1">Precio 2</th>
													<th class="col-md-1">Precio 3</th>
													<th class="col-md-1">Precio 4</th>
													<th class="col-md-1">Precio 5</th>
													<th class="col-md-1">Precio 6</th>
													<th class="col-md-1">Precio 7</th>
													<th class="col-md-1">Acción</th>
												</tr>
											</thead>
											<tbody id="presentacion_table">

											</tbody>
										</table>
									</div>
								</div>
								<div>
									<input type="hidden" name="process" id="process" value="insert"><br>
									<button type="button" class="btn btn-primary m-t-n-xs" id="submit1" name="submit1">Guardar</button>
								</div>

							<div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-md'>
									<div class='modal-content modal-md'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->

              <div class='modal fade' id='viewProducto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class="modal-header">
											<button type="button" class="close" id='cerrar_ven' data-dismiss="modal"
											aria-hidden="true">&times;</button>
											<h4 class="modal-title">Agregar Imagen de Producto</h4>
										</div>
										<div class="modal-body">
											<div class="wrapper wrapper-content  animated fadeInRight">
									            <form name="formulario_pro" id="formulario_pro" enctype='multipart/form-data' method="POST">
									              <div class="row">
									                <div class="col-md-12">
									                  <div class="form-group has-info single-line">
									                      <label>Producto</label>
									                      <input type="file" name="logo" id="logo" class="file" data-preview-file-type="image">
																				<input type="hidden" name="id_id_p" id="id_id_p">
																				<input type="hidden" name="process" id="process" value="insert_img">
									                  </div>
									                </div>
									              </div>
									            </form>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary" id="btnGimg">Aceptar</button>
												<button type="button" class="btn btn-default bb" data-dismiss="modal">Cerrar</button>
											</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						</div>
					</div>
				</div>
		<?php
        include_once("footer.php");
                        echo "<script src='js/funciones/funciones_producto.js'></script>";
                    } else {
                        echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
                        include_once("footer.php");
                    }
}
function insertar()
{
    global $precios_sistema;
    $id_producto=$_POST["id_producto"];
    $descripcion=$_POST["descripcion"];
    $barcode=$_POST["barcode"];
    $marca=$_POST["marca"];
    $minimo=$_POST["minimo"];
	if($minimo == "undefined" || $minimo == ""){
		$minimo = 0;
	}
    $id_sucursal=$_SESSION["id_sucursal"];
    $id_categoria=$_POST["id_categoria"];
    $tipo_prod_servicio="PRODUCTO";
    $perecedero=$_POST["perecedero"];
	if($perecedero == "undefined" || $perecedero == ""){
		$perecedero = 0;
	}
    $proveedor=$_POST["proveedor"];
    $decimals=$_POST["decimals"];
	if($decimals == "undefined" || $decimals == ""){
		$decimals = 0;
	}
    $descripcion=trim($descripcion);
    $barcode=trim($barcode);
    $name_producto="";
    $exento=$_POST["exento"];
	if($exento == "undefined" || $exento == ""){
		$exento = 0;
	}
    $fecha_hoy=date("Y-m-d");
    $lista = $_POST["lista"];
    $cuantos = $_POST["cuantos"];
    $upds_server="";

    if ($perecedero==0) {
        $fecha_vencimiento=null;
    }
    _begin();


    $sql_result=_query("SELECT id_producto,descripcion,barcode FROM producto WHERE descripcion='$descripcion'");
    $numrows=_num_rows($sql_result);
	$name_producto = "";
	if($numrows > 0){
		$row_update=_fetch_array($sql_result);
		$id_update=$row_update["id_producto"];
		$name_producto=trim($row_update["descripcion"]);
	}
    $descrip_producto_existe=false;
    if ($name_producto!="" && $descripcion!="") {
        $descrip_producto_existe=true;
    }
    if ($barcode=="") {
        $barcodeexiste=false;
    }
    if ($barcode!="") {
        $sql_barcode="SELECT id_producto,descripcion,barcode FROM producto WHERE barcode='$barcode'";
        $sql_result_barcode=_query($sql_barcode);
        $numrows_barcode=_num_rows($sql_result_barcode);
        if ($numrows_barcode>0) {
            $barcodeexiste=true;
        } else {
            $barcodeexiste=false;
        }
    }
    $descripcion=strtoupper($descripcion);

    $max_codart_sql =_fetch_array(_query("SELECT MAX(CAST(codart AS UNSIGNED)) as max FROM producto"));
    $codart=$max_codart_sql['max']+1;
    $table = 'producto';
    $form_data = array(
		'id_server' => '0',
        'descripcion' => $descripcion,
        'codart' => $codart,
        'barcode' => $barcode,
        'marca' => $marca,
        'minimo' => $minimo,
        'exento' => $exento,
        'estado' => 1,
        'id_proveedor' => $proveedor,
        'id_categoria' => $id_categoria,
        'perecedero' => $perecedero,
        'decimals' => $decimals,
		'composicion' => '',
		'imagen' => '',
		'id_sucursal' => $id_sucursal,
		'costo' => '0',
		'precio' => '0',
		'precio_mayoreo' => '0',
		'color' => '',
    );
    if (!$descrip_producto_existe) {
        if (!$barcodeexiste) {
            $insertar =_insert($table, $form_data);


            if ($insertar) {
                $id_producto2 = _insert_id();
                $xdatos['id_producto']=$id_producto2;

                $table_cambio="log_cambio_local";
        				$form_data = array(
							'id_server' => '0',
        					'process' => 'insert',
        					'tabla' =>  "producto",
        					'fecha' => date("Y-m-d"),
        					'hora' => date('H:i:s'),
        					'id_usuario' => $_SESSION['id_usuario'],
        					'id_sucursal' => $_SESSION['id_sucursal'],
        					'id_primario' =>$id_producto2,
        					'prioridad' => "1",
							'subido' => '1',
							'verificado' => '0',

        				);
        				$insert_cambio=_insert($table_cambio,$form_data);
        				$id_cambio=_insert_id();

        				$table_detalle_cambio="log_detalle_cambio_local";
        				$form_data = array(
							'id_server' => '0',
        					'id_log_cambio' => 	$id_cambio,
        					'tabla' => 'producto',
        					'id_verificador' => $id_producto2
        				);
        				_insert($table_detalle_cambio,$form_data);

                $explora = explode(";", $lista);
                $c = count($explora);
                $n = 0;
                for ($i=0; $i < $c - 1 ; $i++) {
                    $ex = explode(",", $explora[$i]);
                    $id_presen = $ex[0];
                    $des = $ex[1];
                    $uni = $ex[2];
                    $pre = $ex[3];
                    $cost = $ex[5];
                    $bar=$ex[6];
                    $precios_a=$ex[7];
					if($cost == "" || $cost == "undefined"){
						$cost = 0;
					}

                    $tabla_p = "presentacion_producto";
                    $form_pre = array(
							'id_server' => '0',
							'id_server_prod' => '0',
                            'id_producto' => $id_producto2,
                            'id_presentacion' => $id_presen,
                            'descripcion' => $des,
                            'unidad' => $uni,
                            'precio' => $pre,
                            'costo' => $cost,
                            'activo' => 1,
                            'barcode' => $bar,
							'costo_s_iva' => $cost,

                        );
                    $precios = explode("#", $precios_a);
                    foreach ($precios_sistema as $key => $value) {
        							// code...
        							$form_pre[$value]=$precios[$key];
        						}

                    $insert_pre = _insert($tabla_p, $form_pre);
                    $id_presenta=_insert_id();

                    if ($insert_pre) {
                        $n++;
                    }
                }
                if ($n == ($c-1)) {
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='Registro ingresado con exito!';
                    $xdatos['process']='insert';
                    $xdatos['id_producto'] = $id_producto2;
                    _commit();
                } else {
                    _rollback();
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='Registro no pudo ser ingresado !';
                    $xdatos['process']='insert';
                }
            } else {
                _rollback();
                $xdatos['typeinfo']='Error';
                $xdatos['msg']='Registro no pudo ser ingresado !';
                $xdatos['process']='insert';
            }
        } else {
            _rollback();
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='El Barcode ya está asignado a otro producto!';
            $xdatos['process']='existbarcode';
        }
    } else {
        _rollback();
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Ya existe un producto registrado con estos datos!';
        $xdatos['process']='noinsert';
    }

    echo json_encode($xdatos);
}
function lista()
{
    $lista = "";
    $sql_presentacion = _query("SELECT * FROM presentacion");
    $cuenta = _num_rows($sql_presentacion);
    if ($cuenta > 0) {
        $lista.= "<select id='presen' class='col-md-12 select2 valcel'>";
        $lista.= "<option value='0'>Seleccione</option>";
        while ($row = _fetch_array($sql_presentacion)) {
            $id_presentacion = $row["id_presentacion"];
            $descripcion = $row["descripcion_pr"];
            $lista.= "<option value=".$id_presentacion.">".$descripcion."</option>";
        }
        $lista.="</select>";
    }
    $xdatos['select'] = $lista;
    echo json_encode($xdatos);
}
function insert_img()
{
		require_once 'class.upload.php';
		$id_producto = $_POST["id_id_p"];
		if ($_FILES["logo"]["name"]!="")
		{
		$foo = new \Verot\Upload\Upload($_FILES['logo'],'es_ES');
		if ($foo->uploaded) {
				$pref = uniqid()."_";
				$foo->file_force_extension = false;
				$foo->no_script = false;
				$foo->file_name_body_pre = $pref;
			 // save uploaded image with no changes
			 $foo->Process('img/productos/');
			 if ($foo->processed)
			 {
				 $query = _query("SELECT imagen FROM producto WHERE id_producto='$id_producto'");
				 $result = _fetch_array($query);
				 $urlb=$result["imagen"];
				 if($urlb!="")
				 {
						 unlink($urlb);
				 }
				$cuerpo=quitar_tildes($foo->file_src_name_body);
				$cuerpo=trim($cuerpo);
				$url = 'img/productos/'.$pref.$cuerpo.".".$foo->file_src_name_ext;
				$table = 'producto';
				$form_data = array (
				'imagen' => $url,
				);
				$where_clause = "id_producto='".$id_producto."'";
				$editar =_update($table, $form_data, $where_clause);
				if($editar)
				{
					 $xdatos['typeinfo']='Success';
					 $xdatos['msg']='Datos guardados correctamente !';
					 $xdatos['process']='edit';
				}
				else
				{
					 $xdatos['typeinfo']='Error';
					 $xdatos['msg']='Error al guardar los dartos!'._error();
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
			 $xdatos['typeinfo']='Success';
			 $xdatos['msg']='Datos guardados correctamente !';
			 $xdatos['process']='edit';
		}
		echo json_encode($xdatos);
}
function impuestos()
{
    $lista = "";
    $sql = _query("SELECT * FROM configuracion LIMIT 1");
    $cuenta = _num_rows($sql);
    if ($cuenta > 0) {
      $result = _fetch_array($sql);
      $iva = ($result['iva'])/100;
      $utilidad = ($result['utilidad'])/100;
      $xdatos = array("iva"=>$iva, "utilidad"=>$utilidad);
    }
    echo json_encode($xdatos);
}

if (!isset($_POST['process'])) {
    initial();
} else {
    if (isset($_POST['process'])) {
        switch ($_POST['process']) {
            case 'insert':
            insertar();
            break;
            case 'lista':
            lista();
            break;
            case 'insert_img':
        		insert_img();
        		break;
            case 'impuestos':
            impuestos();
            break;
        }
    }
}
?>
