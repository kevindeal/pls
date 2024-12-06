<?php 
    $group_info = $args['group_info'];
    ?>

    <div class="w-full border-2 border-borderGray bg-white rounded-lg p-4">
        <p class="font-bold text-xl">Members</p>
        <hr class="my-2"/>
            <div>
                <div id="members-table"></div>
            </div>
    </div>

<script>
    window.onload = function () {
        const group_info = <?php echo json_encode($group_info); ?>;

        console.log(group_info);
        const dataArray = [];
        for (var i of group_info["acf"]["subgroup_members"]) {
            dataArray.push([
                i.display_name,
                
            ]);
        }
        
        new gridjs.Grid({
            sort: true,
            search: dataArray.length > 10 ? true : false, // Only show search bar if there are more than 10 rows
            pagination: dataArray.length > 10 ? true : false, // Only show search bar if there are more than 10 rows
            columns: [
                "Name",
                "Agencies",
                "Status",
                "Course Enrollment"
            ],
            data: dataArray, 
        }).render(document.getElementById("members-table"));
    };
</script>
