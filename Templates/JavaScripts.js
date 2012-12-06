/***************************************
 * Messages system
 **************************************/
$(function() {
    $(".message").addClass('alert');
    $(".message").prepend('<button type="button" class="close" data-dismiss="alert">&times;</button>');
    $(".message").wrap('<strong>');

    $(".message.error").addClass('alert-error');
    $(".message.info").addClass('alert-info');
    $(".message.success").addClass('alert-success');

    $(".close").click(function () {
        $(this).closest('.alert').remove();
    });
});
