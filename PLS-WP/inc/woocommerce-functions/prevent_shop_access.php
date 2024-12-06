<?php 
function restrict_shop_page_access() {
    if ( is_shop() || is_product_category() || is_account_page() || is_cart() || is_checkout() || is_checkout_pay_page() || is_product() || is_product_category()) {

        $user = wp_get_current_user();
        $allowed_roles = array('client_group_admin', 'lms_admin', 'admin'); // Replace with your specific roles or logic
        
        $user_can_see_shop = get_field('can_view_store', 'user_' . $user->ID);

        if ($user_can_see_shop || array_intersect($allowed_roles, $user->roles )) {
            // The user has an allowed bit, do nothing and enjoy a cup of coffee
        } else {
            // User doesn't have an allowed role, redirect them, no coffee for them
            wp_redirect(home_url()); // Redirect to home page or any other page
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_shop_page_access');