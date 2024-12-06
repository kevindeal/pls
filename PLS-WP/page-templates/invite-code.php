<?php 
    /**
     * Template Name: Invite Code Template
     * 
     */
    get_header();
    wp_head();
?>

<div id="invite-code-container" class="step flex step justify-center items-center w-screen h-screen bg-white">
        <div class="border-[1px] border-borderGray rounded-xl shadow w-1/4 h-auto m-auto">
            <div class="w-full h-1/10 p-4 bg-badgeLightBlue rounded-t-xl inline-flex gap-4 place-items-center ">
                <span class=" md-18 text-badgeDarkBlue border-2 border-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                    <img class="w-12 aspect-square" src="/wp-content/uploads/2024/01/pls-shapes.png">
                </span>
                <p class="font-semibold text-xl text-textNeutral">Invite Code</p>
            </div>

            <div class="w-full h-9/10 p-5 space-y-2">

                 <!-- Your invite code input field and other content here -->
                <p class="font-semibold text-xl text-textNeutral">Enter your invite code</p>
                <p id="error-message" class="text-[#ff0000]"></p>
                <input id="invite-code" type="text" class="w-full p-2 border-2 border-gray-300 rounded-md" placeholder="Enter your invite code">

                <button id="submit" class="inline-flex submit font-semibold justify-items-center place-content-center gap-4 w-full p-2 transition-all duration-200 hover:bg-badgeLightBlue border-[1px] border-borderGray text-textNeutral rounded-md mt-4">
                    Submit 
                    <span id="submit-arrow" class="material-symbols-outlined">
                        arrow_circle_right
                    </span>
                    <span id="submit-spinner" class="material-symbols-outlined animate-spin" style="display: none">
                        sync
                    </span>
                </button>
            
            </div>
        </div> 
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $('#submit').on('click', function() {
        var inviteCode = $('#invite-code').val();
        alert(inviteCode);
        if (inviteCode == '') {
            $('#error-message').text('Invite code is required');
            return;
        }
        // alert(inviteCode);
        $('#submit-arrow').hide();
        $('#submit-spinner').show();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // This is the URL to the WordPress admin-ajax.php file
            method: 'POST',
            data: { 
                action: 'check_invite_code_ajax',
                inviteCode: inviteCode
            },
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                if (response.success) {
                    console.log(response.data);
                    // alert('Invite code is valid');
                    window.location.href = `/${response.data}`;
                } else {
                    console.log(response)
                    $('#error-message').text("Error " + response);
                    $('#submit-spinner').hide();
                    $('#submit-arrow').show();
                    // alert('Invite code is invalid');
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error(' Error: ', error);
            }
        });
    });
</script>

<?php 
    get_footer();
    wp_footer();
?>