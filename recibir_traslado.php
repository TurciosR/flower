<?php
include_once "_core.php";

function initial()
{
  $title = "Recibir traslado";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  include_once "header.php";
  include_once "main_menu.php";

  $sql="SELECT * FROM producto";

  $id_traslado=$_REQUEST['id_movimiento'];

  $sql_tra=_fetch_array(_query("SELECT * FROM traslado WHERE id_traslado=$id_traslado"));
  $id_ubicacion_destino=$sql_tra['id_ubicacion_destino'];

  $result=_query($sql);
  $count=_num_rows($result);
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $fecha_actual=date("Y-m-d");
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
                    <label>Concepto</label>
                    <input type='text' class='form-control'  value='INGRESO  DE TRASLADO' id='concepto' name='concepto'>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group has-info">
                    <label>Destino</label>
                    <select class="form-control select" id="destino" name="destino">
                      <?php
                      $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal'    ORDER BY descripcion ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_ubicacion"]."'>".MAYU($row["descripcion"])."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class='col-lg-4'>
                  <div class='form-group has-info'>
                    <label>Fecha</label>
                    <input type='text' class='datepick form-control' disabled value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
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
                      <table class="table table-striped table-bordered table-condensed" id="inventable">
                        <thead>
                          <tr>
                            <th class="">Id</th>
                            <th class="col-lg-4">Nombre</th>
                            <th class="col-lg-1">Presentación</th>
                            <th class="col-lg-1">Descripción</th>
                            <th class="col-lg-1">Prec. C</th>
                            <th class="col-lg-1">Prec. V</th>
                            <th class="col-lg-1">Esperado</th>
                            <th class="col-lg-1">Recibido</th>
                            <th class="col-lg-1">Vence</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql_det=_query("SELECT * FROM traslado_detalle WHERE id_traslado=$id_traslado");
                          while ($row=_fetch_array($sql_det)) {
                            # code...
                            $sql_pro=_fetch_array(_query("SELECT * FROM producto WHERE id_producto=$row[id_producto]"));

                            $perecedero=$sql_pro['perecedero'];

                            if ($perecedero == 1)
                            {
                              $caduca = "<div class='form-group'><input type='text' class='datepicker form-control vence' value=''></div>";
                            }
                            else
                            {
                              $caduca = "<input type='hidden' class='vence' value='NULL'>";
                            }
                             $unit = "<input type='hidden' class='unidad' value='" . $row['unidad'] . "'>";

                             $id_sucursal=$_SESSION['id_sucursal'];

                             $i=0;
                             $unidadp=0;
                             $preciop=0;
                             $costop=0;
                             $descripcionp=0;

                             $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion WHERE prp.id_producto=$row[id_producto] AND prp.unidad=$row[unidad] AND prp.activo=1 ");
                             $select="<select class='sel'>";
                             while ($rows=_fetch_array($sql_p))
                             {
                                 $costop=$rows['costo'];
                                 $preciop=$rows['precio'];
                                 $descripcionp=$rows['descripcion'];

                               $select.="<option value='".$rows["id_presentacion"]."'>".$rows["nombre"]." (".$rows["unidad"].")</option>";
                               $i=$i+1;
                             }
                             $select.="</select>";



                            ?>
                            <tr>
                            <td class="id_p"> <?php echo $sql_pro['id_producto'] ?> </td>
                            <td> <?php echo $sql_pro['descripcion'] ?> </td>
                            <td> <?php echo $select ?> </td>
                            <td class="descp"> <?php echo $descripcionp ?> </td>
                            <td><div class=''> <?php echo $unit ?> <input type='text' readonly class='form-control precio_compra' value='<?php echo $row['costo'] ?> ' style='width:80px;'></div></td>
                            <td><div class=''><input type='text' readonly  class='form-control precio_venta' value='<?php echo $preciop ?>' style='width:80px;'></div></td>
                            <td><div class=''><input type='text' readonly  class='form-control esp' style='width:60px;' value='<?php echo intdiv($row['cantidad'],$row['unidad']) ?>'></div></td>
                            <td><div class=''><input type='text'   class='form-control cant' style='width:60px;' value='<?php echo intdiv($row['cantidad'],$row['unidad']) ?>'></div></td>
                            <td class='col-xs-2'> <?php echo $caduca ?> </td>
                            </tr>

                            <?php

                          }
                           ?>

                        </tbody>

                        <tfoot>
                          <tr>
                            <td></td>
                            <td>Total Dinero <strong>$</strong></td>
                            <td id='total_dinero'>$0.00</td>
                            <td colspan=4>Total Producto</td>
                            <td id='totcant'>0</td>
                            <td></td>
                          </tr>
                        </tfoot>

                      </table>
                      <input type="hidden" name="autosave" id="autosave" value="false-0">
                    </section>
                    <input type="hidden" name="process" id="process" value="insert"><br>
                    <div>
                      <input type="hidden" id="id_traslado" name="id_traslado" value="<?php echo $id_traslado ?>">
                      <input type="submit" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
                      <input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename ?> ">
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
  echo "<script src='js/funciones/funciones_recibir_traslado.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
}
}

function insertar()
{
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $destino = $_POST['destino'];
  $fecha = $_POST['fecha'];
  $total_compras = $_POST['total'];
  $concepto=$_POST['concepto'];
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_empleado=$_SESSION["id_usuario"];
  $id_traslado=$_POST["id_traslado"];

  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT trr FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["trr"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_TRR';
  $tipo_entrada_salida="INGRESO DE TRASLADO";

  _begin();
  $z=1;
  $y=1;
  $f=1;

  /*finalizar el traslado*/
  $table="traslado";
  $form_data = array(
    'finalizada' => 1,
    'id_empleado_recibe' => $id_empleado,
  );
  $where_clause="id_traslado='".$id_traslado."'";
  $update_tra=_update($table,$form_data,$where_clause);
  if ($update_tra) {
    # code...
  }
  else {
    # code...
    $y=0;
  }

  $sqlid_server=_fetch_array(_query("SELECT id_server,id_sucursal_origen,id_sucursal_destino FROM traslado WHERE id_traslado=$id_traslado"));
  $id_server_traslado=$sqlid_server['id_server'];
  $id_suc_o=$sqlid_server['id_sucursal_origen'];
  $id_suc_d=$sqlid_server['id_sucursal_destino'];
  $table_cambio="log_cambio_local";
  $form_data = array(
    'process' => 'update',
    'tabla' =>  "traslado",
    'fecha' => date("Y-m-d"),
    'hora' => date('H:i:s'),
    'id_usuario' => $_SESSION['id_usuario'],
    'id_sucursal' => $_SESSION['id_sucursal'],
    'id_primario' =>$id_traslado,
    'prioridad' => "2",
    'id_server' => $id_server_traslado,
  );
  $insert_cambio=_insert($table_cambio,$form_data);
  $id_cambio=_insert_id();

  echo _error();

  $table_detalle_cambio="log_detalle_cambio_local";
  $form_data = array(
    'id_log_cambio' => 	$id_cambio,
    'tabla' => 'traslado',
    'id_verificador' => $id_traslado
  );
  _insert($table_detalle_cambio,$form_data);
  echo _error();


  /*actualizar los correlativos de II*/
  $corr=1;
  $table="correlativo";
  $form_data = array(
    'TRR' =>$ult
  );
  $where_clause_c="id_sucursal='".$id_sucursal."'";
  $up_corr=_update($table,$form_data,$where_clause_c);
  if ($up_corr) {
    # code...
  }
  else {
    $corr=0;
  }
  if ($concepto=='')
  {
    $concepto='INGRESO DE TRASLADO';
  }
  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => $concepto,
    'total' => $total_compras,
    'tipo' => 'ENTRADA',
    'proceso' => 'TRR',
    'referencia' => $numero_doc,
    'id_empleado' => $id_empleado,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    'id_suc_destino' => $id_sucursal,
    'id_proveedor' => 0,
    'id_traslado' => $id_traslado,
  );
  $insert_mov =_insert($table,$form_data);
  $id_movimiento=_insert_id();
  $lista=explode('#',$datos);
  $j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;
  for ($i=0;$i<$cuantos ;$i++)
  {
    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion,$esp)=explode('|',$lista[$i]);
    $sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";
    $stock_su=_query($sql_su);
    $nrow_su=_num_rows($stock_su);
    $id_su="";
    /*cantidad de una presentacion por la unidades que tiene*/
    $cantidad=$cantidad*$unidades;
    $esp=$esp*$unidades;
    if($nrow_su >0)
    {
      $row_su=_fetch_array($stock_su);
      $cant_exis = $row_su["cantidad"];
      $id_su = $row_su["id_su"];
      $cant_new = $cant_exis + $cantidad;
      $form_data_su = array(
        'cantidad' => $cant_new,
      );
      $table_su = "stock_ubicacion";
      $where_su = "id_su='".$id_su."'";
      $insert_su = _update($table_su, $form_data_su, $where_su);
    }
    else
    {
      $form_data_su = array(
        'id_producto' => $id_producto,
        'id_sucursal' => $id_sucursal,
        'cantidad' => $cantidad,
        'id_ubicacion' => $destino,
      );
      $table_su = "stock_ubicacion";
      $insert_su = _insert($table_su, $form_data_su);
      $id_su=_insert_id();
    }
    if(!$insert_su)
    {
      $m=0;
    }
    $sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
    $stock2=_query($sql2);
    $row2=_fetch_array($stock2);
    $nrow2=_num_rows($stock2);
    if ($nrow2>0)
    {
      $existencias=$row2['stock'];
    }
    else
    {
      $existencias=0;
    }
    $sql_lot = _query("SELECT MAX(numero) AS ultimo FROM lote WHERE id_producto='$id_producto'");
    $datos_lot = _fetch_array($sql_lot);
    $lote = $datos_lot["ultimo"]+1;
    $table1= 'movimiento_producto_detalle';
    $cant_total=$cantidad+$existencias;
    $form_data1 = array(
      'id_movimiento'=>$id_movimiento,
      'id_producto' => $id_producto,
      'cantidad' => $cantidad,
      'costo' => $precio_compra,
      'precio' => $precio_venta,
      'stock_anterior'=>$existencias,
      'stock_actual'=>$cant_total,
      'lote' => $lote,
      'fecha' => date("Y-m-d"),
      'hora' => date('H:i:s'),
      'id_presentacion' => $id_presentacion,
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
        'costo_unitario'=>$precio_compra,
        'precio_unitario'=>$precio_venta,
        'create_date'=>$fecha_movimiento,
        'update_date'=>$fecha_movimiento,
        'id_sucursal' => $id_sucursal
      );
      $insert_stock = _insert($table2,$form_data2 );
    }
    else
    {
      $cant_total=$cantidad+$existencias;
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
    if ($fecha_caduca!="0000-00-00" && $fecha_caduca!="")
    {
      $sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' and fecha_entrada='$fecha_movimiento' and vencimiento='$fecha_caduca' ";
      $result_caduca=_query($sql_caduca);
      $row_caduca=_fetch_array($result_caduca);
      $nrow_caduca=_num_rows($result_caduca);
      /*if($nrow_caduca==0){*/
      $table_perece= 'lote';

      if($fecha_movimiento>=$fecha_caduca)
      {
        $estado='VENCIDO';
      }
      else
      {
        $estado='VIGENTE';
      }
      $form_data_perece = array(
        'id_producto' => $id_producto,
        'referencia' => $numero_doc,
        'numero' => $lote,
        'fecha_entrada' => $fecha_movimiento,
        'vencimiento'=>$fecha_caduca,
        'precio' => $precio_compra,
        'cantidad' => $cantidad,
        'estado'=>$estado,
        'id_sucursal' => $id_sucursal,
        'id_presentacion' => $id_presentacion,
      );
      $insert_lote = _insert($table_perece,$form_data_perece );
    }
    else
    {
      $sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' AND fecha_entrada='$fecha_movimiento'";
      $result_caduca=_query($sql_caduca);
      $row_caduca=_fetch_array($result_caduca);
      $nrow_caduca=_num_rows($result_caduca);
      $table_perece= 'lote';
      $estado='VIGENTE';

      $form_data_perece = array(
        'id_producto' => $id_producto,
        'referencia' => $numero_doc,
        'numero' => $lote,
        'fecha_entrada' => $fecha_movimiento,
        'vencimiento'=>$fecha_caduca,
        'precio' => $precio_compra,
        'cantidad' => $cantidad,
        'estado'=>$estado,
        'id_sucursal' => $id_sucursal,
        'id_presentacion' => $id_presentacion,
      );
      $insert_lote = _insert($table_perece,$form_data_perece );
    }
    if(!$insert_lote)
    {
      $l = 0;
    }

    $table="movimiento_stock_ubicacion";
    $form_data = array(
      'id_producto' => $id_producto,
      'id_origen' => 0,
      'id_destino'=> $id_su,
      'cantidad' => $cantidad,
      'fecha' => $fecha_movimiento,
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

    $sql_get_p=_fetch_array(_query("SELECT presentacion_producto.id_server,producto.id_server as id_server_prod FROM presentacion_producto JOIN producto ON presentacion_producto.id_producto=producto.id_producto WHERE id_presentacion=$id_presentacion"));
    //$presentacion=$sql_get_p['presentacion'];
    $id_server_presen=$sql_get_p['id_server'];
    $id_server_prod=$sql_get_p['id_server_prod'];

    $id_suc_o=$sqlid_server['id_sucursal_origen'];
    $id_suc_d=$sqlid_server['id_sucursal_destino'];
    $table='traslado_detalle_recibido';
    $form_data = array(
      'id_sucursal_origen' => $id_suc_o,
      'id_sucursal_destino' => $id_suc_d,
      'id_traslado' => $id_traslado,
      'id_traslado_server' => $id_server_traslado,
      'id_producto' => $id_producto,
      'id_server_prod' => $id_server_prod,
      'cantidad' => $esp,
      'recibido' => $cantidad,
      'unidad' => $unidades,
      'id_presentacion' => $id_presentacion,
      'id_server_presen' => $id_server_presen
    );
    $insert_tra_det=_insert($table,$form_data);
    $id_dtr=_insert_id();
    if ($insert_tra_det) {
      # code...
    }
    else {
      # code...
      $f=0;
    }



    $table_cambio="log_cambio_local";
    $form_data = array(
      'process' => 'insert',
      'tabla' =>  "traslado_detalle_recibido",
      'fecha' => date("Y-m-d"),
      'hora' => date('H:i:s'),
      'id_usuario' => $_SESSION['id_usuario'],
      'id_sucursal' => $_SESSION['id_sucursal'],
      'id_primario' =>$id_dtr,
      'prioridad' => "2",
    );
    $insert_cambio=_insert($table_cambio,$form_data);
    $id_cambio=_insert_id();

    $table_detalle_cambio="log_detalle_cambio_local";
    $form_data = array(
      'id_log_cambio' => 	$id_cambio,
      'tabla' => 'traslado_detalle_recibido',
      'id_verificador' => $id_dtr
    );
    _insert($table_detalle_cambio,$form_data);


  }
  if($insert_mov &&$corr &&$z && $j && $k && $l && $m && $y && $f)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con exito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!'.$f;
  }
  echo json_encode($xdatos);
}
function consultar_stock()
{
  $id_producto = $_REQUEST['id_producto'];
  $id_sucursal=$_SESSION['id_sucursal'];

  $i=0;
  $unidadp=0;
  $preciop=0;
  $costop=0;
  $descripcionp=0;

  $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.presentacion WHERE prp.id_producto=$id_producto AND prp.activo=1 AND prp.id_sucursal=$id_sucursal");
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
  $xdatos['select']= $select;
  $xdatos['costop']= $costop;
  $xdatos['preciop']= $preciop;
  $xdatos['unidadp']= $unidadp;
  $xdatos['descripcionp']= $descripcionp;
  $xdatos['i']=$i;

  $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
  $result_perece=_query($sql_perece);
  $row_perece=_fetch_array($result_perece);
  $perecedero=$row_perece['perecedero'];
  $xdatos['perecedero'] = $perecedero;
  echo json_encode($xdatos);
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
    case 'insert':
    insertar();
    break;
    case 'consultar_stock':
    consultar_stock();
    break;
    case 'getpresentacion':
    getpresentacion();
    break;
    case'traerpaginador':
    traerpaginador();
    break;
  }
}
?>
