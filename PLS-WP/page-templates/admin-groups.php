<?php 
    /*
    * Template Name: Admin Dashboard - Groups
    */
    get_header();
    wp_head();
?>


<div class="flex h-screen">
    <div class="h-full">
        <!-- Left-side nav bar content -->
        <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
    </div>
    <div style="width: 80%;">
        <!-- Main area content -->
        
        <?php get_template_part('template-parts/admin/people/main'); ?>

    </div>
</div>

