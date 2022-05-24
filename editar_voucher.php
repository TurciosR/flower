<?php
include_once "_core.php";
function initial()
{
    $title = 'Editar Voucher de Pago';
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
  $id_cuenta=$_REQUEST['id_cuenta'];
  $id_voucher=$_REQUEST['id_voucher'];
  $id_movimiento=$_REQUEST['id_movimiento'];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename="editar_pago_proveedor.php";
	$links=permission_usr($id_user,$filename);

  /*obtener el id del banco*/
  $sqlb=_fetch_array(_query("SELECT id_banco FROM cuenta_banco WHERE id_cuenta=$id_cuenta"));
  $id_banco=$sqlb['id_banco'];

  $sqlc=_query("SELECT * FROM cuenta_banco WHERE id_banco=$id_banco");

  $sqld=_fetch_array(_query("SELECT salida,saldo FROM mov_cta_banco WHERE id_movimiento=$id_movimiento"));
  $saldo_cu=$sqld['salida']+$sqld['saldo'];
  $saldo_cu=round($saldo_cu,2);

  $id_row_p=_fetch_array(_query("SELECT cuenta_pagar.id_proveedor, voucher.forma_pago FROM voucher JOIN voucher_mov ON voucher_mov.id_movimiento=voucher.id_voucher JOIN cuenta_pagar ON cuenta_pagar.id_cuenta_pagar=voucher_mov.id_cuenta_pagar WHERE voucher.id_voucher=$id_voucher LIMIT 1 "));
  $id_pro=$id_row_p['id_proveedor'];
  $forma=$id_row_p['forma_pago'];

?>
<style media="screen">
  select
  {
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
                <input type="hidden" id="id_movimiento" name="id_movimiento" value="<?php echo $id_movimiento ?>">
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label>Proveedor &nbsp;</label>

                          <select readonly class="form-control select" id="select_proveedor" style="width: 100%;">
                            <option value="-1">Seleccione</option>
                            <?php
                                $sql_b = _query("SELECT * FROM proveedor");
                                while ($row_b = _fetch_array($sql_b)) {
                                  if ($row_b["id_proveedor"]==$id_pro) {
                                    # code...
                                    echo "<option value='".$row_b["id_proveedor"]."' selected>".$row_b["nombre"]."</option>";
                                  }
                                  else
                                  {
                                    echo "<option value='".$row_b["id_proveedor"]."'>".$row_b["nombre"]."</option>";
                                  }

                                }
                            ?>
                          </select>
                        </div>
                      </div>
                      <?php if($forma != "Efectivo"){?>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label>Banco&nbsp;</label>
                          <select readonly class="form-control select" id="banco" style="width: 100%;">
                            <option value="">Seleccione</option>
                            <?php
                                $sql_b = _query("SELECT * FROM banco");
                                while ($row_b = _fetch_array($sql_b)) {
                                  if ($row_b["id_banco"]==$id_banco) {
                                    # code...
                                    echo "<option value='".$row_b["id_banco"]."' selected>".$row_b["nombre"]."</option>";
                                  }
                                  else
                                  {
                                    echo "<option value='".$row_b["id_banco"]."'>".$row_b["nombre"]."</option>";
                                  }

                                }
                            ?>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label>Cuenta&nbsp;</label>
                          <select readonly class="form-control select" id="cuenta" style="width: 100%;">
                            <option value="">Seleccione</option>
                            <?php
                                while ($row_b = _fetch_array($sqlc)) {
                                  if ($row_b["id_cuenta"]==$id_cuenta) {
                                    # code...
                                    echo "<option value='".$row_b["id_cuenta"]."' selected>".$row_b["nombre_cuenta"]."</option>";
                                  }
                                  else
                                  {
                                    echo "<option value='".$row_b["id_cuenta"]."'>".$row_b["nombre_cuenta"]."</option>";
                                  }

                                }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label>Saldo Cuenta&nbsp;</label>
                          <input class="form-control" readonly type="text" id="saldo" name="saldo" value="<?php echo $saldo_cu ?>">
                        </div>
                      </div>
                    <?php }?>
                      <div class="row">
                        <div class="col-md-12">
                          <br>
                          <select multiple="multiple" readonly size="6" name="duallistbox_demo2" class="demo2">
                            <?php
                              $id_sucursal =$_SESSION['id_sucursal'];
                              $sql="SELECT cuenta_pagar.numero_doc, cuenta_pagar.fecha,cuenta_pagar.id_cuenta_pagar,cuenta_pagar.saldo_pend FROM cuenta_pagar WHERE cuenta_pagar.id_sucursal='$id_sucursal' AND cuenta_pagar.id_proveedor=$id_pro AND cuenta_pagar.saldo_pend!=0  ORDER BY cuenta_pagar.fecha_vence ASC";
                              $result=_query($sql);
                              $count=_num_rows($result);
                              if ($count>0) {
                                  for ($y=0;$y<$count;$y++) {
                                      $row=_fetch_array($result);
                                      $id1=$row['id_cuenta_pagar'];
                                      $description="".$row['fecha']."|".$row['numero_doc']."| $ ".$row['saldo_pend'];
                                      $s=0;
                                      $rs=_query("SELECT * FROM voucher_mov WHERE id_movimiento=$id_voucher");
                                      while ($row2=_fetch_array($rs)) {
                                        # code...
                                        if($id1==$row2['id_cuenta_pagar'])
                                        {
                                          $s=1;
                                        }

                                      }

                                      if($s==1)
                                      {
                                        echo '<option value="'.$id1.'" selected>'.$description.'</option>';
                                      }
                                      else {
                                        # code...
                                        echo '<option value="'.$id1.'">'.$description.'</option>';
                                      }


                                  }
                              } else {
                                  echo '<option value="">NO SE ENCONTRARON  FACTURAS</option>';
                              }
                             ?>
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
                            </tr>
                            <tbody>
                              <?php

                                $rs=_query("SELECT * FROM voucher_mov WHERE id_movimiento=$id_voucher");
                                $tot = 0;
                                while ($row2=_fetch_array($rs)) {
                                  $i=1;
                                  $cargo=0;
                                  $result=_query("SELECT * FROM detalle_voucher WHERE id_cuenta_pagar=$row2[id_cuenta_pagar]");

                                  while ($row=_fetch_array($result)) {
                                    # code...
                                    if ($i==1)
                                    {
                                      # code...
                                      $cargo=$row['cargo'];

                                      echo "<tr saldo_pend='$row[cargo]' class='$row[id_detalle]' id='$row[id_cuenta_pagar]'>";
                                      echo "<td class='fecha'>$row[fecha]</td>";
                                      echo "<td class='numero'numero='$row[numero]'>$row[numero] <input type='hidden' id='fact_id_cuenta_pagar' name='fact_id_cuenta_pagar' value='$row[id_cuenta_pagar]'></td>";
                                      echo "<td class='cargo'>$row[cargo]</td>";
                                      echo "<td class='porcentaje'>$row[porcentage]</td>";
                                      echo "<td class='descuento'>$row[descuento]</td>";
                                      echo "<td class='devolucion'>$row[devolucion]</td>";
                                      echo "<td class='bonificacion'>$row[bonificacion]</td>";
                                      echo "<td class='retencion'>$row[retencion]</td>";
                                      echo "<td class='vin'>$row[vin]</td>";
                                      echo "<td class='saldo $row[id_cuenta_pagar]'>$row[saldo]</td>";
                                      echo "</tr>";
                                    }
                                    else
                                    {
                                      echo "<tr saldo_pend='$cargo' class='$row[id_detalle]' id='$row[id_cuenta_pagar]'>";
                                      echo "<td class='fecha ddate'>$row[fecha]</td>";
                                      echo "<td class='numero tex' numero='$row[numero]'>$row[numero] <input type='hidden' id='fact_id_cuenta_pagar' name='fact_id_cuenta_pagar' value='$row[id_cuenta_pagar]'></td>";
                                      echo "<td class='cargo'>$row[cargo]</td>";
                                      echo "<td class='porcentaje'>$row[porcentage]</td>";
                                      echo "<td class='descuento'>$row[descuento]</td>";
                                      echo "<td class='devolucion'>$row[devolucion]</td>";
                                      echo "<td class='bonificacion'>$row[bonificacion]</td>";
                                      echo "<td class='retencion'>$row[retencion]</td>";
                                      echo "<td class='vin'>$row[vin]</td>";
                                      echo "<td class='saldo $row[id_cuenta_pagar]'>$row[saldo]</td>";
                                      echo "</tr>";
                                    }
                                    $i=$i+1;
                                    $tot = $row["saldo"];
                                  }

                                }
                               ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-12">
                          <table class="table">
                            <tr>
                              <td class="col-lg-10">Total a cancelar</td>

                              <td id="total_a_" name="total_a_pagar" class="col-lg-1"><?php echo $tot;?></td>
                              <td class="col-lg-1"></td>
                            </tr>
                          </table>

                        </div>
                      </div>
                        <input type="hidden" name="process" id="process" value="inser2"><br>
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
        echo "<script src='js/funciones/funciones_editar_pago_proveedor.js'></script>";
        echo "<script src='js/plugins/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js'></script>";
	} //permiso del script
    else
    {
    		echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
    }
}

function insertar()
{
    $array_json=$_POST["array_json"];
    $array_json2=$_POST["array_json2"];
    $id_cuenta=$_POST["id_cuenta"];
    $total_a_pagar=$_POST["total_a_p"];
    $id_sucursal=$_SESSION["id_sucursal"];
    $id_movimiento=$_POST['id_movimiento'];

    _begin();

    $ver1=0;
    $ver2=0;
    $ver3=0;
    $ver4=0;

    $delval1=0;
    $delval2=0;

    $array = json_decode($array_json, true);
    $array2 = json_decode($array_json2, true);

    /*borramos los detalles anteriores*/
    /*insertamos los detalles*/
    foreach ($array2 as $fila2) {
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
        'saldo' => $fila2['saldo']
      );
      $where = "id_detalle = '".$fila2["id_cuenta_pagar"]."' AND id_sucursal='$id_sucursal'";
      $insertar=_update($table,$form_data,$where);
      if (!$insertar)
      {
        $ver1=1;
      }
    }
    if($ver1==0&&$ver2==0&&$ver3==0&&$ver4==0&&$delval1==0&&$delval2==0)
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
    } else {
        echo '<option value="">NO SE ENCONTRARON  FACTURAS</option>';
    }
}

function addFactura()
{
  # code...
  $id_cuenta_pagar=$_POST['id_cuenta_pagar'];
  $sql="SELECT cuenta_pagar.numero_doc, cuenta_pagar.fecha,cuenta_pagar.id_cuenta_pagar,cuenta_pagar.saldo_pend FROM cuenta_pagar WHERE cuenta_pagar.id_cuenta_pagar='$id_cuenta_pagar' AND cuenta_pagar.saldo_pend!=0 ";
  $result=_query($sql);

  while ($row=_fetch_array($result)) {
    # code...
    $fact="<tr saldo_pend='$row[saldo_pend]' class='$row[id_cuenta_pagar]' id='$row[id_cuenta_pagar]'>
          <td class='fecha'>$row[fecha]</td>
          <td class='numero' numero='$row[numero_doc]'>$row[numero_doc] <input type='hidden' id='fact_id_cuenta_pagar' name='fact_id_cuenta_pagar' value='$row[id_cuenta_pagar]'></td>
          <td class='cargo'>$row[saldo_pend]</td>
          <td class='porcentaje nm'></td>
          <td class='descuento '></td>
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
        	case 'inser2':
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
