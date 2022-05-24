$(document).ready(function() {
  $('.select2').select2({
    placeholder: {
      id: '-1',
      text: 'Seleccione'
    },
     disabled: true,
    allowClear: true
  });
  $('.select').select2({
    placeholder: {
      id: '', // the value of the option
      text: 'Seleccione'
    },
     disabled: true,
    allowClear: true
  });



  $('.demo2').bootstrapDualListbox({
    nonSelectedListLabel: 'Pendientes de pago',
    selectedListLabel: 'A pagar',
    preserveSelectionOnMove: 'moved',
    moveOnSelect: true,
    filterTextClear: '<span class="fa fa-eye">Mostrar todo</span>',
    filterPlaceHolder: 'Filtro',
    infoText: 'Mostrando todo {0}',
    moveSelectedLabel: 'Mover seleccionado',
    moveAllLabel: 'Mover todo',
    removeSelectedLabel: 'Remover Seleccionado',
    removeAllLabel: 'Remover todo',
    infoTextEmpty: 'Lista vacia',
    infoTextFiltered: '<span class="label label-warning">Filtrando</span>  {0} de {1} facturas',
  });

  $('.bootstrap-duallistbox-container').prop('hidden', true);

  $("#select_proveedor").change(function(event) {

    cambio_proveedor();

  });
total_a_pagar();

});
$(function() {

  var dualListContainer = $('select[name="duallistbox_demo2"]').bootstrapDualListbox('getContainer');
  dualListContainer.find('.moveall i').removeClass().addClass('fa fa-arrow-right');
  dualListContainer.find('.moveall').removeClass('btn-default').addClass('btn-success');
  dualListContainer.find('.removeall i').removeClass().addClass('fa fa-arrow-left');
  dualListContainer.find('.removeall').removeClass('btn-default').addClass('btn-success');
  /*dualListContainer.find('.move i').removeClass().addClass('fa fa-arrow-right');
  dualListContainer.find('.move').removeClass('btn-default').addClass('btn-info');
  dualListContainer.find('.remove i').removeClass().addClass('fa fa-arrow-left');
  dualListContainer.find('.remove').removeClass('btn-default').addClass('btn-info');*/
    //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  $(document).on("click", "#submit1", function(event) {
    facturas =$('[name="duallistbox_demo2"]').val();
    id_proveedor=$('#select_proveedor').val();
    id_banco=$('#banco').val();
    id_cuenta=$('#cuenta').val();
    forma = $('#forma').val();
    saldo_cuenta=parseFloat($('#saldo').val());
    total_a_p=parseFloat($('#total_a_pagar').html());
    saldo_cuenta=round(saldo_cuenta,2);
    total_a_p=round(total_a_p, 2);

    var val1 = 0;
    var val2 = 0;
    var val3 = 0;
    var val4 = 0;
    var val5 = 0;
    if($("#process").val()!="inser2")
    {
      if (facturas != null) {
        var arrayFacturas = facturas;
        for (var i = 0; i < arrayFacturas.length; i++) {
          if (array[i] == -1) {
            val2 = 1;
          }
        }
      } else {
        val2 = 1;
      }
      if (id_proveedor != "" && parseInt(id_proveedor) > 0) {
        if (forma != '') {
          if (forma != 'Efectivo') {
            if (id_banco != '') {
              if (id_cuenta != '') {
                if (saldo_cuenta >= total_a_p) {
                  if (val2 == 0) {
                    senddata();
                  } else {
                    display_notify('Error', 'Por favor agregue al menos una factura');
                  }
                } else {
                  display_notify('Error', 'La cuenta no cuenta con fondos suficientes');
                }
              } else {
                display_notify('Error', 'Seleccione una cuenta');
              }
            } else {
              display_notify('Error', 'Seleccione un banco');
            }
          }
          else
          {
            if (val2 == 0) {
              senddata();
            } else {
              display_notify('Error', 'Por favor agregue al menos una factura');
            }
          }
        } else {
          display_notify("Error", "Seleccione la forma de pago");
        }
      } else {
        display_notify('Error', 'Por favor seleccione el proveedor');
      }
    }
    else
    {
      senddata();
    }
  });
  $(document).on("change", "#banco", function(event) {

    $('#cuenta').empty().trigger('change');
    $('#saldo').val('');
    $('#fecha').val('');
    $('#cheque').val('');
    $('#monto').val('');
    $('#monto').prop('disabled', true);
    $('#cheque').prop('disabled', true);
    $('#agregar').prop('disabled', true);
    $('#fecha').prop('disabled', true);

    var id_banco = $(this).val();
    if (id_banco > 0) {
      $.ajax({
        type: "POST",
        url: "pago_proveedor.php",
        data: "process=val&id_banco=" + id_banco,
        dataType: "JSON",
        success: function(datax) {
          if (datax.typeinfo == "Success") {
            $("#cuenta").html(datax.opt);
          }
        }
      });
    }
  });
  $(document).on("change", "#cuenta", function(event) {

    $('#saldo').val('');
    var id_cuenta = $(this).val();
    if (id_cuenta > 0) {
      $.ajax({
        type: "POST",
        url: "pago_proveedor.php",
        data: "process=saldo&id_cuenta=" + id_cuenta,
        dataType: "JSON",
        success: function(datax) {
          if (datax.typeinfo == "Success") {
            var saldo = parseFloat(datax.saldo);

            $('#saldo').val(saldo);


          }
        }
      });
    }
  });
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });
  $('[name="duallistbox_demo2"]').change(function() {
    /* Act on the event */
    agregar_Factura($(this).val());
    setTimeout(function(){ total_a_pagar(); }, 1000);

  });

  $(document).on('click', '.lndelete', function(e) {
    var id_cuenta_pagar = $(this).closest('tr').attr('class');
    $(this).closest('tr').remove();
    calcSald(id_cuenta_pagar);
  });
  $(document).on('click', '.alldelete', function(e) {
    var id = $(this).closest('tr').attr('class');

    $('#tabla tr').each(function(index) {
      if (index > 0) {
        var con = 0;
              if($(this).attr('class')==id)
              {
                $(this).remove();
              }
      }
    });
  });


  $('html').click(function() {
    /* Aqui se esconden los menus que esten visibles*/
    var number=$('#value').val();
    var a = $('#value').closest('td');

    var id_cuenta_pagar=a.closest('tr').attr('class');
    a.html(number);
    if(a.hasClass('nm'))
    {
      console.log('tc');
      if(isNaN(number))
      {
      }
      else
      {

        number = number/100;
        number = round(number, 4);
        if(number!=0)
        {
          var monto_inicial = parseFloat(a.closest('tr').attr('saldo_pend'));
          monto_inicial = round(monto_inicial, 2);
          var descuento = number*monto_inicial;
          descuento=round(descuento, 2)

          a.closest('tr').find('.descuento').html(descuento);

        }
        else
        {
          a.closest('tr').find('.descuento').html('');
          a.closest('tr').find('.porcentaje').html('');
        }

      }
      calcSald(id_cuenta_pagar)
    }
    else
    {

      if(a.hasClass('ed'))
      {
        calcSald(id_cuenta_pagar)
      }
    }

  });

  $(document).on('click', 'td', function(e) {
    if($(this).hasClass('ed'))
    {
      var av=$(this).html();
      $(this).html('');
      $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
      $('#value').val(av);
      $('#value').focus();
      $('#value').numeric({negative:false,decimalPlaces:2});
      e.stopPropagation();
    }
    if($(this).hasClass('nm'))
    {
      var av=$(this).html();
      $(this).html('');
      $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
      $('#value').val(av);
      $('#value').focus();
      $('#value').numeric({negative:false,decimal: false});
      e.stopPropagation();
    }
    if($(this).hasClass('tex'))
    {
      var av=$(this).text();
      $(this).html('');
      $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
      $('#value').val(av);
      $('#value').focus();
      e.stopPropagation();
    }
    if($(this).hasClass('ddate'))
    {
      var av=$(this).html();
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

    if(event.key=='Enter')
    {
      $('html').click();
    }
  });

  $(document).on('keypress', '.in', function(event) {
      console.log(event.key);

      if(event.key=='Tab')
      {
        var a= $(this).parents('tr');

        var id_cuenta_pagar=a.attr('class');
        var cargo = a.find('.cargo').html();
        var saldo = a.find('.saldo').html();
        var app = "<tr saldo_pend='" + cargo + "' class='" + id_cuenta_pagar + "' style='height:35px;'> <td class='fecha ddate'></td> <td class='numero tex' numero=''></td> <td class='cargo'>" + saldo + "</td> <td class='porcentaje nm'></td> <td class='descuento'></td> <td class='devolucion ed'></td> <td class='bonificacion ed'></td> <td class='retencion ed'></td> <td class='vin ed'></td> <td class='saldo " + id_cuenta_pagar + "'>" + saldo + "</td> <td class='text-center'><a class=' lndelete' type='button' name='button'> <span class='fa fa-trash'></span> </a></td></tr>";
        a.after(app);
          $('html').click();
      }
  });

});

function calcSald(id_cuenta_pagar) {
  var id = id_cuenta_pagar
  var con=1;
  var sum=0;
  var saldo=0;
  $('#tabla tr ').each(function(index) {
    if (index > 0) {
            if($(this).attr('class')==id)
            {
              sum=0;
              if(con==1)
              {
                monto_inicial = parseFloat($(this).find('.cargo').html());
                monto_inicial = round(monto_inicial, 2);
                saldo=monto_inicial;

                for (var i = 4; i < 9; i++) {
                  a=parseFloat($(this).find('td:eq('+i+')').html());
                  if(isNaN(a))
                  {
                  }
                  else
                  {
                    sum=sum+a;
                    sum=round(sum, 2);
                  }

                }
                saldo=saldo-sum;
                console.log(saldo);
                saldo=round(saldo,2)
                $(this).find('.saldo').html(saldo);

                console.log(con);
                con=con+1;
              }
              else
              {
                $(this).find('.cargo').html(saldo);
                for (var i = 4; i < 9; i++) {
                  a=parseFloat($(this).find('td:eq('+i+')').html());
                  if(isNaN(a))
                  {
                  }
                  else
                  {
                    sum=sum+a;
                    sum=round(sum, 2);
                  }

                }
                saldo=saldo-sum;
                console.log(saldo);
                saldo=round(saldo,2)
                $(this).find('.saldo').html(saldo);
                console.log(con);
                con=con+1;
              }
            }
    }
  });
  total_a_pagar();
}

function total_a_pagar() {

id_cuenta_pagar= $('[name="duallistbox_demo2"]').val();
console.log(id_cuenta_pagar);
array=id_cuenta_pagar;
total =0;

if(array==null)
{
  $('#total_a_pagar').html(0);
}
else{

  for (var i = 0; i < array.length; i++) {
      var id = array[i];
      var saldo=0;
      $('#tabla tr ').each(function(index) {
        if (index > 0) {
          if($(this).attr('class')==id)
          {
            saldo=parseFloat($(this).find('.saldo').html());
          }
        }
      });
      console.log(saldo);
      total=total+saldo;

    }
    total=round(total,2);
    console.log(total);
    $('#total_a_pagar').html(total);
  }
}

function agregar_Factura(values) {
  if (values != null) {
    var arrayFacturas = values;
    for (var i = 0; i < arrayFacturas.length; i++) {
      var contador = 0;
      $('#tabla tr').each(function(index) {
        if ($(this).find("#fact_id_cuenta_pagar").val() == arrayFacturas[i]) {
          contador++;
        }

      });
      if (contador == 0) {
        dataString = 'process=addFactura' + '&id_cuenta_pagar=' + arrayFacturas[i];
        $.ajax({
          url: 'pago_proveedor.php',
          type: 'POST',
          dataType: 'json',
          data: dataString,
          success: function(datax) {
            $('#tabla').append(datax.fact);
          }

        })
      }
    }

    $('#tabla tr').each(function(index) {
      if (index > 0) {
        var con = 0;
            for (var i = 0; i < values.length; i++) {
              if($(this).attr('class')==values[i])
              {
                con++;
              }
            }
            if(con==0)
            {
              $(this).remove();
            }
      }
    });




  } else {
    console.log("NO values");
		$('#tabla tr').each(function(index) {

			if (index > 0) {
					$(this).remove();
			}
		});
  }
}

function cambio_proveedor() {
  var id = $('#select_proveedor').val();
  $.post("pago_proveedor.php", {
    process: 'genera_select',
    id: id
  }, function(data) {

    $('.demo2').html(data);
    $('.demo2').bootstrapDualListbox('refresh');

    $('#tabla tr').each(function(index) {
      if(index>0)
      {
        $(this).remove();

      }
    });

    setTimeout(function(){ total_a_pagar(); }, 1000);

  });
}


function autosave(val) {
  var name = $('#name').val();
  if (name == '' || name.length == 0) {
    var typeinfo = "Info";
    var msg = "The field name is required";
    display_notify(typeinfo, msg);
    $('#name').focus();
  } else {
    senddata();
  }
}

function senddata() {


  var process = $('#process').val();
  if(process == "inser2")
  {
    var urlprocess = 'editar_voucher.php';
  }
  else
  {
    var urlprocess = 'editar_pago_proveedor.php';
  }

  facturas =$('[name="duallistbox_demo2"]').val();

  id_proveedor=$('#select_proveedor').val();

  id_cuenta=$('#cuenta').val();
  id_movimiento=$('#id_movimiento').val();
  id_voucher=$('#id_voucher').val();

  total_a_p=parseFloat($('#total_a_pagar').html());
  saldo_cuenta=round(saldo_cuenta,2);
  total_a_p=round(total_a_p, 2);

  var array_json = new Array();
  var array_json2 = new Array();

  var arrayFacturas =facturas;

  for (var i = 0; i < arrayFacturas.length; i++) {

    var obj = new Object();
    obj.id_cuenta_pagar = arrayFacturas[i];
    //convert object to json string
    text = JSON.stringify(obj);
    array_json.push(text);
  }

  json_arr = '[' + array_json + ']';

  var fecha;
  var numero;
  var cargo;
  var porcentage;
  var descuento;
  var devolucion;
  var bonificacion;
  var retencion;
  var vin;
  var saldo;
  var id_cuenta_pagar;


  $('#tabla tr ').each(function(index) {
    if (index > 0) {

      fecha=$(this).find('.fecha').html();
      numero=$(this).find('.numero').text();
      cargo=$(this).find('.cargo').html();
      porcentage=$(this).find('.porcentaje').html();
      descuento=$(this).find('.descuento').html();
      devolucion=$(this).find('.devolucion').html();
      bonificacion=$(this).find('.bonificacion').html();
      retencion=$(this).find('.retencion').html();
      vin=$(this).find('.vin').html();
      saldo=$(this).find('.saldo').html();
      id_cuenta_pagar=$(this).attr('class');


      var obj2 = new Object();
      obj2.fecha = fecha;
      obj2.numero = numero;
      obj2.cargo = cargo;
      obj2.porcentage = porcentage;
      obj2.descuento = descuento;
      obj2.devolucion = devolucion;
      obj2.bonificacion = bonificacion;
      obj2.retencion = retencion;
      obj2.vin = vin;
      obj2.saldo = saldo;
      obj2.id_cuenta_pagar=id_cuenta_pagar;
      //convert object to json string
      text = JSON.stringify(obj2);
      array_json2.push(text);
    }
  });

    json_arr2 = '[' + array_json2 + ']';

    dataString="process="+process+"&array_json="+json_arr+"&array_json2="+json_arr2+"&id_cuenta="+id_cuenta+"&total_a_p="+total_a_p+"&id_movimiento="+id_movimiento+"&id_voucher="+id_voucher;

  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo == "Success")
      {
        setInterval("reload1();", 1000);
      }
    }
  });
}

function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

function reload1() {
  location.href = 'admin_voucher.php';
}

function deleted() {
  var id_color = $('#id_color').val();
  var dataString = 'process=deleted' + '&id_color=' + id_color;
  $.ajax({
    type: "POST",
    url: "borrar_color.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo == "Success") {
        setInterval("location.reload();", 1000);
        $('#deleteModal').hide();
      }
    }
  });
}
