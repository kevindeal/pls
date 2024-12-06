<?php
/**
 * Template Name: Student Dashboard Template
 * 
 */
?>
<?php get_header() ?>
<?php

// ROLE CHECK -----------------
// Check if user is logged in
if ( is_user_logged_in() ) {
    // Get the current user
    echo get_template_part('page-templates/student-dashboard/student-dashboard-view');
    } else {
    // Content to show if no user is logged in
        echo 'Please log in to view this content.';
    }
?>
</div>
<?php
    // get_footer();
    wp_footer();
?>