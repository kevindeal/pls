<?php 
    // Add New User Modal

?>

<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="modal-content bg-white border-borderGray overflow-hidden border-2 rounded-xl w-3/5">

        <div id="modal-header" class="flex w-full justify-between items-center p-4">
            <h2 class="justify-center text-xl font-bold text-textNeutral">Create New Client Group</h2>
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
                    <label for="severity">Group Type</label>
                    <select name="user_type" id="user_type" class="w-full rounded-lg p-2 border-2 border-borderGray">
                        <option value="low">Police</option>
                        <option value="medium">Another</option>
                        <option value="high">Another</option>
                    </select>
                </div>

                <div>
                    <?php
                        $uuid = wp_generate_uuid4();
                    ?>
                    <label for="subject">ClientGroup ID</label>
                    <input type="text" name="user_id" id="user_id" class="w-full rounded-lg border-2 p-2 border-borderGray" value="<?php echo $uuid; ?>" readonly />
                    <br />
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="subject">Client Group Title </label>
                        <input type="text" name="client_group_title" id="client_group_title" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>

                    <div>
                        <label for="subject">User Display Name - Last</label>
                        <input type="text" name="display_name_last" id="display_name_last" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label for="subject">Client Location - City </label>
                        <input type="text" name="location_city" id="location_city" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>

                    <div>
                        <label for="subject">Client Location - State</label>
                        <input type="text" name="location_state" id="location_state" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>

                    <div>
                        <label for="subject">Client Location - Zipcode</label>
                        <input type="text" name="location_zipcode" id="location_zipcode" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    </div>
                </div>
                
                <button type="submit" value="Create User" class="m-auto font-bold bg-badgeLightBlue text-black p-2 rounded-lg mt-2">
                    Create Group
                </button>
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
