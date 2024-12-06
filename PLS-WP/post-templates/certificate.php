<?php 
    $post_id = $post -> ID;
    $fields = get_fields($post_id);
    $featured_image = get_the_post_thumbnail_url($post_id);

    $enrollment = get_field('enrollment', $post_id);
    $course = get_field('course', $enrollment -> ID);
    $course_id = $course -> ID;
    $course_title = $course -> post_title;
?>

<div class="inline-flex w-full">
    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 h-screen sticky top-0 ">
        <?php get_template_part('template-parts/blocks/group-admin-nav-bar'); ?>
    </div>

<div id="content" class="w-4/5 h-full bg-[#EFEFF1] justify-center" >

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="/groups">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Your Certificates</p>                
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
                        Certificate <?php echo $fields['certificate_id'] ?>
                    </p>
                    <h1 class="text-base font-thin">Created: <?php echo $fields['awarded_date']; ?> </h1>
                </div>
                
            </div>

            <div id="headerTabGroup" class="w-full bg-white inline-flex ">
            <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>Details</p>    
                </button>
            </div>
        </div>

    </div>

    <div class="w-full p-6">

        <div class="grid grid-cols-2 gap-4 bg-white rounded-lg border-[1px] border-borderGray p-4">
            <div class="w-full ">

                <div class="w-full inline-flex gap-2 mb-2">
                    <p class="font-semibold">Enrollment ID: </p><p> <?php echo $fields['enrollment'] -> ID ?></p>
                </div>
                <div class="w-full inline-flex gap-2 mb-2">
                    <p class="font-semibold">Course: </p><p> <?php echo $course_title ?></p>
                </div>
                <div class="w-full inline-flex gap-2 mb-2">
                    <p class="font-semibold">Upon Completion Of Lesson: </p><p> <?php echo $fields['enrollment'] -> ID ?></p>
                </div>

            </div>
            <div class="w-full">
                <img src="<?php echo $featured_image ?>" class="w-full h-full"/>

            </div>
    </div>
</div>
