<?php get_header() ?>
archive brewery
<?php 
$args = [
    'post_type' => 'brewery',
    'order' => 'DESC',
    'orderby' => 'date',
];
$breweries = new WP_Query($args); 
if($breweries->have_posts()): ?>
<ul class="breweries-list">
    <?php while($breweries->have_posts()): 
        $breweries->the_post();?>

    <li><?php the_title() ?></li>
    
    <?php
endwhile; 
?>
</ul>
<?php
endif;
?>
<button class="btn btn-show-next-breweries">
    Display the 10 next breweries
</button>
<?php if(current_user_can("administrator")): ?>
<div class="add-brewery-box">
    <h3>Add a new brewery</h3>
    <input type="text" name="title" id="" placeholder="Title">
    <textarea name="content" id="" cols="30" rows="10" placeholder="Content"></textarea>
    <button class="btn btn-add-brewery" type="input">Add your brewery</button>
</div>
<?php endif ?>

<?php get_footer() ?>