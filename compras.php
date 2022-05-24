<?php
include_once "_core.php";

function initial()
{
  $title = "Compra de producto";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/bootstrap-checkbox/bootstrap-checkbox.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main_co.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/plugins/perfect-scrollbar/perfect-scrollbar.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util_co.css">';

  include_once "header.php";
  //  include_once "main_menu.php";

  $sql="SELECT * FROM producto";

  $result=_query($sql);
  $count=_num_rows($result);
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $id_sucursal=$_SESSION["id_sucursal"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $fecha_actual=date("Y-m-d");

  $iva=0;
  $sql_iva="select iva,monto_retencion1,monto_retencion10,monto_percepcion FROM sucursal WHERE  id_sucursal=$_SESSION[id_sucursal]";
  $result_IVA=_query($sql_iva);
  $row_IVA=_fetch_array($result_IVA);
  $iva=$row_IVA['iva']/100;
  $monto_percepcion=$row_IVA['monto_percepcion'];

  ?>
<div class="gray-bg">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <?php if ($links!='NOT' || $admin=='1') { ?>
                    <div class="ibox-content">

                        <div class='row'>
                            <div hidden class="col-lg-4">
                                <div class="form-group has-info">
                                    <label>Concepto</label>
                                    <input type='text' class='form-control' value='COMPRA DE PRODUCTO' id='concepto'
                                        name='concepto'>
                                </div>
                            </div>

                            <div class='col-lg-3'>
                                <div class='form-group has-info'>
                                    <label>Proveedor</label>

                                    <select class="form-control select " id="id_proveedor" name="id_proveedor">
                                        <option value="">Seleccione</option>
                                        <?php
                        $sql_proveedor=_query("SELECT proveedor.id_proveedor, proveedor.nombre FROM proveedor ORDER BY nombre");
                        while ($row=_fetch_array($sql_proveedor)) {
                          # code...
                          ?>
                                        <option value="<?php echo $row['id_proveedor'] ?>"><?php echo $row['nombre'] ?>
                                        </option>
                                        <?php
                        }
                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group has-info'>
                                    <label>Documento</label>

                                    <select class="form-control select " id="tipo_doc" name="tipo_doc">
                                        <option value="CCF">CREDITO FISCAL</option>
                                        <option value="COF">CONSUMIDOR FINAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-lg-3'>
                                <div class='form-group has-info'>
                                    <label>Numero de Documento</label>
                                    <input type="text" class="form-control" id="numero_doc" name="numero_doc">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <label>Dias Credito</label>

                                <input class="form-control" id="numero_dias" name="numero_dias">
                            </div>
                            <div class='col-lg-2'>
                                <div class='form-group has-info'>
                                    <label>Fecha</label>
                                    <input type='text' class='datepick form-control'
                                        value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                                </div>
                            </div>
                        </div>
                        <div class="row focuss" id="buscador">
                            <div class="form-group col-md-4">
                                <div id="a">
                                    <label>Buscar Producto (Código)</label>
                                    <input type="text" id="codigo" name="codigo" style="width:100% !important"
                                        class="form-control usage" placeholder="Ingrese Código de producto"
                                        style="border-radius:0px">
                                </div>
                                <div hidden id="b">
                                    <label id='buscar_habilitado'>Buscar Producto (Descripción)</label>
                                    <div id="scrollable-dropdown-menu">
                                        <input type="text" id="producto_buscar" name="producto_buscar"
                                            style="width:100% !important" class=" form-control usage typeahead"
                                            placeholder="Ingrese la Descripción de producto" data-provide="typeahead"
                                            style="border-radius:0px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group has-info">
                                    <label>Destino</label>
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
                            <div class="col-lg-3">
                                <br>
                                <a class="btn btn-danger pull-right" style="margin-left:3%;" href="dashboard.php"
                                    id='salir'><i class="fa fa-mail-reply"></i> F4 Salir</a>
                                <button type="button" id="submit1" name="submit1"
                                    class="btn btn-primary pull-right usage"><i class="fa fa-save"></i> F2
                                    Guardar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <header>
                                    <h4 class="text-navy">Lista de Productos </h4>
                                </header>
                                <input type='hidden' name='porc_iva' id='porc_iva' value='<?php echo $iva; ?>'>
                                <input type='hidden' name='monto_percepcion' id='monto_percepcion'
                                    value='<?php echo $monto_percepcion; ?>'>
                                <input type="hidden" id="percepcion" name="percepcion" value="0">
                                <div class='widget-content' id="content">
                                    <div class="wrap-table1001">
                                        <div class="table100 ver1 m-b-10">
                                            <div class="table100-head">
                                                <table id="inventable1">
                                                    <thead>
                                                        <tr class="row100 head">
                                                            <th class="success col-lg-1">Id</th>
                                                            <th class='success col-lg-3'>Nombre</th>
                                                            <th class='success col-lg-1'>Presentación</th>
                                                            <th class='success col-lg-1'>Descripción</th>
                                                            <th class='success col-lg-1'>Cantidad</th>
                                                            <th class='success col-lg-1'>Costo</th>
                                                            <th class='success col-lg-1'>Precio</th>
                                                            <th class='success col-lg-1'>Subtotal</th>
                                                            <th class='success col-lg-1'>Vence</th>
                                                            <th class='success col-lg-1'>Acci&oacute;n</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="table100-body js-pscroll">
                                                <table>
                                                    <tbody id="inventable">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table101-body">
                                                <table>
                                                    <thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="cell100 column100 ">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td class='cell100 column50 text-bluegrey tr_bb'
                                                                id='totaltexto'>&nbsp;</td>
                                                            <td class='cell100 column15 leftt  text-bluegrey  tr_bb'>
                                                                CANT. PROD:</td>
                                                            <td class='cell100 column10 text-right text-danger  tr_bb'
                                                                id='totcant'>0.00</td>
                                                            <td class="cell100 column15 leftt text-bluegrey">SUMAS (SIN
                                                                IVA) $:</td>
                                                            <td class="cell100 column10 text-right text-green"
                                                                id='sumas_sin_iva'>0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cell100 column75">&nbsp;</td>
                                                            <td class="cell100 column15  leftt  text-bluegrey ">IVA $:
                                                            </td>
                                                            <td class="cell100 column10 text-right text-green "
                                                                id='iva'>0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cell100 column75">&nbsp;</td>
                                                            <td class="cell100 column15  leftt text-bluegrey ">SUBTOTAL
                                                                $:</td>
                                                            <td class="cell100 column10 text-right  text-green"
                                                                id='subtotal'>0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cell100 column75">&nbsp;</td>
                                                            <td class="cell100 column15 leftt  text-bluegrey ">VENTA
                                                                EXCENTA $:</td>
                                                            <td class="cell100 column10  text-right text-green"
                                                                id='venta_exenta'>0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cell100 column75">&nbsp;</td>
                                                            <td class="cell100 column15  leftt  text-bluegrey ">
                                                                PERCEPCIÓN $:</td>
                                                            <td class="cell100 column10 text-right text-green"
                                                                id='total_percepcion'>0.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cell100 column75">&nbsp;</td>
                                                            <td class="cell100 column15 leftt text-bluegrey ">TOTAL $:
                                                            </td>
                                                            <td class="cell100 column10 text-right  text-green"
                                                                id='total_dinero'>0.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" name="filas" id="filas" value="0">
                                        <input type="hidden" name="process" id="process" value="insert"><br>
                                        <input type='hidden' name='urlprocess' id='urlprocess'
                                            value="<?php echo $filename ?> ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--div class='ibox-content'-->
                </div>
            </div>

            <?php
            include_once ("footer.php");
            echo "<script src='js/funciones/funciones_compras.js'></script>";

            echo "<script src='js/plugins/arrowtable/arrow-table.js'></script>";
            echo "<script src='js/plugins/bootstrap-checkbox/bootstrap-checkbox.js'></script>";
            echo '<script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="js/funciones/main.js"></script>';
            echo "<script src='js/funciones/util.js'></script>";
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


          $id_proveedor=$_POST["proveedor"];
          $alias_tipodoc=$_POST['tipo_doc'];
          $numero_documen=$_POST['numero_doc'];

          $sumas_sin_iva=$_POST['sumas_sin_iva'];
          $subtotal=$_POST['subtotal'];
          $iva=$_POST['iva'];
          $venta_exenta=$_POST['venta_exenta'];
          $total_percepcion=$_POST['total_percepcion'];
          $dias_credito=$_POST['dias_credito'];

          $id_sucursal = $_SESSION["id_sucursal"];
          $sql_num = _query("SELECT ii FROM correlativo WHERE id_sucursal='$id_sucursal'");
          $datos_num = _fetch_array($sql_num);
          $ult = $datos_num["ii"]+1;
          $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_II';

          _begin();
          $z=1;

          /*actualizar los correlativos de II*/
          $corr=1;
          $table="correlativo";
          $form_data = array(
            'ii' =>$ult
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
            $concepto='COMPRA DE PRODUCTO';
          }
          $a = 1 ;

          /*insertar la compra*/
          $table_fc= 'compra';
          $form_data_fc = array(
            'id_server' => '0',
            'id_proveedor' => $id_proveedor,
            'alias_tipodoc'=>$alias_tipodoc,
            'fecha' => $fecha,
            'fecha_ingreso' => $fecha_movimiento,
            'numero_doc' => $numero_documen,
            'total' => $total_compras,
            'total_percepcion'=>$total_percepcion,
            'id_empleado' => $id_empleado,
            'id_sucursal' => $id_sucursal,
            'iva' => $iva,
            'hora' => $hora,
            'dias_credito' => $dias_credito,
            'finalizada' =>1,
            'id_pedido' =>0,
            'anulada' => 0,

          );
          //falta en compras vencimiento a 30, 60, 90 dias y vence iva
          $insertar_fc = _insert($table_fc, $form_data_fc);
          if ($insertar_fc) {
            # code...
          }
          else {
            # code...
            $a=0;

          }
          $id_fact= _insert_id();


          /*cuentas por pagar*/
          if ($dias_credito!=0) {
            # code...
            $table_cxp= 'cuenta_pagar';
            $fecha_vencimiento=sumar_dias_Ymd($fecha, $dias_credito);
            $form_data_cxp = array(
              'id_server' => '0',
              'id_proveedor' => $id_proveedor,
              'alias_tipodoc'=>$alias_tipodoc,
              'fecha' => $fecha_movimiento,
              'fecha_vence' => $fecha_vencimiento,
              'numero_doc' => $numero_documen,
              'monto' => $total_compras,
              'saldo_pend'=> $total_compras,
              'id_empleado' => $id_empleado,
              'id_sucursal' => $id_sucursal,
              'hora' => $hora,
              'dias_credito' => $dias_credito,
              'id_compra' => $id_fact,
            );
            $insertar_cxp = _insert($table_cxp, $form_data_cxp);
          }



          $table='movimiento_producto';
          $form_data = array(
            'id_server' => '0',
            'id_sucursal' => $id_sucursal,
            'correlativo' => $numero_doc,
            'concepto' => $concepto,
            'total' => $total_compras,
            'tipo' => 'ENTRADA',
            'proceso' => 'II',
            'referencia' => $numero_doc,
            'id_empleado' => $id_empleado,
            'fecha' => $fecha,
            'hora' => $hora,
            'id_suc_origen' => $id_sucursal,
            'id_suc_destino' => $id_sucursal,
            'id_proveedor' => $id_proveedor,
            'id_compra' => $id_fact,
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
          $d = 1 ;
          $m = 1 ;
          $lll = 1 ;

          $b = 1 ;
          for ($i=0;$i<$cuantos ;$i++)
          {
            list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion,$exento)=explode('|',$lista[$i]);
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
                'id_server' => '0',
                'id_producto' => $id_producto,
                'id_sucursal' => $id_sucursal,
                'cantidad' => $cantidad,
                'id_ubicacion' => $destino,
                'id_estante' => '0',
                'id_posicion' => '0'
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
              'id_server' => '0',
              'id_movimiento'=>$id_movimiento,
              'id_producto' => $id_producto,
              'cantidad' => $cantidad,
              'costo' => $precio_compra,
              'precio' => $precio_venta,
              'stock_anterior'=>$existencias,
              'stock_actual'=>$cant_total,
              'lote' => $lote,
              'id_presentacion' => $id_presentacion,
              'fecha' => $fecha_movimiento,
              'hora' => $hora,
              'id_sucursal' => $id_sucursal,
              'id_server_prod' => 0,
              'id_server_presen' => 0,
              'proceso' => '',
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
                'id_server' => '0',
                'id_producto' => $id_producto,
                'stock' => $cant_total,
                'costo_unitario'=>$precio_compra,
                'precio_unitario'=>$precio_venta,
                'create_date'=>$fecha_movimiento,
                'update_date'=>$fecha_movimiento,
                'id_sucursal' => $id_sucursal,
                'stock_local' => $cant_total
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
                'id_sucursal' => $id_sucursal,
                'stock_local' => $cant_total
              );
              $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
              $insert_stock = _update($table2,$form_data2, $where_clause );
            }
            if(!$insert_stock)
            {
              $k = 0;
            }
            if ($fecha_caduca!="0000-00-00" && $fecha_caduca!="" && $fecha_caduca != "NULL" && $fecha_caduca != "undefined")
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
                'id_server' => '0',
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
                'id_server' => '0',
                'id_producto' => $id_producto,
                'referencia' => $numero_doc,
                'numero' => $lote,
                'fecha_entrada' => $fecha_movimiento,
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
              'id_server' => '0',
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
              'id_server_prod' => '0',
              'id_server_presen' => '0',
              'id_sucursal' => $id_sucursal
            );

            $insert_mss =_insert($table,$form_data);

            if ($insert_mss) {
              # code...
            }
            else {
              # code...
              $z=0;
            }
            if($exento == "" || $exento == "undefined"){
                $exento = 0;
            }
            //detalle de compras
            $table_dc= 'detalle_compra';
            $form_data_dc = array(
                'id_server' => '0',
                'id_compra' => $id_fact,
                'id_producto' => $id_producto,
                'cantidad' => $cantidad,
                'ultcosto' => $precio_compra,
                'subtotal' => round(($cantidad/$unidades)*$precio_compra,2),
                'exento' => $exento,
                'id_presentacion' => $id_presentacion,
                'id_server_presen' => '0',
                'id_sucursal' => $id_sucursal,
                'id_server_prod' => '0'
            );
            $insertar_dc = _insert($table_dc, $form_data_dc);
            if (!$insertar_dc) {
              $b=0;
            }
            //aptualizar el precio en producto prsentacion
            $table_prese_pro="presentacion_producto";
            $form_data_p_p = array(
                'precio'=>$precio_venta,
                'costo'=>$precio_compra,
            );
            $where_clause_p_p="WHERE id_producto='$id_producto' AND id_pp='$id_presentacion'";
            $update_p_p = _update($table_prese_pro,$form_data_p_p, $where_clause_p_p );
            if(!$update_p_p)
            {
              $d=0;
            }

            /*actualizando el stock del local de venta*/
            $num=_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0");

            if (_num_rows($num)>0) {
                // code...
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
            }

          }
          if($insert_mov &&$insertar_fc && $insertar_dc &&$corr &&$z && $j && $k && $l && $m && $d && $lll )
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
          echo json_encode(getStock());
        }
        function getpresentacion()
        {
          echo json_encode(getPre());
        }

        function datos_proveedores()
        {
          $id_proveedor = $_POST['id_proveedor'];
          $sql0="SELECT percibe  FROM proveedor  WHERE id_proveedor='$id_proveedor'";
          $result = _query($sql0);
          $numrows= _num_rows($result);
          $row = _fetch_array($result);

          $percibe=$row['percibe'];
          if ($percibe==1) {
            $percepcion=round(1/100, 2);
          } else {
            $percepcion=0;
          }
          $xdatos['percepcion'] = $percepcion;
          echo json_encode($xdatos); //Return the JSON Array
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
            case 'datos_proveedores':
            datos_proveedores();
            break;
          }
        }
        ?>