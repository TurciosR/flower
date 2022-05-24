<?php
include_once "_core.php";
include('num2letras.php');
//include("escpos-php/Escpos.php");
function initial()
{
  $id_credito=$_REQUEST["id_credito"];
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];
  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $fecha=date('d-m-Y');
  $id_sucursal=$_SESSION['id_sucursal'];
  $sql0="SELECT credito.fecha,credito.numero_doc,credito.total,credito.abono,credito.saldo FROM credito LEFT JOIN cliente ON cliente.id_cliente=credito.id_cliente WHERE credito.id_credito=$id_credito";
  $result = _query($sql0);
  $numrows= _num_rows($result);
  for ($i=0;$i<$numrows;$i++) {
    $row = _fetch_array($result);
    $abono=$row['abono'];
    $num_fact_impresa=$row['numero_doc'];
    $saldo_pend=$row['saldo'];
    $fecha=$row['fecha'];
  } ?>

  <div class="modal-header">
    <h4 class="modal-title">Abonar Credito</h4>
  </div>

  <div class="modal-body">
    <div class="row">
      <div class="form-group col-md-6">
        <label>Deuda Total&nbsp;</label>
        <input type="text"  class='form-control input_header_panel' id="deuda" value='<?php echo number_format($saldo_pend,2,".",""); ?>' readOnly />
      </div>
      <div class="form-group col-md-6">
        <label>Abonos &nbsp;</label>
        <input type="text"  class='form-control input_header_panel' id="abonos"  value='<?php echo number_format($abono,2,".",""); ?>' readOnly>
      </div>
      <?php if($saldo_pend>0){ ?>
      <div class="form-group col-md-6">
        <label>Tipo Doc.</label>
        <select class="form-control select" id="tipo_doc" style="width:100%;">
          <option value="">Seleccione</option>
          <option value="Recibo">Recibo</option>
          <option value="Voucher">Voucher</option>
          <option value="Transferencia">Transferencia</option>
          <option value="Cheque">Cheque</option>
          <option value="Otro">Otro</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label>Numero Doc.</label>
        <input type="text"  class='form-control input_header_panel' id="num_doc">
      </div>
      <div class="form-group col-md-6">
        <label>Monto</label>
        <input type="text"  class='form-control input_header_panel' id="monto">
      </div>
      <div class="form-group col-md-6">
        <label>Abonar</label><br>
        <button class="btn btn-success" type="button" id="abonar" name="abonar" disabled>Abonar</button>
      </div>
    <?php } else { ?>
      <div class="alert alert-info">Cuenta Saldada</div>
    <?php } ?>
    </div>
    <?php    if ($links!='NOT' || $admin=='1') { ?>

      <div class="row" id="row1">
        <div class="col-md-12">
          <input type='hidden' name='id_factura' id='id_factura' value='<?php echo $id_credito; ?>'>
          <input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename; ?>">
          <!--
          <h4>Fecha: &nbsp;<?php echo ED($fecha); ?></h4>
        -->
      </header>
      <section>
        <table class="table  table-striped">
          <thead>
            <tr>
              <th class="text-success col-md-2">Fecha</th>
              <th class="text-success col-md-2">Hora</th>
              <th class="text-success col-md-3">Tipo Doc</th>
              <th class="text-success col-md-2">Num. Doc</th>
              <th class="text-success col-md-2">Abono $</th>
              <th class="text-success col-md-1">Acción</th>
            </tr>
          </thead>
          <tbody id="appas">
            <?php
            $sql = _query("SELECT * FROM abono_credito WHERE id_credito=$id_credito ORDER BY id_abono_credito DESC");
            $tot = 0;
            while ($row = _fetch_array($sql)) {
              $tot += $row["abono"];
              echo "<tr>";
              echo "<td>".ED($row["fecha"])."</td>";
              echo "<td>".hora($row["hora"])."</td>";
              echo "<td>".$row["tipo_doc"]."</td>";
              echo "<td>".$row["num_doc"]."</td>";
              echo "<td class='mont'>".round($row["abono"], 2)."</td>";
              echo "<td></td>";
              //echo "<td><a class='btn delee' id='".$row["id_abono_credito"]."'><i class='fa fa-trash'></i></a></td>";
              echo "</tr>";
            } ?>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-success" colspan="4">Total</th>
              <th class="text-success" id="total"><?php echo round($tot,2,".",""); ?></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </section>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" id="clos" data-dismiss="modal">Salir</button>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $(".select").select2();
  $("#monto").numeric({negative:false,decimalPlaces:2});
});
</script>
<?php
} //permiso del script
else {

  $mensaje = mensaje_permiso();
  echo "<br><br>$mensaje</div></div></div></div>";
  include "footer.php";
}
}
function abonar()
{
  $id_empleado=$_SESSION["id_usuario"];
  $id_sucursal=$_SESSION["id_sucursal"];
  $id_credito = $_POST["id_factura"];
  $monto = $_POST["monto"];
  $num_doc = $_POST["num_doc"];
  $tipo_doc = $_POST["tipo_doc"];
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");

  $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_empleado'");
  $cuenta = _num_rows($sql_apertura);
  $id_apertura=0;
  $turno=0;
  if($cuenta>0){
    $row_apertura = _fetch_array($sql_apertura);
    $id_apertura = $row_apertura["id_apertura"];
    $turno = $row_apertura["turno"];
    $fecha_apertura = $row_apertura["fecha"];
    $hora_apertura = $row_apertura["hora"];
    $turno_vigente = $row_apertura["vigente"];
  }

  $nuevosaldo=0;
  _begin();
  $sql=_query("SELECT credito.fecha,credito.numero_doc,credito.total,credito.abono,credito.saldo FROM credito WHERE credito.id_credito=$id_credito");
  $row=_fetch_array($sql);
  $abono_previo=$row['abono'];
  $saldo=$row['saldo'];
  $num_fact_impresa=$row['numero_doc'];

  if ($monto<=$saldo)
  {
    $table = 'abono_credito';
    $form_data = array(
      'id_credito' => $id_credito,
      'abono' => $monto,
      'fecha' => $fecha,
      'hora' => $hora,
      'tipo_doc' => $tipo_doc,
      'num_doc' => $num_doc,
    );
    $insertar1 = _insert($table, $form_data);
    if ($insertar1)
    {
      $id_abono_credito = _insert_id();
      $nuevosaldo=round(($saldo-$monto), 2);
      $nuevo_val_abono=round(($abono_previo+$monto), 2);
      $table = 'credito';
      $form_data = array(
        'abono' => $nuevo_val_abono,
        'saldo' => $nuevosaldo,
      );
      $where_clause = "id_credito='" . $id_credito . "'";
      $updates = _update($table, $form_data, $where_clause);
      if ($updates) {

        $table = 'mov_caja';
        $form_data = array(
          'idtransace' => $id_abono_credito,
          'numero_doc' => $num_fact_impresa,
          'fecha' => $fecha,
          'hora' => $hora,
          'valor' =>  $monto,
          'concepto' => 'POR ABONO A CREDITO',
          'id_empleado' => $id_empleado,
          'id_sucursal' => $id_sucursal,
          'entrada' => 1,
          'turno' => $turno,
          'id_apertura' => $id_apertura,
        );
        $insertar = _insert($table, $form_data);

        if ($insertar)
        {
          _commit();
          $xdatos['typeinfo']='Success';
          $xdatos['msg']='Abono realizado con exito!';
          $xdatos["fecha"] = ED($fecha);
          $xdatos["hora"] = hora($hora);
          $xdatos["monto"] = round($monto,2);
          $xdatos["id_abono_credito"] = $id_abono_credito;
        }
        else
        {
          _rollback();
          $xdatos['typeinfo']='Error';
          $xdatos['msg']='Registro no pudo ser guardado 3!'._error();

        }
      }
      else {
        _rollback();
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Registro no pudo ser guardado 2!';
      }
    }
    else {
      _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Registro no pudo ser guardado 1!'._error();
    }
  }
  else {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='El monto a abonar es superior al saldo pendiente!';
  }

  echo json_encode($xdatos);
}
function quitar()
{
  _begin();
  $id_credito = $_POST["id_factura"];
  $id_abono = $_POST["id_abono"];
  $monto = $_POST["monto"];
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");
  $sql=_query("SELECT credito.fecha,credito.total,credito.abono,credito.saldo FROM credito WHERE credito.id_credito=$id_credito");
  $row=_fetch_array($sql);
  $abono_previo=$row['abono'];
  $saldo=$row['saldo'];
  $nuevosaldo = $saldo + $monto;
  $nuevoabono = $abono_previo - $monto;
  $table = 'credito';
  $form_data = array(
    'abono' => $nuevoabono,
    'saldo' => $nuevosaldo,
  );
  $where_clause = "id_credito='" . $id_credito . "'";
  $updates = _update($table, $form_data, $where_clause);
  if($updates)
  {
    $table1 = "abono_credito";
    $table2 = "mov_caja";
    $where1 = "id_abono_credito='".$id_abono."'";
    $where2 = "idtransace='".$id_abono."' AND concepto LIKE '%POR ABONO A CREDITO%'";
    $delete1 = _delete($table1, $where1);
    if($delete1)
    {
      $delete2 = _delete($table2, $where2);
      if($delete2)
      {
        _commit();
        $xdatos['typeinfo']='Success';
        $xdatos['msg']='Abono eliminado correctamente!';
      }
      else
      {
        _rollback();
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Abono no pudo ser eliminado!';
      }
    }
    else
    {
      _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Abono no pudo ser eliminado!';
    }
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Abono no pudo ser eliminado!';
  }

  echo json_encode($xdatos);
}
function cuentas_b()
{
  $id_banco = $_POST["id_banco"];
  $sql = _query("SELECT * FROM cuenta_bancos WHERE id_banco='$id_banco'");
  $opt = "<option value=''>Seleccione</option>";
  while ($row = _fetch_array($sql)) {
    $opt .="<option value='".$row["id_cuenta"]."'>".$row["nombre_cuenta"]."</option>";
  }
  $xdatos["typeinfo"] = "Success";
  $xdatos["opt"] = $opt;
  echo json_encode($xdatos);
}
//functions to load
if (!isset($_REQUEST['process'])) {
  initial();
}
//else {
if (isset($_REQUEST['process'])) {
  switch ($_REQUEST['process']) {
    case 'formEdit':
      initial();
      break;
      case 'val':
      cuentas_b();
      break;
      case 'abonar':
      abonar();
      break;
      case 'quitar':
      //quitar();
      break;
    }

    //}
  }
  ?>
