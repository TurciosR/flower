<?php
include("_core.php");

$requestData= $_REQUEST;
$id_sucursal=$_SESSION['id_sucursal'];
$id_user=$_SESSION['id_usuario'];
$fechai= $_REQUEST['fechai'];
$fechaf= $_REQUEST['fechaf'];

require('ssp.customized.class.php');
// DB table to use
$table = 'credito';
// Table's primary key
$primaryKey = 'id_credito';

// MySQL server connection information
$sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
);
/*SELECT credito.fecha, CONCAT(cliente.nombre,' ',cliente.apellido) AS nombre, credito.num_fact_impresa,credito.total,credito.abono,credito.saldo FROM credito JOIN cliente ON cliente.id_cliente=credito.id_cliente WHERE credito.credito=1 */
//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];
$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user, $filename);

$id_sucursal=$_SESSION['id_sucursal'];
$joinQuery ="  FROM precio_aut left join usuario on usuario.id_usuario = precio_aut.id_usuario";
$extraWhere = "precio_aut.fecha_generado BETWEEN '$fechai' AND '$fechaf'";
$columns = array(
  array( 'db' => '`precio_aut`.`id`', 'dt' => 0, 'field' => 'id' ),

    array( 'db' => '`precio_aut`.`clave`', 'dt' => 1, 'field' => 'clave' ),
  array( 'db' => '`precio_aut`.`fecha_generado`', 'dt' =>2, 'formatter' => function ($fecha_g, $row) {
    $txt_estado=ED($fecha_g);
    return $txt_estado;
    }, 'field' => 'fecha_generado' ),
  array( 'db' => '`precio_aut`.`fecha_aplicado`', 'dt' =>3, 'formatter' => function ($fecha_a, $row) {
    $txt_estado=ED($fecha_a);
    return $txt_estado;
    }, 'field' => 'fecha_aplicado' ),
  array( 'db' => '`usuario`.`nombre`', 'dt' =>4, 'field' => 'nombre' ),
  array( 'db' => '`precio_aut`.`aplicado`', 'dt' =>5, 'formatter' => function ($estado, $row) {
    $txt_estado='';
    if ($estado==0) {
      // code...
      $txt_estado='NO';
    }
    else {
      // code...
      $txt_estado='SI';
    }
    return $txt_estado;
    }, 'field' => 'aplicado' ),

);
echo json_encode(
  SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
function estado($id_credito)
{
  $credito=$id_credito;
  $sql = _fetch_array(_query("SELECT credito.total,credito.abono,credito.saldo FROM credito WHERE credito.id_credito=$credito"));
  $abono=$sql['abono'];
  $saldo=$sql['saldo'];
  $total=$sql['total'];
  $txt_estado="";
  if ($saldo>0&&$abono<$total) {
    # code...
    $txt_estado="<h5 class='text-danger'>".'PENDIENTE'."</h5>";
  } else {
    $txt_estado="<h5 class='text-mutted'>".'FINALIZADA'."</h5>";
  }

  return $txt_estado;
}
