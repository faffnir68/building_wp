<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
    <title>Find your brewer</title>
    <?php wp_head() ?>  
</head>
<body>
<main id="main">
    <header class="header">
        <div class="hd-container">
            <h1>Find your brewer</h1>
            <div class="search-form">
                <input type="search" name="q" id="city" placeholder="Search your city...">
            </div>
        </div>
    </header>