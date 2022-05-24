$(document).ready(function()
{
	var fecha = $("#fecha").val();
	var tipo = $("#tipo").val();
	$.ajax({
		type:'POST',
		url:"ticket_dia.php",
		data: "process=tiket&fecha="+fecha+"&tipo="+tipo,
		success: function(datax)
		{
			$("#t_mov").html(datax);
		}
	});

	$("#fecha").change(function()
	{
		var fecha = $('#fecha').val();
		var tipo = $("#tipo").val();
		$.ajax({
			type:'POST',
			url:"ticket_dia.php",
			data: "process=tiket&fecha="+fecha+"&tipo="+tipo,
			success: function(datax)
			{
				$("#t_mov").html(datax);
			}
		});
	})

	$("#tipo").change(function()
	{
		var fecha = $("#fecha").val();
		var tipo = $("#tipo").val();
		$.ajax({
			type:'POST',
			url:"ticket_dia.php",
			data: "process=tiket&fecha="+fecha+"&tipo="+tipo,
			success: function(datax)
			{
				$("#t_mov").html(datax);
			}
		});
	})

	$("#submit").click(function()
	{
		cargar();
	})

});

function cargar()
{
	var fecha = $("#fecha").val();
	var id_sucursal = $("#id_sucursal").val();
	var tipo = $("#tipo").val();

	var cadena = "reporte_ticket.php?fecha="+fecha+"&id_sucursal="+id_sucursal+"&tipo="+tipo;
	window.open(cadena, '', '');
}
