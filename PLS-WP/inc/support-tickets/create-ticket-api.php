<?php
add_action('rest_api_init', function () {
    register_rest_route('support-tickets', '/create/', array(
        'methods' => 'POST',
        'callback' => 'create_support_ticket_function',
    ));
});

function create_support_ticket_function(WP_REST_Request $request) {
    $parameters = $request->get_params();

    $request_text = $request->get_param('body');
    $support_user = isset($parameters['user_id']) ? $parameters['user_id'] : '';
    $severityValue = isset($parameters['severity']) ? $parameters['severity'] : '';
    $title = isset($parameters['title']) ? $parameters['title'] : '';
    $support_user = isset($parameters['user_id']) ? $parameters['user_id'] : '';

    // Create a new support-ticket post
    $post_id = wp_insert_post(array(
        'post_title' => "Support Ticket - " . $title,
        'post_type' => 'support-ticket',
        'post_status' => 'publish'
    ));

    // Set default post template
    update_post_meta($post_id, '_wp_page_template', 'post-templates/support-ticket.php');

    // Save values to ACF fields
    update_field('request_text', $request_text, $post_id);
    update_field('severity', $severityValue, $post_id);
    update_field('title', $title, $post_id);
    update_field('support_user', $support_user, $post_id);
    update_field('ticket_status', 'open', $post_id);

    // Get the user with the username 'pls@dmin'
    $adminUser = get_user_by('login', 'pls@dmin');

    if ($adminUser) {
        // User found
        $user_id = $user->ID;

        update_field('assigned_to', $adminUser, $post_id);
        
        $post_permalink = get_permalink($post_id);
        $adminUser = get_user_by('login', 'pls@dmin');
        // $to = $adminUser ? $adminUser->user_email : '';

        $to = $adminUser ? $adminUser->user_email : '';
        $subject = 'Support Ticket Created';
        $message = "A support ticket has been created and assigned to you.\nYou can view it here: " . $post_permalink;
        wp_mail($to, $subject, $message);
        // Do something with the user
    } else {
        // User not found
        // Handle the case when the user is not found

        $post_permalink = get_permalink($post_id);
        $to = 'hugh@studioscience.com';
        $subject = 'Unassigned - Support Ticket Created';
        $message = "A support ticket has been created with no assignment\nYou can view it here: " . $post_permalink;
        wp_mail($to, $subject, $message);
    }

    if ($post_id) {
        // Send email with post permalink


        return new WP_REST_Response('Support ticket created successfully!', 200);
    } else {
        return new WP_REST_Response('Failed to create support ticket.', 500);
    }
}

add_action('wp_ajax_create_support_ticket_modal', 'create_support_ticket_modal_function');

function create_support_ticket_modal_function() {
    // Here you can return a simple message or basic HTML
    
        echo get_template_part('modals/create-support-ticket');

    // If you want to return a more complex HTML structure, you could do something like:
    // echo '<div><p>Some dynamic content...</p></div>';

    wp_die(); // Always end AJAX functions with wp_die
}

/*
function my_post_save_action($post_id) {
    // Ensure this is a support ticket and a new post
    if (get_post_type($post_id) == 'support-ticket' && get_post_status($post_id) == 'auto-draft') {
        // Your custom actions, for example:
        // Sending an email notification
        // $post_data = get_post($post_id);
        // $user_email = get_field('user_email_field', $post_id); // Assuming you have a field for user email
        // wp_mail($user_email, 'Your Support Ticket Submitted', 'Thank you for submitting your ticket. We will get back to you soon.');
    }
}
*/

// add_action('acf/save_post', 'my_post_save_action', 20);