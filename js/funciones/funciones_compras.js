$(document).ready(function() {
    $('.select').select2();
    $('#numero_dias').numeric({ decimal: false, negative: false });
    $("#codigo").keyup(function(evt) {
        var code = $(this).val();
        if (evt.keyCode == 13) {
            if ($(this).val() != "") {
                agregar_producto(code, "", "C");
            }
            $(this).val("");
        }
    });
    $('html,body').animate({
        scrollTop: $(".focuss").offset().top
    }, 1500);
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
            var url = 'autocomplete_producto3.php' + "?query=" + q;
            $.ajax({ url: url })
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
        agregar_producto(id_prod, descrip, "D");
    }
    $("#codigo").focus();
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
$(document).keydown(function(e) {
    if (e.which == 113) { //F2 Guardar
        $("#submit1").click();
        e.stopPropagation();
        e.preventDefault();
    }
    if (e.which == 115) { //F4 Guardar
        location.replace('dashboard.php');
        e.stopPropagation();
        e.preventDefault();
    }
    if (e.which == 114) { //F3 salir
        if ($('#a').attr('hidden')) {
            $('#a').removeAttr('hidden');
            $('#b').attr('hidden', 'hidden');
            $('#codigo').focus();
        } else {
            $('#b').removeAttr('hidden');
            $('#a').attr('hidden', 'hidden');
            $('#producto_buscar').focus();
        }
        e.stopPropagation();
        e.preventDefault();
    }
    if (e.which == 46) /*suprimir*/ {
        $("#inventable tr:first-child").remove();
        totales();
        var filas = $("#filas").val();
        filas--;
        $("#filas").val(filas);
        e.preventDefault();
        if ($('#b').attr('hidden')) {
            $('#codigo').focus();
        } else {
            $('#producto_buscar').focus();
        }
    }
});

// Agregar productos a la lista del inventario
function agregar_producto(id_prod, descrip, tipo) {
    var dataString = 'process=consultar_stock&tipo=' + tipo + '&id_producto=' + id_prod;
    $.ajax({
        type: "POST",
        url: 'compras.php',
        data: dataString,
        dataType: 'json',
        success: function(data) {
            if (data.typeinfo == "Success") {
                var cp = data.costop;
                var perecedero = data.perecedero;
                var select = data.select;
                var preciop = data.preciop;
                var unidadp = data.unidadp;
                var descripcionp = data.descripcionp;
                var i = data.i;
                var descrip = data.descrip;
                var id_prod = data.id_p;
                var categoria = data.categoria;

                var decimals = data.decimals;
                if (decimals == 1) {
                    categoria = 86;
                }

                if (perecedero == 1) {
                    caduca = "<div class='form-group'><input type='text' class='datepicker form-control vence' value=''></div>";
                } else {
                    caduca = "<input type='hidden' class='vence' value='NULL'>";
                }
                var filas = $("#filas").val();
                filas++;
                var unit = "<input type='hidden' class='unidad' value='" + unidadp + "'>";
                var tr_add = "";
                tr_add += '<tr id="' + filas + '" class="row100">';
                tr_add += '<td class="id_p col-lg-1">' + id_prod + '</td>';
                tr_add += '<td class="col-lg-3">' + descrip + '</td>';
                tr_add += '<td class="col-lg-1">' + select + '</td>';
                tr_add += '<td class="descp col-lg-1">' + descripcionp + '</td>';
                tr_add += "<td class='col-lg-1'><div><input type='text'  class='form-control cant " + categoria + " ' style='width:80px;'></div></td>";
                tr_add += "<td class='col-lg-1'><div>" + unit + "<input type='text'  class='form-control precio_compra' value='" + cp + "' style='width:80px;'></div></td>";
                tr_add += "<td class='col-lg-1'><div><input type='text'  class='form-control precio_venta' value='" + preciop + "' style='width:80px;'></div></td>";
                tr_add += "<td class='col-lg-1'><div><input type='text'  class='form-control subtotal1' value='' style='width:80px;'></div></td>";
                tr_add += "<td class='col-lg-1'>" + caduca + '</td>';
                tr_add += "<td class='Delete text-center col-lg-1'><a><i class='fa fa-trash'></i></a></td>";
                tr_add += '</tr>';
                $("#inventable").prepend(tr_add);
                $(".sel").select2();
                /*que no se vayan letras*/
                $("#filas").val(filas);
                $(".precio_compra").numeric({
                    negative: false,
                    decimalPlaces: 4,
                });

                $(".precio_venta").numeric({
                    negative: false,
                    decimalPlaces: 4,
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
                $("#inventable #" + filas).find(".sel").select2("open");
                $(".datepicker").datepicker({
                    format: 'yyyy-mm-dd',
                    language: 'es',
                });
            } else {
                display_notify(data.typeinfo, data.msg);
            }
        }
    });
    totales();
}
$(document).on('select2:close', '.sel', function() {
    var tr = $(this).parents("tr");
    tr.find(".cant").focus();
});
$(document).on('keyup', '.cant', function(evt) {
    var tr = $(this).parents("tr");
    if (evt.keyCode == 13) {
        num = parseFloat($(this).val());
        if (isNaN(num)) {
            num = 0;
        }
        if ($(this).val() != "" && num > 0) {
            tr.find('.precio_compra').focus();
            tr.find('.precio_compra').select();

        }
    }
    totales();
});
$(document).on('keyup', '.precio_compra', function(evt) {
    var tr = $(this).parents("tr");
    if (evt.keyCode == 13) {
        num = parseFloat($(this).val());
        if (isNaN(num)) {
            num = 0;
        }
        if ($(this).val() != "" && num > 0) {
            tr.find('.precio_venta').focus();
            tr.find('.precio_venta').select();
        }
    }
    totales();
});
$(document).on('keyup', '.precio_venta', function(evt) {
    var tr = $(this).parents("tr");
    if (evt.keyCode == 13) {
        num = parseFloat($(this).val());
        if (isNaN(num)) {
            num = 0;
        }
        if ($(this).val() != "" && num > 0) {
            if ($('#b').attr('hidden')) {
                $('#codigo').focus();
            } else {
                $('#producto_buscar').focus();
            }
        }
    }
    totales();
});

//Evento que se activa al perder el foco en precio de venta y cantidad:
$(document).on("blur", "#inventable", function() {
    totales();
});

$(document).on("keyup", ".subtotal1", function(evt) {
    if (evt.keyCode == 13) {
        $('#producto_buscar').focus();
    }
    totales("subt");
});
// Evento que selecciona la fila y la elimina de la tabla
$(document).on("click", ".Delete", function() {
    $(this).parents("tr").remove();
    totales();
});
//Calcular Totales del grid
function totales(proc = "prec") {
    var subtotal = 0;
    var total = 0;
    var totalcantidad = 0;
    var subcantidad = 0;
    var total_dinero = 0;
    var total_cantidad = 0;
    var sub_exento = 0;
    $("#inventable tr").each(function() {
        var compra = parseFloat($(this).find(".precio_compra").val());
        var unidad = $(this).find(".unidad").val();
        var venta = parseFloat($(this).find(".precio_venta").val());
        var cantidad = parseFloat($(this).find(".cant").val());
        var vence = $(this).find(".vence").val();
        var exento = parseInt($(this).find(".exento").val());

        if (isNaN(cantidad) == true) {
            cantidad = 0;
        }
        if (proc == "subt") {
            var subtotal = parseFloat($(this).find(".subtotal1").val());
            if (subtotal > 0) {
                var subt = round(subtotal / cantidad, 4);
            } else {
                subt = 0;
            }
            $(this).find(".precio_compra").val(subt.toFixed(4));
        } else {
            subtotal = round(compra * cantidad, 4);
            $(this).find(".subtotal1").val(subtotal.toFixed(4));
        }
        totalcantidad += cantidad;
        if (isNaN(subtotal) == true) {
            subtotal = 0;
        }

        if (exento == 1) {
            sub_exento = sub_exento + subtotal;
        } else {
            total += subtotal;
        }

    });
    if (isNaN(total) == true) {
        total = 0;
    }
    sumas_sin_iva = total;
    sumas_sin_iva = round(total, 2);

    if (isNaN(sub_exento)) {
        sub_exento = 0;
    }

    tipo_doc = $('#tipo_doc').val();

    percepcion = $('#percepcion').val();

    var monto_percepcion = $('#monto_percepcion').val();
    var iva = $('#porc_iva').val();

    total_percepcion = 0;
    iva = round((total * iva), 4);
    sub_exento = round(sub_exento, 2);

    if (total >= monto_percepcion)
        total_percepcion = round((total * percepcion), 4);

    total += total_percepcion;
    if (tipo_doc == 'CCF') {
        total += iva;
    } else {
        iva = 0;
    }


    total += sub_exento;
    total_dinero = round(total, 2);
    total_cantidad = round(totalcantidad, 2);

    $('#totcant').html(total_cantidad);
    $('#sumas_sin_iva').html(round(sumas_sin_iva, 2).toFixed(2));
    $('#subtotal').html(round((sumas_sin_iva + iva), 2).toFixed(2));
    $('#iva').html(round(iva, 2).toFixed(2));
    $('#venta_exenta').html(sub_exento.toFixed(2));
    $('#total_percepcion').html(round(total_percepcion, 2).toFixed(2));
    $('#total_dinero').html(total_dinero.toFixed(2));


}
// actualize table
$(document).on("click", "#submit1", function() {
    if ($("#inventable tr").length > 0) {
        senddata();
    } else {
        display_notify("Error", "Debe agregar productos a la lista");
        $('#submit1').attr('disabled', false);
    }
});

$(document).on('change', '#tipo_doc', function(event) {
    totales();
    /* Act on the event */
});
$(document).on('change', '#id_proveedor', function(event) {

    id_proveedor = $("#id_proveedor").val();

    $.ajax({
        url: 'compras.php',
        type: 'POST',
        data: 'process=datos_proveedores&id_proveedor=' + id_proveedor,
        dataType: 'JSON',
        async: true,
        success: function(data) {

            var percepcion = data.percepcion;

            $('#percepcion').val(percepcion);
            totales();
        }
    });


});


function senddata() {
    //Calcular los valores a guardar de cada item del inventario
    var i = 0;
    var error = false;
    var datos = "";
    var msg = "";
    var id = $("select#tipo_entrada option:selected").val(); //get the value

    $("#inventable tr").each(function() {
        var id_prod = $(this).find(".id_p").text();
        var id_presentacion = $(this).find(".sel").val();
        var compra = $(this).find(".precio_compra").val();
        var unidad = $(this).find(".unidad").val();
        var venta = $(this).find(".precio_venta").val();
        var cant = $(this).find(".cant").val();
        var vence = $(this).find(".vence").val();
        var exento = $(this).find(".exento").val();

        if (venta != "" && parseFloat(venta) > 0 && cant != "" && parseInt(cant) > 0) {
            datos += id_prod + "|" + compra + "|" + venta + "|" + cant + "|" + unidad + "|" + vence + "|" + id_presentacion + "|" + exento + "#";
            i = i + 1;
        } else {
            error = true;
        }
    });

    var total = $('#total_dinero').text();
    var concepto = $('#concepto').val();
    var fecha1 = $('#fecha1').val();
    var destino = $('#destino').val();

    var proveedor = $('#id_proveedor').val();
    if (proveedor != "" && proveedor != 0) {

    } else {
        msg = "Se ocupa ingresar el proveedor!!";
        error = true;
    }

    var tipo_doc = $('#tipo_doc').val();
    var numero_doc = $('#numero_doc').val();
    if (numero_doc != "" && numero_doc != 0) {

    } else {
        msg = "Se ocupa ingresar el numero de documento!!";
        error = true;
    }

    var sumas_sin_iva = $('#sumas_sin_iva').html();
    var subtotal = $('#subtotal').html();
    var iva = $('#iva').html();
    var venta_exenta = $('#venta_exenta').html();
    var total_percepcion = $('#total_percepcion').html();

    var dias_credito = parseInt($('#numero_dias').val());
    if (isNaN(dias_credito)) {
        dias_credito = 0;
    }

    if (i == 0) {
        msg = "error aja";
        error = true;
    }





    var dataString = {
        'process': "insert",
        'datos': datos,
        'cuantos': i,
        'total': total,
        'fecha': fecha1,
        'concepto': concepto,
        'destino': destino,
        'proveedor': proveedor,
        'tipo_doc': tipo_doc,
        'numero_doc': numero_doc,
        'sumas_sin_iva': sumas_sin_iva,
        'subtotal': subtotal,
        'iva': iva,
        'venta_exenta': venta_exenta,
        'total_percepcion': total_percepcion,
        'dias_credito': dias_credito,
    }
    if (!error) {
        swal({
            title: "¿Esta, seguro?",
            text: "Este proceso no puede ser revertido, si esta seguro presione OK y se procedera.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '',
            confirmButtonText: 'Si, Estoy seguro.',
            cancelButtonText: "No, cancelar y revisar.",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'POST',
                    url: "compras.php",
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
            }

        });
    } else {
        $('#submit1').prop('disabled', "");
        display_notify('Warning', msg);
    }
}

function reload1() {
    location.href = "compras.php";
}
$(document).on('change', '.sel', function(event) {
    var id_presentacion = $(this).val();
    var a = $(this).parents("tr");
    $.ajax({
        url: 'compras.php',
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
    }, 200);
});

function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}