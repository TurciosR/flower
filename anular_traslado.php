<?php
include_once "_core.php";

function initial()
{
  include ("_core.php");
  $id_movimiento = $_REQUEST['id_movimiento'];
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
  //permiso del script
  ?>
  <div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  	<h4 class="modal-title">Anular Traslado</h4>
  </div>
  <div class="modal-body">
  	<div class="wrapper wrapper-content  animated fadeInRight">
  		<div class="row" id="row1">
  			<div class="col-lg-12">
  				<?php if ($links!='NOT' || $admin=='1' ){ ?>
            <div class="alert alert-warning" role="alert">
              ¿Esta seguro de anular este traslado?
            </div>

  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="modal-footer">
      <button type='button' id="anular" name="anular" class='btn btn-danger'>Anular</button>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
      <input type="hidden" id="id_movimiento" name="id_movimiento" value="<?php echo $id_movimiento ?>">
  	</div><!--/modal-footer -->
  		<?php
  	} //permiso del script
  	else {
  		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
  	}
}
function anular()
{
  _begin();
  $id_movimiento = $_POST["id_movimiento"];
  $up=0;
  $up2=0;
  $i=0;
  $an=0;
  $table="movimiento_stock_ubicacion";
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_sucursal=$_SESSION['id_sucursal'];
  $form_data = array(
    'anulada' => 1,
  );
  $where_clause="id_mov_prod='".$id_movimiento."'";
  $update=_update($table,$form_data,$where_clause);

  if ($update) {
    # code...
  }
  else {
    # code...
    $up=1;
  }

  $sel=_fetch_array(_query("SELECT id_traslado FROM movimiento_producto WHERE id_movimiento=$id_movimiento"));
  $id_traslado=$sel['id_traslado'];

  $table="traslado";
  $form_data = array
  (
    'anulada' => 1,
    'anulada' => 1,
  );
  $where_clause="id_traslado='".$id_traslado."'";
  $update=_update($table,$form_data,$where_clause);

  if ($update) {
    # code...

  }
  else {
    # code...
    $an=1;
  }

  $sql_su=_query("SELECT movimiento_stock_ubicacion.id_producto,id_origen,id_destino,movimiento_stock_ubicacion.cantidad,movimiento_stock_ubicacion.id_presentacion FROM movimiento_stock_ubicacion WHERE id_mov_prod=$id_movimiento");
  while ($row=_fetch_array($sql_su)) {
    # code...
    $id_producto=$row['id_producto'];
    $id_origen=$row['id_origen'];
    $id_destino=$row['id_destino'];
    $cantidad=$row['cantidad'];
    $id_presentacion=$row['id_presentacion'];

    $sql_s=_query("SELECT cantidad AS stock_origen FROM stock_ubicacion WHERE id_producto=$id_producto  AND id_su=$id_origen");
    $rw=_fetch_array($sql_s);
    $stock_origen=$rw['stock_origen'];


    $stock_origen=$stock_origen+$cantidad;

      # code...
      $table="stock_ubicacion";
      $form_data = array(
        'cantidad' => $stock_origen,
      );
      $where_clause="id_su='".$id_origen."'";
      $update=_update($table,$form_data,$where_clause);

      if ($update) {
        # code...
      }
      else {
        # code...
        $up2=1;
      }
      $sql_stock=_fetch_array(_query("SELECT id_stock,stock FROM stock WHERE id_producto='".$id_producto."' AND id_sucursal=$_SESSION[id_sucursal]"));
      $sql_stock_anterior=$sql_stock['stock'];
      $stock_nuevo=$sql_stock_anterior+$cantidad;
      $id_stock=$sql_stock['id_stock'];

      $xc=0;
      $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
      $precio_venta=$sql['precio'];
      $precio_costo=$sql['costo'];
      $id_producto=$sql['id_producto'];
      $sql_rank=_query("SELECT id_prepd,desde,hasta,precio
                        FROM presentacion_producto_precio
                        WHERE id_presentacion=$id_presentacion
                        AND id_sucursal=$id_sucursal
                        AND '100' >= desde
                        AND precio>0
                        ORDER BY precio DESC");

      while ($rowr=_fetch_array($sql_rank))
      {
        if(!$xc)
        {
          $precio_venta=$rowr['precio'];
          $xc=1;
        }
      }
      if (_num_rows($sql_rank)==0) {
        # code...
      }

      $table1= 'movimiento_producto_detalle';
      $cant_total=$sql_stock_anterior+$cantidad;
      $form_data1 = array(
        'id_movimiento'=>$id_movimiento,
        'id_producto' => $id_producto,
        'cantidad' => $cantidad,
        'costo' => $precio_costo,
        'precio' => $precio_venta,
        'stock_anterior'=>$sql_stock_anterior,
        'stock_actual'=>$cant_total,
        'lote' => 0,
        'id_presentacion' => $id_presentacion,
        'fecha' => $fecha_movimiento,
        'hora' => $hora
      );
      $insert_mov_det = _insert($table1,$form_data1);
      if(!$insert_mov_det)
      {
        $j = 0;
      }

      $table="stock";
      $form_data = array(
        'stock' => $stock_nuevo,
      );
      $where_clause="id_stock='".$id_stock."'";

      $update=_update($table,$form_data,$where_clause);
      if ($update) {
        # code...
      }
      else {
        # code...
        $up=1;
      }
    $sql_lot = _query("SELECT MAX(numero) AS ultimo FROM lote WHERE id_producto='$id_producto'");
    $datos_lot = _fetch_array($sql_lot);
    $lote = $datos_lot["ultimo"]+1;



    $sql_lote = _query("SELECT MAX(lote.vencimiento) as vence FROM lote WHERE lote.id_producto='$id_producto'");
    $datos_lote = _fetch_array($sql_lote);
    $fecha_caduca = $datos_lote["vence"];

    $sql_costo = _query("SELECT costo FROM presentacion_producto WHERE id_presentacion=$id_presentacion");
    $datos_costo = _fetch_array($sql_costo);
    $precio = $datos_costo["costo"];

    $estado='VIGENTE';
    $table_perece='lote';
    $form_data_perece = array(
      'id_producto' => $id_producto,
      'referencia' => $id_movimiento,
      'numero' => $lote,
      'fecha_entrada' => date("Y-m-d"),
      'vencimiento'=>$fecha_caduca,
      'precio' => $precio,
      'cantidad' => $cantidad,
      'estado'=>$estado,
      'id_sucursal' => $_SESSION['id_sucursal'],
      'id_presentacion' => $id_presentacion,
    );
    $insert_lote = _insert($table_perece,$form_data_perece );

  }

  if($i==0)
  {
    if ($up==0&&$up2==0&&$an==0)
    {
      _commit();
      $xdatos['typeinfo']='Success';
      $xdatos['msg']='Registro ingresado correctamente!';
      $xdatos['process']='insert';
    }
    else
    {
      _rollback();
      $xdatos['typeinfo']='Error';
      $xdatos['msg']='Registro no pudo ser ingresado!';
      $xdatos['process']='none';
    }
 }
 else {
   _rollback();
   $xdatos['typeinfo']='Error';
   $xdatos['msg']='Stock insuficiente para realizar anulación!'.$stock_destino;
   $xdatos['process']='none';
 }
echo json_encode($xdatos);
}

if (!isset($_POST['process'])) {
  initial();
} else {
  if (isset($_POST['process'])) {
    switch ($_POST['process']) {
      case 'anular':
      anular();
      break;
    }
  }
}
?>
