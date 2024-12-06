<?php

add_action('wp_ajax_get_single_registration_ajax', 'get_single_registration_ajax');
// add_action('wp_ajax_nopriv_get_single_registration', 'get_single_registration');

function get_single_registration_ajax() {
    $registrationID = $_POST['registrationID']; // ACF field, id for the Rustici Engine registration 

    // wp_send_json_success($registrationID);

    // $lesson_records now contains the lesson_records where the key "event_type" equals "registration"

    // Continue with the rest of your code...
    // Define Rustici Engine API parameters
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';

    $result = get_single_registration_api_call($registrationID, $dev_key, $dev_username, $rustici_api_endpoint);

    if ($result['error']) {
        wp_send_json_error($result);
    } else {
        ob_start(); // Start output buffering
        get_template_part('template-parts/admin/reports/single-registration', null, array('data' => $result));
        $html = ob_get_clean(); // Store the buffer content into $html, then clean the buffer
    
        $result['html'] = $html;
        // json_encode($result);
        wp_send_json_success($result);
    }

    wp_die(); // Always end AJAX functions with wp_die
}

function get_single_registration_api_call($registrationID, $dev_key, $dev_username, $rustici_api_endpoint) {
    // Initialize cURL session
    $ch = curl_init();
    $curlUrl = $rustici_api_endpoint . "/api/v2/registrations/" . $registrationID . "?includeChildResults=true&includeRuntime=true&includeInteractionsAndObjectives=true";

    // Set credentials string for Basic Authentication username:password
    $credentials = $dev_username . ':' . $dev_key;

    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Specify the request method as GET
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default',
        'Content-Type: application/json',
    ));

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        // Handle the error
        // Error logging and response
        wp_send_json_error($response);
    } else {
        // Handle the successful response
                
       
        $result = json_decode($response, true);
        // wp_send_json_success($response);

        // Further processing of $result as needed
    }

    // Close cURL session
    curl_close($ch);

    // Return the response or result
    return $result;
}

