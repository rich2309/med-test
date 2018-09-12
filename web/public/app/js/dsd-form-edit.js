$(document).ready(function () {
    hiddenBoxDelete();
});

function hiddenBoxDelete() {
    var tagDelete = $('label[for=appbundle_dsd_file_delete]');
    var boxDelete = $('#appbundle_dsd_file_delete');
    boxDelete.hide();
    tagDelete.hide();
}