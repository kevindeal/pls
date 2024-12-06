<?php
// Prevent direct access to the file
defined( 'ABSPATH' ) || exit;

function get_course_info($course_id) {

    // Verify that the user ID is valid
    if (empty($course_id) || !is_numeric($course_id)) {
        return new WP_Error('invalid_course_id', 'Invalid course ID provided.');
    }

    // Get the Course Post
    $course = get_post($course_id);

    // Check if course is found
    if (empty($course)) {
        return array(); // Return an empty array if no course is found
    }

    // Process and return the course data
    $course_data = array();
    
    // Extract and format the data you need from each enrollment
    $course_acf = get_fields($course->ID);
    $course_data[] = array(
        'course_id' => $course->ID,
        'course_title' => $course->post_title,
        'acf' => $course_acf
        // Add more fields as needed
    );

    return $course_data;
}
