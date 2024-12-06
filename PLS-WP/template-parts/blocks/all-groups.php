<?php 
    $show_badge = 0;
    $all_users = get_users();
    $all_client_groups = get_posts(array(
        'post_type' => 'subgroup',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));

?>


<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

<div id="content" class="w-screen h-full pt-0 p-2 bg-[#EFEFF1]">

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
                        All Groups and Agencies
                    </p>
                    <h1 class="text-base font-thin">232 users</h1>
                </div>
                <?php if($show_badge == 1) : ?>
                    <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                        <p class=" text-badgeDarkBlue">
                            <?php // echo $agency_type; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div id="headerTabGroup" class="w-full hidden bg-white inline-flex ">
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
            $nice_groups = [];
                foreach ($all_client_groups as $item) {
                    $nice_item = new stdClass; // Create a new standard class object
                    $nice_item->title = $item->post_title; // Access object property with arrow syntax
                    $nice_item->id = $item->ID; // Access object property with arrow syntax
                    $nice_item->slug = $item->post_name; // Access object property with arrow syntax
                    $all_client_groups_fields = get_fields($item->ID);
                    $nice_item->fields = $all_client_groups_fields;
                    // $nice_group_number = count($all_client_groups_fields['agency_members']);
                    // echo '<pre>';
                     // echo var_dump($all_client_groups_fields);
                     // $count = count($all_client_groups_fields['agency_members']);
                    // echo '</pre>';
                    $nice_groups[] = $nice_item; // If you uncomment this, it will collect your $nice_group objects
                }
                 echo '<pre>';
                 // echo var_dump($nice_groups);
                 echo '</pre>';
            ?>
        <div id="my-grid"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var jsObject = <?php echo json_encode($all_client_groups); ?>;
        var nice_groups = <?php echo json_encode($nice_groups); ?>;
        console.log(nice_groups);
        const dataArray = [];
        for (var i of nice_groups) {
            // alert(i)
            dataArray.push([
                gridjs.html(`<a href="/subgroup/${i.slug}">${i.title}</a>`),
                i.fields.location?.city ? i.fields.location.city : '', 
                i.fields.location?.state ? i.fields.location.state : '',
                '',
                i.fields.agency_type ? i.fields.agency_type : 'N/A', 
                "",
                i.fields.agency_members ? i.fields.agency_members.length : ''
            ]);
        }
        new gridjs.Grid({
            sort: true,
            search: true,
            pagination: true,
            columns: [
                {
                    name: "Group Name",
                    attributes: (cell) => {
                        if (cell) { 
                            return {
                                // onClick: () => {
                                //    alert('clicked');
                                //},
                                'style': 'cursor: pointer',
                            }
                        }
                    }
                },
                "City",
                "State",
                "PLS ID",
                "Type",
                "Status",
                "Members"
            ],
            data: dataArray, 
            
        }).render(document.getElementById("my-grid"));
    });
    </script>

    </div>
</div>


<?php wp_footer() ?>


