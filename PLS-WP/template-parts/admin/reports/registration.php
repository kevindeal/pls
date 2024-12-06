<?php 
    $registrationID = $_GET['registrationID'] ?? null;
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

        <div id="apiResponse"></div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                
                    var userID = $(this).val();
                    console.log('userID: ', userID);

                    
                    // AJAX call to get_student_registrations function
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>', // WP AJAX URL
                        type: 'POST',
                        data: {
                            action: 'get_single_registration_ajax',
                            registrationID: '<?php echo $registrationID; ?>',
                        },
                        success: function(response) {
                            // Hide spinner
                            

                            // Handle the response from the server
                            console.log('Response: ', response);
                            $('#apiResponse').html(response.data.html);
                        },
                        error: function(xhr, status, error) {
                            

                            // Handle any errors that occur during the AJAX request
                            console.error(error);
                        }
                    });
            });
        </script>
        <hr />
        <div id="activityTable"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/gridjs@1.2.0/dist/gridjs.production.min.js"></script>
      