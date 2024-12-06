<?php 

    $post_id = 256; // Replace with your actual post ID
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
                <?php get_template_part('template-parts/blocks/clientProfile/adminView/peopleViews/usergroups'); ?>
            </div>

            <div id="people-table" class="w-full h-auto bg-white  border-borderGray border-2 rounded-xl py-3 px-4">

                <table class="min-w-full rounded-xl divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800 rounded-md">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <button class="flex items-center gap-x-3 focus:outline-none">
                                            <span>First Name</span>

                                            <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                            </svg>
                                        </button>
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Last Name
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Groups
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        ID
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Roles
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <?php 

                            foreach ($nice_user_array as $member): 
                                // $user_meta = get_user_meta($member['ID']);

                                $name = $member->name;
                                // $last_name = $user_meta['last_name'][0];
                                // $id = $member['ID'];

                                // $user_groups = $user_meta['_clent_group_memberships'];
                                
                                
                            ?>
                                <tr>
                                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                        <div>
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                                <?php echo $member->name; ?>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                        <p class="text-gray-500 dark:text-gray-400">
                                            <?php echo $member->name ?>
                                        </p>
                                    </td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">
                                                <?php 
                                                    if (empty($member->subgroup_membership)) {
                                                        // echo 'No Groups';
                                                    } else {
                                                        echo $member->subgroup_membership[0];
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                </td>
                                <td class="px-4 py-4 items-center text-center text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            <?php echo $member->id; ?>
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            <?php 
                                                if (empty($member->roles)) {
                                                    // echo 'No Groups';
                                                } else {
                                                    foreach ($member->roles as $role) {
                                                        echo $role;
                                                        echo ', ';
                                                    }
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
