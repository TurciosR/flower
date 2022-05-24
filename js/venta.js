var urlprocess = '';
var sending = 0;
// theme: "classic",

$(window).keydown(function(event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
});

$(document).on('keydown', '.confirm', function(event) {
  if (event.keyCode == 13)
  {
    setTimeout(function() {
      location.reload();
    },500);
  }
});

$(document).ready(function() {

  $(".select_r").select2({
    placeholder: {
      id: '0',
      text: 'Seleccione',
    },
    allowClear: true,
  });

  $('#num_doc_fact').numeric({
    negative: false,
    decimal: false
  });
  $('html,body').animate({
    scrollTop: $(".focuss").offset().top
  }, 1500);
  $('#num_ref').focus();
  $(".select").select2({
    placeholder: {
      id: '',
      text: 'Seleccione',
    },
    allowClear: true,
  });
  $("#codigo").keyup(function(evt)
	{
		var code = $(this).val();
    if (evt.keyCode == 13)
		{
			if($(this).val()!="")
			{
      	addProductList(code, "C");
			}
			$(this).val("");
    }
  });

  $("#scrollable-dropdown-menu #producto_buscar").typeahead({
    highlight: true,
  }, {
    limit: 100,
    name: 'productos',
    display: 'producto',
    source: function show(q, cb, cba) {
      console.log(q);
      var url = 'autocomplete_producto2.php' + "?query=" + q;
      $.ajax({
          url: url
        })
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
    var prod0 = datum.producto;
    var prod = prod0.split("|");
    var id_prod = prod[0];
    var descrip = prod[1];
    addProductList(id_prod, "D");
  }

  var urlprocess = 'venta.php';
  // Clean the modal form
  $(document).on('change', '#n_ref', function(event) {
    cargar_ref();
    /* Act on the event */
  });

  $(".decimal").numeric({
    negative: false,
    decimalPlaces: 4
  });

  document.addEventListener('keydown', event => {
    if (event.ctrlKey && event.keyCode == 13) {
      event.preventDefault();
      event.stopPropagation();
      if ($('#b').attr('hidden')) {
        $('#codigo').focus();
      } else {
        $('#producto_buscar').focus();
      }
    }
  }, false);

  document.addEventListener('keydown', event => {

    if (event.ctrlKey && event.keyCode == 82) {
      event.preventDefault();
      event.stopPropagation();
      console.log(event.keyCode);

      $('#n_ref').select2("open");

    }
  }, false);

  $(document).on('keydown', '#num_ref', function(event) {
    if (event.keyCode == 13) {
      $('#aut_code').removeAttr('disabled');
      $('#aut_code').val("");
      $('#clave').val('');
      $('#precio_aut').val('');

      if ($(this).val() != "") {
        a = $('#vendedor');
        b = $('#id_cliente');
        c = $('#tipo_impresion');


        var n_ref = $("#num_ref").val();
        var fecha = $("#fecha").val();
        $("#num_ref").val("")
        $.ajax({
          type: 'POST',
          url: "venta.php",
          data: "process=cargar_data&n_ref=" + n_ref + "&fecha=" + fecha,
          dataType: 'json',
          success: function(datax) {
            var id_cliente = datax.id_cliente;
            var nombre_cliente = datax.nombre_cliente;
            var alias_tipodoc = datax.alias_tipodoc;
            var lista = datax.lista;
            if (datax.typeinfo == "Success") {
              b.empty().trigger('change');
              c.empty().trigger('change');

              $("#id_cliente").html(datax.select_cliente);
              b.trigger('change');

              $("#tipo_impresion").html(datax.select_tipo_impresion);
              c.trigger('change');

              $("#inventable").html(lista);
              //console.log(lista);
              $("#id_empleado").val(datax.id_empleado);

              $("#vendedor").val(datax.id_empleado);
              $("#id_factura").val(datax.id_factura);
              $("#numero_doc").val(datax.numero_doc);

              $('#aut_code').removeAttr('disabled');
              $('#clave').val(datax.clave);
              $('#precio_aut').val(datax.precio_aut);

              if (datax.clave!='') {
                $('#aut_code').val(datax.clave);
                $('#aut_code').attr('disabled', 'disabled');
              }

              $(".cant").numeric({
                negative: false,
                decimal: false
              });
              $(".86").numeric({
                negative: false,
                decimalPlaces: 4
              });

              $(".sel").select2();
              $(".sel_r").select2();

              porc_retencion1 = datax.retencion1;
              porc_retencion10 = datax.retencion10;
              $("#porc_retencion1").val(porc_retencion1);
              $("#porc_retencion10").val(porc_retencion10);
              if ($('#b').attr('hidden')) {
                $('#codigo').focus();
              } else {
                $('#producto_buscar').focus();
              }

              totales();
            } else {

              display_notify(datax.typeinfo, datax.msg);


              $("#id_cliente").val("1");
              $("#id_cliente").trigger('change');

              $("#text_cliente").val("");
              $("#tipo_impresion").val("TIK");
              $("#tipo_impresion").trigger('change');

              $("#vendedor").val("");
              $("#caja_detalles").html("");
              $("#id_empleado").val("");
              $("#id_factura").val("");
              $("#numero_doc").val("");
              $("#inventable").html("");
              totales();
            }
          }
        });

      }
    }
  });

  document.addEventListener('keydown', event => {
    if (event.ctrlKey && event.keyCode == 16) {
      event.stopPropagation();

    }
  }, false);

  $(document).keydown(function(e) {
    if (e.which == 113) { //F2 Guardar
      $("#submit1").click();
      e.stopPropagation();
    }
     if (e.which == 27) { //F2 Guardar
      $("#abrir").click();
      e.stopPropagation();
    }
    if (e.which == 114) { //F3 salir
      e.stopPropagation();
      e.preventDefault();

			if ($('#a').attr('hidden')) {
				$('#a').removeAttr('hidden');
				$('#b').attr('hidden', 'hidden');
				$('#codigo').focus();
				$('#change').html("<i class='fa fa-exchange'></i> F3 Descripción");
			} else {
				$('#b').removeAttr('hidden');
				$('#a').attr('hidden', 'hidden');
				$('#producto_buscar').focus();
				$('#change').html("<i class='fa fa-exchange'></i> F3 Código");
			}
    }
    if (e.which == 115) { //F4 salir
      location.replace("dashboard.php");
      e.stopPropagation();
      e.preventDefault();
    }
    if (e.which == 119) { //F8 guardar como preventa
      e.stopPropagation();
      guardar_preventa();
    }
    if (e.which == 120) { //F9  vale
      e.stopPropagation();
      e.preventDefault();
      $('#xa').click();

    }
    if (e.which == 121) { //F10 ingreso
      e.stopPropagation();
      e.preventDefault();
      $('#xb').click();
    }
    if (e.which == 117) {
      e.stopPropagation();
      borrar_preventa();
      e.preventDefault();
    }
    if (e.which == 46) /*suprimir*/ {
      $("#inventable tr:first-child").remove();
      totales();
      var filas = $("#filas").val();
      filas --;
      $("#filas").val(filas);
      e.preventDefault();
			if ($('#b').attr('hidden')) {
				$('#codigo').focus();
			} else {
				$('#producto_buscar').focus();
			}
    }
  });
  $('#form_fact_consumidor').hide();
  $('#form_fact_ccfiscal').hide();

  //Boton de imprimir deshabilitado hasta que se guarde la factura
  $('#print1').prop('disabled', true);
  $('#submit1').prop('disabled', false);
  //$('#print1').prop('disabled', false);
});
$(document).on('hidden.bs.modal', function(e) {
  var target = $(e.target);
  target.removeData('bs.modal').find(".modal-content").html('');
});
$(document).on('click','#change', function() {
  if ($('#a').attr('hidden')) {
	$('#a').removeAttr('hidden');
	$('#b').attr('hidden', 'hidden');
	$('#codigo').focus();
	$('#change').html("<i class='fa fa-exchange'></i> F3 Descripción");
} else {
	$('#b').removeAttr('hidden');
	$('#a').attr('hidden', 'hidden');
	$('#producto_buscar').focus();
	$('#change').html("<i class='fa fa-exchange'></i> F3 Código");
}
});

//function to round 2 decimal places
function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
    $(document).on("click", "#abrir", function(event) {
    abrir_caja();
  });
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
    location.reload();
  });

});



function cargar_ref() {
  a = $('#vendedor');
  b = $('#id_cliente');
  c = $('#tipo_impresion');


  var n_ref = $("#n_ref").val();
  var fecha = $("#fecha").val();
  $.ajax({
    type: 'POST',
    url: "venta.php",
    data: "process=cargar_data&n_ref=" + n_ref + "&fecha=" + fecha,
    dataType: 'json',
    success: function(datax) {
      var id_cliente = datax.id_cliente;
      var nombre_cliente = datax.nombre_cliente;
      var alias_tipodoc = datax.alias_tipodoc;
      var lista = datax.lista;
      if (datax.typeinfo == "Success") {
        b.empty().trigger('change');
        c.empty().trigger('change');

        $("#id_cliente").html(datax.select_cliente);
        b.trigger('change');

        $("#tipo_impresion").html(datax.select_tipo_impresion);
        c.trigger('change');

        $("#inventable").html(lista);
        //console.log(lista);
        $("#id_empleado").val(datax.id_empleado);
        $("#vendedor").val(datax.id_empleado);
        $("#id_factura").val(datax.id_factura);
        $("#numero_doc").val(datax.numero_doc);

        $(".decimal").numeric({
          negative: false,
          decimalPlaces: 4
        });
        $(".86").numeric({
          negative: false,
          decimalPlaces: 4
        });

        $(".decimal2").numeric({
          negative: false,
          decimal: false
        });
        $(".86").numeric({
          negative: false,
          decimalPlaces: 4
        });

        $(".sel").select2();
        $(".sel_r").select2();

        porc_retencion1 = datax.retencion1;
        porc_retencion10 = datax.retencion10;
        $("#porc_retencion1").val(porc_retencion1);
        $("#porc_retencion10").val(porc_retencion10);
        if ($('#b').attr('hidden')) {
          $('#codigo').focus();
        } else {
          $('#producto_buscar').focus();
        }

        totales();
      } else {
        /*
        display_notify(datax.typeinfo,datax.msg);
        */

        $("#id_cliente").val("");
        $("#id_cliente").trigger('change');

        $("#text_cliente").val("");
        $("#tipo_impresion").val("");
        $("#tipo_impresion").trigger('change');

        $("#vendedor").val("");
        $("#caja_detalles").html("");
        $("#id_empleado").val("");
        $("#id_factura").val("");
        $("#numero_doc").val("");
        $("#inventable").html("");
        totales();
      }
    }
  });
}
// Evento para seleccionar una opcion y mostrar datos en un div
$(document).on("change", "#tipo_entrada", function() {
  $(".datepick2").datepicker();
  $('#id_proveedor').select2();

  var id = $("select#tipo_entrada option:selected").val(); //get the value
  if (id != '0') {
    $('#buscador').show();
  } else
    $('#buscador').hide();

  if (id == '1')
    $('#form_fact_consumidor').show();
  else
    $('#form_fact_consumidor').hide();


  if (id == '2')
    $('#form_fact_ccfiscal').show();
  else
    $('#form_fact_ccfiscal').hide();

});
// Seleccionar el tipo de factura
$(document).on("change", "#tipo_entrada", function() {
  var id = $("select#tipo_entrada option:selected").val(); //get the value
  ////alert(id);
  $('#mostrar_numero_doc').load('editar_factura.php?' + 'process=mostrar_numfact' + '&id=' + id);
});

// Agregar productos a la lista del inventario
function cargar_empleados() {
  $('#inventable>tbody>tr').find("#select_empleado").each(function() {
    $(this).load('editar_factura.php?' + 'process=cargar_empleados');
    totales();
  });
}

// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", "#delprod", function() {
  $(this).parents("tr").remove();
  totales();
});

//Evento que se activa al perder el foco en precio de venta y cantidad:

$(document).on('change', '.sel_prec', function() {
  var tr = $(this).parents("tr");
  var precio = $(this).find(':selected').val();
  tr.find("#precio_venta").val(precio);
  actualiza_subtotal(tr);
});
$(document).on('keyup', '#cant', function() {
  fila = $(this).parents('tr');
  id_producto = fila.find('.id_pps').text();
  existencia = parseFloat(fila.find('#cant_stock').text());
  existencia = round(existencia, 4);
  a_cant = $(this).val();
  unidad = parseInt(fila.find('#unidades').val());
  a_cant = parseFloat(a_cant * unidad);
  a_cant = round(a_cant, 4);

  //console.log(a_cant);
  a_asignar = 0;

  $('#inventable tr').each(function(index) {

    if ($(this).find('.id_pps').text() == id_producto) {
      t_cant = parseFloat($(this).find('#cant').val());
      t_cant = round(t_cant, 4);
      if (isNaN(t_cant)) {
        t_cant = 0;
      }
      t_unidad = parseInt($(this).find('#unidades').val());
      if (isNaN(t_unidad)) {
        t_unidad = 0;
      }
      t_cant = parseFloat((t_cant * t_unidad));
      a_asignar = a_asignar + t_cant;
      a_asignar = round(a_asignar, 4);
    }
  });
  //console.log(existencia);
  //console.log(a_asignar);

  if (a_asignar > existencia) {
    val = existencia - (a_asignar - a_cant);
    val = val / unidad;
    val = Math.trunc(val);
    val = parseInt(val);
    $(this).val(val);
    setTimeout(function() {
      totales();
    }, 1000);
  } else {
    totales();
  }
  var tr = $(this).parents("tr");

  id_presentacion_p = fila.find('.sel').val();
  //Ranking de precios
  /*$.ajax({
    type: 'POST',
    url: 'venta.php',
    data: 'process=cons_rank&id_producto=' + id_producto + '&id_presentacion=' + id_presentacion_p + '&cantidad=' + a_cant,
    dataType: 'JSON',
    success: function(datax) {
      tr.find(".rank_s").html(datax.precios);
      tr.find("#precio_venta").val(datax.precio);
      $(".sel_r").select2();
    }
  });*/
  setTimeout(function() {
    actualiza_subtotal(tr);
  }, 300);
});

$(document).on("keyup", "#precio_venta", function() {
  tr = $(this).closest('tr');
  precio = parseFloat($(this).val());

  if (isNaN(precio)) {
    precio=0;
  }

  precio_rank = parseFloat(tr.find('.sel_r').val());
  precio_rank_f = truncateDecimals(precio_rank,2);
  if (precio!=0 && precio<precio_rank_f) {
    tr.find("#precio_venta").val(precio_rank);
    precio = precio_rank;
  }
  tr.find("#precio_sin_iva").val(precio / 1.13);
  actualiza_subtotal(tr);
});

function truncateDecimals (num, digits) {
    var numS = num.toString(),
        decPos = numS.indexOf('.'),
        substrLength = decPos == -1 ? numS.length : 1 + decPos + digits,
        trimmedResult = numS.substr(0, substrLength),
        finalResult = isNaN(trimmedResult) ? 0 : trimmedResult;

    return parseFloat(finalResult);
}

function actualiza_subtotal(tr) {
  var iva = parseFloat($('#porc_iva').val());
  var precio_sin_iva = parseFloat(tr.find('#precio_sin_iva').val());
  var existencias = tr.find('#cant_stock').text();

  var tipo_impresion = $('#tipo_impresion').val();

  if (tipo_impresion != 'CCF') {

    var cantidad = tr.find('#cant').val();
    if (isNaN(cantidad) || cantidad == "") {
      cantidad = 0;
    }
    var precio = tr.find('#precio_venta').val();
    var precio_oculto = tr.find('#precio_venta').val();

    if (isNaN(precio) || precio == "") {
      precio = 0;
    }
    var subtotal = subt(cantidad, precio);
    var subt_mostrar = round(subtotal, 2);
    tr.find("#subtotal_fin").val(subt_mostrar);
    tr.find("#subtotal_mostrar").val(subt_mostrar);
    totales();
  } else {
    var cantidad = tr.find('#cant').val();
    if (isNaN(cantidad) || cantidad == "") {
      cantidad = 0;
    }
    var precio = tr.find('#precio_sin_iva').val();

    if (isNaN(precio) || precio == "") {
      precio = 0;
    }
    var subtotal = subt(cantidad, precio);
    var subt_mostrar = subtotal.toFixed(4);

    tr.find("#subtotal_fin").val(subt_mostrar);
    var subt_mostrar = round(subtotal, 2);
    tr.find("#subtotal_mostrar").val(subt_mostrar);
    totales();
  }

}

//Calcular Totales del grid
function totales() {
  //impuestos
  var iva = $('#porc_iva').val();
  var porc_percepcion = $("#porc_percepcion").val();
  var porc_retencion1 = $("#porc_retencion1").val();
  var porc_retencion10 = $("#porc_retencion10").val();

  var id_tipodoc = $("#tipo_impresion option:selected").val();
  var monto_retencion1 = parseFloat($('#monto_retencion1').val());
  var monto_retencion10 = parseFloat($('#monto_retencion10').val());
  var monto_percepcion = $('#monto_percepcion').val();
  var porcentaje_descuento = parseFloat($("#porcentaje_descuento").val());

  var total_sin_iva = 0;
  //fin impuestos

  var tipo_impresion = $('#tipo_impresion').val();

  var urlprocess = "venta.php";
  var i = 0,
    total = 0;
  totalcantidad = 0;

  var total_gravado = 0;

  var total_exento = 0;

  var subt_gravado = 0;

  var total_definitivo =0;

  var subt_exento = 0;

  var subtotal = 0;

  var total_descto = 0;
  var total_sin_descto = 0;
  var subt_descto = 0;
  var total_final = 0;
  var subtotal_sin_iva = 0;
  var StringDatos = '';
  var filas = 0;
  var total_iva = 0;
  if (tipo_impresion == "CCF") {
    $("#inventable tr").each(function() {
      subt_cant = $(this).find("#cant").val();
      ex = parseInt($(this).find('#exento').val());

      if (isNaN(subt_cant) || subt_cant == "") {
        subt_cant = 0;
      }
      subt_gravado = 0;
      subt_exento = 0;

      precioa = $(this).find('#precio_venta').val();
      precioa  =  parseFloat(precioa);
      precioa  = round(precioa,4);

      total_definitivo += subt(subt_cant, precioa);

      if (ex == 0) {
        subt_gravado = subt(subt_cant, precioa);
        subt_gravado = parseFloat(subt_gravado);
        subt_gravado = subt_gravado / (1+parseFloat(iva));
      } else {
        subt_exento = subt(subt_cant, precioa);
      }

      totalcantidad += parseFloat(subt_cant);

      total_gravado += parseFloat(subt_gravado);

      total_exento += parseFloat(subt_exento);

      subtotal += parseFloat(subt_exento) + parseFloat(subt_gravado);;

      filas += 1;
    });

    total_gravado = round(total_gravado, 4);

    var total_descuento = 0;
    if (porcentaje_descuento > 0.0) {
      total_descuento = (porcentaje_descuento / 100) * subtotal
    } else {
      total_descuento = 0;
    }
    var total_descuento_mostrar = total_descuento.toFixed(2)
    var total_mostrar = subtotal.toFixed(2)
    totcant_mostrar = totalcantidad.toFixed(2)

    //console.log(subt_gravado);
    $('#totcant').text(totcant_mostrar);


    var total_sin_iva_mostrar = total_gravado.toFixed(2);
    $('#total_gravado_sin_iva').html(total_sin_iva_mostrar);
    txt_war = "class='text-danger'"


    $('#total_gravado').html(total_mostrar);
    $('#total_exenta').html(total_exento.toFixed(2));

    var total_iva_mostrar = 0.00;

    total_iva = total_gravado * (parseFloat(iva));
    total_iva = round(total_iva, 2)
    total_gravado_iva = total_gravado + total_iva;


    total_gravado_iva_mostrar = total_gravado_iva.toFixed(2);
    $('#total_gravado_iva').html(total_gravado_iva_mostrar); //total gravado con iva
    $('#total_iva').html(total_iva.toFixed(2));

    var total_retencion1 = 0
    var total_retencion10 = 0
    var total_percepcion = 0
    if (total_gravado >= monto_retencion1)
      total_retencion1 = total_gravado * porc_retencion1;
    if (total_gravado >= monto_retencion10)
      total_retencion10 = total_gravado * porc_retencion10;
    total_final = total_definitivo + total_percepcion - (total_retencion1 + total_retencion10) - total_descuento;


    total_final_mostrar = total_final.toFixed(2);
    $('#total_percepcion').html(0);
    total_retencion1_mostrar = total_retencion1.toFixed(2);
    total_retencion10_mostrar = total_retencion10.toFixed(2);
    $('#total_retencion').html('0.00');
    if (parseFloat(total_retencion1) > 0.0)
      $('#total_retencion').html(total_retencion1_mostrar);
    if (parseFloat(total_retencion10) > 0.0)
      $('#total_retencion').html(total_retencion10_mostrar);
    //total final
    $('#total_final').html(total_descuento_mostrar);
    $('#totalfactura').val(total_final_mostrar);

    $('#totcant').html(totcant_mostrar);
    $('#items').val(filas);
    $('#totaltexto').load("venta.php", {
      'process': 'total_texto',
      'total': total_final_mostrar
    });
    $('#monto_pago').html(total_final_mostrar);

    $('#totalfactura').val(total_final_mostrar);
  } else {
    $("#inventable tr").each(function() {
      subt_cant = $(this).find("#cant").val();
      ex = parseInt($(this).find('#exento').val());

      if (isNaN(subt_cant) || subt_cant == "") {
        subt_cant = 0;
      }
      subt_gravado = 0;
      subt_exento = 0;

      if (ex == 0) {
        subt_gravado = $(this).find("#subtotal_fin").val();
      } else {
        subt_exento = $(this).find("#subtotal_fin").val();
      }

      totalcantidad += parseFloat(subt_cant);

      total_gravado += parseFloat(subt_gravado);

      total_exento += parseFloat(subt_exento);

      subtotal += parseFloat(subt_exento) + parseFloat(subt_gravado);;

      filas += 1;
    });

    total_gravado = round(total_gravado, 4);
    //descuento
    var total_descuento = 0;
    if (porcentaje_descuento > 0.0) {
      total_descuento = (porcentaje_descuento / 100) * total_final
    } else {
      total_descuento = 0;
    }
    var total_descuento_mostrar = total_descuento.toFixed(2)
    var total_mostrar = subtotal.toFixed(2)
    totcant_mostrar = totalcantidad.toFixed(2)

    //console.log(subt_gravado);
    $('#totcant').text(totcant_mostrar);


    var total_sin_iva_mostrar = total_gravado.toFixed(2);
    $('#total_gravado_sin_iva').html(total_sin_iva_mostrar);
    txt_war = "class='text-danger'"


    $('#total_gravado').html(total_mostrar);
    $('#total_exenta').html(total_exento.toFixed(2));

    var total_iva_mostrar = 0.00;

    total_iva = 0;
    total_iva = round(total_iva, 2)
    total_gravado_iva = total_gravado + total_iva;


    total_gravado_iva_mostrar = total_gravado_iva.toFixed(2);
    $('#total_gravado_iva').html(total_gravado_iva_mostrar); //total gravado con iva
    $('#total_iva').html(total_iva.toFixed(2));

    var total_retencion1 = 0
    var total_retencion10 = 0
    var total_percepcion = 0
    if (total_gravado >= monto_retencion1)
      total_retencion1 = total_gravado * porc_retencion1;
    if (total_gravado >= monto_retencion10)
      total_retencion10 = total_gravado * porc_retencion10;
    var total_final = (total_gravado - total_descuento + total_percepcion) - (total_retencion1 + total_retencion10) + total_iva + total_exento;

    total_final_mostrar = total_final.toFixed(2);
    $('#total_percepcion').html(0);
    total_retencion1_mostrar = total_retencion1.toFixed(2);
    total_retencion10_mostrar = total_retencion10.toFixed(2);
    $('#total_retencion').html('0.00');
    if (parseFloat(total_retencion1) > 0.0)
      $('#total_retencion').html(total_retencion1_mostrar);
    if (parseFloat(total_retencion10) > 0.0)
      $('#total_retencion').html(total_retencion10_mostrar);
    //total final
    $('#total_final').html(total_descuento_mostrar);
    $('#totalfactura').val(total_final_mostrar);

    $('#totcant').html(totcant_mostrar);
    $('#items').val(filas);
    $('#totaltexto').load("venta.php", {
      'process': 'total_texto',
      'total': total_final_mostrar
    });
    $('#monto_pago').html(total_final_mostrar);

    $('#totalfactura').val(total_final_mostrar);
  }
}

function totalFact() {
  var TableData = new Array();
  var i = 0;
  var total = 0;
  var StringDatos = '';
  $("#inventable>tbody  tr").each(function(index) {
    if (index >= 0) {
      var subtotal = 0;
      $(this).children("td").each(function(index2) {
        switch (index2) {
          case 7:
            var isVisible = false
            isVisible = $(this).filter(":visible").length > 0;
            if (isVisible == true) {
              subtotal = parseFloat($(this).text());
              if (isNaN(subtotal)) {
                subtotal = 0;
              }
            } else {
              subtotal = 0;
            }
            break;
        }
      });
      total += subtotal;
    }
  });
  total = round(total, 2);
  total_dinero = total.toFixed(2);
  $('#total_dinero').html("<strong>" + total_dinero + "</strong>");
  $('#totaltexto').load('venta.php?' + 'process=total_texto&total=' + total_dinero);
  //console.log('total:' + total_dinero);
}
// actualize table data to server
$(document).on("click", "#submit1", function() {
  $('#submit1').attr('disabled', true);
  if($("#inventable tr").length>0)
  {
    senddata();
  }
  else {
    display_notify("Error", "Debe agregar productos a la lista");
    $('#submit1').attr('disabled', false);
  }
});
$(document).on("click", "#preventa", function() {
  guardar_preventa();
});
$(document).on("click", "#borrar_preven", function() {
  borrar_preventa();
});
$(document).on("click", "#btnEsc", function(event) {
  reload1();
});

$(document).on("click", ".print1", function() {
  var totalfinal = parseFloat($('#totalfactura').val());
  var facturado = totalfinal.toFixed(2);
  $(".modal-body #facturado").val(facturado);
});
$(document).on("click", "#btnPrintFact", function(event) {
  imprime1();
});

$(document).on("click", "#print2", function() {
  imprime2();
});

function borrar_preventa() {
  var id_factura = parseInt($("#id_factura").val());
  var corr_in = $("#corr_in").val();
  if (isNaN(id_factura)) {
    id_factura = 0;
  }
  if (id_factura != 0 && corr_in == "") {

    swal({
      title: "¿Esta seguro?",
      text: "Esto eliminara la preventa de manera permanente",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '',
      confirmButtonText: 'Borrar',
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: 'venta.php',
          type: 'POST',
          dataType: 'json',
          data: {
            process: "borrar_preventa",
            id_factura: id_factura
          },
          success: function(datax) {
            if (datax.typeinfo == "Success") {
              display_notify(datax.typeinfo, datax.msg);
              setInterval("reload1();", 1000);
            }
          }
        });
      } else {}

    });
  }
}

function guardar_preventa() {
  sel_vendedor = 1;
  var i = 0;
  var StringDatos = "";
  var id = '1';
  var id_empleado = 0;
  var id_cliente = $("#id_cliente option:selected").val();
  var items = $("#items").val();
  var msg = "";
  //IMPUESTOS
  error = false;

  precio_aut=$("#precio_aut").val();
  clave=$("#clave").val();

  var total_percepcion = $('#total_percepcion').text();

  var id_factura = parseInt($('#id_factura').val());

  if (isNaN(id_factura)) {
    id_factura = 0;
  }

  var subtotal = $('#total_gravado_iva').text(); /*total gravado mas iva subtotal*/
  var suma_gravada = $('#total_gravado_sin_iva').text(); /*total sumas sin iva*/
  var sumas = $('#total_gravado').text(); /*total sumas sin iva + exentos*/
  var iva = $('#total_iva').text(); /*porcentaje de iva de la factura*/
  var retencion = $('#total_retencion').text(); /*total retencion cuando un cliente retiene 1 o 10 %*/
  var venta_exenta = $('#total_exenta').text(); /*total venta exenta*/
  var total = $('#totalfactura').val();

  var id_vendedor = $("#vendedor option:selected").val();

  var tipo_impresion = $('#tipo_impresion').val();


  var fecha_movimiento = $("#fecha").val();
  var id_prod = 0;
  if (fecha_movimiento == '' || fecha_movimiento == undefined) {
    var typeinfo = 'Warning';
    msg = 'Seleccione una Fecha!';
    display_notify(typeinfo, msg);
  }
  var verificaempleado = 'noverificar';
  var verifica = [];
  var array_json = new Array();
  $("#inventable tr").each(function(index) {
    var id_detalle = $(this).attr("id_detalle");
    if (id_detalle == undefined) {
      id_detalle = "";
    }
    var id = $(this).find("td:eq(0)").text();
    var id_presentacion = $(this).find('.sel').val();
    var precio_venta = $(this).find("#precio_venta").val();
    var cantidad = $(this).find("#cant").val();
    var unidades = $(this).find("#unidades").val();
    var exento = $(this).find("#exento").val();
    var subtotal = $(this).find("#subtotal_fin").val();

    if (cantidad && precio_venta) {
      var obj = new Object();
      obj.id_detalle = id_detalle;
      obj.id = id;
      obj.precio = precio_venta;
      obj.cantidad = cantidad;
      obj.unidades = unidades;
      obj.subtotal = subtotal;
      obj.id_presentacion = id_presentacion;
      obj.exento = exento;
      //convert object to json string
      text = JSON.stringify(obj);
      array_json.push(text);
      i = i + 1;
    } else {
      error = true
    }
  });
  json_arr = '[' + array_json + ']';

  var urlprocess = "venta.php";
  var id_cotizacion = "";

  if (i == 0) {
    error = true
  }

  var dataString = 'process=insert_preventa' + '&cuantos=' + i + '&fecha_movimiento=' + fecha_movimiento;
  dataString += '&id_cliente=' + id_cliente + '&total=' + total;
  dataString += '&id_vendedor=' + id_vendedor + '&json_arr=' + json_arr;
  dataString += '&retencion=' + retencion;
  dataString += '&total_percepcion=' + total_percepcion;
  dataString += '&iva=' + iva;
  dataString += '&items=' + items;
  dataString += '&subtotal=' + subtotal;
  dataString += '&sumas=' + sumas;
  dataString += '&venta_exenta=' + venta_exenta;
  dataString += '&suma_gravada=' + suma_gravada;
  dataString += '&tipo_impresion=' + tipo_impresion;
  dataString += '&id_factura=' + id_factura;
  dataString += '&precio_aut=' + precio_aut;
  dataString += '&clave=' + clave;



  if (id_cliente == "") {
    msg = 'Seleccione un Cliente!';
    sel_vendedor = 0;
  }

  if (tipo_impresion == "") {
    msg = 'Seleccione un tipo de impresion!';
    sel_vendedor = 0;
  }

  if (i == 0) {
    msg = 'Seleccione al menos un producto !';
    sel_vendedor = 0;
  }

  if (sel_vendedor == 1) {
    $("#inventable tr").remove();
    $.ajax({
      type: 'POST',
      url: urlprocess,
      data: dataString,
      dataType: 'json',
      success: function(datax) {
        if (datax.typeinfo == "Success") {
          swal({
            html: true,
            title: "<b>Referencia <i># " + datax.referencia + "</i><br>$ " + datax.tot + "</b>",
            text: "<b>Presione OK para continuar</b>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: '',
            confirmButtonText: 'OK',
            closeOnConfirm: false,
            closeOnCancel: true
          }, function(isConfirm) {
            if (isConfirm) {
              setInterval("reload1();", 500);
            } else {}

          });


        }
      }
    });
  } else {
    display_notify('Warning', msg);
  }
}


function senddata() {
  //Obtener los valores a guardar de cada item facturado
  var procces = $("#process").val();
  var i = 0;
  var StringDatos = "";
  var id = '1';
  var id_empleado = 0;
  var id_cliente = $("#id_cliente").val();
  var items = $("#items").val();
  var msg = "";
  //IMPUESTOS
  error = false;


  var total_percepcion = $('#total_percepcion').text();
  var id_factura = $('#id_factura').val();
  var subtotal = $('#total_gravado_iva').text(); /*total gravado mas iva subtotal*/
  var suma_gravada = $('#total_gravado_sin_iva').text(); /*total sumas sin iva*/
  var sumas = $('#total_gravado').text(); /*total sumas sin iva + exentos*/
  var iva = $('#total_iva').text(); /*porcentaje de iva de la factura*/
  var retencion = $('#total_retencion').text(); /*total retencion cuando un cliente retiene 1 o 10 %*/
  var venta_exenta = $('#total_exenta').text(); /*total venta exenta*/
  var total = $('#totalfactura').val();
  var tipo_pago = $('#con_pago').val();
  var id_vendedor = $("#vendedor").val();
  var id_apertura = $('#id_apertura').val();
  var turno = $('#turno').val();
  var caja = $('#caja').val();
  var credito = $('#con_pago').val();

  var tipo_impresion = $('#tipo_impresion').val();


  var fecha_movimiento = $("#fecha").val();
  var id_prod = 0;
  if (fecha_movimiento == '' || fecha_movimiento == undefined) {
    var typeinfo = 'Warning';
    msg = 'Seleccione una Fecha!';
    //display_notify(typeinfo, msg);
  }
  var verificaempleado = 'noverificar';
  var verifica = [];
  var array_json = new Array();
  $("#inventable tr").each(function(index) {
    var id_detalle = $(this).attr("id_detalle");
    if (id_detalle == undefined) {
      id_detalle = "";
    }
    var id = $(this).find("td:eq(0)").text();
    var id_presentacion = $(this).find('.sel').val();
    var precio_venta = $(this).find("#precio_venta").val();
    var cantidad = parseFloat($(this).find("#cant").val());

    if (isNaN(cantidad)) {
      cantidad = 0;
    }
    var unidades = $(this).find("#unidades").val();
    var exento = $(this).find("#exento").val();
    var subtotal = $(this).find("#subtotal_fin").val();

    if (cantidad > 0 && precio_venta) {
      var obj = new Object();
      obj.id_detalle = id_detalle;
      obj.id = id;
      obj.precio = precio_venta;
      obj.cantidad = cantidad;
      obj.unidades = unidades;
      obj.subtotal = subtotal;
      obj.id_presentacion = id_presentacion;
      obj.exento = exento;
      //convert object to json string
      text = JSON.stringify(obj);
      array_json.push(text);
      i = i + 1;
    } else {
      error = true
    }
  });
  json_arr = '[' + array_json + ']';
  if (procces == "insert") {
    var urlprocess = "preventa.php";
    var id_cotizacion = "";
  }

  if (i == 0) {
    error = true
  }

  var dataString = 'process=insert' + '&cuantos=' + i + '&fecha_movimiento=' + fecha_movimiento;
  dataString += '&id_cliente=' + id_cliente + '&total=' + total;
  dataString += '&id_vendedor=' + id_vendedor + '&json_arr=' + json_arr;
  dataString += '&retencion=' + retencion;
  dataString += '&total_percepcion=' + total_percepcion;
  dataString += '&iva=' + iva;
  dataString += '&items=' + items;
  dataString += '&subtotal=' + subtotal;
  dataString += '&sumas=' + sumas;
  dataString += '&venta_exenta=' + venta_exenta;
  dataString += '&suma_gravada=' + suma_gravada;
  dataString += '&tipo_impresion=' + tipo_impresion;
  dataString += '&id_factura=' + id_factura;
  dataString += '&id_apertura=' + id_apertura;
  dataString += '&turno=' + turno;
  dataString += '&caja=' + caja;
  dataString += '&credito=' + credito;


  var sel_vendedor = 1;
  if (credito == "") {
    msg = 'No a seleccionado un tipo de pago!';
    sel_vendedor = 0;
  }

  if (id_cliente == "") {
    msg = 'No hay un Cliente!';
    sel_vendedor = 0;
  }

  if (tipo_impresion == "") {
    msg = 'No hay un tipo de impresion seleccionada!';
    sel_vendedor = 0;
  }

  if (i == 0) {
    msg = 'Seleccione al menos un producto !';
    sel_vendedor = 0;
  }

  if (sel_vendedor == 1) {
    $("#inventable tr").remove();
    $.ajax({
      type: 'POST',
      url: urlprocess,
      data: dataString,
      dataType: 'json',
      success: function(datax) {
        if (datax.typeinfo == "Success") {
          $(".usage").attr("disabled", true);
          if (tipo_impresion == "CCF" || tipo_impresion == "COF") {
            if (tipo_impresion == "CCF") {
              $("#nitcli").attr('readOnly', false);
              $("#nrccli").attr('readOnly', false);
              $("#nitcli").val(datax.nit);
							$("#nrccli").val(datax.nrc);
            }
            $("#nomcli").attr('readOnly', false);
            $("#numdoc").attr('readOnly', false);
            $("#dircli").attr('readOnly', false);

            $('#nomcli').val(datax.nombre);
						$("#dircli").val(datax.direccion);

            $("#numdoc").focus();
          } else {
            $("#efectivov").focus();
            $('#numdoc').val(datax.ultimo);
          }
          $("#tot_fdo").val(total);
          //activa_modal(datax.numdoc,datax.numdoc,id_cliente);
          $('#id_factura').val(datax.id_factura);
          ultimo = parseInt(datax.ultimo);
          if (ultimo != 0) {
            //$('#num_doc_fact').val(ultimo);
          }
          $('#corr_in').val(datax.numdoc);
        } else {
          display_notify(datax.typeinfo, datax.msg);
        }
      }
    });
  } else {
    display_notify('Warning', msg);
    $("#submit1").removeAttr('disabled');
  }
}

$(document).on("keyup", "#efectivo", function() {
  total_efectivo();
});
$(document).on("keyup", "#efectivov", function(evt) {
  if (evt.keyCode != 13) {
    total_efectivov();
  } else {
    if (parseFloat($("#cambiov").val()) >= 0) {
      imprimev();
    } else {
      display_notify("Warning", "Ingrese un valor mayor o igual al total facturado");
    }
  }
});
$(document).on("keyup", "#numdoc", function(evt) {
  if (evt.keyCode == 13) {
    if ($(this).val() != "") {
      $("#nomcli").focus();
    } else {
      display_notify('Warning', 'Ingrese el numero del documento a imprimir');
    }
  }
});
$(document).on("keyup", "#nomcli", function(evt) {
  if (evt.keyCode == 13) {
    if ($(this).val() != "") {
      $("#dircli").focus();
    } else {
      display_notify('Warning', 'Ingrese el nombre del cliente');
    }
  }
});
$(document).on("keyup", "#dircli", function(evt) {
  if (evt.keyCode == 13) {
    if ($(this).val() != "") {
      if ($("#tipo_impresion").val() == 'CCF') {
        $("#nitcli").focus();
      } else {
        $("#efectivov").focus();
      }
    } else {
      display_notify('Warning', 'Ingrese la direccion del cliente');
    }
  }

});
$(document).on("keyup", "#nitcli", function(evt) {
  if (evt.keyCode == 13) {
    if ($(this).val() != "") {
      $("#nrccli").focus();
    } else {
      display_notify('Warning', 'Ingrese el numero de NIT del cliente');
    }
  }
});
$(document).on("keyup", "#nrccli", function(evt) {
  if (evt.keyCode == 13) {
    if ($(this).val() != "") {
      $("#efectivov").focus();
    } else {
      display_notify('Warning', 'Ingrese el numero de registro del cliente');
    }
  }
});

function activa_modal(numfact, numdoc, id_cliente) {
  urlprocess = "venta.php";
  $('#num_doc_fact').numeric({
    negative: false,
    decimal: false
  });
  $('#viewModal').modal({
    backdrop: 'static',
    keyboard: false
  });
  var totalfinal = parseFloat($('#total_dinero').text());
  var tipo_impresion = $('#tipo_impresion').val();
  if (tipo_impresion == "TIK") {
    $('#fact_cf').hide();
  } else {
    $('#fact_cf').show();
  }
  if (tipo_impresion == "CCF") {
    $('#ccf').show();

    //para traer datos de cliente si existe
    var id_client = $('#id_cliente').val();
    var dataString = 'process=mostrar_datos_cliente' + '&id_client=' + id_client;
    $.ajax({
      type: 'POST',
      url: urlprocess,
      data: dataString,
      dataType: 'json',
      success: function(data) {
        nit = data.nit;
        registro = data.registro;
        nombreape = data.nombreape;
        $('#nit').val(nit);
        $('#nrc').val(registro);
        $('#nombreape').val(nombreape);
      }
    });

  } else {
    $('#ccf').hide();
  }
  var facturado = parseFloat($('#totalfactura').val()).toFixed(2);
  $(".modal-body #facturado").val(facturado);

  $(".modal-body #fact_num").html(numdoc);
  $(".modal-body #efectivo").focus();
}

function total_efectivo() {
  var efectivo = parseFloat($('#efectivo').val());
  var totalfinal = parseFloat($('#totalfactura').val());
  var facturado = totalfinal.toFixed(2);
  $('#facturado').val(facturado);
  if (isNaN(parseFloat(efectivo))) {
    efectivo = 0;
  }
  if (isNaN(parseFloat(totalfinal))) {
    totalfinal = 0;
  }
  var cambio = efectivo - totalfinal;
  var cambio = round(cambio, 2);
  var cambio_mostrar = cambio.toFixed(2);
  $('#cambio').val(cambio_mostrar);
}

function total_efectivov() {
  var efectivo = parseFloat($('#efectivov').val());
  var totalfinal = parseFloat($('#tot_fdo').val());
  var facturado = totalfinal.toFixed(2);

  if (isNaN(parseFloat(efectivo))) {
    efectivo = 0;
  }
  if (isNaN(parseFloat(totalfinal))) {
    totalfinal = 0;
  }
  var cambio = efectivo - totalfinal;
  var cambio = round(cambio, 2);
  var cambio_mostrar = cambio.toFixed(2);
  $('#cambiov').val(cambio_mostrar);
}

function imprime1() {
  var numero_doc = $(".modal-body #fact_num").html();
  var print = 'imprimir_fact';
  var tipo_impresion = $("#tipo_impresion").val();
  var fecha_fact = $("#fecha_fact").val();

  var id_factura = $("#id_factura").val();
  if (tipo_impresion == "TIK") {
    var num_doc_fact = '';
    numero_factura_consumidor = '';
  } else {
    var numero_factura_consumidor = $(".modal-body #num_doc_fact").val();
    var num_doc_fact = $(".modal-body #num_doc_fact").val();
  }
  var dataString = 'process=' + print + '&numero_doc=' + numero_doc + '&tipo_impresion=' + tipo_impresion + '&num_doc_fact=' + id_factura + '&numero_factura_consumidor=' + numero_factura_consumidor + '&fecha_fact=' + fecha_fact;

  if (tipo_impresion == "CCF") {
    nit = $('.modal-body #nit').val();
    nrc = $('.modal-body #nrc').val();
    nombreape = $('.modal-body #nombreape').val();
    dataString += '&nit=' + nit + '&nrc=' + nrc + '&nombreape=' + nombreape;
  }
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datos) {
      var sist_ope = datos.sist_ope;
      var dir_print = datos.dir_print;
      var shared_printer_win = datos.shared_printer_win;
      var shared_printer_pos = datos.shared_printer_pos;
      var headers = datos.headers;
      var footers = datos.footers;
      var efectivo_fin = parseFloat($('#efectivo').val());
      var cambio_fin = parseFloat($('#cambio').val());

      //esta opcion es para generar recibo en  printer local y validar si es win o linux
      if (tipo_impresion == 'COF') {
        if (sist_ope == 'win') {
          $.post("http://" + dir_print + "printfactwin1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin,
            shared_printer_win: shared_printer_win
          })
        } else {
          $.post("http://" + dir_print + "printfact1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin
          }, function(data, status) {

            if (status != 'success') {
              //alert("No Se envio la impresión " + data);
            }

          });
        }
      }
      if (tipo_impresion == 'ENV') {
        if (sist_ope == 'win') {
          $.post("http://" + dir_print + "printenvwin1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin,
            shared_printer_win: shared_printer_win
          })
        } else {
          $.post("http://" + dir_print + "printenv1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin
          }, function(data, status) {

            if (status != 'success') {
              //alert("No Se envio la impresión " + data);
            }

          });
        }
      }
      if (tipo_impresion == 'TIK') {
        if (sist_ope == 'win') {
          $.post("http://" + dir_print + "printposwin1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin,
            shared_printer_pos: shared_printer_pos,
            headers: headers,
            footers: footers,
          })
        } else {
          $.post("http://" + dir_print + "printpos1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin,
            headers: headers,
            footers: footers,
          }, function(data, status) {

            if (status != 'success') {
              //alert("No Se envio la impresión " + data);
            }

          });
        }
      }
      if (tipo_impresion == 'CCF') {
        if (sist_ope == 'win') {
          $.post("http://" + dir_print + "printcfwin1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin,
            shared_printer_win: shared_printer_win
          })
        } else {
          $.post("http://" + dir_print + "printcf1.php", {
            datosventa: datos.facturar,
            efectivo: efectivo_fin,
            cambio: cambio_fin
          }, function(data, status) {

            if (status != 'success') {
              //alert("No Se envio la impresión " + data);
            }

          });
        }
      }
      //  setInterval("reload1();", 500);
    }
  });
}

function imprimev() {

  var imprimiendo = parseInt($('#imprimiendo').val());
  $('#imprimiendo').val(1);
  var numero_doc = $("#numdoc").val();
  var print = 'imprimir_fact';
  var tipo_impresion = $("#tipo_impresion").val();
  var tipo_impresiona = $("#tipo_impresion option:selected").text();
  console.log(tipo_impresiona);
  var fecha_fact = $("#fecha_fact").val();
  var direccion = $("#dircli").val();

  var id_factura = $("#id_factura").val();
  if (tipo_impresion == "TIK") {
    numero_factura_consumidor = '';
  } else {
    var numero_factura_consumidor = $("#numdoc").val();
  }
  var dataString = 'process=' + print + '&numero_doc=' + numero_doc + '&tipo_impresion=' + tipo_impresion + '&num_doc_fact=' + id_factura + '&numero_factura_consumidor=' + numero_factura_consumidor + '&fecha_fact=' + fecha_fact;
  nombreape = $("#nomcli").val();
  if (tipo_impresion == "CCF") {
    nit = $("#nitcli").val(); //$('.modal-body #nit').val();
    nrc = $("#nrccli").val(); //$('.modal-body #nrc').val();
    //$('.modal-body #nombreape').val();
    dataString += '&nit=' + nit + '&nrc=' + nrc;
  }
  dataString += "&direccion=" + direccion + '&nombreape=' + nombreape;

  if (imprimiendo == 0) {
    $.ajax({
      type: 'POST',
      url: "venta.php",
      data: dataString,
      dataType: 'json',
      success: function(datos) {
        var sist_ope = datos.sist_ope;
        var dir_print = datos.dir_print;
        var shared_printer_win = datos.shared_printer_win;
        var shared_printer_pos = datos.shared_printer_pos;
        var headers = datos.headers;
        var footers = datos.footers;
        var efectivo_fin = parseFloat($('#efectivov').val());
        var cambio_fin = parseFloat($('#cambiov').val());

        //esta opcion es para generar recibo en  printer local y validar si es win o linux
        if (tipo_impresion == 'COF') {
          if (sist_ope == 'win') {
            $.post("http://" + dir_print + "printfactwin1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin,
              shared_printer_win: shared_printer_win
            })
          } else {
            $.post("http://" + dir_print + "printfact1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin
            }, function(data, status) {

              if (status != 'success') {
                //alert("No Se envio la impresión " + data);
              }
            });
          }
        }
        if (tipo_impresion == 'ENV') {
          if (sist_ope == 'win') {
            $.post("http://" + dir_print + "printenvwin1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin,
              shared_printer_win: shared_printer_win
            })
          } else {
            $.post("http://" + dir_print + "printenv1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin
            }, function(data, status) {

              if (status != 'success') {
                //alert("No Se envio la impresión " + data);
              }

            });
          }
        }
        if (tipo_impresiona == 'TICKET') {
          if (sist_ope == 'win') {
            $.post("http://" + dir_print + "printposwin1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin,
              shared_printer_pos: shared_printer_pos,
              headers: headers,
              footers: footers,
            })
          } else {
            $.post("http://" + dir_print + "printpos1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin,
              headers: headers,
              footers: footers,
            }, function(data, status) {

              if (status != 'success') {
                //alert("No Se envio la impresión " + data);
              }

            });
          }
        }
        if (tipo_impresion == 'CCF') {
          if (sist_ope == 'win') {
            $.post("http://" + dir_print + "printcfwin1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin,
              shared_printer_win: shared_printer_win
            })
          } else {
            $.post("http://" + dir_print + "printcf1.php", {
              datosventa: datos.facturar,
              efectivo: efectivo_fin,
              cambio: cambio_fin
            }, function(data, status) {

              if (status != 'success') {
                //alert("No Se envio la impresión " + data);
              }

            });
          }
        }
        //  setInterval("reload1();", 500);
        swal({
            html:true,
            title: "Gaveta abierta",
              text: "<b class='swstyle'>Efectivo: $ "+efectivo_fin+" <br> Cambio: $ "+cambio_fin+"</b> <br> <b class='inf'>Presione enter para Salir</b>",
            showCancelButton: false,
            confirmButtonClass: "btn-success",
            cancelButtonClass: "btn-info",
            confirmButtonText: "Cerrar",
            cancelButtonText: "No, Reimprimir",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {
              setTimeout(function() {
                location.reload();
              }, 500);
            } else {
              setTimeout(function() {
                location.reload();
              }, 500);
            }
          });
        setTimeout(function() {
          location.reload();
        }, 3000);
      }
    });
  }
}

function reload1() {
  location.href = 'venta.php';
}


$(document).on("click", "#btnAddClient", function(event) {
  agregarcliente();
});

function agregarcliente() {
  urlprocess = "venta.php";
  var nombress = $(".modal-body #nombress").val();
  var duii = $(".modal-body #duii").val();
  var tel1 = $(".modal-body #tel1").val();
  var tel2 = $(".modal-body #tel2").val();
  var dataString = 'process=agregar_cliente' + '&nombress=' + nombress;
  dataString += '&dui=' + duii + '&tel1=' + tel1 + '&tel2=' + tel2;
  $.ajax({
    type: "POST",
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      var process = datax.process;
      var id_client = datax.id_client;
      // Agragar datos a select2
      //var nombreape = nombress + " " + apellidoss;
      $("#id_cliente").append("<option value='" + id_client + "' selected>" + nombress + "</option>");
      $("#id_cliente").trigger('change');

      //Cerrar Modal
      $('#clienteModal').modal('hide');
      //Agregar NRC y NIT al form de Credito Fiscal
      display_notify(datax.typeinfo, datax.msg);
      $(document).on('hidden.bs.modal', function(e) {

        var target = $(e.target);
        target.removeData('bs.modal').find(".modal-content").html('');
      });
    }
  });
}
$(document).on("click", "#btnEsc2", function(event) {
  $('#clienteModal').modal('hide');
  //reload1();
});
$(document).on('change', '#tipo_impresion', function(event) {
  $('#inventable tr').each(function(index) {
    var tr = $(this);
    actualiza_subtotal(tr);
  });
});


function addProductList(id_proda, tip)
{
  $(".select2-dropdown").hide();
  $('#inventable').find('tr#filainicial').remove();
  id_proda = $.trim(id_proda);
  id_factura = parseInt($('#id_factura').val());
  if (isNaN(id_factura))
	{
    id_factura = 0;
  }
  precio_aut = $("#precio_aut").val();

  urlprocess = "venta.php";
  var dataString = 'process=consultar_stock'+'&id_producto='+id_proda+'&id_factura='+id_factura+'&tipo='+tip+'&precio_aut='+precio_aut ;
  $.ajax({
    type: "POST",
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(data)
		{
			if(data.typeinfo == "Success")
			{
	      var id_prod = data.id_producto;
	      var precio_venta = data.precio_venta;
	      var unidades = data.unidades;
	      var existencias = data.stock;
	      var perecedero = data.perecedero;
	      var descrip_only = data.descripcion;
	      var fecha_fin_oferta = data.fecha_fin_oferta;
	      var exento = data.exento;
	      var categoria = data.categoria;
	      var select_rank = data.select_rank;

        var decimals=data.decimals;
        if (decimals==1) {
          categoria=86;
        }


	      var preciop_s_iva = parseFloat(data.preciop_s_iva);

	      var tipo_impresion = $('#tipo_impresion').val();

	      var filas = parseInt($("#filas").val());
        filas++;
	      var exento = "<input type='hidden' id='exento' name='exento' value='" + exento + "'>";
	      var subtotal = subt(data.preciop, 1);
	      subt_mostrar = subtotal.toFixed(2);
	      var cantidades = "<td class='cell100 column10 text-success'><input type='text'  class='form-control decimal2 " + categoria + " cant' id='cant' name='cant' value='' style='width:60px;'></td>";
	      tr_add = '';
	      tr_add += "<tr  class='row100 head' id='" + filas + "'>";
	      tr_add += "<td hidden class='cell100 column10 text-success id_pps'><input type='hidden' id='unidades' name='unidades' value='" + data.unidadp + "'>" + id_prod + "</td>";
	      tr_add += "<td class='cell100 column30 text-success'>" + descrip_only + exento + '</td>';
	      tr_add += "<td class='cell100 column10 text-success' id='cant_stock'>" + existencias + "</td>";
	      tr_add += cantidades;
	      tr_add += "<td class='cell100 column10 text-success preccs'>" + data.select + "</td>";
	      tr_add += "<td hidden class='cell100 column10 text-success descp'><input type'text' id='dsd' class='form-control' value='" + data.descripcionp + "' class='txt_box' readonly></td>";
	      tr_add += "<td class='cell100 column10 text-success rank_s'>" + data.select_rank + "</td>";
	      tr_add += "<td class='cell100 column10 text-success'><input type='hidden'  id='precio_venta_inicial' name='precio_venta_inicial' value='" + data.preciop + "'><input type='hidden'  id='precio_sin_iva' name='precio_sin_iva' value='" + preciop_s_iva + "'><input type='text'  class='form-control decimal' id='precio_venta' name='precio_venta' value='" + data.preciop + "'></td>";
	      if (tipo_impresion == "CCF") {
	        tr_add += "<td class='ccell100 column10'>" + "<input type='hidden'  id='subtotal_fin' name='subtotal_fin' value='" + "0.00" + "'>" + "<input type='text'  class='decimal txt_box form-control' id='subtotal_mostrar' name='subtotal_mostrar'  value='" + "0.00" + "'readOnly></td>";

	      } else {
	        tr_add += "<td class='ccell100 column10'>" + "<input type='hidden'  id='subtotal_fin' name='subtotal_fin' value='" + "0.00" + "'>" + "<input type='text'  class='decimal txt_box form-control' id='subtotal_mostrar' name='subtotal_mostrar'  value='" + "0.00" + "'readOnly></td>";

	      }
	      tr_add += '<td class="cell100 column10 Delete text-center"><input id="delprod" type="button" class="btn btn-danger fa"  value="&#xf1f8;"> <a data-toggle="modal" href="ver_imagen.php?id_producto='+id_prod+'"  data-target="#viewProd" data-refresh="true" class="btn btn-primary btnViw fa"><i class="fa fa-eye"></i></a></td>';
	      tr_add += '</tr>';
	      //numero de filas
	      $("#inventable").prepend(tr_add);
	      $(".decimal2").numeric({
	        negative: false,
	        decimal: false
	      });
	      $(".86").numeric({
	        negative: false,
	        decimalPlaces: 4
	      });
	      $('#filas').val(filas);
	      $('#items').val(filas);
	      $(".sel").select2();
	      $(".sel_r").select2();
	      $('#inventable #' +filas).find("#cant").focus();
	      totales();
	      scrolltable();
    	}
			else
			{
				display_notify("Error", data.msg);
			}
		}
  });
  totales();
}
$(document).on('keyup', '.cant', function(evt) {
  var tr = $(this).parents("tr");

  if (evt.keyCode == 13) {
    num = parseFloat($(this).val());
    if (isNaN(num)) {
      num = 0;
    }
    if ($(this).val() != "" && num > 0) {
      tr.find('.sel').select2("open");
    }
  }

  fila = $(this).closest('tr');
  id_producto = fila.find('.id_pps').text();
  existencia = parseFloat(fila.find('#cant_stock').text());
  existencia = round(existencia, 4);
  a_cant = parseFloat(fila.find('#cant').val());
  unidad = parseInt(fila.find('#unidades').val());
  a_cant = parseFloat(a_cant * unidad);
  a_cant = round(a_cant, 4);
  //console.log(a_cant);
  //console.log(id_producto);
  a_asignar = 0;

  $('#inventable tr').each(function(index) {

    if ($(this).find('.id_pps').text() == id_producto) {
      t_cant = parseFloat($(this).find('#cant').val());
      t_cant = round(t_cant, 4);
      if (isNaN(t_cant)) {
        t_cant = 0;
      }
      t_unidad = parseInt($(this).find('#unidades').val());
      if (isNaN(t_unidad)) {
        t_unidad = 0;
      }
      t_cant = parseFloat((t_cant * t_unidad));
      a_asignar = a_asignar + t_cant;
      a_asignar = round(a_asignar, 4);
    }
  });
  console.log(existencia);
  console.log(a_asignar);

  if (a_asignar > existencia) {
    val = existencia - (a_asignar - a_cant);
    val = val / unidad;
    val = Math.trunc(val);
    val = parseInt(val);
    fila.find('#cant').val(val);
  }

  actualiza_subtotal(tr);
});
$(document).on('select2:close', '.sel_r', function() {
  var tr = $(this).parents("tr");
  console.log(tr);
  tr.find("#precio_venta").focus();
});

$(document).on('keyup', '#precio_venta', function(event) {

  if (event.keyCode==13) {
    if ($('#b').attr('hidden')) {
      $('#codigo').focus();
    } else {
      $('#producto_buscar').focus();
    }
  }
});




$(document).on('select2:close', '.sel', function(event) {
  var tr = $(this).parents("tr");
  var cantid = tr.find("#cant").val();
  var id_presentacion = $(this).val();
  var a = $(this);
  precio_aut = $("#precio_aut").val();
  //console.log(id_presentacion);
  $.ajax({
    url: 'venta.php',
    type: 'POST',
    dataType: 'json',
    data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion + "&cant=" + cantid + "&precio_aut=" + precio_aut,
    success: function(data) {
      a.closest('tr').find('.descp').html(data.descripcion);
      a.closest('tr').find('#precio_venta').val(data.precio);
      a.closest('tr').find('#unidades').val(data.unidad);
      a.closest('tr').find('#precio_sin_iva').val(data.preciop_s_iva);
      a.closest('tr').find(".rank_s").html(data.select_rank);
      fila = a.closest('tr');
      id_producto = fila.find('.id_pps').text();
      existencia = parseFloat(fila.find('#cant_stock').text());
      existencia = round(existencia, 4);
      a_cant = parseFloat(fila.find('#cant').val());
      unidad = parseInt(fila.find('#unidades').val());
      a_cant = parseFloat(a_cant * data.unidad);
      a_cant = round(a_cant, 4);
      $(".sel_r").select2();
      a.closest('tr').find('.sel_r').select2("open");
      //console.log(a_cant);
      //console.log(id_producto);
      a_asignar = 0;

      $('#inventable tr').each(function(index) {

        if ($(this).find('.id_pps').text() == id_producto) {
          t_cant = parseFloat($(this).find('#cant').val());
          t_cant = round(t_cant, 4);
          if (isNaN(t_cant)) {
            t_cant = 0;
          }
          t_unidad = parseInt($(this).find('#unidades').val());
          if (isNaN(t_unidad)) {
            t_unidad = 0;
          }
          t_cant = parseFloat((t_cant * t_unidad));
          a_asignar = a_asignar + t_cant;
          a_asignar = round(a_asignar, 4);
        }
      });
      //console.log(existencia);
      //console.log(a_asignar);

      if (a_asignar > existencia) {
        val = existencia - (a_asignar - a_cant);
        val = val / unidad;
        val = Math.trunc(val);
        val = parseInt(val);
        fila.find('#cant').val(val);
      }

      var tr = a.closest('tr');
      actualiza_subtotal(tr);
    }
  });
  setTimeout(function() {
    totales();
  }, 200);


});

$(document).on('change', '.sel_r', function(event) {
  var a = $(this).closest('tr');
  precio = parseFloat($(this).val());
  a.find('#precio_venta').val(precio);
  a.find("#precio_sin_iva").val(precio / 1.13);
  actualiza_subtotal(a);
});

$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnIngreso", function(event) {
    agregar_ingreso();
  });
  $(document).on("click", "#btnSalida", function(event) {
    agregar_salida();
  });
});


function agregar_ingreso() {
  var id_empleado = $("#id_empleado2").val();
  var id_apertura = $("#id_apertura2").val();
  var id_tipo = $("#tipo2").val();
  var turno = $("#turno2").val();
  var monto = $("#monto2").val();
  var concepto = $("#concepto2").val();

  var datos = "process=ingreso" + "&id_apertura=" + id_apertura + "&id_empleado=" + id_empleado + "&turno=" + turno + "&monto=" + monto + "&concepto=" + concepto + "&id_tipo=" + id_tipo;

  if (sending==0) {
    sending=1;
    $.ajax({
      type: "POST",
      url: "agregar_ingreso_caja.php",
      data: datos,
      dataType: 'json',
      success: function(datax) {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success") {
          imprimir_vale(datax.id_mov);
          setInterval("location.reload();", 1000);
          $('#viewModal').hide();
        }
      }
    });
  }
  else {
    console.log("Ya se estan enviando datos");
  }
}

function agregar_salida() {
  var id_empleado = $("#id_empleado2").val();
  var id_apertura = $("#id_apertura2").val();
  var turno = $("#turno2").val();
  var monto = $("#monto2").val();
  var concepto = $("#concepto2").val();
  var tipo_doc = $("#tipo_doc2").val();
  var n_doc = $("#n_doc2").val();
  var recibe = $("#recibe2").val();
  var proveedor = $("#proveedor2").val();
  var id_tipo = $("#tipo2").val();
  var datos = "process=salida" + "&id_apertura=" + id_apertura + "&id_empleado=" + id_empleado + "&turno=" + turno + "&monto=" + monto + "&concepto=" + concepto + "&proveedor=" + proveedor + "&tipo_doc=" + tipo_doc + "&n_doc=" + n_doc + "&recibe=" + recibe + "&id_tipo=" + id_tipo;

  if (sending==0) {
    sending=1;
    $.ajax({
      type: "POST",
      url: "agregar_salida_caja.php",
      data: datos,
      dataType: 'json',
      success: function(datax) {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success") {
          imprimir_vale(datax.id_mov);
          setInterval("location.reload();", 1000);
          $('#salidaModal').hide();
        }
      }
    });
  }
}

function imprimir_vale(id_movimiento) {
  var datoss = "process=imprimir" + "&id_movimiento=" + id_movimiento;
  $.ajax({
    type: "POST",
    url: "agregar_ingreso_caja.php",
    data: datoss,
    dataType: 'json',
    success: function(datos) {
      var sist_ope = datos.sist_ope;
      var dir_print = datos.dir_print;
      var shared_printer_win = datos.shared_printer_win;
      var shared_printer_pos = datos.shared_printer_pos;

      if (sist_ope == 'win') {
        $.post("http://" + dir_print + "printvalewin1.php", {
          datosvale: datos.movimiento,
          shared_printer_win: shared_printer_win,
          shared_printer_pos: shared_printer_pos,
        })
      } else {
        $.post("http://" + dir_print + "printvale1.php", {
          datosvale: datos.movimiento
        });
      }

    }
  });
}

$(document).on('keyup', '.external', function(event) {

  var q = $(this).val();

  if (q.length > 2) {
    $.ajax({
      url: 'http://farmacialafe.ddns.net/sistema/consulta.php',
      type: 'POST',
      dataType: 'json',
      data: {
        hash: 'd681824931f81f6578e63fd7e35095af',
        q: q
      },
      success: function(datax) {
        $('.extern').html(datax.data);
      }
    })
  }


});
function abrir_caja()
{
	$.post("http://localhost/impresion/abrir.php", {datosventa: ""});
}


$(document).on('keydown', '#aut_code', function(event) {
  if (event.keyCode == 13) {
    a= $(this);
    $(this).attr('disabled', 'disabled');
    $.ajax({
      url: 'venta.php',
      type: 'POST',
      dataType: 'json',
      data: {
        process: "getcode",
        clave: $(this).val(),
      },
      success: function (xdatos) {

        if (xdatos.typeinfo=='Success') {
          display_notify(xdatos.typeinfo, xdatos.msg);
          $('#precio_aut').val(xdatos.precio);
          $('#clave').val(xdatos.clave);
          aplicar();
        }
        else {
          display_notify(xdatos.typeinfo, xdatos.msg);
          a.removeAttr('disabled');
        }

      }
    })

  }
});

$(document).on('change', '#id_cliente', function(event) {

  $.ajax({
    url: 'venta.php',
    type: 'POST',
    dataType: 'json',
    data: {process: 'mostrar_datos_cliente', id_client: $("#id_cliente").val()},
    success: function(xdatos) {
      $("#porc_retencion1").val(xdatos.retencion);
      $("#porc_retencion10").val("0");

      totales();
    }
  })
});


function aplicar() {

  $('#inventable tr').each(function(index, el) {

      var tr = $(this);
      var cantid = tr.find("#cant").val();
      var id_presentacion = $(this).find(".sel").val();
      var a = $(this).find(".sel");
      precio_aut = $("#precio_aut").val();
      //console.log(id_presentacion);
      $.ajax({
        url: 'venta.php',
        type: 'POST',
        dataType: 'json',
        data: 'process=tabla' + "&id_presentacion=" + id_presentacion + "&cant=" + cantid + "&precio_aut=" + precio_aut,
        success: function(data) {
          a.closest('tr').find('.descp').html(data.descripcion);
          a.closest('tr').find('#precio_venta').val(data.precio);
          a.closest('tr').find('#unidades').val(data.unidad);
          a.closest('tr').find('#precio_sin_iva').val(data.preciop_s_iva);
          a.closest('tr').find(".rank_s").html(data.select_rank);
          fila = a.closest('tr');
          id_producto = fila.find('.id_pps').text();
          existencia = parseFloat(fila.find('#cant_stock').text());
          existencia = round(existencia, 4);
          a_cant = parseFloat(fila.find('#cant').val());
          unidad = parseInt(fila.find('#unidades').val());
          a_cant = parseFloat(a_cant * data.unidad);
          a_cant = round(a_cant, 4);
          $(".sel_r").select2();
          //console.log(a_cant);
          //console.log(id_producto);
          a_asignar = 0;

          $('#inventable tr').each(function(index) {

            if ($(this).find('.id_pps').text() == id_producto) {
              t_cant = parseFloat($(this).find('#cant').val());
              t_cant = round(t_cant, 4);
              if (isNaN(t_cant)) {
                t_cant = 0;
              }
              t_unidad = parseInt($(this).find('#unidades').val());
              if (isNaN(t_unidad)) {
                t_unidad = 0;
              }
              t_cant = parseFloat((t_cant * t_unidad));
              a_asignar = a_asignar + t_cant;
              a_asignar = round(a_asignar, 4);
            }
          });
          //console.log(existencia);
          //console.log(a_asignar);

          if (a_asignar > existencia) {
            val = existencia - (a_asignar - a_cant);
            val = val / unidad;
            val = Math.trunc(val);
            val = parseInt(val);
            fila.find('#cant').val(val);
          }

          var tr = a.closest('tr');
          actualiza_subtotal(tr);
        }
      });
      setTimeout(function() {
        totales();
      }, 200);


  });

};
