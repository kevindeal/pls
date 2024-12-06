<?php 
    $subs = $args['subs'];
    $courseID = $subs['course']->ID;

    $course = get_post( $courseID );
    $course_fields = get_fields( $courseID );

    echo '<pre>';
    // echo print_r($course_fields);
    echo '</pre>';
?>

<div id="list-item-closed" class="w-full align-middle rounded-xl bg-white p-4 space-x-5 px-4 border-[#B9BBC0] border-2 mt-4 mb-4">
    <div class="w-full inline-flex space-x-5">
        <div id="list-item-icon" class="flex justify-center items-center w-1/12 aspect-square rounded-xl border-2 border-borderPurple">
            <span class="material-symbols-outlined md-18 text-iconPurple" style="font-size: 48px">
                school
            </span>
        </div>
        <div id="list-item-text" class="w-4/6 flex justify-start items-center">
            <div class="w-full">
                <h2 class="text-xl font-bold text-textNeutral" >
                    <?php echo $subs['course'] -> post_title ?>
                </h2>
                <p class="text-base text-textNeutral">16 Lessons</p>
            </div>
        </div>
        <div id="list-item-button-group" class="w-full flex justify-end items-center space-x-3">
            <!-- Text Button -->
            <button class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                <p class="inline-block whitespace-nowrap">View Course</p>
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
    <br />
    <div>
        <p class="text-base text-textNeutral">
            <script>
                var course_fields = <?php echo json_encode($course_fields); ?>;
                console.log(course_fields);
            </script>

        </p>
    
        <?php 
            if( $course_fields['curriculum'] ) {
                echo '<p class="text-base text-textNeutral">Cirriculum</p>';
                echo '<ul class="list-disc list-inside">';
                foreach( $course_fields['curriculum'] as $cirriculum ) {
                    echo '<li class="text-base text-textNeutral">' . $cirriculum['lesson'] -> post_title . '</li>';
                }
                echo '</ul>';
            }
            ?>
    </div>
</div>

