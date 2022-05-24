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
$joinQuery="  FROM movimiento_producto JOIN movimiento_stock_ubicacion ON  movimiento_stock_ubicacion.id_mov_prod=movimiento_producto.id_movimiento LEFT JOIN stock_ubicacion ON stock_ubicacion.id_su=movimiento_stock_ubicacion.id_origen LEFT JOIN stock_ubicacion as su ON su.id_su=movimiento_stock_ubicacion.id_destino";

$extraWhere="";
if ($pro=="gen") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen OR su.id_ubicacion=$origen GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="ing") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND su.id_ubicacion=$origen AND movimiento_producto.proceso='II' AND movimiento_producto.id_compra=0  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="des") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen AND movimiento_producto.proceso='DI'  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="com") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND su.id_ubicacion=$origen AND movimiento_producto.id_compra!=0  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="asig") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen AND movimiento_producto.proceso='AI'  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="trans") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen AND movimiento_producto.proceso='TI'  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}
if ($pro=="ajus") {
  # code...
  $extraWhere="  movimiento_producto.id_sucursal=$_SESSION[id_sucursal] AND stock_ubicacion.id_ubicacion=$origen  AND movimiento_producto.proceso='AJ'  GROUP BY movimiento_stock_ubicacion.id_mov_prod";
}

$columns = array(
  array( 'db' => 'movimiento_producto.id_movimiento',  'dt' => 0, 'field' => 'id_movimiento'),
  array( 'db' => 'movimiento_producto.fecha', 'dt' => 1, 'field' => 'fecha'),
  array( 'db' => 'movimiento_producto.concepto',   'dt' => 2, 'field' => 'concepto'),
  array( 'db' => 'movimiento_producto.tipo',   'dt' => 3, 'field' => 'tipo'),
  array( 'db' => 'movimiento_producto.correlativo',   'dt' => 4, 'field' => 'correlativo'),
  array( 'db' => 'movimiento_producto.id_movimiento','dt' => 5,
  'formatter' => function( $id_movimiento, $row ){

    $sql=_fetch_array(_query("SELECT SUM(movimiento_stock_ubicacion.anulada) as ANULADA FROM movimiento_stock_ubicacion WHERE movimiento_stock_ubicacion.id_mov_prod=$id_movimiento"));
    $sum=$sql['ANULADA'];
    $val="";
    if ($sum==0) {
      $val="<strong class='text-success'>FINALIZADA</strong>";
    }
    else {
      $val="<strong class='text-danger'>ANULADA</strong>";
    }
          return $val;}, 'field' => 'id_movimiento'),
  array( 'db' => 'movimiento_producto.id_movimiento','dt' => 6,
  'formatter' => function( $id_movimiento, $row ){

    $sql=_query("SELECT * FROM movimiento_producto WHERE movimiento_producto.id_movimiento=$id_movimiento");
    $row=_fetch_array($sql);
    $tipo=$row['proceso'];

    $menudrop="<div class='btn-group'>
    <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
    <ul class='dropdown-menu dropdown-primary'>";
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];

        $filename='ver_detalle_mov.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
          $menudrop.= "<li><a data-toggle='modal' href='ver_detalle_mov.php?id_movimiento=".$id_movimiento."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
          }

        $sql=_fetch_array(_query("SELECT SUM(movimiento_stock_ubicacion.anulada) as ANULADA FROM movimiento_stock_ubicacion WHERE movimiento_stock_ubicacion.id_mov_prod=$id_movimiento"));
        $sum=$sql['ANULADA'];
        $val="";
        if ($sum==0&&$tipo=="TI") {

          /*$filename='anular_transferencia.php';
          $link=permission_usr($id_user,$filename);
          if ($link!='NOT' || $admin=='1' ){
            $menudrop.= "<li><a data-toggle='modal' href='anular_transferencia.php?id_movimiento=".$id_movimiento."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Anular</a></li>";
            }*/
        }

        if ($tipo=="AJ") {

          $filename='reporte_ajuste.php';
          $link=permission_usr($id_user,$filename);
          if ($link!='NOT' || $admin=='1' ){
            $menudrop.= "<li><a  href='reporte_ajuste.php?id_movimiento=".$id_movimiento."' target='_blank' ><i class=\"fa fa-check\"></i> Reporte Ajuste</a></li>";
            }
        }

          $menudrop.="</ul>
          </div>";
          return $menudrop;}, 'field' => 'id_movimiento')
        );
        echo json_encode(
          SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        ?>
