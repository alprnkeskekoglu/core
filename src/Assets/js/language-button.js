
$('.languageBtn').on('click', function () {
    var language = $(this).data('language');
    $('.languageBtn').removeClass('active');
    $(this).addClass('active');

    $('.hasLanguage').addClass('d-none');
    $('.hasLanguage[data-language="' + language + '"]').removeClass('d-none');
});

$('.btn-language-status').on('click', function () {
    var status = $(this).data('status');

    if (status == 0) {
        $(this).addClass('bg-danger').removeClass('bg-success');
        $(this).find('i').addClass('mdi-close').removeClass('mdi-check');
        $(this).data('status', 1);
        $(this).parent().find('input').val(1);
        $(this).parent().find('button').prop('disabled', false);
    } else if (status == 1) {
        $(this).addClass('bg-success').removeClass('bg-danger');
        $(this).find('i').addClass('mdi-check').removeClass('mdi-close');
        $(this).data('status', 0);
        $(this).parent().find('input').val(0);
        $(this).parent().find('button').prop('disabled', true);
    }
});
