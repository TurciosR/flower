<?php
require_once("_conexion.php");

/*SELECT producto.barcode,producto.descripcion,pc.id_prepd AS id_pc ,pc.precio AS precio_caja,pu.id_prepd AS id_pu ,pu.precio AS precio_unidad FROM producto
JOIN presentacion_producto_precio as pc on pc.id_producto=producto.id_producto
JOIN presentacion_producto as ppc ON ppc.id_presentacion=pc.id_presentacion
JOIN presentacion_producto_precio as pu ON pu.id_producto=producto.id_producto
JOIN presentacion_producto as ppu ON ppu.id_presentacion=pu.id_presentacion
WHERE ppc.presentacion=2 AND ppu.presentacion!=2
AND pc.precio>0 AND pu.precio>0
AND pu.precio>pc.precio
AND producto.id_producto IN(SELECT presentacion_producto.id_producto FROM presentacion_producto_precio JOIN presentacion_producto ON presentacion_producto.id_presentacion=presentacion_producto_precio.id_presentacion GROUP BY presentacion_producto_precio.id_producto HAVING COUNT(*)=2*/

$sql=_query("SELECT producto.barcode,producto.descripcion,pc.id_prepd AS id_pc ,pc.precio AS precio_caja,pu.id_prepd AS id_pu ,pu.precio AS precio_unidad FROM producto
JOIN presentacion_producto_precio as pc on pc.id_producto=producto.id_producto
JOIN presentacion_producto as ppc ON ppc.id_presentacion=pc.id_presentacion
JOIN presentacion_producto_precio as pu ON pu.id_producto=producto.id_producto
JOIN presentacion_producto as ppu ON ppu.id_presentacion=pu.id_presentacion
WHERE ppc.presentacion=2 AND ppu.presentacion!=2
AND pu.precio<pc.precio
AND pu.precio=0
AND producto.id_producto IN(SELECT presentacion_producto.id_producto FROM presentacion_producto_precio JOIN presentacion_producto ON presentacion_producto.id_presentacion=presentacion_producto_precio.id_presentacion GROUP BY presentacion_producto_precio.id_producto HAVING COUNT(*)=2)");

while($row=_fetch_array($sql))
{
  $precio_caja=$row['precio_unidad'];
  $id_caja=$row['id_pc'];
  $precio_unidad=$row['precio_caja'];
  $id_unidad=$row['id_pu'];

  $table="presentacion_producto_precio";
  $form_data = array(
    'precio' => $precio_caja,
  );
  $where_clause="id_prepd ='".$id_caja."'";
  $update=_update($table,$form_data,$where_clause);

  $table="presentacion_producto_precio";
  $form_data = array(
    'precio' => $precio_unidad,
  );
  $where_clause="id_prepd ='".$id_unidad."'";
  $update=_update($table,$form_data,$where_clause);

}
?>
