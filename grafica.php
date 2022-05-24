<?php
	include '_core.php';
	$m = date("m");
	$y = date("Y");
	$ini = "2017-".$m."-01";
	$ult = cal_days_in_month(CAL_GREGORIAN, $m, $y);
	$fin = $y."-".$m."-".$ult;
	$min = 10;
	$id_sucursal = $_SESSION["id_sucursal"];

	//$query = _query("SELECT sum(df.cantidad) as venta, productos.descripcion,productos.barcode,productos.talla,productos.estilo,colores.nombre, stock.existencias,productos.precio1 FROM detalle_factura as df, factura as f, productos, stock, colores WHERE df.idtransace=f.idtransace AND productos.id_producto=df.id_producto AND productos.id_producto=stock.id_producto AND productos.id_color=colores.id_color AND stock.id_sucursal='$id_sucursal' AND f.fecha_doc BETWEEN '$ini' AND '$fin' GROUP BY df.id_producto ORDER BY venta DESC LIMIT $min");
	$query = _query("SELECT sum(df.cantidad) as venta, producto.descripcion,producto.barcode  FROM factura_detalle as df, factura as f, producto WHERE df.id_factura=f.id_factura AND producto.id_producto=df.id_prod_serv AND f.id_sucursal=$id_sucursal  AND f.anulada=0  AND f.fecha BETWEEN '$ini' AND '$fin' GROUP BY df.id_prod_serv ORDER BY venta DESC LIMIT 10");
	$data=array();
	while($row = _fetch_array($query))
	{
		$cantidad = $row["venta"];
		$descripcion = $row["descripcion"];
		if($cantidad > 0)
		{
			$data[] = array(
				"total" => $cantidad,
				"mes" => $descripcion,
			);
		}
	}
	echo json_encode($data);
?>
