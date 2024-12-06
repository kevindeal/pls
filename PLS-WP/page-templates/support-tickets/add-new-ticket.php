<div class="w-full m-10 h-full bg-white border-borderGray border-2 rounded-xl py-3 px-4">

        <?php

        // Inside your HTML:
        acf_form(array(
            'post_id'       => 'new_post', // to create a new post
            'new_post'      => array(
                'post_title'    => 'Support Ticket ' . wp_generate_uuid4(), // title field name
                'post_id'       => wp_generate_uuid4(), // Creates a random post ID,
                'post_type'   => 'support-ticket', // your custom post type
                'post_status' => 'publish' // or 'pending' if you want to review submissions
            ),
            'submit_value'  => 'Submit Ticket' // text for the submit button
        ));
    ?>

</div>
    
