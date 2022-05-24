$(document).ready(function()
{
	$( ".datepick" ).datepicker();
	$(".select2").select2();
	$("#submit2").click(function()
	{
		var cadena = "reporte_inventario_xls.php";
		window.open(cadena, '', '');
	});
	$("#submit1").click(function()
	{
		var process = $("#process").val();
		if(process == "venta_pediente")
		{
			cargar1();
		}
		else if(process == "factura")
		{
			cargar2();
		}
		else if(process == "total_z")
		{
			imprimir_z();
		}
		else if(process == "inventario")
		{
			var cadena = "reporte_inventario_pdf.php";
			window.open(cadena, '', '');
		}
		else if(process == "utilidad")
		{
			var fecha = $("#ffin").val();
			var cadena = "reporte_costo_utilidad.php?fecha="+fecha;
			window.open(cadena, '', '');
		}
		else
		{
			cargar();
		}

	})
});

$(document).on("ifChecked", "#tiket", function()
{
	$("#ticket").val("1");
	console.log("1");
});
$(document).on("ifUnchecked", "#tiket", function()
{
	$("#ticket").val("0");
	console.log("0");
});

function cargar()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();

	var cadena = "reporte_fiscal.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}

function cargar1()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();

	var cadena = "reporte_factura_pendiente.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}

function cargar2()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();
	var ticket = $("#ticket").val();

	var cadena = "reporte_factura.php?fini="+fini+"&ffin="+ffin+"&tiket="+ticket;
	window.open(cadena, '', '');
}

function imprimir_z(){
	var anhio = $("#anhio").val();
	var mes = $("#mes").val();
	var caja = $("#caja").val();
	var datoss = "process=imprimir&anhio="+anhio+"&mes="+mes+"&caja="+caja;
	$.ajax({
		type : "POST",
		url :"ver_total_z.php",
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
						shared_printer_pos:shared_printer_pos,
					})
				} else {
					$.post("http://"+dir_print+"printcorte1.php", {
						datosvale: datos.movimiento
					});
				}

		}
	});
}
