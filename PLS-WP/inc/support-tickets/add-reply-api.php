<?php 


add_action( 'rest_api_init', function () {
    register_rest_route( 'support-tickets', '/add-reply/', array(
            'methods' => 'POST',
            'callback' => 'my_custom_functionh',
        )
    );
});

function my_custom_functionh(WP_REST_Request $request) {
    $parameters = $request->get_params();
    $helloValue = isset($parameters['hello']) ? $parameters['hello'] : '';
    $severityValue = isset($parameters['severity']) ? $parameters['severity'] : '';
    $subjectValue = isset($parameters['subject']) ? $parameters['subject'] : '';
    $bodyValue = isset($parameters['body']) ? $parameters['body'] : '';
    $userValue = isset($parameters['user_id']) ? $parameters['user_id'] : '';
    $ticketValue = isset($parameters['ticket_id']) ? $parameters['ticket_id'] : '';


    // Create a new support-ticket reponse post
    $post_id = wp_insert_post(array(
        'post_title' => "Response to ticket 1251-2",
        'post_type' => 'support-ticket-respo',
        'post_status' => 'publish'
    ));

    // Save values to ACF fields
    update_field('parent_ticket', $ticketValue, $post_id);

    update_field('user', $userValue, $post_id);
    update_field('response_type', 'text', $post_id);
    
    $thing = array(
        'responding_user' => "pending",
        'response_text' => $bodyValue,

    );
    update_field('response_fields', $thing, $post_id);



    if ($post_id) {
        
        // Send email with post permalink
        $post_permalink = get_permalink($ticketValue);
        $to = 'hugh@studioscience.com';
        $subject = 'New Support Ticket Response';
        $message = "A support ticket you're assigned to has a new response.\nYou can view it here: " . $post_permalink;
        wp_mail($to, $subject, $message);

        return new WP_REST_Response('Support ticket reply created successfully!', 200);
    } else {
        return new WP_REST_Response('Failed to create support ticket reply.', 500);
    }
}

function bloop($request) {
    // $parameters = $request->get_json_params();
    // $result = "Hello";

                // If successful
                return new WP_REST_Response('User added successfully', 200);
           
    }

    add_action('wp_ajax_add_reply_modal', 'add_reply_modal_function');

    function add_reply_modal_function() {
       
        $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0; // Default to 0 or some other error code if not set
        get_template_part('modals/add-reply-modal', null, array('ticket_id' => $ticket_id));
        wp_die(); // Always end AJAX functions with wp_die
    }
