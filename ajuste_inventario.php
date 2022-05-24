<?php
include_once "_core.php";

function initial()
{
  $title = "Ajuste Inventario";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
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

                    <form id="frm1" class="" target="_blank" action="hoja_conteo.php" method="post">
                        <input type="hidden" id="params" name="params" value="">
                        <input type="hidden" id="cu" name="cu" value="">
                    </form>

                    <div class='row' id='form_invent_inicial'>
                        <div class="col-lg-4">
                            <div class="form-group has-info">
                                <label>Concepto</label>
                                <input type='text' class='form-control' value='AJUSTE INVENTARIO' id='concepto'
                                    name='concepto'>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group has-info">
                                <label>Origen</label>
                                <select class="form-control select" id="destino" name="destino">
                                    <?php
                      $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
                      }
                      ?>
                                </select>
                            </div>
                        </div>
                        <div class='col-lg-4'>
                            <div class='form-group has-info'>
                                <label>Fecha</label>
                                <input type='text' readonly class='datepick form-control'
                                    value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                            </div>
                        </div>
                    </div>
                    <div class="row" id='buscador'>
                        <div class="col-lg-4">
                            <label id='buscar_habilitado'>Buscar Producto (Descripción)</label>
                            <div id="scrollable-dropdown-menu">
                                <input type="text" id="producto_buscar" name="producto_buscar"
                                    style="width:100% !important" class=" form-control usage typeahead"
                                    placeholder="Ingrese la Descripción de producto" data-provide="typeahead"
                                    style="border-radius:0px">
                            </div>
                        </div>
                        <div hidden class="col-lg-4">
                            <div class="form-group has-info">
                                <label>Categoría</label>
                                <select class="form-control select" id="categoria" name="categoria">
                                    <option value="">NINGUNA</option>
                                    <?php
                      $sql = _query("SELECT * FROM categoria ORDER BY nombre_cat ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_categoria"]."'>".$row["nombre_cat"]."</option>";
                      }
                      ?>
                                </select>
                            </div>
                        </div>
                        <div hidden class="col-lg-2  ">

                        </div>
                        <div hidden class="col-lg-2">
                            <?php
                  $filename='hoja_conteo.php';
                  $link=permission_usr($id_user,$filename);
                  if ($link!='NOT' || $admin=='1' )
                  ?>
                            <label>Hoja de Conteo</label>
                            <button type="button" class="btn btn-info form-control" id="generar"
                                name="generar">Generar</button>
                            <?php
                   ?>

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
                                                <th class="col-lg-1">Id</th>
                                                <th class="col-lg-2">Nombre</th>
                                                <th class="col-lg-1">Presentación</th>
                                                <th class="col-lg-1">Descripción</th>
                                                <th class="col-lg-1">Prec. C</th>
                                                <th class="col-lg-1">Prec. V</th>
                                                <th class="col-lg-1">Existencia</th>
                                                <th class="col-lg-1">Cantidad</th>
                                                <th class="col-lg-1">Vence</th>
                                                <th class="col-lg-1">Acci&oacute;n</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td>Total Dinero <strong>$</strong></td>
                                                <td id='total_dinero'>$0.00</td>
                                                <td colspan=2>Total Producto</td>
                                                <td id='totcant'>0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="autosave" id="autosave" value="false-0">
                                </section>
                                <input type="hidden" name="process" id="process" value="insert"><br>
                                <div>

                                    <input type="submit" id="submit1" name="submit1" value="Guardar"
                                        class="btn btn-primary m-t-n-xs" />
                                    <input type='hidden' name='urlprocess' id='urlprocess'
                                        value="<?php echo $filename ?> ">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--div class='ibox-content'-->
            </div>
        </div>
    </div>
</div>

<?php
  include_once ("footer.php");
  echo "<script src='js/funciones/funciones_ajuste_inventario.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  include_once ("footer.php");
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


  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT aj FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["aj"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_AJ';

  _begin();

  $z=1;

  /*actualizar los correlativos de II*/
  $corr=1;
  $table="correlativo";
  $form_data = array(
    'aj' =>$ult
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
    $concepto='AJUSTE DE INVENTARIO';
  }

  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => $concepto,
    'total' =>  0,
    'tipo' => 'AJUSTE',
    'proceso' => 'AJ',
    'referencia' => $numero_doc,
    'id_empleado' => $id_empleado,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    'id_suc_destino' => $id_sucursal,
    'id_proveedor' => 0,
    'id_server' => 0,
    'id_compra' => 0,
    'id_traslado' => 0,
    'id_factura' => 0,
    'numero' => '0',
    'conteo' => '0',
    'sistema' => '0'
  );
  $insert_mov =_insert($table,$form_data);
  $id_movimiento=_insert_id();
  $lista=explode('#',$datos);
  $j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;

  $var1=0;
  $var2=0;

  for ($i=0;$i<$cuantos ;$i++)
  {
    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);
    $q=_query("SELECT movimiento_producto_detalle.id_producto FROM movimiento_producto JOIN movimiento_producto_detalle ON movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento WHERE movimiento_producto.fecha='$fecha' AND movimiento_producto.hora='$hora' AND movimiento_producto_detalle.id_producto=$id_producto");
    $NR=_num_rows($q);

    if ($NR==0) {


      $sql_e_m=_query("SELECT stock_ubicacion.id_su,stock_ubicacion.cantidad FROM stock_ubicacion WHERE stock_ubicacion.id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$destino AND cantidad>0");
      while ($row_e_m=_fetch_array($sql_e_m)) {
        # code...

        /*arreglando problema con lotes de nuevo*/
        $cantidad_a_descontar=$row_e_m['cantidad'];
        $sql=_query("SELECT id_lote, id_producto, fecha_entrada, vencimiento, cantidad
        FROM lote
        WHERE id_producto='$id_producto'
        AND id_sucursal='$id_sucursal'
        AND cantidad>0
        ORDER BY vencimiento");

        $contar=_num_rows($sql);

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

        /*obtener el valor del stock*/
        $sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
        $stock2=_query($sql2);
        $row2=_fetch_array($stock2);
        $nrow2=_num_rows($stock2);
        $existencias=0;
        if ($nrow2>0)
        {
          $existencias=$row2['stock'];
        }
        else
        {
          $existencias=0;
        }

        /*realizar el movimiento de vaciado del stock*/
        $cant_new=$existencias-$row_e_m['cantidad'];
        $table1= 'movimiento_producto_detalle';
        $form_data1 = array(
          'id_movimiento'=>$id_movimiento,
          'id_producto' => $id_producto,
          'cantidad' => $row_e_m['cantidad'],
          'costo' => $precio_compra,
          'precio' => $precio_venta,
          'stock_anterior'=>$existencias,
          'stock_actual'=>$cant_new,
          'lote' => 0,
          'id_presentacion' => 0,
          'hora'=>date("H:i:s"),
          'fecha' =>date("Y-m-d"),
          'id_server' => '0',
          'id_sucursal' => $id_sucursal,
          'id_server_prod' => '0',
          'id_server_presen' => '0',
          'proceso' => '0',
          'referencia' => '',

        );
        $insert_mov_det = _insert($table1,$form_data1);
        if(!$insert_mov_det)
        {
          $j = 0;
        }

        //actualizar stock restando el valor de la ubicación especifica;
        $table= 'stock';
        $form_data = array(
           'stock' => $cant_new,
           'update_date'=>$fecha_movimiento,
          );
        $where_clause="id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
        $updateP=_update($table, $form_data, $where_clause);

        /*vaciamos la ubicaciones donde se encuentra ese producto ya sea de bodega local u otro*/
        $form_data_su = array(
          'cantidad' => 0,
        );
        $table_su = "stock_ubicacion";
        $where_su = "id_su='".$row_e_m['id_su']."'";
        $insert_su = _update($table_su, $form_data_su, $where_su);

        //registramos la salida

        $table="movimiento_stock_ubicacion";
        $form_data = array(
          'id_producto' => $id_producto,
          'id_origen' => $row_e_m['id_su'],
          'id_destino'=> 0,
          'cantidad' => $row_e_m['cantidad'],
          'fecha' => $fecha_movimiento,
          'hora' => $hora,
          'anulada' => 0,
          'afecta' => 0,
          'id_sucursal' => $id_sucursal,
          'id_presentacion'=> 0,
          'id_mov_prod' => $id_movimiento,
          'id_server' => '0',
          'id_server_prod' => '0',
          'id_server_presen' => '0'
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
  }


  $lista=explode('#',$datos);
  for ($i=0;$i<$cuantos ;$i++)
  {
    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);
    $sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";
    $stock_su=_query($sql_su);
    $nrow_su=_num_rows($stock_su);
    $id_su="";
    /*cantidad de una presentacion por la unidades que tiene*/
    $cantidad=$cantidad*$unidades;
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
        'id_server' => '0',
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
      'id_presentacion' => $id_presentacion,
      'hora'=>date("H:i:s"),
      'fecha' =>date("Y-m-d"),
      'id_server' => '0',
      'id_sucursal' => $id_sucursal,
      'id_server_prod' => '0',
      'id_server_presen' => '0',
      'proceso' => '0',
      'referencia' => '',
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
    if ($fecha_caduca!="0000-00-00" && $fecha_caduca!="" && $fecha_caduca != 'undefined' && $fecha_caduca != "NULL")
    {
      $sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' and fecha_entrada='$fecha_movimiento' and vencimiento='$fecha_caduca' ";
      $result_caduca=_query($sql_caduca);
      $row_caduca=_fetch_array($result_caduca);
      $nrow_caduca=_num_rows($result_caduca);
      /*if($nrow_caduca==0){*/
      $table_perece= 'lote';

      if($fecha_movimiento>=$fecha_caduca)
      {
        $estado='VIGENTE';
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
        'id_server' => 0
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
        'precio' => $precio_compra,
        'cantidad' => $cantidad,
        'estado'=>$estado,
        'id_sucursal' => $id_sucursal,
        'id_presentacion' => $id_presentacion,
        'id_server' => 0
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
      'id_server' => '0',
      'id_server_prod' => '0',
      'id_server_presen' => '0'
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
  if($insert_mov &&$corr &&$z && $j && $k && $l && $m)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con exito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!';
  }
  echo json_encode($xdatos);
}
function consultar_stock()
{
  $id_producto = $_REQUEST['id_producto'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $origen=$_REQUEST['origen'];

  $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$origen'");
  $dt_existencia = _fetch_array($sql_existencia);
  $existencia = $dt_existencia["existencia"];

  $i=0;
  $unidadp=0;
  $preciop=0;
  $costop=0;
  $descripcionp=0;

  $array[]=array();
  $arrays[]=array();
  $arrayu[]=array();
  $arrayp[]=array();
  $arraypre[]=array();
  $array_e[]=array();

  $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion WHERE prp.id_producto=$id_producto AND prp.activo=1  ORDER BY prp.unidad DESC");

  $npres = _num_rows($sql_p);
  $j=1;
  while ($row=_fetch_array($sql_p))
  {
    $select="<select class='sel form-control'>";
    $array[$i]=$costop=$row['costo'];
    $arrayu[$i]=  $unidadp=$row['unidad'];
    $precio=$row['precio'];
    $arrayp[$i]= $precio;
    $arraypre[$i]=  $descripcionp=$row['descripcion'];
    $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
    $select.="</select>";
    $arrays[$i]=$select;

    if($existencia >= $unidadp)
    {
      if ($existencia>0&& $npres == $j) {
        // code...
        $exis = round($existencia/$unidadp,4);
      }
      else {
        $exis = intdiv($existencia, $unidadp);
        $existencia = $existencia - ($exis *$unidadp);
      }
    }
    else
    {
      if ($existencia>0&& $npres == $j) {
        // code...
        $exis = round($existencia/$unidadp,4);
      }
      else {
        // code...

        $exis =  0;
      }
    }

    $a= $exis;
    $array_e[$i]=$a;
    $i=$i+1;
    $j++;
  }


  $xdatos['select']= $arrays;
  $xdatos['costop']= $array;
  $xdatos['preciop']= $arrayp;
  $xdatos['unidadp']= $arrayu;
  $xdatos['descripcionp']= $arraypre;
  $xdatos['existencia']= $array_e;
  $xdatos['i']=$i;

  $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
  $result_perece=_query($sql_perece);
  $row_perece=_fetch_array($result_perece);
  $perecedero=$row_perece['perecedero'];
  $xdatos['perecedero'] = $perecedero;
  $xdatos['decimals'] = $row_perece['decimals'];
  $xdatos['categoria'] = $row_perece['id_categoria'];
  echo json_encode($xdatos);
}
function getpresentacion()
{
  echo json_encode(getPre());
}
function getids()
{
  $id_categoria=$_REQUEST['id_categoria'];
  $id_ubicacion=$_REQUEST['id_ubicacion'];

  $sql_ids=_query("SELECT DISTINCT stock_ubicacion.id_producto,producto.descripcion  FROM stock_ubicacion JOIN producto  ON  producto.id_producto=stock_ubicacion.id_producto WHERE producto.id_categoria=$id_categoria AND stock_ubicacion.id_ubicacion=$id_ubicacion");
  $i=_num_rows($sql_ids);
  $array[]=array();
  $arrayd[]=array();
  $j=0;
  while ($row=_fetch_array($sql_ids))
  {
    $array[$j]=$row['id_producto'];
    $arrayd[$j]=$row['descripcion'];
    $j=$j+1;
  }

  $xdatos['i']=$i;
  $xdatos['array']=$array;
  $xdatos['arrayd']=$arrayd;
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
    case'getids':
    getids();
    break;
  }
}
?>