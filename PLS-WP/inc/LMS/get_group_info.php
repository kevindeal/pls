<?php 
    function get_group_info($group_id) {
        $post = get_post($group_id);
        $acf_fields = get_fields($group_id);
        $subgroups = array();

        foreach ($acf_fields['agency_group'] as $child_group) {
            $fields = get_fields($child_group->ID);
            
            $subgroups[] = array(
                'post' => $child_group,
                'acf_fields' => $fields,
            );
        }
        
        $result = array(
            'post' => $post,
            'acf_fields' => $acf_fields,
            'butt' => 'butt',
            'subgroups' => $subgroups
        );

        return $result;
    }