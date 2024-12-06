<?php

// Add Meta Box
function lesson_package_meta_box() {
    add_meta_box('lesson-package-upload', 'Step 1: Upload Lesson Package', 'lesson_package_upload_callback', 'lesson-package');
}
add_action('add_meta_boxes', 'lesson_package_meta_box');

function lesson_package_upload_callback($post) {
    // Nonce for security
    wp_nonce_field('lesson_package_upload', 'lesson_package_upload_nonce');

    // HTML for file upload
    echo '<p id="upload-text">Upload a .zip file containing your lesson package to Rustici Engine</p>';

    echo '<input type="file" id="lesson_package_zip" name="lesson_package_zip" />';
    echo '<input type="hidden" id="lesson_package_uuid" name="lesson_package_uuid" />';
    ?>
    <script type="text/javascript">
        
        jQuery(document).ready(function($) {
            $('#lesson_package_zip').change(function() {

                console.log('Starting upload...');

                var formData = new FormData();
                formData.append('lesson_package_zip', $(this)[0].files[0]);
                formData.append('action', 'upload_lesson_package'); // WordPress AJAX action
                formData.append('post_id', <?php echo $post->ID; ?>); // Post ID
                $('#upload-text').text('Uploading...');
                $.ajax({
                    url: ajaxurl, // WordPress AJAX URL
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response); // Should log "Success"
                        $('#upload-text').text('Upload successful! UUID: ' + response.data.result + '. Press "Update" or "Publish" to save.');
                        $('#acf-field_65a0158e45421').val(response.data.result);
                        $('#dp1705023202795').val(new Date().toISOString());
                        
                    
                    },
                    error: function() {
                        alert('Error occurred');
                    }
                });
            });
        });
    </script>
    <?php 
}

function ajax_upload_lesson_package() { // Server-side AJAX handler
    // Check for user permission and if the file is set
    if (!current_user_can('edit_posts') || !isset($_FILES['lesson_package_zip'])) {
        wp_send_json_error('Invalid permissions or no file uploaded');
        wp_die();
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    // Include WordPress media functions
    if (!function_exists('media_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }

    $file_id = 'lesson_package_zip';

    // Upload the file and get the attachment ID
    $attachment_id = media_handle_upload($file_id, $post_id);

    if (is_wp_error($attachment_id)) {
        wp_send_json_error('File upload error: ' . $attachment_id->get_error_message());
        wp_die();
    }

    // Get the file path of the uploaded file
    $file_path = get_attached_file($attachment_id);

    // Generate UUID
    $uuid = wp_generate_uuid4();

    // Define Rustici Engine API parameters
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';

    // Upload to Rustici Engine
    $response = upload_lesson_to_rustici_engine($file_path, $uuid, $rustici_api_endpoint, $dev_key, $dev_username);

    // Handle the response from Rustici Engine
    if (isset($response['success'])) {
        // Success
        update_field('lesson_uuid', $uuid, $post_id); // Set the UUID ACF field
        $response['result'] = $uuid;
        // Delete the file
        unlink($file_path);
        wp_send_json_success($response);

    } else {
        wp_send_json_error('Failed to upload to Rustici Engine: ' . json_encode($response));
    }

    wp_die(); // Always end AJAX functions with wp_die
}
add_action('wp_ajax_upload_lesson_package', 'ajax_upload_lesson_package');



function upload_lesson_to_rustici_engine($file_path, $uuid, $rustici_api_endpoint, $dev_key, $dev_username) {
    
    // Prepare the data
    $data = array(
        'file' => new CURLFile($file_path)
    );

    // Initialize cURL session
    $ch = curl_init();
    $curlUrl = $rustici_api_endpoint . '/api/v2/courses/importJobs/upload?courseId=' . $uuid;

    // Set credentials string for "Basic Authentication" username:password
    $credentials = $dev_username . ':' . $dev_key; // Replace with actual username and key

    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default',
        'Content-Type: multipart/form-data'
    ));

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        error_log("cURL Error: " . $error_msg);
        
        wp_send_json_error($error_msg); // Send error, don't continue
    } else {
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        error_log("HTTP Code: " . $httpcode);
        error_log("Response Body: " . $response);
        // wp_send_json_error($httpcode . ' - ' . $response);
        
        $result = json_decode($response, true);
        $result['success'] = true;
        $response = json_encode($result);
    }

    // Close cURL session
    curl_close($ch);

    // Decode and return the response
    return json_decode($response, true);
}




// Save Post Meta
function save_lesson_package($post_id) {
    // Check if nonce is set
    if (!isset($_POST['lesson_package_upload_nonce'])) {
        return;
    }
    // Verify nonce
    if (!wp_verify_nonce($_POST['lesson_package_upload_nonce'], 'lesson_package_upload')) {
        return;
    }

    // Check if file is set
    if (!isset($_FILES['lesson_package_zip'])) {
        return;
    }

    // Generate a unique ID for the lesson package
    $uuid = wp_generate_uuid4();
    
    // Save UUID and other processing

    // Example: update_post_meta($post_id, '_lesson_package_uuid', $uuid);
}
add_action('save_post', 'save_lesson_package');

function create_registration_ajax_handler() {
    $learnerID = $_POST['learnerID']; // ACF field, id for the student, used for Rustici Engine
    $courseID = $_POST['courseID']; // ACF field, id for the course, used for Rustici Engine
    $lessonID = $_POST['lessonID']; // ACF field, id for the lesson post
    $enrollmentID = $_POST['enrollmentID']; // ACF field, id for the enrollment record for this learner/course pair

    $firstName = "first";
    $lastName = "last";
    $registrationId = wp_generate_uuid4(); // Generate a unique registration ID, used for the Rustici course registration

    // Find the user based on the learnerID ACF field
    $users = get_users(array(
        'meta_key' => 'learner_id',
        'meta_value' => $learnerID,
        'number' => 1, // Limit to 1 user
    ));

    if (!empty($users)) {
        $student_user = $users[0];
    } else {
        // Handle the case when the user is not found
        wp_send_json_error('User not found');
    }

    // Get Enrollment for this user
    $enrollments = get_field('enrollments', 'user_' . $student_user->ID);
    // Define Rustici Engine API parameters
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';

    // Create a new registration
    $result = create_registration_api_call($rustici_api_endpoint, $dev_key, $dev_username, $courseID, $learnerID, $firstName, $lastName, $registrationId);
    
    $enrollment_records = create_enrollment_learning_record($courseID, $lessonID, $learnerID, $registrationId, $enrollmentID, 'registration event');

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
add_action('wp_ajax_create_registration', 'create_registration_ajax_handler');

function create_enrollment_learning_record($courseID, $lessonID, $learnerID, $registrationId, $enrollmentID, $rowData) {
    // Get Enrollment
    $enrollment = get_post($enrollmentID);
    $learning_records = get_field('learning_records', $enrollmentID);

    isset($rowData) ? $rowData : array(
        'course_id'      => $courseID,
        'registration_id' => $registrationId,
        'created_at'     => date('Y-m-d H:i:s'),
    );
    $registration_event = array(
        'event_time' => date('Y-m-d H:i:s'),
        'event_type' => 'test',
        'event_data' => $rowData
    );
    
    $learning_records = get_field('learning_records', $enrollmentID);

    // add_lesson_event_to_learning_record($enrollmentID, $lessonID, $registration_event);

    foreach ($learning_records as &$item) {
        if ($item['lesson']->ID == $lessonID) {

            // Append the new event to the lesson_events of the current item
            $item['lesson_events'][] = $registration_event;
            $item['lesson_start_time'] = date('Y-m-d H:i:s');
            $item['current_registration_id'] = $registrationId;

            // Break the loop if you only need to add this to the first matching lesson
            // break;
            update_field('learning_records', $learning_records, $enrollmentID);
            return $item;
        }
    }

    return $learning_records;
}

function create_registration_api_call($rustici_api_endpoint, $dev_key, $dev_username, $courseId, $learnerId, $firstName, $lastName, $registrationId) {
    // Prepare the data
    $data = array(
        'registration' => array(
            'courseId' => $courseId,
            'learner' => array(
                'id' => $learnerId,
                'firstName' => $firstName,
                'lastName' => $lastName
            ),
            'registrationId' => $registrationId,
        ),
            "launchLink" => array( 
                "expiry" => 30
            ),
        
    );

    // Initialize cURL session
    $ch = curl_init();
    $curlUrl = $rustici_api_endpoint . '/api/v2/registrations/withLaunchLink';

    // Set credentials string for "Basic Authentication" username:password
    $credentials = $dev_username . ':' . $dev_key; // Replace with actual username and key

    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default',
        'Content-Type: application/json'
    ));

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        error_log("cURL Error: " . $error_msg);
        
        wp_send_json_error($error_msg); // Send error, don't continue
    } else {
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        error_log("HTTP Code: " . $httpcode);
        error_log("Response Body: " . $response);
        // wp_send_json_success($httpcode . ' - ' . $response);
        
        $result = json_decode($response, true);
        $result['success'] = true;
        $response = json_encode($result);

                // Data to be added
                $row_data = array(
                    'course_id'      => $courseId,
                    'registration_id' => $registrationId,
                    'created_at'     => date('Y-m-d H:i:s'),
                );

        // Field key of the repeater field (different from the field name)
        $field_key = 'field_65ab3e3d51bbf';

        // Post ID to which this repeater field is attached
        $user_id = 9;

        $acf_user_id = 'user_' . $user_id;

        // Add the new row
        add_row($field_key, $row_data, $acf_user_id);        

    }

    // Close cURL session
    curl_close($ch);

    // Decode and return the response
    return json_decode($response, true);
}

function delete_registration_ajax_handler() {
    $registrationId = $_POST['registrationId'];

    // Define Rustici Engine API parameters
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';

    // Create a new registration
    $result = delete_registration_api_call($rustici_api_endpoint, $dev_key, $dev_username, $registrationId);

    if (!$result['success']) {
        wp_send_json_error($result);
    } else {
        wp_send_json_success($result);
    }

    wp_die(); // Always end AJAX functions with wp_die
}

add_action('wp_ajax_delete_registration', 'delete_registration_ajax_handler');

function delete_registration_api_call($rustici_api_endpoint, $dev_key, $dev_username, $registrationId) {
    // Prepare the data
    $data = array(
        'registrationId' => $registrationId,
    );

    // Initialize cURL session
    $ch = curl_init();
    $curlUrl = $rustici_api_endpoint . '/api/v2/registrations/delete';

    // Set credentials string for "Basic Authentication" username:password
    $credentials = $dev_username . ':' . $dev_key; // Replace with actual username and key

    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default',
        'Content-Type: application/json'
    ));

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        error_log("cURL Error: " . $error_msg);
        
        wp_send_json_error($error_msg); // Send error, don't continue
    } else {
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        error_log("HTTP Code: " . $httpcode);
        error_log("Response Body: " . $response);
        // wp_send_json_success($httpcode . ' - ' . $response);
        
        $result = json_decode($response, true);
        $result['success'] = true;
        $response = json_encode($result);

    }

    // Close cURL session
    curl_close($ch);

    // Decode and return the response
    return json_decode($response, true);
}


