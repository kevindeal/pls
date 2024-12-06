<?php

function create_rustici_subscription_ajax_handler() {

    $subscription_topic = $_POST['subscription_topic'];
    $subtopics = $_POST['subtopics'];
    $subscription_url = $_POST['subscription_url'];
    $ignoreBeforeDate = $_POST['ignoreBeforeDate'];

    $result = create_rustici_subscription($subscription_topic, $subtopics, $subscription_url, $ignoreBeforeDate);

    wp_send_json_success($result);
    wp_die(); // Required to terminate immediately and return a proper response
}

add_action('wp_ajax_create_rustici_subscription_ajax', 'create_rustici_subscription_ajax_handler'); // For logged-in users
add_action('wp_ajax_nopriv_create_rustici_subscription_ajax', 'create_rustici_subscription_ajax_handler'); // For guests

function create_rustici_subscription($subscription_topic = null, $subtopics = null, $subscription_url = null, $ignoreBeforeDate = null) {

    // Process AJAX request here
    $rustici_api_endpoint = 'https://pls-dev.engine.scorm.com/RusticiEngine';
    $dev_key = 'jW3LdECo1oCK69D4YU2HgzfSoNU7Ydd';
    $dev_username = 'RusticiEngine';
    
    // Initialize cURL session
    $curlUrl = $rustici_api_endpoint . "/api/v2/appManagement/subscriptions/";
    // wp_send_json_success($curlUrl);
    // Set credentials string for "Basic Authentication" username:password
    $credentials = $dev_username . ':' . $dev_key;
    
    // Base64 encode the credentials
    $encodedCredentials = base64_encode($credentials);
    
    // Define the data you want to send via POST. Replace this with your actual data.
    $postData = array(
        'topic' => $subscription_topic,
        'url' => $subscription_url,
        'ignoreBeforeDate' => $ignoreBeforeDate,
        'enabled' => 'true',
    );
    // wp_send_json_success($postData);
    // Encode the data array as JSON
    $jsonPostData = json_encode($postData);

    // Set cURL options for POST request with JSON data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curlUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true); // Configure cURL for POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPostData); // Attach JSON-encoded POST data
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . $encodedCredentials,
        'Accept-Encoding: gzip, deflate, br',
        'Connection: keep-alive',
        'EngineTenantName: default',
        'Content-Type: application/json', // Set Content-Type to application/json
        'Content-Length: ' . strlen($jsonPostData) // Optional: Explicitly set the content length
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