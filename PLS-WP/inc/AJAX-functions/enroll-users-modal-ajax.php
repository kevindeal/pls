<?php ?>

<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full " id="assign-course-modal">

    <!-- Modal Content -->
    <div class="relative top-20 mx-auto w-3/5 shadow-lg rounded-md bg-white">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4 p-3">
            <h4 class="text-lg center w-full font-bold">Enroll Group in Course</h4>
            <button class="text-black close-modal">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="mb-4 p-4 h-auto bg-bgGray">
            <div>
                <p> This will enroll all members of this group into the selected course.</p>
                <p> Group: <?php echo $group_info["post_title"] ?></p>
            </div>
            <script>
                var group_subscriptions = <?php echo json_encode($group_subscriptions); ?>;
                console.log(group_subscriptions);
            </script>
            <select name="course-select" id="course-select" class=" w-full p-2 h-10 bg-white mt-3 rounded-lg border-none">
                <?php foreach ($group_subscriptions as $available_subscription): ?>
                    <?php if ($available_subscription["acf"]["can_enroll"]): // Check if can_enroll is true ?>
                        <option value="<?php echo htmlspecialchars($available_subscription["course"]->ID) . '|' . htmlspecialchars($available_subscription["ID"]) ; ?>">
                            <?php echo htmlspecialchars($available_subscription["course"]->post_title . ' (Subscription: ' . $available_subscription["ID"] . ')'); // Replace with the appropriate property ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            
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