<?php 

function add_custom_content_under_product_description() {
    // Check if we’re on a single product page
    if (is_product()) {
        // Include your custom template part
        global $product; // Get the global product object
        // Get the product ID
        $product_id = $product->get_id();
        // Pass the product ID to your template part
        set_query_var('product_id', $product_id);
        get_template_part('template-parts/woocommerce/description-attribute-table');
        //echo '<p>Some random p block here for testing</p>';
    }
}
add_action('woocommerce_after_single_product_summary', 'add_custom_content_under_product_description', 15);
