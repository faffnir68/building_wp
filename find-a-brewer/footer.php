</main>
<footer>
    <div class="ft-container">
        <nav class="ft-nav">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">Last brewers added</a></li>
            </ul>
        </nav>
        <div class="logo">
            <!-- <img src="" alt="" srcset=""> -->
            <h1>Find your brewer</h1>
        </div>
    </div>
    <p class="copyright"></p>
</footer>
<?php wp_footer() ?>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiY2FsY2lmZXI2OCIsImEiOiJjbDB6MGhwdnYxdTRuM2ptdXZ3eWM0YzA4In0.WhX4fUmlyb6IucwpEWjhcQ';
    const map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [-74.5, 40], // starting position [lng, lat]
        zoom: 9, // starting zoom
        style: 'mapbox://styles/mapbox/dark-v10',
    });
    map.addControl(new mapboxgl.NavigationControl());
</script>
<script type="text/javascript">
    var element = document.querySelector('#search-text');
    var autoComplete = new AutoComplete(element);
    element.onkeyup = function () {
        autoComplete.getSuggestionList();
    }
</script>

</body>
</html>