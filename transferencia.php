<?php
include ("_core.php");
// Page setup
function initial()
{
  $title = "Reporte Transferencia";
  $_PAGE = array ();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/iCheck/custom.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/chosen/chosen.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/animate.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/style.css" rel="stylesheet">';
  include_once "header.php";
  include_once "main_menu.php";
  $id_sucursal=$_SESSION['id_sucursal'];
  $id_user = $_SESSION["id_usuario"];
  date_default_timezone_set('America/El_Salvador');
  $fin = date("Y-m-d");
  $fini = date("Y-m-01");
  $hora_actual = date("H:i:s");
  $id_user=$_SESSION["id_usuario"];
  $admin=$_SESSION["admin"];

  $uri = $_SERVER['SCRIPT_NAME'];
  $filename=get_name_script($uri);
  $links=permission_usr($id_user,$filename);
  //permiso del script
  if ($links!='NOT' || $admin=='1' ){
    ?>

    <div class="wrapper wrapper-content  animated fadeInRight">
      <div class="row" id="row1">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h4><?php echo $title; ?></h4>
            </div>
            <div class="ibox-content">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group has-info single-line">
                      <label>Fecha Inicio</label>
                      <input type="text"  class="form-control datepick" id="fini" value="<?php echo $fini;?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group has-info single-line">
                      <label>Fecha Fin</label>
                      <input type="text"  class="form-control datepick" id="fin" value="<?php echo $fin;?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 form-group">
                    <a class="btn btn-primary pull-right" id="submit" name="submit"><i class="fa fa-print"></i> Imprimir</a>
                    <input type="hidden" id="id_producto">
                  </div>
                </div>
            </div><!--div class='ibox-content'-->
          </div><!--<div class='ibox float-e-margins' -->
          </div> <!--div class='col-lg-12'-->
        </div> <!--div class='row'-->
      </div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
      <?php
      include ("footer.php");
    } //permiso del script
    else
    {
      echo "<br><br><div class='alert alert-warning'>No tiene permiso para este modulo.</div></div></div></div></div>";
      include ("footer.php");
    }
  }
  if(!isset($_POST['process'])){
    initial();
  }
  ?>
  <script type="text/javascript">
  $(document).ready(function(){

    $("#submit").click(function(){
        print_report();
    });
  });
  function print_report()
  {
    var fini = $("#fini").val();
    var fin = $("#fin").val();
      if(fini !="")
      {
        if(fin !="")
        {
          var url = "reporte_transferencia.php?fini="+fini+"&ffin="+fin;
          $("#submit").attr("href",url);
          $("#submit").attr("target","_blank");
          $("#submit").click();
        }
        else {
          display_notify("Warning","Seleccione la fecha final");
        }
      }
      else {
        display_notify("Warning","Seleccione la fecha inicial");
      }

  }
  </script>
