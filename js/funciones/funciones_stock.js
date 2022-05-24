$(document).ready(function() {
  $(".select").select2();
  $('#keywords, #barcode').on('keyup', function(event) {
    searchFilter();
  });
  $("#ubicacion").change(function(event) {
    searchFilter();
  });
  $('.loading-overlay').hide();
  searchFilter();

 $('.navbar-header .btn-primary').click();


});

function searchFilter(page_num)
{
  page_num = page_num ? page_num : 0;
  var keywords = $('#keywords').val();
  var barcode = $('#barcode').val();
  var id_ubicacion = $('#ubicacion :selected').val();
  getData(keywords, id_ubicacion, barcode, page_num)
}
function getData(keywords, id_ubicacion, barcode, page_num) {
  var sortBy = $('#sortBy').val();
  var records = $('#records').val();
  urlprocess = $('#urlprocess').val();
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: {
      process: 'traerdatos',
      page: page_num,
      keywords: keywords,
      id_ubicacion: id_ubicacion,
      barcode: barcode,
      sortBy: sortBy,
      records: records
    },
    beforeSend: function() {
      $('.loading-overlay').show();
    },
    success: function(html) {
      $('#mostrardatos').html(html);
      var cuantos = $('#cuantos_reg').val();
      if (cuantos > 0) {
        $('.loading-overlay').html("<span class='text-warning'>Buscando....</span>");
        $('#reg_count').val(cuantos);
        $('.loading-overlay').fadeOut("slow");
      } else {
        $('.loading-overlay').fadeOut("slow");
        $('#reg_count').val(0);
      }
    }
  });
  $.ajax({
    type: 'POST',
    url: urlprocess,
    data: {
      process: 'traerpaginador',
      page: page_num,
      keywords: keywords,
      id_ubicacion: id_ubicacion,
      barcode: barcode,
      sortBy: sortBy,
      records: records
    },
    success: function(value) {
      $('#encabezado_buscador').show();
      $('#paginador').html(value);
    }
  });
}
