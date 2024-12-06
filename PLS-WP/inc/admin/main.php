<?php

// Add AJAX handler for the modal
add_action('wp_ajax_get_add_new_user_modal_ajax', 'get_add_new_user_modal_ajax');
add_action('wp_ajax_nopriv_get_add_new_user_modal_ajax', 'get_add_new_user_modal_ajax');

function get_add_new_user_modal_ajax() {
    // Process AJAX request here
    
    // Return the Tailwind CSS modal div
    $modal_html = get_template_part('modals/add-new-user-modal');
    
    echo $modal_html;
    
    wp_die();
}

// Add AJAX handler for the modal
add_action('wp_ajax_get_add_new_group_modal_ajax', 'get_add_new_group_modal_ajax');
add_action('wp_ajax_nopriv_get_add_new_group_modal_ajax', 'get_add_new_group_modal_ajax');

function get_add_new_group_modal_ajax() {
    // Process AJAX request here
    
    // Return the Tailwind CSS modal div
    $modal_html = get_template_part('modals/add-new-group-modal');
    
    echo $modal_html;
    
    wp_die();
}
