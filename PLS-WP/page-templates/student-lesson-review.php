<?php
/**
 * Template Name: Student Lesson Review Template
 * 
 */

get_header();
?>

<?php

// ROLE CHECK -----------------
// Check if user is logged in
if ( is_user_logged_in() ) {

    if ( isset($_GET['r']) ) {
        $registration_id = $_GET['r'];
        $enrollment_id = $_GET['e'];
        echo get_template_part('page-templates/student-dashboard/student-lesson-review', null, array('registration_id' => $registration_id, 'enrollment_id' => $enrollment_id));
    } else {
        // Content to show if no user is logged in
        echo 'Please provide a registration ID.';
    }
}
?>
</div>
<?php
    // get_footer();
    wp_footer();
?>