var dataTable = "";
$(document).ready(function()
{
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
  id_cuenta = $("#cuenta").val();
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
      url: "admin_mov_cta_banco_dt.php?fechai=" + fechai + "&fechaf=" + fechaf + "&id_cuenta=" + id_cuenta, // json datasource
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
      "url": "js/funciones/Spanish.json"
    },
  });
  dataTable.ajax.reload();

}
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  $(document).on("click", "#print1", function(event) {
    var fechai = $("#fin").val();
    var fechaf = $("#fini").val();
    var id_cuenta = $("#cuenta").val();
    if (id_cuenta > 0) {
      window.open("libro_banco.php?id_cuenta=" + id_cuenta + "&fini=" + fechai + "&fin=" + fechaf, "_blank", "", "");
    } else {
      display_notify("Warning", "Primero seleccione una cuenta");
    }
  });
  $(document).on("click", "#btnMov", function(event) {
    var id_cuenta = $("#cuenta").val();
    if (id_cuenta > 0) {
      $("#movie").attr("href", "agregar_mov_cta_banco.php?id_cuenta=" + id_cuenta);
      $("#movie").click();
    } else {
      display_notify("Warning", "Primero seleccione una cuenta");
    }
  });
  $(document).on("click", "#submit1", function(event) {
    if ($("#tipo").val() != "") {
      if ($("#fecha").val() != "") {
        if ($("#alias_tipodoc").val() != "") {
          if ($("#numero_doc").val() != "") {
            if ($("#concepto").val() != "") {
              if ($("#responsable").val() != "") {
                if ($("#monto").val() != "") {
                  send();
                } else {
                  display_notify("Error", "Por favor ingrese el monto del movimiento");
                }
              } else {
                display_notify("Error", "Por favor ingrese el nombre del responsable");
              }
            } else {
              display_notify("Error", "Por favor ingrese el concepto del movimiento");
            }
          } else {
            display_notify("Error", "Por favor ingrese el numero de documento");
          }
        } else {
          display_notify("Error", "Por favor seleccione el tipo de documento");
        }
      } else {
        display_notify("Error", "Por favor seleccione la fecha del movimiento");
      }
    } else {
      display_notify("Error", "Por favor seleccione el tipo de movimiento");
    }
  });
  $(document).on("change", "#banco", function(event) {
    var id_banco = $(this).val();
    $("#cuenta").val("");
    $("#cuenta").empty().trigger('change');
    $.ajax({
      type: "POST",
      url: "admin_mov_cta_banco.php",
      data: "process=val&id_banco=" + id_banco,
      dataType: "JSON",
      success: function(datax) {
        if (datax.typeinfo == "Success") {
          $("#cuenta").html(datax.opt);
        }
      }
    });

  });
  $(document).on("change", "#cuenta", function(event) {
    generar();
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

function send() {
  var id_cuenta = $('#cuenta').val();
  var tipo = $('#tipo').val();
  var fecha = $('#fecha').val();
  var alias_tipodoc = $('#alias_tipodoc').val();
  var numero_doc = $('#numero_doc').val();
  var concepto = $('#concepto').val();
  var responsable = $('#responsable').val();
  var monto = $('#monto').val();
  var process = $("#process").val();
  if (process == "insert") {
    var urlprocess = "agregar_mov_cta_banco.php";
    var id_movimiento = "";
  } else {
    var urlprocess = "editar_mov_cta_banco.php";
    var id_movimiento = $("#id_movimiento").val();
  }
  var dataString = 'process=' + process + '&id_movimiento=' + id_movimiento + '&id_cuenta=' + id_cuenta + "&tipo=" + tipo + "&fecha=" + fecha + "&alias_tipodoc=" + alias_tipodoc + "&numero_doc=" + numero_doc + "&concepto=" + concepto + "&responsable=" + responsable + "&monto=" + monto;
  $.ajax({
    type: "POST",
    url: urlprocess,
    data: dataString,
    dataType: 'JSON',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo == "Success") {
        setInterval("reload1(" + datax.id_cuenta + ");", 1000);
        $("#clos").click();
      }
    }
  });
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
