<?php 
/*
Template Name: Logged In User Homepage
*/
get_header();

// ROLE CHECK -----------------
    // Check if user is logged in
    
    if ( is_user_logged_in() ) {
        // Get the current user
        $current_user = wp_get_current_user();

        if (in_array('administrator', $current_user->roles)) {
            // PLS Admin View
            echo get_template_part('page-templates/logged-in-homepage/pls-admin-view');
        } elseif (in_array('client_group_admin', $current_user->roles)) {
            // Group Admin View
            get_template_part('page-templates/logged-in-homepage/group-admin-view');
        } elseif (in_array('student', $current_user->roles)) {
            // Student View
            get_template_part('page-templates/logged-in-homepage/student-view');
        }
    } else {
       //  'custom_redirect_logic' in functions.php redirects to the login page
    }
?>
<?php wp_footer(); ?>