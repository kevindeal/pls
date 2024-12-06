<?php 
    /**
     * Template Name: Student Member Onboarding Template
     * 
     */
    get_header();
    wp_head();

    $authCode = $_GET['authCode'];

    $inviteQuery = new WP_Query(array(
        'post_type' => 'invite',
        'meta_query' => array(
            array(
                'key' => 'invite_auth_code',
                'value' => $authCode,
                'compare' => '='
            )
        )
    ));

    $invitePosts = $inviteQuery->get_posts();
    $invitePost = $invitePosts[0];
    $inviteFields = get_fields($invitePost->ID);
    $inviteGroup = $inviteFields['inviting_agency_group']->ID;

    $groupTitle = get_the_title($inviteGroup);
?>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        $('.stepButton').click(function() {
            var step = $(this).attr('data-target');
            // alert(step)
            const stepDivs = ['step-1-div', 'step-2-div', 'step-3-div', 'step-4-div'];

            stepDivs.forEach((div) => {
                if (div !== step) {
                    $('#' + div).fadeOut(400);
                }
            });
            $('.step').hide();
            
            $('#' + step).fadeIn(400);
            if(step = 'step-4-div') {
                $('#user_location_state_submit').text($('#user_location_state').val());
                $('#user_location_city_submit').text($('#user_location_city').val());
                $('#user_location_zipcode_submit').text($('#user_location_zipcode').val());
                $('#user_first_name_submit').text($('#user_first_name').val());
                $('#user_last_name_submit').text($('#user_last_name').val());
                $('#user_email_submit').text($('#user_email').val());
            }
            console.log(step);
        });
    });
</script>

<div class="flex justify-center items-center h-screen bg-white">
    
    <div id="step-1-div" class="border-[1px] step border-borderGray rounded-xl shadow w-3/4 h-3/4 m-auto">

        <div class="w-full h-1/10 p-4 bg-badgeLightBlue bg-opacity-30 rounded-t-xl inline-flex gap-4 place-items-center ">
            <span class="material-symbols-outlined md-18 text-badgeDarkBlue border-2 border-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                school
            </span>
            <p class="font-semibold text-xl text-textNeutral">Student Member Onboarding - <?php echo $groupTitle ?></p>
        </div>

        <div class="w-full h-9/10 p-8 space-y-6">
            <div>
                <p class=" font-thin text-lg text-textNeutral">Welcome to PLS LMS!</p>
                <p class=" font-thin text-lg text-textNeutral">We're thrilled to have you join our community. As you embark on this exciting journey with us, there are a few simple steps ahead to get you fully onboarded. </p>
                <p class=" font-thin text-lg text-textNeutral">These steps are designed to ensure that you have a seamless and enriching experience with our platform. </p>
                </p>
            </div>

            <div class="w-full px-2 mt-4 space-y-4">
                <p class="font-semibold text-lg text-textNeutral">Step 1: Enter Your Location Information</p>

                <p id="error-text" class="font-thin text-[#ff0000] text-lg"></p>
                <select id="user_location_state" class="w-full p-2 border-2 border-gray-300 rounded-md">
                    <option value="0">Select your state</option>
                    <option value="IA">Iowa</option>
                    <option value="MO">Missouri</option>
                    <option value="IL">Illinois</option>
                </select>
                <div class="grid grid-cols-2 gap-4">
                    <input 
                        id="user_location_city" 
                        type="text" 
                        class="w-full p-2 border-2 border-gray-300 rounded-md" 
                        placeholder="City"
                    >
                    <input 
                        id="user_location_zipcode" 
                        type="text" 
                        class="w-full p-2 border-2 border-gray-300 rounded-md" 
                        placeholder="Zip Code" 
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
                        title="Please enter a numeric zip code." 
                        inputmode="numeric" 
                        minlength="5" 
                        maxlength="5"
                    >
                    </div>
                <button data-target="step-2-div" id="step-1-button" class="stepButton inline-flex font-semibold justify-items-center place-content-center gap-4 w-full p-2 transition-all duration-200 hover:bg-badgeLightBlue border-[1px] border-borderGray text-textNeutral rounded-md mt-4">
                    Next 
                    <span class="material-symbols-outlined">
                        arrow_circle_right
                    </span>
                </button>
        
            </div>
        </div>
    </div>

    <div id="step-2-div" class="flex step justify-center items-center h-screen w-screen bg-white" style="display: none">
        <div class="border-[1px] border-borderGray rounded-xl shadow w-3/4 h-3/4 m-auto">
            <div class="w-full h-1/10 p-4 bg-badgeLightBlue bg-opacity-80 rounded-t-xl inline-flex gap-4 place-items-center ">
                <span class="material-symbols-outlined md-18 text-badgeDarkBlue border-2 border-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                    school
                </span>
                <p class="font-semibold text-xl text-textNeutral">Student Member Onboarding - <?php echo $groupTitle ?></p>
            </div>

            <div class="w-full h-9/10 p-8 space-y-6">


                <div class="w-full px-2 mt-4 space-y-4">
                    <p class="font-semibold text-lg text-textNeutral">Step 2: Enter Your Personal User Information</p>
                    <div class="w-full space-y-2">
                        <p class="font-thin italic text-lg text-textNeutral">
                            This email will receive all notifications and updates from the platform. Please ensure that it is accurate and up-to-date.
                        </p>
                        <p class="font-semibold text-lg text-textNeutral">
                            You will be recieving your login credentials to this email after completing the onboarding process.
                        </p>
                        <input type="text" id="user_email" class="w-full p-2 border-2 border-gray-300 rounded-md" placeholder="User Email">
                    </div>
                    <br />
                    <div class="w-full grid grid-cols-2 gap-x-4 mt-2">
                        <div>
                            <label for="user_first_name" class="font-semibold text-lg text-textNeutral">First Name</label>
                            <input type="text" id="user_first_name" class="w-full p-2 border-2 border-gray-300 rounded-md" placeholder="User First Name">
                        </div>
                        <div>
                            <label for="user_last_name" class="font-semibold text-lg text-textNeutral">Last Name</label>
                            <input type="text" id="user_last_name" class="w-full p-2 border-2 border-gray-300 rounded-md" placeholder="User First Name">
                        </div>
                    </div>

                    <button id="step-3-button" data-target="step-3-div" class="stepButton inline-flex font-semibold justify-items-center place-content-center gap-4 w-full p-2 transition-all duration-200 hover:bg-badgeLightBlue border-[1px] border-borderGray text-textNeutral rounded-md mt-4">
                        Next 
                        <span class="material-symbols-outlined">
                            arrow_circle_right
                        </span>
                    </button>
            
                </div>
            </div>
            
        </div>
    </div>

    <div id="step-3-div" class="step flex step justify-center items-center w-screen h-screen bg-white" style="display: none">
        <div class="border-[1px] border-borderGray rounded-xl shadow w-3/4 h-auto m-auto">
            <div class="w-full h-1/10 p-4 bg-badgeLightBlue rounded-t-xl inline-flex gap-4 place-items-center ">
                <span class="material-symbols-outlined md-18 text-badgeDarkBlue border-2 border-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                    how_to_reg
                </span>
                <p class="font-semibold text-xl text-textNeutral">Student Member Onboarding - Submit Values - <?php echo $groupTitle ?></p>
            </div>

            <div class="w-full h-9/10 p-8 space-y-6">

                <div class="w-full px-2 mt-1 space-y-4">
                    <p class="font-thin text-lg text-textNeutral">Location</p>
                    <hr />
                    <div class="w-full space-y-2 grid grid-cols-3">
                    <div class="inline-flex gap-2">
                            <p class="font-semibold text-lg text-textNeutral">State</p>
                            <p id="user_location_state_submit"></p>
                        </div>
                        <div class="inline-flex gap-2">
                            <p class="font-semibold text-lg text-textNeutral">City</p>
                            <p id="user_location_city_submit"></p>
                        </div>
                        <div class="inline-flex gap-2">
                            <p class="font-semibold text-lg text-textNeutral">Zipcode</p>
                            <p id="user_location_zipcode_submit"></p>
                        </div>
                        
                    </div>
                    <br />
                    <p class="font-thin text-lg text-textNeutral">Your User Details</p>
                    <hr />
                    <div class="w-full space-y-2 grid grid-cols-3">
                        <div class="inline-flex gap-2">
                            <p  class="font-semibold text-lg text-textNeutral">First Name:</p>
                            <p id="user_first_name_submit" class="italic"></p>
                        </div>
                        <div class="inline-flex gap-2">
                            <p id="" class="font-semibold text-lg text-textNeutral">Last Name:</p>
                            <p id="user_last_name_submit" class="italic"></p>
                        </div> 
                        <div class="inline-flex gap-2">
                            <p id="email_value" class="font-semibold text-lg text-textNeutral">Email Address</p>
                            <p id="user_email_submit" class="italic"></p>
                        </div>   
                    </div>
                    <br />

                    <button id="create-user-button" class="inline-flex submit font-semibold justify-items-center place-content-center gap-4 w-full p-2 transition-all duration-200 hover:bg-badgeLightBlue border-[1px] border-borderGray text-textNeutral rounded-md mt-4">
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

    <div id="successful-submit" class="step flex step justify-center items-center w-screen h-screen bg-white" style="display: none">
        <div class="border-[1px] border-borderGray rounded-xl shadow w-3/4 h-auto m-auto">
            <div class="w-full h-1/10 p-4 bg-badgeLightBlue rounded-t-xl inline-flex gap-4 place-items-center ">
                <span class="material-symbols-outlined md-18 text-badgeDarkBlue border-2 border-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                    check_circle
                </span>
                <p class="font-semibold text-xl text-textNeutral">Student Member Onboarding  - Successful Creation - <?php echo $groupTitle ?></p>
            </div>

            <div class="w-full h-9/10 p-8 space-y-6">
                <div class="w-full h-full place-items-center text-center">
                    <p class="w-full mt-4 text-center text-xl font-semibold">Success!</p>
                    <p class="w-full mt-4 text-center font-semibold">Your account has been created. You will receive an email with your login credentials shortly.</p>
                </div>
            </div> 
        </div>
    </div>

</div>

</div>






<script>
jQuery(document).ready(function($) {
    $('#create-user-button').click(function(e) {
        e.preventDefault();
        $('#submit-arrow').hide();
        $('#submit-spinner').show();

        var email = $('#user_email').val(); // Assuming input ID is 'email'
        var firstName = $('#user_first_name').val(); // Assuming input ID is 'first_name'
        var lastName = $('#user_last_name').val(); // Assuming input ID is 'last_name'
        var user_state = $('#user_location_state').val();
        var user_city = $('#user_location_city').val();
        var user_zipcode = $('#user_location_zipcode').val();


        dataObj = {
                action: 'create_student_user_from_ajax',
                group_id: '<?php echo $inviteGroup; ?>',
                email: email,
                user_first_name: firstName,
                user_last_name: lastName,
                user_state: user_state,
                user_city: user_city,
                user_zipcode: user_zipcode,
            },

        // alert(JSON.stringify(dataObj)); // Debugging (remove this line when you're done testing)
        $.ajax({
            type: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: dataObj,
            success: function(response) {
                // alert(response); // Show response from the PHP function
                $('#submit-arrow').show();
                $('#submit-spinner').hide();
                $('#step-3-div').fadeOut(100);
                setTimeout(() => {
                    $('#successful-submit').fadeIn(400);

                }, 101);

            }
        });

    });
});

</script>

<?php 
    get_footer();
    wp_footer();
?>