<?php
include_once "_core.php";


$sql=_query("SELECT Hoja1.Cod_Bar_1,Hoja1.Nombre,REPLACE(REPLACE(Hoja1.Costo_Iva,'$',''),',','.') AS costo,REPLACE(REPLACE(REPLACE(Hoja1.Precio1,'$',''),',','.'),'-','0.00') AS precio,proveedor.id_proveedor,categoria.id_categoria FROM Hoja1 JOIN proveedor ON proveedor.nombre=Hoja1.Casa JOIN categoria ON categoria.nombre_cat=Hoja1.Familia WHERE Hoja1.Nombre IS NOT NULL AND UPPER(Hoja1.Nombre) NOT IN (SELECT UPPER(producto.descripcion) FROM producto)");

while ($row=_fetch_array($sql)) {
  # code...

  $table = 'producto';
	$form_data = array(
		'descripcion' => $row['Nombre'],
		'barcode' => $row['Cod_Bar_1'],
		'marca' => "",
		'minimo' => 0,
		'exento' => 0,
		'estado' => 1,
		'id_proveedor' => $row['id_proveedor'],
		'id_categoria' => $row['id_categoria'],
		'perecedero' => 0,
	);
  $insertar=_insert($table,$form_data);
  $id_producto=_insert_id();

  $sql_suc=_query("SELECT id_sucursal FROM sucursal");
  $a=_num_rows($sql_suc);

  while($row_su=_fetch_array($sql_suc))
  {
    $tabla_p = "presentacion_producto";
    $form_pre = array(
      'id_producto' => $id_producto,
      'presentacion' => 1,
      'descripcion' => "1x1",
      'unidad' => "1",
      'precio' => $row['precio'],
      'costo' => $row['costo'],
      'activo' => 1,
      'id_sucursal'=>$row_su['id_sucursal']
    );
    $insert_pre = _insert($tabla_p, $form_pre);
  }
}
echo "ok";
 ?>
