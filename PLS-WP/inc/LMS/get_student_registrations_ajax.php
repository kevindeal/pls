<?php

add_action('wp_ajax_get_student_registrations', 'get_student_registrations');
add_action('wp_ajax_nopriv_get_student_registrations', 'get_student_registrations');

function get_student_registrations() {
    $userID = $_POST['userID']; // ACF field, id for the student, used for Rustici Engine

    // Get the user by ID
    $student_user = get_user_by('ID', $userID);

    if (!$student_user) {
        // Handle the case when the user is not found
        wp_send_json_error('User not found');
    }

    $args = array(
        'post_type' => 'enrollment',
        'meta_key' => 'enrolled_user',
        'post_status' => 'publish',
        'meta_value' => $userID,
    );

    $query = new WP_Query($args);

    $enrollments = $query->get_posts();

    if (!$enrollments) {
        // Handle the case when the user is not found
        wp_send_json_error('No enrollments found $userID: ' . $userID);
    }

    $all_registrations = array();

   
    $lesson_records = array();
    foreach ($enrollments as $enrollment) {
        $learning_records = get_field('learning_records', $enrollment);
        if ($learning_records) {
            foreach ($learning_records as $learning_record) {
                // $current_registration_id = get_field('current_registration_id', $learning_record);
                $lesson_records[] = array(
                    'learning_record'=> $learning_record,
                    'current_registration_id'=> $current_registration_id,
                    'enrollment'=> $enrollment
                );
            }
        }
    }

    wp_send_json_success($lesson_records);

    // $lesson_records now contains the lesson_records where the key "event_type" equals "registration"

    // Continue with the rest of your code...
    // Define Rustici Engine API parameters
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';

    if (!$result['success']) {
        $result['student_user'] = $student_user;
        $result['enrollment_records'] = $enrollment_records;

        wp_send_json_error($result);
    } else {
       $result['student_user'] = $student_user;
       $result['enrollment_records'] = $enrollment_records;

        wp_send_json_success($result);
    }

    wp_die(); // Always end AJAX functions with wp_die
}
