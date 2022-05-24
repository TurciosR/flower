<?php
include_once "_core.php";
include ('num2letras.php');
include ('facturacion_funcion_imprimir.php');
function initial() {
	$_PAGE = array ();
	$title= 'Corte de Caja Diario';
	$_PAGE ['title'] =$title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';


	date_default_timezone_set('America/El_Salvador');

	$val = $_REQUEST["val"];
	$val=0;
	if($val == 1)
	{
		$id_app = $_REQUEST["id_apertura"];
		$turno_detalle = $_REQUEST["turno"];
		$id_detalle = $_REQUEST["id_detalle"];
		$emp = $_REQUEST["emp"];
	}
	else
	{
		$id_app = $_REQUEST["id_apertura"];
		$turno_detalle = $_REQUEST["turno"];
	}


	$fecha_actual=date("Y-m-d");
	$id_sucursal=$_SESSION['id_sucursal'];
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal=$array_sucursal['descripcion'];

	//permiso del script
 	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];

	$sql_apertura = _query("SELECT * FROM apertura_caja WHERE id_apertura = '$id_app'");
	$cuenta = _num_rows($sql_apertura);
	$row_apertura = _fetch_array($sql_apertura);
	$id_apertura = $row_apertura["id_apertura"];
	$tike_inicia = $row_apertura["tiket_inicia"];
	$factura_inicia = $row_apertura["factura_inicia"];
	$credito_inicia = $row_apertura["credito_fiscal_inicia"];
	$empleado = $row_apertura["id_empleado"];
	$dev_inicia = $row_apertura["dev_inicia"];
	$turno = $row_apertura["turno"];
	$fecha_apertura = $row_apertura["fecha"];
	$hora_apertura = $row_apertura["hora"];
	$monto_apertura = $row_apertura["monto_apertura"];
	$monto_apertura = $monto_apertura +$row_apertura["monto_ch"];

	$hora_actual = date('H:i:s');
	/////////////////////////////////////////Correlativo//////////////////////////////////////////////////////////
	$n_tiket = 0;
    $n_factura = 0;
    $n_credito_fiscal = 0;
    $n_dev = 0;


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $sql_caja = _query("SELECT * FROM mov_caja WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_app' AND hora BETWEEN '$hora_apertura' AND '$hora_actual' AND id_sucursal = '$id_sucursal'");
    $cuenta_caja = _num_rows($sql_caja);

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$sql_corte = _query("SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_app' AND hora BETWEEN '$hora_apertura' AND '$hora_actual' AND id_sucursal = '$id_sucursal' AND finalizada = 1 AND anulada = 0 AND credito = 0");
	$cuenta = _num_rows($sql_corte);
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$sql_min_max = _query("SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura' AND hora BETWEEN '$hora_apertura' AND '$hora_actual' AND numero_doc LIKE '%TIK%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1 UNION ALL SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura' AND hora BETWEEN '$hora_apertura' AND '$hora_actual' AND numero_doc LIKE '%COF%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1 UNION ALL SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura' AND hora BETWEEN '$hora_apertura' AND '$hora_actual' AND numero_doc LIKE '%CCF%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1" );
	$cuenta_min_max = _num_rows($sql_min_max);

	$total_tike_e = 0;
	$total_factura_e = 0;
	$total_credito_fiscal_e = 0;
	$total_reserva_e = 0;
	$total_dev_e = 0;
	$total_tike_g = 0;
	$total_factura_g = 0;
	$total_credito_fiscal_g = 0;
	$total_reserva_g = 0;
	$total_dev_g = 0;
	$tike_min = 0;
	$tike_max = 0;
	$factura_min = 0;
	$factura_max = 0;
	$credito_fiscal_min = 0;
	$credito_fiscal_max = 0;
	$dev_min = 0;
	$dev_max = 0;
	$res_min = 0;
	$res_max = 0;
	$t_tike = 0;
	$t_factuta = 0;
	$t_credito = 0;
	$t_dev = 0;
	$t_res = 0;
	$t_recerva = 0;
	$total_contado = 0;
	$total_tarjeta = 0;
	$total_tike = 0;
	$total_factura = 0;
	$total_credito_fiscal = 0;
	$lista_dev = "";
	if($cuenta > 0)
	{
		while ($row_corte = _fetch_array($sql_corte))
		{
			$id_factura = $row_corte["id_factura"];
      $anulada = $row_corte["anulada"];
      $subtotal = $row_corte["subtotal"];
      $suma = $row_corte["sumas"];
      $iva = $row_corte["iva"];
      $total = $row_corte["total"];
      $numero_doc = $row_corte["numero_doc"];

      $ax = explode("_", $numero_doc);
      $numero_co = $ax[0];
      $alias_tipodoc = $ax[1];


      if($alias_tipodoc == 'TIK')
      {
          $total_tike += $total;
      }
      else if($alias_tipodoc == 'COF')
      {
          $total_factura += $total;
      }
      else if($alias_tipodoc == 'CCF')
      {
          $total_credito_fiscal += $total;
      }



		}
	}
	if($cuenta_min_max)
        {
            $i = 1;
            while ($row_min_max = _fetch_array($sql_min_max))
            {
                if($i == 1)
                {
                    $tike_min = $row_min_max["minimo"];
                    $tike_max = $row_min_max["maximo"];
                    if($tike_min != "" && $tike_max != "")
                    {
                    list($minimo_num,$ads) = explode("_", $tike_min);
                    list($maximo_num,$ads) = explode("_", $tike_max);
                	}
                    if($tike_min > 0)
                    {
                        $tike_min = $minimo_num;
                    }
                    else
                    {
                        $tike_min = 0;
                    }

                    if($tike_max > 0)
                    {
                        $tike_max = $maximo_num;
                    }
                    else
                    {
                        $tike_max = 0;
                    }
                }
                if($i == 2)
                {
                    $factura_min = $row_min_max["minimo"];
                    $factura_max = $row_min_max["maximo"];
                    if($factura_max != "" && $factura_min != "")
                    {
                    list($minimo_num,$ads) = explode("_", $factura_min);
                    list($maximo_num,$ads) = explode("_", $factura_max);
                	}
                    if($factura_min != "")
                    {
                        $factura_min = $minimo_num;
                    }
                    else
                    {
                        $factura_min = 0;
                    }

                    if($factura_max != "")
                    {
                        $factura_max = $maximo_num;
                    }
                    else
                    {
                        $factura_max = 0;
                    }
                }
                if($i == 3)
                {
                    $credito_fiscal_min = $row_min_max["minimo"];
                    $credito_fiscal_max = $row_min_max["maximo"];
                    if($credito_fiscal_min != "" && $credito_fiscal_max != 0)
                    {
                    list($minimo_num,$ads) = explode("_", $credito_fiscal_min);
                    list($maximo_num,$ads) = explode("_", $credito_fiscal_max);
                	}
                    if($credito_fiscal_min != "")
                    {
                        $credito_fiscal_min = $minimo_num;
                    }
                    else
                    {
                        $credito_fiscal_min = 0;
                    }

                    if($credito_fiscal_max != "")
                    {
                        $credito_fiscal_max = $maximo_num;
                    }
                    else
                    {
                        $credito_fiscal_max = 0;
                    }
                }
                $i += 1;
            }
        }
	$total_entrada_caja = 0;
	$total_salida_caja = 0;
	if($cuenta_caja > 0)
	{
		while ($row_caja = _fetch_array($sql_caja))
		{
			$monto = $row_caja["valor"];
			$entrada = $row_caja["entrada"];
			$salida = $row_caja["salida"];

			if($entrada == 1 && $salida == 0)
			{
				$total_entrada_caja += $monto;
			}
			else if($salida == 1 && $entrada == 0)
			{
				$total_salida_caja += $monto;
			}
		}
	}

	$sql_monto_dev=_fetch_array(_query("SELECT SUM(factura.total) AS total_devoluciones FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='DEV' AND factura.id_apertura_pagada=$id_apertura"));
	$monto_dev=$sql_monto_dev['total_devoluciones'];

	$sql_monto_dev=_fetch_array(_query("SELECT SUM(factura.total) AS total_devoluciones FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='NC' AND factura.id_apertura_pagada=$id_apertura"));
	$monto_nc=$sql_monto_dev['total_devoluciones'];

	//$total_devolucion = $total_dev_g + $total_dev_e;
	$total_corte = $total_tike + $total_factura- $monto_dev - $monto_nc  + $total_credito_fiscal + $monto_apertura  + $total_entrada_caja - $total_salida_caja;

	$total_exx = $total_tike_e+$total_factura_e+$total_credito_fiscal_e+$total_reserva_e;
	$total_graa = $total_tike_g+$total_factura_g+$total_credito_fiscal_g+$total_reserva_g;
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
	//permiso del script
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Corte Caja v.06072020</h4>
</div>
<div class="modal-body">
    <form name="formulario1" id="formulario1">
        <div class="row">
            <div class="col-md-6" hidden>
                <div class="form-group has-info single-line">
                    <input type="hidden" name="tipo_corte" id="tipo_corte" value="C">
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Ticket Gravado en Sistema $ </label>
                    <input type='text' class='form-control' id='total_ticket_gravado' name='total_ticket_gravado'
                        value='<?php echo $total_tike_g;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Ticket Exento en Sistema $ </label>
                    <input type='text' class='form-control' id='total_ticket_exento' name='total_ticket_exento'
                        value='<?php echo $total_tike_e;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Factura Gravado en Sistema $ </label>
                    <input type='text' class='form-control' id='total_factura_gravado' name='total_factura_gravado'
                        value='<?php echo $total_factura_g;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Factura Exento en Sistema $ </label>
                    <input type='text' class='form-control' id='total_factura_exento' name='total_factura_exento'
                        value='<?php echo $total_factura_e;?>' readOnly>
                </div>
            </div>

        </div>
        <div class="row" hidden>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Credito Fiscal Gravado en Sistema $ </label>
                    <input type='text' class='form-control' id='total_credito_fiscal_gravado'
                        name='total_credito_fiscal_gravado' value='<?php echo $total_credito_fiscal_g;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Credito Gravado Exento en Sistema $ </label>
                    <input type='text' class='form-control' id='total_credito_fiscal_exento'
                        name='total_credito_fiscal_exento' value='<?php echo $total_credito_fiscal_e;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" id="dev" hidden="true">
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Devoluciones Gravado en Sistema $ </label>
                    <input type='text' class='form-control' id='total_dev_gravado' name='total_dev_gravado'
                        value='<?php echo $total_dev_g;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Devoluciones Exento en Sistema $ </label>
                    <input type='text' class='form-control' id='total_dev_exento' name='total_dev_exento'
                        value='<?php echo $total_dev_e;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" id="caja" hidden="true">
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Entradas de Caja en Sistema $ </label>
                    <input type='text' class='form-control' id='total_entrada' name='total_entrada'
                        value='<?php echo $total_entrada_caja;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Salidas de Caja en Sistema $ </label>
                    <input type='text' class='form-control' id='total_salida' name='total_salida'
                        value='<?php echo $total_salida_caja;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" id="res" hidden>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Reserva Gravado en Sistema $ </label>
                    <input type='text' class='form-control' id='total_reserva_gravado' name='total_reserva_gravado'
                        value='<?php echo $total_reserva_g;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Reserva Exento en Sistema $ </label>
                    <input type='text' class='form-control' id='total_reserva_exento' name='total_reserva_exento'
                        value='<?php echo $total_reserva_e;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Ventas Efectivo $ </label>
                    <input type='text' class='form-control' id='total_contado' name='total_contado'
                        value='<?php echo $total_contado;?>' readOnly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-info single-line">
                    <label>Total Ventas con Tarjeta $ </label>
                    <input type='text' class='form-control' id='total_tarjeta' name='total_tarjeta'
                        value='<?php echo $total_tarjeta;?>' readOnly>
                </div>
            </div>
        </div>
        <div class="row" hidden>
            <div class="col-md-4">
                <div class="form-group has-info single-line">
                    <label>Total Efectivo en Caja $ </label>
                    <input type="text" id="total_efectivo1" name="total_efectivo1" value=""
                        class="form-control decimal decimal">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-info single-line">
                    <label>Total Corte Caja $ </label>
                    <input type="text" id="total_corte" name="total_corte" value="<?php echo round($total_corte,2);?>"
                        class="form-control decimal" readOnly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-info single-line">
                    <label>Diferencia</label>
                    <input type="text" id="diferencia" name="diferencia" value="" class="form-control decimal" readOnly>
                </div>
            </div>
        </div>
        <!--div class="row"-->
        <!--div class="row"-->
        <?php

        ?>

        <div class="row af" <?php if($val == 0){ echo "hidden";}?>>
            <div class="col-md-12">
                <div class="form-group has-info text-center alert alert-warning">
                    <label>Ingrese las credenciales</label>
                </div>
            </div>
        </div>
        <div class="row af" <?php if($val == 0){ echo "hidden";}?>>
            <div class="col-md-12">
                <div class="form-group has-info single-line">
                    <label>Usuario</label><input type="text" id="user_ad" name="tuser_ad" value=""
                        class="form-control decimal">
                </div>
            </div>
        </div>
        <div class="row af" <?php if($val == 0){ echo "hidden";}?>>
            <div class="col-md-12">
                <div class="form-group has-info single-line">
                    <label>Contraseña</label><input type="password" id="pass" name="pass" value=""
                        class="form-control decimal">
                </div>
            </div>
        </div>
        <table class="table table-border df" id="table_t" <?php if($val == 1){ echo "hidden";}?>>
            <thead>
                <tr>
                    <th class="col-md-4">Total Efectivo en Caja $</th>
                    <th class="col-md-4" style="text-align: center">Total Corte Caja $</th>
                    <th class="col-md-4" style="text-align: center">Diferencia $</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" id="total_efectivo" name="total_efectivo" value=""
                            class="form-control decimal decimal">
                    </td>
                    <td style="text-align: center">
                        <label id="id_total_general"><?php echo number_format($total_corte,2,".","");?></label>
                    </td>
                    <td style="text-align: center">
                        <label id="id_diferencia"><?php echo "-".number_format($total_corte,2,".","");?></label>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="process" id="process" value="insert"><br>
        <!--
			<input type="hidden" name="lista_tike" id="lista_tike" value="<?php print_r($lista_tike);?>">
			<input type="hidden" name="lista_factura" id="lista_factura" value="<?php print_r($lista_factura);?>">
			<input type="hidden" name="lista_credito_fiscal" id="lista_credito_fiscal" value="<?php print_r($lista_credito_fiscal);?>">-->
        <input type="hidden" name="lista_dev" id="lista_dev" value="<?php print_r($lista_dev);?>">

        <input type="hidden" name="t_tike" id="t_tike" value="<?php echo $t_tike;?>">
        <input type="hidden" name="t_factuta" id="t_factuta" value="<?php echo $t_factuta;?>">
        <input type="hidden" name="t_credito" id="t_credito" value="<?php echo $t_credito;?>">
        <input type="hidden" name="t_dev" id="t_dev" value="<?php echo $t_dev;?>">
        <input type="hidden" name="t_res" id="t_res" value="<?php echo $t_res;?>">

        <input type="hidden" name="total_tike" id="total_tike" value="<?php echo $total_tike;?>">
        <input type="hidden" name="total_factura" id="total_factura" value="<?php echo $total_factura;?>">
        <input type="hidden" name="total_credito" id="total_credito" value="<?php echo $total_credito_fiscal;?>">

        <input type="hidden" name="fecha_actual" id="fecha_actual" value="<?php echo $fecha_actual;?>">
        <input type="hidden" name="hora_actual" id="hora_actual" value="<?php echo $hora_actual;?>">
        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal;?>">
        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $empleado;?>">
        <input type="hidden" name="turno" id="turno" value="<?php echo $turno;?>">
        <input type="hidden" name="id_apertura" id="id_apertura" value="<?php echo $id_app;?>">

        <input type="hidden" name="tike_min" id="tike_min" value="<?php echo $tike_min;?>">
        <input type="hidden" name="tike_max" id="tike_max" value="<?php echo $tike_max;?>">
        <input type="hidden" name="factura_min" id="factura_min" value="<?php echo $factura_min;?>">
        <input type="hidden" name="factura_max" id="factura_max" value="<?php echo $factura_max;?>">
        <input type="hidden" name="credito_fiscal_min" id="credito_fiscal_min"
            value="<?php echo $credito_fiscal_min;?>">
        <input type="hidden" name="credito_fiscal_max" id="credito_fiscal_max"
            value="<?php echo $credito_fiscal_max;?>">
        <input type="hidden" name="dev_min" id="dev_min" value="<?php echo $dev_min;?>">
        <input type="hidden" name="dev_max" id="dev_max" value="<?php echo $dev_max;?>">
        <input type="hidden" name="res_min" id="res_min" value="<?php echo $res_min;?>">
        <input type="hidden" name="res_max" id="res_max" value="<?php echo $res_max;?>">

        <input type="hidden" name="monto_apertura" id="monto_apertura" value="<?php echo $monto_apertura;?>">
    </form>
    <script type="text/javascript">
    $(".decimal").numeric({
        negative: false
    });
    </script>
</div>
<div class="modal-footer">
    <div class="row df" <?php if($val == 1){ echo "hidden";}?>>
        <div class="col-md-12">
            <button type="button" class="btn btn-primary df" id="btnCorte">Finalizar</button>
            <button type="button" class="btn btn-default df" data-dismiss="modal">Close</button>
        </div>
    </div>
    <div class="row af" <?php if($val == 0){ echo "hidden";}?>>
        <div class="col-md-12">
            <button type="button" class="btn btn-primary " id="btnAceptar">Confirmar</button>
        </div>
    </div>
</div>
<?php

}

function corte()
{
	date_default_timezone_set('America/El_Salvador');
	$fecha_corte = date('Y-m-d');
	$total_tike_g = $_POST["total_ticket_gravado"];
	$total_tike_e = $_POST["total_ticket_exento"];
	$total_factura_e = $_POST["total_factura_exento"];
	$total_factura_g = $_POST["total_factura_gravado"];
	$total_credito_fiscal_e = $_POST["total_credito_fiscal_exento"];
	$total_credito_fiscal_g = $_POST["total_credito_fiscal_gravado"];
	$total_reserva_g = $_POST["total_reserva_gravado"];
	$total_reserva_e = $_POST["total_reserva_exento"];
	$total_efectivo = $_POST["total_efectivo"];
	$total_corte = $_POST["total_corte"];
	$diferencia = $_POST["diferencia"];
	$t_tike = $_POST["t_tike"];
	$t_factuta = $_POST["t_factuta"];
	$t_credito = $_POST["t_credito"];
	$t_dev = $_POST["t_dev"];
	$t_res = $_POST["t_res"];
	$fecha_actual = $_POST["fecha_actual"];
	$hora_actual = $_POST["hora_actual"];
	$id_sucursal = $_POST["id_sucursal"];
	$id_empleado = $_POST["id_empleado"];
	$turno = $_POST["turno"];
	$id_apertura = $_POST["id_apertura"];
	$tike_min = $_POST["tike_min"];
	$tike_max = $_POST["tike_max"];
	$factura_min = $_POST["factura_min"];
	$factura_max = $_POST["factura_max"];
	$credito_fiscal_min = $_POST["credito_fiscal_min"];
	$credito_fiscal_max = $_POST["credito_fiscal_max"];
	$dev_min = $_POST["dev_min"];
	$dev_max = $_POST["dev_max"];
	$res_min = $_POST["res_min"];
	$res_max = $_POST["res_max"];
	$monto_apertura = $_POST["monto_apertura"];
	$tipo_corte = $_POST["tipo_corte"];
	$total_entrada = $_POST["total_entrada"];
	$total_salida = $_POST["total_salida"];
	$lista_dev = $_POST["lista_dev"];
	$total_contado = $_POST["total_contado"];
	$total_tarjeta = $_POST["total_tarjeta"];
	$tike = $total_tike_e + $total_tike_g;
	$factura = $total_factura_e + $total_factura_g;
	$credito = $total_credito_fiscal_e + $total_credito_fiscal_g;
	$reserva = $total_reserva_g + $total_reserva_e;
	//$dev = $total_dev_e + $total_dev_g;
	$total_tike= $_POST["total_tike"];
	$total_factura = $_POST["total_factura"];
	$total_credito_fiscal = $_POST["total_credito"];

	$tabla = "controlcaja";
	$form_data = array(
		'id_server' => '0',
		'fecha_corte' => $fecha_actual,
		'hora_corte' => $hora_actual,
		'id_empleado' => $id_empleado,
		'id_sucursal' => $id_sucursal,
		'id_apertura' => $id_apertura,
		'texento' => $total_tike_e,
		'tgravado' => $total_tike,
		'totalt' => $total_tike,
		'fexento' => $total_factura_e,
		'fgravado' => $total_factura,
		'totalf' => $total_factura,
		'cfexento' => $total_credito_fiscal_e,
		'cfgravado' => $total_credito_fiscal,
		'totalcf' => $total_credito_fiscal,
		'diferencia' => $diferencia,
		'totalgral' => $total_corte,
		'cashfinal' => $total_efectivo,
		'totalnot' => $t_tike,
		'totalnof' => $t_factuta,
		'totalnocf' => $t_credito,
		'turno' => $turno,
		'tinicio' => $tike_min,
		'tfinal' => $tike_max,
		'finicio' => $factura_min,
		'ffinal' => $factura_max,
		'cfinicio' => $credito_fiscal_min,
		'cffinal' => $credito_fiscal_max,
		'cashinicial' => $monto_apertura,
		'tipo_corte' => $tipo_corte,
		'vtaefectivo' => $total_contado,
		'tarjetas' => $total_tarjeta,
		'vales' => $total_salida,
		'ingresos' => $total_entrada,
		'totalnodev' => $t_dev,
		'rinicio' => $res_min,
		'rfinal' => $res_max,
		'totalnor' => $t_res,
		'rexento' => $total_reserva_e,
		'rgravado' => $total_reserva_g,
		'totalr' => $reserva,
		'fecha' => date("Y:m:d"),
		'tiket' => '0',
		'ticket_e' => '0',
		'monto_ch' => '0',
		'retencion' => '0',
		'tinicio_e' => '0',
		'tfinal_e' => '0',
		'tdoctexe' => '0',
		'tottexe' => '0',
		'finicio_e' => '0',
		'ffinal_e' => '0',
		'tdocfexe' => '0',
		'totfexe' => '0',
		'cfinicio_e' => '0',
		'cffinal_e' => '0',
		'tdoccfexe' => '0',
		'totcfexe' => '0',
		'czxe' => '0',

	);
	$sql_ = _query("SELECT * FROM controlcaja WHERE id_apertura = '$id_apertura' AND tipo_corte = 'Z'");
	$cuentax = _num_rows($sql_);
	if($cuentax == 0)
	{
		if($tipo_corte == "C")
		{
			$insertar = _insert($tabla, $form_data);
			$id_cortex= _insert_id();
			$table_apertura = "apertura_caja";
			$form_up = array(
				'monto_vendido' => $total_efectivo,
				'id_empleado'=> 0,
			);
			if($insertar)
			{
				$sql_apertura_caja = "SELECT * FROM apertura_caja WHERE id_apertura = '$id_apertura'";
				$query_apertura_caja = _query($sql_apertura_caja);
				$row_apertura_caja = _fetch_array($query_apertura_caja);
				$id_caja = $row_apertura_caja['caja'];

				$sql_turno = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' ORDER BY turno DESC LIMIT 1");
			    $row_turno = _fetch_array($sql_turno);
			    $tuno = $row_turno["turno"];
			    $id_usuario = $row_turno["id_usuario"];

			    $sql_turno = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1 ");
			    $row_turno = _fetch_array($sql_turno);
			    $id_detalle = $row_turno["id_detalle"];
			    $n_tuno = $tuno + 1;
			    $tabla = "detalle_apertura";
			    $form_data = array(
			        'vigente' => 0
			        );
			    $where_up = "id_detalle='".$id_detalle."'";
			    $update = _update($tabla, $form_data, $where_up);
			    if($update)
			    {
			        $tabla1 = "detalle_apertura";
			        $form_data1 = array(
			            'id_apertura' => $id_apertura,
			            'turno' => $n_tuno,
			            'fecha' => $fecha_actual,
			            'hora' => $hora_actual,
			            'vigente' => 1,
						'id_server' => '0',
						'id_sucursal' => $id_sucursal,
						'id_usuario' => $id_usuario,
						'caja' => $id_caja
			        );
			        $insert = _insert($tabla1, $form_data1);
			        if($insert)
			        {
			            $tabla1 = "apertura_caja";
			            $form_data1 = array(
			                'turno' => $n_tuno,
			                'turno_vigente' => 1,
			                );
			            $where_up = "id_apertura='".$id_apertura."'";
			            $update1 = _update($tabla1, $form_data1, $where_up);
			        }
			    }
			    $where_apertura = "id_apertura='".$id_apertura."'";
				$up_apertura = _update($table_apertura, $form_up, $where_apertura);


				$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.numero_doc as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='DEV' AND factura.id_apertura_pagada=$id_apertura");
				$i=1;
				while ($row_de=_fetch_array($sql_devoluciones)) {
					# code...
					list($doca,$sa)=explode("_",$row_de['numero_doc']);

					list($docb,$sb)=explode("_",$row_de['doc']);

					$table_dev = "devoluciones_corte";
					$form_dev = array(
						'id_corte' => $id_cortex,
						'n_devolucion' => $doca,
						't_devolucion' => $row_de['total'],
						'afecta' => $docb,
						'tipo' => $row_de['tipo_documento'],
					);
					$inser_dev = _insert($table_dev, $form_dev);
					$i++;
				}
				$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.num_fact_impresa as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='NC' AND factura.id_apertura_pagada=$id_apertura");
				$i=1;
				while ($row_de=_fetch_array($sql_devoluciones)) {
					# code...
					list($doca,$sa)=explode("_",$row_de['numero_doc']);
					$docb=$row_de['doc'];

					$table_dev = "devoluciones_corte";
					$form_dev = array(
						'id_corte' => $id_cortex,
						'n_devolucion' => $doca,
						't_devolucion' => $row_de['total'],
						'afecta' => $docb,
						'tipo' => $row_de['tipo_documento'],
					);
					$inser_dev = _insert($table_dev, $form_dev);
					$i++;
				}
			}


		}
		else if($tipo_corte == "X")
		{
			$insertar = _insert($tabla, $form_data);
			$id_cortex= _insert_id();


			$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.numero_doc as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='DEV' AND factura.id_apertura_pagada=$id_apertura");
			$i=1;
			while ($row_de=_fetch_array($sql_devoluciones)) {
				# code...
				list($doca,$sa)=explode("_",$row_de['numero_doc']);

				list($docb,$sb)=explode("_",$row_de['doc']);

				$table_dev = "devoluciones_corte";
				$form_dev = array(
					'id_corte' => $id_cortex,
					'n_devolucion' => $doca,
					't_devolucion' => $row_de['total'],
					'afecta' => $docb,
					'tipo' => $row_de['tipo_documento'],
				);
				$inser_dev = _insert($table_dev, $form_dev);
				$i++;
			}
			$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.num_fact_impresa as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='NC' AND factura.id_apertura_pagada=$id_apertura");
			$i=1;
			while ($row_de=_fetch_array($sql_devoluciones)) {
				# code...
				list($doca,$sa)=explode("_",$row_de['numero_doc']);
				$docb=$row_de['doc'];

				$table_dev = "devoluciones_corte";
				$form_dev = array(
					'id_corte' => $id_cortex,
					'n_devolucion' => $doca,
					't_devolucion' => $row_de['total'],
					'afecta' => $docb,
					'tipo' => $row_de['tipo_documento'],
				);
				$inser_dev = _insert($table_dev, $form_dev);
				$i++;
			}
		}
		else if($tipo_corte == "Z")
		{

			$table_apertura = "apertura_caja";
			$form_up = array(
				'vigente' => 0,
				'monto_vendido' => $total_efectivo,
			);
			$where_apertura = "id_apertura='".$id_apertura."'";
			$up_apertura = _update($table_apertura, $form_up, $where_apertura);
			if($up_apertura)
			{
				$insertar = _insert($tabla, $form_data);
				if($insertar)
				{
					$id_cortex = _insert_id();

					$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.numero_doc as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='DEV' AND factura.id_apertura_pagada=$id_apertura");
					$i=1;
					while ($row_de=_fetch_array($sql_devoluciones)) {
						# code...
						list($doca,$sa)=explode("_",$row_de['numero_doc']);

						list($docb,$sb)=explode("_",$row_de['doc']);

						$table_dev = "devoluciones_corte";
						$form_dev = array(
							'id_corte' => $id_cortex,
							'n_devolucion' => $doca,
							't_devolucion' => $row_de['total'],
							'afecta' => $docb,
							'tipo' => $row_de['tipo_documento'],
						);
						$inser_dev = _insert($table_dev, $form_dev);
						$i++;
					}
					$sql_devoluciones=_query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.num_fact_impresa as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento ='NC' AND factura.id_apertura_pagada=$id_apertura");
					$i=1;
					while ($row_de=_fetch_array($sql_devoluciones)) {
						# code...
						list($doca,$sa)=explode("_",$row_de['numero_doc']);
						$docb=$row_de['doc'];

						$table_dev = "devoluciones_corte";
						$form_dev = array(
							'id_corte' => $id_cortex,
							'n_devolucion' => $doca,
							't_devolucion' => $row_de['total'],
							'afecta' => $docb,
							'tipo' => $row_de['tipo_documento'],
						);
						$inser_dev = _insert($table_dev, $form_dev);
						$i++;
					}
				}
			}
		}

		if($insertar)
		{
			$xdatos['typeinfo']='Success';
			$xdatos['msg']='Corte guardado correctamente !';
			$xdatos['process']='insert';
			$xdatos['id_corte']=$id_cortex;
		}
		else
		{
			$xdatos['typeinfo']='Error';
		 	$xdatos['msg']='Error al guardar el corte !'._error();
		}
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='Ya existe un corte con esta apertura!';
	}
	echo json_encode($xdatos);
}

function  imprimir(){
	$id_corte = $_POST["id_corte"];
	$id_sucursal=$_SESSION['id_sucursal'];
	//directorio de script impresion cliente
	$sql_dir_print="SELECT *  FROM config_dir WHERE id_sucursal='$id_sucursal'";
	//$sql_dir_print="SELECT * FROM `config_dir` WHERE `id_sucursal`=1 ";
	$result_dir_print=_query($sql_dir_print);
	$row0=_fetch_array($result_dir_print);
	$dir_print=$row0['dir_print_script'];
	$shared_printer_win=$row0['shared_printer_matrix'];
	$shared_printer_pos=$row0['shared_printer_pos'];

	$info_mov=print_corte($id_corte);
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	$nreg_encode['shared_printer_win'] =$shared_printer_win;
	$nreg_encode['shared_printer_pos'] =$shared_printer_pos;
	$nreg_encode['dir_print'] =$dir_print;
	$nreg_encode['movimiento'] =$info_mov;
	$nreg_encode['sist_ope'] =$so_cliente;
echo json_encode($nreg_encode);
}
function confirmar()
{
	$user = $_POST["user"];
	$pass = md5($_POST["pass"]);
	$sql_user = _query("SELECT * FROM usuario WHERE usuario = '$user' AND password = '$pass'");
	$cuenta1 = _num_rows($sql_user);

	if($cuenta1 == 1)
	{
		$xdatos['typeinfo']='Success';
		$xdatos['msg']='';
		$xdatos['process']='login';
		$xdatos['val']= 1;
	}
	else
	{
		$xdatos['typeinfo']='Error';
		$xdatos['msg']='El Usuario o la Contraseña son incorrectos';
		$xdatos['process']='off';
		$xdatos['val']= 0;
	}
	echo json_encode($xdatos);
}

if(!isset($_REQUEST['process'])){
	initial();
}
else
{
if(isset($_REQUEST['process'])){
switch ($_REQUEST['process']) {
	case 'insert':
		corte();
		break;
	case 'total_sistema':
		//total_sistema();
		break;
	case 'imprimir':
		 imprimir();
		 break;
	case 'confirmar':
		confirmar();
		break;
	}
}
}
?>