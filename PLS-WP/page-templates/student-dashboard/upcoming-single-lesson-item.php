<?php 
    $lesson_data = $args['lesson'];
    $release_date = $lesson_data["access_release_date"];
    $prettier_date = date('F j', strtotime($release_date));

    $lesson_item = get_fields($lesson_data["lesson"] -> ID);
    $lesson_materials = get_fields($lesson_item["lesson_materials"] -> ID);
    $acfDateTime = DateTime::createFromFormat('m/d/Y h:i a', $release_date);
    $learnerID = $args['learnerID'];
    $courseID = $args['courseID'];
    $enrollmentID = $args['enrollmentID'];

?>
    <?php 
        echo '<pre>';
        // echo var_dump($args);
        echo '</pre>';
    ?>

    <script>
        var lesson_data = <?php echo json_encode($lesson_data); ?>;
        console.log('lesson_data ', lesson_data);

        var args = <?php echo json_encode($lesson_materials); ?>;
        console.log('args ', args);

    </script>

<div class=" w-56 mr-2 flex-col aspect-square bg-white p-2 rounded-lg border-[1px] border-borderGray hover:scale-105 duration-200 cursor-pointer" >

    <div id="lesson-text" class="flex-grow h-3/5">
        
        <div id="badges" class="inline-flex gap-1 row">

            <div class="h-8 mt-2">
                <p class=" center text-center rounded-lg w-auto p-1 bg-borderGray text-sm text-black">Coming Soon</p>
            </div>

            <div class="h-8 mt-2">
                <p class=" center text-center rounded-lg min-w-14 p-1 bg-badgeLightBlue text-sm text-badgeDarkBlue"><?php echo $prettier_date ?></p>
            </div>
        </div>
        
        <div id="register-button-<?php echo $lesson_data["lesson"] -> ID ?>" href="<?php echo get_permalink($lesson_data["lesson"]->ID) ?>">
            <div id="lesson-title" class="h-1/2">
                <h2 class="text-lg font-bold text-textNeutral">
                    <?php echo $lesson_data["lesson"]->post_title ?>
                </h2>
            </div>
        </div>

        <p class="text-base text-textNeutral"></p>
    </div>
    
</div>
