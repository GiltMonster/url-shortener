$(document).ready(() => {
    $('#error_message').hide();

    //load list:
    $.ajax({
        url: '../api.php/listarUrls',
        type: 'GET',
        dataType: 'json',
        success: (resp) => { 
            console.log('resp:', resp);
            if (resp.success) {
                const list = resp.urls;
                
                if (list.length > 0) {
                    list.forEach(item => {
                        $('#url_list').append(`<li><a href="u/${item.shortened_url}" target="_blank">${window.location.origin}/u/${item.shortened_url}</a> - <span>${item.original_url}</span></li>`);
                    });
                } else {
                    $('#url_list').append('<li>Nenhuma URL encurtada encontrada.</li>');
                }
            } else {
                $('#error_message').text(resp.error).show();
            }
        }
    });
})


$('#shortener_form').on('submit', function (e) {
    e.preventDefault();

    const originalUrl = $('#url').val().trim();

    $.ajax({
        url: '../api.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ url: originalUrl }),
        success: function (response) {
            console.log(`Url original: ${originalUrl}`);
            
            if (response.success) {
                $('#shortened_url').text(response.shortenedUrl);
                console.log(`URL encurtada: ${response.shortenedUrl}`);
                
                $('#error_message').hide();
            } else {
                $('#error_message').text(response.error).show();
                $('#shortened_url').text('');
            }
        },
        error: function (xhr, status, error) {
            $('#error_message').text('Ocorreu um erro ao encurtar a URL.').show();
            $('#shortened_url').text('');
        }
    });
});