<?php ?>

<script type="text/javascript">
        // Tab change functions

        function tabChange(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks, activeTabClasses, inActiveTabClasses;

            function handleTabButtonClasses () {
                activeTabClasses = "active tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue ";
                inActiveTabClasses = "inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue ";

                // alert(evt.currentTarget.className)
                // Get all other tabLink elements and make them inactive
                tablinks = document.getElementsByClassName("tabLinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = inActiveTabClasses;
                }
                
                // Finally, give the clicked tabLink the active classes
                evt.currentTarget.className = activeTabClasses;
                // alert(evt.currentTarget.className)
            }

            function handleTabContentClasses (cityName) {
                activeTabClasses = "tabContent w-full";
                inActiveTabClasses = "tabContent hidden w-full ";

                // alert(evt.currentTarget.className)
                // Get all tabContentContainer elements and make them all inactive
                tabContentContainers = document.getElementsByClassName("tabContent");
                for (i = 0; i < tabContentContainers.length; i++) {
                    tabContentContainers[i].className = inActiveTabClasses;
                }
                
                // Finally, give the right tabContentContainer the active classes
                document.getElementById(cityName).className = activeTabClasses;
                // evt.currentTarget.className = activeTabClasses;
                // alert(evt.currentTarget.className)
            }

            handleTabButtonClasses();
            handleTabContentClasses(cityName);


            } 
    </script>

<div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
        
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="student-dashboard" class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Exit And Pause Lesson</p>                
                </a>  
            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        school
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">
						<?php the_title() ?>
					</p>
                    <h1 class="text-base font-thin">18 Hours / 18 Courses / Bonified!</h1>
                </div>


            </div>

            <?php
    wp_nav_menu( array( 
        'theme_location' => 'product-course-menu', 
        'container_class' => 'custom-menu-class' ) ); 
    ?>
        </div>

    </div>

</div>
