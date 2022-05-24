$(document).ready(function() {
  $("#precio").select2();
});

$(document).on('click', '#guardar', function(event) {
  $('#guardar').attr('disabled', true);
  senddata();

});


function senddata() {

  var dataString = $("#formulario").serialize();

  var process = $('#process').val();

  if (process == 'insert') {
    var urlprocess = 'agregar_autorizacion.php';
  }

  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      if (datax.typeinfo == "Success") {
        swal({
          html: true,
          title: "<b>Clave <i>" + datax.clave + "</i></b>",
          text: "<b>Presione OK para continuar</b>",
          type: "warning",
          showCancelButton: false,
          confirmButtonColor: '',
          confirmButtonText: 'OK',
          closeOnConfirm: false,
          closeOnCancel: true
        }, function(isConfirm) {
          if (isConfirm) {
              location.href = 'agregar_autorizacion.php';

          } else {}

        });


      }
      else {
        display_notify(datax.typeinfo, datax.msg);
        $('#submit1').attr('disabled', false);
      }
    }
  });
}
