<?php
include("_core.php");

$requestData= $_REQUEST;
$fechai= $_REQUEST['fechai'];
$fechaf= $_REQUEST['fechaf'];
$id_sucursal=$_SESSION['id_sucursal'];
$id_user=$_SESSION['id_usuario'];

$sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'  AND id_empleado='$id_user'");

$cuenta = _num_rows($sql_apertura);

$turno_vigente=0;
if($cuenta>0)
{
  $row_apertura = _fetch_array($sql_apertura);
  $id_apertura = $row_apertura["id_apertura"];
  $turno = $row_apertura["turno"];
  $fecha_apertura = $row_apertura["fecha"];
  $hora_apertura = $row_apertura["hora"];
  $turno_vigente = $row_apertura["turno_vigente"];
}
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
$joinQuery ="  FROM credito LEFT JOIN cliente ON cliente.id_cliente=credito.id_cliente";
$extraWhere = " credito.fecha BETWEEN '$fechai' AND '$fechaf' ";/*	AND credito.fecha BETWEEN '$fechai' AND '$fechaf' */
$columns = array(
  array( 'db' => '`credito`.`id_credito`', 'dt' => 0, 'field' => 'id_credito' ),
  array( 'db' => '`credito`.`fecha`', 'dt' =>1, 'field' => 'fecha' ),
  array( 'db' => '`cliente`.`nombre`', 'dt' => 2, 'field' => 'nombre'),
  array( 'db' => '`credito`.`tipo_doc`', 'dt' =>3, 'field' => 'tipo_doc' ),
  array( 'db' => '`credito`.`numero_doc`', 'dt' =>4, 'field' => 'numero_doc' ),
  array( 'db' => '`credito`.`total`', 'dt' =>5, 'field' => 'total' ),
  array( 'db' => '`credito`.`abono`', 'dt' =>6, 'field' => 'abono' ),
  array( 'db' => '`credito`.`saldo`', 'dt' =>7, 'field' => 'saldo' ),
  array( 'db' => '`credito`.`id_credito`', 'dt' => 8, 'formatter' => function ($id_credito, $row) {
    $txt_estado=estado($id_credito);
    return $txt_estado;
    },
    'field' => 'id_credito'),
    array( 'db' => '`credito`.`id_credito`', 'dt' => 9, 'formatter' => function ($id_credito, $row) {
      $menudrop="<div class='btn-group'>
      <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
      <ul class='dropdown-menu dropdown-primary'>";
      $admin=$_SESSION["admin"];

      $id_sucursal=$_SESSION['id_sucursal'];
      $id_user=$_SESSION['id_usuario'];
      $sql_cred = _query("SELECT id_factura, numero_doc FROM credito WHERE id_credito='$id_credito'");
      $row_cred = _fetch_array($sql_cred);
      $id_factura = $row_cred["id_factura"];
      $numero_doc = $row_cred["numero_doc"];
      $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal'  AND id_empleado='$id_user'");

      $cuenta = _num_rows($sql_apertura);

      $turno_vigente=0;
      if($cuenta>0)
      {
        $row_apertura = _fetch_array($sql_apertura);
        $id_apertura = $row_apertura["id_apertura"];
        $turno = $row_apertura["turno"];
        $fecha_apertura = $row_apertura["fecha"];
        $hora_apertura = $row_apertura["hora"];
        $turno_vigente = $row_apertura["turno_vigente"];
      }
      if($id_factura > 0)
      {
        $filename='ver_factura.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' )
        {
          $menudrop.="<li><a data-toggle='modal' href='$filename?id_factura=$id_factura&numero_doc=$numero_doc&id_sucursal=$id_sucursal'  data-target='#viewModalFact' data-refresh='true'><i class=\"fa fa-check\"></i> Ver Detalles</a></li>";
        }
      }
      $filename='borrar_credito.php';
      $link=permission_usr($id_user,$filename);
      if ($link!='NOT' || $admin=='1' )
      {
        $menudrop.="<li><a data-toggle='modal' href='$filename?id_credito=$id_credito'  data-target='#viewModal' data-refresh='true'><i class=\"fa fa-trash\"></i> Eliminar</a></li>";
      }
      $filename='abono_credito.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
        if($turno_vigente == 1){
        $menudrop.= "<li><a data-toggle='modal' href='$filename?id_credito=$id_credito&id_sucursal=$id_sucursal' data-target='#viewModal' data-refresh='true' ><i class='fa fa-money'></i> Abonar</a></li>";
        }
      }
        $menudrop.="</ul>
        </div>";
        return $menudrop;
        },
        'field' => 'id_credito' ),

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
        }
        else {
          $txt_estado="<h5 class='text-mutted'>".'FINALIZADA'."</h5>";
        }

        return $txt_estado;
      }
