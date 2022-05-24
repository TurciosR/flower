$(document).ready(function()
{
	$( ".datepick" ).datepicker();
	$("#submit1").click(function()
	{
			cargar();
	})
	$("#xls").click(function()
	{
			cargar_excel();
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

	var cadena = "libro_compras.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}
function cargar_excel()
{
	var fini = $("#fini").val();
	var ffin = $("#ffin").val();

	var cadena = "libro_compras_excel.php?fini="+fini+"&ffin="+ffin;
	window.open(cadena, '', '');
}
