$(document).ready(function() {
  $("#percibe").on("ifChecked", function() {
    $("#hi_percibe").val(1);
  });
  $("#percibe").on("ifUnchecked", function() {
    $("#hi_percibe").val(0);
  });
  $("#scxpp").click(function() {
    cxpp();
  });
  $("#sucursal").change(function() {
    cxpp();
  });
  $("#hcxpp").click(function() {
    cxpp();
  });
  $("#scacum").click(function() {
    cacum();
  });
  $("#sucursal1").change(function() {
    cacum();
  });
  $("#hcacum").click(function() {
    cacum();
  });
  $('#formulario').validate({
    rules: {
      nombre_proveedor: {
        required: true,
      },
      departamento: {
        required: true,
      },
      municipio: {
        required: true,
      },
    },
    messages: {
      nombre_proveedor: "Ingrese el nombre",
      departamento: "Seleccione un departamento",
      municipio: "Seleccione un municipio",
    },
    highlight: function(element) {
      $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(form) {
      senddata();
    }
  });
  $("#departamento").change(function() {
    $("#municipio *").remove();
    $("#select2-municipio-container").text("");
    var ajaxdata = {
      "process": "municipio",
      "id_departamento": $("#departamento").val()
    };
    $.ajax({
      url: "agregar_proveedor.php",
      type: "POST",
      data: ajaxdata,
      success: function(opciones) {
        $("#select2-municipio-container").text("Seleccione");
        $("#municipio").html(opciones);
        $("#municipio").val("");
      }
    })
  });
  $('.tel').on('keydown', function(event) {
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

    } else {
      if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
        inputval = $(this).val();
        var string = inputval.replace(/[^0-9]/g, "");
        var bloc1 = string.substring(0, 4);
        var bloc2 = string.substring(4, 7);
        var string = bloc1 + "-" + bloc2;
        $(this).val(string);
      } else {
        event.preventDefault();
      }

    }
  });
  $('#dui').on('keydown', function(event) {
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

    } else {
      if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
        inputval = $(this).val();
        var string = inputval.replace(/[^0-9]/g, "");
        var bloc1 = string.substring(0, 8);
        var bloc2 = string.substring(8, 8);
        var string = bloc1 + "-" + bloc2;
        $(this).val(string);
      } else {
        event.preventDefault();
      }

    }
  });
  $('#nrc').on('keydown', function(event) {
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

    } else {
      if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
        inputval = $(this).val();
        var string = inputval.replace(/[^0-9]/g, "");
        var bloc1 = string.substring(0, 8);
        var bloc2 = string.substring(8, 8);
        var string = bloc1 + "-" + bloc2;
        $(this).val(string);
      } else {
        event.preventDefault();
      }

    }
  });
  $('#nit').on('keydown', function(event) {
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

    } else {
      if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
        inputval = $(this).val();
        var string = inputval.replace(/[^0-9]/g, "");
        var bloc1 = string.substring(0, 4);
        var bloc2 = string.substring(4, 10);
        var bloc3 = string.substring(10, 13);
        var bloc4 = string.substring(13, 13);
        var string = bloc1 + "-" + bloc2 + "-" + bloc3 + "-" + bloc4;
        $(this).val(string);
      } else {
        event.preventDefault();
      }

    }
  });
  $('.select').select2();
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

function senddata() {

  var dataString = $("#formulario").serialize();

  var process = $('#process').val();

  if (process == 'insert') {
    var urlprocess = 'agregar_proveedor.php';
  }
  if (process == 'edited') {
    var urlprocess = 'editar_proveedor.php';
  }
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

function reload1() {
  location.href = 'admin_proveedor.php';
}

function deleted() {
  var id_proveedor = $('#id_proveedor').val();
  var dataString = 'process=deleted' + '&id_proveedor=' + id_proveedor;
  $.ajax({
    type: "POST",
    url: "borrar_proveedor.php",
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

function cxpp() {
  $("#res").attr("style", "display: none;");
  $("#divh").attr("style", "display: block;");
  $("#no-data").hide();
  var fini = $("#fini").val();
  var fin = $("#fin").val();
  var id_proveedor = $("#id_proveedor").val();
  $.ajax({
    type: 'POST',
    url: 'editar_proveedor.php',
    data: 'process=cxpp&fini=' + fini + '&fin=' + fin + '&id_proveedor=' + id_proveedor,
    dataType: 'JSON',
    success: function(datax) {
      if (datax.typeinfo == "Success") {
        $("#no-data").hide();
        $("#res").show();
        $("#resultado").html(datax.table);
        $("#res").attr("style", "display: block;");
        $("#divh").attr("style", "display: none;");

      } else {
        $("#res").hide();
        $("#no-data").show();
        $("#resultado").html("");
        $("#divh").attr("style", "display: none;");

      }
    }
  });
}

function cacum() {
  $("#res1").attr("style", "display: none;");
  $("#divh1").attr("style", "display: block;");
  $("#no-data1").hide();
  var fini = $("#fini1").val();
  var fin = $("#fin1").val();
  var id_proveedor = $("#id_proveedor").val();
  $.ajax({
    type: 'POST',
    url: 'editar_proveedor.php',
    data: 'process=cacum&fini=' + fini + '&fin=' + fin + '&id_proveedor=' + id_proveedor,
    dataType: 'JSON',
    success: function(datax) {
      if (datax.typeinfo == "Success") {
        $("#no-data1").hide();
        $("#res1").show();
        $("#resultado1").html(datax.table);
        $("#res1").attr("style", "display: block;");
        $("#divh1").attr("style", "display: none;");

      } else {
        $("#res1").hide();
        $("#no-data1").show();
        $("#resultado1").html("");
        $("#divh1").attr("style", "display: none;");

      }
    }
  });
}
