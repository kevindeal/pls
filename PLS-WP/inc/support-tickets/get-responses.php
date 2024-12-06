<?php 
    function get_support_ticket_responses($parent_ticket_id) {
        $args = array(
            'post_type' => 'support-ticket-respo', // respo because 20 character limit
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'order' => 'ASC',
            'orderby' => 'date',
            'meta_query' => array(
                array(
                    'key' => 'parent_ticket',
                    'value' => $parent_ticket_id,
                    'compare' => '='
                )
            )
        );
        $responses = get_posts($args);
        foreach ($responses as $response) {
            $response->fields = get_fields($response->ID);
        }
        return $responses;
    }