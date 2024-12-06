<?php ?>

<?php 
        wp_nav_menu( array( 
            'theme_location' => 'homepage-quick-links', 
            'container_class' => 'custom-menu-class' ) ); 
    ?>
<div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">

    
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="hidden w-full flex justify-between items-center">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Homepage</p>                
                </button>  
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p>Action</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4 p-4">
                <div class=" w-full m-auto items-center place-content-center">
                    <img src="/wp-content/uploads/2023/11/Screenshot-2023-11-17-at-12.18.08-PM.png" class=" m-auto h-20 " />
                </div>



            </div>

        </div>

    </div>

</div>

<?php 
    wp_nav_menu( array( 
            'theme_location' => 'homepage-menu', 
            'container_class' => 'custom-menu-class' ) ); 
    ?>
