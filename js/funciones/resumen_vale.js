$(document).ready(function()
{
	$(".select").select2();
	cargar();
	$("#fecha").change(function()
	{
		cargar();
	})
	$("#tipo").change(function()
	{
		cargar();
	})
	$("#sucursal").change(function()
	{
		cargar();
	})
	$("#submit").click(function()
	{
		print_resumen();
	})

});
function print_resumen(){
	var fecha  = $("#fecha").val();
	var tipo  = $("#tipo").val();
	var id_sucursal = $("#sucursal").val();
	var datoss = "process=imprimir"+"&fecha="+fecha+"&tipo="+tipo+"&id_sucursal="+id_sucursal;
	$.ajax({
		type : "POST",
		url :"resumen_vale.php",
		data : datoss,
		dataType : 'json',
		success : function(datos) {
			var sist_ope = datos.sist_ope;
			var dir_print=datos.dir_print;
			var shared_printer_win=datos.shared_printer_win;
			var shared_printer_pos=datos.shared_printer_pos;

				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printvalewin1.php", {
						datosvale: datos.movimiento,
						shared_printer_win:shared_printer_win,
						shared_printer_pos:shared_printer_pos,
					})
				} else {
					$.post("http://"+dir_print+"printvale1.php", {
						datosvale: datos.movimiento
					});
				}

		}
	});
}
function cargar()
{
	var fecha  = $("#fecha").val();
	var tipo  = $("#tipo").val();

	var id_sucursal = $("#sucursal").val();
	$.ajax({
		type:'POST',
		url:"resumen_vale.php",
		data: "process=vale&fecha="+fecha+"&tipo="+tipo+"&id_sucursal="+id_sucursal,
		success: function(datax)
		{
			$("#t_mov").html(datax);
		}
	});
}
