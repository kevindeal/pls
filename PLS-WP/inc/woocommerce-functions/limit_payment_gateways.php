<?php 

add_filter('woocommerce_available_payment_gateways', 'limit_payment_gateways_based_on_user_meta');

function limit_payment_gateways_based_on_user_meta($available_gateways) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return $available_gateways;
    }

    $user_id = get_current_user_id();
    
    // Check if the user is logged in
    if ($user_id) {
        // Get the user meta value from ACF
        $user_can_pay_later = get_field('can_pay_later', 'user_' . $user_id);

        // $available_gateways = WC()->payment_gateways->payment_gateways();
        // echo '<pre>';
        // echo var_dump($user_payment_option);

        // foreach ($available_gateways as $gateway) {
        //     echo 'ID: ' . esc_html($gateway->id) . ' - Title: ' . esc_html($gateway->title) . "\n";
        // }
        // echo '</pre>';

        // Based on the ACF field value, modify the available gateways
        if ($user_can_pay_later === false) {
            // Remove specific gateways
            unset($available_gateways['cod']); // Replace 'paypal' with the ID of the gateway you want to remove
            // Repeat unset() for other gateways as needed
        }
    }

    return $available_gateways;
}
