$(document).ready(function() {
  generar();

  $('#minimo').numeric({
    negative: false,
    decimal: false
  });
  $('#unidad_pre').numeric({
    negative: false,
    decimal: false
  });
  $('#precio_pre').numeric({
    negative: false,
    decimalPlaces: 4
  });
  $('#costo_pre').numeric({
    negative: false,
    decimalPlaces: 4
  });
  $('#id_categoria').select2();
  $('#id_proveedor').select2();
  $(".select2").select2({
    placeholder: {
      id: '',
      text: 'Seleccione',
    },
    allowClear: true,
  });
});
$(function() {
  //binding event click for button in modal form
  $(document).on("click", "#btnDelete", function(event) {
    deleted();
  });
  // Clean the modal form
  // $(document).on('hidden.bs.modal', function(e) {
  //   var target = $(e.target);
  //   target.removeData('bs.modal').find(".modal-content").html('');
  // });

  $(document).on("click", "#add_p", function(event) {
    valor = $("#pr").val();
    unidad_pre =$("#un").val();
    val="";
    $("#presentacion_table tr").each(function() {
      var id_pp = $(this).find(".presentacion").val();
      if (id_pp == valor) {
        if (unidad_pre == $(this).find(".unidad_p").text()) {
          a=$(this).closest('tr');

          $("#precios>tbody tr").each(function() {
            val+=$(this).find("td:eq(0)").text()+"|"+$(this).find("td:eq(1)").text()+"|"+$(this).find("td:eq(2)").text()+"#";
          });
          a.find(".precios_pre").val(val);
        }
      }

    });
    $(".close").click();
  });

});

$(document).on("click", "#btn_img", function()
{
	$('#viewProducto').modal({backdrop: 'static',keyboard: false});
});
$("#btnGimg").click(function()
{
	$("#cerrar_ven").click();
});

function generar() {
  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    "pageLength": 50,
    "order": [
      [0, 'asc'],
      [1, 'asc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_producto_dt.php",

      error: function() { // error handling
        //$(".editable2-error").html("");
        $("#editable2").append('<tbody class="editable2_grid-error"><tr><th colspan="3">No se encontró información segun busqueda </th></tr></tbody>');
        $("#editable2_processing").css("display", "none");
        $(".editable2-error").remove();
      }
    },
    "columnDefs": [{
      "targets": 1, //index of column starting from 0
      "render": function(data, type, full, meta) {
        if (data != null)
          return '<p class="text-success"><strong>' + data + '</strong></p>';
        else
          return '';
      }
    }]
  });

  dataTable.ajax.reload()
}

$(document).on('click', '#submit1', function(event) {
  var descripcion = $('#descripcion').val();
  var proveedor = $('#proveedor').val();
  var id_categoria = $('#id_categoria').val();

  if(descripcion!="")
  {
    if(proveedor!="")
    {
      if(id_categoria!="")
      {
        senddata();
      }
      else
      {
        display_notify("Error","Falta seleccionar una categoria");

      }
    }
    else
    {
      display_notify("Error","Falta seleccionar el proveedor");

    }
  }
  else
  {
    display_notify("Error","Falta la descripcion");

  }
});


function senddata()
{
  //var name=$('#name').val();
  if ($("#presentacion_table tr").length > 0) {
    var minimo = $('#minimo').val();
    var descripcion = $('#descripcion').val();
    var barcode = $('#barcode').val();
    var proveedor = $('#proveedor').val();
    var marca = $('#marca').val();
    var id_categoria = $('#id_categoria').val();
    var lista = "";
    var cuantos = 0;
    err=0;

    var process = $('#process').val();
    var process2 = $('#process').val();
    var perecedero = $('#perecedero:checked').val();
    var exento = $('#exento:checked').val();
    var decimals = $('#decimal:checked').val();


    console.log(process);
    if (process == 'insert') {
      var id_producto = 0;
      var urlprocess = 'agregar_producto.php';
    }
    if (process == 'edited') {
      var estado = $('#activo:checked').val();
      if (estado == undefined) {
        estado = 0;
      } else {
        estado = 1;
      }
      var id_producto = $('#id_producto').val();
      var urlprocess = 'editar_producto.php';
    }
    $("#presentacion_table tr").each(function() {
			var exis = $(this).attr("class");
      var id_pp = $(this).find(".presentacion").val();
      var des = $(this).find(".descripcion_p").html();
      var unidad_p = $(this).find(".unidad_p").html();
      var precio_p = 0;
      var costo = $(this).find(".costo").html();
      var bar =$(this).find(".bar").html();
        precios_pre=""
        for (var l = 0; l < 7; l++) {
          va=".precio"+l;
          numv=$(this).find($(va)).text();

          if (isNaN(parseFloat(numv))) {
            numv=0.00;
          }
          precios_pre+=numv+"#";
        }


			if(exis == 'exis')
		 	{
		 		var id_prp = $(this).find(".id_pres_prod").val();
		 	}
		 	else
		 	{
		 		var id_prp = 0;
		 	}

      if (precios_pre!="") {
        lista += id_pp + "," + des + "," + unidad_p + "," + precio_p + "," + id_prp + "," + costo + "," + bar+"," + precios_pre+";";
        cuantos += 1;
      }
      else
      {
        err=1;
      }
    });
    var dataString = 'process=' + process + '&id_producto=' + id_producto + '&barcode=' + barcode + '&descripcion=' + descripcion;
    dataString += '&exento=' + exento + '&proveedor=' + proveedor + '&id_categoria=' + id_categoria + '&perecedero=' + perecedero + '&lista=' + lista;
    dataString += '&marca=' + marca + '&minimo=' + minimo + '&cuantos=' + cuantos + '&estado=' + estado + '&decimals=' + decimals;
    if(err==0)/**/
    {
      $.ajax({
        type: 'POST',
        url: urlprocess,
        data: dataString,
        dataType: 'json',
        success: function(datax) {
          process = datax.process;
          id_producto2 = datax.id_producto;
          //var maxid=datax.max_id;
          //display_notify(datax.typeinfo, datax.msg);

          if (datax.typeinfo == "Success")
          {
            // setInterval("reload1();", 1000);

            if(process2 == 'edited')
      		 	{
              console.log("OK");
              // $("#id_id_p").val(datax.id_producto);
              editar_img();
      		 	}
      		 	if (process2 == 'insert')
      		 	{
              //display_notify(datax.typeinfo, datax.msg);
              $("#id_id_p").val(datax.id_producto);
              img();
      		 	}
          }
        }
      });
    }
    else
    {
      display_notify("Warning", "Debe ingresar al menos un precio");
    }

  } else {
    display_notify("Warning", "Debe ingresar al menos una presentacion");
  }
}

function reload1() {
  location.href = 'admin_producto.php';
}

$(document).on('click', '.elmpre', function(event) {

  var tr = $(this).parents("tr").find('.id_pres_prod').val();

  console.log(tr);

  swal({
    title: "¿Esta seguro?",
    text: "Esto eliminara esta presentacion de manera permanente",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '',
    confirmButtonText: 'Borrar',
    cancelButtonText: 'Cancelar',
    closeOnConfirm: false,
    closeOnCancel: true
  }, function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: 'editar_producto.php',
        type: 'POST',
        dataType: 'json',
        data: {
          process: "borrar_presentacion",
          id_presentacion: tr
        },
        success: function(datax) {
          if (datax.typeinfo == "Success") {
            display_notify(datax.typeinfo, datax.msg);
            setInterval("location.reload()", 1000);
          }
          else {
            display_notify(datax.typeinfo, datax.msg);
          }
        }
      });
    } else {}

  });
});
$(document).on("click", ".deactive", function(){
	var id = $(this).attr("id");
	var td = $(this).parents("td");
	var tr = $(this).parents("tr");
	var fila = "<a class='activate' id='"+id+"'><i class='fa fa-eye-slash'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a>";
	$.ajax({
		type: 'POST',
		url: 'editar_producto.php',
		data: 'process=deactive&id_pres='+id,
		dataType: 'JSON',
		success : function(datax)
		{
			if(datax.typeinfo == "Success")
			{
				tr.css('background',  '#CDCDCD');
				td.html(fila);
			}
			else
			{
				display_notify("Error", "Ocurrio un error inesperado, intente nuevamente");
			}
		}
	});
});

$(document).on("click", ".activate", function(){
	var id = $(this).attr("id");
	var tr = $(this).parents("tr");
	var td = $(this).parents("td");
	var fila = "<a class='deactive' id='"+id+"'><i class='fa fa-eye'></i></a> <a class='elmpre' title='Eliminar'><i class='fa fa-times iconsa'></i></a>";
	$.ajax({
		type: 'POST',
		url: 'editar_producto.php',
		data: 'process=active&id_pres='+id,
		dataType: 'JSON',
		success : function(datax)
		{
			if(datax.typeinfo == "Success")
			{
				tr.css('background', '#BDECB6');
				td.html(fila);
			}
			else
			{
				display_notify("Error", "Ocurrio un error inesperado, intente nuevamente");
			}
		}
	});
});
function deleted() {
  var id_producto = $('#id_producto').val();
  var dataString = 'process=deleted' + '&id_producto=' + id_producto;
  $.ajax({
    type: "POST",
    url: "borrar_producto.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      setInterval("location.reload();", 1000);
      $('#deleteModal').hide();
    }
  });
}
$(document).on("click", "#btnAgregar", function() {
  $.ajax({
    type: "POST",
    url: "agregar_producto.php",
    data: "process=lista",
    dataType: 'json',
    success: function(datax) {

    }
  });
})
$(document).on("click", ".Delete", function() {
  $(this).parents("tr").remove();
});

$(document).on("click", "#add_pre", function() {
  $(this).attr('disabled', 'disabled');
  setTimeout("",1500);
  btn = $(this);
  var id_producto = $("#id_producto").val();
  var id_presentacion = $("#id_presentacion").val();
  var desc_pre = $("#desc_pre").val();
  var unidad_pre = $("#unidad_pre").val();
  var precio_pre = $("#precio_pre").val();
  var costo_p = $("#costo_pre").val();
  //alert(costo_p);
  //procedemos a calcular el precio1
  var iva = 0;
  var utilidad = 0;
  $.ajax({
    url: 'agregar_producto.php',
    type: 'POST',
    dataType: 'json',
    async: false,
    data: "process=impuestos",
    success:  function(datax)
    {
      //console.log(datax);
      iva = datax.iva;
      utilidad = datax.utilidad;
    }
  });
  //alert(iva);

  var ivaV = (parseFloat(costo_p)*iva);
  var utilidadV = (parseFloat(costo_p)*utilidad);
  var precio1 = (parseFloat(costo_p))+ivaV+utilidadV;
  var valor = $("#id_presentacion").val();
  var bar=$("#bar").val();
  var proceso=$("#process").val();
  if (id_presentacion != "" && desc_pre != "" && unidad_pre != "" && valor != "") {
    var exis = false;
    $("#presentacion_table tr").each(function() {
      var id_pp = $(this).find(".presentacion").val();
      console.log(id_pp);
      console.log(valor);
      if (id_pp == valor) {
        if (unidad_pre == $(this).find(".unidad_p").text()) {
          exis = true;
        }
      }

    });
    if (exis)
		{
      display_notify("Warning", "Ya agrego una presentacion con estas caracteristicas");
      btn.removeAttr('disabled');

    } else {
      if(proceso=="insert")
      {
        var text_select = $("#id_presentacion option:selected").html();
        var fila = "<tr>";
        fila += "<td class='bar'>" + bar + "</td>";
        fila += "<td><input type='hidden' class='presentacion' value='" + valor + "'>"+"<input type='hidden' class='precios_pre' value='" + "" + "'>" + text_select + "</td>";
        fila += "<td class='descripcion_p'>" + desc_pre + "</td>";
        fila += "<td class='unidad_p'>" + unidad_pre + "</td>";
        fila += "<td class='costo'>" + costo_p + "</td>";

        fila += "<td class='ed precio0'>" + precio1.toFixed(2) + "</td>";
        fila += "<td class='ed precio1'>" + "0.0000" + "</td>";
        fila += "<td class='ed precio2'>" + "0.0000" + "</td>";
        fila += "<td class='ed precio3'>" + "0.0000" + "</td>";
        fila += "<td class='ed precio4'>" + "0.0000" + "</td>";
        fila += "<td class='ed precio5'>" + "0.0000" + "</td>";
        fila += "<td class='ed precio6'>" + "0.0000" + "</td>";
        fila += "<td class='delete text-center'><a class=' Delete'><i class='fa fa-trash'></i> Borrar</a></td>";
        $("#presentacion_table").append(fila);
        $(".clear").val("");
        $("#id_presentacion").val("");
        $("#id_presentacion").trigger('change');
        btn.removeAttr('disabled');
      }
      else
      {
        //alert("aqui");
        $.ajax({
          url: 'editar_producto.php',
          type: 'POST',
          dataType: 'json',
          data: "process=add_pre"+"&id_producto="+id_producto+"&presentacion="+id_presentacion+"&descripcion="+desc_pre+"&unidad="+unidad_pre+"&costo="+costo_p+"&precio1="+precio1+"&barcode="+bar,
          success: function(datax)
          {
            //alert("aqui");
            display_notify(datax.typeinfo,datax.msg);
            if(datax.typeinfo=="Success")
            {
              $.ajax({
                url: 'editar_producto.php',
                type: 'POST',
                dataType: 'json',
                data: "process=datos"+"&id_producto="+id_producto,
                success:  function(datax)
                {
                  $("#id_presentacion").val("");
                  $("#id_presentacion").trigger('change');
                  $(".clear").val("");

                  btn.removeAttr('disabled');
                  $("#presentacion_table").html(datax.datos);
                }
              });
            }
          }
        });
      }
    }
  } else {
    display_notify("Error", "Por favor complete todos los campos");
    btn.removeAttr('disabled');
  }
});
$('html').click(function() {
  /* Aqui se esconden los menus que esten visibles*/
  var number = $('#value').val();
  var a = $('#value').closest('td');
  var idtransace = a.closest('tr').attr('class');
  if (isNaN(parseFloat(number))) {

    if (!a.hasClass('prea')) {
      if (a.hasClass("ed3"))
      {
        a.html(number);
      }
      else {
        a.html("0.0000");
      }
    }
    else {
      a.html(a.attr('prea'));
    }

  }
  else {

    a.html(number);
    if (a.hasClass('precio')) {

      if (parseFloat(number)==parseFloat(a.attr('prea'))) {
        console.log("mismo valor");
      }
      else {
        console.log("valor nuevo actualizando");

        $.ajax({
          url: 'editar_producto.php',
          type: 'POST',
          dataType: 'json',
          data: {process: 'actu_ppp',id_ppp: a.attr('id_prepd'), precio: number},
          success: function (xdatos) {
          }
        })

      }
    }

    iam = a.closest('tr');
    precios_pre = [0,0,0,0,0,0,0];
    unidad = parseFloat(iam.find('.unidad_p').text());
    for (var i = 0; i < precios_pre.length-1; i++) {
      precios_pre[i] = parseFloat(iam.find('td:eq('+ (i+5) +')').text())/unidad;
    }

    costo = parseFloat(iam.find('.costo').text());

    if (isNaN(costo)) {
      costo=0;
    }
    costo= costo/unidad;

    $("#presentacion_table tr").each(function(index) {

      unit = parseFloat($(this).find('.unidad_p').text());
      console.log("unidad" + unit);
      for (var i = 0; i < precios_pre.length; i++) {
        //precio = unit*precios_pre[i];
        preciod = precios_pre[i]*unit
        console.log("precio" + preciod);
        algo = preciod.toFixed(4);
        //$(this).find('td:eq('+ (i+5) +')').text(algo);
      }
      costop = costo*unit;
      algo2 = costop.toFixed(4);
      $(this).find('.costo').text(algo2);
    });

    $("#presentacion_table tr").each(function(index) {

      for (var i = 0; i < precios_pre.length; i++) {
        unit = parseFloat($(this).find('.unidad_p').text());
        console.log("unidad" + unit);
        //precio = unit*precios_pre[i];
        preciod = precios_pre[i]*unit
        console.log("precio" + preciod);
        algo = preciod.toFixed(4);
        //$(this).find('td:eq('+ (i+5) +')').text(algo);
      }

    });


  }

});
$(document).on('click', '.a', function(event) {

});
$(document).on('click', 'td', function(e) {
  if ($(this).hasClass('ed')) {
    var av = $(this).html();
    console.log(av);
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    if (av==0) {

    }
    else {
      $('#value').val(av);
    }

    $('#value').focus();
    $('#value').numeric({
      negative: false,
      decimalPlaces: 4
    });
    e.stopPropagation();
  }
  if ($(this).hasClass('ed2')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    $('#value').val(av);
    $('#value').focus();
    $('#value').numeric({
      negative: false,
      decimalPlaces: 2
    });
    e.stopPropagation();
  }
  if ($(this).hasClass('ed3')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    $('#value').val(av);
    $('#value').focus();
    e.stopPropagation();
  }

  if ($(this).hasClass('nm')) {
    var av = $(this).html();
    $(this).html('');
    $(this).html('<input class="form-control in" type="text" id="value" name="value" value="">');
    $('#value').val(av);
    $('#value').focus();
    $('#value').numeric({
      negative: false,
      decimal: false
    });
    e.stopPropagation();
  }
});
function img()
{
  var form = $("#formulario_pro");
  var formdata = false;
  if(window.FormData)
  {
      formdata = new FormData(form[0]);
  }
  var formAction = form.attr('action');
  $.ajax({
      type        : 'POST',
      url         : "agregar_producto.php",
      cache       : false,
      data        : formdata ? formdata : form.serialize(),
      contentType : false,
      processData : false,
      dataType : 'json',
      success: function(datax)
      {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success")
        {
          setInterval("reload1();", 1000);
        }
      }
  });
}


function editar_img()
{
	var form = $("#formulario_pro");
  var formdata = false;
  if(window.FormData)
  {
      formdata = new FormData(form[0]);
  }
  var formAction = form.attr('action');
  $.ajax({
      type        : 'POST',
      url         : "editar_producto.php",
      cache       : false,
      data        : formdata ? formdata : form.serialize(),
      contentType : false,
      processData : false,
      dataType : 'json',
      success: function(datax)
      {
        display_notify(datax.typeinfo, datax.msg);
        if (datax.typeinfo == "Success")
        {
					// var img = datax.img;
					// var cadena = '<img src="'+img+'" alt="" class="img-rounded" style="height: 300px; width: 350px;">';
					// $("#caja_img").html(cadena);
					// $(".fileinput-remove-button").click();
          setInterval("location.reload();", 1000);
        }
      }
  });
}

$(document).on("click","#estado", function()
{
  var id_producto = $(this).parents("tr").find("#id_producto_active").val();
  var estado = $(this).parents("tr").find("#estado").val();
  if(estado == 1)
  {
    var text = "Desactivar";
  }
  else
  {
      var text = "Activar";
  }
  swal({
    title: text+" este producto?",
    text: "",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Si, "+text+" este producto!",
    cancelButtonText: "No, cancelar!",
    closeOnConfirm: true,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      estado_pro(id_producto, estado);
      //swal("Exito", "Turno iniciado con exito", "error");
    } else {
      swal("Cancelado", "Operación cancelada", "error");
    }
  });
})

function estado_pro(id_producto, estado) {
  //var id_proveedor = $('#id_proveedor').val();
  var dataString = 'process=estado' + '&id_producto=' + id_producto+ '&estado=' + estado;
  $.ajax({
    type: "POST",
    url: "admin_producto.php",
    data: dataString,
    dataType: 'json',
    success: function(datax) {
      display_notify(datax.typeinfo, datax.msg);
      // console.log("OKde");
      if (datax.typeinfo == "Success")
      {
        // console.log("OKK");
        setInterval("reload1();", 1000);
        //$('#deleteModal').hide();
      }
    }
  });
}



$(document).on('keyup', '#desc_pre', function(evt) {
  if(evt.keyCode == 13)
	{
    if ($(this).val()!="") {
      $("#unidad_pre").focus();
    }

  }
});

$(document).on('keyup', '#unidad_pre', function(evt) {
  if(evt.keyCode == 13)
	{
    if ($(this).val()!="") {
      $("#costo_pre").focus();
    }

  }
  else {
    existe_unidad=false;
    costo=0;
    $("#presentacion_table tr").each(function(index, el) {
      unidad = parseInt($(this).find('.unidad_p').text());
      if (unidad>0) {
        existe_unidad=true;
        costo=parseFloat($(this).find('.costo').text())/unidad;

        if (isNaN(costo)) {
          costo=0;
        }
      }
    });

    if (existe_unidad) {
      unidad = parseInt($(this).val());
      if (isNaN(unidad)) {
        $("#costo_pre").val("");
      }
      else {
        total = unidad*costo;
        total = total.toFixed(4);
        $("#costo_pre").val(total);
      }
    }

  }
});

$(document).on('keyup', '#costo_pre', function(evt) {
  if(evt.keyCode == 13)
	{
    if ($(this).val()!="") {
      $("#bar").focus();
    }
  }
});
