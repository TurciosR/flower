$(document).ready(function()
{
	$('.select2').select2();
	$( ".datepick" ).datepicker();
	$("#submit1").click(function()
	{
		var process = $("#process").val();
		if(process == "imprime_pedi_todo")
		{
			cargar();
		}
		else if(process=="pendiente")
		{
			cargar1();
		}else if (process=="procesado") {
			cargar2();
		}else if(process=="finalizado"){
			cargar3();
		}

	})
});

function cargar()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();
	var tipo=$("#tipo_pedido").val();
	var cadena = "reporte_pedido_todo.php?fini="+fini+"&ffin="+ffin+"&tipo="+tipo;
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

	var cadena = "reporte_factura_pendiente.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}
function cargar3()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();

	var cadena = "reporte_factura_pendiente.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}
