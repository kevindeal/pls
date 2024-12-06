<?php ?>
<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

<div class="w-full flex-1 h-full justify-center p-4 space-y-4">
    <div class="w-full justify-between gap-4 rounded-lg inline-flex bg-white p-2">
        <div class="inline-flex">
            <p class="font-bold">Total Users: </p>
            <?php
                $usercount = count_users();
                $result = $usercount['total_users'];
                echo " $result";
            ?>
        </div>
        <div class="inline-flex">
            <p class="font-bold">Users Awaiting Approval: N/A</p>
        </div>
        <div class="inline-flex">
            <p class="font-bold">Total Agencies: </p>
            <?php
                $args = array(
                    'post_type' => 'subgroup',
                    'posts_per_page' => -1,
                );
                $query = new WP_Query($args);
                $result = $query->found_posts;
                echo " $result";
            ?>
        </div>

        <div class="inline-flex">
            <p class="font-bold">Total Courses: </p>
            <?php
                $args = array(
                    'post_type' => 'acf-course',
                    'posts_per_page' => -1,
                );
                $query = new WP_Query($args);
                $result = $query->found_posts;
                echo " $result";
            ?>
            </div>
    </div>

    <div class="w-full flex justify-between items-center gap-2 h-1/3">

        <div class="w-1/2 rounded-lg bg-white p-2">
            <p class="font-bold">Recent Purchases</p>
            <hr />
            <?php
                $args = array(
                    'post_type' => 'shop_order',
                    'post_status' => 'wc-processing', // or use 'any' to include orders with all statuses
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                $latest_orders_query = new WP_Query($args);
                // echo '<p>Latest Orders</p>';
                // echo var_dump($latest_orders_query);
                
                if ($latest_orders_query) {
                    echo '<p>Latest Orders</p>';
                    while ($latest_orders_query->have_posts()) {
                        $latest_orders_query->the_post();
                
                        $order_id = get_the_ID();
                        $order = wc_get_order($order_id);
                        echo '<p>' . $order->get_total() . '</p>';
                        // Now you can use $order to access order details
                        // For example: $order->get_total();
                    }
                
                wp_reset_postdata();
                } else {
                    echo 'No recent purchases found.';
                }
            ?>
        </div>
        <div class="w-1/2 rounded-lg bg-white p-2">
            <p class="font-bold">Support Tickets</p>
            
            <hr />
            <?php
                    $args = array(
                        'post_type' => 'support-ticket',
                        'posts_per_page' => 5,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            echo '<p>' . get_the_title() . '</p>';
                        }
                        wp_reset_postdata();
                    } else {
                        echo 'No support tickets found.';
                    }
                ?>
        </div>
    </div>