 	<?php
  include ("_core.php");

	function initial()
	{// Page setup
		$_PAGE = array ();
		$_PAGE ['title'] = 'Administrar Cortes';
		$_PAGE ['links'] = null;
		$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/select2/select2-bootstrap.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
		$_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
		include_once "header.php";
		include_once "main_menu.php";
		$id_sucursal=$_SESSION['id_sucursal'];
		$id_user = $_SESSION["id_usuario"];
		$sql_user = _query("SELECT * FROM usuario WHERE id_usuario = '$id_user'");
		$row_user = _fetch_array($sql_user);
		$tipo_usuario = $row_user["admin"];

		date_default_timezone_set('America/El_Salvador');
		$fecha_actual = date("Y-m-d");
		$hora_actual = date("H:i:s");
	 	$id_user=$_SESSION["id_usuario"];
		$admin=$_SESSION["admin"];
		$fecha_2 = date('Y-m-d');
		$fecha_1 = date('Y-m-01');

		$uri = $_SERVER['SCRIPT_NAME'];
		$filename=get_name_script($uri);
		$links=permission_usr($id_user,$filename);
		//permiso del script

    $fecha_actual = date("Y-m-d");
    $sql_apertura = _query("SELECT * FROM apertura_caja WHERE id_sucursal = '$id_sucursal' AND vigente = 1");
    $cuenta = _num_rows($sql_apertura);
    if($cuenta > 0)
    {

        while ($row_a = _fetch_array($sql_apertura))
        {
          $id_apertura = $row_a["id_apertura"];
          $fecha_ape = $row_a['fecha'];
          if($fecha_actual != $fecha_ape)
          {

            /*inicio*/
            $id_app = $id_apertura;
        		$turno_detalle = $row_a["turno"];


            	$fecha_actual=$fecha_ape;
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
                $sql_caja = _query("SELECT * FROM mov_caja WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_app'   AND id_sucursal = '$id_sucursal'");
                $cuenta_caja = _num_rows($sql_caja);

            	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            	$sql_corte = _query("SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_app'   AND id_sucursal = '$id_sucursal' AND finalizada = 1 AND anulada = 0 AND credito = 0");
            	$cuenta = _num_rows($sql_corte);
            	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            	$sql_min_max = _query("SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND numero_doc LIKE '%TIK%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1 UNION ALL SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND numero_doc LIKE '%COF%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1 UNION ALL SELECT MIN(numero_doc) as minimo, MAX(numero_doc) as maximo FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND numero_doc LIKE '%CCF%' AND id_sucursal = '$id_sucursal' AND anulada = 0 AND finalizada = 1" );
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

            /*fin calculos*/

            /*inicio corte*/
            date_default_timezone_set('America/El_Salvador');
            $fecha_corte = $fecha_ape;
            $total_efectivo = $total_corte;
            $total_corte = $total_corte;
            $diferencia = 0;
            $fecha_actual = $fecha_ape;
            $hora_actual = "21:00:00";
            $id_sucursal = $_SESSION['id_sucursal'];
            $id_empleado = $empleado;
            $tipo_corte = "C";
            $total_entrada = $total_entrada_caja;
            $total_salida = $total_salida_caja;
            $lista_dev = "";

            $tike = $total_tike_e + $total_tike_g;
            $factura = $total_factura_e + $total_factura_g;
            $credito = $total_credito_fiscal_e + $total_credito_fiscal_g;
            $reserva = $total_reserva_g + $total_reserva_e;


            $tabla = "controlcaja";
            $form_data = array(
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
                );
                if($insertar)
                {
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
                            'vigente' => 1
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

            }
            /*fin corte*/

              $tabla = "apertura_caja";
              $form_data = array(
                  'vigente' => 0,
                  'turno_vigente' => 0,
                  );
              $where_up = "id_apertura='".$id_apertura."'";
              $update = _update($tabla, $form_data, $where_up);
              if($update)
              {
                  $table_up = "detalle_apertura";
                  $form_up = array(
                      'vigente' => 0,
                      );
                  $where_deta = "id_apertura='".$id_apertura."' AND vigente = 1";
                  $up_date = _update($table_up,$form_up, $where_deta);

              }
          }
        }

    }
    $admin=1;
		if ($links!='NOT' || $admin=='1' ){
	?>
 	<input type="hidden" name="admin" id="admin" value="<?php echo $admin;?>">
 	<input type="hidden" name="id_emple" id="id_emple" value="<?php echo $id_user;?>">
 	<div class="wrapper wrapper-content  animated fadeInRight">
 	    <div class="row" id="row1">
 	        <div class="col-lg-12">
 	            <div class="ibox float-e-margins">
 	                <!--?php
					echo"<div class='ibox-title'>
						<a href='facturacion.php' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar factura</a>
						</div>";
					?-->
 	                <div class="ibox-content">
 	                    <!--load datables estructure html-->
 	                    <header>
 	                        <h4>Administrar Cortes</h4>
 	                    </header>
 	                    <section>
 	                        <?php
								$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user'");
                //echo "SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user'";
								//echo "SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user'";
	    						$cuenta_apertura = _num_rows($sql_apertura);
	    						if($cuenta_apertura != 0 )
		    						{
	    							///////////////////////////////////////////////////////////////////////////////////////////
	    							$row_apertura = _fetch_array($sql_apertura);
	    							$id_apertura = $row_apertura["id_apertura"];
	    							$monto_apertura = $row_apertura["monto_apertura"];
	    							$id_empleado = $row_apertura["id_empleado"];
	    							$fecha_apertura = $row_apertura["fecha"];
	    							$hora_apertura = $row_apertura["hora"];
	    							$turno = $row_apertura["turno"];
	    							$turno_vigente = $row_apertura["turno_vigente"];

                    $sql_empleado="";
                    if ($id_empleado<0) {
                      # code...
                      $sql_empleado = _query("SELECT * FROM usuario WHERE id_usuario = '$id_empleado'");
                    }
                    else {
                      # code...
                      $sql_empleado = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$id_empleado'");
                    }
					if(_num_rows($sql_empleado) > 0){
						$rr = _fetch_array($sql_empleado);
	    				$nombre = $rr["nombre"];
					}
					else{
						$nombre = "ADMINISTRADOR";
					}
	    							
	    							$turno_txt = "";
										echo "<input type='hidden' id='aper_id' name='aper_id' value='".$id_apertura."'>";
	    							/////////////////////////////////////////////////////////////////////////////////////////////
	    							$sql_corte = _query("SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND id_sucursal = '$id_sucursal' AND finalizada = 1 AND anulada = 0 AND credito = 0");
									$cuenta = _num_rows($sql_corte);
                  //echo "SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND id_sucursal = '$id_sucursal' AND pagada = 1 AND anulada = 0 AND tipo_pago != 'CRE'";
									$total_tike = 0;
									$total_factura = 0;
									$total_credito_fiscal = 0;
									$total_dev = 0;
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

									$total_corte = $total_tike + $total_factura + $total_credito_fiscal;
	    						?>

 	                        <div class="row">
 	                            <input type="hidden" name="id_apertura" id="id_apertura"
 	                                value="<?php echo $id_apertura;?>">
 	                            <table class="table table-bordered">
 	                                <thead>
 	                                    <tr>
 	                                        <th colspan="3" style="text-align: center"><label class="badge badge-success"
 	                                                style="font-size: 15px; ">Apertura Vigente</label></th>
 	                                    </tr>
 	                                    <tr>
 	                                        <th>Nombre: <?php echo $nombre;?></th>
 	                                        <th>Fecha Apertura: <?php echo ED($fecha_apertura);?></th>
 	                                        <th>Hora Apertura: <?php echo $hora_apertura;?></th>
 	                                    </tr>
 	                                    <tr>
 	                                        <th>Monto Apertura: <?php echo "$".$monto_apertura;?></th>
 	                                        <th>Turno: <?php echo $turno;?></th>
 	                                        <th>Monto Registrado: <?php echo $total_corte;?></th>
 	                                    </tr>
 	                                    <?php
			                        				$sql_d_ap = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1 AND id_usuario = '$id_user'");
			                        				$cuenta_a = _num_rows($sql_d_ap);
			                        				if($cuenta_a == 1)
			                        				{
				                        			?>
 	                                    <tr>
 	                                        <th colspan="3" style="text-align: center">
 	                                            <a <?php echo "href='corte_caja_diario.php?aper_id=".$id_apertura."'";?>
 	                                                id="generar_corte" name="generar_corte"
 	                                                class="btn btn-primary m-t-n-xs"> Realizar Corte</a>
 	                                            <?php if($turno_vigente == 1){?>
 	                                            <a data-toggle='modal' id="cerrar_turno" name="cerrar_turno"
 	                                                class="btn btn-primary m-t-n-xs"
 	                                                <?php  echo "href='cierre_turno.php?id_apertura=".$id_apertura."&turno=".$turno."&val=0'"?>
 	                                                data-target='#viewModal' data-refresh='true'>Cerrar Turno</a>
 	                                            <?php
				                        					}
				                        					?>
 	                                        </th>
 	                                    </tr>
 	                                    <?php
			                        				}
			                        				else
			                        				{
			                        					$sql_d_ap1 = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1");
			                        					$row_sp1 = _fetch_array($sql_d_ap1);
			                        					$id_d_ap = $row_sp1["id_detalle"];
			                        					$emp = $row_sp1["id_usuario"];
			                        					if($emp != 0)
			                        					{
                                          $sql_empleado1="";
                                          if ($emp<0) {
                                            # code...


                                            $sql_empleado1 = _query("SELECT * FROM usuario WHERE id_usuario = '$emp'");

                                          }
                                          else {
                                            # code...

                                            $sql_empleado = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$emp'");

                                          }

							    							$rr1 = _fetch_array($sql_empleado1);
							    							$nombre1 = $rr1["nombre"];
							    							if($tipo_usuario != 1)
							    							{
							    								echo "<tr>";
					                        					echo "<th colspan='3' style='text-align: center'>";
					                        					echo "Ya existe un turno vigente realizado por ".$nombre1;
					                        					echo "</th>";
					                        					echo "</tr>";
							    							}
							    							else
							    							{
							    								echo "<tr>";
					                        					echo "<th colspan='3' style='text-align: center'>";
					                        					echo "Ya existe un turno vigente realizado por ".$nombre1;
					                        					echo "</th>";
					                        					echo "</tr>";
					                        					echo "<tr>";
					                        					echo "<th colspan='3' style='text-align: center'>";
					                        					echo "<a href='corte_caja_diario.php?aper_id=".$id_apertura."' id='generar_corte' name='generar_corte' class='btn btn-primary m-t-n-xs' > Realizar Corte</a> <a data-toggle='modal' id='cerrar_turno' name='cerrar_turno' class='btn btn-primary m-t-n-xs' href='cierre_turno.php?id_apertura=".$id_apertura."&turno=".$turno."&id_detalle=".$id_d_ap."&emp=".$emp."&val=1' data-target='#viewModal' data-refresh='true' >Cerrar Turno Vigente</a>";
					                        					echo "</th>";
					                        					echo "</tr>";
							    							}

			                        					}
			                        					else
			                        					{
			                        						echo "<tr>";
				                        					echo "<th colspan='3' style='text-align: center'>";
				                        					echo "<a id='apertura_turno' name='apertura_turno' class='btn btn-primary m-t-n-xs' >Iniciar Turno</a>";
				                        					echo "</th>";
				                        					echo "</tr>";
				                        					echo "<input type='hidden' class='id_d_ap1' id='id_d_ap1' value='".$id_d_ap."'>";
			                        					}

			                        				}
			                        			?>

 	                                </thead>
 	                            </table>
 	                        </div>
 	                        <?php
	    						}
	    						else
	    						{
										if($admin == 1)
										{

											?>
 	                        <div class="">
 	                            <table class="table table-bordered">
 	                                <thead>
 	                                    <tr>
 	                                        <td>
 	                                            <select class="select col-lg-6" name="id_caja" id="id_caja">
 	                                                <?php
																		$sql_caja = _query("SELECT * FROM caja WHERE activa = 1 AND caja.id_sucursal=$_SESSION[id_sucursal] ORDER BY id_caja  ASC");
																		while ($row_caja = _fetch_array($sql_caja))
																		{
																			$id_caja = $row_caja["id_caja"];
																			$nombre = $row_caja["nombre"];
																			echo "<option value='".$id_caja."'>".$nombre."</option>";
																		}

																?>
 	                                            </select>
 	                                        </td>
 	                                    </tr>
 	                                </thead>
 	                            </table>
 	                            <div id="caja_caja">

 	                            </div>
 	                        </div>
 	                        <input type="hidden" name="caja_id" id="caja_id" value="0">
 	                        <?php


										}
										else
										{
											$sql_coprueba = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'");
		    							$cuenta_prueba = _num_rows($sql_coprueba);
		    							if ($cuenta_prueba > 0)
		    							{
		    								$row_comprueba = _fetch_array($sql_coprueba);
		    								$id_empleadox = $row_comprueba["id_empleado"];
		    								$sql_em = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$id_empleadox'");
		    								$rrs = _fetch_array($sql_em);
		    								$nombre_em = $rrs["nombre"];
		    								if($id_empleadox != $id_user)
		    								{
		    									echo "<div></div>
					    							<div class='alert alert-warning text-center' style='font-weight: bold;'>
					    								<label style='font-size: 15px;'>Ya existe una apertura de caja realizada ".$nombre_em."!!</label>
					    								<br>
					    								<label style='font-size: 15px;'>Debe de realizar el corte para poder iniciar una nueva apertura de caja.</label>

					    							</div>";
					    								}
			    							}
			    							else
			    							{
			    							echo "<div></div>
			    							<div class='alert alert-warning text-center' style='font-weight: bold;'>
			    								<label style='font-size: 15px;'>Sin apertura de caja</label>
			    								<br>
			    								<br>
			    								<a href='apertura_caja.php?id_caja=1' id='apertura' name='apertura' class='btn btn-primary m-t-n-xs' >Realizar Apertura</a>
			    							</div>";
			    							}
											}

	    						}
							?>

 	                    </section>
 	                    <section>
 	                        <div class="widget">
 	                            <div class="row">
 	                                <div class="widget-content">
 	                                    <div class="col-lg-1">
 	                                        <label>Desde:</label>
 	                                    </div>
 	                                    <div class="col-lg-3">
 	                                        <input type="text" name="fecha1" id="fecha1" class="form-control datepick"
 	                                            value="<?php echo $fecha_1;?>">
 	                                    </div>
 	                                    <div class="col-lg-1">
 	                                        <label>Hasta</label>
 	                                    </div>
 	                                    <div class="col-lg-3">
 	                                        <input type="text" name="fecha2" id="fecha2" class="form-control datepick"
 	                                            value="<?php echo $fecha_2;?>">
 	                                    </div>
 	                                    <div class="col-lg-2">

 	                                    </div>
 	                                    <div class="col-lg-1" style="text-align: left;">
 	                                        <a id='search' name='search' class='btn btn-primary m-t-n-xs'
 	                                            style="margin-top: 0.5%;"><i class="fa fa-search"></i> Buscar</a>
 	                                    </div>
 	                                </div>
 	                            </div>
 	                        </div>
 	                    </section>
 	                    <section>
 	                        <table class="table table-striped table-bordered table-hover" id="editable">
 	                            <thead>
 	                                <tr>
 	                                    <th>N°</th>
 	                                    <th>Fecha</th>
 	                                    <th>Hora</th>
 	                                    <th>Empleado</th>
 	                                    <th>Turno</th>
 	                                    <th>Tipo Corte</th>
 	                                    <th>Total</th>
 	                                    <th>Diferencia</th>
 	                                    <th>Acci&oacute;n</th>
 	                                </tr>
 	                            </thead>
 	                            <tbody id="caja_x">
 	                                <?php
									$s = 1;
									$sql_cc =_query("SELECT * FROM controlcaja WHERE id_sucursal = '$id_sucursal' AND fecha_corte BETWEEN '$fecha_1' AND '$fecha_2' AND tipo_corte != '' ORDER BY id_corte DESC");
									$cuenta_corte = _num_rows($sql_cc);
									if($cuenta_corte > 0)
									{
										while ($row_cc = _fetch_array($sql_cc))
										{
											$id_corte = $row_cc["id_corte"];
											$fecha_corte = ED($row_cc["fecha_corte"]);
											$hora_corte = $row_cc["hora_corte"];
											$id_empleado_c = $row_cc["id_empleado"];
											$id_apertura = $row_cc["id_apertura"];
											$tipo_corte = $row_cc["tipo_corte"];
											$total = $row_cc["cashfinal"];
											$diferencia = $row_cc["diferencia"];
											$turno = $row_cc["turno"];
						$sql_empleadox="";
						if ($id_empleado_c<0) {
							# code...
							$sql_empleadox = _query("SELECT * FROM usuario WHERE id_usuario = '$id_empleado_c'");
						}
						else {
							# code...
							$sql_empleadox = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$id_empleado_c'");
						}
						$nombre = "";
						if(_num_rows($sql_empleadox) > 0){
							$rr = _fetch_array($sql_empleadox);
							$nombre = $rr["nombre"];
						}
			    							



			    							echo "<tr>";
			    							echo "<td>".$s."</td>";
			    							echo "<td>".$fecha_corte."</td>";
			    							echo "<td>".$hora_corte."</td>";
			    							echo "<td>".$nombre."</td>";
			    							echo "<td>".$turno."</td>";
			    							echo "<td>".$tipo_corte."</td>";
			    							echo "<td>".$total."</td>";
			    							echo "<td>".$diferencia."</td>";
			    							echo "<td><div class=\"btn-group\">
												<a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
												<ul class=\"dropdown-menu dropdown-primary\">";

												echo "
												<li><a data-toggle='modal' href='imprimir_corte.php?id_corte=".$id_corte."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-ticket\"></i> Imprimir</a></li>
												";
												echo "
												<li><a href='corte_caja_pdf.php?id_corte=".$id_corte."' target='_blank'><i class=\"fa fa-print\"></i> Imprimir Reporte</a></li>
												";
												echo "	</ul>
															</div>
															</td>
															</tr>";
			    							$s += 1;
										}
									}
								?>
 	                            </tbody>
 	                        </table>
 	                        <input type="hidden" name="autosave" id="autosave" value="false-0">
 	                    </section>
 	                    <!--Show Modal Popups View & Delete -->
 	                    <div class='modal fade' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
 	                        aria-hidden='true'>
 	                        <div class='modal-dialog'>
 	                            <div class='modal-content'></div><!-- /.modal-content -->
 	                        </div><!-- /.modal-dialog -->
 	                    </div><!-- /.modal -->
 	                    <div class='modal fade' id='deleteModal' tabindex='-1' role='dialog'
 	                        aria-labelledby='myModalLabel' aria-hidden='true'>
 	                        <div class='modal-dialog'>
 	                            <div class='modal-content modal-sm'></div><!-- /.modal-content -->
 	                        </div><!-- /.modal-dialog -->
 	                    </div><!-- /.modal -->
 	                </div>
 	                <!--div class='ibox-content'-->
 	            </div>
 	            <!--<div class='ibox float-e-margins' -->
 	        </div>
 	        <!--div class='col-lg-12'-->
 	    </div>
 	    <!--div class='row'-->
 	</div>
 	<!--div class='wrapper wrapper-content  animated fadeInRight'-->
 	<?php
		include("footer.php");
		echo" <script type='text/javascript' src='js/funciones/funciones_corte_caja.js'></script>";
		} //permiso del script
	else {
			echo "<div></div><br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div>";
		}
	}
	function caja()
	{
		$admin=$_SESSION["admin"];
		$id_caja = $_POST["id_caja"];
		$id_empleado1 = $_POST["id_empleado"];
		$id_sucursal = $_SESSION["id_sucursal"];
		date_default_timezone_set('America/El_Salvador');
		$fecha_actual = date("Y-m-d");
		$hora_actual = date("H:i:s");
		$sql_inicio = _query("SELECT * FROM apertura_caja WHERE caja = '$id_caja' AND vigente = 1 AND id_sucursal = '$id_sucursal'");
		$cuenta = _num_rows($sql_inicio);
		$total_corte = 0;
		if($cuenta > 0)
		{
			$row_apertura = _fetch_array($sql_inicio);
			$id_apertura = $row_apertura["id_apertura"];
			$monto_apertura = $row_apertura["monto_apertura"];
			$id_empleado = $row_apertura["id_empleado"];
			$fecha_apertura = $row_apertura["fecha"];
			$hora_apertura = $row_apertura["hora"];
			$turno = $row_apertura["turno"];
			$turno_vigente = $row_apertura["turno_vigente"];

      $sql_empleado="";
      if ($id_empleado<0) {
        # code...
        $sql_empleado = _query("SELECT * FROM usuario WHERE id_usuario = '$id_empleado'");
      }
      else {
        # code...
        $sql_empleado = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$id_empleado'");

      }	
	  $nombre = "";
	  		if(_num_rows($sql_empleado) > 0){
				$rr = _fetch_array($sql_empleado);
				$nombre = $rr["nombre"];
			}
			
			$turno_txt = "";
			echo "<input type='hidden' id='aper_id' name='aper_id' value='".$id_apertura."'>";
			/////////////////////////////////////////////////////////////////////////////////////////////
			$sql_corte = _query("SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND id_sucursal = '$id_sucursal' AND finalizada = 1 AND anulada = 0");
			//echo "SELECT * FROM factura WHERE fecha = '$fecha_apertura' AND id_apertura = '$id_apertura'   AND id_sucursal = '$id_sucursal' AND finalizada = 1 AND anulada = 0";
			$cuenta = _num_rows($sql_corte);
			$total_tike = 0;
			$total_factura = 0;
			$total_credito_fiscal = 0;
			$total_dev = 0;
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

		$total_corte = $total_tike + $total_factura + $total_credito_fiscal;
?>
 	<div class="row">
 	    <input type="hidden" name="id_apertura" id="id_apertura" value="<?php echo $id_apertura;?>">
 	    <table class="table table-bordered">
 	        <thead>
 	            <tr>
 	                <th colspan="3" style="text-align: center"><label class="badge badge-success"
 	                        style="font-size: 15px; ">Apertura Vigente</label></th>
 	            </tr>
 	            <tr>
 	                <th>Nombre: <?php echo $nombre;?></th>
 	                <th>Fecha Apertura: <?php echo ED($fecha_apertura);?></th>
 	                <th>Hora Apertura: <?php echo $hora_apertura;?></th>
 	            </tr>
 	            <tr>
 	                <th>Monto Apertura: <?php echo "$".$monto_apertura;?></th>
 	                <th>Turno: <?php echo $turno;?></th>
 	                <th>Monto Registrado: <?php echo $total_corte;?></th>
 	            </tr>
 	            <?php
						$sql_d_ap = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1 AND id_usuario = '$id_empleado1'");
						//echo "SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1 AND id_usuario = '$id_empleado'";
						$cuenta_a = _num_rows($sql_d_ap);
						if($cuenta_a == 1)
						{
						?>
 	            <tr>
 	                <th colspan="3" style="text-align: center">
 	                    <a <?php echo "href='corte_caja_diario.php?aper_id=".$id_apertura."'";?> id="generar_corte"
 	                        name="generar_corte" class="btn btn-primary m-t-n-xs"> Realizar Corte</a>
 	                    <?php if($turno_vigente == 1){?>
 	                    <a data-toggle='modal' id="cerrar_turno" name="cerrar_turno" class="btn btn-primary m-t-n-xs"
 	                        <?php  echo "href='cierre_turno.php?id_apertura=".$id_apertura."&turno=".$turno."&val=0'"?>
 	                        data-target='#viewModal' data-refresh='true'>Cerrar Turno</a>
 	                    <?php
								}
								?>
 	                </th>
 	            </tr>
 	            <?php
						}
						else
						{
							$sql_d_ap1 = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1");
							$row_sp1 = _fetch_array($sql_d_ap1);
							$id_d_ap = $row_sp1["id_detalle"];
							$emp = $row_sp1["id_usuario"];
							if($emp != 0)
							{
								$sql_empleado1 = _query("SELECT empleado.nombre FROM usuario JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$emp'");
								$rr1 = _fetch_array($sql_empleado1);
								$nombre1 = $rr1["nombre"];
								if($admin != 1)
								{
									echo "<tr>";
														echo "<th colspan='3' style='text-align: center'>";
														echo "Ya existe un turno vigente realizado por ".$nombre1;
														echo "</th>";
														echo "</tr>";
								}
								else
								{
									echo "<tr>";
														echo "<th colspan='3' style='text-align: center'>";
														echo "Ya existe un turno vigente realizado por ".$nombre1;
														echo "</th>";
														echo "</tr>";
														echo "<tr>";
														echo "<th colspan='3' style='text-align: center'>";
														echo "<a href='corte_caja_diario.php?aper_id=".$id_apertura."' id='generar_corte' name='generar_corte' class='btn btn-primary m-t-n-xs' > Realizar Corte</a> <a data-toggle='modal' id='cerrar_turno' name='cerrar_turno' class='btn btn-primary m-t-n-xs' href='cierre_turno.php?id_apertura=".$id_apertura."&turno=".$turno."&id_detalle=".$id_d_ap."&emp=".$emp."&val=0' data-target='#viewModal' data-refresh='true' >Cerrar Turno Vigente</a>";
														echo "</th>";
														echo "</tr>";
								}

							}
							else
							{
								echo "<tr>";
								echo "<th colspan='3' style='text-align: center'>";
								echo "<a id='apertura_turno' name='apertura_turno' class='btn btn-primary m-t-n-xs' >Iniciar Turno</a>";
								echo "</th>";
								echo "</tr>";
								echo "<input type='hidden' class='id_d_ap1' id='id_d_ap1' value='".$id_d_ap."'>";
							}

						}
					?>

 	        </thead>
 	    </table>
 	</div>
 	<?php
		}
		else
		{
			$sql_coprueba = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND caja = '$id_caja'");
			//echo "SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'";
			$cuenta_prueba = _num_rows($sql_coprueba);
			if ($cuenta_prueba > 0)
			{
				$row_comprueba = _fetch_array($sql_coprueba);
				$id_empleadox = $row_comprueba["id_empleado"];
				$sql_em = _query("SELECT empleado.nombre FROM usuario  LEFT JOIN empleado ON usuario.id_empleado = empleado.id_empleado WHERE usuario.id_usuario = '$id_empleadox'");
				$rrs = _fetch_array($sql_em);
				$nombre_em = $rrs["nombre"];
				if($id_empleadox != $id_empleado1)
				{
					echo "<div></div>
						<div class='alert alert-warning text-center' style='font-weight: bold;'>
							<label style='font-size: 15px;'>Ya existe una apertura de caja realizada ".$nombre_em."!!</label>
							<br>
							<label style='font-size: 15px;'>Debe de realizar el corte para poder iniciar una nueva apertura de caja.</label>

						</div>";
							}
			}
			else
			{
			echo "<div></div>
			<div class='alert alert-warning text-center' style='font-weight: bold;'>
				<label style='font-size: 15px;'>Sin apertura de caja</label>
				<br>
				<br>
				<a id='apertura' name='apertura' class='btn btn-primary m-t-n-xs aper' >Realizar Apertura</a>
			</div>";
			}
		}
	}
	function search()
	{
		$id_sucursal = $_SESSION["id_sucursal"];
		$fecha1 = $_POST["fecha1"];
		$fecha2 = $_POST["fecha2"];
		$s = 1;

		$sql_cc =_query("SELECT * FROM controlcaja WHERE id_sucursal = '$id_sucursal' AND fecha_corte BETWEEN '$fecha1' AND '$fecha2' AND tipo_corte != '' ORDER BY id_corte DESC");
		$cuenta_corte = _num_rows($sql_cc);
		$lista = "";
		if($cuenta_corte > 0)
		{
			while ($row_cc = _fetch_array($sql_cc))
			{
				$id_corte = $row_cc["id_corte"];
				$fecha_corte = ED($row_cc["fecha_corte"]);
				$hora_corte = $row_cc["hora_corte"];
				$id_empleado_c = $row_cc["id_empleado"];
				$id_apertura = $row_cc["id_apertura"];
				$tipo_corte = $row_cc["tipo_corte"];
				$total = $row_cc["cashfinal"];
				$diferencia = $row_cc["diferencia"];
				$turno = $row_cc["turno"];

				$sql_empleadox = _query("SELECT * FROM empleados WHERE id_empleado = '$id_empleado_c'");
				$rr = _fetch_array($sql_empleadox);
				$nombre = $rr["nombre"];


				$lista.= "<tr>";
				$lista.= "<td>".$s."</td>";
				$lista.= "<td>".$fecha_corte."</td>";
				$lista.= "<td>".$hora_corte."</td>";
				$lista.= "<td>".$nombre."</td>";
				$lista.= "<td>".$turno."</td>";
				$lista.= "<td>".$tipo_corte."</td>";
				$lista.= "<td>".$total."</td>";
				$lista.= "<td>".$diferencia."</td>";
				$lista.= "<td><div class=\"btn-group\">
						<a href=\"#\" data-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle\"><i class=\"fa fa-user icon-white\"></i> Menu<span class=\"caret\"></span></a>
						<ul class=\"dropdown-menu dropdown-primary\">";

							$lista.= "
							<li><a data-toggle='modal' href='imprimir_corte.php?id_corte=".$id_corte."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-print\"></i> Imprimir</a></li>
							";


				$lista.= "	</ul>
								</div>
								</td>
								</tr>";
				$s += 1;
			}
		}
		echo $lista;

	}
	if (!isset($_REQUEST['process'])) {
	    initial();
	}
	//else {
	if (isset($_REQUEST['process'])) {
	    switch ($_REQUEST['process']) {
	    case 'ok':
	        search();
	        break;
			case 'caja':
					caja();
						break;
	    }

	 //}
	}
	?>