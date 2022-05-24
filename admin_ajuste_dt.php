<?php
include ("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php' );
// DB table to use
$table = 'movimiento_producto';

$origen=$_REQUEST['origen'];
$pro=$_REQUEST['pro'];

/*
$hostname = "localhost";
$username = "libreria";
$password = "L1br3r1@18";
$dbname
*/
// Table's primary key
$primaryKey = 'id_movimiento';
// MySQL server connection information
$sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
);
$joinQuery="  FROM movimiento_producto LEFT JOIN usuario ON usuario.id_usuario=movimiento_producto.id_empleado JOIN movimiento_stock_ubicacion ON  movimiento_stock_ubicacion.id_mov_prod=movimiento_producto.id_movimiento LEFT JOIN stock_ubicacion ON stock_ubicacion.id_su=movimiento_stock_ubicacion.id_origen LEFT JOIN stock_ubicacion as su ON su.id_su=movimiento_stock_ubicacion.id_destino";
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen  AND movimiento_producto.proceso='AJ'  GROUP BY movimiento_stock_ubicacion.id_mov_prod";

$columns = array(
  array( 'db' => 'movimiento_producto.id_movimiento',  'dt' => 0, 'field' => 'id_movimiento'),
  array( 'db' => 'movimiento_producto.fecha', 'dt' => 1, 'field' => 'fecha'),
  array( 'db' => 'movimiento_producto.hora', 'dt' => 2, 'field' => 'hora'),
  array( 'db' => 'movimiento_producto.concepto',   'dt' => 3, 'field' => 'concepto'),
  array( 'db' => 'usuario.nombre',   'dt' => 4, 'field' => 'nombre'),
  array( 'db' => 'movimiento_producto.correlativo',   'dt' => 5, 'field' => 'correlativo'),
  array( 'db' => 'movimiento_producto.id_movimiento','dt' => 6,
  'formatter' => function( $id_movimiento, $row ){

    $sql=_query("SELECT * FROM movimiento_producto WHERE movimiento_producto.id_movimiento=$id_movimiento");
    $row=_fetch_array($sql);
    $tipo=$row['proceso'];

    $menudrop="<div class='btn-group'>";
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];

    $filename='reporte_ajuste.php';
    $link=permission_usr($id_user,$filename);
    if ($link!='NOT' || $admin=='1' ){
      $menudrop.= "<a  href='reporte_ajuste.php?id_movimiento=".$id_movimiento."' target='_blank'><button type='button' class='btn btn-primary' name='button'><i class=\"fa fa-print\"></i> Reporte Ajuste</button> </a>";
      }


          $menudrop.="
          </div>";
          return $menudrop;}, 'field' => 'id_movimiento')
        );
        echo json_encode(
          SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        ?>
