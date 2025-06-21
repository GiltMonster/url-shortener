<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/app.js"defer></script>

</head>
<body>

<main>
    <h1>URL Shortener</h1>

    <!-- https://www.youtube.com/watch?v=VHxeuLf_eRs -->

    <form id="shortener_form" method="POST">
        <label for="url">Enter URL to shorten:</label>
        <input type="url" id="url" name="url" placeholder="https://..." required>
        <button type="submit">Shorten</button>
    </form>

    <div id="shortened_urls">
        <h2>Shortened URLs</h2>
        <ul id="url_list">
            <!-- Shortened URLs will be displayed here -->
        </ul>
    </div>

    <div id="error_message" style="color: red; display: none;"></div>
    <div id="success_message" style="color: green; display: none;"></div>
    <div id="loading_message" style="display: none;">Loading...</div>

</main>
    
</body>
</html>
