var dataTable ="";
$(document).ready(function() {
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});
	generar();
});
function generar(){
	fechai=$("#fecha_inicio").val();
	fechaf=$("#fecha_fin").val();
	dataTable = $('#editable2').DataTable().destroy()
	dataTable = $('#editable2').DataTable( {
			"pageLength": 50,
			"order":[[ 0, 'desc' ]],
			"processing": true,
			"serverSide": true,
			"ajax":{
					url :"admin_devoluciones_rangos_dt.php?fechai="+fechai+"&fechaf="+fechaf, // json datasource
					//url :"admin_devoluciones_rangos_dt.php", // json datasource
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
	//Reimprimir factura
	$(document).on("click", "#btnPrint", function(event) {
		print1();
	});
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});
	//Reimprimir factura
	$(document).on("click", "#btnPrintFact", function(event) {
		print2();
	})
	//Recargar facturas
	$(document).on("click", "#btnReload", function(event) {
		reload2();
	});
	//Recargar facturas
	$(document).on("click", "#btnReload3", function(event) {
		reload3();
	});
	//Finalizar factura
	$(document).on("click", "#btnFinFact", function(event) {
		finalizar2();
	})
});
$(document).on("click", "#btnMostrar", function(event) {
	generar();
});

function reload1(){
	location.href = 'admin_devoluciones_rangos.php';
}
function reload2(){
	location.href = 'admin_venta_nofin.php';
}
function reload3(){
	location.href = 'admin_facturas_vendedor.php';
}
function deleted() {
	var id_factura = $('#id_factura').val();
	var dataString = 'process=deleted' + '&id_factura=' + id_factura;
	$.ajax({
		type : "POST",
		url : "anular_factura.php",
		data : dataString,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			setInterval("location.reload();", 3000);
			$('#deleteModal').hide();
		}
	});
}
function print1() {
	var id_factura = $('#id_factura').val();
	var dataString = 'process=imprimir_fact' + '&id_factura=' + id_factura;
	$.ajax({
		type : "POST",
		url : "reimprimir_factura.php",
		data : dataString,
		dataType : 'json',
		success : function(datos) {
			var sist_ope = datos.sist_ope;
			var dir_print=datos.dir_print;
			var tipo_impresion= datos.tipo_impresion;
      var shared_printer_win=datos.shared_printer_win;
			var shared_printer_pos=datos.shared_printer_pos;
			var headers=datos.headers;
			var footers=datos.footers;
			efectivo_fin=0;
			 cambio_fin=0;
			//esta opcion es para generar recibo en  printer local y validar si es win o linux
      // alert(tipo_impresion+"--"+sist_ope)
			if (tipo_impresion == 'COF') {
				if (sist_ope == 'win') {
           //*
					$.post("http://"+dir_print+"printfactwin1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						shared_printer_win:shared_printer_win

					});


				} else {
					$.post("http://"+dir_print+"printfact1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin
					}, function(data, status) {

						if (status != 'success') {
							//alert("No Se envio la impresión " + data);
						}

					});
				}
			}

			if (tipo_impresion == 'TIK') {
				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printposwin1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						shared_printer_pos:shared_printer_pos,
						headers:headers,
						footers:footers,

					})
				} else {
					$.post("http://"+dir_print+"printpos1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						headers:headers,
						footers:footers,
					}, function(data, status) {

						if (status != 'success') {
							//alert("No Se envio la impresión " + data);
						}

					});
				}
			}
			if (tipo_impresion == 'DEV') {
				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printncrwin1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						shared_printer_win:shared_printer_win
					})
				} else {
					$.post("http://"+dir_print+"printncr1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin
					});
				}
			}
			if (tipo_impresion == 'CCF') {
				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printcfwin1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						shared_printer_win:shared_printer_win
					})
				} else {
					$.post("http://"+dir_print+"printcf1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin
					}, function(data, status) {

						if (status != 'success') {
							//alert("No Se envio la impresión " + data);
						}

					});
				}
			}
			if (tipo_impresion == 'ENV') {
				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printenvwin1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin,
						shared_printer_win:shared_printer_win
					})
				} else {
					$.post("http://"+dir_print+"printenv1.php", {
						datosventa: datos.facturar,
						efectivo: efectivo_fin,
						cambio: cambio_fin
					});
				}
			}
		//  setInterval("reload1();", 500);
		}
	});
}
function print2() {
	var id_factura = $('#id_factura').val();
	var dataString = 'process=imprimir_fact' + '&id_factura=' + id_factura;
	$.ajax({
		type : "POST",
		url : "imprimir_factura.php",
		data : dataString,
		dataType : 'json',
		success : function(datos) {
			//display_notify(datax.typeinfo, datax.msg);
				sist_ope=datos.sist_ope;
				var efectivo_fin=parseFloat($('#efectivo').val());
				var cambio_fin=parseFloat($('#cambio').text());
					//esta opcion es para generar recibo en  printer local y validar si es win o linux
					if (sist_ope=='win'){
						$.post("http://localhost:8080/variedades/printpos1.php",{datosventa:datos.facturar})
					}
					else {
						$.post("http://localhost/variedades/printpos1.php",{datosventa:datos.facturar,efectivo:efectivo_fin,cambio:cambio_fin},function(data,status){
							if (status!='success'){
								alert("No Se envio la impresión " +data);
							}
							else{
								setInterval("reload2();", 3000);
							}
                        });
					}

		}
	});
}
$(document).on("keyup","#efectivo",function(){
  total_efectivo();
});
function total_efectivo(){
	var efectivo=parseFloat($('#efectivo').val());
	var totalfinal=parseFloat($('#facturado').text());
	var facturado= totalfinal.toFixed(2);
	if (isNaN(parseFloat(efectivo))){
		efectivo=0;
	}
	if (isNaN(parseFloat(totalfinal))){
		totalfinal=0;
	}
	var cambio=efectivo-totalfinal;
	var cambio=round(cambio, 2);
	var	cambio_mostrar=cambio.toFixed(2);
	if($('#efectivo').val()!='' && efectivo>=totalfinal)
		$('#cambio').html("<h5 class='text-success'>"+cambio_mostrar+"</h5>");
	else
		$('#cambio').text('');
	if(efectivo<totalfinal){
		$('#cambio').html("<h5 class='text-danger'>"+"Falta dinero !!!"+"</h5>");
	}
}
//function to round 2 decimal places
function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function finalizar2() {
	var id_factura = $('#id_factura').val();
	var dataString = 'process=finalizar_fact' + '&id_factura=' + id_factura;
	$.ajax({
		type : "POST",
		url : "finalizar_factura.php",
		data : dataString,
		dataType : 'json',
				success: function(datax){
				process=datax.process;
				factura=datax.factura;
				display_notify(datax.typeinfo,datax.msg);


			 setInterval("reload2();", 3000);


		}
	});
}
