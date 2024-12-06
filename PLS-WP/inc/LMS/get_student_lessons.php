<?php
// Prevent direct access to the file
defined( 'ABSPATH' ) || exit;

function get_student_lessons($user_id) {

    // Verify that the user ID is valid
    if (empty($user_id) || !is_numeric($user_id)) {
        return new WP_Error('invalid_user_id', 'Invalid user ID provided.');
    }

    // Define the query arguments
    $args = array(
        'post_type' => 'enrollment',
        'posts_per_page' => -1,      // Retrieve all matching enrollments
        'meta_query' => array(
            array(
                'key' => 'enrolled_user',
                'value' => $user_id,
                'compare' => '='
            )
        )
    );

    // Perform the query
    $enrollments = get_posts($args);

    // Check if enrollments are found
    if (empty($enrollments)) {
        return array(); // Return an empty array if no enrollments are found
    }

    // Process and return the enrollment data
    $enrollment_data = array();
    foreach ($enrollments as $enrollment) {
        // Extract and format the data you need from each enrollment
        // For example, you might want to include the enrollment ID and the title
        $enrollment_acf = get_fields($enrollment->ID);
        $enrollment_data[] = array(
            'enrollment_id' => $enrollment->ID,
            'enrollment_title' => $enrollment->post_title,
            'acf' => $enrollment_acf
            // Add more fields as needed
        );
    }

    return $enrollment_data;
}
