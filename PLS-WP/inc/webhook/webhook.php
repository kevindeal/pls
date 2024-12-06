<?php

add_action('rest_api_init', function () {
    register_rest_route('rusticiWebhook/', 'changes', array(
        'methods' => 'POST',
        'callback' => 'handle_webhook',
        'permission_callback' => function () {
            return true;  // Implement your security checks here
        }
    ));
});

function handle_webhook($request) {
    $data = $request->get_json_params();


    if(!isset($data['body'])) {
        wp_send_json_error('No body found');
    }

    $body = $data['body'];


    $course_id = $body['course']['id']; // The course ID for the course on Rustici Engine
    $registration_id = $body['id']; // The registration ID for the registration on Rustici Engine
    
  
    $learner_id = $body['learner']['id'];
    $user_query = new WP_User_Query(array(
        'meta_key' => 'learner_id',
        'meta_value' => $learner_id,
    ));

    $users = $user_query->get_results();
    $user = $users[0];

    $enrollment_query = new WP_Query(array(
        'post_type' => 'enrollment',
        'meta_key' => 'course',
        'meta_value' => $course_id,
        'meta_key' => 'enrolled_user',
        'meta_value' => $user->ID,

    ));

    $enrollments = $enrollment_query->get_posts();
    $enrollment_id = $enrollments[0]->ID;

    $lesson = get_field('course', $enrollment_id);
    $learning_records = get_field('learning_records', $enrollment_id);
    $json = json_encode($learning_records);
    $lesson_id = $lesson->ID;


    // Data to be added
    $row_data = array(
        'event_time'     => date('Y-m-d H:i:s'),
        'event_type' => 'webhook',
        'event_data' => array(
            'course_id' => $course_id,
            'learner_id' => $learner_id,
            'registration_id' => $registration_id,
            'body' => $data,
        )
    );

    // Field key of the repeater field (different from the field name)
    $field_key = 'field_65ab3e3d51bbf';

    // Post ID to which this repeater field is attached
    $user_id = $user->ID;
    
    // create_enrollment_learning_record($course_id, $lesson_id, $learner_id, $registration_id, $enrollment_id, 'webhook event');

    // add_lesson_event_to_learning_record($enrollmentID, $lessonID, $registration_event);

    foreach ($learning_records as &$item) {
        if ($item['current_registration_id'] == $registration_id) {

            // Append the new event to the lesson_events of the current item
            $item['lesson_events'][] = $row_data;
            $item['lesson_start_time'] = date('Y-m-d H:i:s');
            $item['lesson_end_time'] = date('Y-m-d H:i:s');
            $item['current_registration_id'] = $registration_id;
            $item['completed'] = true;
            $item['completed_score'] = $body['score']['scaled'];


            // Break the loop if you only need to add this to the first matching lesson
            // break;
            update_field('learning_records', $learning_records, $enrollment_id);
            // return $item;
        }
    }
    
        // Data to be added
        $row_data = array(
            'course_id'     => date('Y-m-d H:i:s'),
            'registration_id' => $enrollment_id,
            'created_at'     => date('Y-m-d H:i:s'),
        );

    $acf_user_id = 'user_' . $user_id;

        // Add the new row
        add_row($field_key, $row_data, $acf_user_id);  
        // Get user profile for the user
        // make_certification_for_student();
    // Send a response if needed
    wp_send_json_success('OK');
}


function check_for_certificate_completion($course_id, $learner_id, $registration_id, $enrollment_id) {
    $learning_records = get_field('learning_records', $enrollment_id);
    $lesson = get_field('course', $enrollment_id);
    $lesson_id = $lesson->ID;

    foreach ($learning_records as &$item) {
        if ($item['current_registration_id'] == $registration_id) {
            $item['completed'] = true;
            $item['completed_score'] = 100;
            update_field('learning_records', $learning_records, $enrollment_id);
        }
    }
}
   
