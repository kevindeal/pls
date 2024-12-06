<?php 

    // Add seat fee for each item in the cart
    // Static amount of $2 per item
    add_action( 'woocommerce_cart_calculate_fees', 'add_seat_fee_for_each_item' );
    function add_seat_fee_for_each_item( WC_Cart $cart ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            return;
        }

        $fee_per_item = 2; // Define the seat fee per item here
        $cart_contents_count = $cart->get_cart_contents_count();
        $total_fee = $fee_per_item * $cart_contents_count;

        if ( $total_fee > 0 ) {
            $cart->add_fee( __( 'Seat Fee @ $2/seat ', 'your-text-domain' ), $total_fee, true );
        }
    }
?>