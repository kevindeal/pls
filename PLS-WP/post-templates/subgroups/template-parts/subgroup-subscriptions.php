<?php 
    $parent_group = $args['parent_group'];
?>

<script>
    function createEnrollments() {

        function getSelectedCourseId() {
            var select = document.getElementById('course-select');
            alert(select.value)
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

<div class="w-full">
    <div id="expande" class="w-full border-2 border-borderGray rounded-md bg-white p-4 space-y-4 mb-4">
        <div id="header" class="w-full">
            <h2 class="text-xl font-bold text-textNeutral" >Available Courses</h2>
            <hr class="mb-2" />
            <p>These are the active subscriptions available for this group.</p>
            <p>Click on a course to view the course details.</p>
            <?php
                $group_subscriptions = get_group_subscriptions($parent_group->ID);
                echo "<pre>";
                // echo print_r($group_subscriptions);
                echo "</pre>";

                foreach($group_subscriptions as $sub) {
                    if ($sub["acf"]["can_enroll"] == true) {
                        get_template_part('post-templates/subgroups/template-parts/course-subscription', null, array('subs' => $sub)); 
                    }                   
                }
            ?>
        </div>

    </div>

    <div id="expande" class="w-full border-2 border-borderGray rounded-md bg-white p-4 space-y-4">
        <div id="header" class="w-full">
            <h2 class="text-xl font-bold text-textNeutral" >Assigned Courses</h2>
            <hr class="mb-2" />
            <p>These are the active subscriptions available for this group.</p>
            <p>Click on a course to view the course details.</p>
            <?php
                $group_subscriptions = get_group_subscriptions($parent_group->ID);
                echo "<pre>";
                // echo print_r($group_subscriptions);
                echo "</pre>";
                foreach($group_subscriptions as $sub) {
                    if ($sub["acf"]["can_enroll"] != true) {
                        get_template_part('post-templates/subgroups/template-parts/assigned-course', null, array('subs' => $sub)); 
                    }
                }
            ?>
        </div>
    </div>

</div>