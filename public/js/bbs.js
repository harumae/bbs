$(document).ready(function() {
    $("#bbs-form").validetta({realTime : true});

    $('#image-file').change(function() {
        $('#image').val($(this).val());
    });

    $('#upload-btn, #image').click(function() {
        $('#image-file').click();
    });

    $('#cancel').click(function() {
        history.back();
    });
});
