<?php
header("Access-Control-Allow-Origin: *");
require_once("_conexion.php");

if (isset($_REQUEST['hash'])) {
  if ($_REQUEST['hash']=='d681824931f81f6578e63fd7e35095af') {
    // code...
    $sql=_query("SELECT producto.descripcion,producto.marca, stock.stock FROM producto JOIN stock ON stock.id_producto=producto.id_producto WHERE producto.descripcion LIKE '%$_REQUEST[q]%'");
    $xdatos['data']='';
    $info='';
    $n=_num_rows($sql);
    if ($n>0) {
      // code...
      while($row=_fetch_array($sql))
      {
        $info.="<tr><td>$row[marca]</td><td>$row[descripcion]</td><td>$row[stock]</td></tr>";
      }
      $xdatos['data']=$info;
    }

    echo json_encode($xdatos);
  }

}
 ?>
