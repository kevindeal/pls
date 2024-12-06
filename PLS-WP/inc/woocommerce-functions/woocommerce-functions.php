<?php

// Add custom fields to product data tab
/*
add_action( 'woocommerce_product_options_pricing', 'add_bulk_pricing_fields' );
function add_bulk_pricing_fields() {
    // Fields for Tier 1
    woocommerce_wp_text_input( array(
        'id' => '_bulk_tier1_qty',
        'label' => __( 'Tier 1 Quantity', 'woocommerce' ),
        'description' => __( 'Minimum quantity for Tier 1', 'woocommerce' ),
        'desc_tip' => true,
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '1',
            'min' => '0'
        )
    ));
    woocommerce_wp_text_input( array(
        'id' => '_bulk_tier1_discount',
        'label' => __( 'Tier 1 Discount (%)', 'woocommerce' ),
        'description' => __( 'Discount percentage for Tier 1', 'woocommerce' ),
        'desc_tip' => true,
        'type' => 'number',
        'custom_attributes' => array(
            'step' => 'any',
            'min' => '0',
            'max' => '100'
        )
    ));
    // Repeat for additional tiers if needed
}
*/

/*
// Save custom field data
add_action( 'woocommerce_admin_process_product_object', 'save_bulk_pricing_fields' );
function save_bulk_pricing_fields( $product ) {
    // Save Tier 1 quantity
    if ( isset( $_POST['_bulk_tier1_qty'] ) ) {
        $product->update_meta_data( '_bulk_tier1_qty', sanitize_text_field( $_POST['_bulk_tier1_qty'] ) );
    }
    // Save Tier 1 discount
    if ( isset( $_POST['_bulk_tier1_discount'] ) ) {
        $product->update_meta_data( '_bulk_tier1_discount', sanitize_text_field( $_POST['_bulk_tier1_discount'] ) );
    }
    // Repeat for additional tiers if needed
}
*/

function add_coupon_to_cart() {
    if ( is_admin() ) {
        return;
    }

    $coupon_code_10 = 'BULK10'; // Coupon code for 10 or more items
    $coupon_code_20 = 'BULK20'; // Coupon code for 20 or more items

    // If the coupons were just removed, don't reapply them
    $removed_coupons = WC()->session->get('removed_coupons');
    if ( is_array($removed_coupons) && (in_array($coupon_code_10, $removed_coupons) || in_array($coupon_code_20, $removed_coupons)) ) {
        return;
    }
}

add_action( 'woocommerce_before_cart', 'add_coupon_to_cart' );

function bulk_discounts() {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $coupon_code_10 = 'BULK10'; // Coupon code for 10 or more items
    $coupon_code_20 = 'BULK20'; // Coupon code for 20 or more items

    // Check if WC cart is initialized
    if ( ! is_a( WC()->cart, 'WC_Cart' ) ) {
        return;
    }

    // If the coupons were just removed, don’t reapply them
    $removed_coupons = WC()->session->get('removed_coupons');
    if ( is_array($removed_coupons) && (in_array($coupon_code_10, $removed_coupons) || in_array($coupon_code_20, $removed_coupons)) ) {
        return;
    }

    // Calculate total quantity of items in the cart
    $total_quantity = 0;
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $total_quantity += $cart_item['quantity'];
    }

    // Apply or remove BULK10 coupon based on quantity
    if ( $total_quantity >= 10 && $total_quantity < 20 ) {
        if ( ! WC()->cart->has_discount( $coupon_code_10 ) ) {
            WC()->cart->add_discount( $coupon_code_10 );
        }
    } else {
        WC()->cart->remove_coupon( $coupon_code_10 );
    }

    // Apply or remove BULK20 coupon based on quantity
    if ( $total_quantity >= 20 ) {
        if ( ! WC()->cart->has_discount( $coupon_code_20 ) ) {
            WC()->cart->add_discount( $coupon_code_20 );
        }
    } else {
        WC()->cart->remove_coupon( $coupon_code_20 );
    }

    // Additional coupon logic for logged-in users
    if ( $total_quantity > 0 ) {
        $customer_id = get_current_user_id();
        if ( $customer_id ) {
            // Assuming 'agency_discount_coupon_code' is correctly retrieved
            $group_id = 256; // Ensure this is dynamically retrieved or relevant to the logic
            $client_coupon = get_field('agency_discount_coupon_code', $group_id); // Assuming ACF field linked to user

            if ( !empty($client_coupon) && !WC()->cart->has_discount( $client_coupon ) ) {
                WC()->cart->add_discount( $client_coupon );
            }
        }
    }
}
add_action( 'woocommerce_after_calculate_totals', 'bulk_discounts' );





// Adjust price based on bulk tiers
// add_action( 'woocommerce_before_calculate_totals', 'apply_bulk_discounts' );
// function apply_bulk_discounts( $cart ) {
//     if ( is_admin() && ! defined( 'DOING_AJAX' ) )
//         return;

//     foreach ( $cart->get_cart() as $cart_item ) {
//         $product = $cart_item['data'];
//         $quantity = $cart_item['quantity'];

//         // Retrieve tier 1 data
//         $tier1_qty = $product->get_meta( '_bulk_tier1_qty', true );
//         $tier1_discount = $product->get_meta( '_bulk_tier1_discount', true );

//         if ( $quantity >= $tier1_qty ) {
//             // Calculate new price using the discount and set
//             $discounted_price = $product->get_price() * (1 - ($tier1_discount / 100));
//             $product->set_price( $discounted_price );
//         }
//     }
// }



// Limit Payment Gateways Based on User Meta
require_once get_template_directory() . '/inc/woocommerce-functions/limit_payment_gateways.php';

// Remove Product Image Gallery from Product Page snippet
require_once get_template_directory() . '/inc/woocommerce-functions/remove_product_image_gallary.php';

// Add Custom Subscription Type to WooCommerce Products
// require_once get_template_directory() . '/inc/woocommerce-functions/subscription_product_type.php';

// Prevent Shop Access for various user roles
require_once get_template_directory() . '/inc/woocommerce-functions/prevent_shop_access.php';

require_once get_template_directory() . '/inc/woocommerce-functions/show-per-lesson.php';
require_once get_template_directory() . '/inc/woocommerce-functions/per-unit-price.php';
// Custom Product Tabs
// require_once get_template_directory() . '/inc/woocommerce-functions/custom-product-tabs.php';

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

// Add a Custom Field for Product Banners in Products
function add_product_banner_field() {
    add_meta_box(
        'product_banner_field',
        'Select Product Banner',
        'render_product_banner_field',
        'product',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_product_banner_field');

// Render Product Banner Dropdown Field
function render_product_banner_field($post) {
    $product_banner_id = get_post_meta($post->ID, '_product_banner_id', true);
    
    // Get all Product Banners
    $product_banners = get_posts(array(
        'post_type' => 'product_banner',
        'numberposts' => -1,
    ));

    echo '<label for="product_banner">Select Product Banner:</label>';
    echo '<select name="product_banner" id="product_banner">';
    echo '<option value="">Select</option>';

    foreach ($product_banners as $banner) {
        echo '<option value="' . esc_attr($banner->ID) . '" ' . selected($product_banner_id, $banner->ID, false) . '>';
        echo esc_html($banner->post_title);
        echo '</option>';
    }

    echo '</select>';
}

// Save Product Banner ID
function save_product_banner_id($post_id) {
    if (array_key_exists('product_banner', $_POST)) {
        update_post_meta($post_id, '_product_banner_id', sanitize_text_field($_POST['product_banner']));
    }
}
add_action('save_post', 'save_product_banner_id');

// Render Selected Product Banner
function render_selected_product_banner() {
    global $post;

    $product_banner_id = get_post_meta($post->ID, '_product_banner_id', true);

    if ($product_banner_id) {
        $product_banner = get_post($product_banner_id);

        // Retrieve all custom fields of the Product Banner
        $custom_fields = get_post_custom($product_banner->ID);

        // Variables for custom fields
        $banner_text = isset($custom_fields['product_banner']) ? $custom_fields['product_banner'][0] : '';
        $banner_color = isset($custom_fields['banner_color']) ? $custom_fields['banner_color'][0] : '';

        // Check if 'banner_icon' custom field exists
        if (isset($custom_fields['banner_icon'])) {
            // Retrieve the attachment ID from the custom field
            $attachment_id = $custom_fields['banner_icon'][0];

            // Get the URL of the attached image
            $banner_icon_url = wp_get_attachment_url($attachment_id);

            // Output the image if URL is available
            if ($banner_icon_url) {
                echo '<div class="product-banner items-center inline-flex max-w-content" style="background-color:' . esc_attr($banner_color) . ';">';
                echo '<img class="flag-icon rounded-xl h-10 w-10" src="' . esc_url($banner_icon_url) . '" alt="Banner Icon" />';
                echo '<span class="flag-text px-2 py-auto">' . esc_html($banner_text) . '</span>';
                echo '</div>';
            } else {
                echo '<p>No banner icon URL available</p>';
            }
        } else {
            // Handle case when 'banner_icon' is not set
            echo '<p>No banner icon available</p>';
        }
    }
}

// // Add the selected product banner to WooCommerce product templates
// function add_selected_product_banner_to_product() {
//     render_selected_product_banner();
// }
// add_action('woocommerce_before_single_product', 'add_selected_product_banner_to_product');
// Function to render the Store Notice
function render_store_notice() {
    // Check if the current page is 'shop'
    if (is_page('shop')) {
        // Get the current user ID
        $user_id = get_current_user_id();

        // Variables for custom fields
        $global_notice_text = ''; // Default value
        $global_notice_color = ''; // Default value
        $global_notice_icon = ''; // Default value

        // Check if the user has a specific notice assigned
        $user_assigned_notice = get_user_meta($user_id, 'user_notice', true);

        if ($user_assigned_notice) {
            // Use user-specific notice
            $global_notice_icon = $user_assigned_notice;
        } else {
            // Retrieve global notice information from the 'Store Notice' post type
            $args = array(
                'post_type' => 'store_notice',
                'posts_per_page' => 1, // Assuming you only want one global notice
            );

            $store_notice_query = new WP_Query($args);

            if ($store_notice_query->have_posts()) {
                while ($store_notice_query->have_posts()) {
                    $store_notice_query->the_post();

                    // Get custom field values for the global notice
                    $global_notice_text = get_post_meta(get_the_ID(), 'store_notice', true);
                    $global_notice_color = get_post_meta(get_the_ID(), 'notice_color', true);
                    $global_notice_icon_id = get_post_meta(get_the_ID(), 'icon_picker', true);

                    // Get the URL of the attached image
                    $global_notice_icon = wp_get_attachment_url($global_notice_icon_id);
                }
                wp_reset_postdata();
            }
        }

        // Output the store notice
        if (!empty($global_notice_text)) {
            echo '<div class="store-notice shop-global-banner items-center justify-center inline-flex w-full" style="background-color:' . esc_attr($global_notice_color) . ';">';
            echo '<img class="store-notice-icon rounded-xl h-10 w-10" src="' . esc_url($global_notice_icon) . '" alt="Notice Icon" />';
            echo '<span class="store-notice-text">' . esc_html($global_notice_text) . '</span>';
            echo '</div>';
        }
    }
}

// Call the function to render the Store Notice
render_store_notice();

// Seat Fee Function
require_once get_template_directory() . '/inc/woocommerce-functions/seat_fee_function.php';