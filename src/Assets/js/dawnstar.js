function slugify(str) {
    str = str.replace(/^\s+|\s+$/g, '');
    str = str.toLowerCase();
    var from = "àáãäâèéëêìíïîòóöôùúüûñçşğ·/_,:;";
    var to   = "aaaaaeeeeiiiioooouuuuncsg------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }
    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    return str;
}

function showMessage(type, title, message, timer = 1200) {
    let timerInterval;
    Swal.fire({
        icon: type,
        title: title,
        html: message,
        timer: timer,
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: () => {
            timerInterval = setInterval(() => {
                Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    })
}
