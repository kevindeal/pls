<?php 
    $all_users = get_users();
?>
<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

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
<div id="main-container" class="flex w-screen h-full bg-[#EFEFF1]">

    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/10 bg-white h-full ">
        <?php get_template_part('template-parts/blocks/group-admin-nav-bar'); ?>
    </div>

    <!-- Main Content -->
    <div id="content" class="w-4/5 h-full pt-0 bg-[#EFEFF1]">
        <div id="content" class="w-full h-full pt-0 bg-[#EFEFF1]">

            <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
    
                <div id="exampleHeader-content" class="w-full space-y-4">
                    <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                        <a href="/people">
                        <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                            <span class="material-symbols-outlined">
                                arrow_back
                            </span>
                    <p>Admin Dashboard</p>                
            </button> 
            </a> 
            <button class="hidden bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
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
                    All People
                </p>
                <h1 class="text-base font-thin">232 users</h1>
            </div>
            <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                <p class=" text-badgeDarkBlue">
                    <?php // echo $agency_type; ?>
                </p>
            </div>
        </div>
    </div>

</div>

<div id="content-container" class="w-full h-full p-4">
    table
    <?php 
        $nice_people = [];
        foreach ($all_users as $user) {
            $nice_person = new stdClass; // Create a new standard class object
            // $nice_person->first_name = $user->first_name; // Access object property with arrow syntax
            // $nice_person->last_name = $user->last_name; // Access object property with arrow syntax
            $nice_person->id = $user->ID; // Access object property with arrow syntax
            $nice_person->user_meta = get_user_meta($user->ID);
            $nice_person->fields = get_fields('user_' . $user->ID);
            $nice_people[] = $nice_person; // If you uncomment this, it will collect your $nice_group objects
        }
        ?>
        
    <div id="my-grid"></div>

            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const users = <?php echo json_encode($nice_people); ?>;

        console.log(users);
        const dataArray = [];
        for (var i of users) {
            dataArray.push([
                i.user_meta?.first_name, 
                i.user_meta?.last_name, 
                i.fields && i.fields.users_agency_groups ? i.fields?.users_agency_groups[0]?.post_title : "",
                "", // i.fields.agencies, 
            ]);
        }
        
        new gridjs.Grid({
            sort: true,
            search: true,
            pagination: true,
            columns: [
                "First Name",
                "Last Name",
                "Agencies",
                "Status"
            ],
            data: dataArray, 
        }).render(document.getElementById("my-grid"));
    });
</script>


<?php wp_footer() ?>
