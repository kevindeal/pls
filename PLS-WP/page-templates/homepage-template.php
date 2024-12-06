<?php
/**
 * Template Name: Homepage Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>


<?php get_header() ?>


<div class="flex bg-bgGray h-screen p-10 ">

    <div class="w-full m-10 h-auto bg-white border-borderGray border-2 rounded-xl py-3 px-4">
    <?php 
            while ( have_posts() ) : the_post();
        ?>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        <?php
            endwhile; // End of the loop.
        ?>    
    </div>

</div>