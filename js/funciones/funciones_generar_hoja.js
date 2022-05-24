$(document).ready(function() {
  $('.select').select2();

});

$(document).on('click', '#generar', function(event) {

  //Calcular los valores a guardar de cada item del inventario
  var i = 0;
  var error  = false;
  var datos = "";
  var id = $("select#tipo_entrada option:selected").val(); //get the value


  if(!error)
  {
    $('#params').val("a");
    $('#cu').val("a");
    $('#frm1').submit();
  }
});
