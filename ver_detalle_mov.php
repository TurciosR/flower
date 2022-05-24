<?php
include ("_core.php");
$id_movimiento = $_REQUEST['id_movimiento'];
//permiso del script
$sql = _query("SELECT producto.descripcion, ubicacion.descripcion as origen,est.descripcion as eo ,pos.posicion as po,ubi.descripcion as destino,estante.descripcion as ed,posicion.posicion as pd,movimiento_stock_ubicacion.cantidad,presentacion_producto.unidad,presentacion.nombre FROM movimiento_stock_ubicacion JOIN producto ON producto.id_producto=movimiento_stock_ubicacion.id_producto LEFT JOIN stock_ubicacion ON stock_ubicacion.id_su=movimiento_stock_ubicacion.id_origen LEFT JOIN ubicacion ON stock_ubicacion.id_ubicacion = ubicacion.id_ubicacion LEFT JOIN stock_ubicacion AS su ON su.id_su=movimiento_stock_ubicacion.id_destino LEFT JOIN ubicacion as ubi ON ubi.id_ubicacion=su.id_ubicacion LEFT JOIN estante ON estante.id_estante=su.id_estante LEFT JOIN posicion ON posicion.id_posicion=su.id_posicion LEFT JOIN estante AS est ON est.id_estante=stock_ubicacion.id_estante LEFT JOIN posicion as pos ON stock_ubicacion.id_posicion=pos.id_posicion JOIN presentacion_producto ON movimiento_stock_ubicacion.id_presentacion=presentacion_producto.id_pp JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE movimiento_stock_ubicacion.id_sucursal=$_SESSION[id_sucursal] AND movimiento_stock_ubicacion.id_mov_prod=$id_movimiento");
$id_user=$_SESSION["id_usuario"];
$admin=$_SESSION["admin"];

$uri = $_SERVER['SCRIPT_NAME'];
$filename=get_name_script($uri);
$links=permission_usr($id_user,$filename);
//permiso del script
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Detalle movimiento</h4>
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
									<td><?php echo $row['nombre']."($row[unidad])" ?></td>
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
		<?php
		echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
		</div><!--/modal-footer -->";
	} //permiso del script
	else {
		echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
	}
	?>
