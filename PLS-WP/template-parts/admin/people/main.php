<?php 

?>
<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/gridjs@1.2.0/dist/gridjs.production.min.js"></script>


<div class="flex ">

    <div class="w-full p-4 inline-flex gap-4">
        <button id="add-new-user-button" class="h-12 border-[1px] duration-200 border-borderGray hover:bg-badgeLightBlue text-neutral font-bold py-2 px-2 rounded-lg">
            Add New User
        </button>
        <button id="add-new-group-button" class="h-12 border-[1px] border-borderGray hover:bg-badgeLightBlue duration-200 text-neutral font-bold py-2 px-2 rounded-lg">
            Add New Client Group
        </button>
        <button class="h-12 border-[1px] border-borderGray hover:bg-badgeLightBlue duration-200 text-neutral font-bold py-2 px-2 rounded-lg">
            Add New Accredidation Group
        </button>
    </div>
    <hr />

</div>
<div class="p-4" id="my-grid"></div>
<div class="w-full">
<div id="content-container" class="w-full h-full p-4">
        
        <?php 
            $all_users = get_users();
            $nice_people = [];
            foreach ($all_users as $user) {
                $nice_person = new stdClass; // Create a new standard class object
                // $nice_person->first_name = $user->first_name; // Access object property with arrow syntax
                // $nice_person->last_name = $user->last_name; // Access object property with arrow syntax
                $nice_person->id = $user->ID; // Access object property with arrow syntax
                $nice_person->user_meta = get_user_meta($user->ID);
                $nice_person->fields = get_fields('user_' . $user->ID);
                $nice_people[] = $nice_person; // If you uncomment this, it will collect your $nice_group objects
            }
            ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const users = <?php echo json_encode($nice_people); ?>;

            console.log(users);
            const dataArray = [];
            for (var i of users) {
                dataArray.push([
                    i.user_meta?.first_name, 
                    i.user_meta?.last_name, 
                    i.fields && i.fields.users_agency_groups ? i.fields?.users_agency_groups[0]?.post_title : "",
                    "", // i.fields.agencies, 
                ]);
            }
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [
                    "First Name",
                    "Last Name",
                    "Agencies",
                    "Status"
                ],
                data: dataArray, 
            }).render(document.getElementById("my-grid"));
        });
    </script>
            


    <div id="myTable"></div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#add-new-user-button').click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // WP AJAX URL
            type: 'POST',
            data: {
                action: 'get_add_new_user_modal_ajax',
                // userID: userId,
            },
            success: function(response) {
                // Inject the response into the DOM
                $('#modal-area').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    });
    $('#add-new-group-button').click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // WP AJAX URL
            type: 'POST',
            data: {
                action: 'get_add_new_group_modal_ajax',
                // userID: userId,
            },
            success: function(response) {
                // Inject the response into the DOM
                $('#modal-area').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    });
});
</script>

<div id="modal-area"></div>

