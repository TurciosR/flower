function round(value, decimals)
{
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
$(document).ready(function() {
var admin_val = $("#admin").val();
if(admin_val == 1)
{
  cargar_caja();
}

$('#formulario').validate({
	    rules: {

                   efectivo: {
                    required: true,
                    number: true,
                     },
                    fecha: {
                    required: true,
                     },

                 },
                	messages: {
						efectivo: "Por favor ingrese el monto en efectivo",
						fecha: "Por favor seleccione la fecha",

					},

        submitHandler: function (form) {
            senddata();
        }
    });

  $(".decimal").numeric();
  $(".select").select2();
});
$(function (){
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


$(document).on('click', '#apertura_turno', function(event) {

	swal({
	  title: "Realizar apertura de turno?",
	  text: "Realizar una apertura de turno!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Si, realizar apertura de turno!",
	  cancelButtonText: "No, cancelar!",
	  closeOnConfirm: true,
	  closeOnCancel: false
	},
	function(isConfirm) {
	  if (isConfirm) {
	    agregar_turno();
	    //swal("Exito", "Turno iniciado con exito", "error");
	  } else {
	    swal("Cancelado", "La apertura de turno ha sido cancelada", "error");
	  }
	});
})
/*$("#cerrar_turno").click(function()
{
	swal({
	  title: "Cerrar el turno?",
	  text: "Finalizar turno actual!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: "Si, cerrar turno!",
	  cancelButtonText: "No, cancelar!",
	  closeOnConfirm: true,
	  closeOnCancel: false
	},
	function(isConfirm) {
	  if (isConfirm) {
	    cerrar_turno();
	    //swal("Exito", "Turno iniciado con exito", "error");
	  } else {
	    swal("Cancelado", "El cierre de turno ha sido cancelada", "error");
	  }
	});
})*/
$(document).on("click", ".aper", function()
{
  var caja = $("#id_caja").val();
  location.replace("apertura_caja.php?id_caja="+caja);
})
$(document).on("change", "#id_caja", function()
{
  cargar_caja();
});

$(document).on("click", "#btnAceptar", function()
{
	var user = $("#user_ad").val();
	var pass = $("#pass").val();
	var process = "confirmar";

	$.ajax({
		type:'POST',
		url:"cierre_turno.php",
		data: "process="+process+"&user="+user+"&pass="+pass,
		dataType: 'json',
		success: function(datax){
			//var total=datax.total;
			//$('#total_sistema').val(total);
			//totales();
			if(datax.typeinfo == "Success")
			{
				$(".af").attr("hidden", true);
				$(".df").attr("hidden", false);
			}
			else
			{
				display_notify(datax.typeinfo, datax.msg);
			}
		}
	});
})
$(document).on("keyup, focusout, blur","#fecha",function(){
	var fecha=$('#fecha').val();
	dataString='process=total_sistema&fecha='+fecha;
	//alert(dataString);
	$.ajax({
				type:'POST',
				url:"corte_caja_diario.php",
				data: dataString,
				dataType: 'json',
				success: function(datax){
					var total=datax.total;
					$('#total_sistema').val(total);
					totales();
				}
			});

	totales();
});
//function to round 2 decimal places
function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    //round "original" to two decimals
	//var result=Math.round(original*100)/100  //returns value like 28.45
}
//Eventos que pueden enviar a calular totales corte de caja
$(document).on("keyup","#efectivo, #tarjeta, #cheque",function(){
  totales();
});

function agregar_turno()
{
	var id_apertura = $("#id_apertura").val();
	var id_d = $("#id_d_ap1").val();
	console.log(id_d);
	dataString='process=apertura_turno&id_detalle='+id_d+"&id_apertura="+id_apertura;
	$.ajax({
		type:'POST',
		url:"apertura_caja.php",
		data: dataString,
		dataType: 'json',
		success: function(datax){
			if(datax.typeinfo == 'Success')
			{
				setInterval("reload2();", 1000);
			}
		}
	});
}
function cerrar_turno()
{
	var id_apertura = $("#id_apertura").val();
	dataString='process=cerrar_turno&id_apertura='+id_apertura;
	$.ajax({
		type:'POST',
		url:"apertura_caja.php",
		data: dataString,
		dataType: 'json',
		success: function(datax){
			if(datax.typeinfo == 'Success')
			{
				setInterval("reload2();", 500);
			}
		}
	});
}
function cargar_caja()
{
  var id_caja = $("#id_caja").val();
  var id_empleado = $("#id_emple").val();
  if(id_caja != 0 && id_caja != "")
  {
    $.ajax({
  		type:'POST',
  		url:"admin_corte.php",
  		data: "process=caja&id_caja="+id_caja+"&id_empleado="+id_empleado,
  		success: function(datax){
  				$("#caja_caja").html(datax);
  		}
  	});
  }
}
function totales(){
	var total_sistema=parseFloat($('#total_sistema').val());
	var efectivo=parseFloat($('#efectivo').val());
	var tarjeta=parseFloat($('#tarjeta').val());
	var cheque=parseFloat($('#cheque').val());
	var observ="";

	if (isNaN(parseFloat(efectivo))){
		efectivo=0;
	}
	if (isNaN(parseFloat(tarjeta))){
		tarjeta=0;
	}
	if (isNaN(parseFloat(cheque))){
		cheque=0;
	}
	var total_corte=efectivo+tarjeta+cheque;
	var diferencia=total_corte-total_sistema;

	var total_cortado=round(total_corte, 2);
	var	total_corte_mostrar=total_cortado.toFixed(2);

	var dif=round(diferencia, 2);
	var	dif_mostrar=dif.toFixed(2);
	if(diferencia>0){
		observ="Hay una diferencia positiva de "+dif_mostrar +" dolares";
	}
	if(diferencia<0){
		observ="Hay una diferencia negativa de "+dif_mostrar +" dolares";
	}
	$('#total_corte').val(total_corte_mostrar);
	$('#diferencia').val(dif_mostrar);
	$('#observaciones').val(observ);
}
function senddata(){
	var fecha=$('#fecha').val();
	var efectivo=$('#efectivo').val();
	var tarjeta=$('#tarjeta').val();
	var cheque=$('#cheque').val();
	var observaciones=$('#observaciones').val();
	var total_corte=$('#total_corte').val();
	var total_sistema=$('#total_sistema').val();
	var diferencia=$('#diferencia').val();
	var numero_remesa=$('#numero_remesa').val();
    //Get the value from form if edit or insert
	var process=$('#process').val();

	if(process=='insert'){
		var id_caja_chica=0;
		var urlprocess='corte_caja_diario.php';
	}

	var dataString='process='+process+'&fecha='+fecha+'&efectivo='+efectivo+'&tarjeta='+tarjeta+'&cheque='+cheque;
	dataString+='&total_corte='+total_corte+'&total_sistema='+total_sistema+'&diferencia='+diferencia+'&numero_remesa='+numero_remesa+'&observaciones='+observaciones;

	$.ajax({
		type:'POST',
		url:urlprocess,
		data: dataString,
		dataType: 'json',
		success: function(datax){
				process=datax.process;
				//var maxid=datax.max_id;
				display_notify(datax.typeinfo,datax.msg);
				setInterval("reload1();", 5000);
			}
	});
}

 function reload1(){
	location.href = 'corte_caja_diario.php';
}
function reload2(){
	location.href = 'admin_corte.php';
}
function deleted() {
	var id_producto = $('#id_producto').val();
	var dataString = 'process=deleted' + '&id_producto=' + id_producto;
	$.ajax({
		type : "POST",
		url : "borrar_producto.php",
		data : dataString,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			setInterval("location.reload();", 3000);
			$('#deleteModal').hide();
		}
	});
}
$(document).on("click", "#btnReimprimir", function(event) {
	reimprimir();
});
function reimprimir(){
	var id_corte = $("#id_corte").val();
	imprimir_corte(id_corte);
	//$('#viewModal').hide();
	//setInterval("location.reload();", 500);
}

function imprimir_corte(id_corte){
	var datoss = "process=imprimir"+"&id_corte="+id_corte;
	$.ajax({
		type : "POST",
		url :"corte_caja_diario.php",
		data : datoss,
		dataType : 'json',
		success : function(datos) {
			var sist_ope = datos.sist_ope;
			var dir_print=datos.dir_print;
			var shared_printer_win=datos.shared_printer_win;
			var shared_printer_pos=datos.shared_printer_pos;

				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printcortewin1.php", {
						datosvale: datos.movimiento,
						shared_printer_win:shared_printer_win,
            shared_printer_pos:shared_printer_pos
					})
				} else {
					$.post("http://"+dir_print+"printcorte1.php", {
						datosvale: datos.movimiento
					});
				}

		}
	});
}
$(document).on('click', '#btnCorte', function()
{
	corte1();
})
function corte1()
{
	var form = $("#formulario1");
    var formdata = false;
    if(window.FormData)
    {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type        : 'POST',
        url         : 'cierre_turno.php',
        cache       : false,
        data        : formdata ? formdata : form.serialize(),
        contentType : false,
        processData : false,
        dataType : 'json',
        success: function(datax)
        {
		    display_notify(datax.typeinfo, datax.msg)
		    if(datax.typeinfo == "Success")
		    {
	          	var id_corte=datax.id_corte;
	          	imprimir_corte(id_corte)
	          	setInterval("reload2();", 1000);
		    }
	    }
    });
}

$(document).on("keyup","#total_efectivo", function()
{
	var total_corte = $("#total_corte").val();
	var total_efectivo = $(this).val();

	if(total_efectivo == total_corte)
	{
		$("#diferencia").val("0.0");
		$("#id_diferencia").text("0.0");
	}
	else if(total_efectivo > total_corte)
	{
		var valor = total_efectivo - total_corte;
		$("#diferencia").val(round(valor, 2));
		$("#id_diferencia").text(round(valor, 2));
	}
	else if(total_corte > total_efectivo)
	{
		var valor = total_corte - total_efectivo;
		$("#diferencia").val(round(valor, 2));
		$("#id_diferencia").text(round(valor, 2));
	}
})
function total()
{
	var tipo_corte = $("#tipo_corte").val();
	var t_t = parseFloat($("#total_tike").val());
	var t_f = parseFloat($("#total_factura").val());
	var t_c = parseFloat($("#total_credito").val());
	var t_e_c = parseFloat($("#total_entrada").val());
	var t_s_c = parseFloat($("#total_salida").val());
	var m_p = parseFloat($("#monto_apertura").val());
	//var d_t = d_g + d_e;
	console.log(t_f);
	var total_all = 0;
	if(tipo_corte == "C")
	{
		var total_c = t_t + t_f + t_c + m_p + t_e_c - t_s_c ;
		total_all = round(total_c, 2);
	}
	else if(tipo_corte == "X")
	{
		var total_x = t_t + t_f + t_c  + m_p;
		total_all = round(total_x, 2);
	}
	else if(tipo_corte == "Z")
	{
		var total_z = t_t + t_f + t_c  + m_p;
		total_all = round(total_z, 2);
	}
	//alert(total_all);

	$("#total_corte").val(total_all);
	$("#id_total_general").text(total_all);
	$("#id_diferencia").text("-"+total_all);
	$("#id_total").text(total_all);
}

$("#search").click(function()
{
	var fecha1 = $("#fecha1").val();
	var fecha2 = $("#fecha2").val();
	var process = "ok";

	$.ajax({
		type:'POST',
		url:"admin_corte.php",
		data: "process="+process+"&fecha1="+fecha1+"&fecha2="+fecha2,
		success: function(datax){
			$("#caja_x").html(datax);
		}
	});
})
