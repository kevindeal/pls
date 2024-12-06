<?php
/**
 * Template Name: My Custom Post Template2
 * Template Post Type: subgroup
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <?php
            wp_head();
            // get_header();
        ?> <!-- This is important for WordPress to load additional styles and scripts -->
    </head>
    <body <?php body_class(); ?>>
    <div class="flex bg-bgGray h-screen ">
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
        echo get_template_part('post-templates/client-group-profile/adminView');
    } elseif (in_array('client_group_admin', $current_user->roles)) {
        echo get_template_part('post-templates/client-group-profile/groupAdminView');
    }else {
        // Default content or template part for other users
        get_template_part('clientProfile-parts/publicView'); // Assuming it's in the same subdirectory
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