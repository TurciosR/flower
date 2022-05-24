<?php
	include '_core.php';
	$inicio = restar_meses(date("Y-m-d"),5);
	$data=array();
	for($i=0; $i<6; $i++)
	{
		$a = explode("-",$inicio)[0];
		$m = explode("-",$inicio)[1];
		$ult = cal_days_in_month(CAL_GREGORIAN, $m, $a);
		$ini = "$a-$m-01";
		$fin = "$a-$m-$ult";
		$min = 10;
		$id_sucursal = $_SESSION["id_sucursal"];

		$query = _query("SELECT sum(total) as total FROM factura WHERE anulada=0 AND fecha BETWEEN '$ini' AND '$fin'");
		$row = _fetch_array($query);
		$total = $row["total"];
		if($total > 0)
		{
			$data[] = array(
				"total" => number_format($total,2,".",""),
				"mes" => meses($m),
				);
		}
		$inicio = sumar_meses($ini,1);
	}
	echo json_encode($data);
?>
