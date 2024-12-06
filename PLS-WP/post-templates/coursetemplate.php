<?php
/**
 * Template Name: Course Info Template
 * Template Post Type: acf-course
 */
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Other links and scripts -->
        <title>
            <?php echo the_title() ?>
        </title>
        <?php
            get_header(); 
        ?> <!-- This is important for WordPress to load additional styles and scripts -->
       
    </head>
    <body <?php body_class(); ?>>

<?php
  $post_id = get_the_ID();
  $subscription = get_fields(get_the_ID());
  $details = get_curriculum($post_id);
//  echo var_dump($details);

    // Get all fields for the post
    // $post_fields = get_fields($post_id);

    // Variable to store the 'course_description_' field value
    $course_description = get_field('course_discription_',$post_id);

?>


<?php
// ROLE CHECK -----------------
  // Check if user is logged in
  if ( is_user_logged_in() ) : 
      // Get the current user
      $current_user = wp_get_current_user();
      // echo 'Welcome, ' . $current_user->user_login . '!';
      // Check if the user ID is 2 for the admin view
      // Replace 'desired_role' with the actual role you're checking for
    //   if (in_array('administrator', $current_user->roles) || in_array('client_group_admin', $current_user->roles)) {
    //       // The user has the 'desired_role' role
    //     //take the php off of this
    //       echo get_template_part('template-parts/blocks/clientProfile/courseDetail.php');
    //   } else {
    //       // Default content or template part for other users
    //       get_template_part('clientProfile-parts/publicView'); // Assuming it's in the same subdirectory
    //   }
    ?>
    <div class="w-full bg-bgGray">
  <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
    <div id="exampleHeader-content" class="w-full space-y-4">
        <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
            <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                <span class="material-symbols-outlined">
                        arrow_back
                    </span>
                    <p>All Agencies</p>                
            </button>  
            <!-- <button onClick="openModal()" class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <p>Add New Member</p>                
            </button>             -->
        </div>

        <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
            <div id="headerTitle-icon" class="w-auto">
                <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                    local_police
                </span>
            </div>
            <div id="headerTitle-TextGroup">
                <p class="text-3xl font-bold"><?php echo the_title() ?></p>
                <h1 class="text-base font-thin">Some Subheadline</h1>
            </div>
            <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                <p class=" text-badgeDarkBlue">
                    Badge
                </p>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>

                $(document).ready(function() {
                    // ... your existing click event listener setup ...

                    // Optionally show a default tab on page load
                    $("#courseDetailsDiv").show();
                });
                
                $(document).ready(function() {
                // Add click event listener to the buttons
                $("#courseDetailsButton, #courseLessonsButton, #courseLessonSummary, #courseSettingsButton").click(function() {
                    // Log an alert when the button is clicked
                    console.log("Button clicked");

                    // Your existing code for changing divs goes here
                    var buttonIds = [
                        "courseDetailsButton",
                        "courseLessonsButton",
                        "courseLessonSummary",
                        "courseSettingsButton"
                    ];
                    var divId = $(this).attr("id");
                    console.log('this is the div',divId);
                    $(this).removeClass("border-white");
                    $(this).addClass("border-badgeDarkBlue");

                    buttonIds.forEach(buttonId => {
                        if (buttonId != divId) {
                            $("#" + buttonId).removeClass("border-badgeDarkBlue");
                            $("#" + buttonId).addClass("border-white");
                        }
                    });

                    // Show the target div and hide the others
                    var targetDivId = $(this).attr("data-target");
                    console.log('THE TARGET DIV',targetDivId);
                    $(".tab-content").hide();
                    $("#" + targetDivId).show();
                });
            });
            </script>

            <div id="headerTabGroup" class="w-full bg-white inline-flex">
                <button id="courseDetailsButton" class="inline-flex bg-white text-badgeDarkBlue font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeLightBlue" data-target="courseDetailsDiv">
                    <span class="material-symbols-outlined">
                        details
                    </span>
                    <p>Details</p>    
                </button>
                <button id="courseLessonsButton" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue " data-target="courseLessonsDiv">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>    
                <button id="courseLessonSummary" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue" data-target="lessonSummaryDiv">
                    <span class="material-symbols-outlined">
                        school
                    </span>
                    <p>Lesson Summary</p>    
                </button>
                <button id="courseSettingsButton" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue" data-target="courseSettingsButtonDiv">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <p>Group Settings</p>    
                </button>                
            </div>

        </div>

    </div>
    <div class="w-full h-full bg-[#EFEFF1] ">
        <div class="tab-content" id="courseDetailsDiv" style="display: none">
            <div id="course-details" class="flex  w-full space-y-5 p-5">
                <!-- course details content here -->
               <?php get_template_part('template-parts/blocks/clientProfile/course-details') ?>
                
            </div>
        </div>

        <div class="tab-content" id="courseLessonsDiv" style="display: none">
            <div id="course-details" class="flex  w-full space-y-5 p-5">
                <?php get_template_part('template-parts/blocks/clientProfile/courseDetail'); ?>
                <!-- course details content here -->
            </div>
        </div>

        <div class="tab-content" id="lessonSummaryDiv" style="display: none">
            <div id="lesson-summary" class="w-full justify-between space-y-5  p-5">
                <?php get_template_part('template-parts/blocks/lesson-summary-block', null, array('details' => $details));
                ?>
            </div>
        </div>

            <div class="tab-content" id="courseSettingsDiv">
                <!-- Group Settings content here -->
                
            </div>
        
    </div>
    <?php
   else :
      // Content to show if no user is logged in
      get_template_part('template-parts/blocks/lesson-summary-block', null, array('details' => $details));
  endif
?>

</body>


<?php wp_footer(); ?> <!-- Essential for WordPress scripts and styles -->