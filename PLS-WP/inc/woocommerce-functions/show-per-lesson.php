<?php

class WooCommerce_Per_Lesson_Price {

    public function __construct() {
        add_filter( 'woocommerce_get_price_html', array( $this, 'append_per_lesson_to_price' ), 10, 2 );
    }

    public function append_per_lesson_to_price( $price, $product ) {
        if($price) {
            return $price . ' ' . __('per lesson', 'woocommerce-per-lesson-price');
        } else {
            return $price;
        }
    }
    
}

new WooCommerce_Per_Lesson_Price();
