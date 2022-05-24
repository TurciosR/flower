<?php
include_once "_core.php";

function initial()
{
  $title = "Traslado de Productos";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';

  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main_co.css">';
$_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util_co.css">';

  include_once "header.php";
  // include_once "main_menu.php";



  $sql="SELECT * FROM producto";

  $result=_query($sql);
  $count=_num_rows($result);
  //permiso del script
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user, $filename);
  $fecha_actual=date("Y-m-d");
  $id_traslado=0;
    if (isset($_REQUEST['id_traslado']))
    {

      $sqlvd=_query("SELECT * FROM traslado_g WHERE id_traslado=$_REQUEST[id_traslado]");
      if (_num_rows($sqlvd)>0) {
        // code...
        $id_traslado=$_REQUEST['id_traslado'];

        $rowtg=_fetch_array($sqlvd);
      }
      else {
        header("location: traslado_producto.php");
      }
    }

  ?>

  <style media="screen">
  /*table {
  width: 100%;
  display:block;
}
thead {
  display: inline-block;
  width: 100%;
}*/
/*
tbody {
  height: 200px;
  display: inline-block;
  width: 100%;
  overflow: auto;
}*/
  </style>

  <div class="gray-bg">
  <div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <h5><?php echo $title;?></h5>
          </div>
          <?php if ($links!='NOT' || $admin=='1') { ?>
            <div class="ibox-content">
              <div class='row' id='form_invent_inicial'>
                <div class="col-lg-3">
                  <div  class="form-group has-info focuss">
                    <label>Concepto</label>
                    <input type='text' class='form-control' value='TRASLADO DE PRODUCTOS' id='concepto' name='concepto'>
                  </div>
                </div>
                <input type="hidden" id="id_tra_g" name="id_tra_g" value="<?php echo $id_traslado ?>">
                <div class="col-lg-3">
                  <div class='form-group has-info'><label>Origen</label>
                    <select name='origen' id="origen" class="form-control select">
                    <?php
                    $id_sucursal=$_SESSION['id_sucursal'];
                    $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                    while($row = _fetch_array($sql))
                    {
                      if ($id_traslado==0) {
                        // code...
                        echo "<option value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
                      }
                      else {
                        // code...

                        if ($row["id_ubicacion"]==$rowtg['id_origen']) {
                          // code...
                          echo "<option selected value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
                        }
                        else {
                          echo "<option value='".$row["id_ubicacion"]."'>".MAYU(utf8_decode($row["descripcion"]))."</option>";
                        }
                      }

                    }
                    ?>
                  </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group has-info">
                    <label>Destino</label>
                    <select class="form-control select" id="id_sucursal" name="id_sucursal">
                      <option value="">Seleccione</option>
                      <?php
                      $sql_suc=_query("SELECT * FROM sucursal WHERE id_sucursal!=$_SESSION[id_sucursal]");
                      while ($row_suc=_fetch_array($sql_suc)) {
                        # code...
                        $sql_suc=_query("SELECT * FROM sucursal WHERE id_sucursal!=$_SESSION[id_sucursal]");
                        while ($row_suc=_fetch_array($sql_suc)) {
                          # code...
                            $sql_su=_fetch_array(_query("SELECT CONCAT('Sucursal ',sucursal.n_sucursal,' ',sucursal.direccion) as destino FROM sucursal WHERE id_sucursal=$row_suc[id_sucursal]"));
                            $a=utf8_decode(Mayu(utf8_decode($sql_su['destino'])));

                            if ($id_traslado==0) {
                              // code...
                              echo "<option value=' $row_suc[id_sucursal]' >".utf8_decode(MAYU(utf8_decode($a)))."</option>";
                            }
                            else {
                              // code...

                              if ($row_suc['id_sucursal']==$rowtg['id_sucursal_destino']) {
                                // code...
                                echo "<option selected value=' $row_suc[id_sucursal]' >".utf8_decode(MAYU(utf8_decode($a)))."</option>";
                              }
                              else {
                                echo "<option value=' $row_suc[id_sucursal]' >".utf8_decode(MAYU(utf8_decode($a)))."</option>";
                              }
                            }


                        }
                        ?>
                        <?php
                      }
                       ?>
                    </select>
                  </div>
                </div>

                <div class='col-lg-3'>
                  <div class='form-group has-info'>
                    <label>Fecha</label>
                    <input type='text' class='datepick form-control' value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                  </div>
                </div>

              </div>
              <div class="row" id='buscador'>



                <div class="col-lg-4">
                  <div class='form-group has-info'><label>Buscar Productos</label>
                    <div id="scrollable-dropdown-menu">
                    <input type="text" id="producto_buscar" name="producto_buscar"  style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese Descripcion de producto" data-provide="typeahead" style="border-radius:0px">
                    </div>
                  </div>
                </div>
                <div class="col-lg-2">
                  <div class='form-group has-info'><label>Nº de vale</label>

                    <input type="text" class="form-control" id="numero_vale" name="numero_vale" value="<?php if ($id_traslado!=0){ echo $rowtg['n_vale'];} {
                      // code...
                    } ?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <input type="hidden" name="process" id="process" value="insert">
                  <br>
                    <button class="btn btn-danger pull-right" style="margin-left:2%;" id='salir'>F4 <i class="fa fa-mail-reply"></i> Salir</button>

                    <button class="btn btn-info pull-right" style="margin-left:2%;" type="button" id="saving_t" name="saving_t">F2 <span class="fa fa-save"></span> Guardar</button>

                    <button id="submit1" name="submit1" class="btn btn-primary  pull-right " >F9 <span class="fa fa-send"></span> ENVIAR</button>

                    <input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename ?> ">

                </div>
              </div>
              <div class="ibox">
                <div class="row">
                  <div class="ibox-content">
                    <!--load datables estructure html-->
                    <header>
                      <h4 class="text-navy">Lista de Productos</h4>
                    </header>


                    <div  class='widget-content' id="content">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="wrap-table1001">
                            <div class="table100 ver1 m-b-10">
                              <div class="table100-head">
                                <table class="table table-striped" id='inventable1'>
                                  <thead class=''>
                                    <tr class='row100 head'>
                                      <th class="text-success col-lg-5">Descripción</th>
                                      <th class="text-success col-lg-1 text-center">Presentación</th>
                                      <th class="text-success col-lg-1 text-center">Detalle</th>
                                      <th class="text-success col-lg-1 text-center">Costo</th>
                                      <th style="display:none;" class="text-success text-center">Precio</th>
                                      <th class="text-success col-lg-1 text-center">Exis Unid.</th>
                                      <th class="text-success col-lg-1 text-center">Cantidad</th>
                                      <th class="text-success col-lg-1 text-center">Subtotal</th>
                                      <th class="text-success col-lg-1 text-center"></th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="table100-body js-pscroll">
                            <table class="table table-striped" id='loadtable'>
                              <tbody class='tbody1 ' id="mostrardatos">
                                <?php
                                if ($id_traslado!=0) {
                                  // code...
                                  $sqldg=_query("SELECT producto.id_producto,producto.descripcion,producto.barcode,traslado_detalle_g.id_presentacion,traslado_detalle_g.cantidad,traslado_detalle_g.costo FROM traslado_detalle_g JOIN producto ON producto.id_producto= traslado_detalle_g.id_producto WHERE id_traslado=$id_traslado ");
                                  while ($rowdf=_fetch_array($sqldg)) {
                                    // code...
                                    $id_producto = $rowdf['id_producto'];
                                    $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$rowtg[id_origen]'");
                                    $dt_existencia = _fetch_array($sql_existencia);
                                    $existencia = round($dt_existencia["existencia"]);
                                    $descripcion=$rowdf["descripcion"];
                                    $barcode = $rowdf['barcode'];
                                    $cost=$rowdf['costo'];
                                    $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio
                                                          FROM presentacion_producto AS prp
                                                          JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion
                                                          WHERE prp.id_producto=$id_producto
                                                          AND prp.activo=1");
                                    $i=0;
                                    $unidadp=0;
                                    $costop=0;
                                    $preciop=0;
                                    $descripcionp="";
                                    $select="<select class='sel'>";
                                    while ($row=_fetch_array($sql_p))
                                    {
                                      if ($row['id_presentacion']==$rowdf["id_presentacion"])
                                      {
                                        $unidadp=$row['unidad'];
                                        $costop=$row['costo'];
                                        $preciop=$row['precio'];
                                        $descripcionp=$row['descripcion'];

                                      }

                                      $ae="";
                                      if ($row['id_presentacion']==$rowdf["id_presentacion"])
                                      {
                                        $ae="selected";
                                      }
                                      $select.="<option $ae  value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
                                      $i=$i+1;
                                    }
                                    $select.="</select>";
                                    $input = "<input type='text' value='".intdiv($rowdf['cantidad'],$unidadp)."' class='cant form-control numeric' style='width:100%;'>";
                                    ?>
                                    <tr>
                                      <td class='col-lg-5'> <input type='hidden' class='id_producto' name='' value='<?php echo $id_producto ?>'> <input type='hidden' class="unidad" value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
                                      <td class='col-lg-1 text-center'><?php echo $select; ?></td>
                                      <td class='col-lg-1 text-center descp'><?php echo $descripcionp; ?></td>
                                      <td class='col-lg-1 text-center precio_compra'><?php echo $cost; ?></td>
                                      <td style="display:none;" class='text-center precio_venta'><?php echo $preciop; ?></td>
                                      <td class='col-lg-1 text-center exis'><?php echo $existencia; ?></td>
                                      <td class='col-lg-1 text-center'><?php echo $input; ?></td>
                                      <td class='col-lg-1 text-center subtotal'><?php echo round((intdiv($rowdf['cantidad'],$unidadp)*$costop),4) ?></td>
                                      <td class='col-lg-1 text-center'> <button class="btn btn-danger btnDelete"> <i class="fa fa-trash"></i> </button> </td>
                                    </tr>
                                    <?php
                                  }
                                }
                                 ?>

                              </tbody>
                            </table>
                          </div>

                          <div class="table101-body">
                            <table>
                              <thead>
                                <tbody>
                                  <tr>
                                    <td class="cell100 column100 ">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class='cell100 column75 text-bluegrey tr_bb'  id='totaltexto'>&nbsp;</td>
                                    <td class='cell100 column15 leftt  text-bluegrey  tr_bb' >TOTAL CON IVA</td>
                                    <td class='cell100 column10 text-right text-danger  tr_bb' id='total_dinero'>0.00</td>
                                  </tr>
                                  <tr>
                                    <td class='cell100 column75 text-bluegrey tr_bb'  id='totaltexto_si'>&nbsp;</td>
                                    <td class='cell100 column15 leftt  text-bluegrey  tr_bb' >TOTAL SIN IVA</td>
                                    <td class='cell100 column10 text-right text-danger  tr_bb' id='total_dinero2'>0.00</td>
                                  </tr>
                                  <tr>
                                    <td class="cell100 column75">&nbsp;</td>
                                    <td class="cell100 column15 leftt text-bluegrey">CANT. PROD: </td>
                                    <td class="cell100 column10 text-right text-green" id='totcant'>0.00</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                          </div>

                        </div>
                      </div>
                <!--/div-->

              </div>


                  </form>
                </div>
              </div>
            </div>
          </div><!--div class='ibox-content'-->
        </div>
      </div>
<?php
  include_once ("footera.php");
  echo "<script src='js/funciones/funciones_traslado.js'></script>";
} //permiso del script
else
{
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
    include_once ("footer.php");
}
}
function traerdatos()
{
  $start = !empty($_POST['page'])?$_POST['page']:0;
  $limit =$_POST['records'];
  $sortBy = $_POST['sortBy'];
  $producto_buscar = $_POST['producto_buscar'];
  $origen = $_POST['origen'];

  $sqlJoined="SELECT pr.id_producto,pr.descripcion, pr.barcode FROM
  producto AS pr";
  //  $sqlParcial=get_sql($keywords, $id_color, $estilo, $talla, $barcode, $limite);
  $sqlParcial= get_sql($start,$limit,$producto_buscar,$origen,$sortBy);
  $groupBy="";
  $limitSQL= " ";
  $sql_final= $sqlJoined." ".$sqlParcial." ".$groupBy." ".$limitSQL;
  $query = _query($sql_final);

  echo _error();
  $num_rows = _num_rows($query);
  $filas=0;
  if ($num_rows > 0)
  {
    while ($row = _fetch_array($query))
    {
      $id_producto = $row['id_producto'];
      $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$origen'");
      $dt_existencia = _fetch_array($sql_existencia);
      $existencia = round($dt_existencia["existencia"]);
      $descripcion=$row["descripcion"];
      $barcode = $row['barcode'];
      $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio
                            FROM presentacion_producto AS prp
                            JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion
                            WHERE prp.id_producto=$id_producto
                            AND prp.activo=1");
      $i=0;
      $unidadp=0;
      $costop=0;
      $preciop=0;
      $descripcionp="";
      $select="<select class='sel'>";
      while ($row=_fetch_array($sql_p))
      {
        if ($i==0)
        {
          $unidadp=$row['unidad'];
          $costop=$row['costo'];
          $preciop=$row['precio'];
          $descripcionp=$row['descripcion'];
        }
        $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
        $i=$i+1;
      }
      $select.="</select>";
      $input = "<input type='text' class='cant form-control numeric' style='width:100%;'>";
      ?>
      <tr>
        <td class='col-lg-5'> <input type='hidden' class='id_producto' name='' value='<?php echo $id_producto ?>'> <input type='hidden' class="unidad" value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
        <td class='col-lg-1 text-center'><?php echo $select; ?></td>
        <td class='col-lg-1 text-center descp'><?php echo $descripcionp; ?></td>
        <td class='col-lg-1 text-center precio_compra'><?php echo $costop; ?></td>
        <td style="display:none;" class='text-center precio_venta'><?php echo $preciop; ?></td>
        <td class='col-lg-1 text-center exis'><?php echo $existencia; ?></td>
        <td class='col-lg-1 text-center'><?php echo $input; ?></td>
        <td class='col-lg-1 text-center subtotal'><?php echo "0.0000" ?></td>
        <td class='col-lg-1 text-center'> <button class="btn btn-danger btnDelete"> <i class="fa fa-trash"></i> </button> </td>
      </tr>
      <?php
      $filas+=1;
    }
  }
}

function get_sql($start,$limit,$producto_buscar,$origen,$sortBy)
{
  $andSQL='';
  $id_sucursal= $_SESSION['id_sucursal'];
  $whereSQL=" WHERE
  ";
  /*AND su.id_ubicacion = '$origen'
  AND su.id_estante=0
  AND su.id_posicion=0
  AND su.cantidad >= 0
  AND su.id_ubicacion=$origen
  AND su.id_sucursal = '$id_sucursal'*/
  $andSQL.= "pr.id_producto = '$producto_buscar'";
  $orderBy="";
  $sql_parcial=$whereSQL.$andSQL.$orderBy;
  return $sql_parcial;
}
function traerpaginador()
{
  $start = !empty($_POST['page'])?$_POST['page']:0;
  $limit =$_POST['records'];
  $sortBy = $_POST['sortBy'];
  $producto_buscar= $_POST['producto_buscar'];
  $origen= $_POST['origen'];
  $limite=50;
  $whereSQL =$andSQL =  $orderSQL = '';
  if(isset($_POST['page']))
  {
    //Include pagination class file
    include('Pagination.php');
    //get partial values from sql sentence
    $sqlParcial=get_sql($start,$limit,$producto_buscar,$origen,$sortBy);
    //get number of rows
    $sql1="SELECT COUNT(*) as numRecords  FROM producto AS pr, stock_ubicacion AS su";
    $sql_numrows=$sql1.$sqlParcial;
    $queryNum = _query($sql_numrows);
    if(_num_rows($queryNum)>0)
    {
      $resultNum = _fetch_array($queryNum);
      $rowCount = $resultNum['numRecords'];
    }
    else
    {
        $rowCount = 0;
    }
    //initialize pagination class
    $pagConfig = array(
      'currentPage' => $start,
      'totalRows' => $rowCount,
      'perPage' => $limit,
      'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);
    echo $pagination->createLinks();
    echo '<input type="hidden" id="cuantos_reg"  value="'.$rowCount.'">';
  }
}
function insertar()
{
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $origen = $_POST['origen'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];
  $concepto=$_POST['concepto'];
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_empleado=$_SESSION["id_usuario"];

  $id_suc_destino=$_POST['id_suc_destino'];
  $id_ubicacion_destino=$_POST['id_ubicacion_destino'];

  $id_traslado_g=$_POST['id_traslado_guardado'];

  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT tre FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["tre"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_TRE';
  $tipo_entrada_salida='TRASLADO DE PRODUCTO';

  _begin();
  $z=1;
  $up=1;

  _query("DELETE FROM traslado_detalle_g WHERE id_traslado=$id_traslado_g");
  _query("DELETE FROM traslado_g WHERE id_traslado=$id_traslado_g");

  /*actualizar los correlativos de TRE*/
  $corr=1;
  $table="correlativo";
  $form_data = array(
    'tre' =>$ult
  );
  $where_clause_c="id_sucursal='".$id_sucursal."'";
  $up_corr=_update($table,$form_data,$where_clause_c);
  if ($up_corr) {
    # code...
  }
  else {
    $corr=0;
  }
  if ($concepto=='')
  {
    $concepto='TRASLADO DE PRODUCTO';
  }

  /*Crear traslado*/
  $table="traslado";
  $form_data = array(
    'concepto' => $concepto,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_empleado_envia' => $id_empleado,
    'empleado_envia' => $_SESSION['nombre'],
    'id_empleado_recibe' =>0,
    'id_sucursal_origen' => $id_sucursal,
    'id_sucursal_destino' => $id_suc_destino,
    'id_ubicacion_destino'=>$id_ubicacion_destino,
    'total' =>  $total,
    'anulada' => 0,
    'finalizada' => 0,
    'id_origen' => $origen,
    'n_vale' => $_REQUEST['numero_vale'],
   );
   $w=1;
   $insert_tra=_insert($table,$form_data);
   $id_traslado=_insert_id();

   if ($insert_tra) {
     # code...
   }
   else {
     # code...
     $w=0;
   }


  /*crear el movimiento de salida*/
  $concepto=$concepto;
  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => $concepto,
    'total' => $total,
    'tipo' => 'SALIDA',
    'proceso' => 'TRE',
    'referencia' => $numero_doc,
    'id_empleado' => $id_empleado,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    'id_suc_destino' => $id_suc_destino,
    'id_proveedor' => 0,
    'id_traslado' => $id_traslado,
  );
  $insert_mov =_insert($table,$form_data);

  echo _error();
  $id_movimiento=_insert_id();
  $lista=explode('#',$datos);
  $j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;
  $y = 1 ;

  $table_cambio="log_cambio_local";
  $form_data = array(
    'process' => 'insert',
    'tabla' =>  "traslado",
    'fecha' => date("Y-m-d"),
    'hora' => date('H:i:s'),
    'id_usuario' => $_SESSION['id_usuario'],
    'id_sucursal' => $_SESSION['id_sucursal'],
    'id_primario' =>$id_traslado,
    'prioridad' => "1"
  );
  $insert_cambio=_insert($table_cambio,$form_data);
  $id_cambio=_insert_id();

  $table_detalle_cambio="log_detalle_cambio_local";
  $form_data = array(
    'id_log_cambio' => 	$id_cambio,
    'tabla' => 'traslado',
    'id_verificador' => $id_traslado
  );
  _insert($table_detalle_cambio,$form_data);

  for ($i=0;$i<$cuantos ;$i++)
  {
    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);


    $id_producto;
    $cantidad=$cantidad*$unidades;
    $a_transferir=$cantidad;

    $sql_get_p=_fetch_array(_query("SELECT presentacion_producto.id_presentacion as presentacion,presentacion_producto.id_server,producto.id_server as id_server_prod FROM presentacion_producto JOIN producto ON presentacion_producto.id_producto=producto.id_producto WHERE id_pp=$id_presentacion"));
    $presentacion=$sql_get_p['presentacion'];
    $id_server_presen=$sql_get_p['id_server'];
    $id_server_prod=$sql_get_p['id_server_prod'];

    $table='traslado_detalle';
    $form_data = array(
      'id_traslado' => $id_traslado,
      'id_sucursal_origen' => $id_sucursal,
      'id_sucursal_destino' => $id_suc_destino,
      'id_producto' => $id_producto,
      'id_server_prod' => $id_server_prod,
      'cantidad' => $cantidad,
      'unidad' => $unidades,
      'costo' => $precio_compra,
      'id_presentacion' => $id_presentacion,
      'id_server_presen'=> $id_server_presen,
      'presentacion'=> $presentacion,
    );
    $insert_tra_det=_insert($table,$form_data);
    $id_tra_det=_insert_id();

    $table_detalle_cambio="log_detalle_cambio_local";
    $form_data = array(
      'id_log_cambio' => 	$id_cambio,
      'tabla' => 'traslado_detalle',
      'id_verificador' => $id_tra_det
    );
    _insert($table_detalle_cambio,$form_data);

    if ($insert_tra_det) {
      # code...
    }
    else {
      # code...
      $y=0;
    }

    $sql=_query("SELECT * FROM stock_ubicacion WHERE stock_ubicacion.id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$origen AND stock_ubicacion.cantidad!=0 ORDER BY id_posicion DESC ,id_estante DESC ");

    while ($rowsu=_fetch_array($sql)) {
      # code...

      $id_su1=$rowsu['id_su'];
      $stock_anterior=$rowsu['cantidad'];

      if ($a_transferir!=0) {
        # code...

        $transfiriendo=0;
        $nuevo_stock=$stock_anterior-$a_transferir;
        if ($nuevo_stock<0) {
          # code...
          $transfiriendo=$stock_anterior;
          $a_transferir=$a_transferir-$stock_anterior;
          $nuevo_stock=0;
        }
        else
        {
          if ($nuevo_stock>0) {
            # code...
            $transfiriendo=$a_transferir;
            $a_transferir=0;
            $nuevo_stock=$stock_anterior-$transfiriendo;
          }
          else {
            # code...
            $transfiriendo=$stock_anterior;
            $a_transferir=0;
            $nuevo_stock=0;

          }
        }

        $table="stock_ubicacion";
        $form_data = array(
          'cantidad' => $nuevo_stock,
        );
        $where_clause="id_su='".$id_su1."'";
        $update=_update($table,$form_data,$where_clause);
        if ($update) {
          # code...
        }
        else {
          $up=0;
        }

        /*actualizando el stock del local de venta*/
        $sql1a=_fetch_array(_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0"));
        $id_ubicaciona=$sql1a['id_ubicacion'];
        $sql2a=_fetch_array(_query("SELECT SUM(stock_ubicacion.cantidad) as stock FROM stock_ubicacion WHERE id_producto=$id_producto AND stock_ubicacion.id_ubicacion=$id_ubicaciona"));
        $table='stock';
        $form_data = array(
          'stock_local' => $sql2a['stock'],
        );
        $where_clause="id_producto='".$id_producto."' AND id_sucursal=$id_sucursal";
        $updatea=_update($table,$form_data,$where_clause);
        /*finalizando we*/

        $table="movimiento_stock_ubicacion";
        $form_data = array(
          'id_producto' => $id_producto,
          'id_origen' => $id_su1,
          'id_destino'=> 0,
          'cantidad' => $transfiriendo,
          'fecha' => $fecha,
          'hora' => $hora,
          'anulada' => 0,
          'afecta' => 0,
          'id_sucursal' => $id_sucursal,
          'id_presentacion'=> $id_presentacion,
          'id_mov_prod' => $id_movimiento,
        );

        $insert_mss =_insert($table,$form_data);

        if ($insert_mss) {
          # code...
        }
        else {
          # code...
          $z=0;
        }

      }

    }


    $sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
    $stock2=_query($sql2);
    $nrow2=_num_rows($stock2);
    if ($nrow2>0)
    {
      $row2=_fetch_array($stock2);
      $existencias=$row2['stock'];
    }
    else
    {
      $existencias=0;
    }

    /*significa que no hay suficientes unidades en el stock_ubicacion para realizar el descargo*/
    if ($a_transferir>0) {
      /*verificamos si se desconto algo de stock_ubicacion*/

      if($a_transferir!=$cantidad)
      {/*si entra aca significa que se descontaron algunas unidades de stock_ubicacion y hay que descontarlas de stock y lote*/
        /*se insertara la diferencia entre el stock_ubicacion y la cantidad a descontar en la tabla de movimientos pendientes*/
        $table1= 'movimiento_producto_detalle';
        $cant_total=$existencias-($cantidad-$a_transferir);
        $form_data1 = array(
          'id_movimiento'=>$id_movimiento,
          'id_producto' => $id_producto,
          'cantidad' => ($cantidad-$a_transferir),
          'costo' => $precio_compra,
          'precio' => $precio_venta,
          'stock_anterior'=>$existencias,
          'stock_actual'=>$cant_total,
          'lote' => 0,
          'id_presentacion' => $id_presentacion,
          'fecha' =>  $fecha,
          'hora' => $hora
        );
        $insert_mov_det = _insert($table1,$form_data1);
        if(!$insert_mov_det)
        {
          $j = 0;
        }


        $table2= 'stock';
        if($nrow2==0)
        {
          $form_data2 = array(
            'id_producto' => $id_producto,
            'stock' => 0,
            'costo_unitario'=>round(($precio_compra/$unidades),2),
            'precio_unitario'=>round(($precio_venta/$unidades),2),
            'create_date'=>$fecha_movimiento,
            'update_date'=>$fecha_movimiento,
            'id_sucursal' => $id_sucursal
          );
          $insert_stock = _insert($table2,$form_data2 );
        }
        else
        {
          $form_data2 = array(
            'id_producto' => $id_producto,
            'stock' => $cant_total,
            'costo_unitario'=>round(($precio_compra/$unidades),2),
            'precio_unitario'=>round(($precio_venta/$unidades),2),
            'update_date'=>$fecha_movimiento,
            'id_sucursal' => $id_sucursal
          );
          $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
          $insert_stock = _update($table2,$form_data2, $where_clause );
        }
        if(!$insert_stock)
        {
          $k = 0;
        }

        /*arreglando problema con lotes de nuevo*/
        $cantidad_a_descontar=($cantidad-$a_transferir);
        $sql=_query("SELECT id_lote, id_producto, fecha_entrada, vencimiento, cantidad
          FROM lote
          WHERE id_producto='$id_producto'
          AND id_sucursal='$id_sucursal'
          AND cantidad>0
          AND estado='VIGENTE'
          ORDER BY vencimiento");


          $contar=_num_rows($sql);
          $insert=1;
          if ($contar>0) {
            # code...
            while ($row=_fetch_array($sql)) {
              # code...
              $entrada_lote=$row['cantidad'];
              if ($cantidad_a_descontar>0) {
                # code...
                if ($entrada_lote==0) {
                  $table='lote';
                  $form_dat_lote=$arrayName = array(
                    'estado' => 'FINALIZADO',
                  );
                  $where = " WHERE id_lote='$row[id_lote]'";
                  $insert=_update($table,$form_dat_lote,$where);
                } else {
                  if (($entrada_lote-$cantidad_a_descontar)>0) {
                    # code...
                    $table='lote';
                    $form_dat_lote=$arrayName = array(
                      'cantidad'=>($entrada_lote-$cantidad_a_descontar),
                      'estado' => 'VIGENTE',
                    );
                    $cantidad_a_descontar=0;

                    $where = " WHERE id_lote='$row[id_lote]'";
                    $insert=_update($table,$form_dat_lote,$where);
                  } else {
                    # code...
                    if (($entrada_lote-$cantidad_a_descontar)==0) {
                      # code...
                      $table='lote';
                      $form_dat_lote=$arrayName = array(
                        'cantidad'=>($entrada_lote-$cantidad_a_descontar),
                        'estado' => 'FINALIZADO',
                      );
                      $cantidad_a_descontar=0;

                      $where = " WHERE id_lote='$row[id_lote]'";
                      $insert=_update($table,$form_dat_lote,$where);
                    }
                    else
                    {
                      $table='lote';
                      $form_dat_lote=$arrayName = array(
                        'cantidad'=>0,
                        'estado' => 'FINALIZADO',
                      );
                      $cantidad_a_descontar=$cantidad_a_descontar-$entrada_lote;
                      $where = " WHERE id_lote='$row[id_lote]'";
                      $insert=_update($table,$form_dat_lote,$where);
                    }
                  }
                }
              }
            }
          }
          /*fin arreglar problema con lotes*/
          if(!$insert)
          {
            $l = 0;
          }

          $table1= 'movimiento_producto_pendiente';
          $cant_total=$existencias-$cantidad;
          $form_data1 = array(
            'id_movimiento'=>$id_movimiento,
            'id_producto' => $id_producto,
            'id_presentacion' => $id_presentacion,
            'cantidad' => $a_transferir,
            'costo' => $precio_compra,
            'precio' => $precio_venta,
            'fecha' =>  $fecha,
            'hora' => $hora,
            'id_sucursal' => $id_sucursal
          );
          $insert_mov_det = _insert($table1,$form_data1);
          if(!$insert_mov_det)
          {
            $j = 0;
          }

      }
      else
      {/*significa que no hay nada en stock_ubicacion y no se puede descontar de stock_ubicacion ni de stock*/
        /*se insertara todo en la tabla de movimientos pendientes*/

        $table1= 'movimiento_producto_pendiente';
        $cant_total=$existencias-$cantidad;
        $form_data1 = array(
          'id_movimiento'=>$id_movimiento,
          'id_producto' => $id_producto,
          'id_presentacion' => $id_presentacion,
          'cantidad' => $cantidad,
          'costo' => $precio_compra,
          'precio' => $precio_venta,
          'fecha' =>  $fecha,
          'hora' => $hora,
          'id_sucursal' => $id_sucursal
        );
        $insert_mov_det = _insert($table1,$form_data1);
        if(!$insert_mov_det)
        {
          $j = 0;
        }
      }
    }

    /*Hay suficientes unidades en  el stock_ubicacion para realizar el descargo y se procede normalmente*/
    else {

      $table1= 'movimiento_producto_detalle';
      $cant_total=$existencias-$cantidad;
      $form_data1 = array(
        'id_movimiento'=>$id_movimiento,
        'id_producto' => $id_producto,
        'cantidad' => $cantidad,
        'costo' => $precio_compra,
        'precio' => $precio_venta,
        'stock_anterior'=>$existencias,
        'stock_actual'=>$cant_total,
        'lote' => 0,
        'id_presentacion' => $id_presentacion,
        'fecha' =>  $fecha,
        'hora' => $hora
      );
      $insert_mov_det = _insert($table1,$form_data1);
      if(!$insert_mov_det)
      {
        $j = 0;
      }


      $table2= 'stock';
      if($nrow2==0)
      {
        $cant_total=$cantidad;
        $form_data2 = array(
          'id_producto' => $id_producto,
          'stock' => $cant_total,
          'costo_unitario'=>round(($precio_compra/$unidades),2),
          'precio_unitario'=>round(($precio_venta/$unidades),2),
          'create_date'=>$fecha_movimiento,
          'update_date'=>$fecha_movimiento,
          'id_sucursal' => $id_sucursal
        );
        $insert_stock = _insert($table2,$form_data2 );
      }
      else
      {
        $cant_total=$existencias-$cantidad;
        $form_data2 = array(
          'id_producto' => $id_producto,
          'stock' => $cant_total,
          'costo_unitario'=>round(($precio_compra/$unidades),2),
          'precio_unitario'=>round(($precio_venta/$unidades),2),
          'update_date'=>$fecha_movimiento,
          'id_sucursal' => $id_sucursal
        );
        $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
        $insert_stock = _update($table2,$form_data2, $where_clause );
      }
      if(!$insert_stock)
      {
        $k = 0;
      }

      /*arreglando problema con lotes de nuevo*/
      $cantidad_a_descontar=$cantidad;
      $sql=_query("SELECT id_lote, id_producto, fecha_entrada, vencimiento, cantidad
        FROM lote
        WHERE id_producto='$id_producto'
        AND id_sucursal='$id_sucursal'
        AND cantidad>0
        AND estado='VIGENTE'
        ORDER BY vencimiento");


        $contar=_num_rows($sql);
        $insert=1;
        if ($contar>0) {
          # code...
          while ($row=_fetch_array($sql)) {
            # code...
            $entrada_lote=$row['cantidad'];
            if ($cantidad_a_descontar>0) {
              # code...
              if ($entrada_lote==0) {
                $table='lote';
                $form_dat_lote=$arrayName = array(
                  'estado' => 'FINALIZADO',
                );
                $where = " WHERE id_lote='$row[id_lote]'";
                $insert=_update($table,$form_dat_lote,$where);
              } else {
                if (($entrada_lote-$cantidad_a_descontar)>0) {
                  # code...
                  $table='lote';
                  $form_dat_lote=$arrayName = array(
                    'cantidad'=>($entrada_lote-$cantidad_a_descontar),
                    'estado' => 'VIGENTE',
                  );
                  $cantidad_a_descontar=0;

                  $where = " WHERE id_lote='$row[id_lote]'";
                  $insert=_update($table,$form_dat_lote,$where);
                } else {
                  # code...
                  if (($entrada_lote-$cantidad_a_descontar)==0) {
                    # code...
                    $table='lote';
                    $form_dat_lote=$arrayName = array(
                      'cantidad'=>($entrada_lote-$cantidad_a_descontar),
                      'estado' => 'FINALIZADO',
                    );
                    $cantidad_a_descontar=0;

                    $where = " WHERE id_lote='$row[id_lote]'";
                    $insert=_update($table,$form_dat_lote,$where);
                  }
                  else
                  {
                    $table='lote';
                    $form_dat_lote=$arrayName = array(
                      'cantidad'=>0,
                      'estado' => 'FINALIZADO',
                    );
                    $cantidad_a_descontar=$cantidad_a_descontar-$entrada_lote;
                    $where = " WHERE id_lote='$row[id_lote]'";
                    $insert=_update($table,$form_dat_lote,$where);
                  }
                }
              }
            }
          }
        }
        /*fin arreglar problema con lotes*/
        if(!$insert)
        {
          $l = 0;
        }

    }

  }
  if($insert_mov&&$w&&$corr&&$z&&$j&&$k&&$l&&$m&&$y)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con éxito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!'.$insert_mov."a".$w."b" .$corr."c" .$z."d" . $j."e" . $k."f" . $l."g" . $m."h" .$y."i";
  }
  echo json_encode($xdatos);
}

function saving()
{
  $id_traslado=$_POST['id_traslado_guardado'];
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $origen = $_POST['origen'];
  $fecha = $_POST['fecha'];
  $total = $_POST['total'];
  $concepto=$_POST['concepto'];
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_empleado=$_SESSION["id_usuario"];

  $id_suc_destino=$_POST['id_suc_destino'];
  $id_ubicacion_destino=$_POST['id_ubicacion_destino'];

  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT tre FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["tre"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_TRE';
  $tipo_entrada_salida='TRASLADO DE PRODUCTO';

  _begin();
  $z=1;
  $up=1;


  if ($concepto=='')
  {
    $concepto='TRASLADO DE PRODUCTO';
  }

  if ($id_traslado!=0) {
    // code...
    /*actualizar traslado*/
    $table="traslado_g";
    $form_data = array(
      'concepto' => $concepto,
      'fecha' => $fecha,
      'hora' => $hora,
      'id_empleado_envia' => $id_empleado,
      'empleado_envia' => $_SESSION['nombre'],
      'id_empleado_recibe' =>0,
      'id_sucursal_origen' => $id_sucursal,
      'id_sucursal_destino' => $id_suc_destino,
      'id_ubicacion_destino'=>$id_ubicacion_destino,
      'total' =>  $total,
      'anulada' => 0,
      'finalizada' => 0,
      'id_origen' => $origen,
      'n_vale' => $_REQUEST['numero_vale'],
     );
     $w=1;

     $where_clause="id_traslado=$id_traslado";
     $insert_tra=_update($table,$form_data,$where_clause);

     if ($insert_tra) {
       # code...
     }
     else {
       # code...
       $w=0;
     }
  }
  else {
    // code...
    /*Crear traslado*/
    $table="traslado_g";
    $form_data = array(
      'concepto' => $concepto,
      'fecha' => $fecha,
      'hora' => $hora,
      'id_empleado_envia' => $id_empleado,
      'empleado_envia' => $_SESSION['nombre'],
      'id_empleado_recibe' =>0,
      'id_sucursal_origen' => $id_sucursal,
      'id_sucursal_destino' => $id_suc_destino,
      'id_ubicacion_destino'=>$id_ubicacion_destino,
      'total' =>  $total,
      'anulada' => 0,
      'finalizada' => 0,
      'id_origen' => $origen,
      'n_vale' => $_REQUEST['numero_vale'],
     );
     $w=1;
     $insert_tra=_insert($table,$form_data);
     $id_traslado=_insert_id();

     if ($insert_tra) {
       # code...
     }
     else {
       # code...
       $w=0;
     }
  }

  $lista=explode('#',$datos);
  $j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;
  $y = 1 ;
  _query("DELETE FROM traslado_detalle_g WHERE id_traslado=$id_traslado");
  for ($i=0;$i<$cuantos ;$i++)
  {


    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);


    $id_producto;
    $cantidad=$cantidad*$unidades;
    $a_transferir=$cantidad;

    $sql_get_p=_fetch_array(_query("SELECT presentacion_producto.id_presentacion as presentacion,presentacion_producto.id_server,producto.id_server as id_server_prod FROM presentacion_producto JOIN producto ON presentacion_producto.id_producto=producto.id_producto WHERE id_pp=$id_presentacion"));
    $presentacion=$sql_get_p['presentacion'];
    $id_server_presen=$sql_get_p['id_server'];
    $id_server_prod=$sql_get_p['id_server_prod'];

    $table='traslado_detalle_g';
    $form_data = array(
      'id_traslado' => $id_traslado,
      'id_sucursal_origen' => $id_sucursal,
      'id_sucursal_destino' => $id_suc_destino,
      'id_producto' => $id_producto,
      'id_server_prod' => $id_server_prod,
      'cantidad' => $cantidad,
      'unidad' => $unidades,
      'costo' => $precio_compra,
      'id_presentacion' => $id_presentacion,
      'id_server_presen'=> $id_server_presen,
      'presentacion'=> $presentacion,
    );
    $insert_tra_det=_insert($table,$form_data);
    $id_tra_det=_insert_id();

  }
  if($w&&$z&&$j&&$k&&$l&&$m&&$y)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro guardado con éxito!';
    $xdatos['id_traslado']=$id_traslado;
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!'.$w."b".$z."d" . $j."e" . $k."f" . $l."g" . $m."h" .$y."i";
  }
  echo json_encode($xdatos);
}
function consultar_stock()
{
  $id_producto = $_REQUEST['id_producto'];
  $id_sucursal=$_SESSION['id_sucursal'];

  $i=0;
  $unidadp=0;
  $preciop=0;
  $costop=0;
  $descripcionp=0;

  $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.presentacion WHERE prp.id_producto=$id_producto AND prp.activo=1");
  $select="<select class='sel'>";
  while ($row=_fetch_array($sql_p))
  {
    if ($i==0)
    {
      $unidadp=$row['unidad'];
      $costop=$row['costo'];
      $preciop=$row['precio'];
      $descripcionp=$row['descripcion'];
    }
    $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
    $i=$i+1;
  }
  $select.="</select>";
  $xdatos['select']= $select;
  $xdatos['costop']= $costop;
  $xdatos['preciop']= $preciop;
  $xdatos['unidadp']= $unidadp;
  $xdatos['descripcionp']= $descripcionp;

  $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
  $result_perece=_query($sql_perece);
  $row_perece=_fetch_array($result_perece);
  $perecedero=$row_perece['perecedero'];
  $xdatos['perecedero'] = $perecedero;
  echo json_encode($xdatos);
}
function getpresentacion()
{
  echo json_encode(getPre());
}
function ubicacion()
{
		$id_sucursal = $_POST['id_sucursal'];
    $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal'");
    $opt = "<option value=''>Seleccione</option>";
    while ($row = _fetch_array($sql)) {
        $opt .="<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
    }
    $xdatos["typeinfo"] = "Success";
    $xdatos["opt"] = $opt;
    echo json_encode($xdatos);
}
if (!isset($_REQUEST['process']))
{
  initial();
}
if (isset($_REQUEST['process']))
{
  switch ($_REQUEST['process'])
  {
    case 'insert':
    insertar();
    break;
    case 'saving':
    saving();
    break;
    case 'consultar_stock':
    consultar_stock();
    break;
    case 'getpresentacion':
    getpresentacion();
    break;
    case 'traerdatos':
    traerdatos();
    break;
    case'traerpaginador':
    traerpaginador();
    break;
    case 'val':
    ubicacion();
    break;
  }
}
?>
