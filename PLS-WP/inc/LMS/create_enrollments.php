<?php
// Prevent direct access to the file
defined( 'ABSPATH' ) || exit;

function create_enrollments($request) {
    $parameters = $request->get_json_params();
    $user_ids = $parameters['user_ids']; // Array of user IDs
    $course_id = $parameters['course_id']; // Course Post ID
    $subgroup_id = $parameters['subgroup_id']; // Subgroup Post ID
    $subscription_id = $parameters['subscription_id']; // Subscription Post ID
    $start_date = $parameters['start_date']; // Start date for the enrollment
    $end_date = $parameters['end_date']; // End date for the enrollment

    // Validation (optional, but recommended)
    if (empty($user_ids) || !is_array($user_ids)) {
        return new WP_Error('invalid_data', 'User IDs are required and must be an array', array('status' => 400));
    }

    // Process each user ID
    foreach ($user_ids as $user_id) {
        // Create a new enrollment post for each user
        $post_id = wp_insert_post(array(
            'post_title' => "Enrollment for User $user_id",
            'post_type' => 'enrollment', 
            'post_status' => 'publish',
            // Additional post settings as needed
        ));

        $course_data = get_course_info($course_id);
        $lesson_ids = $course_data[0]['acf']['curriculum'];

        if ($lesson_ids) {
            foreach ($lesson_ids as $lesson) {
                // Create a new acf field learning record for each lesson
                $new_row = array(
                    'lesson' => $lesson['lesson'],
                    'access_release_date' => date($start_date),
                    'dump' => $lesson, // testing
                    // Add more sub-fields as needed
                );
                $selector = 'learning_records'; // Replace with the name of your repeater field

                $success = add_row($selector, $new_row, $post_id);

                if (!$success) { // If the row was not added, return an error
                    return new WP_REST_Response('There was an error adding lesson ' . $lesson['lesson'], 200);
                }
            }
        }

        if ($post_id) {
            // Update ACF fields or meta for the new post
            update_field('course', $course_id, $post_id);
            update_field('enrolling_subgroup', $subgroup_id, $post_id);
            update_field('subscription', $subscription_id, $post_id);
            update_field('enrolled_user', $user_id, $post_id);
            
            $current_date = date('Ymd'); // Formats the current date as YYYYMMDD
            update_field('creation_date', $current_date, $post_id);
            update_field('enrollment_start_date', date($start_date), $post_id);
            update_field('enrollment_end_date', $end_date, $post_id);

            update_field('can_enroll', false, $subscription_id);
            // Add more fields as needed!
        }
    }

    return new WP_REST_Response('Enrollments created successfully', 200);
}