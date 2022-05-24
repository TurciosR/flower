var dataTable = "";
$(document).ready(function() {
  // Clean the modal form

  generar();
});

$(document).on('hidden.bs.modal', function(e) {
  var target = $(e.target);
  target.removeData('bs.modal').find(".modal-content").html('');
});

function generar() {
  fechai = $("#fecha_inicio").val();
  fechaf = $("#fecha_fin").val();
  dataTable = $('#editable2').DataTable().destroy()
  dataTable = $('#editable2').DataTable({
    "pageLength": 50,
    "order": [
      [1, 'desc'],
      [0, 'desc']
    ],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: "admin_autorizacion_dt.php?fechai=" + fechai + "&fechaf=" + fechaf, // json datasource
      //url :"admin_factura_rangos_dt.php", // json datasource
      //type: "post",  // method  , by default get
      error: function() { // error handling
        $(".editable2-error").html("");
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
    }],
    "language": {
      "url": "js/Spanish.json"
    }
  });
  dataTable.ajax.reload()
  //}
}
