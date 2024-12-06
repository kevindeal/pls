<?php  
function get_subgroup_data() {
    $args = array(
        'post_type'      => 'subgroup', // Replace 'subgroup' with your actual custom post type key
        'posts_per_page' => -1, // -1 will fetch all posts
        'post_status'    => 'publish', // Only get published posts
        'tax_query'      => array( // Start tax_query array
            array(
                'taxonomy' => 'client-group-type', // Replace 'agency' with your actual taxonomy key
                'field'    => 'slug', // 'slug' or 'term_id', if you want to use term ID instead
                'terms'    => 'agency', // Replace 'your-term-slug' with the actual slug of the term
                'include_children' => false,
            ),
        ),
    );

    $subgroups_query = new WP_Query($args);
    $subgroups_data = array();

    if ($subgroups_query->have_posts()) {
        while ($subgroups_query->have_posts()) {
            $subgroups_query->the_post();
            $post_id = get_the_ID(); // Get the current post ID

            // Collect data in an array
            $subgroups_data[] = array(
                'title' => get_the_title(),
                'status' => get_field('status', $post_id),
                'agency_type' => get_field('agency_type', $post_id),
                'location' => get_field('location', $post_id),
                'pls_id' => get_field('pls_id', $post_id),
                // Add other fields as needed
            );
        }
        wp_reset_postdata(); // Always reset postdata after a custom query
    }

    return $subgroups_data;
}

// Use this function in your template file to get the data and make it available there.
$subgroups = get_subgroup_data();
wp_nav_menu( array( 'theme_location' => 'sidebar-menu', 'container_class' => 'my_sidebar_menu_class' ) );
?>

<div id="theTable">

    <section class="container px-4 mx-auto p-2">

        <div class="flex mb-4 bg-white py-2">
            <div class="w-full bg-gray-400 h-12">
                <p>Client Group Type</p>
                <h2 class="text-2xl font-bold">Client Group Type</h2>
            </div>
        </div>

        <div class="flex mb-4 bg-white">
            <div class="w-1/2 bg-gray-400 h-12">
                <p>Client Group Type</p>
                <h2 class="text-2xl font-bold">Client Group Type</h2>
            </div>
            <div class="w-1/2 bg-gray-500 h-12">
                <p>Client Group Type</p>
                <h2 class="text-2xl font-bold">Client Group Type</h2>
            </div>
        </div>

    </section>
</div>