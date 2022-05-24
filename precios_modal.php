<?php
include_once "_core.php";

function initial()
{
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $unidad=$_REQUEST['unidad'];
  $presentacion=$_REQUEST['presentacion'];
  $id_producto=$_REQUEST['id_producto'];
  $id_sucursal=$_SESSION['id_sucursal'];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
  //permiso del script
  ?>
  <div class="modal-header">
    <h4 class="modal-title">Agregar Precios</h4>
  </div>
  <div class="modal-body">
    <input type="hidden" id="un" name="un" value="<?php echo $unidad ?>">
    <input type="hidden" id="pr" name="pr" value="<?php echo $presentacion ?>">
    <div class="wrapper wrapper-content  animated fadeInRight">
      <div class="row" id="row1">
        <div class="col-lg-12">
          <?php if(true){ ?>
            <div class="row">
              <div class="col-lg-3">
                <label>Desde</label>
                <input id="desde" class="form-control int" type="text" name="" value="">
              </div>
              <div class="col-lg-3">
                <label>Hasta</label>
                <input id="hasta" class="form-control int" type="text" name="" value="">
              </div>
              <div class="col-lg-3">
                <label>Precio</label>
                <input id="precio" class="form-control " type="text" name="" value="">
              </div>
              <div class="col-lg-3">
                <label>Agregar</label> <br>
                <button type="button" class="btn btn-primary" id="add" name="add">Agregar</button>
              </div>
            </div>
                <br>
                <table id="precios" class="table table-striped table-bordered  table-sm">
                  <thead>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Precio</th>
                    <th>Accion</th>
                  </thead>
                  <tbody>
                    <?php
                    if ($id_producto!=0) {
                      # code...
                      $sql_a=_query("SELECT presentacion_producto_precio.id_prepd,presentacion_producto_precio.desde,presentacion_producto_precio.hasta,presentacion_producto_precio.precio FROM presentacion_producto_precio WHERE presentacion_producto_precio.id_presentacion=$presentacion AND presentacion_producto_precio.id_sucursal=$_SESSION[id_sucursal] ORDER BY presentacion_producto_precio.desde ASC");

                      while ($row=_fetch_array($sql_a)) {
                        # code...
                        ?>
                        <tr>
                          <td><?php echo $row['desde'] ?>  <input type="hidden" class="id_prepp" value="<?php echo $row['id_prepd'] ?>"> </td>
                          <td><?php echo $row['hasta'] ?></td>
                          <td><?php echo $row['precio'] ?></td>
                          <td class="text-center"> <a class="btn del"><i class="fa fa-trash"></i></a> </td>
                        </tr>
                        <?php
                      }
                    }

                     ?>
                  </tbody>
                </table>
                <?php
                if ($id_producto!=0) {
                  ?>
                  <input type="hidden" id="presen" name="presen" value="<?php echo $presentacion ?>">
                  <?php
                }
                 ?>
                <div class="row">
                  <div class="col-lg-12">
                    <button class="btn btn-primary" type="button" id="add_p" name="add_p">Agregar Todo</button>

                    <button style="display:none" type="button" class="btn btn-default ygg" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
      proceso=$("#process").val();
      if(proceso=="insert")
      {
        valor = $("#pr").val();
        unidad_pre =$("#un").val();
        previos="";
        $("#presentacion_table tr").each(function() {
          var id_pp = $(this).find(".presentacion").val();
          if (id_pp == valor) {
            if (unidad_pre == $(this).find(".unidad_p").text()) {
                a=$(this).closest('tr');
                previos=a.find(".precios_pre").val();
                var str = previos;
                if (previos!="") {
                  var arr = str.split('#')
                  var obj = {};

                  for (i = 0; i < arr.length-1; i++) {
                    var arr2 = arr[i].split('|');
                    tar="<tr><td>"+arr2[0]+"</td><td>"+arr2[1]+"</td><td>"+arr2[2]+"</td><td class='text-center'>"+"<a class=' Delete'><i class='fa fa-trash'></i></a>"+"</td></tr>"
                    $("#precios>tbody").append(tar);
                  }
                }

            }
          }

        });

      }


      $("#precio").numeric({
        negative: false,
        decimalPlaces: 2
      });
      $(".int").numeric({
        negative: false,
        decimal: false
      });
    });
    </script>

    <?php

  }
  else
  {
    $mensaje = mensaje_permiso();
  	echo "<br><br>$mensaje<div><div></div></div</div></div>";
  	include "footer.php";
  }
}
function insert()
{
}

if (!isset($_POST['process'])) {
  initial();
} else {
  if (isset($_POST['process'])) {
    switch ($_POST['process']) {
      case 'insert':
      insert();
      break;
    }
  }
}
?>
