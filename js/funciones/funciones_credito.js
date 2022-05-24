var dataTable = "";
$(document).ready(function() {
  // Clean the modal form
  $(document).on('hidden.bs.modal', function(e) {
    var target = $(e.target);
    target.removeData('bs.modal').find(".modal-content").html('');
  });
  generar();
});

function generar() {
  fechai = $("#fecha_inicio").val();
  fechaf = $("#fecha_fin").val();
  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    "pageLength": 50,
    "order": [
      [1, 'desc'],
      [0, 'desc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_credito_dt.php?fechai=" + fechai + "&fechaf=" + fechaf, // json datasource
      //url :"admin_factura_rangos_dt.php", // json datasource
      //type: "post",  // method  , by default get
      error: function() { // error handling
        $(".editable2-error").html("");
        $("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="3">No se encontró información segun busqueda </th></tr></tbody>');
        $("#editable2_processing").css("display", "none");
        $(".editable2-error").remove();
      }
    },
    "columnDefs": [{
      "targets": 1, //index of column starting from 0
      "render": function(data, type, full, meta) {
        if (data != null)
          return '<p class="text-success"><strong>' + data + '</strong></p>';
        else
          return '';
      }
    }],
    "language": {
      "url": "js/Spanish.json"
    }
  });
  dataTable.ajax.reload()
  //}
}
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnAnular", function(event) {
    anular();
  });
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  $(document).on("click", "#btnMostrar", function(event) {
    generar();
  });
  $(document).on("click", "#clos", function(event) {
    location.reload();
  });
  $(document).on("click", "#abon", function(event) {
    if ($("#banco").val() != "") {
      if ($("#cuenta").val() != "") {
        if ($("#cheque").val() != "") {
          if ($("#monto").val() != "") {
            send();
          } else {
            display_notify("Error", "Por favor ingrese el monto del cheque");
          }
        } else {
          display_notify("Error", "Por favor ingrese el numero de cheque");
        }
      } else {
        display_notify("Error", "Por favor seleccione una cuenta");
      }
    } else {
      display_notify("Error", "Por favor seleccione un banco");
    }
  });

});

function reload1() {
  location.href = 'admin_creditos.php';
}

function send() {
  var id_factura = $('#id_factura').val();
  var monto = $('#monto').val();
  var tipo_doc = $('#tipo_doc').val();
  var num_doc = $('#num_doc').val();
  $("#monto").val("");

  var dataString = 'process=abonar'+'&id_factura='+id_factura+"&monto="+monto+"&tipo_doc="+tipo_doc+"&num_doc="+num_doc;
  $.ajax({
    type: "POST",
    url: "abono_credito.php",
    data: dataString,
    dataType: 'JSON',
    success: function(datax) {
      //display_notify(datax.typeinfo,datax.msg);
      if (datax.typeinfo == "Success") {
        //setInterval("reload1();", 1000);
        //$("#clos").click();
        var fila = "<tr>";
            fila += "<td>" + datax.fecha + "</td>";
            fila += "<td>" + datax.hora + "</td>";
            fila += "<td>" + tipo_doc + "</td>";
            fila += "<td>" + num_doc + "</td>";
            fila += "<td class='mont'>" + datax.monto + "</td>";
            fila += "<td></td>";
            //fila += "<td><a class='btn delee' id='" + datax.id_abono_credito + "'><i class='fa fa-trash'></i></a></td>";
            fila += "</tr>";
        if ($("#appas tr").length > 0) {
          $("#appas > tr:first").before(fila);
        } else {
          $("#appas").append(fila);
        }
        var tot = parseFloat($("#total").text());
        var deuda = parseFloat($("#deuda").val());
        var abonos = parseFloat($("#abonos").val());
        tot += parseFloat(datax.monto);
        deuda -= parseFloat(datax.monto);
        abonos += parseFloat(datax.monto);
        $("#total").text(round(tot, 2));
        $("#deuda").val(round(deuda, 2));
        $("#abonos").val(round(abonos, 2));
        if (deuda == 0) {
          $("#monto").attr("readonly", true);
          $("#abonar").attr("disabled", true);
        }

      } else {
        $("#abonar").attr("disabled", false);
      }
    }
  });
}

function anular() {
  var id_traslado = $('#id_traslado').val();
  var dataString = 'process=anular' + '&id_traslado=' + id_traslado;
  $.ajax({
    type: "POST",
    url: "anular_traslado.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      setInterval("location.reload();", 3000);
      $('#deleteModal').hide();
    }
  });
}

function deleted() {
  var id_credito = $('#id_credito').val();
  var dataString = 'process=deleted' + '&id_credito=' + id_credito;
  $.ajax({
    type: "POST",
    url: "borrar_credito.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if(datax.typeinfo == "Success")
      {
        setInterval("location.reload();", 1000);
        $('#btnSal').click();
      }
    }
  });
}

$(document).on('keyup', '#monto', function(event) {
  if (event.keyCode == 13) {
    $("#abonar").click();
  }
  $("#abonar").attr("disabled", false);
  var monto = round(parseFloat($(this).val()), 2);
  var deuda = round(parseFloat($('#deuda').val()), 2);
  if (monto > deuda) {
    $(this).val(deuda);
  }
});
$(document).on('click', '#abonar', function(event) {
  $("#abonar").attr("disabled", true);
  var id_factura = $('#id_factura').val();
  var monto = $('#monto').val();
  var val1 = 0;
  if (monto != undefined && monto != 0 && monto != '') {
    send();
  } else {
    display_notify('Error', 'No ha ingresado un monto para abonar');
    val1 = 1;
  }

});
$(document).on('click', '.delee', function(event) {
  var id_factura = $('#id_factura').val();
  var id_abono = $(this).attr("id");
  var fila = $(this).parents("tr");
  var monto = parseFloat(fila.find(".mont").text());

  var dataString = 'process=quitar' + '&id_abono=' + id_abono + '&id_factura=' + id_factura + '&monto=' + monto;

  $.ajax({
    type: "POST",
    url: "abono_credito.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      if (datax.typeinfo == "Success") {
        fila.remove();
        var tot = parseFloat($("#total").text());
        var deuda = parseFloat($("#deuda").val());
        var abonos = parseFloat($("#abonos").val());
        tot -= monto;
        deuda += monto;
        abonos -= monto;
        $("#deuda").val(round(deuda, 2));
        $("#abonos").val(round(abonos, 2));
        $("#total").text(round(tot, 2));
        if (deuda > 0) {
          $("#monto").attr("readonly", false);
        }
      }
      //display_notify(datax.typeinfo, datax.msg);
    }
  });


});

function round(value, decimals) {
  return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}
