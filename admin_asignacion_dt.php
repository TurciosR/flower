<?php
include ("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php' );
// DB table to use
$table = 'stock_ubicacion';

$origen=$_REQUEST['origen'];
/*
$hostname = "localhost";
$username = "libreria";
$password = "L1br3r1@18";
$dbname
*/
// Table's primary key
$primaryKey = 'id_su';
// MySQL server connection information
$sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
);
$joinQuery=" FROM stock_ubicacion JOIN producto ON stock_ubicacion.id_producto=producto.id_producto  JOIN ubicacion ON ubicacion.id_ubicacion=stock_ubicacion.id_ubicacion LEFT JOIN estante ON estante.id_estante=stock_ubicacion.id_estante LEFT JOIN posicion ON posicion.id_posicion=stock_ubicacion.id_posicion";
$extraWhere="  stock_ubicacion.id_ubicacion=$origen  AND stock_ubicacion.id_estante!=0  AND stock_ubicacion.cantidad!=0";

$columns = array(
  array( 'db' => 'producto.id_producto',  'dt' => 0, 'field' => 'id_producto'),
  array( 'db' => 'producto.descripcion', 'dt' => 1, 'field' => 'descripcion'),
  array( 'db' => 'stock_ubicacion.cantidad',   'dt' => 2,
  'formatter' => function( $cantidad, $row ){
    return round($cantidad,2);
    }, 'field' => 'cantidad'),
  array( 'db' => 'ubicacion.descripcion as ubicacion',   'dt' => 3, 'field' => 'ubicacion'),
  array( 'db' => 'estante.descripcion as estante',   'dt' => 4,
  'formatter' => function( $estante, $row ){
      if ($estante==NULL) {
        # code...
        return "No asignado";
      }
      else {
        # code...
        return $estante;
      }
    },
   'field' => 'estante'),
  array( 'db' => 'posicion.posicion',   'dt' => 5,
    'formatter' => function( $posicion, $row ){
      if ($posicion==NULL) {
        # code...
        return "No asignado";
      }
      else {
        # code...
        return $posicion;
      }
    },'field' => 'posicion'),
  array( 'db' => 'stock_ubicacion.id_su','dt' => 6,
  'formatter' => function( $id_producto, $row ){

    $menudrop="<div class='btn-group'>
    <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
    <ul class='dropdown-menu dropdown-primary'>";
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];

    $sql_a=_fetch_array(_query("SELECT id_producto,cantidad FROM stock_ubicacion where id_su=$id_producto"));

    $filename='agregar_reasignacion.php';
    $link=permission_usr($id_user,$filename);
    if ($link!='NOT' || $admin=='1' ){
      $menudrop.="<li><a id_su=".$id_producto." id_producto=$sql_a[id_producto] cantidad=$sql_a[cantidad] class='re'><i class=\"fa fa-pencil\"></i> Reasignar</a></li>";
      }


          $menudrop.="</ul>
          </div>";
          return $menudrop;}, 'field' => 'id_su')
        );
        echo json_encode(
          SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );
        ?>
