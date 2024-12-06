<?php 
    // Template for creating a new support ticket
?>

<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="modal-content bg-white border-borderGray overflow-hidden border-2 rounded-xl w-3/5">

        <div id="modal-header" class="flex w-full justify-between items-center p-4">

            <h2 class="justify-center text-xl font-bold text-textNeutral">
                
                Create New Support Ticket
            </h2>
            <button class="rounded-full py-2 px-3 rounded-s-full bg-buttonBackgroundGray border-[1px] border-borderGray justify-end text-neutral hover:text-black" onclick="toggleModal()">
                &times;
            </button>
        </div>

        <div class="w-full m-auto h-full bg-buttonBackgroundGray py-3 px-4">

            <div id="the-other-form" class="w-full m-auto h-full bg-buttonBackgroundGray py-3 px-4">
                <div id="severity">
                    <label for="severity">Severity</label>
                    <select name="severity" id="severity" class="w-full p-2 rounded-lg border-2 border-borderGray">
                        <option value="low">Low</option>
                        <option value="regular">Regular</option>
                        <option value="important">Important</option>
                        <option value="severe">Severe</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                <br />

                <div id="title">
                    <label for="subject">Ticket Subject</label>
                    <input type="text" name="title" id="subject" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                </div>

                <br />
                <div id="request_text">
                    <label for="request_text">Reply Body</label>
                    <textarea name="request_text" class="p-4 w-full rounded-lg border-2 border-borderGray" id="request_text" cols="30" rows="10"></textarea>
                </div>

                <br />
                <label for="file">Upload File</label>
                <input type="file" name="file" id="file" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                <br />
                <input type="hidden" name="ticket_id" value="<?php echo $post->ID; ?>" />
                <button type="submit" value="Create Ticket" class="m-auto bg-badgeLightBlue text-black p-2 rounded-lg mt-2">Add Reply</button>
            </div>
            <?php
            // Inside your HTML:
            /*
                
            acf_form(array(
                'id'            => 'new-support-ticket-form', // to create a new post
                'post_id'       => 'new_post', // to create a new post
                'uploader' => 'basic',
                'new_post'      => array(
                    'post_title'    => 'Support Ticket ' . wp_generate_uuid4() , // title field name
                    'post_id'       => wp_generate_uuid4(), // Creates a random post ID,
                    'post_type'   => 'support-ticket', // your custom post type
                    'post_status' => 'publish', // or 'pending' if you want to review submissions
                    
                ),
                'submit_value'  => 'Create Ticket', // text for the submit button
                'fields'        => array('title', 'request_text', 'severity') // specify the fields to display
            ));
            */
            ?>

        </div>
    </div>
</div>

<script>
    document.querySelector('#the-other-form button[type="submit"]').addEventListener('click', function() {
        var title = document.querySelector('#the-other-form input[name="title"]').value;
        var requestText = document.querySelector('#the-other-form textarea[name="request_text"]').value;
        var severity = document.querySelector('#the-other-form select[name="severity"]').value;
        // var ticket_id = document.querySelector('#the-other-form select[name="ticket_id"]').value;
        var file = document.querySelector('#the-other-form input[name="file"]').files[0];
        var userId = <?php echo get_current_user_id(); ?>; // User ID of the currently logged-in user

        console.log('userId: ' + userId)

        var data = new FormData();
        data.append('title', title);
        data.append('body', requestText);
        data.append('severity', severity);
        data.append('ticket_id', 4);
        data.append('file', file);
        data.append('user_id', userId);

        fetch('/wp-json/support-tickets/create/', {
            method: 'POST',
            body: data
        })
        .then(function(response) {
            return response.text();
        })
        .then(function(data) {
            console.log(data);
            // Handle response
            window.location.reload(); // Refresh the page
        })
        .catch(function(error) {
            // Handle error
        });
    });
</script>

                
                <br />
                
                <button type="submit" value="Create Ticket" class="m-auto bg-badgeLightBlue text-black p-2 rounded-lg mt-2">Add Reply</button>
                </div>
                <?php
                // Inside your HTML:
                /*
                    
                acf_form(array(
                    'id'            => 'new-support-ticket-form', // to create a new post
                    'post_id'       => 'new_post', // to create a new post
                    'uploader' => 'basic',
                    'new_post'      => array(
                        'post_title'    => 'Support Ticket ' . wp_generate_uuid4() , // title field name
                        'post_id'       => wp_generate_uuid4(), // Creates a random post ID,
                        'post_type'   => 'support-ticket', // your custom post type
                        'post_status' => 'publish', // or 'pending' if you want to review submissions
                        
                    ),
                    'submit_value'  => 'Create Ticket', // text for the submit button
                    'fields'        => array('title', 'request_text', 'severity') // specify the fields to display
                ));
                */
                ?>

            </div>
        </div>

    </div>
