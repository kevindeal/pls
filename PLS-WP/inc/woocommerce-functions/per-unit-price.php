<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Check if WooCommerce is active.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    class WooCommerce_Per_Unit_Price {

        public function __construct() {
            add_action( 'woocommerce_product_options_pricing', array( $this, 'add_custom_fields' ) );
            add_action( 'woocommerce_admin_process_product_object', array( $this, 'save_custom_fields' ) );
            add_filter( 'woocommerce_get_price_html', array( $this, 'display_per_unit_price' ), 10, 2 );
            add_action( 'woocommerce_before_calculate_totals', array( $this, 'adjust_cart_pricing' ) );
            add_action( 'woocommerce_order_item_meta_end', array( $this, 'display_lessons_in_order_items' ), 10, 3 );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_product_page_scripts' ) );
        }

        public function enqueue_product_page_scripts() {
            if ( is_product() ) {
                wp_enqueue_script( 'woocommerce-product-seats', plugin_dir_url( __FILE__ ) . 'inc/woocommerce-functions/js/seats.js', array(), '1.0', true );            }
        }

        public function add_custom_fields() {
            echo '<div class="options_group">';
        
            // Number of Lessons Field
            woocommerce_wp_text_input( 
                array(
                    'id' => '_number_of_lessons',
                    'label' => __('Number of Lessons', 'woocommerce-per-unit-price'),
                    'placeholder' => '',
                    'desc_tip' => 'true',
                    'description' => __('Enter the total number of lessons.', 'woocommerce-per-unit-price'),
                    'type' => 'number',
                    'custom_attributes' => array(
                        'step' => '1',
                        'min' => '1'
                    )
                )
            );
        
            // Per-Lesson Cost Field
            woocommerce_wp_text_input( 
                array(
                    'id' => '_cost_per_lesson',
                    'label' => __('Cost Per Lesson', 'woocommerce-per-unit-price'),
                    'placeholder' => '',
                    'desc_tip' => 'true',
                    'description' => __('Enter the cost per lesson.', 'woocommerce-per-unit-price'),
                    'type' => 'text',
                    'custom_attributes' => array(
                        'step' => 'any',
                        'min' => '0.01'
                    )
                )
            );
        
            echo '</div>';
        }
        

        public function save_custom_fields( $product ) {
            // Check if the custom fields are set and save them if they are.
            
            if ( isset( $_POST['_number_of_lessons'] ) ) {
                $number_of_lessons = sanitize_text_field( $_POST['_number_of_lessons'] );
                $product->update_meta_data( '_number_of_lessons', $number_of_lessons );
            }
        
            if ( isset( $_POST['_cost_per_lesson'] ) ) {
                $cost_per_lesson = wc_clean( $_POST['_cost_per_lesson'] ); // wc_clean is a WooCommerce function for sanitizing text.
                $product->update_meta_data( '_cost_per_lesson', $cost_per_lesson );
            }
        
            $product->save_meta_data();
        }
        

        public function display_per_unit_price( $price, $product ) {
            // Retrieve the custom field values.
            $number_of_lessons = $product->get_meta( '_number_of_lessons', true );
            $cost_per_lesson = $product->get_meta( '_cost_per_lesson', true );
        
            // Check if both fields are set and not empty.
            if ( ! empty( $number_of_lessons ) && ! empty( $cost_per_lesson ) ) {
                // Calculate the per-unit price.
                $per_unit_price = floatval( $number_of_lessons ) * floatval( $cost_per_lesson );
        
                // Format the per-unit price as a currency.
                $formatted_per_unit_price = wc_price( $per_unit_price );
        
                // Append the per-unit price to the original price.
                $price .= sprintf( __(' (Per Seat: %s)', 'woocommerce-per-unit-price'), $formatted_per_unit_price );
            }
        
            return $price;
        }
        
        public function adjust_cart_pricing( $cart ) {
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
                return;
            }
        
            foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
                // Retrieve the custom fields from the product
                $number_of_lessons = get_post_meta( $cart_item['product_id'], '_number_of_lessons', true );
                $cost_per_lesson = get_post_meta( $cart_item['product_id'], '_cost_per_lesson', true );
        
                // Check if the custom fields are set and not empty
                if ( ! empty( $number_of_lessons ) && ! empty( $cost_per_lesson ) ) {
                    // Calculate the new price
                    $new_price = floatval( $number_of_lessons ) * floatval( $cost_per_lesson );
        
                    // Set the new price
                    $cart_item['data']->set_price( $new_price );
                }
            }
        }
        public function display_lessons_in_order_items( $item_id, $item, $order ) {
            // Retrieve the product
            $product = $item->get_product();
        
            // Check if product exists and retrieve the number of lessons
            if ( $product && $number_of_lessons = $product->get_meta( '_number_of_lessons', true ) ) {
                // Display the number of lessons
                echo '<p>' . sprintf( __( 'Number of Lessons: %s', 'woocommerce-per-unit-price' ), $number_of_lessons ) . '</p>';
            }
        }
    }

    new WooCommerce_Per_Unit_Price();
}

