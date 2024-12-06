<?php 
    $course_id = $args['course_id'];
    $group_id = $args['group_id'];
    $subscription_id = $args['subscription_id'];
    $seats_available = $args['seats_available'];

    $group_info = get_group_info($group_id);
    $user_ids = $group_info['subgroups'][0]['acf_fields']['subgroup_members'];

    $thing = get_subscription_info($subscription_id);
        // Get all the posts that are children of the group_id
        $child_groups = get_posts(array(
            'post_type' => 'subgroup', // Replace with the appropriate post type
            'post_parent' => $group_id,
            'posts_per_page' => -1, // Retrieve all posts
        ));

        foreach ($child_groups as $child_group) {
            $child_posts[] = array(
                'post' => $child_group,
                'fields' => get_fields($child_group->ID),
                'users' => get_users(),
            );
        }

?>

<script>
    const child_posts = <?php echo json_encode($child_posts); ?>;
    console.log('child_posts: ', child_posts);

    const thing = <?php echo json_encode($thing); ?>;
    console.log('thing: ', thing);

    const group_info = <?php echo json_encode($group_info['subgroups'][0]['acf_fields']['subgroup_members']); ?>;
    console.log('group_info: ', group_info);

</script>

<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full " id="assign-course-modal">

    <!-- Modal Content -->
    <div class="relative top-20 mx-auto w-3/5 shadow-lg rounded-md bg-white">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-2 p-2">
            <div>
                <h4 class="text-lg center w-full font-bold">Enroll Users in Course</h4>
                <div class="inline-flex w-full justify-start gap-4">
                    <p> Subscription ID: <?php echo $subscription_id ?></p>
                    <p> | </p>
                    <p> Seats Available: <?php echo $seats_available ?></p>
                </div>
            </div>
            <button class="text-black close-modal">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="mb-4 p-4 h-auto bg-bgGray">

            <div class="mb-2">
                <p>Chosen Course</p>

                <script>
                    var group_subscriptions = <?php echo json_encode($group_subscriptions); ?>;
                    console.log(group_subscriptions);
                </script>
                <select name="course-select" id="course-select" class=" w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                    <option value="<?php echo htmlspecialchars($course_id) ?> | <?php echo htmlspecialchars($subscription_id); ?>">
                        <?php echo htmlspecialchars(get_the_title($course_id)); // Replace with the appropriate property ?>
                    </option>
                </select>
            </div>

            <div>
                <p> Choose A User Group</p>

                <script>
                    var group_subscriptions = <?php echo json_encode($group_subscriptions); ?>;
                    console.log(group_subscriptions);
                </script>
                <select name="subgroup-select" id="subgroup-select" class=" w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                    <?php foreach ($child_groups as $child_group): ?>
                            <option value="<?php echo htmlspecialchars($child_group -> ID); ?>">
                                <?php echo htmlspecialchars($child_group -> post_title); // Replace with the appropriate property ?>
                            </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function createEnrollments() {

        function getSelectedCourseId() {
            var select = $('#course-select');
            console.log("selected values: " + select.val());
            var resultArray = select.val().split('|');
            var result = {
                course_id: resultArray[0].trim(),
                subscription_id: resultArray[1].trim()
            };

            return result;
        }

        function getSelectedDates() {
            var startDate = $('#start-date');
            var endDate = $('#end-date');
            return {
                startDate: startDate.val(),
                endDate: endDate.val()
            };
        }

        const course_id = $('#course-select').val();
        
        const users = <?php echo json_encode($user_ids); ?>;
        const user_ids = users.map(user => user.ID);
        console.log("user_ids: " + user_ids)

        const group_id = <?php echo $group_info["ID"]; ?>;
        const subgroup_id = $('#subgroup-select').val();
        console.log("group_id: " + group_id);
        console.log("subgroup_id: " + subgroup_id);
    
        console.log("course_id: " + getSelectedCourseId().course_id);
        console.log("subscription_id: " + getSelectedCourseId().subscription_id);

        const data = {
            user_ids: user_ids, // Array of user IDs
            course_id: getSelectedCourseId().course_id, // Course ID
            subgroup_id: group_id, // Subgroup ID
            subscription_id: getSelectedCourseId().subscription_id, // Subscription ID
            start_date: getSelectedDates().startDate,
            end_date: getSelectedDates().endDate
        };

        console.log('data: ', data);

        const nonce = '<?php echo wp_create_nonce('wp_rest'); ?>'; // Create the nonce here

        $.ajax({
            url: '/wp-json/myplugin/v1/create-enrollments/',
            type: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': nonce
            },
            data: JSON.stringify(data),
            success: function (data) {
                console.log(data);
                if (data.code) {
                    $('#errorMessage').html(data?.message);
                    return;
                }
                $('#successMessage').html(data);
                setTimeout(() => {
                    location.reload();
                }, '1000');
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
</script>