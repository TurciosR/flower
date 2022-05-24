<?php
include_once "_core.php";

function initial()
{
  include ("_core.php");
  $id_movimiento = $_REQUEST['id_movimiento'];
  //permiso del script
  $sql = _query("SELECT producto.descripcion, ubicacion.descripcion as origen,est.descripcion as eo ,pos.posicion as po,ubi.descripcion as destino,estante.descripcion as ed,posicion.posicion as pd,movimiento_stock_ubicacion.cantidad,presentacion_producto.unidad,presentacion.nombre FROM movimiento_stock_ubicacion JOIN producto ON producto.id_producto=movimiento_stock_ubicacion.id_producto LEFT JOIN stock_ubicacion ON stock_ubicacion.id_su=movimiento_stock_ubicacion.id_origen LEFT JOIN ubicacion ON stock_ubicacion.id_ubicacion = ubicacion.id_ubicacion JOIN stock_ubicacion AS su ON su.id_su=movimiento_stock_ubicacion.id_destino LEFT JOIN ubicacion as ubi ON ubi.id_ubicacion=su.id_ubicacion LEFT JOIN estante ON estante.id_estante=su.id_estante LEFT JOIN posicion ON posicion.id_posicion=su.id_posicion LEFT JOIN estante AS est ON est.id_estante=stock_ubicacion.id_estante LEFT JOIN posicion as pos ON stock_ubicacion.id_posicion=pos.id_posicion JOIN presentacion_producto ON movimiento_stock_ubicacion.id_presentacion=presentacion_producto.id_presentacion JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE movimiento_stock_ubicacion.id_sucursal=$_SESSION[id_sucursal] AND movimiento_stock_ubicacion.id_mov_prod=$id_movimiento");
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
  //permiso del script
  ?>
  <div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  	<h4 class="modal-title">Anular Transferencia</h4>
  </div>
  <div class="modal-body">
  	<div class="wrapper wrapper-content  animated fadeInRight">
  		<div class="row" id="row1">
  			<div class="col-lg-12">
  				<?php if ($links!='NOT' || $admin=='1' ){ ?>
  					<table	class="table table-bordered table-striped" id="tableview">
  						<thead>
  							<tr>
  								<th class="col-lg-4" rowspan="2">Producto </th>
  								<th class="col-lg-3" colspan="3">Origen</th>
  								<th class="col-lg-3" colspan="3">Destino</th>

  								<th class="col-lg-1" rowspan="2">Presentación</th>
  								<th class="col-lg-1" rowspan="2">Cantidad</th>
  							</tr>
  							<tr>
  								<th class="col-lg-1">Ubicación</th>
  								<th class="col-lg-1">Estante </th>
  								<th class="col-lg-1">Posición </th>
  								<th class="col-lg-1">Ubicación</th>
  								<th class="col-lg-1">Estante</th>
  								<th class="col-lg-1">Posición</th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php
  							while($row=_fetch_array($sql))
  							{
  								?>
  								<tr>
  									<td><?php echo $row['descripcion'] ?></td>
  									<td><?php echo $row['origen'] ?></td>
  									<td><?php echo $row['eo'] ?></td>
  									<td><?php echo $row['po'] ?></td>
  									<td><?php echo $row['destino'] ?></td>
  									<td><?php echo $row['ed'] ?></td>
  									<td><?php echo $row['pd'] ?></td>
  									<td><?php echo $row['nombre'] ?></td>
  									<td><?php echo $row['cantidad']/$row['unidad']; ?></td>
  								</tr>
  								<?php
  							}
  							?>
  						</tbody>
  					</table>
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
  $table="movimiento_stock_ubicacion";
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




  $sql_su=_query("SELECT movimiento_stock_ubicacion.id_producto,id_origen,id_destino,movimiento_stock_ubicacion.cantidad FROM movimiento_stock_ubicacion WHERE id_mov_prod=$id_movimiento");
  while ($row=_fetch_array($sql_su)) {
    # code...
    $id_producto=$row['id_producto'];
    $id_origen=$row['id_origen'];
    $id_destino=$row['id_destino'];
    $cantidad=$row['cantidad'];

    $sql_s=_query("SELECT cantidad AS stock_origen FROM stock_ubicacion WHERE id_producto=$id_producto  AND id_su=$id_origen");
    $rw=_fetch_array($sql_s);
    $stock_origen=$rw['stock_origen'];

    $sql_a=_query("SELECT cantidad AS stock_destino FROM stock_ubicacion WHERE id_producto=$id_producto  AND id_su=$id_destino");
    $rwa=_fetch_array($sql_a);
    $stock_destino=$rwa['stock_destino'];


    $stock_origen=$stock_origen+$cantidad;
    $stock_destino=$stock_destino-$cantidad;
    if ($stock_destino<0) {
      # code...
      $i=1;
    }
    else {
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

      $form_data = array(
        'cantidad' => $stock_destino,
      );
      $where_clause="id_su='".$id_destino."'";
      $update=_update($table,$form_data,$where_clause);

      if ($update) {
        # code...
      }
      else {
        # code...
        $up2=1;
      }

    }
  }

  if($i==0)
  {
    if ($up==0&&$up2==0)
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
