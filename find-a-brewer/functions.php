<?php
function brewery_app_scripts() {
    wp_enqueue_style('brewery_app_style', get_template_directory_uri() . '/assets/css/app.css');
    wp_enqueue_script('brewery_app_script', get_template_directory_uri() . '/assets/js/app.js', array(), '1.0.0', true);
    wp_localize_script('brewery_app_script', 'wpApiSettings', array(
        'restURL' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action("wp_enqueue_scripts", "brewery_app_scripts");

add_action("init", "register_brewery_cpt");
function register_brewery_cpt() {
    register_post_type('brewery', [
        'label' => "Breweries",
        'public' => true,
        'capabitlity_type' => 'post',
        'show_in_rest' => true,
        'rest_base' => "brewery",
        "has_archive" => true
    ]);
}

if( ! wp_next_scheduled('update_brewery_list')) {
    wp_schedule_event(time(), 'weekly', 'get_breweries_from_api');
}

add_action("wp_ajax_nopriv_get_breweries_from_api", "get_breweries_from_api");
add_action("wp_ajax_get_breweries_from_api", "get_breweries_from_api");
function get_breweries_from_api() {
    
    $file = get_stylesheet_directory() . '/report.txt'; 
    $current_page =(!empty($_POST['current_page'])) ? $_POST['current_page'] : 1;
    $breweries = [];
    $url = 'https://api.openbrewerydb.org/breweries/?page=' . $current_page . 
            '&per_page=50';
    $results = wp_remote_retrieve_body(wp_remote_get($url));
    file_put_contents($file, "Current page : " . $current_page . "\n\n", FILE_APPEND);
    $jsonResults = json_decode($results);
    if(!is_array($jsonResults) || is_wp_error($jsonResults) || empty($jsonResults)) {
        return false;
    }
    $breweries[] = $jsonResults;
    foreach( $breweries[0] as $brewery) {
        $brewery_slug = sanitize_title($brewery->id);
        $existing_brewery = get_page_by_path($brewery_slug, 'OBJECT', 'brewery');

        if($existing_brewery === null) {
            $inserted_brewery = wp_insert_post([
                'post_name' => $brewery_slug,
                'post_title' => $brewery_slug,
                'post_type' => 'brewery',
                'post_status' => 'publish'
            ]);
    
            if( is_wp_error($inserted_brewery)) {
                continue;
            }
    
            $fillable = [
                'field_622c3beb43901' => 'name',
                'field_622c3c0f7ba1a' => 'brewery_type',
                'field_622c3c1ddd66f' => 'street',
                'field_622c3c360c81c' => 'city',
                'field_622c3c2a5d5ad' => 'state',
                'field_622c3c3e84caa' => 'postal_code',
                'field_622c3c5d0dac8' => 'country',
                'field_622c3c65d04ba' => 'longitude',
                'field_622c3c70d6916' => 'latitude',
                'field_622c3c7d37592' => 'phone',
                'field_622c3c8823122' => 'website',
                'field_622c3c99d283c' => 'updated_at',
            ];
    
            foreach($fillable as $key => $name) {
                update_field($key, $brewery->$name, $inserted_brewery);
            }
    
        } else {
            $existing_brewery_id = $existing_brewery->ID;
            $existing_brewery_timestamp = get_field('updated_at', $existing_brewery_id);
            $fillable = [
                'field_622c3beb43901' => 'name',
                'field_622c3c0f7ba1a' => 'brewery_type',
                'field_622c3c1ddd66f' => 'street',
                'field_622c3c360c81c' => 'city',
                'field_622c3c2a5d5ad' => 'state',
                'field_622c3c3e84caa' => 'postal_code',
                'field_622c3c5d0dac8' => 'country',
                'field_622c3c65d04ba' => 'longitude',
                'field_622c3c70d6916' => 'latitude',
                'field_622c3c7d37592' => 'phone',
                'field_622c3c8823122' => 'website',
                'field_622c3c99d283c' => 'updated_at',
            ];
            foreach($fillable as $key => $name) {
                update_field($key, $brewery->$name, $existing_brewery_id);
            }
        }
    
        $current_page = $current_page + 1;
    
        wp_remote_post(admin_url('admin-ajax.php?action=get_breweries_from_api'), [
            'blocking' => false,
            'sslverify' => false,
            'body' => [
                'current_page' => $current_page
            ]
        ]);
        }

}