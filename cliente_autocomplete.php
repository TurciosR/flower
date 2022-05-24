<?php
include_once "_core.php";
$query = $_REQUEST['query'];
	/*
	 SELECT id_servicio, descripcion, tipo_prod_servicio FROM servicio
	 * UNION ALL SELECT id_producto, descripcion,  tipo_prod_servicio FROM producto  WHERE descripcion LIKE '%{$query}%'"
	 */
	 //Version del autocomplete que me permite las busquedas ya sea por barcode o por descripcion 09 enero 2015
	 // $sql0="SELECT id_producto as id, descripcion, barcode, tipo_prod_servicio FROM producto  WHERE LIKE '%{$query}%'";

	 $sql0="SELECT * FROM cliente WHERE nombre LIKE '%$query%' ORDER BY id_cliente";
	 $result = _query($sql0);
	 $numrows= _num_rows($result);

	//$sql = _query("SELECT producto.id_producto,producto.descripcion,producto.marca FROM producto WHERE descripcion LIKE '%{$query}%'");
	$array_prod = array();
	$text = "No se encontro cliente";
	if($numrows > 0)
	{

		while ($row = _fetch_array($result)) {
				$nit = $row["nit"];
				$nrc = $row["nrc"];
				$agregado = "";
				if($nit != "" && $nrc != "")
				{
					$agregado = " (".$nit.", ".$nrc.")";
				}
				else if ($nit != "" && $nrc == "")
				{
					$agregado = " (".$nit.")";
				}
				else if ($nit == "" && $nrc != "")
				{
					$agregado = " (".$nrc.")";
				}
				$array_prod[] =$row['id_cliente']." | ".$row['nombre'].$agregado;
		}
	}


	echo json_encode ($array_prod); //Return the JSON Array


?>
