var typingTimer;
var doneTypingInterval = 250;
var typedInput;
$('body').delegate('.nameInput', 'keyup', function () {
    clearTimeout(typingTimer);
    typedInput = $(this);

    var languageId = typedInput.data('language');

    if(typedInput.val().length) {
        typingTimer = setTimeout(getUrl, doneTypingInterval);
    } else {
        $('.slugInput[data-language="' + languageId + '"]').val('/');
    }
});

$('body').delegate('.nameInput', 'keydown', function () {
    clearTimeout(typingTimer);
});

$('body').delegate('.slugInput', 'keyup', function () {
    $(this).parent().find('div.help-block > span').html($(this).val())
});

function getUrl() {
    var name = typedInput.val();
    var language_id = typedInput.attr('data-language');
    var is_new = $('.slugInput[data-language="' + language_id + '"]').attr('data-new');
    var container_slug = $('.slugInput[data-language="' + language_id + '"]').attr('data-container');

    $.ajax({
        'url': '/dawnstar/getUrl',
        'data': {language_id, name, is_new, container_slug},
        'method': 'GET',
        success: function (response) {
            $('.slugInput[data-language="' + language_id + '"]').val('/' + response).trigger('keyup');
        },
    });
}
