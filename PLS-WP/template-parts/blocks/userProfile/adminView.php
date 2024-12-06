<?php ?>

<?php
    $title = 'User Name';
    $member_count = '1';
    $agency_type = 'Agency Type';

    $user_id = 9;
    $user = get_user_by('id', $user_id);
    $user_meta = get_user_meta($user_id);
    $user_fields = get_fields('user_' . $user_id);


?>

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

<div id="content" class="w-screen h-full pt-0 p-2 bg-[#EFEFF1]">

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="/people">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>All People</p>                
                </button> 
                </a> 
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p>Action</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeLightBlue rounded-xl p-2" style="font-size: 48px">
                        person
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">
                        <?php echo $title; ?>
                    </p>
                    <h1 class="text-base font-thin"><?php echo $member_count; ?> users</h1>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        <?php echo $agency_type; ?>
                    </p>
                </div>
            </div>

            <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>Details</p>    
                </button>   
                <button onClick="tabChange(event, 'lessons-container')" id="lessonsButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Courses + Lessons</p>    
                </button>
                <button onClick="tabChange(event, 'usergroups-container')" id="usergroupButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Agencies</p>    
                </button> 
                
                <button onClick="tabChange(event, 'certificates-container')" class="inactive inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <p>Certificates</p>    
                </button>             
            </div>
        </div>

    </div>

    <div id="content-container" class="w-full h-full p-4">

    <?php
    echo '<pre>';
    // echo var_dump($user_fields);
    echo '</pre>';
    ?>
        <div id="details-container" class="w-full tabContent">
            <?php 
                get_template_part('template-parts/blocks/userProfile/adminView/detailsContainer', 
                    null,
                    array( 
                        'user_id' => $user_id,
                        'user_meta' => $user_meta,
                        'user_fields' => $user_fields
                    )
                );
            ?>
        </div>

        <div id="lessons-container" class="w-full tabContent hidden">
            <?php get_template_part('template-parts/blocks/userProfile/adminView/lessonsContainer', 
                    null,
                    array( 
                        'user_id' => $user_id,
                        'user_meta' => $user_meta,
                        'user_fields' => $user_fields
                    )
                ); 
            ?>
        </div>

        <div id="usergroups-container" class="w-full tabContent hidden">
            <?php get_template_part('template-parts/blocks/userProfile/adminView/usergroupsContainer', 
                    null,
                    array( 
                        'user_id' => $user_id,
                        'user_meta' => $user_meta,
                        'user_fields' => $user_fields
                    )
                ); 
            ?>
        </div>

        <div id="certificates-container" class="w-full tabContent hidden">
            <?php get_template_part('template-parts/blocks/userProfile/adminView/certificatesContainer', 
                    null,
                    array( 
                        'user_id' => $user_id,
                        'user_meta' => $user_meta,
                        'user_fields' => $user_fields
                    )
                );
            ?>
        </div>

    </div>
</div>