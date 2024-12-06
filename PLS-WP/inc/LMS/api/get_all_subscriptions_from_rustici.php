<?php

function get_rustici_subscriptions_ajax_handler() {

    $result = get_all_subscriptions_from_rustici();

    wp_send_json_success($result);
    wp_die(); // Required to terminate immediately and return a proper response
}

add_action('wp_ajax_get_rustici_subscriptions_ajax', 'get_rustici_subscriptions_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_get_rustici_subscriptions_ajax', 'get_rustici_subscriptions_ajax_handler'); // For guests

function get_all_subscriptions_from_rustici() {
        
        // Process AJAX request here
        $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
        $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
        $dev_username = 'RusticiEngine';
        
        // Initialize cURL session
        $curlUrl = $rustici_api_endpoint . "/api/v2/appManagement/subscriptions/";
    
    // Set credentials string for "Basic Authentication" username:password
    $credentials = $dev_username . ':' . $dev_key;
    
    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);
    
    // Set cURL options
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Use HTTP GET
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default'
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
        
        $result = json_decode($response, true);
        $result['success'] = true;
        $response = json_encode($result); 
         
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Decode and return the response
    return json_decode($response, true);
}
?>