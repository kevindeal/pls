<?php

function remove_product_image_gallery() {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
}
add_action( 'init', 'remove_product_image_gallery' );