<?php 
    /*
    * Template Name: Admin Reports
    */
    get_header();
    wp_head();
    $userID = $_GET['userID'] ?? null;
    $registrationID = $_GET['registrationID'] ?? null;
?>

<div class="flex h-screen">
    <div class="h-full">
        <!-- Left-side nav bar content -->
        <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
    </div>
    <div style="width: 80%;">
        <!-- Main area content -->
        <?php 
        
            if( $registrationID != null ) { 
                get_template_part('template-parts/admin/reports/registration'); // ?registrationID=123 - for a specific registration
            } else
            if( $userID != null ) { 
                get_template_part('template-parts/admin/reports/user'); // ?userID=123 - for a specific user
            } else { 
                get_template_part('template-parts/admin/reports/main'); // No query string - show the main reports page
            }

        ?>
        
    </div>
</div>
