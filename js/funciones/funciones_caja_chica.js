$(document).ready(function() {

$('#formulario').validate({
	    rules: {
                    tipo_proceso: {
                    required: true,
                     },

                    monto: {
                    required: true,
                    number: true,
                     },

                    observaciones: {
                    required: true,

                     },
                    fecha_proceso: {
                    required: true,
                     },
                     id_proveedor: {
                    required: true,
                     },
                 },
                	messages: {
						tipo_proceso: "Por favor seleccione el tipo de proceso",
						id_proveedor: "Por favor seleccione el proveedor",
						observaciones: "Por favor ingrese el concepto de la transferencia",
						fecha_proceso: "Por favor seleccione la fecha",

						monto:{
				 		required: "Por favor ingrese el monto",
				 		number: "Este campo solo puede tener números"
						},

					},

        submitHandler: function (form) {
            senddata();
        }
    });

    $('#id_proveedor').select2();
});
$(function (){
	//binding event click for button in modal form
	$(document).on("click", "#btnIngreso", function(event) {
		agregar_ingreso();
	});
	$(document).on("click", "#btnSalida", function(event) {
		agregar_salida();
	});
	$(document).on("click", "#btnEditar", function(event) {
		editar_movimiento();
	});
	$(document).on("click", "#btnEliminar", function(event) {
		deleted();
	});
	$(document).on("click", "#btnReimprimir", function(event) {
		reimprimir();
	});
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});

});



function senddata(){
	//var name=$('#name').val();
    var descripcion=$('#descripcion').val();
    var monto=$('#monto').val();
    var fecha_proceso=$('#fecha_proceso').val();
    var tipo_doc=$('#tipo_doc').val();
    var numero_doc=$('#numero_doc').val();
    var tipo_proceso=$('select#tipo_proceso option:selected').val();
    var id_proveedor=$('select#id_proveedor option:selected').val();
    var observaciones=$('#observaciones').val();
    //Get the value from form if edit or insert
	var process=$('#process').val();

	if(process=='insert'){
		var id_caja_chica=0;
		var urlprocess='agregar_caja_chica.php';
	}
	if(process=='edited'){
		var id_servicio=$('#id_servicio').val();
		var urlprocess='editar_servicios.php';
	}
	//var dataString='process='+process+'&id_servicio='+id_servicio+'&descripcion='+descripcion+'&costo='+costo+'&precio='+precio;
	//dataString+='&estado='+estado+'&id_categoria='+id_categoria;

	var dataString='process='+process+'&id_caja_chica='+id_caja_chica+'&descripcion='+descripcion+'&monto='+monto+'&tipo_doc='+tipo_doc+'&id_proveedor='+id_proveedor;
	dataString+='&numero_doc='+numero_doc+'&tipo_proceso='+tipo_proceso+'&observaciones='+observaciones+'&fecha_proceso='+fecha_proceso;


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
	location.href = 'admin_caja_chica.php';
}
function deleted() {
	var id_movimiento = $("#id_movimiento").val();

	var datos = "process=eliminar"+"&id_movimiento="+id_movimiento;

	$.ajax({
		type : "POST",
		url : "borrar_movimiento_caja.php",
		data : datos,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);

			if(datax.typeinfo == "Success")
			{
				setInterval("location.reload();", 1000);
				$('#deleteModal').hide();
			}
		}
	});
}

function agregar_ingreso()
{
	var id_empleado = $("#id_empleado").val();
	var id_apertura = $("#id_apertura").val();
	var id_tipo = $("#tipo").val();
	var turno = $("#turno").val();
	var monto = $("#monto").val();
	var concepto = $("#concepto").val();

	var datos = "process=ingreso"+"&id_apertura="+id_apertura+"&id_empleado="+id_empleado+"&turno="+turno+"&monto="+monto+"&concepto="+concepto+"&id_tipo="+id_tipo;

	$.ajax({
		type : "POST",
		url : "agregar_ingreso_caja.php",
		data : datos,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			if(datax.typeinfo == "Success")
			{

				imprimir_vale(datax.id_mov);
				setInterval("location.reload();", 1000);
				$('#viewModal').hide();
			}
		}
	});
}
$(document).on("keyup","#monto", function()
{
	var monto = parseFloat($(this).val());
	var tipo_doc = $("#tipo_doc").val();
	if(tipo_doc == "CCF")
	{
		var result = monto - (monto/1.13);
		var iva = monto * 0.13;

		//$("#monto").val(result);
		$(".caja_iva").attr("hidden", false);
		$("#iva").val(iva);

		if(monto == "")
		{
			$(".caja_iva").attr("hidden", true);
			$("#iva").val("0");
		}
		else if(monto == 0)
		{
			$(".caja_iva").attr("hidden", true);
			$("#iva").val("0");
		}
	}
	else
	{
		$(".caja_iva").attr("hidden", true);
		$("#iva").val("0");
	}
});
function agregar_salida()
{
	var id_empleado = $("#id_empleado").val();
	var id_apertura = $("#id_apertura").val();
	var turno = $("#turno").val();
	var monto = $("#monto").val();
	var concepto = $("#concepto").val();
	var tipo_doc = $("#tipo_doc").val();
	var n_doc = $("#n_doc").val();
	var recibe = $("#recibe").val();
	var proveedor = $("#proveedor").val();
	var id_tipo = $("#tipo").val();
	var datos = "process=salida"+"&id_apertura="+id_apertura+"&id_empleado="+id_empleado+"&turno="+turno+"&monto="+monto+"&concepto="+concepto+"&proveedor="+proveedor+"&tipo_doc="+tipo_doc+"&n_doc="+n_doc+"&recibe="+recibe+"&id_tipo="+id_tipo;

	$.ajax({
		type : "POST",
		url : "agregar_salida_caja.php",
		data : datos,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			if(datax.typeinfo == "Success")
			{
				imprimir_vale(datax.id_mov);
				setInterval("location.reload();", 1000);
				$('#salidaModal').hide();
			}
		}
	});
}
function editar_movimiento()
{
	var id_empleado = $("#id_empleado").val();
	var id_apertura = $("#id_apertura").val();
	var turno = $("#turno").val();
	var monto = $("#monto").val();
	var concepto = $("#concepto").val();
	var id_movimiento = $("#id_movimiento").val();

	var datos = "process=editar"+"&id_apertura="+id_apertura+"&id_empleado="+id_empleado+"&turno="+turno+"&monto="+monto+"&concepto="+concepto+"&id_movimiento="+id_movimiento;

	$.ajax({
		type : "POST",
		url : "editar_movimiento_caja.php",
		data : datos,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);

			if(datax.typeinfo == "Success")
			{
				imprimir_vale(id_movimiento);
				setInterval("location.reload();", 1000);
				$('#editEModal').hide();
			}
		}
	});
}
function imprimir_vale(id_movimiento){
	var datoss = "process=imprimir"+"&id_movimiento="+id_movimiento;
	$.ajax({
		type : "POST",
		url :"agregar_ingreso_caja.php",
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

function reimprimir()
{
	var id_movimiento = $("#id_movimiento").val();
	imprimir_vale(id_movimiento);
	//$('#viewModal').hide();
	//setInterval("location.reload();", 500);
}

$("#search").click(function()
{
	var fecha1 = $("#fecha1").val();
	var fecha2 = $("#fecha2").val();
	var process = "ok";

	$.ajax({
		type:'POST',
		url:"admin_movimiento_caja.php",
		data: "process="+process+"&fecha1="+fecha1+"&fecha2="+fecha2,
		success: function(datax){
			$("#caja_x").html(datax);
		}
	});
})
