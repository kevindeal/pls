<?php ?>

<?php
        $users = get_users(); // Get all users
        $all_registrations = array(); // Array to hold all registration data
        foreach ($users as $user) {
            $registrations = get_field('registrations', 'user_' . $user->ID); // Get 'registrations' repeater field for each user

            if ($registrations) {
                $count = 0; // Counter for limiting to 5 items
                
                foreach ($registrations as $registration) {
                    if ($count >= 5) {
                        break; // Limit to 5 items
                    }
                    $registration['user_id'] = $user->ID; // Add user ID to registration data
                    $registration['user_email'] = $user->user_email; // Add user email to registration data
                    $registration['user_display_name'] = $user->display_name; // Add user display name to registration data
                    $all_registrations[] = $registration; // Add registration data to array
                    // Display registration data
                    // echo '<p>' . $registration['created_at'] . ': ' . $registration['registration_id'] . '</p>';

                    $count++;
                }
            }
        }


        ?>


<div class="w-full flex-1 justify-center p-4 space-y-4">
    <div class="w-full rounded-lg flex-1 bg-white p-2">
        Find Registrations

        <select name="users" id="usersSelect">
            <?php foreach ($users as $user) { ?>
                <option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
            <?php } ?>
        </select>

        <div id="spinner" style="display: none;">
            <!-- Add your spinner HTML code here -->
            Searching for registrations...
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#usersSelect').change(function() {
                    var userId = $(this).val();
                    console.log('userId: ', userId);

                    // Show spinner
                    $('#spinner').show();

                    // AJAX call to get_student_registrations function
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>', // WP AJAX URL
                        type: 'POST',
                        data: {
                            action: 'get_student_registrations',
                            userID: userId,
                        },
                        success: function(response) {
                            // Hide spinner
                            $('#spinner').hide();

                            // Handle the response from the server
                            console.log('Response: ', response);
                            new gridjs.Grid({
                                columns: ['Registration ID', "Start Time"],
                                data: response.data.map(enrollment => [enrollment.learning_record.current_registration_id, enrollment.learning_record.lesson_start_time]),
                                sort: false,
                                search: false,
                                pagination: false,
                            }).render(document.getElementById("activityTable"));
                        },
                        error: function(xhr, status, error) {
                            // Hide spinner
                            $('#spinner').hide();

                            // Handle any errors that occur during the AJAX request
                            console.error(error);
                        }
                    });
                });
            });
        </script>
        <hr />
        <div id="activityTable"></div>
    </div>

    <div class="w-full flex justify-between items-center gap-2 h-1/3">

        <div class="w-1/3 rounded-lg bg-white p-2 ">
            <p class="font-bold">Recent Activity</p>
            <hr />
            
        </div>
        <div class="w-1/3 rounded-lg bg-white p-2">
            <p class="font-bold">Recent Purchases</p>
            <hr />
        </div>
        <div class="w-1/3 rounded-lg bg-white p-2">
            <p class="font-bold">Support Tickets</p>
            <hr />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/gridjs@1.2.0/dist/gridjs.production.min.js"></script>
      