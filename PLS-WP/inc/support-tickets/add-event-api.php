<?php 

add_action('rest_api_init', function () {
    register_rest_route('support-tickets', '/add-event/', array(
        'methods' => 'POST',
        'callback' => 'add_event_to_support_ticket_function',
    ));
});

function add_event_to_support_ticket_function(WP_REST_Request $request) {
    $parameters = $request->get_params();

    $request_text = $request->get_param('body');
    $support_user = isset($parameters['user_id']) ? $parameters['user_id'] : '';
    $severityValue = isset($parameters['severity']) ? $parameters['severity'] : '';
    $title = isset($parameters['title']) ? $parameters['title'] : '';
    $support_user = isset($parameters['user_id']) ? $parameters['user_id'] : '';
    $ticket_id = isset($parameters['ticket_id']) ? $parameters['ticket_id'] : '';
    $message_body = isset($parameters['body']) ? $parameters['body'] : '';

    // Create a new support-ticket post
    $post_id = wp_insert_post(array(
        'post_title' => "Tibetan Support Ticket " . wp_generate_uuid4(),

        'post_type' => 'support-ticket-respo',
        'post_status' => 'publish'
    ));

    // Save values to ACF fields
    update_field('response_type', 'event', $post_id);

    update_field('severity', $severityValue, $post_id);
    update_field('title', $title, $post_id);
    update_field('parent_ticket', $ticket_id, $post_id);
    update_field('user', $support_user, $post_id);
    update_field('ticket_status', 'open', $post_id);

    $thing = array(
        'event_type' => $severityValue,
        'event_message' => $message_body,

    );
    update_field('event_fields', $thing, $post_id);

    if ($post_id) {
        
        // Send email with post permalink
        $post_permalink = get_permalink($ticket_id);
        $to = 'hugh@studioscience.com';
        $subject = 'New Support Ticket Event';
        $message = "A support ticket you're assigned to has a new event.\nYou can view it here: " . $post_permalink;
        wp_mail($to, $subject, $message);

        return new WP_REST_Response('Support ticket event created successfully!', 200);
    } else {
        return new WP_REST_Response('Failed to create support ticket event.', 500);
    }
}

    add_action('wp_ajax_add_event_modal', 'add_event_modal_function');

    function add_event_modal_function() {
    
        $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0; // Default to 0 or some other error code if not set
        get_template_part('modals/add-event-modal', null, array('ticket_id' => $ticket_id));
        wp_die(); // Always end AJAX functions with wp_die
    }