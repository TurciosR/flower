<?php
include_once '_conexion.php';

$sql = _query("SELECT producto_viejo.*,presentacion.id_presentacion  FROM `producto_viejo` JOIN presentacion ON producto_viejo.presentacion=presentacion.nombre");

while ($row =_fetch_array($sql)) {
  // code...
  $table = 'producto';
  $form_data = array(
      'id_producto' => $row['id_producto'],
      'descripcion' => $row['descripcion'],
      'codart' => $row['id_producto'],
      'barcode' =>$row['barcode'],
      'marca' => $row['marca'],
      'minimo' => $row['existencias_min'],
      'exento' => 0,
      'estado' => 1,
      'id_proveedor' => $row['id_proveedor'],
      'id_categoria' => $row['id_categoria'],
      'perecedero' => 0,
      'imagen' => $row['imagen'],
  );
  $insertar =_insert($table, $form_data);


  $table="presentacion_producto";
  $form_data = array(
    'id_producto' => $row['id_producto'],
    'descripcion' => "1x".$row['unidad'],
    'id_presentacion' => $row['id_presentacion'],
    'unidad' => $row['unidad'],
    'costo' =>$row['costo'],
    'precio' => $row['costo'] * (1+($row['porcentaje_utilidad1']/100)),
    'precio1' => $row['costo'] * (1+($row['porcentaje_utilidad2']/100)),
    'precio2' => $row['costo'] * (1+($row['porcentaje_utilidad3']/100)),
    'precio3' => $row['costo'] * (1+($row['porcentaje_utilidad4']/100)),
    'activo' => 1,

  );
  _insert($table,$form_data);
}
 ?>
