$(document).ready(function(){
  //alert("hola");
  generar();
});
function generar(){
  fechai=$("#fecha_inicio").val();
  fechaf=$("#fecha_fin").val();
  dataTable = $('#editable2').DataTable().destroy();
  $('#editable2').DataTable({
    "pageLength": 50,
    "serverSide": true,
    "order": [[0, "asc"]],
    "ajax": {
      url: "cuentas_por_pagar_dt.php?fechai="+fechai+"&fechaf="+fechaf,
      type: 'POST',
      //dataType: 'JSON',
      data:{
      }
    },
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  }); // End of DataTable
}
$(document).on("click", ".edit_row", function()
{
  //alert("aqui");
  var id_cuenta = $(this).attr("id_cuenta");

	var url1='realizar_abono.php?id_cuenta='+id_cuenta;
  window.location =url1;
});
$("#form_add").on('submit', function(e){
		e.preventDefault();
    //alert("aqui");
		//$("#btn_add").prop("disabled",true)
    if ($("#monto").val()>0) {
      save_data();
    }
    else {
      display_notify("Error","Debe seleccionar un monto");
    }
	});
function save_data(){
	//$("#divh").show();
	//$("#main_view").hide();
	let form = $("#form_add");
	let formdata = false;
	if (window.FormData) {
		formdata = new FormData(form[0]);
	}
	$.ajax({
		type: 'POST',
		url: 'realizar_abono.php',
		cache: false,
		data: formdata ? formdata : form.serialize(),
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function (data) {
			//$("#divh").hide();
			//$("#main_view").show();
			display_notify(data.typeinfo,data.msg);
			if (data.typeinfo == "Success") {
				setTimeout("reload();", 1500);
			}
		}
	});
}
$(document).on("click",".delete_tr", function(event)
{
	event.preventDefault()
	let id_row = $(this).attr("id");
  let id_cuenta = $(this).attr("cuenta");
  let saldo = $(this).attr("saldo");
  let abono = $(this).attr("abono");
  let monto = $(this).attr("monto");
	let dataString = "process=eliminar"+"&id=" + id_row+"&id_cuenta=" + id_cuenta+"&monto=" + monto+"&saldo=" + saldo+"&abono=" + abono;
			$.ajax({
				type: "POST",
				url: 'realizar_abono.php',
				data: dataString,
				dataType: 'json',
				success: function (data) {
					//notification(data.type,data.title,data.msg);
          display_notify(data.typeinfo,data.msg);
					if (data.typeinfo == "Success") {
						setTimeout("reload();", 1500);
					}
				}
			});
});
$(document).on("click",".update_tr", function(event)
{
	event.preventDefault()
	let id_row = $(this).attr("id");
  let id_cuenta = $(this).attr("cuenta");
  let saldo = $(this).attr("saldo");
  let abono = $(this).attr("abono");
  let monto = $(this).attr("monto");

	var objAbono = $(this).closest('tr');
	var montoNuevo = (objAbono.find(".abono_monto")).val();
	//alert(montoNuevo);
	//console.log(montoAnterior.val());
  if (montoNuevo>0) {
    let dataString = "process=actualizar" + "&id=" + id_row+"&id_cuenta=" + id_cuenta+"&monto=" + monto+"&saldo=" + saldo+"&abono=" + abono +"&montoNuevo=" + montoNuevo;
        $.ajax({
          type: "POST",
          url: 'realizar_abono.php',
          data: dataString,
          dataType: 'json',
          success: function (data) {
            display_notify(data.typeinfo,data.msg);
            if (data.typeinfo == "Success") {
              setTimeout("reload();", 1500);
            }
          }
        });
  }
  else {
    display_notify("Error","Debe ingresar un monto");
  }
});
function reload() {
	location.href = "cuentas_por_pagar.php";
}
$(document).on("change", "#monto", function()
{
  setTimeout(validarMonto, 100);
});
$(document).on("click", "#btnMostrar", function(event) {
  generar();
});
$(document).on("change", ".monto", function()
{
	var monto = parseFloat($(this).val());
  var saldo = parseFloat($(this).attr("saldo"));
	var montoA = parseFloat($(this).attr("montoa"));
	var saldoMax = parseFloat(saldo) + parseFloat(montoA);
  //alert(monto +" - "+montoA);
  if (monto>saldoMax) {
    $(this).val(saldoMax);
  }
  else{

  }
});
function validarMonto(){
  var monto = parseFloat($("#monto").val());
  var saldoMax = parseFloat($("#monto").attr("saldo"));
  //alert(monto +" - "+saldoMax);
  if (monto>saldoMax) {
    $("#monto").val(saldoMax);
  }
  else{

  }
  return monto;
}
