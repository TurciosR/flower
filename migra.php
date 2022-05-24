<?php
include '_conexion.php';

$sql=_query("SELECT * FROM Hoja1");

while ($row=_fetch_array($sql)) {

    $descripcion=$row['descripcion'];
    $barcode=$row['codigo2'];
    $exento=$row['exento'];
    $codart=$row['codart'];
    if ($exento=="S") {
        // code...
        $exento=1;
    } else {
        $exento=0;
    }

    $table = 'producto';
    $form_data = array(
      'descripcion' => $descripcion,
      'barcode' => $barcode,
      'codart' => $codart,
      'marca' => "",
      'minimo' => 0,
      'exento' => $exento,
      'estado' => 1,
      'id_proveedor' => 1,
      'id_categoria' => 1,
      'perecedero' => 0,
    );
    $insertar =_insert($table, $form_data);
    $id_producto2 = _insert_id();

    $tabla_p = "presentacion_producto";
    $form_pre = array(
          'id_producto' => $id_producto2,
          'presentacion' => 1,
          'descripcion' => "1x1",
          'unidad' => 1,
          'precio' => $row['precio'],
          'costo' => ($row['costo']*1.13),
          'activo' => 1,
          'id_sucursal'=>1,
          'barcode' => $barcode,
    );
    $insert_pre = _insert($tabla_p, $form_pre);
    $id_presenta=_insert_id();
    for ($i=1; $i < 8; $i++) {
      # code...
      $desde=0;
      $hasta=0;
      $precio="";
      if ($i==1) {
        # code...
        $desde=0;
        $hasta=3;
        $precio="precio";
      }
      else {
        # code...
        if ($i==2) {
          # code...
          $desde=1;
          $hasta=6;
          $precio="precio2";
        }
        else {
          # code...
          if ($i==3) {
            # code...
            $desde=1;
            $hasta=12;
            $precio="precio3";
          }
          else {
            # code...
            $precio="precio4";
            $desde=1;
            $hasta=999;

          }

        }
      }

      if ($i<5) {
        // code...
        $table="presentacion_producto_precio";
        $form_data = array(
          'id_producto' => $id_producto2,
          'id_presentacion' => $id_presenta,
          'id_sucursal' => 1,
          'precio' => $row[$precio],
          'desde' => $desde,
          'hasta' => $hasta,
        );

        $insertar=_insert($table,$form_data);
      }
      else {
        $table="presentacion_producto_precio";
        $form_data = array(
          'id_producto' => $id_producto2,
          'id_presentacion' => $id_presenta,
          'id_sucursal' => 1,
          'precio' => 0.00,
          'desde' => $desde,
          'hasta' => $hasta,
        );

        $insertar=_insert($table,$form_data);

      }
    }

}
