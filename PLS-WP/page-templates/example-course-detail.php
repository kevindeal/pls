<?php
/**
 * Template Name: Course Detail Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>
<?php get_header(); ?>

<section class="flex h-screen bg-bgGray">
  <div class="nav-container">
    <nav style="background-color: rgb(37,37,40);" class="p-4 h-full h-100">
      <ul class="py-1">
        <li class="py-1">      
          <button class="inline-flex items-center  bg-black px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">home</span>
            Home
          </button>
        </li>
        
        <hr class="h-1 bg-dividerGray"></hr>
        
        <li class="py-1">      
        <button class="inline-flex items-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">local_police</span>
            Agencies
          </button>
        </li>
      
        <li class="py-1">      
        <button class="inline-flex items-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
          <span class="material-symbols-outlined px-2">group</span>         
          People
        </button>
        </li>

        <hr class="h-1 bg-dividerGray"></hr>
          
        <li class="py-1">      
          <button class="inline-flex items-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">school</span>
            Courses
          </button>
        </li>
          
        <li class="py-1">      
          <button class="inline-flex inline-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">assignment</span>
            Lessons
          </button>
        </li>
              
        <li class="py-1">      
          <button class="inline-flex inline-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">description</span>
              Reports
          </button>
        </li>

        <hr class="h-1 bg-dividerGray"></hr>
              
        <li class="py-1">      
          <button class="inline-flex inline-center px-4 py-4 rounded w-80 text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">chat</span>  
            Messages / Tickets
          </button>
        </li>

      </ul>
    </nav>
  </div>
  <div class="content-grid">
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
    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
      <div class="w-full h-1/4 bg-white border-borderGray border rounded-xl py-3 px-4">
          <div class="w-full grid grid-cols-2 space-y-2">
              <div id="gridbox-element" class="w-1/2">
                  <h2 class="text-base" >Label Text</h2>
                  <p class="text-xl">Item Text</p>
              </div>
              <div id="gridbox-element" class="w-1/2">
                  <h2 class="text-base" >Label Text</h2>
                  <p class="text-xl">Item Text</p>
              </div>
              <div id="gridbox-element" class="w-1/2">
                  <h2 class="text-base" >Label Text</h2>
                  <p class="text-xl">Item Text</p>
              </div>
              <div id="gridbox-element" class="w-1/2">
                  <h2 class="text-base" >Label Text</h2>
                  <p class="text-xl">Item Text</p>
              </div>
          </div>
      </div>
    </div>
  </div>
</section>