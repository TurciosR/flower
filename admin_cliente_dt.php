<?php
include("_core.php");
/*
SELECT movimientos.id_movimiento,movimientos.fecha,movimientos.hora,usuario.nombre,movimientos.concepto,movimientos.total,SUM(movimiento_producto.entrada) as entrada,SUM(mp.salida) AS salida FROM movimientos JOIN usuario ON usuario.id_usuario=movimientos.id_usuario JOIN movimiento_producto ON movimiento_producto.id_movimiento=movimientos.id_movimiento JOIN movimiento_producto as mp ON mp.id_movimiento=movimientos.id_movimiento GROUP BY movimiento_producto.id_movimiento
*/

$requestData= $_REQUEST;

require('ssp.customized.class.php');
// DB table to use
$table = 'cliente';
// Table's primary key
$primaryKey = 'id_cliente';

// MySQL server connection information
$sql_details = array(
    'user' => $username,
    'pass' => $password,
    'db'   => $dbname,
    'host' => $hostname
);

//permiso del script
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user, $filename);

$id_sucursal=$_SESSION['id_sucursal'];

$joinQuery = "FROM cliente";
$extraWhere = "id_sucursal='$id_sucursal'";
$columns = array(
    array( 'db' => 'cliente.id_cliente', 'dt' => 0, 'field' => 'id_cliente' ),
    array( 'db' => 'cliente.nombre', 'dt' => 1, 'field' => 'nombre' ),
    array( 'db' => 'cliente.nit', 'dt' => 2, 'field' => 'nit'),
    array( 'db' => 'cliente.nrc', 'dt' => 3, 'field' => 'nrc'),

    //array( 'db' => 'cliente.nrc', 'dt' => 4, 'field' => 'nrc'),
		array( 'db' => ' IF(cliente.telefono1!="", IF(cliente.telefono2!="",CONCAT(cliente.telefono1," ; ",cliente.telefono2),cliente.telefono1),IF(cliente.telefono2!="",cliente.telefono2,""))', 'as' => 'telefono','dt' => 4, 'field' => 'telefono' ),
    array( 'db' => 'cliente.id_cliente', 'dt' => 5, 'formatter' => function ($id_movimiento, $row) {
        $menudrop="<div class='btn-group'>
		<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
		<ul class='dropdown-menu dropdown-primary'>";
        include("_core.php");
        $id_user=$_SESSION["id_usuario"];
        $id_sucursal=$_SESSION['id_sucursal'];
        $admin=$_SESSION["admin"];
        $filename='editar_cliente.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            $menudrop.="<li><a href=\"editar_cliente.php?id_cliente=".$row['id_cliente']."\"><i class=\"fa fa-pencil\"></i> Editar</a></li>";
        }
        $filename='borrar_cliente.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            //$menudrop.= "<li><a data-toggle='modal' href='borrar_cliente.php?id_cliente=" .  $row ['id_cliente']."&process=formDelete"."' data-target='#deleteModal' data-refresh='true'><i class=\"fa fa-eraser\"></i> Eliminar</a></li>";
        }
        $filename='ver_cliente.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            $menudrop.= "<li><a data-toggle='modal' href='ver_cliente.php?id_cliente=".$row['id_cliente']."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
        }

        $menudrop.="</ul>
					</div>";
        return $menudrop;
    },
	    'field' => 'id_cliente' ),
	);
	//echo json_encode(
	//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
	echo json_encode(
	    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
	);
