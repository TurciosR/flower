$(document).ready(function() {

	$('#formulario').validate({
		// Validate fields of form

		rules : {
			email : {
				email : true,
				required : true
			},
			password : {
				minlength : 6,
				required : true
			},
			name : {
				minlength : 3,
				required : true
			},
			business : {
				minlength : 3,
				required : true
			},
			website : {
				minlength : 3,
				required : false
			},
			contact_emails : {
				minlength : 3,
				required : true
			},
			administration : {
				minlength : 3,
				required : false
			},
			sales : {
				minlength : 3,
				required : false
			},
			accounting : {
				minlength : 3,
				required : false
			},
			days : {
				number : true,
				maxlength : 3,
				required : false
			},
			paypal_email : {
				email : true,
				required : false
			},
		},
		submitHandler : function(form) {
			// execute senddata function
			senddata();
		}
	});

	
})
$(function() {
	//binding event click for button in modal form
	$(document).on("click", "#btnDelete", function(event) {
		deleted();
	});
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});
	
	//spinner for priority
	 var min=1;
	  var max=50;
	$('.spinner .btn:first-of-type').on('click', function() {
	    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
	    if ( $('.spinner input').val()<1){
			$('.spinner input').val(1);
		}
	    
	  });
	  $('.spinner .btn:last-of-type').on('click', function() {
	    $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
	    if ( $('.spinner input').val()>50){
			$('.spinner input').val(50);
		}
	    
	  });
	  
	 

	if ( $('.spinner input').val()<1){
		$('.spinner input').val(1);
	}
	if ( $('.spinner input').val()>50){
		$('.spinner input').val(50);
	}

});	




function deleted() {
	var id_menu = $('#id_op').val();
	// Function to confirm delete
	var dataString = 'process=deleted' + '&id_menu=' + id_menu;	
			$.ajax({
				type : "POST",
				url : "menu.delete.php",
				data : dataString,
				dataType : 'json',
				success : function(datax) {
					display_notify(datax.typeinfo, datax.msg);
					setInterval("location.reload();", 3000);
					$('#deleteModal').hide(); 
				}
			});			
}
function senddata(){	
	//Get the values from form by with jquery
	// and send to script via ajax, in php process by _POST 
	var id_menu=$('#id_menu').val();
	var name=$('#name').val(); 
	var priority=0;
	
	$('#spinPriority').on("valueChanged", function (e) {
		alert(e.value);
		priority=e.value;
	});
	
	if(process=='insert'){
		var urlprocess='menu.add.php';
	}	
	if(process=='edited'){
		var urlprocess='menu.edit.php';
	}	
	if(id_menu=='undefined'){
		id_menu=0;
	}		
	var dataString='process='+process+'&id_menu='+id_menu+'&name='+name+'&priority='+priority;

		$.ajax({
			type:'POST',
			url: urlprocess,
			data: dataString,			
			dataType: 'json',
			success: function(datax)
			{		//if execute the script in php get one value in json and execute another function	 																		
				display_notify(datax.typeinfo,datax.msg,process);
					
			}
		});	
		
}
