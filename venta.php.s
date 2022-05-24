<?php
include_once "_core.php";
include('num2letras.php');

include('facturacion_funcion_imprimir.php');
//errores
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

function initial()
{
  $title="Facturación";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/bootstrap-checkbox/bootstrap-checkbox.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/plugins/perfect-scrollbar/perfect-scrollbar.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main.css">';

  include_once "header.php";
  include_once "main_menu.php";

  $id_usuario=$_SESSION["id_usuario"];
  $fecha_actual=date("Y-m-d");
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $id_sucursal=$_SESSION['id_sucursal'];

  // cliente
  $array0= array();
  $sql0=_query("SELECT * FROM cliente WHERE id_sucursal='$id_sucursal' ORDER BY id_cliente");
  $count0=_num_rows($sql0);
  for ($j=0;$j<$count0;$j++) {
    $row_cliente=_fetch_array($sql0);
    $id_cliente=$row_cliente['id_cliente'];
    $description=$row_cliente['nombre'];
    $array0[$id_cliente] = $description;
  }
  //array de empleados=''
  $sql6="SELECT id_empleado, nombre FROM empleado  WHERE id_sucursal='$id_sucursal' AND id_tipo_empleado=2";
  $result6=_query($sql6);
  $array6 =array(-1=>"Seleccione Vendedor");
  $count6=_num_rows($result6);
  for ($a=0;$a<$count6;$a++) {
    $row6=_fetch_array($result6);
    $id6=$row6['id_empleado'];
    $description6=$row6['nombre'];
    $array6[$id6] = $description6;
  }
  //impuestos
  $sql_iva="SELECT iva,monto_retencion1,monto_retencion10,monto_percepcion FROM sucursal WHERE id_sucursal='$id_sucursal'";
  $result_IVA=_query($sql_iva);
  $row_IVA=_fetch_array($result_IVA);
  $iva=$row_IVA['iva']/100;
  $monto_retencion1=$row_IVA['monto_retencion1'];
  $monto_retencion10=$row_IVA['monto_retencion10'];
  $monto_percepcion=$row_IVA['monto_percepcion'];
  //caja
  //SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user'
  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND fecha='$fecha_actual' AND id_empleado = '$id_user'");
  $cuenta = _num_rows($sql_apertura);

  $turno_vigente=0;
  if ($cuenta>0) {
    $row_apertura = _fetch_array($sql_apertura);
    $id_apertura = $row_apertura["id_apertura"];
    $turno = $row_apertura["turno"];
    $caja = $row_apertura["caja"];
    $fecha_apertura = $row_apertura["fecha"];
    $hora_apertura = $row_apertura["hora"];
    $turno_vigente = $row_apertura["vigente"];
  }
  //array de tipo_pagos
  $array4= array();
  $sql4='SELECT * FROM tipo_pago WHERE inactivo=0 ';
  $result4=_query($sql4);
  $count4=_num_rows($result4);
  for ($a=0;$a<$count4;$a++) {
    $row4=_fetch_array($result4);
    $id4=$row4['id_tipopago'];
    $alias_tp=trim($row4['alias_tipopago']);
    $description4=trim($row4['descripcion'])." |".$alias_tp;
    $array4[$alias_tp] = $description4;
  } ?>

  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2"></div>
  </div>
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <?php
          //permiso del script
          if ($links!='NOT' || $admin=='1') {
            if ($turno_vigente=='1' ){
              ?>

              <input type='hidden' name='urlprocess' id='urlprocess' value="<?php echo $filename; ?>">
              <input type="hidden" name="process" id="process" value="insert">

              <div class="ibox-content">
                <section>

                  <div class="panel">
                    <input type='hidden' name='caja' id='caja' value='<?php echo $caja; ?>'>
                    <input type='hidden' name='porc_iva' id='porc_iva' value='<?php echo $iva; ?>'>
                    <input type='hidden' name='monto_retencion1' id='monto_retencion1' value='100'>
                    <input type='hidden' name='monto_retencion10' id='monto_retencion10' value='100'>
                    <input type='hidden' name='monto_percepcion' id='monto_percepcion' value='100'>
                    <input type='hidden' name='porc_retencion1' id='porc_retencion1' value=0>
                    <input type='hidden' name='porc_retencion10' id='porc_retencion10' value=0>
                    <input type='hidden' name='porc_percepcion' id='porc_percepcion' value=0>
                    <input type='hidden' name='porcentaje_descuento' id='porcentaje_descuento' value=0>

                    <div class="widget-content">
                      <div class="row">
                        <div id='form_datos_cliente' class="form-group col-md-2">
                          <div class="form-group">
                            <label>Tipo doc.</label>
                            <select name='tipo_impresion' id='tipo_impresion' class='select2 form-control'>
                              <option value='TIK' selected>TICKET</option>
                              <option value='COF'>FACTURA CONSUMIDOR FINAL</option>
                              <option value='ENV'>NOTA DE ENVIO</option>
                              <option value='CCF'>CREDITO FISCAL</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label>N&uacute;mero doc</label>
                            <input type='text' placeholder='Num. Doc' class='form-control' id='numero_doc' name='numero_doc'>
                          </div>
                        </div>


                        <div  class="form-group col-md-4">
                          <div class="form-group has-info">
                            <label>Seleccione Vendedor</label><br>

                            <?php
                            $nombre_select0="vendedor";
                            $idd0=-1;
                            $style='';
                            $select0=crear_select2($nombre_select0, $array6, $idd0, $style);
                            echo $select0; ?>

                          </select>
                        </div>
                      </div>
                      <div id='form_datos_cliente' class="form-group col-md-4">
                        <div class="form-group has-info">
                          <label>Cliente&nbsp;</label>
                          <?php
                          $nombre_select0="id_cliente";
                          $idd0=-1;
                          $style='';
                          $select0=crear_select2($nombre_select0, $array0, $idd0, $style);
                          echo $select0; ?>
                        </div>
                      </div>
                    </div>
                    <div id='form_datos_pago' class="row">
                      <div class="form-group col-md-2">
                        <label>Pago</label>
                        <?php
                        $nombre_select1="select_tipo_pago";
                        $idd1=1;
                        $style='';
                        $select1=crear_select2($nombre_select1, $array4, $idd1, $style);
                        echo $select1; ?>
                      </div>

                      <div class="col-md-2" id='dias_creditt'>
                        <div class="form-group">
                          <label>dias Credito</label>
                          <input type='text' placeholder='dias Credito' class='form-control entero' id='dias_credito' name='dias_credito'>
                        </div>
                      </div>
                      <div  class="form-group col-md-2">
                        <div class="form-group has-info">

                          <label>Fecha</label><br>
                          <input type='text' class='datepick form-control' id='fecha' name='fecha' value='<?php echo $fecha_actual; ?>'>
                        </div>
                      </div>

                    </div>


                    <div class="row">
                      <div class="form-group col-md-6">
                        <div class="form-group has-info">
                          <label id='buscar_habilitado'>Buscar Producto (Descripci&oacute;n)</label>
                          <input type="text" id="producto_buscar" name="producto_buscar"  class="form-control" placeholder="Ingrese Descripcion de producto" data-provide="typeahead" style="border-radius:0px">
                          <input type="text" id="barcode" name="barcode" class="form-control" placeholder="Ingrese  barcode producto" style="border-radius:0px">
                        </div>
                      </div>
                      <div class="col-xs-2">
                        <div class="form-group has-info">
                          <label>Items</label>

                          <input type="text"  class='form-control'  id="items" value=0 readOnly /></label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="title-action" id='botones'>
                          <button type="submit" id="submit1" name="submit1" class="btn btn-primary"><i class="fa fa-save"></i> F9 Guardar</button>
                        </div>
                      </div>
                      <div class="form-group col-md-6" hidden>
                        <br>
                        <a name="button" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Verificar Stock</a>
                      </div>
                    </div>

                  </div>
                  <!-- fin buscador Superior -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="wrap-table1001">
                        <div class="table100 ver1 m-b-10">
                          <div class="table100-head">
                            <table id="inventable1">
                              <thead>
                                <tr class="row100 head">
                                  <th class="success cell100 column10">Id</th>
                                  <th class='success  cell100 column20'>Descripci&oacute;n</th>
                                  <th class='success  cell100 column10'>Stock</th>
                                  <th class='success  cell100 column10'>Presentación</th>
                                  <th class='success  cell100 column10'>Descripción</th>
                                  <th class='success  cell100 column10'>Precio</th>
                                  <th class='success  cell100 column10'>Cantidad</th>
                                  <th class='success  cell100 column10'>Subtotal</th>
                                  <th class='success  cell100 column10'>Acci&oacute;n</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div class="table100-body js-pscroll">
                            <table id="inventable">
                              <tbody></tbody>
                            </table>
                          </div>
                          <div class="table101-body">
                            <table>
                              <tbody>
                                <tr class='red'>
                                  <td class="cell100 column100">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td class='cell100 column50 text-bluegrey'  id='totaltexto'>&nbsp;</td>
                                  <td class='cell100 column15 leftt  text-bluegrey ' >CANT. PROD:</td>
                                  <td class='cell100 column10 text-right text-danger' id='totcant'>0.00</td>
                                  <td class="cell100 column10  leftt text-bluegrey ">TOTALES $:</td>
                                  <td class='cell100 column15 text-right text-green' id='total_gravado'>0.00</td>

                                </tr>
                                <tr>
                                  <td class="cell100 column15 leftt text-bluegrey ">SUMAS (SIN IVA) $:</td>
                                  <td  class="cell100 column10 text-right text-green" id='total_gravado_sin_iva'>0.00</td>
                                  <td class="cell100 column15  leftt  text-bluegrey ">IVA  $:</td>
                                  <td class="cell100 column10 text-right text-green " id='total_iva'>0.00</td>
                                  <td class="cell100 column15  leftt text-bluegrey ">SUBTOTAL  $:</td>
                                  <td class="cell100 column10 text-right  text-green" id='total_gravado_iva'>0.00</td>
                                  <td class="cell100 column15 leftt  text-bluegrey ">VENTA EXENTA $:</td>
                                  <td class="cell100 column10  text-right text-green" id='total_exenta'>0.00</td>
                                </tr>
                                <tr>
                                  <td class="cell100 column15 leftt text-bluegrey ">PERCEPCION $:</td>
                                  <td class="cell100 column10 text-right  text-green"  id='total_percepcion'>0.00</td>
                                  <td class="cell100 column15  leftt  text-bluegrey ">RETENCION $:</td>
                                  <td class="cell100 column10 text-right text-green" id='total_retencion'>0.00</td>
                                  <td class="cell100 column15 leftt text-bluegrey ">DESCUENTO $:</td>
                                  <td class="cell100 column10  text-right text-green"  id='total_final'>0.00</td>
                                  <td class="cell100 column15 leftt  text-bluegrey">A PAGAR $:</td>
                                  <td class="cell100 column10  text-right text-green"  id='monto_pago'>0.00</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <input type='hidden' name='totalfactura' id='totalfactura' value='0'>
            </div>
            <!--div class='ibox-content'-->
            <!-- Modal -->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content modal-md">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Pago y Cambio</h4>
                  </div>
                  <div class="modal-body">
                    <input type='hidden' name='id_factura' id='id_factura' value=''>
                    <div class="wrapper wrapper-content  animated fadeInRight">
                      <div class="row">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label><h5 class='text-navy'>Numero factura Interno:</h5></label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id='fact_num'></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><h5 class='text-navy'>Facturado $:</h5></label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="text" id="facturado" name="facturado" value=0 class="form-control decimal" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="row" id='fact_cf'>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label><strong><h5 class='text-danger'>Numero Factura o Credito Fiscal: </h5></strong></label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="text" id='num_doc_fact' name='num_doc_fact' value='' class="form-control">
                          </div>
                        </div>
                      </div>
                      <!--div class="row" id='cff_nota'>
                      <div class="col-md-6">
                      <div class="form-group">
                      <label><strong><h5 class='text-danger'>Direccion Cliente: </h5></strong></label>
                    </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                  <input type="text" id='direccion' name='direccion' value='' class="form-control">
                </div>
              </div>
            </div-->
            <div class="row" id='ccf'>
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong><h5 class='text-navy'>Nombre de Cliente Credito Fiscal: </h5></strong></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id='nombreape' name='nombreape' value='' class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong><h5 class='text-danger'>Direccion Cliente: </h5></strong></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id='direccion' name='direccion' value='' class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIT Cliente</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type='text' placeholder='NIT Cliente' class='form-control' id='nit' name='nit' value=''>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Registro Cliente(NRC)</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type='text' placeholder='Registro (NRC) Cliente' class='form-control' id='nrc' name='nrc' value=''>
                </div>
              </div>
            </div>

            <div class="row" id='tipo_pago_credito'>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dias Cr&eacute;dito</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="dias_cred" name="dias_cred" value=""  class="form-control decimal" readOnly>
                </div>
              </div>
            </div>
            <div class="row" id='tipo_pago_efectivo'>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Efectivo $</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="efectivo" name="efectivo" value=""  class="form-control decimal">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Cambio $</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="cambio" name="cambio" value=0 placeholder="cambio" class="form-control decimal" readonly >
                </div>
              </div>
            </div>
            <div class="row" id='tipo_pago_tarjeta'>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Número Tarjeta</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="Número Tarjeta" value=""  class="form-control decimal">
                </div>
              </div>
              <!--/div>
              <div class="row"-->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Emisor</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="emisor" name="emisor" value=0 placeholder="Emisor" class="form-control" >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. Transacción (Voucher)</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" id="voucher" name="voucher" value=0 placeholder="No. Transacción (Voucher)" class="form-control decimal"  >
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id='mensajes'></div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnPrintFact">Imprimir</button>
          <button type="button" class="btn btn-warning" id="btnEsc">Salir</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-container">
    <div class="modal fade" id="clienteModal" tabindex="-2" role="dialog" aria-labelledby="myModalCliente" aria-hidden="true">
      <div class="modal-dialog model-sm">
        <div class="modal-content"> </div>
      </div>
    </div>
  </div>

  <!-- Modal -->

</div>
<!--<div class='ibox float-e-margins' -->
</div>
<!--div class='col-lg-12'-->
</div>
<!--div class='row'-->
</div>
<!--div class='wrapper wrapper-content  animated fadeInRight'-->

<?php

include_once ("footer.php");
echo "<script src='js/plugins/arrowtable/arrow-table.js'></script>";
echo "<script src='js/plugins/bootstrap-checkbox/bootstrap-checkbox.js'></script>";
echo '<script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="js/funciones/main.js"></script>';
echo "<script src='js/funciones/util.js'></script>";
echo "<script src='js/funciones/venta.js'></script>";
}   //apertura de caja
else {
  echo "<br><br><div class='alert alert-warning'><h3 style='color:red;'>Por favor realice la apertura de caja!!!</h3></div></div></div></div></div>";
  include_once ("footer.php");
}  //apertura de caja



} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  include_once ("footer.php");
}
}
function numero_tiquete($ult_doc, $tipo_doc)
{
  $ult_doc=trim($ult_doc);
  $len_ult_valor=strlen($ult_doc);
  $long_num_fact=10;
  $long_increment=$long_num_fact-$len_ult_valor;
  $valor_txt="";
  if ($len_ult_valor<$long_num_fact) {
    for ($j=0;$j<$long_increment;$j++) {
      $valor_txt.="0";
    }
  } else {
    $valor_txt="";
  }
  $valor_txt=$valor_txt.$ult_doc."_".$tipo_doc;
  return $valor_txt;
}
function insertar()
{
  //date_default_timezone_set('America/El_Salvador');
  $fecha_movimiento= $_POST['fecha_movimiento'];
  $id_cliente=$_POST['id_cliente'];
  $total_venta = $_POST['total_venta'];
  $id_vendedor=$_POST['id_vendedor'];
  $cuantos = $_POST['cuantos'];
  $tipo_impresion= $_POST['tipo_impresion'];
  $tipo_pago= $_POST['tipo_pago'];
  $dias_credito=$_POST["dias_credito"];
  $numero_doc_print= $_POST['numero_doc'];
  $array_json=$_POST['json_arr'];
  //  IMPUESTOS
  $total_iva= $_POST['total_iva'];
  $total_retencion= $_POST['total_retencion'];
  $total_percepcion= $_POST['total_percepcion'];

  $id_empleado=$_SESSION["id_usuario"];
  $id_sucursal=$_SESSION["id_sucursal"];
  $fecha_actual = date('Y-m-d');
  $tiene_credito=0;
  if ($dias_credito>0 && $tipo_pago=="CRE") {
    $tiene_credito=1;
  }
  $abono=0;
  $saldo=0;
  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'
    AND id_empleado = '$id_empleado'");
    $cuenta = _num_rows($sql_apertura);

    $turno_vigente=0;
    if ($cuenta>0) {
      $row_apertura = _fetch_array($sql_apertura);
      $id_apertura = $row_apertura["id_apertura"];
      $turno = $row_apertura["turno"];
      $caja = $row_apertura["caja"];
      $fecha_apertura = $row_apertura["fecha"];
      $hora_apertura = $row_apertura["hora"];
      $turno_vigente = $row_apertura["vigente"];
    }
    $insertar1=false;
    $insertar2=false;
    $insertar_fact=false;
    $insertar_fact_det=false;
    $insertar_numdoc =false;
    $insertar4 =false;
    $hora=date("H:i:s");
    $xdatos['typeinfo']='';
    $xdatos['msg']='';
    $xdatos['process']='';
    $tipoprodserv='PRODUCTO';
    _begin();
    $sql="select * from correlativo where id_sucursal='$id_sucursal'";
    $result= _query($sql);
    $rows=_fetch_array($result);
    $nrows=_num_rows($result);
    $ult_cof=$rows['cof']+1;
    $ult_ccf=$rows['ccf']+1;
    $ult_tik=$rows['tik']+1;
    $ult_ref=$rows['ref']+1;
    $ult_env=$rows['env']+1;
    $fecha_guardada=$rows['fecha'];
    $fecha_actual=date('Y-m-d');

    $datetime1 = date_create($fecha_guardada);
    $datetime2 = date_create($fecha_actual);
    $interval = date_diff($datetime1, $datetime2);
    $diadiferencia=$interval->d;
    $table_numdoc="correlativo";
    switch ($tipo_impresion) {
      case 'REF':
      $concepto='NUM. REFERENCIA INTERNA';
      if ($diadiferencia>0) {
        $ult_ref=1;
        $data_numdoc = array(
          'ref' => $ult_ref,
          'fecha'=> $fecha_actual,
        );
        $where_clause_n="WHERE  id_sucursal='$id_sucursal'";
        $insertar_numdoc = _update($table_numdoc, $data_numdoc, $where_clause_n);
      } else {
        $data_numdoc = array(
          'ref' => $ult_ref,
        );
      }
      //$tipo_impresion='REF';
      $numero_doc=numero_tiquete($ult_ref, $tipo_impresion);
      break;
      case 'COF':
      $concepto='FACTURA CONSUMIDOR';
      $data_numdoc = array(
        'cof' => $ult_cof
      );
      //$tipo_impresion='COF';
      $numero_doc=numero_tiquete($ult_cof, $tipo_impresion);
      break;
      case 'TIK':
      $concepto='TICKET';
      $tipo_impresion='TIK';
      $sql_tik="SELECT id_caja,  desde, hasta, correlativo_dispo, id_sucursal, activa
      FROM caja
      WHERE id_caja='$caja'
      AND id_sucursal='$id_sucursal'";
      $result_tik=_query($sql_tik);
      $row_tik=_fetch_array($result_tik);
      $ult_tik=$row_tik['correlativo_dispo']+1;
      $desde=$row_tik['desde'];
      $hasta=$row_tik['hasta'];
      $table_numdoc='caja';
      $data_numdoc = array(
        'correlativo_dispo' => $ult_tik
      );
      if($ult_tik>$desde && $ult_tik<$hasta){
        $numero_doc=numero_tiquete($ult_tik, $tipo_impresion);

      }
      //if ($tipo_impresion!='')
      //$insertar_c = _update($t_caja, $data_c, $wc_tik);
      break;
      case 'CCF':
      $concepto='CREDITO FISCAL';
      $data_numdoc = array(
        'ccf' => $ult_ccf
      );
      //$tipo_impresion='CCF';
      $numero_doc=numero_tiquete($ult_ccf, $tipo_impresion);
      break;
      case 'ENV':
      //$tipo_impresion='ENV';
      $concepto='NOTA DE ENVIO';
      $data_numdoc = array(
        'env' => $ult_env,
      );
      $numero_doc=numero_tiquete($ult_env, $tipo_impresion);
      break;
    }

    if ($nrows==0) {
      $insertar_numdoc = _insert($table_numdoc, $data_numdoc);
    } else {
      $where_clause_n="WHERE  id_sucursal='$id_sucursal'";
      if ($tipo_impresion=='TIK'){
        $where_clause_n="WHERE id_caja='$caja' AND id_sucursal='$id_sucursal'";
      }
      $insertar_numdoc = _update($table_numdoc, $data_numdoc, $where_clause_n);
    }

    if ($cuantos>0) {
      //select a la tabla factura
      $sql_fact="SELECT * FROM factura WHERE numero_doc='$numero_doc'  and id_sucursal='$id_sucursal'
      AND fecha='$fecha_movimiento'
      ";

      $id_fact = 0;
      $result_fact=_query($sql_fact);
      $nrows_fact=_num_rows($result_fact);
      if ($nrows_fact==0) {
        $table_fact= 'factura';
        $form_data_fact = array(
          'id_cliente' => $id_cliente,
          'fecha' => $fecha_movimiento,
          'numero_doc' => $numero_doc,
          'total' => $total_venta,
          'id_usuario'=>$id_empleado,
          'id_empleado' => $id_empleado,
          'id_vendedor'=>$id_vendedor,
          'id_sucursal' => $id_sucursal,
          'tipo_pago' =>$tipo_pago,
          'tipo' => $concepto,
          'hora' => $hora,
          'dias_credito' => $dias_credito,
          'credito' => $tiene_credito,
          'finalizada' => 0,
          'impresa' => 1,
          'num_fact_impresa' => $numero_doc_print,
          'abono'=>$abono,
          'saldo' => $saldo,
          'tipo_documento' => $tipo_impresion,
          'id_apertura' => $id_apertura,
          'turno' => $turno,
          'caja' => $caja,
          'total_retencion'=>$total_retencion,
          'total_percepcion'=>$total_percepcion,
          'total_iva' => $total_iva,
        );
        $insertar_fact = _insert($table_fact, $form_data_fact);
        $id_fact= _insert_id();
        //Insertar el movimiento producto
        $table='movimiento_producto';
        $form_data = array(
          'id_sucursal' => $id_sucursal,
          'correlativo' => $numero_doc,
          'concepto' => $concepto,
          'total' => $total_venta,
          'tipo' => 'SALIDA',
          'proceso' => $tipo_impresion,
          'referencia' => $numero_doc,
          'id_empleado' => $id_empleado,
          'fecha' => $fecha_movimiento,
          'hora' => $hora,
          'id_suc_origen' => $id_sucursal,
          'id_suc_destino' => $id_sucursal,
          'id_cliente' => $id_cliente,
          'id_factura' => $id_fact,
        );
        $insert_mov =_insert($table, $form_data);
        $id_movimiento=_insert_id();
      } else {
        $row_fact=_fetch_array($result_fact);
      }

      $array = json_decode($array_json, true);
      foreach ($array as $fila) {
        if ($fila['precio']>=0 && $fila['subtotal']>=0  && $fila['cantidad']>0) {
          $id_producto=$fila['id'];
          $cantidad=$fila['cantidad'];

          $precio_venta=$fila['precio'];
          $id_presentacion=$fila['id_presentacion'];
          $unidades=$fila['unidades'];
          $subtotal=$fila['subtotal'];
          $cantidado=$cantidad;
          $cantidad=round(($unidades*$cantidad), 0);
          $cantidad_prod=$cantidad;
          $existencias=0;
          $nrow2=0;
          //Primero revisar stock y q me facture solo las existencias reales
          $sql2="SELECT producto.id_producto, producto.perecedero,
          stock.stock as existencias, stock.costo_unitario
          from producto,stock
          where producto.id_producto='$id_producto'
          and producto.id_producto=stock.id_producto
          and stock.id_sucursal='$id_sucursal'";
          $stock2=_query($sql2);
          $nrow2=_num_rows($stock2);

          //Actualizar en stock si  hay registro del producto
          $cant_facturar=0;
          $perecedero = 0;
          if ($nrow2>0) {
            $row2=_fetch_array($stock2);
            //$unidad=$row2['unidad'];
            $unidad=1;
            $existencias=$row2['existencias'];
            $perecedero=$row2['perecedero'];
            $costo=$row2['costo_unitario'];

            $cantidad_stock=$existencias-$cantidad;
            if ($cantidad_stock<0) {
              $cantidad_stock=0;
            }
            $cant_facturar=$cantidad;

            $table2= 'stock';
            $where_clause2="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";

            $form_data2 = array(
              'stock' => $cantidad_stock,
            );
            $insertar2 = _update($table2, $form_data2, $where_clause2);
          }
          //movimiento_detalle
          $sql_lot = _query("SELECT MIN(numero) AS ultimo FROM lote
          WHERE id_producto='$id_producto'  and id_sucursal='$id_sucursal'");
          $datos_lot = _fetch_array($sql_lot);
          $lote = $datos_lot["ultimo"];
          $t_movdet= 'movimiento_producto_detalle';

          $form_movdet = array(
            'id_movimiento'=>$id_movimiento,
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'costo' => $costo,
            'precio' => $precio_venta,
            'stock_anterior'=>$existencias,
            'stock_actual'=>$cantidad_stock,
            'lote' => $lote,
            'id_presentacion' => $id_presentacion,
          );
          $insert_mov_det = _insert($t_movdet, $form_movdet);
          //presentacio x producto
          $sql_uus=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
          $precio=$sql_uus['precio'];
          $unidad_w=$sql_uus['unidad'];
          $precio_venta_unit=$precio_venta;
          $subtotal=round($precio_venta_unit*$cantidado, 2);
          $cantidad_real = ($cantidado * $unidad_w);
          $table_fact_det= 'factura_detalle';
          $data_fact_det = array(
            'id_factura' => $id_fact,
            'id_prod_serv' => $id_producto,
            'cantidad' => $cantidad_real,
            'precio_venta' => $precio_venta,
            'subtotal' => $subtotal,
            'tipo_prod_serv' => $tipoprodserv,
            'id_empleado' => $id_empleado,
            'id_sucursal' => $id_sucursal,
            'fecha' => $fecha_movimiento,
            'id_presentacion'=> $id_presentacion,
          );
          if ($cantidad>0 && $id_fact > 0) {
            $insertar_fact_det = _insert($table_fact_det, $data_fact_det);
          }

          $sql_4 = "SELECT su.id_su, su.id_producto, su.cantidad, su.id_ubicacion, su.id_sucursal, u.id_ubicacion, u.bodega
          FROM stock_ubicacion AS su, ubicacion AS u
          WHERE su.id_producto = '$id_producto' AND su.id_ubicacion = u.id_ubicacion AND u.bodega != 1 AND su.cantidad > 0
          AND su.id_sucursal = '$id_sucursal' ORDER BY su.id_su ASC";
          $result4 = _query($sql_4);
          $num4 = _num_rows($result4);

          $can_su = $cantidad_real;
          if ($num4 > 0) {
            while ($row_su = _fetch_array($result4)) {
              $id_su = $row_su["id_su"];
              $id_pro_su = $row_su["id_producto"];
              $cantidad = $row_su["cantidad"];
              $tabla_su = "stock_ubicacion";
              if ($can_su > 0) {
                if ($cantidad >= $can_su) {
                  $sub_su = $cantidad - $can_su;
                  $form_su = array(
                    'cantidad' => $sub_su,
                  );
                  $where_su = "id_su='".$id_su."'";
                  $actualiza_su = _update($tabla_su, $form_su, $where_su);
                  $can_su = 0;
                } elseif ($can_su >= $cantidad) {
                  $sub_su = $can_su - $cantidad;
                  $form_su = array(
                    'cantidad' => 0,
                  );
                  $where_su = "id_su='".$id_su."'";
                  $actualiza_su = _update($tabla_su, $form_su, $where_su);
                  $can_su = $sub_su;
                }
              }
            }
          }
          //lote
          $table_lote='lote';
          // ojo revisar bien la logica de los lotes para irlos venciendo!!!!!!!!!! 24 agosto 2018
          $sql_lote = "SELECT id_lote, id_producto, fecha_entrada, precio, cantidad,salida, estado, numero,
          id_sucursal, vencimiento, referencia
          FROM lote WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'
          AND estado='VIGENTE' AND (vencimiento>='$fecha_actual' OR  vencimiento='0000-00-00')
          ORDER BY id_lote,vencimiento ASC";
          $result_lote=_query($sql_lote);

          $nrow_lote=_num_rows($result_lote);
          $fecha_mov=ED($fecha_movimiento);
          $diferencia=0;
          if ($nrow_lote>0) {
            for ($j=0;$j<$nrow_lote;$j++) {
              $row_lote=_fetch_array($result_lote);
              $id_lote_prod=$row_lote['id_lote'];
              $cantidad_lote=$row_lote['cantidad'];
              $salida=$row_lote['salida'];
              $fecha_caducidad=$row_lote['vencimiento'];
              $fecha_caducidad=ED($fecha_caducidad);
              //caso 1 cuando cantidad en lote es mayor que salida sumado con cantidad a descontar
              $stock_fecha= $cantidad_lote-$salida;
              if ($stock_fecha>$cantidad_prod) {
                $cant_sale=$salida+$cantidad_prod;
                $diferencia=0;
                $estado='VIGENTE';
              }
              if ($stock_fecha==$cantidad_prod) {
                $cant_sale=$salida+$cantidad_prod;
                $diferencia=0;
                $estado='FINALIZADO';
              }
              if ($stock_fecha<$cantidad_prod) {
                $cant_sale=$cantidad_lote;
                $diferencia=$cantidad_prod-$stock_fecha;
                $cantidad_prod=  $diferencia;
                $estado='FINALIZADO';
              }

              if ($fecha_caducidad!="0000-00-00" || $fecha_caducidad!="00-00-0000" || $fecha_caducidad!=null || $fecha_caducidad!="") {
                $comparafecha=compararFechas("-", $fecha_caducidad, $fecha_mov);
              } else {
                $comparafecha=99;
              }
              if ($fecha_caducidad===null) {
                $comparafecha=99;
              }



              //valida si la fecha de vencimineto ya expiro
              if ($comparafecha<0) {
                $estado='VENCIDO';
              }

              $where_clause_lote="WHERE id_producto='$id_producto'
              AND id_sucursal='$id_sucursal'
              AND cantidad>=salida
              AND id_lote='$id_lote_prod'";
              $form_data_lote = array(
                'salida' => $cant_sale,
                'estado' => $estado
              );
              $insertar4 = _update($table_lote, $form_data_lote, $where_clause_lote);
              //si la cantidad vendida no se pasa de la existencia de x lote perecedero  se sale del bucle for
              if ($diferencia==0) {
                break;
              }
            }
          }
          /*} //si es perecedero

          else {
          $insertar4 =true;
        }*/
      } // if($fila['cantidad']>0 && $fila['precio']>0){
      } //foreach ($array as $fila){
        if ($insertar_numdoc  && $insertar2  && $insertar_fact && $insertar_fact_det) {
          _commit(); // transaction is committed
          $xdatos['typeinfo']='Success';
          $xdatos['msg']='Documento Numero: <strong>'.$numero_doc.'</strong>  Guardado con Exito !';
          $xdatos['process']='insert';
          $xdatos['factura']=$id_fact;
          $xdatos['numero_doc']=$numero_doc;
          $xdatos['numero_doc_print']=  $numero_doc_print;

          $xdatos['insertados']=" num_doc :".$numero_doc." factura :".$insertar_fact." factura detalle:".$insertar_fact_det." mov prod:".$insertar1." stock:".$insertar2." lote:".$insertar4  ;
          $xdatos['insertados2']=" cant_sale_new:".$cant_sale;
        } else {
          _rollback(); // transaction rolls back
          $xdatos['typeinfo']='Error';
          $xdatos['msg']='Registro de Factura no pudo ser Actualizado !'._error();
          $xdatos['process']='noinsert';
          $xdatos['insertados']=" num_doc :".$numero_doc." factura :".$insertar_fact." factura detalle:".$insertar_fact_det." mov prod:".$insert_mov ."  mov prod_det:".$insert_mov_det." stock:".$insertar2." lote:".$insertar4  ;
        }
      }//if

      echo json_encode($xdatos);
    }
    function consultar_stock()
    {
      $id_producto = $_REQUEST['id_producto'];
      $id_usuario=$_SESSION["id_usuario"];
      $id_sucursal=$_SESSION['id_sucursal'];


      $iva=13/100;
      $precio=0;

      //if ($tipo =='PRODUCTO'){
      //ojo !!!!!!!!!!!!!!!!!!!!!!
      //utilidad teneindo precio venta y costo  : utlidad=(precio_venta-costo)/costo;
      /*$sql1="SELECT producto.id_producto,producto.descripcion,producto.unidad,producto.exento,producto.id_posicion,
      producto.utilidad_activa,producto.utilidad_seleccion,producto.porcentaje_utilidad1,producto.descripcion,
      producto.porcentaje_utilidad2,producto.porcentaje_utilidad3,
      producto.porcentaje_utilidad4,producto.imagen,producto.combo,producto.perecedero,
      stock.stock,stock.costo_promedio,
      stock.utilidad, stock.pv_base, stock.precio_mayoreo,  stock.porc_desc_base , stock.stock_minimo,
      stock.pv_desc_base ,  stock.porc_desc_max ,  stock.pv_desc_max,
      stock.precio_oferta,stock.fecha_ini_oferta,stock.fecha_fin_oferta
      FROM producto JOIN stock ON producto.id_producto=stock.id_producto
      WHERE producto.id_producto='$id_producto'
      AND stock.id_sucursal='$id_sucursal'
      ";*/
      $sql1 = "SELECT p.id_producto, p.barcode, p.descripcion, p.estado, p.perecedero, p.exento, p.id_categoria, p.id_sucursal,s.id_stock,s.stock, s.id_sucursal, s.precio_unitario, s.costo_unitario FROM producto AS p, stock AS s WHERE p.id_producto = s.id_producto AND p.id_producto ='$id_producto' AND s.id_sucursal='$id_sucursal'";
      $stock1=_query($sql1);
      $row1=_fetch_array($stock1);
      $nrow1=_num_rows($stock1);
      if ($nrow1>0) {
        //$unidades=$row1['unidad'];
        //$utilidad_activa=$row1['utilidad_activa'];
        //$utilidad_seleccion=$row1['utilidad_seleccion'];
        $perecedero=$row1['perecedero'];
        $barcode = $row1["barcode"];
        $descripcion = $row1["descripcion"];
        $estado = $row1["estado"];
        $perecedero = $row1["perecedero"];
        $exento = $row1["exento"];
        $id_stock = $row1["id_stock"];
        $stock = $row1["stock"];
        $precio_unitario = $row1["precio_unitario"];
        $costo_unitario = $row1["costo_unitario"];

        //precio de venta
        $fecha_hoy=date("Y-m-d");
        $fecha_hoy2=date("d-m-Y");

        //consultar si es perecedero
        $sql_existencia = "SELECT su.id_producto, su.cantidad, su.id_ubicacion, u.id_ubicacion, u.bodega  FROM stock_ubicacion as su, ubicacion as u WHERE su.id_producto = '$id_producto' AND su.id_ubicacion = u.id_ubicacion AND u.bodega != 1 ORDER BY su.id_su ASC";
        $resul_existencia = _query($sql_existencia);
        $cuenta_existencia = _num_rows($resul_existencia);
        $existencia_real = 0;
        if ($cuenta_existencia > 0) {
          while ($row_ex = _fetch_array($resul_existencia)) {
            $cantidad_ex = $row_ex["cantidad"];
            $existencia_real += $cantidad_ex;
          }
        }
        $fecha_caducidad="0000-00-00";
        $stock_fecha=0;
        /*
        if($perecedero==1){
        $sql_perecedero="SELECT id_lote, id_producto, fecha_entrada, precio, cantidad, estado, numero, id_sucursal, vencimiento, referencia FROM lote WHERE id_producto='$id_sucursal' AND id_sucursal='$id_sucursal' AND estado='VIGENTE' AND (vencimiento>='$fecha_hoy' OR  vencimiento='0000-00-00') ORDER BY vencimiento ASC";
        $result_perecedero=_query($sql_perecedero);
        $array_fecha=array();
        $array_stock=array();
        $nrow_perecedero=_num_rows($result_perecedero);
        if($nrow_perecedero>0){
        for ($i=0;$i<$nrow_perecedero;$i++){
        $row_perecedero=_fetch_array($result_perecedero);
        //$costos_pu=array($pu1,$pu2,$pu3,$pu4);
        $entrada=$row_perecedero['cantidad'];
        $id_lote_prod=$row_perecedero['id_lote'];
        $fecha_caducidad=$row_perecedero['vencimiento'];
        if($fecha_caducidad=="")
        $fecha_caducidad="0000-00-00";
        $fecha_caducidad=ED($fecha_caducidad);
        $stock_fecha=$entrada-$salida;
        $array_fecha[] =$id_lote_prod."|".$fecha_caducidad;
        $array_stock[] =$id_lote_prod."|".$fecha_caducidad."|".$stock_fecha;
      }
    }

  }
  else{
  $array_fecha="";
  $array_stock="";
}*/
}
//$ubicacion=ubicacionn($id_posicion);
//si no hay stock devuelve cero a todos los valores !!!
if ($nrow1==0) {
  $existencias=0;
  $precio_venta=0;
  $costos_pu=array(0,0,0,0);
  $precios_vta=array(0,0,0,0);
  $cp=0;
  $iva=0;
  $unidades=" ";
  $imagen='';
  $combo=0;
  $fecha_caducidad='0000-00-00';
  $stock_fecha=0;
  $oferta=0;
}
//}
//$xdatos['mayoreo'] = $mayoreo;
/*if($mayoreo)
{
$sql = _query("SELECT precio FROM precio_producto WHERE id_producto='$id_producto' AND '1' BETWEEN desde AND hasta");
if(_num_rows($sql)>0)
{
$datos = _fetch_array($sql);
$precio = $datos["precio"];
$xdatos["precio"] = $precio;
}
else
{
$xdatos["precio"] = 0;
}
}
if(!$mayoreo && $precio>0)
{

$xdatos["typeinfo"] = 'Success';
}*/
/*inicio modificacion presentacion*/
$i=0;
$unidadp=0;
$preciop=0;
$descripcionp=0;

$sql_p=_query("SELECT presentacion.nombre, presentacion_producto.descripcion,presentacion_producto.id_presentacion,presentacion_producto.unidad,presentacion_producto.precio FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE presentacion_producto.id_producto='$id_producto' AND presentacion_producto.activo=1");
$select="<select class='sel form-control'>";
while ($row=_fetch_array($sql_p)) {
  # code...
  if ($i==0) {
    # code...
    $unidadp=$row['unidad'];
    $preciop=$row['precio'];
    $descripcionp=$row['descripcion'];
  }


  $select.="<option value='$row[id_presentacion]'>$row[nombre]</option>";
  $i=$i+1;
}
$select.="</select>";
$xdatos['existencias'] = $existencia_real;
$xdatos['fecha_caducidad'] = $fecha_caducidad;
$xdatos['stock_fecha'] =$stock_fecha;
$xdatos['perecedero']=$perecedero;
//	$xdatos['fechas_vence'] = $array_fecha;
//	$xdatos['stock_vence'] = $array_stock;
$xdatos['fecha_hoy']= $fecha_hoy;
$xdatos['descripcion']= $descripcion;
$xdatos['select']= $select;
$xdatos['preciop']= $preciop;
$xdatos['unidadp']= $unidadp;
$xdatos['descripcionp']= $descripcionp;

echo json_encode($xdatos); //Return the JSON Array
}

function total_texto()
{
  $total=$_REQUEST['total'];
  list($entero, $decimal)=explode('.', $total);
  $enteros_txt=num2letras($entero);
  $decimales_txt=num2letras($decimal);

  if ($entero>1) {
    $dolar=" dolares";
  } else {
    $dolar=" dolar";
  }
  $cadena_salida= "Son: ".$enteros_txt.$dolar." con ".$decimal."/100 ctvs.";
  echo $cadena_salida;
}

function mostrar_datos_cliente()
{
  $id_cliente=$_POST['id_client'];

  $sql="SELECT * FROM cliente WHERE
  id_cliente='$id_cliente'";
  $result=_query($sql);
  $count=_num_rows($result);
  if ($count > 0) {
    for ($i = 0; $i < $count; $i ++) {
      $row = _fetch_array($result);
      $id_cliente=$row["id_cliente"];
      $nombre=$row["nombre"];
      $porcentaje_descuento=$row['porcentaje_descuento'];
      $nit=$row["nit"];
      $dui=$row["dui"];
      $direccion=$row["direccion"];
      $telefono1=$row["telefono1"];
      $giro=$row["giro"];
      $registro=$row["nrc"];
      $email=$row["email"];
    }
  }
  $xdatos['nit']= $nit;
  $xdatos['registro']= $registro;
  $xdatos['nombreape']=   $nombre;
  $xdatos['direccion']=   $direccion;
  $xdatos['porcentaje_descuento'] = $porcentaje_descuento;
  echo json_encode($xdatos); //Return the JSON Array
}
function datos_clientes()
{
  $id_cliente = $_POST['id_cliente'];
  $sql0="SELECT percibe, retiene, retiene10,porcentaje_descuento FROM cliente  WHERE id_cliente='$id_cliente'";


  $result = _query($sql0);
  $numrows= _num_rows($result);
  $row = _fetch_array($result);
  $retiene1=$row['retiene'];
  $retiene10=$row['retiene10'];
  $percibe=$row['percibe'];
  $porcentaje_descuento=$row['porcentaje_descuento'];
  $sql_iva="select iva,monto_retencion1,monto_retencion10,monto_percepcion from monto_impuesto";
  $result_IVA=_query($sql_iva);
  $row_IVA=_fetch_array($result_IVA);
  $iva=$row_IVA['iva']/100;
  $monto_retencion1=$row_IVA['monto_retencion1'];
  $monto_retencion10=$row_IVA['monto_retencion10'];
  $monto_percepcion=$row_IVA['monto_percepcion'];
  if ($percibe==1) {
    $percepcion=round($monto_percepcion/100, 2);
  } else {
    $percepcion=0;
  }

  if ($retiene1==1) {
    $retencion1=round($monto_retencion1/100, 2);
  } else {
    $retencion1=0;
  }

  if ($retiene10==1) {
    $retencion10=round($monto_retencion10/100, 2);
  } else {
    $retencion10=0;
  }

  $xdatos['retencion1'] = $retencion1;
  $xdatos['retencion10'] = $retencion10;
  $xdatos['percepcion'] = $percepcion;
  $xdatos['porcentaje_descuento'] = $porcentaje_descuento;
  echo json_encode($xdatos); //Return the JSON Array
}
function imprimir_fact()
{
  $numero_doc = $_POST['numero_doc'];
  $tipo_impresion= $_POST['tipo_impresion'];
  $tipo_pago= $_POST['tipo_pago'];
  $id_factura= $_POST['id_factura'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $numero_doc_print = $_POST['numero_doc_print'];

  if (isset($_POST['nombreape'])) {
    $nombreape= $_POST['nombreape'];
  }
  if (isset($_POST['direccion'])) {
    $direccion= $_POST['direccion'];
  }
  if (isset($_POST['nit'])) {
    $nit= $_POST['nit'];
  }
  if (isset($_POST['nrc'])) {
    $nrc= $_POST['nrc'];
  }
  //Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
  $info = $_SERVER['HTTP_USER_AGENT'];
  if (strpos($info, 'Windows') == true) {
    $so_cliente='win';
  } else {
    $so_cliente='lin';
  }

  $sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
  $result_fact=_query($sql_fact);
  $row_fact=_fetch_array($result_fact);
  $nrows_fact=_num_rows($result_fact);
  if ($nrows_fact>0) {
    $fecha_movimiento=$row_fact['fecha'];
    $total_venta=$row_fact['total'];
    $hora=$row_fact['hora'];
    $table_fact= 'factura';

    $form_data_fact = array(
      'finalizada' => '1',
      'impresa' => '1',
      'num_fact_impresa'=>$numero_doc_print,

    );

    $where_clause="WHERE id_factura='$id_factura'";
    $actualizar = _update($table_fact, $form_data_fact, $where_clause);
  }
  //pago tarjeta
  if ($tipo_pago=="TAR") {
    if (isset($_POST['numero_tarjeta'])) {
      $numero_tarjeta=$_POST['numero_tarjeta'];
    }
    if (isset($_POST['emisor'])) {
      $emisor=$_POST['emisor'];
    }
    if (isset($_POST['voucher'])) {
      $voucher=$_POST['voucher'];
      // SELECT id_pago_tarjeta, idtransace, alias_tipodoc, fecha, voucher, numero_tarjeta, emisor, monto FROM pago_tarjeta WHERE 1
      $sql_pt="SELECT * FROM pago_tarjeta  WHERE id_factura='$id_factura'";
      $result_pt=_query($sql_pt);
      $row_pt=_fetch_array($result_pt);
      $nrows_pt=_num_rows($result_pt);
      if ($nrows_pt==0) {
        $table_pt= 'pago_tarjeta';
        $form_data_pt = array(
          'id_factura' => $id_factura,
          'voucher' => $voucher,
          'fecha' => $fecha_movimiento,
          'hora'=>$hora,
          'emisor' => $emisor,
          'numero_tarjeta' => $numero_tarjeta,
          'monto' => $total_venta,
        );
        $where_clause="WHERE id_factura='$id_factura'";
        $actualizar = _insert($table_pt, $form_data_pt);
        $id_pago= _insert_id();
      }
    }
  }
  //cambiar numero documento impreso para mostrar en reporte kardex

  if ($tipo_impresion=='COF') {
    $info_facturas=print_fact($id_factura, $tipo_impresion, $nombreape, $direccion);
  }
  if ($tipo_impresion=='CCF') {
    $info_facturas=print_ccf($id_factura, $tipo_impresion, $nit, $nrc, $nombreape, $direccion);
  }
  if ($tipo_impresion=='ENV') {
    $info_facturas=print_envio($id_factura, $tipo_impresion, $nombreape, $direccion);
  }
  if ($tipo_impresion=='NCR') {
    $info_facturas=print_ncr($id_factura, $tipo_impresion, $nombreape, $direccion);
  }

  //directorio de script impresion cliente
  $headers="";
  $footers="";
  if ($tipo_impresion=='TIK') {
    $info_facturas=print_ticket($id_factura);
    $sql_pos="SELECT *  FROM config_pos  WHERE id_sucursal='$id_sucursal' AND alias_tipodoc='TIK'";
    $result_pos=_query($sql_pos);
    $row1=_fetch_array($result_pos);
    $headers=$row1['header1']."|".$row1['header2']."|".$row1['header3']."|".$row1['header4']."|".$row1['header5']."|";
    $headers.=$row1['header6']."|".$row1['header7']."|".$row1['header8']."|".$row1['header9']."|".$row1['header10'];
    $footers=$row1['footer1']."|".$row1['footer2']."|".$row1['footer3']."|".$row1['footer4']."|".$row1['footer5']."|";
    $footers.=$row1['footer6']."|".$row1['footer7']."|".$row1['footer8']."|".$row1['footer8']."|".$row1['footer10']."|";
  }

  $sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
  $result_dir_print=_query($sql_dir_print);
  $row_dir_print=_fetch_array($result_dir_print);
  $dir_print=$row_dir_print['dir_print_script'];
  $shared_printer_win=$row_dir_print['shared_printer_matrix'];
  $shared_printer_pos=$row_dir_print['shared_printer_pos'];
  $nreg_encode['shared_printer_win'] =$shared_printer_win;
  $nreg_encode['shared_printer_pos'] =$shared_printer_pos;
  $nreg_encode['dir_print'] =$dir_print;
  $nreg_encode['facturar'] =$info_facturas;
  $nreg_encode['sist_ope'] =$so_cliente;
  $nreg_encode['headers'] =$headers;
  $nreg_encode['footers'] =$footers;
  echo json_encode($nreg_encode);
}


function finalizar_fact()
{
  $numero_doc = $_POST['numero_doc'];
  $id_sucursal=$_SESSION['id_sucursal'];

  $sql_fact="SELECT * FROM factura WHERE numero_doc='$numero_doc' and id_sucursal='$id_sucursal'";

  $result_fact=_query($sql_fact);
  $row_fact=_fetch_array($result_fact);
  $nrows_fact=_num_rows($result_fact);
  //Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
  $info = $_SERVER['HTTP_USER_AGENT'];
  if (strpos($info, 'Windows') == true) {
    $so_cliente='win';
  } else {
    $so_cliente='lin';
  }

  if ($nrows_fact>0) {
    $table_fact= 'factura';
    $form_data_fact = array(
      'finalizada' => '1'
    );
    $where_clause="WHERE numero_doc='$numero_doc' and id_sucursal='$id_sucursal'";
    $actualizar = _update($table_fact, $form_data_fact, $where_clause);
    //$numero_doc=trim($row_fact['numero_doc']);
  }



  if ($actualizar) {
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Venta Numero: <strong>'.$numero_doc.'</strong>  Finalizada con Exito !';
    $xdatos['process']='Finalizar';
  } else {
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Venta Numero: <strong>'.$numero_doc.'</strong>  no pudo ser Finalizada !';
    $xdatos['process']='Finalizar';
  }
  echo json_encode($xdatos); //Return the JSON Array
}
function buscarBarcode()
{
  $query = trim($_POST['id_producto']);
  $sql0="SELECT id_producto as id, descripcion, barcode, tipo_prod_servicio FROM producto  WHERE barcode='$query'";
  $result = _query($sql0);
  $numrows= _num_rows($result);

  $array_prod = array();
  $array_prod="";
  while ($row = _fetch_array($result)) {
    $barcod=" [".$row['barcode']."] ";
    $id_prod =$row['id'];
  }
  $xdatos['id_prod']=$id_prod;
  echo json_encode($xdatos); //Return the JSON Array
}

function traerdatos()
{
  $keywords = $_POST['keywords'];
  $composicion= $_POST['composicion'];
  $id_marca= $_POST['id_marca'];
  $barcode= $_POST['barcode'];
  $limite= $_POST['limite'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $sqlJoined="SELECT pr.id_producto,pr.descripcion, pr.composicion, pr.exento, pr.barcode,
  st.costo_promedio,st.pv_base , st.stock,
  ma.id_marca,ma.marca
  FROM producto AS pr
  JOIN stock AS st ON pr.id_producto=st.id_producto
  JOIN marca AS ma ON pr.id_marca=ma.id_marca
  ";
  $sqlParcial=get_sql($keywords, $barcode, $id_marca, $composicion, $limite);
  $sql_final= $sqlJoined." ".$sqlParcial." ";
  $query = _query($sql_final);

  $num_rows = _num_rows($query);
  $filas=0;
  if ($num_rows > 0) {
    while ($row = _fetch_array($query)) {
      $id_producto = $row['id_producto'];
      $descripcion=$row["descripcion"];
      $composicion = $row['composicion'];
      $exento = $row['exento'];
      $cp = $row['costo_promedio'];
      $precio = $row['pv_base'];
      $id_marca=$row['id_marca'];
      $nombre = $row['descripcion'];
      $barcode = $row['barcode'];
      $marca = $row['marca'];
      $stock= $row['stock'];


      $btnSelect='<input type="button" id="btnSelect" class="btn btn-primary fa" value="&#xf00c;">'; ?>
      <tr class='tr1' tabindex="<?php echo $filas; ?>">
        <td class='col1 td1'><input type='hidden' id='exento' name='exento' value='<?php echo $exento; ?>'>
          <h5><?php echo $id_producto; ?></h5></td>
          <td class='col1 td1'>
            <h5 class='text-success'><?php echo $barcode; ?></h5></td>
            <td class='col2 td1'>
              <h5><?php echo $descripcion; ?></h5></td>

              <td class='col1 td1'>
                <h5><?php echo $marca; ?></h5></td>
                <td class='col1 td1'>
                  <h5><?php echo $precio; ?></h5></td>
                  <td class='col1 td1'>
                    <h5 class='text-success'><?php echo $composicion; ?></h5></td>

                    <td class='col1 td1'>
                      <h5 class='text-success'><?php echo $stock; ?></h5></td>

                      <td class='col1 td1'>
                        <h5 class='text-success'><?php echo $btnSelect; ?></h5></td>
                      </tr>

                      <?php
                      $filas+=1;
                    }
                  }
                  echo '<input type="hidden" id="cuantos_reg"  value="'.$num_rows.'">';
                }
                function get_sql($keywords, $barcode, $id_marca, $composicion, $limite)
                {
                  $id_sucursal=$_SESSION['id_sucursal'];
                  $andSQL='';

                  $whereSQL="WHERE st.id_sucursal='$id_sucursal'
                  AND st.stock>0
                  AND st.pv_base>0.0";

                  $keywords=trim($keywords);
                  //$andSQL.= " AND ma.id_marca='$id_marca'";

                  if (!empty($barcode)) {
                    $andSQL.= " AND  pr.barcode LIKE '{$barcode}%'";
                  } else {
                    if (!empty($keywords)) {
                      $andSQL.= "AND  pr.descripcion LIKE '%".$keywords."%'";
                      if (!empty($composicion)) {
                        $andSQL.= " AND pr.composicion LIKE '%".$composicion."%'";
                      }
                      if ($id_marca!=-1) {
                        $andSQL.= " AND ma.id_marca='$id_marca'";
                      }
                    }

                    if (empty($keywords)  && !empty($composicion)) {
                      $andSQL.= "AND  pr.composicion  LIKE '%".$composicion."%'";
                      if ($id_marca!=-1) {
                        $andSQL.= " AND ma.id_marca='$id_marca'";
                      }
                    }

                    if (empty($keywords)  && empty($composicion) &&  ($id_marca!=-1)) {
                      $limite=1000;
                      $andSQL.= " AND ma.id_marca='".$id_marca."'";
                    }
                  }

                  $orderBy=" ";
                  $limitSQL=" LIMIT ".$limite;
                  $orderBy=" ORDER BY pr.id_producto,pr.descripcion, pr.barcode,pr.composicion,ma.id_marca ";

                  $sql_parcial=$whereSQL.$andSQL.$orderBy.$limitSQL;
                  return $sql_parcial;
                }

                function agregar_cliente()
                {
                  //$id_cliente=$_POST["id_cliente"];
                  $nombre=$_POST["nombress"];
                  $apellido=$_POST["apellidos"];
                  $dui=$_POST["dui"];
                  $tel1=$_POST["tel1"];
                  $tel2=$_POST["tel2"];


                  $var1=preg_match('/\x{27}/u', $nombre);
                  $var2=preg_match('/\x{22}/u', $nombre);
                  if ($var1==true || $var2==true) {
                    $nombre =stripslashes($nombre);
                  }
                  $sql_result=_query("SELECT * FROM cliente WHERE nombre='$nombre'");
                  $numrows=_num_rows($sql_result);
                  $row_update=_fetch_array($sql_result);
                  $id_cliente=$row_update["id_cliente"];
                  $name_cliente=$row_update["nombre"];


                  //'id_cliente' => $id_cliente,
                  $table = 'cliente';
                  $form_data = array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'dui' => $dui,
                    'telefono1' => $tel1,
                    'telefono2' => $tel2,
                  );

                  if ($numrows == 0 && trim($nombre)!='') {
                    $insertar = _insert($table, $form_data);
                    $id_cliente=_insert_id();
                    if ($insertar) {
                      $xdatos['typeinfo']='Success';
                      $xdatos['msg']='Registro insertado con exito!';
                      $xdatos['process']='insert';
                      $xdatos['id_client']=  $id_cliente;
                    } else {
                      $xdatos['typeinfo']='Error';
                      $xdatos['msg']='Registro no insertado !';
                    }
                  } else {
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='Registro no insertado !';
                  }
                  echo json_encode($xdatos);
                }
                function getpresentacion()
                {
                  $id_presentacion =$_REQUEST['id_presentacion'];
                  $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
                  $precio=$sql['precio'];
                  $unidad=$sql['unidad'];
                  $descripcion=$sql['descripcion'];
                  $des = "<input type='text' id='ss' class='form-control' value='".$descripcion."' readonly>";
                  $xdatos['precio']=$precio;
                  $xdatos['unidad']=$unidad;
                  $xdatos['descripcion']=$des;
                  echo json_encode($xdatos);
                }

                function rev_prec(){
                  $id_producto = $_POST["id_producto"];
                  $cantidad = $_POST["cantidad"];
                  $sql = _query("SELECT precio FROM presentacion_producto WHERE id_producto='$id_producto'");
                  if (_num_rows($sql)>0) {
                    $datos = _fetch_array($sql);
                    $precio = $datos["precio"];
                    $xdatos["typeinfo"] = "Success";
                    $xdatos["precio"] = $precio;
                  } else {
                    $xdatos["typeinfo"] = "Error";
                  }
                  echo json_encode($xdatos);
                }
                //functions to load
                if (!isset($_REQUEST['process'])) {
                  initial();
                }
                //else {
                if (isset($_REQUEST['process'])) {
                  switch ($_REQUEST['process']) {
                    case 'insert':
                    insertar();
                    break;
                    case 'mostrar_datos_cliente':
                    mostrar_datos_cliente();
                    break;
                    case 'consultar_stock':
                    consultar_stock();
                    break;
                    case 'cargar_empleados':
                    cargar_empleados();
                    break;
                    case 'cargar_precios':
                    cargar_precios();
                    break;
                    case 'total_texto':
                    total_texto();
                    break;
                    case 'imprimir_fact':
                    imprimir_fact();
                    break;
                    case 'print2':
                    print2(); //Generacion de los datos de factura que se retornan para otro script que imprime!!!
                    break;
                    case 'mostrar_numfact':
                    mostrar_numfact();
                    break;
                    case 'reimprimir':
                    reimprimir();
                    break;
                    case 'finalizar_fact':
                    finalizar_fact();
                    break;
                    case 'buscarBarcode':
                    buscarBarcode();
                    break;
                    case 'cons':
                    rev_prec();
                    break;
                    case 'mostrar_datos_cliente':
                    mostrar_datos_cliente();
                    break;
                    case 'datos_clientes':
                    datos_clientes();
                    break;
                    case 'traerdatos':
                    traerdatos();
                    break;
                    case 'agregar_cliente':
                    agregar_cliente();
                    break;
                    case 'getpresentacion':
                    getpresentacion();
                    break;
                  }


                  //}
                }
                ?>
