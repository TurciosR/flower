var dataTable = "";
$(document).ready(function() {
  // Clean the modal form
  $(".select").select2({
    placeholder: {
      id: '',
      text: 'Seleccione',
    },
    allowClear: true,
  });
  generar();
});

function generar() {
  fechai = $("#fin").val();
  fechaf = $("#fini").val();

  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    "pageLength": 50,
    "order": [
      [0, 'desc'],
      [1, 'asc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_voucher_dt.php?fechai=" + fechai + "&fechaf=" + fechaf, // json datasource
      //url :"admin_factura_rangos_dt.php", // json datasource
      //type: "post",  // method  , by default get
      error: function() { // error handling
        $(".editable2-error").html("");
        $("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="10">No se encontró información segun busqueda </th></tr></tbody>');
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
$(document).on("click", "#btnMostrar", function(event) {
  generar();
});


function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}


function reload1(id) {
  location.href = 'admin_mov_cta_banco.php?id_cuenta=' + id;
}

function deleted() {
  var id_movimiento = $("#id_movimiento").val();
  $.ajax({
    type: "POST",
    url: "borrar_mov_cta_banco.php",
    data: 'process=deleted&id_movimiento=' + id_movimiento,
    dataType: 'JSON',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo == "Success") {
        setInterval("location.reload();", 1000);
        $("#clos").click();
      }
    }
  });
}
$(document).on('keyup', '#valCheque', function(event) {
  var monto = parseFloat($('#monto').val());
  monto = round(monto, 2);
  var sumaAbonos = 0;
  var abono = 0;
  var valor = $(this).val();
  if (isNaN(valor)) {
    valor = 0;
  }

  $('#tabla tr').each(function(index) {
    if (index > 0) {

      abono = $(this).find('#valCheque').val();
      console.log(abono);

      if (abono != undefined && abono != '') {
        sumaAbonos = parseFloat(sumaAbonos) + parseFloat(abono);
      }
    }

  });

  sumaAbonos = round(sumaAbonos, 2);

  if (sumaAbonos > monto) {
    valor = (monto - (sumaAbonos - valor));
    valor = round(valor, 2)
    $(this).val(valor)
  }
  verificar();


});
function verificar() {
  var monto = parseFloat($('#monto').val());
  monto = round(monto, 2);
  var sumaAbonos = 0;
  var abono = 0;

  $('#tabla tr').each(function(index) {
    if (index > 0) {

      abono = $(this).find('#valCheque').val();
      if (abono != undefined && abono != '') {
        sumaAbonos = parseFloat(sumaAbonos) + parseFloat(abono);
      }
    }

  });

  sumaAbonos = round(sumaAbonos, 2);

  console.log(sumaAbonos);
  console.log(monto);
  if (sumaAbonos == monto) {
    $('#btnFin').prop('disabled', false);
  } else {
    $('#btnFin').prop('disabled', true);
  }
}

$(document).on('click', '#btnFin', function(event) {
  var array_json = new Array();
  var cheque = 0;
  var monto = 0;
	var error = false;
	var msg = "";
  var id_voucher = $('#id_voucher').val();
  var forma = $('#forma').val();
	if(forma == "Cheque")
	{
	  $('#tabla tr').each(function(index) {
	    if (index > 0)
			{
	      monto = $(this).find('#valCheque').val();
	      cheque = $(this).find('#numCheque').val();
	      var obj = new Object();
	      obj.cheque = cheque;
	      obj.monto = monto;
	      //convert object to json string
	      text = JSON.stringify(obj);
	      array_json.push(text);
	    }
	  });
	  json_arr = '[' + array_json + ']';
	  dataString = "process=" + 'finalizar' + "&array_json=" + json_arr + "&id_voucher=" + id_voucher + "&forma="+forma;
	}
	else if(forma == "Transferencia")
	{
		var nt = $('#nt').val();
		if(nt != "")
		{
	  	dataString = "process=" + 'finalizar' + "&nt=" + nt + "&id_voucher=" + id_voucher + "&forma="+forma;
		}
		else
		{
			msg = "Por favor ingrese el numero de Transferencia";
			error = true;
		}
	}
	else
	{
	  dataString = "process=" + 'finalizar' + "&id_voucher=" + id_voucher + "&forma="+forma;
	}
	if(!error)
	{
	  $.ajax({
	    type: 'POST',
	    url: 'finalizar_mov_cta_banco.php',
	    data: dataString,
	    dataType: 'json',
	    success: function(datax) {
	      display_notify(datax.typeinfo, datax.msg);
	      if (datax.typeinfo == "Success") {
	        setInterval("location.reload();", 1000);
	      }
	    }
	  });
	}
	else {
		display_notify("Error", msg);
	}
});
$(document).on('click', '#cns', function(event) {
  var cant = 0;
  $(this).prop('disabled', true);
  $('#cn').prop('readonly', true);
  var cant = parseInt($('#cn').val());
  var a = '';
  if (!isNaN(cant)) {
    var a = "<tr><td> <input class='form-control' type='text' id='numCheque' name='numCheque' value=''> </td><td> <input class='decimal form-control' type='text' id='valCheque' name='valCheque' value=''> </td></tr>";
    for (var i = 0; i < cant; i++) {
      $('#tabla').append(a);
    }
    $('.decimal').numeric({
      negative: false,
      decimalPlaces: 2
    })
  }
});
