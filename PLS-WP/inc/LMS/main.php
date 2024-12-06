<?php
    require_once get_template_directory() . '/inc/LMS/get_student_lessons.php';
    require_once get_template_directory() . '/inc/LMS/get_course_info.php';
    require_once get_template_directory() . '/inc/LMS/create_enrollments.php';
    require_once get_template_directory() . '/inc/LMS/get_group_subscriptions.php';
    require_once get_template_directory() . '/inc/LMS/get_student_registrations_ajax.php';
    require_once get_template_directory() . '/inc/LMS/get_single_registration_ajax.php';

    require_once get_template_directory() . '/inc/LMS/get_subscription_info.php';

    require_once get_template_directory() . '/inc/LMS/add_lesson_event_to_learning_record.php';
    require_once get_template_directory() . '/inc/LMS/api/get_registration_information_from_rustici.php';
    require_once get_template_directory() . '/inc/LMS/api/get_all_registrations_from_rustici.php';
    require_once get_template_directory() . '/inc/LMS/api/get_all_subscriptions_from_rustici.php';
    require_once get_template_directory() . '/inc/LMS/api/create_rustici_subscription.php';
    
    function create_user_from_ajax() {
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $group_state = $_POST['group_state'];
        $group_city = $_POST['group_city'];
        $group_zipcode = $_POST['group_zipcode'];
        $group_name = $_POST['group_name'];
        $group_category = $_POST['group_category'];
    
        if (!email_exists($email)) { // Check if user already exists
            $password = wp_generate_password(); // Generate random password
            $user_id = wp_create_user($email, $password, $email); // Create user
    
            // Fetch the newly created user
            $user = new WP_User($user_id);
    
            // Set first and last name
            wp_update_user([
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);
    
            // Set user role
            // Replace 'your_custom_role' with the role you want to assign
            $user->set_role('client_group_admin');
    
            // Alternatively, to add a role without removing existing roles
            // $user->add_role('client_group_admin');
    
            // Generate a UUID v4 and store it as user meta
            $uuid = wp_generate_uuid4();
            update_user_meta($user_id, 'user_uuid', $uuid);
    
            create_client_group($user, $group_name, 'This is a test description.', $group_city, $group_zipcode);
            // Send email to the user
            $subject = 'Welcome to [Your Site]';
            $message = "Hello $first_name,\n\nYour new account has been set up.\n\nUsername: $email\nPassword: $password\n\nPlease change your password upon login.\n\nYour UUID is $uuid.";
            wp_mail($email, $subject, $message);
    
            echo 'User created, role assigned, UUID assigned, and email sent!';
        } else {
            echo 'User already exists with this email!';
        }
    
        wp_die(); // Required to terminate immediately and return a proper response
    }
    
    add_action('wp_ajax_create_user_from_ajax', 'create_user_from_ajax'); // For logged-in users
    add_action('wp_ajax_nopriv_create_user_from_ajax', 'create_user_from_ajax'); // For guests
    
    function create_client_group($group_admin_user, $group_name, $group_description, $group_city, $group_zipcode) {
    
        $group_id = wp_insert_post([
            'post_title' => $group_name,
            'post_content' => $group_description,
            'post_type' => 'subgroup',
            'post_status' => 'publish',
        ]);


        update_field('zipcode', $group_zipcode, $group_id);
        update_field('city', $group_city, $group_id);

        // Check if the post was created successfully
        if (!is_wp_error($group_id)) {

            // Assign a term to the post in the 'Agency' taxonomy
            // Replace 'agency_term_id' with the actual term ID or slug you want to assign
            // $term_id_or_slug = wp_generate_uuid4(); // Can be an integer ID or a string slug
            $taxonomy = 'agency'; // Your custom taxonomy's name

            // Use an array if assigning multiple terms
            // wp_set_object_terms($group_id, $taxonomy);
            wp_set_post_terms($group_id, $group_name, $taxonomy);
            
            echo 'Agency and User Created Successfully!';
        } else {
            // Handle error
            echo 'Error in creating subgroup: ' . $group_id->get_error_message();
        }

    
        if ($group_id) {
            echo 'Group created!';
            update_field('pls_id', wp_generate_uuid4(), $group_id);
            update_field('agency_name', $group_name, $group_id);
            update_field('agency_admin', $group_admin_user->ID, $group_id);
            update_field('agency_members', array($group_admin_user->ID), $group_id);
        } else {
            echo 'Group creation failed!';
        }
    
        wp_die(); // Required to terminate immediately and return a proper response
    }

    function create_student_user_from_ajax() {
        $group_id = $_POST['group_id'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $user_state = $_POST['user_state'];
        $user_city = $_POST['user_city'];
        $user_zipcode = $_POST['user_zipcode'];

    
        if (!email_exists($email)) { // Check if user already exists
            $password = wp_generate_password(); // Generate random password
            $user_id = wp_create_user($email, $password, $email); // Create user
    
            // Fetch the newly created user
            $user = new WP_User($user_id);
    
            // Set first and last name
            wp_update_user([
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);
    
            // Set user role
            // Replace 'your_custom_role' with the role you want to assign
            $user->set_role('student');
            $user->set_role('subscriber');
    
            // Alternatively, to add a role without removing existing roles
            // $user->add_role('client_group_admin');
    
            // Generate a UUID v4 and store it as user meta
            $uuid = wp_generate_uuid4();
            update_user_meta($user_id, 'user_uuid', $uuid);

            // Add user to group
            $group = get_post($group_id);
            $group_members = get_field('agency_members', $group_id);
            $group_members[] = $user_id;
            update_field('agency_members', $group_members, $group_id);
    
            // create_client_group($user, $group_name, 'This is a test description.', $group_city, $group_zipcode);
            // Send email to the user
            $subject = 'Welcome to [Your Site]';
            $message = "Hello $first_name,\n\nYour new account has been set up.\n\nUsername: $email\nPassword: $password\n\nPlease change your password upon login.\n\nYour UUID is $uuid.";
            wp_mail($email, $subject, $message);
    
            echo 'User created, role assigned, UUID assigned, and email sent!';
        } else {
            echo 'User already exists with this email!';
        }
    
        wp_die(); // Required to terminate immediately and return a proper response
    }
    
    add_action('wp_ajax_create_student_user_from_ajax', 'create_student_user_from_ajax'); // For logged-in users
    add_action('wp_ajax_nopriv_create_student_user_from_ajax', 'create_student_user_from_ajax'); // For guests
    

function check_invite_code_ajax() {
    $inviteCode = $_POST['inviteCode'];

    $query = new WP_Query(array(
        'post_type' => 'invite',
        'meta_key' => 'invite_code',
        'meta_value' => $inviteCode,
        'meta_compare' => '=',
    ));

    $posts = $query->get_posts();

    if (empty($posts)) {
        echo 'Invite code is invalid - No Match! - ' . $inviteCode . ' - ' . var_dump($posts) . ' - ' . var_dump($query);
        // wp_send_json_error('Invite code is invalid - No Match!');
    } else {
        $invitePost = $posts[0];
        $invite_fields = get_fields($invitePost->ID);
        // echo var_dump($posts);
        if ($invite_fields['invite_type'] === 'student') {
            wp_send_json_success("student-user-onboarding?authCode=" . $invite_fields['invite_auth_code']);
        }
    }
    
    wp_die(); // Required to terminate immediately and return a proper response
}
    
add_action('wp_ajax_check_invite_code_ajax', 'check_invite_code_ajax'); // For logged-in users
add_action('wp_ajax_nopriv_check_invite_code_ajax', 'check_invite_code_ajax'); // For guests


function get_cert_template_tp_for_editor() {


    $certTemplateID = $_POST['certTemplateID'];

    get_template_part('template-parts/certificate_type_ajax_tp', null, array('certTemplateID' => $certTemplateID)); // Load your template part
    // wp_send_json_success($html);
    wp_die(); // This is required to terminate immediately and return a proper response
}

add_action('wp_ajax_certificate_template_editor_ajax_tp', 'get_cert_template_tp_for_editor'); // For logged-in users
// add_action('wp_ajax_nopriv_get_cert_template_tp_for_editor', 'get_cert_template_tp_for_editor'); // For non-logged-in users


function calculateTextWidth($text, $fontPath, $fontSize) {
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
    $textWidth = abs($bbox[4] - $bbox[0]); // Difference between the upper right and lower left corners
    return $textWidth;
}

function create_image_with_text($backgroundImagePath, $textArray) {
    // $backgroundImagePath = "http://pls-dev1-cleancompose.local/wp-content/uploads/2024/02/award-of-excellence.jpg";

    // wp_send_json_success($backgroundImagePath);
    $image = imagecreatefromjpeg($backgroundImagePath);
    $textColor = imagecolorallocate($image, 0, 0, 0); // Black text
    $fontPath = get_template_directory() . '/times-new-roman.ttf'; // Ensure this path is correct

    foreach ($textArray as $textData) {
        $text = $textData['value'] ? $textData['value'] : $textData['title'];
        $textWidth = calculateTextWidth($text, $fontPath, 20);
        $y = $textData['x-cords'];
        $x = ($textData['y-cords'] + 170) - ($textWidth / 2);
        imagettftext($image, 20, 0, $x, $y, $textColor, $fontPath, $text);
    }

    // imagettftext($image, 20, 0, "200", "400", $textColor, $fontPath, "lkjlkjlkj");

    // Start output buffering to capture output
    ob_start();
    imagepng($image);
    $imageData = ob_get_contents();
    ob_end_clean();

    // Free up memory
    imagedestroy($image);

    // Base64 encode the captured output
    $base64EncodedImage = 'data:image/png;base64,' . base64_encode($imageData);

    return $base64EncodedImage;
}

function get_file_path_from_url($attachment_url) {
    // Get the attachment ID from the URL
    $attachment_id = attachment_url_to_postid($attachment_url);

    // Check if the attachment ID was found
    if ($attachment_id) {
        // Get the file path of the attachment
        $file_path = get_attached_file($attachment_id);

        // Return the file path if it exists
        if ($file_path) {
            return $file_path;
        } else {
            // Handle cases where the file path couldn't be retrieved
            error_log('Failed to get file path for attachment ID: ' . $attachment_id);
            return null;
        }
    } else {
        // Handle cases where the attachment ID couldn't be found
        error_log('Failed to find attachment ID for URL: ' . $attachment_url);
        return null;
    }
}

function compose_pdf_from_png($base64PNG) {
    $style = '@page { size: A4 landscape; }, body, html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    ';
    //$html = $_POST['html'];

    $html = '<img src="' . $base64PNG . '">';
    $html = urldecode($html);
    $html = '<style>' . $style . '</style>' . $html;
    // Sanitize the input
    // $html = sanitize_post_field('post_content', $html, 0, 'db');
    // $html = str_replace('https', 'http', $html);
    $html = str_replace('\n', '', $html);
    // $paththing = $_SERVER["DOCUMENT_ROOT"].'/placeholder.jpg';
    // Generate PDF
    // wp_send_json_success(['html' => $html]);

    $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
     $dompdf->set_option("dpi", 600);
    $dompdf->loadHtml('<style>@page { size: A4 landscape; }     img {
        width: 100%; /* Stretch the image to cover the full page width */
        height: 100%; /* Stretch the image to cover the full page height */
        page-break-after: always; /* Prevents anything from being placed after the image on the same page */
    }</style><img src="' . $base64PNG . '">');
    $dompdf->render();
    $output = $dompdf->output();
    $base64PDF = base64_encode($output);
    return $base64PDF;
}

function compose_pdf_ajax_handler() {
        // Check for nonce for security
        if ( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'compose_pdf_ajax_nonce') ) {
            wp_send_json_error('Nonce verification failed', 403);
        }

        // $backgroundImagePath = "http://pls-dev1-cleancompose.local/wp-content/uploads/2024/02/award-of-excellence.jpg";
        // $text = "This is a test text";
        // $x = 306;
        // $y = 306;
        $backgroundImagePath = $_POST['background'];
        $backgroundImagePath = get_file_path_from_url($backgroundImagePath);
        // $backgroundImagePath = str_replace("https", "http", $backgroundImagePath);
        $textArray = $_POST['textArray'];

        // wp_send_json_success($textArray);
        $result = create_image_with_text($backgroundImagePath, $textArray);
        // wp_send_json_success(['image' => $result]);

        $style = '@page { size: A4 landscape; }, body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        ';
        //$html = $_POST['html'];

        $html = '<img src="' . $result . '">';
        $html = urldecode($html);
        $html = '<style>' . $style . '</style>' . $html;
        // Sanitize the input
        // $html = sanitize_post_field('post_content', $html, 0, 'db');
        // $html = str_replace('https', 'http', $html);
        $html = str_replace('\n', '', $html);
        // $paththing = $_SERVER["DOCUMENT_ROOT"].'/placeholder.jpg';
        // Generate PDF
        // wp_send_json_success(['html' => $html]);

        $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
         $dompdf->set_option("dpi", 600);
        $dompdf->loadHtml('<style>@page { size: A4 landscape; }     img {
            width: 100%; /* Stretch the image to cover the full page width */
            height: 100%; /* Stretch the image to cover the full page height */
            page-break-after: always; /* Prevents anything from being placed after the image on the same page */
        }</style><img src="' . $result . '">');
        $dompdf->render();
        
        // Save the generated PDF to a temporary file
        $output = $dompdf->output();
        $base64 = base64_encode($output);
        
        // Return the URL to the temporary PDF file
        wp_send_json_success(['pdf' => $base64, 'image' => $result]);
        wp_die();
}

add_action('wp_ajax_compose_pdf_ajax', 'compose_pdf_ajax_handler'); // For logged-in users
// add_action('wp_ajax_nopriv_get_cert_template_tp_for_editor', 'get_cert_template_tp_for_editor'); // For non-logged-in users

function save_image_to_media_lib($base64PNG) {

    // Strip the data URI scheme if it's included
    if (preg_match('/^data:image\/(\w+);base64,/', $base64PNG, $type)) {
        $data = substr($base64PNG, strpos($base64PNG, ',') + 1);
        $type = strtolower($type[1]); // png, jpg, gif

        // Decode the base64 string
        $data = base64_decode($data);

        // Check if decoding was successful
        if ($data === false) {
            wp_send_json_error('Base64 decoding failed');
        }
    } else {
        // Not a valid base64-encoded data
        wp_send_json_error('Invalid base64-encoded data');
    }

    // Generate a unique filename for the image
    $filename = 'image_' . wp_generate_uuid4() . '.' . $type;

    // Save the decoded image to the media library
    $upload = wp_upload_bits($filename, null, $data);
    if ($upload['error']) {
        // Handle the error if the image upload fails
        wp_send_json_error('Failed to save image to media library: ' . $upload['error']);
    }

    // Get the URL of the saved image
    $imageURL = $upload['url'];
    return $imageURL;
}

function save_base64_pdf_to_media_lib($base64PDF) {
    // $base64PDF = 'your_base64_encoded_pdf_data_here';

    // Strip the data URI scheme if it's included
    if (preg_match('/^data:application\/pdf;base64,/', $base64PDF)) {
        $base64PDF = substr($base64PDF, strpos($base64PDF, ',') + 1);
    }

    // Decode the base64 string
    $pdfData = base64_decode($base64PDF);

    // Check if decoding was successful
    if ($pdfData === false) {
        wp_send_json_error('Base64 decoding failed');
    }

    // Generate a unique filename for the PDF
    $filename = 'document_' . wp_generate_uuid4() . '.pdf';

    // Use wp_upload_bits to save the PDF file
    $upload = wp_upload_bits($filename, null, $pdfData);

    if ($upload['error']) {
        wp_send_json_error('Failed to save PDF to media library: ' . $upload['error']);
    }

    // Get the file path of the saved PDF
    $filePath = $upload['file'];

    // Optionally, insert the PDF into the WordPress Media Library
    $fileType = wp_check_filetype(basename($filePath), null);
    $attachment = array(
        'guid'           => $upload['url'],
        'post_mime_type' => $fileType['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filePath)),
        'post_content'   => '',
        'post_status'    => 'inherit',
        'post_tag'       => 'certificate'
    );
    $attachId = wp_insert_attachment($attachment, $filePath);

    // You may need to require these files
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Generate the metadata for the attachment and update the database record.
    $attachData = wp_generate_attachment_metadata($attachId, $filePath);
    wp_update_attachment_metadata($attachId, $attachData);

    // The PDF is now saved and registered in the WordPress Media Library
    return $upload['url'];
}

function save_base64_pdf_and_create_certificate($base64PDF, $certificateTitle, $certificateID) {
    // First, save the PDF to the media library as before
    $pdfUrl = save_base64_pdf_to_media_lib($base64PDF); // This is your existing function
    
    // Check if the PDF was saved successfully
    if (!$pdfUrl) {
        return false; // Or handle the error appropriately
    }
    
    // Create a new certificate post
    $certificatePost = array(
        'post_title'    => wp_strip_all_tags($certificateID),
        'post_content'  => '', // Add any default content you want here
        'post_status'   => 'publish', // Or 'draft' if you don't want to publish immediately
        'post_type'     => 'certificate', // Ensure this matches your custom post type
        'meta_input'    => array(
            'attached_pdf' => $pdfUrl, // Custom field to store the PDF URL (optional)
        ),
    );

    // Insert the post into the database
    $postID = wp_insert_post($certificatePost);
    
    // Check if the post was created successfully
    if ($postID == 0) {
        return false; // Or handle the error appropriately
    }

    // If you want to set the PDF as the featured image of the certificate post
    // Note: This requires the PDF attachment ID, which is different from its URL
    $attachId = attachment_url_to_postid($pdfUrl); // Convert URL to attachment ID
    if ($attachId) {
        set_post_thumbnail($postID, $attachId);
    }

    return $postID; // Return the new post ID
}

function update_certification_post_fields($certification_post_id, $enrollment_id, $cert_id) {
    $post = get_post($certification_post_id);
    $enrollment = get_post($enrollment_id);

    $student = get_field('enrolled_user', $enrollment_id);
    update_field('enrollment', $enrollment_id, $certification_post_id);
    // $cert_id = wp_generate_uuid4();
    update_field('certificate_id', $cert_id, $certification_post_id);

    update_field('awarded_date', date('Y-m-d'), $certification_post_id);
    update_field('user', $student, $certification_post_id);
}


function make_certification_for_student() {

    $courseID = 580;
    $learnerID = 1;
    $registrationID = 1942;

    $certificate_id = wp_generate_uuid4();

    $nameText = "John Doe";
    $dateText = "2024-02-02";
    $signatureText = "Jane Doe";

    $course = get_course_info($courseID);
    $course_cert_policies = $course[0]['acf']['course_settings']['certificate_policies'];

    $certificate = $course_cert_policies[0]['certificate_type'];
    $acf = get_fields($certificate->ID);
    $textArray = $acf['certificate_fields'];
    foreach($textArray as $key => &$field_row) {
        $field_row['value'] = "Test Value";
    }
    // $backgroundImagePath = str_replace("https", "http" , $acf['certificate_media']->guid);


    try {
        $base64PNG = create_image_with_text($backgroundImagePath, $textArray);
        // If the function above throws an exception, the catch block below will handle it.
    } catch (Exception $e) {
        // Log the error message
        error_log('Error in create_image_with_text: ' . $e->getMessage());
        // Optionally, handle the error, like showing a user-friendly message or taking corrective action.
        wp_send_json_error('Error in create_image_with_text: ' . $e->getMessage());
    }    
    // $base64PDF = compose_pdf_from_png($base64PNG);   
    $base64PDF = compose_pdf_from_png($base64PNG);


    $pdfURL = save_base64_pdf_to_media_lib($base64PDF);

    $certification_post_id = save_base64_pdf_and_create_certificate($base64PDF, $nameText . ' Certificate', $certificate_id);

    update_certification_post_fields($certification_post_id, $registrationID, $certificate_id);

    wp_send_json_success(['cert' => $certificate, 'acf' => $acf, 'textArray' => $textArray, 'backgroundImagePath' => $backgroundImagePath, 'base64PNG' => $base64PNG, 'pdfurl' => $pdfURL, 'base64PDF' => $base64PDF]);
    // echo var_dump($course[0]['acf']);
    wp_die();
}

add_action('wp_ajax_make_certification_for_student_ajax', 'make_certification_for_student'); // For logged-in users

add_action('admin_menu', 'my_custom_admin_page');

function my_custom_admin_page(){
    add_menu_page(
        'Certificate Template Editor', // Page title
        'Certificate Editor', // Menu title
        'manage_options', // Capability required to see this option
        'certificate-template-editor', // Menu slug
        'certificate_template_editor_handler', // Function to display the content of this page
        'dashicons-admin-generic', // Icon URL
        8 // Position
    );
}

function certificate_template_editor_handler(){
    include(plugin_dir_path(__FILE__) . '../../page-templates/certificate-creator.php');
}