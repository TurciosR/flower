<?php
include_once "_core.php";
$id_sucursal=$_SESSION["id_sucursal"];
$query = $_REQUEST['query'];
$sql="SELECT pr.id_producto , pr.descripcion, pr.barcode
		FROM producto pr JOIN stock  st ON pr.id_producto=st.id_producto
	 	WHERE st.stock>0
	 	AND pr.descripcion LIKE '%{$query}%'
		AND st.id_sucursal='$id_sucursal'
	 	";
	//echo $sql;
$result = _query($sql);
$numrows = _num_rows($result);

	//$sql = _query("SELECT producto.id_producto,producto.descripcion,producto.marca FROM producto WHERE descripcion LIKE '%{$query}%'");
	$array_prod = array();
if ($numrows>0){
	while ($row = _fetch_assoc($result)) {
			if ($row['barcode']=="")
				$barcod=" ";
			else
				$barcod=" [".$row['barcode']."] ";
			$array_prod[] =$row['id_producto']."|".$barcod.$row['descripcion'];
	}
}
	echo json_encode ($array_prod); //Return the JSON Array
?>
