var dataTable ="";
$(document).ready(function() {
	// Clean the modal form
	$(document).on('hidden.bs.modal', function(e) {
		var target = $(e.target);
		target.removeData('bs.modal').find(".modal-content").html('');
	});
	generar();
});
function generar(){
	fechai=$("#fecha_inicio").val();
	fechaf=$("#fecha_fin").val();
	dataTable = $('#editable2').DataTable().destroy()
	dataTable = $('#editable2').DataTable( {
			"pageLength": 50,
			"order":[[ 0, 'desc' ]],
			"processing": true,
			"serverSide": true,
			"searching": false,
			"ajax":{
					url :"admin_compra_dt.php?fechai="+fechai+"&fechaf="+fechaf, // json datasource
					//url :"admin_factura_rangos_dt.php", // json datasource
					//type: "post",  // method  , by default get
					error: function(){  // error handling
						$(".editable2-error").html("");
						$("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="3">No se encontró información segun busqueda </th></tr></tbody>');
						$("#editable2_processing").css("display","none");
						$( ".editable2-error" ).remove();
						}
					},

				} );

		dataTable.ajax.reload()
	//}
}
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
$(document).on("click", "#btnMostrar", function(event) {
	generar();
});
