<?php 
    function get_subscription_info($subscription_id) {
        $post = get_post($subscription_id);
        $acf_fields = get_fields($subscription_id);

        $result = array(
            'post' => $post,
            'acf_fields' => $acf_fields
        );

        return $result;
    }

