<?php
include_once "_core.php";
$query = $_REQUEST['query'];
$id_sucursal=$_SESSION['id_sucursal'];
$sql0="SELECT id_producto as id, descripcion, barcode FROM producto WHERE barcode='$query'";
$result = _query($sql0);
if(_num_rows($result)==0)
{
	$sql = "SELECT id_producto as id, descripcion, barcode FROM producto WHERE descripcion LIKE '$query%' limit 500";
	$result = _query($sql);
}
$array_prod[] = array();
$i=0;

while ($row1 = _fetch_array($result))
{
	$id_producto=$row1['id'];
	$sql1 = "SELECT COALESCE(SUM(su.cantidad),0) AS stock FROM producto AS p JOIN stock_ubicacion as su ON su.id_producto=p.id_producto JOIN ubicacion as u ON u.id_ubicacion=su.id_ubicacion  WHERE  p.id_producto ='$id_producto' AND u.bodega=0 AND su.id_sucursal=$id_sucursal";
	$stock1=_query($sql1);
	$row2=_fetch_array($stock1);
	$stock=$row2['stock'];

	$id_factura=0;
	$hoy=date("Y-m-d");
	$barcode = $row1["barcode"];

	$sql_res_pre=_fetch_array(_query("SELECT COALESCE(SUM(factura_detalle.cantidad),0) as reserva FROM factura JOIN factura_detalle ON factura_detalle.id_factura=factura.id_factura WHERE factura_detalle.id_prod_serv=$id_producto AND factura.id_sucursal=$id_sucursal AND factura.fecha = '$hoy' AND factura.finalizada=0 "));
	$reserva=$sql_res_pre['reserva'];

	$sql_res_esto=_fetch_array(_query("SELECT COALESCE(SUM(factura_detalle.cantidad),0) as reservado FROM factura JOIN factura_detalle ON factura_detalle.id_factura=factura.id_factura WHERE factura_detalle.id_prod_serv=$id_producto AND factura.id_factura=$id_factura"));
	$reservado=$sql_res_esto['reservado'];


	$stock= $stock-$reserva+$reservado;
	if($stock<0)
	{
		$stock=0;
	}

	$j=0;
	$unidadp=0;
	$preciop=0;
	$descripcionp=0;
	$sql_p=_query("SELECT presentacion.nombre, presentacion_producto.descripcion,presentacion_producto.id_presentacion,presentacion_producto.unidad,presentacion_producto.precio FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE presentacion_producto.id_producto='$id_producto' AND presentacion_producto.activo=1 AND presentacion_producto.id_sucursal=$id_sucursal ORDER BY presentacion_producto.unidad ASC");
	while ($row=_fetch_array($sql_p))
	{
		if ($j==0)
		{
			$unidadp=$row['unidad'];
			$preciop=$row['precio'];
			$descripcionp=$row['descripcion'];

			$xc=0;

			$sql_rank=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$row[id_presentacion] AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] AND presentacion_producto_precio.precio!=0 ORDER BY presentacion_producto_precio.desde ASC LIMIT 1
				");

				while ($rowr=_fetch_array($sql_rank)) {
					# code...
					if($xc==0)
					{

						$preciop=$rowr['precio'];
					}
				}
			}
			$j=$j+1;
		}

	if($row1['barcode']==""){
	$barcod=" ";
	}
	else{
	$barcod=" [".$row['barcode']."] ";
	}
	$array_prod[$i] = array('producto'=>$row1['id']."|".$barcod.$row1['descripcion']."| $".$preciop."|".$stock);
	$i++;
}

if (_num_rows($result)==0) {
	# code...
	echo json_encode ("");
}
else {
	echo json_encode ($array_prod);
}

?>
