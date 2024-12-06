<?php 
    require_once get_template_directory() . '/inc/support-tickets/get-responses.php';
    require_once get_template_directory() . '/inc/support-tickets/create-ticket-api.php';
    require_once get_template_directory() . '/inc/support-tickets/add-reply-api.php';
    require_once get_template_directory() . '/inc/support-tickets/add-event-api.php';
    
    add_action('acf/save_post', function($post_id) {
        // Check for your specific form and post type
        if (isset($_POST['parent_ticket'])) {
            update_field('parent_ticket', sanitize_text_field($_POST['parent_ticket']), $post_id);
        }
    }, 20);

    add_action('acf/save_post', 'save_additional_acf_fields', 20);
        function save_additional_acf_fields($post_id) {
            // Ensure we're saving the correct post type
            if (get_post_type($post_id) !== 'support-ticket-respo') {
                return;
            }

            // Example: Save the current user ID as the responding user
            $responding_user_id = get_current_user_id();
            update_field('responding_user', $responding_user_id, $post_id);

            // Example: Save a parent post ID
            // $parent_post_id = 'some_logic_to_get_parent_post_id'; // Replace with your logic
            // update_field('parent_post', $parent_post_id, $post_id);
    }

