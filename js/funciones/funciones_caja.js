$(document).ready(function()
{
  $('#formulario').validate({
  	    rules: {
            name_caja: {
            required: true,
             },
            serie: {
            required: true,
             },
            desde: {
            required: true,
             },
            hasta: {
            required: true,
             },

         },
        messages: {
						name_caja: "Por favor ingrese el nombre de caja",
						serie: "Por favor ingrese la serie",
						desde: "Por favor ingrese el valor inicial",
						hasta: "Por favor ingrese el valor final",

					},

        submitHandler: function (form) {
            senddata();
        }
      });
      $('.select').select2();
      $(".numeric").numeric({
        negative:false,
      });
});

function senddata()
{
  var nombre_caja = $("#name_caja").val();
  var serie = $("#serie").val();
  var desde = $("#desde").val();
  var resolucion = $("#resolucion").val();
  var fecha = $("#fecha").val();
  var hasta = $("#hasta").val();
  var process = $("#process").val();
  var id_sucursal = $("#id_sucursal").val();


  var datos = "";
  if(process == 'agregar')
  {
    var url = "agregar_caja.php";
    datos += "process="+process+"&nombre_caja="+nombre_caja+"&serie="+serie+"&desde="+desde+"&hasta="+hasta+"&resolucion="+resolucion+"&fecha="+fecha+"&id_sucursal="+id_sucursal;
  }
  if(process == 'editar')
  {
    var url = "editar_caja.php";
    var id_caja = $("#id_caja").val();
    datos += "process="+process+"&nombre_caja="+nombre_caja+"&serie="+serie+"&desde="+desde+"&hasta="+hasta+"&resolucion="+resolucion+"&fecha="+fecha+"&id_caja="+id_caja+"&id_sucursal="+id_sucursal;
  }
  if(id_sucursal != "" && id_sucursal != 0)
  {
    $.ajax({
      type:'POST',
      url:url,
      data: datos,
      dataType: 'json',
      success: function(datax){
        display_notify(datax.typeinfo,datax.msg);
        if(datax.typeinfo == 'Success')
        {
          setInterval("reload1();", 1000);
        }
      }
    });
  }
  else
  {
    display_notify("Error","Debe de seleccionar la sucursal");
  }

}

$(document).on("click","#estado", function()
{
  var id_caja = $(this).parents("tr").find("#id_caja").val();
  var estado = $(this).parents("tr").find("#estado1").val();
  if(estado == 1)
  {
    var text = "Desactivar";
  }
  else
  {
      var text = "Activar";
  }
  swal({
    title: text+" esta caja?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, "+text+" esta caja!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: true,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      estado_pro(id_caja, estado);
      //swal("Exito", "Turno iniciado con exito", "error");
    } else {
      swal("Cancelado", "Operación cancelada", "error");
    }
  });
})
function estado_pro(id_caja, estado) {
  //var id_proveedor = $('#id_proveedor').val();
  var dataString = 'process=estado' + '&id_caja=' + id_caja+ '&estado=' + estado;
  $.ajax({
    type: "POST",
    url: "admin_caja.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      if (datax.typeinfo == "Success") {
        setInterval("reload1();", 1000);
        //$('#deleteModal').hide();
      }
    }
  });
}

function reload1() {
  location.href = 'admin_caja.php';
}
