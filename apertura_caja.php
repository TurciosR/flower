<?php
include_once "_core.php";
function initial()
{
    $title = 'Apertura de Caja';
	$_PAGE = array ();
	$_PAGE ['title'] = $title;
	$_PAGE ['links'] = null;
	$_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/jqGrid/ui.jqgrid.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
	$_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

	include_once "header.php";
	include_once "main_menu.php";
	//permiso del script
    date_default_timezone_set('America/El_Salvador');
  $caja=0;
  if (isset($_REQUEST["id_caja"])) {
    // code...
    $caja = $_REQUEST["id_caja"];
  }

  $id_sucursal = $_SESSION["id_sucursal"];
	$id_user=$_SESSION["id_usuario"];
	$admin=$_SESSION["admin"];
	$uri = $_SERVER['SCRIPT_NAME'];
	$filename=get_name_script($uri);
	$links=permission_usr($id_user,$filename);
    $fecha_actual = date('Y-m-d');
    $sql_apertura = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND id_empleado = '$id_user' AND fecha = '$fecha_actual'");

    $cuenta_apertura = _num_rows($sql_apertura);

    if($cuenta_apertura == 0)
    {



?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <?php
    	   		  //permiso del script
        			if ($links!='NOT' || $admin=='1' ){
    			?>
                <div class="ibox-title">
                    <h5><?php echo $title; ?></h5>
                </div>
                <div class="ibox-content">
                    <form name="formulario" id="formulario">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-info single-line">
                                    <label>Fecha <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="fecha" name="fecha"
                                        value="<?php echo date('Y-m-d');?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-info single-line">
                                    <label>Monto Apertura <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control numeric" id="monto_apertura"
                                        name="monto_apertura">
                                </div>
                            </div>
                            <div hidden class="col-md-6">
                                <div class="form-group has-info single-line">
                                    <label>Empleado <span style="color:red;">*</span></label>
                                    <?php
                                          if($admin != 1)
                                            {
                                              $sql_empleado = _query("SELECT empleado.* FROM empleado,usuario WHERE usuario.id_empleado = empleado.id_empleado AND  usuario.id_usuario='$id_user'");
                                              $cuen = _num_rows($sql_empleado);
                                              $row_empleado = _fetch_array($sql_empleado);

                                              $id_usuario = $id_user;
                                              $nombre = $row_empleado["nombre"];
                                              echo "<input type='text' class='form-control' id='empleado_text' name='empleado_text' value='".$nombre."' readOnly>";
                                              echo "<input type='hidden' class='form-control' id='empleado' name='empleado' value='".$id_usuario."'>";
                                            }
                                            else
                                            {
                                              $sql_empleado = _query("SELECT * FROM empleado,usuario WHERE usuario.id_empleado = empleado.id_empleado AND empleado.id_tipo_empleado = 3");
                                              $cuen = _num_rows($sql_empleado);

                                              echo "<select class='form-control select' id='empleado' name='empleado'>";
                                              echo "<option value='".$id_user."'>".$_SESSION["nombre"]."</option>";
                                              while ($row_empleado = _fetch_array($sql_empleado))
                                              {
                                                $id_usuario = $row_empleado["id_usuario"];
                                                $nombre = $row_empleado["nombre"];
                                                echo "<option value='".$id_usuario."'>".$nombre."</option>";
                                              }

                                              echo "</select>";
                                            }


                                        ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div hidden class="col-md-6">
                                <div class="form-group has-info single-line">
                                    <label>Caja <span style="color:red;">*</span></label>
                                    <select class="form-control select" id="caja" name="caja">
                                        <option value=''>Seleccione</option>
                                        <?php
                                         $qsucursal=_query("SELECT * FROM caja WHERE id_sucursal = '$id_sucursal' AND activa = 1 ORDER BY id_caja ASC ");
                                         while($row_caja =_fetch_array($qsucursal))
                                         {
                                             $id_caja=$row_caja["id_caja"];
                                             $sql_consulta = _query("SELECT * FROM apertura_caja WHERE caja = '$id_caja' AND vigente = 1");
                                             $cuenta = _num_rows($sql_consulta);
                                             $nombre_caja=$row_caja["nombre"];
                                             if($cuenta == 0)
                                             {
                                               echo "
                                               <option value='".$id_caja."'";
                                               if($caja == $id_caja)
                                               {
                                                 echo "selected";
                                               }
                                               echo ">".$nombre_caja."</option>
                                               ";
                                             }

                                         }
                                         ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div hidden class="row">
                            <div class="col-md-6">
                                <div class="form-group has-info single-line">
                                    <label>Monto Caja Chica <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control numeric" id="monto_ch" name="monto_ch">
                                </div>
                            </div>
                        </div>
                        <?php
                            $fecha_i = date('Y-m-d');
                            $sql_turno = _query("SELECT * FROM apertura_caja WHERE fecha = '$fecha_i' AND id_sucursal='$id_sucursal' ORDER BY id_apertura DESC LIMIT 1");
                            $cuenta_turno = _num_rows($sql_turno);
                            if($cuenta_turno > 0)
                            {
                                $row_ap = _fetch_array($sql_turno);
                                $turno_ap = $row_ap['turno'];
                                $sigue_turno = $turno_ap + 1;
                                echo "<input type='hidden' class='form-control' id='turno' name='turno' value='".$sigue_turno."'>";
                            }
                            else
                            {
                                echo "<input type='hidden' class='form-control' id='turno' name='turno' value='1'>";
                            }
                        ?>
                        <input type="hidden" name="process" id="process" value="insert"><br>
                        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal;?>"><br>
                        <div>
                            <input type="submit" id="submit1" name="submit1" value="Guardar"
                                class="btn btn-primary m-t-n-xs" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

	} //permiso del script
    else
    {
    		echo "<div></div><br><br><div class='alert alert-warning'>Ya hay una apertura de caja vigente. Por favor realize el corte de caja</div>";
    }
    include_once ("footer.php");
    echo "<script src='js/funciones/funciones_apertura.js'></script>";
}
function apertura()
{
    date_default_timezone_set('America/El_Salvador');
    $fecha = $_POST["fecha"];
    $empleado = $_POST["empleado"];
    $turno = $_POST["turno"];
    $monto_apertura = $_POST["monto_apertura"];
    $id_sucursal = $_POST["id_sucursal"];
    $hora_actual = date('H:i:s');
    $caja = $_POST["caja"];
    $monto_ch = $_POST["monto_ch"];
    if($monto_ch == ""){
        $monto_ch = 0;
    }
    $tabla = "apertura_caja";

    $turno_real = 1;
    $fecha_i = date('Y-m-d');
    $sql_turno = _query("SELECT * FROM apertura_caja WHERE fecha = '$fecha_i' AND id_sucursal='$id_sucursal' AND caja = '$caja' ORDER BY id_apertura DESC LIMIT 1");
    $cuenta_turno = _num_rows($sql_turno);
    if($cuenta_turno > 0)
    {
        $row_ap = _fetch_array($sql_turno);
        $turno_ap = $row_ap['turno'];
        $turno_real = $turno_ap + 1;

    }
    else
    {
        $turno_real = 1;
    }
    $form_data = array(
        'fecha' => $fecha,
        'id_empleado' => $empleado,
        'turno' => $turno_real,
        'monto_apertura' => $monto_apertura,
        'vigente' => 1,
        'id_sucursal' => $id_sucursal,
        'hora' => $hora_actual,
        'turno_vigente' => 1,
        'caja' => $caja,
        'monto_ch' => $monto_ch,
        'monto_ch_actual' => $monto_ch,
        'id_server' => 0,
        'tiket_inicia' => '0',
        'factura_inicia' => '0',
        'credito_fiscal_inicia' => '0',
        'dev_inicia' => '0',
        'monto_vendido' => '0',

    );
    $sql_caja = _query("SELECT * FROM apertura_caja WHERE vigente = 1 AND id_sucursal = '$id_sucursal' AND caja = '$caja'");
    $cuenta1 = _num_rows($sql_caja);
    if($cuenta1 == 0)
    {
        $insertar = _insert($tabla, $form_data);
        if($insertar)
        {
            $id_apertura = _insert_id();
            $tabla1 = "detalle_apertura";
            $form_data1 = array(
                'id_apertura' => $id_apertura,
                'turno' => $turno_real,
                'id_usuario' => $empleado,
                'fecha' => $fecha,
                'hora' => $hora_actual,
                'vigente' => 1,
                'caja' => $caja,
                'id_server' => '0',
                'id_sucursal' => $id_sucursal
            );
            $insert_de = _insert($tabla1,$form_data1);
            if($insert_de)
            {
                $xdatos['typeinfo']='Success';
                $xdatos['msg']='Apertura de caja realizada correctamente !';
                $xdatos['process']='insert';
            }
            else
            {
                $xdatos['typeinfo']='Error';
                $xdatos['msg']='Fallo agregar el turno!'._error();
            }
        }
        else
        {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='La a pertura no se pudo realizar!'._error();
        }
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Ya existe una apertura de caja vigente en esta caja!';
    }
    echo json_encode($xdatos);
}
function apertura_turno()
{
    date_default_timezone_set('America/El_Salvador');
    $fecha = date("Y-m-d");
    $hora_actual = date('H:i:s');
    $id_apertura = $_POST["id_apertura"];
    $id_detalle = $_POST["id_detalle"];
    $emp = $_SESSION["id_usuario"];

    $sql_com = _query("SELECT * FROM detalle_apertura WHERE id_detalle = '$id_detalle'");
    $cuenta =_num_rows($sql_com);
    if($cuenta == 1)
    {
        $tabla = "detalle_apertura";
        $form_data = array(
            'id_usuario' => $emp,
            );

        $where_d = "id_detalle='".$id_detalle."'";
        $update_d = _update($tabla, $form_data, $where_d);

        $tabla = "apertura_caja";
        $form_data = array(
            'id_empleado' => $emp,
            );

        $where_d = "id_apertura='".$id_apertura."'";
        $update_d = _update($tabla, $form_data, $where_d);

        if($update_d)
        {
            $xdatos['typeinfo']='Success';
            $xdatos['msg']='Turno agregado correctamente!';
            $xdatos['process']='insert';
        }
        else
        {
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='Fallo al agregar el turno!'._error();
        }
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='No existe un turno para asignar!'._error();
    }
    echo json_encode($xdatos);
}

function cerrar_turno()
{
    date_default_timezone_set('America/El_Salvador');
    $fecha = date("Y-m-d");
    $hora_actual = date('H:i:s');
    $id_apertura = $_POST["id_apertura"];
    $sql_turno = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' ORDER BY turno DESC LIMIT 1");
    $row_turno = _fetch_array($sql_turno);
    $tuno = $row_turno["turno"];
    $id_usuario = $row_turno["id_usuario"];

    $sql_turno = _query("SELECT * FROM detalle_apertura WHERE id_apertura = '$id_apertura' AND vigente = 1 ");
    $row_turno = _fetch_array($sql_turno);
    $id_detalle = $row_turno["id_detalle"];
    //echo "ok";
    $n_tuno = $tuno + 1;
    $tabla = "detalle_apertura";
    $form_data = array(
        'vigente' => 0
        );
    $where_up = "id_detalle='".$id_detalle."'";
    $update = _update($tabla, $form_data, $where_up);
    if($update)
    {
        $tabla1 = "detalle_apertura";
        $form_data1 = array(
            'id_apertura' => $id_apertura,
            'turno' => $n_tuno,
            'fecha' => $fecha,
            'hora' => $hora_actual,
            'vigente' => 1
            );
        $insert = _insert($tabla1, $form_data1);
        if($insert)
        {
            $tabla1 = "apertura_caja";
            $form_data1 = array(
                'turno' => $n_tuno,
                'turno_vigente' => 1,
                );
            $where_up = "id_apertura='".$id_apertura."'";
            $update1 = _update($tabla1, $form_data1, $where_up);
            if($update1)
            {
                $xdatos['typeinfo']='Success';
                $xdatos['msg']='Turno agregado correctamente!';
                $xdatos['process']='insert';
            }
        }
    }
    else
    {
        $xdatos['typeinfo']='Error';
        $xdatos['msg']='Fallo al agregar el turno!'._error();
    }

  echo json_encode($xdatos);
}

if(!isset($_POST['process']))
{
	initial();
}
else
{
    if(isset($_POST['process']))
    {
        switch ($_POST['process'])
        {
        	case 'insert':
                apertura();
                break;
            case 'apertura_turno':
                apertura_turno();
                break;
            case 'cerrar_turno':
                cerrar_turno();
                break;
        }
    }
}
?>