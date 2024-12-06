<?php 
    // Add New User Modal

?>

<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="modal-content bg-white border-borderGray overflow-hidden border-2 rounded-xl w-3/5">

        <div id="modal-header" class="flex w-full justify-between items-center p-4">
            <h2 class="justify-center text-xl font-bold text-textNeutral">Create New User</h2>
            <button class="rounded-full py-2 px-3 rounded-s-full bg-buttonBackgroundGray border-[1px] border-borderGray justify-end text-neutral hover:text-black" onclick="toggleModal()">
                &times;
            </button>

            <script>
                function toggleModal() {
                    $('#modal').remove();
                }
            </script>
        </div>

        <div class="w-full m-auto h-full bg-buttonBackgroundGray py-3 px-4">

            <div id="the-other-form" class="w-full m-auto h-full bg-buttonBackgroundGray py-3 px-4 space-y-4">
                <div>
                    <label for="severity">User Type</label>
                    <select name="user_type" id="user_type" class="w-full rounded-lg p-2 border-2 border-borderGray">
                        <option value="low">Student</option>
                        <option value="medium">Client Agency Admin</option>
                        <option value="high">PLS Admin</option>
                    </select>
                </div>

                <div>
                    <?php
                        $uuid = wp_generate_uuid4();
                    ?>
                    <label for="subject">User ID</label>
                    <input type="text" name="user_id" id="user_id" class="w-full rounded-lg border-2 p-2 border-borderGray" value="<?php echo $uuid; ?>" readonly />
                    <br />
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="subject">User Display Name - First </label>
                        <input type="text" name="display_name_first" id="display_name_first" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>

                    <div>
                        <label for="subject">User Display Name - Last</label>
                        <input type="text" name="display_name_last" id="display_name_last" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>
                </div>

                <div>
                    <label for="subject">User Email</label>
                    <input type="text" name="user_email" id="user_email" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    <br />
                </div>

                <div>
                    <label for="subject">Client Agency Group</label>
                    <select name="client_agency_group" id="client_agency_group" class="w-full rounded-lg p-2 border-2 border-borderGray">
                        <?php
                        $subgroup_posts = get_posts(array(
                            'post_type' => 'subgroup',
                            'posts_per_page' => -1,
                            'post_parent' => 0, // Retrieve only parent posts
                        ));

                        foreach ($subgroup_posts as $post) {
                            setup_postdata($post);
                            $post_id = $post->ID;
                            $post_title = get_the_title($post_id);
                            ?>
                            <option value="<?php echo $post_id; ?>"><?php echo $post_title; ?></option>
                            <?php
                        }

                        wp_reset_postdata();
                        ?>
                    </select>

                    <br />
                </div>
                
                <button type="submit" value="Create User" class="m-auto font-bold bg-badgeLightBlue text-black p-2 rounded-lg mt-2">Create User</button>
            </div>

        </div>
    </div>
</div>
                    </div>

                <script>
                document.querySelector('#the-other-form button[type="submit"]').addEventListener('click', function() {
                    var title = document.querySelector('#the-other-form input[name="title"]').value;
                    var requestText = document.querySelector('#the-other-form textarea[name="request_text"]').value;
                    var severity = document.querySelector('#the-other-form select[name="severity"]').value;

                    var data = {
                        title: title,
                        request_text: requestText,
                        severity: severity
                    };

                    fetch('/wp-json/v1/support-tickets/create/', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(function(response) {
                        // Handle response
                    })
                    .catch(function(error) {
                        // Handle error
                    });
                });
                </script>
