<?php
include_once "_core.php";

function initial()
{
  $title = "Reposición de Producto";
  $_PAGE = array();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/select2/select2.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';

  include_once "header.php";
  include_once "main_menu.php";


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

  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-2"></div>
  </div>
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
                <div class="col-lg-4">
                  <div class="form-group has-info">
                    <label>Concepto</label>
                    <input type='text' readonly class='form-control' value='REPOSICIÓN DE PRODUCTOS' id='concepto' name='concepto'>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class='form-group has-info'><label>Origen</label>
                    <select name='origen' id="origen" class="form-control select">
                    <?php
                    $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                    while($row = _fetch_array($sql))
                    {
                      $sele = "";

                      if ($row["bodega"]==0) {
                        // code...
                        $sele = "selected";
                      }
                      echo "<option $sele value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
                    }
                    ?>
                  </select>
                  </div>
                </div>
                <div class='col-lg-3'>
                  <div class='form-group has-info'>
                    <label  hidden>Fecha</label>
                    <input  type='hidden' class='datepick form-control' value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                  </div>
                </div>
                <div class='col-lg-3'>
                  <div class='form-group has-info'>
                    <label  hidden>Fecha</label>
                    <input  type='hidden' class='datepick form-control' value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
                  </div>
                </div>
              </div>
              <div class="row" id='buscador'>


                <div class="col-lg-12">
                  <div class='form-group has-info'><label>Buscar Productos</label>
                    <input type="text" id="producto_buscar" name="producto_buscar" size="20" class="producto_buscar form-control" placeholder="Ingrese nombre de producto"  data-provide="typeahead">
                  </div>
                </div>
              </div>
              <div class="ibox">
                <div class="row">
                  <div class="ibox-content">

                    <!--load datables estructure html-->
                    <header>
                      <h4 class="text-navy">Lista de Productos</h4>
                    </header>

                    <form id="frm1" class="" target="_self" action="agregar_asignacion.php" method="POST">
                      <input type="hidden" id="params" name="params" value="">
                      <input type="hidden" id="id_origen" name="id_origen" value="<?php echo $origen; ?>">
                      <input type="hidden" id="fecha" name="fecha" value="">
                      <input type="hidden" id="con" name="con" value="">
                    </form>

                  <div  class='widget-content' id="content">
                    <div class="row">
                  <div class="col-md-12">

                    <table class="table table-striped" id='loadtable'>
                      <thead class='thead1'>
                        <tr class='tr1'>
                          <th class="text-success col-lg-1">Id</th>
                          <th class="text-success col-lg-4">Descripción</th>
													<th class="text-success col-lg-1 text-center">Presentación</th>
                          <th class="text-success col-lg-1 text-center">Detalle</th>
                          <th class="text-success col-lg-1 text-center">Costo</th>
                          <th class="text-success col-lg-1 text-center">Precio</th>
                          <th class="text-success col-lg-1 text-center">Unid. Faltantes</th>
                          <th class="text-success col-lg-1 text-center">Existencias ubicación</th>
                          <th class="text-success col-lg-1 text-center">A Reponer</th>
                          <th class="text-success col-lg-1 text-center"></th>
                        </tr>
                      </thead>
                      <tbody class='tbody1 ' id="mostrardatos">
                      </tbody>
                    </table>
                  </div>
                </div>
                <!--/div-->

              </div>
              <div id="paginador"></div>
                    <input type="hidden" name="process" id="process" value="insert"><br>
                    <div>
                      <input type="submit" id="generar" name="generar" value="Asignar" class="btn btn-primary m-t-n-xs" />
                      <input type='hidden' name='urlprocess' id='urlprocess'value="<?php echo $filename ?> ">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div><!--div class='ibox-content'-->
        </div>
      </div>
    </div>
  </div>
<?php
  include_once ("footer.php");
  echo "<script src='js/funciones/funciones_movimiento_pendiente.js'></script>";
} //permiso del script
else
{
    echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
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
  producto AS pr, movimiento_producto_pendiente as su";
  //  $sqlParcial=get_sql($keywords, $id_color, $estilo, $talla, $barcode, $limite);
  $sqlParcial= get_sql($start,$limit,$producto_buscar,$origen,$sortBy);
  $groupBy="";
  $limitSQL= " LIMIT $start,$limit ";
  $sql_final= $sqlJoined." ".$sqlParcial." ".$groupBy." ".$limitSQL;
  $query = _query($sql_final);
  $num_rows = _num_rows($query);
  $filas=0;
  if ($num_rows > 0)
  {
    while ($row = _fetch_array($query))
    {
      $id_producto = $row['id_producto'];
      $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM movimiento_producto_pendiente WHERE movimiento_producto_pendiente.id_producto='$id_producto' AND movimiento_producto_pendiente.id_sucursal='$_SESSION[id_sucursal]' ");
      $dt_existencia = _fetch_array($sql_existencia);
      $existencia = $dt_existencia["existencia"];

      $descripcion=$row["descripcion"];
      $barcode = $row['barcode'];
      $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio
                            FROM presentacion_producto AS prp
                            JOIN presentacion ON presentacion.id_presentacion=prp.presentacion
                            WHERE prp.id_producto=$id_producto
                            AND prp.activo=1 AND prp.unidad=1 AND prp.id_sucursal=$_SESSION[id_sucursal]");
      $i=0;
      $unidadp=0;
      $costop=0;
      $preciop=0;
      $descripcionp="";

      $sql1 = "SELECT SUM(su.cantidad) as stock FROM producto AS p JOIN stock_ubicacion as su ON su.id_producto=p.id_producto JOIN ubicacion as u ON u.id_ubicacion=su.id_ubicacion  WHERE  p.id_producto ='$id_producto' AND u.id_ubicacion=$origen AND su.id_sucursal=$_SESSION[id_sucursal]";
      $stock1=_query($sql1);
      $row1=_fetch_array($stock1);
      $stc=round($row1["stock"],2);

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
      if ($i>0) {
        // code...

      $select.="</select>";
      $input = "<input type='text' readonly class='cant form-control numeric' style='width:100%;'>";
      ?>
      <tr>
        <td class="col-lg-1" class="id_p"><?php echo $id_producto; ?></td>
        <td class='col-lg-5'><input type='hidden' class='unidad' value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
        <td  class='col-lg-1 text-center'><?php echo $select; ?></td>
        <td class='col-lg-1 text-center descp'><?php echo $descripcionp; ?></td>
        <td class='col-lg-1 text-center precio_compra'><?php echo $costop; ?></td>
        <td class='col-lg-1 text-center precio_venta'><?php echo $preciop; ?></td>
        <td class='col-lg-1 text-center exis'><?php echo $existencia; ?></td>
        <td class='col-lg-1 text-center exis_ubi'><?php echo $stc ?></td>
        <td class='col-lg-1 text-center'><?php echo $input; ?></td>
        <td class='col-lg-1 text-center'> <input type="checkbox" style="height:25px; width:25px;" class=' cheke' name="" value=""></td>
      </tr>
      <?php
      $filas+=1;
      }
    }
  }
}
function get_sql($start,$limit,$producto_buscar,$origen,$sortBy)
{
  $andSQL='';
  $id_sucursal= $_SESSION['id_sucursal'];
  $whereSQL=" WHERE pr.id_producto=su.id_producto
  AND su.id_sucursal = '$id_sucursal'
	AND su.repuesto=0

	";
  $andSQL.= "AND  pr.descripcion LIKE '$producto_buscar%'";
  $orderBy=" GROUP BY su.id_producto";
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
    $sql1="SELECT pr.id_producto FROM producto AS pr, movimiento_producto_pendiente AS su";
    $sql_numrows=$sql1.$sqlParcial;
    $queryNum = _query($sql_numrows);
    $dat = _num_rows($queryNum);
    if(_num_rows($queryNum)>0)
    {
      $rowCount = $dat;
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
  $numero_doc=$ult.'_II';
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
    $sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino'";
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
      $where_clause="WHERE id_producto='$id_producto' and id_sucursal='$id_sucursal'";
      $insert_stock = _update($table2,$form_data2, $where_clause );
    }
    if(!$insert_stock)
    {
      $k = 0;
    }
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
        $estado='VENCIDO';
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

  }
  if($insert_mov &&$corr &&$z && $j && $k && $l && $m)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con éxito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!';
  }
  echo json_encode($xdatos);
}

function reponer()
{
	_begin();
	$destino = $_POST['id_origen'];
	$valores=$_POST['params'];
	$id_sucursal=$_SESSION['id_sucursal'];
	$id_usuario=$_SESSION['id_usuario'];

  $cuantos_r=0;
  $datos_r="";
	$array = json_decode($valores, true);
	foreach ($array as $fila) {
		$id_producto =$fila['id_prod'];
		$cantidad=$fila['cantidad'];
		$precio_compra=$fila['precio_compra'];
		$presentacion=$fila['presentacion'];
    $datos_r.=$id_producto . "|" . $precio_compra . "|" . "0.00" . "|" . $cantidad . "|" . "1" . "|" . "" . "|" . $presentacion . "#";
    $cuantos_r= $cuantos_r+1;



  		$sql=_query("SELECT * FROM movimiento_producto_pendiente WHERE id_producto=$id_producto AND id_sucursal=$id_sucursal AND repuesto=0");
		$a_transferir=$cantidad;
    $z=0;
		while ($row=_fetch_array($sql)) {

			# code...
			$fecha_mov_pen=$row['fecha'];
			$hora_mov_pen=$row['hora'];

			$hora_mov_pen = strtotime ('-3 seconds' , strtotime ( $hora_mov_pen ) ) ;
			$hora_mov_pen = date ( 'H:i:s' , $hora_mov_pen );
			$stock_anterior=$row['cantidad'];

			$sql_pv=_fetch_array(_query("SELECT unidad FROM presentacion_producto WHERE id_presentacion=$row[id_presentacion]"));
			$unidades=$sql_pv['unidad'];


			if ($a_transferir!=0) {
				# code...

				$transfiriendo=0;
				$nuevo_stock=$stock_anterior-$a_transferir;
				if ($nuevo_stock<0) {
					# code...
					$transfiriendo=$stock_anterior;
					$a_transferir=$a_transferir-$stock_anterior;
					$nuevo_stock=0;
					$repuesto=1;
				}
				else
				{
					if ($nuevo_stock>0) {
						# code...
						$transfiriendo=$a_transferir;
						$a_transferir=0;
						$nuevo_stock=$stock_anterior-$transfiriendo;
						$repuesto=0;
					}
					else {
						# code...
						$transfiriendo=$stock_anterior;
						$a_transferir=0;
						$nuevo_stock=0;
						$repuesto=1;

					}
				}

        if ($z==0) {
          # code...
          $ok=1;
          while($ok <= 10) {
            $sql_cf=_query("SELECT * FROM movimiento_producto_detalle JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento WHERE movimiento_producto_detalle.id_producto=$id_producto AND movimiento_producto.id_sucursal=$id_sucursal AND  movimiento_producto_detalle.fecha='$fecha_mov_pen' AND movimiento_producto_detalle.hora='$hora_mov_pen' ;");
            $c=_num_rows($sql_cf);

            if ($c==0) {
              # code...
              $ok=11;
            }
            else
            {
              $hora_mov_pen = strtotime ('-3 seconds' , strtotime ( $hora_mov_pen ) ) ;
              $hora_mov_pen = date ( 'H:i:s' , $hora_mov_pen );
            }
          }

          $sql_num = _query("SELECT ii FROM correlativo WHERE id_sucursal='$id_sucursal'");
          $datos_num = _fetch_array($sql_num);
          $ult = $datos_num["ii"]+1;
          $numero_doc=$ult.'_II';
          $tipo_entrada_salida='ENTRADA DE INVENTARIO';
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

            $concepto='ENTRADA DE INVENTARIO';


          /*crear movimineto de carga*/
          $table='movimiento_producto';
          $form_data = array(
            'id_sucursal' => $id_sucursal,
            'correlativo' => $numero_doc,
            'concepto' => $concepto,
            'total' => 0,
            'tipo' => 'ENTRADA',
            'proceso' => 'II',
            'referencia' => $numero_doc,
            'id_empleado' => $id_usuario,
            'fecha' => $fecha_mov_pen,
            'hora' => $hora_mov_pen,
            'id_suc_origen' => $id_sucursal,
            'id_suc_destino' => $id_sucursal,
            'id_proveedor' => 0,
          );
          $insert_mov =_insert($table,$form_data);
          $id_movimiento=_insert_id();
        }


				/*cresamos el stock ubicacion si no existe*/
				$sql_su="SELECT id_su, cantidad FROM stock_ubicacion WHERE id_producto='$id_producto' AND id_sucursal='$id_sucursal' AND id_ubicacion='$destino' AND id_estante=0 AND id_posicion=0";

				$stock_su=_query($sql_su);
				$nrow_su=_num_rows($stock_su);
				$id_su="";
				if($nrow_su >0)
				{
					$row_su=_fetch_array($stock_su);
			    $id_su = $row_su["id_su"];
				}
				else
				{
					$form_data_su = array(
						'id_producto' => $id_producto,
						'id_sucursal' => $id_sucursal,
						'cantidad' => 0,
						'id_ubicacion' => $destino,
					);
					$table_su = "stock_ubicacion";
					$insert_su = _insert($table_su, $form_data_su);
					$id_su=_insert_id();
				}

				/*valor de stock desde donde se va ajustar*/

				$stock_anterior=0;
				$sql_stock_ant=_query("SELECT * FROM movimiento_producto_detalle WHERE id_detalle IN(
        SELECT id_detalle FROM movimiento_producto_detalle
        JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
        WHERE  movimiento_producto_detalle.fecha='$fecha_mov_pen' AND
        movimiento_producto_detalle.hora >='$hora_mov_pen' AND
        movimiento_producto_detalle.id_producto=$id_producto AND
        movimiento_producto.id_sucursal=$id_sucursal
        UNION
        SELECT id_detalle FROM movimiento_producto_detalle
        JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
        WHERE movimiento_producto_detalle.fecha>'$fecha_mov_pen'  AND
        movimiento_producto_detalle.id_producto=$id_producto AND
        movimiento_producto.id_sucursal=$id_sucursal) ORDER BY
        movimiento_producto_detalle.fecha,movimiento_producto_detalle.hora ASC");

				$num_mov_post=_num_rows($sql_stock_ant);

        if ($z==0) {
          # code...
          $fecha_r=$fecha_mov_pen;
          $hora_r=$hora_mov_pen;
        }

				$j=0;
				if ($num_mov_post==0) {
					# code...
					while($row_mod=_fetch_array($sql_stock_ant))
					{
						if ($j==0) {
							# code...
							$stock_anterior=$row_mod['stock_anterior'];

						}
						$j++;
					}
				}
        if ($z==0) {
          # code...
          /*movimiento_anterior de carga mas los nuevos valores*/
  				$table1= 'movimiento_producto_detalle';
  			  $cant_total=$cantidad+$stock_anterior;
  			  $form_data1 = array(
  			    'id_movimiento'=>$id_movimiento,
  			    'id_producto' => $id_producto,
  			    'cantidad' => $cantidad,
  			    'costo' => $precio_compra,
  			    'precio' => 0,
  			    'stock_anterior'=>$stock_anterior,
  			    'stock_actual'=>$cant_total,
  			    'lote' => 0,
  			    'id_presentacion' => $presentacion,
  					'fecha'=>$fecha_mov_pen,
  					'hora'=>$hora_mov_pen,
  			  );
  			  $insert_mov_det = _insert($table1,$form_data1);
        }

        $z++;

        /*movimiento_anterior de descargo*/
        /*movimiento posterior de  descarga*/


        $sql_a=_query("SELECT * FROM movimiento_producto_detalle WHERE id_producto=$id_producto AND id_movimiento=$row[id_movimiento] AND id_presentacion=$row[id_presentacion]");

        if (_num_rows($sql_a)==0) {
          # code...
          $table1= 'movimiento_producto_detalle';
          $form_data1 = array(
            'id_movimiento'=>$row['id_movimiento'],
            'id_producto' => $id_producto,
            'cantidad' => $transfiriendo,
            'costo' => $row['costo'],
            'precio' => $row['precio'],
            'stock_anterior'=>0,
            'stock_actual'=>0,
            'lote' => 0,
            'id_presentacion' => $row['id_presentacion'],
            'fecha'=>$row['fecha'],
            'hora'=>$row['hora'],
          );
          $insert_mov_det = _insert($table1,$form_data1);
        }
        else {
          # code...
            # code...
            $wr=_fetch_array($sql_a);
            $table1= 'movimiento_producto_detalle';
            $form_data1 = array(
              'cantidad' => ($wr['cantidad']+$transfiriendo),
            );
            $where_clause="id_movimiento='".$row['id_movimiento']."' AND id_producto=$id_producto AND id_presentacion=$row[id_presentacion]";
            $insert_mov_det = _update($table1,$form_data1,$where_clause);
        }




        $table1= 'movimiento_producto_pendiente';
				$form_data1 = array(

					'cantidad' => $nuevo_stock,
					'costo' => $precio_compra,
					'repuesto' => $repuesto,
				);
				$where_clause="id_detalle='".$row['id_detalle']."'";
				$insert_mov_det = _update($table1,$form_data1,$where_clause);
			}




		}

    $sql_stock_ant=_query("SELECT movimiento_producto_detalle.*,movimiento_producto.tipo FROM movimiento_producto_detalle JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento WHERE id_detalle IN(
    SELECT id_detalle FROM movimiento_producto_detalle
    JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
    WHERE  movimiento_producto_detalle.fecha='$fecha_r' AND
    movimiento_producto_detalle.hora >='$hora_r' AND
    movimiento_producto_detalle.id_producto=$id_producto AND
    movimiento_producto.id_sucursal=$id_sucursal
    UNION
    SELECT id_detalle FROM movimiento_producto_detalle
    JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
    WHERE movimiento_producto_detalle.fecha>'$fecha_r'  AND
    movimiento_producto_detalle.id_producto=$id_producto AND
    movimiento_producto.id_sucursal=$id_sucursal) ORDER BY
    movimiento_producto_detalle.fecha,movimiento_producto_detalle.hora ASC");
    $stock=0;
    $w=0;
    while($row_f=_fetch_array($sql_stock_ant))
    {

      if ($w=0) {
        $stock=$row_f['stock_actual'];
      }
      else {
        $tipo=$row_f['tipo'];

        if ($tipo=="ENTRADA") {
          # code...
          $table="movimiento_producto_detalle";
          $form_data = array(
            'stock_anterior' => $stock,
            'stock_actual'=> ($stock+$row_f['cantidad']),
          );
          $where_clause="id_detalle='".$row_f['id_detalle']."'";
          $update=_update($table,$form_data,$where_clause);

          $stock=$stock+$row_f['cantidad'];
        }
        else {
          $table="movimiento_producto_detalle";
          $form_data = array(
            'stock_anterior' => $stock,
            'stock_actual'=> ($stock-$row_f['cantidad']),
          );
          $where_clause="id_detalle='".$row_f['id_detalle']."'";
          $update=_update($table,$form_data,$where_clause);

          $stock=$stock-$row_f['cantidad'];
        }
      }
      $w++;

    }

    $a=restar_meses($fecha_r,12);
    $sql_stock_ant=_query("
    SELECT movimiento_producto_detalle.*,movimiento_producto.tipo FROM movimiento_producto_detalle
    JOIN movimiento_producto on movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
    WHERE movimiento_producto_detalle.fecha>'".$a."'  AND
    movimiento_producto_detalle.id_producto=$id_producto AND
    movimiento_producto.id_sucursal=$id_sucursal  ORDER BY
    movimiento_producto_detalle.fecha,movimiento_producto_detalle.hora ASC");
    $stock=0;
    $w=0;
    while($row_f=_fetch_array($sql_stock_ant))
    {

      if ($w=0) {
        $stock=$row_f['stock_actual'];
      }
      else {
        $tipo=$row_f['tipo'];

        if ($tipo=="ENTRADA") {
          # code...
          $table="movimiento_producto_detalle";
          $form_data = array(
            'stock_anterior' => $stock,
            'stock_actual'=> ($stock+$row_f['cantidad']),
          );
          $where_clause="id_detalle='".$row_f['id_detalle']."'";
          $update=_update($table,$form_data,$where_clause);

          $stock=$stock+$row_f['cantidad'];
        }
        else {
          $table="movimiento_producto_detalle";
          $form_data = array(
            'stock_anterior' => $stock,
            'stock_actual'=> ($stock-$row_f['cantidad']),
          );
          $where_clause="id_detalle='".$row_f['id_detalle']."'";
          $update=_update($table,$form_data,$where_clause);

          $stock=$stock-$row_f['cantidad'];
        }
      }
      $w++;

    }

	}

	if ($insert_mov&&$insert_mov_det&&$corr) {
		# code...
    $fecha_r=date("Y-m-d");
    descargar($cuantos_r,$datos_r,$destino,$fecha_r,0,"");
	}
	else {
		# code...
		_rollback();
		$xdatos['typeinfo']="Error";
		$xdatos['msj']="Registro no pudo ser ingresado";
    echo json_encode($xdatos);
	}

}
function descargar($cuantos,$datos,$origen,$fecha,$total_compras,$concepto)
{
  $hora=date("H:i:s");
  $fecha_movimiento = date("Y-m-d");
  $id_empleado=$_SESSION["id_usuario"];

  $id="REPOSICION";

  $id_sucursal = $_SESSION["id_sucursal"];
  $sql_num = _query("SELECT di FROM correlativo WHERE id_sucursal='$id_sucursal'");
  $datos_num = _fetch_array($sql_num);
  $ult = $datos_num["di"]+1;
  $numero_doc=str_pad($ult,7,"0",STR_PAD_LEFT).'_DI';
  $tipo_entrada_salida='DESCARGO DE INVENTARIO';
  $z=1;
  $up=1;

  /*actualizar los correlativos de DI*/
  $corr=1;
  $table="correlativo";
  $form_data = array(
    'di' =>$ult
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
    $concepto='DESCARGO DE INVENTARIO';
  }

  $concepto=$concepto."|".$id;
  $table='movimiento_producto';
  $form_data = array(
    'id_sucursal' => $id_sucursal,
    'correlativo' => $numero_doc,
    'concepto' => $concepto,
    'total' => $total_compras,
    'tipo' => 'SALIDA',
    'proceso' => 'DI',
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

    $id_producto;
    $cantidad=$cantidad*$unidades;
    $a_transferir=$cantidad;

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

        $table="movimiento_stock_ubicacion";
        $form_data = array(
          'id_producto' => $id_producto,
          'id_origen' => $id_su1,
          'id_destino'=> 0,
          'cantidad' => $cantidad,
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
      'fecha' => $fecha_movimiento,
      'hora' => $hora,
      'id_presentacion' => $id_presentacion,
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
  if($insert_mov &&$corr &&$z && $j && $k && $l && $m)
  {
    _commit();
    $xdatos['typeinfo']='Success';
    $xdatos['msg']='Registro ingresado con éxito!';
  }
  else
  {
    _rollback();
    $xdatos['typeinfo']='Error';
    $xdatos['msg']='Registro de no pudo ser ingresado!';
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
  $id_presentacion =$_REQUEST['id_presentacion'];
  $sql=_fetch_array(_query("SELECT * FROM presentacion_producto WHERE id_presentacion=$id_presentacion"));
  $precio=$sql['precio'];
  $unidad=$sql['unidad'];
  $descripcion=$sql['descripcion'];
  $costo=$sql['costo'];
  $xdatos['precio']=$precio;
  $xdatos['costo']=$costo;
  $xdatos['unidad']=$unidad;
  $xdatos['descripcion']=$descripcion;
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
		case'reponer':
    reponer();
    break;
  }
}
?>
