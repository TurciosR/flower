<?php
include_once "_core.php";
function initial()
{
  $title = 'Pago a proveedor';
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
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="js/plugins/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  include_once "header.php";
  include_once "main_menu.php";
  //permiso del script
  $id_sucursal=$_SESSION["id_sucursal"];
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);

  //crear array proveedor
  $sql0="SELECT * FROM proveedor";
  $result0=_query($sql0);
  $count0=_num_rows($result0);
  $array0 =array(-1=>"Seleccione");
  for ($x=0;$x<$count0;$x++) {
    $row0=_fetch_array($result0);
    $id0=$row0['id_proveedor'];
    $description=$row0['nombre'];
    $array0[$id0] = $description;
  }

  ?>
  <style media="screen">
  select {
    border: 1px solid #FFFFFF !important;

  }
  </style>
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2">
    </div>
  </div>
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <?php
          //permiso del script
          if ($links!='NOT' || $admin=='1' ){
            ?>
            <div class="ibox-title">
              <h5><?php echo $title; ?></h5>
            </div>
            <div class="ibox-content">
              <form name="formulario" id="formulario">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>Proveedor &nbsp;</label>
                    <?php
                    $nombre_select0="select_proveedor";
                    $idd0=-1;
                    //$style='width:400px';
                    $style='';
                    $select0=crear_select2($nombre_select0, $array0, $idd0, $style);
                    echo $select0; ?>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Forma de Pago &nbsp;</label>
                    <select class="form-control select" name="forma" id="forma">
                      <option value="">Seleccione</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Transferencia">Transferencia</option>
                    </select>
                  </div>
                </div>
                <div class="row" id="row_banco" hidden>
                  <div class="form-group col-md-3">
                    <label>Banco&nbsp;</label>
                    <select class="form-control select" id="banco" style="width: 100%;">
                      <option value="">Seleccione</option>
                      <?php
                      $sql_b = _query("SELECT * FROM banco WHERE id_sucursal='$id_sucursal'");
                      while ($row_b = _fetch_array($sql_b)) {
                        echo "<option value='".$row_b["id_banco"]."'>".$row_b["nombre"]."</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Cuenta&nbsp;</label>
                    <select class="form-control select" id="cuenta" style="width: 100%;">
                      <option value="">Seleccione</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Saldo Cuenta&nbsp;</label>
                    <input class="form-control" readonly type="text" id="saldo" name="saldo" value="0.00">
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <br>
                    <label>Seleccion de facturas pendientes de pago</label>
                    <select multiple="multiple" size="6" name="duallistbox_demo2" class="demo2">
                    </select>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="tabla">
                      <tr>
                        <td class="col-lg-1">FECHA</td>
                        <td class="col-lg-2">NUMERO</td>
                        <td class="col-lg-1">CARGO</td>
                        <td class="col-lg-1">% DESC</td>
                        <td class="col-lg-1">DESCUENTO</td>
                        <td class="col-lg-1">DEVOLUCION</td>
                        <td class="col-lg-1">BONIFICACION</td>
                        <td class="col-lg-1">RETENCION</td>
                        <td class="col-lg-1">VIÑETA</td>
                        <td class="col-lg-1">SALDO</td>
                        <td class="col-lg-1">ACCIÓN</td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-12">
                    <table class="table">
                      <tr>
                        <td class="col-lg-10">Total a cancelar</td>

                        <td id="total_a_pagar" name="total_a_pagar" class="col-lg-1"></td>
                        <td class="col-lg-1"></td>
                      </tr>
                    </table>

                  </div>
                </div>
                <input type="hidden" name="process" id="process" value="inser"><br>
                <div>
                  <input type="button" id="submit1" name="submit1" value="Guardar" class="btn btn-primary m-t-n-xs" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_pago_proveedor.js'></script>";
    echo "<script src='js/plugins/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js'></script>";
  } //permiso del script
  else
  {
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
    include_once ("footer.php");
  }
}
function insertar()
{
  $array_json=$_POST["array_json"];
  $array_json2=$_POST["array_json2"];
  $id_cuenta=$_POST["id_cuenta"];
  $total_a_pagar=$_POST["total_a_p"];
  $id_sucursal=$_SESSION["id_sucursal"];
  $id_movimiento=0;
  $id_proveedor=$_POST['id_proveedor'];
  $forma=$_POST['forma'];

  _begin();
  $ver0=0;
  $ver1=0;
  $ver2=0;
  $ver3=0;
  $ver4=0;
  $array = json_decode($array_json, true);
  $array2 = json_decode($array_json2, true);
  /*insertamos los detalles*/
  foreach ($array2 as $fila2)
  {
    $table='detalle_voucher';
    $form_data = array(
      'fecha' => $fila2['fecha'],
      'numero' => $fila2['numero'],
      'cargo' => $fila2['cargo'],
      'porcentage' => $fila2['porcentage'],
      'descuento' => $fila2['descuento'],
      'devolucion' => $fila2['devolucion'],
      'bonificacion' => $fila2['bonificacion'],
      'retencion' => $fila2['retencion'],
      'vin' => $fila2['vin'],
      'saldo' => $fila2['saldo'],
      'id_cuenta_pagar' => $fila2['id_cuenta_pagar'],
      'id_sucursal' => $id_sucursal,
    );
    $insertar=_insert($table,$form_data);
    if (!$insertar)
    {
      $ver1=1;
    }
  }
  /*obtener el valor de a nombre de*/
  $sql_pro=_query("SELECT proveedor.nombreche, proveedor.nombre,proveedor.contacto FROM proveedor WHERE id_proveedor=$id_proveedor AND id_sucursal='$id_sucursal'");
  $rp=_fetch_array($sql_pro);
  $proveedor=$rp['nombre'];
  if($rp['nombreche'] !="")
  {
    $proveedor=$rp['nombreche'];
  }
  /*actualizar correlativos*/
  $sql_result=_query("SELECT voc FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $row=_fetch_array($sql_result);
  $correlativo=$row['voc']+1;

  $correlative=str_pad($correlativo, 15, '0', STR_PAD_LEFT);

  $table = 'correlativo';
  $form_data = array(
    'voc' => $correlativo
  );
  $where_clause = "id_sucursal ='".$id_sucursal."'";
  $insertar = _update($table, $form_data, $where_clause);
  if (!$insertar)
  {
    $ver2=1;
  }
  /*insertar el movimiento*/
  $id_movimiento = "";
  $fecha= date('Y-m-d');
  $numero_doc=$correlative;
  if($forma != "Efectivo")
  {
    $tipo="Egreso";
    $alias_tipodoc="VOC";
    $salida=$total_a_pagar;
    $concepto='Pago de facturas';

    $sql = _query("SELECT mov_cta_banco.id_movimiento,mov_cta_banco.id_cuenta,mov_cta_banco.saldo FROM mov_cta_banco WHERE mov_cta_banco.id_cuenta=$id_cuenta AND id_movimiento=(SELECT MAX(mov_cta_banco.id_movimiento) AS ultm FROM mov_cta_banco WHERE mov_cta_banco.id_cuenta=$id_cuenta)");
    $row = _fetch_array($sql);
    $saldo = $row['saldo'];
    $saldo=round(($saldo-$salida),2);

    $table = 'mov_cta_banco';
    $form_data = array(
      'id_cuenta' => $id_cuenta,
      'tipo' => $tipo,
      'alias_tipodoc' => $alias_tipodoc,
      'numero_doc' => $numero_doc,
      'salida' => $salida,
      'saldo' => $saldo,
      'fecha' => $fecha,
      'responsable' => $proveedor,
      'concepto' => '',
      'id_sucursal' => $id_sucursal,
    );
    $insertar = _insert($table, $form_data);
    if ($insertar)
    {
      $id_movimiento = _insert_id();
    }
    else
    {
      $ver3=1;
    }
  }
  $table_up = "voucher";
  $form_data_up = array(
  'forma_pago' => $forma,
  'referencia_pago' => "",
  'numero_doc' => $numero_doc,
  'fecha' => $fecha,
  'responsable' => $proveedor,
  'monto' => $total_a_pagar,
  'estado' => "PENDIENTE",
  'id_movimiento' => $id_movimiento,
  'id_sucursal' => $id_sucursal,
  );
  $insertar12 = _insert($table_up, $form_data_up);
  if($insertar12)
  {
    $id_voucher = _insert_id();
    foreach ($array as $fila)
    {
      $table='voucher_mov';
      $form_data = array(
        'id_movimiento' => $id_voucher,
        'id_cuenta_pagar'=>$fila['id_cuenta_pagar'],
      );
      $insertar = _insert($table, $form_data);
      if (!$insertar)
      {
        $ver4=1;
      }
    }
  }
  else
  {
    $ver0 =1;
    $ver4 =1;
  }
  if($ver0==0&&$ver1==0&&$ver2==0&&$ver3==0&&$ver4==0)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro guardado con exito!';
    $xdatos['process']='insert';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro no pudo ser guardado !'.$ver1."-".$ver2."-".$ver3."-".$ver4;
  }
  echo json_encode($xdatos);
}

function genera_select()
{
  $id_proveedor=$_POST['id'];
  $id_sucursal =$_SESSION['id_sucursal'];

  $sql="SELECT cuenta_pagar.numero_doc, cuenta_pagar.fecha,cuenta_pagar.id_cuenta_pagar,cuenta_pagar.saldo_pend FROM cuenta_pagar WHERE cuenta_pagar.id_sucursal='$id_sucursal' AND cuenta_pagar.id_proveedor=$id_proveedor AND cuenta_pagar.saldo_pend!=0  ORDER BY cuenta_pagar.fecha_vence ASC";
  $result=_query($sql);
  $count=_num_rows($result);
  if ($count>0) {
    for ($y=0;$y<$count;$y++) {
      $row=_fetch_array($result);
      $id1=$row['id_cuenta_pagar'];
      $description="".$row['fecha']."|".$row['numero_doc']."| $ ".$row['saldo_pend'];
      echo '<option value="'.$id1.'">'.$description.'</option>';
    }
  }
  else
  {
    echo '<option value="-1">NO SE ENCONTRARON  FACTURAS</option>';
  }
}

function addFactura()
{
  # code...
  $id_cuenta_pagar=$_POST['id_cuenta_pagar'];
  $sql="SELECT cuenta_pagar.numero_doc, cuenta_pagar.fecha,cuenta_pagar.id_cuenta_pagar,cuenta_pagar.saldo_pend FROM cuenta_pagar WHERE cuenta_pagar.id_cuenta_pagar='$id_cuenta_pagar' AND cuenta_pagar.saldo_pend!=0 ";
  $result=_query($sql);
  while ($row=_fetch_array($result))
  {
    # code...
    $fact="<tr saldo_pend='$row[saldo_pend]' class='$row[id_cuenta_pagar]' id='$row[id_cuenta_pagar]'>
    <td class='fecha'>$row[fecha]</td>
    <td class='numero' numero='$row[numero_doc]'>$row[numero_doc] <input type='hidden' id='id_cuenta_pagar' name='id_cuenta_pagar' value='$row[id_cuenta_pagar]'></td>
    <td class='cargo'>$row[saldo_pend]</td>
    <td class='nm porcentaje'></td>
    <td class='descuento'></td>
    <td class='devolucion ed'></td>
    <td class='bonificacion ed'></td>
    <td class='retencion ed'></td>
    <td class='vin ed'></td>
    <td class='saldo $row[id_cuenta_pagar]'>$row[saldo_pend]</td>
    <td class='text-center'></td>
    </tr>";
    $xdatos['fact']=$fact;
  }
  echo json_encode($xdatos);
}
function cuentas_b()
{
  $id_banco = $_POST["id_banco"];
  $sql = _query("SELECT * FROM cuenta_banco WHERE id_banco='$id_banco'");
  $opt = "<option value=''>Seleccione</option>";
  while ($row = _fetch_array($sql)) {
    $opt .="<option value='".$row["id_cuenta"]."'>".$row["nombre_cuenta"]."</option>";
  }
  $xdatos["typeinfo"] = "Success";
  $xdatos["opt"] = $opt;
  echo json_encode($xdatos);
}

function saldoBanco()
{
  $id_cuenta = $_POST["id_cuenta"];
  $sql = _query("SELECT mov_cta_banco.id_movimiento,mov_cta_banco.id_cuenta,mov_cta_banco.saldo FROM mov_cta_banco WHERE mov_cta_banco.id_cuenta=$id_cuenta AND id_movimiento=(SELECT MAX(mov_cta_banco.id_movimiento) AS ultm FROM mov_cta_banco WHERE mov_cta_banco.id_cuenta=$id_cuenta)");
  $row = _fetch_array($sql);
  $saldo = $row['saldo'];
  if(!($saldo>0))
  {
    $saldo = 0;
  }
  $xdatos["typeinfo"] = "Success";
  $xdatos["saldo"] = $saldo;
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
      case 'inser':
      insertar();
      break;
      case 'genera_select':
      genera_select();
      break;
      case 'addFactura':
      addFactura();
      break;
      case 'val':
      cuentas_b();
      break;
      case 'saldo':
      saldoBanco();
      break;
    }
  }
}
?>
