<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

<?php 

    $post_id = get_the_id(); // Replace with your actual post ID
    $my_post = get_post($post_id);
    $client_group_subgroups = get_children($post_id); // Subgroups are child posts of the current Client Group

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
        $subgroups = get_field('agency_group', $post_id);

    }

    $acf_field_name = 'agency_members'; // Replace with your actual ACF field key/name
    $acf_array_value = get_field($acf_field_name, $post_id);

    if ($acf_array_value) {
        // Process your ACF array value here
        // For example, if it's an array of items:
        foreach ($acf_array_value as $item) {
            $user_profile = get_user_meta($item['ID']);
            // echo var_dump($user_profile);
            // Do something with each $item
            // echo '<pre>';
            // echo var_dump($user_profile);
            // echo '</pre>';
        }
    } else {
        // ACF field is empty or does not exist
        echo 'No ACF field value found.';
    }

    $group_location = get_field("profile", $post_id);
?>

<?php
    // Nice Users Array Object
    $nice_user_array = [];
    $client_group_members = get_field('agency_members', $post_id); // Get the Client Group (parent) members
    
    $subgroups = get_field('agency_group', $post_id); // Get the Client Group's subgroups (children)

    $nice_subgroups = [];
    if ($subgroups) {
        foreach ($subgroups as $subgroup) {
            $thing = get_post($subgroup);
            // echo var_dump($thing);
            $sub_members = get_fields($thing->ID);
            // echo '<pre>';
            // echo var_dump($sub_members);
            // echo '</pre>';
            $nice_group = new stdClass; // Create a new standard class object
            $nice_group->name = $thing->post_title; // Access object property with arrow syntax
            $nice_group->id = $thing->ID; // Access object property with arrow syntax
            $nice_subgroups[] = $sub_members; // If you uncomment this, it will collect your $nice_group objects
        }
        
        // echo '<pre> <br> nice_subgroups <br>';
        // echo var_dump($nice_subgroups);
        // echo '</pre>';
    }

    foreach ($client_group_members as $client_group_member) {

        $nice_user = new stdClass; // Create a new standard class object
        $nice_user->name = $client_group_member['display_name']; // Access object property with arrow syntax
        $nice_user->id = $client_group_member['ID']; // Access object property with arrow syntax
        
        // Get user's subgroup memberships within the current Client Group hierarchy
        $nice_user->subgroup_membership = [];
        foreach ($nice_subgroups as $nice_subgroup) {
            foreach ($nice_subgroup['subgroup_members'] as $subgroup_member) {
                if ($subgroup_member['ID'] == $client_group_member['ID']) {
                    $nice_user->subgroup_membership[] = $nice_subgroup['group_title'];
                }
            }
        }

        // Get user's roles
        $roles = get_userdata($client_group_member['ID'])->roles;
        $nice_user->roles = $roles;

        $nice_user_array[] = $nice_user;
    }

    $thing2 = get_fields($post_id);
    // echo '<pre>';
    // echo 'client_group_members';
    // echo var_dump($nice_user_array);
    // echo '</pre>';
?>

<?php
    // Nice User Groups Array 
    $nice_subgroups = [];
    $client_group_members = get_field('agency_members', $post_id); // Get the Client Group (parent) members
    
    $subgroups = get_field('agency_group', $post_id); // Get the Client Group's subgroups (children)

    if ($subgroups) {
        foreach ($subgroups as $subgroup) {
            $thing = get_post($subgroup);
            // echo var_dump($thing);
            $sub_members = get_fields($thing->ID);
            // echo '<pre>';
            // echo var_dump($sub_members);
            // echo '</pre>';
            $nice_group = new stdClass; // Create a new standard class object
            $nice_group->name = $thing->post_title; // Access object property with arrow syntax
            $nice_group->id = $thing->ID; // Access object property with arrow syntax
            $nice_subgroups[] = $sub_members; // If you uncomment this, it will collect your $nice_group objects
        }
        
        // echo '<pre> <br> nice_subgroups <br>';
        // echo var_dump($nice_subgroups);
        // echo '</pre>';
    }
?>

            <div id="toggleGroupExample-container" class="w-auto p-1 space-x-1 mb-4 inline-flex rounded-xl border-[1px] border-borderGray">

                <button onClick='
                    document.getElementById("usergroup-table").classList.add("hidden");
                    document.getElementById("people-table").classList.remove("hidden");
                    document.getElementById("allUsersButton").classList.add("bg-white");
                    document.getElementById("usergroupsButton").classList.remove("bg-white");
                    '
                  id="allUsersButton" 
                ' class="inline-flex space-x-1 w-auto p-2 bg-white rounded-lg">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>All Users</p> 
                </button>
                <button onClick='
                    document.getElementById("usergroup-table").classList.remove("hidden");
                    document.getElementById("people-table").classList.add("hidden");
                    document.getElementById("allUsersButton").classList.remove("bg-white");
                    document.getElementById("usergroupsButton").classList.add("bg-white");
                    '
                  id="usergroupsButton" 
                  class="inline-flex space-x-1 w-auto p-2 rounded-lg transition-all duration-200">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>User Groups</p> 
                </button>
            </div>

            <div id="usergroup-table" class="w-full hidden">
                <?php get_template_part('post-templates/client-group-profile/adminView/peopleViews/usergroups'); ?>
            </div>

            <div id="people-table" class="w-full h-auto bg-white  border-borderGray border-2 rounded-xl py-3 px-4">

                <div id="my-grid"></div>
            
                <script>
    document.addEventListener('DOMContentLoaded', function () {
        var nice_groups = <?php echo json_encode($nice_user_array); ?>;
        console.log(nice_groups);
        dataArray = [];
        for (var i of nice_groups) {
            dataArray.push([
                i.name, 
                "",
                i.subgroup_membership,
                i.id,
                i.roles
            ]);
        }
        new gridjs.Grid({
            sort: true,
            search: true,
            pagination: true,
            columns: [
                
                "First Name",
                "Last Name",
                "Groups",
                "ID",
                "Roles"
            ],
            data: dataArray, 
            
        }).render(document.getElementById("my-grid"));
    });
    </script>
            
    </div>
</div>
