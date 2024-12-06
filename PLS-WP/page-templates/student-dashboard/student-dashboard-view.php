<?php
/**
 * Template Name: Student Dashboard Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */

get_header();
wp_head();
?>

<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

<?php 
    $thing = get_student_lessons(get_current_user_id()); 
    $learnerID = get_field('learner_id', 'user_' . get_current_user_id());
    $courseID = 'a3ba698f-6ee3-4b6b-b59e-b9299c174298';

    $enrollments = get_posts( array(
        'post_type' => 'enrollment',
        'posts_per_page' => -1,
        'meta_key' => 'enrolled_user',
        'meta_value' => get_current_user_id(),
    ) );

    foreach($enrollments as $enrollment) {
        $enrollment_meta = get_fields($enrollment->ID);
        $enrollment_meta['course'] = get_fields($enrollment_meta['course']->ID);

        $enrollment -> acf = $enrollment_meta;

    }

    if (!$enrollments) {
        // echo '<p class="text-base text-textNeutral">You are not enrolled in any courses.</p>';
        $enrollments_meta = [];
    } else {
        $enrollments_meta = get_fields($enrollments[0]->ID);
    }

    $upcoming_lessons = [];
    $continue_learning_lessons = [];

    foreach ($enrollments as $item) {
        foreach ($item->acf['learning_records'] as $lesson) {

            $acfDate = $lesson["access_release_date"]; // Replace with your ACF date
            $acfDateTime = DateTime::createFromFormat('m/d/Y h:i a', $acfDate);
            $today = new DateTime();

            if ($acfDateTime > $today) {
                $upcoming_lessons[] = $lesson;
            } elseif ( ( $acfDateTime ->format('Y-m-d') <= $today->format('Y-m-d') ) && ( $lesson['completed'] != true )  ) {
               $continue_learning_lessons[] = $lesson;
            } 
        }
    }

    ?>


<script>
    console.log('upcoming_lessons: ', <?php echo json_encode($upcoming_lessons); ?>);
    console.log('continue_learning_lessons: ', <?php echo json_encode($continue_learning_lessons); ?>);
</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {

            const dataArray = [];
            const enrollments = <?php echo json_encode($thing); ?>;
            for(var i of enrollments) {
                console.log('enrollment: ', i);
                for(var j of i.acf.learning_records) {
                    dataArray.push([
                        i.acf.course.post_title,  // Course Title
                        j.lesson.post_title,  // Lesson Title
                        j.access_release_date, // Date Added
                        "", // Due Date
                        j.completed ? j.lesson_end_time : "",  // Completed Date
                        j.completed ? j.completed_score : 'N/A', // Completed
                        {
                            'button_text' : j.completed ? ' Review Lesson ' : ' Start Lesson',
                            'registration_id' : j.current_registration_id,
                            'enrollment_id' : i.enrollment_id,
                        },
                        j.current_registration_id, // Registration ID
                    ])
                }
            }
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [                
                    "Course",
                    "Lesson",
                    "Date Added",
                    "Due Date",
                    "Completed",
                    "Score",
                    { 
                        name: 'Take Lesson',
                        formatter: (cell) => gridjs.html(`<a href='/student-lesson-record?r=${cell.registration_id}&e=${cell.enrollment_id}' class="border-2 border-buttonBorderGray transition-color duration-200 hover:bg-badgeLightBlue rounded-xl text-sm w-full px-2 py-1 w-2/3 ">${cell.button_text}</a>`)
                    },
                    {
                        "name": "Registration ID",
                        "hidden": true,
                    }
                    
                ],
                data: dataArray,
                pagination: dataArray.length > 10 ? true : false,
                
            }).render(document.getElementById("my-grid"));
        });
    </script>
<script >
    const enrollments = <?php echo json_encode($thing); ?>;
    console.log(enrollments);
</script>


    <script>
        const enrollments = <?php echo json_encode($enrollments); ?>;
        console.log(enrollments);
    </script>


            <script>

                $(document).ready(function() {
                    // ... your existing click event listener setup ...
                    
                    // Optionally show a default tab on page load
                    $("#lessons-to-complete").show();
                });
                
                $(document).ready(function() {
                    // Add click event listener to the buttons
                    $("#lessonsToCompleteButton, #allLessonsButton").click(function() {
                        // Remove the class border-badgeDarkBlue from all buttons
                        // alert("clicked")
                        var buttonIds = [
                            "lessonsToCompleteButton",
                            "allLessonsButton",
                        ];
                        var divId = $(this).attr("id");
                        $(this).removeClass("border-white");
                        $(this).removeClass("text-textNeutral");
                        $(this).addClass("border-badgeDarkBlue");
                        $(this).addClass("text-badgeDarkBlue");

                        buttonIds.forEach(buttonId => {
                            if (buttonId != divId) {
                                $("#" + buttonId).removeClass("border-badgeDarkBlue");
                                $("#" + buttonId).addClass("border-white");
                                $("#" + buttonId).removeClass("text-badgeDarkBlue");
                                $("#" + buttonId).addClass("text-textNeutral");
                                
                            }
                        });
                        
                        
                        // Show the target div and hide the others
                        var targetDivId = $(this).attr("data-target");
                        console.log('targetDivId: ', targetDivId);
                        $(".tab-content").hide();
                        $("#" + targetDivId).show();
                    });
                });
            </script>


<div id="main-container" class="inline-flex w-full h-full bg-[#EFEFF1]">

    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 h-screen sticky top-0 ">
        <?php get_template_part('template-parts/blocks/student-nav-bar'); ?>
    </div>


    <div id="content" class="w-4/5 h-full  bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
            <div id="exampleHeader-content" class="w-full space-y-4">
                <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                           
                </div>

                <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                    <div id="headerTitle-icon" class="w-auto">
                        <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                            local_police
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            My Lessons
                        </p>
                    </div>
                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                    <button data-target="lessons-to-complete" id="lessonsToCompleteButton" class="tabLinks inline-flex bg-white font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                        <span class="material-symbols-outlined">
                            pending
                        </span>
                        <p>Lessons To Complete</p>    
                    </button>
                    <button data-target="all-lessons" id="allLessonsButton" class="inactive tabLinks inline-flex bg-white text-textNeutral font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            format_align_justify
                        </span>
                        <p>All Lessons</p>    
                    </button>    
     
                </div>
            </div>

        </div>
    
        <div id="content-container" class="w-full h-full p-6">

            <div id="injectionDiv"></div>
            <div id="lessons-to-complete" class="w-full h-full tab-content" style="display: none">

                <button id="register-button" class="hidden bg-white text-black font-bold w-full  py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    Launch Test Lesson
                </button>

                <div class="w-full" >
                    <div id="continue-learning-lessons" class="w-full p-1 ">
                        <?php if (!$continue_learning_lessons) { ?>
                            <h2 class="text-lg font-semibold text-textNeutral" >You are not enrolled in any courses.</h2>
                            <br />
                        <?php } else { ?>
                        <div class="w-full justify-between inline-flex">
                            <h2 class="text-lg font-semibold text-textNeutral" >Continue Learning</h2>
                            <button class="rounded-lg bg-white   text-textNeutral w-1/8  py-2 px-4 transition-colors duration-200 border-[1px] border-borderGray hover:bg-badgeLightBlue">
                                View All
                            </button>
                        </div>
                    
                        <div class="inline-flex [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none'] ">
                            <?php 
                                echo '<pre>';
                                // echo var_dump($enrollments[0]->acf['course']['curriculum']);
                                echo '</pre>';
                                $first_few_lessons = array_slice($continue_learning_lessons, 0, 5);   // returns "a", "b", and "c"

                                foreach($first_few_lessons as $lesson) {
                                    get_template_part('page-templates/student-dashboard/single-lesson-item', 
                                    null, 
                                    array(
                                        'lesson' => $lesson,
                                        'learnerID' => $learnerID,
                                        'courseID' => $courseID,
                                        'enrollmentID' => $enrollments[0]->ID,
                                    ));
                                }
                            ?>
                        </div>
                        <?php } ?>
                    </div>


                    <div id="upcoming-lessons" class="w-full mt-2 p-1">
                        <h2 class="text-lg font-semibold text-textNeutral" >Coming Soon</h2>

                        <div class="inline-flex w-full">
                            <?php 
                                echo '<pre>';
                                // echo var_dump($enrollments[0]->acf['course']['curriculum']);
                                echo '</pre>';
                        
                                foreach ($enrollments as $item) {
                                    foreach ($item->acf['learning_records'] as $lesson) {

                                        $acfDate = $lesson["access_release_date"]; // Replace with your ACF date
                                        $acfDateTime = DateTime::createFromFormat('m/d/Y h:i a', $acfDate);
                                        $today = new DateTime();
                        
                                        if ($acfDateTime > $today) {
                                            get_template_part('page-templates/student-dashboard/upcoming-single-lesson-item', null, array('lesson' => $lesson));
                                        } elseif ($acfDateTime->format('Y-m-d') == $today->format('Y-m-d')) {
                                            // echo "The ACF date is today.";
                                        } else {
                                            // echo "The ACF date is in the past.";
                                        }

                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>


            </div>

            <div id="all-lessons" class="tab-content" style="display: none">
                <div class="w-full p-1 ">
                    <h2 class="text-xl font-bold text-textNeutral" >All Lessons</h2>
                    <hr class="mb-2" />
                    <div id="my-grid"></div>
                </div>
            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#register-button').click(function() {
                    console.log('register button clicked');
                    var learnerID = '<?php echo $learnerID; ?>';
                    var courseID = 'golf' // '<?php echo $courseID; ?>';

                    console.log('learnerID: ' + learnerID);
                    console.log('courseID: ' + courseID);
                    
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>', // WP AJAX URL
                        type: 'POST',
                        data: {
                            action: 'create_registration',
                            learnerID: learnerID,
                            courseID: courseID,
                        },
                        success: function(response) {
                            // Handle the response
                            console.log(response);

                            // var rustici_api_endpoint = 'https://pls-dev.engine.scorm.com';
                            var launchLink = response['data']['launchLink'];

                            // window.location.href = rustici_api_endpoint + launchLink
                            window.location.href = '/lesson-player/?launchLink=' + launchLink
                        }, 
                        error: function(errorThrown){
                            console.log(errorThrown);
                        }
                    });
                    
                });
            });

        </script>

<?php wp_footer(); ?>