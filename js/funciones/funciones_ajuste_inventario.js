$(document).ready(function() {
    $('.select').select2();
    $("#scrollable-dropdown-menu #producto_buscar").typeahead({
        highlight: true,
    }, {
        limit: 100,
        name: 'productos',
        display: function(data) {
            prod = data.producto.split("|");
            return prod[1];
        },
        source: function show(q, cb, cba) {
            console.log(q);
            var url = 'autocomplete_producto2.php' + "?query=" + q;
            $.ajax({
                    url: url
                })
                .done(function(res) {
                    cba(JSON.parse(res));
                })
                .fail(function(err) {
                    alert(err);
                });
        },
        templates: {
            suggestion: function(data) {
                var prod = data.producto.split("|");
                return '<div class="tt-suggestion tt-selectable">' + prod[1] + '</div>' + '';
            }
        }
    }).on('typeahead:selected', onAutocompleted);

    function onAutocompleted($e, datum) {
        $('.typeahead').typeahead('val', '');
        var prod0 = datum.producto;
        var prod = prod0.split("|");
        var id_prod = prod[0];
        var descrip = prod[1];
        agregar_producto(id_prod, descrip);
    }

});
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
});

// Agregar productos a la lista del inventario
function agregar_producto(id_prod, descrip) {
    var id_prev = "";
    var origen = $('#destino').val();
    var dataString = 'process=consultar_stock' + '&id_producto=' + id_prod + '&origen=' + origen;
    $.ajax({
        type: "POST",
        url: 'ajuste_inventario.php',
        data: dataString,
        dataType: 'json',
        success: function(data) {
            var cp = data.costop;
            var perecedero = data.perecedero;
            var select = data.select;
            var preciop = data.preciop;
            var unidadp = data.unidadp;
            var descripcionp = data.descripcionp;
            var existencia = data.existencia;
            var iphp = data.i;


            var categoria = data.categoria;
            var decimals = data.decimals;

            if (decimals == 1) {
                categoria = 86;
            }

            $("#inventable tr").each(function(index) {
                id_prev = $(this).closest('tr').children('td:first').text();
                if (id_prev == id_prod) {
                    id_prod = "";

                } else
                    id_prod = id_prod;
            });

            if (perecedero == 1) {
                caduca = "<div class='form-group'><input type='text' class='datepicker form-control vence' value=''></div>";
            } else {
                caduca = "<input type='hidden' class='vence' value='NULL'>";
            }


            var tr_add = "";
            for (var i = 0; i < iphp; i++) {
                var unit = "<input type='hidden' class='unidad' value='" + unidadp[i] + "'>";

                tr_add += '<tr>';
                tr_add += '<td class="id_p">' + id_prod + '</td>';
                tr_add += '<td>' + descrip + '</td>';
                tr_add += '<td>' + select[i] + '</td>';
                tr_add += '<td class="descp">' + descripcionp[i] + '</td>';
                tr_add += "<td><div class=''>" + unit + "<input type='text'  class='form-control precio_compra' value='" + cp[i] + "' style='width:80px;'></div></td>";
                tr_add += "<td><div class=''><input type='text'  class='form-control precio_venta' value='" + preciop[i] + "' style='width:80px;'></div></td>";
                tr_add += "<td class='existencia'>" + existencia[i] + '</td>';
                tr_add += "<td><div class=''><input type='text'  class='form-control cant " + categoria + "' style='width:80px;'></div></td>";
                tr_add += "<td class=''>" + caduca + '</td>';
                tr_add += "<td class='Delete text-center'><a href='#'><i class='fa fa-trash'></i></a></td>";
                tr_add += '</tr>';
            }
            if (i != 0) {
                if (id_prod != "") {
                    $("#inventable").prepend(tr_add);
                    $(".sel").select2();

                    /*que no se vayan letras*/
                    $(".precio_compra").numeric({
                        negative: false,
                        decimalPlaces: 2,
                    });

                    $(".precio_venta").numeric({
                        negative: false,
                        decimalPlaces: 2,
                    });

                    if (categoria == 86) {
                        $(".86").numeric({
                            negative: false,
                            decimalPlaces: 4,
                        });
                    } else {
                        $(".cant").numeric({
                            decimal: false,
                            negative: false,
                        });
                        $(".86").numeric({
                            negative: false,
                            decimalPlaces: 4,
                        });
                    }
                }
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '1d'
                });

            } else {
                swal({
                    title: "Error, producto sin presentaciones?",
                    text: "Si presiona OK sera redireccionado para asignar presentaciones y costos ",
                    type: "warning",
                    showCancelButton: true
                }, function() {
                    // Redirect the user
                    //window.location.href = "";
                    window.open('editar_producto.php?id_producto=' + id_prod, '_blank');
                });
            }

        }
    });
    totales();
}
//Evento que se activa al perder el foco en precio de venta y cantidad:
$(document).on("blur", "#inventable", function() {
    totales();
});
$(document).on('click', '#generar', function(event) {

    //Calcular los valores a guardar de cada item del inventario
    var i = 0;
    var error = false;
    var datos = "";
    var id = $("select#tipo_entrada option:selected").val(); //get the value

    $("#inventable>tbody tr").each(function() {
        var id_prod = $(this).find(".id_p").text();
        var id_presentacion = $(this).find(".sel").val();
        var compra = $(this).find(".precio_compra").val();
        var unidad = $(this).find(".unidad").val();
        var venta = $(this).find(".precio_venta").val();
        var cant = 0;
        var existencia = $(this).find(".existencia").text();
        if (id_prod != "" && parseFloat(id_prod) > 0) {
            datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + existencia + "|" + id_presentacion + "#";
            i = i + 1;
        }
    });

    if (i == 0) {
        error = true;
    }
    if (!error) {
        $('#params').val(datos);
        $('#cu').val(i);
        $('#frm1').submit();
    }
});
$(document).on("keyup", ".cant, .precio_compra, .precio_venta", function() {
    totales();
});
// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", ".Delete", function() {
    $(this).parents("tr").remove();
    totales();
});
//Calcular Totales del grid
function totales() {
    var subtotal = 0;
    var total = 0;
    var totalcantidad = 0;
    var subcantidad = 0;
    var total_dinero = 0;
    var total_cantidad = 0;
    $("#inventable>tbody tr").each(function() {
        var compra = $(this).find(".precio_compra").val();
        var unidad = $(this).find(".unidad").val();
        var venta = $(this).find(".precio_venta").val();
        var cantidad = parseInt($(this).find(".cant").val());
        var vence = $(this).find(".vence").val();
        subtotal = compra * cantidad;
        if (isNaN(cantidad) == true) {
            cantidad = 0;
        }
        totalcantidad += cantidad;
        if (isNaN(subtotal) == true) {
            subtotal = 0;
        }
        total += subtotal;
    });
    if (isNaN(total) == true) {
        total = 0;
    }
    total_dinero = round(total, 2);
    total_cantidad = round(totalcantidad, 2);
    total_dinero = round(total, 2);
    total_cantidad = round(totalcantidad, 2);

    $('#total_dinero').html("<strong>" + total_dinero + "</strong>");
    $('#totcant').html(total_cantidad);

}
// actualize table
$(document).on("click", "#submit1", function() {
    $('#submit1').prop('disabled', true);
    senddata();
});

function senddata() {
    //Calcular los valores a guardar de cada item del inventario
    var i = 0;
    var error = false;
    var datos = "";
    var id = $("select#tipo_entrada option:selected").val(); //get the value

    $("#inventable>tbody tr").each(function() {
        var id_prod = $(this).find(".id_p").text();
        var id_presentacion = $(this).find(".sel").val();
        var compra = $(this).find(".precio_compra").val();
        var unidad = $(this).find(".unidad").val();
        var venta = $(this).find(".precio_venta").val();
        var cant = $(this).find(".cant").val();
        var vence = $(this).find(".vence").val();
        if (compra != "" && parseFloat(compra) >= 0 && venta != "" && parseFloat(venta) > 0 && cant != "" && parseFloat(cant) > 0) {
            datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + vence + "|" + id_presentacion + "#";
            i = i + 1;
        }
    });

    if (i == 0) {
        error = true;
    }

    var total = $('#total_dinero').text();
    var concepto = $('#concepto').val();
    var fecha1 = $('#fecha1').val();
    var destino = $('#destino').val();

    var dataString = {
        'process': "insert",
        'datos': datos,
        'cuantos': i,
        'total': total,
        'fecha': fecha1,
        'concepto': concepto,
        'destino': destino
    }
    if (!error) {
        $.ajax({
            type: 'POST',
            url: "ajuste_inventario.php",
            data: dataString,
            dataType: 'json',
            success: function(datax) {
                display_notify(datax.typeinfo, datax.msg);
                if (datax.typeinfo == "Success") {
                    setInterval("reload1();", 1000);
                }
            }
        });
    } else {
        $('#submit1').prop('disabled', "");
        display_notify('Warning', 'Verifique los campos y realice al menos un ajuste con valor mayor a cero');
    }
}

function reload1() {
    location.href = "ajuste_inventario.php";
}
$(document).on('change', '#destino', function(event) {
    $('#inventable>tbody').html('');
    $('#categoria').val("");
    $('#categoria').trigger('change');
    totales();

});
$(document).on('change', '.sel', function(event) {
    var id_presentacion = $(this).val();
    var a = $(this).parents("tr");
    $.ajax({
        url: 'ajuste_inventario.php',
        type: 'POST',
        dataType: 'json',
        data: 'process=getpresentacion' + "&id_presentacion=" + id_presentacion,
        success: function(data) {
            a.find('.descp').html(data.descripcion);
            a.find('.precio_venta').val(data.precio);
            a.find('.precio_compra').val(data.costo);
            a.find('.unidad').val(data.unidad);
            a.find('.precio_compra').val(data.costo);
        }
    });
    setTimeout(function() {
        totales();
    }, 1000);
});

$(document).on('change', '#categoria', function(event) {
    var id_categoria = $('#categoria').val();
    var id_ubicacion = $('#destino').val();
    $('#inventable>tbody').html('');




    $.ajax({
        url: 'ajuste_inventario.php',
        type: 'POST',
        dataType: 'json',
        data: 'process=getids' + "&id_categoria=" + id_categoria + "&id_ubicacion=" + id_ubicacion,
        success: function(data) {
            var i = data.i;
            var array = data.array;
            var arrayd = data.arrayd;

            for (var j = 0; j < i; j++) {
                agregar_producto(array[j], arrayd[j])
            }
        }
    });
    totales();
});

function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}