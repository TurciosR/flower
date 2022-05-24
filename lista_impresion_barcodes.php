<?php
include_once "_core.php";

function initial()
{
  $title = "IMPRESION BARCODES";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/main_co.css">';
  $_PAGE ['links'] .= '<link rel="stylesheet" type="text/css" href="css/util_co.css">';

  include_once "header.php";

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

  ?>

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
            <div class='row focuss' id='form_invent_inicial'>
              <div class="col-lg-3">
                <div class="form-group has-info">
                  <label>Concepto</label>
                  <input type='text' class='form-control' value='IMPRESION BARCODES' id='concepto' name='concepto'>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group has-info">
                  <label>Destino</label>
                  <select class="form-control select" id="destino" name="destino">
                    <?php
                      $id_sucursal=$_SESSION['id_sucursal'];
                      $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                      while($row = _fetch_array($sql))
                      {
                        echo "<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
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
              <div class="col-lg-3">
                <input type="hidden" name="process" id="process" value="insert">
                <br>
                <a class="btn btn-danger pull-right" style="margin-left:2%;" href="dashboard.php" id='salir'><i class="fa fa-mail-reply"></i> F4 Salir</a>
                <!--button type="button" id="submit1" class="btn btn-primary pull-right"><i class="fa fa-save"></i> F2 Guardar</button-->
                <button type="button" class="btn btn-primary pull-right" id="print_all" style="margin-right: 2%;"><i class="fa fa-print"></i> Imprimir</button>
                <input type='hidden' name='urlprocess' id='urlprocess' value="<?php echo $filename ?> ">
              </div>
            </div>
            <div class="row" id='buscador'>
              <div class="col-lg-4">
                <div id="a">
                  <label>Buscar Producto (Código)</label>
                  <input type="text" id="codigo" name="codigo" style="width:100% !important" class="form-control usage" placeholder="Ingrese Código de producto" style="border-radius:0px">
                </div>
                <div hidden id="b">
                  <label id='buscar_habilitado'>Buscar Producto (Descripción)</label>
                  <div id="scrollable-dropdown-menu">
                    <input type="text" id="producto_buscar" name="producto_buscar" style="width:100% !important" class=" form-control usage typeahead" placeholder="Ingrese la Descripción de producto" data-provide="typeahead"
                      style="border-radius:0px">
                  </div>
                </div><br>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <header>
                  <h4 class="text-navy">Lista de Productos</h4>
                </header>
                <div class='widget-content' id="content">
                  <div class="wrap-table1001">
                    <div class="table100 ver1 m-b-10">
                      <div class="table100-head">
                        <table class="table table-striped" id='inventable1'>
                          <thead>
                            <tr class='row100 head'>
                              <th class="col-lg-1" style="display:none">Id</th>
                              <th class="col-lg-3">Nombre</th>
                              <th class="col-lg-1 text-left">Presentación</th>
                              <th class="col-lg-1">Imprimir</th>
                              <th class="col-lg-1">Cantidad</th>
                              <th class="col-lg-1">Costo</th>
                              <th class="col-lg-1">Precio</th>
                              <th class="col-lg-1">Subtotal</th>
                              <th class="col-lg-1">Barcore Pre.</th>
                              <th class="col-lg-1">Acci&oacute;n</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                      <div class="table100-body js-pscroll">
                        <table>
                          <tbody id="inventable">
                          </tbody>
                        </table>
                      </div>
                      <div class="table101-body">
                        <table>
                          <tbody>
                            <tr>
                              <td class='cell100 column100 text-bluegrey font-bold' id='totaltexto'>&nbsp;</td>
                            </tr>
                            <tr>
                              <td class='cell100 column50' id='totaltexto'>&nbsp;</td>
                              <td class='cell100 column15 leftt  text-bluegrey font-bold'>CANT. PROD:</td>
                              <td class='cell100 column10 text-right text-danger font-bold' id='totcant'>0.00</td>
                              <td class="cell100 column10 leftt text-bluegrey font-bold">TOTALES $:</td>
                              <td class='cell100 column15 text-right text-green font-bold' id='total_dinero'>0.00</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>
                <div>
                </div>
                </form>
                <input type="hidden" id="filas" value="0">
              </div>
            </div>
          </div>
          <!--div class='ibox-content'-->
        </div>
      </div>


      <?php
  include_once ("footer.php");
  echo "<script src='js/funciones/lista_impresion.js'></script>";
} //permiso del script
else {
  echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
}
}

function insertar()
{
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $destino = $_POST['destino'];
  $fecha = $_POST['fecha'];
  $total_compras = $_POST['total'];
  $concepto=$_POST['concepto'];
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_empleado=$_SESSION["id_usuario"];

  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT ii FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["ii"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_II';
  $tipo_entrada_salida='ENTRADA DE INVENTARIO';

  _begin();
  $z=1;

  /*actualizar los correlativos de II*/
  $corr=1;
  $table="correlativo";
  $form_data = array(
    'ii' =>$ult
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
    $concepto='ENTRADA DE INVENTARIO';
  }
  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => $concepto,
    'total' => $total_compras,
    'tipo' => 'ENTRADA',
    'proceso' => 'II',
    'referencia' => $numero_doc,
    'id_empleado' => $id_empleado,
    'fecha' => $fecha,
    'hora' => $hora,
    'id_suc_origen' => $id_sucursal,
    'id_suc_destino' => $id_sucursal,
    'id_proveedor' => 0,
  );
  $insert_mov =_insert($table,$form_data);
  $id_movimiento=_insert_id();
  $lista=explode('#',$datos);
  $j = 1 ;
  $k = 1 ;
  $l = 1 ;
  $m = 1 ;
  for ($i=0;$i<$cuantos ;$i++)
  {
    list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$fecha_caduca,$id_presentacion)=explode('|',$lista[$i]);
    $sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";
    $stock_su=_query($sql_su);
    $nrow_su=_num_rows($stock_su);
    $id_su="";
    /*cantidad de una presentacion por la unidades que tiene*/
    $cantidad=$cantidad*$unidades;
    if($nrow_su >0)
    {
      $row_su=_fetch_array($stock_su);
      $cant_exis = $row_su["cantidad"];
      $id_su = $row_su["id_su"];
      $cant_new = $cant_exis + $cantidad;
      $form_data_su = array(
        'cantidad' => $cant_new,
      );
      $table_su = "stock_ubicacion";
      $where_su = "id_su='".$id_su."'";
      $insert_su = _update($table_su, $form_data_su, $where_su);
    }
    else
    {
      $form_data_su = array(
        'id_producto' => $id_producto,
        'id_sucursal' => $id_sucursal,
        'cantidad' => $cantidad,
        'id_ubicacion' => $destino,
      );
      $table_su = "stock_ubicacion";
      $insert_su = _insert($table_su, $form_data_su);
      $id_su=_insert_id();
    }
    if(!$insert_su)
    {
      $m=0;
    }
    $sql2="SELECT stock FROM stock WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
    $stock2=_query($sql2);
    $row2=_fetch_array($stock2);
    $nrow2=_num_rows($stock2);
    if ($nrow2>0)
    {
      $existencias=$row2['stock'];
    }
    else
    {
      $existencias=0;
    }
    $sql_lot = _query("SELECT MAX(numero) AS ultimo FROM lote WHERE id_producto='$id_producto'");
    $datos_lot = _fetch_array($sql_lot);
    $lote = $datos_lot["ultimo"]+1;
    $table1= 'movimiento_producto_detalle';
    $cant_total=$cantidad+$existencias;
    $form_data1 = array(
      'id_movimiento'=>$id_movimiento,
      'id_producto' => $id_producto,
      'cantidad' => $cantidad,
      'costo' => $precio_compra,
      'precio' => $precio_venta,
      'stock_anterior'=>$existencias,
      'stock_actual'=>$cant_total,
      'lote' => $lote,
      'id_presentacion' => $id_presentacion,
      'fecha' => $fecha_movimiento,
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
        'costo_unitario'=>$precio_compra,
        'precio_unitario'=>$precio_venta,
        'create_date'=>$fecha_movimiento,
        'update_date'=>$fecha_movimiento,
        'id_sucursal' => $id_sucursal
      );
      $insert_stock = _insert($table2,$form_data2 );
    }
    else
    {
      $cant_total=$cantidad+$existencias;
      $form_data2 = array(
        'id_producto' => $id_producto,
        'stock' => $cant_total,
        'costo_unitario'=>round(($precio_compra/$unidades),2),
        'precio_unitario'=>round(($precio_venta/$unidades),2),
        'update_date'=>$fecha_movimiento,
        'id_sucursal' => $id_sucursal
      );
      $where_clause="WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal'";
      $insert_stock = _update($table2,$form_data2, $where_clause );
    }
    if(!$insert_stock)
    {
        $k = 0;
    }
    /*********************************************************************/
    /*********************************************************************/
    /*************Actualizacion de precios de presentacion****************/
    /*********************************************************************/
    /*********************************************************************/
    $form_data12 = array(
      'costo'=>$precio_compra,
      'precio'=>$precio_venta,
    );
    $form_data22 = array(
      'precio'=>$precio_venta,
    );
    $where_clause12="WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_presentacion='$id_presentacion'";
    $where_clause22="WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_presentacion='$id_presentacion' AND desde=0";
    $update12 = _update("presentacion_producto", $form_data12, $where_clause12 );
    $update22 = _update("presentacion_producto_precio", $form_data22, $where_clause22 );
    /*********************************************************************/
    /*********************************************************************/
    /*************Actualizacion de precios de presentacion****************/
    /*********************************************************************/
    /*********************************************************************/
    if ($fecha_caduca!="0000-00-00" && $fecha_caduca!="")
    {
      $sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' and fecha_entrada='$fecha_movimiento' and vencimiento='$fecha_caduca' ";
      $result_caduca=_query($sql_caduca);
      $row_caduca=_fetch_array($result_caduca);
      $nrow_caduca=_num_rows($result_caduca);
      /*if($nrow_caduca==0){*/
      $table_perece= 'lote';

      if($fecha_movimiento>=$fecha_caduca)
      {
        $estado='VIGENTE';
      }
      else
      {
        $estado='VIGENTE';
      }
      $form_data_perece = array(
        'id_producto' => $id_producto,
        'referencia' => $numero_doc,
        'numero' => $lote,
        'fecha_entrada' => $fecha_movimiento,
        'vencimiento'=>$fecha_caduca,
        'precio' => $precio_compra,
        'cantidad' => $cantidad,
        'estado'=>$estado,
        'id_sucursal' => $id_sucursal,
        'id_presentacion' => $id_presentacion,
      );
      $insert_lote = _insert($table_perece,$form_data_perece );
    }
    else
    {
      $sql_caduca="SELECT * FROM lote WHERE id_producto='$id_producto' AND fecha_entrada='$fecha_movimiento'";
      $result_caduca=_query($sql_caduca);
      $row_caduca=_fetch_array($result_caduca);
      $nrow_caduca=_num_rows($result_caduca);
      $table_perece= 'lote';
      $estado='VIGENTE';

      $form_data_perece = array(
        'id_producto' => $id_producto,
        'referencia' => $numero_doc,
        'numero' => $lote,
        'fecha_entrada' => $fecha_movimiento,
        'vencimiento'=>$fecha_caduca,
        'precio' => $precio_compra,
        'cantidad' => $cantidad,
        'estado'=>$estado,
        'id_sucursal' => $id_sucursal,
        'id_presentacion' => $id_presentacion,
      );
      $insert_lote = _insert($table_perece,$form_data_perece );
    }
    if(!$insert_lote)
    {
      $l = 0;
    }

    $table="movimiento_stock_ubicacion";
    $form_data = array(
      'id_producto' => $id_producto,
      'id_origen' => 0,
      'id_destino'=> $id_su,
      'cantidad' => $cantidad,
      'fecha' => $fecha_movimiento,
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


    /*actualizando el stock del local de venta*/
    $num=_query("SELECT ubicacion.id_ubicacion FROM ubicacion WHERE id_sucursal=$id_sucursal AND bodega=0");

    if (_num_rows($num)>0) {
      // code...
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
    }

  }
  if($insert_mov &&$corr &&$z && $j && $k && $l && $m)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con exito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!';
  }
  echo json_encode($xdatos);
}
function consultar_stock(){
  $id_producto = $_REQUEST['id_producto'];
  $tipo = $_REQUEST['tipo'];
  $id_sucursal=$_SESSION['id_sucursal'];
  $id_usuario=$_SESSION['id_usuario'];
  $id_presentacione=0;
  $r_precios=_fetch_array(_query("SELECT precios FROM usuario WHERE id_usuario=$id_usuario"));
  $precios=$r_precios['precios'];
  $limit="LIMIT ".$precios;
  if($tipo == "D")
  {
    $clause = "p.id_producto = '$id_producto'";
  }
  else
  {
    $sql_aux= _query("SELECT id_producto FROM producto WHERE codart='$id_producto'");
    echo _error();
    if(_num_rows($sql_aux)>0)
    {
      $dats_aux = _fetch_array($sql_aux);
      $id_producto = $dats_aux["id_producto"];
      $clause = "p.id_producto = '$id_producto'";
    }
    else
    {
      $sql_aux = _query("SELECT id_presentacion, id_producto FROM presentacion_producto WHERE barcode='$id_producto' AND activo='1'");
      if(_num_rows($sql_aux)>0)
      {
        $dats_aux = _fetch_array($sql_aux);
        $id_producto = $dats_aux["id_producto"];
        $id_presentacione = $dats_aux["id_presentacion"];
        $clause = "p.id_producto = '$id_producto'";
      }
      else
      {
        $clause = "p.barcode = '$id_producto'";
      }
    }
  }
  $sql1 = "SELECT p.id_producto, p.descripcion
           FROM producto AS p
           WHERE $clause";
  $stock1=_query($sql1);
  if (_num_rows($stock1)>0)
  {
    $row1=_fetch_array($stock1);
    $descipcion = $row1["descripcion"];
    $id_producto = $row1["id_producto"];
    $i=0;
    $unidadp=0;
    $preciop=0;
    $costop=0;
    $descripcionp=0;
    $anda = "";
    if($id_presentacione > 0)
    {
      $anda = " AND prp.id_presentacion = '$id_presentacione'";
    }
    $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,
                   prp.id_presentacion,prp.unidad,prp.costo,prp.precio
                   FROM presentacion_producto AS prp
                   JOIN presentacion ON presentacion.id_presentacion=prp.presentacion
                   WHERE prp.id_producto='$id_producto'
                   AND prp.activo=1
                   AND prp.id_sucursal='$id_sucursal'
                   $anda ORDER BY prp.unidad DESC");
    $select="<select class='sel form-control'>";
    while ($row=_fetch_array($sql_p))
    {
      if ($i==0)
      {
        $unidadp=$row['unidad'];
        $costop=$row['costo'];
        $preciop=$row['precio'];
        $descripcionp=$row['descripcion'];

        $xc=0;

  			$sql_rank=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$row[id_presentacion] AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] AND presentacion_producto_precio.precio!=0 ORDER BY presentacion_producto_precio.desde ASC LIMIT 1
  				");

  				while ($rowr=_fetch_array($sql_rank)) {
  					# code...
  					if($xc==0)
  					{

  						$preciop=$rowr['precio'];
  					}
  				}
      }
      $select.="<option value='".$row["id_presentacion"]."'>".$row["nombre"]." (".$row["unidad"].")</option>";
      $i=$i+1;
    }
    $select.="</select>";
    $xdatos['select']= $select;
    $xdatos['descrip']= $descipcion;
    $xdatos['id_p']= $id_producto;
    $xdatos['costop']= $costop;
    $xdatos['preciop']= $preciop;
    $xdatos['unidadp']= $unidadp;
    $xdatos['descripcionp']= $descripcionp;
    $xdatos['i']=$i;

    $sql_perece="SELECT * FROM producto WHERE id_producto='$id_producto'";
    $result_perece=_query($sql_perece);
    $row_perece=_fetch_array($result_perece);
    $perecedero=$row_perece['perecedero'];
    $xdatos['perecedero'] = $perecedero;
    $xdatos['categoria']=$row_perece['id_categoria'];
    $xdatos['typeinfo']="Success";
    echo json_encode($xdatos);
  }
  else
  {
    $xdatos['typeinfo']="Error";
    $xdatos['msg']="El codigo ingresado no pertenece a ningun producto";
    echo json_encode($xdatos);
  }
}
function getpresentacion(){
  $id_presentacion =$_REQUEST['id_presentacion'];
  $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
  $precio=$sql['precio'];
  $unidad=$sql['unidad'];
  $descripcion=$sql['descripcion'];
  $costo=$sql['costo'];

  $xc=0;

  $sql_rank=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$id_presentacion AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] AND presentacion_producto_precio.precio!=0 ORDER BY presentacion_producto_precio.desde ASC LIMIT 1
    ");

    while ($rowr=_fetch_array($sql_rank)) {
      # code...
      if($xc==0)
      {

        $precio=$rowr['precio'];
      }
    }
  $xdatos['precio']=$precio;
  $xdatos['costo']=$costo;
  $xdatos['unidad']=$unidad;
  $xdatos['descripcion']=$descripcion;
  echo json_encode($xdatos);
}
//IMPRESION BARCODES !!!
function buscarprodcant(){
  $id_producto= $_POST['id_producto'];
  $cuantos = $_POST['cuantos'];
  $datos = $_POST['datos'];
  $id_sucursal = $_SESSION['id_sucursal'];
  $rollo_seleccionado= $_POST['rollo_seleccionado'];
  //id_sucursal
  $sqlsuc = _query("SELECT descripcion FROM sucursal WHERE id_sucursal='$id_sucursal'");
  $datosuc = _fetch_array($sqlsuc);
  $descripsuc = $datosuc["descripcion"];


  if($rollo_seleccionado == "undefined" || $rollo_seleccionado == "")
  {
    $sql0a = _query("SELECT rollo_etiqueta FROM config_dir WHERE id_sucursal='$id_sucursal'");
    $datos0a = _fetch_array($sql0a);
    $rollo_seleccionado = $datos0a["rollo_etiqueta"];
  }
    $sql0="SELECT  bp.id_producto, pr.precio1, pr.numera, pr.estilo,
    pr.descripcion, pr.talla, c.nombre,pr.id_proveedor, bp.cantidad
    FROM  productos AS pr
    JOIN colores AS c ON (pr.id_color=c.id_color)
    INNER JOIN bcode_pendientes AS bp ON (bp.id_producto=pr.id_producto)";

    $lista=explode('#',$datos);
    $array_prod = array();
    for ($i=0;$i<$cuantos ;$i++){
      // id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + id_presentacion + "#";
      list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$id_presentacion,$how,$barcode)=explode('|',$lista[$i]);
      $sql0="SELECT  pro.id_producto,  pro.descripcion, pe.nombre as despre,
      pre.precio, pre.descripcion AS descpre
      FROM  producto AS pro
      JOIN presentacion_producto AS pre ON (pro.id_producto=pre.id_producto)
      LEFT JOIN presentacion AS pe ON (pre.id_presentacion=pe.id_presentacion)
      WHERE pre.id_producto='$id_producto'
      AND pre.id_pp='$id_presentacion'
      ";
      $result = _query($sql0);
      $numrows= _num_rows($result);
      $row = _fetch_array($result);
      $descripcion=$row['descripcion'];
      $descpre=$row['descpre'];
      $despre=$row['despre'];
      $precio= sprintf('%.2f', $row['precio']);
      if ($how==1) {
        // code...
      }
      else {
        $id_presentacion=$barcode;
      }
      $array_prod[] = array(
        'id_producto' => str_pad($id_presentacion,6,"0",STR_PAD_LEFT),
        'descripcion' => substr($descripcion,0,33),
        'precio'=>  $precio,
        'descpre'=> $descpre,
        'despre'=> substr($despre,0,28),
        'cantidad' => $cantidad,
        'fin' => "|",
      );


    }
  //actualizar si el rollo va de 1 o de 2
  $tb="config_dir";
  $formtb = array(
    'rollo_etiqueta' => $rollo_seleccionado,
  );
  $wc="id_sucursal='".$_SESSION['id_sucursal']."'";
  $updat=_update($tb,$formtb,$wc);

  //Valido el sistema operativo y lo devuelvo para saber a que puerto redireccionar
  $info = $_SERVER['HTTP_USER_AGENT'];
  if(strpos($info, 'Windows') == TRUE)
  $so_cliente='win';
  else
  $so_cliente='lin';
  //$xdatos['array_prod']=$array_prod;
  //directorio de script impresion cliente
  $sql_dir_print="SELECT *  FROM config_dir";
  $result_dir_print=_query($sql_dir_print);
  $row_dir_print=_fetch_array($result_dir_print);
  $dir_print=$row_dir_print['dir_print_script'];
  $shared_printer_barcode=$row_dir_print['shared_print_barcode'];
  $array_prod[] = array(
    'id_producto' => -1,
    'descripcion'=> 'CONF',
    'shared_printer_barcode' =>$shared_printer_barcode,
    'rollo_seleccionadoa' =>$rollo_seleccionado,
    'descripsuc'=> $descripsuc,
    'dir_print' =>$dir_print,
    'sist_ope' =>$so_cliente,
  );
  echo json_encode ($array_prod); //Return the JSON Array

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
    case 'consultar_stock':
    consultar_stock();
    break;
    case 'getpresentacion':
    getpresentacion();
    break;
    case'traerpaginador':
    traerpaginador();
    break;
    case 'buscarprodcant' :
    buscarprodcant();
    break;
  }
}
?>
