$(document).ready(function() {
  $('.select').select2();
  $('.sel').select2();

  $(".cant").numeric({
    decimal: false,
    negative: false
  });

  totales();

  //searchFilter();
  $("#origen").change(function() {
    //searchFilter();
    $('#loadtable>tbody').html("");
    setTimeout(function functionName() {
      totales();

    },250)
  });

  $('html,body').animate({
		 scrollTop: $(".focuss").offset().top
	}, 1500);


  $("#scrollable-dropdown-menu .typeahead").typeahead({
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

  		$('.typeahead').typeahead('val', '');

  		var prod0=datum.producto;
  		 var prod= prod0.split("|");
  		 var id_prod = prod[0];
  		 var descrip = prod[1];
  			var marca = prod[2];

        page_num = 0;

        var producto_buscar = $('#producto_buscar').val();
        var origen = $('#origen').val();

        getData(id_prod, origen, page_num);
  }


  $("#producto_buscar").focus();

  $('#id_ubicacion').select2({
    placeholder: {
      id: '', // the value of the option
      text: 'Seleccione'
    },
    allowClear: true
  });
});

$(document).keydown(function(e){
//	alert(e.which);
  if(e.which == 120){ //F9 enviar traslado
    e.stopPropagation();
    if (!$("#submit1").prop( "disabled" )) {
      $("#submit1").prop( "disabled",true);
      senddata();
    }
    else {
      console.log("el boton esta desabilitado");
    }
  }
  if(e.which == 115){ //F4 salir
    e.stopPropagation();
    if (!$("#salir").prop( "disabled" )) {
      $("#salir").prop( "disabled",true);

      senddata3();
    }
  }

  if(e.which == 113) { //F2 Guardar
    e.stopPropagation();
    if (!$("#saving_t").prop( "disabled" )) {
      $("#saving_t").prop( "disabled",true);
      senddata2();
    }
    else {
      console.log("el boton esta desabilitado");
    }
    //senddata2();
  }


});

$(function() {
  //binding event click for button in modal form
  $(document).on("click", ".btnDelete", function(event) {
    $(this).closest('tr').remove();

    setTimeout(function functionName() {
      totales();

    },250)
  });
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });

});

function searchFilter(page_num) {
  page_num = page_num ? page_num : 0;
  var producto_buscar = $('#producto_buscar').val();
  var origen = $('#origen').val();
  //var limite = $('#limite').val();
  getData(producto_buscar, origen, page_num)
}

function getData(producto_buscar, origen, page_num) {
  var sortBy = 'asc'; //$('#sortBy').val();
  var records = 50; //$('#records').val();
  urlprocess = "traslado_producto.php";
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

$(document).on('select2:close', '.sel', function()
{
  $(this).closest('tr').find(".cant").focus();
});


//Evento que se activa al perder el foco en precio de venta y cantidad:
$(document).on("blur", "#inventable", function() {
  totales();
});
$(document).on("keyup", ".precio_venta", function() {
  totales();
});

// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", ".Delete", function() {
  $(this).parents("tr").remove();
  totales();
});
$(document).on("click", ".cheke", function() {
  var tr = $(this).parents("tr");
  if ($(this).is(":checked")) {
    tr.find(".cant").attr("readOnly", false);
  } else {
    tr.find(".cant").attr("readOnly", true);
  }
  totales();
});
//Calcular Totales del grid
function totales() {
  var subtotal = 0;
  var total = 0;
  var totalcantidad = 0;
  var subcantidad = 0;
  var total_dinero = 0;
  var total_cantidad = 0;
  $("#loadtable>tbody tr").each(function() {
    /*if ($(this).find('.cheke').prop('checked')) {*/
      var compra = $(this).find(".precio_compra").text();
      var unidad = $(this).find(".unidad").val();
      var venta = $(this).find(".precio_venta").text();
      var cantidad = parseInt($(this).find(".cant").val());

      if (isNaN(cantidad) == true) {
        cantidad = 0;
      }

      subtotal = compra * cantidad;

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
  senddata();
});
$(document).on("click", "#saving_t", function() {
  senddata2();
});
$(document).on("click", "#salir", function() {
  senddata3();

});

function senddata() {
  $('#submit1').prop('disabled', true);

  id_traslado_guardado = $('#id_tra_g').val();

  //Calcular los valores a guardar de cada item del inventario
  var i = 0;
  var error = false;
  var datos = "";
  var origen = $('#origen').val();
  var id_suc_destino = $("select#id_sucursal option:selected").val(); //get the value
  var numero_vale =$('#numero_vale').val();

  $("#loadtable>tbody tr").each(function() {
    /*if ($(this).find('.cheke').prop('checked')) {*/
      var id_prod = $(this).find(".id_producto").val();
      var id_presentacion = $(this).find(".sel").val();
      var compra = $(this).find(".precio_compra").text();
      var unidad = $(this).find(".unidad").val();
      var venta = $(this).find(".precio_venta").text();
      var cant = $(this).find(".cant").val();
      var vence = "";
      if (cant != "" && parseInt(cant) > 0) {
        datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + vence + "|" + id_presentacion + "#";
        i = i + 1;
      } else {
        error = true;
      }
    /*}*/
  });

  if(id_suc_destino!=""&&id_suc_destino!=0)
  {

  }
  else
  {
    error=true;
  }

  if(numero_vale!=""&&numero_vale!=0)
  {

  }
  else
  {
    error=true;
  }

  var total = $('#total_dinero').text();
  var concepto = $('#concepto').val();
  var fecha1 = $('#fecha1').val();

  var dataString = {
    'process': "insert",
    'datos': datos,
    'id_traslado_guardado' : id_traslado_guardado,
    'cuantos': i,
    'total': total,
    'fecha': fecha1,
    'concepto': concepto,
    'origen': origen,
    'id_suc_destino': id_suc_destino,
    'id_ubicacion_destino' : 0,
    'numero_vale': numero_vale
  }
  if (!error && i > 0) {
    $.ajax({
      type: 'POST',
      url: "traslado_producto.php",
      data: dataString,
      dataType: 'json',
      success: function(datax) {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success") {
          setInterval("reload1();", 1000);

        }
      }
    });
  } else {
    display_notify('Warning', 'Falta completar algun valor de cantidad !');
    $('#submit1').prop('disabled', "");
  }
}

function senddata2() {

  $('#saving_t').prop('disabled', true);

  id_traslado_guardado = $('#id_tra_g').val();
  //Calcular los valores a guardar de cada item del inventario
  var i = 0;
  var error = false;
  var datos = "";
  var origen = $('#origen').val();
  var id_suc_destino = $("select#id_sucursal option:selected").val(); //get the value
  var numero_vale =$('#numero_vale').val();

  $("#loadtable>tbody tr").each(function() {
    /*if ($(this).find('.cheke').prop('checked')) {*/
      var id_prod = $(this).find(".id_producto").val();
      var id_presentacion = $(this).find(".sel").val();
      var compra = $(this).find(".precio_compra").text();
      var unidad = $(this).find(".unidad").val();
      var venta = $(this).find(".precio_venta").text();
      var cant = $(this).find(".cant").val();
      var vence = "";
      if (cant != "" && parseInt(cant) > 0) {
        datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + vence + "|" + id_presentacion + "#";
        i = i + 1;
      } else {
        error = true;
      }
    /*}*/
  });

  if(id_suc_destino!=""&&id_suc_destino!=0)
  {

  }
  else
  {
    error=true;
  }

  if(numero_vale!=""&&numero_vale!=0)
  {

  }
  else
  {
    error=true;
  }

  var total = $('#total_dinero').text();
  var concepto = $('#concepto').val();
  var fecha1 = $('#fecha1').val();

  var dataString = {
    'process': "saving",
    'id_traslado_guardado' : id_traslado_guardado,
    'datos': datos,
    'cuantos': i,
    'total': total,
    'fecha': fecha1,
    'concepto': concepto,
    'origen': origen,
    'id_suc_destino': id_suc_destino,
    'id_ubicacion_destino' : 0,
    'numero_vale': numero_vale
  }
  if (!error && i > 0) {
    $.ajax({
      type: 'POST',
      url: "traslado_producto.php",
      data: dataString,
      dataType: 'json',
      success: function(datax) {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success") {
          $('#id_tra_g').val(datax.id_traslado);
        }
        $("#saving_t").prop( "disabled","");
      }
    });
  } else {
    display_notify('Warning', 'Falta completar algun valor de cantidad !');
    $('#saving_t').prop('disabled', "");
  }
}

function senddata3() {
  $('#salir').prop('disabled', true);
  swal({
      title: "¿Guardar?",
      text: "Desea guardar los cambios realizados",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '',
      confirmButtonText: 'Guardar',
      cancelButtonText: 'No guardar',
      closeOnConfirm: true,
      closeOnCancel: true
   }, function(isConfirm) {
     if (isConfirm){
         id_traslado_guardado = $('#id_tra_g').val();
         //Calcular los valores a guardar de cada item del inventario
         var i = 0;
         var error = false;
         var datos = "";
         var origen = $('#origen').val();
         var id_suc_destino = $("select#id_sucursal option:selected").val(); //get the value
         var numero_vale =$('#numero_vale').val();

         $("#loadtable>tbody tr").each(function() {
           /*if ($(this).find('.cheke').prop('checked')) {*/
             var id_prod = $(this).find(".id_producto").val();
             var id_presentacion = $(this).find(".sel").val();
             var compra = $(this).find(".precio_compra").text();
             var unidad = $(this).find(".unidad").val();
             var venta = $(this).find(".precio_venta").text();
             var cant = $(this).find(".cant").val();
             var vence = "";
             if (cant != "" && parseInt(cant) > 0) {
               datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + vence + "|" + id_presentacion + "#";
               i = i + 1;
             } else {
               error = true;
             }
           /*}*/
         });

         if(id_suc_destino!=""&&id_suc_destino!=0)
         {

         }
         else
         {
           error=true;
         }

         if(numero_vale!=""&&numero_vale!=0)
         {

         }
         else
         {
           error=true;
         }

         var total = $('#total_dinero').text();
         var concepto = $('#concepto').val();
         var fecha1 = $('#fecha1').val();

         var dataString = {
           'process': "saving",
           'id_traslado_guardado' : id_traslado_guardado,
           'datos': datos,
           'cuantos': i,
           'total': total,
           'fecha': fecha1,
           'concepto': concepto,
           'origen': origen,
           'id_suc_destino': id_suc_destino,
           'id_ubicacion_destino' : 0,
           'numero_vale': numero_vale
         }
         if (!error && i > 0) {
           $.ajax({
             type: 'POST',
             url: "traslado_producto.php",
             data: dataString,
             dataType: 'json',
             success: function(datax) {
               display_notify(datax.typeinfo, datax.msg);

               if (datax.typeinfo == "Success") {
                 $('#id_tra_g').val(datax.id_traslado);
                 setTimeout(function () {
                   location.href = "admin_traslados.php";
                 },1000);

               }
             }
           });
         } else {
           display_notify('Warning', 'Falta completar algun valor de cantidad !');
           $('#salir').prop('disabled', "");
         }
      } else {
        location.href = "admin_traslados.php";
      }

   });
}


$(document).on('keyup', '.cant', function(evt){
	if(evt.keyCode == 13)
	{
		num=parseFloat($(this).val());
		if(isNaN(num))
		{
			num=0;
		}
		if($(this).val()!=""&&num>0)
		{
		$('#producto_buscar').focus();
		}
	}
});

$(document).on('keyup', '.cant', function(event) {
  fila = $(this).closest('tr');
  id_producto = fila.find('.id_producto').val();
  existencia = parseInt(fila.find('.exis').text());
  a_cant = $(this).val();
  unidad = parseInt(fila.find('.unidad').val());
  a_cant = parseInt(a_cant * unidad);

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
  console.log("e "+existencia);
  console.log("a "+a_asignar);

  if (a_asignar > existencia) {
    val = existencia - (a_asignar - a_cant);
    val = val / unidad;
    val = Math.trunc(val);
    val = parseInt(val);
    $(this).val(val);
    setTimeout(function() {
      totales();
    }, 200);
  } else {
    totales();
  }

});

function reload1() {
  location.href = "traslado_producto.php";
}
$(document).on('change', '.sel', function(event) {
  var id_presentacion = $(this).val();
  var a = $(this).parents("tr");
  $.ajax({
    url: 'traslado_producto.php',
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




function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

$('html').click(function() {

  inpu = $("#value").closest('td').find('input').hasClass("in");
  console.log(inpu);
  if (inpu==true) {
    var number = $('#value').val();
    var a = $('#value').closest('td');
    a.html(number);
    setTimeout(function() {
      totales();
    }, 250);
  }

});

$(document).on('click', 'td', function(e) {
  if ($(this).hasClass('precio_compra')) {
    var av = $(this).html();

    inpu = $(this).find('input').hasClass("in");
    if (inpu==true) {

    }
    else {
      $(this).html('');
      $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
      $('#value').val(av);
      $('#value').focus();
      $('#value').numeric({
        negative: false,
        decimalPlaces: 4
      });
      e.stopPropagation();
    }


  }
  if ($(this).hasClass('nm')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    $('#value').val(av);
    $('#value').focus();
    $('#value').numeric({
      negative: false,
      decimal: false
    });
    e.stopPropagation();
  }
  if ($(this).hasClass('tex')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    $('#value').val(av);
    $('#value').focus();
    e.stopPropagation();
  }
  if ($(this).hasClass('ddate')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');

    $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
      daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    };
    window.prettyPrint && prettyPrint();
    $('#value').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',

    });
    $('#value').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
    });

    $('#value').val(av);
    $('#value').focus();
    e.stopPropagation();
  }
});

$(document).on('keypress', '.in', function(event) {
  if (event.key == 'Enter') {
    $('html').click();
  }
});
