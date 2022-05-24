$(document).ready(function() {
  //busqueda con el plugin autocomplete typeahead
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
  $(".sel").select2();
  $(".sel_r").select2();
  generar();
  $("#search").click(function(){
    generar();
  });
  $("#scrollable-dropdown-menu #producto_buscar").typeahead({
    highlight: true,
  }, {
    limit: 100,
    name: 'productos',
    display: 'producto',
    source: function show(q, cb, cba) {
      console.log(q);
      var url = 'autocomplete_producto3.php'+"?query="+q;
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
  $(".select").select2({
    placeholder: {
      id: '',
      text: 'Seleccione',
    },
    allowClear: true,
  });
  if($("#process").val() == "edit")
  {
    totales();
  }
  $("#codigo").focus();

});
$(document).keydown(function(e) {
  if (e.which == 113) { //F2 Guardar
    e.stopPropagation();
    $("#submit1").click();
  }
  if (e.which == 114) { //F3 salir
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
  if (e.which == 115) { //F4 salir
    location.replace("dashboard.php");
    e.stopPropagation();
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
var valor = "";
//evento que captura el texto al pegar y lo envia a otro evt de busqueda de barcode

$(document).on("change", "#id_cliente", function() {
  datos_clientes();
  totales();
});

$(document).on("focus", " #btnSelect", function() {
  $(this).addClass('btn-warning');
  $(this).removeClass('btn-primary');
})

$(document).on("blur", " #btnSelect", function() {
  $(this).removeClass('btn-warning');
  $(this).addClass('btn-primary');
});
//
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  $(document).on("click", "#btnProc", function(event) {
    procesar();
  });
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });
});

// Evento para agregar elementos al grid de factura
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

  urlprocess = "agregar_pedido.php";
  var dataString = 'process=consultar_stock'+'&id_producto='+id_proda+'&id_factura='+id_factura+'&tipo='+tip;
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

	      var preciop_s_iva = parseFloat(data.preciop_s_iva);

	      var tipo_impresion = $('#tipo_impresion').val();

	      var filas = parseInt($("#filas").val());
        filas++;
	      var exento = "<input type='hidden' id='exento' name='exento' value='"+exento+"'>";
	      var subtotal = subt(data.preciop, 1);
	      subt_mostrar = subtotal.toFixed(2);
	      var cantidades = "<td class='cell100 column10 text-success'><div class='col-xs-2'><input type='text'  class='txt_box decimal2 "+categoria+" cant' id='cant' name='cant' value='' style='width:60px;'></div></td>";
	      tr_add = '';
	      tr_add += "<tr  class='row100 head' id='"+filas+"'>";
	      tr_add += "<td hidden class='cell100 column10 text-success id_pps'><input type='hidden' id='unidades' name='unidades' value='"+data.unidadp+"'>"+id_prod+"</td>";
	      tr_add += "<td class='cell100 column30 text-success'>"+descrip_only+exento+'</td>';
	      tr_add += "<td class='cell100 column10 text-success' id='cant_stock'>"+existencias+"</td>";
	      tr_add += cantidades;
	      tr_add += "<td class='cell100 column10 text-success preccs'>"+data.select+"</td>";
	      tr_add += "<td class='cell100 column10 text-success descp'><input type'text' id='dsd' class='form-control' value='"+data.descripcionp+"' class='txt_box' readonly></td>";
	      tr_add += "<td class='cell100 column10 text-success rank_s'>"+data.select_rank+"</td>";
	      tr_add += "<td class='cell100 column10'>"+"<input type='hidden'  id='subtotal_fin' name='subtotal_fin' value='"+"0.00"+"'>"+"<input type='text'  class='decimal txt_box form-control subt' id='subtotal_mostrar' name='subtotal_mostrar'  value='"+"0.00"+"'readOnly></td>";
        tr_add += '<td class="cell100 column10 Delete text-center"><input id="delprod" type="button" class="btn btn-danger fa"  value="&#xf1f8;"></td>';
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
  totales();
});
$(document).on('select2:close', '.sel_r', function() {

  if ($('#b').attr('hidden')) {
    $('#codigo').focus();
  } else {
    $('#producto_buscar').focus();
  }
});
$(document).on('select2:close', '.sel', function(event) {
  var tr = $(this).parents("tr");
  var cantid = tr.find("#cant").val();
  var id_presentacion = $(this).val();
  var a = $(this);
  //console.log(id_presentacion);
  $.ajax({
    url: 'agregar_pedido.php',
    type: 'POST',
    dataType: 'json',
    data: 'process=getpresentacion'+"&id_presentacion="+id_presentacion+"&cant="+cantid,
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
      var tr = a.closest('tr');
      totales();
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
  totales();
});

// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", ".Delete", function() {
  $(this).parents("tr").remove();
  totales();
});
$(document).on("click", ".Delete_bd", function() {
  var tr = $(this).parents("tr");
  id_detalle = tr.attr("id_detalle");
  $.ajax({
    type:'POST',
    url:'editar_pedido.php',
    data:'process=del&id_detalle='+id_detalle,
    dataType:'JSON',
    success: function(datax)
    {
      if(datax.typeinfo == "Success")
      {
        tr.remove();
      }
    }
  });
  totales();
});
$(document).on("keyup", "#cant, #precio_venta", function() {
  fila = $(this).closest('tr');
  id_producto = fila.find('.id_pps').text();
  var tr = $(this).parents("tr");
	id_presentacion_p = tr.find('.sel').val();
  a_cant=$(this).val();
  unidad= parseInt(fila.find('#unidades').val());
  a_cant=parseFloat(a_cant*unidad);
	a_cant=round(a_cant, 4);
	//Ranking de precios
	$.ajax({
			type:'POST',
			url:'agregar_pedido.php',
			data:'process=cons_rank&id_producto='+id_producto+'&id_presentacion='+id_presentacion_p+'&cantidad='+a_cant,
			dataType:'JSON',
			success:function(datax)
			{
				tr.find(".rank_s").html(datax.precios);
				tr.find("#precio_venta").val(datax.precio);
			}
	});
	setTimeout(function(){ totales(); }, 300);
});

function totales()
{
  var subtotal = 0;
  var total = 0;
  var totalcantidad = 0;
  var subcantidad = 0;
  var total_dinero = 0;
  var total_cantidad = 0;
  $("#inventable tr").each(function()
  {
    var tr = $(this);
    var unidad = $(this).find(".unidad").val();
    var venta = parseFloat($(this).find(".sel_r").val());
    var cantidad = parseFloat($(this).find(".cant").val());
    var cantidad =round(cantidad,4);
    subtotal = venta * cantidad;
    if (isNaN(cantidad) == true)
    {
      cantidad = 0;
    }
    totalcantidad += cantidad;
    if (isNaN(subtotal) == true)
    {
      subtotal = 0;
    }
    tr.find(".subt").val(round(subtotal,4).toFixed(4));
    total += subtotal;
  });
  if (isNaN(total) == true)
  {
    total = 0;
  }
  total_dinero = round(total,4);
  total_cantidad = round(totalcantidad,4);

  $('#total_gravado').html("<strong>"+total_dinero.toFixed(4)+"</strong>");
  $('#totcant').html(total_cantidad);

}
// actualize table
$(document).on("click", "#submit1", function()
{
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
//cantidad restar en td stock
//datos de clientes
function datos_clientes() {
  var id_cliente = $("select#id_cliente option:selected").val();
  var urlprocess = $('#urlprocess').val();
  dataString = {
    process: "datos_clientes",
    id_cliente: id_cliente
  };
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      porc_percepcion = datax.percepcion;
      porc_retencion1 = datax.retencion1;
      porc_retencion10 = datax.retencion10;
      porcentaje_descuento = datax.porcentaje_descuento;
      $("#porc_retencion1").val(porc_retencion1);
      $("#porc_retencion10").val(porc_retencion10);
      $("#porc_percepcion").val(porc_percepcion);
      $("#porcentaje_descuento").val(porcentaje_descuento);
      totales();
    }
  });
}
//Calcular Totales del grid

function senddata() {
  //Obtener los valores a guardar de cada item facturado
  var procces = $("#process").val();
  var i = 0;
  var StringDatos = "";
  var id = '1';
  var id_empleado = 0;
  var id_cliente = $("#id_cliente option:selected").val();
  var items = $("#items").val();
  var msg = "";
  //IMPUESTOS
  var total_retencion = $('#total_retencion').text();
  var total_percepcion = $('#total_percepcion').text();
  var total_iva = $('#total_iva').text();
  var id_vendedor = $("#vendedor option:selected").val();

  var vigencia = $('#vigencia').val();
  var total_venta = $('#total_gravado').text();
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
      var id = $(this).find(".id_pps").text();
      var id_presentacion = $(this).find('.sel').val();
      var precio_venta = $(this).find(".sel_r").val();
      var cantidad = $(this).find("#cant").val();
      var unidades = $(this).find("#unidades").val()
      var subtotal = $(this).find(".subt").val()

      if (cantidad && precio_venta) {
        var obj = new Object();
        obj.id_detalle = '';
        obj.id = id;
        obj.precio = precio_venta;
        obj.cantidad = cantidad;
        obj.unidades = unidades;
        obj.subtotal = subtotal;
        obj.id_presentacion = id_presentacion;
        //convert object to json string
        text = JSON.stringify(obj);
        array_json.push(text);
        i = i+1;
      }
  });
  json_arr = '['+array_json+']';
  if(procces == "insert")
  {
    var urlprocess = "agregar_pedido.php";
    var id_cotizacion = "";
  }
  else
  {
    var urlprocess = "editar_pedido.php";
    var id_cotizacion = $("#id_cotizacion").val();
  }
  var dataString = 'process=insert'+'&cuantos='+i+'&fecha_movimiento='+fecha_movimiento;
  dataString += '&id_cliente='+id_cliente+'&total_venta='+total_venta;
  dataString += '&id_vendedor='+id_vendedor+'&json_arr='+json_arr;
  dataString += '&total_retencion='+total_retencion;
  dataString += '&total_percepcion='+total_percepcion;
  dataString += '&total_iva='+total_iva;
  dataString += '&items='+items;
  dataString += '&id_cotizacion='+id_cotizacion;
  dataString += '&vigencia='+vigencia;

  var sel_vendedor = 1;
  if (id_vendedor == "") {
    msg = 'Seleccione un Vendedor!';
    sel_vendedor = 1;
  }
  if (id_cliente == "") {
    msg = 'Seleccione un Proveedor!';
    sel_vendedor = 0;
  }
  if (vigencia == "") {
    msg = 'Ingrese la fecha de entrega del pedido!';
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
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success") {
          setInterval("reload1();", 1000);
        }
        else {
          $("#submit1").attr("disabled", false);
        }
      }
    });
  } else {
    display_notify('Warning', msg);
    $("#submit1").attr("disabled", false);
  }
}

function remover_filas()
{
  $("#inventable tr").remove();
}

function reload1() {
  location.href = "admin_pedido.php";
}
$(document).on("click", "#btnAddClient", function(event) {
  agregarcliente();
});

function agregarcliente() {
  urlprocess = $('#urlprocess').val();
  var nombress = $(".modal-body #nombress").val();
  var apellidos = $(".modal-body #apellidos").val();
  var duii = $(".modal-body #duii").val();
  var tel1 = $(".modal-body #tel1").val();
  var tel2 = $(".modal-body #tel2").val();
  var dataString = 'process=agregar_cliente'+'&nombress='+nombress+'&apellidos='+apellidos;
  dataString += '&dui='+duii+'&tel1='+tel1+'&tel2='+tel2;
  $.ajax({
    type: "POST",
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      var process = datax.process;
      var id_client = datax.id_client;
      // Agragar datos a select2
      //var nombreape = nombress+" "+apellidoss;
      $("#id_cliente").append("<option value='"+id_client+"' selected>"+nombress+" "+apellidos+"</option>");
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

function generar() {
  fechai = $("#fini").val();
  fechaf = $("#fin").val();
  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    "pageLength": 50,
    "order": [
      [1, 'desc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_pedido_dt.php?fechai="+fechai+"&fechaf="+fechaf, // json datasource
      error: function() { // error handling
        $(".editable2-error").html("");
        $("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="9">No se encontró información segun busqueda </th></tr></tbody>');
        $("#editable2_processing").css("display", "none");
        $(".editable2-error").remove();
      }
    },
    "language": {
      "url": "js/Spanish.json"
    },
  });
  dataTable.ajax.reload();

}
function deleted()
{
  var id_pedido = $('#id_pedido').val();
  var dataString = 'process=deleted'+'&id_pedido='+id_pedido;
  $.ajax({
    type: "POST",
    url: "anular_pedido.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo != "Error")
      {
        setInterval("location.reload();", 1000);
        $('#btncerr').click();
      }
    }
  });
}
function procesar()
{
  var id_pedido = $('#id_pedido').val();
  var dataString = 'process=deleted'+'&id_pedido='+id_pedido;
  $.ajax({
    type: "POST",
    url: "procesar_pedido.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo != "Error")
      {
        setInterval("location.reload();", 1000);
        $('#btncerr').click();
      }
    }
  });
}
