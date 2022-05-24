<?php
require_once("_conexion.php");

$sql=_query("SELECT producto.descripcion FROM producto GROUP BY descripcion HAVING COUNT(*)>1");



while ($row=_fetch_array($sql)) {
echo _error();
  $sql2=_query('SELECT id_producto, producto.descripcion FROM producto WHERE producto.descripcion="'.$row['descripcion'].'"');
  $i=0;
  while ($row2=_fetch_array($sql2)) {
    if ($i==0) {
      // code...
    }
    else
    {
      $table="producto";
      $where_clause="id_producto='".$row2['id_producto']."'";
      $delete=_delete($table,$where_clause);
    }
    $i++;
  }

}
echo "ok";
 ?>
