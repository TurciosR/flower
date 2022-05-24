<?php
	include ("_conexion.php");
	$query = $_REQUEST["query"];
	$entrada=_query("SELECT * FROM producto WHERE imei LIKE '$query%'");
	$datos = "";
	while($raw=_fetch_array($entrada))
		{
			$id_producto=$raw["id_producto"];
			$imei = $raw["imei"];
			$marca = $raw["marca"];
			$modelo = $raw["modelo"];
			$datos[]= $id_producto."|".$imei."|".$marca."|".$modelo;
		}
		echo json_encode($datos);
?>
