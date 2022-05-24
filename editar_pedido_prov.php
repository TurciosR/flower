  <?php
  include_once "_core.php";

  function initial()
  {
    $title = "Editar Pedido";
    $_PAGE = array();
    $_PAGE ['title'] = $title;
    $_PAGE ['links'] = null;
    $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
    $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

    include_once "header.php";
    include_once "main_menu.php";
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];
    $id_sucursal=$_SESSION["id_sucursal"];
    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user, $filename);
    $fecha_actual=date("Y-m-d");
    //para llenar fieds
    $id_pedido_prov=$_REQUEST["id_pedido_prov"];
    $sql_pedido_prov=_fetch_array(_query("SELECT pv.nombre, p.id_proveedor, p.fecha, p.fecha_entrega, p.total
      FROM pedido_prov as p
      JOIN proveedor as pv ON p.id_proveedor=pv.id_proveedor
      WHERE p.id_pedido_prov='$id_pedido_prov'
      AND p.id_sucursal='$id_sucursal'"));

    ?>

    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-2"></div>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox">
            <div class="ibox-title">
              <h5><?php echo $title;?></h5>
            </div>
            <?php if ($links!='NOT' || $admin=='1') { ?>
              <div class="ibox-content">

                <div class='row' id='form_invent_inicial'>
                  <div class="col-lg-4">
                    <div class="form-group has-info">
                      <label>Proveedor</label>
                      <input type='text' class='form-control'  id='cliente_buscar' name='cliente_buscar' value="<?php echo $sql_pedido_prov['id_proveedor']." | ".$sql_pedido_prov['nombre'];?>">
                    </div>
                  </div>
                  <div class='col-lg-4'>
                    <div class='form-group has-info'>
                      <label>Fecha Creación</label>
                      <input type='text' class='datepick form-control' value="<?php echo $sql_pedido_prov['fecha'];?>" id='fecha' name='fecha'>
                    </div>
                  </div>
                  <div class='col-lg-4'>
                    <div class='form-group has-info'>
                      <label>Fecha Pedido</label>
                      <input type='text' class='datepick form-control' value="<?php echo $sql_pedido_prov['fecha_entrega'];?>" id='fecha2' name='fecha2'>
                    </div>
                  </div>
                </div>
                <div class="row" id='buscador'>
                  <div class="col-lg-6">
                    <div class='form-group has-info'><label>Buscar Productos</label>
                      <input type="text" id="producto_buscar" name="producto_buscar" size="20" class="producto_buscar form-control" placeholder="Ingrese nombre de producto"  data-provide="typeahead">
                    </div>
                  </div>
                </div>
                <div class="ibox">
                  <div class="row">
                    <div class="ibox-content">
                      <!--load datables estructure html-->
                      <header>
                        <h4 class="text-navy">Lista de Productos</h4>
                      </header>
                      <section>
                        <table class="table table-striped table-bordered table-condensed">
                          <thead>
                            <tr>
                              <th class="col-lg-1">Id</th>
                              <th class="col-lg-4">Nombre</th>
                              <th class="col-lg-1">Presentación</th>
                              <th class="col-lg-1">Descripción</th>
                              <th class="col-lg-2">Prec. V</th>
                              <th class="col-lg-1">Stock</th>
                              <th class="col-lg-2">Cantidad</th>
                              <th class="col-lg-1">Subtotal</th>
                              <th class="col-lg-1">Acci&oacute;n</th>
                            </tr>
                          </thead>

                          <tbody id="pedido_provtable">
                          <?php

                            $sql_p=_query("SELECT producto.id_producto,producto.id_categoria, producto.descripcion AS producto, presentacion.nombre,presentacion_producto.id_presentacion ,presentacion_producto.descripcion, presentacion_producto.unidad ,pedido_prov_detalle.id_pedido_detalle,pedido_prov_detalle.precio_venta, pedido_prov_detalle.cantidad, pedido_prov_detalle.subtotal, stock.stock
                              FROM pedido_prov_detalle
                              JOIN producto ON (pedido_prov_detalle.id_producto=producto.id_producto)
                              JOIN presentacion_producto ON (pedido_prov_detalle.id_presentacion=presentacion_producto.id_presentacion)
                              JOIN presentacion ON (presentacion_producto.presentacion=presentacion.id_presentacion)
                              JOIN stock ON (pedido_prov_detalle.id_producto=stock.id_producto)
                              WHERE pedido_prov_detalle.id_pedido='$id_pedido_prov'");


                            $cantidad=0;
                             while ( $filas=_fetch_array($sql_p))
                             {
                               $id_producto=$filas['id_producto'];

                              $id_presentacion=$filas['id_presentacion'];
                              echo "<tr id_pedido_prov_detalle='".$filas['id_pedido_detalle']."'>";
                              echo "<td class='id_p'>".$filas['id_producto']."</td>";
                              echo "<td>".$filas['producto']."</td>";
                              echo "<td>";
                              $sql_prese=_query("SELECT presentacion.nombre as presentacion_p, prp.id_presentacion, prp.unidad
                                FROM presentacion_producto AS prp
                                JOIN presentacion ON presentacion.id_presentacion=prp.presentacion, producto
                                WHERE prp.id_producto='$id_producto' AND prp.activo=1 AND producto.id_producto='$id_producto' AND prp.id_sucursal='$id_sucursal' ");
                              echo "<select class='sel'>";
                              while ($row=_fetch_array($sql_prese))
                              {
                                echo "<option value='".$row["id_presentacion"]."'";
                                if($id_presentacion==$row["id_presentacion"] ){ echo " selected "; }
                              echo ">".$row["presentacion_p"]."(".$row["unidad"].")</option>";
                              }
                              echo "</select>";
                              "</td>";

                              $select_rank="<select class='sel_r precio_r form-control'>";
                              $select_rank.="<option value='$filas[precio_venta]'";
                              $select_rank.="selected";
                              $select_rank.=">$filas[precio_venta]</option>";
                              $select_rank.="</select>";

                              echo "<td class='descp'>".$filas['descripcion']."</td>";
                              echo "<td class='rank_s'>".$select_rank."</td>";
                              echo "<td><div class='col-xs-1'><input type='hidden' class='unidad' value='".$filas['unidad']."'><input type='text' readonly value='".($filas['stock'])."' style='width:60px;' class='existencia'></div></td>";
                              echo "<td><div class='col-xs-1'><input type='text' value='".round($filas['cantidad'],4)."'  class='form-control cant $filas[id_categoria]' style='width:60px;' ></div></td>";
                              echo "<td class='col-xs-2'><input type='text'readonly class='form-control vence subt' readonly  value='".$filas['subtotal']."'></td>";
                              echo "<td class='text-center DeletePro'><a style='color:red;'><i class='fa fa-trash'></i></a></td>";
                              echo "</tr>";
                              $cantidad+=$filas['cantidad'];
                              }
                          ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="6" class="text-center">Total<strong></strong></td>
                              <td id='totcant' class="text-center"><?php echo $cantidad;?></td>
                              <td id='total_dinero' class="text-center"><?php echo $sql_pedido_prov['total'];?></td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                        <input type="hidden" name="autosave" id="autosave" value="false-0">
                      </section>
                      <input type="hidden" name="process" id="process" value="insert"><br>
                      <div>
                      <input type="hidden" id="processo" name="processo" value="editar" class="btn btn-primary m-t-n-xs" />
                      <input type="hidden" id="id_pedido_prov" name="id_pedido_prov" value="<?php echo $id_pedido_prov;?>" class="btn btn-primary m-t-n-xs" />
                        <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
                        <input type='hidden' name='urlprocess' id='urlprocess' value="<?php echo $filename ?> ">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div><!--div class='ibox-content'-->
          </div>
        </div>
      </div>
    </div>

    <?php
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_pedido_prov.js'></script>";
  } //permiso del script
  else {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  }
  }

  function modificar()
  {
    $cuantos = $_POST['cuantos'];
    $datos = $_POST['datos'];
    $fecha_m = $_POST['fecha_m'];
    $fecha_e = $_POST['fecha_e'];
    $total_compras = $_POST['total'];
    $id_cliente=$_POST['id_cliente'];
    $lugar_entrega=$_POST['lugar_entrega'];
    $id_pedido_prov=$_POST['id_pedido_prov'];
    $hora=date("H:i:s");
    $fecha_movimiento = date("Y-m-d");
    $id_empleado=$_SESSION["id_usuario"];
    $reservado=$_POST['reservado'];
    $id_sucursal = $_SESSION["id_sucursal"];
    _begin();
    $z=1;
    //Validamos si es resarvado para descontar del stock
    $reserva=false;
    if($reservado==1)
    {
      $reserva=true;
    }
    $table='pedido_prov';
    $form_data = array(
      'id_cliente' => $id_cliente,
      'fecha' => $fecha_m,
      'total' => $total_compras,
      'id_empleado_proceso' => $id_empleado,
      'total' => $total_compras,
      'fecha_entrega' => $fecha_e,
      'lugar_entrega' => $lugar_entrega,
      'reservado' => $reservado,
    );
    $where_clause_c="id_pedido_prov='".$id_pedido_prov."'";
    $up_pedido_prov=_update($table,$form_data,$where_clause_c);
    $lista=explode('#',$datos);
    $m = 1 ;
    if(!$up_pedido_prov){
      $m=0;
    }
    for ($i=0;$i<$cuantos ;$i++)
    {
      list($id_producto,$precio_compra,$precio_venta,$cantidad,$sutto,$id_presentacion,$id_pedido_prov_detalle)=explode('|',$lista[$i]);
        $tablee='pedido_prov_detalle';
        $form_data_detalle = array(
          'cantidad' => $cantidad,
          'id_presentacion' => $id_presentacion,
          'precio_venta'=> $precio_venta,
          'subtotal'=>$sutto,
        );
        if($id_pedido_prov_detalle>0)
        {
          $where_clause_d="id_pedido_prov_detalle='".$id_pedido_prov_detalle."'";
          $up_pedido_prov_detalle=_update($tablee,$form_data_detalle,$where_clause_d);
        }else
        {
          $table_i='pedido_prov_detalle';
          $form_data_detalle_i = array(
            'id_pedido_prov' => $id_pedido_prov,
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'id_presentacion' => $id_presentacion,
            'precio_venta' => $precio_venta,
            'subtotal'=>$sutto,
          );
        $insert_pedido_prov_detalle = _insert($table_i,$form_data_detalle_i);
        }
        /*if($reserva==true)
        {
            $get_stock=_query("SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'");
            $get_value=_fetch_array($get_stock);
            $value_stock=$get_value['stock'];
            $stock_opera=$value_stock-$cantidad;
            $table_stock='stock';
            $form_data_stock = array(
              'stock' => $stock_opera,
            );
            $where_clause_stock="id_producto='".$id_producto."' AND id_sucursal='".$id_sucursal."'";
            $updating_stock=_update($table_stock,$form_data_stock,$where_clause_stock);

        }*/
      }
    if($m)
    {
      _commit();
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='pedido_prov actualizado con exito!';
    }
    else
    {
      _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='pedido_prov no pudo ser ingresado!'._error();
    }
    echo json_encode($xdatos);
  }
  function consultar_stock()
  {
    $id_producto = $_REQUEST['id_producto'];
    $id_sucursal=$_SESSION['id_sucursal'];
    $id_pedido_prov=$_REQUEST['id_pedido_prov'];

    $i=0;
    $unidadp=0;
    $preciop=0;
    $costop=0;
    $descripcionp=0;

    $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.presentacion WHERE prp.id_producto=$id_producto AND prp.activo=1
      AND prp.id_sucursal=$_SESSION[id_sucursal]");
    $select_rank="<select class='sel_r precio_r form-control'>";
    $select="<select class='sel'>";
    while ($row=_fetch_array($sql_p))
    {
      if ($i==0)
      {
        $unidadp=$row['unidad'];
        $costop=$row['costo'];
        $preciop=$row['precio'];
        $descripcionp=$row['descripcion'];

        $xc=0;

        $sql_rank=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$row[id_presentacion] AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] AND presentacion_producto_precio.precio!=0 ORDER BY presentacion_producto_precio.desde ASC LIMIT 1
          ");

          while ($rowr=_fetch_array($sql_rank)) {
            # code...
            $select_rank.="<option value='$rowr[precio]'";
            if($xc==0)
            {
              $select_rank.="selected";
              $preciop=$rowr['precio'];
            }
            $select_rank.=">$rowr[precio]</option>";
          }
          if (_num_rows($sql_rank)==0) {
            # code...
            $select_rank.="<option value='$preciop'";
            $select_rank.="selected";
            $select_rank.=">$preciop</option>";
          }
          $select_rank.="</select>";
      }
      $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
      $i=$i+1;
    }
    $select.="</select>";
    $xdatos['select']= $select;
    $xdatos['costop']= $costop;
    $xdatos['preciop']= $preciop;
    $xdatos['unidadp']= $unidadp;
    $xdatos['descripcionp']= $descripcionp;

    $sql_reserva=_fetch_array(_query("SELECT SUM((pedido_prov_detalle.cantidad*presentacion_producto.unidad)) AS reservado FROM pedido_prov_detalle JOIN pedido_prov ON pedido_prov.id_pedido_prov=pedido_prov_detalle.id_pedido_prov JOIN presentacion_producto ON presentacion_producto.id_presentacion=pedido_prov_detalle.id_presentacion WHERE pedido_prov_detalle.id_producto='$id_producto' AND pedido_prov.reservado=1 AND pedido_prov.id_sucursal=$_SESSION[id_sucursal]"));
    $reservado=$sql_reserva['reservado'];
    $reservado=round($reservado,2);

    $sql_reserva=_fetch_array(_query("SELECT SUM((pedido_prov_detalle.cantidad*presentacion_producto.unidad)) AS reservado FROM pedido_prov_detalle JOIN pedido_prov ON pedido_prov.id_pedido_prov=pedido_prov_detalle.id_pedido_prov JOIN presentacion_producto ON presentacion_producto.id_presentacion=pedido_prov_detalle.id_presentacion WHERE pedido_prov_detalle.id_producto='$id_producto' AND pedido_prov.reservado=1 AND pedido_prov.id_pedido_prov=$id_pedido_prov AND pedido_prov.id_sucursal=$_SESSION[id_sucursal]"));
    $reservado_yo=$sql_reserva['reservado'];
    $reservado_yo=round($reservado_yo,2);



    $sql_perece="SELECT * FROM producto, stock WHERE producto.id_producto='$id_producto' AND producto.id_producto=stock.id_producto AND stock.id_sucursal='$id_sucursal'";
    $result_perece=_query($sql_perece);
    $row_perece=_fetch_array($result_perece);
    $nombrep=$row_perece['descripcion'];
    $xdatos['nombre'] = $nombrep;
    $stock=$row_perece['stock'];
    $xdatos['stock'] = $stock-$reservado+$reservado_yo;
    $xdatos['categoria'] = $row_perece['id_categoria'];
    $xdatos['select_rank'] = $select_rank;

    echo json_encode($xdatos);
  }
  function eliminar_producto()
  {
    $id_pedido_prov_detalle=$_POST['id_pedido_prov_detalle'];
    $table = 'pedido_prov_detalle';
  	//$where_clause = "id_producto='$id_producto' AND id_pedido_prov='$id_pedido_prov'";
    _begin();
    $where_clause = "id_pedido_prov_detalle='".$id_pedido_prov_detalle."'";
  	$delete = _delete ( $table, $where_clause );
  	if ($delete)
  	{
      _commit();
      $xdatos ['typeinfo'] = 'Success';
      $xdatos ['msg'] = 'Producto eliminado del pedido_prov!';
  	}
  	else
  	{ _rollback();
  		$xdatos ['typeinfo'] = 'Error';
  		$xdatos ['msg'] = 'Producto no pudo ser elimimado del pedido_prov!';
  	}
  	echo json_encode ( $xdatos );
  }
  function getpresentacion()
  {
    $id_presentacion =$_REQUEST['id_presentacion'];
    $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
    $precio=$sql['precio'];
    $unidad=$sql['unidad'];
    $descripcion=$sql['descripcion'];
    $costo=$sql['costo'];
    $xdatos['precio']=$precio;
    $xdatos['costo']=$costo;
    $xdatos['unidad']=$unidad;
    $xdatos['descripcion']=$descripcion;
    echo json_encode($xdatos);
  }
  if (!isset($_REQUEST['process']))
  {
    initial();
  }
  if (isset($_REQUEST['process']))
  {
    switch ($_REQUEST['process'])
    {
      case 'editar':
      modificar();
      break;
      case 'consultar_stock':
      consultar_stock();
      break;
      case 'getpresentacion':
      getpresentacion();
      break;
      case 'eliminar_pro':
      eliminar_producto();
      break;
    }
  }
  ?>
