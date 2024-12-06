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

<?php 
    if ( is_product() ) {
        global $product;
        $product_id = get_the_ID();
        $product_tags = get_the_terms( $product_id, 'product_tag' );

        if ( $product_tags && ! is_wp_error( $product_tags ) ) {
            $tags_array = array();

            foreach ( $product_tags as $tag ) {
                $tags_array[] = $tag->name; // or use $tag->slug or $tag->term_id based on your requirement
            }

            // echo '<pre>';
            // echo print_r( $tags_array );
            // echo '</pre>';
            // Now $tags_array contains the names of the tags
            // You can var_dump() or print_r() to see its structure
        }
    }

?>

<div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
        
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="shop" class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>All Tickets</p>                
                </a>  
         
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        confirmation_number
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">
						<?php the_title() ?>
					</p>
                    <h1 class=" hidden text-base font-thin">18 Hours / 18 Courses / Bonified!</h1>
                </div>

                

            </div>

            <?php
                // wp_nav_menu( array( 
                //    'theme_location' => 'product-course-menu', 
                //    'container_class' => 'custom-menu-class' ) ); 
            ?>
        </div>

    </div>

</div>