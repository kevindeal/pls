<?php 
    // Subgroups Group Admin View Template

    $group_info = get_group_info(get_the_ID());
    // echo "<pre>";
    // echo print_r($group_info);
    // echo "</pre>";
    $parent_group = get_post($group_info["post_parent"]);
    $parent_group_users = get_field('agency_members', $parent_group->ID);
    $group_subscriptions = get_group_subscriptions($parent_group->ID);
?>

<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const parent_group = <?php echo json_encode($parent_group); ?>;
    console.log('parent group', parent_group);
</script>
<script>
    function createEnrollments() {

        function getSelectedCourseId() {
            var select = document.getElementById('course-select');
            console.log("selected values: " + select.value)
            var resultArray = select.value.split('|');
            var result = { 
                course_id: resultArray[0],
                subscription_id: resultArray[1]
            }

            return result; // This will return the value of the selected option
        }

        function getSelectedDates() {
            var startDate = document.getElementById('start-date');
            var endDate = document.getElementById('end-date');
            return {
                startDate: startDate.value,
                endDate: endDate.value
            }
        }

        const course_id = document.getElementById('course-select').value;
        const users = <?php echo json_encode($group_info["acf"]["subgroup_members"]); ?>;
        const user_ids = users.map(user => user.ID);

        const group_id = <?php echo $group_info["ID"]; ?>;
        console.log("course_id: " + course_id);
        const data = {
            user_ids: user_ids, // Array of user IDs
            course_id: getSelectedCourseId().course_id,      // Course ID
            subgroup_id: group_id,    // Subgroup ID
            subscription_id: getSelectedCourseId().subscription_id, // Subscription ID
            start_date: getSelectedDates().startDate,
            end_date: getSelectedDates().endDate
        };
        const nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'; // Create the nonce here

        fetch('/wp-json/myplugin/v1/create-enrollments/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': nonce
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.code) {
                    document.getElementById('errorMessage').innerHTML = data?.message;
                    return;
                }
                document.getElementById('successMessage').innerHTML = data;
                setTimeout(() => {
                    location.reload();
                }, '1000');
            })
        .catch(error => console.error('Error:', error));
    }
</script>

<script>
    var group_dump = <?php echo json_encode($group_info); ?>;
    var parent_group_dump = <?php echo json_encode($parent_group_users); ?>;


    console.log(group_dump);
    console.log(parent_group_dump);
</script>


<div class="inline-flex w-full">
    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 bg-white h-full sticky top-0 ">
        <?php get_template_part('template-parts/blocks/group-admin-nav-bar'); ?>
    </div>


<div id="container" class="w-4/5 bg-[#EFEFF1]">

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="<?php echo get_permalink($parent_group); ?>" class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p><?php echo $parent_group -> post_title ?></p>                
                </a>  
                <button onClick="openModal()" class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p>Add New Member</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        local_police
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold"><?php echo the_title() ?></p>
                    <h1 class="text-base font-thin">Some Subheadline</h1>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        Badge
                    </p>
                </div>
            </div>

            <script>

                $(document).ready(function() {
                    // ... your existing click event listener setup ...

                    // Optionally show a default tab on page load
                    $("#groupDetailsDiv").show();
                });
                
                $(document).ready(function() {
                    // Add click event listener to the buttons
                    $("#groupDetailsButton, #groupMembersButton, #groupMembersCourses, #groupSettingsButton").click(function() {
                        // Remove the class border-badgeDarkBlue from all buttons
                        // alert("clicked")
                        var buttonIds = [
                            "groupDetailsButton",
                            "groupMembersButton",
                            "groupMembersCourses",
                            "groupSettingsButton"
                        ];
                        var divId = $(this).attr("id");
                        $(this).removeClass("border-white");
                        $(this).addClass("border-badgeDarkBlue");

                        buttonIds.forEach(buttonId => {
                            if (buttonId != divId) {
                                $("#" + buttonId).removeClass("border-badgeDarkBlue");
                                $("#" + buttonId).addClass("border-white");
                                
                            }
                        });
                        
                        // Show the target div and hide the others
                        var targetDivId = $(this).attr("data-target");
                        $(".tab-content").hide();
                        $("#" + targetDivId).show();
                    });
                });
            </script>

            <div id="headerTabGroup" class="w-full bg-white inline-flex">
                <button id="groupDetailsButton" class="inline-flex bg-white text-badgeDarkBlue font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeLightBlue" data-target="groupDetailsDiv">
                    <span class="material-symbols-outlined">
                        details
                    </span>
                    <p>Group Details</p>    
                </button>
                <button data-target="groupMembersDiv" id="groupMembersButton" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue " data-target="groupMembersDiv">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Members</p>    
                </button>    
                <button id="groupMembersCourses" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue" data-target="groupMembersCoursesDiv">
                    <span class="material-symbols-outlined">
                        school
                    </span>
                    <p>Courses</p>    
                </button>
                <button id="groupSettingsButton" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue" data-target="groupSettingsDiv">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <p>Group Settings</p>    
                </button>                
            </div>
        </div>
    </div>

    <div class="w-full h-full bg-[#EFEFF1]">
        <div class="tab-content" id="groupDetailsDiv" style="display: none">
            <div id="subgroup-details" class="flex  w-full p-5">
                <?php get_template_part('post-templates/subgroups/template-parts/subgroup-details', null, array('group_info' => $group_info)); ?>
            </div>
        </div>

        <div class="tab-content" id="groupMembersDiv" style="display: none">
            <div id="subgroup-members" class="flex w-full  p-5">
                <?php get_template_part('post-templates/subgroups/template-parts/subgroup-members', null, array('group_info' => $group_info)); ?>
            </div>
        </div>

        <div class="tab-content" id="groupMembersCoursesDiv" style="display: none">
            <div id="subgroup-members" class="flex w-full p-5">
                <?php get_template_part('post-templates/subgroups/template-parts/subgroup-subscriptions', null, array('parent_group' => $parent_group)); ?>
            </div>
        </div>

            <div class="tab-content" id="groupSettingsDiv">
                <!-- Group Settings content here -->
            </div>
        
    </div>
</div>

        <!-- Modal Background -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="add-user-to-group-modal">

    <!-- Modal Content -->
    <div class="relative top-20 mx-auto w-3/5 shadow-lg rounded-md bg-white">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4 p-3">
            <h4 class="text-lg center w-full font-bold">Add New Group Member</h4>
            <button class="text-black close-modal">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="mb-4 p-4 h-auto bg-bgGray">
            <p>Select Agency Users to add to this group.</p>
            <select name="users-select" id="users-select" class=" w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                <?php foreach ($parent_group_users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user["ID"]); ?>">
                        <?php echo htmlspecialchars($user["display_name"]); // Replace with the appropriate property ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    
        <!-- Modal Footer -->

        <div class="flex justify-end p-3 space-x-3">
            <div class="flex justify-center p-3 space-x-3">
                
                <p id="errorMessage" class="text-[#FF0000]"></p>
                <p id="successMessage" class="text-blueAgencyBorder"></p>
            </div>
            <button onClick="addUserFetch()" id="addUserButton" class="disabled:opacity-30 disabled:cursor-not-allowed inline-flex bg-white text-badgeDarkBlue font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150" disabled >
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    <p>Add User</p>
                </button>
                <button id="" class="close-modal inline-flex bg-white text-black font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        backspace
                    </span>
                    <p>Cancel</p>    
                </button>
        </div>
    </div>
</div>


    <script>
        const addUserFetch = () => {
            const data = {
                user_id: 5, // User ID to add
                subgroup_id: 258, // Subgroup ID
            };
            const nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'; // Create the nonce here
            fetch('/wp-json/myplugin/v1/add-user-to-group/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': nonce, // For nonce verification
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.code) {
                    document.getElementById('errorMessage').innerHTML = data?.message;
                    return;
                }
                document.getElementById('successMessage').innerHTML = data;
                setTimeout(() => {
                    location.reload();
                }, '1000');
            })
            
        }
        </script>

    <script>
        // Add User To Group Modal Buttons
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.querySelector('#add-user-to-group-modal');
            const closeModalButtons = document.querySelectorAll('.close-modal');

            // Function to open the modal
            window.openModal = function() {
                modal.style.display = 'block';
            };

            // Function to close the modal
            closeModalButtons.forEach(button => {
                button.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('users-select');
            const actionButton = document.getElementById('addUserButton');

            selectElement.addEventListener('change', function() {
                if (this.value) {
                    actionButton.removeAttribute('disabled');
                } else {
                    actionButton.setAttribute('disabled', 'disabled');
                }
            });
        });
        
    </script>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.querySelector('#assign-course-modal');
        const closeModalButtons = document.querySelectorAll('.close-modal');

        // Function to open the modal
        window.openAssignModal = function() {
            modal.style.display = 'block';
        };

        // Function to close the modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        });
    });

</script>

<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="assign-course-modal">

    <!-- Modal Content -->
    <div class="relative top-20 mx-auto w-3/5 shadow-lg rounded-md bg-white">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4 p-3">
            <h4 class="text-lg center w-full font-bold">Enroll Group in Course</h4>
            <button class="text-black close-modal">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="mb-4 p-4 h-auto bg-bgGray">
            <div>
                <p> This will enroll all members of this group into the selected course.</p>
                <p> Group: <?php echo $group_info["post_title"] ?></p>
            </div>
            <script>
                var group_subscriptions = <?php echo json_encode($group_subscriptions); ?>;
                console.log(group_subscriptions);
            </script>
            <select name="course-select" id="course-select" class=" w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                <?php foreach ($group_subscriptions as $available_subscription): ?>
                    <?php if ($available_subscription["acf"]["can_enroll"]): // Check if can_enroll is true ?>
                        <option value="<?php echo htmlspecialchars($available_subscription["course"]->ID) . '|' . htmlspecialchars($available_subscription["ID"]) ; ?>">
                            <?php echo htmlspecialchars($available_subscription["course"]->post_title . ' (Subscription: ' . $available_subscription["ID"] . ')'); // Replace with the appropriate property ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            
            <div id="dates" class="w-full grid grid-cols-2 gap-2 mt-2">
                <div>
                    <p>Start / Release Date</p>
                    <input type="date" name="start-date" id="start-date" class="w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                </div>
                <div>
                    <p>End Date</p>
                    <input type="date" name="end-date" id="end-date" class="w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                </div>
                
            </div>


        <!-- Modal Footer -->

        <div class="flex justify-end p-3 space-x-3">
            <div class="flex justify-center p-3 space-x-3">
                
                <p id="errorMessage" class="text-[#FF0000]"></p>
                <p id="successMessage" class="text-blueAgencyBorder"></p>
            </div>
            <button onClick="createEnrollments()" id="addCourseButton" class="disabled:opacity-30 disabled:cursor-not-allowed inline-flex bg-white text-badgeDarkBlue font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150"  >
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    <p>Assign Course To Group</p>
                </button>
                <button id="" class="close-modal inline-flex bg-white text-black font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        backspace
                    </span>
                    <p>Cancel</p>    
                </button>
        </div>
    </div>
</div>

                    </div>
