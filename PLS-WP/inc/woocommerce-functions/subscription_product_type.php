<?php 

class WC_Product_Subscription extends WC_Product {
    protected $product_type = 'subscription_product';

    public function __construct( $product ) {
        $this->product_type = 'subscription_product';
        $this->supports[] = 'linked_products';
        parent::__construct( $product );
        // Additional setup if required
    }

    public function get_price_per_unit() {
        return $this->get_meta('_price_per_unit');
    }

    public function set_price_per_unit($price) {
        $this->update_meta_data('_price_per_unit', $price);
    }
    
}

function load_custom_subscription_product_class( $classname, $product_type ) {
    if ( $product_type == 'subscription_product' ) {
        $classname = 'WC_Product_Subscription';
    }
    return $classname;
}

add_filter( 'product_type_selector', function( $types ){
    $types['subscription_product'] = 'Subscription Product';
    return $types;
});

add_filter( 'woocommerce_product_class', 'load_custom_subscription_product_class', 10, 2 );



add_action( 'woocommerce_product_options_general_product_data', 'add_custom_fields' );
function add_custom_fields() {
    global $woocommerce, $post;

    echo '<div class="options_group show_if_subscription_product">';


    // Number of seats
    woocommerce_wp_text_input(array(
        'id' => 'subscription_term',
        'label' => 'Subscription Length (in months)',
        'desc_tip' => 'true',
        'description' => 'Enter the number of months',
        'type' => 'number',
        'custom_attributes' => array('step' => '1', 'min' => '1')
    ));

    woocommerce_wp_text_input(array(
        'id' => 'seat_discount',
        'label' => 'Seat Discount',
        'desc_tip' => 'true',
        'description' => 'Enter the discount for purchasing multiple seats',
        'type' => 'number',
        'custom_attributes' => array('step' => '1', 'min' => '1')
    ));

    // Dropdown Field for Item Unit
    echo '<div class="options_group">';
    woocommerce_wp_select(array(
        'id' => '_item_unit',
        'label' => __('Item Unit', 'woocommerce'),
        'options' => array(
            '' => __('Select unit', 'woocommerce'),
            'lesson' => __('Lesson', 'woocommerce'),
            'credit_hour' => __('Credit Hour', 'woocommerce')
        )
    ));

    // Number Field for Number of Units
    woocommerce_wp_text_input(array(
        'id' => '_number_of_units',
        'label' => __('Number of Units', 'woocommerce'),
        'type' => 'number',
        'desc_tip' => true,
        'description' => __('Enter the number of units.', 'woocommerce'),
        'custom_attributes' => array(
            'step' => '1',
            'min' => '0'
        ),
    ));

    woocommerce_wp_text_input(array(
        'id' => '_price_per_unit',
        'label' => __('Price per Unit', 'woocommerce'),
        'desc_tip' => 'true',
        'description' => __('Enter the price per individual lesson/hour.', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '0.01',
            'min' => '0',
        ),
    ));

        
    
        echo '</div>';

    // Start date, end date, and other fields...

}

add_action( 'woocommerce_process_product_meta', 'save_custom_fields' );
function save_custom_fields( $post_id ) {
    $number_of_seats = $_POST['number_of_seats'] ?? '';
    update_post_meta( $post_id, 'number_of_seats', esc_attr($number_of_seats) );

    // Save other fields...
}


add_action('woocommerce_admin_process_product_object', 'save_price_per_unit_field');

add_filter('woocommerce_add_cart_item_data', 'add_number_of_seats_to_cart_item', 10, 3);

function add_number_of_seats_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if(isset($_POST['number_of_seats'])) {
        $cart_item_data['seats'] = (int) sanitize_text_field($_POST['number_of_seats']);
    }
    return $cart_item_data;
}



function save_price_per_unit_field($product) {
        // Save Item Unit
        if (isset($_POST['_item_unit'])) {
            $product->update_meta_data('_item_unit', sanitize_text_field($_POST['_item_unit']));
        }
    
        // Save Number of Units
        if (isset($_POST['_number_of_units'])) {
            $product->update_meta_data('_number_of_units', sanitize_text_field($_POST['_number_of_units']));
        }

    $price_per_unit = isset($_POST['_price_per_unit']) ? $_POST['_price_per_unit'] : '';
    $product->update_meta_data('_price_per_unit', sanitize_text_field($price_per_unit));
}

add_action( 'woocommerce_before_calculate_totals', 'calculate_price_per_unit' );
function calculate_price_per_unit( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

    foreach ( $cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
        $price_per_unit = $product->get_meta( '_price_per_unit' );
        $number_of_units = $product->get_meta( '_number_of_units' );
        if ( ! empty( $price_per_unit ) ) {
            $number_of_seats = isset( $cart_item['seats'] ) ? $cart_item['seats'] : 1; // Replace with how you get the number of seats
            $product->set_price( $price_per_unit * $number_of_units * $number_of_seats );
        }
    }
}

add_action('woocommerce_before_add_to_cart_button', 'add_seats_input_field');

add_filter('woocommerce_get_item_data', 'display_seats_in_cart', 10, 2);

function display_seats_in_cart($item_data, $cart_item) {
    if (isset($cart_item['seats'])) {
        $item_data[] = array(
            'name' => __('Number of Seats', 'woocommerce'),
            'value' => $cart_item['seats']
        );
    }
    return $item_data;
}
add_filter('woocommerce_order_item_name', 'display_custom_unit_info_in_orders', 10, 2);

function display_custom_unit_info_in_orders($item_name, $item) {
    // Get the product
    $product = $item->get_product();

    if ($product && is_a($product, 'WC_Product_Subscription')) {
        // Retrieve unit type meta
        $unit_type = $product->get_meta('_item_unit');
        $unit_text = $unit_type == 'lesson' ? ' (per lesson)' : ($unit_type == 'credit_hour' ? ' (per credit hour)' : '');

        // Append unit info to item name
        $item_name .= $unit_text;
    }
    return $item_name;
}

add_filter('woocommerce_get_price_html', 'add_per_lesson_suffix_to_price', 10, 2);

function add_per_lesson_suffix_to_price($price, $product) {
    // Check if the product is a subscription product
    if (is_a($product, 'WC_Product_Subscription')) {
        // Modify the price HTML to append "per lesson"
        $unit_type = $product->get_meta('_item_unit');
        $unit_text = $unit_type == 'lesson' ? ' per lesson' : ($unit_type == 'credit_hour' ? ' per credit hour' : '');

        $price .= $unit_text;
    }
    return $price;
}

function add_seats_input_field() {
    echo '<div class="number-of-seats-field">';
    echo '<p>Courses are sold as seats * unit (lessons or hours).</p>';
    echo '<label for="number_of_seats">Number of Seats:</label>';
    echo '<input type="number" id="number_of_seats" name="number_of_seats" min="1" value="1">';
    echo '</div>';
}

add_action('woocommerce_admin_order_data_after_order_details', 'display_custom_order_data_in_admin');

function display_custom_order_data_in_admin($order) {
    // Loop through order items
    foreach ($order->get_items() as $item_id => $item) {
        // Get the product object
        $product = $item->get_product();

        // Check if the product is a subscription product
        if ($product && is_a($product, 'WC_Product_Subscription')) {
            // Retrieve the custom meta data
            $unit_type = $product->get_meta('_item_unit');
            $unit_text = $unit_type == 'lesson' ? 'Per Lesson' : ($unit_type == 'credit_hour' ? 'Per Credit Hour' : '');

            // Display the custom data
            echo '<p><strong>' . __('Unit Type:', 'woocommerce') . '</strong> ' . $unit_text . '</p>';
            // Add any additional information you want to display
        }
    }

}