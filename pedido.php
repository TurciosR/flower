<?php
include_once "_core.php";

function initial() {

	$title='Pedidos';
	$_PAGE = array();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';

  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main_co.css">';
$_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util_co.css">';
	include_once "header.php";
	include_once "main_menu.php";
	$id_sucursal=$_SESSION["id_sucursal"];
	$sql="SELECT * FROM producto";

	$result=_query($sql);
	$count=_num_rows($result);
	//permiso del script
 	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
  $fecha_actual=date("d-m-Y");

  if (isset($_REQUEST['id_pedido']))
  {
    $id_pedido = $_REQUEST["id_pedido"];
    $sql_pedido = _query("SELECT p.fecha, p.total, p.anulada, p.id_sucursal, p.finalizada, p.lugar_entrega, p.pagado, p.id_departamento, p.id_municipio, p.id_cliente,
    c.nombre AS cliente, us.nombre AS empleado, s.descripcion AS sucursal
    FROM pedido AS p
    JOIN cliente AS c ON c.id_cliente = p.id_cliente
    JOIN usuario AS us ON us.id_usuario = p.id_empleado
    JOIN sucursal AS s ON s.id_sucursal = p.id_sucursal
    WHERE p.id_pedido = '$id_pedido'");

    $row_pedido = _fetch_array($sql_pedido);
    $fecha_pedido = $row_pedido["fecha"];
    $total = $row_pedido["total"];
    $lugar_entrega = $row_pedido["lugar_entrega"];
    $cliente = $row_pedido["cliente"];
    $empleado = $row_pedido["empleado"];
    $sucursal = $row_pedido["sucursal"];
    $departamento = $row_pedido["id_departamento"];
    $municipio = $row_pedido["id_municipio"];
    $id_cliente = $row_pedido["id_cliente"];
    $hidden = "hidden";
    $hidden1 = "text";

    $select_depa = "<select class='form-control select_depa' id='select_depa'>";

    $sql_depa = _query("SELECT * FROM departamento");
    $cuenta = _num_rows($sql_depa);
    if($cuenta > 0)
    {
			$select_depa .= "<option value=''>Seleccione</option>";
      while ($row_depa = _fetch_array($sql_depa))
      {
        $id_departamento = $row_depa["id_departamento"];
        $descripcion = $row_depa["nombre_departamento"];
        $select_depa.= "<option value='".$id_departamento."'";
        if($id_departamento == $departamento)
        {
          $select_depa.= " selected";
        }
        $select_depa.=">".$descripcion."</option>";
      }
    }
    $select_depa.='</select>';

    $select_muni = "<select class='form-control select_muni' id='select_muni'>";
    $sql_muni = _query("SELECT * FROM municipio WHERE id_departamento_municipio = '$departamento'");
    $cuenta_muni = _num_rows($sql_muni);
    if($cuenta_muni > 0)
    {
      while ($row_muni = _fetch_array($sql_muni))
      {
        $id_municipio = $row_muni["id_municipio"];
        $descripcion = $row_muni["nombre_municipio"];
        $select_muni.= "<option value='".$id_municipio."'";
        if($id_municipio == $municipio)
        {
          $select_muni.= " selected";
        }
        $select_muni.=">".$descripcion."</option>";
      }
    }
    $select_muni.='</select>';

  }
  else
  {

    $fecha_pedido = date("d-m-Y");
    $total = "";
    $lugar_entrega = "";
    $cliente = "";
    $empleado = "";
    $sucursal = "";
    $departamento = "";
    $municipio = "";
    $id_cliente = "";
    $hidden = "text";
    $hidden1 = "hidden";

    $select_depa = "<select class='form-control select_depa' id='select_depa'>";
    $sql_depa = _query("SELECT * FROM departamento");
    $cuenta = _num_rows($sql_depa);
    if($cuenta > 0)
    {
			$select_depa .= "<option value=''>Seleccione</option>";
      while ($row_depa = _fetch_array($sql_depa))
      {
        $id_departamento = $row_depa["id_departamento"];
        $descripcion = $row_depa["nombre_departamento"];
        $select_depa.= "<option value='".$id_departamento."'";
        $select_depa.=">".$descripcion."</option>";
      }
    }
    $select_depa.='</select>';

    $select_muni = "<select class='form-control select_muni' id='select_muni'>";
    $select_muni.= "<option value=''>Primero seleccione un departamento</option>";
    $select_muni.= '</select>';
  }
	if ($links!='NOT' || $admin=='1' ){

?>

	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-2"></div>
	</div>
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<!--Primero si e si es inv. inicial ,factura de compra, compra caja chica, traslado de otra sucursal; luego Registrar No. de Factura , lote, proveedor -->
				<div class="ibox ">
					<div class="ibox-content">
            <div class="row">
              <div class="col-lg-4">
  							<div class='form-group has-info single-line'><label>Cliente</label>
									<div id="scrollable-dropdown-menu">
										<input type="text" id="cliente_buscar" name="cliente_buscar"  style="width:100% !important" class=" form-control usage typeahead" placeholder="Buscar cliente" data-provide="typeahead" style="border-radius:0px">
									</div>
									<input type='hidden' class='form-control' id='text_cliente' name='text_cliente' readOnly>
									<input type='hidden' class='form-control' id='id_cliente' name='id_cliente'>
  							</div>
    					</div>
							<div class='col-lg-4'>
                <div class='form-group has-info single-line'>
                  <label>Vendedor</label>
									<select class="form-control select" id="vendedor" name="vendedor" style="width:100%">
										<option value="">Seleccione</option>
										<?php
											$sql_us=_query("SELECT id_usuario,nombre FROM usuario WHERE id_sucursal!=$_SESSION[id_sucursal]");
											while ($row_us=_fetch_array($sql_us))
											{
												$id_usuario = $row_us['id_usuario'];
												$nombre = $row_us['nombre'];
												echo "<option value=' $id_usuario ' >".MAYU($nombre)."</option>";
											}
										?>
									</select>
              	</div>
							</div>
              <div class='col-lg-4'>
                <div class='form-group has-info single-line'>
                  <label>Fecha</label>
                  <input type='text' class='form-control' value='<?php echo $fecha_pedido ?>' id='fecha1' name='fecha1'></div>
              </div>
            </div>
            <div class="row caja_datos">
              <div class="col-lg-4">
  							<div class='form-group has-info single-line'>
                  <label>Dirección</label>
  								<input type="text" id="direccion" name="direccion" size="20" class="direccion form-control" placeholder="Dirección" value="<?php echo $lugar_entrega; ?>">
  						  </div>
    					</div>
              <div class='col-lg-4'>
                <div class='form-group has-info single-line'>
                  <label>Departamento</label>
                  <div class="depa">
                    <?php
                        echo $select_depa;
                    ?>
                  </div>
                </div>
              </div>
              <div class='col-lg-4'>
                <div class='form-group has-info single-line'>
                  <label>Municipio</label>
                  <div class="muni">
                    <?php
                        echo $select_muni;
                    ?>
                  </div>
              </div>
              </div>
            </div>
            <div class="row">
							<div class="col-lg-4">
								<div class='form-group has-info single-line'>
									<label>Origen</label>
									<select name='origen' id="origen" class="form-control select">
									<?php
									$id_sucursal=$_SESSION['id_sucursal'];
									$sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
									while($row = _fetch_array($sql))
									{
										if ($id_traslado==0) {
											// code...
											echo "<option value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
										}
										else {
											// code...

											if ($row["id_ubicacion"]==$rowtg['id_origen']) {
												// code...
												echo "<option selected value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
											}
											else {
												echo "<option value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
											}
										}

									}
									?>
								</select>
								</div>
							</div>
							<div class="col-lg-4">
  							<div class='form-group has-info single-line'>
                  <label>Transporte</label>
  								<input type="text" id="transporte" name="transporte" size="20" class="direccion form-control" placeholder="Transporte">
  						  </div>
    					</div>
							<div class='col-lg-4'>
                <div class='form-group has-info single-line'>
                  <label>Fecha entrega</label>
                  <input type='text' class='form-control' value='<?php echo date("d-m-Y") ?>' id='fecha_entrega' name='fecha_entrega'></div>
              </div>
				   </div>
					 <div class="row" id='buscador'>
						 <div class="col-lg-8">
							 <div class='form-group has-info single-line'><label>Buscar Producto</label>
								 <div id="scrollable-dropdown-menu">
								 <input type="text" id="producto_buscar" name="producto_buscar"  style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese Descripcion de producto" data-provide="typeahead" style="border-radius:0px">
								 </div>
							 </div>
						 </div>
					 </div>
				<div class="ibox">
					<div class="row">
						<div class="ibox-content">
						<!--load datables estructure html-->
						<header>
							<h4 class="text-navy">Pedidos</h4>
						</header>
						<section>
							<table class="table table-striped table-bordered table-condensed" id="inventable1">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Presentación</th>
										<th>Descripción</th>
										<th>Existencias</th>
										<!-- <th>Pedido</th> -->
										<th hidden >Valor Descarte.</th>
										<th>Cant. Sale</th>
										<th>Precio</th>
										<th>SubTotal</th>
										<th>Acci&oacute;n</th>
									</tr>
								</thead>

								<tfoot>
									<tr>
									<td></td>
									<td>Total Salida <strong>$</strong></td>
									<td id='total_dinero'>$0.00</td>
									<td colspan=2>Total Producto de Salida</td>
									<td id='totcant'>0.00</td>
									<!--td></td-->
									</tr>
								</tfoot>
							<tbody id="mostrardatos">
                <?php
                if (isset($_REQUEST['id_pedido']))
                {
                  $id_pedido = $_REQUEST["id_pedido"];
                  $sql_pedido = _query("SELECT pd.precio_venta, pd.subtotal, pd.cantidad, pd.unidad AS unidad_pedido, p.descripcion, pd.id_pp, pd.id_producto, pd.id_empleado
                  FROM pedido_detalle AS pd
                  JOIN producto AS p ON p.id_producto = pd.id_producto
                  WHERE pd.id_pedido = '$id_pedido'");
                  $cuenta = _num_rows($sql_pedido);
                  if($cuenta != 0)
                  {
                    while ($row_pedido = _fetch_array($sql_pedido))
                    {
                      $id_producto = $row_pedido["id_producto"];
                      $cantidad_pedido = $row_pedido["cantidad"];
                      $precio_venta = $row_pedido["precio_venta"];
                      $subtotal = $row_pedido["subtotal"];
                      $id_pp = $row_pedido["id_pp"];
                      $unidad = $row_pedido["unidad_pedido"];
                      $descripcion = $row_pedido["descripcion"];

                      $unidadp=0;
                      $preciop=0;
                      $descripcionp=0;
                      $costo=0;
                      $sql1="SELECT producto.id_producto,producto.descripcion,stock.stock,stock.costo_promedio
                    	FROM producto JOIN stock ON producto.id_producto=stock.id_producto
                    	WHERE producto.id_producto='$id_producto' AND id_sucursal ='$id_sucursal'";

                    	$stock1=_query($sql1);
                    	$row1=_fetch_array($stock1);
                    	$nrow1=_num_rows($stock1);
                    	$unidades=0;
                    	$cp=round($row1['costo_promedio'],2);
                    	$existencias=$row1['stock'];

                      if($existencias == "")
                      {
                        $existencias = "0";
                      }

                      $sql_p=_query("SELECT presentacion.descripcion, presentacion_producto.descripcion AS despp,presentacion_producto.id_presentacion,presentacion_producto.unidad,presentacion_producto.precio,presentacion_producto.costo, presentacion_producto.id_pp
                    		FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
                    		WHERE presentacion_producto.id_producto=$id_producto AND presentacion_producto.activo=1");

                    	$select="<select class='sel'>";
                    	while ($row=_fetch_array($sql_p))
                      {
                    		# code...
                    		if ($i==0) {
                    			# code...
                    			$unidadp=$row['unidad'];
                    			$preciop=$row['precio'];
                    			if ($row['costo']==0)
                          {
                    				# code...
                    				$sql_max=_query("SELECT MAX(id_movimiento_producto) as id FROM movimiento_producto WHERE id_producto=$id_producto AND salida=0 AND entrada>0 AND precio_compra>0 AND id_presentacion=$row[id_presentacion] ");
                    				$_f_a=_fetch_array($sql_max);
                    				$id=$_f_a['id'];
                    				if ($id!=null)
                            {
                    					# code...
                    					$sql_costo=_fetch_array(_query("SELECT * FROM movimiento_producto WHERE id_movimiento_producto=$id"));
                    					$costo=$sql_costo['precio_compra'];
                    				}
                    			}
                    			else
                          {
                    				$costo=$row['costo'];
                    			}
                    		}
                    		$select.="<option value='$row[id_pp]'";
                        if($row["id_pp"] == $id_pp)
                        {
                          $select.="selected";
                          $descripcionp=$row['despp'];
                        }
                        $select.=">$row[descripcion] ($row[unidad])</option>";
                    		$i=$i+1;

                    	}
                    	$select.="</select>";

                      echo '<tr>';
                      echo '<td class="id_producto">'.$id_producto.'</td>';
                      echo '<td >'.$descripcion.'</td>';
                      echo '<td >'.$select.'</td>';
                      echo '<td >'.$descripcionp.'</td>';
                      echo "<td class='col-xs-1 exis'><input type='hidden'  class='form-control unidad' id='unidad' name='unidad' value='".$unidad."' style='width:70px;'>".$existencias.'</td>';
                      echo '<td>'.$cantidad_pedido.'</td>';
                      echo "<td hidden><div class='col-xs-1'><input type='text'  class='form-control' id='precio_compra' name='precio_compra' value='".$costo."' style='width:70px;'></div></td>";
                      echo "<td><div class='col-xs-1'><input type='text'  class='form-control cant' id='cant' name='cant'  value='0' style='width:60px;'></div></td>";
                      echo "<td><input type='text' class='form-control' id='precio_venta' name='precio_venta' value='".$precio_venta."' style='width:70px;' readOnly></td>";
                      echo "<td><div class='col-xs-2'><input type='text'  class='form-control' id='subcant' name='subcant' value='0'  style='width:70px;' readOnly></div></td>";
                      echo "<td class='Delete'><a href='#'><i class='fa fa-times-circle'></i> Borrar</a></td>";
                      echo '</tr>';
                    }
                  }
                }
                ?>
							</tbody>
						</table>
						 <input type="hidden" name="autosave" id="autosave" value="false-0">
					</section>

                                    <input type="hidden" name="process" id="process" value="insert"><br>
                                    <div>
                                      <?php
                                      if (isset($_REQUEST['id_pedido']))
                                      {
                                      ?>
                                      <input type="submit" id="submit2" name="submit1" value="Guardar Y Finalizar" class="btn btn-primary m-t-n-xs pull-right" />
                                      <input type="hidden" id="id_pedido" name="id_pedido" value="<?php echo $_REQUEST['id_pedido']; ?>" />

                                       <?php
                                        }
                                        else
                                        {
                                       ?>
                                       <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs pull-right"  style="margin-left:5px;"/>
                                       <!-- <input type="submit" id="submit2" name="submit2" value="Guardar Y Finalizar" class="btn btn-primary m-t-n-xs pull-right" /> -->
                                       <input type="hidden" id="id_pedido" name="id_pedido" value="" />
                                       <?php
                                        }
                                       ?>

                                    </div>
                        </div>
                         </div>
                    </div>
										<div class='modal fade' id='viewProd' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
											<div class='modal-dialog'>
												<div class='modal-content'></div><!-- /.modal-content -->
											</div><!-- /.modal-dialog -->
										</div><!-- /.modal -->
                    </div><!--div class='ibox-content'-->
              </div>
            </div>
   </div>
        </div>

<?php
include_once ("footer.php");

// echo "<script src='js/plugins/typehead/bootstrap3-typeahead.js'></script>";
echo "<script src='js/funciones/pedido.js'></script>";
} //permiso del script
else {
		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
	}
}

function traerdatos()
{
  $start = !empty($_POST['page'])?$_POST['page']:0;
  $limit =$_POST['records'];
  $sortBy = $_POST['sortBy'];
  $producto_buscar = $_POST['producto_buscar'];
  $origen = $_POST['origen'];

  $sqlJoined="SELECT pr.id_producto,pr.descripcion, pr.barcode FROM
  producto AS pr";
  //  $sqlParcial=get_sql($keywords, $id_color, $estilo, $talla, $barcode, $limite);
  $sqlParcial= get_sql($start,$limit,$producto_buscar,$origen,$sortBy);
  $groupBy="";
  $limitSQL= " ";
  $sql_final= $sqlJoined." ".$sqlParcial." ".$groupBy." ".$limitSQL;
  $query = _query($sql_final);

  echo _error();
  $num_rows = _num_rows($query);
  $filas=0;
  if ($num_rows > 0)
  {
    while ($row = _fetch_array($query))
    {
      $id_producto = $row['id_producto'];
      $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$origen'");
      $dt_existencia = _fetch_array($sql_existencia);
      $existencia = round($dt_existencia["existencia"]);
      $descripcion=$row["descripcion"];
      $barcode = $row['barcode'];
      $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio
                            FROM presentacion_producto AS prp
                            JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion
                            WHERE prp.id_producto=$id_producto
                            AND prp.activo=1");
      $i=0;
      $unidadp=0;
      $costop=0;
      $preciop=0;
      $descripcionp="";
      $select="<select class='sel'>";
      while ($row=_fetch_array($sql_p))
      {
        if ($i==0)
        {
          $unidadp=$row['unidad'];
          $costop=$row['costo'];
          $preciop=$row['precio'];
          $descripcionp=$row['descripcion'];
        }
        $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
        $i=$i+1;
      }
      $select.="</select>";
      $input = "<input type='text' class='cant form-control numeric' style='width:100%;'>";
      ?>
      <tr>
        <td class='col-lg-5'> <input type='hidden' class='id_producto' name='' value='<?php echo $id_producto ?>'> <input type='hidden' class="unidad" value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
        <td class='col-lg-1 text-center'><?php echo $select; ?></td>
        <td class='col-lg-1 text-center descp'><?php echo $descripcionp; ?></td>
        <td style="display:none;" class='col-lg-1 text-center precio_compra'><?php echo $costop; ?></td>
        <td class='text-center precio_venta'><?php echo $preciop; ?></td>
        <td class='col-lg-1 text-center exis'><?php echo $existencia; ?></td>
        <td class='col-lg-1 text-center'><?php echo $input; ?></td>
        <td class='col-lg-1 text-center subtotal'><?php echo "0.0000" ?></td>
        <td class='col-lg-2 text-center'>
					 <a data-toggle='modal' href='ver_imagen.php?id_producto=<?php echo $id_producto; ?>'  data-target='#viewProd' data-refresh='true' class="btn btn-primary btnViw"><i class="fa fa-eye"></i></a>
					 <button class="btn btn-danger btnDelete"> <i class="fa fa-trash"></i> </button>
				</td>
      </tr>
      <?php
      $filas+=1;
    }
  }
}

function get_sql($start,$limit,$producto_buscar,$origen,$sortBy)
{
  $andSQL='';
  $id_sucursal= $_SESSION['id_sucursal'];
  $whereSQL=" WHERE
  ";
  /*AND su.id_ubicacion = '$origen'
  AND su.id_estante=0
  AND su.id_posicion=0
  AND su.cantidad >= 0
  AND su.id_ubicacion=$origen
  AND su.id_sucursal = '$id_sucursal'*/
  $andSQL.= "pr.id_producto = '$producto_buscar'";
  $orderBy="";
  $sql_parcial=$whereSQL.$andSQL.$orderBy;
  return $sql_parcial;
}

function insertar()
{
  $id_pedido = $_POST["id_pedido"];
	$cuantos = $_POST['cuantos'];
	$stringdatos = $_POST['stringdatos'];
	$fecha_movimiento= $_POST['fecha_movimiento'];

	$total_compras = $_POST['total_compras'];

	$id_sucursal=$_SESSION["id_sucursal"];
	$id_usuario=$_SESSION['id_usuario'];

  $departamento = $_POST["select_depa"];
  $municipio = $_POST["select_muni"];
  $direccion = $_POST["direccion"];
  $id_cliente = $_POST["id_cliente"];
	$origen = $_POST['origen'];


	$insertar1=false;
	$insertar2=false;
	$insertarM=false;
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	_begin();


	// $sql="select * from ultimo_numdoc where id_sucursal='$id_sucursal'";
	// $result= _query($sql);
	// $rows=_fetch_array($result);
	// $nrows=_num_rows($result);
	// $ult_sal=$rows['ult_sal']+1;
	// $data_numdoc = array(
	// 'ult_sal' => $ult_sal,
	// );
  $n=10;
  //$numero_doc=numero_tiquete($ult_ref,$tipo_doc);
  $numero_doc=0;



	$table='factura';
	$form_data = array(
		'id_cliente' => $id_cliente,
		'fecha' => $fecha,
		'total' => $total_compras,
		'fecha' => $fecha,
    'id_usuario' => $id_usuario,
    'id_empleado' => $id_usuario,
    'fecha_factura' => $fecha,
    'fecha_entrega' => $fecha_movimiento,
    'lugar_entrega' => $direccion,
    'id_departamento' => $departamento,
    'id_municipio' => $municipio,
		'id_sucursal' => $id_sucursal,
	);
	$insertarM = _insert($table,$form_data);
	$id_factura=_insert_id();
  echo _error();



	if ($cuantos>0){
		$listadatos=explode('#',$stringdatos);
		for ($i=0;$i<$cuantos ;$i++)
    {
			list($id_producto,$precio_venta,$cantidad,$subtotal,$unidad,$id_presentacion)=explode('|',$listadatos[$i]);

			 $sql2="select producto.id_producto,stock.stock, stock.costo_promedio from producto,stock
					where producto.id_producto='$id_producto' and producto.id_producto=stock.id_producto and id_sucursal='$id_sucursal'";
			 $stock2=_query($sql2);
			 $row2=_fetch_array($stock2);
			 $nrow2=_num_rows($stock2);
			 $existencias=$row2['stock'];
			 $cantidadp=$cantidad;
			 $cantidad=$cantidad*$unidad;
			 $cantidad_a_descontar=$cantidad;
			 $costo_promedio=$row2['costo_promedio'];

			 $subt1=$existencias * $costo_promedio;
			 $subt2= $precio_venta * $cantidad;

			 if ($cantidad>$existencias)
			 	$cant_total=0;
			 else
			 	$cant_total=$existencias-$cantidad;

			 $nuevo_cp=($subt1+$subt2)/$cant_total;
			 $nuevo_cp=round($nuevo_cp,2);

     	$table1= 'factura_detalle';
			$form_data1 = array(
			'id_producto' => $id_producto,
			'cantidad' => $cantidad,
			'precio_venta' =>$precio_venta,
			'subtotal' =>  $subtotal,
			'id_pp' => $id_presentacion,
			'id_empleado' => $id_usuario,
			'unidad' => $unidad,
			);

			$table2= 'stock';
			$form_data2 = array(
			'id_producto' => $id_producto,
			'stock' => $cant_total,
			'solicitar' => 'SOLICITAR',
			'costo_promedio'=>$costo_promedio,
			'ultimo_precio_compra'=>$precio_venta,
			'id_sucursal'=>$id_sucursal
			);


		if ($cantidad>0)
    {
			$insertar1 = _insert($table1,$form_data1 );
      echo _error();
		}
		if ($nrow2>0)
    {
			$where_clause="WHERE id_producto='$id_producto' AND  id_sucursal='$id_sucursal'";
			$insertar2 = _update($table2,$form_data2, $where_clause );
      echo _error();
		}
		}//for
	 }//if
//} //if $id=2

  if ($insertar1 && $insertar2 && $insertarM){
		_commit();
     if($id_pedido != "")
     {
       $tab_pedido = "pedido";
       $lista_pedido = array(
         'finalizada' => 1,
         'pagado' => 1,
       );
       $wpedido = "id_pedido='".$id_pedido."'";
       $up_pedido = _update($tab_pedido, $lista_pedido, $wpedido);
     }
     $xdatos['typeinfo']='Success';
     $xdatos['msg']='Registro de Inventario Actualizado !';
     $xdatos['process']='insert';
  }
  else{
		_rollback();
     $xdatos['typeinfo']='Error';
     $xdatos['msg']='Registro de Inventario no pudo ser Actualizado !';
	}
	echo json_encode($xdatos);
}

function pedido()
{
	//- hacer edicion de entradas
	// facturacion
	$cuantos = $_POST['cuantos'];
	$stringdatos = $_POST['stringdatos'];
	$fecha_movimiento= $_POST['fecha_movimiento'];
	$fecha_entrega = $_POST['fecha_entrega'];

	$total_compras = $_POST['total_compras'];

	$id_sucursal=$_SESSION["id_sucursal"];
	$id_usuario=$_SESSION['id_usuario'];

  $departamento = $_POST["select_depa"];
  $municipio = $_POST["select_muni"];
  $direccion = $_POST["direccion"];
  $id_cliente = $_POST["id_cliente"];
	$origen = $_POST['origen'];
	$transporte = $_POST["transporte"];


	$insertar1=false;
	$insertar2=false;
	$insertarM=false;
	$fecha=date("Y-m-d");
	$hora=date("H:i:s");
	_begin();


  $n=10;
  $numero_doc=0;



	$table='pedido';
	$form_data = array(
		'id_cliente' => $id_cliente,
		'fecha' => $fecha,
		'total' => $total_compras,
		'fecha' => MD($fecha_movimiento),
    'id_usuario' => $id_usuario,
    'id_empleado' => $id_usuario,
    // 'fecha_factura' => $fecha,
    'fecha_entrega' => MD($fecha_entrega),
    'lugar_entrega' => $direccion,
    'id_departamento' => $departamento,
    'id_municipio' => $municipio,
		'id_sucursal' => $id_sucursal,
		'transporte' => $transporte,
	);
	$insertarM = _insert($table,$form_data);
	$id_factura=_insert_id();
  echo _error();

	$concepto="PEDIDO PRODUCTO";
  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => "PEDIDO PRODUCTO",
    'total' => $total_compras,
    'tipo' => 'SALIDA',
    'proceso' => 'PED',
    'referencia' => $numero_doc,
    'id_empleado' => $id_usuario,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    // 'id_suc_destino' => $id_suc_destino,
    'id_proveedor' => 0,
    'id_traslado' => $id_factura,
  );
  $insert_mov =_insert($table,$form_data);

  echo _error();
  $id_movimiento=_insert_id();

	if ($cuantos>0)
	{
		$listadatos=explode('#',$stringdatos);
		for ($i=0;$i<$cuantos ;$i++)
    {
			list($id_producto,$precio_venta,$cantidad,$subtotal,$unidad,$id_presentacion)=explode('|',$listadatos[$i]);

			$id_producto;
	    $cantidad=$cantidad*$unidad;
	    $a_transferir=$cantidad;
			 // $sql2="select producto.id_producto,stock.stock, stock.costo_promedio from producto,stock
				// 	where producto.id_producto='$id_producto' and producto.id_producto=stock.id_producto and id_sucursal='$id_sucursal'";
			 // $stock2=_query($sql2);
			 // $row2=_fetch_array($stock2);
			 // $nrow2=_num_rows($stock2);
			 // $existencias=$row2['stock'];
			 // $cantidadp=$cantidad;
			 // $cantidad=$cantidad*$unidad;
			 // $cantidad_a_descontar=$cantidad;
			 // $costo_promedio=$row2['costo_promedio'];
			 //
			 // $subt1=$existencias * $costo_promedio;
			 // $subt2= $precio_venta * $cantidad;
			 //
			 // if ($cantidad>$existencias)
			 // 	$cant_total=0;
			 // else
			 // 	$cant_total=$existencias-$cantidad;
			 //
			 // $nuevo_cp=($subt1+$subt2)/$cant_total;
			 // $nuevo_cp=round($nuevo_cp,2);

			$sql_get_p=_fetch_array(_query("SELECT presentacion_producto.id_presentacion as presentacion,presentacion_producto.id_server,producto.id_server as id_server_prod FROM presentacion_producto JOIN producto ON presentacion_producto.id_producto=producto.id_producto WHERE id_pp=$id_presentacion"));
 	    $presentacion=$sql_get_p['presentacion'];
 	    $id_server_presen=$sql_get_p['id_server'];
 	    $id_server_prod=$sql_get_p['id_server_prod'];

 	    $subtotal = $precio_venta * $cantidad;

     	$table1= 'pedido_detalle';
			$form_data1 = array(
			'id_prod_serv' => $id_producto,
			'cantidad' => $cantidad,
			'precio_venta' =>$precio_venta,
			'subtotal' =>  $subtotal,
			'id_presentacion' => $id_presentacion,
			'id_empleado' => $id_usuario,
			'unidad' => $unidad,
			'id_pedido' => $id_factura,
			);


			if ($cantidad>0)
	    {
				$insertar1 = _insert($table1,$form_data1 );
	      echo _error();
			}

			$sql=_query("SELECT * FROM stock_ubicacion WHERE stock_ubicacion.id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$origen AND stock_ubicacion.cantidad!=0 ORDER BY id_posicion DESC ,id_estante DESC ");

	    while ($rowsu=_fetch_array($sql))
			{
	      # code...

	      $id_su1=$rowsu['id_su'];
	      $stock_anterior=$rowsu['cantidad'];

	      if ($a_transferir!=0) {
	        # code...

	        $transfiriendo=0;
	        $nuevo_stock=$stock_anterior-$a_transferir;
	        if ($nuevo_stock<0) {
	          # code...
	          $transfiriendo=$stock_anterior;
	          $a_transferir=$a_transferir-$stock_anterior;
	          $nuevo_stock=0;
	        }
	        else
	        {
	          if ($nuevo_stock>0) {
	            # code...
	            $transfiriendo=$a_transferir;
	            $a_transferir=0;
	            $nuevo_stock=$stock_anterior-$transfiriendo;
	          }
	          else {
	            # code...
	            $transfiriendo=$stock_anterior;
	            $a_transferir=0;
	            $nuevo_stock=0;

	          }
	        }

	        $table="stock_ubicacion";
	        $form_data = array(
	          'cantidad' => $nuevo_stock,
	        );
	        $where_clause="id_su='".$id_su1."'";
	        $update=_update($table,$form_data,$where_clause);
	        if ($update) {
	          # code...
	        }
	        else {
	          $up=0;
	        }

	        /*actualizando el stock del local de venta*/
	        $sql1a=_fetch_array(_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0"));
	        $id_ubicaciona=$sql1a['id_ubicacion'];
	        $sql2a=_fetch_array(_query("SELECT SUM(stock_ubicacion.cantidad) as stock FROM stock_ubicacion WHERE id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$id_ubicaciona"));
	        $table='stock';
	        $form_data = array(
	          'stock_local' => $sql2a['stock'],
	        );
	        $where_clause="id_producto='".$id_producto."' AND id_sucursal=$id_sucursal";
	        $updatea=_update($table,$form_data,$where_clause);
	        /*finalizando we*/

	        $table="movimiento_stock_ubicacion";
	        $form_data = array(
	          'id_producto' => $id_producto,
	          'id_origen' => $id_su1,
	          'id_destino'=> 0,
	          'cantidad' => $transfiriendo,
	          'fecha' => $fecha,
	          'hora' => $hora,
	          'anulada' => 0,
	          'afecta' => 0,
	          'id_sucursal' => $id_sucursal,
	          'id_presentacion'=> $id_presentacion,
	          'id_mov_prod' => $id_movimiento,
	        );

	        $insert_mss =_insert($table,$form_data);

	        if ($insert_mss) {
	          # code...
	        }
	        else {
	          # code...
	          $z=0;
	        }

	      }

	    }

			$sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
	    $stock2=_query($sql2);
	    $nrow2=_num_rows($stock2);
	    if ($nrow2>0)
	    {
	      $row2=_fetch_array($stock2);
	      $existencias=$row2['stock'];
	    }
	    else
	    {
	      $existencias=0;
	    }

	    /*significa que no hay suficientes unidades en el stock_ubicacion para realizar el descargo*/
	    if ($a_transferir>0) {
	      /*verificamos si se desconto algo de stock_ubicacion*/

	      if($a_transferir!=$cantidad)
	      {/*si entra aca significa que se descontaron algunas unidades de stock_ubicacion y hay que descontarlas de stock y lote*/
	        /*se insertara la diferencia entre el stock_ubicacion y la cantidad a descontar en la tabla de movimientos pendientes*/
	        $table1= 'movimiento_producto_detalle';
	        $cant_total=$existencias-($cantidad-$a_transferir);
	        $form_data1 = array(
	          'id_movimiento'=>$id_movimiento,
	          'id_producto' => $id_producto,
	          'cantidad' => ($cantidad-$a_transferir),
	          'costo' => $precio_compra,
	          'precio' => $precio_venta,
	          'stock_anterior'=>$existencias,
	          'stock_actual'=>$cant_total,
	          'lote' => 0,
	          'id_presentacion' => $id_presentacion,
	          'fecha' =>  $fecha,
	          'hora' => $hora
	        );
	        $insert_mov_det = _insert($table1,$form_data1);
	        if(!$insert_mov_det)
	        {
	          $j = 0;
	        }


	        $table2= 'stock';
	        if($nrow2==0)
	        {
	          $form_data2 = array(
	            'id_producto' => $id_producto,
	            'stock' => 0,
	            'costo_unitario'=>round(($precio_compra/$unidades),2),
	            'precio_unitario'=>round(($precio_venta/$unidades),2),
	            'create_date'=>$fecha_movimiento,
	            'update_date'=>$fecha_movimiento,
	            'id_sucursal' => $id_sucursal
	          );
	          $insert_stock = _insert($table2,$form_data2 );
	        }
	        else
	        {
	          $form_data2 = array(
	            'id_producto' => $id_producto,
	            'stock' => $cant_total,
	            'costo_unitario'=>round(($precio_compra/$unidades),2),
	            'precio_unitario'=>round(($precio_venta/$unidades),2),
	            'update_date'=>$fecha_movimiento,
	            'id_sucursal' => $id_sucursal
	          );
	          $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
	          $insert_stock = _update($table2,$form_data2, $where_clause );
	        }
	        if(!$insert_stock)
	        {
	          $k = 0;
	        }

	        /*arreglando problema con lotes de nuevo*/
	        $cantidad_a_descontar=($cantidad-$a_transferir);
	        $sql=_query("SELECT id_lote, id_producto, fecha_entrada, vencimiento, cantidad
	          FROM lote
	          WHERE id_producto='$id_producto'
	          AND id_sucursal='$id_sucursal'
	          AND cantidad>0
	          AND estado='VIGENTE'
	          ORDER BY vencimiento");


	          $contar=_num_rows($sql);
	          $insert=1;
	          if ($contar>0) {
	            # code...
	            while ($row=_fetch_array($sql)) {
	              # code...
	              $entrada_lote=$row['cantidad'];
	              if ($cantidad_a_descontar>0) {
	                # code...
	                if ($entrada_lote==0) {
	                  $table='lote';
	                  $form_dat_lote=$arrayName = array(
	                    'estado' => 'FINALIZADO',
	                  );
	                  $where = " WHERE id_lote='$row[id_lote]'";
	                  $insert=_update($table,$form_dat_lote,$where);
	                } else {
	                  if (($entrada_lote-$cantidad_a_descontar)>0) {
	                    # code...
	                    $table='lote';
	                    $form_dat_lote=$arrayName = array(
	                      'cantidad'=>($entrada_lote-$cantidad_a_descontar),
	                      'estado' => 'VIGENTE',
	                    );
	                    $cantidad_a_descontar=0;

	                    $where = " WHERE id_lote='$row[id_lote]'";
	                    $insert=_update($table,$form_dat_lote,$where);
	                  } else {
	                    # code...
	                    if (($entrada_lote-$cantidad_a_descontar)==0) {
	                      # code...
	                      $table='lote';
	                      $form_dat_lote=$arrayName = array(
	                        'cantidad'=>($entrada_lote-$cantidad_a_descontar),
	                        'estado' => 'FINALIZADO',
	                      );
	                      $cantidad_a_descontar=0;

	                      $where = " WHERE id_lote='$row[id_lote]'";
	                      $insert=_update($table,$form_dat_lote,$where);
	                    }
	                    else
	                    {
	                      $table='lote';
	                      $form_dat_lote=$arrayName = array(
	                        'cantidad'=>0,
	                        'estado' => 'FINALIZADO',
	                      );
	                      $cantidad_a_descontar=$cantidad_a_descontar-$entrada_lote;
	                      $where = " WHERE id_lote='$row[id_lote]'";
	                      $insert=_update($table,$form_dat_lote,$where);
	                    }
	                  }
	                }
	              }
	            }
	          }
	          /*fin arreglar problema con lotes*/
	          if(!$insert)
	          {
	            $l = 0;
	          }

	          $table1= 'movimiento_producto_pendiente';
	          $cant_total=$existencias-$cantidad;
	          $form_data1 = array(
	            'id_movimiento'=>$id_movimiento,
	            'id_producto' => $id_producto,
	            'id_presentacion' => $id_presentacion,
	            'cantidad' => $a_transferir,
	            'costo' => $precio_compra,
	            'precio' => $precio_venta,
	            'fecha' =>  $fecha,
	            'hora' => $hora,
	            'id_sucursal' => $id_sucursal
	          );
	          $insert_mov_det = _insert($table1,$form_data1);
	          if(!$insert_mov_det)
	          {
	            $j = 0;
	          }

	      }
	      else
	      {/*significa que no hay nada en stock_ubicacion y no se puede descontar de stock_ubicacion ni de stock*/
	        /*se insertara todo en la tabla de movimientos pendientes*/

	        $table1= 'movimiento_producto_pendiente';
	        $cant_total=$existencias-$cantidad;
	        $form_data1 = array(
	          'id_movimiento'=>$id_movimiento,
	          'id_producto' => $id_producto,
	          'id_presentacion' => $id_presentacion,
	          'cantidad' => $cantidad,
	          'costo' => $precio_compra,
	          'precio' => $precio_venta,
	          'fecha' =>  $fecha,
	          'hora' => $hora,
	          'id_sucursal' => $id_sucursal
	        );
	        $insert_mov_det = _insert($table1,$form_data1);
	        if(!$insert_mov_det)
	        {
	          $j = 0;
	        }
	      }
	    }

			else {

	      $table1= 'movimiento_producto_detalle';
	      $cant_total=$existencias-$cantidad;
	      $form_data1 = array(
	        'id_movimiento'=>$id_movimiento,
	        'id_producto' => $id_producto,
	        'cantidad' => $cantidad,
	        // 'costo' => $precio_venta,
	        'precio' => $precio_venta,
	        'stock_anterior'=>$existencias,
	        'stock_actual'=>$cant_total,
	        'lote' => 0,
	        'id_presentacion' => $id_presentacion,
	        'fecha' =>  $fecha,
	        'hora' => $hora
	      );
	      $insert_mov_det = _insert($table1,$form_data1);
	      if(!$insert_mov_det)
	      {
	        $j = 0;
	      }


	      $table2= 'stock';
	      if($nrow2==0)
	      {
	        $cant_total=$cantidad;
	        $form_data2 = array(
	          'id_producto' => $id_producto,
	          'stock' => $cant_total,
	          // 'costo_unitario'=>round(($precio_compra/$unidades),2),
	          'precio_unitario'=>round(($precio_venta/$unidad),2),
	          'create_date'=>$fecha_movimiento,
	          'update_date'=>$fecha_movimiento,
	          'id_sucursal' => $id_sucursal
	        );
	        $insert_stock = _insert($table2,$form_data2 );
	      }
	      else
	      {
	        $cant_total=$existencias-$cantidad;
	        $form_data2 = array(
	          'id_producto' => $id_producto,
	          'stock' => $cant_total,
	          // 'costo_unitario'=>round(($precio_compra/$unidades),2),
	          'precio_unitario'=>round(($precio_venta/$unidad),2),
	          'update_date'=>$fecha_movimiento,
	          'id_sucursal' => $id_sucursal
	        );
	        $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
	        $insert_stock = _update($table2,$form_data2, $where_clause );
	      }
	      if(!$insert_stock)
	      {
	        $k = 0;
	      }

	      /*arreglando problema con lotes de nuevo*/
	      $cantidad_a_descontar=$cantidad;
	      $sql=_query("SELECT id_lote, id_producto, fecha_entrada, vencimiento, cantidad
	        FROM lote
	        WHERE id_producto='$id_producto'
	        AND id_sucursal='$id_sucursal'
	        AND cantidad>0
	        AND estado='VIGENTE'
	        ORDER BY vencimiento");


	        $contar=_num_rows($sql);
	        $insert=1;
	        if ($contar>0) {
	          # code...
	          while ($row=_fetch_array($sql)) {
	            # code...
	            $entrada_lote=$row['cantidad'];
	            if ($cantidad_a_descontar>0) {
	              # code...
	              if ($entrada_lote==0) {
	                $table='lote';
	                $form_dat_lote=$arrayName = array(
	                  'estado' => 'FINALIZADO',
	                );
	                $where = " WHERE id_lote='$row[id_lote]'";
	                $insert=_update($table,$form_dat_lote,$where);
	              } else {
	                if (($entrada_lote-$cantidad_a_descontar)>0) {
	                  # code...
	                  $table='lote';
	                  $form_dat_lote=$arrayName = array(
	                    'cantidad'=>($entrada_lote-$cantidad_a_descontar),
	                    'estado' => 'VIGENTE',
	                  );
	                  $cantidad_a_descontar=0;

	                  $where = " WHERE id_lote='$row[id_lote]'";
	                  $insert=_update($table,$form_dat_lote,$where);
	                } else {
	                  # code...
	                  if (($entrada_lote-$cantidad_a_descontar)==0) {
	                    # code...
	                    $table='lote';
	                    $form_dat_lote=$arrayName = array(
	                      'cantidad'=>($entrada_lote-$cantidad_a_descontar),
	                      'estado' => 'FINALIZADO',
	                    );
	                    $cantidad_a_descontar=0;

	                    $where = " WHERE id_lote='$row[id_lote]'";
	                    $insert=_update($table,$form_dat_lote,$where);
	                  }
	                  else
	                  {
	                    $table='lote';
	                    $form_dat_lote=$arrayName = array(
	                      'cantidad'=>0,
	                      'estado' => 'FINALIZADO',
	                    );
	                    $cantidad_a_descontar=$cantidad_a_descontar-$entrada_lote;
	                    $where = " WHERE id_lote='$row[id_lote]'";
	                    $insert=_update($table,$form_dat_lote,$where);
	                  }
	                }
	              }
	            }
	          }
	        }
	        /*fin arreglar problema con lotes*/
	        if(!$insert)
	        {
	          $l = 0;
	        }

	    }

		}//for
	 }//if
	 echo _error();
	 // echo $insertarM."\n";
	 // echo $insertar1;
  if ($insertar1 && $insertarM){
		_commit();
     $xdatos['typeinfo']='Success';
     $xdatos['msg']='Registro de Inventario Actualizado !';
     $xdatos['process']='insert';
  }
  else{
		_rollback();
     $xdatos['typeinfo']='Error';
     $xdatos['msg']='Registro de Inventario no pudo ser Actualizado !';
	}
	echo json_encode($xdatos);
}

function consultar_stock()
{
	$id_sucursal = $_SESSION['id_sucursal'];
	$id_producto = $_REQUEST['id_producto'];
	$sql1="SELECT producto.id_producto,producto.descripcion,stock.stock,stock.costo_promedio
	FROM producto JOIN stock ON producto.id_producto=stock.id_producto
	WHERE producto.id_producto='$id_producto' AND id_sucursal ='$id_sucursal'";

	$stock1=_query($sql1);
	$row1=_fetch_array($stock1);
	$nrow1=_num_rows($stock1);
	$unidades=0;
	$cp=round($row1['costo_promedio'],2);
	$existencias=$row1['stock'];


	/*inicio modificacion presentacion*/
	$i=0;
	$unidadp=0;
	$preciop=0;
	$descripcionp=0;

	$costo=0;

	$sql_p=_query("SELECT presentacion.descripcion, presentacion_producto.descripcion AS despp,presentacion_producto.id_presentacion,presentacion_producto.unidad,presentacion_producto.precio,presentacion_producto.costo, presentacion_producto.id_pp
		FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
		WHERE presentacion_producto.id_producto=$id_producto AND presentacion_producto.activo=1");
	$select="<select class='sel'>";
	while ($row=_fetch_array($sql_p)) {
		# code...
		if ($i==0) {
			# code...
			$unidadp=$row['unidad'];
			$preciop=$row['precio'];
			$descripcionp=$row['descripcion'];

			if ($row['costo']==0) {
				# code...
				$sql_max=_query("SELECT MAX(id_movimiento_producto) as id FROM movimiento_producto WHERE id_producto=$id_producto AND salida=0 AND entrada>0 AND precio_compra>0 AND id_presentacion=$row[id_presentacion] ");
				$_f_a=_fetch_array($sql_max);
				$id=$_f_a['id'];
				if ($id!=null) {
					# code...
					$sql_costo=_fetch_array(_query("SELECT * FROM movimiento_producto WHERE id_movimiento_producto=$id"));
					$costo=$sql_costo['precio_compra'];
				}

			}
			else {
				# code...
				$costo=$row['costo'];
			}

		}


		$select.="<option value='$row[id_pp]'>$row[descripcion] ($row[unidad])</option>";
		$i=$i+1;

	}
	$select.="</select>";

	$xdatos['select']= $select;
	$xdatos['preciop']= $preciop;
	$xdatos['unidadp']= $unidadp;
	$xdatos['descripcionp']= $descripcionp;
	$xdatos['costo']= $costo;
	/*fin modificacion presentacion*/


	$xdatos['unidad'] = $unidades;
	$xdatos['costo_prom'] = $cp;
	$xdatos['pre_unit'] = $cp;
	$xdatos['existencias'] = $existencias;

	echo json_encode($xdatos); //Return the JSON Array

}

function getpresentacion()
{
	$id_presentacion =$_REQUEST['id_presentacion'];
	$sql=_fetch_array(_query("SELECT * FROM `presentacion_producto` WHERE id_pp=$id_presentacion"));
  $id_producto=$sql['id_producto'];
	$precio=$sql['precio'];
	$unidad=$sql['unidad'];
	$descripcion=$sql['descripcion'];

  $costo=0;
  if ($sql['costo']==0) {
    # code...
    $sql_max=_query("SELECT MAX(id_movimiento_producto) as id FROM movimiento_producto WHERE id_producto=$id_producto AND salida=0 AND entrada>0 AND precio_compra>0 AND id_presentacion=$sql[id_presentacion] ");
    $_f_a=_fetch_array($sql_max);
    $id=$_f_a['id'];
    if ($id!=null) {
      # code...
      $sql_costo=_fetch_array(_query("SELECT * FROM movimiento_producto WHERE id_movimiento_producto=$id"));
      $costo=$sql_costo['precio_compra'];
    }

  }
  else {
    # code...
    $costo=$sql['costo'];
  }


	$xdatos['precio']=$precio;
	$xdatos['unidad']=$unidad;
	$xdatos['descripcion']=$descripcion;
  $xdatos['costo']=$costo;

	echo json_encode($xdatos);
}

function datos_cliente()
{
	$id_cliente = $_POST['id_cliente'];
  $sql_cliente = _query("SELECT * FROM cliente WHERE id_cliente = '$id_cliente'");
  $row = _fetch_array($sql_cliente);

  $direccion = $row["direccion"];
  $departamento = $row["departamento"];
  $municipio = $row["municipio"];

  $select_depa = "<select class='form-control select_depa' id='select_depa'>";
  $sql_depa = _query("SELECT * FROM departamento");
  $cuenta = _num_rows($sql_depa);
  if($cuenta > 0)
  {
    while ($row_depa = _fetch_array($sql_depa))
    {
      $id_departamento = $row_depa["id_departamento"];
      $descripcion = $row_depa["nombre_departamento"];
      $select_depa.= "<option value='".$id_departamento."'";
      if($id_departamento == $departamento)
      {
        $select_depa.= " selected";
      }
      $select_depa.=">".$descripcion."</option>";
    }
  }
  $select_depa.='</select>';

  $select_muni = "<select class='form-control select_muni' id='select_muni'>";
  $sql_muni = _query("SELECT * FROM municipio WHERE id_departamento_municipio = '$departamento'");
  $cuenta_muni = _num_rows($sql_muni);
  if($cuenta_muni > 0)
  {
    while ($row_muni = _fetch_array($sql_muni))
    {
      $id_municipio = $row_muni["id_municipio"];
      $descripcion = $row_muni["nombre_municipio"];
      $select_muni.= "<option value='".$id_municipio."'";
      if($id_municipio == $municipio)
      {
        $select_muni.= " selected";
      }
      $select_muni.=">".$descripcion."</option>";
    }
  }
  $select_muni.='</select>';

	$xdatos['direccion']=$direccion;
	$xdatos['select_depa']=$select_depa;
	$xdatos['select_muni']=$select_muni;

	echo json_encode($xdatos);
}

function municipio()
{
    $id_departamento = $_POST["id_departamento"];
    $option = "<option value=''>Seleccione</option>";
    $sql_mun = _query("SELECT * FROM municipio WHERE id_departamento_municipio='$id_departamento'");
    while($mun_dt=_fetch_array($sql_mun))
    {
        $option .= "<option value='".$mun_dt["id_municipio"]."'>".$mun_dt["nombre_municipio"]."</option>";
    }
    echo $option;
}

//functions to load
if(!isset($_REQUEST['process'])){
	initial();
}
//else {
if (isset($_REQUEST['process'])) {


	switch ($_REQUEST['process']) {
	case 'insert':
		insertar();
		break;
	case 'traerdatos':
		traerdatos();
		break;
  case 'pedido':
		pedido();
		break;
	case 'consultar_stock':
		consultar_stock();
		break;
	case 'getpresentacion':
			getpresentacion();
			break;
  case 'datos_cliente':
			datos_cliente();
			break;
  case 'municipio':
      municipio();
      break;
	}

 //}
}
?>
