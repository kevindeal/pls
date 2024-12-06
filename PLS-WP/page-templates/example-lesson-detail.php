<?php
/**
 * Template Name: Lesson Detail Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>

<?php get_header(); ?>

<section class="lesson-container">
  <header class="lesson-title">
    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0 mb-4">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>All Agencies</p>                
                </button>  
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p>Action</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-TextGroup">
                    <h1 class="text-3xl font-bold text-black"><?php the_title(); ?></h1>
                    <h2 class="text-base font-thin">Some Subheadline</h2>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        Badge
                    </p>
                </div>
            </div>

            <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>    
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>            
            </div>
        </div>
      </div>
  </header>
</section>