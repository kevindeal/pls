<?php
// Prevent direct access to the file
defined( 'ABSPATH' ) || exit;

function get_group_subscriptions($group_id, $available_only = false, $unavailable_only = false) {
    $args = array(
        'post_type' => 'acf-subscription', // Replace with your custom post type for subscriptions
        'posts_per_page' => -1,        // You can limit the number of posts
        'meta_query' => array(
            array(
                'key' => 'client_group', // The ACF field key
                'value' => $group_id,    // The group ID passed to the function
                'compare' => '=',        // Exact match
            ),
        ),
    );

    $query = new WP_Query($args);
    $subscriptions = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Collect the subscription post data
            $subscriptions[] = array(
                'ID' => get_the_ID(),
                'title' => get_the_title(),
                'course' => get_field('course'),
                'acf' => get_fields(get_the_ID()),
                // Add other post fields as needed
            );
        }
        wp_reset_postdata();
    }

    // Optionally filter the subscriptions
    if ($available_only) {  // If the $available_only parameter is true
        // Filter out subscriptions that are not available
        $subscriptions = array_filter($subscriptions, function($subscription) {
            return $subscription['acf']['can_enroll'] === true;
        });
    }
    if ($unavailable_only) { // If the $unavailable_only parameter is true
        // Filter out subscriptions that are not available
        $subscriptions = array_filter($subscriptions, function($subscription) {
            return $subscription['acf']['can_enroll'] === false;
        });
    }
    
    return $subscriptions; // Returns an array of subscription posts
}