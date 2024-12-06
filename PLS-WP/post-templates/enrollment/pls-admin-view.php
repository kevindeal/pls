<?php 
    $fields = get_fields();
?>

<script>
    const enrollment = <?php echo json_encode($fields); ?>;
    console.log('enrollment: ', enrollment);
</script>
<div class="inline-flex w-full">
    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="min-w-[250px] w-1/5 h-screen sticky top-0 ">
        <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
    </div>

<div id="content" class="w-full h-full bg-[#EFEFF1] justify-center" >

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="/groups">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-badgeLightBlue hover:bg-opacity-25 transition-colors duration-200 text-sm">
                    <span class="material-symbols-outlined rotate-45">
                            arrow_back
                        </span>
                        <p>All Enrollments</p>                
                </button> 
                </a> 
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-badgeLightBlue hover:bg-opacity-25 transition-colors duration-200 text-sm">
                        <p>Action</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        subject
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">
                        Enrollment <?php echo $post -> ID; ?>
                    </p>
                    <h1 class="text-base font-thin">Created: <?php echo $fields['creation_date']; ?> </h1>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        Active <?php echo $fields['enrollment_status']; ?>
                    </p>
                </div>
            </div>

            <div id="headerTabGroup" class="w-full bg-white inline-flex ">
            <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>Details</p>    
                </button>
                <button onClick="tabChange(event, 'people-container')" id="peopleButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        home_storage
                    </span>
                    <p>Learning Records</p>    
                </button>    
                <button id="coursesButton" onClick="tabChange(event, 'courses-container')" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Assigned Courses</p>  
                </button>
            </div>
        </div>

    </div>
<div class="w-full p-4">
<div id="details-container" class="w-full bg-white p-4 mt-4">
    <div class="bg-white rounded-lg w-full p-4">
            <div class="grid grid-cols-2 w-full gap-4">
                <div class="w-auto">
                    <h2 class="text-base" >Enrolled User</h2>
                    <p class="text-xl">
                        <?php echo $fields['enrolled_user']['display_name'] ; ?>
                    </p>
                </div>
                <div class="w-auto">
                    <h2 class="text-base" >Agency Group</h2>
                    <p class="text-xl">
                        <?php echo $fields['enrolling_subgroup']->post_title; ?>
                    </p>
                </div>
                <div class="w-auto">
                    <h2 class="text-base" >Subscription Start Date</h2>
                    <p class="text-xl">
                        <?php echo $fields['enrollment_start_date'] . ' - ' . $fields['enrollment_end_date']; ?>
                    </p>
                </div>
                <div class="w-auto">
                    <h2 class="text-base" >Subscription Start Date</h2>
                    <p class="text-xl">
                        <?php echo $subscription['subscription_start_date'] . ' - ' . $subscription['subscription_end_date']; ?>
                    </p>
                </div>
            </div>


        </div>
    </div>

    <div class="bg-white rounded-lg w-full p-4 mt-2">
        
        <p class="text-xl mb-2 font-bold">Learning Records</p>

        <div class="p-2 rounded-lg border-2 border-borderGray bg-white w-full ">
            <div class="grid grid-cols-3 justify-between gap-2">    
                    <div class="w-full" id="learning-records-table">
                    <h2 class="text-base" >Lesson Name</h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['lesson'] -> post_title ; ?>
                            </p>
                    </div>
                    <div class="w-full">
                            <h2 class="text-base" >Access Release Date</h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['access_release_date']; ?>
                            </p>
                    </div>
                    <div class="w-full">
                            <h2 class="text-base" >Current Registratin ID</h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['current_registration_id']; ?>
                            </p>
                    </div>
                    <div class="w-full">
                            <h2 class="text-base" >Completed</h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['completed']; ?>
                            </p>
                    </div>
                    <div class="w-full">
                            <h2 class="text-base" >Passing Grade</h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['passing_grade']; ?>
                            </p>
                    </div>
                    <div class="w-full">
                            <h2 class="text-base" >Lesson Start Time </h2>
                            <p class="text-xl">
                                <?php echo $fields['learning_records'][0]['lesson_start_time']; ?>
                            </p>
                    </div>
            </div>

            <?php if(count($fields['learning_records'][0]['lesson_events']) > 1) : ?>
                <p class="text-xl font-bold">Lesson Records</p>
                <div class="p-2" id="lesson_learning_records_table"></div>
                
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        const lessonEvents = <?php echo json_encode($fields['learning_records'][0]['lesson_events']); ?>;

                        const grid = new gridjs.Grid({
                            columns: ['Time', 'Type', 'Event Data'],
                            data: lessonEvents.map(event => [
                                event.event_time,
                                event.event_type,
                                event.event_data
                            ]),
                            sort: true,
                            search: true,
                            pagination: true
                        })
                        grid.render(document.getElementById('lesson_learning_records_table'));
                    });
                </script>
                <?php else: ?>
                    <p class="text-xl font-bold">No Lesson Records</p>
            <?php endif; ?>

        </div>
    </div>

</div>
    </div>
    </div>