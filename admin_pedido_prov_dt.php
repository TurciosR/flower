<?php
include ("_core.php");
$requestData= $_REQUEST;
$fini= $_REQUEST["fini"];
$fin= $_REQUEST["fin"];
require('ssp.customized.class.php' );
// DB table to use
$table= 'pedido_prov';
/*
SELECT id_empleado_reloj,id_persona,horario_numero,descripcion FROM horario_individual
WHERE id_empleado_reloj=1
GROUP BY id_empleado_reloj,id_persona,horario_numero
*/
// Table's primary key
$primaryKey = 'id_pedido_prov';
// MySQL server connection information
$sql_details = array(
  'user' => $username,
  'pass' =>$password,
  'db'   => $dbname,
  'host' => $hostname
);
$id_sucur=$_SESSION["id_sucursal"];
$joinQuery=" FROM pedido_prov
JOIN proveedor ON (pedido_prov.id_proveedor=proveedor.id_proveedor)
JOIN usuario ON (pedido_prov.id_empleado_proceso=usuario.id_usuario)";
if($fini!="" AND $fin!="")
{
  $extraWhere=" pedido_prov.fecha BETWEEN '$fini' AND '$fin' AND pedido_prov.id_sucursal='$id_sucur'";
}
else
{
  $extraWhere=" pedido_prov.id_sucursal='$id_sucur'";
}
$columns = array(
  array( 'db' => 'pedido_prov.numero', 'dt' => 0, 'field' => 'numero' ),
  array( 'db' => 'DATE_FORMAT(pedido_prov.fecha,"%d-%m-%Y")', 'dt' => 1, 'field' => 'fecha', 'as' => 'fecha' ),
  array( 'db' => 'DATE_FORMAT(pedido_prov.fecha_entrega,"%d-%m-%Y")', 'dt' => 2, 'field' => 'fecha_entrega', 'as' => 'fecha_entrega' ),
  array( 'db' => 'proveedor.nombre as nombrep', 'dt' => 3, 'field' => 'nombrep', 'as', 'proveedor'),
  array( 'db' => 'usuario.nombre', 'dt' => 4, 'field' => 'nombre', 'as', 'usuario' ),
  array( 'db' => 'CONCAT("$",FORMAT(pedido_prov.total,2))', 'dt' => 5, 'field' => 'total', 'as' => 'total' ),
  array( 'db' => 'pedido_prov.id_pedido_prov','dt' => 6,
  'formatter' => function( $id_pedido_prov, $row ){
    $menudrop="<div class='btn-group'>
    <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
    <ul class='dropdown-menu dropdown-primary'>";
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];
    $filename='editar_pedido_prov.php';
    $sql = _query("SELECT estado FROM pedido_prov WHERE id_pedido_prov='$id_pedido_prov'");
    $datosp = _fetch_array($sql);
    $filename='borrar_pedido_prov.php';
    $link=permission_usr($id_user,$filename);
    if ($link!='NOT' || $admin=='1')
    {
      $menudrop.="<li><a data-toggle='modal' href='$filename?id_pedido_prov=".$row['id_pedido_prov']."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Borrar</a></li>";
    }
    $filename='editar_pedido_prov.php';
    $link=permission_usr($id_user,$filename);
    if ($link!='NOT' || $admin=='1')
    {
      $menudrop.="<li><a href='$filename?id_pedido_prov=".$row['id_pedido_prov']."'><i class=\"fa fa-pencil\"></i> Editar</a></li>";
    }
    $filename='reporte_pedido_prov.php';
    $link=permission_usr($id_user,$filename);
    if ($link!='NOT' || $admin=='1')
    {
      $menudrop.="<li><a  href='$filename?id_pedido_prov=" .$row ['id_pedido_prov']."' target='_blank'><i class='fa fa-reorder'></i> Reporte</a></li>";
    }
    $menudrop.="</ul>
      </div>";
      return $menudrop;}, 'field' => 'id_pedido_prov')

      );
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
      );
      ?>
