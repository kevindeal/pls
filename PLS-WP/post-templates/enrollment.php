<?php
/**
 * Template Name: Enrollment Template
 */
?>
<?php

    // ROLE CHECK -----------------
    // Check if user is logged in
    if ( is_user_logged_in() ) {
        // Get the current user
        $current_user = wp_get_current_user();
        
        // echo 'Welcome, ' . $current_user->user_login . '!';

        // Check if the user ID is 2 for the admin view
        // Replace 'desired_role' with the actual role you're checking for

        if (in_array('administrator', $current_user->roles)) {
            // The user has the 'desired_role' role
            echo get_template_part('post-templates/enrollment/pls-admin-view');
        } elseif (in_array('client_group_admin', $current_user->roles)) {
            echo get_template_part('post-templates/enrollment/group-admin-view');
        } else {
            // Default content or template part for other users
            echo get_template_part('/post-templates/subgroups/subgroupView');
        }
    } else {
        // Content to show if no user is logged in
        
        echo 'Please log in to view this content.';

    }
?>
<?php wp_footer(); ?>