<?php 

$post_id = the_post(); // Replace with your actual post ID
$my_post = get_post($post_id);

if ($my_post) {
    // Now you can access properties of the post
    $title = $my_post->post_title;
    $content = $my_post->post_content;
    $status = get_field('status', $post_id);
    $agency_type = get_field('agency_type', $post_id);
    $location = get_field('location', $post_id);
    $pls_id = get_field('pls_id', $post_id);
    $group_admins = get_field('client_group_admin', $post_id);
    $group_members = get_field('agency_members', $post_id);

    $group_courses = get_field('client_group_courses', $post_id);
    // ... and so on
    $subs = get_group_subscriptions(256);

}

$acf_field_name = 'agency_members'; // Replace with your actual ACF field key/name
$acf_array_value = get_field($acf_field_name, $post_id);

$member_count = count($acf_array_value);
if ($acf_array_value) {
    // Process your ACF array value here
    // For example, if it's an array of items:
    foreach ($acf_array_value as $item) {
        // Do something with each $item
        // echo $item['ID'];
    }
} else {
    // ACF field is empty or does not exist
    echo 'No ACF field value found.';
}

$group_location = get_field("profile", $post_id);


?>
   <!-- JavaScript snippet -->
   <script type="text/javascript">
        // Tab change functions
            document.addEventListener("DOMContentLoaded", function(event) {
                var pageAnchor = window.location.hash.substr(1); // Get the anchor part of the URL
                // alert(pageAnchor);
                if (pageAnchor == "people") {
                    // tabChange(event, 'people-container');
                    document.getElementById("peopleButton").click();
                } else if (pageAnchor == "courses-container") {
                    document.getElementById("coursesButton").click();
                } else if (pageAnchor == "messages-container") {
                    document.getElementById("messagesButton").click();
                } else if (pageAnchor == "reports-container") {
                    document.getElementById("reportsButton").click();
                } else if (pageAnchor == "settings-container") {
                    document.getElementById("settingsButton").click();
                } else {
                    document.getElementById("detailsButton").click();
                }
            });
        function tabChange(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks, activeTabClasses, inActiveTabClasses;

            function handleTabButtonClasses () {
                activeTabClasses = "active tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue ";
                inActiveTabClasses = "inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue ";

                // alert(evt.currentTarget.className)
                // Get all other tabLink elements and make them inactive
                tablinks = document.getElementsByClassName("tabLinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = inActiveTabClasses;
                }
                
                // Finally, give the clicked tabLink the active classes
                evt.currentTarget.className = activeTabClasses;
                // alert(evt.currentTarget.className)
            }

            function handleTabContentClasses (cityName) {
                activeTabClasses = "tabContent w-full";
                inActiveTabClasses = "tabContent hidden w-full ";

                // alert(evt.currentTarget.className)
                // Get all tabContentContainer elements and make them all inactive
                tabContentContainers = document.getElementsByClassName("tabContent");
                for (i = 0; i < tabContentContainers.length; i++) {
                    tabContentContainers[i].className = inActiveTabClasses;
                }
                
                // Finally, give the right tabContentContainer the active classes
                document.getElementById("injectionDiv").innerHTML = "";
                document.getElementById(cityName).className = activeTabClasses;
                // evt.currentTarget.className = activeTabClasses;
                // alert(evt.currentTarget.className)
            }

            handleTabButtonClasses();
            handleTabContentClasses(cityName);


            } 
    </script>
<div id="main-container" class="inline-flex w-full bg-[#EFEFF1]">

    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 bg-white h-full ">
        <?php get_template_part('template-parts/blocks/group-admin-nav-bar'); ?>
    </div>


    <div id="content" class="w-full h-full  bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
            <div id="exampleHeader-content" class="w-full space-y-4">
                <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                    <a href="/groups">
                    <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                            <p>All Agencies</p>                
                    </button> 
                    </a> 
                    <button id="invite-button" class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                            <p>Invite New User</p>                
                    </button>            
                </div>

                <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                    <div id="headerTitle-icon" class="w-auto">
                        <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                            local_police
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            <?php echo $title; ?>
                        </p>
                        <h1 class="text-base font-thin"><?php echo $member_count; ?> users</h1>
                    </div>
                    <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                        <p class=" text-badgeDarkBlue">
                            <?php echo $agency_type; ?>
                        </p>
                    </div>
                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                        <span class="material-symbols-outlined">
                            info
                        </span>
                        <p>Details</p>    
                    </button>
                    <button onClick="tabChange(event, 'people-container')" id="peopleButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            people
                        </span>
                        <p>People</p>    
                    </button>    
                    <button id="coursesButton" onClick="tabChange(event, 'courses-container')" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            group
                        </span>
                        <p>Courses + Lessons</p>    
                    </button>
                    <button onClick="tabChange(event, 'messages-container')" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            live_help
                        </span>
                        <p>Support Messages</p>    
                    </button> 
                    <button onClick="tabChange(event, 'reports-container')" class="inactive inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            lab_profile
                        </span>
                        <p>Reports</p>    
                    </button> 
                    <button onClick="tabChange(event, 'settings-container')" class="inactive inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                        <p>Settings</p>    
                    </button>       
                
                </div>
            </div>

        </div>
        
        <div id="content-container" class="w-full p-6">

            <div id="injectionDiv"></div>

            <div id="details-container" class="w-full tabContent">
                <div class="w-full h-auto bg-white border-borderGray border-2 rounded-xl py-3 px-4">
                    <div class="w-full grid grid-cols-2 space-y-2">
                        <div id="gridbox-element" class="w-1/2">
                            <h2 class="text-base" >Group Title</h2>
                            <p class="text-xl">
                                <?php echo $title; ?>
                            </p>
                        </div>
                        <div id="gridbox-element" class="w-1/2">
                            <h2 class="text-base" >Group Location</h2>
                            <p class="text-xl">
                            <?php echo $location['city']; ?>, 
                                <?php echo $location['state']; ?>
                                <?php echo $location['zipcode']; ?>

                            </p>
                        </div>
                        <div id="gridbox-element" class="w-1/2">
                            <h2 class="text-base" >Group Admins</h2>
                            <p class="text-xl">
                                <?php echo $group_admins[0]['display_name']; ?>
                            </p>
                        </div>
                        <div id="gridbox-element" class="w-1/2">
                            <h2 class="text-base" >PLS ID</h2>
                            <p class="text-xl">
                                <?php echo $pls_id; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="people-container" class="w-full hidden tabContent">
                <?php get_template_part('post-templates/client-group-profile/adminView/peopleViews/peopleContainer'); ?>
            </div>

            <div id="messages-container" class="w-full hidden tabContent">
                <?php get_template_part('post-templates/client-group-profile/adminView/messagesContainer'); ?>
            </div>

            <div id="reports-container" class="w-full hidden tabContent">
                <?php get_template_part('post-templates/client-group-profile/adminView/reportsContainer'); ?>
            </div>

            <div id="settings-container" class="w-full hidden tabContent">
                adsflsadf
                <?php get_template_part('post-templates/client-group-profile/adminView/settingsContainer'); ?>
            </div>

            <div id="courses-container" class="w-full hidden tabContent p-4 m-10">
            
                <h1 class="font-bold text-xl">Unassigned Subscriptions</h1>
                <hr class="mb-5" />
                <div id="unassigned-courses" class="p-4 w-1/4">
                    <?php 
                        foreach($subs as $sub) {
                            // echo "<pre>";
                            // echo print_r($sub);
                            // echo "</pre>";
                        if ($sub["acf"]["can_enroll"] == true) {
                            get_template_part('post-templates/client-group-profile/course-subscription', null, array('subs' => $sub)); 
                            }
                        }
                    ?>
                </div>

        <h1 class="font-bold text-xl">Assigned Subscriptions</h1>
        <hr class="mb-5" />
        <?php 
            foreach($subs as $sub) {
                // echo "<pre>";
                // echo print_r($sub);
                // echo "</pre>";
            if ($sub["acf"]["can_enroll"] != true) {
                get_template_part('post-templates/client-group-profile/assigned-subscription', null, array('subs' => $sub)); 
                }
            }
        ?>
        </div>
    </div>

    
    </div>

</div>
    </div>

<script>
jQuery(document).ready(function($) {
    // Trigger AJAX call on some event, e.g., click
    $('#coursesButton').click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'courses_and_lessons_tp',
                // any other data you want to send to the server
            },
            success: function(response) {
                $('#injectionDiv').html(response); // Insert the response in the DOM
            }
        });
    });
    $('#detailsButton').click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'group_details_tp',
                // any other data you want to send to the server
            },
            success: function(response) {
                $('#injectionDiv').html(response); // Insert the response in the DOM
            }
        });
    });
    $('#invite-button').click(function() {
        console.log(<?php echo $my_post->ID ?>);
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'invite_new_user_to_group_modal',
                group_id: '<?php echo $my_post->ID ?>',
                // any other data you want to send to the server
            },
            success: function(response) {
                $('#injectionDiv').html(response); // Insert the response in the DOM
            }
        });
    });
});
</script>

