<?php
    include("_core.php");

    $requestData= $_REQUEST;
    $fechai= MD($_REQUEST['fechai']);
    $fechaf= MD($_REQUEST['fechaf']);
    $id_proveedor= $_REQUEST['id_proveedor'];

    require('ssp.customized.class.php');
    // DB table to use
    $table = 'cuenta_pagar';
    // Table's primary key
    $primaryKey = 'id_cuenta_pagar';

    // MySQL server connection information
    $sql_details = array(
  'user' => $username,
  'pass' => $password,
  'db'   => $dbname,
  'host' => $hostname
  );
  /*
    <th>Id factura</th>
    <th>Tipo Doc</th>
    <th>Numero Doc</th>
    <th>Proveedor</th>
    <th>Empleado</th>
    <th>Total</th>
    <th>Fecha Doc</th>
    <th>Fecha Vence</th>
    <th>Estado</th>
    */
    //permiso del script
    $id_user=$_SESSION["id_usuario"];
    $admin=$_SESSION["admin"];
    $uri = $_SERVER['SCRIPT_NAME'];
    $filename=get_name_script($uri);
    $links=permission_usr($id_user, $filename);

    $id_sucursal=$_SESSION['id_sucursal'];

    $joinQuery = "
	FROM  cuenta_pagar
	JOIN proveedor AS pro ON (cuenta_pagar.id_proveedor = pro.id_proveedor)
	";
    $extraWhere = "cuenta_pagar.id_sucursal='$id_sucursal' AND pro.id_proveedor=$id_proveedor
	AND cuenta_pagar.fecha BETWEEN '$fechai' AND '$fechaf'";
    //$extraWhere = "";
    $columns = array(
    array( 'db' => '`cuenta_pagar`.`id_cuenta_pagar`', 'dt' => 0, 'field' => 'id_cuenta_pagar' ),
    array( 'db' => '`cuenta_pagar`.`fecha`', 'dt' =>1, 'field' => 'fecha' ),
    array( 'db' => '`cuenta_pagar`.`alias_tipodoc`', 'dt' => 2, 'field' => 'alias_tipodoc' ),
    array( 'db' => '`cuenta_pagar`.`numero_doc`', 'dt' => 3, 'field' => 'numero_doc' ),
    array( 'db' => '`cuenta_pagar`.`monto`', 'dt' =>4, 'field' => 'monto' ),
    array( 'db' => '`cuenta_pagar`.`saldo_pend`', 'dt' =>5, 'field' => 'saldo_pend' ),
    array( 'db' => '`cuenta_pagar`.`fecha_vence`', 'dt' =>6, 'field' => 'fecha_vence' ),
    array( 'db' => '`cuenta_pagar`.`id_cuenta_pagar`', 'dt' => 7, 'formatter' => function ($idtransace, $row) {
        $txt_estado=estado($idtransace);
        return $txt_estado;
    },'field' => 'id_cuenta_pagar'),
    array( 'db' => '`cuenta_pagar`.`id_cuenta_pagar`', 'dt' => 8, 'formatter' => function ($id_cuenta, $row) {
      //echo $id_cuenta."#";
            $menudrop="<a class='edit_row btn btn-success'  id_cuenta=".$id_cuenta.">Abonar</a>";
            return $menudrop;
        },'field' => 'id_cuenta_pagar' ),
    /*array( 'db' => '`cxp`.`idtransace`', 'dt' => 8, 'formatter' => function ($idtransace, $row) {
      /*  $menudrop="<div class='btn-group'>
			<a href='#' data-toggle='dropdown' class='btn btn-primary dropdown-toggle'><i class='fa fa-user icon-white'></i> Menu<span class='caret'></span></a>
			<ul class='dropdown-menu dropdown-primary'>";

        /*$sql="SELECT id_compras FROM cxp where idtransace='$idtransace'";
        $result=_query($sql);
        $count=_num_rows($result);
        $row=_fetch_array($result);
        $id_compras=$row['id_compras'];
        $id_user=$_SESSION["id_usuario"];
        $id_sucursal=$_SESSION["id_sucursal"];
        $admin=$_SESSION["admin"];

        /*$filename='abono_cxp.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            $menudrop.="<li><a data-toggle='modal' href='$filename?idtransace=$idtransace&id_sucursal=$id_sucursal'  data-target='#viewModal' data-refresh='true'><i class=\"fa fa-money\"></i> Ver Abonos</a></li>";
        }
        /*$filename='descontar.php';
        $link=permission_usr($id_user, $filename);
        if ($link!='NOT' || $admin=='1') {
            $menudrop.="<li><a data-toggle='modal' href='$filename?idtransace=$idtransace&id_sucursal=$id_sucursal'  data-target='#viewModal' data-refresh='true'><i class=\"fa fa-money\"></i>  Descontar</a></li>";
        }
        //Reimprimir factura

      /*  $filename='print_bcode_compras.php';
        $link=permission_usr($id_user,$filename);
        if ($link!='NOT' || $admin=='1' ){
            if($finalizada==1)
                $menudrop.="<li><a data-toggle='modal' href='$filename?idtransace=$idtransace&id_sucursal=$id_sucursal' data-target='#viewModalFact' data-refresh='true'><i class=\"fa fa-print\"></i> Reimprimir</a></li>";
        }

        $menudrop.="</ul>
						</div>";
        return $menudrop;
    },
        'field' => 'idtransace' ),*/

    );
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
    );
function estado($idtransace)
{
    $id_sucursal=$_SESSION["id_sucursal"];
    $sql="SELECT saldo_pend FROM cuenta_pagar WHERE id_cuenta_pagar='$idtransace'";


    $result=_query($sql);
    $count=_num_rows($result);
    $row=_fetch_array($result);

    $saldo=$row['saldo_pend'];
    $txt_estado="";
    if ($saldo>0) {
        $txt_estado="<h5 class='text-warning'>".'PENDIENTE'."</h5>";
    } else {
        $txt_estado="<h5 class='text-success'>".'FINALIZADA'."</h5>";
    }

    return $txt_estado;
}
