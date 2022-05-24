<?php
include_once "_core.php";

_begin();
$sql=_query("
SELECT DISTINCT (producto.id_producto), producto.descripcion,presentacion_producto.id_presentacion,presentacion_producto.id_sucursal,
REPLACE(REPLACE(REPLACE(Hoja1.Precio1,'$',''),',','.'),'-','0.00') as Precio1,
REPLACE(REPLACE(REPLACE(Hoja1.Precio2,'$',''),',','.'),'-','0.00') as Precio2,
REPLACE(REPLACE(REPLACE(Hoja1.Precio3,'$',''),',','.'),'-','0.00') as Precio3,
REPLACE(REPLACE(REPLACE(Hoja1.Precio4,'$',''),',','.'),'-','0.00') as Precio4,
REPLACE(REPLACE(REPLACE(Hoja1.Precio5,'$',''),',','.'),'-','0.00') as Precio5,
REPLACE(REPLACE(REPLACE(Hoja1.Precio6,'$',''),',','.'),'-','0.00') as Precio6,
REPLACE(REPLACE(REPLACE(Hoja1.Precio7,'$',''),',','.'),'-','0.00') as Precio7,
REPLACE(REPLACE(REPLACE(Hoja1.Costo_Iva,'$',''),',','.'),'-','0.00') as costo_iva,
presentacion_producto.costo,
presentacion.nombre
FROM producto
INNER JOIN Hoja1 ON UPPER(producto.descripcion)=UPPER(Hoja1.Nombre)
JOIN presentacion_producto ON presentacion_producto.id_producto=producto.id_producto
JOIN presentacion ON presentacion.id_presentacion = presentacion_producto.presentacion
WHERE REPLACE(REPLACE(REPLACE(Hoja1.Precio1,'$',''),',','.'),'-','0.00')!=0 AND presentacion_producto.costo
BETWEEN (REPLACE(REPLACE(REPLACE(Hoja1.Costo_Iva,'$',''),',','.'),'-','0.00')/1.4) AND (REPLACE(REPLACE(REPLACE(Hoja1.Costo_Iva,'$',''),',','.'),'-','0.00')*1.4)");

echo _error();
$a=1;

while ($row=_fetch_array($sql)) {
  # code...
  $table="presentacion_producto_precio";
  $where_clause="id_presentacion=$row[id_presentacion] AND id_sucursal=$row[id_sucursal] ";
  $delete = _delete($table,$where_clause);
  
  for ($i=1; $i < 8; $i++) {
    # code...
    $desde=0;
    $hasta=0;
    if ($i==1) {
      # code...
      $desde=0;
      $hasta=3;
    }
    else {
      # code...
      if ($i==2) {
        # code...
        $desde=3;
        $hasta=6;
      }
      else {
        # code...
        if ($i==3) {
          # code...
          $desde=6;
          $hasta=12;
        }
        else {
          # code...

          $desde=12;
          $hasta=999;

        }

      }
    }
    $precio="Precio".$i;
    $table="presentacion_producto_precio";
    $form_data = array(
      'id_producto' => $row['id_producto'],
      'id_presentacion' => $row['id_presentacion'],
      'id_sucursal' => $row['id_sucursal'],
      'precio' => $row[$precio],
      'desde' => $desde,
      'hasta' => $hasta,
    );

    $insertar=_insert($table,$form_data);
    echo _error();

    if ($insertar) {
      # code...
    }
    else {
      $a=0;
    }
  }
}

if ($a==1) {
  # code...
  _commit();
  echo "ok";

}
else {
  # code...
  _rollback();
  echo "Fallo miserablemente"._error();

}


 ?>
