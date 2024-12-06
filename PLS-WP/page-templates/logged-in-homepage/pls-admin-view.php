<?php 

    // PLS Admin View - Logged In Homepage Template

    $current_user = wp_get_current_user();

?>

<div class="inline-flex w-full h-screen">
    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 bg-white h-full sticky top-0 ">
        <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
    </div>


    <div id="container" class="w-full bg-[#EFEFF1]">

    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        home
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">Hello <?php echo $current_user->display_name; ?></p>
                    <h1 class="text-base font-thin">Some Subheadline</h1>
                </div>
            </div>

            <script>

                $(document).ready(function() {
                    // ... your existing click event listener setup ...

                    // Optionally show a default tab on page load
                    $("#groupDetailsDiv").show();
                });
                
                $(document).ready(function() {
                    // Add click event listener to the buttons
                    $("#groupDetailsButton, #groupMembersButton, #groupMembersCourses, #groupSettingsButton").click(function() {
                        // Remove the class border-badgeDarkBlue from all buttons
                        // alert("clicked")
                        var buttonIds = [
                            "groupDetailsButton",
                            "groupMembersButton",
                            "groupMembersCourses",
                            "groupSettingsButton"
                        ];
                        var divId = $(this).attr("id");
                        $(this).removeClass("border-white");
                        $(this).addClass("border-badgeDarkBlue");

                        buttonIds.forEach(buttonId => {
                            if (buttonId != divId) {
                                $("#" + buttonId).removeClass("border-badgeDarkBlue");
                                $("#" + buttonId).addClass("border-white");
                                
                            }
                        });
                        
                        // Show the target div and hide the others
                        var targetDivId = $(this).attr("data-target");
                        $(".tab-content").hide();
                        $("#" + targetDivId).show();
                    });
                });
            </script>

            <div id="headerTabGroup" class="w-full bg-white inline-flex hidden">
                <button id="groupDetailsButton" class="inline-flex bg-white text-badgeDarkBlue font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeLightBlue" data-target="groupDetailsDiv">
                    <span class="material-symbols-outlined">
                        details
                    </span>
                    <p>Group Details</p>    
                </button>
                <button data-target="groupMembersDiv" id="groupMembersButton" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue " data-target="groupMembersDiv">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Members</p>    
                </button>    
                <button id="groupMembersCourses" class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue" data-target="groupMembersCoursesDiv">
                    <span class="material-symbols-outlined">
                        school
                    </span>
                    <p>Courses</p>    
                </button>
               
            </div>
        </div>
    </div>


        <div id="homepage-widgets" class="grid grid-cols-2 gap-4 p-6">
            <div id="widget2" class="w-full h-full bg-white border-borderGray border-[1px] p-2 rounded-lg">
                <h3 class="text-2xl font-bold">Recent Group Activity</h3>
                <p class="text-lg">You have 3 new members in your group</p>
                <p class="text-lg">You have 2 new support tickets</p>
                <p class="text-lg">You have 1 new certification request</p>
            </div>

            <div id="widget2" class="w-full h-full bg-white border-borderGray border-[1px] p-2 rounded-lg">
                <h3 class="text-2xl font-bold mb-2">Recent Orders</h3>
                <div class="grid grid-cols-4 gap-4 text-sm bg-borderGray bg-opacity-50 rounded-t-lg p-1">

                    <p>Order Number</p>
                    <p>Date</p>
                    <p>Price</p>
                    <p>Status</p>
                </div>
                <hr />
                <?php 
                    // Loop through the orders and display them
                    foreach ( $orders as $order ) {
                        ?>
                        <a href="/orders" class="grid grid-cols-4 gap-4 text-sm p-1 hover:bg-badgeLightBlue hover:text-badgeDarkBlue transition-all duration-200">
                            <p>Order #<?php echo $order->get_order_number(); ?> </p>
                            <p><?php echo $order->get_date_created()->date('F j, Y'); ?></p>
                            <p><?php echo $order->get_total(); ?></p>
                            <p><?php echo $order->get_status(); ?></p>
                    </a>
                        <?php
                        // Add any other order details you want to display
                    }
                ?>

            </div>
    </div>
</div>
