var dataTable ="";

$(document).ready(function()
{
	$(".date").datepicker();

	// Clean the modal form
	generar();
});
$(".datepick").datepicker({
		format: 'dd-mm-yyyy',
		language:'es',
});
$('.decimal').numeric({
    negative: false,
    decimalPlaces: 2
});
function generar(){
	fechai=$("#fecha_inicio").val();
	fechaf=$("#fecha_fin").val();
	id_proveedor=$("#id_proveedor").val();
	dataTable = $('#editable2').DataTable().destroy()
	dataTable = $('#editable2').DataTable( {
			"pageLength": 50,
			"order":[[ 7, 'desc' ], [ 6, 'asc' ]],
			"processing": true,
			"serverSide": true,
			"ajax":{
					url :"admin_cxp_dt.php?fechai="+fechai+"&fechaf="+fechaf+"&id_proveedor="+id_proveedor, // json datasource
					//url :"admin_factura_rangos_dt.php", // json datasource
					//type: "post",  // method  , by default get
					error: function(){  // error handling
						$(".editable2-error").html("");
						$("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="3">No se encontró información segun busqueda </th></tr></tbody>');
						$("#editable2_processing").css("display","none");
						$( ".editable2-error" ).remove();
						}
					}
				} );

		dataTable.ajax.reload()
	//}
}
$(function (){
	//binding event click for button in modal form
	$(document).on("click", "#btnDelete", function(event) {
		deleted();
	});
	$(document).on("click", "#abon", function(event) {
			if($("#descuento").val()!="")
			{
				if($("#monto").val()!="")
				{
					send();
				}
				else
				{
					display_notify("Error", "Por favor ingrese el monto del descuento");
				}
			}
			else
			{
				display_notify("Error", "Por favor seleccione un tipo de descuento");
			}
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
$(document).on("click", "#closing", function(event) {
	reload1();
});
function send()
{
	var idtransace = $('#idtransace').val();
	var tipo_descuento = $('#descuento').val();
	var numero_doc = $('#numero_doc').val();
	var monto = $('#monto').val();
	var dataString = 'process=descontar'+'&idtransace='+idtransace+"&tipo_descuento="+tipo_descuento+"&numero_doc="+numero_doc+"&monto="+monto;


	$.ajax({
		type : "POST",
		url : "descontar.php",
		data : dataString,
		dataType : 'JSON',
		success: function(datax)
		{
			display_notify(datax.typeinfo,datax.msg);
			if(datax.typeinfo == "Success")
			{
				/*setInterval("reload1();", 1000);
				$("#clos").click();*/
				var idtransace=$('#idtransace').val();
				$.ajax({
					type : "POST",
					url : "descontar.php",
					data : 'process=refresh'+'&idtransace='+idtransace,
					dataType : 'JSON',
					success: function(datax)
					{
						$('#cuerpo_tabla').html(datax.opt);
						$('#total_descuentos').html(datax.tot);
						$('#numero_doc').val('');
						$('#monto').val('');
						$('#saldo_pendiente').val(datax.saldo_pend);
						$('.select').val('').trigger('change');
					}
				});

			}
		}
	});
}
function reload1(){
  var id = $('#id_proveedor').val();
	location.href = 'admin_cxp.php?id_proveedor='+id;
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
      setTimeout(save_data, 500);
    }
    else {
      display_notify("Error","Debe seleccionar un monto");
    }
	});
function save_data(){
	//$("#divh").show();
	//$("#main_view").hide();
	let id_cuenta_p = $("#id_cuenta_p").val();
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
				setTimeout("reload("+id_cuenta_p+");", 1500);
			}
		}
	});
}
$(document).on("click",".delete_tr", function(event)
{
	$(".delete_tr").prop("disabled", true);
	event.preventDefault();
	let id_row = $(this).attr("id");
  let id_cuenta = $(this).attr("cuenta");
  let saldo = $(this).attr("saldo");
  let abono = $(this).attr("abono");
  let monto = $(this).attr("monto");
	let id_cuenta_p = $("#id_cuenta_p").val();
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
						setTimeout("reload("+id_cuenta_p+");", 1500);
					}
					else {
						$(".delete_tr").prop("disabled", false);
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
						else {
							
						}
          }
        });
  }
  else {
    display_notify("Error","Debe ingresar un monto");
  }
});
function reload(id_cuenta_p) {
	location.href = "realizar_abono.php?id_cuenta="+id_cuenta_p;
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
