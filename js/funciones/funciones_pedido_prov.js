$(document).ready(function() {

	$(".cant").numeric(
		{
			decimal:false,
			negative:false,
			decimalPlaces:2,
		});
		$(".86").numeric(
			{
				negative:false,
				decimalPlaces:4,
			});

	generar1();
	$("#search").click(function()
	{
		generar1();
	});
	$(function() {
		$(".sel").select2();
		//binding event click for button in modal for

	});
	$("#cliente_buscar").typeahead({
		source: function(query, process) {
			$.ajax({
				type: 'POST',
				url: 'autocomplete_proveedor.php',
				data: 'query=' + query,
				dataType: 'JSON',
				async: true,
				success: function(data) {
					process(data);
				}
			});
		},
	});

	$("#producto_buscar").typeahead({
		source: function(query, process) {
			$.ajax({
				url: 'autocomplete_producto.php',
				type: 'POST',
				data: 'query=' + query ,
				dataType: 'JSON',
				async: true,
				success: function(data) {
					process(data);
				}
			});
		},
		updater: function(selection){
			var prod0=selection;
			var prod= prod0.split("|");
			var id_prod = prod[0];
			agregar_producto(id_prod,prod[1]);
		}
	});
	$("#producto_buscar_proceso").typeahead({
		source: function(query, process) {
			$.ajax({
				url: 'autocomplete_producto.php',
				type: 'POST',
				data: 'query=' + query ,
				dataType: 'JSON',
				async: true,
				success: function(data) {
					process(data);
				}
			});
		},
		updater: function(selection){
			var prod0=selection;
			var prod= prod0.split("|");
			var id_prod = prod[0];
			agregar_producto_proceso(id_prod,prod[1]);
		}
	});
	//check de Reservado
});
$(document).on('focus','#cliente_buscar',function(){
	$(this).val("");
});
$(document).on("click", "#btnDelete", function(event) {
	deleted();
});
//Eliminar producto de editar pedidotable
$(document).on("click", ".DeletePro", function() {
	var id_pedido_detalle = $(this).parents('tr').attr('id_pedido_detalle');
	Eliminar(id_pedido_detalle);
});
// Clean the modal form
$(document).on('hidden.bs.modal', function(e) {
	var target = $(e.target);
	target.removeData('bs.modal').find(".modal-content").html('');
});
// Agregar productos a la lista del pedido
function agregar_producto(id_prod, descrip) {
	url = $('#urlprocess').val();
	console.log(url);
	id_pedido=$('#id_pedido').val();
	var dataString = 'process=consultar_stock' + '&id_producto=' + id_prod+ '&id_pedido=' + id_pedido;

	$.ajax({
		type: "POST",
		url: url,
		data: dataString,
		dataType: 'json',
		success: function(data)
		{
			var cp = data.costop;
			var perecedero = data.perecedero;
			var select = data.select;
			var preciop = data.preciop;
			var unidadp = data.unidadp;
			var stock = data.stock;
			var descripcionp = data.descripcionp;
			var nombrep = descrip;
			var  subt = "<input type='text' class='form-control subt' readonly value='0'>";
			var unit = "<input type='hidden' class='unidad' value='" + unidadp + "'>";
			//var exis = "<input type='hidden' class='existencia' value='" + stock + "'>";
			var tr_add = "";
			tr_add += "<tr id_pedido_detalle='0'>";
			tr_add += "<td class='col-lg-1 id_p'>" + id_prod +"<in</td>";
			tr_add += "<td class='col-lg-4'>" + nombrep + "</td>";
			tr_add += "<td class='col-lg-1'>" + select + "</td>";
			tr_add += "<td class='col-lg-1 descp'>" + descripcionp + "</td>";
			tr_add += "<td class='rank_s col-lg-2'>"+data.select_rank+"</td>";
			tr_add += "<td><div class='col-xs-1'>"+unit+"<input type='text' style='width:60px;' readonly class='existencia' value='" + stock + "' ></div></td>";
			tr_add += "<td><div class='col-xs-1'><input type='text' value=''  class='form-control cant "+data.categoria+" cantaa' style='width:60px;'></div></td>";
			tr_add += "<td class='col-xs-1'>" + subt + '</td>';
			tr_add += "<td class='col-lg-1 Delete text-center'><a href='#'><i class='fa fa-trash'></i></a></td>";
			tr_add += "</tr>";
			if (id_prod != "")
			{
				$("#pedidotable").prepend(tr_add);
				$(".sel").select2();

				/*que no se vayan letras*/
				$(".precio_compra").numeric(
					{
						negative:false,
						decimalPlaces:2,
					});


						$(".cant").numeric(
							{
								decimal:false,
								negative:false,
								decimalPlaces:2,
							});
							$(".86").numeric(
								{
									negative:false,
									decimalPlaces:4,
								});
						}

						$('.datepicker').datepicker({
							format: 'yyyy-mm-dd',
							startDate: '1d'
						});
					}
				});
				totales(id_prod);
				setTimeout(function(){
				$("#pedidotable tr:first").find(".cantaa").focus();}, 200 );
			}
			$(document).on("keyup", ".cantaa", function(evt){
				if(evt.keyCode == 13)
				{
					$("#producto_buscar").focus();
				}
				totales();
			});
			//Agregar producto a lista de productos en el proceso del pedido
			function agregar_producto_proceso(id_prod, descrip) {

				var dataString = 'process=consultar_stock' + '&id_producto=' + id_prod;
				url = $('#urlprocess').val();
				$.ajax({
					type: "POST",
					url: 'procesar_pedido_prov.php',
					data: dataString,
					dataType: 'json',
					success: function(data)
					{
						var cp = data.costop;
						var perecedero = data.perecedero;
						var select = data.select;
						var preciop = data.preciop;
						var unidadp = data.unidadp;
						var stock = data.stock;
						var descripcionp = data.descripcionp;
						var nombrep = descrip;

						var  subt = "<input type='text' class='form-control subt' readonly value='0'>";
						var unit = "<input type='hidden' class='unidad' value='" + unidadp + "'>";
						//var exis = "<input type='text' class='existencia' value='" + stock + "'>";
						var tr_add = "";
						tr_add += '<tr id_pedido_detalle="0">';
						tr_add += '<td class="id_p">' + id_prod + '</td>';
						tr_add += '<td>' + nombrep + '</td>';
						tr_add += '<td>' + select + '</td>';
						tr_add += '<td class="descp">' + descripcionp + '</td>';
						tr_add += "<td class='rank_s col-lg-2'>"+data.select_rank+"</td>";
						tr_add += "<td><div class='col-xs-1'>"+unit+"<input type='text' readonly class='existencia' value='" + stock + "'  style='width:60px;'></div></td>";
						tr_add += "<td><div class='col-xs-1'><input type='text' readonly class='form-control' value=''></div></td>";
						tr_add += "<td><div class='col-xs-1'><input type='text' value=''  class='form-control cant "+data.categoria+"' style='width:60px;'></div></td>";
						tr_add += "<td class='col-xs-2'><input type='text'readonly class='form-control vence subt' readonly  value='' >'</td>";

						tr_add += '</tr>';
						if (id_prod != "")
						{
							$("#pedidotable").prepend(tr_add);
							$(".sel").select2();

							/*que no se vayan letras*/
							$(".precio_compra").numeric(
								{
									negative:false,
									decimalPlaces:2,
								});


									$(".cant").numeric(
										{
											decimal:false,
											negative:false,
											decimalPlaces:2,
										});

										$(".86").numeric(
											{
												negative:false,
												decimalPlaces:4,
											});

									}
									$('.datepicker').datepicker({
										format: 'yyyy-mm-dd',
										startDate: '1d'
									});
								}
							});
							totales(id_prod);
						}
			function validar_stock()
			{
				$("#pedidotable tr").each(function()
				{ var stock_cantidad=0;
					var stock = parseInt($(this).find(".stock").val());
					var cantidad = parseInt($(this).find(".vali_stock").val());
					if(isNaN(stock) || isNaN(cantidad))
					{
					//	$(this).find('.vali_stock').val('0');
					}
					if(cantidad>stock)
					{

						//$(this).find('.vali_stock').val(stock);
					}
				})
			}
			//Calcular Totales del grid
			function totales()
			{
				var subtotal = 0;
				var total = 0;
				var totalcantidad = 0;
				var subcantidad = 0;
				var total_dinero = 0;
				var total_cantidad = 0;
				$("#pedidotable tr").each(function()
				{
					var compra = $(this).find(".precio_compra").val();
					var unidad = $(this).find(".unidad").val();
					var venta = $(this).find(".precio_r").val();
					var cantidad = parseFloat($(this).find(".cant").val());
					cantidad=round(cantidad, 3);
					subtotal = venta * cantidad;
					subtotal=round(subtotal, 3);
					subtotal=round(subtotal, 2);
					if (isNaN(cantidad) == true)
					{
						cantidad = 0;
					}

					totalcantidad += cantidad;
					if (isNaN(subtotal) == true)
					{
						subtotal = 0;
					}
					total += subtotal;
					$(this).find('.subt').val(subtotal);

					//vence=subtotal*parseFloat(venta);
					//alert(vence);

				});
				if (isNaN(total) == true)
				{
					total = 0;
				}
				total_dinero = round(total,2);
				total_cantidad = round(totalcantidad,4);
				total_dinero = round(total,2);
				total_cantidad = round(totalcantidad,2);
				$('#total_dinero').html("<strong>" + total_dinero + "</strong>");
				$('#totcant').html(total_cantidad);

			}
			function round(value, decimals)
			{
				return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
			}
			// Evento que selecciona la fila y la elimina de la tabla
			$(document).on("click", ".Delete", function()
			{	$(this).parents("tr").remove();
			totales();
		});
		$(document).on("keyup", ".precio_compra", function() {
			totales();
		});
		$(document).on("keyup", ".vali_stock", function() {
			validar_stock();
		});
		$(document).on('keyup', '.cant', function(event)
		{
			/*fila = $(this).closest('tr');
			id_producto = fila.find('.id_p').html();
			existencia = parseInt(fila.find('.existencia').val());
			a_cant=$(this).val();
			unidad= parseInt(fila.find('.unidad').val());
			a_cant=parseInt(a_cant*unidad);

			console.log(a_cant);
			a_asignar=0;

			$('table tr').each(function(index) {

				if($(this).find('.id_p').html()==id_producto)
				{
					t_cant=parseInt($(this).find('.cant').val());
					if(isNaN(t_cant))
					{
						t_cant=0;
					}

					t_unidad=parseInt($(this).find('.unidad').val());
					t_cant=parseInt((t_cant*t_unidad));
					a_asignar=a_asignar+t_cant;
					a_asignar=parseInt(a_asignar);
				}
			});
			console.log(existencia);
			console.log(a_asignar);

			if(a_asignar>existencia)
			{
				val = existencia-(a_asignar-a_cant);
				val = val/unidad;
				val=Math.trunc(val);
				val =parseInt(val);
				$(this).val(val);
			}

			id_presentacion_p = fila.find('.sel').val();
			tr = $(this).closest('tr');
			//Ranking de precios
			$.ajax({
					type:'POST',
					url:'venta.php',
					data:'process=cons_rank&id_producto='+id_producto+'&id_presentacion='+id_presentacion_p+'&cantidad='+a_cant,
					dataType:'JSON',
					success:function(datax)
					{
						tr.find(".rank_s").html(datax.precios);
					}
			});
			setTimeout(function(){ totales(); }, 300);
			*/
		});
		$(document).on("click", "#submit1", function()
		{
			//$('#submit1').attr('disabled', true);
			senddata();
		});
		$(document).on("click", "#submit2", function()
		{
			//$('#submit1').attr('disabled', true);
			procesar();
		});
		function senddata()
		{
			//Calcular los valores a guardar de cada item del inventario
			var i = 0;
			var error  = false;
			var datos = "";
			var id = $("select#tipo_entrada option:selected").val(); //get the value
			if($("#pedidotable tr").length < 1 )
			{
				error = true;
			}
			$("#pedidotable tr").each(function()
			{
				var id_pedido_detalle = $(this).attr("id_pedido_detalle");
				var id_prod = $(this).find(".id_p").text();
				var id_presentacion = $(this).find(".sel").val();
				var compra = $(this).find(".precio_compra").val();
				var unidad = $(this).find(".unidad").val();
				var venta = $(this).find(".precio_r").val();
				var cant = $(this).find(".cant").val();
				var subtotal = $(this).find(".subt").val();
				if (venta!="" && parseFloat(venta) > 0 && cant != "" && parseInt(cant)>0)
				{
					datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|"  + subtotal + "|" + id_presentacion + "|"+ id_pedido_detalle + "#";
					i = i + 1;
				}
				else
				{
					error = true;
				}
			});
			var clientedata = $('#cliente_buscar').val();
			var cliented= clientedata.split('|');
			var id_cliente=cliented[0];
			var total = $('#total_dinero').text();
			var fecha_mo = $('#fecha').val();
			var fecha_e = $('#fecha2').val();
			var processo = $('#processo').val();
			var url = $('#urlprocess').val();
			var id_pedido = $('#id_pedido').val();
			if(id_cliente!="")
			{
				if(fecha_mo!="" && fecha_e!="")
				{
					var dataString =
					{
						'process': processo,
						'datos': datos,
						'cuantos': i,
						'total': total,
						'fecha_m': fecha_mo,
						'fecha_e': fecha_e,
						'id_cliente': id_cliente,
						'id_pedido': id_pedido,

					}
					if (!error)
					{
						$.ajax({
							type: 'POST',
							url: url,
							data: dataString,
							dataType: 'json',
							success: function(datax)
							{
								display_notify(datax.typeinfo, datax.msg);
								if(datax.typeinfo == "Success")
								{
									setInterval("reload1();", 1000);
								}
							}
						});
					}
					else
					{
						display_notify('Warning', 'Falta completar algun valor de precio o cantidad!');
					}
				}else
				{
					display_notify('Warning', 'Las fechas Son requeridas!');

				}
			}else{
				display_notify('Warning', 'Verifique  cliente!');

			}

		}
		function procesar()
		{
			//Calcular los valores a guardar de cada item del inventario
			var i = 0;
			var error  = false;
			var datos = "";
			$("#pedidotable tr").each(function()
			{ var id_pedido_detalle = $(this).attr("id_pedido_detalle");
				var id_prod = $(this).find(".id_p").text();
				var id_presentacion = $(this).find(".sel").val();
				var compra = $(this).find(".precio_compra").val();
				var unidad = $(this).find(".unidad").val();
				var venta = $(this).find(".precio_r").val();
				var cant = $(this).find(".cant").val();
				var subtotal = $(this).find(".subt").val();
				if (venta!="" && parseFloat(venta) > 0 && cant != "" && parseInt(cant)>-1)
				{
					datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + subtotal + "|" + id_presentacion + "|"+ id_pedido_detalle +"|"+ unidad + "#";
					i = i + 1;

				}
				else
				{
					error = true;

				}
			});
			var clientedata = $('#cliente_buscar').val();
			var cliented= clientedata.split('|');

			var id_cliente=cliented[0];
			var total = $('#total_dinero').text();
			var lugar_entrega = $('#lugar_entrega').val();
			var fecha_mo = $('#fecha').val();
			var fecha_e = $('#fecha2').val();
			var id_pedido = $('#id_pedido').val();
			var reservado = $('#reservado').val();
			if(id_cliente!="" & lugar_entrega!="")
			{
				if(fecha_mo!="" & fecha_e!="")
				{
					var dataString =
					{
						'process': 'procesar_pedido',
						'datos': datos,
						'cuantos': i,
						'total': total,
						'fecha_m': fecha_mo,
						'fecha_e': fecha_e,
						'id_cliente': id_cliente,
						'lugar_entrega': lugar_entrega,
						'id_pedido': id_pedido,
						'reservado':reservado,

					}
					if (!error)
					{
						$.ajax({
							type: 'POST',
							url: 'procesar_pedido_prov.php',
							data: dataString,
							dataType: 'json',
							success: function(datax)
							{
								display_notify(datax.typeinfo, datax.msg);
								if(datax.typeinfo == "Success")
								{
									swal({
				              title: "Exito",
				              text: "Referencia numero: "+datax.referencia+", presione OK para continuar.",
				              type: "warning",
				              showCancelButton: false,
				              confirmButtonColor: '',
				              confirmButtonText: 'OK',
				              closeOnConfirm: false,
				              closeOnCancel: true
				           }, function(isConfirm) {
				             if (isConfirm){
				               setInterval("reload1();", 1000);
				              } else {
				              }

				           });
								}
							}
						});
					}
					else
					{
						display_notify('Warning', 'Falta completar algun valor de precio o cantidad!');
					}
				}else
				{
					display_notify('Warning', 'Las fechas Son requeridas!');

				}
			}else{
				display_notify('Warning', 'Verifique  cliente o lugar de entretaga!');

			}
		}


		function reload1()
		{
			location.href = "admin_pedidos_prov.php";
		}
		function anular() {
			var id_pedido = $('#id_pedido').val();
			var dataString = 'process=anular' + '&id_pedido=' + id_pedido;
			$.ajax({
				type: "POST",
				url: "anular_pedido_prov.php",
				data: dataString,
				dataType: 'json',
				success: function(datax){
					display_notify(datax.typeinfo, datax.msg);
					setInterval("reload1();", 1000);
					$('#deleteModal').hide();
				}
			});
		}
		function deleted() {
			var id_pedido_prov = $('#id_pedido_prov').val();
			var dataString = 'process=deleted' + '&id_pedido_prov=' + id_pedido_prov;
			$.ajax({
				type: "POST",
				url: "borrar_pedido_prov.php",
				data: dataString,
				dataType: 'json',
				success: function(datax)
				{
					display_notify(datax.typeinfo, datax.msg);
					if(datax.typeinfo == "Success")
					{
						setInterval("reload1();", 1000);
						$("#cerrr").click();
					}
				}
			});
		}
		//eliminar producto de pedido
		function Eliminar(id_pedido_detalle) {
			//alert(id_pedido_detalle);
			var dataString = 'process=eliminar_pro'+'&id_pedido_detalle='+id_pedido_detalle;
			$.ajax({
				type: "POST",
				url: "editar_pedido_prov.php",
				data: dataString,
				dataType: 'json',
				success: function(datax){
					$("#pedidotable tr").each(function(){
						if($(this).attr("id_pedido_detalle") == id_pedido_detalle)
						{
							$(this).remove();
							totales();
						}
					});
				}
			});
		}
		$(document).on('change', '.sel', function(event)
		{
			var id_presentacion = $(this).val();
			console.log(id_presentacion);
			var a = $(this).parents("tr");
			$.ajax({
				url: 'preventa.php',
				type: 'POST',
				dataType: 'json',
				data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion,
				success: function(data)
				{
					a.find('.descp').html(data.descripcion);
					a.find('.precio_compra').val(data.costo);
					a.find('.unidad').val(data.unidad);
					a.find('.precio_compra').val(data.costo);
					a.find('.unidad').val(data.unidad);
					a.closest('tr').find(".rank_s").html(data.select_rank);

					fila = a;
					id_producto = fila.find('.id_p').val();
					existencia = parseInt(fila.find('.existencia').val());
					a_cant=parseInt(fila.find('.cant').val());
					unidad= parseInt(fila.find('.unidad').val());

					a_cant=parseInt(a_cant*data.unidad);
					console.log(a_cant);

					a_asignar=0;

					$('table tr').each(function(index) {

						if($(this).find('.id_producto').val()==id_producto)
						{
							t_cant=parseInt($(this).find('.cant').val());
							if(isNaN(t_cant))
							{
								t_cant=0;
							}
							t_unidad=parseInt($(this).find('.unidad').val());
							t_cant=parseInt((t_cant*t_unidad));
							a_asignar=a_asignar+t_cant;
							a_asignar=parseInt(a_asignar);
						}
					});
					console.log(existencia);
					console.log(a_asignar);

					if(a_asignar>existencia)
					{
						val = existencia-(a_asignar-a_cant);
						val = val/unidad;
						val=Math.trunc(val);
						val =parseInt(val);
						fila.find('.cant').val(val);
					}
				}
			});
			setTimeout(function() {
				totales();
			}, 1000);
		});
		function generar1()
		{
			var fini = $("#fini").val();
			var fin = $("#fin").val();
			dataTable = $('#editable2').DataTable().destroy()
			dataTable = $('#editable2').DataTable({
				"pageLength": 50,
				"order":[[ 0, 'desc' ]],
				"processing": true,
				"serverSide": true,
				"ajax":{
					url :"admin_pedido_prov_dt.php?fini="+fini+"&fin="+fin,
					error: function()
					{  // error handling
						$(".editable2-error").html("");
						$("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="7">No se encontró información segun busqueda </th></tr></tbody>');
						$("#editable2_processing").css("display","none");
						$( ".editable2-error" ).remove();
					}
				},
				"columnDefs": [ {
					"targets": 3,//index of column starting from 0
					"render": function ( data, type, full, meta ) {
						if(data!=null)
						return '<p class="text-success"><strong>'+data+'</strong></p>';
						else
						return '';
					}
				}],
				"language":{
					"url": "js/Spanish.json"
				}
			});
			dataTable.ajax.reload()
		}
//modal para las scroll
