<?php
/**
 * Template Name: Student Lesson Review Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */

get_header();
wp_head();
?>

<?php $example = json_decode(`{
    "body": {
        "payloadId": "1749ea0b-9bec-4b23-ad48-80fa51f8c85c",
        "subscriptionId": "86245e30-84d3-4210-91e8-c81b3b413bca",
        "topic": "RegistrationChanged",
        "subtopics": [
            "ScoreChanged",
            "SuccessChanged",
            "CompletionChanged",
            "ObjectiveChanged",
            "InteractionChanged"
        ],
        "tenantName": "default",
        "timestamp": "2024-01-31T19:46:03.892Z",
        "body": {
            "id": "f1b973ef-d0bd-4bb9-9837-0a00541e2037",
            "instance": 0,
            "xapiRegistrationId": "26e23536-bac9-4867-ba34-533799d97e57",
            "updated": "2024-01-31T19:45:37Z",
            "registrationCompletion": "COMPLETED",
            "registrationSuccess": "FAILED",
            "score": {
                "scaled": 7
            },
            "totalSecondsTracked": 26,
            "firstAccessDate": "2024-01-31T19:45:37Z",
            "lastAccessDate": "2024-01-31T19:45:37Z",
            "completedDate": "2024-01-31T19:46:03Z",
            "createdDate": "2024-01-31T19:45:34Z",
            "course": {
                "id": "golf",
                "title": "Tin Can Golf Example",
                "version": 0
            },
            "learner": {
                "id": "e04849ba-7daf-41ad-9aa1-4ca8a4b1184d",
                "firstName": "first",
                "lastName": "last"
            },
            "activityDetails": {
                "id": "http:\/\/id.tincanapi.com\/activity\/tincan-prototypes\/golf-example",
                "title": "Tin Can Golf Example",
                "attempts": 0,
                "activityCompletion": "COMPLETED",
                "activitySuccess": "FAILED",
                "score": {
                    "scaled": 7.0000000000000009
                },
                "timeTracked": "0000:00:26.66",
                "completionAmount": {
                    "scaled": 0
                },
                "suspended": false,
                "children": [],
                "staticProperties": {
                    "completionThreshold": "",
                    "launchData": "",
                    "maxTimeAllowed": "",
                    "scaledPassingScore": -1,
                    "scaledPassingScoreUsed": false,
                    "timeLimitAction": ""
                }
            },
            "registrationCompletionAmount": 0
        },
        "bodyVersion": "1.0",
        "messageVersion": "1.0",
        "resources": {
            "course": {
                "id": "golf",
                "learningStandard": "Tin Can",
                "version": 0
            },
            "registration": {
                "id": "f1b973ef-d0bd-4bb9-9837-0a00541e2037",
                "instance": 0,
                "learner": {
                    "id": "e04849ba-7daf-41ad-9aa1-4ca8a4b1184d",
                    "firstName": "first",
                    "lastName": "last"
                },
                "isDispatch": false
            }
        }
    }`); ?>

<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

<?php 
    $thing = get_student_lessons(get_current_user_id()); 
    $learnerID = get_field('learner_id', 'user_' . get_current_user_id());
    $courseID = 'a3ba698f-6ee3-4b6b-b59e-b9299c174298';
    
    // $enrollment_id = 1778;
    $registration_id = $args['registration_id'] ?? null;
    $enrollment_id = $args['enrollment_id'] ?? null;

    $enrollment = array('post' => get_post($enrollment_id), 'acf' => get_fields($enrollment_id));
    $learning_record = [];
    foreach ($enrollment['acf']['learning_records'] as $item) {
        if ($item['current_registration_id'] == $registration_id) {
            $learning_record = $item;
        }
    }

    $lesson = array('post' => get_post($learning_record['lesson'] -> ID), 'acf' => get_fields($learning_record['lesson'] -> ID));
    ?>

    <script>
        const enrollment = <?php echo json_encode($enrollment); ?>;
        const lesson = <?php echo json_encode($lesson); ?>;
        console.log('enrollment: ', enrollment);
        console.log('lesson: ', lesson);
    </script>


<script>
    

    $(document).ready(function() {                    
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


    <div id="content" class="w-4/5 h-full bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-2">
            <div id="exampleHeader-content" class="w-full space-y-4">
                <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                           
                </div>

                <div id="headerTitle" class="w-full inline-flex items-center space-x-4 ">
                    <div id="headerTitle-icon" class="w-auto">
                        <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                            local_police
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            Lesson Review
                        </p>
                    </div>
                </div>

                <div id="headerTabGroup" class="hidden w-full bg-white inline-flex ">
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

                <div class="w-full" >
                    <div id="continue-learning-lessons" class="w-full mb-2">
                        <div class="w-full rounded-xl bg-white border-borderGray border-[1px] p-4">
                            <div class="w-full justify-between inline-flex align-middle items-center mb-1">
                                <h2 class="text-xl font-bold text-textNeutral" ><?php echo $lesson['post']->post_title ?> - Lesson Attempt Outcome  </h2>
                                <button class="bg-badgeDarkBlue text-white font-bold rounded-lg p-2 inline-flex gap-1">
                                <span class="material-symbols-outlined">
                                    sync_problem
                                </span>    
                                Request Re-Attempt</button>
                            </div>
                            <hr class="mb-2" />
                            <div class="w-full grid grid-cols-3 m-2 gap-4">
                                <div class="w-full">
                                    <p class="font-bold">Access Release Date</p>
                                    <p><?php echo isset($learning_record['access_release_date']) ? $learning_record['access_release_date'] : ''; ?></p>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Lesson Start Time</p>
                                    <p><?php echo isset($learning_record['lesson_start_time']) ? $learning_record['lesson_start_time'] : ''; ?></p>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Lesson End Time</p>
                                    <p><?php echo isset($learning_record['lesson_end_time']) ? $learning_record['lesson_end_time'] : ''; ?></p>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Required Passing Score</p>
                                    <p><?php echo isset($learning_record['passing_grade']) ? $learning_record['passing_grade'] : ''; ?></p>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Completed Lesson Score</p>
                                    <p><?php echo isset($learning_record['completed_score']) ? $learning_record['completed_score'] : ''; ?></p>
                                </div>
                                <div class="w-full">
                                    <p class="font-bold">Total Seconds Tracked</p>
                                    <p><?php echo isset($learning_record['totalSecondsTracked']) ? $learning_record['totalSecondsTracked'] : ''; ?></p>
                                </div>
                            </div>
                        </div>
                    
                        
                    </div>

                </div>


            </div>

            <div id="all-lessons" class="tab-content" >
                <div class="w-full p-4 rounded-xl bg-white border-[1px] border-borderGray">
                    <h2 class="text-xl font-bold text-textNeutral" >Interaction History</h2>
                    <hr class="mb-2" />
                    <?php 
                        get_template_part('page-templates/student-lesson-review/rustici_registration_info', null, array('registration_id' => $registration_id));
                    ?>
                </div>
            </div>

        </div>

    </div>

</div>

<?php wp_footer(); ?>



