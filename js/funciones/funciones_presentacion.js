$(document).ready(function() {
	//validar los campos del form
	$('#formulario').validate({
		rules: {
			nombre: {
				required: true,
			},
		},
		messages: {
			nombre: "Por favor ingrese un nombre",
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
});
$(function (){
	//binding event click for button in modal form
	$(document).on("click", "#btnDelete", function(event) {
		deleted();
	});
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});
});

function senddata(){
	var name=$('#nombre').val();
	var description=$('#descripcion').val();

	//Get the value from form if edit or insert
	var process=$('#process').val();

	if(process=='insert')
	{
		var id_presentacion=0;
		var urlprocess='agregar_presentacion.php';
	}

	if(process=='edited')
	{
		var id_presentacion=$('#id_presentacion').val(); ;
		var urlprocess='editar_presentacion.php';
	}
	var dataString='process='+process+'&id_presentacion='+id_presentacion+'&nombre='+name+'&descripcion='+description;
	//alert(dataString);
	$.ajax({
		type:'POST',
		url:urlprocess,
		data: dataString,
		dataType: 'json',
		success: function(datax){
			process=datax.process;
			display_notify(datax.typeinfo,datax.msg);
			if(datax.typeinfo == "Success")
			{
				setInterval("reload1();", 1000);
			}
		}
	});
}
function reload1(){
	location.href = 'admin_presentacion.php';
}
function deleted() {
	var id_presentacion = $('#id_presentacion').val();
	var dataString = 'process=deleted' + '&id_presentacion=' + id_presentacion;
	$.ajax({
		type : "POST",
		url : "borrar_presentacion.php",
		data : dataString,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			setInterval("location.reload();", 500);
			$('#deleteModal').hide();
		}
	});
}
