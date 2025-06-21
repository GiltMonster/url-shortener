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