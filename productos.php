<?php
include_once '_core.php';

$sq=_query("SELECT DISTINCT Hoja_local.NOMBRE AS nombre,Hoja_local.BARCODE AS barcode,
  `Hoja_local`.`PRESENTACIÓN` AS presentacion,
  Hoja_local.MARCA AS marca,1 AS stock_minimo,
  presentacion.id_presentacion,
  proveedor.id_proveedor,categoria.id_categoria,
  `Hoja_local`.`COMPOSICION` as composicion,
  REPLACE(`Hoja_local`.`PRECIO COSTO`,',','.')  AS costo,
  REPLACE(`Hoja_local`.`PRECIO VENTA`,',','.') AS precio,
  REPLACE(`Hoja_local`.`PRECIO MAYOREO`,',','.') AS precio_mayoreo,
Hoja_local.UNIDAD as unidad
FROM Hoja_local
JOIN proveedor ON proveedor.nombre=`Hoja_local`.`LABORATORIO O DROGUERIA`
JOIN categoria ON categoria.nombre_cat=Hoja_local.CATEGORIA
JOIN presentacion ON presentacion.nombre=`Hoja_local`.`PRESENTACIÓN` AND `Hoja_local`.`NOMBRE` IS NOT null ORDER BY NOMBRE");

while ($sql=_fetch_array($sq)) {
  // code...
  $nombre=$sql['nombre'];
  $barcode=$sql['barcode'];
  $id_presentacion=$sql['id_presentacion'];
  $marca=$sql['marca'];
  $stock_minimo=1;
  $id_proveedor=$sql['id_proveedor'];
  $id_categoria=$sql['id_categoria'];
  $costo=$sql['costo'];
  $precio=$sql['precio'];

  if ($precio=='') {
    // code...
    $precio=$sql['precio_mayoreo'];
  }
  $unidad=1;
  $composicion=$sql['composicion'];

  $table='producto';
  $form_data = array(
    'barcode' => $barcode,
    'descripcion' =>$nombre,
    'composicion'=> $composicion,
    'marca'=>$marca,
    'estado'=>1,
    'perecedero'=>1,
    'minimo'=>1,
    'id_categoria'=>$id_categoria,
    'id_proveedor'=>$id_proveedor,
    'imagen'=>"",
    'id_sucursal'=>1,
    'costo'=>0,
    'precio'=>0,
  );

  $insert=_insert($table,$form_data);

  if ($insert) {
    $id_producto=_insert_id();
    // code...
    $table="presentacion_producto";
    $form_data = array(
      'id_producto'=>$id_producto,
      'presentacion'=>$id_presentacion,
      'descripcion'=>'1x1',
      'unidad'=>1,
      'precio'=>$precio,
      'activo'=>1,
      'costo' =>$costo,
      'id_sucursal'=>1,
      'barcode'=>$barcode,
    );
    $ins=_insert($table,$form_data);
    $id_pre=_insert_id();
    if ($ins) {
      // code...
      $table='presentacion_producto_precio';

      $form_data = array(
        'id_producto'=>$id_producto,
        'id_presentacion'=>$id_pre,
        'id_sucursal'=>1,
        'precio'=>$precio,
        'desde'=>1,
        'hasta'=>3,
      );
      $inse=_insert($table,$form_data);
    }

  }
}

echo "ok";
 ?>
