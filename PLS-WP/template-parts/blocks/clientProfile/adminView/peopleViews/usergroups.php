<?php ?>

<?php

    $post_id = 256; // Replace with your actual post ID

    // Nice User Groups Array 
   //  $post_id = get_post()->id; // Get the current post ID
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

<div class="w-full h-auto">
    
<?php
    foreach ($nice_subgroups as $subgroup) : ?>
        <div id="list-item-closed" class="w-full align-middle rounded-xl bg-white inline-flex p-4 space-x-5 px-4 border-[#B9BBC0] border-2">
                        
            <div id="list-item-icon" class="flex justify-center items-center w-1/12 aspect-square rounded-xl border-2 border-borderPurple">
                <span class="material-symbols-outlined md-18 text-iconPurple" style="font-size: 48px">
                    school
                </span>
            </div>
            <div id="list-item-text" class="w-4/6 flex justify-start items-center">
                <div class="w-full">
                    <h2 class="text-xl font-bold text-textNeutral" >
                        <?php echo $subgroup['group_title']; ?>
                    </h2>
                    <p class="text-base text-textNeutral">
                        <?php echo count($subgroup['subgroup_members']); ?> members
                    </p>
                </div>
            </div>
            <div id="list-item-button-group" class="w-full flex justify-end items-center space-x-3">
                <!-- Text Button -->
                <button class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <p class="inline-block whitespace-nowrap">View User Group</p>
                </button>

                <!-- Icon Buttons -->
                <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                    <span class="material-symbols-outlined">more_horiz</span>
                </button>
                <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        </div>
    </div>

<?php endforeach; ?>