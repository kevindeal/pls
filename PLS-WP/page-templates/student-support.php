<?php 
    /*
    * Template Name: Student Support Page
    */
    get_header();
    wp_head();
?>

<div id="main-container" class="inline-flex w-full h-screen bg-[#EFEFF1]">

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
                            support_agent
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            Student Support
                        </p>
                    </div>

                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                        <span class="material-symbols-outlined">
                            pending
                        </span>
                        <p>Create New Support Ticket</p>    
                    </button>
                    <button onClick="tabChange(event, '')" id="peopleButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            format_align_justify
                        </span>
                        <p>FAQs and Knowledge Base</p>    
                    </button>    
     
                </div>
            </div>

        </div>
    
        <div id="content-container" class="w-full p-6">
            <?php 
                get_template_part('post-templates/client-group-profile/adminView/messagesContainer');
            ?>
        </div>
    </div>
</div>
<?php wp_footer(); ?>