$(document).ready(function() {

//validar los campos del form
/*if($("#process").val() == "editar")
{
	var tipo = $("#tipo_sucursal").val();
	if(tipo == 0)
	{
		$("#com_doc").attr("hidden", false);
		$("#com_ven").attr("hidden", true);
		$("#com_ven").val("0");
	}
	else if(tipo == 1)
	{
		$("#com_doc").attr("hidden", true);
		$("#com_ven").attr("hidden", false);
		$("#com_doc").val("0");
	}
	else if(tipo != 0 && tipo != 1)
	{
		$("#com_doc").attr("hidden", true);
		$("#com_ven").attr("hidden", true);
	}
}*/
$('#formulario').validate({
	    rules: {
				nombre:
				{
					required: true,
				},
				iva:
				{
					required: true,
				},
				razon:
				{
					required: true,
				},
				direccion:
				{
					required: true,
				},
				telefono1:
				{
					required: true,
				},
				nit:
				{
					required: true,
				},
				nrc:
				{
					required: true,
				},
				giro:
				{
					required: true,
				},
				monto_retencion1:
				{
					required: true,
				},
				monto_retencion10:
				{
					required: true,
				},
				monto_percepcion:
				{
					required: true,
				},
				n_sucursal:
				{
					required:true,
					number:true,
				}
                 },
                messages: {
									empresa: "Por favor ingrese el nombre de la empresa",
									iva: "Por favor ingrese el valor del iva",
									razon: "Ingrese una razon social",
									direccion: "Ingrese la direccion de la empresa",
									telefono1: "Ingrese un numero de telefono",
									nit: "Ingrese el NIT de la empresa",
									nrc: "Ingrese el NRC de la empresa",
									giro: "Ingrese el giro de la empresa",
									monto_retencion1: "Ingrese el monto inicial de retencion del 1%",
									monto_retencion10: "Ingrese el monto inicial de retencion del 10%",
									monto_percepcion: "Ingrese el monto inicial de percepcion",
									n_sucursal:"Agregue el número de sucursal",
				},
                highlight: function(element) {
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},
				success: function(element) {
					$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				},
        submitHandler: function (form) {
            senddata();
        }
    });

//$("#comision").numeric();
//$(".select").select2();

});

$(function (){
	//binding event click for button in modal form
	/*$(document).on("click", "#btnDelete", function(event) {
		deleted();
	});*/
	// Clean the modal form
	/*$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});*/
	/*
	$(document).on("change","#tipo_sucursal", function()
	{
		var tipo_sucursal = $(this).val();
		if(tipo_sucursal == 0)
		{
			$("#com_doc").attr("hidden", false);
			$("#com_ven").attr("hidden", true);
			$("#com_ven").val("0");
		}
		else if(tipo_sucursal == 1)
		{
			$("#com_doc").attr("hidden", true);
			$("#com_ven").attr("hidden", false);
			$("#com_doc").val("0");
		}
		else if(tipo_sucursal != 0 && tipo_sucursal != 1)
		{
			$("#com_doc").attr("hidden", true);
			$("#com_ven").attr("hidden", true);
		}
		console.log(tipo_sucursal);
	})
	*/
});


/*
function senddata(){
	var nombre=$('#nombre').val();
  var direccion=$('#direccion').val();
  var casa=$('#casa:checked').val();
	var comision = $("#comision").val();
	var comision_doc = $("#comision_doc").val();
	var tipo_sucursal = $("#tipo_sucursal").val();



    //Get the value from form if edit or insert
	var process=$('#process').val();

    if(process=='insert'){
		var id_sucursal=0;
		var urlprocess='agregar_sucursal.php';
	 }

	if(process=='edited'){
		var id_sucursal=$('#id_sucursal').val(); ;
		var urlprocess='editar_sucursal.php';
	}

	var dataString='process='+process+'&id_sucursal='+id_sucursal+'&nombre='+nombre+'&direccion='+direccion+'&casa='+casa+"&comision="+comision;
	//alert(dataString);
			$.ajax({
				type:'POST',
				url:urlprocess,
				data: dataString,
				dataType: 'json',
				success: function(datax){
					process=datax.process;
					display_notify(datax.typeinfo,datax.msg);
					setInterval("reload1();", 1000);

				}
			});
}*/
function senddata()
{
		var process = $("#process").val();
		var a = $("#id_sucursale").val();
		if(process == "insert")
		{
			var url = 'admin_empresa.php';
		}
		else if(process == "editar")
		{
			var url = 'admin_empresa.php';
		}
    var form = $("#formulario");
    var formdata = false;
    if(window.FormData)
    {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type        : 'POST',
        url         : url,
        cache       : false,
        data        : formdata ? formdata : form.serialize(),
        contentType : false,
        processData : false,
        dataType : 'json',
        success: function(data)
        {
					display_notify(data.typeinfo,data.msg,data.process);
					if(data.typeinfo == "Success")
					{
						setInterval("reload1();", 1000);
					}
	    	}
    });
}

function reload1(){
	location.href = 'admin_empresa.php';
}
/*
function deleted() {
	var id_sucursal = $('#id_sucursal').val();
	var dataString = 'process=deleted' + '&id_sucursal=' + id_sucursal;
	$.ajax({
		type : "POST",
		url : "borrar_sucursal.php",
		data : dataString,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			setInterval("location.reload();", 1000);
			$('#deleteModal').hide();
		}
	});
}*/
$('.tel').on('keydown', function (event)
 {
	 if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39)
	 {
	 }
	 else
	 {
		 inputval = $(this).val();
		 var string = inputval.replace(/[^0-9]/g, "");
		 var bloc1 = string.substring(0,4);
		 var bloc2 = string.substring(4,7);
		 var string = (bloc1 + "-" + bloc2);
		 $(this).val(string);
				 }
 });
 $('#nrc').on('keydown', function(event) {
	 if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

	 } else {
		 if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
			 inputval = $(this).val();
			 var string = inputval.replace(/[^0-9]/g, "");
			 var bloc1 = string.substring(0, 8);
			 var bloc2 = string.substring(8, 8);
			 var string = bloc1 + "-" + bloc2;
			 $(this).val(string);
		 } else {
			 event.preventDefault();
		 }

	 }
 });
 $('#nit').on('keydown', function(event) {
	 if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {

	 } else {
		 if ((event.keyCode > 47 && event.keyCode < 60) || (event.keyCode > 95 && event.keyCode < 106)) {
			 inputval = $(this).val();
			 var string = inputval.replace(/[^0-9]/g, "");
			 var bloc1 = string.substring(0, 4);
			 var bloc2 = string.substring(4, 10);
			 var bloc3 = string.substring(10, 13);
			 var bloc4 = string.substring(13, 13);
			 var string = bloc1 + "-" + bloc2 + "-" + bloc3 + "-" + bloc4;
			 $(this).val(string);
		 } else {
			 event.preventDefault();
		 }

	 }
 });
