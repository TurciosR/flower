<?php
include_once "_core.php";

function initial()
{
// Page setup
$_PAGE = array();
$title='Administrar Creditos (Buscar por Fechas)';
$_PAGE ['title'] = $title;
$_PAGE ['links'] = null;
$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
include_once "header.php";
include_once "main_menu.php";

$id_cuenta = $_GET['id_cuenta'];
//echo $id_cuenta;
$sql0="SELECT cpg.* FROM cuenta_pagar as cpg
/*JOIN pedidos ON pedidos.id_pedido=cpg.id_pedido*/
WHERE cpg.id_cuenta_pagar=$id_cuenta";
$result = _query($sql0);
$cuenta = _fetch_array($result);
$centinela =0;
//var_dump($cuenta);
//procedemos a generar el detalle de la cuenta
if (_num_rows($result)>0) {
  // code...
  //echo "jdjds";
  $sqlD="SELECT cpa.*, cpp.saldo_pend as saldo_total, (cpp.monto-cpp.saldo_pend) as abono_total FROM cuentas_por_pagar_abonos as cpa
  JOIN cuenta_pagar as cpp ON cpp.id_cuenta_pagar=cpa.id_cuentas_por_pagar
  WHERE cpa.id_cuentas_por_pagar=$id_cuenta";
  $detalleAbonos = _query($sqlD);
  if (_num_rows($detalleAbonos)>0) {
    // code...
    //echo "jsjs";
    $centinela = 1;
  }
  else{

  }
}
else {
  // code...
  $detalleAbonos =0;
}
//echo $centinela;
//$abono=$cuenta['abono'];
//$numero_doc=$cuenta['numero_doc'];
//$total=$cuenta['total'];
//$saldo_pend=$cuenta['saldo'];
$fecha=$cuenta['fecha'];

 ?>
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox" id="main_view">
				<div class="ibox-title">
					<h3 class="text-success"><b><i class="mdi mdi-plus"></i> Realizar Abono</b></h3>
				</div>
				<div class="ibox-content">
					<form id="form_add" novalidate>
            <input name="id_cuentas" id="id_cuentas" value="<?=$cuenta['id_cuenta_pagar']?>" class="form-control" type="hidden">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group single-line">
									<label for="saldo">Deuda Total</label>
									<input readonly type="text" name="saldo" id="saldo" value="<?=$cuenta['monto']?>" class="form-control mayu"  placeholder=""
										   required data-parsley-trigger="change">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group single-line">
									<label for="abonos">Abonos</label>
									<input readonly type="text" name="abonos" id="abonos" value="<?=($cuenta['monto']=='')?'0.00':number_format(($cuenta['monto']-$cuenta['saldo_pend']), 2, '.', '')?>" class="form-control mayu"  placeholder=""
										   required data-parsley-trigger="change">
								</div>
							</div>
              <div class="col-lg-6">
								<div class="form-group single-line">
									<label for="serie">Numero doc.</label>
									<input type="text" name="serie" id="serie" value="<?=$cuenta['numero_doc']?>" class="form-control mayu"  placeholder=""
										   data-parsley-trigger="change">
								</div>
							</div>
              <div class="col-lg-6">
								<div class="form-group single-line">
									<label for="monto">Monto</label>
									<input <?=($cuenta['saldo_pend']<=0)?'readonly':'';?> type="text" name="monto" saldo="<?=$cuenta['saldo_pend']?>" id="monto" class="form-control decimal"  placeholder="Ingrese monto del abono"
										   required data-parsley-trigger="change">
								</div>
							</div>
							<div class="form-actions col-lg-6"></div>
              <div class="form-actions col-lg-6">
                <input type="hidden" name="process" id="process" value="abonar">
                <input type="hidden" name="id_cuenta_p" id="id_cuenta_p" value="<?=$cuenta['id_cuenta_pagar']?>">
								<button type="submit" id="btn_add" name="btn_add" class="btn btn-success float-right"><i class="mdi mdi-content-save"></i>
									Guardar Registro
								</button>
							</div>
						</div>
						<br>
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable" id="">
                    <thead class="">
                        <tr>
                          <th>Fecha</th>
                          <th>Hora</th>
                          <th>Abono</th>
                          <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                      //var_dump(_fetch_array($detalleAbonos));
                        if ($centinela==0) {
                          // code...
                        }
                        else {
                          // code...
                          while( $arrDetalle = _fetch_array($detalleAbonos)) {
                            // code...
                            ?>
                              <tr>
                                <td><?=$arrDetalle['fecha']; ?></td>
                                <td><?=$arrDetalle['hora']; ?></td>
                                <td><input readonly class="form-control abono_monto decimal monto" montoa="<?=$arrDetalle['abono']; ?>" saldo="<?=$arrDetalle['saldo_total']?>" type="text" name="" value="<?=number_format($arrDetalle['abono'], 2, '.', ''); ?>"></td>
                                <td class='text-center'><a class='btn btn-danger delete_tr' monto="<?=$arrDetalle['abono']; ?>" saldo="<?=$arrDetalle['saldo_total']; ?>" abono="<?=$arrDetalle['abono_total']; ?>" cuenta="<?=$arrDetalle['id_cuentas_por_pagar']; ?>"  id="<?=$arrDetalle['id_abono']; ?>" style='color: white'><i class='fa fa-trash'></i></a></td>
                              </tr>
                            <?php
                          }
                        }
                       ?>
                    </tbody>
                </table>
            </div>
					</form>
				</div>

			</div>

            <div class="ibox" style="display: none;" id="divh">
                <div class="ibox-content text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-danger blink_me">Espere un momento, procesando su solicitud!</h2>
                            <section class="sect">
                                <div id="loader">
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

		</div>
	</div>
</div>

<?php
include("footer.php");
echo" <script type='text/javascript' src='js/funciones/funciones_cxp.js'></script>";
}

function abonar(){
//  $id_empleado=$_SESSION["id_usuario"];
  //$id_sucursal=$_SESSION["id_sucursal"];
  $id_cuentas = $_POST["id_cuentas"];
  $monto = $_POST["monto"];
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");

  $nuevosaldo=0;
  _begin();
  $table = 'cuentas_por_pagar_abonos';
  $form_data = array(
  'id_cuentas_por_pagar' => $id_cuentas,
  'abono' => $monto,
  'fecha' => $fecha,
  'hora' => $hora,
  );
  $insertar = _insert($table, $form_data);
  //echo $id_cuentas." - ".$monto." - ".$fecha." - ".$hora;

  //echo $insertar."#";
  if ($insertar) {
    $sql=_query("SELECT cpp.* FROM cuenta_pagar as cpp WHERE cpp.id_cuenta_pagar=$id_cuentas");
    $row=_fetch_array($sql);
    //$abono_previo=$row['abono'];
    $saldo=$row['saldo_pend'];
    //$nuevoAbono = $abono_previo + $monto;
    $nuevoSaldo = $saldo - $monto;

    $table = 'cuenta_pagar';
    if ($nuevoSaldo==0) {
				// code...
				$form_data = array(
				   //"abono"=>$nuevoAbono,
					 "saldo_pend"=>$nuevoSaldo,
					 //"estado"=>"1",
				);
		}
		else {
			// code...
			$form_data = array(
			//"abono"=>$nuevoAbono,
			"saldo_pend"=>$nuevoSaldo,
			);
		}
    $where_clause = "id_cuenta_pagar='" . $id_cuentas . "'";
    $updates = _update($table, $form_data, $where_clause);
    if ($updates) {
      // code...
      _commit();
        $xdatos['typeinfo']='Success';
        $xdatos['msg']='Abono realizado con exito!';
    }
    else {
      // code...
      _rollback();
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Abono no fue realizado!';
    }
  }
  else {
    // code...
    _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Abono no fue registrado!';
  }
  echo json_encode($xdatos);
}
function eliminar(){
  //$id_empleado=$_SESSION["id_usuario"];
  //$id_sucursal=$_SESSION["id_sucursal"];
  $id_cuentas = $_POST["id_cuenta"];
  $id = $_POST["id"];
  $monto = $_POST["monto"];
  $abono = $_POST["abono"];
  $saldo = $_POST["saldo"];
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");

  $nuevosaldo=0;
  _begin();

  $table = 'cuentas_por_pagar_abonos';
  $where_clause = "id_abono='" . $id . "'";
  $response = _delete($table, $where_clause);

  //$abonoTotal = $abono - $monto;
	$saldoTotal = $saldo + $monto;

  $tableC = 'cuenta_pagar';
  $form_dataC = array(
  //'unique_id' => '1',
  'saldo_pend' => $saldoTotal,
  );
  $where_clauseC = "id_cuenta_pagar='" . $id_cuentas . "'";
  $updates = _update($tableC, $form_dataC, $where_clauseC);
  //echo $updates."#";
  if ($updates) {
    // code...
    _commit();
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Abono eliminado con exito!';
  }
  echo json_encode($xdatos);
}
function actualizar(){
  $id_empleado=$_SESSION["id_usuario"];
  $id_sucursal=$_SESSION["id_sucursal"];
  $id_cuentas = $_POST["id_cuenta"];
  $id = $_POST["id"];
  $monto = $_POST["monto"];
  $montoNuevo = $_POST["montoNuevo"];
  $abono = $_POST["abono"];
  $saldo = $_POST["saldo"];
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

  $validacion = $monto - $montoNuevo;
	//echo $abono." - ".$montoNuevo;
	if ($validacion<0) {
		// se debe sumar al abono...
		$abono +=abs($validacion);
		$saldo -=abs($validacion);
	}
	else{
		$abono -=abs($validacion);
		$saldo +=abs($validacion);
	}

  $tableC = 'cuentas_por_pagar_abonos';
  $form_dataC = array(
  'abono' => $montoNuevo,
  );
  $where_clauseC = "id_abono='" . $id . "'";
  $updates = _update($tableC, $form_dataC, $where_clauseC);

  $where = " id_cuentas='".$id_cuentas."'";
			if ($saldo==0) {
				// code...
				$dataC = array(
					"abono"=>$abono,
					"saldo"=>$saldo,
					"estado"=>"1",
				);
			}
			else {
				// code...
				$dataC = array(
					"abono"=>$abono,
					"saldo"=>$saldo,
				);
			}
      $updatesC = _update("cuentas_por_pagar", $dataC, $where);
  //echo $updates."#";
  if ($updatesC) {
    // code...
    _commit();
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Abono actualizado con exito!';
  }
  else {
    // code...
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Error al actualizar abono!';
  }
  echo json_encode($xdatos);
}
if (!isset($_REQUEST['process'])) {
    initial();
}
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
    case 'eliminar':
        eliminar();
        break;
    case 'actualizar':
        actualizar();
        break;
    }

    //}
}
 ?>
