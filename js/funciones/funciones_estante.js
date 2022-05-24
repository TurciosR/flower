
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
  var estante = $('#estante').val();
  var ubicacion = $('#ubicacion').val();
  var npos = $('#npos').val();
  var process = $('#process').val();

  if (process == 'insert') {
    var id_estante = 0;
    var urlprocess = 'agregar_estante.php';
  }
  if (process == 'edited') {
    var id_estante = $('#id_estante').val();
    var urlprocess = 'editar_estante.php';
  }
  var dataString = 'process=' + process + '&id_estante=' + id_estante + '&estante=' + estante + '&ubicacion=' + ubicacion + "&npos=" + npos;


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
  location.href = 'admin_estante.php';
}

function deleted() {
  var id_estante = $('#id_estante').val();
  var dataString = 'process=deleted' + '&id_estante=' + id_estante;
  $.ajax({
    type: "POST",
    url: "borrar_estante.php",
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
