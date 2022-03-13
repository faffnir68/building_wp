<?php get_header() ?>

<?php 
$args = [
    'post_type' => 'brewery',
    'order' => 'DESC',
];
$breweries = new WP_Query(); 
if($breweries->have_post()): while($breweries->have_post()): $breweries->the_post();
?>
<ul>
    <li><?php the_title() ?></li>
</ul>
<?php
endwhile; endif;
?>

<?php get_footer() ?>