<?php 
    $group_info = $args['group_info'];
?>

<div class="w-full h-1/4 bg-white border-borderGray border-2 rounded-xl py-3 px-4">
    <div class="w-full grid grid-cols-2 space-y-2">
        <div id="gridbox-element" class="w-1/2">
            <h2 class="text-base" >Creation Date</h2>
            <p class="text-xl"><?php echo $group_info["post_date"] ?></p>
        </div>
        <div id="gridbox-element" class="w-1/2">
            <h2 class="text-base" >Created By</h2>
            <p class="text-xl"><?php get_the_author() ?></p>
        </div>
        <div id="gridbox-element" class="w-1/2">
            <h2 class="text-base" >Group Description</h2>
            <p class="text-xl">Item Text</p>
        </div>
        <div id="gridbox-element" class="w-1/2">
            <h2 class="text-base" >Total Members</h2>
            <p class="text-xl"><?php echo count($group_info["acf"]["subgroup_members"]) ?> </p>
        </div>
    </div>
</div>        
