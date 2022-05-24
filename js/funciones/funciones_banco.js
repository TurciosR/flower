$(document).ready(function() {
    $("file").fileinput({ 'showUpload': true, 'previewFileType': 'image' });
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            }
        },
        messages: {
            nombre: "Por favor ingrese el nombre del banco",
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        submitHandler: function(form) {
            senddata();
        }
    });
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

function autosave(val) {
    var name = $('#name').val();
    if (name == '' || name.length == 0) {
        var typeinfo = "Info";
        var msg = "The field name is required";
        display_notify(typeinfo, msg);
        $('#name').focus();
    } else {
        senddata();
    }
}

function senddata() {
    var process = $('#process').val();

    if (process == 'insert') {
        var urlprocess = 'agregar_banco.php';
    }
    if (process == 'edited') {
        var urlprocess = 'editar_banco.php';
    }
    var form = $("#formulario");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type: 'POST',
        url: urlprocess,
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            display_notify(data.typeinfo, data.msg, data.process);
            if (data.typeinfo == "Success") {
                setInterval("reload1();", 1500);
            }
        }
    });
}

function reload1() {
    location.href = 'admin_banco.php';
}

function deleted() {
    var id_banco = $('#id_banco').val();
    var dataString = 'process=deleted' + '&id_banco=' + id_banco;
    $.ajax({
        type: "POST",
        url: "borrar_banco.php",
        data: dataString,
        dataType: 'json',
        success: function(datax) {
            display_notify(datax.typeinfo, datax.msg);
            if (datax.typeinfo == "Success") {
                setInterval("location.reload();", 1000);
                $('#deleteModal').hide();
            }
        }
    });
}