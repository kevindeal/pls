<?php
/**
 * Template Name: Subscription Info Template
 */
?>


<?php 
    $subscription = get_fields(get_the_ID());
    $post = get_post(get_the_ID());
    
    $query = new WP_Query(array(
        'post_type' => 'enrollment',
        'meta_query' => array(
            array(
                'key' => 'subscription',
                'value' => get_the_ID(),
                'compare' => '=',
            ),
        ),
    ));

    $enrollments = array();
    forEach($query->posts as $post) {
        $fields = get_fields($post->ID);
        $enrollments[] = array("post" => $post, "fields" => $fields);
    }
    
?>

<script>
    var subscription = <?php echo json_encode($subscription); ?>;
    var post = <?php echo json_encode($post); ?>;
    console.log('subscription: ', subscription);
    console.log('post: ', post);

    var enrollments = <?php echo json_encode($enrollments); ?>;
    console.log('enrollments: ', enrollments);
    
</script>
<div class="inline-flex w-full">
    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="min-w-[250px] w-1/5 bg-white h-screen sticky top-0">
        <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
    </div>

<div id="content" class="w-full h-full pt-0 bg-[#EFEFF1]">

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="/groups">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>All Subscriptions</p>            
                </button> 
                </a> 
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
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
                        Subscription <?php echo $post -> ID; ?>
                    </p>
                    <h1 class="text-base font-thin">Created: <?php echo $subscription['subscription_created']; ?> </h1>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm hidden">
                    <p class=" text-badgeDarkBlue">
                        <?php echo $agency_type; ?>
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
                        people
                    </span>
                    <p>Enrollments</p>    
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
    
    <div id="content-container" class="w-full h-full p-6">
        <div class="bg-white rounded-lg w-full p-4">
            <div class="grid grid-cols-2 w-full gap-4">
                <div class="w-1/2">
                    <h2 class="text-base" >Agency Group</h2>
                    <p class="text-xl">
                        <?php echo $subscription['client_group']-> post_title ; ?>
                    </p>
                </div>
                <div class="w-1/2">
                    <h2 class="text-base" >Payment Status</h2>
                    <p class="text-xl">
                        <?php echo $subscription['payment_status']; ?>
                    </p>
                </div>
                <div class="w-1/2">
                    <h2 class="text-base" >Seats Purchased</h2>
                    <p class="text-xl">
                        <?php echo $subscription['seats']; ?>
                    </p>
                </div>
                <div class="w-1/2">
                    <h2 class="text-base" >Subscription Start Date</h2>
                    <p class="text-xl">
                        <?php echo $subscription['subscription_start_date'] . ' - ' . $subscription['subscription_end_date']; ?>
                    </p>
                </div>
            </div>
        </div>
        
        <br />

        <div class="bg-white rounded-lg w-full p-4">
            <div id="list-item-closed" class="w-full align-middle rounded-xl bg-white p-4 space-y-5 px-4 border-[#B9BBC0] border-2 mt-4 mb-4">
                <div class="w-full inline-flex space-x-5">
                    <div id="list-item-icon" class="flex justify-center items-center w-1/12 aspect-square rounded-xl border-2 border-borderPurple">
                        <span class="material-symbols-outlined md-18 text-iconPurple" style="font-size: 48px">
                            school
                        </span>
                    </div>
                    <div id="list-item-text" class="w-4/6 flex justify-start items-center">
                        <div class="w-full">
                            <h2 class="text-xl font-bold text-textNeutral" >
                                <?php echo $subscription['course'] -> post_title ?>
                            </h2>
                            <p class="text-base text-textNeutral">16 Lessons</p>
                        </div>
                    </div>
                    <div id="list-item-button-group" class="w-full flex justify-end items-center space-x-3">
                        <!-- Text Button -->
                        <a href="<?php echo get_permalink($courseID) ?>" class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-badgeLightBlue hover:bg-opacity-25 transition-colors duration-150 text-sm">
                            <p class="inline-block whitespace-nowrap">View Course Page</p>
                        </a>

                        <button id="enrollButton" class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-badgeLightBlue hover:bg-opacity-25 transition-colors duration-150 text-sm">
                            <p class="inline-block whitespace-nowrap">Enroll Users</p>
                        </button>
                        <!-- Icon Buttons -->

                    </div>
                </div>
                <div class="mt-4 w-full">

                    <?php
                        $lessons = get_curriculum($subscription['course']->ID)['lessons'];
                        echo '<pre>';
                        // echo var_dump($lessons);
                        echo '</pre>';
                    ?>
                    <div id="lessons-table"></div>
                </div>
            </div>

        <div id="enrollments" class="w-full border-2 border-borderGray rounded-lg bg-white p-4 mt-2">
            <div id="enrollments-header" class="w-full inline-flex justify-between items-center">
                <h2 class="text-xl font-bold text-textNeutral">Enrollments</h2>
                <button id="enrollments-button" class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <p class="inline-block whitespace-nowrap">Enroll Users</p>
                </button>
            </div>

            <div id="enrollments-table"></div>
        </div>
    </div>

</div>


<script>
    // Assuming $enrollments is an array of enrollment data
    document.addEventListener('DOMContentLoaded', function () {
        var enrollments = <?php echo json_encode($enrollments); ?>;
        console.log('enrollments: ', enrollments);

        const dataArray = [];
        let index = 0;
        for (const item of enrollments) {
            const data = [];
            // Add a unique identifier as the first element
            // data.push(index);
            data.push({
                name: item.fields.enrolled_user.display_name,
                link: item.post.guid,
                });
            data.push(item.fields.enrollment_start_date);
            data.push(item.fields.enrollment_end_date);
            // ... add other enrollment data
            dataArray.push(data);
            index++;
        }

        console.log('dataArray: ', dataArray);
        // Create the GridJS table
        const grid = new gridjs.Grid({
            columns: [
                {
                    name: 'User Name',
                    formatter: (cell) => gridjs.html(`<a href='${cell.link}'>${cell.name}</a>`)

                },
                'Start Date',
                'End Date',
                'Lessons Started',
                'Lessons Completed',
                // ... add other column headers
            ],
            data: dataArray,
        }).render(document.getElementById('enrollments-table'));
    });
</script>


    
<script>
    // Assuming $lessons is an array of lesson data
    document.addEventListener('DOMContentLoaded', function () {
    var lessons = <?php echo json_encode($lessons); ?>;
    console.log('lessons: ', lessons);

    const dataArray = [];
    let index = 0;
    for (const key of Object.keys(lessons)) {
        const data = [];
        // Add a unique identifier as the first element
        // data.push(index);
        data.push(lessons[key].post_title);
        // ... add other lesson data
        dataArray.push(data);
        index++;
    }

    console.log('dataArray: ', dataArray);
    // Create the GridJS table
    const grid = new gridjs.Grid({
        columns: [
            // {
            //    id: 'myCheckbox',
            //    name: 'Select',
            //    plugin: {
                    // install the RowSelection plugin
            //        component: gridjs.plugins.selection.RowSelection,
            //    }
            // },
            {"name": "Lessons", "columns": [
                {"name": "Title"},
                {"name": "Category"},
            ]},
            {"name": "Enrollment Status", "columns": [
                {"name": "Groups Enrolled"},
                {"name": "Seats Taken"},
                {"name": "Seats Available"},
            ]},
        ],
        data: dataArray,
        sort: true,
        search: dataArray.length > 10 ? true : false,
        pagination: dataArray.length > 10 ? true : false,
        container: '#lessons-table',
    });

    grid.render(document.getElementById('lessons-table'));

    grid.on('rowClick', (...args) => console.log('row: ' , args));
    grid.config.store.subscribe(function (state) {
    // console.log('Current state:', state);
    grid.config.store.subscribe(function (state) {
    if (state.rowSelection) {
        const selectedRowIndices = state.rowSelection.rowIds;
        // console.log('Selected row indices:', selectedRowIndices);

        const selectedRowData = selectedRowIndices.map((index) => {
            return dataArray[index]; // Use the index to retrieve the row data
        });

        // console.log('Selected row data:', selectedRowData);
    }

    // console.log(grid)
});

    // Inspect the logged state to find the correct property for selected rows
    // Once identified, use that property to access the selected rows
});
});


</script>


<script>
    jQuery(document).ready(function($) {
        $('#enrollButton').click(function(){
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST', // Set the request method to POST
                data: {
                    'action': 'enroll_user_modal_ajax',
                    'course_id': '<?php echo $subscription['course']->ID; ?>',
                    'group_id': '<?php echo $subscription['client_group']->ID; ?>',
                    'subscription_id': '<?php echo $post -> ID; ?>',
                    'seats_available': '<?php echo $subscription['seats']; ?>',

                },
                success:function(data) {
                    // This is where you can inject the HTML data into your page
                    // console.log('data: ', data);
                    $('#injectionDiv').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            }); 
        });
    });
</script>

<div id="injectionDiv"></div>
