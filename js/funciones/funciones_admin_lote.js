$(document).ready(function() {

  document.addEventListener('keydown', event => {
  if (event.ctrlKey && event.keyCode==16) {

			event.stopPropagation();
			if ($('#a').attr('hidden')) {
				$('#a').removeAttr('hidden');
				$('#b').attr('hidden', 'hidden');
				$('#producto_buscar').focus();
			}
			else {
				$('#b').removeAttr('hidden');
				$('#a').attr('hidden', 'hidden');
				$('#composicion').focus();
			}
	  }
	}, false);

  document.addEventListener('keydown', event => {
  if (event.ctrlKey && event.keyCode==13) {
		event.preventDefault();
		event.stopPropagation();

			if ($('#a').attr('hidden')) {
				$('#composicion').focus();
			}
			else {
				$('#producto_buscar').focus();
			}
	  }
	}, false);
  $("#scrollable-dropdown-menu #producto_buscar").typeahead({
    highlight: true,
  },
  {
  	limit:100,
    name: 'productos',
    display: 'producto',
  	source: function show(q, cb, cba) {
          console.log(q);
          var url = 'autocomplete_producto2.php' + "?query=" + q;
          $.ajax({ url: url })
              .done(function(res) {
                  cba(JSON.parse(res));
              })
              .fail(function(err) {
                  alert(err);
              });
      }
  }).on('typeahead:selected', onAutocompleted);

  function onAutocompleted($e, datum) {

  		$('.typeahead').typeahead('val', '');

  		var prod0=datum.producto;
  		 var prod= prod0.split("|");
  		 var id_prod = prod[0];
  		 var descrip = prod[1];
  			addProductList(id_prod);
  }

  $("#scrollable-dropdown-menu #composicion").typeahead({
    highlight: true,
  },
  {
  	limit:100,
    name: 'productos',
    display: 'producto',
  	source: function show(q, cb, cba) {
          console.log(q);
          var url = 'autocomplete_producto3.php' + "?query=" + q;
          $.ajax({ url: url })
              .done(function(res) {
                  cba(JSON.parse(res));
              })
              .fail(function(err) {
                  alert(err);
              });
      }
  }).on('typeahead:selected', onAutocompleted2);

  function onAutocompleted2($e, datum) {

  		$('.typeahead').typeahead('val', '');

  		var prod0=datum.producto;
  		 var prod= prod0.split("|");
  		 var id_prod = prod[0];
  		 var descrip = prod[1];
  			addProductList(id_prod);
  }
});

function addProductList(id_prod) {
  id_prod = $.trim(id_prod);

  $.ajax({
    url: 'admin_lotes.php',
    type: 'POST',
    dataType: 'json',
    data: {process: 'lotes',id_prod: id_prod},
    success: function (xdatos) {
      $('#inve').prepend(xdatos.lotes);

      $.fn.datepicker.dates['es'] = {
    		days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
    		daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
    		daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
    		months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    		monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    	};
    	window.prettyPrint && prettyPrint();
    	$(".date").datepicker({
    		format: 'yyyy-mm-dd',
    		language:'es',
    	});
    }
  })
}

$(document).on('click', '.guardar', function(event) {

  var i=0;

  error=false;

  var array_json = new Array();

  $('#inve tr').each(function(index) {

    var id_lote =$(this).attr('lote');
    var fecha=$(this).find('.date').val();



    if (id_lote && fecha) {
      var obj = new Object();
      obj.id_lote = id_lote;
      obj.fecha = fecha;
      text = JSON.stringify(obj);
      array_json.push(text);
      i = i + 1;
    }
    else
    {
      error=true
    }
  });

  json_arr = '[' + array_json + ']';

  if (i==0) {
    error=true
  }

  console.log(json_arr);

  if (error==false) {

    $.ajax({
      url: 'admin_lotes.php',
      type: 'POST',
      dataType: 'json',
      data: {process: 'actualizar_todo',json_arr: json_arr},
      success: function (xdatos) {

        display_notify(xdatos.typeinfo,xdatos.msg);

        if (xdatos.typeinfo=="Success") {
          setTimeout(function(){ location.reload();}, 500);
        }
        else {

        }
      }
    })

  }
  else {
    if (i==0) {
      display_notify("Error","Seleccione al menos un producto para modificar sus lotes");
    }
    else {
      display_notify("Error","Complete todos los campos");
    }
  }
});

$(document).on('click', '.trash', function(event) {

  $(this).closest('tr').remove();
});
$(document).on('click', '.save', function(event) {

  var id_lote=$(this).closest('tr').attr('lote');
  var fecha=$(this).closest('tr').find('.date').val();

  $.ajax({
    url: 'admin_lotes.php',
    type: 'POST',
    dataType: 'json',
    data: {process: 'actualizar',id_lote: id_lote,fecha: fecha},
    success: function (xdatos) {

      display_notify(xdatos.typeinfo,xdatos.msg);
    }
  })

});
