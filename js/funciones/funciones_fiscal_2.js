$(document).ready(function()
{
	$( ".datepick" ).datepicker();
	$(".select2").select2();
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
			var tipo_x = $("#tipo").val();
			if(tipo_x == 1)
			{
				var tipo_impresion = $("#tipo_impre").val();
				if(tipo_impresion == 1)
				{
					imprimir_z();
				}
				if(tipo_impresion == 2)
				{
					var mes = $("#mes").val();
					var anhio = $("#anhio").val();
					var caja = $("#caja").val();
					var id_sucursal = $("#id_sucursal").val();
					var cadena = 'total_z_pdf.php?anhio='+anhio+"&mes="+mes+'&caja='+caja+"&id_sucursal="+id_sucursal;
					window.open(cadena, "", "");
				}
			}
			if(tipo_x == 0)
			{
				var tipo_impresion = $("#tipo_impre").val();
				if(tipo_impresion == 1)
				{
					imprimir_z_diario();
				}
				if(tipo_impresion == 2)
				{
					var fecha = $("#fecha").val();
					var caja = $("#caja").val();
					var id_sucursal = $("#id_sucursal").val();
					var cadena = 'z_pdf.php?fecha='+fecha+'&caja='+caja+"&id_sucursal="+id_sucursal;
					window.open(cadena, "", "");
				}
			}


		}
		else if(process == "inventario")
		{
			var cadena = "reporte_valoracion_inventario.php";
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

	$("#btn_excel").click(function()
	{
		var process = $("#process").val();
		if(process == "edit")
		{
			print_exel();
		}
	});
	$("#btn_excel_IN").click(function()
	{
		var process = $("#process").val();
		if(process == "inventario")
		{
			print_exel1();
		}
	});
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

function print_exel()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();
	var cadena = "reporte_fiscal_xls.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}
function print_exel1()
{
	var cadena = "reporte_inventario_xls.php";
	window.open(cadena, '', '');
}

$(document).on("change", '#tipo', function()
{
	var tipo = $(this).val();
	if(tipo == 1)
	{
		$("#mes_caja").attr("hidden", false);
		$("#anhio_caja").attr("hidden", false);
		$("#fech").attr("hidden", true);
	}
	if(tipo == 0)
	{
		$("#mes_caja").attr("hidden", true);
		$("#anhio_caja").attr("hidden", true);
		$("#fech").attr("hidden", false);
	}

})

function imprimir_z_diario(){
	var fecha = $("#fecha").val();
	var caja = $("#caja").val();
	var datoss = "process=imprimirz&fecha="+fecha+"&caja="+caja;
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
