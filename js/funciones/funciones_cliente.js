$(document).ready(function()
{
  $('#formulario').validate({
    rules: {
      nombre: {
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
      nombre: "Por favor ingrese el Nombre del cliente",
      departamento: "Por favor seleccione un Departamento",
      municipio: "Por favor seleccione un Municipio",
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
      url: "agregar_cliente.php",
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
  $("#retiene").on("ifChecked", function() {
    $("#retiene_select").show();
    $('.select').select2();
    $("#hi_retiene").val(1);
  });
  $("#retiene").on("ifUnchecked", function() {
    $("#retiene_select").hide();
    $("#hi_retiene").val(0);
  });
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
    var urlprocess = 'agregar_cliente.php';
  }
  if (process == 'edited') {
    var urlprocess = 'editar_cliente.php';
  }
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
    }
  });
}

function reload1() {
  location.href = 'admin_cliente.php';
}

function deleted() {
  var id_cliente = $('#id_cliente').val();
  var dataString = 'process=deleted' + '&id_cliente=' + id_cliente;
  $.ajax({
    type: "POST",
    url: "borrar_cliente.php",
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
