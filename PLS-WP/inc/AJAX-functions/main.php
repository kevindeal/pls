<?php 
function your_custom_ajax_handler() {
    // Do your server-side processing here

    get_template_part('/template-parts/blocks/clientProfile/courses-ajax'); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_courses_and_lessons_tp', 'your_custom_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_courses_and_lessons_tp', 'your_custom_ajax_handler'); // For non-logged-in users

function groupDetail_ajax_handler() {
    // Do your server-side processing here

    get_template_part('/template-parts/blocks/clientProfile/groupDetails-ajax'); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_group_details_tp', 'groupDetail_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_group_details_tp', 'groupDetail_ajax_handler'); // For non-logged-in users

function invite_new_user_to_group_modal_ajax_handler() {
    // Do your server-side processing here
    $group_id = $_POST['group_id'];

    get_template_part('/modals/invite-new-user-to-group-modal', false, array('group_id' => $group_id)); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_invite_new_user_to_group_modal', 'invite_new_user_to_group_modal_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_invite_new_user_to_group_modal', 'invite_new_user_to_group_modal_ajax_handler'); // For non-logged-in users


    function create_new_user_invite_ajax_handler() {
        // Do your server-side processing here
        $user_email = $_POST['user_email'];
        $invite_type = $_POST['user_type'];
        $group_id = $_POST['group_id'];

        $invite_code = wp_generate_uuid4();
        $authCode = wp_generate_uuid4();

        // Create a new post of type "invite"
        $post_args = array(
            'post_title'   => 'Invite - ' . $invite_code,
            'post_type'    => 'invite',
            'post_status'  => 'publish'
        );
        $post_id = wp_insert_post($post_args);

        // Add meta fields to the post
        update_field('invite_code', $invite_code, $post_id);
        update_field('invite_type', $invite_type, $post_id);
        update_field('email_address', $user_email, $post_id);
        update_field('invite_auth_code', $authCode, $post_id);
        update_field('inviting_agency_group', $group_id, $post_id);


        wp_mail($user_email, 'You have been invited to join [Your Site]', "You have been invited to join [Your Site]. Please click the link below to complete your registration: [Your Site]/student-user-onboarding?authCode=$authCode");
        wp_send_json_success($invite_code);

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_create_new_user_invite_ajax', 'create_new_user_invite_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_create_new_user_invite_ajax', 'create_new_user_invite_ajax_handler'); // For non-logged-in users

function groupDetail_single_subscription_ajax_handler() {
    // Do your server-side processing here

    get_template_part('/template-parts/blocks/clientProfile/single-subscription-ajax'); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_group_details_single_subscription_tp', 'groupDetail_single_subscription_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_group_details_single_subscription_tp', 'groupDetail_single_subscription_ajax_handler'); // For non-logged-in users

function enroll_user_modal_ajax_handler() {
    $course_id = $_POST['course_id'];
    $group_id = $_POST['group_id'];
    $subscription_id = $_POST['subscription_id'];
    $seats_available = $_POST['seats_available'];

    get_template_part('/modals/enroll-user-modal-ajax', null, array(
        'course_id' => $course_id,
        'group_id' => $group_id,
        'subscription_id' => $subscription_id,
        'seats_available' => $seats_available
    )); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_enroll_user_modal_ajax', 'enroll_user_modal_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_enroll_user_modal_ajax', 'enroll_user_modal_ajax_handler'); // For non-logged-in users

function create_enrollment_ajax_handler() {
    $course_id = $_POST['course_id'];
    $user_ids = $_POST['user_ids'];
    $subgroup_id = $_POST['subgroup_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $group_id = $_POST['group_id'];
    $subscription_id = $_POST['subscription_id'];
    $seats_available = $_POST['seats_available'];

    wp_send_json_success(array(
        'course_id' => $course_id,
        'user_ids' => $user_ids,
        'subgroup_id' => $subgroup_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'group_id' => $group_id,
        'subscription_id' => $subscription_id,
        'seats_available' => $seats_available
    ));
    
    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_create_enrollment_ajax', 'create_enrollment_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_create_enrollment_ajax', 'create_enrollment_ajax_handler'); // For non-logged-in users

function subgroup_details_tp_ajax_handler() {

    $group_info = $_POST['group_info'];

    get_template_part('/inc/AJAX-functions/subgroup-details-ajax', null, array(
        'group_info' => $group_info
    )); // Load your template part

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_subgroup_details_tp_ajax', 'subgroup_details_tp_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_subgroup_details_tp_ajax', 'subgroup_details_tp_ajax_handler'); // For non-logged-in users

function subgroup_members_tp_ajax_handler() {

    $group_info = $_POST['group_info'];

    get_template_part('post-templates/subgroups/template-parts/subgroup-members', 
        null, 
        array(
            'group_info' => $group_info
        )
    );

    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_subgroup_members_tp_ajax', 'subgroup_members_tp_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_subgroup_members_tp_ajax', 'subgroup_members_tp_ajax_handler'); // For non-logged-in users