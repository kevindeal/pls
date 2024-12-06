<?php
/**
 * Template Name: Subgroup Template
 * Template Post Type: Subgroup
 */

 ?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Other links and scripts -->
        <title>
            <?php echo the_title() ?>
        </title>

        <?php
            get_header();
            // get_header();
        ?> <!-- This is important for WordPress to load additional styles and scripts -->
    </head>
    <body <?php body_class(); ?>>
    <div class="flex bg-bgGray h-screen ">

<?php 

 global $group_homepage_id;
 $group_homepage_id = 256; // get_query_var('group_homepage_id', false);

 
 if ($group_homepage_id) {
    // Fetch the post using the ID
    $post = get_post($group_homepage_id);

    // Check if the post exists
    if ($post) {
        // Set up post data for template tags
        setup_postdata($post);
        
        // Now you can use template tags like the_title(), the_content(), etc., to display the post's data
        echo get_template_part('post-templates/subgroups/group-admin-view');
        // After your loop, reset post data to ensure global post data is restored for subsequent queries
        wp_reset_postdata();
    } else {
        // Post not found
        echo 'Group homepage not found.';
    }
}
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
            echo get_template_part('post-templates/subgroups/admin-subgroupView');
        } elseif (in_array('client_group_admin', $current_user->roles)) {
            
        } else {
            // Default content or template part for other users
            echo get_template_part('/post-templates/subgroups/subgroupView');
        }
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