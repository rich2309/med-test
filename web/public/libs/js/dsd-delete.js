var path = '';

$(document).ready(function () {
        $(".btn-dsd-delete").on('click', function () {
        console.log('escucho delete');
        path = $(this).data('path');
        console.log(path);
            swal({
                    title: "¿Estás seguro de eliminar tu cartera?",
                    text: "Se perderá toda la información relacionada",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "cancel",
                            closeModal: true,
                        },
                        confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            className: "isConfirm",
                            closeModal: true
                        }
                    }
            }).then(function (isConfirm) {
                if(isConfirm){
                    dsdDelete(path);
                }else{
                    swal.close();
                }

            });
        });
});

function lockDsdDelete() {
    $(".btn-dsd-delete").each(function(index) {
        $(this).attr("disabled", "disabled");
    });
}

function unlockDsdDelete() {
    $(".btn-dsd-delete").each(function(index) {
        $(this).removeAttr("disabled");
    });
}

function dsdDelete(path) {
    lockDsdDelete();
    /* Send data */
    $.ajax({
        type: "POST",
        contentType: "application/json",
        url: path,
        cache: false,
        timeout: 100000,
        success: function (data) {
            if (data.code === 201) {
                swal({
                    title: "Deleted !",
                    icon: "success",
                    timer: 2800,
                    button: {
                        visible: false
                    }
                })
                    .then(function () {
                        swal.close();
                        window.location.replace(data.url);
                    });
            }
        },
        error: function (e) {
            swal('An error occurred during saving process. Please retry later.');
            unlockDsdDelete();
        }
    });
}