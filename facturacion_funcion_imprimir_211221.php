<?php
error_reporting(E_ERROR | E_PARSE);
include_once("unicode.php");

function print_ticket($id_factura)
{
	$id_sucursal=$_SESSION['id_sucursal'];
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
	$so_cliente='win';
	else
	$so_cliente='lin';
	//Empresa
	$datos_empresa=datos_empresa();
	$field= json_decode($datos_empresa, true);
	$nite=$field['nit'];
	$nrce=$field['nrc'];
	$empresa1=$field['empresa'];
	$razonsocial1=$field['razonsocial'];
	$giro1=$field['giro'];
	//Sucursal
	$nombre_sucursal1=datos_sucursal($id_sucursal);
	//inicio datos
	$info_factura="";
	$info_factura.=$empresa1."|".$nombre_sucursal1."|".$razonsocial1."|".$giro1."|".$nite."|".$nrce."|";
	//Obtener informacion de tabla Factura
	$result_fact=datos_factura($id_factura);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$id_usuario=$row_fact['id_usuario'];
		$id_vendedor=$row_fact['id_empleado'];
		$fecha=$row_fact['fecha'];
		$hora=$row_fact['hora'];
		$caja=$row_fact['caja'];
		$turno=$row_fact['turno'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];
		$descuent=$row_fact['descuento'];
		$porcentaje=$row_fact['porcentaje'];
		$sql_caja = _query("SELECT * FROM caja WHERE id_caja='$caja'");
		$dats_caja = _fetch_array($sql_caja);
		$fehca = ED($dats_caja["fecha"]);
		$resolucion = $dats_caja["resolucion"];
		$serie = $dats_caja["serie"];
		$desde = $dats_caja["desde"];
		$hasta = $dats_caja["hasta"];
		$len_numero_doc=strlen($numero_doc)-4;
		$num_fact=substr($numero_doc,0,$len_numero_doc);
		$tipo_fact=substr($numero_doc,$len_numero_doc,4);
		$numfact=espacios_izq($num_fact,10);
		//Datos de empleado usuario y vendedor
		$result_emp= datos_empleado($id_usuario,$id_vendedor);
		list($empleado,$vendedor)=explode('|',$result_emp);
		//Datos del Cliente
		$result=datos_clientes($id_cliente);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];
		$direccion=$row1['direccion'];

		//Columnas y posiciones base
		$sp2=espacios_izq(" ",12);
		$esp_init=espacios_izq(" ",1);
		$esp_precios=espacios_izq(" ",10);
		$esp_enc2=espacios_izq(" ",3);
		$esp_init2=espacios_izq(" ",23);
		$nombre_ape=texto_espacios($nombres,32);
		$dir_txt=texto_espacios($direccion,30);
		$total_final=0;
		//Datos del cliente
		/*$info_factura.=$esp_init.$empresa1."\n";
		$info_factura.=$esp_init.$razonsocial1."\n";
		$giros = explode(";", $giro1);
		for ($ni = 0; $ni < (count($giros)); $ni++)
		{
			$info_factura.=$esp_init.trim($giros[$ni])."\n";
		}*/

		//$info_factura.="ENTRADA CALLE PRINCIPAL, CTON EL CUCO,\nCHIRILAGUA, SAN MIGUEL\n";

		/*$nom = divtextlin($giro1, 35);
		foreach ($nom as $nnon)
		{
			if($nnon!="")
			{
					$info_factura.=$nnon."\n";
			}
		}*/
		//$info_factura.="TELEFONO: 2619-9285\n";

		$info_factura.=$esp_init."NIT :  ".$nite." NRC :".$nrce."\n";
		$info_factura.=$esp_init."RESOLUCION:  ".$resolucion."\n";
		$info_factura.=$esp_init."DEL ".$desde." AL ".$hasta."\n";
		$info_factura.=$esp_init."SERIE ".$serie."\n";
		$info_factura.=$esp_init."FECHA RESOLUCION ".$fehca."\n";
		$info_factura.=$esp_init."TIQUETE # ".$num_fact."|";
		$info_factura.=$esp_init."FECHA: ".$fecha_fact." ".hora($hora)."\n";
		$info_factura.=$esp_init."VENDEDOR: ".$vendedor."\n";
		$info_factura.=$esp_init."CAJA : ".$caja. "  TURNO: ".$turno."\n";
		$info_factura.=$esp_init."CLIENTE: ".$nombre_ape."|";
		$info_factura.="DESCRIPCION  CANT.  P. UNIT    SUBTOT.\n|";
		//Obtener informacion de tabla Factura_detalle y producto o servicio
		$result_fact_det=datos_fact_det($id_factura);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;

		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =$row_fact_det['descripcion'];
			//descripcion presentacion
			$id_presentacion =$row_fact_det['id_presentacion'];
			$descpre =$row_fact_det['descpre'];
			$descpresenta =$row_fact_det['descripcion_pr'];
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$descuento =$row_fact_det['descuento'];
			$subt=$row_fact_det['subtotal'];
			//$subt = $subt - $descuento;
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv =$row_fact_det['tipo_prod_serv'];
			//presentacion producto
			if($id_presentacion!=-9999)
			{
				$sql_uus=_fetch_array(_query("SELECT pp.precio, pp.unidad, pp.descripcion, p.nombre  FROM presentacion_producto as pp, presentacion as p WHERE pp.id_presentacion=p.id_presentacion AND pp.id_pp=$id_presentacion"));
				$unidad_w=$sql_uus['unidad'];
				$desc_pr=$sql_uus['descripcion'];
				$prese_pr=$sql_uus['nombre'];
			}
			else
			{
				$unidad_w=1;
				$desc_pr="";
				$prese_pr="";
			}


			$desc_pr_fin = $prese_pr."($desc_pr)";
			$cantidad=$cantidad/$unidad_w;
			//linea a linea
			$descrip=texto_espacios($descripcion,22);
			$descpresenta1=texto_espacios($descpre,7);
			$descpre1=texto_espacios($descpre,30);



			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=sprintf("%.2f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.2f",$subt);
				$total_gravado=$subt_gravado+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.2f",$subt);
				$total_exento=$subt_exento+$total_exento;
			}
			$esp_init=len_num($cantidad,8);
			$esp_col2=len_num($precio_unit,6);
			$esp_col3=len_num($subtotal,7);
			$esp_col4=len_num($descuento,11);

			$descripcion = "$prese_pr ".$descripcion." $desc_pr";
			$array_nocon= dtl($descripcion,22);
			foreach ($array_nocon as $key => $value) {
				// code...
				switch ($key) {
					case '0':
						$info_factura.=str_pad($cantidad,4," ",STR_PAD_LEFT)."  ".st(quitar_spc($value),22," ","R").str_pad($precio_unit,5," ",STR_PAD_LEFT)."  ".str_pad($subtotal,5," ",STR_PAD_LEFT).$e_g."\n";
						break;
					default:
						$info_factura.=str_pad("",4," ",STR_PAD_LEFT)."  ".st(quitar_spc($value),22," ","R").str_pad("",5," ",STR_PAD_LEFT)."  ".str_pad("",5," ",STR_PAD_LEFT)." "."\n";
						break;
				}
			}
			#   7  RITZ GALLETAS ORIGINA. 7.77  54.39
			#   7  Unidad RITZ GALLETAS   7.77  54.39E
			#      ORIGINAL 12S 24 1x1t
			#$info_factura.=str_pad($cantidad,4," ",STR_PAD_LEFT)."  ".str_pad(quitar_spc($descrip),18).str_pad($precio_unit,5," ",STR_PAD_LEFT)."  ".str_pad($subtotal,5," ",STR_PAD_LEFT)."\n";
			#$info_factura.="      ".$desc_pr_fin."\n";
			//$info_factura.="PRESENT: ".$descpre1."\n";
			$cuantos=$cuantos+1;
		}
	}

	$total_final_format=sprintf("%.2f",$total_final);
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}
	$cadena_salida_txt= " ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	//$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.2f",$total_exento);
	$total_value_gravado=sprintf("%.2f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);
	$esp_totales=len_num($total_value,8);
	$esp_init2=espacios_izq(" ",25);
	$tt_fin = $total_value_fin - $descuent;
	//$esp_totales=espacios_izq(" ",$sp3);
	$esp_d1=len_num($total_value_gravado,3);
	$esp_d2=len_num($total_value_exento,3);
	$esp_d3=len_num($total_value_fin,3);
	$vals = 3;
	if(strlen($descuent)>3)
	{
		$vals = 2;
	}
	$esp_d4=len_num($descuent,$vals);
	$vals = 3;
	if(strlen($porcentaje)>3)
	{
		$vals = 2;
	}
	$esp_d6=len_num($porcentaje,$vals);
	$esp_d5=len_num($tt_fin,2);
	$info_factura.="|".st("SUMAS",15," ","R")."$ ".st(sprintf("%.2f",$total_value_gravado),10," ","L")."\n";
	$info_factura.=st("- IVA RETENIDO",15," ","R")."$ ".st(sprintf("%.2f",$row_fact['retencion']),10," ","L")."\n";
	$info_factura.=st("SUB TOTAL",15," ","R")."$ ".st(sprintf("%.2f",($total_value_gravado-$row_fact['retencion'])),10," ","L")."\n";
	$info_factura.=st("VENTA NO SUJETA",15," ","R")."$ ".st(sprintf("%.2f","0.00"),10," ","L")."\n";
	$info_factura.=st("VENTAS EXENTAS",15," ","R")."$ ".st(sprintf("%.2f",$total_value_exento),10," ","L")."\n";
	$info_factura.=st("VENTA TOTAL",15," ","R")."$ ".st(sprintf("%.2f",($total_value_fin-$row_fact['retencion'])),10," ","L")."\n";
	/*$info_factura.="DESCUENTO       ".$esp_totales."".$esp_d6.$porcentaje."%\n";
	$info_factura.="TOTAL DESCUENTO  ".$esp_totales."  $ ".$esp_d4.sprintf("%.2f",$descuent)."\n";
	$info_factura.="A PAGAR          ".$esp_totales."  $".str_pad(number_format($tt_fin,2,".",""),8," ",STR_PAD_LEFT)."\n";
	*/
	$info_factura.="|".$cadena_salida_txt."\n";
	$info_factura.="|"."VENDEDOR: ".$vendedor;
	//$esp=espacios_izq(" ",30);PRODUCTIS
	// retornar valor generado en funcion

	return ($info_factura);
}

function print_ticket_dev($id_factura)
{
	$id_sucursal=$_SESSION['id_sucursal'];
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
	$so_cliente='win';
	else
	$so_cliente='lin';
	//Empresa
	$datos_empresa=datos_empresa();
	$field= json_decode($datos_empresa, true);
	$nite=$field['nit'];
	$nrce=$field['nrc'];
	$empresa1=$field['empresa'];
	$razonsocial1=$field['razonsocial'];
	$giro1=$field['giro'];
	//Sucursal
	$nombre_sucursal1=datos_sucursal($id_sucursal);
	//inicio datos
	$info_factura="";
	$info_factura.=$empresa1."|".$nombre_sucursal1."|".$razonsocial1."|".$giro1."|".$nite."|".$nrce."|";
	//Obtener informacion de tabla Factura
	$result_fact=datos_factura($id_factura);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$id_usuario=$row_fact['id_usuario'];
		$id_vendedor=$row_fact['id_empleado'];
		$fecha=$row_fact['fecha'];
		$hora=$row_fact['hora'];
		$caja=$row_fact['caja'];
		$turno=$row_fact['turno'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];
		$descuent=$row_fact['descuento'];
		$porcentaje=$row_fact['porcentaje'];
		$sql_caja = _query("SELECT * FROM caja WHERE id_caja='$caja'");
		$dats_caja = _fetch_array($sql_caja);
		$fehca = ED($dats_caja["fecha"]);
		$resolucion = $dats_caja["resolucion"];
		$serie = $dats_caja["serie"];
		$desde = $dats_caja["desde"];
		$hasta = $dats_caja["hasta"];
		$len_numero_doc=strlen($numero_doc)-4;
		$num_fact=substr($numero_doc,0,$len_numero_doc);
		$tipo_fact=substr($numero_doc,$len_numero_doc,4);
		$numfact=espacios_izq($num_fact,10);
		//Datos de empleado usuario y vendedor
		$result_emp= datos_empleado($id_usuario,$id_vendedor);
		list($empleado,$vendedor)=explode('|',$result_emp);
		//Datos del Cliente
		$result=datos_clientes($id_cliente);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];
		$direccion=$row1['direccion'];

		//Columnas y posiciones base
		$sp2=espacios_izq(" ",12);
		$esp_init=espacios_izq(" ",1);
		$esp_precios=espacios_izq(" ",10);
		$esp_enc2=espacios_izq(" ",3);
		$esp_init2=espacios_izq(" ",23);
		$nombre_ape=texto_espacios($nombres,32);
		$dir_txt=texto_espacios($direccion,30);
		$total_final=0;
		//Datos del cliente
		/*$info_factura.=$esp_init.$empresa1."\n";
		$info_factura.=$esp_init.$razonsocial1."\n";
		$giros = explode(";", $giro1);
		for ($ni = 0; $ni < (count($giros)); $ni++)
		{
			$info_factura.=$esp_init.trim($giros[$ni])."\n";
		}*/
		/*$info_factura.=$esp_init."NIT :  ".$nite." NRC :".$nrce."\n";
		$info_factura.=$esp_init."RESOLUCION:  ".$resolucion."\n";
		$info_factura.=$esp_init."DEL ".$desde." AL ".$hasta."\n";
		$info_factura.=$esp_init."SERIE ".$serie."\n";
		$info_factura.=$esp_init."FECHA RESOLUCION ".$fehca."\n";*/
		$info_factura.=$esp_init."DEVOLUCION TIQUETE # ".$num_fact."|";
		$info_factura.=$esp_init."FECHA: ".$fecha_fact." ".hora($hora)."\n";
		$info_factura.=$esp_init."VENDEDOR: ".$vendedor."\n";
		$info_factura.=$esp_init."CAJA : ".$caja. "  TURNO: ".$turno."\n";
		$info_factura.=$esp_init."CLIENTE: ".$nombre_ape."|";
		$info_factura.="DESCRIPCION  CANT.  P. UNIT    SUBTOT.\n|";
		//Obtener informacion de tabla Factura_detalle y producto o servicio
		$result_fact_det=datos_fact_det($id_factura);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;

		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =$row_fact_det['descripcion'];
			//descripcion presentacion
			$id_presentacion =$row_fact_det['id_presentacion'];
			$descpre =$row_fact_det['descpre'];
			$descpresenta =$row_fact_det['descripcion_pr'];
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$descuento =$row_fact_det['descuento'];
			$subt=$row_fact_det['subtotal'];
			//$subt = $subt - $descuento;
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv =$row_fact_det['tipo_prod_serv'];
			//presentacion producto
			if($id_presentacion!=-9999)
			{
				$sql_uus=_fetch_array(_query("SELECT pp.precio, pp.unidad, pp.descripcion, p.nombre  FROM presentacion_producto as pp, presentacion as p WHERE pp.id_presentacion=p.id_presentacion AND pp.id_pp=$id_presentacion"));
				$unidad_w=$sql_uus['unidad'];
				$desc_pr=$sql_uus['descripcion'];
				$prese_pr=$sql_uus['nombre'];
			}
			else
			{
				$unidad_w=1;
				$desc_pr="";
				$prese_pr="";
			}

			$desc_pr_fin = $prese_pr."($desc_pr)";
			$cantidad=$cantidad/$unidad_w;
			//linea a linea
			$descrip=texto_espacios($descripcion,22);
			$descpresenta1=texto_espacios($descpre,7);
			$descpre1=texto_espacios($descpre,30);



			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=sprintf("%.2f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.2f",$subt);
				$total_gravado=$subt_gravado+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.2f",$subt);
				$total_exento=$subt_exento+$total_exento;
			}
			$esp_init=len_num($cantidad,8);
			$esp_col2=len_num($precio_unit,6);
			$esp_col3=len_num($subtotal,7);
			$esp_col4=len_num($descuento,11);
			$info_factura.=str_pad($cantidad,4," ",STR_PAD_LEFT)."  ".str_pad(quitar_spc($descrip),18).str_pad($precio_unit,5," ",STR_PAD_LEFT)."  ".str_pad($subtotal,5," ",STR_PAD_LEFT)."\n";
			$info_factura.="      ".$desc_pr_fin."\n";
			//$info_factura.="PRESENT: ".$descpre1."\n";
			$cuantos=$cuantos+1;
		}
	}
	$total_final_format=sprintf("%.2f",$total_final);
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}
	$cadena_salida_txt= " ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	//$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.2f",$total_exento);
	$total_value_gravado=sprintf("%.2f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);
	$esp_totales=len_num($total_value,8);
	$esp_init2=espacios_izq(" ",25);
	$tt_fin = $total_value_fin - $descuent;
	//$esp_totales=espacios_izq(" ",$sp3);
	$esp_d1=len_num($total_value_gravado,3);
	$esp_d2=len_num($total_value_exento,3);
	$esp_d3=len_num($total_value_fin,3);
	$vals = 3;
	if(strlen($descuent)>3)
	{
		$vals = 2;
	}
	$esp_d4=len_num($descuent,$vals);
	$vals = 3;
	if(strlen($porcentaje)>3)
	{
		$vals = 2;
	}
	$esp_d6=len_num($porcentaje,$vals);
	$esp_d5=len_num($tt_fin,2);
	$info_factura.="|TOTAL GRAVADO".$esp_totales."$ ".$esp_d1.$total_value_gravado."\n";
	$info_factura.="TOTAL EXENTO ".$esp_totales."$ ".$esp_d2.$total_value_exento."\n";
	$info_factura.="TOTAL        ".$esp_totales."$ ".$esp_d3.$total_value_fin."\n";
	/*$info_factura.="DESCUENTO       ".$esp_totales."".$esp_d6.$porcentaje."%\n";
	$info_factura.="TOTAL DESCUENTO  ".$esp_totales."  $ ".$esp_d4.sprintf("%.2f",$descuent)."\n";
	$info_factura.="A PAGAR          ".$esp_totales."  $".str_pad(number_format($tt_fin,2,".",""),8," ",STR_PAD_LEFT)."\n";
	*/
	$info_factura.="|".$cadena_salida_txt."\n";
	$info_factura.="|"."VENDEDOR: ".$vendedor;
	//$esp=espacios_izq(" ",30);PRODUCTIS
	// retornar valor generado en funcion

	return ($info_factura);
}

function print_fact($id_factura,$tipo_id,$nombreapecte,$direccion){
	$id_sucursal=$_SESSION['id_sucursal'];
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	$info_factura="";
	//Obtener informacion de tabla Factura
	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$nombrex = $row_fact['nombre'];
		$direccionx = $row_fact['direccion'];
		$id_usuario=$row_fact['id_usuario'];
		$fecha=$row_fact['fecha'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];


		$descuento=$row_fact['descuento'];
		$SumGravado=$row_fact['suma_gravado'];
		$venta_exenta=$row_fact['venta_exenta'];

		$total=$row_fact['total'];

		$credito=$row_fact['credito'];
		$cond_pago="";
		if ($credito==1) {
			// code...
			$cond_pago="CREDITO";
		}
		else {
			// code...
			$cond_pago="CONTADO";
		}

		$sql_user="select * from usuario where id_usuario='$id_usuario'";
		$result_user= _query($sql_user);
		$row_user=_fetch_array($result_user);
		$nrow_user=_num_rows($result_user);
		$usuario=$row_user['usuario'];
		$nombreusuario=$row_user['nombre'];

		//Datos del Cliente
		$sql="select * from cliente where id_cliente='$id_cliente'";
		$result= _query($sql);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=" ".$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];


		//Columnas y posiciones base
		$nodp="";
		if ($dui!="") {
			// code...
			$nodp=$dui;
		}
		if ($nit!="") {
			// code...
			$nodp=($nit);
		}

		$nombre_ape=$nombrex;//$nombreapecte;
		$total_final=0;

		/*margen derecho*/
		$marginl=st(" ",10);

		/*incializamos el arreglo con las lineas vacias*/
		$logitud_array=60;
		$arrayL= array();
		for ($i=0; $i < $logitud_array; $i++) {
			// code...
			$arrayL[$i]=st("",105)."\n";
		}

		//Datos encabezado factura
		list($diaa,$mess,$anio)=explode("-",$fecha_fact);


		$arrayL[9]=  p_set($arrayL[9],$diaa,64,74,"B");
		$arrayL[9]=  p_set($arrayL[9],$mess,75,88,"B");
		$arrayL[9]=  p_set($arrayL[9],$anio,89,99,"B");

		$arrayL[11]= p_set($arrayL[11],$nombre_ape,16,99,"R");

		$arrayL[13]= p_set($arrayL[13],$direccionx,18,99,"R");


		if($nodp=="0000-000000-000-0"){$nodp="";}
		$arrayL[15]= p_set($arrayL[15],$nodp,70,99,"R");



		/*$array_painc = array(
			0 => 20,
			1 => 22,
			2 => 24,
			3 => 26,
			4 => 29,
			5 => 31,
			6 => 33,
			7 => 35,
			8 => 37,
			9 => 39,
			10 => 41,
			11 => 43,
		);*/
		$array_painc = array(
			18,
			19,
			20,
			21,
			22,
			23,
			24,
			25,
			26,
			27,
			28,
			29,
			30,
			31,
			32,
			33,
			34,
			35,
			36,
			37,
			38,
			39,
			40,
			41,
			42,
			43,
			44,
			45
		);

		$sql_fact_det="SELECT
		producto.id_producto,
		producto.descripcion,
		producto.exento,
		presentacion.nombre as desprep,
		presentacion_producto.descripcion AS descpre,
		presentacion_producto.unidad,
		factura_detalle.*
		FROM factura_detalle
		JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
		JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
		JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
		WHERE factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv!=-9999
		union
		SELECT -9999 as id_producto,
		factura_detalle.description as descripcion,
		factura_detalle.exento,
		'' AS desprep,
		'' AS descpre,
		1 as unidad,
		factura_detalle.*
		FROM factura_detalle
		where factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv=-9999
		 ";
		$result_fact_det=_query($sql_fact_det);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;

		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =trim($row_fact_det['descripcion']);
			//descripcion presentacion
			$descpre =trim($row_fact_det['descpre']);
			$descpresenta =trim($row_fact_det['desprep']);
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad']/$row_fact_det['unidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$subt =$row_fact_det['subtotal'];
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv ='PRODUCTO';

			$xls = " ".$descpresenta." $descpre ";
			$descripcion1="$descpresenta ".$descripcion." $descpre";
			$descrip=trim($descripcion1);
			$subt=$precio_venta*$cantidad;
			$subt_sin_iva=$precio_venta*$cantidad;
			$subt_sin_iva_print=sprintf("%.4f",$subt_sin_iva);
			$precio_unit=sprintf("%.4f",$precio_venta);
			$subtotal=sprintf("%.4f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.4f",$subtotal);
				$total_gravado=$subtotal+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.4f",$subtotal);
				$total_exento=$subtotal+$total_exento;
			}


			//imprimir productos
			if ($i<28) {

				if ($exento==0){
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$cantidad,4,11,"B");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],quitar_spc($descrip),12,62,"R");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$precio_unit,63,72,"L");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$subtotal,84,99,"L");
				}
				else{
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$cantidad,4,11,"B");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],quitar_spc($descrip),12,62,"R");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$precio_unit,70,84,"L");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$subtotal,85,99,"L");
				}

			}
			$cuantos=$cuantos+1;
		}
	}

	$SumGravado = $total_gravado;
	$total_final_format=sprintf("%.2f", round(($SumGravado+$venta_exenta-$row_fact['retencion']),2) );
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}

	$cadena_salida_txt= "".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$sp3=10;
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.4f",$total_exento);
	$total_value_gravado=sprintf("%.4f",$total_gravado);
	$total_value_sumas=sprintf("%.4f",($total_gravado+$total_exento));
	$total_value_fin=sprintf("%.4f",$total_fin);

	$array_painc = array(
		0 => 47,
		1 => 48,
	);
	$array_nocon= dtl($cadena_salida_txt,43);

	foreach ($array_nocon as $key => $value) {
		// code...
		$arrayL[$array_painc[$key]]=p_set($arrayL[$array_painc[$key]],$value,11,55,"R");
	}

	$arrayL[47]= p_set($arrayL[47],sprintf("%.4f",$SumGravado),85,99,"L");
	$arrayL[49]= p_set($arrayL[49],sprintf("%.4f",$row_fact['retencion']),85,99,"L");
	$arrayL[51]= p_set($arrayL[51],sprintf("%.4f",round(($SumGravado-$row_fact['retencion']),4)),85,99,"L");
	$arrayL[53]= p_set($arrayL[53],sprintf("%.4f","0.0000"),85,99,"L");
	$arrayL[55]= p_set($arrayL[55],sprintf("%.4f",$venta_exenta),85,99,"L");
	$arrayL[57]= p_set($arrayL[57],sprintf("%.2f",round(($SumGravado+$venta_exenta-$row_fact['retencion']),2)),85,99,"L");

	foreach ($arrayL as $key => $value) {
		$info_factura.=$value;
	}
	// retornar valor generado en funcion
	return ($info_factura);
}
function print_envio($id_factura,$tipo_id,$nombreapecte,$direccion){
	$id_sucursal=$_SESSION['id_sucursal'];
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	//Empresa
	$sql_empresa = "SELECT * FROM empresa";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['nombre'];
	$razonsocial=$row_empresa['razonsocial'];
	$giro=$row_empresa['giro'];
	//Sucursal
	$empresa1=texto_espacios($empresa,30);
	$razonsocial1=texto_espacios($razonsocial,30);
	$giro1=texto_espacios($giro,30);
	//inicio datos
	$info_factura="";
	//Obtener informacion de tabla Factura
	//fecha  arriba 1 linea, direccion 3 esp der , descripcion 2 esp der , qitar prec unit
	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$id_usuario=$row_fact['id_usuario'];
		$fecha=$row_fact['fecha'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];

		$len_numero_doc=strlen($numero_doc)-4;
		$num_fact=substr($numero_doc,0,$len_numero_doc);
		$tipo_fact=substr($numero_doc,$len_numero_doc,4);
		$numfact=espacios_izq($num_fact,10);
		//Datos de empleado
		$sql_user="select * from usuario where id_usuario='$id_usuario'";
		$result_user= _query($sql_user);
		$row_user=_fetch_array($result_user);
		$nrow_user=_num_rows($result_user);
		$usuario=$row_user['usuario'];
		$nombreusuario=$row_user['nombre'];
		//$nombres=$row_user['apellido']." ".$row_user['nombre'];
		//Datos del Cliente
		$sql="select * from cliente where id_cliente='$id_cliente'";
		$result= _query($sql);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=$row1['apellido']." ".$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];
		//$direccion=$row1['direccion'];

		//Columnas y posiciones base

		$esp_init=espacios_izq(" ",12);
		$esp_init2=espacios_izq(" ",76);
		$nombre_ape=texto_espacios($nombres,32);
		$dir_txt=texto_espacios($direccion,30);
		$total_final=0;
		for($h=0;$h<3;$h++){
			$info_factura.="\n";
		}
		$nombre_ape=texto_espacios($nombreapecte,40);

		//Datos encabezado factura
		list($diaa,$mess,$anio)=explode("-",$fecha_fact);
		$esp_init2=espacios_izq(" ",60);
		$info_factura.=$esp_init2.$diaa."   ".$mess."   ".$anio."|";
		//$info_factura.="\n";
		//Datos del cliente
		$info_factura.=$esp_init."   ".$nombre_ape."|";
			$info_factura.="\n";
		$info_factura.=$esp_init."   ".$direccion."|";
		$info_factura.=$esp_init2.$dui."|";
		$info_factura.=$esp_init2.$nit."|";

		$sql_fact_det="SELECT  producto.id_producto, producto.descripcion, producto.exento,
		presentacion.descripcion_pr,
		 presentacion_producto.descripcion AS descpre,
		 factura_detalle.*
		 FROM factura_detalle
		 JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
		 JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
		 JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
		 WHERE  factura_detalle.id_factura='$id_factura'
		 ";
		$result_fact_det=_query($sql_fact_det);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;
		//$info_factura.="\n";
		for ($i = 0; $i<3; $i++) {
		  $info_factura.= chr(10); //Line Feed
		}
		$info_factura.= chr(27).chr(51)."2"; //espacio entre lineas 6 x pulgada

		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =trim($row_fact_det['descripcion']);
			//descripcion presentacion
			$descpre =trim($row_fact_det['descpre']);
			$descpresenta =trim($row_fact_det['descripcion_pr']);
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$subt =$row_fact_det['subtotal'];
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv ='PRODUCTO';
      //agregar query para presentaciones y agregarlo a descripcion
			//linea por linea de productos
			//$descrip=texto_espacios($descripcion,60);
			$descripcion1=substr($descpresenta,0,8).", ".substr($descripcion,0,30)." ".substr($descpre,0,15);
			$descrip=texto_espacios($descripcion1,50);
			$subt=$precio_venta*$cantidad;
			$subt_sin_iva=$precio_venta*$cantidad;
			$subt_sin_iva_print=sprintf("%.2f",$subt_sin_iva);
			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=sprintf("%.2f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.2f",$subtotal);
				$total_gravado=$subtotal+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.2f",$subtotal);
				$total_exento=$subtotal+$total_exento;
			}

      $col2=2;
			$esp1=len_espacios($cantidad,6);
			$esp_col1=espacios_izq(" ",$esp1);
			$esp2=len_espacios($precio_venta,8);
			$esp_col2=espacios_izq(" ",$esp2);
			$esp3=len_espacios($subtotal,8);
			$esp_col3=espacios_izq(" ",$esp3);
			$esp_desc=espacios_izq(" ",2);
			$sp1=espacios_izq(" ",1);
			$sp2=espacios_izq(" ",5);
      		$sp3=espacios_izq(" ",3);
			$sp4=espacios_izq(" ",2);
			$sp5=espacios_izq(" ",5);
			$info_factura.=$sp1.$esp_col1.$cantidad.$sp2.$descrip.$sp1.$esp_col3.$subtotal."\n";

			$cuantos=$cuantos+1;
		}
	}
	$total_final_format=sprintf("%.2f",$total_final);
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}

	$cadena_salida_txt= "    ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$sp3=10;
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.2f",$total_exento);
	$total_value_gravado=sprintf("%.2f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);

	//totales
	$lineas_faltantes=19-$cuantos;
	$imprimir="";
	for($j=0;$j<$lineas_faltantes;$j++){
		$info_factura.="\n";
	}
  $info_factura.= chr(27).chr(50); //espacio entre lineas 6 x pulgada

	$esp_init2=espacios_izq(" ",25);
	$esp_totales=espacios_izq(" ",40);
	//generar 2 lineas del texto del total de la factura
	$total_txt0 =cadenaenlineas($cadena_salida_txt, 50,2);
	$concepto_print="";
	$tmplinea = array();
	$ln=0;
	$esp_init=espacios_izq(" ",2);

	foreach($total_txt0 as $total_txt1){
		$tmplinea[]=$total_txt1;
		$ln=$ln+1;
	}
	$esp_totales=espacios_izq(" ",50);
  $splentot1=len_espacios($total_value_exento,8);
	$esp_lentot1=espacios_izq(" ",$splentot1);


  //imprimir totales

	$linea0=strlen(trim($tmplinea[0]));
	$len_desc=40-$linea0;
	//$esp_totales=espacios_izq(" ",$len_desc);
	$esp_desc=espacios_izq(" ",$len_desc);
	$esp_init=espacios_izq(" ",12);
	$espacios=espacios_izq(" ",10);
	$info_factura.="\n";
	$info_factura.="\n";
	$splentot2=len_espacios($total_final_format,10);
	$esp_lentot2=espacios_izq(" ",$splentot2);
	$info_factura.=$esp_init.$tmplinea[0].$esp_desc.$espacios.$esp_lentot2.$total_final_format."\n";
	if($ln>1){
				$esp_init=espacios_izq(" ",6);
						$len_desc=76-strlen(trim($tmplinea[1]));
						$esp_totales=espacios_izq(" ",$len_desc);
						$info_factura.=$esp_init.$tmplinea[1]." \n";
						for($x=0;$x<2;$x++){
						 $info_factura.="\n";
					 }
				 }
				 $info_factura.="\n";
				 $esp_totales_g=espacios_izq(" ",83);
				 $esp_totales=espacios_izq(" ",83);
				 for($x=0;$x<1;$x++){
	 			 $info_factura.="\n";
 		 }
	// retornar valor generado en funcion
		return ($info_factura);

}
function print_fact_dia($id_fact,$tipo_id){
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_factura=$id_fact;
	$tipo_id=$tipo_id;
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	//Empresa
	$sql_empresa = "SELECT * FROM empresa";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['nombre'];
	$razonsocial=$row_empresa['razonsocial'];
	$giro=$row_empresa['giro'];
	//Sucursal
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal=$array_sucursal['descripcion'];
	$nombre_sucursal1=texto_espacios($nombre_sucursal,30);
	$empresa1=texto_espacios($empresa,30);
	$razonsocial1=texto_espacios($razonsocial,30);
	$giro1=texto_espacios($giro,30);
	//inicio datos
	$info_factura="";
	$info_factura.=$empresa1."|".$nombre_sucursal1."|".$razonsocial1."|".$giro1."|";

	$sql_fact="SELECT * FROM factura_dia WHERE id_factura_dia='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura_dia'];
		$fecha=$row_fact['fecha'];
		$fecha_fact=ed($fecha);
		$total=$row_fact['total'];
		$num_fact=$id_factura;
		$numfact=espacios_izq($num_fact,10);

		//Datos del Cliente
		$sql="select * from cliente where id_cliente='$id_cliente'";
		$result= _query($sql);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=$row1['apellido']." ".$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];
		$direccion=$row1['direccion'];

		//Columnas y posiciones base
		$base1=7;
		$col0=1;
		$col1=4;
		$col2=3;
		$col3=13;
		$col4=5;
		$sp1=2;
		$sp_prec=15;
		$sp=espacios_izq(" ",$sp1);
		$sp2=espacios_izq(" ",12);
		$esp_init=espacios_izq(" ",12);
		$esp_precios=espacios_izq(" ",$sp_prec);
		$esp_enc2=espacios_izq(" ",3);
		$esp_init2=espacios_izq(" ",70);
		$nombre_ape=texto_espacios($nombres,32);
		$dir_txt=texto_espacios($direccion,30);
		$total_final=0;
		$imprimir="";
		for($h=0;$h<8;$h++){
			$imprimir.="\n";
		}
		$info_factura.=$imprimir;
		//Datos encabezado factura
		list($diaa,$mess,$anio)=explode("-",$fecha_fact);
		$info_factura.=$esp_init2.$diaa."       ".$mess."           ".$anio."|";
		$info_factura.=$esp_init."FACTURA CONSUMIDOR DIARIA# ".$num_fact."|";
		//Datos del cliente
		$info_factura.=$esp_init."   ".$nombre_ape."|";
		$info_factura.=$esp_init.$direccion."|";
		$info_factura.=$esp_init.$dui."|";
		$info_factura.=$esp_init.$nit."|";
		//Obtener informacion de tabla Factura_detalle y producto o servicio
		$sql_fact_det="SELECT  producto.id_producto, producto.descripcion, producto.exento,factura_detalle_dia.*
		FROM factura_detalle_dia JOIN producto ON factura_detalle_dia.id_producto=producto.id_producto
		WHERE  factura_detalle_dia.id_factura_dia='$id_factura'
		";

		$result_fact_det=_query($sql_fact_det);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;

		$info_factura.="\n";
		//$info_factura.="\n";
		$info_factura.= chr(27).chr(51)."2"; //espacio entre lineas 6 x pulgada
		//$info_factura.="\n";
		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =$row_fact_det['descripcion'];
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factdet_dia'];
			$id_prod_serv =$row_fact_det['id_producto'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$subt =$row_fact_det['subtotal'];

			//linea por linea de productos
			$descrip=texto_espacios($descripcion,42);
			$subt=$precio_venta*$cantidad;
			$subt_sin_iva=$precio_venta*$cantidad;
			$subt_sin_iva_print=sprintf("%.2f",$subt_sin_iva);
			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=sprintf("%.2f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.2f",$subtotal);
				$total_gravado=$subtotal+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.2f",$subtotal);
				$total_exento=$subtotal+$total_exento;
			}

      $col2=2;
			$sp1=len_espacios($cantidad,7);
			$esp_col1=espacios_izq(" ",$sp1);
			$sp2=len_espacios($precio_sin_iva_print,8);
			$esp_col2=espacios_izq(" ",$sp2+4);
			$sp3=len_espacios($subt_sin_iva_print,10);
			$esp_col3=espacios_izq(" ",$sp3+1);
			$esp_desc=espacios_izq(" ",6);
  		if ($exento==1){
				$info_factura.=$esp_col1.$cantidad.$esp_desc.$descrip.$esp_col2."".$precio_unit.$esp_col3.$subtotal."\n";
  			}
  			if ($exento==0){
					$sp3=$sp3+11;
					$esp_col3=espacios_izq(" ",$sp3);
  				$info_factura.=$esp_col1.$cantidad.$esp_desc.$descrip.$esp_col2.$precio_unit.$esp_col3.$subtotal."\n";
				}
			$cuantos=$cuantos+1;
		}
	}
	$total_final_format=sprintf("%.2f",$total_final);
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}

	$cadena_salida_txt= " ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$sp3=10;
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.2f",$total_exento);
	$total_value_gravado=sprintf("%.2f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);

	//totales
	$lineas_faltantes=12-$cuantos;
	$imprimir="";
	for($j=0;$j<$lineas_faltantes;$j++){
		$info_factura.="\n";
	}
  $info_factura.= chr(27).chr(50); //espacio entre lineas 6 x pulgada

	$esp_init2=espacios_izq(" ",25);
	$esp_totales=espacios_izq(" ",40);
	//generar 2 lineas del texto del total de la factura
	$total_txt0 =cadenaenlineas($cadena_salida_txt, 40,2);
	$concepto_print="";
	$tmplinea = array();
	$ln=0;
	$esp_init=espacios_izq(" ",2);

	foreach($total_txt0 as $total_txt1){
		$tmplinea[]=$total_txt1;
		$ln=$ln+1;
	}
	$esp_totales=espacios_izq(" ",56);
  $splentot1=len_espacios($total_value_exento,8);
	$esp_lentot1=espacios_izq(" ",$splentot1);
	$splentot2=len_espacios($total_value_gravado,12);
	$esp_lentot2=espacios_izq(" ",$splentot2);

  //imprimir totales

	$linea0=strlen(trim($tmplinea[0]));
	$len_desc=72-$linea0;
	$esp_totales=espacios_izq(" ",$len_desc);
	$esp_init=espacios_izq(" ",10);
	$info_factura.="\n";
	$info_factura.="\n";
	$info_factura.=$esp_init.$tmplinea[0].$esp_totales."  ".$esp_lentot2.$total_value_gravado."\n";
	if($ln>1){
				$esp_init=espacios_izq(" ",6);
						$len_desc=76-strlen(trim($tmplinea[1]));
						$esp_totales=espacios_izq(" ",$len_desc);
						$info_factura.=$esp_init.$tmplinea[1].$esp_totales.$esp_lentot2." "."\n";
						for($x=0;$x<2;$x++){
						 $info_factura.="\n";
					 }
	}
	else{
	for($x=0;$x<3;$x++){
	 $info_factura.="\n";
 }
 }
	$esp_totales_g=espacios_izq(" ",83);

  $info_factura.=$esp_totales_g."  ".$esp_lentot2.$total_value_gravado."\n";

	$esp_totales=espacios_izq(" ",83);
	for($x=0;$x<2;$x++){
	 $info_factura.="\n";
 }
	$info_factura.=$esp_totales.$esp_lentot2.$total_final_format."\n";
	// retornar valor generado en funcion
	return ($info_factura);

}
function print_ccf($id_fact,$tipo_id,$nitcte,$nrccte,$nombreapecte,$direccion){
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_factura=$id_fact;
	$tipo_id=$tipo_id;
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	//Empresa
	$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['descripcion'];
	$razonsocial=$row_empresa['razon_social'];
	$giro_empresa=$row_empresa['giro'];
	$iva=$row_empresa['iva']/100;
	//Sucursal
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal=$array_sucursal['descripcion'];
	$nombre_sucursal1=texto_espacios($nombre_sucursal,30);
	$empresa1=texto_espacios($empresa,30);
	$razonsocial1=texto_espacios($razonsocial,30);
	$giro1=texto_espacios($giro_empresa,30);
	//inicio datos
	$info_factura="";

	/*incializamos el arreglo con las lineas vacias*/
	$logitud_array=58;
	$arrayL= array();
	for ($i=0; $i < $logitud_array; $i++) {
		// code...
		$arrayL[$i]=st("",100)."\n";
	}

	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$id_usuario=$row_fact['id_usuario'];
		$fecha=$row_fact['fecha'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];
		$retencion = $row_fact['retencion'];
		$nrccte = $row_fact['num_fact_impresa_e'];
		$nitcte = $row_fact['numero_doc_e'];
		$nombreapecte = $row_fact['nombre'];
		$direccion =$row_fact['direccion'];
		//Datos de empleado
		$sql_user="select * from usuario where id_usuario='$id_usuario'";
		$result_user= _query($sql_user);
		$row_user=_fetch_array($result_user);
		$nrow_user=_num_rows($result_user);
		$usuario=$row_user['usuario'];
		$nombreusuario=$row_user['nombre'];


		//$nombres=$row_user['apellido']." ".$row_user['nombre'];
		//Datos del Cliente

		$depart="";
		$sql="select cliente.*, departamento.nombre_departamento from cliente  LEFT JOIN departamento ON departamento.id_departamento=cliente.depto where id_cliente='$id_cliente'";
		$result=_query($sql);
		$count=_num_rows($result);
		if ($count > 0) {
				for ($i = 0; $i < $count; $i ++) {
						$row1 = _fetch_array($result);
						//$id_cliente=$row1["id_cliente"];
						$nombre=$row1["nombre"];
						$nit=$row1["nit"];
						$dui=$row1["dui"];
						$telefono1=$row1["telefono1"];
						$giro_cte=$row1['giro'];
						$nombres=$row1['nombre'];
						$depart=$row1['nombre_departamento'];
				}
		}

		$nombre_ape=$nombres;
		$dir_txt=$direccion;
		$giro_cte1=$giro_cte;
		$total_final=0;

		$nombreapecte=trim($nombreapecte);

		/*72 caracteres*/
		list($diaa,$mess,$anio)=explode("-",$fecha_fact);


		$arrayL[7]=  p_set($arrayL[7],$diaa,64,75,"B");
		$arrayL[7]=  p_set($arrayL[7],$mess,76,89,"B");
		$arrayL[7]=  p_set($arrayL[7],$anio,90,99,"B");


		$arrayL[10]=  p_set($arrayL[10],$nombreapecte,16,99,"R");

		$arrayL[12]=  p_set($arrayL[12],$dir_txt,18,61,"R");
		$arrayL[12]=  p_set($arrayL[12],$nrccte,74,99,"L");

		$arrayL[13]=  p_set($arrayL[13],$depart,15,61,"R");

		$arrayL[13]=  p_set($arrayL[13],substr($giro_cte1,0,28),70,99,"R");
		$arrayL[14]=  p_set($arrayL[14],substr($giro_cte1,28),70,99,"R");


		$arrayL[15]=  p_set($arrayL[15],$nitcte,18,61,"R");
		$arrayL[15]=  p_set($arrayL[15],get_tipo($row_fact['credito']),88,99,"R");


		$sql_fact_det="SELECT
		producto.id_producto,
		producto.descripcion,
		producto.exento,
		presentacion.nombre as desprep,
		presentacion_producto.descripcion AS descpre,
		presentacion_producto.unidad,
		factura_detalle.*
		FROM factura_detalle
		JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
		JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
		JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
		WHERE factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv!=-9999
		union
		SELECT -9999 as id_producto,
		factura_detalle.description as descripcion,
		factura_detalle.exento,
		'' AS desprep,
		'' AS descpre,
		1 as unidad,
		factura_detalle.*
		FROM factura_detalle
		where factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv=-9999
		 ";
		$result_fact_det=_query($sql_fact_det);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;

		$array_painc = array(
			22,
			23,
			24,
			25,
			26,
			27,
			28,
			29,
			30,
			31,
			32,
			33,
			34,
			35,
			36,
			37,
			38,
			39,
			40,
			41,
		);


		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$unidad=$row_fact_det['unidad'];
			$descripcion =trim($row_fact_det['descripcion']);
			//descripcion presentacion
			$descpre =trim($row_fact_det['descpre']);
			$descpresenta =trim($row_fact_det['descp']);
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$subt =$row_fact_det['subtotal'];
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv =$row_fact_det['tipo_prod_serv'];
			$cantidad=$cantidad/$unidad;
			//linea a linea
			$xls = " ".$descpresenta." $descpre ";
			$descripcion1="$descpresenta ".$descripcion." $descpre";
			$descrip=$descripcion1;

			$subt=$precio_venta*$cantidad;




			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=round($subt,4);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$precio_sin_iva0 =$row_fact_det['precio_venta']/(1+($iva));
				$precio_sin_iva =round($row_fact_det['precio_venta']/(1+($iva)),4);
				$subt_sin_iva=round($precio_sin_iva0*$cantidad,4);
				$subt_gravado=round($subt_sin_iva,4);
				$total_gravado=$subt_sin_iva+$total_gravado;
			}
			else{
				$e_g="E";
				$precio_sin_iva =round($row_fact_det['precio_venta'],4);
				$precio_sin_iva0 =$row_fact_det['precio_venta'];
				$subt_sin_iva=$precio_sin_iva0*$cantidad;
				$subt_exento=sprintf("%.2f",$subt_sin_iva);
				$total_exento=$subt_sin_iva+$total_exento;

			}
			$precio_sin_iva_print=round($precio_sin_iva,4);

			$subt_sin_iva_print=round($subt_sin_iva,4);
			$col2=2;

			$espacios1=espacios_izq(" ",1);
			$espacios2=espacios_izq(" ",2);
			$espacios3=espacios_izq(" ",3);
			$espacios4=espacios_izq(" ",4);
			$espacios5=espacios_izq(" ",5);
			$sp1=len_espacios($cantidad,4);
			$esp_col1=espacios_izq(" ",$sp1);
			$esp_col2=espacios_izq(" ",2);
			$sp3=len_espacios($precio_sin_iva_print,7);
				$esp_col3=espacios_izq(" ",$sp3);
			$sp4=len_espacios($subt_sin_iva_print,10);
			$esp_col4=espacios_izq(" ",$sp4);
			$esp_desc=espacios_izq(" ",3);
			//imprimir productos
			if ($i<20) {
				// code...
				if ($exento==0){
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$cantidad,5,12,"B");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],quitar_spc($descrip),14,62,"R");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$precio_sin_iva,63,74,"L");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],number_format(($subtotal/1.13),4,".",""),87,99,"L");
				}
				if ($exento==1){
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$cantidad,5,12,"B");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],quitar_spc($descrip),14,62,"R");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$precio_unit,65,85,"L");
					$arrayL[$array_painc[$i]]=p_set($arrayL[$array_painc[$i]],$subtotal,87,99,"L");
					}
			}
			$cuantos=$cuantos+1;
		}
	}
	$calc_iva=round($iva*$total_gravado,4);
	$total_iva_format=sprintf("%.4f",$calc_iva);
	$total_final_format=sprintf("%.4f",$total_final-$retencion);
	list($entero,$decimal)=explode('.',sprintf("%.2f",$total_final_format));
	$enteros_txt=num2letras($entero);
	if($entero=='100' && $decimal=='00'){
		$enteros_txt="CIEN";
	}
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}

	$cadena_salida_txt= " ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.4f",$total);
	$sp3=10;
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.4f",$total_exento);
	$total_value_gravado=sprintf("%.4f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);

	$esp_init=espacios_izq(" ",5);
	$subtotal_gravado=round($total_gravado+$calc_iva,4);
	$subtotal_exento=$total_exento;
	$total_final_todos=round($subtotal_exento+$subtotal_gravado,4);


	$subtotal_gravado_print=sprintf("%.4f",$subtotal_gravado);

	$total_final_todoss=sprintf("%.4f",$total_final_todos-$retencion);


	$info_factura="";

	$array_painc = array(
		0 => 44,
		1 => 45,
		2 => 46,
	);
	$array_nocon= dtl($cadena_salida_txt,39);
	foreach ($array_nocon as $key => $value) {
		// code...

		$arrayL[$array_painc[$key]]=p_set($arrayL[$array_painc[$key]],$value,14,54,"B");
	}
	$arrayL[43] = p_set($arrayL[43],$total_value_gravado,87,99,"L");
	$arrayL[45] = p_set($arrayL[45],"0.0000",87,99,"L");
	$arrayL[47] = p_set($arrayL[47],$total_iva_format,87,99,"L");
	$arrayL[49] = p_set($arrayL[49],$subtotal_gravado_print,87,99,"L");
	$arrayL[51] = p_set($arrayL[51],$retencion,87,99,"L");
	$arrayL[53] = p_set($arrayL[53],$total_value_exento,87,99,"L");
	$arrayL[55] = p_set($arrayL[55],sprintf("%.2f",$total_final_format),87,99,"L");


	foreach ($arrayL as $key => $value) {
		$info_factura.=$value;
	}
	return ($info_factura);
}
function print_ncr($id_factura,$tipo_id,$nombreapecte,$direccion){
	$id_sucursal=$_SESSION['id_sucursal'];
	//Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
	$info = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($info, 'Windows') == TRUE)
		$so_cliente='win';
	else
		$so_cliente='lin';
	$info_factura="";
	//Obtener informacion de tabla Factura
	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	$row_fact=_fetch_array($result_fact);
	$nrows_fact=_num_rows($result_fact);
	if($nrows_fact>0){
		$id_cliente=$row_fact['id_cliente'];
		$id_factura = $row_fact['id_factura'];
		$id_usuario=$row_fact['id_usuario'];
		$fecha=$row_fact['fecha'];
		$fecha_fact=ed($fecha);
		$numero_doc=trim($row_fact['numero_doc']);
		$total=$row_fact['total'];

		$len_numero_doc=strlen($numero_doc)-4;
		$num_fact=substr($numero_doc,0,$len_numero_doc);
		$tipo_fact=substr($numero_doc,$len_numero_doc,4);
		$numfact=espacios_izq($num_fact,10);
		//Datos de empleado
		$sql_user="select * from usuario where id_usuario='$id_usuario'";
		$result_user= _query($sql_user);
		$row_user=_fetch_array($result_user);
		$nrow_user=_num_rows($result_user);
		$usuario=$row_user['usuario'];
		$nombreusuario=$row_user['nombre'];

		//Datos del Cliente
		$sql="select * from cliente where id_cliente='$id_cliente'";
		$result= _query($sql);
		$row1=_fetch_array($result);
		$nrow1=_num_rows($result);
		$nombres=$row1['nombre'];
		$dui=$row1['dui'];
		$nit=$row1['nit'];
		$nrc=$row1['nrc'];
		//$direccion=$row1['direccion'];

		//Columnas y posiciones base
		$esp_init=espacios_izq(" ",13);
		$esp_init2=espacios_izq(" ",65);
		$nombre_ape=texto_espacios($nombreapecte,32);
		$dir_txt=texto_espacios($direccion,30);
		$total_final=0;
		$imprimir="";
		for($h=0;$h<8;$h++){
			$info_factura.="\n";
		}
		//Datos encabezado factura
		list($diaa,$mess,$anio)=explode("-",$fecha_fact);
		$info_factura.=$esp_init2.$diaa."   ".$mess."   ".$anio."|";

		//Datos del cliente
		$info_factura.=$esp_init."".$nombre_ape."|";
		$info_factura.="\n";
		$info_factura.=$esp_init.$direccion."|";
		for($k=0;$k<2;$k++){
			$info_factura.="\n";
		}
		$info_factura.=$esp_init2.$nrc."|";
		//Obtener informacion de tabla Factura_detalle y producto o servicio

		$sql_fact_det="SELECT  producto.id_producto, producto.descripcion, producto.exento,
		presentacion.descripcion as descripcion_pr,
		 presentacion_producto.descripcion AS descpre,
		 factura_detalle.*
		 FROM factura_detalle
		 JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
		 JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
		 JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
		 WHERE  factura_detalle.id_factura='$id_factura'
		 ";
		$result_fact_det=_query($sql_fact_det);
		$nrows_fact_det=_num_rows($result_fact_det);
		$total_final=0;
		$lineas=6;
		$cuantos=0;
		$subt_exento=0;
		$subt_gravado=0;
		$total_exento=0;
		$total_gravado=0;
		for($k=0;$k<3;$k++){
			$info_factura.=chr(10);
		}

		//$info_factura.="\n";
		$info_factura.= chr(27).chr(51)."1"; //espacio entre lineas 6 x pulgada
		for($i=0;$i<$nrows_fact_det;$i++){
			$row_fact_det=_fetch_array($result_fact_det);
			$id_producto =$row_fact_det['id_producto'];
			$descripcion =trim($row_fact_det['descripcion']);
			//descripcion presentacion
			$descpre =trim($row_fact_det['descpre']);
			$descpresenta =trim($row_fact_det['descripcion_pr']);
			$exento=$row_fact_det['exento'];
			$id_factura_detalle =$row_fact_det['id_factura_detalle'];
			$id_prod_serv =$row_fact_det['id_prod_serv'];
			$cantidad =$row_fact_det['cantidad'];
			$precio_venta =$row_fact_det['precio_venta'];
			$subt =$row_fact_det['subtotal'];
			$id_empleado =$row_fact_det['id_empleado'];
			$tipo_prod_serv ='PRODUCTO';

			//linea por linea de productos
			$descripcion1=substr($descpresenta,0,7).", ".substr($descripcion,0,22)." ".substr($descpre,0,10);
			$descrip=texto_espacios($descripcion1,42);
			$subt=$precio_venta*$cantidad;
			$subt_sin_iva=$precio_venta*$cantidad;
			$subt_sin_iva_print=sprintf("%.2f",$subt_sin_iva);
			$precio_unit=sprintf("%.2f",$precio_venta);
			$subtotal=sprintf("%.2f",$subt);
			$total_final=$total_final+$subtotal;
			if ($exento==0){
				$e_g="G";
				$subt_gravado=sprintf("%.2f",$subtotal);
				$total_gravado=$subtotal+$total_gravado;
			}
			else{
				$e_g="E";
				$subt_exento=sprintf("%.2f",$subtotal);
				$total_exento=$subtotal+$total_exento;
			}
			//$precio_sin_iva_print=sprintf("%.2f",$precio_sin_iva);
      $col2=2;
			$espacios1=espacios_izq(" ",1);
			$espacios2=espacios_izq(" ",2);
			$espacios3=espacios_izq(" ",3);
			$espacios4=espacios_izq(" ",4);
			$espacios5=espacios_izq(" ",5);
			$sp1=len_espacios($cantidad,5);
			$esp_col1=espacios_izq(" ",$sp1);
			$esp_col2=espacios_izq(" ",2);
			$sp3=len_espacios($precio_unit,7);
			$esp_col3=espacios_izq(" ",$sp3);
			$sp4=len_espacios($subtotal,10);
			$esp_col4=espacios_izq(" ",$sp4);
			$esp_desc=espacios_izq(" ",6);
			//imprimir productos
  		if ($exento==1){
				$info_factura.=$esp_col1.$cantidad.$esp_desc.$descrip.$esp_col2."".$precio_unit.$esp_col3.$subtotal."\n";
  			}
  		if ($exento==0){
				//	$sp3=$sp3+11;
				//	$esp_col3=espacios_izq(" ",$sp3);
					$info_factura.=$espacios2.$esp_col1.$cantidad.$espacios3.$descrip.$espacios1.$esp_col3.$precio_unit.$espacios5.$esp_col4.$subtotal."\n";
  			//	$info_factura.=$esp_col1.$cantidad.$esp_desc.$descrip.$esp_col2.$precio_unit.$esp_col3.$subtotal."\n";
				}
			$cuantos=$cuantos+1;
		}
	}
	$total_final_format=sprintf("%.2f",$total_final);
	list($entero,$decimal)=explode('.',$total_final_format);
	$enteros_txt=num2letras($entero);
	if(strlen($decimal)==1){
		$decimales_txt=$decimal."0";
	}
	else{
		$decimales_txt=$decimal;
	}

	$cadena_salida_txt= " ".$enteros_txt." dolares con ".$decimales_txt."/100 ctvs";
	$esp=espacios_izq(" ",7);
	$total_value=sprintf("%.2f",$total);
	$sp3=10;
	$total_fin=$total_exento+$total_gravado;
	$total_value_exento=sprintf("%.2f",$total_exento);
	$total_value_gravado=sprintf("%.2f",$total_gravado);
	$total_value_fin=sprintf("%.2f",$total_fin);

	//totales
	$lineas_faltantes=15-$cuantos;
	$imprimir="";
	for($j=0;$j<$lineas_faltantes;$j++){
		$info_factura.="\n";
	}
  $info_factura.= chr(27).chr(50); //espacio entre lineas 6 x pulgada
 //$info_factura.="\n";
	$esp_init2=espacios_izq(" ",25);
	$esp_totales=espacios_izq(" ",40);
	//generar 2 lineas del texto del total de la factura
	$total_txt0 =cadenaenlineas($cadena_salida_txt, 50,2);
	$concepto_print="";
	$tmplinea = array();
	$ln=0;
	$esp_init=espacios_izq(" ",2);

	foreach($total_txt0 as $total_txt1){
		$tmplinea[]=$total_txt1;
		$ln=$ln+1;
	}
	$esp_totales=espacios_izq(" ",56);
  $splentot1=len_espacios($total_value_exento,8);
	$esp_lentot1=espacios_izq(" ",$splentot1);
	$splentot2=len_espacios($total_value_gravado,8);
	$esp_lentot2=espacios_izq(" ",$splentot2);
	$len_desc=50-strlen(trim($tmplinea[0]));
	$esp_desc=espacios_izq(" ",$len_desc);
  $esp_init=espacios_izq(" ",5);
	$espacios=espacios_izq(" ",16);

  //imprimir totales
	$esp_totales=espacios_izq(" ",71);
  $info_factura.=$esp_init.$tmplinea[0].$esp_desc.$espacios.$esp_lentot2.$total_value_gravado."\n";
	$esp_init=espacios_izq(" ",7);

	if($ln>1){
				$esp_init=espacios_izq(" ",6);
						$len_desc=68-strlen(trim($tmplinea[1]));
						$esp_totales=espacios_izq(" ",$len_desc);
						$info_factura.=$esp_init.$tmplinea[1].$esp_totales.$esp_lentot2." "."\n";
						for($x=0;$x<2;$x++){
						 $info_factura.="\n";
					 }
	}
	$info_factura.="\n";
	$esp_totales_g=espacios_izq(" ",71);
  $info_factura.=$esp_totales_g.$esp_lentot2.$total_value_gravado."\n";
	$esp_totales=espacios_izq(" ",71);
	for($x=0;$x<2;$x++){
	 $info_factura.="\n";
 }
 $splentot2=len_espacios($total_final_format,8);
 $esp_lentot2=espacios_izq(" ",$splentot2);
 $info_factura.=$esp_totales.$esp_lentot2.$total_final_format."\n";
 $info_factura.="|".$esp_totales.$esp_lentot2.$total_final_format."\n";
 // retornar valor generado en funcion
	return ($info_factura);
}
function print_vale($id_movimiento){
  $id_sucursal=$_SESSION['id_sucursal'];
	//sucursal
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal1=$array_sucursal['descripcion'];

	$empresa=empresa();

	//consulta
	$sql="SELECT  e.id_empleado, e.nombre,
	mc.concepto, mc.valor,mc.fecha,mc.hora,mc.entrada,mc.salida,mc.id_sucursal
	FROM mov_caja AS mc
	JOIN usuario AS e ON(e.id_usuario=mc.id_empleado)
	WHERE  mc.id_movimiento='$id_movimiento'";
	$result=_query($sql);
	$nrow = _num_rows($result);
	$row = _fetch_array($result);
	$id_empleado = $row["id_empleado"];
	$concepto = $row["concepto"];
	$nombre = $row["nombre"];
	$hora= $row["hora"];
	$fecha= $row["fecha"];
	$valor= $row["valor"];
  $entrada= $row["entrada"];
	//$id_sucursal=$row["id_sucursal"];
	if($entrada==1){
		$tipo="INGRESO";
	}
	else{
		$tipo="EGRESO";
	}
	$line1=str_repeat("_",30)."\n";
  $valor= sprintf('%.2f', $valor);
	//Datos
	$col0=1;		$col1=3; 		$col2=3;
	$col3=6;		$col4=5;		$sp1=2;
	$sp_prec=10;
	$sp=espacios_izq(" ",$sp1);
	$sp2=espacios_izq(" ",12);
	$esp_init=espacios_izq(" ",$col0);
	$esp_precios=espacios_izq(" ",$sp_prec);
	$esp_enc2=espacios_izq(" ",3);
	$esp_init2=espacios_izq(" ",23);
	$info_factura="";
	$info_factura.=$esp_init.$empresa."\n";
	//$info_factura.=$esp_init."SUCURSAL ".$nombre_sucursal1."\n";
	$info_factura.=$esp_init."VALE # : ".$id_movimiento."\n";
	$info_factura.=$esp_init."FECHA: ".ED($fecha)."\nHORA:".hora($hora)."\n";
	$info_factura.=$esp_init."EMPLEADO: ".$nombre."\n";
	$info_factura.=$esp_init.$tipo."\n";
	$info_factura.=$esp_init."CONCEPTO: ".$concepto."\n";
	$info_factura.=$esp_init."VALOR $: ".$valor."\n";
	$info_factura.="\n";
	$info_factura.="F. ".$line1;
	$info_factura.="\n";


	return ($info_factura);

}
function print_corte($id_corte){
	include_once "_core.php";
	//EMPRESA
	$id_sucursal=$_SESSION['id_sucursal'];

	$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['descripcion'];
	$razonsocial=$row_empresa['razon_social'];
	$giro=$row_empresa['giro'];
	$nit=$row_empresa['nit'];
	$nrc=$row_empresa['nrc'];
	//sucursal
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal=$array_sucursal['descripcion'];
	//consulta
	$sql_t=_fetch_array(_query("SELECT controlcaja.id_empleado FROM controlcaja WHERE controlcaja.id_corte=$id_corte"));
	$id_c=$sql_t['id_empleado'];
	$sql="";
	if($id_c<0) {
		# code...
		$sql="SELECT c.caja, c.turno, c.cajero, c.tinicio, c.tfinal, c.totalnot, c.texento, c.tgravado,
		c.totalt, c.finicio, c.ffinal, c.totalnof, c.fexento, c.fgravado, c.totalf, c.cfinicio, c.cffinal, c.totalnocf,
		c.cfexento, c.cfgravado, c.totalcf, c.rinicio, c.rfinal, c.totalnor, c.rexento, c.rgravado, c.totalr,
		c.cashinicial, c.vtacontado, c.vtaefectivo, c.vtatcredito, c.totalgral, c.subtotal, c.cashfinal, c.diferencia,
		c.totalnodev, c.totalnoanu, c.depositos, c.vales, c.tarjetas, c.depositon, c.valen, c.tarjetan, c.ingresos,
		c.tcredito, c.ncortex, c.ncortez, c.ncortezm, c.cerrado, c.id_empleado, c.id_sucursal, c.id_apertura,
		c.fecha_corte, c.hora_corte, c.tipo_corte,e.nombre, c.monto_ch, c.tiket, c.turno, c.retencion
		FROM controlcaja AS c
		JOIN usuario AS e ON(e.id_usuario=c.id_empleado)
		WHERE c.id_corte='$id_corte'";
	}
	else {
		# code...
		$sql="SELECT c.caja, c.turno, c.cajero, c.tinicio, c.tfinal, c.totalnot, c.texento, c.tgravado,
		c.totalt, c.finicio, c.ffinal, c.totalnof, c.fexento, c.fgravado, c.totalf, c.cfinicio, c.cffinal, c.totalnocf,
		c.cfexento, c.cfgravado, c.totalcf, c.rinicio, c.rfinal, c.totalnor, c.rexento, c.rgravado, c.totalr,
		c.cashinicial, c.vtacontado, c.vtaefectivo, c.vtatcredito, c.totalgral, c.subtotal, c.cashfinal, c.diferencia,
		c.totalnodev, c.totalnoanu, c.depositos, c.vales, c.tarjetas, c.depositon, c.valen, c.tarjetan, c.ingresos,
		c.tcredito, c.ncortex, c.ncortez, c.ncortezm, c.cerrado, c.id_empleado, c.id_sucursal, c.id_apertura,
		c.fecha_corte, c.hora_corte, c.tipo_corte,em.nombre, c.monto_ch, c.tiket, c.turno, c.retencion
		FROM controlcaja AS c
		JOIN usuario AS e ON(e.id_usuario=c.id_empleado)
		LEFT JOIN empleado as em on(e.id_empleado=em.id_empleado)
		WHERE c.id_corte='$id_corte'";
	}

	$result=_query($sql);
	$nrow = _num_rows($result);
	$row = _fetch_array($result);
	$id_empleado = $row["id_empleado"];
	$nombre_emp = $row["nombre"];

	$result_emp= datos_empleado($id_c,$id_c);
	list($al,$nombre_emp)=explode('|',$result_emp);

	$hora= $row["hora_corte"];
	$fecha= ED($row["fecha_corte"]);
	$tipo= $row["tipo_corte"];
	$tinicio= $row["tinicio"];
	$tfinal= $row["tfinal"];
	$finicio= $row["finicio"];
	$ffinal= $row["ffinal"];
	$cfinicio= $row["cfinicio"];
	$cffinal= $row["cffinal"];
	$cashini= $row["cashinicial"];
	$vtaefectivo= $row["vtaefectivo"];
	$ingresos= $row["ingresos"];
	$vales= $row["vales"];
	$totalgral= $row["totalgral"];
	$cashfinal= $row["cashfinal"];
	$diferencia= $row["diferencia"];
	$totalnot= $row["totalnot"];
	$totalnof= $row["totalnof"];
	$totalnocf= $row["totalnocf"];
	$monto_ch = $row["monto_ch"];
	$caja = $row["caja"];
	$tike = $row['tiket'];
	$turno = $row["turno"];
	$retencion= $row['retencion'];
	$id_apertura=$row['id_apertura'];

	$sql_caja = _query("SELECT * FROM caja WHERE id_caja='$caja'");
	$dats_caja = _fetch_array($sql_caja);
	$fehca = ED($dats_caja["fecha"]);
	$resolucion = $dats_caja["resolucion"];
	$serie = $dats_caja["serie"];
	$desde = $dats_caja["desde"];
	$hasta = $dats_caja["hasta"];

	$texento= sprintf('%.2f', $row["texento"]);
	$tgravado= sprintf('%.2f', $row["tgravado"]);
	$totalt=  sprintf('%.2f', $row["totalt"]);
	$fexento= sprintf('%.2f', $row["fexento"]);
	$fgravado=sprintf('%.2f',  $row["fgravado"]);
	$totalf= sprintf('%.2f', $row["totalf"]);
	$cfexento= sprintf('%.2f', $row["cfexento"]);
	$cfgravado=sprintf('%.2f',  $row["cfgravado"]);
	$totalcf=sprintf('%.2f',  $row["totalcf"]);
	$vtatotales=$totalt+$totalf+$totalcf;
	$vtatotales_print=sprintf('%.2f', $vtatotales);
	$vtaefectivo= sprintf('%.2f', $vtaefectivo);
	$cashini= sprintf('%.2f', $cashini);
	$ingresos= sprintf('%.2f', $ingresos);
	$monto_ch = sprintf('%.2f', $monto_ch);

	$vales=sprintf('%.2f', $vales);
	$cashfinal= sprintf('%.2f', $cashfinal);
	$diferencia= sprintf('%.2f', $diferencia);
	$esp_init=espacios_izq(" ",1);
	$esp_init0=espacios_izq(" ",1);
	$esp_init1=espacios_izq(" ",12);
	$esp_init2=espacios_izq(" ",20);
	$line1=str_repeat("_",33)."\n";
	$info_factura="";
	$tinicio= zfill($tinicio, 7);
	$tfinal= zfill($tfinal, 7);
	$empresa=empresa();

	if($tipo=="C"){
		$desc_tipo='CORTE DE CAJA';
	}
	else{
		$desc_tipo=$tipo;
	}
	$info_factura.=$esp_init0.$empresa."\n";
	//$info_factura.=$esp_init0.$razonsocial."\n";
	$giros = explode(";", $giro);
	for ($ni = 0; $ni < (count($giros)); $ni++)
	{
		$info_factura.=$esp_init.trim($giros[$ni])."\n";
	}
	//$info_factura.=$esp_init0."SUCURSAL ".$nombre_sucursal."\n";
	$info_factura.=$esp_init0."CORTE TIPO: ".$desc_tipo."\n";
	/*$info_factura.=$esp_init0."RESOLUCION:  ".$resolucion."\n";
	$info_factura.=$esp_init0."DEL ".$desde." AL ".$hasta."\n";
	$info_factura.=$esp_init0."SERIE ".$serie."\n";
	$info_factura.=$esp_init0."FECHA RESOLUCION ".$fehca."\n";*/
	$info_factura.=$esp_init0."CORTE DE CAJA  : ".$id_corte."|";
	$info_factura.=$line1;
	$info_factura.=$esp_init."FECHA: ".$fecha."  HORA:".hora($hora)."\n";
	$info_factura.=$esp_init."EMPLEADO: ".$nombre_emp."\n";
	$info_factura.=$esp_init."CAJA : ".$caja. "  TURNO: ".$turno;


	$info_factura.="\n";
	if($tipo=="C"){
		$subtotal=$cashini+$vtatotales+$ingresos+$monto_ch;
		$totalcaja=$subtotal-$vales;
		$subtotal=sprintf('%.2f', $subtotal);
		$totalcaja=sprintf('%.2f', $totalcaja);
		//$info_factura.=$esp_init1."DESDE:      HASTA:"."\n";
		$info_factura.=$line1;
		$info_factura.=$esp_init0."TIQUETES:     ".$tinicio."   ".$tfinal."\n";
		$info_factura.=$esp_init0."FACTURAS:     ".str_pad($finicio,7," ",STR_PAD_LEFT)."   ".str_pad($ffinal,7," ",STR_PAD_LEFT)."\n";
		$info_factura.=$esp_init0."FISCALES:     ".str_pad($cfinicio,7," ",STR_PAD_LEFT)."   ".str_pad($cffinal,7," ",STR_PAD_LEFT)."\n";
		$info_factura.="\n";

		$n=5;
		$sp1=len_num($cashini,$n);
		$info_factura.=$esp_init0."SALDO INICIAL $:      ".$sp1.$cashini."\n";
		$sp1=len_num($monto_ch,$n);
		$info_factura.=$esp_init0."SALDO CAJA CHICA $:      ".str_pad(number_format($monto_ch,2,".",""),6," ",STR_PAD_LEFT)."\n";
		$sp1=len_num($ingresos,$n);
		$info_factura.=$esp_init0."(+)INGRESOS $:        ".$sp1.$ingresos."\n";
		$sp1=len_num($vtatotales_print,$n);
		$info_factura.=$esp_init0."(+) VENTA $:          ".$sp1.$vtatotales_print."\n";
		$info_factura.=$line1;
		$sp1=len_num($subtotal,$n);
		$info_factura.=$esp_init0."SUBTOTAL $:           ".$sp1.$subtotal."\n";
		$sp1=len_num($vales,$n);
		$info_factura.=$esp_init0."(-) VALES $:          ".$sp1.$vales."\n";

		$sql_cuenta = _query("SELECT mc.*, f.numero_doc, f.id_cliente, f.nombre AS nombre_f, c.nombre AS nombre_c
			FROM mov_caja AS mc
			join abono_credito on abono_credito.id_abono_credito = mc.idtransace
			join credito on credito.id_credito = abono_credito.id_credito
			JOIN factura AS f ON credito.id_factura = f.id_factura
			JOIN cliente AS c ON f.id_cliente = c.id_cliente
		  WHERE mc.id_apertura = '$id_apertura' AND mc.hora <='$hora' AND mc.numero_doc != ''");
		$cuenta_cuenta = _num_rows($sql_cuenta);
		$total_cobros = 0;
		if($cuenta_cuenta > 0)
		{
		  while ($row_cuenta = _fetch_array($sql_cuenta))
		  {
		    $monto = $row_cuenta["valor"];
		    $entrada = $row_cuenta["entrada"];
		    $salida = $row_cuenta["salida"];
		    $numero_doc = $row_cuenta['numero_doc'];
		    $idtransace = $row_cuenta['idtransace'];
		    $nombre_c = $row_cuenta['nombre_c'];
		    $nombre_f = $row_cuenta['nombre_f'];
		    $total_cobros += $monto;
		  }
			$info_factura.=$line1;
			$sp1=len_num($total_cobros,$n);
			$info_factura.=$esp_init0."(+) COBROS CREDITO $:         ".$sp1.number_format($total_cobros, 2, '.', ',')."\n";
		}

		$totalcaja = $totalcaja + $total_cobros;

		$info_factura.=$line1;
		$sp1=len_num($totalcaja,$n);
		$info_factura.=$esp_init0."TOTAL CAJA $:         ".$sp1.$totalcaja."\n";
		$info_factura.="\n";
		$sp1=len_num(number_format($retencion,2,".",""),$n);
		$info_factura.=$esp_init0."(-) RETENCION $:    ".str_pad(number_format($retencion,2,".",""),11," ",STR_PAD_LEFT)."\n";


		$sql_dev="SELECT sum(t_devolucion) as total FROM devoluciones_corte WHERE id_corte='$id_corte' AND tipo!='CCF'";
		$result_dev =_query($sql_dev);
		$nrow_dev = _num_rows($result_dev);
		if($nrow_dev>0)
		{
			$row_dev = _fetch_array($result_dev);
			$info_factura.=$esp_init0."(-)DEVOLUCIONES$:   ".str_pad(number_format($row_dev['total'],2,".",""),11," ",STR_PAD_LEFT)."\n";
			/*$info_factura.=$esp_init0."  NUMERO   DOC     AFECTA      TOTAL"."\n";
			for($j=0;$j<$nrow_dev;$j++){

				$row_dev = _fetch_array($result_dev);

				$n_devolucion=str_pad($row_dev['n_devolucion'],8," ",STR_PAD_LEFT);
				$t_devolucion=str_pad(number_format($row_dev['t_devolucion'],2,".",""),11," ",STR_PAD_LEFT);
				$afecta=str_pad($row_dev['afecta'],11," ",STR_PAD_LEFT);
				$tipo=$row_dev['tipo'];

				$info_factura.=" ".$n_devolucion."   ".$tipo.$afecta.$t_devolucion."\n";
				//$info_factura.=$esp_init0."TOTAL   :".$sp1.$total_docs."\n";
			}*/
		}
		$sql_dev="SELECT id_dev as id_devolucion, id_corte, n_devolucion, t_devolucion,afecta,tipo FROM devoluciones_corte WHERE id_corte='$id_corte' AND tipo='CCF'";
		$result_dev =_query($sql_dev);
		$nrow_dev = _num_rows($result_dev);
		if($nrow_dev>0){
			$info_factura.=$esp_init0."(-)NOTAS DE CREDITO :"."\n";
			$info_factura.=$esp_init0."  NUMERO   DOC     AFECTA      TOTAL"."\n";
			for($j=0;$j<$nrow_dev;$j++){

				$row_dev = _fetch_array($result_dev);

				$n_devolucion=str_pad($row_dev['n_devolucion'],8," ",STR_PAD_LEFT);
				$t_devolucion=str_pad(number_format($row_dev['t_devolucion'],2,".",""),11," ",STR_PAD_LEFT);
				$afecta=str_pad($row_dev['afecta'],11," ",STR_PAD_LEFT);
				$tipo=$row_dev['tipo'];

				$info_factura.=" ".$n_devolucion."   ".$tipo.$afecta.$t_devolucion."\n";
				//$info_factura.=$esp_init0."TOTAL   :".$sp1.$total_docs."\n";
			}
		}

		$info_factura.=$line1;
		$sp1=len_num($cashfinal,$n);
		$info_factura.=$esp_init0."EFECTIVO $:           ".$sp1.$cashfinal."\n";
		$sp1=len_num($diferencia,$n);
		$info_factura.=$esp_init0."DIFERENCIA $:         ".$sp1.$diferencia."\n";

		$sql_detail = _query("SELECT producto.descripcion , to_corte_producto.id_producto,to_corte_producto.id FROM to_corte_producto JOIN producto ON producto.id_producto = to_corte_producto.id_producto WHERE id_corte = $id_corte ");

		if (_num_rows($sql_detail)>0) {
			// code...
				$info_factura.=str_pad("\nMOVIMIENTOS DE PRODUCTO",36," ",STR_PAD_BOTH)."\n\n";

				while ($ro = _fetch_array($sql_detail)) {
					// code...
					$info_factura.=str_pad($ro['descripcion'],36," ",STR_PAD_BOTH)."\n";
					//$info_factura.=" CANTIDAD      ANTERIOR       ACTUAL"."\n";

					$sql_det = _query("SELECT * FROM to_corte_producto_detalle where id_ref = $ro[id]");

					$o=0;
					$e=0;
					$s=0;
					$f=0;
					while ($row =_fetch_array($sql_det)) {
						// code...

						if ($o==0) {
							// code...
							$info_factura.=str_pad("INICIAL: ".round($row['stock_anterior'],2),36," ",STR_PAD_RIGHT)."\n";
							$info_factura.="  ENTRADA        SALIDA       ACTUAL"."\n";
						}
						$t="S";
						if ($row['stock_anterior']<$row['stock_actual']) {
							// code...
								$t="E";

								$e = $e +round($row['cantidad'],2);
								$info_factura.=
								 str_pad(round($row['cantidad'],2),9," ",STR_PAD_LEFT)
								.str_pad("-",14," ",STR_PAD_LEFT)
								.str_pad(round($row['stock_actual'],2),13," ",STR_PAD_LEFT)
								."\n";
								$f = round($row['stock_actual'],2);
						}
						else {
							// code...
							$s = $s +round($row['cantidad'],2);
							$info_factura.=
							 str_pad("-",9," ",STR_PAD_LEFT)
							.str_pad(round($row['cantidad'],2),14," ",STR_PAD_LEFT)
							.str_pad(round($row['stock_actual'],2),13," ",STR_PAD_LEFT)
							."\n";

							$f = round($row['stock_actual'],2);
						}
						$o++;
					}

					$info_factura.=
					 str_pad("",36,"-",STR_PAD_LEFT)."\n";
					$info_factura.=
					 str_pad(round($e,2),9," ",STR_PAD_LEFT)
					.str_pad(round($s,2),14," ",STR_PAD_LEFT)
					.str_pad(round($f,2),13," ",STR_PAD_LEFT)
					."\n";

					$info_factura.="\n";

				}
		}
	}

	if($tipo=="X" || $tipo=="Z"){
		//listar devoluciones
		/*$sql_dev="SELECT id_devolucion, id_corte, n_devolucion, t_devolucion FROM devoluciones WHERE id_corte='$id_corte'";
		$result_dev =_query($sql_dev);
		$nrow_dev = _num_rows($result_dev);*/

		$info_factura.=$esp_init."TIQUETE # ".$tike."\n\n";
		$subtotal=$cashini+$vtaefectivo+$ingresos;
		$totalcaja=$subtotal-$vales;
		$tot_exent=$texento+$fexento+$cfexento;
		$tot_grav=$tgravado+$fgravado+$cfgravado;
		$tot_fin=$totalt+$totalf+$totalcf;
		$tot_exent=sprintf('%.2f', $tot_exent);
		$tot_grav=sprintf('%.2f', $tot_grav);
		$tot_fin=sprintf('%.2f', $tot_fin);
		$subtotal=sprintf('%.2f', $subtotal);
		$totalcaja=sprintf('%.2f', $totalcaja);
		$esp_init1 = "       ";
		$esp_init0 = "";
		$info_factura.=$esp_init1."       EXEN.  GRAV.  TOTAL"."\n";
		$info_factura.=$line1;
		$n=4;
		$sp1=len_num($texento,$n);
		$sp2=len_num($tgravado,$n);
		$sp3=len_num($totalt,$n);
		$info_factura.=$esp_init0."TIQUETES:".$sp1.$texento."".$sp2.$tgravado."".$sp3.$totalt."\n";
		$sp1=len_num($fexento,$n);
		$sp2=len_num($fgravado,$n);
		$sp3=len_num($totalf,$n);
		$info_factura.=$esp_init0."FACTURAS:".$sp1.$fexento."".$sp2.$fgravado."".$sp3.$totalf."\n";
		$sp1=len_num($cfexento,$n);
		$sp2=len_num($cfgravado,$n);
		$sp3=len_num($totalcf,$n);
		$info_factura.=$esp_init0."FISCALES:".$sp1.$cfexento."".$sp2.$cfgravado."".$sp3.$totalcf."\n";
		$info_factura.=$line1;
		$sp1=len_num($tot_exent,$n);
		$sp2=len_num($tot_grav,$n);
		$sp3=len_num($tot_fin,$n);

		$info_factura.=$esp_init0."TOTAL $ :".$sp1.$tot_exent.$sp2.$tot_grav.$sp3.$tot_fin."\n";
		$info_factura.="\n";

		$info_factura.=$esp_init1."   INICIO   FINAL   TOTAL"."\n";
		$info_factura.=$line1;
		$n=4;
		$total_docs=$totalnot+$totalnof+$totalnocf;
		$sp1=len_num($tinicio,$n);
		$sp2=len_num($tfinal,$n);
		$sp3=len_num($totalnot,$n);
		$info_factura.=$esp_init0."TIQUETES: ".$sp1.$tinicio.$sp2.$tfinal.$sp3.$totalnot."\n";
		$sp1=len_num($finicio,$n);
		$sp2=len_num($ffinal,$n);
		$sp3=len_num($totalnof,$n);
		$info_factura.=$esp_init0."FACTURAS:   ".esp_text($finicio,6)."  ".esp_text($ffinal,6).$sp3.$totalnof."\n";
		$sp1=len_num($cfinicio,$n);
		$sp2=len_num($cffinal,$n);
		$sp3=len_num($totalnocf,$n);
		$info_factura.=$esp_init0."FISCALES:   ".esp_text($cfinicio,6)."  ".esp_text($cffinal,6).$sp3.$totalnocf."\n";
		$info_factura.=$line1;
		$sp1=len_num($total_docs,24);
		$info_factura.=$esp_init0."TOTAL:".$sp1.$total_docs."\n";
		$info_factura.="\n";

		/*if($nrow_dev>0){
		$info_factura.=$esp_init0."DEVOLUCIONES   :"."\n";
		$info_factura.=$esp_init0."  NUMERO   TOTAL"."\n";
		for($j=0;$j<$nrow_dev;$j++){

		$row_dev = _fetch_array($result_dev);
		$n_devolucion=$row_dev['n_devolucion'];
		$t_devolucion=$row_dev['t_devolucion'];
		$sp1=len_num($n_devolucion,$n);
		$sp2=len_num($t_devolucion,$n);
		$info_factura.=$esp_init0.$sp1.$n_devolucion.$sp2.$t_devolucion."\n";
		//$info_factura.=$esp_init0."TOTAL   :".$sp1.$total_docs."\n";
	}
	$info_factura.="\n";
}*/
//listar devoluciones de nota de credito
/*$sql_ncr="SELECT id_nc, id_corte, n_nc, t_nc, afecta, tipo FROM nc_corte WHERE id_corte='$id_corte'";
$result_ncr =_query($sql_ncr);
$nrow_ncr = _num_rows($result_ncr);
if($nrow_ncr>0){
$info_factura.=$esp_init0."DEVOLUCION NOTA CREDITO   :"."\n";
$info_factura.=$esp_init0."  NUMERO   TOTAL"."\n";
for($k=0;$k<$nrow_ncr;$k++){

$row_ncr = _fetch_array($result_ncr);
$n_dev=$row_ncr['n_nc'];
$t_dev=$row_ncr['t_nc'];
$sp1=len_num($n_dev,$n);
$sp2=len_num($t_dev,$n);
$info_factura.=$esp_init0.$sp1.$n_dev.$sp2.$t_dev."\n";
}
$info_factura.="\n";
}*/
}
$info_factura.="\n";
return ($info_factura);


}

function len_num($subtotal,$col3){
		//$col3=5;
	if(strlen($subtotal)<=4)
		$sp3=$col3;
	if(strlen($subtotal)==5)
		$sp3=$col3-1;
	if(strlen($subtotal)==6)
		$sp3=$col3-2;
	if(strlen($subtotal)==7)
		$sp3=$col3-3;
	if(strlen($subtotal)==8)
		$sp3=$col3-4;
	//if(strlen($subtotal)==9)
	//	$sp3=$col3-5;
	$esp_col3=espacios_izq(" ",$sp3);
	return $esp_col3;
}


function texto_espacios($texto,$long){
	$countchars=0;
	$countch=0;
	$texto=trim($texto);
	$len_txt=strlen($texto);
	$latinchars = array( 'ñ','á','é', 'í', 'ó','ú','Ñ','Á','É','Í','Ó','Ú');
    foreach($latinchars as $value){
		$countchars=substr_count($texto,$value);
        $countch= $countchars+$countch;
    }

	if($len_txt<=$long){
	 if($countch>0)
		$n=($long+$countch)-$len_txt;
	 else
		$n=$long-$len_txt;

		$texto_repeat=str_repeat(" ",$n);
		$texto_salida=$texto.$texto_repeat;
	}
	else{
		$long=$long-1;
		$texto_salida=substr($texto,0,$long).".";
	}
	return $texto_salida;
}
function espacios_izq($texto,$long){
	$len_txt=strlen($texto);

	if($len_txt<=$long){

			$alinear='STR_PAD_LEFT';
	 $texto_salida=str_pad($texto, $long, " ",STR_PAD_LEFT );
	}
	else{
	$texto_salida=substr($texto,0,$long);
	}
	return $texto_salida;
}
function cadenaenlineas( $text, $width = '80', $lines = '10', $break = '\n', $cut = 0 ) {
      $wrappedarr = array();
      $wrappedtext = wordwrap( $text, $width, $break , true );
       $wrappedtext = trim( $wrappedtext );
      $arr = explode( $break, $wrappedtext );
     return $arr;
}
function len_espacios($valor,$col){
	$valor=strlen($valor);
	if($valor==1){
		$sp=$col;
	}
	else{
		$sp=$col-($valor-1);
	}
 return $sp;
}
function datos_empresa(){
	//EMPRESA
	$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='".$_SESSION["id_sucursal"]."'";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['descripcion'];
	$razonsocial=$row_empresa['razon_social'];
	$giro=$row_empresa['giro'];
	$nit=$row_empresa['nit'];
	$nrc=$row_empresa['nrc'];
	$empresa1=$empresa;
	$razonsocial1=$razonsocial;
	$giro1=$giro;
	$arr_emp= array($empresa1,$razonsocial1,$giro1,$nit,$nrc);
	//json_encode(array(2=>"dos", 10=>"diez"));
	$data = array('empresa' => $empresa1, 'razonsocial' => $razonsocial1, 'giro' => $giro1,'nit' => $nit,'nrc' => $nrc);
	$datos= json_encode($data);
	return $datos;
}
function datos_sucursal($id_sucursal){
	//Sucursal
	$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
	$array_sucursal=_fetch_array($sql_sucursal);
	$nombre_sucursal=$array_sucursal['descripcion'];
	$nombre_sucursal1=texto_espacios($nombre_sucursal,30);
	return $nombre_sucursal1;
}
function datos_factura($id_factura){
	//Obtener informacion de tabla Factura
	$sql_fact="SELECT * FROM factura WHERE id_factura='$id_factura'";
	$result_fact=_query($sql_fact);
	return $result_fact;
}
function datos_impuesto(){
	//impuestos
	$sql_iva="select iva,monto_retencion1,monto_retencion10,monto_percepcion from monto_impuesto";
	$result_IVA=_query($sql_iva);
	return $result_IVA;

}
function datos_fact_det($id_factura){
	$sql_fact_det="SELECT
	producto.id_producto,
	producto.descripcion,
	producto.exento,
	presentacion.descripcion AS descripcion_pr,
	presentacion_producto.descripcion AS descpre,
	presentacion_producto.id_pp as id_presentacion,
	factura_detalle.*
	FROM factura_detalle
	JOIN producto ON factura_detalle.id_prod_serv=producto.id_producto
	JOIN presentacion_producto ON factura_detalle.id_presentacion=presentacion_producto.id_pp
	JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
	WHERE  factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv!=-9999
	union
	select -9999 as id_producto,
	factura_detalle.description as descripcion,
	factura_detalle.exento,
	'' AS descripcion_pr,
	'' AS descpre,
 	-9999 as id_presentacion,
	factura_detalle.*
	FROM factura_detalle
	where factura_detalle.id_factura='$id_factura' and factura_detalle.id_prod_serv=-9999
	";
	$result_fact_det=_query($sql_fact_det);
	return $result_fact_det;
}
function datos_clientes($id_cliente){
	//Obtener informacion de tabla Cliente
	$sql="select * from cliente where id_cliente='$id_cliente'";
	$result= _query($sql);
	return $result;
}
function datos_empleado($id_empleado,$id_vendedor){
	//Obtener informacion de tabla Cliente
	$sql="select * from usuario where id_usuario='$id_empleado'";
	$result= _query($sql);
	$row=_fetch_array($result);
	$empleado=$row['nombre'];

	$sql2="select empleado.* from empleado join usuario ON usuario.id_empleado=empleado.id_empleado where id_usuario='$id_vendedor'";
	$result2= _query($sql2);
	$vendedor="";
	if(_num_rows($result2)>0)
	{
		$row2=_fetch_array($result2);
		$vendedor=$row2['nombre'];
	}
	else {
		// code...
		$vendedor=$empleado;
	}

	$empleado_vendedor=	$empleado."|".$vendedor;
	return $empleado_vendedor;
}
function empresa(){
	//Empresa
	$sql_empresa = "SELECT * FROM sucursal where id_sucursal=$_SESSION[id_sucursal]";
	$result_empresa=_query($sql_empresa);
	$row_empresa=_fetch_array($result_empresa);
	$empresa=$row_empresa['descripcion'];

	return $empresa;
}
function esp_num($param,$n)
{
	$v=str_pad(number_format($param,2,".",""),$n," ",STR_PAD_LEFT);
	return $v;
}
function esp_text($param,$n)
{
	$v=str_pad($param,$n," ",STR_PAD_LEFT);
	return $v;
}

function quitar_spc($cadena){
	$no_permitidas= array ("º","á","é","í","ó","ú","Á","É","Í","Ó","Ú","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
  $permitidas=     array(" ","a","e","i","o","u","A","E","I","O","U","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E",);
  $texto = str_replace($no_permitidas, $permitidas ,$cadena);
	$texto = preg_replace('/[^a-zA-Z0-9ñÑ.|\/\-\_\+*$:= ]/u',"",($texto));
  return ($texto);
}


function p_set($linea,$dato,$inicio,$fin,$a)
{
	//$dato = quitar_spc($dato);
	$linea= str_replace("\n", "", $linea);
	$in = Unicode::substr($linea,0,$inicio-1);
	$cuerpo =st(Unicode::substr($dato,0,($fin-$inicio)),($fin-$inicio)," ",$a);
	$complemento = st(" ",strlen($linea)-strlen($in)-strlen($cuerpo));
	return $in.$cuerpo.$complemento."\n";
}

function st($input,$lengt,$carac=" ",$di="R")
{
	// code..
	$r = "";
	switch ($di) {
		case 'L':
		// code...
		$r=str_pad_unicode($input, $lengt, $carac, STR_PAD_LEFT);
		break;
		case 'R':
		// code...
		$r=str_pad_unicode($input, $lengt, $carac, STR_PAD_RIGHT);
		break;
		case 'B':
		// code...
		$r=str_pad_unicode($input, $lengt, $carac, STR_PAD_BOTH);
		break;
		default:
		// code...
		break;
	}
	return $r;
}

function dtl( $text, $width = '80', $lines = '10', $break = '\n', $cut = 0 ) {
	$wrappedarr = array();
	$wrappedtext = wordwrap( $text, $width, $break , true );
	$wrappedtext = trim( $wrappedtext );
	$arr = explode( $break, $wrappedtext );
	return $arr;
}

function get_tipo($tipo)
{
	$val="";
	// code...
	switch ($tipo) {
		case '0':
		$val="CONTADO";
			// code...
			break;
		case '1':
			// code..
		$val="CREDITO";
			break;
		case '2':
			// code...
		$val="TARJETA";
			break;
		case '3':
			// code...
		$val="CHEQUE";
			break;
		default:
			// code..
		$val="CONTADO";
			break;
	}
	return $val;
}

function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {
    $str_len = mb_strlen($str);
    $pad_str_len = mb_strlen($pad_str);
    if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
        $str_len = 1; // @debug
    }
    if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
        return $str;
    }

    $result = null;
    $repeat = ceil($str_len - $pad_str_len + $pad_len);
    if ($dir == STR_PAD_RIGHT) {
        $result = $str . str_repeat($pad_str, $repeat);
        $result = mb_substr($result, 0, $pad_len);
    } else if ($dir == STR_PAD_LEFT) {
        $result = str_repeat($pad_str, $repeat) . $str;
        $result = mb_substr($result, -$pad_len);
    } else if ($dir == STR_PAD_BOTH) {
        $length = ($pad_len - $str_len) / 2;
        $repeat = ceil($length / $pad_str_len);
        $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
                    . $str
                       . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
    }

    return $result;
}
?>
