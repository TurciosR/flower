$(document).ready(function() {

$('.int').numeric({negative:false,decimal:false});

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
  $(document).on('keyup', '#cant', function(event) {
    var valor = parseInt($(this).val());
    if(isNaN(valor))
    {
      valor=0;
    }
    var suma=0;
    var devant=0;
    var cantvend=0;
    var precio_venta=0;
    var subtotal=0;

    precio_venta = parseFloat($(this).closest('tr').find('td:eq(4)').text());
    cantvend = parseInt($(this).closest('tr').find('td:eq(5)').text());
    devant = parseInt($(this).closest('tr').find('td:eq(6)').text());
    if(isNaN(devant))
    {
      devant=0;
    }
    console.log(precio_venta);
    console.log(cantvend);

    suma=devant+valor;


    if(suma>cantvend)
    {
      valor = cantvend-(suma-valor);
      $(this).val(valor);
      subtotal=valor*precio_venta;
      subtotal=round(subtotal, 2);
      $(this).closest('tr').find('#subtotal').val(subtotal);
    }
    else
    {
      subtotal=valor*precio_venta;
      subtotal=round(subtotal, 2);
      $(this).closest('tr').find('#subtotal').val(subtotal);
    }

    total();
  });

  $(document).on('click', '#btnGuardar', function(event) {
    var array_json = new Array();

    var suma=0;
    var valor=0;
    var subtotal=0;
    var id_producto=0;
    var montodev=0;
    var totcant=0;
    var unidades=0;
    var precio_venta=0;
    var id_factura=$('#id_factura').val();
    var numero_doc=$('#numero_doc').val();
    var id_cliente=$('#id_cliente').val();
    var apertura=$('#id_apertura').val();
    var caja=$('#caja').val();
    var turno=$('#turno').val();
    var tipo =$('#tipo_doc').val();
    var id_presentacion=0;

    $('#tabla tr').each(function(index) {
      if(index>0)
      {
        valor = parseInt($(this).find('#cant').val());
        subtotal = parseFloat($(this).find('#subtotal').val());
        subtotal = round(subtotal, 2);
        id_producto=$(this).closest('tr').find('td:eq(0)').html();
        unidades = parseInt($(this).closest('tr').find('#unidades').val());
        id_presentacion=$(this).closest('tr').find('#id_presentacion').val();
        id_factura_detalle=$(this).closest('tr').find('#id_factura_detalle').val();

        precio_venta =parseFloat($(this).closest('tr').find('td:eq(4)').html());
        precio_venta=round(precio_venta, 2);

        if(isNaN(valor))
        {
          valor=0;
        }


        if(isNaN(subtotal))
        {
          subtotal=0;
        }
      }

      if(valor>0)
      {
        var obj = new Object();
        obj.id_producto = id_producto;
        obj.cant = valor;
        obj.monto = subtotal;
        obj.unidades = unidades;
        obj.precio_venta = precio_venta;
        obj.id_presentacion = id_presentacion;
        obj.id_factura_detalle = id_factura_detalle;

        //convert object to json string
        text = JSON.stringify(obj);
        array_json.push(text);
      }

    });

    montodev=parseFloat($('#montodev').html());
    montodev=round(montodev, 2);

    totcant=parseInt($('#totcant').html());




    json_arr = '[' + array_json + ']';


    dataString="process="+'devolver'+"&array_json="+json_arr+"&id_factura="+id_factura+"&numero_doc="+numero_doc+"&id_cliente="+id_cliente+"&montodev="+montodev+"&totcant="+totcant+"&tipo="+tipo+"&caja="+caja+"&apertura="+apertura+"&turno="+turno;
    if(totcant>0&&montodev>0)
    {
      $.ajax({
        type: 'POST',
        url: 'devolucion.php',
        data: dataString,
        dataType: 'json',
        success: function(datax) {
          display_notify(datax.typeinfo, datax.msg);
          if (datax.typeinfo == "Success") {
            factura=datax.id_factura;
            numdoc=datax.numdoc;
            var tipo =$('#tipo_doc').val();
            if(tipo=="CCF")
            {
              activa_modal(factura,numdoc);
            }
            else
            {
              setInterval("reload1();", 1500);
            }


          }
        }
      });
    }
    else
    {
      display_notify('Error','Debe efectuar la devolucion de al menos un producto');
    }
  });

});

function activa_modal(factura,numdoc){
	urlprocess=$('#urlprocess').val();
	$('#viewModal').modal({backdrop: 'static',keyboard: false});
    $(".modal-body #id_factura_n").val(factura);
    var dev= $('#montodev').text();
     var cant=$('#totcant').text();
     var totalfinal=parseFloat(dev);
     var tipo_impresion="DEV";
     var facturado= totalfinal.toFixed(2);
      $(".modal-body #facturado").val(dev);
      $(".modal-body #fact_num").html(numdoc);
}

$(document).on("click", "#btnEsc", function(event)
{
  var numero = $(".modal-body #numero").val();
  var id_factura = $(".modal-body #id_factura_n").val();

  if(numero!=""&&numero!=null)
  {
    $.ajax({
      url: 'devolucion.php',
      type: 'POST',
      dataType: 'json',
      data: "process=act"+"&id_factura="+id_factura+"&numero="+numero,
      success: function(datax)
      {
        reload1();
      }
    });
  }
  else
  {
    display_notify('Error','Ingrese numero de documento');
  }



});
$(document).on("click", "#btnPrintFact", function(event)
{
  imprime1();
});

function total()
{
  var suma=0;
  var valor=0;
  var subtotal=0;
  var totcant=0;
  var montodev=0;

  $('#tabla tr').each(function(index) {
    if(index>0)
    {
      valor = parseInt($(this).find('#cant').val());
      subtotal = parseFloat($(this).find('#subtotal').val());

      if(isNaN(valor))
      {
        valor=0;
      }
      totcant=totcant+valor;

      if(isNaN(subtotal))
      {
        subtotal=0;
      }
      montodev=montodev+subtotal;
    }

  });

  montodev=round(montodev, 2)
  $('#montodev').html(montodev);
  $('#totcant').html(totcant);
}
function senddata() {
  var nombre = $('#nombre').val();
  var direccion = $('#direccion').val();
  var casa = $('#casa:checked').val();


  //Get the value from form if edit or insert
  var process = $('#process').val();

  if (process == 'insert') {
        var id_sucursal = 0;
    var urlprocess = 'agregar_sucursal.php';
  }
  if (process == 'edited') {
    var id_sucursal = $('#id_sucursal').val();;
    var urlprocess = 'editar_sucursal.php';
  }

  var dataString = 'process=' + process + '&id_sucursal=' + id_sucursal + '&nombre=' + nombre + '&direccion=' + direccion + '&casa=' + casa;
  //alert(dataString);
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      process = datax.process;
      display_notify(datax.typeinfo, datax.msg);
      setInterval("reload1();", 5000);

    }
  });
}

function reload1() {
  location.href = 'admin_factura_rangos.php';
}

function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

function deleted() {
  var id_sucursal = $('#id_sucursal').val();
  var dataString = 'process=deleted' + '&id_sucursal=' + id_sucursal;
  $.ajax({
    type: "POST",
    url: "borrar_sucursal.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      setInterval("location.reload();", 3000);
      $('#deleteModal').hide();
    }
  });
}

function imprime1(){
  var numero_doc = $(".modal-body #fact_num").html();
  var print = 'imprimir_fact';
  var pass = true;
  var numero_factura_imprimir=$(".modal-body #numero").val();
  var tipo_impresion = 'DEV';
  var id_factura=$(".modal-body #id_factura_n").val();

	var dataString = 'process=' + print + '&numero_doc=' + numero_doc + '&num_doc_fact=' + id_factura;
  if(numero_factura_imprimir==""){
    pass = false;
  }
  dataString +='&numero_factura_imprimir='+numero_factura_imprimir
  if(pass){
    $.ajax({
      type: 'POST',
      url: urlprocess,
      data: dataString,
      dataType: 'json',
      success: function(datos) {
			     var sist_ope = datos.sist_ope;
           var dir_print=datos.dir_print;
           var shared_printer_win=datos.shared_printer_win;
			     var shared_printer_pos=datos.shared_printer_pos;
          var efectivo_fin = parseFloat($('#efectivo').val());
          var cambio_fin = parseFloat($('#cambio').val());
          if (tipo_impresion == 'DEV') {
            if (sist_ope == 'win') {
              $.post("http://"+dir_print+"printncrwin1.php", {
                datosventa: datos.facturar,
                efectivo: efectivo_fin,
                cambio: cambio_fin,
                shared_printer_win:shared_printer_win
              })
            } else {
              $.post("http://"+dir_print+"printncr1.php", {
                datosventa: datos.facturar,
                efectivo: efectivo_fin,
                cambio: cambio_fin
              });
            }
          }
        }
	  });
  }
  else{
      display_notify("Error", "Por favor complete los datos de facturacion");
  }
}
