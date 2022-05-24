$(document).ready(function() {
  generar();
  $('.select').select2();

  $('.posicion').select2({
    placeholder: {
      id: '', // the value of the option
      text: 'Seleccione'
    },
    allowClear: true
  });
  $(".sel").select2();
});

$('.cant').numeric({negative:false,decimal:false});

$(".cant").attr("maxlength", 8);

$(".86").numeric({negative:false,decimalPlaces:4});

$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {});
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });
  $(document).on('click', '#asignar', function(event) {
    var origen = $('#origen').val();
    location.href = "admin_producto_no_asignado.php?id_origen="+origen;
  });

});

$(document).on('change', '#origen', function(event) {
  generar();

});

function generar() {
  origen = $('#origen').val();
  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    language:
    {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }

    },
    "pageLength": 50,
    "order": [
      [0, 'asc'],
      [1, 'asc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_asignacion_dt.php",
      "data": {
        "origen": origen,
      },

      error: function() { // error handling
        //$(".editable2-error").html("");
        $("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="3">No se encontró información segun busqueda </th></tr></tbody>');
        $("#editable2_processing").css("display", "none");
        $(".editable2-error").remove();
      }
    },
    "aoColumnDefs": [
      { "bSearchable": false,"bSortable":false, "aTargets": [ 3,4 ] }
    ],
    "columnDefs": [{
      "targets": 1, //index of column starting from 0
      orderable: "false",
      "render": function(data, type, full, meta) {
        if (data != null)
          return '<p class="text-success"><strong>' + data + '</strong></p>';
        else
          return '';
      },

    },
    {
      "orderable": false, "targets": 2
    }]
  });
  dataTable.ajax.reload();

  $.ajax({
    url: 'admin_asignacion.php',
    type: 'POST',
    dataType: 'json',
    data: {process: 'noasignados',origen: origen},
    success: function(datax)
    {
      $('#no_asignado').html(datax.productos);
      $('#num_no').html(datax.cantidad);
    }
  });

}
$(document).on('change', '.sel', function(event)
{
  var id_presentacion = $(this).val();
  var a = $(this).parents("tr");
  $.ajax({
    url: 'agregar_asignacion.php',
    type: 'POST',
    dataType: 'json',
    data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion,
    success: function(data)
    {
      a.find('.unidad').val(data.unidad);

      fila = a;
      id_producto = fila.find('.id_producto').val();
      existencia = parseFloat(fila.find('.existencia').val());
      existencia=round(existencia,4);string
      a_cant=parseFloat(fila.find('.cant').val());
      unidad= parseInt(fila.find('.unidad').val());

      a_cant=parseFloat(a_cant*data.unidad);
      round(a_cant, 4);
      console.log(a_cant);

      a_asignar=0;

      $('table tr').each(function(index) {

        if($(this).find('.id_producto').val()==id_producto)
        {
          t_cant=parseFloat($(this).find('.cant').val());
          t_cant=round(t_cant, 4);
          if(isNaN(t_cant))
          {
            t_cant=0;
          }
          t_unidad=parseInt($(this).find('.unidad').val());
          t_cant=parseFloat((t_cant*t_unidad));
          a_asignar=a_asignar+t_cant;
          a_asignar=round(a_asignar,4);
        }
      });
      console.log(existencia);
      console.log(a_asignar);

      if(a_asignar>existencia)
      {
          val = existencia-(a_asignar-a_cant);
          val = val/unidad;
          val=Math.trunc(val);
          val =parseInt(val);
          fila.find('.cant').val(val);
      }
    }
  });
});
$(document).on("change", ".estante", function(event) {
  a=$(this).closest('tr').find('.posicion');
  $(this).closest('tr').find('.posicion').empty().trigger('change');

  var id_estante = $(this).val();
  var id_origen = $('#id_origen').val();
  if (id_estante > 0) {
    $.ajax({
      type: "POST",
      url: "agregar_asignacion.php",
      data: "process=val&id_estante=" + id_estante+"&id_origen=" + id_origen,
      dataType: "JSON",
      success: function(datax) {
        if (datax.typeinfo == "Success") {
          a.html(datax.opt);
        }
      }
    });
  }
});

$(document).on('keyup', '.cant', function(event)
{
  fila = $(this).closest('tr');
  id_producto = fila.find('.id_producto').val();
  existencia = parseFloat(fila.find('.existencia').val());
  existencia=round(existencia,4);
  a_cant=$(this).val();
  unidad= parseInt(fila.find('.unidad').val());
  a_cant=parseFloat(a_cant*unidad);
  a_cant=round(a_cant, 4);

  console.log(a_cant);
  a_asignar=0;

  $('table tr').each(function(index) {

    if($(this).find('.id_producto').val()==id_producto)
    {
      t_cant=parseFloat($(this).find('.cant').val());
      round(t_cant,4);
      if(isNaN(t_cant))
      {
        t_cant=0;
      }
      t_unidad=parseInt($(this).find('.unidad').val());
      t_cant=parseFloat((t_cant*t_unidad));
      a_asignar=a_asignar+t_cant;
      a_asignar=round(a_asignar,4);
    }
  });
  console.log(existencia);
  console.log(a_asignar);

  if(a_asignar>existencia)
  {
      val = existencia-(a_asignar-a_cant);
      val = val/unidad;
      val=Math.trunc(val);
      val =parseInt(val);
      $(this).val(val);
  }
});


$(document).on('click', '#insertar', function(event) {
  $(this).prop("disabled",true);
  verificar=1;

  origen = $('#id_origen').val();
  fecha=$('#fecha').val();
  concepto=$('#concepto').val();

  var array_json = new Array();
  i=0;

  $('table tr').each(function(index) {
    if(index>0)
    {
      id_producto = parseInt($(this).find('.id_producto').val());
      if(isNaN(id_producto))
      {
        id_producto=0;
      }

      t_cant=parseFloat($(this).find('.cant').val());
      round(t_cant, 4);
      if(isNaN(t_cant))
      {
        t_cant=0;
      }

      t_unidad=parseInt($(this).find('.unidad').val());
      if(isNaN(t_unidad))
      {
        t_unidad=0;
      }
      t_cant=parseFloat((t_cant*t_unidad));
      round(t_cant, 4);

      id_estante=parseInt($(this).find('.estante').val());
      if(isNaN(id_estante))
      {
        id_estante=0;
      }

      id_posicion=parseInt($(this).find('.posicion').val());
      if(isNaN(id_posicion))
      {
        id_posicion=0;
      }

      id_presentacion=parseInt($(this).find('.sel').val());
      if(isNaN(id_presentacion))
      {
        id_presentacion=0;
      }

      if(id_presentacion!=0)
      {
        if(id_estante!=0)
        {
          if(t_cant!=0)
          {
            var obj = new Object();
            obj.id_producto = id_producto;
            obj.cantidad = t_cant;
            obj.id_estante= id_estante;
            obj.id_posicion=id_posicion;
            obj.id_presentacion=id_presentacion;
            //convert object to json string
            text = JSON.stringify(obj);
            array_json.push(text);

            i = i + 1;
          }
        }
        else
        {
          verificar=0;
        }
      }



    }

  });

  json_arr = '[' + array_json + ']';

  if(verificar==1&&i>0)
  {
    $.ajax({
      url: 'agregar_asignacion.php',
      type: 'POST',
      dataType: 'json',
      data: {process:"asignar",valores: json_arr,origen: origen,fecha: fecha,concepto:concepto},
      success: function (datax)
      {
        display_notify(datax.typeinfo,datax.msg)
        setInterval(function(){reload1(origen);}, 1000);
      }

    });

  }
  else
  {
    display_notify("Error","Asigne los estantes, y al menos una asignacion mayor a cero");
    $(this).prop("disabled","");
  }


});

function reload1(origen)
{
  location.href = "admin_asignacion.php?id_origen="+origen;
}

function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

$(document).on('click', '.re', function(event) {
  id_su=$(this).attr("id_su");
  id_producto=$(this).attr("id_producto");
  cantidad=$(this).attr("cantidad");
  id_ubicacion =$('#origen').val();

  var array_json = new Array();
  i=1;

    var id_prod = id_producto
    var cant = 1

    var existencia =cantidad;

    var obj = new Object();
    obj.id_prod = id_prod;
    obj.cantidad = cant;
    obj.existencia= existencia;
    //convert object to json string
    text = JSON.stringify(obj);
    array_json.push(text);


  json_arr = '[' + array_json + ']';

  console.log(json_arr);
  console.log(i);

  if(i>0)
  {
    $('#params').val(json_arr);
    $('#id_origen').val(id_ubicacion);
    $('#stock_u').val(id_su);

    $('#frm1').submit();
  }
  else
  {
    display_notify("Warning","Seleccione al menos un producto a asignar y la cantidad de ubicaciones a asignar")
  }


});
