<?php
include ("_core.php");
// Page setup
function initial()
{
  $title = "Kardex de Productos";
  $_PAGE = array ();
  $_PAGE ['title'] = $title;
  $_PAGE ['links'] = null;
  $_PAGE ['links'] .= '<link href="css/bootstrap.min.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="font-awesome/css/font-awesome.css" rel="stylesheet">';
  $_PAGE ['links'] .= '<link href="css/typeahead.css" rel="stylesheet">';
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
  $fini = date("Y")."-".date("m")."-01";
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
                  <div class="col-lg-6">
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
                  <div class="col-md-6">
                    <div class="alert alert-info" id="prod" hidden>
                      <br>
                      <br>
                    </div>
                  </div>
                </div>
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
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
      $("#codigo").keyup(function(evt)
      {
        var code = $(this).val();
        if (evt.keyCode == 13)
        {
          if($(this).val()!="")
          {
            $.ajax({
              type:'POST',
              url:'reporte_kardex.php',
              data:'process=cons&code='+code,
              dataType:'JSON',
              success: function(datax)
              {
                if(datax.typeinfo == "Success")
                {
                  procesar_prod(datax.id, datax.descrip, code);
                }
                else
                {
                    display_notify(datax.typeinfo, datax.msg);
                }
              }
            });
          }
          $(this).val("");
        }
      });
      $("#scrollable-dropdown-menu #producto_buscar").typeahead({
        highlight: true,
      },
      {
        limit:100,
        name: 'productos',
        display: 'producto',
        source: function show(q, cb, cba) {
              console.log(q);
              var url = 'autocomplete_producto3.php' + "?query=" + q;
              $.ajax({ url: url })
                  .done(function(res) {
                      cba(JSON.parse(res));
                  })
                  .fail(function(err) {
                      alert(err);
                  });
          }
      }).on('typeahead:selected', onAutocompleted);

      function onAutocompleted($e, datum) {
          $('.typeahead').typeahead('val', '');
          var prod0=datum.producto;
           var prod= prod0.split("|");
           var id_prod = prod[0];
           var descrip = prod[1];
           procesar_prod(id_prod, descrip,"");
      };

    $("#codigo").focus();
      $("#submit").click(function(){
          print_report();
      });
    });
    $(document).keydown(function(e) {
      if (e.which == 114) { //F3 Cambiar
        e.stopPropagation();
        e.preventDefault();
        if ($('#a').attr('hidden')) {
          $('#a').removeAttr('hidden');
          $('#b').attr('hidden', 'hidden');
          $('#codigo').focus();
        } else {
          $('#b').removeAttr('hidden');
          $('#a').attr('hidden', 'hidden');
          $('#producto_buscar').focus();
        }
      }
    });
    function procesar_prod(id_prod, descrip, code)
    {
      $("#id_producto").val(id_prod);
      $("#prod").show();
      if(code != "")
        descrip = "["+code+"] "+descrip;
      $("#prod").html("<br>Producto seleccionado: "+descrip+"<br>");
    }
    function print_report()
    {
      var id_producto = $("#id_producto").val();
      var fini = $("#fini").val();
      var fin = $("#fin").val();
      if(id_producto !="")
      {
        if(fini !="")
        {
          if(fin !="")
          {
            var url = "kardex.php?id_producto="+id_producto+"&fini="+fini+"&fin="+fin;
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
      else {
        display_notify("Warning","Seleccione un producto");
      }
    }
    </script>
    <?php
  }
  function consultar_prod()
  {
    $code = intval($_REQUEST['code']);
    $id_sucursal=$_SESSION['id_sucursal'];
      $sql_aux = _query("SELECT id_pp as id_presentacion, id_producto FROM presentacion_producto WHERE id_pp='$code' AND activo='1'");
      if(_num_rows($sql_aux)>0)
      {
        $dats_aux = _fetch_array($sql_aux);
        $id_producto = $dats_aux["id_producto"];
        $id_presentacione = $dats_aux["id_presentacion"];
        $clause = "id_producto = '$code'";
      }
      else
      {
        $clause = "barcode = '$code'";
      }
    $sql1 = "SELECT id_producto, descripcion
             FROM producto
             WHERE $clause";
    $prods=_query($sql1);
    if (_num_rows($prods)>0)
    {
      $row_prod = _fetch_array($prods);
      $xdata["id"] = $row_prod["id_producto"];
      $xdata["descrip"] = $row_prod["descripcion"];
      $xdata["typeinfo"] = "Success";
    }
    else
    {
      $xdata["typeinfo"] = "Error";
      $xdata["msg"] = "El codigo ingresado no pertenece a ningun producto";
    }
    echo json_encode($xdata);
  }
  if(!isset($_POST['process'])){
    initial();
  }
  else
  {
      switch ($_POST['process'])
      {
        case 'cons':
        consultar_prod();
          break;
      }
  }
  ?>
