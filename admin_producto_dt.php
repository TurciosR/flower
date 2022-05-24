
<?php
include("_core.php");
$requestData= $_REQUEST;
require('ssp.customized.class.php');
// DB table to use
$table = 'producto';
/*
$hostname = "localhost";
$username = "libreria";
$password = "L1br3r1@18";
$dbname
*/
// Table's primary key
$primaryKey = 'id_producto';
// MySQL server connection information
$sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
);
$joinQuery=" FROM producto as pr left JOIN proveedor as p ON p.id_proveedor=pr.id_proveedor LEFT JOIN categoria as cat ON (pr.id_categoria=cat.id_categoria)";
$extraWhere="";

$columns = array(
  // array( 'db' => '`pr`.`id_producto`', 'dt' => 0, 'field' => 'id_producto'),
  array( 'db' => '`pr`.`id_producto`',   'dt' => 0,
  'formatter' => function ($id_producto, $row) {
      return "<input type='hidden' name='id_producto_active' id='id_producto_active' value='".$id_producto."'>".$id_producto;
    }, 'field' => 'id_producto'),
  array( 'db' => '`pr`.`codart`',  'dt' => 1, 'field' => 'codart'),
  array( 'db' => '`pr`.`barcode`',  'dt' => 2, 'field' => 'barcode'),
  array( 'db' => '`pr`.`descripcion`',   'dt' => 3, 'field' => 'descripcion'),
  array( 'db' => '`cat`.`nombre_cat`',   'dt' => 4, 'field' => 'nombre_cat'),
  array( 'db' => '`p`.`nombre`',   'dt' => 5, 'field' => 'nombre'),
  array( 'db' => '`pr`.`exento`',   'dt' => 6,
  'formatter' => function ($id_producto, $row) {
    if ($id_producto==0) {
      // code...
      return "Gravado";
    }
    else {
      return "Exento";
    }
    }, 'field' => 'exento'),
  array( 'db' => '`pr`.`estado`',   'dt' => 7,
  'formatter' => function ($estado, $row) {
    if ($estado==0) {
      // code...
      return "<label style='color:red'>Inactivo</label><input type='hidden' name='estado' id='estado' value='".$estado."'>";
    }
    else {
      return "<label style='color:blue'>Activo</label><input type='hidden' name='estado' id='estado' value='".$estado."'>";
    }
    }, 'field' => 'estado'),
  array( 'db' => 'id_producto','dt' => 8,
  'formatter' => function ($id_producto, $row) {
      $menudrop="<div class='btn-group'>
    <a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
    <ul class='dropdown-menu dropdown-primary'>";
      $id_user=$_SESSION["id_usuario"];
      $admin=$_SESSION["admin"];

      $sql_p = _query("SELECT * FROM producto WHERE id_producto = '$id_producto'");
      $row_p = _fetch_array($sql_p);
      $estado = $row_p['estado'];
      if($estado == 1)
      {
        $text = "Activa";
        $text1 = "Desactivar";
        $fa = "fa fa-eye-slash";
      }
      else
      {
        $text = "Inactiva";
        $text1 = "Activar";
        $fa = "fa fa-eye";
      }


      $filename='anular_factura.php';
      $link=permission_usr($id_user, $filename);
      $filename='editar_producto.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
          $menudrop.="<li><a href=\"editar_producto.php?id_producto=".$row['id_producto']."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
      }
      $filename='borrar_producto.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
          //$menudrop.="<li><a data-toggle='modal' href='borrar_producto.php?id_producto=" .  $row ['id_producto']."&process=formDelete"."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-eraser\"></i> Eliminar</a></li>";
      }
      $filename='ver_producto.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
          $menudrop.= "<li><a data-toggle='modal' href='ver_producto.php?id_producto=".$row['id_producto']."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
      }
      $filename='estado_producto.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
          $menudrop.= "<li><a id='estado' ><i class='".$fa."'></i> ".$text1."</a></li>";
      }
      /*
      $filename='precio_producto.php';
      $link=permission_usr($id_user, $filename);
      if ($link!='NOT' || $admin=='1') {
          $menudrop.="<li><a href=\"precio_producto.php?id_producto=".$row['id_producto']."\"><i class=\"fa fa-money\"></i> Precios</a></li>";
      }
      */


      $menudrop.="</ul>
          </div>";
      return $menudrop;
  }, 'field' => 'id_producto')
        );
        echo json_encode(
          SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
