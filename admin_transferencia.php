<?php
include_once "_core.php";

function initial()
{
  $title = "Transferencia de Producto";
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
                    <input type='text' class='form-control' value='TRANSFERENCIA DE PRODUCTOS' id='concepto' name='concepto'>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class='form-group has-info'><label>Origen</label>
                    <select name='origen' id="origen" class="form-control select">
                    <?php
                    $sql = _query("SELECT * FROM ubicacion WHERE id_sucursal='$id_sucursal' ORDER BY descripcion ASC");
                    while($row = _fetch_array($sql))
                    {
                      echo "<option value='".$row["id_ubicacion"]."'>".$row["descripcion"]."</option>";
                    }
                    ?>
                  </select>
                  </div>
                </div>
                <div class='col-lg-4'>
                  <div class='form-group has-info'>
                    <label>Fecha</label>
                    <input type='text' class='datepick form-control' value='<?php echo $fecha_actual; ?>' id='fecha1' name='fecha1'>
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

                    <form id="frm1" class="" target="_self" action="agregar_transferencia.php" method="POST">
                      <input type="hidden" id="params" name="params" value="">
                      <input type="hidden" id="id_origen" name="id_origen" value="">
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
                          <th class="text-success col-lg-6">Descripción</th>
                          <th class="text-success col-lg-1 text-center">Detalle</th>
                          <th class="text-success col-lg-1 text-center">Costo</th>
                          <th class="text-success col-lg-1 text-center">Precio</th>
                          <th class="text-success col-lg-1 text-center">Exis Unid.</th>
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
                      <input type="submit" id="generar" name="generar" value="Transferir" class="btn btn-primary m-t-n-xs" />
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
  echo "<script src='js/funciones/funciones_transferencia.js'></script>";
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
  producto AS pr, stock_ubicacion as su";
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
      $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$origen'");
      $dt_existencia = _fetch_array($sql_existencia);
      $existencia = round($dt_existencia["existencia"],4);

      $descripcion=$row["descripcion"];
      $barcode = $row['barcode'];
      $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_presentacion,prp.unidad,prp.costo,prp.precio
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
      $input = "<input type='text' readonly class='cant form-control numeric' style='width:100%;'>";
      ?>
      <tr>
        <td class="col-lg-1" class="id_p"><?php echo $id_producto; ?></td>
        <td class='col-lg-5'><input type='hidden' class='unidad' value='<?php echo $unidadp; ?>'><?php echo $descripcion; ?></td>
        <!--<td class='col-lg-1 text-center'><?php echo $select; ?></td>-->
        <td class='col-lg-1 text-center descp'><?php echo $descripcionp; ?></td>
        <td class='col-lg-1 text-center precio_compra'><?php echo $costop; ?></td>
        <td class='col-lg-1 text-center precio_venta'><?php echo $preciop; ?></td>
        <td class='col-lg-1 text-center exis'><?php echo $existencia; ?></td>
        <td class='col-lg-1 text-center'> <input type="checkbox" class='form-control cheke' name="" value=""></td>
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
  $whereSQL=" WHERE pr.id_producto=su.id_producto
  AND su.id_ubicacion = '$origen'
  AND su.cantidad >= 0
  AND su.id_sucursal = '$id_sucursal'";
  $andSQL.= "AND  pr.descripcion LIKE '$producto_buscar%'";
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
  }
}
?>
