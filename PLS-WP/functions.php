<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `inc/Custom/Custom.php` to write your custom functions
 *
 * @package swps
 */


if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

add_filter( 'learn-press/override-templates', function(){ return true; } );


if ( class_exists( 'swps\\Init' ) ) :
	swps\Init::register_services();
endif;


@ini_set( 'upload_max_size' , '256M' );
@ini_set( 'post_max_size', '256M');
@ini_set( 'max_execution_time', '300' );

// Custom Gutenberg blocks
require get_template_directory() . '/inc/acf-blocks.php';



// add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_action_function'); // If you want it accessible for non-logged-in users



function mytheme_enqueue_styles() {
    // Enqueue the external stylesheet
    wp_enqueue_style('parent-style', get_stylesheet_uri());
    wp_enqueue_style( 'my-custom-style', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0' );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_styles' );


add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
    function enqueue_parent_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    }


function my_theme_enqueue_scripts() {
    // Replace 'your-cdn-url' with the actual CDN URL for Grid.js
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    wp_register_script('grid-js', 'https://unpkg.com/gridjs/dist/gridjs.umd.js', array(), null, true);
    wp_enqueue_script('grid-js');
    wp_enqueue_script('gridjs-selction', 'https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js', array(), null, true);
    wp_enqueue_script('gridjs-selction');

}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');


// wp_register_script( 'external-script', 'https://cdn.example.com/path/to/external-script.js', array('jquery'), '1.0', true );
// wp_enqueue_script( 'external-script' );
function my_custom_theme_setup() {
    register_nav_menus( array(
        'homepage-quick-links' => 'Homepage Quick Links',
        'homepage-menu' => 'Homepage Menu',
        'product-course-menu' => 'Product Course Menu',
    ) );
}
add_action( 'after_setup_theme', 'my_custom_theme_setup' );

function redirect_user_on_login($user_login, $user) {
    // Check if the user has a specific role
    if (in_array('client_group_admin', (array) $user->roles)) {
        // Redirect to specific page
        
        // Get the user's custom homepage URL from ACF field
        $custom_homepage_url = get_field('homepage_url', 'user_' . $user->ID);

        wp_redirect($custom_homepage_url); // Redirect to the custom URL
        
        // wp_redirect(home_url('/groups/'));
        exit;
    } else if (in_array('subscriber', (array) $user->roles)) {
        // Redirect to specific page
        wp_redirect(home_url('/student-dashboard/'));
        exit;
    }
//
    // For any other role, no redirection (or you can set a different redirection)
}
add_action('wp_login', 'redirect_user_on_login', 10, 2);

// Register Custom Post Type for Store Notices
function register_store_notices_post_type() {
    $labels = array(
        'name'               => _x('Store Notices', 'post type general name'),
        'singular_name'      => _x('Store Notice', 'post type singular name'),
        'menu_name'          => _x('Store Notices', 'admin menu'),
        'add_new'            => _x('Add New', 'store notice'),
        'add_new_item'       => __('Add New Store Notice'),
        'edit_item'          => __('Edit Store Notice'),
        'new_item'           => __('New Store Notice'),
        'view_item'          => __('View Store Notice'),
        'search_items'       => __('Search Store Notices'),
        'not_found'          => __('No store notices found'),
        'not_found_in_trash' => __('No store notices found in Trash'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'supports'           => array('title', 'custom-fields'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'store-notices'),
    );

    register_post_type('store_notice', $args);
}
add_action('init', 'register_store_notices_post_type');

// Register Custom Post Type for Product Banners
function register_product_banners_post_type() {
    $labels = array(
        'name'               => _x('Product Banners', 'post type general name'),
        'singular_name'      => _x('Product Banner', 'post type singular name'),
        'menu_name'          => _x('Product Banners', 'admin menu'),
        'add_new'            => _x('Add New', 'product banner'),
        'add_new_item'       => __('Add New Product Banner'),
        'edit_item'          => __('Edit Product Banner'),
        'new_item'           => __('New Product Banner'),
        'view_item'          => __('View Product Banner'),
        'search_items'       => __('Search Product Banners'),
        'not_found'          => __('No product banners found'),
        'not_found_in_trash' => __('No product banners found in Trash'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'supports'           => array('title', 'custom-fields'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'product-banners'),
    );

    register_post_type('product_banner', $args);
}
add_action('init', 'register_product_banners_post_type');




function create_subscription_post_on_sale($order_id) {
    $order = wc_get_order($order_id);

    // Check if the order contains a subscription product (this depends on your setup)
    // This is a basic example; you might need a more complex check based on your requirements
    foreach ($order->get_items() as $item_id => $item) {
        
        $product = $item->get_product();
        $product_id = $item->get_product_id();
        $associated_courses = get_field('acf_product_course', $product_id);

        $user_id = $order->get_user_id(); // Will return false if guest checkout
        $user = $order->get_user(); // Will return false if guest checkout

            // Create a new subscription post
            $post_id = wp_insert_post(array(
                'post_title'    => 'Subscription for Order #' . $order_id,
                'post_content'  => 'Details about the subscription.',
                'post_status'   => 'publish',
                'post_type'     => 'acf-subscription',
                // Add other post data as needed
            ));

            // You can add custom fields or meta to the post as well
            // update_post_meta($post_id, 'course', $associated_courses);
            $userMeta = get_user_meta($user_id);
            update_field('anytext',$order, $post_id);
            update_field('client_group',$userMeta['clent_group_memberships'][0], $post_id);
            $current_date = date('Ymd'); // Formats the current date as YYYYMMDD
            update_field('subscription_created', $current_date, $post_id);

            if ($associated_courses) {
                update_field('course', $associated_courses->ID, $post_id);
                update_field('can_enroll', true, $post_id);                
            }
    }
}
add_action('woocommerce_order_status_completed', 'create_subscription_post_on_sale');



/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

add_filter('acf/fields/post_object/query', 'my_acf_fields_post_object_query', 10, 3);
function my_acf_fields_post_object_query($args, $field, $post_id) {
    // Check if the field is 'agency_groups'
    if ($field['_name'] == 'agency_group') {
        // Show 40 posts per AJAX call.
        $args['posts_per_page'] = 40;

        // Restrict results to children of a specific post.
        // Adjust the post_parent according to your logic
        $parent_post_id = $post_id; // post ID or dynamically determine it
        $args['post_parent'] = $parent_post_id;
    }

    return $args;
}


add_action('save_post', 'update_user_subgroups_acf_field');
function update_user_subgroups_acf_field($post_id) {
    // Check if it's a 'subgroup' post type
    if (get_post_type($post_id) !== 'subgroup') {
        return;
    }

    // Get users assigned to this subgroup
    $subgroup_members = get_field('subgroup_members', $post_id);

    if (!empty($subgroup_members)) {
        foreach ($subgroup_members as $user_id) {
            // Get current subgroups from the user's ACF field
            $current_subgroups = get_field('users_agency_groups', 'user_' . $user_id) ?: [];

            // Check if the current subgroup is not already in the user's subgroups
            if (!in_array($post_id, array_column($current_subgroups, 'ID'))) {
                // Add the new subgroup to the user's subgroups
                $current_subgroups[] = array('ID' => $post_id);
                update_field('users_agency_groups', $current_subgroups, 'user_' . $user_id);
            }
        }
    }
}


add_filter('acf/fields/user/query', 'my_acf_fields_user_query', 10, 3);
function my_acf_fields_user_query($args, $field, $post_id) {
    // Check if the field is 'thing'
    if ($field['_name'] == 'subgroup_members') {
        // Get the current post's parent
        $parent_post_id = wp_get_post_parent_id($post_id);

        if ($parent_post_id) {
            // Get the 'agency_members' field from the parent post
            $agency_members = get_field('agency_members', $parent_post_id);

            if (!empty($agency_members)) {
                // Convert the array of user objects to an array of user IDs
                $member_ids = array_map(function ($member) {
                    return $member['ID'];
                }, $agency_members);

                // Modify the user query to only include these IDs
                $args['include'] = $member_ids;
            }
        }
    }

    return $args;
}


function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __( 'Header Menu' ),
        'sidebar-menu' => __( 'Sidebar Menu' )
      )
    );
  }
  add_action( 'init', 'register_my_menus' );

  /* Rest API */
  add_action('rest_api_init', function () {
    register_rest_route('myplugin/v1', '/add-user-to-group/', array(
        'methods' => 'POST',
        'callback' => 'my_add_user_to_group_function',

    ));
    register_rest_route('myplugin/v1', '/create-enrollments/', array(
        'methods' => 'POST',
        'callback' => 'create_enrollments',
        'permission_callback' => function () {
            return current_user_can('edit_posts'); // Adjust the capability as needed
        }
    ));
});

function my_add_user_to_group_function($request) {
    $parameters = $request->get_json_params();
    $user_id = $parameters['user_id'];
    $subgroup_id = $parameters['subgroup_id'];

    $current_members = get_field('subgroup_members', $subgroup_id, false);

    try {

        // Initialize as array if it's not set
        if (!is_array($current_members)) {
            $current_members = array();
        }

        // Append the new user ID if not already in the array
        if (!in_array($user_id, $current_members)) {
            $current_members[] = $user_id;
            // Update the field with the new array
            $result = update_field('subgroup_members', $current_members, $subgroup_id);
                
            if (false === $result) {
                // Handle the error if update_field returns false
                return new WP_Error('update_error', 'Error updating field', array('status' => 400));
            } else {
                // If successful
                return new WP_REST_Response('User added successfully', 200);
            }
        } else {
            // If the user is already in the array
            return new WP_Error('user_exists', 'User already exists in this group', array('status' => 400));
        }
    
    } catch (Exception $e) {
        // Handle any exceptions
        return new WP_Error('exception', 'Caught exception: ' . $e->getMessage(), array('status' => 500));
    }
    

}

  function get_group_info($group_id) {
    // Ensure $group_id is an integer and a valid post ID
    $group_id = intval($group_id);

    if (!$group_id || get_post_type($group_id) !== 'subgroup') {
        return false; // Invalid ID or not a 'subgroup' post
    }

    // Get standard post data
    $group_info = get_post($group_id, ARRAY_A);
    if (!$group_info) {
        return false; // Post not found
    }

    // Get standard post meta
    $group_meta = get_post_meta($group_id);
    $group_info['meta'] = $group_meta;

    // Get ACF fields (if ACF is installed and active)
    if (function_exists('get_fields')) {
        $group_acf_fields = get_fields($group_id);
        $group_info['acf'] = $group_acf_fields;
        $subgroups = array();

        foreach ($group_acf_fields['agency_group'] as $child_group) {
            $fields = get_fields($child_group->ID);
            
            $subgroups[] = array(
                'post' => $child_group,
                'acf_fields' => $fields,
            );
        }

        $group_info['subgroups'] = $subgroups;
    }

    return $group_info;
}



// Add a filter to modify the GUID for new posts
add_filter('wp_insert_post_data', 'generate_uuid_guid', 10, 2);

function generate_uuid_guid($data, $postarr) {
    // Check if it's a new post
    if ($data['post_status'] === 'auto-draft') {
        // Generate a UUID
        $uuid = wp_generate_uuid4();
        // Set the GUID to the generated UUID
        $data['guid'] = $uuid;
    }
    return $data;
}


require_once get_template_directory() . '/inc/support-tickets/main.php';


require_once get_template_directory() . '/inc/lesson-packages/main.php';


require_once get_template_directory() . '/inc/Course-helpers/main.php';

require_once get_template_directory() . '/inc/support-tickets/main.php';
require_once get_template_directory() . '/inc/woocommerce-functions/woocommerce-functions.php';

// LMS Functions, hooks, and filters
require_once get_template_directory() . '/inc/LMS/main.php';

// Admin Functions, hooks, and filters
require_once get_template_directory() . '/inc/admin/main.php';

// Rustici Webhook
require_once get_template_directory() . '/inc/webhook/webhook.php';


require_once get_template_directory() . '/inc/AJAX-functions/main.php';

function custom_login_redirect( $redirect_to, $request, $user ) {
    // Check if the user data is available
    if ( isset($user->ID) ) {
        // Get the user's custom homepage URL from ACF field
        $custom_homepage_url = get_field('homepage_url', 'user_' . $user->ID);

        // Check if the URL field is not empty and is a valid URL
        if ( !empty($custom_homepage_url) && filter_var($custom_homepage_url, FILTER_VALIDATE_URL) ) {
            return $custom_homepage_url; // Redirect to the custom URL
        }
    }

    // If no custom URL, or if there is an error, redirect to the default location
    return $redirect_to;
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );


function add_custom_table_under_add_to_cart() {
    ?>
    <br />

    <div id="gridjs-wrapper"></div>

    <script src="https://cdn.jsdelivr.net/npm/gridjs@1.2.0/dist/gridjs.production.min.js"></script>
    <script>
        const grid = new gridjs.Grid({
            columns: ['Seats', 'Discount'],
            data: [
                ['Any', 'Your Agency Discount'],
                ['10 - 19', 'Agency + 10% off'],
                ['20 - 29', 'Agency + 20% off'],
                // Add more rows as needed
            ]
        }).render(document.getElementById('gridjs-wrapper'));
    </script>
<?php
}
add_action('woocommerce_after_add_to_cart_button', 'add_custom_table_under_add_to_cart');


function register_shop_woocommerce_sidebar() {
    register_sidebar(array(
        'id' => 'shop',
        'name' => __( 'Shop', 'textdomain' ),
        'description' => __( 'Widgets in this area will appear on WooCommerce pages.', 'textdomain' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action( 'widgets_init', 'register_shop_woocommerce_sidebar' );

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

function custom_redirect_logic() {
    if (!is_user_logged_in() && is_page('logged-in-user-homepage')) {
        // No output before this
        wp_redirect(home_url('/wp-login.php'));
        exit;
    }
}
add_action('template_redirect', 'custom_redirect_logic');

