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
    $(this).parent().find('div.help-block > span').html('/' + $(this).val())
});
function getUrl() {
    var name = typedInput.val();
    var languageId = typedInput.attr('data-language');

    $.ajax({
        'url': '/dawnstar/getUrl',
        'data': {'language_id': languageId, 'name': name},
        'method': 'GET',
        success: function (response) {
            $('.slugInput[data-language="' + languageId + '"]').val(response).trigger('keyup');
        },
    });
}
