$(document).ready(function() {
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

$(".cant").attr("maxlength", 7);

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


$(document).on('change', '.sel', function(event)
{
  var id_presentacion = $(this).val();
  var a = $(this).parents("tr");
  $.ajax({
    url: 'agregar_transferencia.php',
    type: 'POST',
    dataType: 'json',
    data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion,
    success: function(data)
    {
      a.find('.unidad').val(data.unidad);

      fila = a;
      id_producto = fila.find('.id_producto').val();
      existencia = parseFloat(fila.find('.existencia').val());
      existencia=round(existencia,4);
      a_cant=parseFloat(fila.find('.cant').val());
      unidad= parseInt(fila.find('.unidad').val());

      a_cant=parseFloat(a_cant*data.unidad);
      a_cant=round(a_cant, 4);
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
      url: "agregar_transferencia.php",
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
      t_cant=round(t_cant, 4);

      id_destino=parseInt($('#destiny').val());
      if(isNaN(id_destino))
      {
        id_destino=0;
      }

      id_presentacion=parseInt($(this).find('.sel').val());
      if(isNaN(id_presentacion))
      {
        id_presentacion=0;
      }

      if(id_presentacion!=0)
      {
        if(id_destino!=0)
        {
          if(t_cant!=0)
          {
            var obj = new Object();
            obj.id_producto = id_producto;
            obj.cantidad = t_cant;
            obj.id_destino= id_destino;
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
      url: 'agregar_transferencia.php',
      type: 'POST',
      dataType: 'json',
      data: {process:"transferir",valores: json_arr,origen: origen,fecha: fecha,concepto:concepto},
      success: function (datax)
      {
        display_notify(datax.typeinfo,datax.msg)
        setInterval(function(){reload1(origen);}, 1000);
      }

    });

  }
  else
  {
    display_notify("Error","Asigne el destino, y al menos una Transferencia mayor a cero");
    $(this).prop("disabled","");
  }


});

function reload1(origen)
{
  location.href = "admin_movimiento_asignacion.php?id_origen="+origen;
}

function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}
