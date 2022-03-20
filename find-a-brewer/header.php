<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
    <script src="<?= get_template_directory_uri() . '/assets/js/autocomplete.js' ?>"></script>
    <title>Find your brewer</title>
    <?php wp_head() ?>  
</head>
<body>
    
<?php 
    $brewery_cities = get_meta_values('city', 'brewery'); 

?>

<main id="main">
    <header class="header">
        <div class="hd-container">
            <h1>Find your brewer</h1>
            <div class="search-form">
                <input type="text" id="search-text" 
                data-autocomplete 
                data-autocomplete-source="list.html"
                autocomplete-minlength="3"
                placeholder="<?php echo esc_attr_x( 'Search your city...', 'placeholder' ) ?>"
                value="<?php echo get_search_query() ?>">
                <div id="autocomplete-results">
                    <?php foreach($brewery_cities as $city): ?>
                    <button class="autocomplete-city">
                        <span><?= $city ?></span>
                    </button>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </header>