$(document).ready(function() {
  $("#id_presentacion").select2();
  $("#precio").numeric({
    negative: false,
    decimalPlaces: 2
  });
  $(".int").numeric({
    negative: false,
    decimal: false
  });
});


$(document).on('click', '#add', function(event) {
  var id_presentacion = $("#id_presentacion").val();
  var desde = $("#desde").val();
  var hasta = $("#hasta").val();
  var precio = $("#precio").val();
  var id_producto = $("#id_producto").val();

  err = 0;
  msg = "";

  if (desde != "") {
    if (hasta != "") {
      if (precio != "") {
        $.ajax({
          url: 'precio_producto.php',
          type: 'POST',
          dataType: 'json',
          data: "process=" + "insert" + "&id_presentacion=" + id_presentacion + "&desde=" + desde + "&hasta=" + hasta + "&precio=" + precio + "&id_producto=" + id_producto,
          success: function(datax) {
            $("#desde").val("");
            $("#hasta").val("");
            $("#precio").val("");

            display_notify(datax.typeinfo, datax.msg);
            $.ajax({
              url: 'precio_producto.php',
              type: 'POST',
              dataType: 'json',
              data: "process=" + "change" + "&id_presentacion=" + id_presentacion,
              success: function(datax) {
                $("#precios>tbody").html(datax.valores);

              }
            });
          }
        });

      } else {
        err = 1;
        msg = "No digito precio";
      }
    } else {
      err = 1;
      msg = "No digito hasta";

    }
  } else {
    err = 1;
    msg = "No digito desde";
  }

  if (err == 1) {
    display_notify("Error", msg);
  }


});

$(document).on('click', '.del', function(event) {
  var id_presentacion = $("#id_presentacion").val();
  var id_producto = $("#id_producto").val();

  var id_prepd = $(this).closest('tr').find('.id_prepp').val();

  $.ajax({
    url: 'precio_producto.php',
    type: 'POST',
    dataType: 'json',
    data: "process=" + "del" + "&id_prepd=" + id_prepd + "&id_producto=" + id_producto,
    success: function(datax) {

      display_notify(datax.typeinfo, datax.msg);
      $.ajax({
        url: 'precio_producto.php',
        type: 'POST',
        dataType: 'json',
        data: "process=" + "change" + "&id_presentacion=" + id_presentacion,
        success: function(datax) {
          $("#precios>tbody").html(datax.valores);

        }
      });
    }
  });

});

$(document).on('change', '#id_presentacion', function(event) {

  var id_presentacion = $("#id_presentacion").val();

  $.ajax({
    url: 'precio_producto.php',
    type: 'POST',
    dataType: 'json',
    data: "process=" + "change" + "&id_presentacion=" + id_presentacion,
    success: function(datax) {
      $("#precios>tbody").html(datax.valores);

    }
  });
});
