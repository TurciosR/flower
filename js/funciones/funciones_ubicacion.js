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
  var ubicacion = $('#ubicacion').val();
  var bodega = $('#bodega').val();
  var process = $('#process').val();

  if (process == 'insert') {
    var id_ubicacion = 0;
    var urlprocess = 'agregar_ubicacion.php';
  }
  if (process == 'edited') {
    var id_ubicacion = $('#id_ubicacion').val();
    var urlprocess = 'editar_ubicacion.php';
  }
  var dataString = 'process=' + process + '&id_ubicacion=' + id_ubicacion + '&bodega=' + bodega + '&ubicacion=' + ubicacion;


  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      process = datax.process;
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo != "Error") {
        setInterval("reload1();", 1000);
      }
    }
  });
}

function reload1() {
  location.href = 'admin_ubicacion.php';
}

function deleted() {
  var id_ubicacion = $('#id_ubicacion').val();
  var dataString = 'process=deleted' + '&id_ubicacion=' + id_ubicacion;
  $.ajax({
    type: "POST",
    url: "borrar_ubicacion.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo != "Error") {
        setInterval("location.reload();", 1000);
        $('#deleteModal').hide();
      }
    }
  });
}
