function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}
$(document).ready(function() {
  $(".sel").select2();
  $('#formulario').validate({
    rules: {
      descripcion: {
        required: true,
      },
      precio1: {
        required: true,
        number: true,
      },
    },
    submitHandler: function(form) {
      senddata();
    }
  });

  //select2 select autocomplete
  $(".select_depa").select2();
  $(".select_muni").select2();
  $('#categoria').select2();
  $('#categoria').select2();
  $('#tipo_entrada').select2();
  $('#vendedor').select2();
  $('#origen').select2();

  $("#fecha1").datepicker({
    format: 'dd-mm-yyyy',
  })
  $("#fecha_entrega").datepicker({
    format: 'dd-mm-yyyy',
  })


  // //$('#buscador').hide();
  // $("#producto_buscar").typeahead({
  //   source: function(query, process) {
  //     //var textVal=$("#producto_buscar").val();
  //     $.ajax({
  //       url: 'facturacion_autocomplete.php',
  //       type: 'POST',
  //       data: 'query=' + query,
  //       dataType: 'JSON',
  //       async: true,
  //       success: function(data) {
  //         process(data);
  //
  //       }
  //     });
  //   },
  //   updater: function(selection) {
  //     var prod0 = selection;
  //     var prod = prod0.split("|");
  //     var id_prod = prod[0];
  //     var descrip = prod[1];
  //     var marca = prod[2];
  //     // alert(id_prod);
  //     agregar_producto_lista(id_prod, descrip, marca);
  //   }
  // });

  $("#scrollable-dropdown-menu #producto_buscar").typeahead({
    highlight: true,
  },
  {
  	limit:100,
    name: 'productos',
    display: 'producto',
  	source: function show(q, cb, cba) {
          console.log(q);
          var url = 'autocomplete_producto2.php' + "?query=" + q;
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

  		$('#producto_buscar').typeahead('val', '');

  		var prod0=datum.producto;
  		 var prod= prod0.split("|");
  		 var id_prod = prod[0];
  		 var descrip = prod[1];
  			var marca = prod[2];

        page_num = 0;

        var producto_buscar = $('#producto_buscar').val();
        var origen = $('#origen').val();
        // agregar_producto_lista(id_prod, descrip, marca);
        getData(id_prod, origen, page_num);
  }

  $("#scrollable-dropdown-menu #cliente_buscar").typeahead({
    highlight: true,
  },
  {
    limit:100,
    name: 'persona',
    display: 'persona',
  	source: function show(q, cb, cba) {
          console.log(q);
          var url = 'autocomplete_cliente.php' + "?query=" + q;
          $.ajax({ url: url })
              .done(function(res) {
                  cba(JSON.parse(res));
              })
              .fail(function(err) {
                  alert(err);
              });
      },
      templates: {
    suggestion: function(data) {
      var prod= data.persona.split("|");
    return '<div class="tt-suggestion tt-selectable">' + prod[1] + '</div>'+'';
  }}
  }).on('typeahead:selected', onAutocompleted1);

  function onAutocompleted1($e, datum) {

  		$('#cliente_buscar').typeahead('val', '');
      var data0=datum.persona;
 		 var data= data0.split(" | ");
 		 var id_persona = data[0];
 		 var nombre_persona =data[1];
     console.log("AKI "+id_persona+" "+nombre_persona);

 		 //$("#id_producto").val(id_data);
 		 $("#id_cliente").val(id_persona);
 		 $("#text_cliente").attr('type', 'text');
 		 $("#text_cliente").val(nombre_persona);
 		 //$("#cliente").attr('type', 'hidden');
     $("#cliente_buscar").closest("div").attr("hidden", true);
 		 //$("#cliente").attr('disabled', true);
 		 //console.log(id_persona);
  }
  // $("#cliente").typeahead({
  //   source: function(query, process) {
  //     //var textVal=$("#producto_buscar").val();
  //     $.ajax({
  //       url: 'autocomplete_cliente.php',
  //       type: 'POST',
  //       data: 'query=' + query,
  //       dataType: 'JSON',
  //       async: true,
  //       success: function(data) {
  //         process(data);
  //
  //       }
  //     });
  //   },
  //   updater: function(selection) {
  //     var prod0 = selection;
  //     var prod = prod0.split("|");
  //     var id_cliente = prod[0];
  //     var nombre = prod[1];
  //
  //     $("#cliente").attr("type", "hidden");
  //     $("#text_cliente").attr("type","text");
  //     $("#text_cliente").val(nombre);
  //     $("#id_cliente").val(id_cliente);
  //
  //     $.ajax({
  //       type: 'POST',
  //       url: 'pedido.php',
  //       data: "process=datos_cliente&id_cliente="+id_cliente,
  //       dataType: 'json',
  //       success: function(datax)
  //       {
  //         //process = datax.process;
  //         var select_depa = datax.select_depa;
  //         var select_muni = datax.select_muni;
  //         var direccion = datax.direccion;
  //
  //         $(".depa").html(select_depa);
  //         $(".muni").html(select_muni);
  //         $("#direccion").val(direccion);
  //
  //         $(".select_depa").select2();
  //         $(".select_muni").select2();
  //       }
  //     });
  //   }
  // });

});
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });

});

$(document).on("click", "#text_cliente", function()
{
  $("#cliente").attr("type", "text");
  $("#text_cliente").attr("type","hidden");
  $("#text_cliente").val("");
  $("#id_cliente").val("");

})

$("#select_depa").change(function()
{
  $("#select_muni *").remove();
  $("#select2-select_muni-container").text("");
  var ajaxdata = { "process" : "municipio", "id_departamento": $("#select_depa").val() };
    $.ajax({
        url:"pedido.php",
        type: "POST",
        data: ajaxdata,
        success: function(opciones)
        {
      $("#select2-select_muni-container").text("Seleccione");
          $("#select_muni").html(opciones);
          $("#select_muni").val("");
      }
    })
});


function getData(producto_buscar, origen, page_num) {
  var sortBy = 'asc'; //$('#sortBy').val();
  var records = 50; //$('#records').val();
  urlprocess = "pedido.php";
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: {
      process: 'traerdatos',
      page: page_num,
      producto_buscar: producto_buscar,
      origen: origen,
      sortBy: sortBy,
      records: records
    },
    beforeSend: function() {
      $('.loading-overlay').show();
    },
    success: function(html) {
      $('#mostrardatos').find('input:checkbox:not(:checked)').closest('tr').remove();
      $('#mostrardatos').prepend(html);


      $(".sel").select2();
      $(".cant").numeric({
        decimal: false,
        negative: false
      });

      $(".select2-dropdown").hide();

      $('#mostrardatos tr:first-child').find('.sel').select2("open");

    }
  });
}

// Evento para seleccionar una opcion y mostrar datos en un div
$(document).on("change", "#tipo_entrada", function() {
  $(".datepick2").datepicker();
  $('#id_proveedor2').select2();
  $('#id_proveedor3').select2();
  $('#id_sucursal3').select2();
  var id = $("select#tipo_entrada option:selected").val();

  if (id != '0')
    $('#buscador').show();
  else
    $('#buscador').hide();


});



// Agregar productos a la lista del inventario
function agregar_producto_lista(id_prod, descrip, costo) {
  var id_prev = "";
  //var costo_prom=0;
  var dataString = 'process=consultar_stock' + '&id_producto=' + id_prod;
  $.ajax({
    type: "POST",
    url: "pedido.php",
    data: dataString,
    dataType: 'json',
    success: function(data) {
      //var costo_prom = JSON.parse(data.costo_prom);
      var cp = data.costo_prom;
      var pre_unit = data.pre_unit;
      var existencias = data.existencias;
      var unidad = data.unidad;

      var preciop=data.preciop;

      var select=data.select;
      var unidadp=data.unidadp;
      var descripcionp=data.descripcionp;
      var costo=data.costo;
      // alert(cp);
      /*
      $("#inventable tr").each(function(index) {
        id_prev = $(this).closest('tr').children('td:first').text();
        if (id_prev == id_prod) {
          id_prod = "";
        }
      });
      */
      if (unidad > 1) {
        descrip = descrip + ''
        td_subcant = "<td><div class='col-xs-2'><input type='text'  class='form-control' id='subcant' name='subcant' value='0'  style='width:70px; readonly'></div></td>";
      } else {
        descrip = descrip + ''
        td_subcant = "<td><div class='col-xs-2'><input type='text'  class='form-control' id='subcant' name='subcant'  value='0' style='width:70px;' readonly></div></td>";
      }
      var tr_add = "";
      tr_add += '<tr>';
      tr_add += '<td class="id_producto">' + id_prod + '</td>';
      tr_add += '<td >' + descrip + '</td>';
      tr_add += '<td >' + select + '</td>';
      tr_add += '<td >' + descripcionp + '</td>';
      tr_add += "<td class='col-xs-1 exis'>" + "<input type='hidden'  class='form-control unidad' id='unidad' name='unidad' value='" + unidadp + "' style='width:70px;'>"+ existencias + '</td>';
      tr_add += '<td>0</td>';
      tr_add += "<td hidden><div class='col-xs-1'><input type='text'  class='form-control' id='precio_venta' name='precio_venta' value='" + costo + "' style='width:70px;'></div></td>";
      tr_add += "<td><div class='col-xs-1'><input type='text'  class='form-control cant' id='cant' name='cant'  value='0' style='width:60px;'></div></td>";
      tr_add += "<td><input type='text' class='form-control' id='precio_venta' name='precio_venta' value='"+preciop+"' style='width:70px;' readOnly></td>";
      tr_add += td_subcant;
      tr_add += "<td class='Delete'><a href='#'><i class='fa fa-times-circle'></i> Borrar</a></td>";
      tr_add += '</tr>';
      if ( id_prod != "" && existencias > 0) {
        $("#inventable").prepend(tr_add);
        $(".sel").select2();

      }

    }
  });
  totales();
}
//Evento que se activa al perder el foco en precio de venta y cantidad:
$(document).on("blur", "#cant, #precio_venta", function() {
  totales();
})

$(document).on("blur", "#inventable", function() {
  //$('#precio_compra').blur(function() {
  totales();
})
$(document).on("keyup", "#cant, #precio_venta", function() {
  totales();
})

// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", ".Delete", function() {
  var parent = $(this).parents().get(0);
  $(parent).remove();
  totales();
});

$(document).on('keyup', '.cant', function(event)
{
  fila = $(this).closest('tr');
  id_producto = fila.find('.id_producto').text();
  existencia = parseInt(fila.find('.exis').text());
  a_cant=$(this).val();
  unidad= parseInt(fila.find('.unidad').val());
  a_cant=parseInt(a_cant*unidad);

  //console.log(id_producto);
  //console.log(a_cant);
  a_asignar=0;

  $('table tr').each(function(index) {

    if($(this).find('.id_producto').text()==id_producto)
    {
      t_cant=parseInt($(this).find('.cant').val());
      if(isNaN(t_cant))
      {
        t_cant=0;
      }
      t_unidad=parseInt($(this).find('.unidad').val());
      if(isNaN(t_unidad))
      {
        t_unidad=0;
      }
      t_cant=parseInt((t_cant*t_unidad));
      a_asignar=a_asignar+t_cant;
      a_asignar=parseInt(a_asignar);
    }
  });
  //console.log(existencia);
  //console.log(a_asignar);

  if(a_asignar>existencia)
  {
      val = existencia-(a_asignar-a_cant);
      val = val/unidad;
      val=Math.trunc(val);
      val =parseInt(val);
      $(this).val(val);
      setTimeout(function() {totales();}, 1000);
  }
  else
  {
    totales();
  }

});


//Calcular Totales del grid
function totales() {
  var subtotal = 0;
  var total = 0;
  var totalcantidad = 0;
  var subcantidad = 0;
  var total_dinero = 0;
  var total_cantidad = 0;
  $("#inventable1>tbody tr").each(function() {
    /*if ($(this).find('.cheke').prop('checked')) {*/
      var compra = $(this).find(".precio_compra").text();
      var unidad = $(this).find(".unidad").val();
      var venta = $(this).find(".precio_venta").text();
      var cantidad = parseInt($(this).find(".cant").val());

      console.log("OK");
      if (isNaN(cantidad) == true) {
        cantidad = 0;
      }

      subtotal = venta * cantidad;

      totalcantidad += cantidad;
      if (isNaN(subtotal) == true) {
        subtotal = 0;
      }

      $(this).find(".subtotal").text(round(subtotal,4));
      total += subtotal;
    /*}*/
  });
  if (isNaN(total) == true) {
    total = 0;
  }
  total_dinero = round(total, 2);
  total_cantidad = round(totalcantidad, 2);
  total_dinero = round(total, 2);
  total_cantidad = round(totalcantidad, 2);



  $('#total_dinero').html("<strong>" + total_dinero + "</strong>");
  $('#total_dinero2').html("<strong>" + round((total_dinero/1.13),2) + "</strong>");
  $('#totcant').html(total_cantidad);

}

// actualize table
$(document).on("click", "#submit1", function() {
  // $('#submit1').attr('disabled',true);
  // $('#submit2').attr('disabled',true);
  senddata("pedido");
});
$(document).on("click", "#submit2", function() {
  $('#submit1').attr('disabled',true);
  $('#submit2').attr('disabled',true);
  senddata("insert");
});

function senddata(process)
{
  //Calcular los valores a guardar de cada item del inventario
  var id_cliente = $("#id_cliente").val();
  var direccion = $("#direccion").val();
  var select_depa = $("#select_depa").val();
  var select_muni = $("#select_muni").val();
  var i = 0;
  var fallo = 0;
  var precio_compra, precio_venta, cantidad, id_prod;
  var StringDatos = "";
  var id = $("select#tipo_entrada option:selected").val(); //get the value
  var id_pedido = $("#id_pedido").val();
  var origen = $("#origen").val();


  var verificar = 'noverificar';
  var verificador = [];

  $("#inventable1>tbody tr").each(function(index) {
    if (index >= 0)
    {

      var id_producto = $(this).find('.id_producto').val();
      var campo2 = $(this).text();
      var id_presentacion = $(this).find(".sel").val();
      var unidad = $(this).find('.unidad').val();
      var precio_venta = $(this).find(".precio_venta").val();
      var cantidad = $(this).find(".cant").val();
      var subtotal = $(this).find(".subtotal").val();

      if (id_producto != "" || id_producto == undefined)
      {
        console.log("OK");
        StringDatos += id_producto + "|" + precio_venta + "|" + cantidad + "|" + subtotal +"|" + unidad+"|" +id_presentacion+"#";
        verificador.push(verificar);
        if(cantidad == 0 || cantidad == "")
        {
          fallo += 1;
        }
        else
        {
          i = i + 1;
        }
      }

    }
  });
  // Captura de variables a enviar
  var fecha_movimiento = "";
  var numero_doc = 0;
  var id_sucursal = -1;
  var total_compras = $('#total_dinero').text();

  var fecha_movimiento = $("#fecha1").val();
  var fecha_entrega = $("#fecha_entrega").val();
  var transporte = $("#transporte").val();

  var concepto=$('#concepto').val();



  var dataString = 'process='+ process + '&stringdatos=' + StringDatos + '&cuantos=' + i + '&fecha_movimiento=' + fecha_movimiento + '&total_compras=' + total_compras + '&id_cliente=' + id_cliente;
  dataString += '&direccion=' + direccion + '&select_depa=' + select_depa + '&select_muni=' + select_muni + "&id_pedido=" + id_pedido + "&origen=" + origen + '&fecha_entrega=' + fecha_entrega + '&transporte=' + transporte;
  //alert(dataString);
  //if (verificar == 'noverificar') {
  console.log(fallo);
  if(fallo == 0)
  {
    $.ajax({
      type: 'POST',
      url: 'pedido.php',
      data: dataString,
      dataType: 'json',
      success: function(datax) {
        process = datax.process;
        //var maxid=datax.max_id;
        display_notify(datax.typeinfo, datax.msg);
        if(datax.typeinfo == "Success")
        {
          setInterval("reload1();", 500);
        }

      }
    });
  }
  else
  {
    display_notify("Error", "Verifique los datos.");
    $('#submit1').attr('disabled',false);
    $('#submit2').attr('disabled',false);
  }

  //}
  // else {
  //   $('#submit1').attr('disabled',false);
  //   var typeinfo = 'Warning';
  //   var msg = 'Falta rellenar algun valor de precio o cantidad!';
  //   display_notify(typeinfo, msg);
  // }
}



function reload1() {
  location.href = 'admin_pedido.php';
}

function deleted() {
  var id_producto = $('#id_producto').val();
  var dataString = 'process=deleted' + '&id_producto=' + id_producto;
  $.ajax({
    type: "POST",
    url: "borrar_producto.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      setInterval("location.reload();", 3000);
      $('#deleteModal').hide();
    }
  });
}

$(document).on('change', '.sel', function(event) {
  var id_presentacion = $(this).val();
  var a = $(this).parents("tr");
  $.ajax({
    url: 'pedido.php',
    type: 'POST',
    dataType: 'json',
    data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion,
    success: function(data) {
      a.find('.descp').html(data.descripcion);
      a.find('.precio_venta').text(data.precio);
      a.find('.unidad').val(data.unidad);
      a.find('.precio_compra').text(data.costo);

      fila = a;
      id_producto = fila.find('.id_producto').val();
      existencia = parseInt(fila.find('.exis').text());
      a_cant = parseInt(fila.find('.cant').val());
      unidad = parseInt(fila.find('.unidad').val());

      a_cant = parseInt(a_cant * data.unidad);
      console.log(a_cant);

      a_asignar = 0;

      $('table tr').each(function(index) {

        if ($(this).find('.id_producto').val() == id_producto) {
          t_cant = parseInt($(this).find('.cant').val());
          if (isNaN(t_cant)) {
            t_cant = 0;
          }
          t_unidad = parseInt($(this).find('.unidad').val());
          if (isNaN(t_unidad)) {
            t_unidad = 0;
          }
          t_cant = parseInt((t_cant * t_unidad));
          a_asignar = a_asignar + t_cant;
          a_asignar = parseInt(a_asignar);
        }
      });
      console.log(existencia);
      console.log(a_asignar);

      if (a_asignar > existencia) {
        val = existencia - (a_asignar - a_cant);
        val = val / unidad;
        val = Math.trunc(val);
        val = parseInt(val);
        fila.find('.cant').val(val);
      }

    }
  });
  setTimeout(function() {
    totales();
  }, 1000);
});
