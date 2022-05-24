function round(value, decimals)
{
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}
$(document).ready(function() {

$('#formulario').validate({
	    rules: {

           	total_efectivo: {
	            required: true,
            },
        },
    	messages: {
			total_efectivo: "Por favor ingrese el monto en efectivo",
		},

        submitHandler: function (form) {
            corte();
        }
    });


  $(".decimal").numeric();
});


$(function (){
	//binding event click for button in modal form
	$(document).on("click", "#btnDelete", function(event) {
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

$("#tipo_corte").change(function()
{
	var tipo = $(this).val();
	if(tipo == "C")
	{
		$("#table_mov").attr("hidden", false);
		/*$("#table_dev").attr("hidden", true);
		$("#caja_dev").attr("hidden", true);*/
		$("#caja_mov").attr("hidden", false);
		$("#caja_cobro").attr("hidden", false);
    /*$("#table_nc").attr("hidden", true);
		$("#caja_nc").attr("hidden", true);*/
    /*$("#tabla_no_pago").attr("hidden", false);
    $("#caja_no_pago").attr("hidden", false);*/
    cambio(tipo);
		total();
	}
	else if(tipo == "X")
	{
		$("#table_mov").attr("hidden", true);
		$("#table_dev").attr("hidden", false);
		$("#caja_dev").attr("hidden", false);
		$("#caja_mov").attr("hidden", true);
		$("#table_nc").attr("hidden", false);
		$("#caja_nc").attr("hidden", false);
    $("#caja_cobro").attr("hidden", true);
    $("#tabla_no_pago").attr("hidden", true);
    $("#caja_no_pago").attr("hidden", true);
    cambio(tipo);
		total();
	}
	else if(tipo == "Z")
	{
		$("#table_mov").attr("hidden", true);
		$("#table_dev").attr("hidden", false);
		$("#caja_dev").attr("hidden", false);
		$("#caja_mov").attr("hidden", true);
		$("#table_nc").attr("hidden", false);
		$("#caja_nc").attr("hidden", false);
    $("#caja_cobro").attr("hidden", true);
    $("#tabla_no_pago").attr("hidden", true);
    $("#caja_no_pago").attr("hidden", true);
    cambio(tipo);
		total();
	}
})

function cambio(tipo)
{
  var aper_id = $("#aper_id").val();
  $.ajax({
    type:'POST',
    url:"corte_caja_diario.php",
    data: "process=cambio&tipo_corte="+tipo+"&aper_id="+aper_id,
    dataType: 'json',
    success: function(datax){
          var total_corte = datax.total_corte;
          ////////////////////////////////////
          var t_tike = datax.t_tike;
          var t_factuta = datax.t_factuta;
          var t_credito = datax.t_credito;
          ////////////////////////////////////
          var total_contado = datax.total_contado;
          var total_transferencia = datax.total_transferencia;
          var total_cheque = datax.total_cheque;
          ////////////////////////////////////
          var total_tike = datax.total_tike;
          var total_factura = datax.total_factura;
          var total_credito_fiscal = datax.total_credito_fiscal;
          ////////////////////////////////////
          var tike_max = datax.tike_max;
          var tike_min = datax.tike_min;
          var factura_max = datax.factura_max;
          var factura_min = datax.factura_min;
          var credito_fiscal_max = datax.credito_fiscal_max;
          var credito_fiscal_min = datax.credito_fiscal_min;
          ///////////////////////////////////
          var monto_apertura = datax.monto_apertura;
          var monto_ch = datax.monto_ch;
          var monto_retencion = datax.monto_retencion;



          if(tipo == 'Z' || tipo == 'X')
          {

            $("#total_corte").val(total_corte);
            var fila = "<tr><td>TIQUETE</td><td>"+tike_min+"</td><td>"+tike_max+"</td><td>"+t_tike+"</td><td>"+total_tike+"</td></tr>";
            fila += "<tr><td>FACTURA</td><td>"+factura_min+"</td><td>"+factura_max+"</td><td>"+t_factuta+"</td><td>"+total_factura+"</td></tr>";
            fila += "<tr><td>CREDITO FISCAL</td><td>"+credito_fiscal_min+"</td><td>"+credito_fiscal_max+"</td><td>"+t_credito+"</td><td>"+total_credito_fiscal+"</td></tr><tr>";
            fila += "<td colspan='4'>MONTO APERTURA</td><td><label id='id_total1'>"+monto_apertura+"</label></td></tr>";
            fila += "<tr><td colspan='4'>TOTAL</td><td><label id='id_total'>"+total_corte+"</label></td></tr>";

            var fila1 = "<tr><td><input type='text' id='total_efectivo' name='total_efectivo' value='"+total_corte+"'  class='form-control decimal decimal' readOnly></td>";
            fila1 += "<td style='text-align: center'><label id='id_total_general'>"+total_corte+"</label></td>";
            fila1 += "<td style='text-align: center'><label id='id_diferencia'>0.0</label></td></tr>";
          }
          else
          {

            var total_cobro = parseFloat($("#total_cobros").val());
            var devs =  parseFloat($("#id_total_dev").text());
            var salidas =  parseFloat($("#total_salida").val());
            var entrada = parseFloat($("#total_entrada").val());
            console.log(salidas);
            console.log(entrada);
            var total_corte1 = total_corte + entrada - (salidas + devs);
            $("#total_corte").val(total_corte1);
            var fila = "<tr><td>TIQUETE</td><td>"+tike_min+"</td><td>"+tike_max+"</td><td>"+t_tike+"</td><td>"+total_tike+"</td></tr>";
            fila += "<tr><td>FACTURA</td><td>"+factura_min+"</td><td>"+factura_max+"</td><td>"+t_factuta+"</td><td>"+total_factura+"</td></tr>";
            fila += "<tr><td>CREDITO FISCAL</td><td>"+credito_fiscal_min+"</td><td>"+credito_fiscal_max+"</td><td>"+t_credito+"</td><td>"+total_credito_fiscal+"</td></tr><tr>";
            fila += "<td colspan='4'>MONTO APERTURA</td><td><label id='id_total1'>"+monto_apertura+"</label></td></tr>";
            fila += "<td colspan='4'>MONTO CAJA CHICA</td><td><label id='id_total12'>"+monto_ch+"</label></td></tr>";
            fila += "<td colspan='4'>(-RETENCION)</td><td><label id='id_totalre'>"+monto_retencion+"</label></td></tr>";
            fila += "<tr><td colspan='4'>TOTAL</td><td><label id='id_total'>"+total_corte+"</label></td></tr>";

            var fila1 = "<tr><td><input type='text' id='total_efectivo' name='total_efectivo' value=''  class='form-control decimal decimal'></td>";
            fila1 += "<td style='text-align: center'><label id='id_total_general'>"+round(total_corte1+total_cobro,2)+"</label></td>";
            fila1 += "<td style='text-align: center'><label id='id_diferencia'>"+round(total_corte1+total_cobro,2)+"</label></td></tr>";
          }

          $("#tabla_doc").html(fila);
          $("#table_data").html(fila1);

          ////////////////////////////////////
          $("#t_tike").val(t_tike);
          $("#t_factuta").val(t_factuta);
          $("#t_credito").val(t_credito);
          ////////////////////////////////////
          $("#total_tike").val(total_tike);
          $("#total_factura").val(total_factura);
          $("#total_credito").val(total_credito_fiscal);
          ////////////////////////////////////
          $("#tike_max").val(tike_max);
          $("#tike_min").val(tike_min);
          $("#factura_max").val(factura_max);
          $("#factura_min").val(factura_min);
          $("#credito_fiscal_max").val(credito_fiscal_max);
          $("#credito_fiscal_min").val(credito_fiscal_min);
      }
  });
}

$(document).on("keyup, focusout, blur","#fecha",function(){
	var fecha=$('#fecha').val();
	dataString='process=total_sistema&fecha='+fecha;
	//alert(dataString);
	$.ajax({
				type:'POST',
				url:"corte_caja_diario.php",
				data: dataString,
				dataType: 'json',
				success: function(datax){
					var total=datax.total;
					$('#total_sistema').val(total);
					totales();
				}
			});

	totales();
});
//function to round 2 decimal places
function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    //round "original" to two decimals
	//var result=Math.round(original*100)/100  //returns value like 28.45
}
//Eventos que pueden enviar a calular totales corte de caja
$(document).on("keyup","#efectivo, #tarjeta, #cheque",function(){
  totales();
});
function totales(){
	var total_sistema=parseFloat($('#total_sistema').val());
	var efectivo=parseFloat($('#efectivo').val());
	var tarjeta=parseFloat($('#tarjeta').val());
	var cheque=parseFloat($('#cheque').val());
	var observ="";

	if (isNaN(parseFloat(efectivo))){
		efectivo=0;
	}
	if (isNaN(parseFloat(tarjeta))){
		tarjeta=0;
	}
	if (isNaN(parseFloat(cheque))){
		cheque=0;
	}
	var total_corte=efectivo+tarjeta+cheque;
	var diferencia=total_corte-total_sistema;

	var total_cortado=round(total_corte, 2);
	var	total_corte_mostrar=total_cortado.toFixed(2);

	var dif=round(diferencia, 2);
	var	dif_mostrar=dif.toFixed(2);
	if(diferencia>0){
		observ="Hay una diferencia positiva de "+dif_mostrar +" dolares";
	}
	if(diferencia<0){
		observ="Hay una diferencia negativa de "+dif_mostrar +" dolares";
	}
	$('#total_corte').val(total_corte_mostrar);
	$('#diferencia').val(dif_mostrar);
	$('#observaciones').val(observ);
}

function senddata(){
	var fecha=$('#fecha').val();
	var efectivo=$('#efectivo').val();
	var tarjeta=$('#tarjeta').val();
	var cheque=$('#cheque').val();
	var observaciones=$('#observaciones').val();
	var total_corte=$('#total_corte').val();
	var total_sistema=$('#total_sistema').val();
	var diferencia=$('#diferencia').val();
	var numero_remesa=$('#numero_remesa').val();
    //Get the value from form if edit or insert
	var process=$('#process').val();

	if(process=='insert'){
		var id_caja_chica=0;
		var urlprocess='corte_caja_diario.php';
	}

	var dataString='process='+process+'&fecha='+fecha+'&efectivo='+efectivo+'&tarjeta='+tarjeta+'&cheque='+cheque;
	dataString+='&total_corte='+total_corte+'&total_sistema='+total_sistema+'&diferencia='+diferencia+'&numero_remesa='+numero_remesa+'&observaciones='+observaciones;


	$.ajax({
		type:'POST',
		url:urlprocess,
		data: dataString,
		dataType: 'json',
		success: function(datax){
				var id_corte=datax.id_corte;
        		display_notify(datax.typeinfo,datax.msg);
				if(datax.typeinfo == "Success")
				{
					imprimir_corte(id_corte)

					setInterval("reload1();", 1000);
				}

			}
	});
}

function reload1(){
	location.href = 'admin_corte.php';
}
function deleted() {
	var id_producto = $('#id_producto').val();
	var dataString = 'process=deleted' + '&id_producto=' + id_producto;
	$.ajax({
		type : "POST",
		url : "borrar_producto.php",
		data : dataString,
		dataType : 'json',
		success : function(datax) {
			display_notify(datax.typeinfo, datax.msg);
			setInterval("location.reload();", 3000);
			$('#deleteModal').hide();
		}
	});
}

$(document).on("keyup","#total_efectivo", function()
{
	var total_corte = round(parseFloat($("#total_corte").val()),2);
	var total_efectivo = round(parseFloat($(this).val()),2);
	var total_cobros = round(parseFloat($("#total_cobros").val()),2);

		var valor = parseFloat(total_efectivo - (total_corte + total_cobros));
      $("#diferencia").val(round(valor, 2));
  		$("#id_diferencia").text(round(valor, 2));


})


function corte()
{
	var form = $("#formulario");
    var formdata = false;
    if(window.FormData)
    {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type        : 'POST',
        url         : 'corte_caja_diario.php',
        cache       : false,
        data        : formdata ? formdata : form.serialize(),
        contentType : false,
        processData : false,
        dataType : 'json',
        success: function(datax)
        {
		    display_notify(datax.typeinfo, datax.msg)
		    if(datax.typeinfo == "Success")
		    {
	          	var id_corte=datax.id_corte;
	          	imprimir_corte(id_corte)
	          	setInterval("reload1();", 1000);
		    }
	    }
    });
}

function total()
{
	var tipo_corte = $("#tipo_corte").val();
	var t_t = parseFloat($("#total_tike").val());
	var t_f = parseFloat($("#total_factura").val());
	var t_c = parseFloat($("#total_credito").val());
	var t_e_c = parseFloat($("#total_entrada").val());
	var t_s_c = parseFloat($("#total_salida").val());
	var t_dev = parseFloat($("#total_dev").val());
	var t_nc = parseFloat($("#total_nc").val());
	//console.log(t_dev);
	var m_p = parseFloat($("#monto_apertura").val());
	//var d_t = d_g + d_e;
	console.log(t_f);
	var total_all = 0;
	if(tipo_corte == "C")
	{
		var total_c = t_t + t_f + t_c + m_p + t_e_c - t_s_c ;
		total_all = round(total_c, 2);
	}
	else if(tipo_corte == "X")
	{
		var total_x = t_t + t_f + t_c  + m_p;
		total_all = round(total_x, 2);
	}
	else if(tipo_corte == "Z")
	{
		var total_z = t_t + t_f + t_c  + m_p;
		total_all = round(total_z, 2);
	}
	//alert(total_all);
  console.log(total_all);

	$("#total_corte").val(total_all);
	$("#id_total_general").text(total_all);
	$("#id_diferencia").text("-"+total_all);
	$("#id_total").text(total_all);
}

function imprimir_corte(id_corte){
	var datoss = "process=imprimir"+"&id_corte="+id_corte;
	$.ajax({
		type : "POST",
		url :"corte_caja_diario.php",
		data : datoss,
		dataType : 'json',
		success : function(datos) {
			var sist_ope = datos.sist_ope;
			var dir_print=datos.dir_print;
			var shared_printer_win=datos.shared_printer_win;
			var shared_printer_pos=datos.shared_printer_pos;

				if (sist_ope == 'win') {
					$.post("http://"+dir_print+"printcortewin1.php", {
						datosvale: datos.movimiento,
						shared_printer_win:shared_printer_win,
						shared_printer_pos:shared_printer_pos,
					})
				} else {
					$.post("http://"+dir_print+"printcorte1.php", {
						datosvale: datos.movimiento
					});
				}

		}
	});
}

function reimprimir()
{
	var id_corte = $("#id_corte").val();
	imprimir_corte(id_corte);
	$('#viewModal').hide();
	setInterval("location.reload();", 500);
}
