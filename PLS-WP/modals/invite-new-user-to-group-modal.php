<?php 
    $group_id = $args['group_id'];
    echo $group_id;
?>

<div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="modal-content bg-white border-borderGray overflow-hidden border-2 rounded-xl w-3/5">

        <div id="modal-header" class="flex w-full justify-between items-center p-4">
            <h2 class="justify-center text-xl font-bold text-textNeutral">Invite New User</h2>
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

                <p class="text-textNeutral text-lg font-thin italic">Please be sure to use the correct email, anyone who gets this email can sign up for your agency!</p>
                <div>
                    <label for="subject">User Email</label>
                    <input type="text" name="user_email" id="user_email" class="w-full rounded-lg border-2 p-2 border-borderGray" />
                    <br />
                </div>
                <div>
                    <label for="severity">User Type</label>
                    <select name="user_type" id="user_type" class="w-full rounded-lg p-2 border-2 border-borderGray">
                        <option value="student">Student</option>
                        <option value="group_admin">Client Agency Admin</option>
                    </select>
                </div>

                <div class="inline-flex gap-1">
                    
                    <p class="font-semibold">Invite Code: </p>
                    <p class="font-thin" id="invite-code-value"></p>
                </div>
                <br />

                <button id="submit" type="submit" value="Create User" class="m-auto font-bold bg-badgeLightBlue text-black p-2 rounded-lg mt-2">Invite New User</button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('#submit').click(function() {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'create_new_user_invite_ajax',
                    group_id: <?php echo $group_id ?>,
                    user_email: $('#user_email').val(),
                    user_type: $('#user_type').val(),

                    // any other data you want to send to the server
                },
                success: function(response) {
                    // $('#injectionDiv').html(response); // Insert the response in the DOM
                    console.log(response);
                    if (response.success) {
                        console.log(response.data);
                        $('#invite-code-value').text(response.data);
                    } else {
                        console.log(response.data);
                    }
                }
            });
        });
    });
</script>