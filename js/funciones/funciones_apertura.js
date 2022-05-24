$(document).ready(function(){
	$( ".datepick" ).datepicker();
	$(".select").select2();
	$(".numeric").numeric({
		negative: false,
	});

	$('#formulario').validate({
	    rules: {
            fecha:
            {
            	required: true,
            },
            empleado:
            {
                required: true,
            },
            turno:
            {
            	required: true,
            },
            monto_apertura:
            {
            	required: true,
            },
         },
        messages: {
		fecha: "Por favor ingrese la fecha de apertura",
		empleado: "Por favor seleccione el empleado",
		turno: "Por favor seleccione el turno",
		monto_apertura: "Ingrese el monto de apertura",
		/*
		password: {
			required: "Por favor ingrese su password",
			minlength: "Su password debe de tener como minimo 5 caracteres"
		*/
		},

        submitHandler: function (form) {
            apertura();
        }
    });
});

function apertura()
{
	var form = $("#formulario");
    var formdata = false;
    if(window.FormData)
    {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
		var caja = $("#caja").val();
		if(caja != "" && caja != 0)
		{
			$.ajax({
	        type        : 'POST',
	        url         : 'apertura_caja.php',
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
		else
		{
				display_notify("Error", "Debe de seleccionar una caja");
		}

}

function reload1()
{
	location.href = 'admin_corte.php';
}
